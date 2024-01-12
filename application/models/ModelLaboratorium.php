<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class ModelLaboratorium extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	function simpanItemLab($dataArray){
		$this->db->insert("kl_labitem",$dataArray);
	}

	function tampilkanLabAktif(){
		$this->db->select("*");
		$this->db->from("kl_labitem");
		$this->db->where("isDelete",1);
		$this->db->order_by("id","DESC");
		return $this->db->get()->result();
	}

	function editItemLab($dataArray,$id){
		$this->db->where("id",$id);
		$this->db->update("kl_labitem",$dataArray);
	}

	function hapusItem($dataUpdate,$id){
		$this->db->where("id",$id);
		$this->db->update("kl_labitem",$dataUpdate);
	}

}