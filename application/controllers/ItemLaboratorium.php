<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';

class ItemLaboratorium extends BaseController{
	function __construct(){
		parent::__construct();
		$this->load->model("modelLaboratorium");
		$this->isLoggedIn($this->global['idUser'],2,9);
	}

	function index(){
		$this->global['pageTitle'] = "SIMRS - Item Laboratorium";
		$this->loadViews("laboratorium/itemlaboratorium/bodyItemLaboratorium",$this->global,NULL,"laboratorium/itemlaboratorium/footerItemLaboratorium");
	}

	function datatableItem(){
		$data['item'] = $this->modelLaboratorium->tampilkanLabAktif();
		$this->load->view("laboratorium/itemlaboratorium/datatableItem",$data);
	}

	function formTambahItem(){
		$this->load->view("laboratorium/itemlaboratorium/formTambahItem");
	}

	function formUbahItem(){
		$id = $this->input->post("id");
		$data['item'] = $this->db->get_where("kl_labitem",array("id" => $id))->row();
		$this->load->view("laboratorium/itemlaboratorium/formUbahLaboratorium",$data);
	}

	function tambahItemSQL(){
		$namaLaboratorium = $this->input->post("namaLaboratorium");
		$harga = $this->input->post("harga");
		$keterangan = $this->input->post("keterangan");

		$dataArray = array(
			"namaLab" => $namaLaboratorium,
			"harga" => $harga,
			"keterangan" => $keterangan,
			"status" => 1,
			"isDelete" => 1
		);

		$this->modelLaboratorium->simpanItemLab($dataArray);
	}

	function editItemSQL(){
		$namaLaboratorium = $this->input->post("namaLaboratorium");
		$harga = $this->input->post("harga");
		$keterangan = $this->input->post("keterangan");
		$status = $this->input->post("status");
		$id = $this->input->post("id");

		$dataArray = array(
			"namaLab" => $namaLaboratorium,
			"harga" => $harga,
			"keterangan" => $keterangan,
			"status" => $status,
			"isDelete" => 1
		);

		$this->modelLaboratorium->editItemLab($dataArray,$id);
	}

	function hapusItem(){
		$id = $this->input->post("id");

		$dataUpdate = array(
			"isDelete" => 0
		);

		$this->modelLaboratorium->hapusItem($dataUpdate,$id);
	}
}