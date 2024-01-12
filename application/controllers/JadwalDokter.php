<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class JadwalDokter extends BaseController{
	function __construct(){
		parent::__construct();
		$this->load->model("modelJadwalDokter");
		$this->isLoggedIn($this->global['idUser'],1,6);
	}

	function index(){
		$this->global['pageTitle'] = "SIMRS - Jadwal Dokter";
		$this->loadViews("jadwaldokter/bodyJadwalDokter",$this->global,NULL,"jadwaldokter/footerJadwalDokter");
	}

	function formEditJadwal(){
		$idDokter = $this->input->post("id");
		$data['idDokter'] = $idDokter;
		$data['dokter'] = $this->modelJadwalDokter->getDataDokter($idDokter);
		$this->load->view("jadwaldokter/formEditJadwal",$data);
	}

	function datatableJadwal(){
		$draw = $_REQUEST['draw'];
		$length = $_REQUEST['length'];
		$start = $_REQUEST['start'];
		$search = $_REQUEST['search']["value"];

		$total = $this->modelJadwalDokter->totalDokterAktif();
		$output = array();
		$output['draw']	= $draw;
		$output['recordsTotal'] = $output['recordsFiltered']=$total;
		$output['data'] = array();

		if($search!=""){
			$query = $this->modelJadwalDokter->viewDokterDatatables($length,$start,$search);
			$output['recordsTotal'] = $output['recordsFiltered'] = $query->num_rows();
		} else {
			$query = $this->modelJadwalDokter->viewDokterDatatables($length,$start,$search);
		}

		$nomor_urut=$start+1;
		foreach ($query->result_array() as $dt) {

			$output['data'][]=array($nomor_urut,"<a href='#myModal' data-toggle='modal' class='editJadwal' id='".$dt['id_dokter']."'>".$dt['nama']."</a>",$dt['poliklinik'],$this->modelJadwalDokter->getJadwal($dt['id_dokter'],'1'),$this->modelJadwalDokter->getJadwal($dt['id_dokter'],'2'),$this->modelJadwalDokter->getJadwal($dt['id_dokter'],'3'),$this->modelJadwalDokter->getJadwal($dt['id_dokter'],'4'),$this->modelJadwalDokter->getJadwal($dt['id_dokter'],'5'),$this->modelJadwalDokter->getJadwal($dt['id_dokter'],'6'),$this->modelJadwalDokter->getJadwal($dt['id_dokter'],'7'));
			$nomor_urut++;
		}

		echo json_encode($output);
	}

	function simpanJadwal(){
		$beginSchedule = $this->input->post("beginSchedule");
		$endSchedule = $this->input->post("endSchedule");
		$idDokter = $this->input->post("idDokter");

		$beginScheduleDecode = json_decode(stripcslashes($beginSchedule));
		$endScheduleDecode = json_decode(stripcslashes($endSchedule));

		foreach($beginScheduleDecode as $dt){
			$idJadwalBegin = $dt->idJadwalBegin;
			$jadwalBegin = $dt->jadwalBegin;

			$cekIfJadwalExist = $this->modelJadwalDokter->cekIfJadwalExist($idDokter,$idJadwalBegin);

			if($cekIfJadwalExist < 1){
				$dataInsert = array(
					"idDokter" => $idDokter,
					"hari" => $idJadwalBegin,
					"begin" => $jadwalBegin
				);

				$this->modelJadwalDokter->insertJadwal($dataInsert);
			} else {
				$dataUpdate = array(
					"begin" => $jadwalBegin
				);

				$this->modelJadwalDokter->updateJadwal($dataUpdate,$idDokter,$idJadwalBegin);
			}
		} //end foreach jadwal mulai	


		foreach($endScheduleDecode as $row){
			$idJadwalEnd = $row->idJadwalEnd;
			$jadwalEnd = $row->jadwalEnd;

			$cekIfJadwalExist = $this->modelJadwalDokter->cekIfJadwalExist($idDokter,$idJadwalBegin);

			if($cekIfJadwalExist < 1){
				$dataInsert = array(
					"idDokter" => $idDokter,
					"hari" => $idJadwalEnd,
					"end" => $jadwalEnd
				);

				$this->modelJadwalDokter->insertJadwal($dataInsert);
			} else {
				$dataUpdate = array(
					"end" => $jadwalEnd
				);

				$this->modelJadwalDokter->updateJadwal($dataUpdate,$idDokter,$idJadwalEnd);
			}
		}
	}

	function tampilkanJadwal(){
		$this->load->view("jadwaldokter/tampilkanJadwal");
	}

}