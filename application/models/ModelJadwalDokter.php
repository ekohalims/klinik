<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class ModelJadwalDokter extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	function getDokterAktif(){
		$this->db->select(array("kl_dokter.nama","kl_poliklinik.poliklinik","kl_dokter.id_dokter"));
		$this->db->from("kl_dokter");
		$this->db->join("kl_poliklinik","kl_poliklinik.id_poliklinik = kl_dokter.idPoliklinik");
		$this->db->where("kl_dokter.status",1);
		$this->db->where("kl_dokter.isDelete",1);
		return $this->db->get()->result();
	}

	function getJadwal($idDokter,$idJadwal){
		$this->db->select("CONCAT(begin,' - ',end) as jadwal");
		$this->db->from("kl_jadwaldokter");
		$this->db->where("idDokter",$idDokter);
		$this->db->where("hari",$idJadwal);
		$query = $this->db->get()->result();

		foreach($query as $row){
			return $row->jadwal;
		}
	}

	function getJadwalBegin($idDokter,$idJadwal){
		$this->db->select("begin");
		$this->db->from("kl_jadwaldokter");
		$this->db->where("idDokter",$idDokter);
		$this->db->where("hari",$idJadwal);
		$query = $this->db->get()->result();

		foreach($query as $row){
			return $row->begin;
		}
	}

	function getJadwalEnd($idDokter,$idJadwal){
		$this->db->select("end");
		$this->db->from("kl_jadwaldokter");
		$this->db->where("idDokter",$idDokter);
		$this->db->where("hari",$idJadwal);
		$query = $this->db->get()->result();

		foreach($query as $row){
			return $row->end;
		}
	}

	function totalDokterAktif(){
		$this->db->from("kl_dokter");
		$this->db->where("status",1);
		$this->db->where("isDelete",1);
		return $this->db->count_all_results();
	}

	function viewDokterDatatables($limit,$start,$search){
		$this->db->select(array("kl_dokter.nama","kl_poliklinik.poliklinik","kl_dokter.id_dokter"));
		$this->db->from("kl_dokter");
		$this->db->join("kl_poliklinik","kl_poliklinik.id_poliklinik = kl_dokter.idPoliklinik");

		if(!empty($search)){
			$this->db->like("kl_dokter.nama",$search);
		}

		$this->db->where("kl_dokter.status",1);
		$this->db->where("kl_dokter.isDelete",1);
		$this->db->limit($limit,$start);
		return $this->db->get();
	}

	function getDataDokter($idDokter){
		$this->db->select(array("kl_dokter.nama","kl_poliklinik.poliklinik"));
		$this->db->from("kl_dokter");
		$this->db->join("kl_poliklinik","kl_poliklinik.id_poliklinik = kl_dokter.idPoliklinik");
		$this->db->where("kl_dokter.id_dokter",$idDokter);
		return $this->db->get()->row();
	}

	function cekIfJadwalExist($idDokter,$idJadwal){
		$this->db->from("kl_jadwaldokter");
		$this->db->where("idDokter",$idDokter);
		$this->db->where("hari",$idJadwal);
		return $this->db->count_all_results();
	}

	function insertJadwal($dataInsert){
		$this->db->insert("kl_jadwaldokter",$dataInsert);
	}

	function updateJadwal($dataUpdate,$idDokter,$idJadwalBegin){
		$this->db->where("idDokter",$idDokter);
		$this->db->where("hari",$idJadwalBegin);
		$this->db->update("kl_jadwaldokter",$dataUpdate);
	}
}