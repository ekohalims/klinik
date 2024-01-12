<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class ModelRadiologi extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	function simpanItemRad($dataArray){
		$this->db->insert("kl_radiologiitem",$dataArray);
	}

	function tampilkanRadAktif(){
		$this->db->select("*");
		$this->db->from("kl_radiologiitem");
		$this->db->where("isDelete",1);
		$this->db->order_by("id","DESC");
		return $this->db->get()->result();
	}

	function editItemLab($dataArray,$id){
		$this->db->where("id",$id);
		$this->db->update("kl_radiologiitem",$dataArray);
	}

	function hapusItem($dataUpdate,$id){
		$this->db->where("id",$id);
		$this->db->update("kl_radiologiitem",$dataUpdate);
	}

}