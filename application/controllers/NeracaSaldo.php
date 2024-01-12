<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class NeracaSaldo extends BaseController{
	function __construct(){
		parent::__construct();
		$this->load->model("modelNeracaSaldo");
		$this->isLoggedIn($this->global['idUser'],2,27);
    }

    function index(){
		$this->global['pageTitle'] = "SIMRS - Neraca Saldo";
		$data['akun'] = $this->modelNeracaSaldo->viewAkun();
		$this->loadViews("keuangan/neraca/bodyNeraca",$this->global,$data,"keuangan/neraca/footerNeraca");
    }

	function viewNeraca(){
		$bulan = $this->input->post("bulan");
		$tahun = $this->input->post("tahun");

		$data['header'] = $this->db->get_where("kl_klinikinfo",array("id" => 1))->row();
		$data['akun'] = $this->modelNeracaSaldo->viewNeracaSaldo($bulan,$tahun);

		$bulanConvert = array(
			"01" => "Januari",
			"02" => "Februari",
			"03" => "Maret",
			"04" => "April",
			"05" => "Mei",
			"06" => "Juni",
			"07" => "Juli",
			"08" => "Agustus",
			"09" => "September",
			"10" => "Oktober",
			"11" => "November",
			"12" => "Desember"
		);

		$data['periode'] = $bulanConvert[$bulan]." ".$tahun;
		$this->load->view("keuangan/neraca/viewNeraca",$data);
	}
}