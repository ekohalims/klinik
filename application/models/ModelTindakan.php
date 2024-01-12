<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class ModelTindakan extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->load->database();
	}
	
	function viewTindakan($tableName){
		$this->db->select(array(
			"kl_masterjenis.nama",
			$tableName.".namaTarif",
			$tableName.".tarif",
			$tableName.".sarana",
			$tableName.".dokter",
			$tableName.".bhp",
			$tableName.".alat",
			$tableName.".jenis",
			$tableName.".kode"
		));
		$this->db->from($tableName);
		$this->db->join("kl_masterjenis","kl_masterjenis.id = $tableName.jeis","left");
		$this->db->group_by("kode");
		$this->db->order_by("kode","DESC");
		return $this->db->get()->result();
	}

	function viewTarifVK($limit,$start,$search){
		$this->db->select("*");
		$this->db->from("kl_tarifvk");
		if(!empty($search)){
			$this->db->like("kode",$search);
			$this->db->or_like("namaTarif",$search);
		}
		$this->db->limit($limit,$start);
		return $this->db->get();
	}

	function totalTarif($kode){
		$this->db->select("SUM(tarif) as tarif");
		$this->db->from("kl_tarifvkrinci");
		$this->db->where("kode",$kode);
		$query = $this->db->get()->result();
		foreach($query as $row){
			return $row->tarif; 
		}
	}

	function viewTarifOK($limit,$start,$search){
		$this->db->select("*");
		$this->db->from("kl_tarifok");
		if(!empty($search)){
			$this->db->like("kode",$search);
			$this->db->or_like("namaTarif",$search);
		}
		$this->db->limit($limit,$start);
		return $this->db->get();
	}

	function totalTarifOK($kode){
		$this->db->select("SUM(tarif) as tarif");
		$this->db->from("kl_tarifokrinci");
		$this->db->where("kode",$kode);
		$query = $this->db->get()->result();
		foreach($query as $row){
			return $row->tarif; 
		}
	}
	
	function viewTarifLabDatatable($limit,$start,$search,$jenis){
		$this->db->select("*");
		$this->db->from("kl_tariflab");
		$this->db->join("kl_tariflabkategori","kl_tariflabkategori.idKategori = kl_tariflab.idKategori","left");
		$this->db->where("jenis",$jenis);

		if(!empty($search)){
			$this->db->like("kl_tariflab.namaTarif",$search);
		}
		$this->db->order_by("kl_tariflab.kode","DESC");
		return $this->db->get();
	}

	function tarifLabSelect2($q){
		$this->db->select("*");
		$this->db->from("kl_tariflab");
		$this->db->where("jenis","S");
		if(!empty($q)){
			$this->db->like("namaTarif",$q);
		}

		return $this->db->get();
	}
}