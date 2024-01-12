<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class ModelNeracaSaldo extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->load->database();
    }

    function viewAkun(){
        $this->db->select(array("kodeSubAkun","namaSubAkun"));
        $this->db->from("coa_sub");
        return $this->db->get()->result();
    }

    function viewNeracaSaldo($bulan,$tahun){
        $this->db->select(array("SUM(jurnal.debit) as debit","SUM(jurnal.kredit) as kredit","jurnal.kodeAkun","coa_sub.namaSubAkun"));
        $this->db->from("jurnal");
        $this->db->join("coa_sub","coa_sub.kodeSubAkun = jurnal.kodeAkun");
        $this->db->where("MONTH(tanggal)",$bulan);
        $this->db->where("YEAR(tanggal)",$tahun);
        $this->db->group_by("kodeAkun");
        return $this->db->get()->result();
    }

    function hartaLancar(){
        $this->db->select(array("kodeSubAkun","namaSubAkun"));
        $this->db->from("coa_sub");
        $this->db->where("kodeAkun",11);
        return $this->db->get()->result();
    }

    function asetTetap(){
        $this->db->select(array("coa_sub.kodeSubAkun","coa_sub.namaSubAkun","SUM(ak_aset.hargaBeli) as hargaBeli"));
        $this->db->from("coa_sub");
        $this->db->join("ak_aset","ak_aset.akunHarta = coa_sub.kodeSubAkun");
        $this->db->where("coa_sub.kodeAkun",17);
        return $this->db->get()->result();
    }

    function kewajiban(){
        $this->db->select(array("kodeSubAkun","namaSubAkun"));
        $this->db->from("coa_sub");
        $this->db->where("kodeAkun",21);
        return $this->db->get()->result();
    }

    function modal(){
        $this->db->select(array("kodeSubAkun","namaSubAkun"));
        $this->db->from("coa_sub");
        $this->db->where("kodeAkun",31);
        return $this->db->get()->result();
    }

    function hartaLancarNeraca($bulan,$tahun){
        $this->db->select(array("coa_sub.kodeSubAkun","coa_sub.namaSubAkun","SUM(jurnal.debit) as debit","SUM(jurnal.kredit) as kredit"));
        $this->db->from("jurnal");
        $this->db->join("coa_sub","coa_sub.kodeSubAkun = jurnal.kodeAkun");
        $this->db->join("coa","coa.kodeAkun = coa_sub.kodeAkun");
        $this->db->where("MONTH(jurnal.tanggal)",$bulan);
        $this->db->where("YEAR(jurnal.tanggal)",$tahun);
        $this->db->where("coa.kodeHeader",1);
        $this->db->group_by("jurnal.kodeAkun");
        return $this->db->get()->result();
    }

    function kewajibanNeraca($bulan,$tahun){
        $this->db->select(array("coa_sub.kodeSubAkun","coa_sub.namaSubAkun","SUM(jurnal.debit) as debit","SUM(jurnal.kredit) as kredit"));
        $this->db->from("jurnal");
        $this->db->join("coa_sub","coa_sub.kodeSubAkun = jurnal.kodeAkun");
        $this->db->where("MONTH(jurnal.tanggal)",$bulan);
        $this->db->where("YEAR(jurnal.tanggal)",$tahun);
        $this->db->where("coa_sub.kodeAkun",21);
        $this->db->group_by("jurnal.kodeAkun");
        return $this->db->get()->result();
    }

    function modalNeraca($bulan,$tahun){
        $this->db->select(array("coa_sub.kodeSubAkun","coa_sub.namaSubAkun","SUM(jurnal.debit) as debit","SUM(jurnal.kredit) as kredit"));
        $this->db->from("jurnal");
        $this->db->join("coa_sub","coa_sub.kodeSubAkun = jurnal.kodeAkun");
        $this->db->where("MONTH(jurnal.tanggal)",$bulan);
        $this->db->where("YEAR(jurnal.tanggal)",$tahun);
        $this->db->where("coa_sub.kodeAkun",31);
        $this->db->group_by("jurnal.kodeAkun");
        return $this->db->get()->result();
    }

    function historicalBalancing($bulan,$tahun){
        $this->db->select(array("SUM(debit) as debit","SUM(kredit) as kredit"));
        $this->db->from("jurnal");
        $this->db->where("MONTH(jurnal.tanggal)",$bulan);
        $this->db->where("YEAR(jurnal.tanggal)",$tahun);
        $this->db->where("jurnal.kodeAkun",3103);
        $query = $this->db->get()->result();
    
        foreach($query as $row){
            return $row->kredit-$row->debit;
        }   
    }
}