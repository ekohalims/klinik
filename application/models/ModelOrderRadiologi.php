<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class ModelOrderRadiologi extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	function countOrder($status){
		$this->db->from("kl_orderradiologiheader");
		$this->db->join("kl_daftar","kl_daftar.noPendaftaran = kl_orderradiologiheader.noPendaftaran");
		$this->db->where("kl_daftar.status > 0");
		$this->db->where("kl_orderradiologiheader.status",$status);
		return $this->db->count_all_results();
	}

	function cariOrder($query,$cariBerdasarkan){
		$this->db->select(array("kl_orderradiologiheader.noPendaftaran","kl_pasien.noPasien","kl_pasien.noID","kl_pasien.namaLengkap","kl_pasien.alamat","kl_pasien.noHP","kl_orderradiologiheader.tanggal","kl_dokter.nama as namaDokter","kl_poliklinik.poliklinik","kl_orderradiologiheader.status"));
		$this->db->from("kl_orderradiologiheader");
		$this->db->join("kl_daftar","kl_daftar.noPendaftaran = kl_orderradiologiheader.noPendaftaran");
		$this->db->join("kl_pasien","kl_pasien.noPasien = kl_daftar.idPasien");
		$this->db->join("kl_dokter","kl_dokter.id_dokter = kl_daftar.idDokter");
		$this->db->join("kl_poliklinik","kl_poliklinik.id_poliklinik = kl_daftar.idPoliklinik");
		$this->db->like($cariBerdasarkan,$query);	
		return $this->db->get()->result();
	}

	function dataOrder($noPendaftaran){
		$this->db->select(array("kl_tarifradiologi.namaTarif as namaRadiologi","kl_orderradiologi.catatan","kl_orderradiologi.status","kl_orderradiologi.idRadiologi","users.first_name","users.last_name","kl_orderradiologi.tanggal"));
		$this->db->from("kl_orderradiologi");
		$this->db->join("kl_tarifradiologi","kl_tarifradiologi.kode = kl_orderradiologi.idRadiologi");
		$this->db->join("users","users.id = kl_orderradiologi.idUser","left");
		$this->db->where("kl_orderradiologi.noPermintaan",$noPendaftaran);
		return $this->db->get()->result();
	}

	function dataOrderRow($noPendaftaran){
		$this->db->select(array("kl_orderradiologiheader.noPendaftaran","kl_daftar.tanggalDaftar","kl_pasien.noPasien","kl_pasien.noID","kl_pasien.namaLengkap as namaPasien","kl_pasien.alamat","kl_pasien.noHP","kl_orderradiologiheader.tanggal","kl_dokter.nama as namaDokter","kl_poliklinik.poliklinik","kl_orderradiologiheader.status","kl_pasien.jenisKelamin","kl_pasien.tanggalLahir","kl_orderradiologiheader.idDokter as idDokterPemeriksa"));
		$this->db->from("kl_orderradiologiheader");
		$this->db->join("kl_daftar","kl_daftar.noPendaftaran = kl_orderradiologiheader.noPendaftaran","left");
		$this->db->join("kl_pasien","kl_pasien.noPasien = kl_daftar.idPasien","left");
		$this->db->join("kl_dokter","kl_dokter.id_dokter = kl_daftar.idDokter","left");
		$this->db->join("kl_poliklinik","kl_poliklinik.id_poliklinik = kl_daftar.idPoliklinik","left");
		$this->db->where("kl_orderradiologiheader.noPermintaan",$noPendaftaran);	
		return $this->db->get()->row();
	}

	function updateStatusOrder($noPendaftaran,$status){
		$dataUpdate = array(
			"status" => $status
		);

		$this->db->where("noPermintaan",$noPendaftaran);
		$this->db->update("kl_orderradiologiheader",$dataUpdate);
	}

	function updateHasilLab($id,$hasil,$noPendaftaran){
		$dataArray = array(
			"hasil" => $hasil
		);

		$this->db->where("noPermintaan",$noPendaftaran);
		$this->db->where("idRadiologi",$id);
		$this->db->update("kl_orderradiologi",$dataArray);
	}

	function totalOrderDatatable(){
		$this->db->from("kl_orderradiologiheader");
		$this->db->where("status",2);
		return $this->db->count_all_results();
	}

	function viewOrderServerSide($limit,$start,$search,$status){
		$this->db->select(array("kl_orderradiologiheader.noPermintaan","kl_orderradiologiheader.noPendaftaran","kl_daftar.idPasien","kl_orderradiologiheader.tanggal","kl_pasien.namaLengkap as namaPasien","kl_pasien.tanggalLahir","kl_dokter.nama as namaDokter","kl_poliklinik.poliklinik"));
		$this->db->from("kl_orderradiologiheader");
		$this->db->join("kl_daftar","kl_daftar.noPendaftaran = kl_orderradiologiheader.noPendaftaran","left");
		$this->db->join("kl_pasien","kl_pasien.noPasien = kl_daftar.idPasien","left");
		$this->db->join("kl_dokter","kl_dokter.id_dokter = kl_daftar.idDokter","left");
		$this->db->join("kl_poliklinik","kl_poliklinik.id_poliklinik = kl_daftar.idPoliklinik","left");
		$this->db->where("kl_orderradiologiheader.status",$status);

		if(!empty($search)){
			$this->db->like("kl_orderradiologiheader.noPendaftaran",$search);
		}

		$this->db->limit($limit,$start);

		$this->db->group_by("kl_orderradiologiheader.noPermintaan");
		$this->db->group_by("kl_orderradiologiheader.noPendaftaran");
		$this->db->group_by("kl_daftar.idPasien");
		$this->db->group_by("kl_orderradiologiheader.tanggal");
		$this->db->group_by("kl_pasien.namaLengkap");
		$this->db->group_by("kl_pasien.tanggalLahir");
		$this->db->group_by("kl_dokter.nama");
		$this->db->group_by("kl_poliklinik.poliklinik");
		$this->db->order_by("kl_orderradiologiheader.tanggal","ASC");
		return $this->db->get();
	}

	function hasilRad($noPendaftaran,$idLab){
		$this->db->select(array("kl_tarifradiologi.namaTarif namaRadiologi","kl_orderradiologi.hasil"));
		$this->db->from("kl_orderradiologi");
		$this->db->join("kl_tarifradiologi","kl_tarifradiologi.kode = kl_orderradiologi.idRadiologi");
		$this->db->where("kl_orderradiologi.noPendaftaran",$noPendaftaran);
		$this->db->where("kl_orderradiologi.idRadiologi",$idLab);
		return $this->db->get()->result();
	}

	function updateDokterPemeriksa($dataUpdate,$noPendaftaran){
		$this->db->where("noPermintaan",$noPendaftaran);
		$this->db->update("kl_orderradiologiheader",$dataUpdate);
	}
}