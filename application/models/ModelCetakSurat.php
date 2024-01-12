<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class ModelCetakSurat extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->load->database();
    }

    function dataPemeriksaan($idPasien){
        $this->db->select(array("kl_daftar.noPendaftaran","kl_daftar.tanggalDaftar","kl_dokter.nama"));
        $this->db->from("kl_daftar");
        $this->db->join("kl_dokter","kl_dokter.id_dokter = kl_daftar.idDokter");
        $this->db->where("kl_daftar.idPasien",$idPasien);
        $this->db->where("kl_daftar.status",2);
        $this->db->group_by("kl_daftar.noPendaftaran");
        $this->db->order_by("kl_daftar.tanggalDaftar","DESC");
        return $this->db->get();
    }

    function dataPemeriksaanRujuk($idPasien){
        $this->db->select(array("kl_daftar.noPendaftaran","kl_daftar.tanggalDaftar","kl_dokter.nama"));
        $this->db->from("kl_daftar");
        $this->db->join("kl_dokter","kl_dokter.id_dokter = kl_daftar.idDokter");
        $this->db->join("kl_tindaklanjutpasien","kl_tindaklanjutpasien.noPendaftaran = kl_daftar.noPendaftaran");
        $this->db->where("kl_daftar.idPasien",$idPasien);
        $this->db->where("kl_daftar.status",2);
        $this->db->where("kl_tindaklanjutpasien.idTindakLanjut",4);
        $this->db->group_by("kl_daftar.noPendaftaran");
        $this->db->order_by("kl_daftar.tanggalDaftar","DESC");
        return $this->db->get();
    }

    function namaKecamatan(){
        $this->db->select("ae_kecamatan.kecamatan");
        $this->db->from("kl_klinikinfo");
        $this->db->join("ae_kecamatan","ae_kecamatan.id_kecamatan = kl_klinikinfo.kecamatan");
        $this->db->where("kl_klinikinfo.id",1);
        return $this->db->get()->row()->kecamatan;
    }

    function diagnosaPenyakit($noPendaftaran){
        $this->db->select(array("kl_icd.CODE","kl_icd.STR"));
        $this->db->from("kl_diagnosa");
        $this->db->join("kl_icd","kl_icd.id = kl_diagnosa.idDiagnosa");
        $this->db->where("noPendaftaran",$noPendaftaran);
        return $this->db->get();
    }

    function tampilkanCartResep($noPendaftaran){
		$this->db->select(array("ap_produk.id_produk","ap_produk.nama_produk","ap_kategori.kategori","kl_resep.aturan","kl_resep.jumlah","ap_produk.satuan"));
		$this->db->from("kl_resep");
		$this->db->join("ap_produk","ap_produk.id_produk = kl_resep.idObat");
		$this->db->join("ap_kategori","ap_kategori.id_kategori = ap_produk.id_kategori");
		$this->db->where("kl_resep.noPendaftaran",$noPendaftaran);
		return $this->db->get();
	}
}