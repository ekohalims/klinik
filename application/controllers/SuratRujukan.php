<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class SuratRujukan extends BaseController{
	function __construct(){
		parent::__construct();
		$this->load->model("modelCetakSurat");
		$this->isLoggedIn($this->global['idUser'],2,46);
    }

    function index(){
        $this->global['pageTitle'] = "SIMRS - Surat Sehat";
		$this->loadViews("cetaksurat/suratrujukan/bodySurat",$this->global,NULL,"cetaksurat/suratrujukan/footerSurat");
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

			$output['data'][]=array($nomor_urut,$dt['noPasien'],$dt['namaLengkap'],$dt['jenisKelamin'],$this->hitungUmur($dt['tanggalLahir'])." Th",$dt['noHP'],$dt['alamat'],"<a href='".base_url('suratRujukan/cetakSurat/'.$encoded)."'><i class='fa fa-print'></i></a>");
			$nomor_urut++;
		}

		echo json_encode($output);
    }
    
    function cetakSurat(){
        $this->global['pageTitle'] = "SIMRS - Cetak Surat Rujukan";
        $idPasien = $this->dekripsi($this->uri->segment(3));
        $data['dataPemeriksaan'] = $this->modelCetakSurat->dataPemeriksaanRujuk($idPasien);
		$this->loadViews("cetaksurat/suratrujukan/bodyCetakSurat",$this->global,$data,"cetaksurat/suratrujukan/footerCetakSurat");
    }

    function previewSurat(){
        $noPendaftaran = $this->input->post("noPendaftaran");
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

        $noUrut = substr($noPendaftaran,15,3);
        $kodePoliDokter = substr($noPendaftaran,10,4);
        $tanggal = substr($noPendaftaran,7,2);
        $bulan = substr($noPendaftaran,5,2);
        $bulanRomawi = $bulanRomawi[$bulan];
        $tahun = substr($noPendaftaran,3,2);
        
        $idDokter = $this->db->get_where("kl_daftar",array("noPendaftaran" => $noPendaftaran))->row()->idDokter;

        $dataPasien = $this->modelPublic->dataPasienLengkap($idPasien);
        $data['nomorSurat'] = $noUrut."/".$kodePoliDokter."/".$tanggal."/".$bulanRomawi."/".$tahun;
        $data['dataPasien'] = $dataPasien;
        $data['hasilPemeriksaan'] = $this->db->get_where("kl_catatan",array("noPendaftaran" => $noPendaftaran))->row();
        $data['umur'] = $this->hitungUmur($dataPasien->tanggalLahir);
        $data['kecamatanKlinik'] = $this->modelCetakSurat->namaKecamatan();
        $data['tanggal'] = $this->db->get_where("kl_daftar",array("noPendaftaran" => $noPendaftaran))->row()->tanggalDaftar;
        $data['dokter'] = $this->db->get_where("kl_dokter",array("id_dokter" => $idDokter))->row();
        $data['diagnosaPenyakit'] = $this->modelCetakSurat->diagnosaPenyakit($noPendaftaran);
        $data['obat'] = $this->modelCetakSurat->tampilkanCartResep($noPendaftaran);
        $data['tujuanRujukan'] = $this->db->get_where("kl_tindaklanjutpasien",array("noPendaftaran" => $noPendaftaran))->row();
        $data['noPendaftaran'] = $noPendaftaran;
        $this->load->view("cetaksurat/suratrujukan/previewSurat",$data);
    }

}