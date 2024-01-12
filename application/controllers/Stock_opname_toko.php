<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Stock_opname_toko extends BaseController{
	function __construct(){
		parent::__construct();
		$this->load->model("modelStockOpname");
		$this->isLoggedIn($this->global['idUser'],2,16);
	}

	function index(){
		$data['toko'] = $this->db->get("ap_store")->result();
		$data['show_kategori'] = $this->db->get("ap_kategori")->result();
		$data['stand'] = $this->db->get("ap_stand")->result();
		$this->global['pageTitle'] = "TokoSourceCode POS - Stock Opname Toko";
		$this->loadViews("stock_opname/body_so_toko",$this->global,$data,"stock_opname/footerSOToko");
	}

	function download_format_so(){
		$this->load->library("excel/PHPExcel");
		$id_store = $_POST['id_store'];
		$stand = $_POST['tempat'];
		$kategori = $_POST['kategori'];

		if(!empty($_POST['subkategori'])){
			$subKategori = $_POST['subkategori'];
		} else {
			$subKategori = '';
		}

		if(!empty($_POST['subkategori2'])){
			$subKategori2 = $_POST['subkategori2'];
		} else {
			$subKategori2 = '';
		}


		$nama_toko = $this->model1->nama_toko($id_store);

		$objPHPExcel = new PHPExcel();

		$objPHPExcel->getActiveSheet()->setCellValue('A1','Kode Toko')
									  ->setCellValue('B1','Nama Toko')
									  ->setCellValue('C1','Tanggal');

		$objPHPExcel->getActiveSheet()->setCellValue('A2',$id_store)
									  ->setCellValue('B2',$nama_toko)
									  ->setCellValue('C2',date('d M Y H:i'));

		$objPHPExcel->getActiveSheet()->setCellValue('A3','No')
									  ->setCellValue('B3','SKU')
									  ->setCellValue('C3','Nama Produk')
									  ->setCellValue('D3','Kategori')
									  ->setCellValue('E3','Last Stok')	
									  ->setCellValue('F3','Harga Beli')	
									  ->setCellValue('G3','Stock Opname');	

		$this->load->model("modelProduk");
		

		$data_stok = $this->modelProduk->data_stok_distributor($id_store,$stand,$kategori,$subKategori,$subKategori2);

		$i=4;
		foreach($data_stok->result() as $row){
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$i,$i-1)
									  ->setCellValue('B'.$i,$row->id_produk)
									  ->setCellValue('C'.$i,$row->nama_produk)
									  ->setCellValue('D'.$i,$row->kategori."/".$row->kategori_level_1)
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
	 
	     //mulai menyimpan excel format xlsx, kalau ingin xls ganti Excel2007 menjadi Excel5          
	    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	 	
	 	
	    
	   	//sesuaikan headernya 
	    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	   	header("Cache-Control: no-store, no-cache, must-revalidate");
	    header("Cache-Control: post-check=0, pre-check=0", false);
	    header("Pragma: no-cache");
	    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	    //ubah nama file saat diunduh
	    header('Content-Disposition: attachment;filename=StockOpnameTokoTemplate.xlsx');
	    //unduh file
	    $objWriter->save("php://output");
	}

	function upload_so(){
		$config['upload_path'] = './excel/';
		$config['allowed_types'] = 'xls|xlsx';

		$this->load->library("upload",$config);

		if(! $this->upload->do_upload('file')){
			$error = array('error' => $this->upload->display_errors());

			echo $error['error'];
		} else {
			$upload_data = $this->upload->data();
			$this->load->library('excel/PHPExcel');
			$file =  $upload_data['full_path'];
			$objPHPExcel = PHPExcel_IOFactory::load($file);
			$sheets = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

			$x = 1;
			foreach($sheets as $dt){
				if($x==2){
					$kode_toko = $dt['A'];
				}
			$x++; }

			$urutanSOToko = $this->modelStockOpname->cekNOSOToko();;
			$noSO = "SOTK-".date('ym').sprintf("%03d",$urutanSOToko+1);

			//SISIPKAN INFORMASI SO
			$data_so = array(
							"noSO" 		=> $noSO,
							"tanggal"		=> date('Y-m-d'),
							"idUser"		=> $this->global['idUser'],
							"keterangan"	=> "SO By Excel",
							"type"			=> 2,
							"store"			=> $kode_toko
						);

			$this->modelStockOpname->insertStockOpnameInfoToko($data_so);

			$i=1;
			foreach($sheets as $row){
				if($i>3){
					$sku  		 = $row['B'];
					$last_stok 	 = $this->modelPublic->currentStokToko($sku,$kode_toko);
					$new_stok 	 = $row['G'];	

					//INPUT DATA ITEM DAN SELISIH
					$data_item[] = array(
										"noSO" => $noSO,
										"idProduk" => $sku,
										"lastStok" => $last_stok,
										"newStok" => $new_stok
							  	   );

					$data_stok = array(
									"stok" 		=> $new_stok
							  );

					$this->modelStockOpname->updateStokToko($kode_toko,$sku,$data_stok);

					$selisih = $new_stok-$last_stok;
					$barangKeluar = $selisih < 0 ? ($new_stok-$last_stok)*(-1) : NULL;
					$barangMasuk = $selisih > 0 ? $selisih : NULL;
					
					if($selisih != 0){
						$dataKartuStok[] = array(
							"noRefference" => $noSO,
							"tanggal" => date('Y-m-d'),
							"idUser" => $this->global['idUser'],
							"idProduk" => $sku,
							"idStore" => $kode_toko,
							"currentStok" => $this->modelPublic->currentStokToko($sku,$kode_toko),
							"barangMasuk" => $barangMasuk,
							"barangKeluar" => $barangKeluar,
							"jenisTrx" => 'STOCKOPNAME',
							"type" => 'STORE'
						);
					}

				}
			$i++;}

			//INSERT BATCH ITEM DATA 
			$this->modelStockOpname->insertBatchStokOpnameToko($data_item);

			//insert batch kartu stok toko
			$this->modelPublic->insertKartuStokToko($dataKartuStok);
		}
		unlink($file);
		echo $noSO;
	}

	function stock_opname_report(){
		$this->global['pageTitle'] = "SIMRS - Laporan Stock Opname Toko";
		$data['header'] = $this->db->get_where("kl_klinikinfo",array("id" => 1))->row();
		$data['headerSO'] = $this->modelStockOpname->headerSOStore($this->input->get("no_so"));
		$data['dataSO'] = $this->modelStockOpname->dataSOItem($this->input->get("no_so"));
		$this->loadViews("stock_opname/bodyStockOpnameReportStore",$this->global,$data,"footer_empty");
	}

}