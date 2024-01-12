<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class ModelStockOpname extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	function hargaProduk($sku){
		$this->db->select("hpp");
		$this->db->from("ap_produk");
		$this->db->where("id_produk",$sku);
		$query = $this->db->get()->row();
		return $query->hpp;
	}

	function dataStokFG($kategori){
		$this->db->select(array("ap_produk.id_produk","ap_produk.nama_produk","ap_kategori.kategori","ap_produk.stok","ap_produk.hpp as harga"));
		$this->db->from("ap_produk");
		$this->db->join("ap_kategori","ap_kategori.id_kategori = ap_produk.id_kategori","left");

		if(!empty($kategori)){
			$this->db->where("ap_produk.id_kategori",$kategori);
		}

		return $this->db->get();
	}

	function insertStockOpnameInfo($data_so){
		$this->db->insert("stock_opname_info",$data_so);
	}

	function insertBatchSO($data_item){
		$this->db->insert_batch("stock_opname",$data_item);
	}

	function updateBatchStok($data_stok){
		$this->db->update_batch("ap_produk",$data_stok,"id_produk");
	}

	function insertStockOpnameInfoToko($data_so){
		$this->db->insert("stock_opname_info",$data_so);
	}

	function updateStokToko($kode_toko,$sku,$data_stok){
		$this->db->where("id_store",$kode_toko);
		$this->db->where("id_produk",$sku);
		$this->db->update("stok_store",$data_stok);
	}

	function insertBatchStokOpnameToko($data_item){
		$this->db->insert_batch("stock_opname",$data_item);
	}

	function cekNoSOGudang(){
		$this->db->from("stock_opname_info");
		$this->db->where("MONTH(tanggal)",date('m'));
		$this->db->where("YEAR(tanggal)",date('Y'));
		$this->db->where("type",1);
		return $this->db->count_all_results();
	}

	function cekNOSOToko(){
		$this->db->from("stock_opname_info");
		$this->db->where("MONTH(tanggal)",date('m'));
		$this->db->where("YEAR(tanggal)",date('Y'));
		$this->db->where("type",2);
		return $this->db->count_all_results();
	}

	function headerSO($noSO){
		$this->db->select(array("stock_opname_info.noSO","stock_opname_info.tanggal","users.first_name","users.last_name","stock_opname_info.keterangan","stock_opname_info.type"));
		$this->db->from("stock_opname_info");
		$this->db->join("users","users.id = stock_opname_info.idUser");
		$this->db->where("stock_opname_info.noSO",$noSO);
		return $this->db->get()->row();
	}

	function headerSOStore($noSO){
		$this->db->select(array("stock_opname_info.noSO","stock_opname_info.tanggal","users.first_name","users.last_name","stock_opname_info.keterangan","stock_opname_info.type","ap_store.store"));
		$this->db->from("stock_opname_info");
		$this->db->join("users","users.id = stock_opname_info.idUser");
		$this->db->join("ap_store","ap_store.id_store = stock_opname_info.store");
		$this->db->where("stock_opname_info.noSO",$noSO);
		return $this->db->get()->row();
	}

	function dataSOItem($noSO){
		$this->db->select(array("ap_produk.id_produk","ap_produk.nama_produk","stock_opname.lastStok","stock_opname.newStok","stock_opname.harga"));
		$this->db->from("stock_opname");
		$this->db->join("ap_produk","ap_produk.id_produk = stock_opname.idProduk");
		$this->db->where("stock_opname.noSO",$noSO);
		$this->db->group_by("stock_opname.idProduk");
		return $this->db->get()->result();
	}

	function nilaiSelisihSO($no_so){
		$this->db->select("SUM((newStok-lastStok)*harga) as total");
		$this->db->from("stock_opname");
		$this->db->where("noSO",$no_so);
		$query = $this->db->get()->row();
		return $query->total;
	
	}
}