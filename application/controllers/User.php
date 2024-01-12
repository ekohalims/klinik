<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class User extends BaseController{
	function __construct(){
		parent::__construct();
		$this->load->model("modelAntrian");
		$this->isLoggedIn($this->global['idUser'],1,9);
	}

	function index(){
		$this->global['pageTitle'] = "SIMRS - User";
		$data['user'] = $this->db->get("users");
		$this->loadViews("user/body_user_management",$this->global,$data,"footer_empty");
	}

	function tambah_user(){
		$this->global['pageTitle'] = "SIMRS - Tambah User";
		$data['user'] = $this->db->get("users");
		$data['akses'] = $this->db->get("users_access")->result();
		$this->loadViews("user/body_tambah_user",$this->global,$data,"user/footerTambahUser");
	}

	function logUser(){
		$this->global['pageTitle'] = "SIMRS - User";
		$idUser = $this->uri->segment(3);
		$data['log'] = $this->db->get_where("users_log",array("idUser" => $idUser))->result();
		$data['user'] = $this->db->get("users")->result();
		$this->loadViews("user/log",$this->global,$data,"user/footerLog");
	}

	function viewLog(){
		$dateStart = $this->input->post("dateStart");
		$dateEnd = $this->input->post("dateEnd");
		$user = $this->input->post("user");
		$data['log'] = $this->modelAntrian->viewLog($dateStart,$dateEnd,$user);
		$this->load->view("user/dataLog",$data);
	}

	function tambah_user_sql(){
		$namaDepan = $_POST['namaDepan'];
		$namaBelakang = $_POST['namaBelakang'];
		$noHP = $_POST['noHP'];
		$email = $_POST['email'];	
		$username = $_POST['username'];
		$password = $_POST['password'];
		$group = "";
		$menu = $_POST['menu'];
		$submenu = $_POST['submenu'];
		$hakAkses = $_POST['hakAkses'];

		$getAccess = $this->db->get_where("users_access",['id' => $hakAkses])->row();

		$additionalData = array(
			"first_name" => $namaDepan,
			"last_name"	=> $namaBelakang,
			"phone"	=> $noHP,
			"menu" => $getAccess->menu,
			"sub_menu" => $getAccess->submenu,
			"hakAkses" => $hakAkses				
		);

		$this->ion_auth->register($username,$password,$email,$additionalData,$group);
	}

	function editUserSQL(){
		$namaDepan = $_POST['namaDepan'];
		$namaBelakang = $_POST['namaBelakang'];
		$noHP = $_POST['noHP'];
		$email = $_POST['email'];	
		$username =$_POST['username'];
		$password = $_POST['password'];
		$group 	= "";
		$menu = $_POST['menu'];
		$submenu = $_POST['submenu'];
		$status = $_POST['status'];
		$idUser = $_POST['idUser'];
		$hakAkses = $_POST['hakAkses'];
		$getAccess = $this->db->get_where("users_access",['id' => $hakAkses])->row();

		if(!empty($password)){

			$dataUpdate = array(
				"first_name" => $namaDepan,
				"last_name"	=> $namaBelakang,
				"phone"	=> $noHP,
				"menu" => $getAccess->menu,
				"sub_menu" => $getAccess->submenu,
				"username" => $username,
				"password" => $password,
				"active" => $status,
				"email"	=> $email,
				"hakAkses" => $hakAkses					
			);
		} else {
			$dataUpdate = array(
				"first_name" => $namaDepan,
				"last_name"	=> $namaBelakang,
				"phone" => $noHP,
				"menu" => $getAccess->menu,
				"sub_menu" => $getAccess->submenu,
				"username" => $username,
				"active" => $status,
				"email" => $email,
				"hakAkses" => $hakAkses					
			);
		}

		 $this->ion_auth->update($idUser,$dataUpdate);
	}

	function editUser(){
		$this->global['pageTitle'] = "SIMRS - Edit User";
		$data['user'] = $this->db->get_where("users",array("id" => $this->input->get("id_user")))->row();
		$data['akses'] = $this->db->get("users_access")->result();
		$this->loadViews("user/bodyEditUser",$this->global,$data,"user/footerEditUser");
	
	}

	function checkEmailIfExist(){
		$email = $_POST['email'];
		$cekEmail = $this->modelPublic->checkEmailIfExist($email);

		if($cekEmail > 0){
			echo "1";
		} 
	}

	function checkUsernameIfExist(){
		$username = $_POST['username'];

		$cekUsername = $this->modelPublic->checkUsername($username);

		if($cekUsername > 0){
			echo "1";
		}
	}

	function formDokter(){
		$data['dokter'] = $this->db->get_where("kl_dokter",array("status" => 1,"isDelete" => 1));
		$this->load->view("user/formDokter",$data);
	}

	function getDataDokter(){
		$idDokter = $this->input->post("idDokter");
		$dokter = $this->db->get_where("kl_dokter",array("id_dokter" => $idDokter));

		foreach($dokter->result() as $row){
			$dataDokter[] = array(
				"nama" => $row->nama,
				"noHP" => $row->noHP,
			);
		}

		echo json_encode($dataDokter);
	}
}
