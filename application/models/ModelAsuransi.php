<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class ModelAsuransi extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->load->database();
    }

    function insertDataAsuransi($dataAsuransi){
        $this->db->insert("kl_asuransi",$dataAsuransi);
    }

    function updateDataAsuransi($dataAsuransi,$idAsuransi){
        $this->db->where("idAsuransi",$idAsuransi);
        $this->db->update("kl_asuransi",$dataAsuransi);
    }

    function hapusDataAsuransi($idAsuransi){
        $dataArray = array(
            "isDelete" => 0
        );

        $this->db->where("idAsuransi",$idAsuransi);
        $this->db->update("kl_asuransi",$dataArray);
    }
}