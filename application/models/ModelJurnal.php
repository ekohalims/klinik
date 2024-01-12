<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class ModelJurnal extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->load->database();
    }

    function viewJurnal($dateStart,$dateEnd){
        $this->db->select(array("jurnal.tanggal","coa_sub.namaSubAkun as namaAkun","jurnal.kodeAkun","jurnal.debit","jurnal.kredit","jurnal.keterangan"));
        $this->db->from("jurnal");
        $this->db->join("coa_sub","coa_sub.kodeSubAkun = jurnal.kodeAkun");
        $this->db->where("jurnal.tanggal BETWEEN '$dateStart' AND '$dateEnd'");
        return $this->db->get()->result();
    }
}