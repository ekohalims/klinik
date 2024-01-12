<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class LaporanPerubahanModal extends BaseController{
	function __construct(){
		parent::__construct();
		$this->load->model("modelLaporanPerubahanModal");
		$this->isLoggedIn($this->global['idUser'],2,41);
    }

    function index(){
        $this->global['pageTitle'] = "SIMRS - Laporan Perubahan Modal";
		$this->loadViews("keuangan/laporanperubahanmodal/bodyLaporanPerubahanModal",$this->global,NULL,"keuangan/laporanperubahanmodal/footerLaporanPerubahanModal");
    }

    function viewLaporan(){
        $data['header'] = $this->db->get_where("kl_klinikinfo",array("id" => 1))->row();

        $bulan = $this->input->post("bulan");
        $tahun = $this->input->post("tahun");

        
        $totalPendapatan = $this->modelLaporanPerubahanModal->totalPendapatan($bulan,$tahun);
        $totalBeban = $this->modelLaporanPerubahanModal->totalBeban($bulan,$tahun);
        
        $this->load->model("modelLabaRugi");


        $hpp = $this->modelLaporanPerubahanModal->totalHPP($bulan,$tahun);
        $data['modal'] = $this->modelLaporanPerubahanModal->totalModal($bulan,$tahun);
        $data['labaBersih'] = $totalPendapatan-$totalBeban-$hpp;
        $data['prive'] = $this->modelLaporanPerubahanModal->totalPrive($bulan,$tahun);
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
        $this->load->view("keuangan/laporanperubahanmodal/viewLaporan",$data);
    }
}