<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Poliklinik extends BaseController{
	function __construct(){
		parent::__construct();
		$this->load->helper("url");
		$this->load->database();
		$this->load->model(array("model1","modelPoliklinik","modelPublic"));
		$this->load->library("session");
		$this->isLoggedIn($this->global['idUser'],2,3);
	}

	function index(){
		$this->global['pageTitle'] = "SIMRS - Poliklinik";
		$this->loadViews("masterdata/poliklinik/bodyPoliklinik",$this->global,NULL,"masterdata/poliklinik/footerPoliklinik");
	}

	function viewDaftarPoli(){
		$data['daftarPoli'] = $this->modelPoliklinik->daftarPoli();
		$this->load->view("masterdata/poliklinik/viewDaftarPoli",$data);
	}

	function formTambahPoli(){
		$this->load->view("masterdata/poliklinik/formTambahPoli");
	}

	function simpanPoli(){
		$namaPoli = $this->input->post("namaPoli");
		$keterangan = $this->input->post("keterangan");

		$dataArray = array(
			"poliklinik" => $namaPoli,
			"keterangan" => $keterangan,
			"status" => 1,
			"isDelete" => 1
		);

		$this->modelPoliklinik->simpanPoli($dataArray);
		$this->modelPublic->insertLog($this->global['idUser'],"Menambah Poli Baru, Data : ".$namaPoli);
	}

	function editPoli(){
		$namaPoli = $this->input->post("namaPoli");
		$keterangan = $this->input->post("keterangan");
		$status = $this->input->post("status");
		$idPoli = $this->input->post("idPoli");

		$dataArray = array(
			"poliklinik" => $namaPoli,
			"keterangan" => $keterangan,
			"status" => $status
		);

		$this->modelPoliklinik->editPoli($dataArray,$idPoli);
		$this->modelPublic->insertLog($this->global['idUser'],"Mengupdate Data Poli, Data : ".$namaPoli);
	}

	function formEditPoli(){
		$idPoli = $this->input->post("idPoli");
		$data['poli'] = $this->db->get_where("kl_poliklinik",array("id_poliklinik" => $idPoli))->row();
		$this->load->view("masterdata/poliklinik/formEditPoli",$data);
	}

	function hapusPoli(){
		$idPoli = $this->input->post("idPoli");
		$delete = $this->modelPoliklinik->hapusPoli($idPoli);
		$this->modelPublic->insertLog($this->global['idUser'],"Menghapus Poli, Data : ".$this->modelPublic->getValueOfTable("kl_poliklinik","poliklinik",array("id_poliklinik" => $idPoli)));
	}
}