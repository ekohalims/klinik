<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';
require APPPATH . '/libraries/phpbarcode/vendor/autoload.php';

class PendaftaranRanap extends BaseController{
	function __construct(){
		parent::__construct();
		$this->load->model(array("modelPasienBaru","modelPendaftaranRanap"));
		$this->isLoggedIn($this->global['idUser'],2,56);
	}

	function index(){
		$this->global['pageTitle'] = "SIMRS - Pendaftaran Pasien Rawat Inap";
		$this->loadViews("pendaftaran/ranap/bodyDaftarPasien",$this->global,NULL,"pendaftaran/ranap/footerDaftarPasien");
	}

	function viewRegistRanap(){
		$search = $this->input->post('search');

		$data['viewRegistPasien'] = $this->modelPendaftaranRanap->viewRegistPasienRanap(date('Y-m-d'),$search);
		$this->load->view("pendaftaran/ranap/viewRegistRanap",$data);
	}

	function daftar(){
		$this->global['pageTitle'] = "SIMRS - Pendaftaran Pasien Rawat Inap";
		$data['poliklinik'] = $this->modelPasienBaru->daftarPoliAktif();
		$data['layanan'] = $this->db->get("kl_layanan")->result();
		$data['jenisRujukan'] = $this->db->get("kl_jenisasalrujukan")->result();
		$this->loadViews("pendaftaran/ranap/body",$this->global,$data,"pendaftaran/ranap/footer");
	}

	function cariPasien(){
		$noPasien = $this->input->post("noPasien");
		$searchBy = $this->input->post("searchBy");

		$cariPasienByID = $this->modelPasienBaru->cariPasienByID($noPasien,$searchBy);

		if($cariPasienByID < 1){
			echo "NotFound";
		} else {
			echo "Found";
		}
	}

	function tampilkanPasienJSON(){
		$noPasien = $this->input->post("noPasien");
		$searchBy = $this->input->post("searchBy");
		$dataPasien = $this->modelPasienBaru->dataPasienRowJSON($noPasien,$searchBy);

		$dataJSON[] = array(
			"noPasien" => $dataPasien->noPasien,
			"noID" => $dataPasien->noID,
			"nama" => $dataPasien->namaLengkap,
			"tanggalLahir" => $dataPasien->tempatLahir.",".date_format(date_create($dataPasien->tanggalLahir),'d F Y'),
			"umur" => $dataPasien->jenisKelamin." / ".$this->hitungUmur($dataPasien->tanggalLahir)." Thn",
			"alamat" => $dataPasien->alamat,
			"idEncoded" => $this->enkripsi($dataPasien->noPasien)
		);

		echo json_encode($dataJSON);
	}

	function tampilkanPasienJSONLangsung(){
		$noPasien = $this->dekripsi($this->input->post("noPasien"));
		$dataPasien = $this->modelPasienBaru->dataPasienRowJSONLangsung($noPasien);

		$dataJSON[] = array(
			"noPasien" => $dataPasien->noPasien,
			"noID" => $dataPasien->noID,
			"nama" => $dataPasien->namaLengkap,
			"tanggalLahir" => $dataPasien->tempatLahir.",".date_format(date_create($dataPasien->tanggalLahir),'d F Y'),
			"umur" => $dataPasien->jenisKelamin." / ".$this->hitungUmur($dataPasien->tanggalLahir)." Thn",
			"alamat" => $dataPasien->alamat,
			"idEncoded" => $this->enkripsi($dataPasien->noPasien)
		);

		echo json_encode($dataJSON);
	}

	function hitungUmur($tanggal_lahir) {
	    list($year,$month,$day) = explode("-",$tanggal_lahir);
	    $year_diff  = date("Y") - $year;
	    $month_diff = date("m") - $month;
	    $day_diff   = date("d") - $day;
	    if ($month_diff < 0) $year_diff--;
	        elseif (($month_diff==0) && ($day_diff < 0)) $year_diff--;
	    return $year_diff;
	}

	function dropdownDokterPoli(){
		$idPoli = $this->input->post("idPoli");

		$dokter = $this->db->get_where("kl_dokter",array("idPoliklinik" => $idPoli))->result();

		echo "<select class='select2' id='dokter'>";
		echo "<option value=''>--Pilih Dokter--</option>";
		foreach($dokter as $row){
			echo "<option value='".$row->id_dokter."'>".$row->nama."</option>";
		}
		echo "</select>";
	}
	

	function tampilkanKartu(){
		$idPasien = $this->dekripsi($this->input->post("idPasien"));
		$cekPasienRegistered = $this->modelPasienBaru->cekPasienRegistered($idPasien);
		
		if($cekPasienRegistered > 0){
			$data['dataDaftar'] = $this->modelPasienBaru->dataPendaftaranRow($idPasien);
			$data['klinikInfo'] = $this->db->get_where("ap_receipt",array("id" => 1))->row();
			$this->load->view("pendaftaran/kartuAntrian",$data);
		} else {
			$this->load->view("pendaftaran/buttonDaftar");
		}
	}

	function cetakKartuRanap(){
		$this->global['pageTitle'] = "SIMRS - Cetak Antrian";
		$noPendaftaran = $this->dekripsi($this->uri->segment(3));

		$data['klinikInfo'] = $this->db->get_where("kl_klinikinfo",array("id" => 1))->row();
		$data['dataDaftar'] = $this->modelPendaftaranRanap->dataPendaftaranRow($noPendaftaran);
		$this->loadViews("pendaftaran/ranap/bodyKartuRanap",$this->global,$data,"pendaftaran/ranap/footerKartuRanap");
	}

	function submitPendaftaran(){
		$idDokter = $this->input->post("idDokter");
		$jenisLayanan = $this->input->post("jenisLayanan");
		$idPasien = $this->dekripsi($this->input->post("idPasien"));
		$asalRujukan = $this->input->post("asalRujukan");
		$keluhan = $this->input->post("keluhan");
		$asuransi = $this->input->post('asuransi');
        $noKartu = $this->input->post("noKartu");
        $ruangInap = $this->input->post("ruangInap");

        $today = date('Y-m-d');
		$urutanDaftar = $this->modelPendaftaranRanap->cekPendaftaranRanap($today);
		$noPendaftaran = "RNP.".date('ymd').'.'.sprintf('%04d',$urutanDaftar+1);

		$dataPendaftaran = array(
			"noPendaftaran" => $noPendaftaran,
			"tanggalDaftar" => date('Y-m-d H:i:s'),
			"idPasien" => $idPasien,
			"idDokter" => $idDokter,
			"idLayanan" => $jenisLayanan,
			"status" => 0,
			"asuransi" => $asuransi,
			"noKartu" => $noKartu,
			"asalRujukan" => $asalRujukan,
            "keluhan" => $keluhan,
			"asalDaftar" => "RANAP",
			"operator" => $this->global['idUser']
		);

        $this->modelPasienBaru->simpanPendaftaran($dataPendaftaran);
		
		$this->daftarkanRuangPasien($noPendaftaran,$ruangInap);
		
		echo $this->enkripsi($noPendaftaran);
	}

	function daftarkanRuangPasien($noPendaftaran,$ruangInap){
		$dataArray = array(
            "noPendaftaran" => $noPendaftaran,
			"kodeRuang" =>$ruangInap,
			"tanggalMasuk" => date('Y-m-d'),
			"tanggalKeluar" => '',
			"tarif" => $this->modelPublic->getTarifKamar($ruangInap),
            "status" => 0
		);
		
		$this->modelPublic->insert("kl_ranaptopasien",$dataArray);
	}

	function tablePasienModal(){
		$data['uri'] = "pendaftaranRanap";
		$this->load->view("pendaftaran/tablePasienOnModal",$data);
	}

	function datatablePasien(){
		$this->load->model("modelPasien");

		$draw = $_REQUEST['draw'];
		$length = $_REQUEST['length'];
		$start = $_REQUEST['start'];
		$search = $_REQUEST['search']["value"];

		$total = $this->modelPasien->totalPasien();
		$output = array();
		$output['draw']	 = $draw;
		$output['recordsTotal'] = $output['recordsFiltered']=$total;
		$output['data'] = array();

		if($search!=""){
			$query = $this->modelPasien->viewPasienDatatables($length,$start,$search);
			$output['recordsTotal'] = $output['recordsFiltered'] = $query->num_rows();
		} else {
			$query = $this->modelPasien->viewPasienDatatables($length,$start,$search);
		}

		$nomor_urut=$start+1;
		foreach ($query->result_array() as $dt) {
			$encoded = $this->enkripsi($dt['noPasien']);
			$output['data'][]=array(
				$nomor_urut,
				"<a class='pilihPasien label label-success' id='".$encoded."'>".$dt['noPasien']."</a>",
				$dt['namaLengkap'],
				date_format(date_create($dt['tanggalLahir']),'d-m-Y'),
				$dt['jenisKelamin'],
				$dt['alamat'],
				$dt['noHP']
			);

			$nomor_urut++;
		}

		echo json_encode($output);
	}

	function asalRujukanForm(){
		$jenisRujukan = $this->input->post("jenisRujukan");
		$data['rujukan'] = $this->db->get_where("kl_asalrujukan",array("idJenis" => $jenisRujukan))->result();
		$this->load->view("pendaftaran/asalRujukanForm",$data);
	}

	function formTambahAsalRujukan(){
		$data['jenisRujukan'] = $this->modelPublic->viewJenisAsalRujukan();
		$this->load->view("pendaftaran/formTambahAsalRujukan",$data);
	}

	function simpanAsalRujukanSQL(){
        $namaRujukan = $this->input->post("namaRujukan");
        $jenisRujukan = $this->input->post("jenisRujukan");
        $keterangan = $this->input->post("keterangan");

        $dataArray = array(
            "asalRujukan" => $namaRujukan,
            "idJenis" => $jenisRujukan,
            "keterangan" => $keterangan
        );

        $this->modelPublic->simpanAsalRujukan($dataArray);
	}
	
	function dropdownAsuransi(){
		$data['asuransi'] = $this->modelPublic->asuransiAktif();
		$this->load->view("pendaftaran/dropdownAsuransi2",$data);
	}

	function noKartuForm(){
		$this->load->view("pendaftaran/noKartuForm2");
	}

	function formPasienBaru(){
		$data['provinsi'] = $this->db->get("ae_provinsi")->result();
		$data['agama'] = $this->db->get("kl_agama")->result();
		$data['pendidikan'] = $this->db->get("kl_pendidikan")->result();
		$data['kawin'] = $this->db->get("kl_perkawinan")->result();
		$this->load->view("pendaftaran/formPasienBaru",$data);
	}

	function simpanPasienSQL(){
		$noRM = $this->input->post("noRM");
		$noID = $this->input->post("noID");
		$namaLengkap = $this->input->post("namaLengkap");
		$tempatLahir = $this->input->post("tempatLahir");
		$tanggalLahir = $this->input->post("tanggalLahir");
		$jenisKelamin = $this->input->post("jenisKelamin");
		$noHP = $this->input->post("noHP");
		$email = $this->input->post("email");
		$anotherPhone = $this->input->post("anotherPhone");
		$pekerjaan = $this->input->post("pekerjaan");
		$alamat = $this->input->post("alamat");
		$rtrw = $this->input->post('rtrw');
		$kelurahan = $this->input->post("kelurahan");
		$provinsi = $this->input->post("provinsi");
		$kabupaten = $this->input->post("kabupaten");
		$kecamatan = $this->input->post("kecamatan");
		$agama = $this->input->post('agama');
		$pendidikan = $this->input->post("pendidikan");
		$namaKeluarga = $this->input->post("namaKeluarga");
		$statusKawin = $this->input->post("statusKawin");
		
		$day = substr($tanggalLahir,0,2);
		$month = substr($tanggalLahir,3,2);
		$year = substr($tanggalLahir,6,4);

		$birthDate = $year."-".$month."-".$day;
		
		$cekPasienPerhari = $this->modelPasienBaru->cekUrutanPasienPerhari();
		$currentOldMedRec = $this->db->get_where("kl_lastmedrec",array("id" => 1))->row()->oldMedRec;

		if(empty($noRM)){
			$batasNoRM = $this->db->get_where("kl_lastmedrec",array("id" => 1))->row()->lastMedrec;
			$noPasien = sprintf('%06d',($cekPasienPerhari-$currentOldMedRec)+$batasNoRM+1);
		} else {
			$noPasien = $noRM;

			$dataUpdate = array(
				"oldMedRec" => $currentOldMedRec+1
			);

			$this->modelPublic->update("kl_lastmedrec",array("id" => 1),$dataUpdate);
		}

		$dataArray = array(
			"noPasien" => $noPasien,
			"noID" => $noID,
			"namaLengkap" => $namaLengkap,
			"tempatLahir" => $tempatLahir,
			"tanggalLahir" => $birthDate,
			"jenisKelamin" => $jenisKelamin,
			"noHP" => $noHP,
			"email" => $email,
			"kontakLain" => $anotherPhone,
			"alamat" => $alamat,
			"rtrw" => $rtrw,
			"kelurahan" => $kelurahan,
			"provinsi" => $provinsi,
			"kabupaten" => $kabupaten,
			"kecamatan" => $kecamatan,
			"tanggalDaftar" => date('Y-m-d'),
			"pekerjaan" => $pekerjaan,
			"agama" => $agama,
			"pendidikan" => $pendidikan,
			"namaKeluarga" => $namaKeluarga,
			"perkawinan" => $statusKawin
		);

		$insert = $this->modelPasienBaru->simpanDataPasienSQL($dataArray);
		
		if($insert < 1){
			echo "Failed";
		} else {
			echo $this->enkripsi($noPasien);
		}

	}
    
    function select2Dokter(){
		$q 	= $_GET['term'];
		$query = $this->modelPublic->dokterSelect2($q);
		$data_array = array();

		foreach($query->result() as $row){
			$data_array[] = array(
				"id" => $row->id_dokter,
				"text"	=> $row->nama
			);
		}

		echo json_encode($data_array);
    }
    
    function formRanap(){
        $data['pos'] = $this->modelPublic->tampilkanPosRanap();
        $this->load->view('pendaftaran/ranap/modalFormRanap',$data);
    }

    function formPilihGroupRuang(){
        $id = $this->input->post("id");
        $data['groupRuang'] = $this->modelPendaftaranRanap->daftarGroupRuang($id);
        $this->load->view("pendaftaran/ranap/daftarGroupRuang",$data);
    }

    function formPilihRuang(){
        $idGroup = $this->input->post("idGroup");

        $data['ruangan'] = $this->modelPendaftaranRanap->viewRuanganPergroup($idGroup);
        $this->load->view("pendaftaran/ranap/formPilihRuang",$data);
    }

    function cekRuangAvailable(){
        $idRuangan = $this->input->post("idRuangan");
        $kapasitas = $this->modelPendaftaranRanap->kapasitasPerruangan($idRuangan);
        $ruanganTerpakai = $this->modelPendaftaranRanap->ruanganTerpakai($idRuangan);

        $sisaRuang = $kapasitas-$ruanganTerpakai;

        $namaRuangan = $this->db->get_where("kl_ruangan",array("kodeRuang" => $idRuangan))->row()->namaRuang;

        if($sisaRuang > 0){
            echo $namaRuangan;
        } else {
            echo "Penuh";
        }
	}
	
	function cetakIdentitas(){
		$this->global['pageTitle'] = "SIMRS - Cetak Identitas Pasien";

		$noSJP = $this->dekripsi($this->uri->segment(3));
		$data['header'] = $this->db->get_where("viewheaderrs")->row();
		$data['headerSJP'] = $this->db->get_where("viewsjp",array("noPendaftaran" => $noSJP))->row();
		$this->loadViews("pendaftaran/cetakIdentitas",$this->global,$data,"pendaftaran/footerCetak");
	}

	function cetakLembaranMasukDanKeluar(){
		$this->global['pageTitle'] = "SIMRS - Cetak Lembaran Masuk dan Keluar";

		$noSJP = $this->dekripsi($this->uri->segment(3));
		$data['header'] = $this->db->get_where("viewheaderrs")->row();
		$data['headerSJP'] = $this->db->get_where("viewsjp",array("noPendaftaran" => $noSJP))->row();
		$this->loadViews("pendaftaran/ranap/cetakLembaranMasukDanKeluar",$this->global,$data,"pendaftaran/footerCetak");
	}

	function cetakGelang(){
		$this->global['pageTitle'] = "SIMRS - Gelang Pasien";

		$noSJP = $this->dekripsi($this->uri->segment(3));

		$noRM = $this->db->get_where("kl_daftar",array("noPendaftaran" => $noSJP))->row()->idPasien;

		$data['header'] = $this->db->get_where("viewheaderrs")->row();
		$data['pasien'] = $this->db->get_where("kl_pasien",array("noPasien" => $noRM))->row();
		$data['noSJP'] = $noSJP;
		$this->loadViews("pendaftaran/ranap/cetakGelang",$this->global,$data,"pendaftaran/footerCetak");
	}

	function cetakStatus(){
		$this->global['pageTitle'] = "SIMRS - Cetak Status";

		$noSJP = $this->dekripsi($this->uri->segment(3));

		$noRM = $this->db->get_where("kl_daftar",array("noPendaftaran" => $noSJP))->row()->idPasien;

		$data['header'] = $this->db->get_where("viewheaderrs")->row();
		$data['pasien'] = $this->db->get_where("kl_pasien",array("noPasien" => $noRM))->row();
		$data['noSJP'] = $noSJP;
		$this->loadViews("pendaftaran/ranap/cetakStatus",$this->global,$data,"pendaftaran/footerCetak");
	}

	function cetakKartuPasien(){
		$this->global['pageTitle'] = "SIMRS - Cetak Kartu Pasien";

		$noRM = $this->dekripsi($this->uri->segment(3));
		$data['header'] = $this->db->get_where("viewheaderrs")->row();
		$data['pasien'] = $this->db->get_where("kl_pasien",array("noPasien" => $noRM))->row();
		$this->loadViews("pendaftaran/cetakKartu",$this->global,$data,"pendaftaran/footerCetak");
	}
}