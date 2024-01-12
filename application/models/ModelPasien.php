<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class ModelPasien extends CI_Model{
	
	function totalPasien(){
		$this->db->from("kl_pasien");
		return $this->db->count_all_results();
	}

	function viewPasienDatatables($limit,$start,$search){
		$this->db->select(array("kl_pasien.noPasien","kl_pasien.namaLengkap","kl_pasien.jenisKelamin","kl_pasien.tanggalLahir","kl_pasien.noHP","CONCAT(kl_pasien.alamat,' ',ae_kabupaten.nama_kabupaten) as alamat"));
		$this->db->from("kl_pasien");
		$this->db->join("ae_kabupaten","ae_kabupaten.kabupaten_id = kl_pasien.kabupaten","left");

		if(!empty($search)){
			$this->db->like("kl_pasien.noPasien",$search);
			$this->db->or_like("kl_pasien.namaLengkap",$search);
			$this->db->or_like("kl_pasien.tanggalLahir",$search);
			$this->db->or_like("kl_pasien.noHP",$search);
		}

		$this->db->limit($limit,$start);

		return $this->db->get();
	}

	function updatePasienSQL($dataArray,$idPasien){
		$this->db->where("noPasien",$idPasien);
		$this->db->update("kl_pasien",$dataArray);
	}

	function selfID($id){
		$this->db->select("noID");
		$this->db->from("kl_pasien");
		$this->db->where("noPasien",$id);
		$query = $this->db->get()->row();
		return $query->noID;
	}
}
