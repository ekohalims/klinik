<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class PembatalanTransaksi    extends BaseController{
	function __construct(){
		parent::__construct();
		$this->load->model("modelPembatalanTransaksi");
		$this->isLoggedIn($this->global['idUser'],2,50);
    }

    function index(){
        $this->global['pageTitle'] = "SIMRS - Pembatalan Transaksi";
		$this->loadViews("pendaftaran/pembatalantransaksi/bodyPembatalanTransaksi",$this->global,NULL,"pendaftaran/pembatalantransaksi/footerPembatalanTransaksi");
	}
	
	function daftarTransaksiDibatalkan(){
		$this->global['pageTitle'] = "SIMRS - Pembatalan Transaksi";
		$this->loadViews("pendaftaran/pembatalantransaksi/bodyDaftarPembatalanTransaksi",$this->global,NULL,"pendaftaran/pembatalantransaksi/footerDaftarPembatalanTransaksi");
	}

    function datatableTransaksi(){
		$draw = $_REQUEST['draw'];
		$length = $_REQUEST['length'];
		$start = $_REQUEST['start'];
		$search = $_REQUEST['search']["value"];

		$total = $this->modelPembatalanTransaksi->totalTransaksiNotCancel();
		$output = array();
		$output['draw']	 = $draw;
		$output['recordsTotal'] = $output['recordsFiltered']=$total;
		$output['data'] = array();

		if($search!=""){
			$query = $this->modelPembatalanTransaksi->viewDaftarTransaksi($length,$start,$search);
			$output['recordsTotal'] = $output['recordsFiltered'] = $query->num_rows();
		} else {
			$query = $this->modelPembatalanTransaksi->viewDaftarTransaksi($length,$start,$search);
		}

		$nomor_urut=$start+1;
		foreach ($query->result_array() as $dt) {
			$noPendaftaran = $this->encryption->encrypt($dt['noPendaftaran']);

			$encoded = strtr($noPendaftaran,array('+' => '.', '=' => '-', '/' => '~'));

            if($dt['status']==2){
                $status = "<span class='label label-success'>Terbayar</span>";
            } else {
                $status = "<span class='label label-danger'>Belum Terbayar</span>";
            }

			$output['data'][]=array($nomor_urut,"<a href='".base_url('pembatalanTransaksi/listTransaksi/'.$encoded)."'>".$dt['noPendaftaran']."</a>",date_format(date_create($dt['tanggalDaftar']),'d/m/Y H:i'),$dt['namaLengkap'],$dt['noID'],$dt['noPasien'],$dt['kelurahan'],$dt['tempatLahir'].",".date_format(date_create($dt['tanggalLahir']),'d M Y'),$status);
			$nomor_urut++;
		}

		echo json_encode($output);
	}
	
	function datatableTransaksiDibatalkan(){
		$draw = $_REQUEST['draw'];
		$length = $_REQUEST['length'];
		$start = $_REQUEST['start'];
		$search = $_REQUEST['search']["value"];

		$total = $this->modelPembatalanTransaksi->totalTransaksiCancel();
		$output = array();
		$output['draw']	 = $draw;
		$output['recordsTotal'] = $output['recordsFiltered']=$total;
		$output['data'] = array();

		if($search!=""){
			$query = $this->modelPembatalanTransaksi->viewDaftarTransaksiDibatalkan($length,$start,$search);
			$output['recordsTotal'] = $output['recordsFiltered'] = $query->num_rows();
		} else {
			$query = $this->modelPembatalanTransaksi->viewDaftarTransaksiDibatalkan($length,$start,$search);
		}

		$nomor_urut=$start+1;
		foreach ($query->result_array() as $dt) {
			$noPendaftaran = $this->encryption->encrypt($dt['noPendaftaran']);

			$encoded = strtr($noPendaftaran,array('+' => '.', '=' => '-', '/' => '~'));

			$output['data'][]=array($nomor_urut,"<a href='".base_url('pembatalanTransaksi/viewTransaksi/'.$encoded)."'>".$dt['noPendaftaran']."</a>",date_format(date_create($dt['tanggalDaftar']),'d/m/Y H:i'),$dt['namaLengkap'],$dt['noID'],$dt['noPasien'],$dt['kelurahan'],$dt['tempatLahir'].",".date_format(date_create($dt['tanggalLahir']),'d M Y'));
			$nomor_urut++;
		}

		echo json_encode($output);
    }
    
    function listTransaksi(){
		$this->load->model("modelKasir");

        $this->global['pageTitle'] = "SIMRS - Daftar Transaksi Pasien";
		$noPendaftaran = $this->dekripsi($this->uri->segment(3));

		$jenisTransaksi = $this->db->get_where("kl_daftar",array("noPendaftaran" => $noPendaftaran))->row()->asalDaftar;

        $data['dataTransaksi'] = $this->modelPembatalanTransaksi->dataTransaksi($noPendaftaran);
		$data['typeBayar'] = $this->modelPembatalanTransaksi->typeBayar($noPendaftaran);
		$data['tindakan'] = $this->modelPembatalanTransaksi->viewTindakan($noPendaftaran,$jenisTransaksi);
		$data['farmasi'] = $this->modelPembatalanTransaksi->viewFarmasi($noPendaftaran);
		$data['radiologi'] = $this->modelPembatalanTransaksi->viewRadiologi($noPendaftaran);
		$data['laboratorium'] = $this->modelPembatalanTransaksi->viewLaboratorium($noPendaftaran);
		$data['cekInvoice'] = $this->modelPembatalanTransaksi->cekInvoice($noPendaftaran);
		$data['idPaymentType'] = $this->modelPembatalanTransaksi->idPaymentType($noPendaftaran);
		$data['riwayatPembayaran'] = $this->modelPublic->riwayatPembayaran($noPendaftaran);
		$data['noPendaftaran'] = $noPendaftaran;
		$data['noPendaftaranEnc'] = $this->enkripsi($noPendaftaran);
		$data['total'] = $this->modelKasir->totalTransaksi($noPendaftaran);
		$this->loadViews("pendaftaran/pembatalantransaksi/bodyDaftarTrx",$this->global,$data,"pendaftaran/pembatalantransaksi/footerDaftarTrx");
	}

	function viewTransaksi(){
		$this->load->model("modelKasir");

        $this->global['pageTitle'] = "SIMRS - Daftar Transaksi Pasien";
        $noPendaftaran = $this->dekripsi($this->uri->segment(3));
        $data['dataTransaksi'] = $this->modelPembatalanTransaksi->dataTransaksi($noPendaftaran);
		$data['typeBayar'] = $this->modelPembatalanTransaksi->typeBayar($noPendaftaran);

		$asalDaftar = $this->db->get_where("kl_daftar",array("noPendaftaran" => $noPendaftaran))->row()->asalDaftar;

		$data['tindakan'] = $this->modelPembatalanTransaksi->viewTindakan($noPendaftaran,$asalDaftar);
		$data['farmasi'] = $this->modelPembatalanTransaksi->viewFarmasi($noPendaftaran);
		$data['radiologi'] = $this->modelPembatalanTransaksi->viewRadiologi($noPendaftaran);
		$data['laboratorium'] = $this->modelPembatalanTransaksi->viewLaboratorium($noPendaftaran);
		$data['cekInvoice'] = $this->modelPembatalanTransaksi->cekInvoice($noPendaftaran);
		$data['idPaymentType'] = $this->modelPembatalanTransaksi->idPaymentType($noPendaftaran);
		$data['riwayatPembayaran'] = $this->modelPublic->riwayatPembayaran($noPendaftaran);
		$data['noPendaftaran'] = $noPendaftaran;
		$data['noPendaftaranEnc'] = $this->enkripsi($noPendaftaran);
		$data['total'] = $this->modelKasir->totalTransaksi($noPendaftaran);
		$this->loadViews("pendaftaran/pembatalantransaksi/bodyViewTrx",$this->global,$data,"pendaftaran/pembatalantransaksi/footerDaftarTrx");
	}
	
	function formPembatalanType(){
		$noPendaftaran = $this->dekripsi($this->input->post("noPendaftaran"));
		$status  = $this->input->post("status");

		if($status=='terbayar'){
			$this->load->view("pendaftaran/pembatalantransaksi/formPembatalanTransaksi");
		} else {
			$this->load->view("pendaftaran/pembatalantransaksi/formPembatalanTransaksiNotPaid");
		}
	}

	function refundForm(){
		$data['akunKas'] = $this->modelPembatalanTransaksi->formAkunBayar(11);
		$data['akunBank'] = $this->modelPembatalanTransaksi->formAkunBayar(12);
		$this->load->view("pendaftaran/pembatalantransaksi/refundForm",$data);
	}

	function cekSaldoAkun(){
		$this->load->model("modelKasir");
		$noPendaftaran = $this->dekripsi($this->input->post("noPendaftaran"));
		$idAkun = $this->input->post("idAkun");
		$saldoAkun = $this->modelPembatalanTransaksi->saldoAkun($idAkun);
		$totalTransaksi = $this->modelKasir->totalTransaksi($noPendaftaran);
		
		if($saldoAkun < $totalTransaksi){
			//saldo tidak mencukupi
			echo 0;
		} else {
			//saldo mencukupi
			echo 1;
		}
	}
	
	function statusPembayaran(){
		$noPendaftaran = $this->dekripsi($this->input->post("noPendaftaran"));
		$statusPembayaran = $this->modelPembatalanTransaksi->dataTransaksi($noPendaftaran)->status;
		echo $statusPembayaran;
	}

	function batalkanTransaksi(){
		$this->load->model("modelKasir");
		$this->load->model("modelTrxJurnal");

		$akun = $this->input->post("akun");
		$noPendaftaran = $this->dekripsi($this->input->post("noPendaftaran"));

		$statusPembayaran = $this->modelPembatalanTransaksi->dataTransaksi($noPendaftaran)->status;
		
		//yang sudah terbayar dikembalikan saldonya
		if($statusPembayaran==2){

			if(empty($akun)){
				//ambil akun default
				$typeBayar = $this->db->get_where("kl_invoice",array("noPendaftaran" => $noPendaftaran))->row()->typeBayar;
				
				if($typeBayar==1){
					$akunKredit = '1103';
				} elseif($typeBayar==5){	
					$akunKredit = '1301';
				} else {
					$akunKredit = $this->db->get_where("kl_invoice",array("noPendaftaran" => $noPendaftaran))->row()->subAccount;
				}
			} else {
				$akunKredit = $akun;	
			}

			$totalTindakan = $this->modelKasir->totalTindakan($noPendaftaran);
			$totalObat = $this->modelKasir->totalObat($noPendaftaran);
			$totalLab = $this->modelKasir->totalLab($noPendaftaran);
			$totalRadiologi = $this->modelKasir->totalRadiologi($noPendaftaran);
			$totalTransaksi = $this->modelKasir->totalTransaksi($noPendaftaran);
			
			//update status table kl_daftar
			$this->modelPembatalanTransaksi->updateStatusTableDaftar($noPendaftaran,3);

			if($totalTindakan > 0){
				$dataTindakan = $totalTindakan;
			} else {
				$dataTindakan = 0;
			}

			if($totalObat > 0){
				$dataObat = $totalObat;
				$this->modelPembatalanTransaksi->updateStatusFarmasi($noPendaftaran,3);
			} else {
				$dataObat = 0;
			}

			if($totalLab > 0){
				$dataLab = $totalLab;
				$this->modelPembatalanTransaksi->updateStatusLab($noPendaftaran,3);
			} else {
				$dataLab = 0;
			}

			if($totalRadiologi > 0){
				$dataRadiologi = $totalRadiologi;
				$this->modelPembatalanTransaksi->updateStatusRad($noPendaftaran,3);
			} else {
				$dataRadiologi = 0;
			}

			$keterangan = "Pembatalan Transaksi no pendaftaran ".$noPendaftaran;

			//masukan kas terlebih dahulu
			$this->modelTrxJurnal->insertJurnalPenjualanBatal($noPendaftaran,$akunKredit,$keterangan,$totalTransaksi,$dataTindakan,$dataObat,$dataLab,$dataRadiologi);

			//kurangi saldo pada akun
			$this->load->model("modelKasDanBank");
			$currentSaldo = $this->modelKasDanBank->currentSaldoKas($akunKredit);
			$this->modelKasDanBank->kurangiSaldoAkun($currentSaldo,$totalTransaksi,$akunKredit);
			
		} else {
			//jika belum terbayar ubah saja status transaksinya menjadi batal
			$this->modelPembatalanTransaksi->updateStatusTableDaftar($noPendaftaran,3);

			$totalObat = $this->modelKasir->totalObat($noPendaftaran);
			$totalLab = $this->modelKasir->totalLab($noPendaftaran);
			$totalRadiologi = $this->modelKasir->totalRadiologi($noPendaftaran);

			if($totalObat > 0){
				$dataObat = $totalObat;
				$this->modelPembatalanTransaksi->updateStatusFarmasi($noPendaftaran,3);
			} else {
				$dataObat = 0;
			}

			if($totalLab > 0){
				$dataLab = $totalLab;
				$this->modelPembatalanTransaksi->updateStatusLab($noPendaftaran,3);
			} else {
				$dataLab = 0;
			}

			if($totalRadiologi > 0){
				$dataRadiologi = $totalRadiologi;
				$this->modelPembatalanTransaksi->updateStatusRad($noPendaftaran,3);
			} else {
				$dataRadiologi = 0;
			}
		}
	}
}