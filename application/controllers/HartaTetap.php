<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class HartaTetap extends BaseController{
	function __construct(){
		parent::__construct();
		$this->load->model("modelHartaTetap");
		$this->isLoggedIn($this->global['idUser'],2,42);
    }

    function index(){
        $this->global['pageTitle'] = "SIMRS - Harta Tetap";
		$this->loadViews("masterdata/hartatetap/bodyHartaTetap",$this->global,NULL,"masterdata/hartatetap/footerHartaTetap");
    }

    function tambahAset(){
		$this->global['pageTitle'] = "SIMRS - Tambah Harta Tetap";
		$this->load->model("modelKasDanBank");
		$data['coa'] = $this->db->get("coa")->result();
		$this->loadViews("masterdata/hartatetap/bodyTambahAset",$this->global,$data,"masterdata/hartatetap/footerTambahAset");
	}
	
	function saveKelompokHarta(){
		$kelompokHarta = $this->input->post("kelompokHarta");

		$dataArray = array(
			"nama" => $kelompokHarta,
			"status" => 1,
			"isDelete" => 1
		);

		$this->modelHartaTetap->saveKelompokHarta($dataArray);
	}

	function formKelompokHarta(){
		$data['kelompokHarta'] = $this->db->get_where("ak_kelompok_harta",array("status" => 1,"isDelete" => 1))->result();
		$this->load->view("masterdata/hartatetap/formKelompokHarta",$data);
	}

	function simpanAset(){
		$nama = $this->input->post("nama");
		$kelompokHarta = $this->input->post("kelompokHarta");
		$tanggalBeli = $this->input->post("tanggalBeli");
		$hargaBeli = $this->input->post("hargaBeli");
		$nilaiResidu = $this->input->post("nilaiResidu");
		$umurEkonomis = $this->input->post("umurEkonomis");
		$metode = $this->input->post("metode");
		$akunHarta = $this->input->post("akunHarta");
		$akumulasiDepresiasi = $this->input->post("akumulasiDepresiasi");
		$depresiasi = $this->input->post("depresiasi");

		$urutanKodeAset = $this->modelHartaTetap->urutanKode($kelompokHarta);
		$kodeAset = sprintf('%03d',$kelompokHarta).sprintf('%05d',$urutanKodeAset+1);

		$dataArray = array(
			"kodeAset" => $kodeAset,
			"nama" => $nama,
			"kelompok" => $kelompokHarta,
			"tanggalBeli" => $tanggalBeli,
			"hargaBeli" => $hargaBeli,
			"hargaBeli" => $hargaBeli,
			"nilaiResidu" => $nilaiResidu,
			"umurEkonomis" => $umurEkonomis,
			"metode" => $metode,
			"akunHarta" => $akunHarta,
			"akumulasiDepresiasi" => $akumulasiDepresiasi,
			"depresiasi" => $depresiasi
		);

		$this->modelHartaTetap->simpanAset($dataArray);

		$this->load->model("modelTrxJurnal");
		$akunDebit = $akunHarta;
		$akunKredit = '3103';
		$keterangan = 'Penambahan Aset '.$nama;
		$value = $hargaBeli;
		$this->modelTrxJurnal->insertJurnal($kodeAset,$akunDebit,$akunKredit,$keterangan,$value);
	}

	function datatableHarta(){
		$draw = $_REQUEST['draw'];
		$length = $_REQUEST['length'];
		$start = $_REQUEST['start'];
		$search = $_REQUEST['search']["value"];

		$total = $this->modelHartaTetap->totalBarisHarta();
		$output = array();
		$output['draw']	 = $draw;
		$output['recordsTotal'] = $output['recordsFiltered']=$total;
		$output['data'] = array();

		if($search!=""){
			$query = $this->modelHartaTetap->viewHartaDatatable($length,$start,$search);
			$output['recordsTotal'] = $output['recordsFiltered'] = $query->num_rows();
		} else {
			$query = $this->modelHartaTetap->viewHartaDatatable($length,$start,$search);
		}

		$nomor_urut=$start+1;
		foreach ($query as $dt) {
			$encoded = $this->enkripsi($dt->kodeAset);

			$hitungUsia = $this->countMonthBetweenTwoDate($dt->tanggalBeli,date('Y-m-d'));
			$usia = round($hitungUsia/30);

			if($dt->metode != 1){
				$bebanPerbulan = (($dt->hargaBeli-$dt->nilaiResidu)/$dt->umurEkonomis)/12;
				$bebanAkumulasiDepresiasi = $bebanPerbulan*$usia;
			} else {
				$bebanPerbulan = 0;
				$bebanAkumulasiDepresiasi = 0;
			}

			$output['data'][]=array($nomor_urut,$dt->kodeAset,$dt->nama,$dt->kelompok,number_format($dt->hargaBeli,'0',',','.'),$dt->umurEkonomis,number_format($bebanAkumulasiDepresiasi,'0',',','.'),number_format($bebanPerbulan,'0',',','.'),number_format($dt->hargaBeli-$bebanAkumulasiDepresiasi,'0',',','.'),'<a href="'.base_url('hartaTetap/editHarta/'.$encoded).'"><i class="fa fa-pencil"></i></a> <a class="hapusAset" id="'.$encoded.'"><i class="fa fa-trash"></i></a>');
			$nomor_urut++;
		}

		echo json_encode($output);
	}

	function editHarta(){
		$this->global['pageTitle'] = "SIMRS - Edit Harta";
		$idHarta = $this->dekripsi($this->uri->segment(3));
		$data['coa'] = $this->db->get("coa")->result();
		$data['currentAset'] = $this->db->get_where("ak_aset",array("kodeAset" => $idHarta))->row();
		$data['kelompokHarta'] = $this->db->get_where("ak_kelompok_harta",array("status" => 1,"isDelete" => 1))->result();
		$data['kodeAset'] = $this->uri->segment(3);
		$this->loadViews("masterdata/hartatetap/bodyEditHarta",$this->global,$data,"masterdata/hartatetap/footerEditHarta");
	}

	function editAsetSQL(){
		$kodeAset = $this->dekripsi($this->input->post("kodeAset"));
		$nama = $this->input->post("nama");
		$kelompokHarta = $this->input->post("kelompokHarta");
		$tanggalBeli = $this->input->post("tanggalBeli");
		$hargaBeli = $this->input->post("hargaBeli");
		$nilaiResidu = $this->input->post("nilaiResidu");
		$umurEkonomis = $this->input->post("umurEkonomis");
		$metode = $this->input->post("metode");
		$akunHarta = $this->input->post("akunHarta");
		$akumulasiDepresiasi = $this->input->post("akumulasiDepresiasi");
		$depresiasi = $this->input->post("depresiasi");

		$dataArray = array(
			"nama" => $nama,
			"kelompok" => $kelompokHarta,
			"tanggalBeli" => $tanggalBeli,
			"hargaBeli" => $hargaBeli,
			"hargaBeli" => $hargaBeli,
			"nilaiResidu" => $nilaiResidu,
			"umurEkonomis" => $umurEkonomis,
			"metode" => $metode,
			"akunHarta" => $akunHarta,
			"akumulasiDepresiasi" => $akumulasiDepresiasi,
			"depresiasi" => $depresiasi
		);

		$this->modelHartaTetap->editAsetSQL($kodeAset,$dataArray);
	}

	function countMonthBetweenTwoDate($date1,$date2){
		$begin = new DateTime($date1);
    	$end = new DateTime($date2);
    	$end = $end->modify( '+1 day' );

    	$interval = DateInterval::createFromDateString('1 day');

    	$period = new DatePeriod($begin, $interval, $end);
    	$counter = 0;
    	foreach($period as $dt) {
        	$counter++;
    	}

    	return $counter;
    }
}