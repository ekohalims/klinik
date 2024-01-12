<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class PenerimaanPiutang extends BaseController{
	function __construct(){
		parent::__construct();
		$this->load->model(array("modelPenerimaanPiutang","modelKasir"));
		$this->isLoggedIn($this->global['idUser'],2,52);
    }

    function index(){
		$this->global['pageTitle'] = "SIMRS - Penerimaan Piutang";
		$data['layanan'] = $this->db->get("kl_layanan")->result();
		$this->loadViews("keuangan/penerimaanpiutang/body",$this->global,$data,"keuangan/penerimaanpiutang/footer");
    }

    function loadDataPiutang(){
        $tempo = $this->input->post("tempo");
        $penanggung = $this->input->post("penanggung");
        $asuransi = $this->input->post("asuransi");
		$noRM = $this->input->post("noRM");
		$status = $this->input->post("status");

        $data['viewDataPiutang'] = $this->modelPenerimaanPiutang->viewDataPiutang($tempo,$penanggung,$asuransi,$noRM,$status);
        $this->load->view("keuangan/penerimaanpiutang/viewDataPiutang",$data);
    }

    function select2Pasien(){
		$q 	= $_GET['term'];
		$pasien = $this->modelPublic->getPasienAjax($q);

		$dataArray = array();
		foreach($pasien->result() as $row){
			$dataArray[] = array(
				"id" 	=> $row->noPasien,
				"text"	=> $row->noPasien."/".$row->namaLengkap,
			);
		}

		echo json_encode($dataArray);
    }
    
    function dropdownAsuransi(){
		$data['asuransi'] = $this->modelPublic->asuransiAktif();
		$this->load->view("keuangan/penerimaanpiutang/dropdownAsuransi",$data);
	}

	function bayarPiutang(){
		$this->global['pageTitle'] = "SIMRS - Bayar Piutang";

		$noPendaftaran = $this->dekripsi($this->uri->segment(3));
		$data['dataPiutang'] = $this->modelPublic->dataPiutangRow($noPendaftaran);
		$data['jenisPembayaran'] = $this->db->get("ap_payment_type")->result();
		$data['noInvoie'] = $this->enkripsi($this->modelPublic->dataPiutangRow($noPendaftaran)->noInvoice);
		$this->loadViews("keuangan/penerimaanpiutang/bodyBayarPiutang",$this->global,$data,"keuangan/penerimaanpiutang/footerBayarPiutang");
	}

	function dataPembayaranPiutang(){
		$noPendaftaran = $this->dekripsi($this->input->post("noPendaftaran"));

		$totalTransaksi = $this->db->get_where("kl_invoice",array("noPendaftaran" => $noPendaftaran))->row()->grandTotal;
		$terbayar = $this->modelPublic->hutangTerbayar($noPendaftaran);
		$sisaPembayaran = $totalTransaksi-$terbayar;

		$dataArray[] = array(
			"totalTransaksi" => number_format($totalTransaksi,'0',',','.'),
			"terbayar" => number_format($terbayar,'0',',','.'),
			"sisaPembayaran" => number_format($sisaPembayaran,'0',',','.')
		);

		echo json_encode($dataArray);
	}

	function dataRiwayatPembayaran(){
		$noPendaftaran = $this->dekripsi($this->input->post("noPendaftaran"));

		$data['riwayatPembayaran'] = $this->modelPublic->riwayatPembayaran($noPendaftaran);
		$this->load->view("kasir/riwayatPembayaran",$data);
	}

	function buttonPiutang(){
		$noPendaftaran = $this->dekripsi($this->input->post("noPendaftaran"));

		$totalTransaksi = $this->modelKasir->totalTransaksi($noPendaftaran);
		$terbayar = $this->modelPublic->hutangTerbayar($noPendaftaran);
		$sisaPiutang = $totalTransaksi-$terbayar;
		$statusPiutang = $this->db->get_where("kl_piutang",array("noPendaftaran" => $noPendaftaran))->row()->status;

		if($sisaPiutang < 1 && $statusPiutang==1){
			echo "<button class='btn btn-success btn-rounded' id='updateStatusTrx'><i class='fa fa-bolt'></i> Selesai</button>";
		}
	}

	function statusPiutang(){
		$noPendaftaran = $this->dekripsi($this->input->post("noPendaftaran"));
		$status = $this->db->get_where("kl_piutang",array("noPendaftaran" => $noPendaftaran))->row()->status;
	
		if($status==0){
			echo "<span class='label label-danger'>Belum Terbayar</span>";
		} elseif($status==1){
			echo "<span class='label label-info'>Terbayar</span>";
		} elseif($status==2){
			echo "<span class='label label-success'>Selesai</span>";
		} elseif($status==3){
			echo "<span class='label label-warning'>Batal</span>";
		}
	}

	function subAccountForm(){
		$id = $this->input->post("id");
		
		$data['subAccount'] = $this->modelKasir->getBankBayar($id);
		$this->load->view("kasir/subAccountForm",$data);
	}

	function maxPayPiutang(){
		$noPendaftaran = $this->dekripsi($this->input->post("noPendaftaran"));
		$jumlahBayar = $this->input->post("jumlahBayar");

		$totalTransaksi = $this->db->get_where("kl_invoice",array("noPendaftaran" => $noPendaftaran))->row()->grandTotal;
		$terbayar = $this->modelPublic->hutangTerbayar($noPendaftaran);

		$maxPay = $totalTransaksi-$terbayar;

		if($jumlahBayar > $maxPay){
			echo "MoreThanMax";
		} else {
			echo "ok";
		}
	}

	function prosesPembayaranPiutang(){
		$this->load->model("modelTrxJurnal");
		$noPendaftaran = $this->dekripsi($this->input->post("noPendaftaran"));
		$jumlahPembayaran = $this->input->post("jumlahPembayaran");
		$jenisPembayaran = $this->input->post("jenisPembayaran");
		$subAccount = $this->input->post("subAccount");
		$keterangan = $this->input->post("keterangan");
		
		$cekPembayaranPerbulan = $this->modelKasir->cekPembayaranPerbulan();
		$noPembayaran = "PAY.".date('ym').".".sprintf('%04d',$cekPembayaranPerbulan+1);

		$dataArray = array(
			"noPembayaran" => $noPembayaran,
			"noPendaftaran" => $noPendaftaran,
			"tanggalBayar" => date('Y-m-d H:i:s'),
			"typeBayar" => $jenisPembayaran,
			"subAccount" => $subAccount,
			"nilaiBayar" => $jumlahPembayaran,
			"idUser" => $this->global['idUser'],
			"keterangan" => $keterangan
		);

		$this->modelKasir->prosesPembayaranPiutang($dataArray);

		//ubah status piutang
		$this->modelKasir->ubahStatusPiutang($noPendaftaran,1);
		
		if($subAccount==''){
			//nanti ini aku setting biar bisa di ubah kalo penjualan itu masuk ke kas mana :)
			$akunDebit = '1103';
		}else {
			$akunDebit = $subAccount;
		}

		$akunKredit = '1301';
		$statement = "Pembayaran Piutang Purchase No Pendaftaran : ".$noPendaftaran;
		$this->modelTrxJurnal->insertJurnal($noPembayaran,$akunDebit,$akunKredit,$statement,$jumlahPembayaran);
	
		//tambah saldo akun
		$this->load->model("modelKasDanBank");
		$currentSaldo = $this->modelKasDanBank->currentSaldoKas($akunDebit);
        $this->modelKasDanBank->tambahSaldoAkun($currentSaldo,$jumlahPembayaran,$akunDebit);
	}

	function updateStatusPiutang(){
		$noPendaftaran = $noPendaftaran = $this->dekripsi($this->input->post("noPendaftaran"));
		$this->modelKasir->ubahStatusPiutang($noPendaftaran,2);
	}

	function viewInvoice(){
		$this->global['pageTitle'] = "SIMRS - Invoice Pembayaran";
		$noInvoice = $this->dekripsi($this->uri->segment(3));
		$noPendaftaran = $this->db->get_where("kl_invoice",array("noInvoice" => $noInvoice))->row()->noPendaftaran;

		$data['header'] = $this->db->get_where("kl_klinikinfo",array("id" => 1))->row();
		$data['dataOrder'] = $this->modelKasir->dataOrderInvoice($noInvoice);
		$data['tindakan'] = $tindakan = $this->modelKasir->viewTindakan($noPendaftaran);
		$data['farmasi'] = $this->modelKasir->viewFarmasi($noPendaftaran);
		$data['laboratorium'] = $this->modelKasir->viewLaboratorium($noPendaftaran);
		$data['radiologi'] = $this->modelKasir->viewRadiologi($noPendaftaran);
		$data['total'] = $this->modelKasir->totalTransaksi($noPendaftaran);

		$typeBayar = $this->db->get_where("kl_invoice",array("noInvoice" => $noInvoice))->row()->typeBayar;

		if($typeBayar != 5){
			$this->loadViews("kasir/invoicePembayaran",$this->global,$data,"footer_empty");
		} else {
			$data['jatuhTempo'] = $this->db->get_where("kl_piutang",array("noPendaftaran" => $noPendaftaran))->row()->jatuhTempo;
			$this->loadViews("kasir/invoicePembayaranHutang",$this->global,$data,"footer_empty");
		}
	}

	function cetakBuktiBayar(){
		$this->global['pageTitle'] = "SIMRS - Cetak Kwitansi Pembayaran";
		
		$noPendaftaran = $this->dekripsi($this->uri->segment(3));
		$data['header'] = $this->db->get_where("kl_klinikinfo",array("id" => 1))->row();
		$data['headerInvoice'] = $this->modelPublic->headerInvoice($noPendaftaran);
		$data['riwayatPembayaran'] = $this->modelPublic->riwayatPembayaran($noPendaftaran);
		$this->loadViews("kasir/bodyCetakBuktiBayar",$this->global,$data,"footer_empty");
	}
}