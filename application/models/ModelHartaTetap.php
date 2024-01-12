<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class ModelHartaTetap extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->load->database();
    }

    function saveKelompokHarta($dataArray){
        $this->db->insert("ak_kelompok_harta",$dataArray);
    }
    
    function urutanKode($kelompokHarta){
        $this->db->from("ak_aset");
        $this->db->where("kelompok",$kelompokHarta);
        return $this->db->count_all_results();
    }

    function simpanAset($dataArray){
        $this->db->insert("ak_aset",$dataArray);
    }

    function totalBarisHarta(){
        $this->db->from("ak_aset");
        return $this->db->count_all_results();
    }

    function viewHartaDatatable($limit,$start,$search){
        $this->db->select(array("ak_aset.kodeAset","ak_aset.nama","ak_kelompok_harta.nama as kelompok","ak_aset.hargaBeli","ak_aset.umurEkonomis","ak_aset.nilaiResidu","ak_aset.metode","ak_aset.tanggalBeli"));
        $this->db->from("ak_aset");
        $this->db->join("ak_kelompok_harta","ak_kelompok_harta.id = ak_aset.kelompok");
        if(!empty($search)){
            $this->db->like("ak_aset.nama",$search);
            $this->db->or_like("ak_aset.kodeAset",$search);
        }

        $this->db->group_by(array("ak_aset.kodeAset","ak_aset.nama","ak_kelompok_harta.nama ","ak_aset.hargaBeli","ak_aset.umurEkonomis","ak_aset.nilaiResidu","ak_aset.metode","ak_aset.tanggalBeli"));
        $this->db->limit($limit,$start);
        return $this->db->get()->result();
    }

    function editAsetSQL($kodeAset,$dataArray){
        $this->db->where("kodeAset",$kodeAset);
        $this->db->update("ak_aset",$dataArray);
    }
}