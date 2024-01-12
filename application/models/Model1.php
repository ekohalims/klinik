<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class Model1 extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	function footertext(){
		$this->db->select("footer");
		$this->db->from("footer_text");
		$this->db->where("id",1);
		$query = $this->db->get()->row();
		return $query->footer;
	}

	function daftarProdukAll(){
		$this->db->select("*");
		$this->db->from("ap_produk");
		$this->db->join("ap_kategori","ap_kategori.id_kategori = ap_produk.id_kategori","left");
		$this->db->join("ap_kategori_1","ap_kategori_1.id = ap_produk.id_subkategori","left");
		$this->db->join("ap_kategori_2","ap_kategori_2.id = ap_produk.id_subkategori_2","left");
		$this->db->where("ap_produk.status",1);
		$this->db->or_where("ap_produk.status",0);
		$this->db->order_by("ap_produk.id_produk");
		return $this->db->get()->result();	
	}

	function data_stok_distributor($id_distributor){
		$this->db->select(array("ap_produk.id_produk","ap_produk.nama_produk","stok_store.stok","ap_kategori.kategori","bahan_baku.harga"));
		$this->db->from("stok_store");
		$this->db->join("ap_produk","ap_produk.id_produk = stok_store.id_produk","left");
		$this->db->join("ap_kategori","ap_produk.id_kategori = ap_kategori.id_kategori","left");
		$this->db->join("bahan_baku","bahan_baku.sku = stok_store.id_produk","left");
		$this->db->where("id_store",$id_distributor);
		$this->db->group_by("stok_store.id_produk");
		return $this->db->get();
	}

	function nama_toko($id){
		$this->db->select("store");
		$this->db->from("ap_store");
		$this->db->where("id_store",$id);
		$query = $this->db->get()->result();

		foreach($query as $row){
			return $row->store;
		}
	}

	function callNavigation(){
		$this->db->select(array("z_menu_klinik.id","z_menu_klinik.menu","z_menu_klinik.slug","z_menu_klinik.icon"));
		$this->db->from("z_menu_klinik");
		$this->db->group_by("z_menu_klinik.id");
		$query = $this->db->get()->result();
		return $query;
	}

	function submenu($id){
		$this->db->select("*");
		$this->db->from("z_submenu_klinik");
		$this->db->where("id",$id);
		return $this->db->get()->result();
	}

	function permitAccess($idUser){
		$this->db->select("menu");
		$this->db->from("users");
		$this->db->where("id",$idUser);
		$query = $this->db->get()->row();
		return $query->menu;
	}

	function permitAccessSub($idUser){
		$this->db->select("sub_menu");
		$this->db->from("users");
		$this->db->where("id",$idUser);
		$query = $this->db->get()->row();
		return $query->sub_menu;
	}

	function masterMenu($slug){
		$this->db->select("id");
		$this->db->from("z_menu");
		$this->db->where("slug",$slug);
		$query = $this->db->get()->row();
		return $query->id;
	}

	function subMenuId($slug){
		$this->db->select("idSub");
		$this->db->from("z_submenu");
		$this->db->where("z_submenu.slug",$slug);
		$query = $this->db->get()->row();
		return $query->idSub;
	}

	function cekMyAccess($idUser,$type,$code){
		if($type==1){
			$permit = json_decode($this->permitAccess($idUser));
			$accessMenu = in_array($code,$permit);
		} else {
			$permit = json_decode($this->permitAccessSub($idUser));
			$accessMenu = in_array($code,$permit);
		}

		return $accessMenu;
	}

	function get_produk_select2(){
		$this->db->select(array("ap_produk.nama_produk","ap_produk.id_produk"));
		$this->db->from("ap_produk");
		return $this->db->get();
	}

	function count_invoice($tanggal){
		$this->db->from("ap_invoice_number");
		$this->db->like("tanggal",$tanggal);
		return $this->db->count_all_results();
	}

	function invoice_ket($no_invoice){
		$this->db->select(array("ap_invoice_number.jumlah_bayar","ap_invoice_number.jatuh_tempo","ap_customer_group.group_customer","ap_invoice_number.poin_value","ap_invoice_number.status","ap_invoice_number.kontak_pengiriman","ap_invoice_number.no_invoice","ap_invoice_number.diskon_free","ap_invoice_number.tipe_bayar","ap_invoice_number.tanggal","ap_invoice_number.total","ap_invoice_number.ongkir","ap_invoice_number.diskon","ap_customer.nama","ap_invoice_number.alamat","ae_provinsi.nama_provinsi","ae_kecamatan.kecamatan","ae_kabupaten.nama_kabupaten","ap_invoice_number.keterangan","ap_payment_account.account","ap_payment_type.payment_type","ap_customer.kontak","ap_customer.alamat"));
		$this->db->from("ap_invoice_number");
		$this->db->join("ap_customer","ap_customer.id_customer = ap_invoice_number.id_customer","left");
		$this->db->join("ap_customer_group","ap_customer_group.id_group = ap_customer.kategori","left");
		$this->db->join("ae_provinsi","ae_provinsi.id_provinsi = ap_invoice_number.id_provinsi","left");
		$this->db->join("ae_kabupaten","ae_kabupaten.kabupaten_id = ap_invoice_number.id_kabupaten","left");
		$this->db->join("ae_kecamatan","ae_kecamatan.id_kecamatan = ap_invoice_number.id_kecamatan","left");
		$this->db->join("ap_payment_type","ap_payment_type.id = ap_invoice_number.tipe_bayar","left");
		$this->db->join("ap_payment_account","ap_payment_account.id_payment_account = ap_invoice_number.sub_account","left");
		$this->db->where("ap_invoice_number.no_invoice",$no_invoice);
		$this->db->group_by("ap_invoice_number.no_invoice");
		$this->db->order_by("ap_invoice_number.tanggal","DESC");
		return $this->db->get();
	}

	function invoice_item($no_invoice){
		$this->db->select(array("ap_produk.nama_produk","ap_invoice_item.qty","ap_invoice_item.harga_jual","ap_produk.id_produk","ap_produk.id_produk","ap_invoice_item.diskon","ap_invoice_item.pajak"));
		$this->db->from("ap_invoice_item");
		$this->db->join("ap_produk","ap_produk.id_produk = ap_invoice_item.id_produk","left");
		$this->db->where("ap_invoice_item.no_invoice",$no_invoice);
		$this->db->group_by("ap_invoice_item.id_produk");
		return $this->db->get();
	}

	function getIdKasir($id){
		$this->db->select("id_pic");
		$this->db->from("ap_invoice_number");
		$this->db->where("no_invoice",$id);
		$query = $this->db->get()->result();

		foreach($query as $row){
			return $row->id_pic;
		}
	}

	function nama_kasir($id){
		$this->db->select("first_name");
		$this->db->from("users");
		$this->db->where("id",$id);
		$query = $this->db->get()->result();

		foreach($query as $row){
			return $row->first_name;
		}
	}

	function item_barang_struk($no_invoice){
		$this->db->select("COUNT(no_invoice) as qty");
		$this->db->from("ap_invoice_item");
		$this->db->where("no_invoice",$no_invoice);
		$query = $this->db->get()->result();

		foreach($query as $row){
			return $row->qty;
		}
	}

	function qty_barang_struk($no_invoice){
		$this->db->select("SUM(qty) as qty");
		$this->db->from("ap_invoice_item");
		$this->db->where("no_invoice",$no_invoice);
		$query = $this->db->get()->result();

		foreach($query as $row){
			return $row->qty;
		}
	}

	function tipe_bayar_struk($no_invoice){
		$this->db->select(array("ap_payment_type.payment_type","ap_payment_account.account"));
		$this->db->from("ap_invoice_number");
		$this->db->join("ap_payment_type","ap_payment_type.id = ap_invoice_number.tipe_bayar","left");
		$this->db->join("ap_payment_account","ap_payment_account.id_payment_account = ap_invoice_number.sub_account","left");
		$this->db->where("ap_invoice_number.no_invoice",$no_invoice);
		$query = $this->db->get()->result();

		foreach($query as $row){
			return $row->payment_type." ".$row->account;
		}
	}

	function total_penjualan_all(){
		$this->db->from("ap_invoice_number");
		return $this->db->count_all_results();
	}

	function daftarPenjualan($limit,$start,$query=''){
		$this->db->select(array("ap_invoice_number.poin_value","ap_invoice_number.no_invoice","ap_invoice_number.tipe_bayar","ap_invoice_number.tanggal","ap_invoice_number.total","ap_invoice_number.ongkir","ap_invoice_number.diskon","ap_invoice_number.keterangan","ap_invoice_number.status","ap_invoice_number.diskon_free","ap_invoice_number.diskon_otomatis","ap_payment_type.payment_type","ap_payment_account.account"));
		$this->db->from("ap_invoice_number");
		$this->db->join("ap_payment_type","ap_payment_type.id = ap_invoice_number.tipe_bayar","left");
		$this->db->join("ap_payment_account","ap_payment_account.id_payment_account = ap_invoice_number.sub_account","left");
		$this->db->where("ap_invoice_number.total != ''");
		if(!empty($query)){
			$this->db->like("ap_invoice_number.no_invoice",$query);
		}

		$this->db->limit($limit,$start);
		$this->db->group_by("ap_invoice_number.no_invoice");
		$this->db->order_by("ap_invoice_number.tanggal","DESC");
		return $this->db->get();
	}

	function daftar_penjualan_all_sort($query){
		$this->db->select(array("ap_invoice_number.poin_value","ap_invoice_number.no_invoice","ap_invoice_number.tipe_bayar","ap_invoice_number.tanggal","ap_invoice_number.total","ap_invoice_number.ongkir","ap_invoice_number.diskon","ap_customer.nama","ap_invoice_number.alamat","ae_provinsi.nama_provinsi","ae_kecamatan.kecamatan","ae_kabupaten.nama_kabupaten","ap_invoice_number.keterangan","ap_invoice_number.status","ap_invoice_number.tanggal_kirim","ap_invoice_number.diskon_free","ap_invoice_number.diskon_otomatis","ap_payment_type.payment_type","ap_payment_account.account"));
		$this->db->from("ap_invoice_number");
		$this->db->join("ap_payment_type","ap_payment_type.id = ap_invoice_number.tipe_bayar","left");
		$this->db->join("ap_payment_account","ap_payment_account.id_payment_account = ap_invoice_number.sub_account","left");
		$this->db->join("ap_customer","ap_customer.id_customer = ap_invoice_number.id_customer","left");
		$this->db->join("ae_provinsi","ae_provinsi.id_provinsi = ap_invoice_number.id_provinsi","left");
		$this->db->join("ae_kabupaten","ae_kabupaten.kabupaten_id = ap_invoice_number.id_kabupaten","left");
		$this->db->join("ae_kecamatan","ae_kecamatan.id_kecamatan = ap_invoice_number.id_kecamatan","left");
		$this->db->like("ap_invoice_number.no_invoice",$query);
		$this->db->or_like("ap_customer.nama",$query);
		$this->db->group_by("ap_invoice_number.no_invoice");
		$this->db->order_by("ap_invoice_number.tanggal","DESC");
		return $this->db->get();
	}
}