<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class ModelJurnalUmum extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->load->database();
    }

    function subAccount($kodeAkun){
        $this->db->select(array("kodeSubAkun","namaSubAkun"));
        $this->db->from("coa_sub");
        $this->db->where("status",1);
        $this->db->where("isDelete",1);
        $this->db->where("kodeAkun",$kodeAkun);
        return $this->db->get()->result();
    }

    function addTempJurnal($dataArray){
        $this->db->insert("jurnal_temp",$dataArray);
    }

    function viewJurnalTemp($idUser){
        $this->db->select(array("jurnal_temp.id","coa_sub.kodeSubAkun","coa_sub.namaSubAkun as namaAkun","jurnal_temp.debit","jurnal_temp.kredit","jurnal_temp.deskripsi"));
        $this->db->from("jurnal_temp");
        $this->db->join("coa_sub","coa_sub.kodeSubAkun = jurnal_temp.kodeAkun");
        $this->db->where("jurnal_temp.idUser",$idUser);
        return $this->db->get();
    }

    function updateJurnalTemp($dataUpdate,$kodeAkun){
        $this->db->where("id",$kodeAkun);
        $this->db->update("jurnal_temp",$dataUpdate);
    }

    function hapusAkun($kodeAkun){
        $this->db->delete("jurnal_temp",array("id" => $kodeAkun));
    }

    function urutanJurnalHead(){
        $today = date('Y-m-d');
        $this->db->from("jurnal_umum_head");
        $this->db->where("DATE(tanggal)",$today);
        return $this->db->count_all_results();
    }

    function insertHeadJurnal($dataArray){
        $this->db->insert("jurnal_umum_head",$dataArray);
    }

    function insertBatchJurnalUmum($dataJurnal){
        $this->db->insert_batch("jurnal",$dataJurnal);
    }

    function hapusJurnalTemp($idUser){
        $this->db->delete("jurnal_temp",array("idUser" => $idUser));
    }
    
    function getJurnalPerNumber($noHeadJurnal){
        $this->db->select(array("jurnal.kodeAkun","coa_sub.namaSubAkun as namaAkun","jurnal.keterangan","jurnal.debit","jurnal.kredit"));
        $this->db->from("jurnal");
        $this->db->join("coa_sub","coa_sub.kodeSubAkun = jurnal.kodeAkun");
        $this->db->where("jurnal.noReferrence",$noHeadJurnal);
        return $this->db->get()->result();
    }

    function cekKodeAkun($kodeAkun){
        $this->db->from("coa_sub");
        $this->db->where("kodeSubAkun",$kodeAkun);
        $this->db->group_start();
        $this->db->where("kodeAkun",11);
        $this->db->or_where("kodeAkun",12);
        $this->db->group_end();
        return $this->db->count_all_results();
    }

    function currentSaldo($kodeAkun){
        $this->db->select("saldo");
        $this->db->from("coa_sub");
        $this->db->where("kodeSubAkun",$kodeAkun);
        $query = $this->db->get()->row();
        return $query->saldo;
    }

    function updateSaldo($kodeAkun,$debit,$kredit){
        $currentSaldo = $this->currentSaldo($kodeAkun);
        
        if($debit > 0){
            $dataUpdate = array(
                "saldo" => $currentSaldo+$debit
            );
        } else {
            $dataUpdate = array(
                "saldo" => $currentSaldo-$kredit
            );
        }

        $this->db->where("kodeSubAkun",$kodeAkun);
        $this->db->update("coa_sub",$dataUpdate);
    }
}