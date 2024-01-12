<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class ModelLaporanPerubahanModal extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->load->database();
    }

    function viewPendapatanUsaha($bulan,$tahun){
        $this->db->select(array("SUM(jurnal.debit) as debit","SUM(jurnal.kredit) as kredit"));
        $this->db->from("jurnal");
        $this->db->where("kodeAkun",4101);
        $this->db->where("MONTH(jurnal.tanggal)",$bulan);
        $this->db->where("YEAR(jurnal.tanggal)",$tahun);
        $query =  $this->db->get()->row();
        return $query->kredit-$query->debit;
    }

    function viewBeban($bulan,$tahun){
        $this->db->select(array("SUM(jurnal.debit) as debit","SUM(jurnal.kredit) as kredit","coa_sub.namaSubAkun"));
        $this->db->from("jurnal");
        $this->db->join("coa_sub","coa_sub.kodeSubAkun = jurnal.kodeAkun");
        $this->db->where("MONTH(jurnal.tanggal)",$bulan);
        $this->db->where("YEAR(jurnal.tanggal)",$tahun);
        $this->db->where("coa_sub.kodeAkun",51);
        return $this->db->get()->result();
    }

    function totalBeban($bulan,$tahun){
        $this->db->select(array("SUM(jurnal.debit) as debit","SUM(jurnal.kredit) as kredit"));
        $this->db->from("jurnal");
        $this->db->join("coa_sub","coa_sub.kodeSubAkun = jurnal.kodeAkun");
        $this->db->join("coa","coa.kodeAkun = coa_sub.kodeAkun");
        $this->db->join("coa_header","coa_header.kode = coa.kodeHeader");
        $this->db->where("MONTH(jurnal.tanggal)",$bulan);
        $this->db->where("YEAR(jurnal.tanggal)",$tahun);
        $this->db->where("coa_header.kode",5);
        $query =  $this->db->get()->row();
        return $query->debit-$query->kredit;
    }


    function totalModal($bulan,$tahun){
        $this->db->select(array("SUM(debit) as debit","SUM(kredit) as kredit"));
        $this->db->from("jurnal");
        $this->db->where("MONTH(jurnal.tanggal)",$bulan);
        $this->db->where("YEAR(jurnal.tanggal)",$tahun);
        $this->db->where("jurnal.kodeAkun",3101);
        $query = $this->db->get()->result();

        foreach($query as $row){
            return $row->kredit-$row->debit;
        }
    }

    function totalPendapatan($bulan,$tahun){
        $this->db->select(array("SUM(jurnal.debit) as debit","SUM(jurnal.kredit) as kredit"));
        $this->db->from("jurnal");
        $this->db->join("coa_sub","coa_sub.kodeSubAkun = jurnal.kodeAkun");
        $this->db->where("coa_sub.kodeAkun",41);
        $this->db->where("MONTH(jurnal.tanggal)",$bulan);
        $this->db->where("YEAR(jurnal.tanggal)",$tahun);
        $query =  $this->db->get()->row();
        return $query->kredit-$query->debit;
    }

    function totalPrive($bulan,$tahun){
        $this->db->select(array("SUM(debit) as debit","SUM(kredit) as kredit"));
        $this->db->from("jurnal");
        $this->db->where("MONTH(jurnal.tanggal)",$bulan);
        $this->db->where("YEAR(jurnal.tanggal)",$tahun);
        $this->db->where("jurnal.kodeAkun",3102);
        $query = $this->db->get()->result();

        foreach($query as $row){
            return $row->debit-$row->kredit;
        }
    }

    function totalHPP($bulan,$tahun){
        $this->db->select(array("SUM(debit) as debit","SUM(kredit) as kredit"));
        $this->db->from("jurnal");
        $this->db->where("MONTH(jurnal.tanggal)",$bulan);
        $this->db->where("YEAR(jurnal.tanggal)",$tahun);
        $this->db->where("jurnal.kodeAkun",4204);
        $query = $this->db->get()->result();

        foreach($query as $row){
            return $row->debit-$row->kredit;
        }
    }
}