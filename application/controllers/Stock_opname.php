<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';
include_once APPPATH . '/third_party/phpspreadsheet/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;


class Stock_opname extends BaseController{
	function __construct(){
		parent::__construct();
		$this->load->model("modelStockOpname");
		$this->isLoggedIn($this->global['idUser'],2,15);
	}

	function index(){
		$data['show_kategori'] = $this->db->get("ap_kategori")->result();
		$this->global['pageTitle'] = "SIMRS - Stock Opname";
		$this->loadViews("stock_opname/body_stock_opname",$this->global,$data,"stock_opname/footer_so");
	}
	
	function stock_opname_report(){
		$this->global['pageTitle'] = "SIMRS - Laporan Stock Opname Gudang";
		$data['header'] = $this->db->get_where("kl_klinikinfo",array("id" => 1))->row();
		$data['headerSO'] = $this->modelStockOpname->headerSO($this->input->get("no_so"));
		$data['dataSO'] = $this->modelStockOpname->dataSOItem($this->input->get("no_so"));
		$this->loadViews("stock_opname/body_stock_opname_report",$this->global,$data,"footer_empty");
	}

	function exportExcelFG(){
		$kategori = $_POST['kategori'];

		$objPHPExcel = new Spreadsheet();

		$objPHPExcel->getActiveSheet()->setCellValue('A1','No')
									  ->setCellValue('B1','SKU')
									  ->setCellValue('C1','Nama Produk')
									  ->setCellValue('D1','Kategori')
									  ->setCellValue('E1','Last Stok')	
									  ->setCellValue('F1','Harga')	
									  ->setCellValue('G1','Stock Opname');	

		$data_stok = $this->modelStockOpname->dataStokFG($kategori);

		$i=2;
		foreach($data_stok->result() as $row){
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$i,$i-1)
									  ->setCellValue('B'.$i,$row->id_produk)
									  ->setCellValue('C'.$i,$row->nama_produk)
									  ->setCellValue('D'.$i,$row->kategori)
									  ->setCellValue('E'.$i,$row->stok)
									  ->setCellValue('F'.$i,$row->harga)
									  ->setCellValue('G'.$i,$row->stok);
		$i++; }

		//set title pada sheet (me rename nama sheet)
	  	$objPHPExcel->getActiveSheet()->setTitle('Sheet 1');

	    // Set document properties
		$objPHPExcel->getProperties()->setCreator("Rifal")
								->setLastModifiedBy("Rifal")
								->setTitle("TukuWebsite | Simple PSB System")
								->setSubject("TukuWebsite | Simple PSB System")
								->setDescription("Export Data")
								->setKeywords("office 2007 openxml php")
								->setCategory("Data SO");
	
	 
	   	//sesuaikan headernya 
	    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	   	header("Cache-Control: no-store, no-cache, must-revalidate");
	    header("Cache-Control: post-check=0, pre-check=0", false);
	    header("Pragma: no-cache");
	    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	    //ubah nama file saat diunduh
	    header('Content-Disposition: attachment;filename=StockOpnameGudangTemplate.xlsx');
	    //unduh file
	    $writer = IOFactory::createWriter($objPHPExcel, 'Xlsx');
		$writer->save('php://output');
		exit;
	}


	//UPLOAD DATA SO FINISH GOODS KE EXCEL
	function uploadFGSQL(){
		$config['upload_path'] = './excel/';
		$config['allowed_types'] = 'xls|xlsx';

		$this->load->library("upload",$config);

		if(! $this->upload->do_upload('file')){
			$error = array('error' => $this->upload->display_errors());

			echo $error['error'];
		} else {
			$idUser = $this->global['idUser'];
			$cekNoSO = $this->modelStockOpname->cekNoSOGudang();
			$no_so = "SOWH-".date('ym').sprintf("%02d",$cekNoSO+1);


			//SISIPKAN INFORMASI SO
			$data_so = array(
							"noSO" 	=> $no_so,
							"tanggal" => date('Y-m-d'),
							"idUser" => $idUser,
							"keterangan" => "SO By Excel",
							"type" => 1
						);

			$this->modelStockOpname->insertStockOpnameInfo($data_so);
			
			$upload_data = $this->upload->data();

			$file =  $upload_data['full_path'];
			$objPHPExcel = IOFactory::load($file);

			$sheets = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

			$i=1;
			foreach($sheets as $row){

				if($i>1){
					$sku  		 = $row['B'];
					$last_stok 	 = $this->modelPublic->currentStokGudang($sku);
					$new_stok 	 = $row['G'];	

					//INPUT DATA ITEM DAN SELISIH
					$data_item[] = array(
										"noSO" => $no_so,
										"idProduk"  => $sku,
										"harga" => $this->modelStockOpname->hargaProduk($sku),
										"lastStok" => $last_stok,
										"newStok" 	=> $new_stok
							  	   );

					$data_stok[] = array(
									"id_produk" => $sku,
									"stok" 		=> $new_stok
							  );
	
					$selisih = $last_stok-$new_stok;

					if($selisih != 0){

						$selisih = $new_stok-$last_stok;
						$barangKeluar = $selisih < 0 ? ($new_stok-$last_stok)*(-1) : NULL;
						$barangMasuk = $selisih > 0 ? $new_stok-$last_stok : NULL;
							
						$dataKartuStok = array(
							"noRefference" => $no_so,
							"tanggal" => date('Y-m-d'),
							"idUser" => $this->global['idUser'],
							"idProduk" => $sku,
							"currentStok" => $last_stok,
							"barangMasuk" => $barangMasuk,
							"barangKeluar" => $barangKeluar,
							"hargaSatuan" => $this->modelStockOpname->hargaProduk($sku),
							"jenisTrx" => 'STOCKOPNAME',
							"type" => 'GUDANG'
						);

						$this->modelPublic->insertCardStockOne($dataKartuStok);

					}
				
				}
			$i++;}

			//INSERT BATCH ITEM DATA 
			$this->modelStockOpname->insertBatchSO($data_item);
			$this->modelStockOpname->updateBatchStok($data_stok);
			unlink($file);

			echo $no_so;
		}

		

		//cek selisih stock

		$hasilSelisihStockOpname = $this->modelStockOpname->nilaiSelisihSO($no_so);

		/**$this->load->model("modelTrxJurnal");

		$akunDebit = '1401';
		$akunKredit = '2101';
		$keterangan ='Penerimaan Barang No Receive '.$no_inv;
		$value = $this->modelBahanMasukMaterial->hutangSesuaiBarangYangDiterima($no_inv);
		$this->modelTrxJurnal->insertJurnal($no_inv,$akunDebit,$akunKredit,$keterangan,$value);
		**/
    }
}