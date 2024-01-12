<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Laporan extends BaseController{
	function __construct(){
		parent::__construct();
		$this->load->model("modelLaporan");
		$this->isLoggedIn($this->global['idUser'],2,61);
	}

	function index(){
		$this->global['pageTitle'] = "SIMRS - Laporan";
		$this->loadViews("laporan/bodyLaporan",$this->global,NULL,"footer_empty");
	}

	/**laporan pendapatan**/
	function pendapatan(){
		$this->global['pageTitle'] = "SIMRS - Laporan Pendapatan";
		$data['poli'] = $this->modelPublic->daftarPoliAktif();
		$data['typeBayar'] = $this->db->get("ap_payment_type")->result();
		$this->loadViews("laporan/pendapatan/bodyLaporanPendapatan",$this->global,$data,"laporan/pendapatan/footerLaporanPendapatan");
	}

	function dropdownDokter(){
		$idPoliklinik = $this->input->post("idPoliklinik");

		$data['dokter'] = $this->db->get_where("kl_dokter",
			array("
				idPoliklinik" => $idPoliklinik,
				"status" =>1,
				"isDelete" => 1))->result();

		$this->load->view("antrian/select2Dokter",$data);
	}

	function select2Pasien(){
		$q 	= $_GET['term'];
		$pasien = $this->modelPublic->getPasienAjax($q);

		$dataArray = array();
		foreach($pasien->result() as $row){
			$dataArray[] = array(
				"id" 	=> $row->noPasien,
				"text"	=> $row->noPasien."/".$row->namaLengkap,
			);
		}

		echo json_encode($dataArray);
	}

	function viewReportPendapatan(){
		$dateStart = $this->input->post('dateStart');
		$dateEnd = $this->input->post("dateEnd");
		$poli = $this->input->post("poli");
		$dokter = $this->input->post("dokter");
		$pasien = $this->input->post("pasien");
		$typeBayar = $this->input->post("typeBayar");
		$subAccount = $this->input->post("subAccount");
		$jenis = $this->input->post("jenis");

		$data['viewReportPendapatan'] = $this->modelLaporan->viewReportPendapatan($dateStart,$dateEnd,$poli,$dokter,$pasien,$typeBayar,$subAccount,$jenis);
		$data['periode'] = date_format(date_create($dateStart),'d F Y')." - ".date_format(date_create($dateEnd),'d M Y');
		$this->load->view("laporan/pendapatan/viewReportPendapatan",$data);
	}

	function cetakInvoice(){
		$this->global['pageTitle'] = "SIMRS - Invoice Pembayaran";
		$this->load->model("modelKasir");
		$noInvoice = $this->dekripsi($this->uri->segment(3));
		$noPendaftaran = $this->db->get_where("kl_invoice",array("noInvoice" => $noInvoice))->row()->noPendaftaran;
		$asalDaftar = $this->db->get_where("kl_daftar",array("noPendaftaran" => $noPendaftaran))->row()->asalDaftar;

		$data['asalDaftar'] = $asalDaftar;

		$data['header'] = $this->db->get_where("kl_klinikinfo",array("id" => 1))->row();
		$data['dataOrder'] = $this->modelKasir->dataOrderInvoice($noInvoice);
		$data['tindakan'] = $this->modelKasir->viewTindakan($noPendaftaran,$asalDaftar);
		$data['farmasi'] = $this->modelKasir->viewFarmasi($noPendaftaran);
		$data['laboratorium'] = $this->modelKasir->viewLaboratorium($noPendaftaran);
		$data['radiologi'] = $this->modelKasir->viewRadiologi($noPendaftaran);
		$data['total'] = $this->modelKasir->totalTransaksi($noPendaftaran);

		if($asalDaftar=='RANAP'){
			$data['kamarPasien'] = $this->modelKasir->viewKamar($noPendaftaran);
		}
		
		$this->loadViews("kasir/invoicePembayaran",$this->global,$data,"footer_empty");
	}

	function subAccount(){
		$id = $this->input->post("id");
		$data['subAccount'] = $this->modelLaporan->getBankBayar($id);
		$this->load->view("laporan/subAccountForm",$data);
	}

	function buttonExport(){
		$this->load->view("laporan/pendapatan/buttonExport");
	}
	/**end laporan pendapatan**/

	function rekamMedis(){
		$this->global['pageTitle'] = "SIMRS - Laporan Rekam Medis";
		$data['poli'] = $this->modelPublic->daftarPoliAktif();
		$data['typeBayar'] = $this->db->get("ap_payment_type")->result();
		$this->loadViews("laporan/rekammedis/bodyRekamMedis",$this->global,$data,"laporan/rekammedis/footerRekamMedis");
	}

	function select2Diagnosa(){
		$q 	= $_GET['term'];
		$pasien = $this->modelPublic->getDiagnosaAjax($q);

		$dataArray = array();
		foreach($pasien->result() as $row){
			$dataArray[] = array(
				"id" 	=> $row->id,
				"text"	=> $row->code."/".$row->str,
			);
		}

		echo json_encode($dataArray);
	}

	function viewRekamMedis(){
		$dateStart = $this->input->post('dateStart');
		$dateEnd = $this->input->post("dateEnd");
		$poli = $this->input->post("poli");
		$dokter = $this->input->post("dokter");
		$pasien = $this->input->post("pasien");
		$diagnosa = $this->input->post("diagnosa");
		$jenis = $this->input->post("jenis");

		//include model kasir karena banyak fungsi yang digunakan disini
		$this->load->model("modelKasir");

		$data['viewRekamMedis'] = $this->modelLaporan->viewRekamMedis($dateStart,$dateEnd,$poli,$dokter,$pasien,$diagnosa,$jenis);
		$this->load->view("laporan/rekammedis/viewRekamMedis",$data);
	}

	//laporan kunjungan
	function kunjungan(){
		$this->global['pageTitle'] = "SIMRS - Laporan Kunjungan";
		$this->loadViews("laporan/kunjungan/bodyKunjungan",$this->global,NULL,"laporan/kunjungan/footerKunjungan");
	}

	function viewLaporanKunjungan(){
		$dateStart = $this->input->post("dateStart");
		$dateEnd = $this->input->post("dateEnd");
		$pasien = $this->input->post("pasien");

		$data['viewLaporanKunjungan'] = $this->modelLaporan->viewLaporanKunjungan($dateStart,$dateEnd,NULL,NULL,$pasien,NULL);
		$this->load->view("laporan/kunjungan/viewLaporanKunjungan",$data);
	}
	//end laporan kunjungan///

	//laporan komisi dokter
	function komisiDokter(){
		$this->global['pageTitle'] = "SIMRS - Komisi Dokter";
		$data['viewDokter'] = $this->modelPublic->daftarDokterAktif();
		$this->loadViews("laporan/komisidokter/bodyKomisiDokter",$this->global,$data,"laporan/komisidokter/footerKomisiDokter");
	}

	function viewLaporanKomisiDokter(){
		$dateStart = $this->input->post("dateStart");
		$dateEnd = $this->input->post("dateEnd");
		$dokter = $this->input->post("dokter");
		$jenis = $this->input->post("jenis");

		$data['viewKomisiDokter'] = $this->modelLaporan->viewKomisiDokter($dateStart,$dateEnd,$dokter,$jenis);
		$data['dateStart'] = $dateStart;
		$data['dateEnd'] = $dateEnd;
		$data['dokter'] = $dokter;
		$data['jenis'] = $jenis;
		$data['header'] = $this->db->get_where("kl_klinikinfo",array("id" => 1))->row();
		$data['periode'] = date_format(date_create($dateStart),'d M Y')." - ".date_format(date_create($dateEnd),'d M Y');
		$this->load->view("laporan/komisidokter/viewLaporanKomisiDokter",$data);
	}
	//end laporan komisi dokter

	//laporan pemakaian obat
	function pemakaianObat(){
		$this->global['pageTitle'] = "SIMRS - Pemakaian Obat";
		$data['poli'] = $this->modelPublic->daftarPoliAktif();
		$this->loadViews("laporan/pemakaianobat/bodyPemakaianObat",$this->global,$data,"laporan/pemakaianobat/footerPemakaianObat");
	}

	function viewReportPengeluaranObat(){
		$dateStart = $this->input->post('dateStart');
		$dateEnd = $this->input->post("dateEnd");
		$poli = $this->input->post("poli");
		$dokter = $this->input->post("dokter");
		$pasien = $this->input->post("pasien");
		$jenisLaporan = $this->input->post("jenisLaporan");

		$data['header'] = $this->db->get_where("kl_klinikinfo",array("id" => 1))->row();
		$data['periode'] = date_format(date_create($dateStart),'d M Y')." - ".date_format(date_create($dateEnd),'d M Y');

		if($jenisLaporan=='akumulasi' || $jenisLaporan==''){
			$data['viewReport'] = $this->modelLaporan->viewReportPengeluaranObatAkumulasi($dateStart,$dateEnd,$poli,$dokter,$pasien);
			$this->load->view("laporan/pemakaianobat/viewReportPengeluaranObatAkumulasi",$data);
		} elseif($jenisLaporan=='perpendaftaran'){
			$data['headerResep'] = $this->modelLaporan->headerResep($dateStart,$dateEnd,$poli,$dokter,$pasien);
			$this->load->view("laporan/pemakaianobat/viewReportPengeluaranObatPerinvoice",$data);
		}
	}
	//end laporan pemakaian obat

	//laporan laboratorium
	function laporanLaboratorium(){
		$this->global['pageTitle'] = "SIMRS - Laporan Laboratorium";
		$data['poli'] = $this->modelPublic->daftarPoliAktif();
		$data['dokter'] = $this->modelPublic->daftarDokterAktif();
		$data['listLab'] = $this->modelPublic->listLabAktif();
		$this->loadViews("laporan/laboratorium/bodyLaporanLaboratorium",$this->global,$data,"laporan/laboratorium/footerLaboratorium");
	}

	function viewLaporanLaboratorium(){
		$dateStart = $this->input->post("dateStart");
		$dateEnd = $this->input->post("dateEnd");
		$dokter = $this->input->post("dokter");
		$pasien = $this->input->post("pasien");
		$itemLab = $this->input->post("itemLab");

		$data['header'] = $this->db->get_where("kl_klinikinfo",array("id" => 1))->row();
		$data['periode'] = date_format(date_create($dateStart),'d M Y')." - ".date_format(date_create($dateEnd),'d M Y');

		$data['laporanLab'] = $this->modelLaporan->viewLaporanLab($dateStart,$dateEnd,$dokter,$pasien,$itemLab);
		$this->load->view("laporan/laboratorium/viewLaporanLaboratorium",$data);
	}
	//end laporan laboratorium

	//laporan radiologi
	function laporanRadiologi(){
		$this->global['pageTitle'] = "SIMRS - Laporan Radiologi";
		$data['poli'] = $this->modelPublic->daftarPoliAktif();
		$data['dokter'] = $this->modelPublic->daftarDokterAktif();
		$data['listRadiologi'] = $this->modelPublic->listRadiologiAktif();
		$this->loadViews("laporan/radiologi/bodyLaporanRadiologi",$this->global,$data,"laporan/radiologi/footerRadiologi");
	}

	function viewLaporanRadiologi(){
		$dateStart = $this->input->post("dateStart");
		$dateEnd = $this->input->post("dateEnd");
		$dokter = $this->input->post("dokter");
		$pasien = $this->input->post("pasien");
		$itemRadiologi = $this->input->post("itemLab");

		$data['header'] = $this->db->get_where("kl_klinikinfo",array("id" => 1))->row();
		$data['periode'] = date_format(date_create($dateStart),'d M Y')." - ".date_format(date_create($dateEnd),'d M Y');

		$data['laporanRadiologi'] = $this->modelLaporan->viewLaporanRadiologi($dateStart,$dateEnd,$dokter,$pasien,$itemRadiologi);
		$this->load->view("laporan/radiologi/viewLaporanRadiologi",$data);
	}
	//end laporan radiologi

	//laporan purchase ordder
	function purchaseOrder(){
		$data['supplier'] = $this->db->get("supplier")->result();
		$this->global['pageTitle'] = "SIMRS - Laporan Purchase Order";
		$this->loadViews("laporan/purchaseorder/bodyLaporanPurchaseOrder",$this->global,$data,"laporan/purchaseorder/footerPurchaseOrder");
	}

	function viewReportPurchaseOrder(){
		$dateStart = $_POST['dateStart'];
		$dateEnd = $_POST['dateEnd'];
		$supplier = $_POST['supplier'];
		$status = $_POST['status'];

		$data['viewReport'] = $this->modelLaporan->viewReportPurchaseOrder($dateStart,$dateEnd,$supplier,$status);
		$data['header'] = $this->db->get_where("kl_klinikinfo",array("id" => 1))->row();
		$data['dateStart'] = date_format(date_create($dateStart),'d M Y');
		$data['dateEnd'] = date_format(date_create($dateEnd),'d M Y');
		$this->load->view("laporan/purchaseorder/viewReportPurchaseOrder",$data);
	}
	//end laporan purchase order

	//laporan hutang po
	function hutangPO(){
		$data['supplier'] = $this->db->get("supplier")->result();
		$this->global['pageTitle'] = "SIMRS - Laporan Hutang Pembelian";
		$this->loadViews("laporan/hutangpo/body_hutang_po",$this->global,$data,"laporan/hutangpo/footerHutangPO");
	}

	function dataHutangPO(){
		$data['tagihan_hutang'] = $this->modelLaporan->hutang_ditagih();
		$this->load->view("laporan/hutangpo/dataHutangPO",$data);
	}

	function dataHutangPOFilter(){
		$supplier = $_POST['supplier'];
		$tanggalPO = $_POST['tanggalPO'];
		$jatuhTempo = $_POST['jatuhTempo'];

		$data['tagihan_hutang'] = $this->modelLaporan->hutang_ditagih_filter($supplier,$tanggalPO,$jatuhTempo);
		$this->load->view("laporan/hutangpo/dataHutangPO",$data);
	}
	//end laporan hutang po

	//laporan hutang jatuh tempo
	function hutangJatuhTempo(){
		$this->global['pageTitle'] = "SIMRS - Laporan Hutang Jatuh Tempo";
		$data['supplier'] = $this->db->get("supplier")->result();
		$this->loadViews("laporan/hutangjatuhtempo/body_hutang_jatuh_tempo",$this->global,$data,"laporan/hutangjatuhtempo/footerHutangJatuhTempo");
	}

	function dataHutangJatuhTempo(){
		$data['hutang_jatuh_tempo'] = $this->modelLaporan->hutangJatuhTempo();
		$this->load->view("laporan/hutangjatuhtempo/dataHutangJatuhTempo",$data);
	}

	function dataHutangJatuhTempoFilter(){
		$supplier = $_POST['supplier'];
		$data['hutang_jatuh_tempo'] = $this->modelLaporan->hutangJatuhTempoFilter($supplier);
		$this->load->view("laporan/hutangjatuhtempo/dataHutangJatuhTempo",$data);
	}
	//end laporan hutang jatuh tempo

	//laporan hutang terbayar
	function hutangTerbayar(){
		$this->global['pageTitle'] = "SIMRS - Laporan Hutang Terbayar";
		$data['supplier'] = $this->db->get("supplier")->result();
		$data['tipeBayar'] = $this->db->get("payment_type_debt")->result();
		$this->loadViews("laporan/hutangterbayar/body_hutang_terbayar",$this->global,$data,"laporan/hutangterbayar/footerHutangTerbayar");
	}

	function dataHutangTerbayar(){
		$dateStart = $_POST['dateStart'];
		$dateEnd = $_POST['dateEnd'];
		$supplier = $_POST['supplier'];
		$tipeBayar = $_POST['tipeBayar'];
		$noPO = $_POST['noPO'];
		$noPayment = $_POST['noPayment'];

		$data['hutang_terbayar'] = $this->modelLaporan->laporanHutangTerbayar($dateStart,$dateEnd,$supplier,$tipeBayar,$noPO,$noPayment);
		$this->load->view("laporan/hutangterbayar/dataHutangTerbayar",$data);
	}
	//end laporan hutang terbayar

	//laporan analisa umur hutang
	function analisaUmurHutang(){
		$this->global['pageTitle'] = "SIMRS - Analisa Umur Hutang";
		$data['supplier'] = $this->db->get("supplier")->result();
		$this->loadViews("laporan/analisaumurhutang/body_analisa_umur_hutang",$this->global,$data,"laporan/analisaumurhutang/footerAnalisaUmurHutang");
	}

	function dataAnalisaUmurHutang(){

		if(!empty($_POST['supplier'])){
			$supplier = $_POST['supplier'];
		} else {
			$supplier = '';
		}

		$data['hutang_ditagih'] = $this->modelLaporan->hutang_ditagih($supplier);
		$this->load->view("laporan/analisaumurhutang/dataAnalisaUmurHutang",$data);
	}
	// end analisa umur hutang

	//laporan waste
	function waste(){
		$this->global['pageTitle'] = "SIMRS - Laporan Waste";
		$this->loadViews("laporan/waste/body_laporan_waste",$this->global,NULL,"laporan/waste/footerWaste");
	}

	function viewReportWaste(){
		$dateStart 	 	= $_POST['dateStart'];
		$dateEnd 		= $_POST['dateEnd'];
		$idProduk 		= $_POST['idProduk'];

		$data['viewReport'] = $this->modelLaporan->viewReportWaste($dateStart,$dateEnd,$idProduk);
		$this->load->view("laporan/waste/viewReportWaste",$data);
	}
	//end laporan waste
	
	//laporan penerimaan barang
	function penerimaanBarang(){
		$data['supplier'] = $this->db->get("supplier")->result();
		$this->global['pageTitle'] = "SIMRS - Laporan Penerimaan Barang";
		$this->loadViews("laporan/penerimaanbarang/bodyPenerimaanBarang",$this->global,$data,"laporan/penerimaanbarang/footerPenerimaanBarang");
	}

	function penerimaanBarangPeritem(){
		$data['toko'] = $this->db->get("ap_store")->result();
		$data['supplier'] = $this->db->get("supplier")->result();
		$this->global['pageTitle'] = "SIMRS - Penerimaan Barang Peritem";
		$this->loadViews("laporan/penerimaanbarang/bodyPenerimaanBarangPeritem",$this->global,$data,"laporan/penerimaanbarang/footerPenerimaanBarangPeritem");
	}

	function viewReportPenerimaanBarang(){
		$data['dateStart'] = $_POST['dateStart'];
		$data['dateEnd'] = $_POST['dateEnd'];
		$data['tempatPenerimaan'] = $_POST['tempatPenerimaan'];
		$data['supplier'] = $_POST['supplier'];
		$this->load->view("laporan/penerimaanbarang/viewReportPenerimaanBarang",$data);
	}

	function viewReportPenerimaanBarangPeritem(){
		$data['dateStart'] = $_POST['dateStart'];
		$data['dateEnd'] = $_POST['dateEnd'];
		$data['tempatPenerimaan'] = $_POST['tempatPenerimaan'];
		$data['supplier'] = $_POST['supplier'];
		$data['idProduk'] = $_POST['idProduk'];
		$this->load->view("laporan/penerimaanbarang/viewReportPenerimaanBarangPeritem",$data);
	}

	function datatablePenerimaanBarang(){
		$draw 		= $_REQUEST['draw'];
		$length 	= $_REQUEST['length'];
		$start 		= $_REQUEST['start'];
		$search 	= $_REQUEST['search']["value"];

		$dateStart = $_POST['dateStart'];
		$dateEnd = $_POST['dateEnd'];
		$tempatPenerimaan = $_POST['tempatPenerimaan'];
		$supplier = $_POST['supplier'];

		$total 			 			= $this->modelLaporan->rowPenerimaanBarang($dateStart,$dateEnd,$tempatPenerimaan,$supplier);
		$output 					= array();
		$output['draw']	 			= $draw;
		$output['recordsTotal'] 	= $output['recordsFiltered']=$total;
		$output['data'] 			= array();

		if($search!=""){
			$query = $this->modelLaporan->viewPenerimaanBarang($length,$start,$search,$dateStart,$dateEnd,$tempatPenerimaan,$supplier);
			$output['recordsTotal'] = $output['recordsFiltered'] = $query->num_rows();
		} else {
			$query = $this->modelLaporan->viewPenerimaanBarang($length,$start,$search,$dateStart,$dateEnd,$tempatPenerimaan,$supplier);
		}

		$nomor_urut=$start+1;
		foreach ($query->result_array() as $dt) {

			if(empty($dt['store'])){
				$place = "Gudang";
			} else {
				$place = $dt['store'];
			}

			$output['data'][]=array($nomor_urut,"<a target='_blank' href='".base_url('laporan/invoice_receive?no_receive='.$dt['no_receive'])."'>".$dt['no_receive']."</a>",$dt['no_po'],$this->convertDate('dmy',$dt['tanggal_terima']),$place,$dt['penerima'],$dt['pemeriksa'],$dt['supplier']);
			$nomor_urut++;
		}

		echo json_encode($output);
	}

	function datatablePenerimaanBarangPeritem(){
		$draw 		= $_REQUEST['draw'];
		$length 	= $_REQUEST['length'];
		$start 		= $_REQUEST['start'];
		$search 	= $_REQUEST['search']["value"];

		$dateStart = $_POST['dateStart'];
		$dateEnd = $_POST['dateEnd'];
		$tempatPenerimaan = $_POST['tempatPenerimaan'];
		$supplier = $_POST['supplier'];
		$idProduk = $_POST['idProduk'];

		$total 			 			= $this->modelLaporan->rowPenerimaanBarangPeritem($dateStart,$dateEnd,$tempatPenerimaan,$supplier,$idProduk);
		$output 					= array();
		$output['draw']	 			= $draw;
		$output['recordsTotal'] 	= $output['recordsFiltered']=$total;
		$output['data'] 			= array();

		if($search!=""){
			$query = $this->modelLaporan->viewPenerimaanBarangPeritem($length,$start,$search,$dateStart,$dateEnd,$tempatPenerimaan,$supplier,$idProduk);
			$output['recordsTotal'] = $output['recordsFiltered'] = $query->num_rows();
		} else {
			$query = $this->modelLaporan->viewPenerimaanBarangPeritem($length,$start,$search,$dateStart,$dateEnd,$tempatPenerimaan,$supplier,$idProduk);
		}

		$nomor_urut=$start+1;
		foreach ($query->result_array() as $dt) {

			if(empty($dt['store'])){
				$place = "Gudang";
			} else {
				$place = $dt['store'];
			}

			$output['data'][]=array($nomor_urut,"<a target='_blank' href='".base_url('laporan/invoice_receive?no_receive='.$dt['no_receive'])."'>".$dt['no_receive']."</a>",$this->convertDate('dmy',$dt['tanggal']),$place,$dt['supplier'],$dt['id_produk'],$dt['nama_produk'],$dt['qty']);
			$nomor_urut++;
		}

		echo json_encode($output);
	}

	function qtyPeritemPenerimaan(){
		$dateStart = $_POST['dateStart'];
		$dateEnd = $_POST['dateEnd'];
		$tempatPenerimaan = $_POST['tempatPenerimaan'];
		$supplier = $_POST['supplier'];
		$idProduk = $_POST['idProduk'];

		$qty = $this->modelLaporan->qtyPeritemPenerimaan($dateStart,$dateEnd,$tempatPenerimaan,$supplier,$idProduk);
		echo $qty;
	}

	function ajax_produk(){
		$q 	= $_GET['term'];
				
		$customer = $this->modelLaporan->ajaxProduk($q);

		$data_array = array();

		foreach($customer->result() as $row){
			$data_array[] = array(
									"id" 	=> $row->id_produk,
									"text"	=> $row->id_produk." / ".$row->nama_produk,
								 );
		}

		echo json_encode($data_array);
	}

	function invoice_receive(){
		$this->load->model("modelBahanMasukMaterial");
		$data['header'] = $this->db->get_where("kl_klinikinfo",array("id" => 1))->row();
		$no_receive = $_GET['no_receive'];
		$data['dataReceive'] = $this->modelBahanMasukMaterial->dataReceive($no_receive);
		$data['receive_item'] = $this->modelBahanMasukMaterial->received_item($no_receive);

		$this->global['pageTitle'] = "SIMRS - Invoice Penerimaan";
		$this->loadViews("bahan_masuk/body_invoice_receive",$this->global,$data,"footer_empty");
	}
	//end laporan penerimaan barang

	//laporan stock opname
	function stockOpname(){
		$this->global['pageTitle'] = "SIMRS - Laporan Stock Opname";
		$this->loadViews("laporan/stockopname/bodyLaporanStockOpname",$this->global,NULL,"laporan/stockopname/footerLaporanStockOpname");
	}

	function viewLaporanStockOpname(){
		$tahun = $this->input->post("tahun");
		$data['tahun'] = $tahun;
		$this->load->view("laporan/stockopname/viewLaporanStockOpname",$data);
	}

	function datatableLaporanSO(){
		$tahun = $this->input->post("tahun");

		$draw = $_REQUEST['draw'];
		$length = $_REQUEST['length'];
		$start = $_REQUEST['start'];
		$search = $_REQUEST['search']["value"];

		$total = $this->modelLaporan->totalRowSO($tahun);
		$output = array();
		$output['draw']	 = $draw;
		$output['recordsTotal'] = $output['recordsFiltered']=$total;
		$output['data'] = array();

		if($search!=""){
			$query = $this->modelLaporan->viewLaporanSO($length,$start,$search,$tahun);
			$output['recordsTotal'] = $output['recordsFiltered'] = $query->num_rows();
		} else {
			$query = $this->modelLaporan->viewLaporanSO($length,$start,$search,$tahun);
		}

		$nomor_urut=$start+1;
		foreach ($query->result_array() as $dt) {
			$output['data'][]=array($nomor_urut,"<a href='".base_url('laporan/stock_opname_report?no_so='.$dt['noSO'])."'>".$dt['noSO']."</a>",date_format(date_create($dt['tanggal']),'d M Y'),$dt['first_name'],$dt['keterangan']);
			$nomor_urut++;
		}

		echo json_encode($output);
	}

	function stock_opname_report(){
		$this->load->model("modelStockOpname");
		$this->global['pageTitle'] = "SIMRS - Laporan Stock Opname Gudang";
		$data['header'] = $this->db->get_where("kl_klinikinfo",array("id" => 1))->row();
		$data['headerSO'] = $this->modelStockOpname->headerSO($this->input->get("no_so"));
		$data['dataSO'] = $this->modelStockOpname->dataSOItem($this->input->get("no_so"));
		$this->loadViews("stock_opname/body_stock_opname_report",$this->global,$data,"footer_empty");
	}

	//end laporan stock opname

	//laporan retur pembelian
	function returPembelian(){
		$this->global['pageTitle'] = "SIMRS - Laporan Retur Pembelian";
		$data['supplier'] = $this->db->get("supplier")->result();
		$this->loadViews("laporan/returpembelian/returPembelian",$this->global,$data,"laporan/returpembelian/footerReturPembelian");
	}

	function viewReportReturPembelian(){
		$dateStart = $_POST['dateStart'];
		$dateEnd = $_POST['dateEnd'];
		$supplier = $_POST['supplier'];

		$data['viewReport'] = $this->modelLaporan->viewReportReturPembelian($dateStart,$dateEnd,$supplier);
		$data['header'] = $this->db->get_where("kl_klinikinfo",array("id" => 1))->row();
		$data['dateStart'] = date_format(date_create($dateStart),'d M Y');
		$data['dateEnd'] = date_format(date_create($dateEnd),'d M Y');
		$this->load->view("laporan/returpembelian/viewReportReturPembelian",$data);
	}
	//end retur pembelian

	//laporan penjualan akumulasi
	function akumulasiPenjualan(){
		$this->global['pageTitle'] = "SIMRS - Akumulasi Penjualan";
		$data['payment_type'] = $this->db->get("ap_payment_type")->result();
		$this->loadViews("laporan_penjualan/bodyPenjualanPerkriteria",$this->global,$data,"laporan_penjualan/footerAkumulasi");
	}

	function sub_account(){
		$id 	= $_POST['id'];

		$query = $this->db->get_where("ap_payment_account",array("id_payment_type" => $id));

		$data['sub_account'] = $query;

		$rows = $query->num_rows();

		if($rows > 0 ){
			$this->load->view("sub_account",$data);
		} else {
			echo "<input type='hidden' id='subAccount' value=''/>";
		}
	}

	function laporanPenjualanPerkriteria(){
		$dateStart 			= $_POST['dateStart'];
		$dateEnd 			= $_POST['dateEnd'];
		$typeBayar 			= $_POST['typeBayar'];
		$subAccount 		= $_POST['subAccount'];

		$data['dateStart'] 	= $_POST['dateStart'];
		$data['dateEnd'] 	= $_POST['dateEnd'];
		$data['typeBayar'] 	= $_POST['typeBayar'];
		$data['subAccount'] = $_POST['subAccount'];

		$data['laporan'] = $this->modelLaporan->laporanPenjualanPerkriteria($dateStart,$dateEnd,$typeBayar,$subAccount);
		$this->load->view("laporan_penjualan/laporanPenjualanPerkriteria",$data);
	}
	//end laporan penjualan akumulasi

	//penjualan peritem
	function penjualanPeritem(){
		$this->global['pageTitle'] = "SIMRS - Akumulasi Penjualan";
		$data['payment_type'] = $this->db->get("ap_payment_type")->result();
		$this->loadViews("laporan_penjualan/bodyPenjualanPerkriteriaProduk",$this->global,$data,"laporan_penjualan/footerAkumulasiKriteria");
	}

	function laporanPenjualanPerkriteriaProduk(){
		$dateStart 		= $_POST['dateStart'];
		$dateEnd 		= $_POST['dateEnd'];

		$data['dateStart'] 		= $_POST['dateStart'];
		$data['dateEnd'] 		= $_POST['dateEnd'];

		$data['laporan'] = $this->modelLaporan->penjualanPerkriteriaProduk($dateStart,$dateEnd);
	   $this->load->view("laporan_penjualan/laporanPenjualanPerkriteriaProduk",$data);
   }
	//end penjualan peritemx
}