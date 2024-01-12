<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class ModelWaste extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	function cekCartWaste($idProduk,$idUser){
		$this->db->from("cc_cartwaste");
		$this->db->where("idProduk",$idProduk);
		$this->db->where("idUser",$idUser);
		return $this->db->count_all_results();
	}

	function getIdCart($idProduk,$idUser){
		$this->db->select("id");
		$this->db->from("cc_cartwaste");
		$this->db->where("idUser",$idUser);
		$this->db->where("idProduk",$idProduk);
		$query = $this->db->get()->row();
		return $query->id;
	}

	function viewCartWaste($idUser){
		$this->db->select(array("cc_cartwaste.batchNo","ap_produk.id_produk","ap_produk.nama_produk","ap_produk.satuan","cc_cartwaste.qty","cc_cartwaste.id","ap_produk.hpp","cc_cartwaste.expiredDate"));
		$this->db->from("cc_cartwaste");
		$this->db->join("ap_produk","ap_produk.id_produk = cc_cartwaste.idProduk");
		$this->db->where("cc_cartwaste.idUser",$idUser);
		$this->db->order_by("cc_cartwaste.id","DESC");
		return $this->db->get()->result();
	}

	function currentStokWarehouse($sku){
		$this->db->select("stok");
		$this->db->from("ap_produk");
		$this->db->where("id_produk",$sku);
		$query = $this->db->get()->row();
		return $query->stok;
	}

	function cek_tanggal_waste($tanggal_waste){
		$this->db->from("waste");
		$this->db->where("tanggal_waste",$tanggal_waste);
		return $this->db->count_all_results();
	}

	function insertWaste($data_waste){
		$this->db->insert("waste",$data_waste);
	}

	function insertWasteItemBatch($data_item){
		$this->db->insert_batch("waste_item",$data_item);
	}

	function updateStokBatch($data_update){
		$this->db->update_batch("ap_produk",$data_update,"id_produk");
	}

	function hapusCartWaste($idUser){
		$this->db->delete("cc_cartwaste",array("idUser" => $idUser));
	}

	function insertCartWaste($dataArray){
		$this->db->insert("cc_cartwaste",$dataArray);
	}

	function updateQtyCartWaste($idProduk,$idUser,$dataUpdate){
		$this->db->where("idProduk",$idProduk);
		$this->db->where("idUser",$idUser);
		$this->db->update("cc_cartwaste",$dataUpdate);
	}

	function hapusCartId($id){
		$this->db->delete("cc_cartwaste",array("id" => $id));
	}

	function info_waste($no_waste){
		$this->db->select(array("users.first_name as nama_user","waste.no_waste","waste.tanggal_waste","(keterangan_waste.keterangan) as tipe_waste","waste.keterangan","SUM(waste_item.harga*waste_item.qty) as value","waste.image"));
		$this->db->from("waste");
		$this->db->join("keterangan_waste","keterangan_waste.id_keterangan = waste.id_keterangan","left");
		$this->db->join("waste_item","waste_item.no_waste = waste.no_waste","left");
		$this->db->join("users","users.id = waste.id_pic","left");
		$this->db->where("waste.no_waste",$no_waste);
		$this->db->order_by("waste.tanggal_waste","DESC");
		$this->db->group_by("waste.no_waste");
		return $this->db->get();
	}

	function item_waste($no_waste){
		$this->db->select(array("ap_produk.id_produk","ap_produk.nama_produk","waste_item.qty","ap_produk.satuan","waste_item.harga"));
		$this->db->from("waste_item");
		$this->db->join("ap_produk","ap_produk.id_produk = waste_item.sku","left");
		$this->db->where("waste_item.no_waste",$no_waste);
		return $this->db->get();
	}

	function ubahExpiredDate($dataUpdate,$idProduk,$idUser){
		$this->db->where("idProduk",$idProduk);
		$this->db->where("idUser",$idUser);
		$this->db->update("cc_cartwaste",$dataUpdate);
	}

	function totalHPP($no_inv){
		$this->db->select("(harga*qty) as total");
		$this->db->from("waste_item");
		$this->db->where("no_waste",$no_inv);
		$query = $this->db->get()->result();

		foreach($query as $row){
			return $row->total;
		}
	}
}