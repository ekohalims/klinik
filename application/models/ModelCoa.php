<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class ModelCoa extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->load->database();
    }
    
    function simpanCoa($dataArray){
        $this->db->insert("coa_sub",$dataArray);
    }

    function subCoa($kodeAkun){
        $this->db->select("*");
        $this->db->from("coa_sub");
        $this->db->where("kodeAkun",$kodeAkun);
        $this->db->where("isDelete",1);
        $this->db->where("status",1);
        return $this->db->get()->result();
    }

    function getSubCoa($kode){
        $this->db->select(array("kodeAkun","namaAkun"));
        $this->db->from("coa");
        $this->db->where("kodeHeader",$kode);
        return $this->db->get()->result();
    }

    function cekKodeAkun($kodeAkun){
        $this->db->from("coa_sub");
        $this->db->where("kodeSubAkun",$kodeAkun);
        return $this->db->count_all_results();
    }

    function updateCoa($kodeAkun,$dataUpdate){
        $this->db->where("kodeSubAkun",$kodeAkun);
        $this->db->update("coa_sub",$dataUpdate);
    }

    function hapusCoa($kodeAkun){
        $dataUpdate = array(
            "isDelete" => 0
        );

        $this->db->where("kodeSubAkun",$kodeAkun);
        $this->db->update("coa_sub",$dataUpdate);
    }

    function urutanAkun($kategori){
        $this->db->from("coa_sub");
        $this->db->where("kodeAkun",$kategori);
        return $this->db->count_all_results();
    }

    function simpanDataBank($dataBank){
        $this->db->insert("bank",$dataBank);
    }
}