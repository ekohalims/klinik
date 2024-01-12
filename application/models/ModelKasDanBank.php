<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class ModelKasDanBank extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->load->database();
    }
    
    function viewAkunAktif(){
        $this->db->select("*");
        $this->db->from("coa_sub");
        $this->db->where("kodeAkun",10000);
        $this->db->where("status",1);
        $this->db->where("isDelete",1);
        return $this->db->get()->result();
    }

    function updateSaldoAwal($dataUpdate,$kodeAkun){
        $this->db->where("kodeSubAkun",$kodeAkun);
        $this->db->update("coa_sub",$dataUpdate);
    }

    function urutanTrxMasuk(){
        $today = date('Y-m-d');
        $this->db->from("ak_transaksikas");
        $this->db->where("tanggal",$today);
        $this->db->where("jenis","MASUK");
        return $this->db->count_all_results();
    }

    function urutanTrxKeluar(){
        $today = date('Y-m-d');
        $this->db->from("ak_transaksikas");
        $this->db->where("tanggal",$today);
        $this->db->where("jenis","KELUAR");
        return $this->db->count_all_results();
    }

    function saldoKas(){
        $this->db->select(array("coa_sub.kodeSubAkun","coa_sub.namaSubAkun","coa_sub.saldo"));
        $this->db->from("coa_sub");
        $this->db->where("kodeAkun",11);
        $this->db->or_where("kodeAkun",12);
        $query = $this->db->get()->result();
        return $query;
    }

    function tambahSaldoAkun($currentSaldo,$sebesar,$kodeAkun){
        $dataUpdate = array(
            "saldo" => $currentSaldo+$sebesar
        );

        $this->db->where("kodeSubAkun",$kodeAkun);
        $this->db->update("coa_sub",$dataUpdate);
    }

    function kurangiSaldoAkun($currentSaldo,$sebesar,$kodeAkun){
        $dataUpdate = array(
            "saldo" => $currentSaldo-$sebesar
        );

        $this->db->where("kodeSubAkun",$kodeAkun);
        $this->db->update("coa_sub",$dataUpdate);
    }

    function saldoBank($kodeBank){
        $this->db->select("saldo");
        $this->db->from("bank");
        $this->db->where("kodeBank",$kodeBank);
        $query = $this->db->get()->row();
        return $query->saldo;
    }

    function tambahSaldoBank($currentSaldo,$sebesar,$kodeBank){
        $dataUpdate = array(
            "saldo" => $currentSaldo+$sebesar
        );

        $this->db->where("kodeBank",$kodeBank);
        $this->db->update("bank",$dataUpdate);
    }

    function simpanHeaderTrx($dataArray){
        $this->db->insert("ak_transaksikas",$dataArray);
    }

    function kasAktif(){
        $this->db->select(array("coa_sub.kodeSubAkun","coa_sub.namaSubAkun"));
        $this->db->from("coa_sub");
        $this->db->where("kodeAkun",11);
        $this->db->where("isDelete",1);
        return $this->db->get()->result();
    }

    function bankAktif(){
        $this->db->select(array("coa_sub.kodeSubAkun","coa_sub.namaSubAkun"));
        $this->db->from("coa_sub");
        $this->db->where("kodeAkun",12);
        $this->db->where("isDelete",1);
        return $this->db->get()->result();
    }

    function coaKeluar(){
        $this->db->select("*");
        $this->db->from("coa");
        $this->db->where("kodeAkun != 11");
        $this->db->where("kodeAkun != 12");
        return $this->db->get()->result();
    }

    function currentSaldoKas($kodeAkun){
        $this->db->select("saldo");
        $this->db->from("coa_sub");
        $this->db->where("kodeSubakun",$kodeAkun);
        $query = $this->db->get()->row();
        return $query->saldo;
    }

    function urutanMutasi(){
        $bulan = date('m');
        $tahun = date("Y");

        $this->db->from("ak_mutasikas");
        $this->db->where("MONTH(ak_mutasikas.tanggal)",$bulan);
        $this->db->where("YEAR(ak_mutasikas.tanggal)",$tahun);
        return $this->db->count_all_results();
    }

    function insertMutasiHeader($dataMutasi){
        $this->db->insert("ak_mutasikas",$dataMutasi);
    }

    function countKasTrx($param){
        $this->db->from("ak_transaksikas");
        $this->db->where("jenis",$param);
        return $this->db->count_all_results();
    }

    function listKasDatatables($limit,$start,$search,$param){
        $this->db->select(array("ak_transaksikas.kodeTrx","ak_transaksikas.tanggal","ak_transaksikas.kodeAkun","coa_sub.namaSubAkun","users.first_name","users.last_name","ak_transaksikas.memo","ak_transaksikas.sebesar"));
        $this->db->from("ak_transaksikas");
        $this->db->join("coa_sub","coa_sub.kodeSubAkun = ak_transaksikas.kodeAkun");
        $this->db->join("users","users.id = ak_transaksikas.idUser");
        $this->db->where("ak_transaksikas.jenis",$param);

        if(!empty($search)){
            $this->db->like("ak_transaksikas.kodeTrx",$search);
        }
        $this->db->limit($limit,$start);
        $this->db->group_by("ak_transaksikas.kodeTrx");
        $this->db->order_by("ak_transaksikas.tanggal","DESC");
        return $this->db->get();
    }
}