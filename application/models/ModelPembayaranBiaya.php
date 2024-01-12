<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class ModelPembayaranBiaya extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->load->database();
    }

    function biayaAktif(){
        $this->db->select(array("kodeSubAkun","namaSubAkun"));
        $this->db->from("coa_sub");
        $this->db->join("coa","coa.kodeAkun = coa_sub.kodeAkun");
        $this->db->where("coa.kodeHeader",5);
        $this->db->where("coa_sub.status",1);
        $this->db->where("coa_sub.isDelete",1);
        return $this->db->get()->result();
    }

    function insertPembayaranBiaya($pembayaranBiaya){
        $this->db->insert("ak_pembayaran_biaya",$pembayaranBiaya);
    }

    function urutanBayar(){
        $today = date('Y-m-d');
        $this->db->from("ak_pembayaran_biaya");
        $this->db->where("DATE(tanggal)",$today);
        return $this->db->count_all_results();
    }
}