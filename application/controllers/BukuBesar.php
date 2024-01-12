<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class BukuBesar extends BaseController{
	function __construct(){
		parent::__construct();
		$this->load->model("modelBukuBesar");
		$this->isLoggedIn($this->global['idUser'],2,28);
    }

    function index(){
        $this->global['pageTitle'] = "SIMRS - Buku Besar";
        $data['viewAkun'] = $this->db->get_where("coa_sub",array("status" => 1,"isDelete" => 1))->result();
		$this->loadViews("keuangan/bukubesar/bodyBukuBesar",$this->global,$data,"keuangan/bukubesar/footerBukuBesar");
    }

    function viewBukuBesar(){
        $dateStart = $this->input->post("dateStart");
        $dateEnd = $this->input->post("dateEnd");
        $akun = $this->input->post("akun");
		$data['dateStart'] = $dateStart;
		$data['dateEnd'] = $dateEnd;
		$data['header'] = $this->db->get_where("kl_klinikinfo",array("id" => 1))->row();
		$data['periode'] = date_format(date_create($dateStart),'d M Y')." - ".date_format(date_create($dateEnd),'d M Y');
        $data['kodeAkun'] = $akun;
        $data['namaAkun'] = $this->db->get_where("coa_sub",array("kodeSubAkun" => $akun))->row()->namaSubAkun;
        
        $data['viewBukuBesar'] = $this->modelBukuBesar->viewBukuBesar($dateStart,$dateEnd,$akun);
        $this->load->view("keuangan/bukubesar/viewBukuBesar",$data);
    }

}