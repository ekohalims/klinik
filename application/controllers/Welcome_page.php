<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Welcome_page extends BaseController{
	function __construct(){
		parent::__construct();
	}

	function index(){
		$this->global['pageTitle'] = "SIMRS";
		$this->loadViews("bodyWelcome",$this->global,NULL,"footer_empty");
	}

}