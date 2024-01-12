<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Jurnal extends BaseController{
	function __construct(){
		parent::__construct();
		$this->load->model("modelJurnal");
		$this->isLoggedIn($this->global['idUser'],2,33);
    }
    
    function index(){
        $this->global['pageTitle'] = "SIMRS - Jurnal";
		$this->loadViews("keuangan/jurnal/bodyJurnal",$this->global,NULL,"keuangan/jurnal/footerJurnal");
    }

    function viewJurnal(){
        $dateStart = $this->input->post("dateStart");
        $dateEnd = $this->input->post("dateEnd");
        $data['viewJurnal'] = $this->modelJurnal->viewJurnal($dateStart,$dateEnd);
        $data['dateStart'] = $dateStart;
		$data['dateEnd'] = $dateEnd;
		$data['header'] = $this->db->get_where("kl_klinikinfo",array("id" => 1))->row();
		$data['periode'] = date_format(date_create($dateStart),'d M Y')." - ".date_format(date_create($dateEnd),'d M Y');
        $this->load->view("keuangan/jurnal/viewJurnal",$data);
    }
}