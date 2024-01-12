<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class ModelOrderLaboratorium extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	function countOrder($status){
		$this->db->from("kl_orderlabheader");
		$this->db->where("kl_orderlabheader.status",$status);
		return $this->db->count_all_results();
	}

	function cariOrder($query,$cariBerdasarkan){
		$this->db->select(array("kl_orderlabheader.noPendaftaran","kl_pasien.noPasien","kl_pasien.noID","kl_pasien.namaLengkap","kl_pasien.alamat","kl_pasien.noHP","kl_orderlabheader.tanggal","kl_dokter.nama as namaDokter","kl_poliklinik.poliklinik","kl_orderlabheader.status"));
		$this->db->from("kl_orderlabheader");
		$this->db->join("kl_daftar","kl_daftar.noPendaftaran = kl_orderlabheader.noPendaftaran");
		$this->db->join("kl_pasien","kl_pasien.noPasien = kl_daftar.idPasien");
		$this->db->join("kl_dokter","kl_dokter.id_dokter = kl_daftar.idDokter");
		$this->db->join("kl_poliklinik","kl_poliklinik.id_poliklinik = kl_daftar.idPoliklinik");
		$this->db->like($cariBerdasarkan,$query);	
		return $this->db->get()->result();
	}

	function dataOrder($noPendaftaran){
		$this->db->select(array("kl_tariflab.namaTarif as namaLab","kl_orderlab.catatan","kl_orderlab.catatan","kl_orderlab.status","kl_orderlab.idLab","kl_orderlab.tanggal","users.first_name","users.last_name","kl_orderlab.hasil","kl_tariflab.nmin","kl_tariflab.nmax","kl_tariflab.satuan"));
		$this->db->from("kl_orderlab");
		$this->db->join("kl_tariflab","kl_tariflab.kode = kl_orderlab.idLab");
		$this->db->join("users","users.id = kl_orderlab.idUser","left");
		$this->db->where("kl_orderlab.noPermintaan",$noPendaftaran);
		$this->db->group_by("kl_orderlab.idLab");
		return $this->db->get()->result();
	}

	function dataOrderRow($noPendaftaran){
		$this->db->select(array("kl_orderlabheader.status","kl_orderlabheader.noPendaftaran","kl_daftar.tanggalDaftar","kl_pasien.noPasien","kl_pasien.noID","kl_pasien.namaLengkap as namaPasien","kl_pasien.alamat","kl_pasien.noHP","kl_orderlabheader.tanggal","kl_dokter.nama as namaDokter","kl_poliklinik.poliklinik","kl_orderlabheader.status","kl_pasien.jenisKelamin","kl_pasien.tanggalLahir","kl_orderlabheader.idDokter as idDokterPemeriksa","kl_daftar.status as statusPembayaran"));
		$this->db->from("kl_orderlabheader");
		$this->db->join("kl_daftar","kl_daftar.noPendaftaran = kl_orderlabheader.noPendaftaran","left");
		$this->db->join("kl_pasien","kl_pasien.noPasien = kl_daftar.idPasien","left");
		$this->db->join("kl_dokter","kl_dokter.id_dokter = kl_daftar.idDokter","left");
		$this->db->join("kl_poliklinik","kl_poliklinik.id_poliklinik = kl_daftar.idPoliklinik","left");
		$this->db->where("kl_orderlabheader.noPermintaan",$noPendaftaran);	
		return $this->db->get()->row();
	}

	function updateStatusOrder($noPendaftaran,$status){
		$dataUpdate = array(
			"status" => $status
		);

		$this->db->where("noPermintaan",$noPendaftaran);
		$this->db->update("kl_orderlabheader",$dataUpdate);
	}

	function updateHasilLab($id,$hasil,$noPendaftaran){
		$dataArray = array(
			"hasil" => $hasil
		);

		$this->db->where("noPendaftaran",$noPendaftaran);
		$this->db->where("idLab",$id);
		$this->db->update("kl_orderlab",$dataArray);
	}
	
	function viewOrderServerSide($limit,$start,$search,$status){
		$this->db->select(array("kl_orderlabheader.noPermintaan","kl_orderlabheader.noPendaftaran","kl_daftar.idPasien","kl_orderlabheader.tanggal","kl_pasien.namaLengkap as namaPasien","kl_pasien.tanggalLahir","kl_dokter.nama as namaDokter","kl_poliklinik.poliklinik"));
		$this->db->from("kl_orderlabheader");
		$this->db->join("kl_daftar","kl_daftar.noPendaftaran = kl_orderlabheader.noPendaftaran");
		$this->db->join("kl_pasien","kl_pasien.noPasien = kl_daftar.idPasien");
		$this->db->join("kl_dokter","kl_dokter.id_dokter = kl_daftar.idDokter","left");
		$this->db->join("kl_poliklinik","kl_poliklinik.id_poliklinik = kl_daftar.idPoliklinik","left");
		$this->db->where("kl_orderlabheader.status",$status);

		if(!empty($search)){
			$this->db->like("kl_orderlabheader.noPendaftaran",$search);
		}

		$this->db->limit($limit,$start);

		$this->db->group_by(array("kl_orderlabheader.noPermintaan","kl_orderlabheader.noPendaftaran","kl_daftar.idPasien","kl_orderlabheader.tanggal","kl_pasien.namaLengkap","kl_pasien.tanggalLahir","kl_dokter.nama","kl_poliklinik.poliklinik"));
		$this->db->order_by("kl_orderlabheader.tanggal","ASC");
		return $this->db->get();
	}

	function totalOrderDatatable(){
		$this->db->from("kl_orderlabheader");
		$this->db->where("status",2);
		return $this->db->count_all_results();
	}

	function hasilLab($noPendaftaran,$idLab){
		$this->db->select(array("kl_labitem.namaLab","kl_orderlab.hasil"));
		$this->db->from("kl_orderlab");
		$this->db->join("kl_labitem","kl_labitem.id = kl_orderlab.idLab");
		$this->db->where("kl_orderlab.noPendaftaran",$noPendaftaran);
		$this->db->where("kl_orderlab.idLab",$idLab);
		return $this->db->get()->result();
	}

	function updateDokterPemeriksa($dataUpdate,$noPendaftaran){
		$this->db->where("noPermintaan",$noPendaftaran);
		$this->db->update("kl_orderlabheader",$dataUpdate);
	}
}