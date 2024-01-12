<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class ModelDokter extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	function daftarPoliAktif(){
		$this->db->select("*");
		$this->db->from("kl_poliklinik");
		$this->db->where("isDelete",1);
		$this->db->where("status",1);
		$this->db->order_by("poliklinik","ASC");
		return $this->db->get()->result();
	}

	function simpanDokter($dataDokter){
		$this->db->insert("kl_dokter",$dataDokter);
	}

	function editDokterSQL($dataDokter,$idDokter){
		$this->db->where("id_dokter",$idDokter);
		$this->db->update("kl_dokter",$dataDokter);
		return $this->db->affected_rows();
	}

	function viewDokterAktif(){
		$this->db->select(array("kl_dokter.id_dokter","kl_dokter.nama","kl_dokter.noHP","kl_dokter.jenisKelamin","kl_dokter.noIzinPraktek","CONCAT(kl_dokter.alamat,',',ae_provinsi.nama_provinsi) as alamat","kl_poliklinik.poliklinik","kl_dokter.status","kl_dokter.isDelete"));
		$this->db->from("kl_dokter");
		$this->db->join("ae_provinsi","ae_provinsi.id_provinsi = kl_dokter.provinsi","left");
		$this->db->join("ae_kabupaten","ae_kabupaten.kabupaten_id = kl_dokter.kabupaten","left");
		$this->db->join("ae_kecamatan","ae_kecamatan.id_kecamatan = kl_dokter.kecamatan","left");
		$this->db->join("kl_poliklinik","kl_poliklinik.id_poliklinik = kl_dokter.idPoliklinik");
		$this->db->where("kl_dokter.isDelete ",1);
		$this->db->order_by("kl_dokter.id_dokter","DESC");
		$this->db->group_by("kl_dokter.id_dokter");
		return $this->db->get()->result();
	}

	function hapusDokter($dataUpdate,$idDokter){
		$this->db->where("id_dokter",$idDokter);
		$this->db->update("kl_dokter",$dataUpdate);
		return $this->db->affected_rows();
	}
}