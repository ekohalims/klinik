<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class LabaRugi extends BaseController{
	function __construct(){
		parent::__construct();
		$this->load->model("modelLabaRugi");
		$this->isLoggedIn($this->global['idUser'],2,29);
    }

    function index(){
        $this->global['pageTitle'] = "SIMRS - Laba Rugi";
		$this->loadViews("keuangan/labarugi/bodyLabaRugi",$this->global,NULL,"keuangan/labarugi/footerLabaRugi");
    }

    function viewLabaRugi(){
        $data['header'] = $this->db->get_where("kl_klinikinfo",array("id" => 1))->row();

        $bulan = $this->input->post("bulan");
        $tahun = $this->input->post("tahun");

        $data['pendapatanUsaha'] = $this->modelLabaRugi->viewPendapatanUsaha($bulan,$tahun);
        $data['beban'] = $this->modelLabaRugi->viewBeban($bulan,$tahun);
        $data['persediaanAkhir'] = $this->modelLabaRugi->persediaanAkhir($bulan,$tahun);
        $data['totalRetur'] = $this->modelLabaRugi->totalRetur($bulan,$tahun);
        $data['totalHPP'] = $this->modelLabaRugi->totalHPP($bulan,$tahun);
        $data['persediaanAwal'] = $this->modelLabaRugi->persediaanAwal($bulan,$tahun);

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

        $this->load->view("keuangan/labarugi/viewLabaRugi",$data);
    }
}