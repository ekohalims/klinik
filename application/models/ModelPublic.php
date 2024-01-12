<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class ModelPublic extends CI_Model{
	function getValueOfTable($tableName,$column,$where){
		$this->db->select($column);
		$this->db->from($tableName);
		
		foreach($where as $key => $value){
			$this->db->where($key,$value);
		}

		$query = $this->db->get()->row();
		return $query->$column;
	}

	function insert($tableName,$dataArray){
		$this->db->insert($tableName,$dataArray);
		return $this->db->affected_rows();
	}

	function insertBatch($tableName,$dataArray){
		$this->db->insert_batch($tableName,$dataArray);
		return $this->db->affected_rows();
	}

	function insertReturnID($table,$data){
		$this->db->insert($table,$data);
		return $this->db->insert_id();
	}

	function delete($tableName,$param){
		$this->db->delete($tableName,$param);
		return $this->db->affected_rows();
	}

	function update($tableName,$param,$dataArray){

		foreach($param as $key => $value){
			$this->db->where($key,$value);
		}

		$this->db->update($tableName,$dataArray);
		return $this->db->affected_rows();
	}

	function countRow($tableName,$where){
		$this->db->from($tableName);

		if(!empty($where)){
			foreach($where as $key => $value){
				$this->db->where($key,$value);
			}
		}

		return $this->db->count_all_results();
	}

	function selectAll($tableName,$where,$join){
		$this->db->select("*");
		$this->db->from($tableName);

		if(!empty($join)){
			foreach($join as $key => $row){
				$this->db->join($row['joinWith'],$row['onJoin'],$row['type']);
			}
		}

		if(!empty($where)){
			foreach($where as $key => $value){
				$this->db->where($key,$value);
			}
		}
		
		return $this->db->get()->result();
	}


	function select($tableName,$where,$join,$orderBy){
		$this->db->select("*");
		$this->db->from($tableName);

		if(!empty($join)){
			foreach($join as $key => $row){
				$this->db->join($row['joinWith'],$row['onJoin'],$row['type']);
			}
		}

		if(!empty($where)){
			foreach($where as $key => $value){
				$this->db->where($key,$value);
			}
		}

		if(!empty($orderBy)){
			foreach($orderBy as $key => $value){
				$this->db->order_by($key,$value);
			}
		}
		
		return $this->db->get()->result();
	}

	function insertLog($idUser,$activity){
		$dataInsert = array(
			"idUser" => $idUser,
			"tanggal" => date('Y-m-d H:i:s'),
			"activity" => $activity
		);

		$this->db->insert("users_log",$dataInsert);
	}

	function getTarifKamar($kodeRuang){
		$this->db->select("tarif");
		$this->db->from("kl_ruanggroup");
		$this->db->join("kl_ruangan","kl_ruangan.kodeGroup = kl_ruanggroup.kodeGroup");
		$this->db->where("kl_ruangan.kodeRuang",$kodeRuang);
		$this->db->group_by("kl_ruanggroup.kodeGroup");
		$query = $this->db->get()->result();

		foreach($query as $row){
			return $row->tarif;
		}
	}

	function checkEmailIfExist($email){
		$this->db->from("users");
		$this->db->where("email",$email);
		return $this->db->count_all_results();
	}

	function checkUsername($username){
		$this->db->from("users");
		$this->db->where("username",$username);
		return $this->db->count_all_results();
	}

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

	function idUser($email){
		$this->db->select("id");
		$this->db->from("users");
		$this->db->where("email",$email);
		$query = $this->db->get()->row();

		return $query->id;
	}

	function updateInfoPerusahaanSQL($dataUpdate){
		$this->db->where("id",1);
		$this->db->update("kl_klinikinfo",$dataUpdate);
		$affect = $this->db->affected_rows();
		return $affect;
	}

	function updateEmailSetting($dataUpdate){
		$this->db->where("id",1);
		$this->db->update("settingemail",$dataUpdate);

		$affect = $this->db->affected_rows();
		return $affect;
	}

	function updateTampilanSetting($dataUpdate){
		$this->db->where("id",1);
		$this->db->update("setting",$dataUpdate);
	}

	function cekIDexist($noID){
		$this->db->from("kl_pasien");
		$this->db->where("noID",$noID);
		return $this->db->count_all_results();
	}

	function daftarDokterAktif(){
		$this->db->select(array("id_dokter","nama"));
		$this->db->from("kl_dokter");
		$this->db->where("status",1);
		$this->db->where("isDelete",1);
		return $this->db->get()->result();
	}

	function daftarPoliAktif(){
		$this->db->select("*");
		$this->db->from("kl_poliklinik");
		$this->db->where("isDelete",1);
		$this->db->where("status",1);
		$this->db->order_by("poliklinik","ASC");
		return $this->db->get()->result();
	}

	function getPasienAjax($q){
		$this->db->select(array("kl_pasien.noPasien","kl_pasien.namaLengkap"));
		$this->db->from("kl_pasien");
		$this->db->like("kl_pasien.noPasien",$q);
		$this->db->or_like("kl_pasien.namaLengkap",$q);
		return $this->db->get();
	}

	function getDiagnosaAjax($q){
		$this->db->select(array("kl_icd.id","kl_icd.code","kl_icd.str"));
		$this->db->from("kl_icd");
		$this->db->like("kl_icd.code",$q);
		$this->db->or_like("kl_icd.str",$q);
		return $this->db->get();
	}

	function currentStokGudang($sku){
		$this->db->select("stok");
		$this->db->from("ap_produk");
		$this->db->where("id_produk",$sku);
		$query = $this->db->get();
		foreach($query->result() as $row){
			return $row->stok;
		}
	}

	function currentStokToko($id_produk,$id_store){
		$this->db->select("stok");
		$this->db->from("stok_store");
		$this->db->where("id_produk",$id_produk);
		$this->db->where("id_store",$id_store);
		$query = $this->db->get();

		foreach($query->result() as $row){
			return $row->stok;
		}
	}

	function namaStore($idStore){
		$this->db->select("store");
		$this->db->from("ap_store");
		$this->db->where("id_store",$idStore);
		$query = $this->db->get()->row();
		return $query->store;
	}

	function get_produk_select2(){
		$this->db->select(array("ap_produk.nama_produk","ap_produk.id_produk"));
		$this->db->from("ap_produk");
		$this->db->where("status",1);
		return $this->db->get();
	}

	function produk_search_all($q){
		$this->db->select(array("ap_produk.id_produk","ap_produk.nama_produk"));
		$this->db->from("ap_produk");
		$this->db->like("ap_produk.nama_produk",$q);
		$this->db->or_like("ap_produk.id_produk",$q);
		return $this->db->get();
	}

	function cekProdukTokoIfExist($id_produk,$id_store){
		$this->db->from("stok_store");
		$this->db->where("id_produk",$id_produk);
		$this->db->where("id_store",$id_store);
		return $this->db->count_all_results();
	}

	function listLabAktif(){
		$this->db->select(array("kode as id","namaTarif as namaLab"));
		$this->db->from("kl_tariflab");
		return $this->db->get()->result();
	}

	function listRadiologiAktif(){
		$this->db->select(array("kl_tarifradiologi.kode as id","kl_tarifradiologi.namaTarif as namaRadiologi"));
		$this->db->from("kl_tarifradiologi");
		return $this->db->get()->result();
	}

	function getHeaderNavigation($uri){
		$this->db->select("z_menu_klinik.id");
		$this->db->from("z_menu_klinik");
		$this->db->join("z_submenu_klinik","z_submenu_klinik.id = z_menu_klinik.id");
		$this->db->where("z_submenu_klinik.slug",$uri);
		$query =  $this->db->get()->result();

		foreach($query as $row){
			return $row->id;
		}
	}

	function hutangTerbayar($noPendaftaran){
		$this->db->select_sum("nilaiBayar");
		$this->db->from("kl_piutang_pembayaran");
		$this->db->where("noPendaftaran",$noPendaftaran);
		$query = $this->db->get()->result();
		foreach($query as $row){
			return $row->nilaiBayar;
		}
	}

	function dataPiutangRow($noPendaftaran){
		$this->db->select(array("kl_piutang.status","kl_invoice.noInvoice","kl_piutang.noPendaftaran","kl_pasien.noPasien","kl_daftar.tanggalDaftar","kl_pasien.namaLengkap as namaPasien","kl_pasien.jenisKelamin","kl_pasien.tanggalLahir","kl_dokter.nama as namaDokter","kl_poliklinik.poliklinik","kl_piutang.jatuhTempo","kl_pasien.tempatLahir"));
		$this->db->from("kl_piutang");
		$this->db->join("kl_invoice","kl_invoice.noPendaftaran = kl_piutang.noPendaftaran");
		$this->db->join("kl_daftar","kl_daftar.noPendaftaran = kl_piutang.noPendaftaran");
		$this->db->join("kl_pasien","kl_pasien.noPasien = kl_daftar.idPasien");
		$this->db->join("kl_dokter","kl_dokter.id_dokter = kl_daftar.idDokter");
		$this->db->join("kl_poliklinik","kl_poliklinik.id_poliklinik = kl_daftar.idPoliklinik","left");
		$this->db->where("kl_piutang.noPendaftaran",$noPendaftaran);
		return $this->db->get()->row();
	}

	function riwayatPembayaran($noPendaftaran){
		$this->db->select(array("kl_piutang_pembayaran.noPembayaran","kl_piutang_pembayaran.tanggalBayar","users.first_name","ap_payment_type.payment_type","coa_sub.namaSubAkun as account","kl_piutang_pembayaran.keterangan","kl_piutang_pembayaran.nilaiBayar"));
		$this->db->from("kl_piutang_pembayaran");
		$this->db->join("users","users.id = kl_piutang_pembayaran.idUser");
		$this->db->join("ap_payment_type","ap_payment_type.id = kl_piutang_pembayaran.typeBayar");
		$this->db->join("coa_sub","coa_sub.kodeSubAkun = kl_piutang_pembayaran.subAccount","left");
		$this->db->where("kl_piutang_pembayaran.noPendaftaran",$noPendaftaran);
		$this->db->group_by("kl_piutang_pembayaran.noPembayaran");
		return $this->db->get();
	}

	function headerInvoice($noPendaftaran){
		$this->db->select(array("kl_invoice.noInvoice","kl_invoice.noPendaftaran","kl_daftar.idPasien","kl_daftar.tanggalDaftar","kl_invoice.tanggalBayar","kl_piutang.jatuhTempo","kl_pasien.namaLengkap as namaPasien","kl_pasien.tanggalLahir","kl_pasien.alamat","kl_dokter.nama as namaDokter"));
		$this->db->from("kl_invoice");
		$this->db->join("kl_daftar","kl_daftar.noPendaftaran = kl_invoice.noPendaftaran");
		$this->db->join("kl_pasien","kl_pasien.noPasien = kl_daftar.idPasien");
		$this->db->join("kl_piutang","kl_piutang.noPendaftaran = kl_invoice.noPendaftaran");
		$this->db->join("kl_dokter","kl_dokter.id_dokter = kl_daftar.idDokter");
		$this->db->where("kl_invoice.noPendaftaran",$noPendaftaran);
		$query = $this->db->get()->row();
		return $query;
	}

	function viewAsuransi(){
		$this->db->select("*");
		$this->db->from("kl_asuransi");
		$this->db->where("isDelete",1);
		return $this->db->get()->result();
	}

	function tempatPenerimaan($tempatPenerimaan){
		$this->db->select("store");
		$this->db->from("ap_store");
		$this->db->where("id_store",$tempatPenerimaan);
		$query = $this->db->get()->row();
		return $query->store;
	}

	function viewBank(){
		$this->db->select(array("bank.kodeBank","coa_sub.namaSubAkun as bank","bank.cabang","bank.noRekening","bank.atasNama","coa_sub.status"));
		$this->db->from("bank");
		$this->db->join("coa_sub","coa_sub.kodeSubAkun = bank.kodeBank");
		$this->db->where("coa_sub.isDelete",1);
		return $this->db->get()->result();
	}

	function tambahBankSQL($dataArray){
		$this->db->insert("bank",$dataArray);
	}

	function kodeBank(){
		$this->db->from("bank");
		return $this->db->count_all_results();
	}

	function editBankSQL($dataArray,$kodeAkun){
		$this->db->where("kodeBank",$kodeAkun);
		$this->db->update("bank",$dataArray);
	}

	function hapusBank($kodeAkun){
		$dataUpdate = array(
			"isDelete" => 0
		);

		$this->db->where("kodeSubAkun",$kodeAkun);
		$this->db->update("coa_sub",$dataUpdate);
	}

	function insertBankAccount($dataCoa){
		$this->db->insert("coa_sub",$dataCoa);
	}

	function getDataBank($kodeAkun){
		$this->db->select(array("bank.kodeBank","bank.cabang","coa_sub.namaSubAkun as bank","bank.noRekening","bank.atasNama","coa_sub.isDelete","coa_sub.status","bank.debit","bank.kredit","bank.transfer"));
		$this->db->from("bank");
		$this->db->join("coa_sub","coa_sub.kodeSubAkun = bank.kodeBank");
		$this->db->where("bank.kodeBank",$kodeAkun);
		$query = $this->db->get()->row();
		return $query;
	}

	function editBankAccount($dataBank,$kodeAkun){
		$this->db->where("kodeSubAkun",$kodeAkun);
		$this->db->update("coa_sub",$dataBank);
	}

	function insertKartuStok($dataKartuStok){
		$this->db->insert_batch("kartu_stok",$dataKartuStok);
	}

	function insertKartuStokToko($dataKartuStokToko){
		$this->db->insert_batch("kartu_stok_toko",$dataKartuStokToko);
	}

	function produkAjaxAll($q){
		$this->db->select(array("ap_produk.id_produk","ap_produk.nama_produk"));
		$this->db->from("ap_produk");
		$this->db->like("ap_produk.nama_produk",$q);
		$this->db->or_like("ap_produk.id_produk",$q);
		return $this->db->get();
	}

	function dataPasienLengkap($idPasien){
        $this->db->select(array("kl_pasien.namaLengkap","kl_pasien.golonganDarah","kl_pasien.tanggalLahir","kl_pasien.jenisKelamin","kl_pasien.pekerjaan","kl_pasien.alamat","kl_pasien.rtrw","kl_pasien.kelurahan","ae_provinsi.nama_provinsi","ae_kabupaten.nama_kabupaten","ae_kecamatan.kecamatan"));
        $this->db->from("kl_pasien");
        $this->db->join("ae_provinsi","ae_provinsi.id_provinsi = kl_pasien.provinsi","left");
        $this->db->join("ae_kabupaten","ae_kabupaten.kabupaten_id = kl_pasien.kabupaten","left");
        $this->db->join("ae_kecamatan","ae_kecamatan.id_kecamatan = kl_pasien.kecamatan","left");
        $this->db->where("kl_pasien.noPasien",$idPasien);
        $this->db->group_by("kl_pasien.noPasien");
        return $this->db->get()->row();
	}
	
	function insertCardStockOne($dataKartuStok){
		$this->db->insert("kartu_stok",$dataKartuStok);
	}

	function asuransiAktif(){
		$this->db->select(array("kl_asuransi.idAsuransi","kl_asuransi.namaAsuransi"));
		$this->db->from("kl_asuransi");
		$this->db->where("status",1);
		$this->db->where("isDelete",1);
		$this->db->order_by("kl_asuransi.namaAsuransi","asc");
		return $this->db->get()->result();
	}

	function tampilkanAsalRujukan(){
		$this->db->select(array("kl_asalrujukan.id","kl_asalrujukan.asalRujukan","kl_jenisasalrujukan.jenisRujukan","kl_asalrujukan.keterangan"));
		$this->db->from("kl_asalrujukan");
		$this->db->join("kl_jenisasalrujukan","kl_jenisasalrujukan.idJenis = kl_asalrujukan.idJenis");
		$this->db->order_by("kl_asalrujukan.id","desc");
		return $this->db->get()->result();
	}

	function viewJenisAsalRujukan(){
		$this->db->select("*");
		$this->db->from("kl_jenisasalrujukan");
		return $this->db->get()->result();
	}

	function simpanAsalRujukan($dataArray){
		$this->db->insert("kl_asalrujukan",$dataArray);
	}

	function editAsalRujukan($dataArray,$id){
		$this->db->where("id",$id);
		$this->db->update("kl_asalrujukan",$dataArray);
	} 

	function hapusAsalRujukan($id){
		$this->db->delete("kl_asalrujukan",array("id" => $id));
	}

	function tambahPOSRanap($pos){
		$arrayData = array(
			"pos" => $pos
		);
		$this->db->insert("kl_kategoriruang",$arrayData);
	}

	function updatePOSRanap($dataUpdate,$id){
		$this->db->where("idPos",$id);
		$this->db->update("kl_kategoriruang",$dataUpdate);
	}

	function deletePOSRanap($id){
		$this->db->delete("kl_kategoriruang",array("idPos" => $id));
	}

	function tambahKelasRanap($kelas){
		$dataArray = array(
			"kelasruang" => $kelas
		);

		$this->db->insert("kl_kelasruang",$dataArray);
	}

	function updateKelasRanap($dataUpdate,$id){
		$this->db->where("idKelas",$id);
		$this->db->update("kl_kelasruang",$dataUpdate);
	}

	function deleteKelasRanap($id){
		$this->db->delete("kl_kelasruang",array("idKelas" => $id));
	}

	function insertRuang($dataArray){
		$this->db->insert("kl_ruanggroup",$dataArray);
		return $this->db->insert_id();
	}

	function updateRuangInap($dataArray,$id){
		$this->db->where("kodeGroup",$id);
		$this->db->update("kl_ruanggroup",$dataArray);
	}

	function viewRuangInap(){
		$this->db->select(
			array(
				"kl_ruanggroup.kodeGroup",
				"kl_ruanggroup.namaGroup",
				"kl_kategoriruang.pos",
				"kl_kelasruang.kelasruang",
				"kl_ruanggroup.kapasitas",
				"kl_ruanggroup.tarif",
				"COUNT(kl_ruangan.namaRuang) as jumlahRuang"
			)
		);

		$this->db->from("kl_ruanggroup");
		$this->db->join("kl_kategoriruang","kl_kategoriruang.idPos = kl_ruanggroup.idKategori","left");
		$this->db->join("kl_kelasruang","kl_kelasruang.idKelas = kl_ruanggroup.idKelas","left");
		$this->db->join("kl_ruangan","kl_ruangan.kodeGroup = kl_ruanggroup.kodeGroup");
		$this->db->group_by("kl_ruanggroup.kodeGroup");
		$this->db->order_by("kl_kategoriruang.pos","ASC");
		$this->db->order_by("kl_kelasruang.kelasruang","ASC");
		return $this->db->get()->result();
	}

	function hapusRuangan($id){
		$this->db->delete("kl_ruanggroup",array("kodeGroup" => $id));
	}

	function ruangGroupRow($id){
		$this->db->select(
			array(
				"kl_ruanggroup.kodeGroup",
				"kl_ruanggroup.namaGroup",
				"kl_kategoriruang.pos",
				"kl_kelasruang.kelasruang",
				"kl_ruanggroup.kapasitas",
				"kl_ruanggroup.tarif"
			)
		);

		$this->db->from("kl_ruanggroup");
		$this->db->join("kl_kategoriruang","kl_kategoriruang.idPos = kl_ruanggroup.idKategori","left");
		$this->db->join("kl_kelasruang","kl_kelasruang.idKelas = kl_ruanggroup.idKelas","left");
		$this->db->where("kl_ruanggroup.kodeGroup",$id);
		$this->db->group_by("kl_ruanggroup.kodeGroup");
		return $this->db->get()->row();
	}

	function insertNamaRuang($id,$banyakRuang,$namaRuang){
		for($i=1;$i<=$banyakRuang;$i++){
			$dataArray[] = array(
				"kodeGroup" => $id,
				"namaRuang" => $namaRuang." "."(".$i.")",
				"status" => 1
			);
		}

		$this->db->insert_batch("kl_ruangan",$dataArray);
	}

	function updateBatchRuang($dataUpdate){
		$this->db->update_batch("kl_ruangan",$dataUpdate,"kodeRuang");
	}

	function daftarRuangGroup($id){
		$this->db->select("*");
		$this->db->from("kl_ruangan");
		$this->db->where("kodeGroup",$id);
		return $this->db->get()->result();
	}

	function dokterSelect2($q){
		$this->db->select(array(
			"kl_dokter.id_dokter","kl_dokter.nama"
		));

		$this->db->from("kl_dokter");

		if(!empty($q)){
			$this->db->like("kl_dokter.nama",$q);
		}

		$this->db->where("status",1);
		$this->db->where("isDelete",1);
		return $this->db->get();
	}

	function tampilkanPosRanap(){
		$this->db->select(
			array(
				"kl_kategoriruang.idPos",
				"kl_kategoriruang.pos",
			)
		);
		$this->db->from("kl_kategoriruang");
		//$this->db->join("kl_ruanggroup","kl_ruanggroup.idKategori = kl_kategoriruang.idPos");
		$this->db->group_by("kl_kategoriruang.idPos");
		$this->db->order_by("pos","ASC");
		return $this->db->get()->result();
	}

	function viewRegistRajal($search,$tanggal){
		$this->db->select("*");
		$this->db->from("viewpasienregist");
		$this->db->where("asalDaftar",'RAJAL');
		
		if(empty($search)){
			$this->db->where("DATE(tanggalDaftar)",$tanggal);
		} else {
			$this->db->like("noPendaftaran",$search);
            $this->db->or_like("idPasien",$search);
            $this->db->or_like("namaLengkap",$search);
		}

		$this->db->order_by("tanggalDaftar","desc");
		return $this->db->get();
	}

	function jenisKunjungan($noPasien){
		$this->db->from("kl_daftar");
		$this->db->where("idPasien",$noPasien);
		$count = $this->db->count_all_results();

		if($count <= 1){
			return "Baru";
		} else {
			return "Lama";
		}
	}

	function viewRegistIGD($search){
		$today = date('Y-m-d');

		$this->db->select("*");
		$this->db->from("viewpasienregist");
		
		if(empty($search)){
			$today = date("Y-m-d");
			$this->db->where("DATE(tanggalDaftar)",$today);
		} else {
			$this->db->like("noPendaftaran",$search);
            $this->db->or_like("idPasien",$search);
            $this->db->or_like("namaLengkap",$search);
		}

		$this->db->where("asalDaftar","IGD");
		$this->db->order_by("tanggalDaftar","DESC");
		return $this->db->get();
	}

	function cekPendaftaranIGD($today){
		$this->db->from("kl_daftar");
		$this->db->where("asalDaftar","IGD");
		$this->db->where("DATE(tanggalDaftar)",$today);
		return $this->db->count_all_results();
	}

	function viewTarif($limit,$start,$search,$tableName){
		$this->db->select("*");
		$this->db->from($tableName);
		$this->db->join("kl_masterjenis","kl_masterjenis.id = ".$tableName.".jenis","left");
		if(!empty(($search))){
			$this->db->like("namaTarif",$search);
		}

		$this->db->limit($limit,$start);
		$this->db->order_by("kode","DESC");
		return $this->db->get();
	}
	
	function itemCetakBarcode($idUser){
		$this->db->select(array(
			"barcodetemp.idProduk",
			"ap_produk.nama_produk",
			"ap_produk.harga"
		));
		$this->db->from("barcodetemp");
		$this->db->join("ap_produk","ap_produk.id_produk = barcodetemp.idProduk","left");
		$this->db->where("barcodetemp.idUser",$idUser);
		$this->db->order_by("barcodetemp.idProduk","DESC");
		return $this->db->get();
	}

	function viewKategoriLab(){
		$this->db->select("*");
		$this->db->from("kl_tariflabkategori");
		$this->db->order_by("kategori","ASC");
		return $this->db->get()->result();
	}

	function viewStokBatch($limit,$start,$search){
		$this->db->select(array("ap_produk_batch.id_produk","ap_produk_batch.noBatch","ap_produk_batch.qty","ap_kategori.kategori","ap_produk.nama_produk"));
		$this->db->from("ap_produk_batch");
		$this->db->join("ap_produk","ap_produk.id_produk = ap_produk_batch.id_produk","left");
		$this->db->join("ap_kategori","ap_kategori.id_kategori = ap_produk.id_kategori","left");
		if(!empty($search)){
			$this->db->like("ap_produk_batch.id_produk",$search);
			$this->db->or_like("ap_produk.nama_produk",$search);
		}

		$this->db->order_by("ap_produk.nama_produk","DESC");
		$this->db->limit($limit,$start);
		return $this->db->get();
	}
}