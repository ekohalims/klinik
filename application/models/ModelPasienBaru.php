<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class ModelPasienBaru extends CI_Model{
	function cekUrutanPasienPerhari(){
		$this->db->from("kl_pasien");
		return $this->db->count_all_results();
	}

	function simpanDataPasienSQL($dataArray){
		$this->db->insert("kl_pasien",$dataArray);
		return $this->db->affected_rows();
	}

	function dataPasienRow($idPasien){
		$this->db->select(array("kl_pasien.noPasien","kl_pasien.tempatLahir","kl_pasien.jenisKelamin","kl_pasien.noID","kl_pasien.namaLengkap","kl_pasien.tanggalLahir","CONCAT(kl_pasien.alamat,' ',ae_kabupaten.nama_kabupaten) as alamat"));
		$this->db->from("kl_pasien");
		$this->db->join("ae_kabupaten","ae_kabupaten.kabupaten_id = kl_pasien.kabupaten","left");
		$this->db->where("kl_pasien.noPasien",$idPasien);
		return $this->db->get()->row();
	}

	function dataPasienRowJSON($idPasien,$searchBy){
		$this->db->select(array("kl_pasien.noPasien","kl_pasien.tempatLahir","kl_pasien.jenisKelamin","kl_pasien.noID","kl_pasien.namaLengkap","kl_pasien.tanggalLahir","CONCAT(kl_pasien.alamat,' ',ae_kabupaten.nama_kabupaten) as alamat"));
		$this->db->from("kl_pasien");
		$this->db->join("ae_kabupaten","ae_kabupaten.kabupaten_id = kl_pasien.kabupaten","left");
		$this->db->where("kl_pasien.".$searchBy,$idPasien);
		return $this->db->get()->row();
	}

	function dataPasienRowJSONLangsung($idPasien){
		$this->db->select(array("kl_pasien.noPasien","kl_pasien.tempatLahir","kl_pasien.jenisKelamin","kl_pasien.noID","kl_pasien.namaLengkap","kl_pasien.tanggalLahir","CONCAT(kl_pasien.alamat,' ',ae_kabupaten.nama_kabupaten) as alamat"));
		$this->db->from("kl_pasien");
		$this->db->join("ae_kabupaten","ae_kabupaten.kabupaten_id = kl_pasien.kabupaten","left");
		$this->db->where("kl_pasien.noPasien",$idPasien);
		return $this->db->get()->row();
	}

	function daftarPoliAktif(){
		$this->db->select("*");
		$this->db->from("kl_poliklinik");
		$this->db->where("isDelete",1);
		$this->db->where("status",1);
		$this->db->order_by("id_poliklinik","DESC");
		return $this->db->get()->result();
	}

	function cekNonPendaftaranPoli($idPoliklinik,$idDokter){
		$today = date('Y-m-d');

		$this->db->from("kl_daftar");
		$this->db->where("idPoliklinik",$idPoliklinik);
		$this->db->where("idDokter",$idDokter);
		$this->db->where("DATE(tanggalDaftar)",$today);
		$this->db->where("asalDaftar","RAJAL");
		return $this->db->count_all_results();
	}

	function simpanPendaftaran($dataPendaftaran){
		$this->db->insert("kl_daftar",$dataPendaftaran);
	}

	function cekPasienRegistered($idPasien){
		$this->db->from("kl_daftar");
		$this->db->where("idPasien",$idPasien);
		$this->db->where("status",0);
		return $this->db->count_all_results();
	}

	function dataPendaftaranRow($noPendaftaran){
		$today = date('Y-m-d');

		$this->db->select(array("kl_pasien.noPasien","kl_pasien.namaLengkap","kl_poliklinik.poliklinik","kl_dokter.nama as namaDokter","kl_daftar.tanggalDaftar","kl_daftar.noPendaftaran"));
		$this->db->from("kl_daftar");
		$this->db->join("kl_dokter","kl_dokter.id_dokter = kl_daftar.idDokter");
		$this->db->join("kl_poliklinik","kl_poliklinik.id_poliklinik = kl_daftar.idPoliklinik");
		$this->db->join("kl_pasien","kl_pasien.noPasien = kl_daftar.idPasien");
		$this->db->where("kl_daftar.noPendaftaran",$noPendaftaran);
		return $this->db->get()->row();
	}

	function cariPasienByID($noPasien,$searchBy){
		$this->db->from("kl_pasien");
		$this->db->where($searchBy,$noPasien);
		return $this->db->count_all_results();
	}
}