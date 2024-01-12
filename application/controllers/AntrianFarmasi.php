<?php
defined('BASEPATH') OR exit('No direct script access allowed');	

require APPPATH . '/libraries/BaseController.php';

class AntrianFarmasi extends BaseController{
	function __construct(){
		parent::__construct();
		$this->load->model("modelAntrianFarmasi");
		$this->isLoggedIn($this->global['idUser'],2,15);
    }

    function index(){
        $this->global['pageTitle'] = "SIMRS - Antrian Farmasi";
        $data['belumDiProses'] = $this->modelAntrianFarmasi->countOrderResep(0);
        $data['dalamProses'] = $this->modelAntrianFarmasi->countOrderResep(1);
        $data['selesai'] = $this->modelAntrianFarmasi->countOrderResep(2);
        $data['batal'] = $this->modelAntrianFarmasi->countOrderResep(3);
		$this->loadViews("farmasi/antrianfarmasi/bodyAntrianFarmasi",$this->global,$data,"farmasi/antrianfarmasi/footerAntrianFarmasi");
    }

    function cariOrder(){
		$query = $this->input->post("query");
		$cariBerdasarkan = $this->input->post("cariBerdasarkan");
		$data['cariOrder'] = $this->modelAntrianFarmasi->cariOrder($query,$cariBerdasarkan);
		$this->load->view("farmasi/antrianfarmasi/hasilPencarianOrder",$data);
	}

	function processOrder(){
		$this->global['pageTitle'] = "SIMRS - Proses Permintaan Farmasi";
		$noPendaftaran = $this->dekripsi($this->uri->segment(3));

		$getOrder = $this->modelAntrianFarmasi->dataOrderRow($noPendaftaran);
		$data['dataOrderRow'] = $getOrder;
		$data['umur'] = $this->hitungUmur($getOrder->tanggalLahir);
		$data['kategori'] = $this->modelAntrianFarmasi->kategoriSort();
		$this->loadViews("farmasi/antrianfarmasi/bodyProcessOrder",$this->global,$data,"farmasi/antrianfarmasi/footerProcessOrder");
	}

	function dataOrderTable(){
		$noPendaftaran = $this->dekripsi($this->input->post('noPendaftaran'));
		$data['dataOrder'] = $this->modelAntrianFarmasi->daftarObatPesanan($noPendaftaran);
		$data['status'] = $this->modelAntrianFarmasi->dataOrderRow($noPendaftaran)->status;
		$data['noPendaftaran'] = $noPendaftaran;
		$this->load->view("farmasi/antrianfarmasi/dataOrder",$data);
	}

	function hapusPesanan(){
		$idProduk = $this->input->post("idProduk");
		$noPendaftaran = $this->dekripsi($this->input->post("noPendaftaran"));

		$this->modelAntrianFarmasi->hapusPesanan($idProduk,$noPendaftaran);
	}

	function tombolProses(){
		$noPendaftaran = $this->dekripsi($this->input->post('noPendaftaran'));
		$data['status'] = $this->modelAntrianFarmasi->dataOrderRow($noPendaftaran)->status;
		$this->load->view("farmasi/antrianfarmasi/tombolProses",$data);
	}

	function tombolAddItem(){
		$noPendaftaran = $this->dekripsi($this->input->post('noPendaftaran'));
		$data['status'] = $this->modelAntrianFarmasi->dataOrderRow($noPendaftaran)->status;
		$data['noPendaftaran'] = $this->enkripsi($noPendaftaran);
		$this->load->view("farmasi/antrianfarmasi/tombolAddItem",$data);
	}

	function updateStatusOrder(){
		$noPendaftaran = $this->dekripsi($this->input->post("noPendaftaran"));
		$status = $this->input->post("status");

		$this->modelAntrianFarmasi->updateStatusOrder($noPendaftaran,$status);

		if($status==2){
			$this->kurangiStokObat($noPendaftaran);
		}
	}

	function kurangiStokObat($noPendaftaran){
		$dataItem = $this->modelAntrianFarmasi->daftarObatPesanan($noPendaftaran);
		$idStore = $this->global['idStore'];

		foreach($dataItem as $row){
			//update data stok obat gudang
			$tanggalExpired = $row->expiredDate;
			$noBatch = $row->noBatch;

			$currentStok = $this->modelAntrianFarmasi->currentStokGudang($row->id_produk);
			$dataUpdate[] = array(
				"id_produk" => $row->id_produk,
				"stok" => $currentStok-$row->jumlah,
			); 

			if(!empty($tanggalExpired)){
				//data stok expired 
				$dataStokExpired = $this->modelAntrianFarmasi->stokObatPertanggalExpired($row->id_produk,$tanggalExpired);

				$dataUpdateExpItem = array(
					"stok" => $dataStokExpired-$row->jumlah
				);

				$this->modelAntrianFarmasi->kurangiStokExp($dataUpdateExpItem,$row->id_produk,$row->expiredDate);
			}

			if(!empty($noBatch)){
				$currentBatchStok = $this->db->get_where("ap_produk_batch",
					array(
						"id_produk" => $row->id_produk,
						"noBatch" => $noBatch
					)
				)->row()->qty;

				$updateBatchQty = array(
					"qty" => $currentBatchStok-$row->jumlah
				);

				$this->modelPublic->update("ap_produk_batch",
					array(
						"id_produk" => $row->id_produk,
						"noBatch" => $noBatch
					),$updateBatchQty
				);
			}

			$dataKartuStok[] = array(
				"noRefference" => $noPendaftaran,
				"tanggal" => date('Y-m-d'),
				"idUser" => $this->global['idUser'],
				"idProduk" => $row->id_produk,
				"currentStok" => $currentStok,
				"barangKeluar" => $row->jumlah,
				"hargaSatuan" => $row->hpp, 
				"jenisTrx" => 'PENJUALAN',
				"type" => 'GUDANG',
				"noBatch" => $noBatch,
				"tanggalExpired" => $tanggalExpired,
				"pasien" => $this->db->get_where("kl_daftar",array("noPendaftaran" => $noPendaftaran))->row()->idPasien
			);
		}

		$this->db->update_batch("ap_produk",$dataUpdate,"id_produk");
		$this->modelPublic->insertKartuStok($dataKartuStok);
		

		//update hpp
		$this->load->model("modelTrxJurnal");
		$totalHPP = $this->modelAntrianFarmasi->totalHPP($noPendaftaran);

		$akunDebit = '4204';
		$akunKredit = '1401';
		$statement = "Pengambilan Obat Atas No Pendaftararan : ".$noPendaftaran;
		$this->modelTrxJurnal->insertJurnal($noPendaftaran,$akunDebit,$akunKredit,$statement,$totalHPP);
	}

	function statusOrder(){
		$noPendaftaran = $this->dekripsi($this->input->post("noPendaftaran"));
		$status = $this->db->get_where("kl_resepheader",array("noPendaftaran" => $noPendaftaran))->row()->status;

		if($status==0){
            echo "<span class='label label-warning'>Belum Diproses</span>";
       	} elseif($status==1){
            echo "<span class='label label-info'>Dalam Proses</span>";
        } elseif($status==2){
            echo "<span class='label label-success'>Selesai</span>";
        }
	}

	function loadTableOrder(){
		$status = $this->input->post("status");

		if($status!=2){
			$data['viewOrder'] = $this->modelAntrianFarmasi->viewOrder($status);
			$this->load->view("farmasi/antrianfarmasi/viewTableOrder",$data);
		} else {
			$this->load->view("farmasi/antrianfarmasi/viewTableOrderServerSide");
		}
	}

	function datatableOrderServerSide(){
		$draw = $_REQUEST['draw'];
		$length = $_REQUEST['length'];
		$start = $_REQUEST['start'];
		$search = $_REQUEST['search']["value"];

		$total = $this->modelAntrianFarmasi->totalOrderDatatable();
		$output = array();
		$output['draw']	= $draw;
		$output['recordsTotal'] = $output['recordsFiltered']=$total;
		$output['data'] = array();

		if($search!=""){
			$query = $this->modelAntrianFarmasi->viewOrderServerSide($length,$start,$search);
			$output['recordsTotal'] = $output['recordsFiltered'] = $query->num_rows();
		} else {
			$query = $this->modelAntrianFarmasi->viewOrderServerSide($length,$start,$search);
		}

		$nomor_urut=$start+1;

		foreach ($query->result_array() as $dt) {
			$encoded = $this->enkripsi($dt['noPendaftaran']);
			$tanggal = date_format(date_create($dt['tanggal']),'d M Y H:i');
			$tanggalLahir = date_format(date_create($dt['tanggalLahir']),'d M Y H:i');

			$output['data'][]=array($nomor_urut,"<a href='".base_url('antrianFarmasi/processOrder/'.$encoded)."'>".$dt['noPendaftaran']."</a>",$dt['idPasien'],$tanggal,$dt['namaPasien'],$tanggalLahir,$dt['namaDokter'],$dt['poliklinik']);
			$nomor_urut++;
		}

		echo json_encode($output);
	}

	function formEditTanggalExpired(){
		$idProduk = $this->input->post("idProduk");
		$data['dataExpiredDate'] = $this->modelAntrianFarmasi->expiredDatePerproduk($idProduk);
		$data['dataItem'] = $this->db->get_where("ap_produk",array("id_produk" => $idProduk))->row();
		$data['noPendaftaran'] = $this->input->post("noPendaftaran");
		$this->load->view("farmasi/antrianfarmasi/formEditTanggalExpired",$data);
	}

	function ubahExpiredDate(){
		$idProduk = $this->input->post("idProduk");
		$tanggal = $this->input->post("tanggal");
		$noPendaftaran = $this->input->post("noPendaftaran");

		$dataUpdate = array(
			"expiredDate" => $tanggal
		);

		$this->modelAntrianFarmasi->updateExpiredDate($dataUpdate,$idProduk,$noPendaftaran);
	}

	function tampilkanItemObat(){
		$idKategori = isset($_POST['idKategori']) ? $_POST['idKategori'] : "";
		$limitStart = isset($_POST['limitStart']) ? $_POST['limitStart'] : 0;
		$search = isset($_POST['search']) ? $_POST['search'] : "";

		$perPage = 12;

		if($limitStart==0){
			$limitOnNextPage = 0;
		} else {
			$limitOnNextPage = ($limitStart-1)*$perPage;
		}

		//hitung jumlah produk
		$numRows = $this->modelAntrianFarmasi->numRowsJumlahProduk($search,$idKategori);

		//jumlah halaman
		$data['jumlahHalaman'] = ceil($numRows/$perPage);

		//tampilkan produk 
		$viewMenu = $this->modelAntrianFarmasi->viewItemObat($search,$limitOnNextPage,$idKategori,$perPage);
		$data['viewItem'] = $viewMenu;
		$data['numRowsTotal'] = $numRows;
		$data['urutanNo'] = $limitStart;
		$this->load->view("farmasi/antrianfarmasi/itemObatDatatables",$data);
	}

	function tambahItemResep(){
		$idProduk = $this->input->post("idProduk");
		$noPendaftaran = $this->dekripsi($this->input->post("noPendaftaran"));

		//cek resep jika sudah tersedia
		$cekResepExist = $this->modelAntrianFarmasi->cekResepExist($idProduk,$noPendaftaran);

		if($cekResepExist > 0){
			$currentQtyResep = $this->modelAntrianFarmasi->currentQtyResep($idProduk,$noPendaftaran);

			$dataUpdate = array(
				"jumlah" => $currentQtyResep+1
			);

			$this->modelAntrianFarmasi->updateQtyResep($dataUpdate,$idProduk,$noPendaftaran);
		} else {
			$dataInsert = array(
				"noPendaftaran" => $noPendaftaran,
				"idObat" => $idProduk,
				"jumlah" => 1,
				"harga" => $this->modelPublic->getValueOfTable("ap_produk","harga",array("id_produk" => $idProduk)),
				"aturan" => '',
				"idUser" => $this->global['idUser'],
				"expiredDate" => $this->modelAntrianFarmasi->getProdukExpiredFirst($idProduk)
			);
			
			$this->modelAntrianFarmasi->insertResep($dataInsert);
		}	
	}

	function formPilihNoBatch(){
		$idProduk = $this->input->post("idProduk");
		$data['batch'] = $this->db->get_where("ap_produk_batch",array("id_produk" => $idProduk));
		$data['dataItem'] = $this->db->get_where("ap_produk",array("id_produk" => $idProduk))->row();
		$this->load->view("farmasi/antrianfarmasi/formPilihBatchNo",$data);
	}

	function pilihBatchSQL(){
		$noBatch = $this->input->post("noBatch");
		$idProduk = $this->input->post("idProduk");
		$noPendaftaran = $this->dekripsi($this->input->post("noPendaftaran"));

		$dataUpdate = array(
			"noBatch" => $noBatch
		);

		$this->modelPublic->update("kl_resep",array("noPendaftaran" => $noPendaftaran,"idObat" => $idProduk),$dataUpdate);
	}

	function cetakResep(){
		$this->load->model("modelInputTindakan");
		$this->global['pageTitle'] = "SIMRS - Input Tindakan Rawat Jalan";
		$noPendaftaran = $this->dekripsi($this->uri->segment(3));
		$data['header'] = $this->db->get_where("viewheaderrs")->row();
		$data['cart'] = $this->modelInputTindakan->tampilkanCartResep($noPendaftaran);
		$this->loadViews("inputtindakan/cetakResep",$this->global,$data,"pendaftaran/footerCetak");
	}
}