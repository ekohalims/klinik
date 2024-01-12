<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class ModelInputTindakan extends CI_Model{
    function totalRowPasien($asal){
        $this->db->from("viewpasienregist");
		$this->db->where("status",0);
		$this->db->where("asalDaftar",$asal);
        return $this->db->count_all_results();
	}
	
	function viewPasienDatatable($limit,$start,$search,$asal){
		$this->db->select("*");
		$this->db->from("viewpasienregist");
		$this->db->where("asalDaftar",$asal);
		$this->db->where("status",0);

		if($this->input->post('poli')!==null && $this->input->post('poli')!=='')
			$this->db->where("poliklinik",$this->input->post('poli'));
		if($this->input->post('dokter')!==null && $this->input->post('dokter')!=='')
			$this->db->where("namaDokter",$this->input->post('dokter'));
        if($this->input->post('tgl_daftar')!==null && $this->input->post('tgl_daftar')!=='')			
			$this->db->like("tanggalDaftar",$this->input->post('tgl_daftar'),"after");
		if(!empty($search)){
			$this->db->group_start();
			$this->db->like("namaLengkap",$search);
			$this->db->or_where("idPasien",$search);
			$this->db->or_like("noPendaftaran",$search);
			$this->db->group_end();
		}
		
		$this->db->limit($limit,$start);
		$this->db->order_by("tanggalDaftar","DESC");
		return $this->db->get();
	}

	function viewPasienDatatableRanap($limit,$start,$search,$idPos){
		$this->db->select("*");
		$this->db->from("viewregistranap");
		$this->db->where("status",0);

		if(!empty($idPos)){
			$this->db->where("idPos",$idPos);
		}

		if(!empty($search)){
			$this->db->like("namaLengkap",$search);
			$this->db->or_where("idPasien",$search);
		}

		$this->db->limit($limit,$start);
		$this->db->order_by("tanggalDaftar","ASC");
		return $this->db->get();
	}

    //lama yg bawah
	function getProdukExpiredFirst($idProduk){
		$this->db->select("ap_produk_exp.expiredDate");
		$this->db->from("ap_produk_exp");
		$this->db->where("id_produk",$idProduk);
		$this->db->where("stok > 0");
		$this->db->order_by("expiredDate","ASC");
		$this->db->limit(1,0);
		$query = $this->db->get()->result();
		foreach($query as $row){
			return $row->expiredDate;
		}
	}

	function judulAntrian($idDokter,$idPoliklinik){
		$this->db->select(array("kl_dokter.nama","kl_poliklinik.poliklinik"));
		$this->db->from("kl_dokter");
		$this->db->join("kl_poliklinik","kl_poliklinik.id_poliklinik = kl_dokter.idPoliklinik");
		$this->db->where("kl_dokter.id_dokter",$idDokter);
		$this->db->where("kl_dokter.idPoliklinik",$idPoliklinik);
		$query = $this->db->get()->row();
		return $query;
	}

	function dataPendaftaranRow($noPendaftaran){
		$this->db->select(array("kl_pasien.noPasien","kl_pasien.namaLengkap","kl_poliklinik.poliklinik","kl_asuransi.namaAsuransi","kl_dokter.nama as namaDokter","kl_daftar.tanggalDaftar","kl_daftar.noPendaftaran","kl_pasien.tempatLahir","kl_pasien.tanggalLahir","kl_pasien.jenisKelamin","kl_layanan.layanan"));
		$this->db->from("kl_daftar");
		$this->db->join("kl_dokter","kl_dokter.id_dokter = kl_daftar.idDokter","left");
		$this->db->join("kl_poliklinik","kl_poliklinik.id_poliklinik = kl_daftar.idPoliklinik","left");
		$this->db->join("kl_pasien","kl_pasien.noPasien = kl_daftar.idPasien","left");
		$this->db->join("kl_layanan","kl_layanan.id_layanan = kl_daftar.idLayanan","left");
		$this->db->join("kl_asuransi","kl_asuransi.idAsuransi = kl_daftar.asuransi","left");
		$this->db->where("kl_daftar.noPendaftaran",$noPendaftaran);
		return $this->db->get()->row();
	}

	function jenisKunjungan($noPasien){
		$this->db->from("kl_daftar");
		$this->db->where("idPasien",$noPasien);
		$count = $this->db->count_all_results();

		if($count <= 1){
			return "Baru";
		} else {
			return "Pernah Berkunjung";
		}
	}

	function simpanCatatan($dataArray){
		$this->db->insert("kl_catatan",$dataArray);
	}

	function cekCatatanExist($noPendaftaran){
		$this->db->from("kl_catatan");
		$this->db->where("noPendaftaran",$noPendaftaran);
		return $this->db->count_all_results();
	}

	function updateCatatan($dataArray,$noPendaftaran){
		$this->db->where("noPendaftaran",$noPendaftaran);
		$this->db->update("kl_catatan",$dataArray);
	}

	function tampilkanLabAktif(){
		$this->db->select("*");
		$this->db->from("kl_labitem");
		$this->db->where("isDelete",1);
		$this->db->where("status",1);
		$this->db->order_by("id","DESC");
		return $this->db->get()->result();
	}

	function tampilkanRadAktif(){
		$this->db->select("*");
		$this->db->from("kl_tarifradiologi");
		$this->db->order_by("kode","DESC");
		return $this->db->get()->result();
	}

	function hargaLab($id){
		$this->db->select("harga");
		$this->db->from("kl_labitem");
		$this->db->where("id",$id);
		$query = $this->db->get()->row();
		return $query->harga;
	}

	function hargaRad($id){
		$this->db->select("tarif");
		$this->db->from("kl_tarifradiologi");
		$this->db->where("kode",$id);
		$query = $this->db->get()->row();
		return $query->tarif;
	}

	function tampilkanCartLab($noPendaftaran){
		$this->db->select(array("kl_tariflab.namaTarif","kl_orderlab.harga","kl_orderlab.noPendaftaran","kl_orderlab.idLab","kl_orderlab.catatan"));
		$this->db->from("kl_orderlab");
		$this->db->join("kl_tariflab","kl_tariflab.kode = kl_orderlab.idLab");
		//$this->db->where("kl_orderlab.noPermintaan",$noPendaftaran);
		$this->db->where("kl_orderlab.noPendaftaran",$noPendaftaran);
		return $this->db->get();
	}

	function tampilkanCartRad($noPendaftaran){
		$this->db->select(array("kl_tarifradiologi.namaTarif","kl_orderradiologi.harga","kl_orderradiologi.noPendaftaran","kl_orderradiologi.idRadiologi","kl_orderradiologi.catatan"));
		$this->db->from("kl_orderradiologi");
		$this->db->join("kl_tarifradiologi","kl_tarifradiologi.kode = kl_orderradiologi.idRadiologi");
		//$this->db->where("kl_orderRadiologi.noPermintaan",$noPendaftaran);
		$this->db->where("kl_orderRadiologi.noPendaftaran",$noPendaftaran);
		//$this->db->where("kl_orderRadiologi.noPermintaan",NULL);
		return $this->db->get();
	}

	function tampilkanCartLabRNP($noPendaftaran){
		$this->db->select(array("kl_tariflab.namaTarif as namaLab","kl_orderlab.harga","kl_orderlab.noPendaftaran","kl_orderlab.idLab","kl_orderlab.catatan"));
		$this->db->from("kl_orderlab");
		$this->db->join("kl_tariflab","kl_tariflab.kode = kl_orderlab.idLab");
		$this->db->where("kl_orderlab.noPendaftaran",$noPendaftaran);
		$this->db->where("kl_orderlab.noPermintaan",NULL);
		return $this->db->get();
	}

	function tampilkanCartRadRNP($noPendaftaran){
		$this->db->select(array("kl_tarifradiologi.namaTarif as namaRadiologi","kl_orderradiologi.harga","kl_orderradiologi.noPendaftaran","kl_orderradiologi.idRadiologi","kl_orderradiologi.catatan"));
		$this->db->from("kl_orderradiologi");
		$this->db->join("kl_tarifradiologi","kl_tarifradiologi.kode = kl_orderradiologi.idRadiologi");
		$this->db->where("kl_orderRadiologi.noPendaftaran",$noPendaftaran);
		$this->db->where("kl_orderRadiologi.noPermintaan",NULL);
		return $this->db->get();
	}

	function tampilkanCartDiagnosa($noPendaftaran){
		$this->db->select(array("kl_icd.id","kl_icd.code","kl_icd.str as diagnosa","kl_diagnosa.keterangan","kl_icd.sab as icd"));
		$this->db->from("kl_diagnosa");
		$this->db->join("kl_icd","kl_icd.id = kl_diagnosa.idDiagnosa");
		$this->db->where("kl_diagnosa.noPendaftaran",$noPendaftaran);
		return $this->db->get();
	}

	function totalDiagnosa(){
		$this->db->from("kl_icd");
		return $this->db->count_all_results();
	}

	function viewICDXdatatables($limit,$start,$search){
		$this->db->select(array("code","str as diagnosa","sab","id"));
		$this->db->from("kl_icd");

		if(!empty($search)){
			$this->db->like("code",$search);
			$this->db->or_like("str",$search);
		}

		$this->db->limit($limit,$start);
		return $this->db->get();
	}

	function viewObatPercategory($limit,$start,$search,$idKategori){
		$this->db->select(array("ap_produk.id_produk","ap_produk.nama_produk","ap_produk.satuan","ap_kategori.kategori"));
		$this->db->from("ap_produk");
		$this->db->where('status',1);

		if(!empty($idKategori)){
			$this->db->where("id_kategori",$idKategori);
		}

		if(!empty($search)){
			$this->db->like("ap_produk.nama_produk",$search);
			$this->db->or_like("ap_produk.id_produk",$search);
		}

		$this->db->join("ap_kategori","ap_kategori.id_kategori = ap_produk.id_kategori");
		$this->db->limit($limit,$start);
		return $this->db->get();
	}

	function totalObatPercategory($idKategori){
		$this->db->from("ap_produk");
		$this->db->where("status",1);

		if(!empty($idKategori)){
			$this->db->where("id_kategori",$idKategori);
		}
		
		return $this->db->count_all_results();
	}

	function namaObat($id_produk){
		$this->db->select("nama_produk");
		$this->db->from("ap_produk");
		$this->db->where("id_produk",$id_produk);
		$query = $this->db->get()->row();
		return $query->nama_produk;
	}

	function hargaObatPerstore($idProduk,$idToko){
		$this->db->select("harga");
		$this->db->from("ap_produk_price");
		$this->db->where("id_produk",$idProduk);
		$this->db->where("id_toko",$idToko);
		$query = $this->db->get()->row();
		return $query->harga;
	}

	function tampilkanCartResep($noPendaftaran){
		$this->db->select(array("kl_resep.harga","ap_produk.id_produk","ap_produk.nama_produk","ap_kategori.kategori","kl_resep.aturan","kl_resep.jumlah","ap_produk.satuan"));
		$this->db->from("kl_resep");
		$this->db->join("ap_produk","ap_produk.id_produk = kl_resep.idObat");
		$this->db->join("ap_kategori","ap_kategori.id_kategori = ap_produk.id_kategori");
		$this->db->where("kl_resep.noPendaftaran",$noPendaftaran);
		return $this->db->get();
	}

	function daftarTindakanAktif(){
		$this->db->select("*");
		$this->db->from("kl_tindakan");
		$this->db->where("status",1);
		$this->db->where("isDelete",1);
		return $this->db->get()->result();
	}

	function tarifPelayanan($tableName){
		$this->db->select("*");
		$this->db->from($tableName);
		$this->db->join("kl_masterjenis","kl_masterjenis.id = $tableName.jenis","left");
		$this->db->order_by("namaTarif","ASC");
		return $this->db->get()->result();
	}

	function hargaTindakan($idTindakan){
		$this->db->select("tarif");
		$this->db->from("kl_tindakan");
		$this->db->where("idTindakan",$idTindakan);
		$query = $this->db->get()->row();
		return $query->tarif;
	}

	function pelayananField($tableName,$column,$kode){
		$this->db->select($column);
		$this->db->from($tableName);
		$this->db->where("kode",$kode);
		return $this->db->get()->row()->$column;
	}

	function komisiTindakan($idTindakan){
		$this->db->select("komisi");
		$this->db->from("kl_tindakan");
		$this->db->where("idTindakan",$idTindakan);
		$query = $this->db->get()->row();
		return $query->komisi;
	}

	function viewTindakanCart($noPendaftaran,$tableName){
		$this->db->select(
			array(
				"kl_tindakanorder.idTindakan",
				$tableName.".namaTarif",
				"kl_tindakanorder.harga",
				"kl_dokter.nama as namaDokter",
				"kl_tindakanorder.selisih",
				"kl_tindakanorder.qty",
				$tableName.".kode",
				$tableName.".dokter",
				"kl_tindakanorder.tanggal"
			)
		);
		$this->db->from("kl_tindakanorder");
		$this->db->join($tableName,"$tableName.kode = kl_tindakanorder.idTindakan");
		$this->db->join("kl_dokter","kl_dokter.id_dokter = kl_tindakanorder.dokter","left");
		$this->db->where("kl_tindakanorder.noPendaftaran",$noPendaftaran);
		return $this->db->get();
	}

	function hapusTindakan($noPendaftaran,$idTindakan){
		$this->db->delete("kl_tindakanorder",array("idTindakan" => $idTindakan, "noPendaftaran" => $noPendaftaran));
	}

	function cekTindakLanjutIfExist($noPendaftaran){
		$this->db->from("kl_tindaklanjutpasien");
		$this->db->where("noPendaftaran",$noPendaftaran);
		return $this->db->count_all_results();
	}

	function currentTindakLanjut($noPendaftaran){
		$this->db->select("*");
		$this->db->from("kl_tindaklanjutpasien");
		$this->db->where("noPendaftaran",$noPendaftaran);
		return $this->db->get()->row();
	}

	function updateTindakanOnProcess($noPendaftaran){
		$dataArray = array(
			"status" => 1
		);

		$this->db->where("noPendaftaran",$noPendaftaran);
		$this->db->update("kl_daftar",$dataArray);
	}

	function updateTindakanSelesai($noPendaftaran){
		$dataArray = array(
			"status" => 2
		);

		$this->db->where("noPendaftaran",$noPendaftaran);
		$this->db->update("kl_daftar",$dataArray);
	}

	function cekIfLabExist($noPendaftaran){
		$this->db->from("kl_orderlab");
		$this->db->where("noPendaftaran",$noPendaftaran);
		return $this->db->count_all_results();
	}

	function cekIfRadExist($noPendaftaran){
		$this->db->from("kl_orderradiologi");
		$this->db->where("noPendaftaran",$noPendaftaran);
		return $this->db->count_all_results();
	}

	function cekIfResepExist($noPendaftaran){
		$this->db->from("kl_resep");
		$this->db->where("noPendaftaran",$noPendaftaran);
		return $this->db->count_all_results();
	}

	function dataRiwayatBerobat($idPasien){
		$this->db->select(array("kl_poliklinik.poliklinik","kl_catatan.catatan","kl_catatan.riwayatAlergi","kl_daftar.noPendaftaran","kl_daftar.tanggalDaftar","kl_dokter.nama as namaDokter","kl_icd.STR as diagnosa"));
		$this->db->from("kl_daftar");
		$this->db->join("kl_diagnosa","kl_diagnosa.noPendaftaran = kl_daftar.noPendaftaran","left");
		$this->db->join("kl_icd","kl_icd.id = kl_diagnosa.idDiagnosa","left");
		$this->db->join("kl_dokter","kl_dokter.id_dokter = kl_daftar.idDokter","left");
		$this->db->join("kl_catatan","kl_catatan.noPendaftaran = kl_daftar.noPendaftaran","left");
		$this->db->join("kl_poliklinik","kl_poliklinik.id_poliklinik = kl_daftar.idPoliklinik","left");
		$this->db->where("kl_daftar.idPasien",$idPasien);
		$this->db->where("kl_daftar.status",2);
		$this->db->group_by("kl_daftar.noPendaftaran");
		return $this->db->get();
	}

	function numRowsJumlahProduk($search,$idKategori){
		$this->db->from("ap_produk");

		if(!empty($idKategori)){
			$this->db->where("ap_produk.id_kategori",$idKategori);
		}

		if(!empty($search)){
			$this->db->like("ap_produk.id_produk",$search);
			$this->db->or_like("ap_produk.nama_produk",$search);
		}
		return $this->db->count_all_results();
	}

	function viewItemObat($search,$limitOnNextPage,$idKategori,$perPage){
		$this->db->select(array("ap_produk.id_produk","ap_produk.nama_produk","ap_produk.satuan","ap_kategori.kategori"));
		$this->db->from("ap_produk");
		$this->db->join("ap_kategori","ap_kategori.id_kategori = ap_produk.id_kategori","left");
		
		if(!empty($idKategori)){
			$this->db->where("ap_produk.id_kategori",$idKategori);
		}
		
		if(!empty($search)){
			$this->db->like("ap_produk.id_produk",$search);
			$this->db->or_like("ap_produk.nama_produk",$search);
		}

		$this->db->limit($perPage,$limitOnNextPage);
		return $this->db->get();
	}

	function cekResepExist($idProduk,$noPendaftaran){
		$this->db->from("kl_resep");
		$this->db->where("noPendaftaran",$noPendaftaran);
		$this->db->where("idObat",$idProduk);
		return $this->db->count_all_results();
	}

	function currentQtyResep($idProduk,$noPendaftaran){
		$this->db->select("jumlah");
		$this->db->from("kl_resep");
		$this->db->where("noPendaftaran",$noPendaftaran);
		$this->db->where("idObat",$idProduk);
		$query = $this->db->get()->row()->jumlah;
		return $query;
	}

	function currentStokItem($idProduk){
		$this->db->select("stok");
		$this->db->from("ap_produk");
		$this->db->where("ap_produk.id_produk",$idProduk);
		$query = $this->db->get()->row();
		return $query->stok;
	}

	function updateTindakLanjutParam($dataUpdate,$noPendaftaran){
		$this->db->where("noPendaftaran",$noPendaftaran);
		$this->db->update("kl_tindaklanjutpasien",$dataUpdate);
	}

	function getGolonganDarah($idPasien){
		$this->db->select("golonganDarah");
		$this->db->from("kl_pasien");
		$this->db->where("noPasien",$idPasien);
		return $this->db->get()->row()->golonganDarah;
	}

	function updateGolonganDarah($dataUpdate,$idPasien){
		$this->db->where("noPasien",$idPasien);
		$this->db->update("kl_pasien",$dataUpdate);
	}

	function kamarRanapPasien($noPendaftaran){
		$this->db->select(array("kl_ruangan.namaRuang","kl_ranaptopasien.tanggalMasuk","kl_ranaptopasien.tanggalKeluar","kl_ranaptopasien.status","kl_ranaptopasien.tarif","kl_ranaptopasien.status","kl_ranaptopasien.noPendaftaran","kl_ranaptopasien.kodeRuang"));
		$this->db->from("kl_ranaptopasien");
		$this->db->join("kl_ruangan","kl_ruangan.kodeRuang = kl_ranaptopasien.kodeRuang","left");
		$this->db->where("kl_ranaptopasien.noPendaftaran",$noPendaftaran);
		$this->db->order_by("kl_ranaptopasien.tanggalMasuk","DESC");
		return $this->db->get()->result();
	}

	function updateQtyResep($dataUpdate,$idProduk,$noPendaftaran){
		$this->db->where("noPendaftaran",$noPendaftaran);
		$this->db->where("idObat",$idProduk);
		$this->db->update("kl_resep",$dataUpdate);
	}

	function urutanPermintaan($tableName,$noPendaftaran){
		$this->db->from($tableName);
		$this->db->where("noPendaftaran",$noPendaftaran);
		return $this->db->count_all_results();
	}

	function insertNoPermintaanitem($tableName,$noPermintaan,$noPendaftaran){
		$dataUpdate = array(
			"noPermintaan" => $noPermintaan
		);

		$this->db->where("noPendaftaran",$noPendaftaran);
		$this->db->where("noPermintaan",NULL);
		$this->db->update($tableName,$dataUpdate);
	}

	function riwayatPermintaanLab($noPendaftaran){
		$this->db->select("*");
		$this->db->from("viewriwayatpermintaanlab");
		$this->db->where("noPendaftaran",$noPendaftaran);
		$this->db->where("noPermintaan != ''");
		return $this->db->get();
	}

	function riwayatPermintaanRad($noPendaftaran){
		$this->db->select("*");
		$this->db->from("viewriwayatpermintaaanrad");
		$this->db->where("noPendaftaran",$noPendaftaran);
		$this->db->where("noPermintaan != ''");
		return $this->db->get();
	}

	function itemOrderLab($noPermintaan){
		$this->db->select("kl_labitem.namaLab");
		$this->db->from("kl_orderlab");
		$this->db->join("kl_labitem","kl_labitem.id = kl_orderlab.idLab","left");
		$this->db->where("kl_orderlab.noPermintaan",$noPermintaan);
		return $this->db->get()->result();
	}

	function itemOrderRad($noPermintaan){
		$this->db->select("kl_radiologiitem.namaRadiologi");
		$this->db->from("kl_orderradiologi");
		$this->db->join("kl_radiologiitem","kl_radiologiitem.id = kl_orderradiologi.idRadiologi","left");
		$this->db->where("kl_orderradiologi.noPermintaan",$noPermintaan);
		return $this->db->get()->result();
	}

	function kamarKeluar($noPendaftaran){
		$getDataKamar = $this->dataKamarNon($noPendaftaran);

		foreach($getDataKamar as $row){
			$kodeRuang = $row->kodeRuang;

			$dataUpdate = array(
				"tanggalKeluar" => date('Y-m-d'),
				"status" => 1
			);

			$this->db->where("noPendaftaran",$noPendaftaran);
			$this->db->where("kodeRuang",$kodeRuang);
			$this->db->update("kl_ranaptopasien",$dataUpdate);
		}
	}

	function dataKamarNon($noPendaftaran){
		$this->db->select("*");
		$this->db->from("kl_ranaptopasien");
		$this->db->where("noPendaftaran",$noPendaftaran);
		$this->db->where("status","0");
		return $this->db->get()->result();
	}
}