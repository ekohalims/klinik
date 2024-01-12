<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class ModelPembayaranHutang extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->load->database();
    }

    function totalHutang(){
        $this->db->from("hutang");
        $this->db->where("status_hutang",0);
        $this->db->or_where("status_hutang",1);
        return $this->db->count_all_results();
    }

    function viewDaftarHutang($limit,$start,$search){
        $query  = "SELECT hutang.no_tagihan,supplier.supplier,purchase_order.tanggal_po,purchase_order.jatuh_tempo,totalHutang,totalRetur,terbayar
            FROM hutang
            LEFT JOIN purchase_order ON purchase_order.no_po = hutang.no_tagihan
            LEFT JOIN supplier ON supplier.id_supplier = purchase_order.id_supplier
            LEFT JOIN (SELECT SUM(receive_item.price*receive_item.qty) as totalHutang,receive_order.no_po,receive_item.no_receive
                       FROM receive_item
                       LEFT JOIN receive_order ON receive_order.no_receive = receive_item.no_receive
                       GROUP BY receive_order.no_po,receive_item.no_receive) 
                       as receiveItemJoin ON receiveItemJoin.no_po = purchase_order.no_po
            LEFT JOIN (SELECT SUM(retur_item.harga*retur_item.qty) as totalRetur, retur_item.no_retur,retur.no_po
                       FROM retur_item
                       LEFT JOIN retur ON retur.no_retur = retur_item.no_retur
                       GROUP BY retur_item.no_retur,retur.no_po)
                       as returItemJoin ON returItemJoin.no_po = purchase_order.no_po
            LEFT JOIN (SELECT SUM(hutang_order.pembayaran) as terbayar,hutang_order.no_po
                       FROM hutang_order 
                       GROUP BY hutang_order.no_po) 
                       as hutangOrderJoin ON hutangOrderJoin.no_po = purchase_order.no_po";
        
        $query .= " WHERE hutang.status_hutang != 2";

        if(!empty($search)){
            $query .=  " AND hutang.no_tagihan LIKE '%$search%'";
        }

        $query .= " GROUP BY hutang.no_tagihan,supplier.supplier,purchase_order.tanggal_po,purchase_order.jatuh_tempo,totalHutang,totalRetur,terbayar
                   LIMIT $start,$limit";
        return $this->db->query($query);
    }

    function headerTagihan($noTagihan){
        $this->db->select(array("hutang.no_tagihan","hutang.status_hutang","users.first_name","supplier.supplier","purchase_order.jatuh_tempo","purchase_order.keterangan"));
        $this->db->from("hutang");
        $this->db->join("purchase_order","purchase_order.no_po = hutang.no_tagihan");
        $this->db->join("supplier","supplier.id_supplier = purchase_order.id_supplier");
        $this->db->join("users",'users.id = purchase_order.id_pic');
        $this->db->where("hutang.no_tagihan",$noTagihan);
        $this->db->group_by("hutang.no_tagihan");
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
    
    function hutangTerbayar($noTagihan){
		$this->db->select_sum("pembayaran");
		$this->db->from("hutang_order");
		$this->db->where("no_po",$noTagihan);
		$query = $this->db->get()->row();
		return $query->pembayaran;
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
        $month = date('m');
        $year = date('Y');
        
		$this->db->from("hutang_order");
		$this->db->where("MONTH(tanggal_pembayaran)",$month);
		$this->db->where("YEAR(tanggal_pembayaran)",$year);
		return $this->db->count_all_results();
    }
    
    function insertPembayaran($dataArray){
        $this->db->insert("hutang_order",$dataArray);
        return $this->db->affected_rows();
    }

    function totalBarangDiterima($noTagihan){
        $this->db->select("SUM(receive_item.qty*receive_item.price) as total");
        $this->db->from("receive_item");
        $this->db->join("receive_order","receive_order.no_receive = receive_item.no_receive");
        $this->db->where("receive_order.no_po",$noTagihan);
        $this->db->group_by("receive_order.no_po");
        $query = $this->db->get()->result();
        foreach($query as $row){
            return $row->total;
        }
    }

    function totalRetur($noTagihan){
        $this->db->select("SUM(retur_item.qty*retur_item.harga) as total");
        $this->db->from("retur_item");
        $this->db->join("retur","retur.no_retur = retur_item.no_retur");
        $this->db->where("retur.no_po",$noTagihan);
        $this->db->group_by("retur.no_po");
        $query = $this->db->get()->result();
        foreach($query as $row){
            return $row->total;
        }
    }

    function riwayatPembayaran($noTagihan){
        $this->db->select(array("hutang_order.no_payment","users.first_name","payment_type_debt.paymentType","hutang_order.tanggal_pembayaran","hutang_order.pembayaran"));
        $this->db->from("hutang_order");
        $this->db->join("users","users.id = hutang_order.id_pic");
        $this->db->join("payment_type_debt","payment_type_debt.id = hutang_order.id_payment");
        $this->db->where("hutang_order.no_po",$noTagihan);
        return $this->db->get();       
    }

    function updateStatusPembayaran($noTagihan,$status){
        $dataUpdate = array(
            "status_hutang" => $status
        );

        $this->db->where("no_tagihan",$noTagihan);
        $this->db->update("hutang",$dataUpdate);
    }

    function riwayatPenerimaan($noTagihan){
        $this->db->select(array("receive_order.no_receive","users.first_name","receive_order.tanggal_terima","receive_order.diterimaDi"));
        $this->db->from("receive_order");
        $this->db->join("users","users.id = receive_order.id_pic");
        $this->db->where("receive_order.no_po",$noTagihan);
        return $this->db->get();
    }

    function updateJatuhTempo($dataUpdate,$noTagihan){
        $this->db->where("no_po",$noTagihan);
        $this->db->update("purchase_order",$dataUpdate);
    }

    function formAkunBayar($kodeAkun){
        $this->db->select(array('coa_sub.kodeSubAkun','coa_sub.namaSubAkun'));
        $this->db->from("coa_sub");
        $this->db->where("kodeAkun",$kodeAkun);
        $this->db->where("isDelete",1);
        $this->db->where("status",1);
        return $this->db->get()->result();
    }
}