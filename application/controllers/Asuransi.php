<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Asuransi extends BaseController{
	function __construct(){
		parent::__construct();
		$this->load->model("modelAsuransi");

		$this->isLoggedIn($this->global['idUser'],2,31);
    }

    function index(){
        $this->global['pageTitle'] = "SIMRS - Master Data Asuransi";
		$this->loadViews("masterdata/asuransi/bodyAsuransi",$this->global,NULL,"masterdata/asuransi/footerAsuransi");
	}

	function viewTableAsuransi(){
		$data['viewAsuransiAktif'] = $this->modelPublic->viewAsuransi();
		$this->load->view("masterdata/asuransi/viewTableAsuransi",$data);
	}

	function formTambahAsuransi(){
		$this->load->view("masterdata/asuransi/formTambahAsuransi");
	}

	function simpanAsuransiSQL(){
		$namaAsuransi = $this->input->post("namaAsuransi");
		$keterangan = $this->input->post("keterangan");
		$tempo = $this->input->post('tempo');

		$dataAsuransi = array(
			"namaAsuransi" => $namaAsuransi,
			"keterangan" => $keterangan,
			"tempo" => $tempo,
			"status" => 1,
			"isDelete" => 1
		);

		$this->modelAsuransi->insertDataAsuransi($dataAsuransi);

		$this->modelPublic->insertLog($this->global['idUser'],"Menambah Asuransi Baru, Data : ".$namaAsuransi);
	}

	function editAsuransiSQL(){
		$namaAsuransi = $this->input->post("namaAsuransi");
		$tempo = $this->input->post("tempo");
		$keterangan = $this->input->post("keterangan");
		$status = $this->input->post("status");
		$idAsuransi = $this->input->post("idAsuransi");

		$dataAsuransi = array(
			"namaAsuransi" => $namaAsuransi,
			"tempo" => $tempo,
			"keterangan" => $keterangan,
			"status" => $status,
			"isDelete" => 1
		);

		$this->modelAsuransi->updateDataAsuransi($dataAsuransi,$idAsuransi);

		$this->modelPublic->insertLog($this->global['idUser'],"Mengubah asuransi, Data : ".$namaAsuransi);
	}

	function formEditAsuransi(){
		$idAsuransi = $this->input->post("idAsuransi");

		$data['asuransi'] = $this->db->get_where("kl_asuransi",array("idAsuransi" => $idAsuransi))->row();
		$this->load->view("masterdata/asuransi/formEditAsuransi",$data);
	}

	function hapusAsuransi(){
		$idAsuransi = $this->input->post("idAsuransi");

		$this->modelAsuransi->hapusDataAsuransi($idAsuransi);
		$this->modelPublic->insertLog($this->global['idUser'],"Menghapus asuransi, Data : ".$this->modelPublic->getValueOfTable("kl_asuransi","namaAsuransi",array("idAsuransi" => $idAsuransi)));
	}
}
