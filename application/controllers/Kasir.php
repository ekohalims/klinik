<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Kasir extends BaseController{
	function __construct(){
		parent::__construct();
		$this->load->model("modelKasir");
		$this->isLoggedIn($this->global['idUser'],1,7);
	}

	function index(){
		$this->global['pageTitle'] = "SIMRS - Billing";
		$this->loadViews("kasir/bodyKasir",$this->global,NULL,"kasir/footerKasir");
	}

	function cariTagihan(){
		$query = $this->input->post("query");
		$cariBerdasarkan = $this->input->post("cariBerdasarkan");
		$data['cariTagihan'] = $this->modelKasir->cariTagihan($query,$cariBerdasarkan);
		$this->load->view("kasir/tampilkanTagihan",$data);
	}

	function payment(){
		$noPendaftaran = $this->dekripsi($this->uri->segment(3));

		$this->global['pageTitle'] = "SIMRS - Pembayaran";

		$asalDaftar = $this->db->get_where("kl_daftar",array("noPendaftaran" => $noPendaftaran))->row()->asalDaftar;

		$data['asalDaftar'] = $asalDaftar;
		$data['noPendaftaran'] = $noPendaftaran;
		$data['dataOrder'] = $this->modelKasir->dataOrderPerpendaftaran($noPendaftaran);
		$data['tindakan'] = $this->modelKasir->viewTindakan($noPendaftaran,$asalDaftar);
		$data['farmasi'] = $this->modelKasir->viewFarmasi($noPendaftaran);
		$data['laboratorium'] = $this->modelKasir->viewLaboratorium($noPendaftaran);
		$data['radiologi'] = $this->modelKasir->viewRadiologi($noPendaftaran);
		$data['total'] = $this->modelKasir->totalTransaksi($noPendaftaran);
		$data['paymentType'] = $this->db->get("ap_payment_type")->result();

		if($asalDaftar=='RANAP'){
			$data['kamarPasien'] = $this->modelKasir->viewKamar($noPendaftaran);
		}
		
		$this->loadViews("kasir/bodyPayment",$this->global,$data,"kasir/footerPayment");
	}

	function grandTotal(){
		$noPendaftaran = $this->dekripsi($this->input->post("noPendaftaran"));
		$total = $this->modelKasir->totalTransaksi($noPendaftaran);

		echo $total;
	}

	function formInputCash(){
		$noPendaftaran = $this->dekripsi($this->input->post("noPendaftaran"));
		$this->load->view("kasir/formInputCash");
	}

	function formInputCard(){
		$noPendaftaran = $this->dekripsi($this->input->post("noPendaftaran"));
		$idPayment = $this->input->post("idPayment");


		$data['subPayment'] = $this->modelKasir->getBankBayar($idPayment);
 		$this->load->view("kasir/formInputCard",$data);
	}

	function formInputHutang(){
		$noPendaftaran = $this->dekripsi($this->input->post("noPendaftaran"));
		$this->load->view("kasir/formInputHutang");
	}

	function formInputTransfer(){
		$noPendaftaran = $this->dekripsi($this->input->post("noPendaftaran"));
		$this->load->view("kasir/formInputTransfer");
	}

	function prosesPembayaran(){
		$noPendaftaran = $this->dekripsi($this->input->post("noPendaftaran"));
		$jumlahBayar = $this->input->post("idPaymentType") > 1 ? $this->modelKasir->totalTransaksi($noPendaftaran) : $this->input->post("jumlahBayar");
		$idPayment = $this->input->post("idPaymentType");
		$subAccount = $this->input->post("subAccount");
		$idUser = $this->global['idUser'];
		$today = date('Y-m-d');
		$diskon = 0;
		$totalTindakan = $this->modelKasir->totalTindakan($noPendaftaran);
		$totalObat = $this->modelKasir->totalObat($noPendaftaran);
		$totalLab = $this->modelKasir->totalLab($noPendaftaran);
		$totalRadiologi = $this->modelKasir->totalRadiologi($noPendaftaran);
		$cekInvoice = $this->modelKasir->cekInvoice($today);
		$noInvoice = "INV.".date('ymd').".".sprintf('%03d',$idUser).".".sprintf('%04d',$cekInvoice+1);
		$grandTotal = $this->modelKasir->totalTransaksi($noPendaftaran)-$diskon;

		$dataInsert = array(
			"noInvoice" => $noInvoice,
			"noPendaftaran" => $noPendaftaran,
			"tanggalBayar" => date('Y-m-d H:i:s'),
			"idUser" => $idUser,
			"typeBayar" => $idPayment,
			"subAccount" => $subAccount,
			"totalTindakan" => $totalTindakan,
			"totalObat" => $totalObat,
			"totalLaboratorium" => $totalLab,
			"totalRadiologi" => $totalRadiologi,
			"diskon" => $diskon,
			"grandTotal" => $grandTotal,
			"jumlahBayar" => $jumlahBayar,
			"kembali" => $jumlahBayar-$this->modelKasir->totalTransaksi($noPendaftaran)
		);

		$insert = $this->modelPublic->insert("kl_invoice",$dataInsert);

		if($insert > 0){
			//update status daftar
			$this->modelKasir->updateStatusTerbayar($noPendaftaran);
			echo $this->enkripsi($noInvoice);

			$this->load->model("modelTrxJurnal");

			if($idPayment==1){
				$akunDebit = "1103";
			} else {
				$akunDebit = $subAccount;				
			}


			if($totalTindakan > 0){
				$dataTindakan = $totalTindakan;
			} else {
				$dataTindakan = 0;
			}

			if($totalObat > 0){
				$dataObat = $totalObat;
			} else {
				$dataObat = 0;
			}

			if($totalLab > 0){
				$dataLab = $totalLab;
			} else {
				$dataLab = 0;
			}

			if($totalRadiologi > 0){
				$dataRadiologi = $totalRadiologi;
			} else {
				$dataRadiologi = 0;
			}

			$keterangan = "Pendapatan atas no invoice ".$noInvoice;

			//masukan kas terlebih dahulu
			$this->modelTrxJurnal->insertJurnalPenjualan($noInvoice,$akunDebit,$keterangan,$grandTotal,$dataTindakan,$dataObat,$dataLab,$dataRadiologi);

			//tambah saldo pada akun
			$this->load->model("modelKasDanBank");
			$currentSaldo = $this->modelKasDanBank->currentSaldoKas($akunDebit);
			$this->modelKasDanBank->tambahSaldoAkun($currentSaldo,$grandTotal,$akunDebit);

		} else {
			echo "Failed";
		}
	}

	function prosesPembayaranHutang(){
		$noPendaftaran = $this->dekripsi($this->input->post("noPendaftaran"));
		$jumlahBayar = 0 ;
		$idPayment = $this->input->post("idPaymentType");
		$subAccount = $this->input->post("subAccount");
		$idUser = $this->global['idUser'];
		$today = date('Y-m-d');
		$diskon = 0;
		$jatuhTempo = $this->input->post("jatuhTempo");
		$keterangan = $this->input->post("keterangan");

		$cekInvoice = $this->modelKasir->cekInvoice($today);
		$noInvoice = "INV.".date('ymd').".".sprintf('%03d',$idUser).".".sprintf('%04d',$cekInvoice+1);

		$totalTindakan = $this->modelKasir->totalTindakan($noPendaftaran);
		$totalObat = $this->modelKasir->totalObat($noPendaftaran);
		$totalLab = $this->modelKasir->totalLab($noPendaftaran);
		$totalRadiologi = $this->modelKasir->totalRadiologi($noPendaftaran);
		$grandTotal = $this->modelKasir->totalTransaksi($noPendaftaran)-$diskon;

		$dataInsert = array(
			"noInvoice" => $noInvoice,
			"noPendaftaran" => $noPendaftaran,
			"tanggalBayar" => date('Y-m-d H:i:s'),
			"idUser" => $idUser,
			"typeBayar" => $idPayment,
			"subAccount" => $subAccount,
			"totalTindakan" => $totalTindakan,
			"totalObat" => $totalObat,
			"totalLaboratorium" => $totalLab,
			"totalRadiologi" => $totalRadiologi,
			"diskon" => $diskon,
			"grandTotal" => $grandTotal,
			"jumlahBayar" => $jumlahBayar,
			"kembali" => $jumlahBayar-$grandTotal
		);

		$insert = $this->modelKasir->insertInvoice($dataInsert);
		
		if($insert > 0){
			//update status daftar
			$this->modelKasir->updateStatusTerbayar($noPendaftaran);
			echo $this->enkripsi($noInvoice);

			//insert data piutang
			$dataPiutang = array(
				"noPendaftaran" => $noPendaftaran,
				"tanggalInput" => date('Y-m-d H:i:s'),
				"jatuhTempo" => $jatuhTempo,
				"idUser" => $this->global['idUser'],
				"keterangan" => $keterangan,
				"status" => 0
			);
			
			$this->modelKasir->insertDataPiutang($dataPiutang);

			$this->load->model("modelTrxJurnal");

			$akunDebit = '1301';

			if($totalTindakan > 0){
				$dataTindakan = $totalTindakan;
			} else {
				$dataTindakan = 0;
			}

			if($totalObat > 0){
				$dataObat = $totalObat;
			} else {
				$dataObat = 0;
			}

			if($totalLab > 0){
				$dataLab = $totalLab;
			} else {
				$dataLab = 0;
			}

			if($totalRadiologi > 0){
				$dataRadiologi = $totalRadiologi;
			} else {
				$dataRadiologi = 0;
			}

			$keterangan = "Piutang atas no invoice : ".$noInvoice;

			//masukan kas terlebih dahulu
			$this->modelTrxJurnal->insertJurnalPenjualan($noInvoice,$akunDebit,$keterangan,$grandTotal,$dataTindakan,$dataObat,$dataLab,$dataRadiologi);
		} else {
			echo "Failed";
		}
	}

	function viewInvoice(){
		$this->global['pageTitle'] = "SIMRS - Invoice Pembayaran";
		$noInvoice = $this->dekripsi($this->uri->segment(3));
		$noPendaftaran = $this->db->get_where("kl_invoice",array("noInvoice" => $noInvoice))->row()->noPendaftaran;

		$asalDaftar = $this->db->get_where("kl_daftar",array("noPendaftaran" => $noPendaftaran))->row()->asalDaftar;

		$data['asalDaftar'] = $asalDaftar;
		$data['header'] = $this->db->get_where("kl_klinikinfo",array("id" => 1))->row();
		$data['dataOrder'] = $this->modelKasir->dataOrderInvoice($noInvoice);
		$data['tindakan'] = $tindakan = $this->modelKasir->viewTindakan($noPendaftaran,$asalDaftar);
		$data['farmasi'] = $this->modelKasir->viewFarmasi($noPendaftaran);
		$data['laboratorium'] = $this->modelKasir->viewLaboratorium($noPendaftaran);
		$data['radiologi'] = $this->modelKasir->viewRadiologi($noPendaftaran);
		$data['total'] = $this->modelKasir->totalTransaksi($noPendaftaran);
		$data['noInvoice'] = $this->enkripsi($noInvoice);

		$data['totalTindakan'] = $this->modelKasir->totalTindakan($noPendaftaran);
		$data['totalObat'] = $this->modelKasir->totalObat($noPendaftaran);
		$data['totalLab'] = $this->modelKasir->totalLab($noPendaftaran);
		$data['totalRad'] = $this->modelKasir->totalRadiologi($noPendaftaran);
		$data['totalKamar'] = $this->modelKasir->totalKamar($noPendaftaran);
		
		if($asalDaftar=='RANAP'){
			$data['kamarPasien'] = $this->modelKasir->viewKamar($noPendaftaran);
		}

		$typeBayar = $this->db->get_where("kl_invoice",array("noInvoice" => $noInvoice))->row()->typeBayar;
		$data['mode'] = $this->uri->segment(4);

		if($typeBayar != 5){
			
			//jenis invoice
			$data['jenisInv'] = $this->db->get_where("setting",array("id" => 3))->row()->setting;
			$this->loadViews("kasir/invoicePembayaran",$this->global,$data,"footer_empty");
		} else {
			$data['jatuhTempo'] = $this->db->get_where("kl_piutang",array("noPendaftaran" => $noPendaftaran))->row()->jatuhTempo;
			$this->loadViews("kasir/invoicePembayaranHutang",$this->global,$data,"footer_empty");
		}
	}

	function viewDataNotPayment(){
		$filter = $this->input->post("filter");
		$data['dataPembayaran'] = $this->modelKasir->viewDataPembayaran($filter);
		$this->load->view("kasir/viewDataNotPayment",$data);
	}

	function daftarPiutang(){
		$this->global['pageTitle'] = "SIMRS - Daftar Piutang";
		$this->loadViews("kasir/bodyDaftarPiutang",$this->global,NULL,"kasir/footerDaftarPiutang");
	}

	function datatablePiutang(){
		$draw = $_REQUEST['draw'];
		$length = $_REQUEST['length'];
		$start = $_REQUEST['start'];
		$search = $_REQUEST['search']["value"];

		$total 	= $this->modelKasir->totalPiutangBelumLunas();
		$output = array();
		$output['draw']	= $draw;
		$output['recordsTotal'] = $output['recordsFiltered']=$total;
		$output['data'] = array();

		if($search!=""){
			$query = $this->modelKasir->viewPiutangDatatable($length,$start,$search);
			$output['recordsTotal'] = $output['recordsFiltered'] = $query->num_rows();
		} else {
			$query = $this->modelKasir->viewPiutangDatatable($length,$start,$search);
		}

		$nomor_urut=$start+1;
		foreach ($query->result_array() as $dt) {
			$encoded = $this->enkripsi($dt['noPendaftaran']);

			$hutangTerbayar = $this->modelPublic->hutangTerbayar($dt['noPendaftaran']);

			$output['data'][]=array($nomor_urut,"<a href='".base_url('kasir/bayarPiutang/'.$encoded)."'>".$dt['noPendaftaran']."</a>",$dt['idPasien'],$dt['namaPasien'],$this->convertDate('dmyhi',$dt['tanggalDaftar']),$this->convertDate('dmy',$dt['jatuhTempo']),number_format($dt['grandTotal'],'0',',','.'),number_format($hutangTerbayar,'0',',','.'),number_format($dt['grandTotal']-$hutangTerbayar,'0',',','.'));
			$nomor_urut++;
		}

		echo json_encode($output);
	}

	function datatableInvoice(){
		$draw = $_REQUEST['draw'];
		$length = $_REQUEST['length'];
		$start = $_REQUEST['start'];
		$search = $_REQUEST['search']["value"];

		$total 	= $this->modelKasir->totalInvoiceSelesai();
		$output = array();
		$output['draw']	= $draw;
		$output['recordsTotal'] = $output['recordsFiltered']=$total;
		$output['data'] = array();

		if($search!=""){
			$query = $this->modelKasir->viewInvoiceDatatable($length,$start,$search);
			$output['recordsTotal'] = $output['recordsFiltered'] = $query->num_rows();
		} else {
			$query = $this->modelKasir->viewInvoiceDatatable($length,$start,$search);
		}

		$nomor_urut=$start+1;
		foreach ($query->result_array() as $dt) {
			$encoded = $this->enkripsi($dt['noInvoice']);
			$output['data'][]=array(
				$nomor_urut,
				"<a href='".base_url('kasir/viewInvoice/'.$encoded)."'>".$dt['noInvoice']."</a>",
				$dt['idPasien'],
				$dt['namaLengkap'],
				date_format(date_create($dt['tanggalDaftar']),'d M Y H:i'),
				$dt['poliklinik'],
				$dt['namaDokter'],
				$dt['layanan']." ".$dt['namaAsuransi']
			);

			$nomor_urut++;
		}

		echo json_encode($output);
	}

	function bayarPiutang(){
		$this->global['pageTitle'] = "SIMRS - Bayar Piutang";

		$noPendaftaran = $this->dekripsi($this->uri->segment(3));
		$data['dataPiutang'] = $this->modelPublic->dataPiutangRow($noPendaftaran);
		$data['jenisPembayaran'] = $this->db->get("ap_payment_type")->result();
		$data['noInvoie'] = $this->enkripsi($this->modelPublic->dataPiutangRow($noPendaftaran)->noInvoice);
		$this->loadViews("kasir/bodyBayarPiutang",$this->global,$data,"kasir/footerBayarPiutang");
	}

	function subAccountForm(){
		$id = $this->input->post("id");
		
		$data['subAccount'] = $this->modelKasir->getBankBayar($id);
		$this->load->view("kasir/subAccountForm",$data);
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

	function cetakBuktiBayar(){
		$this->global['pageTitle'] = "SIMRS - Cetak Kwitansi Pembayaran";
		
		$noPendaftaran = $this->dekripsi($this->uri->segment(3));
		$data['header'] = $this->db->get_where("kl_klinikinfo",array("id" => 1))->row();
		$data['headerInvoice'] = $this->modelPublic->headerInvoice($noPendaftaran);
		$data['riwayatPembayaran'] = $this->modelPublic->riwayatPembayaran($noPendaftaran);
		$this->loadViews("kasir/bodyCetakBuktiBayar",$this->global,$data,"footer_empty");
	}

	function searchPiutang(){
		$query = $this->input->post("query");
		$searchBy = $this->input->post("searchBy");
		$data['headerPenjualan'] = $this->modelKasir->headerPenjualan($query,$searchBy);
		$this->load->view("kasir/hasilPencarianPiutang",$data);
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

	function updateStatusPiutang(){
		$noPendaftaran = $noPendaftaran = $this->dekripsi($this->input->post("noPendaftaran"));
		$this->modelKasir->ubahStatusPiutang($noPendaftaran,2);
	}

	function pembatalanTransaksi(){
		$this->global['pageTitle'] = "SIMRS - Pembatalan Transaksi";
		$this->loadViews("kasir/bodyPembatalanTrx",$this->global,NULL,"kasir/footerPembatalanTrx");
	}

	function cariTransaksi(){
		$noPendaftaran = $this->input->post("noPendaftaran");
	}

	function daftarInvoicePasien(){
		$this->global['pageTitle'] = "SIMRS - Daftar Invoice Pasien";
		$this->loadViews("kasir/bodyDaftarInvoice",$this->global,NULL,"kasir/footerDaftarInvoice");
	}
}