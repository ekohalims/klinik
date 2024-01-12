<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class ModelDashboard extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->load->database();
    }   

    function dataDiagnosaPasien($type,$tanggal,$bulan,$tahun){
        $this->db->select(array("COUNT(kl_diagnosa.idDiagnosa) as jumlah","kl_icd.CODE","kl_icd.STR"));
        $this->db->from("kl_diagnosa");
        $this->db->join("kl_icd","kl_icd.id = kl_diagnosa.idDiagnosa");
        $this->db->join("kl_daftar","kl_daftar.noPendaftaran = kl_diagnosa.noPendaftaran");
        
        if($type=='day'){
            $this->db->where("DATE(kl_daftar.tanggalDaftar)",$tanggal);
        } elseif($type=='month'){
            $this->db->where("MONTH(kl_daftar.tanggalDaftar)",$bulan);
            $this->db->where("YEAR(kl_daftar.tanggalDaftar)",$tahun);
        } elseif($type=='year'){
            $this->db->where("YEAR(kl_daftar.tanggalDaftar)",$tahun);
        } else {
            $month = date('m');
            $year = date('Y');

            $this->db->where("MONTH(kl_daftar.tanggalDaftar)",$month);
            $this->db->where("YEAR(kl_daftar.tanggalDaftar)",$year);
        }

        $this->db->where("kl_daftar.status != 3");

        $this->db->group_by("kl_icd.id");
        return $this->db->get();
    }

    function jumlahPasien($type,$tanggal,$bulan,$tahun){
        $this->db->select("COUNT(kl_daftar.idPasien) as jumlahPasien");
        $this->db->from("kl_daftar");

        if($type=='day'){
            $this->db->where("DATE(kl_daftar.tanggalDaftar)",$tanggal);
        } elseif($type=='month'){
            $this->db->where("MONTH(kl_daftar.tanggalDaftar)",$bulan);
            $this->db->where("YEAR(kl_daftar.tanggalDaftar)",$tahun);
        } elseif($type=='year'){
            $this->db->where("YEAR(kl_daftar.tanggalDaftar)",$tahun);
        } else {
            $month = date('m');
            $year = date('Y');

            $this->db->where("MONTH(kl_daftar.tanggalDaftar)",$month);
            $this->db->where("YEAR(kl_daftar.tanggalDaftar)",$year);
        }

        $this->db->where("kl_daftar.status != 3");
        $query = $this->db->get()->row();
        return $query->jumlahPasien;
    }

    function menungguPembayaran($type,$tanggal,$bulan,$tahun){
        $this->db->select("COUNT(kl_daftar.idPasien) as jumlah");
        $this->db->from("kl_daftar");

        if($type=='day'){
            $this->db->where("DATE(kl_daftar.tanggalDaftar)",$tanggal);
        } elseif($type=='month'){
            $this->db->where("MONTH(kl_daftar.tanggalDaftar)",$bulan);
            $this->db->where("YEAR(kl_daftar.tanggalDaftar)",$tahun);
        } elseif($type=='year'){
            $this->db->where("YEAR(kl_daftar.tanggalDaftar)",$tahun);
        } else {
            $month = date('m');
            $year = date('Y');

            $this->db->where("MONTH(kl_daftar.tanggalDaftar)",$month);
            $this->db->where("YEAR(kl_daftar.tanggalDaftar)",$year);
        }

        $this->db->where("kl_daftar.status",1);
        $query = $this->db->get()->row();
        return $query->jumlah;
    }

    function permintaanLab($type,$tanggal,$bulan,$tahun){
        $this->db->select("COUNT(kl_orderlabheader.noPendaftaran) as jumlah");
        $this->db->from("kl_orderlabheader");

        if($type=='day'){
            $this->db->where("DATE(kl_orderlabheader.tanggal)",$tanggal);
        } elseif($type=='month'){
            $this->db->where("MONTH(kl_orderlabheader.tanggal)",$bulan);
            $this->db->where("YEAR(kl_orderlabheader.tanggal)",$tahun);
        } elseif($type=='year'){
            $this->db->where("YEAR(kl_orderlabheader.tanggal)",$tahun);
        } else {
            $month = date('m');
            $year = date('Y');

            $this->db->where("MONTH(kl_orderlabheader.tanggal)",$month);
            $this->db->where("YEAR(kl_orderlabheader.tanggal)",$year);
        }

        $this->db->where("kl_orderlabheader.status != 3");
        $query = $this->db->get()->row();
        return $query->jumlah;
    }

    function permintaanRad($type,$tanggal,$bulan,$tahun){
        $this->db->select("COUNT(kl_orderradiologiheader.noPendaftaran) as jumlah");
        $this->db->from("kl_orderradiologiheader");

        if($type=='day'){
            $this->db->where("DATE(kl_orderradiologiheader.tanggal)",$tanggal);
        } elseif($type=='month'){
            $this->db->where("MONTH(kl_orderradiologiheader.tanggal)",$bulan);
            $this->db->where("YEAR(kl_orderradiologiheader.tanggal)",$tahun);
        } elseif($type=='year'){
            $this->db->where("YEAR(kl_orderradiologiheader.tanggal)",$tahun);
        } else {
            $month = date('m');
            $year = date('Y');

            $this->db->where("MONTH(kl_orderradiologiheader.tanggal)",$month);
            $this->db->where("YEAR(kl_orderradiologiheader.tanggal)",$year);
        }

        $this->db->where("kl_orderradiologiheader.status != 3");
        $query = $this->db->get()->row();
        return $query->jumlah;
    }

    function dataUmur($type,$tanggal,$bulan,$tahun){
        $query = "SELECT ageGroup, COUNT(*) AS ageCount
                    FROM
                    (
                        SELECT
                            CASE WHEN TIMESTAMPDIFF(YEAR, tanggalLahir, CURDATE()) BETWEEN 0 AND 10
                                THEN '0-10'
                                WHEN TIMESTAMPDIFF(YEAR, tanggalLahir, CURDATE()) BETWEEN 10 AND 20
                                THEN '10-20'
                                WHEN TIMESTAMPDIFF(YEAR, tanggalLahir, CURDATE()) BETWEEN 20 AND 30
                                THEN '20-30'
                                WHEN TIMESTAMPDIFF(YEAR, tanggalLahir, CURDATE()) BETWEEN 30 AND 40
                                THEN '30-40'
                                WHEN TIMESTAMPDIFF(YEAR, tanggalLahir, CURDATE()) BETWEEN 40 AND 50
                                THEN '40-50'
                                WHEN TIMESTAMPDIFF(YEAR, tanggalLahir, CURDATE()) > 50
                                THEN '>50'
                                ELSE 'Other'
                            END AS ageGroup
                        FROM kl_pasien
                        JOIN kl_daftar ON kl_daftar.idPasien = kl_pasien.noPasien
                 ";

        if($type=='day'){
            $query .= "WHERE DATE(kl_daftar.tanggalDaftar)='$tanggal'";
        } elseif($type=='month'){
            $query .= "WHERE MONTH(kl_daftar.tanggalDaftar)='$bulan' AND YEAR(kl_daftar.tanggalDaftar)='$tahun'";
        } elseif($type=='year'){
            $query .= "WHERE YEAR(kl_daftar.tanggalDaftar)='$tahun'";
        } else {
            $month = date('m');
            $year = date('Y');
            $query .= "WHERE MONTH(kl_daftar.tanggalDaftar)=$month AND YEAR(kl_daftar.tanggalDaftar)='$year'";
        }

         $query .= " ) t GROUP BY ageGroup";

        return $this->db->query($query);
    }

    function pasienByGender($type,$tanggal,$bulan,$tahun){
        $this->db->select(array("kl_pasien.jenisKelamin","COUNT(kl_pasien.jenisKelamin) as jumlah"));
        $this->db->from("kl_pasien");
        $this->db->join("kl_daftar","kl_daftar.idPasien = kl_pasien.noPasien");

        if($type=='day'){
            $this->db->where("DATE(kl_daftar.tanggalDaftar)",$tanggal);
        } elseif($type=='month'){
            $this->db->where("MONTH(kl_daftar.tanggalDaftar)",$bulan);
            $this->db->where("YEAR(kl_daftar.tanggalDaftar)",$tahun);
        } elseif($type=='year'){
            $this->db->where("YEAR(kl_daftar.tanggalDaftar)",$tahun);
        } else {
            $month = date('m');
            $year = date('Y');

            $this->db->where("MONTH(kl_daftar.tanggalDaftar)",$month);
            $this->db->where("YEAR(kl_daftar.tanggalDaftar)",$year);
        }

        $this->db->group_by("kl_pasien.jenisKelamin");
        return $this->db->get();
    }

    function dataKunjunganPasien($type,$tanggal,$bulan,$tahun){
        //seleksi data berdasarkan jenisnya, hari / bulan / tahun
        if($type=='day'){
            $this->db->select(array("CONCAT(HOUR(kl_daftar.tanggalDaftar),':00-',HOUR(kl_daftar.tanggalDaftar)+1,':00') as tanggalDaftar","COUNT(kl_daftar.tanggalDaftar) as jumlah"));
            $this->db->from("kl_daftar");
            $this->db->where("DATE(kl_daftar.tanggalDaftar)",$tanggal);
            $this->db->group_by("HOUR(kl_daftar.tanggalDaftar)");
        } elseif($type=='month'){
            $this->db->select(array("DATE_FORMAT(kl_daftar.tanggalDaftar,'%d/%m/%y') as tanggalDaftar","COUNT(kl_daftar.tanggalDaftar) as jumlah"));
            $this->db->from("kl_daftar");
            $this->db->where("MONTH(kl_daftar.tanggalDaftar)",$bulan);
            $this->db->where("YEAR(kl_daftar.tanggalDaftar)",$tahun);
            $this->db->group_by("DAY(kl_daftar.tanggalDaftar)");
        } elseif($type=='year'){
            $this->db->select(array("DATE_FORMAT(kl_daftar.tanggalDaftar,'%M %Y') as tanggalDaftar","COUNT(kl_daftar.tanggalDaftar) as jumlah"));
            $this->db->from("kl_daftar");
            $this->db->where("YEAR(kl_daftar.tanggalDaftar)",$tahun);
            $this->db->group_by("MONTH(kl_daftar.tanggalDaftar)");
        } else {
            $month = date('m');
            $year = date('Y');

            $this->db->select(array("DATE_FORMAT(kl_daftar.tanggalDaftar,'%d/%m/%y') as tanggalDaftar","COUNT(kl_daftar.tanggalDaftar) as jumlah"));
            $this->db->from("kl_daftar");
            $this->db->where("MONTH(kl_daftar.tanggalDaftar)",$month);
            $this->db->where("YEAR(kl_daftar.tanggalDaftar)",$year);
            $this->db->group_by("DAY(kl_daftar.tanggalDaftar)");
        }

        
        return $this->db->get();
    }
}