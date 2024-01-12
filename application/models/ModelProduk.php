<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class ModelProduk extends CI_Model{
	function cekSKUIfExist($sku){
		$this->db->from("ap_produk");
		$this->db->where("id_produk",$sku);
		return $this->db->count_all_results();
	}

	function produkJoin($sku){
		$this->db->select(array("ap_produk.status","ap_produk.id_produk","ap_produk.nama_produk","ap_produk.hpp as harga_beli","ap_produk.satuan","ap_produk.tempat","ap_produk.id_kategori","ap_produk.id_subkategori","ap_produk.id_subkategori_2","ap_produk.image"));
		$this->db->from("ap_produk");
		$this->db->where("ap_produk.id_produk",$sku);
		return $this->db->get()->result();
	}

	function getPrice($idStore,$sku){
		$this->db->select("harga");
		$this->db->from("ap_produk_price");
		$this->db->where("id_toko",$idStore);
		$this->db->where("id_produk",$sku);
		$query = $this->db->get()->result();

		foreach($query as $row){
			return $row->harga;
		}
	}

	function countIfStoreExist($idStore,$id_produk){
		$this->db->from("ap_produk_price");
		$this->db->where("id_toko",$idStore);
		$this->db->where("id_produk",$id_produk);
		return $this->db->count_all_results();
	}


	function dataStokToko($length,$start,$search,$id){
		$query = "SELECT ap_produk.id_produk,ap_produk.nama_produk,stok_store.stok,ap_kategori.kategori,ap_kategori_1.kategori_level_1,ap_kategori_2.kategori_3,ap_produk.hpp as harga_beli, ap_stand.stand
				  FROM stok_store
				  LEFT JOIN ap_produk ON ap_produk.id_produk = stok_store.id_produk
				  LEFT JOIN ap_kategori ON ap_kategori.id_kategori = ap_produk.id_kategori
				  LEFT JOIN ap_kategori_1 ON ap_kategori_1.id = ap_produk.id_subkategori
				  LEFT JOIN ap_kategori_2 ON ap_kategori_2.id = ap_produk.id_subkategori_2
				  LEFT JOIN ap_stand ON ap_stand.id_stand = ap_produk.tempat
				  WHERE stok_store.id_store = '$id' AND (ap_produk.nama_produk LIKE '%$search%' OR ap_produk.id_produk LIKE '%$search%')
				  GROUP BY stok_store.id_produk
				  LIMIT $start,$length";
		return $this->db->query($query);
	}

	function dataStokTokoFull($length,$start,$id){
		$query = "SELECT ap_produk.id_produk,ap_produk.nama_produk,stok_store.stok,ap_kategori.kategori,ap_kategori_1.kategori_level_1,ap_kategori_2.kategori_3,ap_produk.hpp as harga_beli, ap_stand.stand
				  FROM stok_store
				  LEFT JOIN ap_produk ON ap_produk.id_produk = stok_store.id_produk
				  LEFT JOIN ap_kategori ON ap_kategori.id_kategori = ap_produk.id_kategori
				  LEFT JOIN ap_kategori_1 ON ap_kategori_1.id = ap_produk.id_subkategori
				  LEFT JOIN ap_kategori_2 ON ap_kategori_2.id = ap_produk.id_subkategori_2
				  LEFT JOIN ap_stand ON ap_stand.id_stand = ap_produk.tempat
				  WHERE stok_store.id_store = '$id'
				  GROUP BY stok_store.id_produk
				  LIMIT $start,$length";
		return $this->db->query($query);
	}

	function dataStokTokoFullExport($id){
		$query = "SELECT ap_produk.id_produk,ap_produk.nama_produk,stok_store.stok,ap_kategori.kategori,ap_kategori_1.kategori_level_1,ap_kategori_2.kategori_3,ap_produk.hpp as harga_beli, ap_stand.stand
				  FROM stok_store
				  LEFT JOIN ap_produk ON ap_produk.id_produk = stok_store.id_produk
				  LEFT JOIN ap_kategori ON ap_kategori.id_kategori = ap_produk.id_kategori
				  LEFT JOIN ap_kategori_1 ON ap_kategori_1.id = ap_produk.id_subkategori
				  LEFT JOIN ap_kategori_2 ON ap_kategori_2.id = ap_produk.id_subkategori_2
				  LEFT JOIN ap_stand ON ap_stand.id_stand = ap_produk.tempat
				  WHERE stok_store.id_store = '$id'
				  GROUP BY stok_store.id_produk";
		return $this->db->query($query);
	}

	function totalProdukPromotion($id){
		$this->db->from("stok_store");
		$this->db->where("stok_store.id_store",$id);
		return $this->db->count_all_results();
	}

	function hargaJual($idProduk,$idToko){
		$this->db->select("harga");
		$this->db->from("ap_produk_price");
		$this->db->where("id_produk",$idProduk);
		$this->db->where("id_toko",$idToko);
		$query = $this->db->get()->result();

		foreach($query as $row){
			return $row->harga;
		}
	}

	function data_stok_distributor($id_store,$stand,$kategori,$subKategori,$subKategori2){
		$this->db->select(array("ap_produk.id_produk","ap_produk.nama_produk","stok_store.stok","ap_kategori.kategori","ap_kategori_1.kategori_level_1","bahan_baku.harga"));
		$this->db->from("ap_produk");
		$this->db->join("stok_store","ap_produk.id_produk = stok_store.id_produk");
		$this->db->join("ap_kategori","ap_produk.id_kategori = ap_kategori.id_kategori","left");
		$this->db->join("ap_kategori_1","ap_produk.id_subkategori = ap_kategori_1.id","left");
		$this->db->join("bahan_baku","bahan_baku.sku = stok_store.id_produk","left");

		$this->db->where("stok_store.id_store",$id_store);

		if(!empty($stand)){
			$this->db->where("ap_produk.tempat",$stand);
		}

		if(!empty($kategori)){
			$this->db->where("ap_produk.id_kategori",$kategori);
		}

		if(!empty($subKategori)){
			$this->db->where("ap_produk.id_subkategori",$subKategori);
		}

		if(!empty($subKategori2)){
			$this->db->where("ap_produk.id_subkategori_2",$subKategori2);
		}

		$this->db->group_by("stok_store.id_produk");
		return $this->db->get();
	}

	function updateSoBatch($kode_toko,$data_stok){
		$this->db->where("id_store",$kode_toko);
		$this->db->update_batch("stok_store",$data_stok,'id_produk');
	}

	function hargaJualPerToko($idStore,$idProduk){
		$this->db->select("harga");
		$this->db->from("ap_produk_price");
		$this->db->where("id_toko",$idStore);
		$this->db->where("id_produk",$idProduk);
		return $this->db->get()->row();
	}

	function viewCartMutasi($idUser){
		$this->db->select(array("ap_produk.stok","cc_cartmutasi.idProduk","ap_produk.nama_produk","ap_produk.harga as hargaBeli","cc_cartmutasi.qty","cc_cartmutasi.id"));
		$this->db->from("cc_cartmutasi");
		$this->db->join("ap_produk","ap_produk.id_produk = cc_cartmutasi.idProduk");
		$this->db->where("cc_cartmutasi.idUser",$idUser);
		$this->db->order_by("cc_cartmutasi.id","DESC");
		$this->db->group_by("cc_cartmutasi.idProduk");
		return $this->db->get()->result();
	}

	function cekCartMutasi($idProduk,$idUser){
		$this->db->from("cc_cartmutasi");
		$this->db->where("idProduk",$idProduk);
		$this->db->where("idUser",$idUser);
		return $this->db->count_all_results();
	}

	function currentQtyCart($idProduk,$idUser){
		$this->db->select("qty");
		$this->db->from("cc_cartmutasi");
		$this->db->where("idProduk",$idProduk);
		$this->db->where("idUser",$idUser);
		$query = $this->db->get()->row();
		return $query->qty;
	}

	function lastStok($idProduk){
		$this->db->select("stok");
		$this->db->from("ap_produk");
		$this->db->where("id_produk",$idProduk);
		$query = $this->db->get()->row(); 
		return $query->stok;
	}

	function totalProdukActive(){
		$this->db->from("ap_produk");
		return $this->db->count_all_results();
	}

	function totalProdukNonJasa(){
		$this->db->from("ap_produk");
		$this->db->where("type != 2");
		$this->db->where("status",1);
		$this->db->or_where("status",0);
		return $this->db->count_all_results();
	}

	function daftarProdukAll($limit,$start,$search=''){
		$this->db->select(array("ap_produk.id_produk","ap_produk.nama_produk","ap_produk.satuan","ap_kategori.kategori"));
		$this->db->from("ap_produk");
		$this->db->join("ap_kategori","ap_kategori.id_kategori = ap_produk.id_kategori","left");
		
		
		if(!empty($search)){
			$this->db->like("ap_produk.nama_produk",$search);
			$this->db->or_like("ap_produk.id_produk",$search);
		}
		$this->db->order_by("ap_produk.id_produk");
		$this->db->limit($limit,$start);
		return $this->db->get();	
	}

	function daftarProdukNonJasa($limit,$start,$search=''){
		$this->db->select(array("ap_produk.id_produk","ap_produk.nama_produk","ap_produk.satuan","ap_kategori.kategori","ap_kategori_1.kategori_level_1","ap_kategori_2.kategori_3","ap_produk.status"));
		$this->db->from("ap_produk");
		$this->db->join("ap_kategori","ap_kategori.id_kategori = ap_produk.id_kategori","left");
		$this->db->join("ap_kategori_1","ap_kategori_1.id = ap_produk.id_subkategori","left");
		$this->db->join("ap_kategori_2","ap_kategori_2.id = ap_produk.id_subkategori_2","left");
		
		
		if(!empty($search)){
			$this->db->like("ap_produk.nama_produk",$search);
			$this->db->or_like("ap_produk.id_produk",$search);
		}

		$this->db->where("type != 3");
		$this->db->where("ap_produk.status",1);
		$this->db->or_where("ap_produk.status",0);
		$this->db->order_by("ap_produk.id_produk");
		$this->db->limit($limit,$start);
		return $this->db->get();	
	}

	function exportTemplateKategori(){
		$this->db->select(array("ap_produk.id_produk","ap_produk.nama_produk","ap_kategori.kategori","ap_kategori_1.kategori_level_1","ap_kategori_2.kategori_3","ap_produk.hpp","ap_produk.id_kategori","ap_produk.id_subkategori","ap_produk.id_subkategori_2"));
		$this->db->from("ap_produk");
		$this->db->join("ap_kategori","ap_kategori.id_kategori = ap_produk.id_kategori","left");
		$this->db->join("ap_kategori_1","ap_kategori_1.id = ap_produk.id_subkategori","left");
		$this->db->join("ap_kategori_2","ap_kategori_2.id = ap_produk.id_subkategori_2","left");
		$this->db->where("ap_produk.status",1);
		$this->db->or_where("ap_produk.status",0);
		$this->db->order_by("ap_kategori.kategori");
		return $this->db->get()->result();
	}

	function exportTemplateHargaJual($idToko,$idKategori,$subkategori,$subSubKategori,$idStand){
		$this->db->select(array("ap_produk.id_produk","ap_produk.nama_produk","ap_kategori.kategori","ap_kategori_1.kategori_level_1","ap_kategori_2.kategori_3","ap_produk_price.harga","ap_produk_price.id_toko","ap_stand.stand","ap_store.store"));
		$this->db->from("ap_produk_price");
		$this->db->join("ap_produk","ap_produk.id_produk = ap_produk_price.id_produk");
		$this->db->join("ap_kategori","ap_kategori.id_kategori = ap_produk.id_kategori");
		$this->db->join("ap_kategori_1","ap_kategori_1.id = ap_produk.id_subkategori","left");
		$this->db->join("ap_kategori_2","ap_kategori_2.id = ap_produk.id_subkategori_2","left");
		$this->db->join("ap_stand","ap_stand.id_stand = ap_produk.tempat");
		$this->db->join("ap_store","ap_store.id_store = ap_produk_price.id_toko");

		if(!empty($idKategori)){
			$this->db->where("ap_produk.id_kategori",$idKategori);
		}

		if(!empty($subkategori)){
			$this->db->where("ap_produk.id_subkategori",$subkategori);
		}

		if(!empty($subSubKategori)){
			$this->db->where("ap_produk.id_subkategori_2",$subSubKategori);
		}

		if(!empty($idStand)){
			$this->db->where("ap_produk.tempat",$idStand);
		}

		$this->db->where("ap_produk_price.id_toko",$idToko);
		$this->db->group_by("ap_produk.id_produk");
		return $this->db->get()->result();
	}

	function insertProduk($data_upload){
		$this->db->insert("ap_produk", $data_upload);
	}

	function insertHargaJual($dataHarga){
		$this->db->insert_batch("ap_produk_price",$dataHarga);
	}

	function updateProduk($id_produk,$data_upload){
		$this->db->where("id_produk",$id_produk);
		$this->db->update("ap_produk", $data_upload);
	}

	function updateHargaPertoko($idStore,$id_produk,$dataHarga){
		$this->db->where("id_toko",$idStore);
		$this->db->where("id_produk",$id_produk);	
		$this->db->update("ap_produk_price",$dataHarga);
	}

	function insertNewHargaPertoko($dataHarga){
		$this->db->insert("ap_produk_price",$dataHarga);
	}

	function hapusProduk($sku,$updateDataProduk){
		$this->db->where("id_produk",$sku);
		$this->db->update("ap_produk",$updateDataProduk);
	}

	function insertStokStore($dataInsertStore){
		$this->db->insert("stok_store",$dataInsertStore);
	}
}