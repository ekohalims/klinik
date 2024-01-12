<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';

class Tindakan extends BaseController{
	function __construct(){
		parent::__construct();
		$this->load->model("modelTindakan");
		$this->load->library("form_validation");
		$this->isLoggedIn($this->global['idUser'],2,6);
	}

	function index(){
		$this->global['pageTitle'] = "SIMRS - Master Data Tarif";
		$this->loadViews("masterdata/tindakan/bodyTindakan",$this->global,NULL,"masterdata/tindakan/footerTindakan");
	}

	function viewTableTindakan(){
		$data['tindakan'] = $this->modelTindakan->viewTindakanAktif();
		$this->load->view("masterdata/tindakan/viewTableTindakan",$data);
	}

	function formTambahTindakan(){
		$this->load->view("masterdata/tindakan/formTambahTindakan");
	}

	function formEditTindakan(){
		$idTindakan = $this->input->post("idTindakan");
		$data['tindakan'] = $this->db->get_where("kl_tindakan",array("idTindakan" => $idTindakan))->row();
		$data['idTindakan'] = $idTindakan;
		$this->load->view("masterdata/tindakan/formEditTindakan",$data);
	}

	function simpanTindakanSQL(){
		$namaTindakan = $this->input->post("namaTindakan");
		$tarif = $this->input->post("tarif");
		$keterangan = $this->input->post("keterangan");
		$komisi = $this->input->post("komisi");

		$dataArray = array(
			"namaTindakan" => $namaTindakan,
			"tarif" => $tarif,
			"komisi" => $komisi,
			"keterangan" => $keterangan,
			"status" => 1,
			"isDelete" => 1
		);

		$this->modelTindakan->simpanTindakanSQL($dataArray);
	}

	function editTindakanSQL(){
		$namaTindakan = $this->input->post("namaTindakan");
		$tarif = $this->input->post("tarif");
		$komisi = $this->input->post("komisi");
		$keterangan = $this->input->post("keterangan");
		$status = $this->input->post("status");
		$idTindakan = $this->input->post("idTindakan");

		$dataArray = array(
			"namaTindakan" => $namaTindakan,
			"tarif" => $tarif,
			"komisi" => $komisi,
			"keterangan" => $keterangan,
			"status" => $status,
			"isDelete" => 1
		);

		$this->modelTindakan->editTindakanSQL($dataArray,$idTindakan);
	}

	function hapusTindakan(){
		$idTindakan = $this->input->post("idTindakan");
		$this->modelTindakan->hapusTindakan($idTindakan);
	}

	function masterTarif(){
		$tarifAsal = $this->uri->segment(3);

		$this->global['pageTitle'] = "SIMRS - Master Data Tarif ".$tarifAsal;
		$data['title'] = $tarifAsal;

		if($tarifAsal == "IGD"){
			$data['tableName'] = $this->enkripsi('kl_tarifigd');
			$data['dekrip'] = $tarifAsal;
		} elseif($tarifAsal=='Rajal'){
			$data['tableName'] = $this->enkripsi('kl_tarifrajal');
			$data['dekrip'] = $tarifAsal;
		} elseif($tarifAsal=='Ranap'){
			$data['tableName'] = $this->enkripsi('kl_tarifranap');
			$data['dekrip'] = $tarifAsal;
		} elseif($tarifAsal=='Radiologi'){
			$data['tableName'] = $this->enkripsi('kl_tarifradiologi');
			$data['dekrip'] = $tarifAsal;
		} elseif($tarifAsal=='Fisioterapi'){
			$data['tableName'] = $this->enkripsi('kl_tariffisioterapi');
			$data['dekrip'] = $tarifAsal;
		}

		$this->loadViews("masterdata/tindakan/bodyTarif",$this->global,$data,"masterdata/tindakan/footerTarif");
	}

	//begin master tarif lab
	function masterTarifLab(){
		$this->global['pageTitle'] = "SIMRS - Master Tarif Laboratorium";
		$this->loadViews("masterdata/tindakan/lab/body",$this->global,NULL,"masterdata/tindakan/lab/footer");
	}

	function loadTarifLab(){
		$type = $this->input->post('type');

		if($type=='satuan'){
			$this->load->view("masterdata/tindakan/lab/loadTarif");
		} else {
			$this->load->view("masterdata/tindakan/lab/loadTarifPaket");
		}
	}

	function formTambahLab(){
		$jenis = $this->input->post("jenis");
		$data['kategori'] = $this->modelPublic->viewKategoriLab();

		if($jenis=='satuan'){
			$this->load->view("masterdata/tindakan/lab/formTambahSatuan",$data);
		} else {
			$this->load->view("masterdata/tindakan/lab/formTambahPaket",$data);
		}
	}

	function formEditLab(){
		$jenis = $this->input->post("jenis");
		$kode = $this->input->post("kode");
		$data['kategori'] = $this->modelPublic->viewKategoriLab();
		$data['tarif'] = $this->db->get_where("kl_tariflab",array("kode" => $kode))->row();

		if($jenis=='satuan'){
			$this->load->view("masterdata/tindakan/lab/formEditSatuan",$data);
		} else {

		}
	}

	function simpanLabSQL(){
		$namaTarif = $this->input->post("namaTarif");
		$golongan = $this->input->post("golongan");
		$nilaiMin = $this->input->post("nilaiMin");
		$nilaiMax = $this->input->post("nilaiMax");
		$nilai = $this->input->post("nilai");
		$satuan = $this->input->post("satuan");
		$nilaiLain = $this->input->post("nilaiLain");
		$tarif = $this->input->post("tarif");
		$keterangan = $this->input->post("keterangan");
		$hargaNormal = $this->input->post("hargaNormal");

		$dataInsert = array(
			"namaTarif" => $namaTarif,
			"idKategori" => $golongan,
			"nilai" => $nilai,
			"nmin" => $nilaiMin,
			"nmax" => $nilaiMax,
			"satuan" => $satuan,
			"keterangan" => $keterangan,
			"nilaiLain" => $nilaiLain,
			"hargaNormal" => $hargaNormal,
			"tarif" => $tarif,
			"jenis" => "SATUAN"
		);

		$this->modelPublic->insert("kl_tariflab",$dataInsert);
	}

	function editLabSQL(){
		$namaTarif = $this->input->post("namaTarif");
		$golongan = $this->input->post("golongan");
		$nilaiMin = $this->input->post("nilaiMin");
		$nilaiMax = $this->input->post("nilaiMax");
		$nilai = $this->input->post("nilai");
		$satuan = $this->input->post("satuan");
		$nilaiLain = $this->input->post("nilaiLain");
		$tarif = $this->input->post("tarif");
		$keterangan = $this->input->post("keterangan");
		$hargaNormal = $this->input->post("hargaNormal");
		$kode = $this->input->post("kode");

		$dataUpdate = array(
			"namaTarif" => $namaTarif,
			"idKategori" => $golongan,
			"nilai" => $nilai,
			"nmin" => $nilaiMin,
			"nmax" => $nilaiMax,
			"satuan" => $satuan,
			"keterangan" => $keterangan,
			"nilaiLain" => $nilaiLain,
			"hargaNormal" => $hargaNormal,
			"tarif" => $tarif
		);

		$this->modelPublic->update("kl_tariflab",array("kode" => $kode),$dataUpdate);
	}

	function datatableTarifLabSatuan(){
		$draw = $_REQUEST['draw'];
		$length = $_REQUEST['length'];
		$start = $_REQUEST['start'];
		$search = $_REQUEST['search']["value"];

		$total = $this->modelPublic->countRow("kl_tariflab",array("jenis" => "S"));
		$output = array();
		$output['draw']	 = $draw;
		$output['recordsTotal'] = $output['recordsFiltered']=$total;
		$output['data'] = array();

		if($search!=""){
			$query = $this->modelTindakan->viewTarifLabDatatable($length,$start,$search,"S");
			$output['recordsTotal'] = $output['recordsFiltered'] = $query->num_rows();
		} else {
			$query = $this->modelTindakan->viewTarifLabDatatable($length,$start,$search,"S");
		}

		$nomor_urut=$start+1;
		foreach ($query->result_array() as $dt) {
			$encoded = $this->enkripsi($dt['kode']);

			$output['data'][]=array(
				$nomor_urut,
				$dt['namaTarif'],
				$dt['kategori'],
				$dt['nilai'],
				$dt['nmin']." - ".$dt['nmax'],
				$dt['hargaNormal'],
				$dt['satuan'],
				$dt['keterangan'],
				number_format($dt['tarif'],'0',',','.'),
				"<a class='editLabSatuan' id='".$dt['kode']."'><i class='fa fa-pencil'></i></a> <a class='hapus' id='".$dt['kode']."'><i class='fa fa-trash'></i></a>"
			);
			$nomor_urut++;
		}

		echo json_encode($output);
	}

	function datatableTarifLabPaket(){
		$draw = $_REQUEST['draw'];
		$length = $_REQUEST['length'];
		$start = $_REQUEST['start'];
		$search = $_REQUEST['search']["value"];

		$total = $this->modelPublic->countRow("kl_tariflab",array("jenis" => "S"));
		$output = array();
		$output['draw']	 = $draw;
		$output['recordsTotal'] = $output['recordsFiltered']=$total;
		$output['data'] = array();

		if($search!=""){
			$query = $this->modelTindakan->viewTarifLabDatatable($length,$start,$search,"P");
			$output['recordsTotal'] = $output['recordsFiltered'] = $query->num_rows();
		} else {
			$query = $this->modelTindakan->viewTarifLabDatatable($length,$start,$search,"P");
		}

		$nomor_urut=$start+1;
		foreach ($query->result_array() as $dt) {
			$encoded = $this->enkripsi($dt['kode']);

			$output['data'][]=array(
				$nomor_urut,
				$dt['namaTarif'],
				$dt['kategori'],
				$dt['nilai'],
				$dt['nmin']."-".$dt['nmax'],
				$dt['hargaNormal'],
				$dt['satuan'],
				$dt['keterangan'],
				number_format($dt['tarif'],'0',',','.')  
			);
			$nomor_urut++;
		}

		echo json_encode($output);
	}

	function hapusTarifLab(){
		$kode = $this->input->post("kode");
		$this->modelPublic->delete("kl_tariflab",array("kode" => $kode));
	}

	function formTarifLabRinci(){
		$data['row'] = $_GET['no'];
		$this->load->view("masterdata/tindakan/lab/formTarifLabRinci",$data);
	}

	function select2Lab(){
		$q 	= $_GET['term'];
		$query = $this->modelTindakan->tarifLabSelect2($q);
		$data_array = array();

		foreach($query->result() as $row){
			$data_array[] = array(
				"id" => $row->kode,
				"text"	=> $row->namaTarif
			);
		}

		echo json_encode($data_array);
    }
	//end master tarif lab

	//begin tarif vk
	function masterTarifVK(){
		$this->global['pageTitle'] = "SIMRS - Master Tarif VK";
		$this->loadViews("masterdata/tindakan/vk/body",$this->global,NULL,"masterdata/tindakan/vk/footer");
	}

	function loadTarifVK(){
		$this->load->view("masterdata/tindakan/vk/viewItem");
	}

	function formTambahVK(){
		$this->load->view("masterdata/tindakan/vk/formTambah");
	}

	function formEditVK(){
		$kode = $this->input->post("id");
		$data['tarif'] = $this->db->get_where("kl_tarifvk",array("kode" => $kode))->row();
		$data['tarifRinci'] = $this->db->get_where("kl_tarifvkrinci",array("kode" => $kode))->result();
		$this->load->view("masterdata/tindakan/vk/formEdit",$data);
	}

	function formTarif(){
		$data['urutan'] = $this->input->get("no");
		$this->load->view("masterdata/tindakan/vk/formTarifTambah",$data);
	}


	function datatableVK(){
		$draw = $_REQUEST['draw'];
		$length = $_REQUEST['length'];
		$start = $_REQUEST['start'];
		$search = $_REQUEST['search']["value"];

		$total = $this->modelPublic->countRow("kl_tarifvk",NULL);
		$output = array();
		$output['draw']	 = $draw;
		$output['recordsTotal'] = $output['recordsFiltered']=$total;
		$output['data'] = array();

		if($search!=""){
			$query = $this->modelTindakan->viewTarifVK($length,$start,$search);
			$output['recordsTotal'] = $output['recordsFiltered'] = $query->num_rows();
		} else {
			$query = $this->modelTindakan->viewTarifVK($length,$start,$search);
		}

		$nomor_urut=$start+1;

		foreach ($query->result_array() as $dt){
			$totalTarif = $this->modelTindakan->totalTarif($dt['kode']);

			$output['data'][]=array(
				$nomor_urut,
				$dt['kelas'],
				$dt['namaTarif'],
				number_format($totalTarif,'0',',','.'),
				'<a class="edit" id="'.$dt['kode'].'"><i class="fa fa-pencil"></i></a> <a class="hapus" id="'.$dt['kode'].'"><i class="fa fa-trash"></i></a>'
			);
			$nomor_urut++;
		}

		echo json_encode($output);
	}

	function simpanVK(){
		$namaTarif = $this->input->post("namaTarif");
		$kelas = $this->input->post("kelas");
		$jenis = $this->input->post("jenis");

		if($jenis=='tambah'){
			$dataTarif = array(
				"kelas" => $kelas,
				"namaTarif" => $namaTarif
			);

			$insert = $this->modelPublic->insertReturnID("kl_tarifvk",$dataTarif);

			$count = count($_POST['namaTarifRinci']);
			for($i=0;$i<$count;$i++){
				$namaTarifRinci = $_POST['namaTarifRinci'][$i];
				$keterangan = $_POST['keterangan'][$i];
				$tarif = $_POST['tarif'][$i];

				$dataInsert[] = array(
					"kode" => $insert,
					"namaTarif" => $namaTarifRinci,
					"tarif" => $tarif,
					"keterangan" => $keterangan
				);
			}

			$this->modelPublic->insertBatch("kl_tarifvkrinci",$dataInsert);
		} else {
			$kodeVK = $this->input->post("kodeVK");

			$dataTarif = array(
				"kelas" => $kelas,
				"namaTarif" => $namaTarif
			);

			$this->modelPublic->update("kl_tarifvk",array("kode" => $kodeVK),$dataTarif);

			$count = count($_POST['namaTarifRinci']);
			for($i=0;$i<$count;$i++){
				$namaTarifRinci = $_POST['namaTarifRinci'][$i];
				$keterangan = $_POST['keterangan'][$i];
				$tarif = $_POST['tarif'][$i];
				$kodeTarif = $_POST['kode'][$i];

				if(!empty($kodeTarif)){
					$dataUpdate = array(
						"namaTarif" => $namaTarifRinci,
						"tarif" => $tarif,
						"keterangan" => $keterangan
					);

					$this->modelPublic->update("kl_tarifvkrinci",array("kodeTarif" => $kodeTarif),$dataUpdate);
				} else {
					$dataInsert = array(
						"kode" => $kodeVK,
						"namaTarif" => $namaTarifRinci,
						"tarif" => $tarif,
						"keterangan" => $keterangan
					);

					$this->modelPublic->insert("kl_tarifvkrinci",$dataInsert);
				}
			}
		}
	}

	function hapusVKRinci(){
		$kode = $this->input->post("kode");
		$this->modelPublic->delete("kl_tarifvkrinci",array("kodeTarif" => $kode));
	}

	function hapusVK(){
		$kode = $this->input->post("kode");
		$this->modelPublic->delete("kl_tarifvk",array("kode" => $kode));
	}
	//end master tarif vk

	//begin maser tarif ok
	function masterTarifOK(){
		$this->global['pageTitle'] = "SIMRS - Master Tarif OK";
		$this->loadViews("masterdata/tindakan/ok/body",$this->global,NULL,"masterdata/tindakan/ok/footer");
	}

	function loadTarifOK(){
		$this->load->view("masterdata/tindakan/ok/viewItem");
	}

	function datatableOK(){
		$draw = $_REQUEST['draw'];
		$length = $_REQUEST['length'];
		$start = $_REQUEST['start'];
		$search = $_REQUEST['search']["value"];

		$total = $this->modelPublic->countRow("kl_tarifok",NULL);
		$output = array();
		$output['draw']	 = $draw;
		$output['recordsTotal'] = $output['recordsFiltered']=$total;
		$output['data'] = array();

		if($search!=""){
			$query = $this->modelTindakan->viewTarifOK($length,$start,$search);
			$output['recordsTotal'] = $output['recordsFiltered'] = $query->num_rows();
		} else {
			$query = $this->modelTindakan->viewTarifOK($length,$start,$search);
		}

		$nomor_urut=$start+1;

		foreach ($query->result_array() as $dt){
			$totalTarif = $this->modelTindakan->totalTarifOK($dt['kode']);

			$output['data'][]=array(
				$nomor_urut,
				$dt['jenis'],
				$dt['kelas'],
				$dt['namaTarif'],
				number_format($totalTarif,'0',',','.'),
				'<a class="edit" id="'.$dt['kode'].'"><i class="fa fa-pencil"></i></a> <a class="hapus" id="'.$dt['kode'].'"><i class="fa fa-trash"></i></a>'
			);
			$nomor_urut++;
		}

		echo json_encode($output);
	}

	function formTambahOK(){
		$this->load->view("masterdata/tindakan/ok/formTambah");
	}

	function simpanOK(){
		$namaTarif = $this->input->post("namaTarif");
		$kelas = $this->input->post("kelas");
		$jenis = $this->input->post("jenis");
		$jenisTarif = $this->input->post("jenisTarif");

		if($jenis=='tambah'){
			$dataTarif = array(
				"jenis" => $jenisTarif,
				"kelas" => $kelas,
				"namaTarif" => $namaTarif
			);

			$insert = $this->modelPublic->insertReturnID("kl_tarifok",$dataTarif);

			$count = count($_POST['namaTarifRinci']);
			for($i=0;$i<$count;$i++){
				$namaTarifRinci = $_POST['namaTarifRinci'][$i];
				$keterangan = $_POST['keterangan'][$i];
				$tarif = $_POST['tarif'][$i];

				$dataInsert[] = array(
					"kode" => $insert,
					"namaTarif" => $namaTarifRinci,
					"tarif" => $tarif,
					"keterangan" => $keterangan
				);
			}

			$this->modelPublic->insertBatch("kl_tarifokrinci",$dataInsert);
		} else {
			$kodeOK = $this->input->post("kodeOK");

			$dataTarif = array(
				"jenis" => $jenisTarif,
				"kelas" => $kelas,
				"namaTarif" => $namaTarif
			);

			$this->modelPublic->update("kl_tarifok",array("kode" => $kodeOK),$dataTarif);

			$count = count($_POST['namaTarifRinci']);
			for($i=0;$i<$count;$i++){
				$namaTarifRinci = $_POST['namaTarifRinci'][$i];
				$keterangan = $_POST['keterangan'][$i];
				$tarif = $_POST['tarif'][$i];
				$kodeTarif = $_POST['kode'][$i];

				if(!empty($kodeTarif)){
					$dataUpdate = array(
						"namaTarif" => $namaTarifRinci,
						"tarif" => $tarif,
						"keterangan" => $keterangan
					);

					$this->modelPublic->update("kl_tarifokrinci",array("kodeTarif" => $kodeTarif),$dataUpdate);
				} else {
					$dataInsert = array(
						"kode" => $kodeOK,
						"namaTarif" => $namaTarifRinci,
						"tarif" => $tarif,
						"keterangan" => $keterangan
					);

					$this->modelPublic->insert("kl_tarifokrinci",$dataInsert);
				}
			}
		}
	}

	function formEditOK(){
		$kode = $this->input->post("id");
		$data['tarif'] = $this->db->get_where("kl_tarifok",array("kode" => $kode))->row();
		$data['tarifRinci'] = $this->db->get_where("kl_tarifokrinci",array("kode" => $kode))->result();
		$this->load->view("masterdata/tindakan/ok/formEdit",$data);
	}

	function hapusOKRinci(){
		$kode = $this->input->post("kode");
		$this->modelPublic->delete("kl_tarifokrinci",array("kodeTarif" => $kode));
	}

	function hapusOK(){
		$kode = $this->input->post("kode");
		$this->modelPublic->delete("kl_tarifok",array("kode" => $kode));
	}
	//end master tarif ok

	function dataRow(){
		$data['tableName'] = $this->input->post("table");
		$data['table'] = $this->dekripsi($this->input->post("table"));
		$this->load->view("masterdata/tindakan/dataRow",$data);
	}

	function datatableTarif(){
		$table = $this->dekripsi($this->input->post('table'));

		$draw = $_REQUEST['draw'];
		$length = $_REQUEST['length'];
		$start = $_REQUEST['start'];
		$search = $_REQUEST['search']["value"];

		$total = $this->modelPublic->countRow($table,NULL);
		$output = array();
		$output['draw']	 = $draw;
		$output['recordsTotal'] = $output['recordsFiltered']=$total;
		$output['data'] = array();

		if($search!=""){
			$query = $this->modelPublic->viewTarif($length,$start,$search,$table);
			$output['recordsTotal'] = $output['recordsFiltered'] = $query->num_rows();
		} else {
			$query = $this->modelPublic->viewTarif($length,$start,$search,$table);
		}

		$nomor_urut=$start+1;

		if($table=='kl_tarifranap'){
			foreach ($query->result_array() as $dt) {
				$output['data'][]=array(
					$nomor_urut,
					$dt['namaTarif'],
					$dt['kelas'],
					$dt['nama'],
					number_format($dt['tarif'],'0',',','.'),
					number_format($dt['sarana'],'0',',','.'),
					number_format($dt['dokter'],'0',',','.'),
					number_format($dt['bhp'],'0',',','.'),
					number_format($dt['alat'],'0',',','.'),
					'<a class="editTarif" id="'.$dt['kode'].'"><i class="fa fa-pencil"></i></a> <a class="hapusTarif" id="'.$dt['kode'].'"><i class="fa fa-trash"></i></a>'
				);
				$nomor_urut++;
			}
		} else {
			foreach ($query->result_array() as $dt) {
				$output['data'][]=array(
					$nomor_urut,
					$dt['namaTarif'],
					$dt['nama'],
					number_format($dt['tarif'],'0',',','.'),
					number_format($dt['sarana'],'0',',','.'),
					number_format($dt['dokter'],'0',',','.'),
					number_format($dt['bhp'],'0',',','.'),
					number_format($dt['alat'],'0',',','.'),
					'<a class="editTarif" id="'.$dt['kode'].'"><i class="fa fa-pencil"></i></a> <a class="hapusTarif" id="'.$dt['kode'].'"><i class="fa fa-trash"></i></a>'
				);
				$nomor_urut++;
			}
		}
		echo json_encode($output);
	}

	function formTambahTarif(){
		$data['id'] = $this->input->post("id");
		$data['masterjenis'] = $this->db->get("kl_masterjenis")->result();
		$this->load->view("masterdata/tindakan/formTambahTarif",$data);
	}

	function formEditTarif(){
		$table = $this->dekripsi($this->input->post("table"));
		$kode = $this->input->post("kode");

		$data['masterjenis'] = $this->db->get("kl_masterjenis")->result();
		$data['tarif'] = $this->db->get_where($table,array("kode" => $kode))->row();
		$data['kode'] = $kode;
		$data['table'] = $table;
		$this->load->view("masterdata/tindakan/formEditTarif",$data);
	}

	function simpanTarif(){
		$table = $this->dekripsi($this->input->post("table"));
		$namaTarif = $this->input->post("namaTarif");
		$jenisTarif = $this->input->post('jenisTarif');
		$tarif = $this->input->post("tarif");
		$sarana = $this->input->post("sarana");
		$dokter = $this->input->post("dokter");
		$bhp = $this->input->post("bhp");
		$alat = $this->input->post("alat");
		$kelas = $this->input->post('kelas');

		if($table=='kl_tarifranap'){
			$dataArray = array(
				"jenis" => $jenisTarif,
				"kelas" => $kelas,
				"namaTarif" => $namaTarif,
				"tarif" => $tarif,
				"sarana" => $sarana,
				"dokter" => $dokter,
				"bhp" => $bhp,
				"alat" => $alat
			);
		} else {
			$dataArray = array(
				"jenis" => $jenisTarif,
				"namaTarif" => $namaTarif,
				"tarif" => $tarif,
				"sarana" => $sarana,
				"dokter" => $dokter,
				"bhp" => $bhp,
				"alat" => $alat
			);
		}

		

		$this->modelPublic->insert($table,$dataArray);
	}

	function editTarif(){
		$table = $this->dekripsi($this->input->post("table"));
		$namaTarif = $this->input->post("namaTarif");
		$jenisTarif = $this->input->post('jenisTarif');
		$tarif = $this->input->post("tarif");
		$sarana = $this->input->post("sarana");
		$dokter = $this->input->post("dokter");
		$bhp = $this->input->post("bhp");
		$alat = $this->input->post("alat");
		$kode = $this->input->post("kode");
		$kelas = $this->input->post("kelas");

		if($table=='kl_tarifranap'){
			$dataArray = array(
				"kelas" => $kelas,
				"jenis" => $jenisTarif,
				"namaTarif" => $namaTarif,
				"tarif" => $tarif,
				"sarana" => $sarana,
				"dokter" => $dokter,
				"bhp" => $bhp,
				"alat" => $alat
			);
		} else {
			$dataArray = array(
				"jenis" => $jenisTarif,
				"namaTarif" => $namaTarif,
				"tarif" => $tarif,
				"sarana" => $sarana,
				"dokter" => $dokter,
				"bhp" => $bhp,
				"alat" => $alat
			);
		}

		$param = array(
			"kode" => $kode
		);

		$this->modelPublic->update($table,$param,$dataArray);
	}

	function hapusTarif(){
		$kode = $this->input->post('kode');
		$table = $this->dekripsi($this->input->post("table"));

		$param = array(
			"kode" => $kode
		);

		$this->modelPublic->delete($table,$param);
	}

}
