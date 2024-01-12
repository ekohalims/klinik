<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class ModelKartuStok extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->load->database();
    }

    function viewData($dateStart,$dateEnd,$item){
        $this->db->select(array("kartu_stok.noRefference","kartu_stok.currentStok","kartu_stok.barangMasuk","kartu_stok.barangKeluar","kartu_stok.jenisTrx","kartu_stok.tanggal","kartu_stok.hargaSatuan","kl_pasien.namaLengkap","supplier.supplier","kartu_stok.tanggalExpired"));
        $this->db->from("kartu_stok");
        $this->db->join("kl_pasien","kl_pasien.noPasien = kartu_stok.pasien","left");
        $this->db->join("supplier","supplier.id_supplier = kartu_stok.supplier","left");
        $this->db->where("type","GUDANG");
        $this->db->where("idProduk",$item);
        $this->db->where("tanggal BETWEEN '$dateStart' AND '$dateEnd'");
        return $this->db->get()->result();
    }

    function stokAwal($dateStart,$dateEnd,$item){
        $this->db->select("currentStok");
        $this->db->from("kartu_stok");
        $this->db->where("type","GUDANG");
        $this->db->where("idProduk",$item);
        $this->db->where("tanggal BETWEEN '$dateStart' AND '$dateEnd'");
        $query = $this->db->get()->row();
        return $query;
    }   

    function viewDataAkumulasi($dateStart,$dateEnd){
        $query = "SELECT kartu_stok.idProduk,ap_produk.nama_produk, kartu_stok.currentStok,SUM(kartu_stok.barangMasuk*kartu_stok.hargaSatuan) as rpMasuk, SUM(kartu_stok.barangKeluar*kartu_stok.hargaSatuan) as rpKeluar,
                         SUM(CASE WHEN kartu_stok.jenisTrx='PENERIMAAN' THEN kartu_stok.barangMasuk ELSE 0 END ) totalBarangMasuk,
                         SUM(CASE WHEN kartu_stok.jenisTrx='STOKAWAL' THEN kartu_stok.barangMasuk ELSE 0 END ) totalStokAwal,
                         SUM(CASE WHEN kartu_stok.jenisTrx='PENJUALAN' THEN kartu_stok.barangKeluar ELSE 0 END) totalBarangKeluar,
                         SUM(CASE WHEN kartu_stok.jenisTrx='RETUR' THEN kartu_stok.barangKeluar ELSE 0 END) totalRetur,
                         SUM(CASE WHEN kartu_stok.jenisTrx='WASTE' THEN kartu_stok.barangKeluar ELSE 0 END) totalWaste,
                         SUM(CASE WHEN kartu_stok.jenisTrx='RETURSTORE' THEN kartu_stok.barangMasuk ELSE 0 END) totalReturStore,
                         SUM(CASE WHEN kartu_stok.jenisTrx='STOCKOPNAME' THEN kartu_stok.barangMasuk ELSE 0 END) SOPlus,
                         SUM(CASE WHEN kartu_stok.jenisTrx='STOCKOPNAME' THEN kartu_stok.barangKeluar ELSE 0 END) SOMin
                  FROM kartu_stok
                LEFT JOIN ap_produk ON ap_produk.id_produk = kartu_stok.idProduk
                WHERE kartu_stok.tanggal BETWEEN '$dateStart' AND '$dateEnd'
                GROUP BY kartu_stok.idProduk
                  ";
        return $this->db->query($query);
    }

    function viewDataTokoPeritem($dateStart,$dateEnd,$item,$idStore){
        $this->db->select(array("kartu_stok_toko.noRefference","kartu_stok_toko.currentStok","kartu_stok_toko.barangMasuk","kartu_stok_toko.barangKeluar","kartu_stok_toko.jenisTrx","kartu_stok_toko.tanggal"));
        $this->db->from("kartu_stok_toko");
        $this->db->where("idStore",$idStore);
        $this->db->where("idProduk",$item);
        $this->db->where("tanggal BETWEEN '$dateStart' AND '$dateEnd'");
        return $this->db->get()->result();
    }

    function stokAwalToko($dateStart,$dateEnd,$item,$idStore){
        $this->db->select("currentStok");
        $this->db->from("kartu_stok_toko");
        $this->db->where("idStore",$idStore);
        $this->db->where("idProduk",$item);
        $this->db->where("tanggal BETWEEN '$dateStart' AND '$dateEnd'");
        $query = $this->db->get()->row();
        return $query;
    }   

    function viewDataAkumulasiToko($dateStart,$dateEnd,$idStore){
        $query = "SELECT kartu_stok_toko.idProduk,ap_produk.nama_produk, kartu_stok_toko.currentStok,
                         SUM(CASE WHEN kartu_stok_toko.jenisTrx='MUTASI' THEN kartu_stok_toko.barangMasuk ELSE 0 END ) totalBarangMasuk,
                         SUM(CASE WHEN kartu_stok_toko.jenisTrx='PENJUALAN' THEN kartu_stok_toko.barangKeluar ELSE 0 END) totalBarangKeluar,
                         SUM(CASE WHEN kartu_stok_toko.jenisTrx='RETURSTORE' THEN kartu_stok_toko.barangKeluar ELSE 0 END) totalRetur
                  FROM kartu_stok_toko
                LEFT JOIN ap_produk ON ap_produk.id_produk = kartu_stok_toko.idProduk
                WHERE kartu_stok_toko.tanggal BETWEEN '$dateStart' AND '$dateEnd' AND  kartu_stok_toko.idStore='$idStore'
                GROUP BY kartu_stok_toko.idProduk
                  ";
        return $this->db->query($query);
    }
}   