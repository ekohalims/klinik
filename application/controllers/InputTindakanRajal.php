<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class InputTindakanRajal extends BaseController{
	function __construct(){
		parent::__construct();
		$this->load->model("modelInputTindakan");
		$this->isLoggedIn($this->global['idUser'],2,58);
    }

    function index(){
		$this->global['pageTitle'] = "SIMRS - Input Tindakan Rawat Jalan";
		$data['listdokter'] = $this->modelPublic->daftarDokterAktif();
		$data['listpoli'] = $this->modelPublic->daftarPoliAktif();
		$this->loadViews("inputtindakan/rajal/body",$this->global,$data,"inputtindakan/rajal/footer");
	}
	
	function datatable(){
		$draw = $_REQUEST['draw'];
		$length = $_REQUEST['length'];
		$start = $_REQUEST['start'];
		$search = $_REQUEST['search']["value"];

		$total = $this->modelInputTindakan->totalRowPasien("RAJAL");
		$output = array();
		$output['draw']	 = $draw;
		$output['recordsTotal'] = $output['recordsFiltered']=$total;
		$output['data'] = array();

		if($search!=""){
			$query = $this->modelInputTindakan->viewPasienDatatable($length,$start,$search,"RAJAL");
			$output['recordsTotal'] = $output['recordsFiltered'] = $query->num_rows();
		} else {
			$query = $this->modelInputTindakan->viewPasienDatatable($length,$start,$search,"RAJAL");
		}

		$nomor_urut=$start+1;
		foreach ($query->result_array() as $dt) {
			$encoded = $this->enkripsi($dt['noPendaftaran']);

			$output['data'][]=array(
				substr($dt['noPendaftaran'],-3),
				"<a href='".base_url('inputTindakanRajal/inputTind/'.$encoded)."'><span class='label label-info'>".$dt['noPendaftaran']."</span></a>",
				$dt['idPasien'],
				nice_date($dt['tanggalDaftar'],'d/m/Y'),
				$dt['namaLengkap'],
				$dt['jenisKelamin'],
                nice_date($dt['tanggalLahir'],'d/m/Y'),
                $dt['poliklinik'],
				$dt['namaDokter'],
				$dt['layanan']." ".$dt['namaAsuransi']	
			);
			$nomor_urut++;
		}

		echo json_encode($output);
	}

	function inputTind(){
		$this->global['pageTitle'] = "SIMRS - Input Tindakan Pasien Rawat Jalan";
		$noPendaftaran = $this->dekripsi($this->uri->segment(3));

		$getPasien = $this->modelInputTindakan->dataPendaftaranRow($noPendaftaran);
		$data['dataPasien'] = $getPasien;
		$data['umur'] = $this->hitungUmur($getPasien->tanggalLahir);
		$data['jenisKunjungan'] = $this->modelInputTindakan->jenisKunjungan($getPasien->noPasien);
		$this->loadViews("inputtindakan/rajal/bodyTindakanPasien",$this->global,$data,"inputtindakan/rajal/footerTindakanPasien");
	}

	function tabsContent(){
		$tabs = $this->input->post("tabs");
		$noPendaftaran = $this->dekripsi($this->input->post("noPendaftaran"));

		switch ($tabs) {
			case 'catatan':
				$this->load->view("inputtindakan/rajal/tabsCatatan");
				break;

			case 'laboratorium':
				$this->load->view("inputtindakan/rajal/tabsLaboratorium");
				break;

			case 'radiologi':
				$this->load->view("inputtindakan/rajal/tabsRadiologi");
				break;

			case 'diagnosa':
				$this->load->view("inputtindakan/rajal/tabsDiagnosa");
				break;

			case 'resep':
				$this->load->view("inputtindakan/rajal/tabsResep");
				break;

			case 'tindakan':
				$this->load->view("inputtindakan/rajal/tabsTindakan");
				break;

			case 'tindakLanjut':
				$this->load->view("inputtindakan/rajal/tabsTindakLanjut");
				break;

			case 'riwayatBerobat':
				$this->load->view("inputtindakan/rajal/tabsRiwayatBerobat");
				break;

			default:
				echo "Not Found";
				break;
		}
	}

	function loadFormCatatan(){
		$noPendaftaran = $this->dekripsi($this->input->post("noPendaftaran"));
		$catatan = $this->db->get_where("kl_catatan",array("noPendaftaran" => $noPendaftaran));

		$idPasien = $this->db->get_where("kl_daftar",array("noPendaftaran" => $noPendaftaran))->row()->idPasien;
		$golonganDarah = $this->modelInputTindakan->getGolonganDarah($idPasien);

		if(!empty($golonganDarah)){
			$data['golonganDarah'] = $golonganDarah;
		} else {
			$data['golonganDarah'] = '';
		}

		$numRows = $catatan->num_rows();
		if($numRows < 1){
			$data['riwayatAlergi'] = '';
			$data['catatan'] = '';
			$data['tinggiBadan'] = '';
			$data['beratBadan'] = '';
			$data['tekananDarah'] = '';
			$data['butaWarna'] = '';
			$data['cacatBadan'] = '';
		} else {
			$data['riwayatAlergi'] = $catatan->row()->riwayatAlergi;
			$data['catatan'] = $catatan->row()->catatan;
			$data['tinggiBadan'] = $catatan->row()->tinggiBadan;
			$data['beratBadan'] = $catatan->row()->beratBadan;
			$data['tekananDarah'] = $catatan->row()->tekananDarah;
			$data['butaWarna'] = $catatan->row()->butaWarna;
			$data['cacatBadan'] = $catatan->row()->cacatBadan;
		}

		$this->load->view("inputtindakan/ranap/loadFormCatatan",$data);
	}

	function simpanGolonganDarah(){
		$noPendaftaran = $this->dekripsi($this->input->post("noPendaftaran"));
		$golonganDarah = $this->input->post("golonganDarah");
		$idPasien = $this->db->get_where("kl_daftar",array("noPendaftaran" => $noPendaftaran))->row()->idPasien;

		$dataUpdate = array(
			"golonganDarah" => $golonganDarah
		);

		$this->modelInputTindakan->updateGolonganDarah($dataUpdate,$idPasien);
	}

	function simpanCatatan(){
		$noPendaftaran = $this->dekripsi($this->input->post("noPendaftaran"));
		$riwayatAlergi = $this->input->post("riwayatAlergi");
		$keluhan = $this->input->post("keluhan");
		$tinggiBadan = $this->input->post("tinggiBadan");
		$beratBadan = $this->input->post("beratBadan");
		$tekananDarah = $this->input->post("tekananDarah");
		$butaWarna = $this->input->post("butaWarna");
		$cacatBadan = $this->input->post("cacatBadan");

		$cekCatatanExist = $this->modelInputTindakan->cekCatatanExist($noPendaftaran);

		if($cekCatatanExist < 1){
			$dataArray = array(
				"noPendaftaran" => $noPendaftaran,
				"riwayatAlergi" => $riwayatAlergi,
				"catatan" => $keluhan,
				"idUser" => $this->global['idUser'],
				"tinggiBadan" => $tinggiBadan,
				"beratBadan" => $beratBadan,
				"tekananDarah" => $tekananDarah,
				"butaWarna" => $butaWarna,
				"cacatBadan" => $cacatBadan
			);

			$this->modelInputTindakan->simpanCatatan($dataArray);
		} else {
			$dataArray = array(
				"riwayatAlergi" => $riwayatAlergi,
				"catatan" => $keluhan,
				"idUser" => $this->global['idUser'],
				"tinggiBadan" => $tinggiBadan,
				"beratBadan" => $beratBadan,
				"tekananDarah" => $tekananDarah,
				"butaWarna" => $butaWarna,
				"cacatBadan" => $cacatBadan
			);

			$this->modelInputTindakan->updateCatatan($dataArray,$noPendaftaran);
		}
	}

	function hapusCartLab(){
		$idLab = $this->input->post("idLab");
		$noPendaftaran = $this->dekripsi($this->input->post("noPendaftaran"));
		
		$param = array(
			"idLab" => $idLab,
			"noPendaftaran" => $noPendaftaran
		);

		$this->modelPublic->delete("kl_orderlab",$param);
	}

	function tampilkanCartLab(){
		$noPendaftaran = $this->dekripsi($this->input->post("noPendaftaran"));
		$data['cartLab'] = $this->modelInputTindakan->tampilkanCartLab($noPendaftaran);
		$this->load->view("inputtindakan/rajal/tampilkanCartLab",$data);
	}

	function datatableLab(){
		$data['item'] = $this->modelPublic->selectAll("kl_tariflab",NULL,NULL);
		$this->load->view("inputtindakan/rajal/datatableLab",$data);
	}

	function orderLab(){
		$id = $this->input->post("id");
		$noPendaftaran = $this->dekripsi($this->input->post("noPendaftaran"));
		$catatan = $this->input->post("catatan");
		$hargaLab = $this->modelPublic->getValueOfTable("kl_tariflab","tarif",array("kode" => $id));
		$idUser = $this->global['idUser'];

		$dataArray = array(
			"noPermintaan" => $noPendaftaran,
			"noPendaftaran" => $noPendaftaran,
			"idLab" => $id,
			"harga" => $hargaLab,
			"catatan" => $catatan,
			"idUser" => $idUser,
			"tanggal" => date('Y-m-d H:i:s'),
			"status" => 0
		);

		$this->modelPublic->insert("kl_orderlab",$dataArray);
	}

	function orderRad(){
		$id = $this->input->post("id");
		$noPendaftaran = $this->dekripsi($this->input->post("noPendaftaran"));
		$hargaRad = $this->modelInputTindakan->hargaRad($id);
		$idUser = $this->global['idUser'];
		$catatan = $this->input->post("catatan");

		$dataArray = array(
			"noPermintaan" => $noPendaftaran,
			"noPendaftaran" => $noPendaftaran,
			"idRadiologi" => $id,
			"harga" => $hargaRad,
			"catatan" => $catatan,
			"idUser" => $idUser,
			"tanggal" => date('Y-m-d H:i:s'),
			"status" => 0
		);

		$this->modelPublic->insert("kl_orderradiologi",$dataArray);
	}

	function catatanLab(){
		$id = $this->input->post("id");

		$data['namaLab'] = $this->db->get_where("kl_tariflab",array("kode" => $id))->row()->namaTarif;
		$data['id'] = $id;
		$this->load->view("inputtindakan/rajal/catatanLab",$data);
	}

	function hapusCartRad(){
		$idRad = $this->input->post("idRad");
		$noPendaftaran = $this->dekripsi($this->input->post("noPendaftaran"));

		$param = array(
			"idRadiologi" => $idRad,
			"noPendaftaran" => $noPendaftaran
		);

		$this->modelPublic->delete("kl_orderradiologi",$param);
	}

	function tampilkanCartRad(){
		$noPendaftaran = $this->dekripsi($this->input->post("noPendaftaran"));
		$data['cartLab'] = $this->modelInputTindakan->tampilkanCartRad($noPendaftaran);
		$this->load->view("inputtindakan/rajal/tampilkanCartRad",$data);
	}

	function datatableRad(){
		$data['item'] = $this->modelPublic->selectAll("kl_tarifradiologi",NULL,NULL);
		$this->load->view("inputtindakan/rajal/datatableRad",$data);
	}

	function catatanRad(){
		$id = $this->input->post("id");

		$data['namaRad'] = $this->db->get_where("kl_tarifradiologi",array("kode" => $id))->row()->namaTarif;
		$data['id'] = $id;
		$this->load->view("inputtindakan/rajal/catatanRad",$data);
	}

	function tampilkanCartDiagnosa(){
		$noPendaftaran = $this->dekripsi($this->input->post("noPendaftaran"));
		$data['cartLab'] = $this->modelInputTindakan->tampilkanCartDiagnosa($noPendaftaran);
		$this->load->view("inputtindakan/rajal/tampilkanCartDiagnosa",$data);
	}

	function datatableDiagnosa(){
		$this->load->view("inputtindakan/rajal/datatableDiagnosa");
	}

	function datatableDiagnosaJSON(){
		$draw = $_REQUEST['draw'];
		$length = $_REQUEST['length'];
		$start = $_REQUEST['start'];
		$search = $_REQUEST['search']["value"];

		$total = $this->modelInputTindakan->totalDiagnosa();
		$output = array();
		$output['draw']	= $draw;
		$output['recordsTotal'] = $output['recordsFiltered']=$total;
		$output['data'] = array();

		if($search!=""){
			$query = $this->modelInputTindakan->viewICDXdatatables($length,$start,$search);
			$output['recordsTotal'] = $output['recordsFiltered'] = $query->num_rows();
		} else {
			$query = $this->modelInputTindakan->viewICDXdatatables($length,$start,$search);
		}

		$nomor_urut=$start+1;
		foreach ($query->result_array() as $dt) {
			$output['data'][]=array($nomor_urut,"<a class='addDiagnosa' id='".$dt['id']."'>".$dt['code']."</a>",$dt['sab'],$dt['diagnosa']);
			$nomor_urut++;
		}

		echo json_encode($output);
	}

	function keteranganDiagnosa(){
		$id = $this->input->post("id");

		$data['diagnosa'] = $this->db->get_where("kl_icd",array("id" => $id))->row()->STR;
		$data['id'] = $id;
		$this->load->view("inputtindakan/rajal/keteranganDiagnosa",$data);
	}

	function hapusCartDiag(){
		$id = $this->input->post("id");
		$noPendaftaran = $this->dekripsi($this->input->post("noPendaftaran"));

		$param = array(
			"noPendaftaran" => $noPendaftaran,
			"idDiagnosa" => $id
		);

		$this->modelPublic->delete("kl_diagnosa",$param);
	}

	function addDiagnosaOnPasien(){
		$id = $this->input->post("id");
		$noPendaftaran = $this->dekripsi($this->input->post("noPendaftaran"));
		$keterangan = $this->input->post("keterangan");

		$dataArray = array(
			"noPendaftaran" => $noPendaftaran,
			"idDiagnosa" => $id,
			"keterangan" => $keterangan,
			"idUser" => $this->global['idUser']
		);

		$this->modelPublic->insert("kl_diagnosa",$dataArray);
	}

	function tampilkanCartResep(){
		$noPendaftaran = $this->dekripsi($this->input->post("noPendaftaran"));
		$data['cart'] = $this->modelInputTindakan->tampilkanCartResep($noPendaftaran);
		$this->load->view("inputtindakan/rajal/tampilkanCartResep",$data);
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
		$numRows = $this->modelInputTindakan->numRowsJumlahProduk($search,$idKategori);

		//jumlah halaman
		$data['jumlahHalaman'] = ceil($numRows/$perPage);

		//tampilkan produk
		$viewMenu = $this->modelInputTindakan->viewItemObat($search,$limitOnNextPage,$idKategori,$perPage);
		$data['viewItem'] = $viewMenu;
		$data['numRowsTotal'] = $numRows;
		$data['urutanNo'] = $limitStart;
		$this->load->view("inputtindakan/rajal/itemObatDatatables",$data);
	}

	function simpanResepPasien(){
		$idProduk = $this->input->post("idProduk");
		$noPendaftaran = $this->dekripsi($this->input->post("noPendaftaran"));
		$expiredDate = $this->modelInputTindakan->getProdukExpiredFirst($idProduk);

		$currentStokItem = $this->modelInputTindakan->currentStokItem($idProduk);

		//0 = stok tidak mencukupi
		//1 = stok mencukupi

		if($currentStokItem > 0){
			//cek resep jika sudah tersedia
			$cekResepExist = $this->modelInputTindakan->cekResepExist($idProduk,$noPendaftaran);

			if($cekResepExist > 0){
				//ubah ini
				$currentQtyResep = $this->modelInputTindakan->currentQtyResep($idProduk,$noPendaftaran);

				if($currentQtyResep+1 > $currentStokItem){
					echo 0;
				} else {
					$dataUpdate = array(
						"jumlah" => $currentQtyResep+1
					);

					$param = array(
						"noPendaftaran" => $noPendaftaran,
						"idObat" => $idProduk
					);

					$this->modelPublic->update("kl_resep",$param,$dataUpdate);
					echo 1;
				}
			} else {
				$dataArray = array(
					"noPendaftaran" => $noPendaftaran,
					"idObat" => $idProduk,
					"jumlah" => 1,
					"harga" => $this->modelPublic->getValueOfTable("ap_produk","harga",array("id_produk" => $idProduk)),
					"aturan" => '',
					"idUser" => $this->global['idUser'],
					"expiredDate" => $expiredDate,
				);

				$this->modelPublic->insert("kl_resep",$dataArray);
				echo 1;
			}
		} else {
			echo 0;
		}
	}

	function ubahQtyResep(){
		$noPendaftaran = $this->dekripsi($this->input->post("noPendaftaran"));
		$idProduk = $this->input->post("idProduk");
		$qty = $this->input->post("qty");

		$currentStokItem = $this->modelInputTindakan->currentStokItem($idProduk);
		$currentQtyResep = $this->modelInputTindakan->currentQtyResep($idProduk,$noPendaftaran);

		if($qty > $currentStokItem){
			echo $currentQtyResep;
		} else {
			$dataUpdate = array(
				"jumlah" => $qty
			);

			$this->modelInputTindakan->updateQtyResep($dataUpdate,$idProduk,$noPendaftaran);
			echo 'StokEnough';
		}
	}

	function ubahAturanPakai(){
		$aturanPakai = $this->input->post("aturanPakai");
		$idProduk = $this->input->post("idProduk");
		$noPendaftaran = $this->dekripsi($this->input->post("noPendaftaran"));

		$dataUpdate = array(
			"aturan" => $aturanPakai
		);

		$param = array(
			"idObat" => $idProduk,
			"noPendaftaran" => $noPendaftaran
		);

		$exec = $this->modelPublic->update("kl_resep",$param,$dataUpdate);
		echo $exec;
	}

	function hapusResep(){
		$idProduk = $this->input->post("idProduk");
		$noPendaftaran = $this->dekripsi($this->input->post("noPendaftaran"));

		$param = array(
			"idObat" => $idProduk,
			"noPendaftaran" => $noPendaftaran
		);

		$this->modelPublic->delete("kl_resep",$param);
	}

	function tampilkanDaftarTindakan(){
		$data['dataTindakan'] = $this->modelInputTindakan->tarifPelayanan("kl_tarifrajal");
		$this->load->view("inputtindakan/rajal/tampilkanDaftarTindakan",$data);
	}

	function hapusTindakan(){
		$noPendaftaran = $this->dekripsi($this->input->post("noPendaftaran"));
		$idTindakan = $this->input->post("idTindakan");
		
		$param = array(
			"idTindakan" => $idTindakan,
			"noPendaftaran" => $noPendaftaran
		);

		$this->modelPublic->delete("kl_tindakanorder",$param);
	}

	function tampilkanCartTindakan(){
		$noPendaftaran = $this->dekripsi($this->input->post("noPendaftaran"));
		$data['viewTindakan'] = $this->modelInputTindakan->viewTindakanCart($noPendaftaran,"kl_tarifrajal");
		$this->load->view("inputtindakan/rajal/tampilkanCartTindakan",$data);
	}

	function addTindakanSQL(){
		$idTindakan = $this->input->post("idTindakan");
		$noPendaftaran = $this->dekripsi($this->input->post("noPendaftaran"));
		$dokter = $this->input->post("dokter");

		$dataArray = array(
			"noPendaftaran" => $noPendaftaran,
			"idTindakan" => $idTindakan,
			"harga" => $this->modelInputTindakan->pelayananField("kl_tarifrajal","tarif",$idTindakan),
			"komisi" => $this->modelInputTindakan->pelayananField("kl_tarifrajal","dokter",$idTindakan),
			"qty" => 1,
			"sarana" => $this->modelInputTindakan->pelayananField("kl_tarifrajal","sarana",$idTindakan),
			"bhp" => $this->modelInputTindakan->pelayananField("kl_tarifrajal","bhp",$idTindakan),
			"alat" => $this->modelInputTindakan->pelayananField("kl_tarifrajal","alat",$idTindakan),
			"catatan" => '',
			"idUser" => $this->global['idUser'],
			"dokter" => $dokter
		);

		$this->modelPublic->insert("kl_tindakanorder",$dataArray);
	}

	function keteranganTindakan(){
		$id = $this->input->post("id");

		$data['tindakan'] = $this->db->get_where("kl_tarifrajal",array("kode" => $id))->row()->namaTarif;
		$data['id'] = $id;
		$data['dokter'] = $this->db->get_where("kl_dokter",array("status" => 1, "isDelete" => 1))->result();
		$this->load->view("inputtindakan/rajal/keteranganTindakan",$data);
	}

	function dataTindakLanjut(){
		$noPendaftaran = $this->dekripsi($this->input->post("noPendaftaran"));
		$cekDataTindakLanjut = $this->modelInputTindakan->cekTindakLanjutIfExist($noPendaftaran);
		$data['dropdownTindakLanjut'] = $this->db->get_where("kl_tindaklanjut",array("status" => 1, "isDelete" => 1))->result();

		if($cekDataTindakLanjut < 1){
			$this->load->view("inputtindakan/rajal/dataTindakLanjut",$data);
		} else {
			$data['currentValue'] = $this->modelInputTindakan->currentTindakLanjut($noPendaftaran);
			$this->load->view("inputtindakan/rajal/dataTindakLanjutExist",$data);
		}
	}

	function updateTanggalKontrol(){
		$noPendaftaran = $this->dekripsi($this->input->post("noPendaftaran"));
		$tanggalKontrol = $this->input->post("tanggalKontrol");

		$dataUpdate = array(
			"tanggalKontrol" => $tanggalKontrol,
			"spesialisRujuk" => "",
			"rumahSakit" => ""
		);

		$param = array(
			"noPendaftaran" => $noPendaftaran
		);

		$this->modelPublic->update("kl_tindaklanjutpasien",$param,$dataUpdate);
	}

	function updateRujukanPasien(){
		$spesialis = $this->input->post("spesialis");
		$tujuan = $this->input->post("tujuan");
		$noPendaftaran = $this->dekripsi($this->input->post("noPendaftaran"));

		if(empty($tujuan)){
			$dataUpdate = array(
				"spesialisRujuk" => $spesialis,
				"tanggalKontrol" => NULL
			);
		} else {
			$dataUpdate = array(
				"rumahSakit" => $tujuan,
				"tanggalKontrol" => NULL
			);
		}

		$param = array(
			"noPendaftaran" => $noPendaftaran
		);

		$this->modelPublic->update("kl_tindaklanjutpasien",$param,$dataUpdate);
	}

	function formKontrolKembali(){
		$noPendaftaran = $this->dekripsi($this->input->post("noPendaftaran"));
		$data['tanggalKontrol'] = $this->db->get_where("kl_tindaklanjutpasien",array("noPendaftaran" => $noPendaftaran))->row()->tanggalKontrol;
		$this->load->view("inputtindakan/rajal/formKontrolKembali",$data);
	}

	function formRujukPasien(){
		$noPendaftaran = $this->dekripsi($this->input->post("noPendaftaran"));
		$dataRujuk = $this->db->get_where("kl_tindaklanjutpasien",array("noPendaftaran" => $noPendaftaran))->row();
		$data['spesialis'] = $dataRujuk->spesialisRujuk;
		$data['rumahSakit'] = $dataRujuk->rumahSakit;
		$this->load->view("inputtindakan/rajal/formRujukPasien",$data);
	}

	function kosongkanRujukanDanTanggalKontrol(){
		$noPendaftaran = $this->dekripsi($this->input->post("noPendaftaran"));

		$dataUpdate = array(
			"tanggalKontrol" => NULL,
			"spesialisRujuk" => NULL,
			"rumahSakit" => NULL
		);

		$param = array(
			"noPendaftaran" => $noPendaftaran
		);

		$this->modelPublic->update("kl_tindaklanjutpasien",$param,$dataUpdate);
	}

	function simpanTindakLanjut(){
		$tindakLanjut = $this->input->post("tindakLanjut");
		$keterangan = $this->input->post("keterangan");
		$noPendaftaran = $this->dekripsi($this->input->post("noPendaftaran"));

		$cekDataTindakLanjut = $this->modelInputTindakan->cekTindakLanjutIfExist($noPendaftaran);

		if($cekDataTindakLanjut < 1){
			$dataArray = array(
				"noPendaftaran" => $noPendaftaran,
				"idTindakLanjut" => $tindakLanjut,
				"keterangan" => $keterangan,
				"idUser" => $this->global['idUser']
			);

			$this->modelPublic->insert("kl_tindaklanjutpasien",$dataArray);
		} else {
			$dataArray = array(
				"idTindakLanjut" => $tindakLanjut,
				"keterangan" => $keterangan,
				"idUser" => $this->global['idUser']
			);

			$param = array(
				"noPendaftaran" => $noPendaftaran
			);

			$this->modelPublic->update("kl_tindaklanjutpasien",$param,$dataArray);
		}
	}

	function dataRiwayatBerobat(){
		$noPendaftaran = $this->dekripsi($this->input->post("noPendaftaran"));

		$getIdPasien = $this->db->get_where("kl_daftar",array("noPendaftaran" => $noPendaftaran))->row()->idPasien;

		$data['dataRiwayatBerobat'] = $this->modelInputTindakan->dataRiwayatBerobat($getIdPasien);
		$this->load->view("inputtindakan/ranap/dataRiwayatBerobat",$data);
	}

	function tindakanApprove(){
		$this->load->model("modelKasir");

		//update status pendaftaran
		$noPendaftaran = $this->dekripsi($this->input->post("noPendaftaran"));

		//cek jenis layanan
		$jenisLayanan = $this->db->get_where("kl_daftar",array("noPendaftaran" => $noPendaftaran))->row()->idLayanan;

		if($jenisLayanan==1){
			$this->modelInputTindakan->updateTindakanOnProcess($noPendaftaran);
		} else {
			$this->modelInputTindakan->updateTindakanSelesai($noPendaftaran);
			$today = date("Y-m-d");

			$kodeAsuransi = $this->db->get_where("kl_daftar",array("noPendaftaran" => $noPendaftaran))->row()->asuransi;
			$tempoAsuransi = $this->db->get_where("kl_asuransi",array("idAsuransi" => $kodeAsuransi))->row()->tempo;

			if($kodeAsuransi == 0){
				$tempo = date('Y-m-d', strtotime('+30 days', strtotime($today)));
			} else {
				$tempo = date('Y-m-d', strtotime('+'.$tempoAsuransi.' days', strtotime($today)));
			}

			//sisipkan data piutang
			$dataPiutang = array(
				"noPendaftaran" => $noPendaftaran,
				"tanggalInput" => date('Y-m-d H:i:s'),
				"jatuhTempo" => $tempo,
				"idUser" => $this->global['idUser'],
				"keterangan" => "Piutang Asuransi",
				"status" => 0
			);

			$this->modelPublic->insert("kl_piutang",$dataPiutang);

			//generate invoice
			$jumlahBayar = $this->input->post("idPaymentType") > 1 ? $this->modelKasir->totalTransaksi($noPendaftaran) : $this->input->post("jumlahBayar");
			$idPayment = 5;
			$subAccount = '';
			$idUser = $this->global['idUser'];
			$diskon = 0;
			$totalTindakan = $this->modelKasir->totalTindakan($noPendaftaran);
			$totalObat = $this->modelKasir->totalObat($noPendaftaran);
			$totalLab = $this->modelKasir->totalLab($noPendaftaran);
			$totalRadiologi = $this->modelKasir->totalRadiologi($noPendaftaran);
			$cekInvoice = $this->modelKasir->cekInvoice($today);
			$noInvoice = "INV.".date('ymd').".".sprintf('%03d',$idUser).".".sprintf('%04d',$cekInvoice+1);
			$grandTotal = $this->modelKasir->totalTransaksi($noPendaftaran)-$diskon;

			$dataInvoice = array(
				"noInvoice" => $noInvoice,
				"noPendaftaran" => $noPendaftaran,
				"tanggalBayar" => date('Y-m-d H:i:s'),
				"idUser" => $idUser,
				"typeBayar" => $idPayment,
				"subAccount" => $subAccount,
				"totalTindakan" => $totalTindakan,
				"totalObat" => $totalObat,
				"totalLaboratorium" => $totalLab,
				"totalRadiologi" => $totalRadiologi,
				"diskon" => $diskon,
				"grandTotal" => $grandTotal,
				"jumlahBayar" => $jumlahBayar,
				"kembali" => $jumlahBayar-$this->modelKasir->totalTransaksi($noPendaftaran)
			);

			$insert = $this->modelPublic->insert("kl_invoice",$dataInvoice);
		}

		$idUser = $this->global['idUser'];

		//cek jika menggunakan lab
		$cekIfLabExist = $this->modelInputTindakan->cekIfLabExist($noPendaftaran);
		if($cekIfLabExist > 0){
			$urutan = $this->modelInputTindakan->urutanPermintaan("kl_orderlabheader",$noPendaftaran);
			$noPermintaan = $noPendaftaran."/".sprintf('%02d',$urutan+1);

			$dataInsert = array(
				"noPermintaan" => $noPendaftaran,
				"noPendaftaran" => $noPendaftaran,
				"tanggal" => date('Y-m-d H:i:s'),
				"idUser" => $idUser,
				"status" => 0
			);

			$this->modelPublic->insert("kl_orderlabheader",$dataInsert);
			$this->modelInputTindakan->insertNoPermintaanItem("kl_orderlab",$noPermintaan,$noPendaftaran);
		}

		//cek jika menggunakan radiologi
		$cekIfRadExist = $this->modelInputTindakan->cekIfRadExist($noPendaftaran);
		if($cekIfRadExist > 0){
			$urutan = $this->modelInputTindakan->urutanPermintaan("kl_orderradiologiheader",$noPendaftaran);
			$noPermintaan = $noPendaftaran."/".sprintf('%02d',$urutan+1);

			$dataInsert = array(
				"noPermintaan" => $noPendaftaran,
				"noPendaftaran" => $noPendaftaran,
				"tanggal" => date('Y-m-d H:i:s'),
				"idUser" => $idUser,
				"status" => 0
			);

			$this->modelPublic->insert("kl_orderradiologiheader",$dataInsert);
			$this->modelInputTindakan->insertNoPermintaanItem("kl_orderradiologi",$noPermintaan,$noPendaftaran);
		}

		//cek jika diberi resep
		$cekIfResepExist = $this->modelInputTindakan->cekIfResepExist($noPendaftaran);
		if($cekIfResepExist > 0){
			$urutan = $this->modelInputTindakan->urutanPermintaan("kl_resepheader",$noPendaftaran);
			$noPermintaan = $noPendaftaran."/".sprintf('%02d',$urutan+1);

			$dataInsert = array(
				"noPermintaan" => $noPendaftaran,
				"noPendaftaran" => $noPendaftaran,
				"tanggal" => date('Y-m-d H:i:s'),
				"idUser" => $idUser,
				"status" => 0
			);

			$this->modelPublic->insert("kl_resepheader",$dataInsert);
			$this->modelInputTindakan->insertNoPermintaanItem("kl_resep",$noPermintaan,$noPendaftaran);
		}
	}

	function updateSelisih(){
		$noPendaftaran = $this->dekripsi($this->input->post("noPendaftaran"));
		$kode = $this->input->post("kode");
		$selisih = $this->input->post("selisih");

		$dataUpdate = array(
			"selisih" => $selisih
		);

		$where = array(
			"noPendaftaran" => $noPendaftaran,
			"idTindakan" => $kode,
		);

		$this->modelPublic->update("kl_tindakanorder",$where,$dataUpdate);
	}

	function updateQty(){
		$noPendaftaran = $this->dekripsi($this->input->post("noPendaftaran"));
		$kode = $this->input->post("kode");
		$qty = $this->input->post("qty");

		$dataUpdate = array(
			"qty" => $qty
		);

		$where = array(
			"noPendaftaran" => $noPendaftaran,
			"idTindakan" => $kode,
		);

		$this->modelPublic->update("kl_tindakanorder",$where,$dataUpdate);
	}

	function daftarBiaya(){
		$this->load->model("modelKasir");

		$noPendaftaran = $this->dekripsi($this->input->post("noPendaftaran"));
		$totalTindakan = $this->modelKasir->totalTindakan($noPendaftaran);
		$totalObat = $this->modelKasir->totalObat($noPendaftaran);
		$totalLab = $this->modelKasir->totalLab($noPendaftaran);
		$totalRadiologi = $this->modelKasir->totalRadiologi($noPendaftaran);
		$diskon = $this->modelKasir->totalDiskon($noPendaftaran);
		$subtotal = $totalTindakan+$totalObat+$totalLab+$totalRadiologi;

		$dataArray[] = array(
			"pelayanan" => $totalTindakan,
			"resep" => $totalObat,
			"lab" => $totalLab,
			"rad" => $totalRadiologi,
			"subtotal" => $subtotal,
			"diskon" => $diskon,
			"grandTotal" => $subtotal-$diskon
		);

		echo json_encode($dataArray);
	}

	function cetakResepModal(){
		$noPendaftaran = $this->dekripsi($this->input->post("noPendaftaran"));
		$data['cart'] = $this->modelInputTindakan->tampilkanCartResep($noPendaftaran);
		$data['noPendaftaran'] = $this->enkripsi($noPendaftaran);
		$this->load->view("inputtindakan/rajal/cetakResepOnModal",$data);
	}

	function cetakResep(){
		$this->global['pageTitle'] = "SIMRS - Input Tindakan Rawat Jalan";
		$noPendaftaran = $this->dekripsi($this->uri->segment(3));
		$data['header'] = $this->db->get_where("viewheaderrs")->row();
		$data['cart'] = $this->modelInputTindakan->tampilkanCartResep($noPendaftaran);
		$this->loadViews("inputtindakan/cetakResep",$this->global,$data,"pendaftaran/footerCetak");
	}
}