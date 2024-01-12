<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Setting extends BaseController{
	function __construct(){
		parent::__construct();
		$this->isLoggedIn($this->global['idUser'],1,15);
	}

	function infoPerusahaan(){
		if (!$this->ion_auth->logged_in()){	
			redirect("login");
		} else {
			$cekMyAccess = $this->model1->cekMyAccess($this->global['idUser'],2,47);
			if($cekMyAccess < 1){
				$this->accessDenied();
			} else {
				$this->global['pageTitle'] = "SIMRS - Setting Info Perusahaan";
				$klinfo = $this->db->get_where("kl_klinikinfo",array("id" => 1))->row();
				$data['klinfo'] = $klinfo;
				$data['provinsi'] = $this->db->get("ae_provinsi")->result();
				$data['kabupaten'] = $this->db->get_where("ae_kabupaten",array("id_provinsi" => $klinfo->provinsi))->result();
				$data['kecamatan'] = $this->db->get_where("ae_kecamatan",array("kabupaten_id" => $klinfo->kabupaten))->result();	
				$this->loadViews("setting/bodyInfoPerusahaan",$this->global,$data,"setting/footerInfoPerusahaan");
			}
		}
	}

	function updateInfoPerusahaanSQL(){
		$namaKlinik = $this->input->post("namaKlinik");
		$kontak = $this->input->post("kontak");
		$address = $this->input->post("address");
		$provinsi = $this->input->post("provinsi");
		$kabupaten = $this->input->post("kabupaten");
		$kecamatan = $this->input->post("kecamatan");

		$dataUpdate = array(
			"namaKlinik" => $namaKlinik,
			"alamat" => $address,
			"provinsi" => $provinsi,
			"kabupaten" => $kabupaten,
			"kecamatan" => $kecamatan,
			"telepon" => $kontak
		);

		$this->modelPublic->updateInfoPerusahaanSQL($dataUpdate);
	}

	function email(){
		$data['viewEmailSetting'] = $this->db->get("settingemail")->result();
		$this->global['pageTitle'] = "SIMRS - Setting Email";
		$this->loadViews("setting/bodyEmailSetting",$this->global,$data,"footer_empty");
	}

	function updateEmailSetting(){
		$SMTPHost 		= $this->input->post("SMTPHost");
		$SMTPPort 		= $this->input->post("SMTPPort");
		$SMTPUser 		= $this->input->post("SMTPUser");
		$SMTPPassword 	= $this->input->post("SMTPPassword");
		$senderName 	= $this->input->post("SenderName");

		$dataUpdate 	= array(
									"SMTPHost"		=> $SMTPHost,
									"SMTPPort"		=> $SMTPPort,
									"SMTPUser"		=> $SMTPUser,
									"SMTPPas" 		=> $SMTPPassword,
									"UserName"		=> $senderName
							   );

		$affect = $this->modelPublic->updateEmailSetting($dataUpdate);

		if($affect > 0){
			$message = "<div class='alert alert-success alert-dismissable'>";
            $message .= "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>";
            $message .= "Data Berhasil Diubah";
            $message .= "</div>";

			$this->session->set_flashdata("message",$message);
		} else {
			$message = "<div class='alert alert-danger alert-dismissable'>";
            $message .= "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>";
            $message .= "Data Gagal Diubah";
            $message .= "</div>";

			$this->session->set_flashdata("message",$message);
		}

		redirect("setting/email");
	}
}