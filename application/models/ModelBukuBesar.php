<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class ModelBukuBesar extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->load->database();
    }

    function viewBukuBesar($dateStart,$dateEnd,$akun){
        $this->db->select(array("jurnal.tanggal","jurnal.keterangan","jurnal.debit","jurnal.kredit"));
        $this->db->from("jurnal");
        $this->db->where("tanggal BETWEEN '$dateStart' AND '$dateEnd'");
        $this->db->where("kodeAkun",$akun);
        return $this->db->get()->result();
    }
}