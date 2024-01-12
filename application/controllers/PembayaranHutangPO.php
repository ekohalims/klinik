<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class pembayaranHutangPO extends BaseController{
	function __construct(){
		parent::__construct();
		$this->load->model("modelPembayaranHutang");
		$this->isLoggedIn($this->global['idUser'],2,25);
	}

    function index(){
        $this->global['pageTitle'] = "SIMRS - Pembayaran Hutang";
		$this->loadViews("keuangan/pembayaranhutang/bodyPembayaranHutang",$this->global,NULL,"keuangan/pembayaranhutang/footerPembayaranHutang");
	}
	
	function listHutangDatatables(){
		$draw = $_REQUEST['draw'];
		$length = $_REQUEST['length'];
		$start = $_REQUEST['start'];
		$search = $_REQUEST['search']["value"];

		$total = $this->modelPembayaranHutang->totalHutang();
		$output = array();
		$output['draw']	 = $draw;
		$output['recordsTotal'] = $output['recordsFiltered']=$total;
		$output['data'] = array();

		if($search!=""){
			$query = $this->modelPembayaranHutang->viewDaftarHutang($length,$start,$search);
			$output['recordsTotal'] = $output['recordsFiltered'] = $query->num_rows();
		} else {
			$query = $this->modelPembayaranHutang->viewDaftarHutang($length,$start,$search);
		}

		$nomor_urut=$start+1;
		foreach ($query->result() as $dt) {
			$output['data'][]=array($nomor_urut,"<a href='".base_url('pembayaranHutangPO/invoicePenagihan/'.$this->enkripsi($dt->no_tagihan))."'>".$dt->no_tagihan."</a>",$dt->supplier,$this->convertDate('dmy',$dt->tanggal_po),$this->convertDate('dmy',$dt->jatuh_tempo),number_format($dt->totalHutang-$dt->totalRetur,'0',',','.'),number_format($dt->terbayar,'0',',','.'),number_format(($dt->totalHutang-$dt->totalRetur)-$dt->terbayar,'0',',','.'));
			$nomor_urut++;
		}

		echo json_encode($output);
	}

	function invoicePenagihan(){
		$this->global['pageTitle'] = "SIMRS - Pembayaran Hutang";
		$noTagihan = $this->dekripsi($this->uri->segment(3));
		$data['paymentType'] = $this->db->get("payment_type_debt")->result();
		$data['status_transaksi'] = $this->db->get_where("hutang",array("no_tagihan" => $noTagihan))->row()->status_hutang;
		$this->loadViews("keuangan/pembayaranhutang/bodyInvoicePenagihan",$this->global,$data,"keuangan/pembayaranhutang/footerPembayaranHutang");
	}

	function headerTagihan(){
		$noTagihan = $this->dekripsi($this->input->post("noTagihan"));
		$data['headerTagihan'] = $this->modelPembayaranHutang->headerTagihan($noTagihan);
		$this->load->view("keuangan/pembayaranhutang/headerTagihan",$data);
	}

	function dataTagihan(){
		$no_tagihan = $this->dekripsi($this->input->post("noTagihan"));

		$typePO = $this->db->get_where("purchase_order",array("no_po" => $no_tagihan))->row()->type;

		if($typePO==1){
			$data['purchaseItem'] = $this->modelPembayaranHutang->purchaseItemMaterial($no_tagihan);
		} else {
			$data['purchaseItem'] = $this->modelPembayaranHutang->purchaseItem($no_tagihan);
		}
		
		$data['noTagihan'] = $no_tagihan;
		$data['hutangTerbayar'] = $this->modelPembayaranHutang->hutangTerbayar($no_tagihan);
		$this->load->view("keuangan/pembayaranhutang/dataTagihan",$data);
	}

	function formPembayaranHutang(){
		$noTagihan = $this->dekripsi($this->input->post("noTagihan"));
		$status_transaksi = $this->db->get_where("hutang",array("no_tagihan" => $noTagihan))->row()->status_hutang;

		if($status_transaksi != 2){
			$data['paymentType'] = $this->db->get("payment_type_debt")->result();
			$this->load->view("keuangan/pembayaranhutang/formPembayaranHutang",$data);
		}
	}

	function informasiSupplier(){
		$noTagihan = $this->dekripsi($this->input->post("noTagihan"));
		$idSupplier = $this->db->get_where("purchase_order",array("no_po" => $noTagihan))->row()->id_supplier;
		$data['infoSupplier'] = $this->db->get_where("supplier",array("id_supplier" => $idSupplier))->row();
		
		$status_transaksi = $this->db->get_where("hutang",array("no_tagihan" => $noTagihan))->row()->status_hutang;
		if($status_transaksi != 2){
			$this->load->view("keuangan/pembayaranhutang/informasiSupplier",$data);
		}
	}

	function submitPembayaran(){
		$this->load->model('modelTrxJurnal');

		$jumlahBayar = $this->input->post("jumlahBayar");
		$jenisBayar = $this->input->post("jenisBayar");
		$keterangan = $this->input->post("keterangan");
		$noTagihan = $this->dekripsi($this->input->post("noTagihan"));
		$idUser = $this->global['idUser'];
		$urutanPayment = $this->modelPembayaranHutang->noPayment();
		$noPayment = "PAYD.".date('ym').".".sprintf('%03d',$idUser).".".sprintf('%04d',$urutanPayment+1);
		
		$dataArray = array(
			"no_payment" => $noPayment,
			"no_po" => $noTagihan,
			"id_pic" => $idUser,
			"id_payment" => $jenisBayar,
			"tanggal_pembayaran" => date('Y-m-d H:i:s'),
			"pembayaran" => $jumlahBayar,
			"keterangan" => $keterangan
		);
		
		$insert = $this->modelPembayaranHutang->insertPembayaran($dataArray);
		if($insert > 0){
			$this->modelPembayaranHutang->updateStatusPembayaran($noTagihan,1);
		}	

		$akunDebit = '2101';
		$akunKredit = $this->input->post("akun");
		$statement = "Pembayaran Hutang Purchase Order No PO : ".$noTagihan;
		$this->modelTrxJurnal->insertJurnal($noPayment,$akunDebit,$akunKredit,$statement,$jumlahBayar);
		
		$this->load->model("modelKasDanBank");
		$currentSaldo = $this->modelKasDanBank->currentSaldoKas($akunKredit);
        $this->modelKasDanBank->kurangiSaldoAkun($currentSaldo,$jumlahBayar,$akunKredit);

		echo $insert;
	}

	function totalHutang(){
		$noTagihan = $this->dekripsi($this->input->post("noTagihan"));

		$totalBarangDiterima = $this->modelPembayaranHutang->totalBarangDiterima($noTagihan);
		$totalRetur = $this->modelPembayaranHutang->totalRetur($noTagihan);
		$totalTerbayar = $this->modelPembayaranHutang->hutangTerbayar($noTagihan);

		echo ($totalBarangDiterima-$totalRetur)-$totalTerbayar;
	}

	function riwayatPembayaran(){
		$noTagihan = $this->dekripsi($this->input->post("noTagihan"));
		$data['riwayatPembayaran'] = $this->modelPembayaranHutang->riwayatPembayaran($noTagihan);
		$this->load->view("keuangan/pembayaranhutang/riwayatPembayaran",$data);
	}

	function riwayatPenerimaan(){
		$noTagihan = $this->dekripsi($this->input->post("noTagihan"));
		$data['riwayatPenerimaan'] = $this->modelPembayaranHutang->riwayatPenerimaan($noTagihan);
		$this->load->view("keuangan/pembayaranhutang/riwayatPenerimaan",$data);
	}

	function buktiPenerimaan(){
		$this->load->model("modelBahanMasukMaterial");
		$data['header'] = $this->db->get_where("kl_klinikinfo",array("id" => 1))->row();
		$no_receive = $this->dekripsi($this->uri->segment(3));
		$data['dataReceive'] = $this->modelBahanMasukMaterial->dataReceive($no_receive);
		$data['receive_item'] = $this->modelBahanMasukMaterial->received_item($no_receive);

		$this->global['pageTitle'] = "SIMRS - Bukti Penerimaan";
		$this->loadViews("bahan_masuk/body_invoice_receive",$this->global,$data,"footer_empty");
	}

	function buttonTrx(){
		$noTagihan = $this->dekripsi($this->input->post("noTagihan"));
		$statusTrx = $this->db->get_where("hutang",array("no_tagihan" => $noTagihan))->row()->status_hutang;

		$totalBarangDiterima = $this->modelPembayaranHutang->totalBarangDiterima($noTagihan);
		$totalRetur = $this->modelPembayaranHutang->totalRetur($noTagihan);
		$totalTerbayar = $this->modelPembayaranHutang->hutangTerbayar($noTagihan);

		$sisa = ($totalBarangDiterima-$totalRetur)-$totalTerbayar;

		if($statusTrx==1 && $sisa==0){
			echo "<button class='btn btn-success btn-rounded' id='trxSelesai'><i class='fa fa-bolt'></i> Transaksi Selesai</button>";
		}
	}

	function updateTrxSelesai(){
		$noTagihan = $this->dekripsi($this->input->post("noTagihan"));
		$this->modelPembayaranHutang->updateStatusPembayaran($noTagihan,2);
	}

	function getJatuhTempo(){
		$noTagihan = $this->dekripsi($this->input->post("noTagihan"));
		$jatuhTempo = $this->db->get_where("purchase_order",array("no_po" => $noTagihan))->row()->jatuh_tempo;
		echo $jatuhTempo;
	}

	function updateJatuhTempo(){
		$noTagihan = $this->dekripsi($this->input->post("noTagihan"));
		$jatuhTempo = $this->input->post("jatuhTempo");

		$dataUpdate = array(
			"jatuh_tempo" => $jatuhTempo
		);

		$this->modelPembayaranHutang->updateJatuhTempo($dataUpdate,$noTagihan);
	}

	function formAkunBayar(){
		$jenisBayar = $this->input->post("jenisBayar");

		if($jenisBayar==1){
			$kodeAkun = 11;
		} else {
			$kodeAkun = 12;
		}

		$data['akun'] = $this->modelPembayaranHutang->formAkunBayar($kodeAkun);
		$this->load->view("keuangan/pembayaranhutang/formAkunBayar",$data);
		
	}
}