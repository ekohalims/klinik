<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class ModelPoliklinik extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	function simpanPoli($dataArray){
		$this->db->insert("kl_poliklinik",$dataArray);
		return $this->db->count_all_results();
	}

	function editPoli($dataArray,$idPoli){
		$this->db->where("id_poliklinik",$idPoli);
		$this->db->update("kl_poliklinik",$dataArray);
		return $this->db->count_all_results();
	}

	function daftarPoli(){
		$this->db->select("*");
		$this->db->from("kl_poliklinik");
		$this->db->where("isDelete",1);
		$this->db->order_by("id_poliklinik","DESC");
		return $this->db->get()->result();
	}

	function hapusPoli($idPoli){
		$dataUpdate = array(
			"isDelete" => 0
		);

		$this->db->where("id_poliklinik",$idPoli);
		$this->db->update("kl_poliklinik",$dataUpdate);
		return $this->db->count_all_results();
	}
}