<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Invoice extends BaseController{
	function __construct(){
		parent::__construct();
		$this->load->model("modelKasir");
		$this->isLoggedIn($this->global['idUser'],2,67);
    }

    function index(){
        $this->global['pageTitle'] = "SIMRS - Invoice";
        $data['setting'] = $this->db->get_where("setting",array("id" => 3))->row()->setting;
		$this->loadViews("setting/bodyInvoice",$this->global,$data,"setting/footerInvoice",$data);
    }

    function simpan(){
        $jenis = $this->input->post("jenis");
        
        $dataUpdate = array(
            "setting" => $jenis
        );

        $this->db->where("id",3);
        $this->db->update("setting",$dataUpdate);
        redirect("invoice");
    }
}