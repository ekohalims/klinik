<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class ModelFinance extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	function total_tagihan(){
		$this->db->from("hutang");
		return $this->db->count_all_results();
	}

	function status_transaksi($id){
		$this->db->select("status_hutang");
		$this->db->from("hutang");
		$this->db->where("no_tagihan",$id);
		$query = $this->db->get();	

		foreach($query->result() as $row){
			return $row->status_hutang;
		}
	}

	function updateTanggalJatuhTempo($noPO,$dataUpdate){
		$this->db->where("no_po",$noPO);
		$this->db->update("purchase_order",$dataUpdate);
		$affect = $this->db->affected_rows();
		return $affect;
	}

	function dataTagihan($limit,$start,$search){
		$this->db->select(array("hutang.no_tagihan","purchase_order.tanggal_po","purchase_order.jatuh_tempo","users.first_name","hutang.status_hutang","purchase_order.keterangan","SUM(purchase_item.harga*purchase_item.qty) as total","hutang.status_hutang"));
		$this->db->from("hutang");
		$this->db->join("purchase_order","purchase_order.no_po = hutang.no_tagihan","left");
		$this->db->join("users","users.id = purchase_order.id_pic","left");
		$this->db->join("purchase_item","purchase_item.no_po = hutang.no_tagihan","left");

		if(!empty($search)){
			$this->db->where("hutang.no_tagihan",$search);
		}

		$this->db->limit($limit,$start);
		$this->db->order_by("hutang.no_tagihan","DESC");
		$this->db->group_by("hutang.no_tagihan");
		return $this->db->get();		
	}

	function infoHutang($no_tagihan){
		$this->db->select(array("hutang.no_tagihan","hutang.status_hutang","users.first_name","supplier.supplier","purchase_order.jatuh_tempo","purchase_order.keterangan","supplier.id_supplier"));
		$this->db->from("hutang");
		$this->db->join("purchase_order","purchase_order.no_po = hutang.no_tagihan","left");
		$this->db->join("users","users.id = purchase_order.id_pic","left");
		$this->db->join("supplier","supplier.id_supplier = purchase_order.id_supplier","left");
		$this->db->where("hutang.no_tagihan",$no_tagihan);
		return $this->db->get()->row();
	}

	function purchaseItem($no_po){
		$this->db->select(array("ap_produk.nama_produk","purchase_item.qty","ap_produk.satuan","purchase_item.harga","(purchase_item.harga*purchase_item.qty) as total","ap_produk.id_produk"));
		$this->db->from("purchase_item");
		$this->db->join("ap_produk","ap_produk.id_produk = purchase_item.sku","left");
		$this->db->where("purchase_item.no_po",$no_po);
		return $this->db->get()->result();
	}

	function purchaseItemMaterial($no_po){
		$this->db->select(array("bahan_baku.nama_bahan as nama_produk","purchase_item.qty","bahan_baku.satuan","purchase_item.harga","(purchase_item.harga*purchase_item.qty) as total","bahan_baku.sku as id_produk"));
		$this->db->from("purchase_item");
		$this->db->join("bahan_baku","bahan_baku.sku = purchase_item.sku","left");
		$this->db->where("purchase_item.no_po",$no_po);
		return $this->db->get()->result();
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

	function returItem($noPO,$sku){
		$this->db->select_sum("qty");
		$this->db->from("retur_item");
		$this->db->join("retur","retur.no_retur = retur_item.no_retur");
		$this->db->where("retur.no_po",$noPO);
		$this->db->where("retur_item.sku",$sku);
		$query = $this->db->get()->row();
		return $query->qty;
	}

	function noPayment(){
		$today = date('Y-m-d');
		$this->db->from("hutang_order");
		$this->db->where("DATE(tanggal_pembayaran)",$today);
		return $this->db->count_all_results();
	}

	function updateStatusHutang($noPO){
		$update_hutang = array(
									"status_hutang" 	=> 1
							  );

		$this->db->where("no_tagihan",$noPO);
		$this->db->update("hutang",$update_hutang);
	}

	function insertDebtPayment($data=array()){
		$this->db->insert("hutang_order",$data);
	}

	function riwayatPembayaran($noPO){
		$this->db->select(array("hutang_order.no_payment","users.first_name as nama_user","payment_type_debt.paymentType","hutang_order.pembayaran"));
		$this->db->from("hutang_order");
		$this->db->join("users","users.id = hutang_order.id_pic","left");
		$this->db->join("payment_type_debt","payment_type_debt.id = hutang_order.id_payment","left");
		$this->db->where("hutang_order.no_po",$noPO);
		return $this->db->get()->result();
	}

	function infoPembayaran($noPayment){
		$this->db->select(array("hutang_order.no_payment","hutang_order.keterangan","hutang_order.no_po","users.first_name as nama_user","payment_type_debt.paymentType","hutang_order.pembayaran"));
		$this->db->from("hutang_order");
		$this->db->join("users","users.id = hutang_order.id_pic","left");
		$this->db->join("payment_type_debt","payment_type_debt.id = hutang_order.id_payment","left");
		$this->db->where("hutang_order.no_payment",$noPayment);
		return $this->db->get()->row();
	}

	function hutangTerbayar($noTagihan){
		$this->db->select_sum("pembayaran");
		$this->db->from("hutang_order");
		$this->db->where("no_po",$noTagihan);
		$query = $this->db->get()->row();
		return $query->pembayaran;
	}

	function tutup_transaksi($no_tagihan,$update_hutang){
		$this->db->where("no_tagihan",$no_tagihan);
		$this->db->update("hutang",$update_hutang);
	}

	function diskonMemberRange($start,$end,$toko){
		$this->db->select_sum("diskon");
		$this->db->from("ap_invoice_number");
		$this->db->where("DATE(ap_invoice_number.tanggal) BETWEEN '$start' AND '$end'");

		if(!empty(($toko))){
			$this->db->where("ap_invoice_number.id_toko",$toko);
		}

		$query = $this->db->get()->result();

		foreach($query as $row){
			return $row->diskon;
		}
	}

	function diskonGlobalRange($start,$end,$toko){
		$this->db->select_sum("diskon_free");
		$this->db->from("ap_invoice_number");
		$this->db->where("DATE(ap_invoice_number.tanggal) BETWEEN '$start' AND '$end'");

		if(!empty($toko)){
			$this->db->where("ap_invoice_number.id_toko",$toko);
		}

		$query = $this->db->get()->result();

		foreach($query as $row){
			return $row->diskon_free;
		}
	}

	function diskonPeritemRange($start,$end,$toko){
		$this->db->select_sum("diskon_otomatis");
		$this->db->from("ap_invoice_number");
		$this->db->where("DATE(ap_invoice_number.tanggal) BETWEEN '$start' AND '$end'");

		if(!empty($toko)){
			$this->db->where("ap_invoice_number.id_toko",$toko);
		}

		$query = $this->db->get()->result();

		foreach($query as $row){
			return $row->diskon_otomatis;
		}
	}

	function poinReimbursRange($start,$end,$toko){
		$this->db->select_sum("poin_value");
		$this->db->from("ap_invoice_number");

		if(!empty($toko)){
			$this->db->where("ap_invoice_number.id_toko",$toko);
		}

		$this->db->where("DATE(ap_invoice_number.tanggal) BETWEEN '$start' AND '$end'");
		$query = $this->db->get()->result();

		foreach($query as $row){
			return $row->poin_value;
		}		
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

	function dataReceive($noReceive){
		$this->db->select(array("receive_order.no_receive","receive_order.no_po","receive_order.tanggal_terima","receive_order.received_by","receive_order.checked_by","supplier.supplier","receive_order.diterimaDi"));
		$this->db->from("receive_order");
		$this->db->join("purchase_order","purchase_order.no_po = receive_order.no_po");
		$this->db->join("supplier","supplier.id_supplier = purchase_order.id_supplier","right");
		$this->db->where("receive_order.no_receive",$noReceive);
		return $this->db->get()->result();
	}

}