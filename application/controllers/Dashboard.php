<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Dashboard extends BaseController{
	function __construct(){
		parent::__construct();
		$this->load->model("modelDashboard");
		$this->isLoggedIn($this->global['idUser'],1,1);
	}

	function index(){
		$this->global['pageTitle'] = "SIMRS - Dashboard";
		$this->loadViews("dashboard/bodyDashboard",$this->global,NULL,"dashboard/footerDashboard");
	}

	function buttonFilter(){
		$this->load->view("dashboard/buttonFilter");
	}

	function dateFilterForm(){
		$data['type'] = $this->input->post("type");
		$this->load->view("dashboard/dateFilterForm",$data);
	}

	function dataWidget(){
		$type = $this->input->post("type");
		$tanggal = $this->input->post("tanggal");
		$bulan =  $this->input->post("bulan");
		$tahun = $this->input->post("tahun");

		$jumlahPasien = $this->modelDashboard->jumlahPasien($type,$tanggal,$bulan,$tahun);
		$menungguPembayaran = $this->modelDashboard->menungguPembayaran($type,$tanggal,$bulan,$tahun);
		$permintaanLab = $this->modelDashboard->permintaanLab($type,$tanggal,$bulan,$tahun);
		$permintaanRad = $this->modelDashboard->permintaanRad($type,$tanggal,$bulan,$tahun);

		$dataJSON[] = array(
			"jumlahPasien" => $jumlahPasien,
			"menungguPembayaran" => $menungguPembayaran,
			"permintaanLab" => $permintaanLab,
			"permintaanRad" => $permintaanRad
		);

		echo json_encode($dataJSON);
	}

	function pasienByAge(){
		$type = $this->input->post("type");
		$tanggal = $this->input->post("tanggal");
		$bulan =  $this->input->post("bulan");
		$tahun = $this->input->post("tahun");

		$dataUmur = $this->modelDashboard->dataUmur($type,$tanggal,$bulan,$tahun);

		foreach($dataUmur->result() as $row){
			$ageGroup[] = $row->ageGroup;
			$ageCount[] = $row->ageCount;
		}

		$numRows = $dataUmur->num_rows();

		if($numRows > 0){
			$data['ageGroup'] = json_encode($ageGroup);
		$data['ageCount'] = json_encode($ageCount);
			$this->load->view("dashboard/pasienByAge",$data);
		} else {
			$this->load->view("dashboard/noDataWidget");
		}
	}

	function pasienByGender(){
		$type = $this->input->post("type");
		$tanggal = $this->input->post("tanggal");
		$bulan =  $this->input->post("bulan");
		$tahun = $this->input->post("tahun");

		$dataGender = $this->modelDashboard->pasienByGender($type,$tanggal,$bulan,$tahun);
		
		foreach($dataGender->result() as $row){
			$label[] = $row->jenisKelamin;
			$dataJk[] = $row->jumlah;
		}

		$numRows = $dataGender->num_rows();

		if($numRows > 0){
			$data['label'] = json_encode($label);
			$data['dataJk'] = json_encode($dataJk);
			$this->load->view("dashboard/pasienByGender",$data);
		} else {
			$this->load->view("dashboard/noDataWidget");
		}
	}

	function diagnosaPasien(){
		$type = $this->input->post("type");
		$tanggal = $this->input->post("tanggal");
		$bulan =  $this->input->post("bulan");
		$tahun = $this->input->post("tahun");

		$dataDiagnosaPasien = $this->modelDashboard->dataDiagnosaPasien($type,$tanggal,$bulan,$tahun);

		foreach($dataDiagnosaPasien->result() as $row){
			$label[] = $row->CODE;
			$dataDiag[] = $row->jumlah;
		}

		$numRows = $dataDiagnosaPasien->num_rows();

		if($numRows > 0){
			$data['label'] = json_encode($label);
			$data['value'] = json_encode($dataDiag);
			$this->load->view("dashboard/diagnosaPasien",$data);
		} else {
			$this->load->view("dashboard/noDataWidget");
		}
	}

	function pasienVisit(){
		$type = $this->input->post("type");
		$tanggal = $this->input->post("tanggal");
		$bulan =  $this->input->post("bulan");
		$tahun = $this->input->post("tahun");

		$dataKunjunganPasien = $this->modelDashboard->dataKunjunganPasien($type,$tanggal,$bulan,$tahun);

		foreach($dataKunjunganPasien->result() as $row){
			$label[] = $row->tanggalDaftar;
			$dataVisit[] = $row->jumlah;
		}

		$numRows = $dataKunjunganPasien->num_rows();

		if($numRows > 0){
			$data['label'] = json_encode($label);
			$data['value'] = json_encode($dataVisit);
			$this->load->view("dashboard/pasienVisit",$data);
		} else {
			$this->load->view("dashboard/noDataWidget");
		}
	}

	function hitungUmur($tanggal_lahir) {
	    list($year,$month,$day) = explode("-",$tanggal_lahir);
	    $year_diff  = date("Y") - $year;
	    $month_diff = date("m") - $month;
	    $day_diff   = date("d") - $day;
	    if ($month_diff < 0) $year_diff--;
	        elseif (($month_diff==0) && ($day_diff < 0)) $year_diff--;
	    return $year_diff;
	}

	function titlePeriode(){
		$type = $this->input->post("type");
		$tanggal = $this->input->post("tanggal");
		$bulan =  $this->input->post("bulan");
		$tahun = $this->input->post("tahun");

		$bulanArray = array(
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
			"11" => "Nopember",
			"12" => "Desember"
		);

		if($type=='day'){
			$periode = date_format(date_create($tanggal),'d F Y');
		} elseif($type=='month'){
			$month = $bulanArray[$bulan];
			$periode = $month." ".$tahun;
		} elseif($type=='year'){
			$periode = $tahun;
		} else {
			$thisMonth = date('m');
			$month = $bulanArray[$thisMonth];
			$periode = $month." ".date('Y');
		}

		echo $periode;
	}
}