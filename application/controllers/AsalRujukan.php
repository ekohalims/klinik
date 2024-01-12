<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class AsalRujukan extends BaseController{
	function __construct(){
		parent::__construct();
		$this->isLoggedIn($this->global['idUser'],2,51);
	}

    function index(){
        $this->global['pageTitle'] = "SIMRS - Master Data Asal Rujukan";
		$this->loadViews("masterdata/asalrujukan/body",$this->global,NULL,"masterdata/asalrujukan/footer");
    }

    function viewTableAsalRujukan(){
        $data['tampilkanData'] = $this->modelPublic->tampilkanAsalRujukan();
        $this->load->view("masterdata/asalrujukan/viewTableAsalRujukan",$data);
    }

    function formTambahData(){
        $data['jenisRujukan'] = $this->modelPublic->viewJenisAsalRujukan();
        $this->load->view("masterdata/asalrujukan/formTambahData",$data);
    }

    function simpanAsalRujukanSQL(){
        $namaRujukan = $this->input->post("namaRujukan");
        $jenisRujukan = $this->input->post("jenisRujukan");
        $keterangan = $this->input->post("keterangan");

        $dataArray = array(
            "asalRujukan" => $namaRujukan,
            "idJenis" => $jenisRujukan,
            "keterangan" => $keterangan
        );

        $this->modelPublic->simpanAsalRujukan($dataArray);
        $this->modelPublic->insertLog($this->global['idUser'],"Menambah Asal Rujukan, Data : ".$namaRujukan);
    }

    function editDataSQL(){
        $id = $this->input->post("id");
        $namaRujukan = $this->input->post("namaRujukan");
        $jenisRujukan = $this->input->post("jenisRujukan");
        $keterangan = $this->input->post("keterangan");

        $dataArray = array(
            "asalRujukan" => $namaRujukan,
            "idJenis" => $jenisRujukan,
            "keterangan" => $keterangan
        );

        $this->modelPublic->editAsalRujukan($dataArray,$id);
        $this->modelPublic->insertLog($this->global['idUser'],"Mengubah Asal Rujukan, Data : ".$namaRujukan);
    }

    function formEdit(){
        $id = $this->input->post("id");
        $data['row'] = $this->db->get_where("kl_asalrujukan",array("id" => $id))->row();
        $data['jenisRujukan'] = $this->modelPublic->viewJenisAsalRujukan();
        $this->load->view("masterdata/asalrujukan/formEdit",$data);
    }

    function hapusAsalRujukan(){
        $id = $this->input->post("id");
        $this->modelPublic->hapusAsalRujukan($id);
        $this->modelPublic->insertLog($this->global['idUser'],"Menghapus Asal Rujukan, Data : ".$id);
    }
}