<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class PembayaranBiaya extends BaseController{
	function __construct(){
		parent::__construct();
		$this->load->model("modelPembayaranBiaya");
		$this->isLoggedIn($this->global['idUser'],2,36);
	}

    function index(){
        $this->global['pageTitle'] = "SIMRS - Pembayaran Biaya";
        $data['biayaAktif'] = $this->modelPembayaranBiaya->biayaAktif();
		$this->loadViews("keuangan/pembayaranbiaya/bodyPembayaranBiaya",$this->global,$data,"keuangan/pembayaranbiaya/footerPembayaranBiaya");
    }

    function convertHuruf(){
        $nilai = $this->input->post("nilaiKas");
        $hasil = $this->terbilang($nilai);

        echo $hasil;
    }

    function formAkunBayar(){
        $jenisBayar = $this->input->post("jenisBayar");

		if($jenisBayar==1){
			$kodeAkun = 11;
		} else {
			$kodeAkun = 12;
		}
        $this->load->model("modelPembayaranHutang");
		$data['akun'] = $this->modelPembayaranHutang->formAkunBayar($kodeAkun);
		$this->load->view("keuangan/pembayaranbiaya/formAkunBayar",$data);
    }

    function simpanPembayaran(){
        $kodeAkunBiaya = $this->input->post("kodeAkunBiaya");
        $jumlahBayar = $this->input->post("jumlahBayar");
        $jenisBayar = $this->input->post("jenisBayar");
        $kodeAkunKas = $this->input->post("kodeAkunKas");
        $keterangan = $this->input->post("keterangan");
        
        $urutanBayar = $this->modelPembayaranBiaya->urutanBayar();
        $noPembayaran = "PAYBIAYA".date('dmy').sprintf('%03d',$urutanBayar+1);

        $pembayaranBiaya = array(
            "noPembayaran" => $noPembayaran,
            "jenisBayar" => $jenisBayar,
            "kodeAkun" => $kodeAkunBiaya,
            "tanggal" => date('Y-m-d H:i:s'),
            "jumlahBayar" =>  $jumlahBayar,
            "keterangan" => $keterangan
        );

        $this->modelPembayaranBiaya->insertPembayaranBiaya($pembayaranBiaya);
        
        //kurangi saldo kas
        $this->load->model("modelKasDanBank");
        $currentSaldo = $this->modelKasDanBank->currentSaldoKas($kodeAkunKas);
        $this->modelKasDanBank->kurangiSaldoAkun($currentSaldo,$jumlahBayar,$kodeAkunKas);
        
        $this->load->model("modelTrxJurnal");
        $keterangan = "Pembayaran Biaya, No Pembayaran : ".$noPembayaran;
        $this->modelTrxJurnal->insertJurnal($noPembayaran,$kodeAkunBiaya,$kodeAkunKas,$keterangan,$jumlahBayar);
    }

    function cekSaldoAkun(){
        $kodeAkun = $this->input->post("akun");
        $nilaiKas = $this->input->post("nilaiKas");

        $nilaiSaldo = $this->db->get_where("coa_sub",array("kodeSubAkun" => $kodeAkun))->row()->saldo;

        if($nilaiKas > $nilaiSaldo){
            echo "notEnough";
        } else {
            echo "enough";
        }
    }
}