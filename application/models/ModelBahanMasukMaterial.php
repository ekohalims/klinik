<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class ModelBahanMasukMaterial extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	function totalPOMaterial(){
		$this->db->from("purchase_order");
		$this->db->where("type",1);
		return $this->db->count_all_results();
	}

	function totalPOMaterialFilter($tanggalPO='',$tanggalKirim='',$supplier='',$status=''){
		$this->db->from("purchase_order");
		if(!empty($tanggalPO)){
			$this->db->where("purchase_order.tanggal_po",$tanggalPO);
		}

		if(!empty($tanggalKirim)){
			$this->db->where("purchase_order.tanggal_kirim",$tanggalKirim);
		}

		if(!empty($supplier)){
			$this->db->where("purchase_order.id_supplier",$supplier);
		}

		if(!empty($status)){
			$this->db->where("purchase_order.status",$status);
		}
		$this->db->where("type",1);
		return $this->db->count_all_results();
	}

	function totalPOProduk(){
		$this->db->from("purchase_order");
		$this->db->where("type",0);
		return $this->db->count_all_results();
	}

	function totalPOProdukFilter($tanggalPO='',$tanggalKirim='',$supplier='',$status=''){
		$this->db->from("purchase_order");

		if(!empty($tanggalPO)){
			$this->db->where("purchase_order.tanggal_po",$tanggalPO);
		}

		if(!empty($tanggalKirim)){
			$this->db->where("purchase_order.tanggal_kirim",$tanggalKirim);
		}

		if(!empty($supplier)){
			$this->db->where("purchase_order.id_supplier",$supplier);
		}

		if(!empty($status)){
			$this->db->where("purchase_order.status",$status);
		}
		$this->db->where("type",0);
		return $this->db->count_all_results();
	}

	function viewPOMaterial($limit,$start,$search=''){
		$dataSelect = array(
								"purchase_order.no_po","purchase_order.tanggal_po","purchase_order.tanggal_kirim","supplier.supplier","users.first_name","purchase_order.status"
						   );

		$this->db->select($dataSelect);
		$this->db->from("purchase_order");
		$this->db->join("supplier","supplier.id_supplier = purchase_order.id_supplier");
		$this->db->join("users","users.id = purchase_order.id_pic");

		if(!empty($search)){
			$this->db->like("purchase_order.no_po",$search);
		}

		$this->db->limit($limit,$start);
		$this->db->order_by("purchase_order.tanggal_po","DESC");
		$this->db->order_by("purchase_order.no_po","DESC");
		$this->db->where('type',1);
		return $this->db->get();
	}

	function viewPOMaterialFilter($limit,$start,$search='',$tanggalPO='',$tanggalKirim='',$supplier='',$status=''){
		$dataSelect = array(
								"purchase_order.no_po","purchase_order.tanggal_po","purchase_order.tanggal_kirim","supplier.supplier","users.first_name","purchase_order.status"
						   );

		$this->db->select($dataSelect);
		$this->db->from("purchase_order");
		$this->db->join("supplier","supplier.id_supplier = purchase_order.id_supplier");
		$this->db->join("users","users.id = purchase_order.id_pic");

		if(!empty($search)){
			$this->db->like("purchase_order.no_po",$search);
		}

		if(!empty($tanggalPO)){
			$this->db->where("purchase_order.tanggal_po",$tanggalPO);
		}

		if(!empty($tanggalKirim)){
			$this->db->where("purchase_order.tanggal_kirim",$tanggalKirim);
		}

		if(!empty($supplier)){
			$this->db->where("purchase_order.id_supplier",$supplier);
		}

		if(!empty($status)){
			$this->db->where("purchase_order.status",$status);
		}

		$this->db->where('type',1);

		$this->db->limit($limit,$start);
		$this->db->order_by("purchase_order.tanggal_po","DESC");
		$this->db->order_by("purchase_order.no_po","DESC");
		return $this->db->get();
	}

	function viewPOProduk($limit,$start,$search=''){
		$dataSelect = array(
								"purchase_order.no_po","purchase_order.tanggal_po","purchase_order.tanggal_kirim","supplier.supplier","users.first_name","purchase_order.status"
						   );

		$this->db->select($dataSelect);
		$this->db->from("purchase_order");
		$this->db->join("supplier","supplier.id_supplier = purchase_order.id_supplier");
		$this->db->join("users","users.id = purchase_order.id_pic");

		if(!empty($search)){
			$this->db->like("purchase_order.no_po",$search);
		}

		$this->db->limit($limit,$start);
		$this->db->order_by("purchase_order.tanggal_po","DESC");
		$this->db->order_by("purchase_order.no_po","DESC");
		$this->db->where('type',0);
		return $this->db->get();
	}

	function viewPOProdukFilter($limit,$start,$search='',$tanggalPO='',$tanggalKirim='',$supplier='',$status=''){
		$dataSelect = array(
								"purchase_order.no_po","purchase_order.tanggal_po","purchase_order.tanggal_kirim","supplier.supplier","users.first_name","purchase_order.status"
						   );

		$this->db->select($dataSelect);
		$this->db->from("purchase_order");
		$this->db->join("supplier","supplier.id_supplier = purchase_order.id_supplier");
		$this->db->join("users","users.id = purchase_order.id_pic");

		if(!empty($search)){
			$this->db->like("purchase_order.no_po",$search);
		}

		if(!empty($tanggalPO)){
			$this->db->where("purchase_order.tanggal_po",$tanggalPO);
		}

		if(!empty($tanggalKirim)){
			$this->db->where("purchase_order.tanggal_kirim",$tanggalKirim);
		}

		if(!empty($supplier)){
			$this->db->where("purchase_order.id_supplier",$supplier);
		}

		if(!empty($status)){
			$this->db->where("purchase_order.status",$status);
		}

		$this->db->limit($limit,$start);
		$this->db->order_by("purchase_order.tanggal_po","DESC");
		$this->db->order_by("purchase_order.no_po","DESC");
		$this->db->where('type',0);
		return $this->db->get();
	}

	function purchase_item($no_po){
		$this->db->select(array("ap_produk.nama_produk","purchase_item.qty","ap_produk.satuan","purchase_item.harga","(purchase_item.harga*purchase_item.qty) as total","ap_produk.id_produk"));
		$this->db->from("purchase_item");
		$this->db->join("ap_produk","ap_produk.id_produk = purchase_item.sku","left");
		$this->db->where("purchase_item.no_po",$no_po);
		return $this->db->get();
	}

	function purchaseItemMaterial($no_po){
		$this->db->select(array("bahan_baku.sku","bahan_baku.nama_bahan","purchase_item.qty","bahan_baku.satuan","purchase_item.harga","(purchase_item.harga*purchase_item.qty) as total"));
		$this->db->from("purchase_item");
		$this->db->join("bahan_baku","bahan_baku.sku = purchase_item.sku","left");
		$this->db->where("purchase_item.no_po",$no_po);
		return $this->db->get();
	}

	function received_item($no_receive){
		$this->db->select("*");
		$this->db->from("receive_item");
		$this->db->join("ap_produk","ap_produk.id_produk = receive_item.sku","left");
		$this->db->where("no_receive",$no_receive);
		return $this->db->get();
	}

	function received_item_material($no_receive){
		$this->db->select(array("bahan_baku.sku as id_produk","bahan_baku.nama_bahan as nama_produk","bahan_baku.satuan","receive_item.qty"));
		$this->db->from("receive_item");
		$this->db->join("bahan_baku","bahan_baku.sku = receive_item.sku","left");
		$this->db->where("no_receive",$no_receive);
		return $this->db->get();
	}

	function receivedItemMaterial($no_receive){
		$this->db->select(array('bahan_baku.sku','bahan_baku.nama_bahan','receive_item.qty','bahan_baku.satuan'));
		$this->db->from("receive_item");
		$this->db->join("bahan_baku","bahan_baku.sku = receive_item.sku","left");
		$this->db->where("no_receive",$no_receive);
		return $this->db->get();
	}

	function noteInfoPO($noPO){
		$colSelect = array(
							"purchase_order.tanggal_po",
							"purchase_order.no_po",
							"purchase_order.tanggal_kirim",
							"purchase_order.status",
							"supplier.supplier",
							"supplier.alamat",
							"supplier.kontak",
							"purchase_order.alamat_pengiriman",
							"purchase_order.id_supplier"
						);
		$this->db->select($colSelect);
		$this->db->from("purchase_order");
		$this->db->join("supplier","supplier.id_supplier = purchase_order.id_supplier");
		$this->db->where("purchase_order.no_po",$noPO);
		return $this->db->get()->row();
	}

	function cekStokBahanBaku($sku){
		$this->db->select("stok");
		$this->db->from("bahan_baku");
		$this->db->where("sku",$sku);
		$row = $this->db->get()->row();
		return $row->stok;
	}

	function dataReceive($noReceive){
		$this->db->select(array("receive_order.no_receive","receive_order.no_po","receive_order.tanggal_terima","receive_order.received_by","receive_order.checked_by","supplier.supplier","receive_order.diterimaDi"));
		$this->db->from("receive_order");
		$this->db->join("purchase_order","purchase_order.no_po = receive_order.no_po");
		$this->db->join("supplier","supplier.id_supplier = purchase_order.id_supplier","right");
		$this->db->where("receive_order.no_receive",$noReceive);
		return $this->db->get()->result();
	}

	function riwayatPenerimaan($noPo){
		$this->db->select(array("bahan_baku.sku","bahan_baku.nama_bahan","receive_item.tanggal","receive_item.qty"));
		$this->db->from("receive_item");
		$this->db->join("receive_order","receive_order.no_receive = receive_item.no_receive");
		$this->db->join("bahan_baku","bahan_baku.sku=receive_item.sku");
		$this->db->where("receive_order.no_po",$noPo);
		$this->db->where("receive_item.qty > 0");
		$this->db->order_by("receive_item.tanggal","DESC");
		return $this->db->get()->result();
	}

	function riwayatPenerimaanProduk($noPo){
		$this->db->select(array("ap_produk.id_produk","ap_produk.nama_produk","receive_item.tanggal","receive_item.qty"));
		$this->db->from("receive_item");
		$this->db->join("receive_order","receive_order.no_receive = receive_item.no_receive");
		$this->db->join("ap_produk","ap_produk.id_produk=receive_item.sku");
		$this->db->where("receive_order.no_po",$noPo);
		$this->db->where("receive_item.qty > 0");
		$this->db->order_by("receive_item.tanggal","DESC");
		return $this->db->get()->result();
	}

	function receivedInvoice($no_po){
		$this->db->select(array(
									"receive_order.no_receive",
									"receive_order.received_by",
									"receive_order.checked_by",
									"receive_order.tanggal_terima",
									"receive_order.diterimaDi",
									"SUM(receive_item.qty*receive_item.price) as total"
							    ));
		$this->db->from("receive_order");
		$this->db->join("receive_item","receive_item.no_receive = receive_order.no_receive","left");
		$this->db->where("no_po",$no_po);
		$this->db->order_by("receive_order.no_receive","DESC");
		$this->db->group_by("receive_order.no_receive");
		return $this->db->get();
	}

	function changePOStatus($no_po,$data_update){
		$this->db->where("no_po",$no_po);
		$this->db->update("purchase_order",$data_update);
	}


	function penerimaanGudang($data_stok){
		$this->db->update_batch("ap_produk",$data_stok,"id_produk");
	}

	function penerimaanToko($sku,$diterimaDi,$dataStok){
		$this->db->where("id_produk",$sku);
		$this->db->where("id_store",$diterimaDi);
		$this->db->update("stok_store",$dataStok);
	}

	function insertNewStokStoreTransfer($dataStok){
		$this->db->insert("stok_store",$dataStok);
	}

	function terbitkanStatusHutang($data_tagihan){
		$this->db->insert("hutang",$data_tagihan);
	}

	function insertReceiveOrder($data_receive){
		$this->db->insert("receive_order",$data_receive);
	}

	function insertBatchReceiveItem($data_insert){
		$this->db->insert_batch("receive_item",$data_insert);
	}

	function updateBatchStokBahanBaku($data_update){
		$this->db->update_batch("bahan_baku",$data_update,"sku");
	}

	function terbitkanHutang($data_tagihan){
		$this->db->insert("hutang",$data_tagihan);
	}

	function cekTanggalReceive($tanggal){
		$this->db->from("receive_order");
		$this->db->where("tanggal_terima",$tanggal);
		return $this->db->count_all_results();
	}

	function cek_stok_toko($id_produk,$id_store){
		$this->db->from("stok_store");
		$this->db->where("id_produk",$id_produk);
		$this->db->where("id_store",$id_store);
		return $this->db->count_all_results();
	}

	function cek_penerbitan_hutang($no_po){
		$this->db->from("hutang");
		$this->db->where("no_tagihan",$no_po);
		return $this->db->count_all_results();
	}

	function received_invoice($no_po){
		$this->db->select(array(
									"receive_order.no_receive",
									"receive_order.received_by",
									"receive_order.checked_by",
									"receive_order.tanggal_terima",
									"receive_order.diterimaDi",
									"SUM(receive_item.qty*receive_item.price) as total"
							    ));
		$this->db->from("receive_order");
		$this->db->join("receive_item","receive_item.no_receive = receive_order.no_receive","left");
		$this->db->where("no_po",$no_po);
		$this->db->order_by("receive_order.no_receive","DESC");
		$this->db->group_by("receive_order.no_receive");
		return $this->db->get();
	}

	function info_purchase($no_po){
		$this->db->select(array("purchase_order.tanggal_po","purchase_order.keterangan","supplier.supplier","supplier.alamat","supplier.kontak","purchase_order.ppn","purchase_order.nilai_ppn","purchase_order.alamat_pengiriman","purchase_order.tanggal_kirim","purchase_order.id_supplier"));
		$this->db->from("purchase_order");
		$this->db->join("supplier","supplier.id_supplier = purchase_order.id_supplier","left");
		$this->db->where("purchase_order.no_po",$no_po);
		$this->db->group_by("purchase_order.no_po");
		$query = $this->db->get();
		return $query->result();
	}

	function qtyDiterima($id,$no_po){
		$this->db->select("SUM(receive_item.qty) as qty");
		$this->db->from("receive_item");
		$this->db->join("receive_order","receive_order.no_receive = receive_item.no_receive","left");
		$this->db->where("receive_order.no_po",$no_po);
		$this->db->where("receive_item.sku",$id);
		$query = $this->db->get();

		foreach($query->result() as $dt){
			return $dt->qty;
		}
	}

	function status_po($no_po){
		$this->db->select("status");
		$this->db->from("purchase_order");
		$this->db->where("no_po",$no_po);
		$query = $this->db->get();

		foreach($query->result() as $row){
			return $row->status;
		}
	}

	function delivered_qty($no_po,$sku){
		$this->db->select("SUM(qty) as qty");
		$this->db->from("receive_item");
		$this->db->join("receive_order","receive_order.no_receive = receive_item.no_receive","left");
		$this->db->where("receive_order.no_po",$no_po);
		$this->db->where("receive_item.sku",$sku);
		$query = $this->db->get();
		foreach($query->result() as $row){
			return $row->qty;
		}
	}

	function hutangSesuaiBarangYangDiterima($noReceive){
		$this->db->select("SUM(qty*price) as total");
		$this->db->from("receive_item");
		$this->db->where("no_receive",$noReceive);
		$query = $this->db->get()->row();
		return $query->total;
	}

	function cekPenerimaan($sku){
		$bulan = date('m');
		$tahun = date('Y');

		$this->db->from("kartu_stok");
		$this->db->where("idProduk",$sku);
		$this->db->where("MONTH(tanggal)",$bulan);
		$this->db->where("YEAR(tanggal)",$tahun);
		return $this->db->count_all_results();
	}

	function rpMasuk($sku){
		$bulan = date('m');
		$tahun = date('Y');

		$this->db->select("SUM(hargaSatuan*barangMasuk) as rpMasuk");
		$this->db->from("kartu_stok");
		$this->db->where("idProduk",$sku);
		$this->db->where("MONTH(tanggal)",$bulan);
		$this->db->where("YEAR(tanggal)",$tahun);
		$query = $this->db->get()->result();

		foreach($query as $row){
			return $row->rpMasuk;
		}
	}

	function rpKeluar($sku){
		$bulan = date('m');
		$tahun = date('Y');

		$this->db->select("SUM(hargaSatuan*barangKeluar) as rpKeluar");
		$this->db->from("kartu_stok");
		$this->db->where("idProduk",$sku);
		$this->db->where("MONTH(tanggal)",$bulan);
		$this->db->where("YEAR(tanggal)",$tahun);
		$query = $this->db->get()->result();

		foreach($query as $row){
			return $row->rpKeluar;
		}
	}

	function qtyMasuk($sku){
		$bulan = date('m');
		$tahun = date('Y');

		$this->db->select("SUM(barangMasuk) as qtyMasuk");
		$this->db->from("kartu_stok");
		$this->db->where("idProduk",$sku);
		$this->db->where("MONTH(tanggal)",$bulan);
		$this->db->where("YEAR(tanggal)",$tahun);
		$query = $this->db->get()->result();

		foreach($query as $row){
			return $row->qtyMasuk;
		}
	}

	function qtyKeluar($sku){
		$bulan = date('m');
		$tahun = date('Y');

		$this->db->select("SUM(barangKeluar) as qtyKeluar");
		$this->db->from("kartu_stok");
		$this->db->where("idProduk",$sku);
		$this->db->where("MONTH(tanggal)",$bulan);
		$this->db->where("YEAR(tanggal)",$tahun);
		$query = $this->db->get()->result();

		foreach($query as $row){
			return $row->qtyKeluar;
		}
	}

	function updateHargaAverage($dataHargaAverage){
		$this->db->update_batch("ap_produk",$dataHargaAverage,"id_produk");
	}

	function hargaBeli($sku,$noPO){
		$this->db->select("harga");
		$this->db->from("purchase_item");
		$this->db->where("sku",$sku);
		$this->db->where("no_po",$noPO);
		return $this->db->get()->row()->harga;
	}

	function cekExpProduk($sku,$tanggalExpired){
		$this->db->from("ap_produk_exp");
		$this->db->where("id_produk",$sku);
		$this->db->where("expiredDate",$tanggalExpired);
		return $this->db->count_all_results();
	}

	function currentStokExpired($sku,$tanggalExpired){
		$this->db->select("stok");
		$this->db->from("ap_produk_exp");
		$this->db->where("id_produk",$sku);
		$this->db->where("expiredDate",$tanggalExpired);
		$query = $this->db->get()->row();
		return $query->stok;
	}

	function updateStokExp($dataUpdateStokExp,$sku,$tanggalExpired){
		$this->db->where("id_produk",$sku);
		$this->db->where("expiredDate",$tanggalExpired);
		$this->db->update("ap_produk_exp",$dataUpdateStokExp);
	}

	function insertStokExp($dataExpStok){
		$this->db->insert("ap_produk_exp",$dataExpStok);
	}
}