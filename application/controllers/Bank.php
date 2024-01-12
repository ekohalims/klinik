<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Bank extends BaseController{
	function __construct(){
		parent::__construct();
		$this->isLoggedIn($this->global['idUser'],2,38);
    }

    function index(){
        $this->global['pageTitle'] = "SIMRS - Daftar Bank";
		$this->loadViews("masterdata/bank/bodyBank",$this->global,NULL,"masterdata/bank/footerBank");
    }

	function viewDataBank(){
		$data['viewBank'] = $this->modelPublic->viewBank();
		$this->load->view("masterdata/bank/dataBank",$data);
	}

	function formTambahBank(){
		$urutanKode = $this->modelPublic->kodeBank();
		$data['kodeBank'] = '12'.sprintf('%02d',$urutanKode+1);
		$this->load->view("masterdata/bank/formTambahBank",$data);
	}

	function tambahBankSQL(){
		$urutanKode = $this->modelPublic->kodeBank();

		$kodeAkun = '12'.sprintf('%02d',$urutanKode+1);
		$namaBank = $this->input->post("namaBank");
		$cabang = $this->input->post("cabang");
		$noRekening = $this->input->post("noRekening");
		$atasNama = $this->input->post("atasNama");
		$debit = $this->input->post("debit");
		$kredit = $this->input->post("kredit");
		$transfer = $this->input->post("transfer");

		$dataArray = array(
			"kodeBank" => $kodeAkun,
			"cabang" => $cabang,
			"noRekening" => $noRekening,
			"atasNama" => $atasNama,
			"debit" => $debit,
			"kredit" => $kredit,
			"transfer" => $transfer
		);

		$this->modelPublic->tambahBankSQL($dataArray);

		//tambah ke akun coa
		$dataCoa = array(
			"kodeSubAkun" => $kodeAkun,
			"kodeAkun" => 12,
			"namaSubAkun" => $namaBank,
			"keterangan" => '',
			"tglSaldoAwal" => '',
			"status" => 1,
			"isDelete" => 1,
			"locked" => 0,
			"saldo" => 1
		);

		$this->modelPublic->insertBankAccount($dataCoa);
	}

	function formEditBank(){
		$kodeAkun = $this->input->post("id");
		$data['bank'] = $this->modelPublic->getDataBank($kodeAkun);
		$data['kodeAkun'] = $this->enkripsi($this->db->get_where("bank",array("kodeBank" => $kodeAkun))->row()->kodeBank);
		$this->load->view("masterdata/bank/formEditBank",$data);
	}

	function editBankSQL(){
		$kodeAkun = $this->dekripsi($this->input->post("kodeAkun"));
		$namaBank = $this->input->post("namaBank");
		$cabang = $this->input->post("cabang");
		$noRekening = $this->input->post("noRekening");
		$atasNama = $this->input->post("atasNama");
		$status = $this->input->post("status");
		$debit = $this->input->post("debit");
		$kredit = $this->input->post("kredit");
		$transfer = $this->input->post("transfer");

		$dataArray = array(
			"cabang" => $cabang,
			"noRekening" => $noRekening,
			"atasNama" => $atasNama,
			"debit" => $debit,
			"kredit" => $kredit,
			"transfer" => $transfer
		);

		$this->modelPublic->editBankSQL($dataArray,$kodeAkun);

		$dataBank = array(
			"namaSubAkun" => $namaBank,
			"status" => $status
		);

		$this->modelPublic->editBankAccount($dataBank,$kodeAkun);
	}

	function hapusBank(){
		$kodeAkun = $this->dekripsi($this->input->post("kodeBank"));
		$this->modelPublic->hapusBank($kodeAkun);
	}
}