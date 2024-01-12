<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class KartuStok extends BaseController{
	function __construct(){
		parent::__construct();
		$this->load->model("modelKartuStok");
		$this->isLoggedIn($this->global['idUser'],2,43);
    }

    function index(){
        $this->global['pageTitle'] = "SIMRS - Kartu Stok";
		$this->loadViews("kartustok/bodyKartuStok",$this->global,NULL,"footer_empty");
    }

    function ajaxProduk(){
		$q 	= $_GET['term'];
		
		$customer = $this->modelPublic->produkAjaxAll($q);

		$data_array = array();

		foreach($customer->result() as $row){
			$data_array[] = array(
									"id" 	=> $row->id_produk,
									"text"	=> $row->id_produk." / ".$row->nama_produk,
								 );
		}

		echo json_encode($data_array);
	}

    // kartu stok gudang
    function kartuStokGudang(){
        $this->global['pageTitle'] = "SIMRS - Kartu Stok Gudang Peritem";
		$this->loadViews("kartustok/kartustokgudang/bodyKartuStokGudang",$this->global,NULL,"kartustok/kartustokgudang/footerKartuStokGudang");
    }

    function kartuStokGudangAkumulasi(){
        $this->global['pageTitle'] = "SIMRS - Kartu Stok Gudang Akumulasi";
		$this->loadViews("kartustok/kartustokgudang/bodyKartuStokGudangAkumulasi",$this->global,NULL,"kartustok/kartustokgudang/footerKartuStokGudangAkumulasi");
    }

    function viewKartuStokGudang(){
        $dateStart = $this->input->post("dateStart");
        $dateEnd = $this->input->post("dateEnd");
        $item = $this->input->post("item");

        if(!empty($item)){
            $data['stokAwal'] = $this->modelKartuStok->stokAwal($dateStart,$dateEnd,$item);
            $data['viewData'] = $this->modelKartuStok->viewData($dateStart,$dateEnd,$item);
            $this->load->view("kartustok/kartustokgudang/viewKartuStokGudang",$data);
        } else {
            $data['viewData'] = $this->modelKartuStok->viewDataAkumulasi($dateStart,$dateEnd);
            $this->load->view("kartustok/kartustokgudang/viewKartuStokGudangAkumulasi",$data);
        }
    }
    //end kartu stok gudang

    //kartu stok toko
    /**function kartuStokToko(){
        $this->global['pageTitle'] = "SIMRS - Kartu Stok Toko";
		$this->loadViews("kartustok/kartustoktoko/bodyKartuStokToko",$this->global,NULL,"kartustok/kartustoktoko/footerKartuStokToko");
    }

    function kartuStokTokoAkumulasi(){
        $this->global['pageTitle'] = "SIMRS - Kartu Stok Toko Akumulasi";
		$this->loadViews("kartustok/kartustoktoko/bodyKartuStokTokoAkumulasi",$this->global,NULL,"kartustok/kartustoktoko/footerKartuStokTokoAkumulasi");
    }

    function viewKartuStokToko(){
        $dateStart = $this->input->post("dateStart");
        $dateEnd = $this->input->post("dateEnd");
        $item = $this->input->post("item");
        $idStore = 1;

        if(!empty($item)){
            $data['stokAwal'] = $this->modelKartuStok->stokAwalToko($dateStart,$dateEnd,$item,$idStore);
            $data['viewData'] = $this->modelKartuStok->viewDataTokoPeritem($dateStart,$dateEnd,$item,$idStore);
            $this->load->view("kartustok/kartustoktoko/viewKartuStokToko",$data);
        } else {
            $data['viewData'] = $this->modelKartuStok->viewDataAkumulasiToko($dateStart,$dateEnd,$idStore);
            $this->load->view("kartustok/kartustoktoko/viewKartuStokTokoAkumulasi",$data);
        }
    }**/
}