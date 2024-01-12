<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class ModelAntrianFarmasi extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->load->database();
    }

    function countOrderResep($status){
        $this->db->from("kl_resepheader");
        $this->db->where("status",$status);
        return $this->db->count_all_results();
    }

    function cariOrder($query,$cariBerdasarkan){
		$this->db->select(array("kl_resepheader.noPendaftaran","kl_pasien.noPasien","kl_pasien.noID","kl_pasien.namaLengkap","kl_pasien.alamat","kl_pasien.noHP","kl_resepheader.tanggal","kl_dokter.nama as namaDokter","kl_poliklinik.poliklinik","kl_resepheader.status"));
		$this->db->from("kl_resepheader");
		$this->db->join("kl_daftar","kl_daftar.noPendaftaran = kl_resepheader.noPendaftaran");
		$this->db->join("kl_pasien","kl_pasien.noPasien = kl_daftar.idPasien");
		$this->db->join("kl_dokter","kl_dokter.id_dokter = kl_daftar.idDokter");
		$this->db->join("kl_poliklinik","kl_poliklinik.id_poliklinik = kl_daftar.idPoliklinik");
		$this->db->like($cariBerdasarkan,$query);	
		return $this->db->get()->result();
    }
    
    function daftarObatPesanan($noPendaftaran){
		$this->db->select(array("ap_produk.id_produk","ap_produk.nama_produk","kl_resep.jumlah","ap_produk.satuan","kl_resep.aturan","ap_produk.hpp","kl_resep.expiredDate","kl_resep.noBatch"));
		$this->db->from("kl_resep");
		$this->db->join("ap_produk","ap_produk.id_produk = kl_resep.idObat");
		$this->db->where("kl_resep.noPendaftaran",$noPendaftaran);
		return $this->db->get()->result();
	}

	function totalHPP($noPendaftaran){
		$this->db->select("SUM(kl_resep.jumlah*ap_produk.hpp) as totalHPP");
		$this->db->from("kl_resep");
		$this->db->join("ap_produk","ap_produk.id_produk = kl_resep.idObat");
		$this->db->where("kl_resep.noPendaftaran",$noPendaftaran);
		return $this->db->get()->row()->totalHPP;

	}
	
	function dataOrderRow($noPendaftaran){
		$this->db->select(array("kl_resepheader.noPendaftaran","kl_pasien.noPasien","kl_pasien.noID","kl_pasien.namaLengkap","kl_pasien.alamat","kl_pasien.noHP","kl_resepheader.tanggal","kl_dokter.nama as namaDokter","kl_poliklinik.poliklinik","kl_resepheader.status","kl_pasien.jenisKelamin","kl_pasien.tanggalLahir","kl_daftar.status as statusPembayaran"));
		$this->db->from("kl_resepheader");
		$this->db->join("kl_daftar","kl_daftar.noPendaftaran = kl_resepheader.noPendaftaran");
		$this->db->join("kl_pasien","kl_pasien.noPasien = kl_daftar.idPasien");
		$this->db->join("kl_dokter","kl_dokter.id_dokter = kl_daftar.idDokter");
		$this->db->join("kl_poliklinik","kl_poliklinik.id_poliklinik = kl_daftar.idPoliklinik");
		$this->db->where("kl_resepheader.noPendaftaran",$noPendaftaran);	
		return $this->db->get()->row();
	}

	function hapusPesanan($idProduk,$noPendaftaran){
		$this->db->delete("kl_resep",array("idObat" => $idProduk,"noPendaftaran" => $noPendaftaran));
	}

	function updateStatusOrder($noPendaftaran,$status){
		$dataUpdate = array(
			"status" => $status
		);

		$this->db->where("noPendaftaran",$noPendaftaran);
		$this->db->update("kl_resepheader",$dataUpdate);
	}

	function currentStokGudang($idProduk){
		$this->db->select("stok");
		$this->db->from("ap_produk");
		$this->db->where("id_produk",$idProduk);
		$query = $this->db->get()->row();
		return $query->stok;
	}

	function currentStokToko($idProduk,$idStore){
		$this->db->select("stok");
		$this->db->from("stok_store");
		$this->db->where("id_produk",$idProduk);
		$this->db->where("id_store",$idStore);
		$query = $this->db->get()->row();
		return $query->stok;
	}

	function updateStokToko($dataUpdate,$idProduk,$idStore){
		$this->db->where("id_produk",$idProduk);
		$this->db->where("id_store",$idStore);
		$this->db->update("stok_store",$dataUpdate);
	}

	function viewOrder($status){
		$this->db->select(array("kl_resepheader.noPendaftaran","kl_daftar.idPasien","kl_resepheader.tanggal","kl_pasien.namaLengkap as namaPasien","kl_pasien.tanggalLahir","kl_dokter.nama as namaDokter","kl_poliklinik.poliklinik"));
		$this->db->from("kl_resepheader");
		$this->db->join("kl_daftar","kl_daftar.noPendaftaran = kl_resepheader.noPendaftaran");
		$this->db->join("kl_pasien","kl_pasien.noPasien = kl_daftar.idPasien");
		$this->db->join("kl_dokter","kl_dokter.id_dokter = kl_daftar.idDokter");
		$this->db->join("kl_poliklinik","kl_poliklinik.id_poliklinik = kl_daftar.idPoliklinik");
		$this->db->where("kl_resepheader.status",$status);
		$this->db->group_by(array("kl_resepheader.noPendaftaran","kl_daftar.idPasien","kl_resepheader.tanggal","kl_pasien.namaLengkap","kl_pasien.tanggalLahir","kl_dokter.nama","kl_poliklinik.poliklinik"));
		$this->db->order_by("kl_resepheader.tanggal","ASC");
		return $this->db->get()->result();
	}

	function totalOrderDatatable(){
		$this->db->from("kl_resepheader");
		$this->db->where("status",2);
		return $this->db->count_all_results();	
	}

	function viewOrderServerSide($limit,$start,$search){
		$this->db->select(array("kl_resepheader.noPendaftaran","kl_daftar.idPasien","kl_resepheader.tanggal","kl_pasien.namaLengkap as namaPasien","kl_pasien.tanggalLahir","kl_dokter.nama as namaDokter","kl_poliklinik.poliklinik"));
		$this->db->from("kl_resepheader");
		$this->db->join("kl_daftar","kl_daftar.noPendaftaran = kl_resepheader.noPendaftaran");
		$this->db->join("kl_pasien","kl_pasien.noPasien = kl_daftar.idPasien");
		$this->db->join("kl_dokter","kl_dokter.id_dokter = kl_daftar.idDokter");
		$this->db->join("kl_poliklinik","kl_poliklinik.id_poliklinik = kl_daftar.idPoliklinik");
		$this->db->where("kl_resepheader.status",2);

		if(!empty($search)){
			$this->db->like("kl_resepheader.noPendaftaran",$search);
		}

		$this->db->limit($limit,$start);
		$this->db->group_by(array("kl_resepheader.noPendaftaran","kl_daftar.idPasien","kl_resepheader.tanggal","kl_pasien.namaLengkap","kl_pasien.tanggalLahir","kl_dokter.nama","kl_poliklinik.poliklinik"));
		$this->db->order_by("kl_resepheader.tanggal","ASC");
		return $this->db->get();
	}

	function expiredDatePerproduk($idProduk){
		$this->db->select("*");
		$this->db->from("ap_produk_exp");
		$this->db->where("id_produk",$idProduk);
		return $this->db->get()->result();
	}
	
	function updateExpiredDate($dataUpdate,$idProduk,$noPendaftaran){
		$this->db->where("noPendaftaran",$noPendaftaran);
		$this->db->where("idObat",$idProduk);
		$this->db->update("kl_resep",$dataUpdate);
	}

	function stokObatPertanggalExpired($idProduk,$tanggalExpired){
		$this->db->select("stok");
		$this->db->from("ap_produk_exp");
		$this->db->where("id_produk",$idProduk);
		$this->db->where("expiredDate",$tanggalExpired);
		return $this->db->get()->row()->stok;
	}

	function kurangiStokExp($dataUpdateExpItem,$idProduk,$expiredDate){
		$this->db->where("id_produk",$idProduk);
		$this->db->where("expiredDate",$expiredDate);
		$this->db->update("ap_produk_exp",$dataUpdateExpItem);
	}

	function cekResepExist($idProduk,$noPendaftaran){
		$this->db->from("kl_resep");
		$this->db->where("noPendaftaran",$noPendaftaran);
		$this->db->where("idObat",$idProduk);
		return $this->db->count_all_results();
	}

	function currentQtyResep($idProduk,$noPendaftaran){
		$this->db->select("jumlah");
		$this->db->from("kl_resep");
		$this->db->where("noPendaftaran",$noPendaftaran);
		$this->db->where("idObat",$idProduk);
		$query = $this->db->get()->row()->jumlah;
		return $query;
	}

	function updateQtyResep($dataUpdate,$idProduk,$noPendaftaran){
		$this->db->where("noPendaftaran",$noPendaftaran);
		$this->db->where("idObat",$idProduk);
		$this->db->update("kl_resep",$dataUpdate);
	}

	function hargaObatPerstore($idProduk,$idToko){
		$this->db->select("harga");
		$this->db->from("ap_produk_price");
		$this->db->where("id_produk",$idProduk);
		$this->db->where("id_toko",$idToko);
		$query = $this->db->get()->row();
		return $query->harga;
	}

	function getProdukExpiredFirst($idProduk){
		$this->db->select("ap_produk_exp.expiredDate");
		$this->db->from("ap_produk_exp");
		$this->db->where("id_produk",$idProduk);
		$this->db->where("stok > 0");
		$this->db->order_by("expiredDate","ASC");
		$this->db->limit(1,0);
		$query = $this->db->get()->result();
		foreach($query as $row){
			return $row->expiredDate;
		}
	}

	function insertResep($dataInsert){
		$this->db->insert("kl_resep",$dataInsert);
	}

	function numRowsJumlahProduk($search,$idKategori){
		$this->db->from("ap_produk");

		if(!empty($idKategori)){
			$this->db->where("ap_produk.id_kategori",$idKategori);
		}

		if(!empty($search)){
			$this->db->like("ap_produk.id_produk",$search);
			$this->db->or_like("ap_produk.nama_produk",$search);
		}
		return $this->db->count_all_results();
	}

	function viewItemObat($search,$limitOnNextPage,$idKategori,$perPage){
		$this->db->select(array("ap_produk.id_produk","ap_produk.nama_produk","ap_produk.satuan","ap_kategori.kategori"));
		$this->db->from("ap_produk");
		$this->db->join("ap_kategori","ap_kategori.id_kategori = ap_produk.id_kategori","left");
		
		if(!empty($idKategori)){
			$this->db->where("ap_produk.id_kategori",$idKategori);
		}
		
		if(!empty($search)){
			$this->db->like("ap_produk.id_produk",$search);
			$this->db->or_like("ap_produk.nama_produk",$search);
		}

		$this->db->limit($perPage,$limitOnNextPage);
		return $this->db->get();
	}

	function kategoriSort(){
		$this->db->select("*");
		$this->db->from("ap_kategori");
		$this->db->order_by("kategori","ASC");
		return $this->db->get()->result();
	}
}