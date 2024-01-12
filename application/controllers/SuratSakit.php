<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class SuratSakit extends BaseController{
	function __construct(){
		parent::__construct();
		$this->load->model("modelCetakSurat");
		$this->isLoggedIn($this->global['idUser'],2,45);
    }

    function index(){
        $this->global['pageTitle'] = "SIMRS - Surat Sakit";
		$this->loadViews("cetaksurat/suratsakit/bodySurat",$this->global,NULL,"cetaksurat/suratsakit/footerSurat");
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

			$output['data'][]=array($nomor_urut,$dt['noPasien'],$dt['namaLengkap'],$dt['jenisKelamin'],$this->hitungUmur($dt['tanggalLahir'])." Th",$dt['noHP'],$dt['alamat'],"<a href='".base_url('suratSakit/cetakSurat/'.$encoded)."'><i class='fa fa-print'></i></a>");
			$nomor_urut++;
		}

		echo json_encode($output);
    }
    
    function cetakSurat(){
        $this->global['pageTitle'] = "SIMRS - Cetak Surat Sakit";
		$this->loadViews("cetaksurat/suratsakit/bodyCetakSurat",$this->global,NULL,"cetaksurat/suratsakit/footerCetakSurat");
    }

    function daftarTanggalPeriksa(){
        $idPasien = $this->dekripsi($this->input->post("idPasien"));
        $data['dataPemeriksaan'] = $this->modelCetakSurat->dataPemeriksaan($idPasien);
        $data['idPasien'] = $this->input->post("idPasien");
        $this->load->view("cetaksurat/suratsakit/daftarTanggalPeriksa",$data);
    }

    function lamaHari(){
        $noPendaftaran = $this->input->post("noPendaftaran");
        $idPasien = $this->input->post("idPasien");
        $data['noPendaftaran'] = $noPendaftaran;
        $data['idPasien'] = $idPasien;
        $this->load->view("cetaksurat/suratsakit/lamaHari",$data);
    }

    function previewSurat(){
        $noPendaftaran = $this->input->post("noPendaftaran");
        $lamaHari = $this->input->post("lamaHari");
        $idPasien = $this->db->get_where("kl_daftar",array("noPendaftaran" => $noPendaftaran))->row()->idPasien;
        $data['header'] = $this->db->get_where("kl_klinikinfo",array("id" => 1))->row();

        $bulanRomawi = array(
            "01" => 'I',
            "02" => "II",
            "03" => "III",
            "04" => "IV",
            "05" => "V",
            "06" => "VI",
            "07" => "VII",
            "08" => "VIII",
            "09" => "IX",
            "10" => "X",
            "11" => "XI",
            "12" => "XII"
        );

        $bulanIndonesia = array(
            "01" => 'Januari',
            "02" => 'Februari',
            "03" => "Maret",
            "04" => "Aoril",
            "05" => "Mei",
            "06" => "Juni",
            "07" => "Juli",
            "08" => "Agustus",
            "09" => "September",
            "10" => "Oktober",
            "11" => "Nopember",
            "12" => "Desember"
        );

        $hariIndonesia = array(
            "Sun" => "Minggu",
            "Mon" => "Senin",
            "Tue" => "Selasa",
            "Wed" => "Rabu",
            "Thu" => "Kamis",
            "Fri" => "Jumat",
            "Sat" => "Sabtu"
        );

        $tanggalPeriksa = $this->db->get_where("kl_daftar",array("noPendaftaran" => $noPendaftaran))->row()->tanggalDaftar;

        $tanggal = nice_date($tanggalPeriksa,'D');
        $bulan = nice_date($tanggalPeriksa,'m');
        $tahun = nice_date($tanggalPeriksa,'Y');

        $hari = date_format(date_create($tanggalPeriksa),'D');
        $tahunF = date_format(date_create($tanggalPeriksa),'Y');
        $tanggalYMD = date_format(date_create($tanggalPeriksa),'Y-m-d');
        $tanggalAkhirIzin = date('Y-m-d', strtotime('+'.$lamaHari.' days', strtotime($tanggalYMD)));
        
        $hariAkhir = date_format(date_create($tanggalAkhirIzin),'D');
        $tanggalAkhir = date_format(date_create($tanggalAkhirIzin),'d');
        $bulanAkhir = date_format(date_create($tanggalAkhirIzin),'m');
        $tahunAkhir = date_format(date_create($tanggalAkhirIzin),'Y');

        $hariAkhirIzin = $hariIndonesia[$hariAkhir];

        $data['tanggalIndonesia'] = $hariIndonesia[$hari].", ".$tanggal." ".$bulanIndonesia[$bulan]." ".$tahunF;

        $idDokter = $this->db->get_where("kl_daftar",array("noPendaftaran" => $noPendaftaran))->row()->idDokter;

        $dataPasien = $this->modelPublic->dataPasienLengkap($idPasien);
        $data['dataPasien'] = $dataPasien;
        $data['umur'] = $this->hitungUmur($dataPasien->tanggalLahir);
        $data['kecamatanKlinik'] = $this->modelCetakSurat->namaKecamatan();
        $data['tanggal'] = $tanggalPeriksa;
        $data['dokter'] = $this->db->get_where("kl_dokter",array("id_dokter" => $idDokter))->row();
        $data['tanggalAkhirIzin'] = $hariAkhirIzin.", ".$tanggalAkhir." ".$bulanIndonesia[$bulanAkhir]." ".$tahunAkhir;
        $data['lamaHari'] = $lamaHari;
        $data['diagnosaPenyakit'] = $this->modelCetakSurat->diagnosaPenyakit($noPendaftaran);
        $data['noPendaftaran'] = $noPendaftaran;
        $this->load->view("cetaksurat/suratsakit/previewSurat",$data);
    }

}