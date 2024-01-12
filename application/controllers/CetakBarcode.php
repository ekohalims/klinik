<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';
require APPPATH . '/libraries/phpbarcode/vendor/autoload.php';

class CetakBarcode extends BaseController{
	function __construct(){
        parent::__construct();
        $this->load->model("modelProduk");
		$this->isLoggedIn($this->global['idUser'],2,64);
    }

    function index(){
        $this->global['pageTitle'] = "SIMRS - Cetak Barcode";
		$this->loadViews("inventory/cetakbarcode/body",$this->global,NULL,"inventory/cetakbarcode/footer");
    }

    function formProduk(){
        $this->load->view("inventory/cetakbarcode/formProduk");
    }

    function datatablesProduk(){
		$draw 	= $_REQUEST['draw'];
		$length = $_REQUEST['length'];
		$start = $_REQUEST['start'];
		$search = $_REQUEST['search']["value"];

		$total = $this->modelProduk->totalProdukActive();
		$output = array();
		$output['draw']	 = $draw;
		$output['recordsTotal'] = $output['recordsFiltered']=$total;
		$output['data'] = array();

		if($search!=""){
			$query = $this->modelProduk->daftarProdukAll($length,$start,$search);
			$output['recordsTotal'] = $output['recordsFiltered'] = $query->num_rows();
		} else {
			$query = $this->modelProduk->daftarProdukAll($length,$start,$search);
		}

		$nomor_urut=$start+1;
		foreach ($query->result_array() as $dt) {
			$output['data'][]=array(
                $nomor_urut,$dt['id_produk'],
                $dt['nama_produk'],
                "<input type='number' class='form-control' id='idProduk".$dt['id_produk']."'/>",
                "<a class='btn btn-info simpanBarcode' id='".$dt['id_produk']."'><i class='fa fa-save'></i></a>",
            );
		$nomor_urut++;
		}

		echo json_encode($output);
    }
    
    function simpanBarcode(){
        $idProduk = $this->input->post("idProduk");
        $qty = $this->input->post("qty");

        for($i=1;$i<=$qty;$i++){
            $dataInsert = array(
                "idProduk" => $idProduk,
                "idUser" => $this->global['idUser']
            );

            $this->modelPublic->insert("barcodetemp",$dataInsert);
        }
    }

    function dataCetak(){
        $data['itemCetak'] = $this->modelPublic->itemCetakBarcode($this->global['idUser']);
        $this->load->view("inventory/cetakbarcode/dataCetak",$data);
    }

    function hapus(){
        $this->modelPublic->delete("barcodetemp",array("idUser" => $this->global['idUser']));
    }
}
