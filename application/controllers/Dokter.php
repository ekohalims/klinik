<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';

class Dokter extends BaseController{
	function __construct(){
		parent::__construct();
		$this->load->model("modelDokter");
		$this->isLoggedIn($this->global['idUser'],2,3);
	}

	function index(){
		$this->global['pageTitle'] = "SIMRS - Master Data Dokter";
		$this->loadViews("masterdata/dokter/bodyDokter",$this->global,NULL,"masterdata/dokter/footerDokter");
	}

	function tambahDokter(){
		$this->global['pageTitle'] = "SIMRS - Tambah Dokter";
		$data['poli'] = $this->modelDokter->daftarPoliAktif();
		$data['provinsi'] = $this->db->get("ae_provinsi")->result();
		$this->loadViews("masterdata/dokter/bodyTambahDokter",$this->global,$data,"masterdata/dokter/footerTambahDokter");
	}

	function editDokter(){
		$this->global['pageTitle'] = "SIMRS - Edit Dokter";
		$idDokter = $this->dekripsi($this->input->get("idDokter"));
		$getDokter = $this->db->get_where("kl_dokter",array("id_dokter" => $idDokter))->row();

		$data['poli'] = $this->modelDokter->daftarPoliAktif();
		$data['provinsi'] = $this->db->get("ae_provinsi")->result();
 		$data['dokter'] = $getDokter;

 		$data['kabupaten'] = $this->db->get_where("ae_kabupaten",array("id_provinsi" => $getDokter->provinsi))->result();
 		$data['kecamatan'] = $this->db->get_where("ae_kecamatan",array("kabupaten_id" => $getDokter->kabupaten))->result();
		$this->loadViews("masterdata/dokter/bodyEditDokter",$this->global,$data,"masterdata/dokter/footerEditDokter");
	}

	function simpanDokterSQL(){
		$namaLengkap = $this->input->post("namaLengkap");
		$jenisKelamin = $this->input->post("jenisKelamin");
		$noHP = $this->input->post("noHP");
		$noIzinPraktek = $this->input->post("noIzinPraktek");
		$poliklinik = $this->input->post("poliklinik");
		$alamat = $this->input->post("alamat");
		$provinsi = $this->input->post("provinsi");
		$kabupaten = $this->input->post("kabupaten");
		$kecamatan = $this->input->post("kecamatan");

		$dataDokter = array(
			"nama" => $namaLengkap,
			"noHP" => $noHP,
			"jenisKelamin" => $jenisKelamin,
			"noIzinPraktek" => $noIzinPraktek,
			"alamat" => $alamat,
			"provinsi" => $provinsi,
			"kabupaten" => $kabupaten,
			"kecamatan" => $kecamatan,
			"idPoliklinik" => $poliklinik,
			"status" => 1,
			"isDelete" => 1
		);

		$this->modelDokter->simpanDokter($dataDokter);
		$this->modelPublic->insertLog($this->global['idUser'],"Menambah Dokter Baru, Data : ".$namaLengkap);
	}

	function editDokterSQL(){
		$namaLengkap = $this->input->post("namaLengkap");
		$jenisKelamin = $this->input->post("jenisKelamin");
		$noHP = $this->input->post("noHP");
		$noIzinPraktek = $this->input->post("noIzinPraktek");
		$poliklinik = $this->input->post("poliklinik");
		$alamat = $this->input->post("alamat");
		$provinsi = $this->input->post("provinsi");
		$kabupaten = $this->input->post("kabupaten");
		$kecamatan = $this->input->post("kecamatan");
		$idDokter = $this->dekripsi($this->input->post("idDokter"));
		$status = $this->input->post("status");

		$dataDokter = array(
			"nama" => $namaLengkap,
			"noHP" => $noHP,
			"jenisKelamin" => $jenisKelamin,
			"noIzinPraktek" => $noIzinPraktek,
			"alamat" => $alamat,
			"provinsi" => $provinsi,
			"kabupaten" => $kabupaten,
			"kecamatan" => $kecamatan,
			"idPoliklinik" => $poliklinik,
			"status" => $status,
			"isDelete" => 1
		);

		echo $this->modelDokter->editDokterSQL($dataDokter,$idDokter);
		$this->modelPublic->insertLog($this->global['idUser'],"Mengupdate Dokter, Data :".$namaLengkap);
	}

	function viewTableDokter(){
		$data['dokter'] = $this->modelDokter->viewDokterAktif();
		$this->load->view("masterdata/dokter/viewTableDokter",$data);
	}

	function hapusDokter(){
		$idDokter = $this->dekripsi($this->input->post("idDokter"));

		$dataUpdate = array(
			"isDelete" => 0
		);

		$this->modelDokter->hapusDokter($dataUpdate,$idDokter);
		$this->modelPublic->insertLog($this->global['idUser'],"Menghapus Dokter, Nama Dokter : ".$this->modelPublic->getValueOfTable("kl_dokter","nama",array("id_dokter" => $idDokter)));
	}
}