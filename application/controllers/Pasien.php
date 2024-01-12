<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';
require APPPATH . '/libraries/phpbarcode/vendor/autoload.php';

class Pasien extends BaseController{
	function __construct(){
		parent::__construct();
		$this->load->model("modelPasien");
		$this->isLoggedIn($this->global['idUser'],2,8);
	}

	function index(){
		$this->global['pageTitle'] = "SIMRS - Master Data Pasien";
		$this->loadViews("masterdata/pasien/bodyPasien",$this->global,NULL,"masterdata/pasien/footerPasien");
	}

	function cetakKartuPasien(){
		$this->global['pageTitle'] = "SIMRS - Cetak Kartu Pasien";

		$noRM = $this->dekripsi($this->uri->segment(3));
		$data['header'] = $this->db->get_where("viewheaderrs")->row();
		$data['pasien'] = $this->db->get_where("kl_pasien",array("noPasien" => $noRM))->row();
		$this->loadViews("pendaftaran/cetakKartu",$this->global,$data,"pendaftaran/footerCetak");
	}

	function datatablePasien(){
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

			$output['data'][]=array($nomor_urut,$dt['noPasien'],$dt['namaLengkap'],$dt['jenisKelamin'],$this->hitungUmur($dt['tanggalLahir'])." Th",$dt['noHP'],$dt['alamat'],"<a href='".base_url('pasien/editPasien?idPasien='.$encoded)."'><i class='fa fa-pencil'></i></a> <a href='".base_url('pasien/cetakKartuPasien/'.$encoded)."'><i class='fa fa-credit-card'></i></a>");
			$nomor_urut++;
		}

		echo json_encode($output);
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

	function editPasien(){
		$this->global['pageTitle'] = "SIMRS - Edit Pasien";
		$data['provinsi'] = $this->db->get("ae_provinsi")->result();

		$idPasien = $this->dekripsi($this->input->get("idPasien"));
		$getPasien = $this->db->get_where("kl_pasien",array("noPasien" => $idPasien))->row();
		$data['pasien'] = $getPasien;
		$data['kabupaten'] = $this->db->get_where("ae_kabupaten",array("id_provinsi" => $getPasien->provinsi))->result();
		$data['kecamatan'] = $this->db->get_where("ae_kecamatan",array("kabupaten_id" => $getPasien->kabupaten))->result();	
		$data['idPasien'] = $this->input->get("idPasien");	
		$this->loadViews("masterdata/pasien/bodyEditPasien",$this->global,$data,"masterdata/pasien/footerPasien");
	}

	function editPasienSQL(){
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
		$idPasien = $this->dekripsi($this->input->post("idPasien"));

		$dataArray = array(
			"noID" => $noID,
			"namaLengkap" => $namaLengkap,
			"tempatLahir" => $tempatLahir,
			"tanggalLahir" => $tanggalLahir,
			"jenisKelamin" => $jenisKelamin,
			"noHP" => $noHP,
			"email" => $email,
			"kontakLain" => $anotherPhone,
			"pekerjaan" => $pekerjaan,
			"alamat" => $alamat,
			"rtrw" => $rtrw,
			"kelurahan" => $kelurahan,
			"provinsi" => $provinsi,
			"kabupaten" => $kabupaten,
			"kecamatan" => $kecamatan,
			"tanggalDaftar" => date('Y-m-d')
		);

		$this->modelPasien->updatePasienSQL($dataArray,$idPasien);
	}

	function cekIDexist(){
		$noID = $this->input->post("noID");
		$idPasien = $this->dekripsi($this->input->post("idPasien"));

		//jika id sama dengan punya sendiri tidak apa-apa
		$selfID = $this->modelPasien->selfID($idPasien);
		if($idPasien==$selfID){
			echo 0;
		} else {
			$this->load->model("modelPublic");
			$cekID = $this->modelPublic->cekIDexist($noID);
			echo $cekID;
		}
	}
}