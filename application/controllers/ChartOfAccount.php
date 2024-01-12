<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class ChartOfAccount extends BaseController{
	function __construct(){
		parent::__construct();
		$this->load->model("modelCoa");
		$this->isLoggedIn($this->global['idUser'],2,34);
    }

    function index(){
        $this->global['pageTitle'] = "SIMRS - Chart of Account";
		$this->loadViews("keuangan/coa/bodyCoa",$this->global,NULL,"keuangan/coa/footerCoa");
    }

    function viewCoa(){
        $data['coa'] = $this->db->get("coa")->result();
        $data['header'] = $this->db->get("coa_header")->result();
        $this->load->view("keuangan/coa/viewCoa",$data);
    }

    function formTambahAccount(){
        $data['coa'] = $this->db->get("coa")->result();
        $this->load->view("keuangan/coa/formTambahAccount",$data);
    }

    function simpanAkun(){
        $namaAkun = $this->input->post("namaAkun");
        $kategori = $this->input->post("kategori");
        $keterangan = $this->input->post("keterangan");

        $urutanAkun = $this->modelCoa->urutanAkun($kategori);
        $kodeAkun = $kategori.sprintf('%02d',$urutanAkun+1);

        $dataArray = array(
            "kodeSubAkun" => $kodeAkun,
            "kodeAkun" => $kategori,
            "namaSubAkun" => $namaAkun,
            "keterangan" => $keterangan,
            "status" => 1,
            "isDelete" => 1,
            "locked" => 0
        );

        $this->modelCoa->simpanCoa($dataArray);
    }

    function simpanAkunBank(){
        $namaAkun = $this->input->post("namaAkun");
        $kategori = $this->input->post("kategori");
        $keterangan = $this->input->post("keterangan");

        $urutanAkun = $this->modelCoa->urutanAkun($kategori);
        $kodeAkun = $kategori.sprintf('%02d',$urutanAkun+1);

        $dataArray = array(
            "kodeSubAkun" => $kodeAkun,
            "kodeAkun" => $kategori,
            "namaSubAkun" => $namaAkun,
            "keterangan" => $keterangan,
            "status" => 1,
            "isDelete" => 1,
            "locked" => 0
        );

        $this->modelCoa->simpanCoa($dataArray);

        $cabang = $this->input->post("cabang");
        $noRekening = $this->input->post("noRekening");
        $atasNama = $this->input->post("atasNama");

        $dataBank = array(
            "kodeBank" => $kodeAkun,
            "cabang" => $cabang,
            "noRekening" => $noRekening,
            "atasNama" => $atasNama
        );

        $this->modelCoa->simpanDataBank($dataBank);
    }

    function editAkun(){
        $kodeAkun = $this->input->post("kodeAkun");
        $namaAkun = $this->input->post("namaAkun");
        $keterangan = $this->input->post("keterangan");

        $dataUpdate = array(
            "namaSubAkun" => $namaAkun,
            "keterangan" => $keterangan
        );

        $this->modelCoa->updateCoa($kodeAkun,$dataUpdate);
    }

    function cekKodeIfExist(){
        $kodeAkun = $this->input->post("kodeAkun");
        $cekKodeAkun = $this->modelCoa->cekKodeAkun($kodeAkun);
        echo $cekKodeAkun;
    }

    function formEditAccount(){
        $data['currentCoa'] = $this->db->get_where("coa_sub",array("kodeSubAkun" => $this->input->post("kodeAkun")))->row();
        $this->load->view("keuangan/coa/formEditAccount",$data);
    }

    function hapusCoa(){
        $kodeAkun = $this->input->post("kodeAkun");
        $this->modelCoa->hapusCoa($kodeAkun);
    }

    function formBank(){
        $this->load->view("keuangan/coa/formBank");
    }
}