<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class ModelTrxJurnal extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->load->database();
    }


    function sisipkanJurnal($akunDebit,$akunKredit,$noReff,$keterangan){
        $urutanNoJurnal = $this->noJurnal();
        $noJurnal = "JURN".date('y').date('m').date('d').sprintf('%04d',$urutanNoJurnal+1);

        foreach($akunDebit as $db){
            $kodeAkunDebit = $db['kodeAkun'];
            $valueDebit = $db['value'];
            $posisiDebit = $db['posisi'];
            $slugDebit = $db['slug'];

            if($valueDebit > 0){
                $debitArray[] = array(
                    "noJurnal" => $noJurnal,
                    "noReferrence" => $noReff,
                    "tanggal" => date('Y-m-d'),
                    "kodeAkun" => $kodeAkunDebit,
                    "debit" => $valueDebit,
                    "posisi" => $posisiDebit,
                    "keterangan" => $keterangan,
                    "slug" => $slugDebit
                );
            }
        }

        $this->db->insert_batch("jurnal",$debitArray);

        foreach($akunKredit as $kr){
            $kodeAkunKredit = $kr['kodeAkun'];
            $valueKredit = $kr['value'];
            $posisiKredit = $kr['posisi'];
            $slugKredit = $kr['slug'];

            if($valueKredit > 0){
                $kreditArray[] = array(
                    "noJurnal" => $noJurnal,
                    "noReferrence" => $noReff,
                    "tanggal" => date('Y-m-d'),
                    "kodeAkun" => $kodeAkunKredit,
                    "kredit" => $valueKredit,
                    "posisi" => $posisiKredit,
                    "keterangan" => $keterangan,
                    "slug" => $slugKredit
                );
            }
        }

        $this->db->insert_batch("jurnal",$kreditArray);
    }

    function insertJurnal($noReff,$akunDebit,$akunKredit,$keterangan,$value){
        $urutanNoJurnal = $this->noJurnal();
        $noJurnal = "JURN".date('y').date('m').date('d').sprintf('%04d',$urutanNoJurnal+1);

        $dataDebit = array(
            "noJurnal" => $noJurnal,
            "noReferrence" => $noReff,
            "tanggal" => date('Y-m-d'),
            "kodeAkun" => $akunDebit,
            "debit" => $value,
            "keterangan" => $keterangan,
            "posisi" => 'D',
            "slug" => ''
        );

        $dataKredit = array(
            "noJurnal" => $noJurnal,
            "noReferrence" => $noReff,
            "tanggal" => date('Y-m-d'),
            "kodeAkun" => $akunKredit,
            "kredit" => $value,
            "keterangan" => $keterangan,
            "posisi" => 'K',
            "slug" => ''
        );

        $this->db->insert("jurnal",$dataDebit);
        $this->db->insert("jurnal",$dataKredit);
    }

    //
    function insertJurnalAkhirBulan($noReff,$akunDebit,$akunKredit,$keterangan,$value,$tanggalJurnal){
        $urutanNoJurnal = $this->noJurnalAkhirBulan($tanggalJurnal);
        $formatTanggal = date_format(date_create($tanggalJurnal),'ymd');
        $noJurnal = "JURN".$formatTanggal.sprintf('%04d',$urutanNoJurnal+1);

        $dataDebit = array(
            "noJurnal" => $noJurnal,
            "noReferrence" => $noReff,
            "tanggal" => $tanggalJurnal,
            "kodeAkun" => $akunDebit,
            "debit" => $value,
            "keterangan" => $keterangan,
            "posisi" => 'D',
            "slug" => ''
        );

        $dataKredit = array(
            "noJurnal" => $noJurnal,
            "noReferrence" => $noReff,
            "tanggal" => $tanggalJurnal,
            "kodeAkun" => $akunKredit,
            "kredit" => $value,
            "keterangan" => $keterangan,
            "posisi" => 'K',
            "slug" => ''
        );

        $this->db->insert("jurnal",$dataDebit);
        $this->db->insert("jurnal",$dataKredit);
    }

    function noJurnalAkhirBulan($tanggal){
        $this->db->from("jurnal");
        $this->db->group_by("noJurnal");
        $this->db->where("tanggal",$tanggal);
        return $this->db->count_all_results();
    }

    function insertJurnalPenjualan($noReff,$akunDebit,$keterangan,$value,$dataTindakan,$dataObat,$dataLab,$dataRadiologi){
        $urutanNoJurnal = $this->noJurnal();
        $noJurnal = "JURN".date('y').date('m').date('d').sprintf('%04d',$urutanNoJurnal+1);

        $dataDebit = array(
            "noJurnal" => $noJurnal,
            "noReferrence" => $noReff,
            "tanggal" => date('Y-m-d'),
            "kodeAkun" => $akunDebit,
            "debit" => $value,
            "keterangan" => $keterangan,
            "posisi" => 'D',
            "slug" => ''
        );
        
        $this->db->insert("jurnal",$dataDebit);

        if($dataTindakan > 0){
            $dataKredit = array(
                "noJurnal" => $noJurnal,
                "noReferrence" => $noReff,
                "tanggal" => date('Y-m-d'),
                "kodeAkun" => '4102',
                "kredit" => $dataTindakan,
                "keterangan" => $keterangan,
                "posisi" => 'K',
                "slug" => ''
            );
            
            $this->db->insert("jurnal",$dataKredit);
        }

        if($dataObat > 0){
            $dataKredit = array(
                "noJurnal" => $noJurnal,
                "noReferrence" => $noReff,
                "tanggal" => date('Y-m-d'),
                "kodeAkun" => '4105',
                "kredit" => $dataObat,
                "keterangan" => $keterangan,
                "posisi" => 'K',
                "slug" => ''
            );
            
            $this->db->insert("jurnal",$dataKredit);
        }

        if($dataLab > 0){
            $dataKredit = array(
                "noJurnal" => $noJurnal,
                "noReferrence" => $noReff,
                "tanggal" => date('Y-m-d'),
                "kodeAkun" => '4103',
                "kredit" => $dataLab,
                "keterangan" => $keterangan,
                "posisi" => 'K',
                "slug" => ''
            );
            
            $this->db->insert("jurnal",$dataKredit);
        }
        
        if($dataRadiologi > 0){
            $dataKredit = array(
                "noJurnal" => $noJurnal,
                "noReferrence" => $noReff,
                "tanggal" => date('Y-m-d'),
                "kodeAkun" => '4104',
                "kredit" => $dataRadiologi,
                "keterangan" => $keterangan,
                "posisi" => 'K',
                "slug" => ''
            );
            
            $this->db->insert("jurnal",$dataKredit);
        }
    }

    function insertJurnalPenjualanBatal($noReff,$akunKredit,$keterangan,$value,$dataTindakan,$dataObat,$dataLab,$dataRadiologi){
        $urutanNoJurnal = $this->noJurnal();
        $noJurnal = "JURN".date('y').date('m').date('d').sprintf('%04d',$urutanNoJurnal+1);

        $dataKreditK = array(
            "noJurnal" => $noJurnal,
            "noReferrence" => $noReff,
            "tanggal" => date('Y-m-d'),
            "kodeAkun" => $akunKredit,
            "kredit" => $value,
            "keterangan" => $keterangan,
            "posisi" => 'K',
            "slug" => ''
        );
        

        if($dataTindakan > 0){
            $dataKredit = array(
                "noJurnal" => $noJurnal,
                "noReferrence" => $noReff,
                "tanggal" => date('Y-m-d'),
                "kodeAkun" => '4102',
                "debit" => $dataTindakan,
                "keterangan" => $keterangan,
                "posisi" => 'D',
                "slug" => ''
            );
            
            $this->db->insert("jurnal",$dataKredit);
        }

        if($dataObat > 0){
            $dataKredit = array(
                "noJurnal" => $noJurnal,
                "noReferrence" => $noReff,
                "tanggal" => date('Y-m-d'),
                "kodeAkun" => '4105',
                "debit" => $dataObat,
                "keterangan" => $keterangan,
                "posisi" => 'D',
                "slug" => ''
            );
            
            $this->db->insert("jurnal",$dataKredit);
        }

        if($dataLab > 0){
            $dataKredit = array(
                "noJurnal" => $noJurnal,
                "noReferrence" => $noReff,
                "tanggal" => date('Y-m-d'),
                "kodeAkun" => '4103',
                "debit" => $dataLab,
                "keterangan" => $keterangan,
                "posisi" => 'D',
                "slug" => ''
            );
            
            $this->db->insert("jurnal",$dataKredit);
        }
        
        if($dataRadiologi > 0){
            $dataKredit = array(
                "noJurnal" => $noJurnal,
                "noReferrence" => $noReff,
                "tanggal" => date('Y-m-d'),
                "kodeAkun" => '4104',
                "debit" => $dataRadiologi,
                "keterangan" => $keterangan,
                "posisi" => 'D',
                "slug" => ''
            );
            
            $this->db->insert("jurnal",$dataKredit);
        }

        $this->db->insert("jurnal",$dataKreditK);
    }

    function noJurnal(){
        $today = date('Y-m-d');
        $this->db->from("jurnal");
        $this->db->group_by("noJurnal");
        $this->db->where("tanggal",$today);
        return $this->db->count_all_results();
    }
}