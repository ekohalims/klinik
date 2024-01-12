<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class TutupKasir extends BaseController{
	function __construct(){
		parent::__construct();
		$this->load->model("modelKasir");
		$this->isLoggedIn($this->global['idUser'],2,32);
    }

    function index(){
        $this->global['pageTitle'] = "SIMRS - Tutup Kasir";
		$this->loadViews("keuangan/tutupkasir/bodyTutupKasir",$this->global,NULL,"keuangan/tutupkasir/footerTutupKasir");
    }

    function viewKasir(){
        $tanggal = $this->input->post("date");
        $data['pemasukan'] = $this->modelKasir->pemasukanPerkasir($tanggal);
        $data['tanggal'] = $tanggal;
        $this->load->view("keuangan/tutupkasir/viewKasir",$data);
    }

    function formClosing(){
        $this->global['pageTitle'] = "SIMRS - Form Closing";
        $this->loadViews("keuangan/tutupkasir/formClosing",$this->global,NULL,"keuangan/tutupkasir/footerFormClosing");
    }

    function contentClosing(){
        $idKasir = $this->input->post("idKasir");
        $tanggal = $this->input->post("tanggal");

        $data['debit'] = $this->modelKasir->dataBank('debit');
        $data['kredit'] = $this->modelKasir->dataBank('kredit');
        $data['idKasir'] = $idKasir;
        $data['tanggal'] = $tanggal;
        $data['namaKasir'] = $this->db->get_where("users",array("id" => $idKasir))->row();

        //cek closing belum
        $cekClosing = $this->modelKasir->cekClosingIfExist($idKasir,$tanggal);

        if($cekClosing < 1){
            $this->load->view("keuangan/tutupkasir/contentClosing",$data);
        } else {
            $noClosing = $this->db->get_where("closing_header",array("tanggalTrx" => $tanggal,"idKasir" => $idKasir))->row()->noClosing;
            $data['headerClosing'] = $this->modelKasir->headerClosing($noClosing);
            $data['noClosing'] = $noClosing;
            $this->load->view("keuangan/tutupkasir/contentClosingClosed",$data);
        }
    }

    function submitClosing(){
        $cash = $this->input->post("cash");
        $transfer = $this->input->post("transfer");
        $debit = json_decode(stripcslashes($this->input->post("debit")));
        $kredit = json_decode(stripcslashes($this->input->post("kredit")));
        $tanggalTrx = $this->input->post("tanggalTrx");
        $idKasir = $this->input->post("idKasir");
        $idUser = $this->global['idUser'];
    
        //insert closing header
        $today = date("Y-m-d");
        $urutanClosing = $this->modelKasir->noClosing($today);
        $noClosing = "CLOSING.".date('y').date('m').date('d').".".sprintf('%03d',$idUser).".".sprintf('%03d',$urutanClosing+1);

        $dataHeader = array(
            "noClosing" => $noClosing,
            "tanggalTrx" => $tanggalTrx,
            "tanggalClosing" => date('Y-m-d H:i:s'),
            "idKasir" => $idKasir,
            "idUser" => $idUser
        );

        $insert = $this->modelKasir->insertHeaderClosing($dataHeader);

        if($insert > 0){
            //insert cash
            $this->modelKasir->insertClosingValue($noClosing,1,NULL,$cash);
            $this->modelKasir->insertClosingValue($noClosing,4,NULL,$transfer);

            foreach($kredit as $krd){
                $subAccount = $krd->subAccount;
                $nilaiClosing = $krd->nilaiClosing;

                if($nilaiClosing > 0){
                    $this->modelKasir->insertClosingValue($noClosing,3,$subAccount,$nilaiClosing);
                }
            }

            foreach($debit as $dbt){
                $subAccount = $dbt->subAccount;
                $nilaiClosing = $dbt->nilaiClosing;
                if($nilaiClosing > 0){
                    $this->modelKasir->insertClosingValue($noClosing,2,$subAccount,$nilaiClosing);
                }
             }
        }
    }

    function buttonTrx(){
        //cek closing belum
        $idKasir = $this->input->post("idKasir");
        $tanggal = $this->input->post("tanggal");
        $cekClosing = $this->modelKasir->cekClosingIfExist($idKasir,$tanggal);

        if($cekClosing < 1){
            echo "<button class='btn btn-success btn-rounded' id='trxSelesai'><i class='fa fa-bolt'></i> Selesai</button>";
        } else {
            echo "<button class='btn btn-danger btn-rounded' id='batalkanTrx'><i class='fa fa-ban'></i> Batalkan Closing</button>";
        }
    }

    function batalkanClosing(){
        $idKasir = $this->input->post("idKasir");
        $tanggal = $this->input->post("tanggalTrx");

        $noClosing = $this->db->get_where("closing_header",array("tanggalTrx" => $tanggal,"idKasir" => $idKasir))->row()->noClosing;
        $this->modelKasir->hapusClosing($noClosing);
    }
}