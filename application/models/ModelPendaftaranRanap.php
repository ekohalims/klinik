<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class ModelPendaftaranRanap extends CI_Model{
	function daftarGroupRuang($id){
        $this->db->select(array(
            "kl_ruanggroup.namaGroup",
            "kl_ruanggroup.kodeGroup",
            "kl_kelasruang.kelasruang",
            "kl_ruanggroup.tarif",
            "kl_ruanggroup.kapasitas",
            "COUNT(kl_ruangan.namaRuang) as jumlahRuang"
        ));
        $this->db->from("kl_ruanggroup");
        $this->db->join("kl_kelasruang","kl_kelasruang.idKelas = kl_ruanggroup.idKelas");
        $this->db->join("kl_ruangan","kl_ruangan.kodeGroup = kl_ruanggroup.kodeGroup");
        $this->db->where("kl_ruanggroup.idKategori",$id);
        $this->db->group_by("kl_ruanggroup.kodeGroup");
        $this->db->order_by("kl_kelasruang.kelasruang","ASC");
        $this->db->order_by("kl_ruanggroup.namaGroup","ASC");
        return $this->db->get()->result();
    }

    function viewRuanganPergroup($idGroup){
        $this->db->select(array("kl_ruangan.kodeRuang","kl_ruangan.namaRuang"));
        $this->db->from("kl_ruangan");
        $this->db->where("kodeGroup",$idGroup);
        $this->db->order_by("kodeRuang","ASC");
        return $this->db->get()->result();
    }

    function ruanganTerpakai($idRuangan){
        $this->db->from("kl_ranaptopasien");
        $this->db->where("kodeRuang",$idRuangan);
        $this->db->where("status",0);
        return $this->db->count_all_results();
    }

    function kapasitasPerruangan($idRuangan){
        $kodeGroup = $this->db->get_where("kl_ruangan",array("kodeRuang" => $idRuangan))->row()->kodeGroup; 
        $kapasitas = $this->db->get_where("kl_ruanggroup",array("kodeGroup" => $kodeGroup))->row()->kapasitas;

        return $kapasitas;
    }

    function ruanganTersedia($kodeRuang){
        $kapasitas = $this->kapasitasPerruangan($kodeRuang);
        $ruanganTerpakai = $this->ruanganTerpakai($kodeRuang);

        return $kapasitas-$ruanganTerpakai;
    }

    function ruanganTerpakaiPergroup($kodeGroup){
        $this->db->from("kl_ranaptopasien");
        $this->db->join("kl_ruangan","kl_ruangan.kodeRuang = kl_ranaptopasien.kodeRuang");
        $this->db->where("kl_ruangan.kodeGroup",$kodeGroup);
        $this->db->where("kl_ranaptopasien.status",0);
        return $this->db->count_all_results();
    }

    function cekPendaftaranRanap($today){
        $this->db->from("kl_daftar");
        $this->db->where("DATE(tanggalDaftar)",$today);
        $this->db->where("asalDaftar","RANAP");
        return $this->db->count_all_results();
    }

    function dataPendaftaranRow($noPendaftaran){
		$today = date('Y-m-d');

		$this->db->select(array("kl_ruangan.namaRuang","kl_pasien.noPasien","kl_pasien.namaLengkap","kl_dokter.nama as namaDokter","kl_daftar.tanggalDaftar","kl_daftar.noPendaftaran",""));
        $this->db->from("kl_daftar");
        $this->db->join("kl_ranaptopasien","kl_ranaptopasien.noPendaftaran = kl_daftar.noPendaftaran");
        $this->db->join("kl_ruangan","kl_ruangan.kodeRuang = kl_ranaptopasien.kodeRuang");
		$this->db->join("kl_dokter","kl_dokter.id_dokter = kl_daftar.idDokter");
		$this->db->join("kl_pasien","kl_pasien.noPasien = kl_daftar.idPasien");
		$this->db->where("kl_daftar.noPendaftaran",$noPendaftaran);
		return $this->db->get()->row();
    }
    
    function viewRegistPasienRanap($tanggal,$search){
		$this->db->select("*");
        $this->db->from("viewregistranap");
        
        if(empty($search)){
            $this->db->where("DATE(tanggalDaftar)",$tanggal);
        } else {
            $this->db->like("noPendaftaran",$search);
            $this->db->or_like("idPasien",$search);
            $this->db->or_like("namaLengkap",$search);
        }

		$this->db->order_by("tanggalDaftar","desc");
		return $this->db->get();
	}
}