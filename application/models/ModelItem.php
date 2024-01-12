<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class ModelItem extends CI_Model{
	function viewItem($limit,$start,$search){
        $this->db->select("*");
        $this->db->from("ap_produk");
        $this->db->join("ap_kategori","ap_kategori.id_kategori = ap_produk.id_kategori","left");

        if(!empty($search)){
            $this->db->like("ap_produk.id_produk",$search);
            $this->db->or_like("ap_produk.nama_produk",$search);
        }

        $this->db->limit($limit,$start);
        return $this->db->get();
    }
}