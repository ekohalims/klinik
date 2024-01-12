<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Neraca extends BaseController{
	function __construct(){
		parent::__construct();
		$this->load->model("modelNeracaSaldo");
		$this->isLoggedIn($this->global['idUser'],2,40);
    }

    function index(){
        $this->global['pageTitle'] = "SIMRS - Neraca";
		$data['header'] = $this->db->get_where("kl_klinikinfo",array("id" => 1))->row();
        $this->loadViews("keuangan/neracaumum/bodyNeraca",$this->global,NULL,"keuangan/neracaumum/footerNeraca");
    }
    
    function viewNeraca(){
        $data['header'] = $this->db->get_where("kl_klinikinfo",array("id" => 1))->row();
        $bulan = $this->input->post("bulan");
		$tahun = $this->input->post("tahun");
        $this->load->model("modelLaporanPerubahanModal");
        $this->load->model("modelLabaRugi");

		$data['hartaLancar'] = $this->modelNeracaSaldo->hartaLancarNeraca($bulan,$tahun);
        $data['asetTetap'] = $this->modelNeracaSaldo->asetTetap($bulan,$tahun);
        $data['kewajiban'] = $this->modelNeracaSaldo->kewajibanNeraca($bulan,$tahun);
        $data['historicalBalancing'] = $this->modelNeracaSaldo->historicalBalancing($bulan,$tahun);

        $modal = $this->modelLaporanPerubahanModal->totalModal($bulan,$tahun);
        $totalPendapatan = $this->modelLaporanPerubahanModal->totalPendapatan($bulan,$tahun);
        $totalBeban = $this->modelLaporanPerubahanModal->totalBeban($bulan,$tahun);
        $hpp = $this->modelLaporanPerubahanModal->totalHPP($bulan,$tahun);
        $prive = $this->modelLaporanPerubahanModal->totalPrive($bulan,$tahun);

        $pendapatanBersih = $totalPendapatan-$totalBeban-$hpp;
        $data['modalAkhir'] = $modal+$pendapatanBersih-$prive;
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
		$this->load->view("keuangan/neracaumum/viewNeraca",$data);
    }
}