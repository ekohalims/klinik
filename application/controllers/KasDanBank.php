<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class KasDanBank extends BaseController{
	function __construct(){
		parent::__construct();
		$this->load->model("modelKasDanBank");
		$this->isLoggedIn($this->global['idUser'],2,26);
    }

    function index(){
        $this->global['pageTitle'] = "SIMRS - Kas Dan Bank";
		$this->loadViews("keuangan/kas/bodyKas",$this->global,NULL,"keuangan/kas/footerKas");
    }

    function saldoAwal(){
        $this->global['pageTitle'] = "SIMRS - Saldo Awal";
		$this->loadViews("keuangan/kas/saldoawal/bodySaldoAwal",$this->global,NULL,"keuangan/kas/saldoawal/footerSaldoAwal");
    }

    function daftarSaldoAwal(){
        $data['viewAkun'] = $this->modelKasDanBank->viewAkunAktif();
        $this->load->view("keuangan/kas/saldoawal/daftarSaldoAwal",$data);
    }

    function formSaldoAwal(){
        $kodeAkun = $this->input->post("kodeAkun");

        $form = "<div class='form-group'>";
        $form .= "<input type='text' class='form-control' id='saldoAwal'/>";
        $form .= "</div>";
        $form .= "<div class='form-group' style='text-align:right;'>";
        $form .= "<input type='hidden' id='kodeAkun' value='".$kodeAkun."'>";
        $form .= "<button class='btn btn-success' id='simpanSaldo'><i class='fa fa-save'></i> Simpan</button>";
        $form .= "</div>";

        echo $form;
    }

    function simpanSaldoAwal(){
        $kodeAkun = $this->input->post("kodeAkun");
        $saldo = $this->input->post("saldo");

        $dataUpdate = array(
            "tglSaldoAwal" => date('Y-m-d'),
            "saldo" => $saldo
        );

        $this->modelKasDanBank->updateSaldoAwal($dataUpdate,$kodeAkun);
    }

    //kas masuk
    function kasMasuk(){
        $this->global['pageTitle'] = "SIMRS - Kas Masuk";
        $data['kasAktif'] = $this->modelKasDanBank->kasAktif();
        $data['bankAktif'] = $this->modelKasDanBank->bankAktif();
        $data['coa'] = $this->modelKasDanBank->coaKeluar();
		$this->loadViews("keuangan/kas/kasmasuk/bodyKasMasuk",$this->global,$data,"keuangan/kas/kasmasuk/footerKasMasuk");
    }

    function simpanKasMasuk(){
        $idKas = $this->input->post("idKas");
        $alokasi = $this->input->post("alokasi");
        $sebesar = $this->input->post("sebesar");
        $memo = $this->input->post("memo");
        $today = date('Y-m-d');

        $kodeAkun = $idKas;

        //tambah saldo pada akun
        $currentSaldo = $this->modelKasDanBank->currentSaldoKas($kodeAkun);
        $this->modelKasDanBank->tambahSaldoAkun($currentSaldo,$sebesar,$kodeAkun);
        
        $urutanTrx = $this->modelKasDanBank->urutanTrxMasuk();
        $kodeTrx = "CASHIN".date('ymd').sprintf('%02d',$urutanTrx+1);

        $dataArray = array(
            "kodeTrx" => $kodeTrx,
            "kodeAkun" => $kodeAkun,
            "idUser" => $this->global['idUser'],
            "tanggal" => $today,
            "dari" => 'NULL',
            "memo" => $memo,
            "sebesar" => $sebesar,
            "jenis" => "MASUK"
        );

        $this->modelKasDanBank->simpanHeaderTrx($dataArray);

        $this->load->model("modelTrxJurnal");
        $akunDebit = $kodeAkun;
        $akunKredit = $alokasi;
        $keterangan = $memo;
        $value = $sebesar;
        $this->modelTrxJurnal->insertJurnal($kodeTrx,$akunDebit,$akunKredit,$keterangan,$value);
    }

    function listKasMasuk(){
        $this->global['pageTitle'] = "SIMRS - List Kas Masuk";
		$this->loadViews("keuangan/kas/kasmasuk/listKasMasuk",$this->global,NULL,"keuangan/kas/kasmasuk/footerList");
    }

    function listKasMasukDatatables(){
        $draw = $_REQUEST['draw'];
		$length = $_REQUEST['length'];
		$start = $_REQUEST['start'];
		$search = $_REQUEST['search']["value"];

        $param = "MASUK";
		$total = $this->modelKasDanBank->countKasTrx($param);
		$output = array();
		$output['draw']	 = $draw;
		$output['recordsTotal'] = $output['recordsFiltered']=$total;
		$output['data'] = array();

		if($search!=""){
			$query = $this->modelKasDanBank->listKasDatatables($length,$start,$search,$param);
			$output['recordsTotal'] = $output['recordsFiltered'] = $query->num_rows();
		} else {
			$query = $this->modelKasDanBank->listKasDatatables($length,$start,$search,$param);
		}

		$nomor_urut=$start+1;
		foreach ($query->result() as $dt) {
			$output['data'][]=array($nomor_urut,$dt->kodeTrx,$this->convertDate('dmy',$dt->tanggal),$dt->kodeAkun."-".$dt->namaSubAkun,$dt->first_name." ".$dt->last_name,$dt->memo,number_format($dt->sebesar,'0',',','.'));
			$nomor_urut++;
		}

		echo json_encode($output);
    }
    //end kas masuk

    function saldoKas(){
        $this->global['pageTitle'] = "SIMRS - Saldo Kas";
        $data['saldoKas'] = $this->modelKasDanBank->saldoKas(); 
        $this->loadViews("keuangan/kas/saldokas/bodySaldoKas",$this->global,$data,"footer_empty");
    }

    function convertHuruf(){
        $nilai = $this->input->post("nilaiKas");
        $hasil = $this->terbilang($nilai);

        echo $hasil;
    }

    //kas keluar
    function kasKeluar(){
        $this->global['pageTitle'] = "SIMRS - Kas Keluar";
        $data['kasAktif'] = $this->modelKasDanBank->kasAktif();
        $data['bankAktif'] = $this->modelKasDanBank->bankAktif();
        $data['coa'] = $this->modelKasDanBank->coaKeluar();
		$this->loadViews("keuangan/kas/kaskeluar/bodyKasKeluar",$this->global,$data,"keuangan/kas/kaskeluar/footerKasKeluar");
    }

    function listKasKeluar(){
        $this->global['pageTitle'] = "SIMRS - List Kas Keluar";
		$this->loadViews("keuangan/kas/kaskeluar/listKasKeluar",$this->global,NULL,"keuangan/kas/kaskeluar/footerList");
    }

    function listKasKeluarDatatables(){
        $draw = $_REQUEST['draw'];
		$length = $_REQUEST['length'];
		$start = $_REQUEST['start'];
		$search = $_REQUEST['search']["value"];

        $param = "KELUAR";
		$total = $this->modelKasDanBank->countKasTrx($param);
		$output = array();
		$output['draw']	 = $draw;
		$output['recordsTotal'] = $output['recordsFiltered']=$total;
		$output['data'] = array();

		if($search!=""){
			$query = $this->modelKasDanBank->listKasDatatables($length,$start,$search,$param);
			$output['recordsTotal'] = $output['recordsFiltered'] = $query->num_rows();
		} else {
			$query = $this->modelKasDanBank->listKasDatatables($length,$start,$search,$param);
		}

		$nomor_urut=$start+1;
		foreach ($query->result() as $dt) {
			$output['data'][]=array($nomor_urut,$dt->kodeTrx,$this->convertDate('dmy',$dt->tanggal),$dt->kodeAkun."-".$dt->namaSubAkun,$dt->first_name." ".$dt->last_name,$dt->memo,number_format($dt->sebesar,'0',',','.'));
			$nomor_urut++;
		}

		echo json_encode($output);
    }

    function simpanKasKeluar(){
        $idKas = $this->input->post("idKas");
        $sebesar = $this->input->post("sebesar");
        $memo = $this->input->post("memo");
        $alokasi = $this->input->post("alokasi");
        $today = date('Y-m-d');

        //kurangi saldo pada akun
        $currentSaldo = $this->modelKasDanBank->currentSaldoKas($idKas);
        $this->modelKasDanBank->kurangiSaldoAkun($currentSaldo,$sebesar,$idKas);
    
        $urutanTrx = $this->modelKasDanBank->urutanTrxKeluar();
        $kodeTrx = "CASHOUT".date('ymd').sprintf('%02d',$urutanTrx+1);

        $dataArray = array(
            "kodeTrx" => $kodeTrx,
            "kodeAkun" => $idKas,
            "idUser" => $this->global['idUser'],
            "tanggal" => $today,
            "dari" => '',
            "memo" => $memo,
            "sebesar" => $sebesar,
            "jenis" => "KELUAR"
        );

        $this->modelKasDanBank->simpanHeaderTrx($dataArray);

        $this->load->model("modelTrxJurnal");
        $akunDebit = $alokasi;
        $akunKredit = $idKas;
        $keterangan = $memo;
        $value = $sebesar;
        $this->modelTrxJurnal->insertJurnal($kodeTrx,$akunDebit,$akunKredit,$keterangan,$value);
    }
    //end kas keluar

    //mutasi kas
    function mutasiKas(){
        $this->global['pageTitle'] = "SIMRS - Kas Dan Bank";
        $data['kasAktif'] = $this->modelKasDanBank->kasAktif();
        $data['bankAktif'] = $this->modelKasDanBank->bankAktif();
		$this->loadViews("keuangan/kas/mutasikas/bodyMutasiKas",$this->global,$data,"keuangan/kas/mutasikas/footerMutasiKas");
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

    function mutasiKasSQL(){
        $dariAkun = $this->input->post("dariAkun");
        $keAkun = $this->input->post("keAkun");
        $sebesar = $this->input->post("sebesar");
        $keterangan = $this->input->post("keterangan");

        $urutanMutasi = $this->modelKasDanBank->urutanMutasi();
        $noMutasi = "MUTASI".date("ym").sprintf('%04d',$urutanMutasi+1);

        $dataMutasi = array(
            "noMutasi" => $noMutasi,
            "tanggal" => date("Y-m-d H:i:s"),
            "idUser" => $this->global['idUser'],
            "dari" => $dariAkun,
            "ke" => $keAkun,
            "saldo" => $sebesar,
            "keterangan" => $keterangan
        );    
        
        $this->modelKasDanBank->insertMutasiHeader($dataMutasi);

        //kurangi saldo akun
        $currentSaldo = $this->modelKasDanBank->currentSaldoKas($dariAkun);
        $this->modelKasDanBank->kurangiSaldoAkun($currentSaldo,$sebesar,$dariAkun);

        //tambah saldo akun alokasi
        $currentSaldoPenerima = $this->modelKasDanBank->currentSaldoKas($keAkun);
        $this->modelKasDanBank->tambahSaldoAkun($currentSaldoPenerima,$sebesar,$keAkun);

        //sisipkan transaksi ke jurnal
        $this->load->model("modelTrxJurnal");
        $keterangan = $keterangan." / ".$noMutasi;
        $this->modelTrxJurnal->insertJurnal($noMutasi,$keAkun,$dariAkun,$keterangan,$sebesar);
    }
    //end mutasi kas
}