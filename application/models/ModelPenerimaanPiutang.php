<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class ModelPenerimaanPiutang extends CI_Model{
    function viewDataPiutang($tempo,$penanggung,$asuransi,$noRM,$status){
        $this->db->select(array("kl_piutang.noPendaftaran","kl_daftar.idPasien","kl_layanan.layanan","kl_asuransi.namaAsuransi","kl_pasien.namaLengkap as namaPasien","kl_daftar.tanggalDaftar","kl_piutang.jatuhTempo","kl_invoice.grandTotal"));
		$this->db->from("kl_piutang");
		$this->db->join("kl_daftar","kl_daftar.noPendaftaran = kl_piutang.noPendaftaran");
		$this->db->join("kl_layanan","kl_layanan.id_layanan = kl_daftar.idLayanan","left");
		$this->db->join("kl_asuransi","kl_asuransi.idAsuransi = kl_daftar.asuransi","left");
		$this->db->join("kl_pasien","kl_pasien.noPasien = kl_daftar.idPasien");
		$this->db->join("kl_invoice","kl_invoice.noPendaftaran = kl_piutang.noPendaftaran");

		if(!empty($status)){
			$this->db->where("kl_piutang.status",$status);
		} else {
			$this->db->where("kl_piutang.status != 2");
		}

		if(!empty($penanggung)){
			$this->db->where("kl_daftar.idLayanan",$penanggung);
		}

		if(!empty($asuransi)){
			$this->db->where("kl_daftar.asuransi",$asuransi);
		}

		if(!empty($noRM)){
			$this->db->where("kl_daftar.idPasien",$noRM);
		}

		if(!empty($tempo)){
			if($tempo==1){
				$this->db->where("kl_piutang.jatuhTempo > CURDATE()");
			} else {
				$this->db->where("kl_piutang.jatuhTempo < CURDATE()");
			}
		}

		$this->db->order_by("kl_piutang.jatuhTempo","asc");
		$this->db->group_by(array("kl_piutang.noPendaftaran","kl_daftar.idPasien","kl_layanan.layanan","kl_asuransi.namaAsuransi","kl_pasien.namaLengkap","kl_daftar.tanggalDaftar","kl_piutang.jatuhTempo","kl_invoice.grandTotal"));
		return $this->db->get();
    }
}