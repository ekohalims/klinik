<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';
class AddressPicker extends BaseController{
	function list_kabupaten(){
		$id = $_POST['id'];

		$kabupaten = $this->db->get_where("ae_kabupaten", array("id_provinsi" => $id));

		foreach($kabupaten->result() as $dt){
			echo "<option value='".$dt->kabupaten_id."'>".$dt->nama_kabupaten."</option>";
		}
	}

	function list_kecamatan(){
		$id  = $_POST['id'];

		$kecamatan = $this->db->get_where("ae_kecamatan",array("kabupaten_id" => $id));

		foreach($kecamatan->result() as $dt){
			echo "<option value='".$dt->id_kecamatan."'>".$dt->kecamatan."</option>";
		}
	}

	function cekIDexist(){
		$noID = $this->input->post("noID");
		$cekID = $this->modelPublic->cekIDexist($noID);
		echo $cekID;
	}

	function buttonExport(){
		$this->load->view("laporan/pendapatan/buttonExport");
	}

	function cekNoRM(){
		$noRM = $this->input->post("noRM");
		$currentOldMedRec = $this->db->get_where("kl_lastmedrec",array("id" => 1))->row()->oldMedRec;
		$lastMedRec = $this->db->get_where("kl_lastmedrec",array("id" => 1))->row()->lastMedrec;

		$noRMExist = $this->modelPublic->countRow("kl_pasien",array("noPasien" => $noRM));
		
		if($noRMExist > 0){
			echo 0; //ada yg sama			
		} else {
			echo 1;
		}
	}
}

	