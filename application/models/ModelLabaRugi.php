<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class ModelLabaRugi extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->load->database();
    }

    function viewPendapatanUsaha($bulan,$tahun){
        $this->db->select(array("SUM(jurnal.debit) as debit","SUM(jurnal.kredit) as kredit","coa_sub.namaSubAkun"));
        $this->db->from("jurnal");
        $this->db->join("coa_sub","coa_sub.kodeSubAkun = jurnal.kodeAkun");
        $this->db->where("coa_sub.kodeAkun",41);
        $this->db->where("MONTH(jurnal.tanggal)",$bulan);
        $this->db->where("YEAR(jurnal.tanggal)",$tahun);
        $this->db->group_by("coa_sub.kodeSubAkun");
        return $this->db->get()->result();
    }

    function viewBeban($bulan,$tahun){
        $this->db->select(array("jurnal.debit as debit","jurnal.kredit as kredit","coa_sub.namaSubAkun"));
        $this->db->from("jurnal");
        $this->db->join("coa_sub","coa_sub.kodeSubAkun = jurnal.kodeAkun");
        $this->db->join("coa","coa.kodeAkun = coa_sub.kodeAkun");
        $this->db->join("coa_header","coa_header.kode = coa.kodeHeader");
        $this->db->where("MONTH(jurnal.tanggal)",$bulan);
        $this->db->where("YEAR(jurnal.tanggal)",$tahun);
        $this->db->where("coa_header.kode",5);
        return $this->db->get()->result();
    }


    function persediaanAkhir($bulan,$tahun){
        $this->db->select(array("SUM(debit) as debit","SUM(kredit) as kredit"));
        $this->db->from("jurnal");
        $this->db->join("coa_sub","coa_sub.kodeSubAkun = jurnal.kodeAkun");
        $this->db->where("MONTH(tanggal)",$bulan);
        $this->db->where("YEAR(tanggal)",$tahun);
        $this->db->where("coa_sub.kodeAkun",14);
        $query = $this->db->get()->row();
        return $query->debit-$query->kredit;
    }

    function totalRetur($bulan,$tahun){
        $this->db->select("SUM(debit) as total");
        $this->db->from("jurnal");
        $this->db->where("MONTH(tanggal)",$bulan);
        $this->db->where("YEAR(tanggal)",$tahun);
        $this->db->where("kodeAkun",2101);
        $query = $this->db->get()->row();
        return $query->total;
    }

    function totalHPP($bulan,$tahun){
        $this->db->select(array("SUM(debit) as debit","SUM(kredit) as kredit"));
        $this->db->from("jurnal");
        $this->db->where("MONTH(tanggal)",$bulan);
        $this->db->where("YEAR(tanggal)",$tahun);
        $this->db->where("kodeAkun",4204);
        $query = $this->db->get()->row();
        return $query->debit-$query->kredit;
    }

    function persediaanAwal($bulan,$tahun){
        $this->db->select("SUM(ak_saldoawal.saldo) as saldo");
        $this->db->from("ak_saldoawal");
        $this->db->join("coa_sub","coa_sub.kodeSubAkun = ak_saldoawal.kodeAkun");
        $this->db->where("coa_sub.kodeAkun",14);
        $this->db->where("ak_saldoawal.bulan",$bulan);        
        $this->db->where("ak_saldoawal.tahun",$tahun);
        $query = $this->db->get()->result();
        foreach($query as $row){
            return $row->saldo;
        }        
    }
}