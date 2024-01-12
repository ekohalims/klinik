<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Retur extends BaseController{
	function __construct(){
		parent::__construct();
		$this->load->model("modelRetur");
		$this->isLoggedIn($this->global['idUser'],2,20);
	}

	function index(){
		$this->global['pageTitle'] = "SIMRS - Retur Pembelian";
		$this->loadViews("retur/body_retur",$this->global,NULL,"footer_empty");		
	}

	function returPO(){
		$this->global['pageTitle'] = "SIMRS - Retur Pembelian";
		$this->loadViews("retur/bodyReturPO",$this->global,NULL,"retur/footerReturPO");	
	}

	function datatablesPO(){
		$this->load->model("modelBahanMasukMaterial");
		$draw 		= $_REQUEST['draw'];
		$length 	= $_REQUEST['length'];
		$start 		= $_REQUEST['start'];
		$search 	= $_REQUEST['search']["value"];

		$total 			 			= $this->modelBahanMasukMaterial->totalPOProduk();
		$output 					= array();
		$output['draw']	 			= $draw;
		$output['recordsTotal'] 	= $output['recordsFiltered']=$total;
		$output['data'] 			= array();

		if($search!=""){
			$query = $this->modelBahanMasukMaterial->viewPOProduk($length,$start,$search);
			$output['recordsTotal'] = $output['recordsFiltered'] = $query->num_rows();
		} else {
			$query = $this->modelBahanMasukMaterial->viewPOProduk($length,$start,$search);
		}

		$nomor_urut=$start+1;
		foreach ($query->result_array() as $dt) {
			$output['data'][]=array($nomor_urut,"<a href='".base_url('retur/returPOForm?noPO='.$dt['no_po'])."'>".$dt['no_po']."</a>",$dt['tanggal_po'],$dt['tanggal_kirim'],$dt['supplier'],$dt['first_name']);
			$nomor_urut++;
		}

		echo json_encode($output);
	}

	function returPOForm(){
		$noPO = $this->input->get("noPO");
		$data['infoPO'] = $this->modelRetur->infoPO($noPO);
		$data['purchase_item'] = $this->modelRetur->purchase_item($noPO);
		$this->global['pageTitle'] = "SIMRS - Form Retur Pembelian";
		$this->loadViews("retur/bodyReturPOForm",$this->global,$data,"retur/footerReturPOForm");
	}

	function cekPurchasePeritem(){
		$idProduk = $_POST['idProduk'];
		$noPO = $_POST['noPO'];
		$qty = $_POST['qty'];
		$expiredDate = $_POST['expiredDate'];

		$purchasePeritem = $this->modelRetur->barangDiterima($idProduk,$noPO);
		$returHistory = $this->modelRetur->returHistory($idProduk,$noPO);

		$max = $purchasePeritem-$returHistory;

		if($qty > $max){
			echo 0;
		} else {
			//cekStok berdasarkan stok barang yang sudah expired
			$cekStok = $this->modelRetur->cekStokExpired($idProduk,$expiredDate);
			if($qty > $cekStok){
				echo 0;
			} else {
				echo 1;
			}
		}
	}

	function returSQL(){
		$this->load->model("modelTrxJurnal");
		$this->load->model("modelAntrianFarmasi");

		$tanggal_retur = date('Y-m-d H:i:s');
		$id_pic = $this->global['idUser'];
		$cek_no_retur = $this->modelRetur->cekNoRetur();
		$no_inv = "RT-".date('y').date('m').date('d').sprintf("%03d",$id_pic).sprintf("%03d",$cek_no_retur+1);
		$noPO = $_POST['noPO'];

		$data_retur = array(
			"no_retur" => $no_inv,
			"no_po" => $noPO,
			"id_pic" => $id_pic,
			"tanggal_retur"	=> $tanggal_retur
		);

		$this->modelRetur->insertNoRetur($data_retur);
		
		$count = count($_POST['idProduk']);
		
		for($i=0;$i<$count;$i++){

			$sku = $_POST['idProduk'][$i];
			$qty = $_POST['retur'][$i];
			$harga = $this->modelRetur->hargaBeli($sku,$noPO);
			$expiredDate = $_POST['expiredDate'][$i];

			if($qty > 0){

				$data_item[] = array(
					"no_retur" => $no_inv,
					"sku" => $sku,
					"qty" => $qty,
					"harga" => $harga,
					"keterangan" => "",
					"tanggal" => $tanggal_retur
				);

				$stok_lama = $this->modelPublic->currentStokGudang($sku);

				$data_update[] = array(
					"id_produk" => $sku,
					"stok"	=> $stok_lama-$qty
				);
			}

			if($qty > 0){
				$dataKartuStok[] = array(
					"noRefference" => $no_inv,
					"tanggal" => date('Y-m-d'),
					"idUser" => $this->global['idUser'],
					"idProduk" => $sku,
					"currentStok" => $stok_lama,
					"barangKeluar" => $qty,
					"hargaSatuan" => $this->db->get_where("ap_produk",array("id_produk" => $sku))->row()->hpp,
					"jenisTrx" => 'RETUR',
					"type" => 'GUDANG'
				);
			}

			if(!empty($expiredDate)){
				//data stok expired 
				$dataStokExpired = $this->modelAntrianFarmasi->stokObatPertanggalExpired($sku,$expiredDate);

				$dataUpdateExpItem = array(
					"stok" => $dataStokExpired-$qty
				);

				$this->modelAntrianFarmasi->kurangiStokExp($dataUpdateExpItem,$sku,$expiredDate);
			}
		}
		
		$this->modelPublic->insertKartuStok($dataKartuStok);
		$this->modelRetur->insertReturItemBatch($data_item);
		$this->modelRetur->updateBatchStok($data_update);
		echo $no_inv;

		//insert jurnal
		$totalRetur = $this->modelRetur->totalNilaiRetur($no_inv);
		$totalHPP = $this->modelRetur->totalHPP($no_inv);

		$akunDebit = '2101'; //hutang usaha
		$akunKredit = '1401'; //persediaan gudang
		$keterangan = 'Purchase Return No : '.$noPO;
		$this->modelTrxJurnal->insertJurnal($no_inv,$akunDebit,$akunKredit,$keterangan,$totalRetur);
		
		if($totalHPP < $totalRetur){
			$akunDebitY = '1401'; //persediaan gudang
			$akunKreditY = '4204'; //hutang usaha
			$value = $totalRetur-$totalHPP;
		} else {
			$akunDebitY = '4204'; //persediaan gudang
			$akunKreditY = '1401'; //harga pokok
			$value = $totalHPP-$totalRetur;
		}

		if($value > 0){
			$keteranganY = 'Purchase Return Adjusment : '.$noPO;
			$this->modelTrxJurnal->insertJurnal($no_inv,$akunDebitY,$akunKreditY,$keteranganY,$value);
		}
	}


	function nota_retur(){
		$data['header'] = $this->db->get_where("kl_klinikinfo",array("id" => 1))->row();
		$no_retur = $_GET['no_retur'];
		$data['returInfo'] = $this->modelRetur->returInfo($no_retur);
		$data['returItem'] = $this->modelRetur->returItem($no_retur);

		$this->global['pageTitle'] = "SIMRS - Invoice Retur";
		$this->loadViews("retur/nota_retur",$this->global,$data,"footer_empty");
	}

	function returToWarehouse(){
		$data['getStore'] = $this->db->get("ap_store")->result();
		
		$this->global['pageTitle'] = "SIMRS - Retur Toko ke Gudang";
		$this->loadViews("retur/bodyReturToWarehouse",$this->global,$data,"retur/footerReturWarehouse");
	}

	function returContent(){
		$data['idStore'] 	= $_POST['idStore'];
		$this->load->view("retur/returContent",$data);
	}

	function ajaxProdukStore(){
		$q 	= $_GET['term'];
		$id_store = $_GET['idStore'];
		$this->load->model("model_penjualan");
		$customer = $this->model_penjualan->produkSearchRetur($q,$id_store);
		$data_array = array();

		foreach($customer->result() as $row){
			$data_array[] = array(
									"id" 	=> $row->id_produk,
									"text"	=> $row->id_produk." / ".$row->nama_produk,
								 );
		}

		echo json_encode($data_array);
	}

	function data_form(){
		$this->load->model("model_penjualan");
		$data['no'] 	= $_GET['no'];
		$sku = $_GET['sku'];
		$data['idStore'] = $_GET['idStore'];

		$data['bahan_baku'] = $this->db->get_where("ap_produk",array("id_produk"	=> $sku));
		$this->load->view("retur/expandDataRetur",$data);
	}

	function returPerStoreSQL(){
		$this->load->model("model_penjualan");
		$tanggalRetur 		= date('Y-m-d H:i:s');
		$id_pic 			= $this->global['idUser'];
		$idStore 			= $_POST['idStore'];
		$cek_no_retur 		= $this->model_penjualan->cekNoReturPerstore();
		$no_inv 			= "RTS-".date('y').date('m').date('d')."-".sprintf("%02d",$cek_no_retur+1);
		
		$dataRetur 			= array(
										"NoRetur"		=> $no_inv,
										"tanggal"		=> $tanggalRetur,
										"id_user"		=> $id_pic,
										"idStoreFrom"	=> $idStore
								   );

		$this->modelRetur->returPerstore($dataRetur);
		
		$count = count($_POST['sku']);

		for($i=0;$i<$count;$i++){
			$sku 	= $_POST['sku'][$i];
			$qty 	= $_POST['qty'][$i];

			//potong stok di store
			$stokStore = $this->model_penjualan->cekStokPerStore($sku,$idStore);

			$dataUpdate = array(
									"stok"	=> $stokStore-$qty
							   );

			$this->modelRetur->updateStokStore($idStore,$sku,$dataUpdate);

			//update data di gudang 
			//get old stock on warehouse
			$oldStokGudang = $this->model_penjualan->oldStokWarehouse($sku);

			$stokGudang[] = array(
								    "id_produk" => $sku,
									"stok" => $oldStokGudang+$qty
							   );
		
			$dataArray[] = array(
								"NoRetur"	=> $no_inv,
								"sku"		=> $sku,
								"qty"		=> $qty,
								"tanggal"	=> date('Y-m-d')
							  );

			//kartu stok untuk gudang
			$dataKartuStok[] = array(
				"noRefference" => $no_inv,
				"tanggal" => date('Y-m-d'),
				"idUser" => $this->global['idUser'],
				"idProduk" => $sku,
				"currentStok" => $oldStokGudang,
				"barangMasuk" => $qty,
				"jenisTrx" => 'RETURSTORE',
				"type" => 'GUDANG'
			);

			//kartu stok untuk toko
			$dataKartuStokToko[] = array(
				"noRefference" => $no_inv,
				"tanggal" => date('Y-m-d'),
				"idUser" => $this->global['idUser'],
				"idStore" => $this->global['idStore'],
				"idProduk" => $sku,
				"currentStok" => $stokStore,
				"barangKeluar" => $qty,
				"jenisTrx" => 'RETURSTORE',
				"type" => 'STORE'
			);
		}

		$this->modelRetur->tambahStokGudang($stokGudang);
		$this->modelRetur->insertBatchReturStoreItem($dataArray);
		$this->modelPublic->insertKartuStok($dataKartuStok);
		$this->modelPublic->insertKartuStokToko($dataKartuStokToko);
		redirect("retur/invReturPerStore?noRetur=".$no_inv);
	}

	function invReturPerStore(){
		$this->load->model("model_penjualan");
		$noRetur 	= $this->input->get("noRetur");
		$data['infoCompany'] = $this->db->get("ap_receipt")->result();
		$data['infoRetur'] 	 = $this->model_penjualan->infoReturPerstore($noRetur);
		$data['returItem'] 	 = $this->model_penjualan->returItem($noRetur);

		$this->global['pageTitle'] = "SIMRS - Invoice Retur Toko ke Gudang";
		$this->loadViews("retur/bodyInvRetuPerstore",$this->global,$data,"footer_empty");
	}

	function daftarReturPerstore(){
		$this->load->model("model_penjualan");
		$data['dataRetur'] = $this->model_penjualan->dataReturPerstore();
		$this->global['pageTitle'] = "SIMRS - Data Retur Store ke Gudang";
		$this->loadViews("retur/bodyDaftarReturPerstore",$this->global,$data,"footer_empty");
	}

}