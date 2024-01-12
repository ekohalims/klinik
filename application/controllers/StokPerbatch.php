<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class StokPerbatch extends BaseController{
	function __construct(){
		parent::__construct();
		$this->isLoggedIn($this->global['idUser'],2,17);
	}

	function index(){
		$this->global['pageTitle'] = "SIMRS - Laporan Data Stok";
		$this->loadViews("data_stok/batch/body",$this->global,NULL,"data_stok/batch/footer");
    }
    
    function datatable(){
		$draw = $_REQUEST['draw'];
		$length = $_REQUEST['length'];
		$start = $_REQUEST['start'];
		$search = $_REQUEST['search']["value"];

		$total = $this->modelPublic->countRow("ap_produk_batch",NULL);
		$output = array();
		$output['draw']	 = $draw;
		$output['recordsTotal'] = $output['recordsFiltered']=$total;
		$output['data'] = array();

		if($search!=""){
			$query = $this->modelPublic->viewStokBatch($length,$start,$search);
			$output['recordsTotal'] = $output['recordsFiltered'] = $query->num_rows();
		} else {
			$query = $this->modelPublic->viewStokBatch($length,$start,$search);
		}

		$nomor_urut=$start+1;
		foreach ($query->result_array() as $dt) {
            $output['data'][]=array(
                $nomor_urut,
                $dt['id_produk'],
                $dt['noBatch'],
                $dt['nama_produk'],
                $dt['kategori'],
                $dt['qty']
            );
			$nomor_urut++;
		}

		echo json_encode($output);
	}
}