<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';

class ItemRadiologi extends BaseController{
	function __construct(){
		parent::__construct();
		$this->load->model("modelRadiologi");
		$this->isLoggedIn($this->global['idUser'],2,11);
	}

	function index(){
		$this->global['pageTitle'] = "SIMRS - Item Radiologi";
		$this->loadViews("radiologi/itemradiologi/bodyItemRadiologi",$this->global,NULL,"radiologi/itemradiologi/footerItemRadiologi");
	}

	function datatableItem(){
		$data['item'] = $this->modelRadiologi->tampilkanRadAktif();
		$this->load->view("radiologi/itemradiologi/datatableItem",$data);
	}

	function formTambahItem(){
		$this->load->view("radiologi/itemradiologi/formTambahItem");
	}

	function formUbahItem(){
		$id = $this->input->post("id");
		$data['item'] = $this->db->get_where("kl_radiologiitem",array("id" => $id))->row();
		$this->load->view("radiologi/itemradiologi/formUbahRadiologi",$data);
	}

	function tambahItemSQL(){
		$namaRad = $this->input->post("namaRadiologi");
		$harga = $this->input->post("harga");
		$keterangan = $this->input->post("keterangan");

		$dataArray = array(
			"namaRadiologi" => $namaRad,
			"harga" => $harga,
			"keterangan" => $keterangan,
			"status" => 1,
			"isDelete" => 1
		);

		$this->modelRadiologi->simpanItemRad($dataArray);
	}

	function editItemSQL(){
		$namaRadiologi = $this->input->post("namaRadiologi");
		$harga = $this->input->post("harga");
		$keterangan = $this->input->post("keterangan");
		$status = $this->input->post("status");
		$id = $this->input->post("id");

		$dataArray = array(
			"namaRadiologi" => $namaRadiologi,
			"harga" => $harga,
			"keterangan" => $keterangan,
			"status" => $status,
			"isDelete" => 1
		);

		$this->modelRadiologi->editItemLab($dataArray,$id);
	}

	function hapusItem(){
		$id = $this->input->post("id");

		$dataUpdate = array(
			"isDelete" => 0
		);

		$this->modelRadiologi->hapusItem($dataUpdate,$id);
	}
}