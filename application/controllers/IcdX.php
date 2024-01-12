<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';

class IcdX extends BaseController{
	function __construct(){
		parent::__construct();
		$this->load->model("modelInputTindakan");
		$this->isLoggedIn($this->global['idUser'],2,59);
    }

    function index(){
        $this->global['pageTitle'] = "SIMRS - ICD X";
		$this->loadViews("masterdata/icd/body",$this->global,NULL,"masterdata/icd/footer");
    }
}