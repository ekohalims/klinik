<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class OrderRadiologi extends BaseController{
	function __construct(){
		parent::__construct();
		$this->load->model("modelOrderRadiologi");
		$this->isLoggedIn($this->global['idUser'],2,12);
	}

	function index(){
		$this->global['pageTitle'] = "SIMRS - Order Radiologi";
		$data['batal'] = $this->modelOrderRadiologi->countOrder(3);
		$data['belumDiProses'] = $this->modelOrderRadiologi->countOrder(0);
		$data['dalamProses'] = $this->modelOrderRadiologi->countOrder(1);
		$data['selesai'] = $this->modelOrderRadiologi->countOrder(2);
		$this->loadViews("radiologi/orderradiologi/bodyOrderRadiologi",$this->global,$data,"radiologi/orderradiologi/footerOrderRadiologi");
	}

	function cariOrder(){
		$query = $this->input->post("query");
		$cariBerdasarkan = $this->input->post("cariBerdasarkan");
		$data['cariOrder'] = $this->modelOrderRadiologi->cariOrder($query,$cariBerdasarkan);
		$this->load->view("radiologi/orderradiologi/hasilPencarianOrder",$data);
	}

	function processOrder(){
		$this->global['pageTitle'] = "SIMRS - Proses Permintaan Radiologi";
		$noPendaftaran = $this->dekripsi($this->uri->segment(3));

		$getOrder = $this->modelOrderRadiologi->dataOrderRow($noPendaftaran);
		$data['dataOrderRow'] = $getOrder;
		$data['umur'] = $this->hitungUmur($getOrder->tanggalLahir);
		$this->loadViews("radiologi/orderradiologi/bodyProcessOrder",$this->global,$data,"radiologi/orderradiologi/footerProcessOrder");
	}

	function dataOrderTable(){
		$noPendaftaran = $this->dekripsi($this->input->post('noPendaftaran'));
		$data['dataOrder'] = $this->modelOrderRadiologi->dataOrder($noPendaftaran);
		$data['statusOrder'] = $this->db->get_where("kl_orderradiologiheader",array("noPermintaan" => $noPendaftaran))->row()->status;
		$data['noPendaftaran'] = $this->input->post('noPendaftaran');
		$this->load->view("radiologi/orderradiologi/dataOrder",$data);
	}

	function tombolProses(){
		$noPendaftaran = $this->dekripsi($this->input->post('noPendaftaran'));
		$data['status'] = $this->modelOrderRadiologi->dataOrderRow($noPendaftaran)->status;
		$this->load->view("radiologi/orderradiologi/tombolProses",$data);
	}

	function tombolAddItem(){
		$noPendaftaran = $this->dekripsi($this->input->post('noPendaftaran'));
		$data['status'] = $this->modelOrderRadiologi->dataOrderRow($noPendaftaran)->status;
		$this->load->view("radiologi/orderradiologi/tombolAddItem",$data);
	}

	function datatableRad(){
		$this->load->model("modelAntrian");
		$data['item'] = $this->modelAntrian->tampilkanRadAktif();
		$this->load->view("antrian/datatableRad",$data);
	}

	function catatanRad(){
		$id = $this->input->post("id");

		$data['namaRad'] = $this->db->get_where("kl_radiologiitem",array("id" => $id))->row()->namaRadiologi;
		$data['id'] = $id;
		$this->load->view("radiologi/orderradiologi/catatanRad",$data);
	}
	
	function addRadItem(){
		$this->load->model("modelAntrian");

		$id = $this->input->post("id");
		$noPendaftaran = $this->dekripsi($this->input->post("noPendaftaran"));
		$hargaRad = $this->modelAntrian->hargaRad($id);
		$idUser = $this->global['idUser'];
		$catatan = $this->input->post("catatan");

		$dataArray = array(
			"noPendaftaran" => $noPendaftaran,
			"idRadiologi" => $id,
			"harga" => $hargaRad,
			"catatan" => $catatan,	
			"idUser" => $idUser,
			"tanggal" => date('Y-m-d H:i:s'),
			"status" => 0
		);

		$this->modelAntrian->simpanOrderRad($dataArray);
	}

	function statusOrderLab(){
		$noPendaftaran = $this->dekripsi($this->input->post("noPendaftaran"));
		$status = $this->db->get_where("kl_orderradiologiheader",array("noPermintaan" => $noPendaftaran))->row()->status;

		if($status==0){
            echo "<span class='label label-warning'>Belum Diproses</span>";
       	} elseif($status==1){
            echo "<span class='label label-info'>Dalam Proses</span>";
        } elseif($status==2){
            echo "<span class='label label-success'>Selesai</span>";
        }
	}

	function updateStatusOrder(){
		$noPendaftaran = $this->dekripsi($this->input->post("noPendaftaran"));
		$status = $this->input->post("status");

		$this->modelOrderRadiologi->updateStatusOrder($noPendaftaran,$status);
	}

	function formHasilLab(){
		$id = $this->input->post("id");
		$noPendaftaran = $this->dekripsi($this->input->post("noPendaftaran"));
		$data['id'] = $id;
		$data['hasil'] = $this->db->get_where("kl_orderradiologi",array("noPermintaan" => $noPendaftaran,"idRadiologi" => $id))->row()->hasil;
		$this->load->view("radiologi/orderradiologi/formHasilLab",$data);
	}

	function saveHasilOrder(){
		$id = $this->input->post("id");
		$hasil = $this->input->post("hasil");
		$noPendaftaran = $this->dekripsi($this->input->post("noPendaftaran"));

		$this->modelOrderRadiologi->updateHasilLab($id,$hasil,$noPendaftaran);
	}

	function loadTableOrder(){
		$status = $this->input->post("status");
		$data['status'] = $status;

		$this->load->view("radiologi/orderradiologi/viewTableOrderServerSide",$data);
	}

	function datatableOrderServerSide(){
		$draw = $_REQUEST['draw'];
		$length = $_REQUEST['length'];
		$start = $_REQUEST['start'];
		$search = $_REQUEST['search']["value"];
		$status = $this->input->post('status');

		$total = $this->modelOrderRadiologi->totalOrderDatatable();
		$output = array();
		$output['draw']	= $draw;
		$output['recordsTotal'] = $output['recordsFiltered']=$total;
		$output['data'] = array();

		if($search!=""){
			$query = $this->modelOrderRadiologi->viewOrderServerSide($length,$start,$search,$status);
			$output['recordsTotal'] = $output['recordsFiltered'] = $query->num_rows();
		} else {
			$query = $this->modelOrderRadiologi->viewOrderServerSide($length,$start,$search,$status);
		}

		$nomor_urut=$start+1;

		foreach ($query->result_array() as $dt) {
			$encoded = $this->enkripsi($dt['noPermintaan']);
			$tanggal = date_format(date_create($dt['tanggal']),'d M Y H:i');
			$tanggalLahir = date_format(date_create($dt['tanggalLahir']),'d M Y H:i');

			$output['data'][]=array(
				$nomor_urut,
				"<a href='".base_url('orderRadiologi/processOrder/'.$encoded)."'>".$dt['noPermintaan']."</a>",
				$dt['idPasien'],
				$tanggal,
				$dt['namaPasien'],
				$tanggalLahir,
				$dt['namaDokter'],
				$dt['poliklinik']
			);
			$nomor_urut++;
		}

		echo json_encode($output);
	}

	function printHasil(){
		$this->global['pageTitle'] = "SIMRS - Order Radiologi";
		$noPendaftaran = $this->dekripsi($this->uri->segment(3));
		$idLab = $this->uri->segment(4);
		$data['header'] = $this->db->get_where("kl_klinikinfo",array("id" => 1))->row();
		$getOrder = $this->modelOrderRadiologi->dataOrderRow($noPendaftaran);
		$data['dataOrderRow'] = $getOrder;
		$data['umur'] = $this->hitungUmur($getOrder->tanggalLahir);
		$data['hasilLab'] = $this->modelOrderRadiologi->hasilRad($noPendaftaran,$idLab);
		$data['dokterPemeriksa'] = $this->db->get_where("kl_dokter",array("id_dokter" => $getOrder->idDokterPemeriksa))->row()->nama;
		$this->loadViews("radiologi/orderradiologi/printHasil",$this->global,$data,"footer_empty");
	}

	function tampilkanDokterPemeriksa(){
		$noPendaftaran = $this->dekripsi($this->input->post("noPendaftaran"));
		$status = $this->db->get_where("kl_orderradiologiheader",array("noPermintaan" => $noPendaftaran))->row()->status;

		if($status==1){
			$data['dokter'] = $this->modelPublic->daftarDokterAktif();
			$this->load->view("radiologi/orderradiologi/dropdownDokter",$data);
		} elseif($status==2){
			$idDokter = $this->db->get_where("kl_orderradiologiheader",array("noPermintaan" => $noPendaftaran))->row()->idDokter;
			$data['namaDokter'] = $this->db->get_where("kl_dokter",array("id_dokter" => $idDokter))->row()->nama;
			$this->load->view("radiologi/orderradiologi/dokterPemeriksaTerpilih",$data);
		}
	}

	function updateDokterPemeriksa(){
		$noPendaftaran = $this->dekripsi($this->input->post("noPendaftaran"));
		$idDokter = $this->input->post("idDokter");

		$dataUpdate = array(
			"idDokter" => $idDokter
		);

		$this->modelOrderRadiologi->updateDokterPemeriksa($dataUpdate,$noPendaftaran);
	}
}