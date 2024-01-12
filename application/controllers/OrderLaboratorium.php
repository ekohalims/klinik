<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class OrderLaboratorium extends BaseController{
	function __construct(){
		parent::__construct();
		$this->load->model("modelOrderLaboratorium");
		$this->isLoggedIn($this->global['idUser'],2,10);
	}

	function index(){
		$this->global['pageTitle'] = "SIMRS - Order Laboratorium";
		$data['batal'] = $this->modelOrderLaboratorium->countOrder(3);
		$data['belumDiProses'] = $this->modelOrderLaboratorium->countOrder(0);
		$data['dalamProses'] = $this->modelOrderLaboratorium->countOrder(1);
		$data['selesai'] = $this->modelOrderLaboratorium->countOrder(2);
		$this->loadViews("laboratorium/orderlaboratorium/bodyOrderLaboratorium",$this->global,$data,"laboratorium/orderlaboratorium/footerOrderLaboratorium");
	}

	function cariOrder(){
		$query = $this->input->post("query");
		$cariBerdasarkan = $this->input->post("cariBerdasarkan");
		$data['cariOrder'] = $this->modelOrderLaboratorium->cariOrder($query,$cariBerdasarkan);
		$this->load->view("laboratorium/orderlaboratorium/hasilPencarianOrder",$data);
	}

	function processOrder(){
		$this->global['pageTitle'] = "SIMRS - Proses Permintaan Laboratorium";
		$noPendaftaran = $this->dekripsi($this->uri->segment(3));

		$getOrder = $this->modelOrderLaboratorium->dataOrderRow($noPendaftaran);
		$data['dataOrderRow'] = $getOrder;

		if(!empty($getOrderTanggalLahir)){
			$data['umur'] = $this->hitungUmur($getOrder->tanggalLahir);
		} else {
			$data['umur'] = '';
		}
		$data['header'] = $this->db->get_where("kl_klinikinfo",array("id" => 1))->row();
		$this->loadViews("laboratorium/orderlaboratorium/bodyProcessOrder",$this->global,$data,"laboratorium/orderlaboratorium/footerProcessOrder");
	}

	function datatableLab(){
		$this->load->model("modelAntrian");
		$data['item'] = $this->modelAntrian->tampilkanLabAktif();
		$this->load->view("antrian/datatableLab",$data);
	}

	function catatanLab(){
		$id = $this->input->post("id");

		$data['namaLab'] = $this->db->get_where("kl_labitem",array("id" => $id))->row()->namaLab;
		$data['id'] = $id;
		$this->load->view("laboratorium/orderlaboratorium/catatanLab",$data);
	}

	function addLabItem(){
		$this->load->model("modelAntrian");

		$idLab = $this->input->post("id");
		$noPendaftaran = $this->dekripsi($this->input->post("noPendaftaran"));
		$catatan = $this->input->post("catatan");
		$hargaLab = $this->modelAntrian->hargaLab($id);
		$idUser = $this->global['idUser'];

		$dataArray = array(
			"noPendaftaran" => $noPendaftaran,
			"idLab" => $idLab,
			"harga" => $hargaLab,
			"catatan" => $catatan,
			"idUser" => $idUser,
			"tanggal" => date('Y-m-d H:i:s'),
			"status" => 0
		);

		$this->modelAntrian->simpanOrderLab($dataArray);
	}

	function dataOrderTable(){
		$this->load->model("modelOrderLaboratorium");
		$noPendaftaran = $this->dekripsi($this->input->post('noPendaftaran'));
		$data['dataOrder'] = $this->modelOrderLaboratorium->dataOrder($noPendaftaran);
		$data['statusOrder'] = $this->db->get_where("kl_orderlabheader",array("noPermintaan" => $noPendaftaran))->row()->status;
		$data['noPendaftaran'] = $this->input->post("noPendaftaran");
		$this->load->view("laboratorium/orderlaboratorium/dataOrder",$data);
	}

	function tombolProses(){
		$noPendaftaran = $this->dekripsi($this->input->post('noPendaftaran'));
		$data['status'] = $this->modelOrderLaboratorium->dataOrderRow($noPendaftaran)->status;
		$this->load->view("laboratorium/orderlaboratorium/tombolProses",$data);
	}

	function tombolAddItem(){
		$noPendaftaran = $this->dekripsi($this->input->post('noPendaftaran'));
		$data['status'] = $this->modelOrderLaboratorium->dataOrderRow($noPendaftaran)->status;
		$this->load->view("laboratorium/orderlaboratorium/tombolAddItem",$data);
	}

	function statusOrderLab(){
		$noPendaftaran = $this->dekripsi($this->input->post("noPendaftaran"));
		$status = $this->db->get_where("kl_orderlabheader",array("noPermintaan" => $noPendaftaran))->row()->status;

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

		$this->modelOrderLaboratorium->updateStatusOrder($noPendaftaran,$status);
	}

	function formHasilLab(){
		$id = $this->input->post("id");
		$noPendaftaran = $this->dekripsi($this->input->post("noPendaftaran"));
		$data['id'] = $id;
		$data['hasil'] = $this->db->get_where("kl_orderlab",array("noPermintaan" => $noPendaftaran,"idLab" => $id))->row()->hasil;
		$this->load->view("laboratorium/orderlaboratorium/formHasilLab",$data);
	}

	function saveHasilOrder(){
		$id = $this->input->post("id");
		$hasil = $this->input->post("hasil");
		$noPendaftaran = $this->dekripsi($this->input->post("noPendaftaran"));

		$this->modelOrderLaboratorium->updateHasilLab($id,$hasil,$noPendaftaran);
	}

	function loadTableOrder(){
		$status = $this->input->post("status");
		$data['status'] = $status;
		$this->load->view("laboratorium/orderlaboratorium/viewTableOrderServerSide",$data);
	}

	function datatableOrderServerSide(){
		$draw = $_REQUEST['draw'];
		$length = $_REQUEST['length'];
		$start = $_REQUEST['start'];
		$search = $_REQUEST['search']["value"];
		$status = $this->input->post('status');

		$total = $this->modelOrderLaboratorium->totalOrderDatatable();
		$output = array();
		$output['draw']	= $draw;
		$output['recordsTotal'] = $output['recordsFiltered']=$total;
		$output['data'] = array();

		if($search!=""){
			$query = $this->modelOrderLaboratorium->viewOrderServerSide($length,$start,$search,$status);
			$output['recordsTotal'] = $output['recordsFiltered'] = $query->num_rows();
		} else {
			$query = $this->modelOrderLaboratorium->viewOrderServerSide($length,$start,$search,$status);
		}

		$nomor_urut=$start+1;

		foreach ($query->result_array() as $dt) {
			$encoded = $this->enkripsi($dt['noPermintaan']);
			$tanggal = date_format(date_create($dt['tanggal']),'d M Y H:i');
			$tanggalLahir = date_format(date_create($dt['tanggalLahir']),'d M Y');

			$output['data'][]=array(
				$nomor_urut,
				"<a href='".base_url('orderLaboratorium/processOrder/'.$encoded)."'><span class='label label-info'>".$dt['noPermintaan']."</span></a>",
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
		$this->global['pageTitle'] = "SIMRS - Order Laboratorium";
		$noPendaftaran = $this->dekripsi($this->uri->segment(3));
		$idLab = $this->uri->segment(4);
		$data['header'] = $this->db->get_where("kl_klinikinfo",array("id" => 1))->row();
		$getOrder = $this->modelOrderLaboratorium->dataOrderRow($noPendaftaran);
		$data['dataOrderRow'] = $getOrder;
		$data['umur'] = $this->hitungUmur($getOrder->tanggalLahir);
		$data['hasilLab'] = $this->modelOrderLaboratorium->hasilLab($noPendaftaran,$idLab);
		$data['dokterPemeriksa'] = $this->db->get_where("kl_dokter",array("id_dokter" => $getOrder->idDokterPemeriksa))->row()->nama;
		$this->loadViews("laboratorium/orderlaboratorium/printHasil",$this->global,$data,"footer_empty");
	}

	function tampilkanDokterPemeriksa(){
		$noPendaftaran = $this->dekripsi($this->input->post("noPendaftaran"));
		$status = $this->db->get_where("kl_orderlabheader",array("noPermintaan" => $noPendaftaran))->row()->status;

		if($status==1){
			$data['dokter'] = $this->modelPublic->daftarDokterAktif();
			$this->load->view("laboratorium/orderlaboratorium/dropdownDokter",$data);
		} elseif($status==2){
			$idDokter = $this->db->get_where("kl_orderlabheader",array("noPermintaan" => $noPendaftaran))->row()->idDokter;
			$data['namaDokter'] = $this->db->get_where("kl_dokter",array("id_dokter" => $idDokter))->row()->nama;
			$this->load->view("laboratorium/orderlaboratorium/dokterPemeriksaTerpilih",$data);
		}
	}

	function updateDokterPemeriksa(){
		$noPendaftaran = $this->dekripsi($this->input->post("noPendaftaran"));
		$idDokter = $this->input->post("idDokter");

		$dataUpdate = array(
			"idDokter" => $idDokter
		);

		$this->modelOrderLaboratorium->updateDokterPemeriksa($dataUpdate,$noPendaftaran);
	}
}