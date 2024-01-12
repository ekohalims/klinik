<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class ModelKasir extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	function cariTagihan($query,$cariBerdasarkan){
		$this->db->select(array("kl_daftar.noPendaftaran","kl_pasien.noPasien","kl_pasien.noID","kl_pasien.namaLengkap","kl_pasien.alamat","kl_pasien.noHP","kl_daftar.tanggalDaftar","kl_dokter.nama as namaDokter","kl_poliklinik.poliklinik","kl_daftar.status"));
		$this->db->from("kl_daftar");
		$this->db->join("kl_pasien","kl_pasien.noPasien = kl_daftar.idPasien");
		$this->db->join("kl_dokter","kl_dokter.id_dokter = kl_daftar.idDokter");
		$this->db->join("kl_poliklinik","kl_poliklinik.id_poliklinik = kl_daftar.idPoliklinik");
		$this->db->where("kl_daftar.status > 0");
		$this->db->like($cariBerdasarkan,$query);
		$this->db->group_by("kl_daftar.noPendaftaran");
		$this->db->order_by("kl_daftar.tanggalDaftar","DESC");
		return $this->db->get()->result();
	}

	function viewTindakan($noPendaftaran,$asalDaftar){

		if($asalDaftar=='IGD'){
			$table = "kl_tarifigd";
		} elseif($asalDaftar=='RAJAL'){
			$table = "kl_tarifrajal";
		} elseif($asalDaftar=='RANAP'){
			$table = "kl_tarifranap";
		}

		$this->db->select(array($table.".namaTarif as namaTindakan","kl_tindakanorder.harga","kl_tindakanorder.qty"));
		$this->db->from("kl_tindakanorder");
		$this->db->join($table,$table.".kode = kl_tindakanorder.idTindakan");
		$this->db->where("kl_tindakanorder.noPendaftaran",$noPendaftaran);
		return $this->db->get();
	}

	function viewFarmasi($noPendaftaran){
		$this->db->select(array("ap_produk.nama_produk","kl_resep.jumlah","kl_resep.harga"));
		$this->db->from("kl_resep");
		$this->db->join("ap_produk","ap_produk.id_produk = kl_resep.idObat");
		$this->db->where("kl_resep.noPendaftaran",$noPendaftaran);
		return $this->db->get();
	}

	function viewLaboratorium($noPendaftaran){
		$this->db->select(array("kl_tariflab.namaTarif as namaLab","kl_orderlab.harga"));
		$this->db->from("kl_orderlab");
		$this->db->join("kl_tariflab","kl_tariflab.kode = kl_orderlab.idLab");
		$this->db->where("kl_orderlab.noPendaftaran",$noPendaftaran);
		return $this->db->get();
	}

	function viewRadiologi($noPendaftaran){
		$this->db->select(array("kl_tarifradiologi.namaTarif as namaRadiologi","kl_orderradiologi.harga"));
		$this->db->from("kl_orderradiologi");
		$this->db->join("kl_tarifradiologi","kl_tarifradiologi.kode = kl_orderradiologi.idRadiologi");
		$this->db->where("kl_orderradiologi.noPendaftaran",$noPendaftaran);
		return $this->db->get();
	}

	function viewKamar($noPendaftaran){
		$this->db->select("*");
		$this->db->from("viewtarifkamar");
		$this->db->where("noPendaftaran",$noPendaftaran);
		return $this->db->get()->result();
	}


	function totalTransaksi($noPendaftaran){
		$totalTindakan = $this->totalTindakan($noPendaftaran);
		$totalObat = $this->totalObat($noPendaftaran);
		$totalLab = $this->totalLab($noPendaftaran);
		$totalRad = $this->totalRadiologi($noPendaftaran);
		$totalKamar = $this->totalKamar($noPendaftaran);

		return $totalTindakan+$totalObat+$totalLab+$totalRad+$totalKamar;
	}

	function totalKamar($noPendaftaran){
		$this->db->select("SUM(totalTarif) as total");
		$this->db->from("viewtarifkamar");
		$this->db->where("noPendaftaran",$noPendaftaran);
		$query = $this->db->get()->result();
		foreach($query as $row){
			return $row->total; 
		}
	}

	function totalTindakan($noPendaftaran){
		$this->db->select("SUM(harga*qty) as harga");
		$this->db->from("kl_tindakanorder");
		$this->db->where("noPendaftaran",$noPendaftaran);
		$query = $this->db->get()->result();

		foreach($query as $row){
			return $row->harga;
		}
	}

	function totalObat($noPendaftaran){
		$this->db->select("SUM(jumlah*harga) as total");
		$this->db->from("kl_resep");
		$this->db->where("noPendaftaran",$noPendaftaran);
		$query = $this->db->get()->result();

		foreach($query as $row){
			return $row->total;
		}
	}

	function totalLab($noPendaftaran){
		$this->db->select("SUM(harga) as harga");
		$this->db->from("kl_orderlab");
		$this->db->where("noPendaftaran",$noPendaftaran);
		$query = $this->db->get()->result();

		foreach($query as $row){
			return $row->harga;
		}
	}

	function totalRadiologi($noPendaftaran){
		$this->db->select("SUM(harga) as harga");
		$this->db->from("kl_orderradiologi");
		$this->db->where("noPendaftaran",$noPendaftaran);
		$query = $this->db->get()->result();

		foreach($query as $row){
			return $row->harga;
		}
	}

	function dataOrderPerpendaftaran($noPendaftaran){
		$this->db->select(array("kl_daftar.noPendaftaran","kl_pasien.noPasien","kl_pasien.noID","kl_pasien.namaLengkap","kl_pasien.alamat","kl_pasien.noHP","kl_daftar.tanggalDaftar","kl_dokter.nama as namaDokter","kl_poliklinik.poliklinik","kl_daftar.status","kl_layanan.layanan"));
		$this->db->from("kl_daftar");
		$this->db->join("kl_pasien","kl_pasien.noPasien = kl_daftar.idPasien");
		$this->db->join("kl_dokter","kl_dokter.id_dokter = kl_daftar.idDokter","left");
		$this->db->join("kl_poliklinik","kl_poliklinik.id_poliklinik = kl_daftar.idPoliklinik","left");
		$this->db->join("kl_layanan","kl_layanan.id_layanan = kl_daftar.idLayanan");
		$this->db->where("kl_daftar.noPendaftaran",$noPendaftaran);
		$this->db->group_by("kl_daftar.noPendaftaran");
		return $this->db->get()->row();
	}

	function dataOrderInvoice($noInvoice){
		$this->db->select(array("kl_invoice.noInvoice","kl_daftar.noPendaftaran","kl_pasien.noPasien","kl_pasien.noID","kl_pasien.namaLengkap","kl_pasien.alamat","kl_pasien.noHP","kl_daftar.tanggalDaftar","kl_dokter.nama as namaDokter","kl_poliklinik.poliklinik","kl_daftar.status","kl_layanan.layanan","kl_invoice.tanggalBayar","ap_payment_type.payment_type","coa_sub.namaSubAkun as account","kl_invoice.jumlahBayar","kl_invoice.kembali","kl_invoice.typeBayar"));
		$this->db->from("kl_invoice");
		$this->db->join("kl_daftar","kl_daftar.noPendaftaran = kl_invoice.noPendaftaran");
		$this->db->join("kl_pasien","kl_pasien.noPasien = kl_daftar.idPasien");
		$this->db->join("kl_dokter","kl_dokter.id_dokter = kl_daftar.idDokter","left");
		$this->db->join("kl_poliklinik","kl_poliklinik.id_poliklinik = kl_daftar.idPoliklinik","left");
		$this->db->join("kl_layanan","kl_layanan.id_layanan = kl_daftar.idLayanan","left");
		$this->db->join("ap_payment_type","ap_payment_type.id = kl_invoice.typeBayar","left");
		$this->db->join("coa_sub","coa_sub.kodeSubAkun = kl_invoice.subAccount","left");
		$this->db->where("kl_invoice.noInvoice",$noInvoice);
		$this->db->group_by("kl_daftar.noPendaftaran");
		return $this->db->get()->row();
	}

	function cekInvoice($today){
		$this->db->from("kl_invoice");
		$this->db->where("DATE(tanggalBayar)",$today);
		return $this->db->count_all_results();
	}

	function updateStatusTerbayar($noPendaftaran){
		$dataUpdate = array(
			"status" => 2
		);

		$this->db->where("noPendaftaran",$noPendaftaran);
		$this->db->update("kl_daftar",$dataUpdate);
	}

	function viewDataPembayaran($filter){
		$this->db->select(array("kl_daftar.noPendaftaran","kl_daftar.tanggalDaftar","kl_pasien.namaLengkap as namaPasien","kl_pasien.jenisKelamin","kl_pasien.tanggalLahir","kl_dokter.nama as namaDokter","kl_poliklinik.poliklinik"));
		$this->db->from("kl_daftar");
		$this->db->join("kl_pasien","kl_pasien.noPasien = kl_daftar.idPasien","left");
		$this->db->join("kl_dokter","kl_dokter.id_dokter = kl_daftar.idDokter","left");
		$this->db->join("kl_poliklinik","kl_poliklinik.id_poliklinik = kl_daftar.idPoliklinik","left");
		$this->db->where("kl_daftar.status",1);

		if(!empty($filter)){
			$this->db->where("kl_daftar.asalDaftar",$filter);
		}

		return $this->db->get();
	}

	function insertDataPiutang($dataPiutang){
		$this->db->insert("kl_piutang",$dataPiutang);
	}

	function totalPiutangBelumLunas(){
		$this->db->from("kl_piutang");
		$this->db->where("status",0);
		$this->db->or_where("status",1);
		return $this->db->count_all_results();
	}

	function totalInvoiceSelesai(){
		$this->db->from("kl_invoice");
		return $this->db->count_all_results();
	}

	function viewPiutangDatatable($limit,$start,$search){
		$this->db->select(array("kl_piutang.noPendaftaran","kl_daftar.idPasien","kl_pasien.namaLengkap as namaPasien","kl_daftar.tanggalDaftar","kl_piutang.jatuhTempo","kl_invoice.grandTotal"));
		$this->db->from("kl_piutang");
		$this->db->join("kl_daftar","kl_daftar.noPendaftaran = kl_piutang.noPendaftaran");
		$this->db->join("kl_pasien","kl_pasien.noPasien = kl_daftar.idPasien");
		$this->db->join("kl_invoice","kl_invoice.noPendaftaran = kl_piutang.noPendaftaran");
		$this->db->where("kl_piutang.status != 2");
		$this->db->where("kl_daftar.idLayanan",1);

		if(!empty($search)){
			$this->db->like("kl_piutang.noPendaftaran",$search);
			$this->db->or_like("kl_daftar.idPasien",$search);
		}

		$this->db->limit($limit,$start);
		$this->db->group_by("kl_piutang.noPendaftaran");
		return $this->db->get();
	}

	function viewInvoiceDatatable($limit,$start,$search){
		$this->db->select(
			array(
				"kl_invoice.noInvoice",
				"kl_daftar.idPasien",
				"kl_pasien.namaLengkap",
				"kl_daftar.tanggalDaftar",
				"kl_poliklinik.poliklinik",
				"kl_dokter.nama as namaDokter",
				"kl_layanan.layanan",
				"kl_asuransi.namaAsuransi"
			)
		);

		$this->db->from("kl_invoice");
		$this->db->join("kl_daftar","kl_daftar.noPendaftaran = kl_invoice.noPendaftaran");
		$this->db->join("kl_pasien","kl_pasien.noPasien = kl_daftar.idPasien");
		$this->db->join("kl_poliklinik","kl_poliklinik.id_poliklinik = kl_daftar.idPoliklinik","left");
		$this->db->join("kl_dokter","kl_dokter.id_dokter = kl_daftar.idDokter","left");
		$this->db->join("kl_layanan","kl_layanan.id_layanan = kl_daftar.idLayanan","left");
		$this->db->join("kl_asuransi","kl_asuransi.idAsuransi = kl_daftar.asuransi","left");

		if(!empty($search)){
			$this->db->like("kl_invoice.noInvoice",$search);
			$this->db->or_like("kl_pasien.namaLengkap",$search);
			$this->db->or_like("kl_pasien.noPasien",$search);
		}

		$this->db->limit($limit,$start);
		$this->db->order_by("kl_daftar.tanggalDaftar","ASC");
		$this->db->group_by("kl_invoice.noInvoice");
		return $this->db->get();

	}


	function cekPembayaranPerbulan(){
		$bulan = date('m');
		$tahun = date('Y');

		$this->db->from("kl_piutang_pembayaran");
		$this->db->where("MONTH(tanggalBayar)",$bulan);
		$this->db->where("YEAR(tanggalBayar)",$tahun);
		return $this->db->count_all_results();
	}

	function prosesPembayaranPiutang($dataArray){
		$this->db->insert("kl_piutang_pembayaran",$dataArray);
	}

	function headerPenjualan($query,$searchBy){
        $this->db->select(array("kl_piutang.status","kl_pasien.noID","kl_invoice.noPendaftaran","kl_pasien.noPasien","kl_pasien.namaLengkap","kl_pasien.tempatLahir","kl_pasien.tanggalLahir","kl_poliklinik.poliklinik","kl_dokter.nama as namaDokter"));
        $this->db->from("kl_invoice");
        $this->db->join("kl_daftar","kl_daftar.noPendaftaran = kl_invoice.noPendaftaran");
        $this->db->join("kl_pasien","kl_pasien.noPasien = kl_daftar.idPasien");
        $this->db->join("kl_poliklinik","kl_poliklinik.id_poliklinik = kl_daftar.idPoliklinik");
		$this->db->join("kl_dokter","kl_dokter.id_dokter = kl_daftar.idDokter");
		$this->db->join("kl_piutang","kl_piutang.noPendaftaran = kl_invoice.noPendaftaran");
		$this->db->where("kl_invoice.typeBayar",5);
        $this->db->like($searchBy,$query);
        $this->db->group_by("kl_invoice.noPendaftaran");
        return $this->db->get();
	}

	function ubahStatusPiutang($noPendaftaran,$status){
		$dataUpdate = array(
			"status" => $status
		);

		$this->db->where("noPendaftaran",$noPendaftaran);
		$this->db->update("kl_piutang",$dataUpdate);
	}

	function pemasukanPerkasir($tanggal){
		$this->db->select(array("users.first_name","users.last_name","users.id"));
		$this->db->from("users");
		$this->db->where("active",1);
		$this->db->like("menu",7);
		return $this->db->get()->result();
	}

	function pembayaranCardPerkasirPertipeBayar($tanggal,$idKasir,$tipeBayar,$subAccount){
		$totalPembayaranPiutang = $this->pembayaranPiutangPertipeBayarPerkartu($tanggal,$idKasir,$tipeBayar,$subAccount);

		$this->db->select("SUM(grandTotal) as total");
		$this->db->from("kl_invoice");
		$this->db->where("DATE(kl_invoice.tanggalBayar)",$tanggal);
		$this->db->where("kl_invoice.idUser",$idKasir);
		$this->db->where("kl_invoice.typeBayar",$tipeBayar);
		$this->db->where("kl_invoice.subAccount",$subAccount);
		$query = $this->db->get()->result();
		foreach($query as $row){
			return $row->total+$totalPembayaranPiutang;
		}
	}

	function pembayaranPiutangPertipeBayarPerkartu($tanggal,$idKasir,$tipeBayar,$subAccount){
		$this->db->select("SUM(nilaiBayar) as total");
		$this->db->from("kl_piutang_pembayaran");
		$this->db->where("DATE(kl_piutang_pembayaran.tanggalBayar)",$tanggal);
		$this->db->where("kl_piutang_pembayaran.idUser",$idKasir);
		$this->db->where("kl_piutang_pembayaran.typeBayar",$tipeBayar);
		$this->db->where("kl_piutang_pembayaran.subAccount",$subAccount);
		$query = $this->db->get()->result();
		foreach($query as $row){
			return $row->total;
		}
	}

	function pendapatanPerkasirPertipeBayar($tanggal,$idKasir,$tipeBayar){
		$totalPembayaranPiutang = $this->pembayaranPiutangPertipeBayar($tanggal,$idKasir,$tipeBayar);

		$this->db->select("SUM(grandTotal) as total");
		$this->db->from("kl_invoice");
		$this->db->where("DATE(kl_invoice.tanggalBayar)",$tanggal);
		$this->db->where("kl_invoice.idUser",$idKasir);
		$this->db->where("kl_invoice.typeBayar",$tipeBayar);
		$query = $this->db->get()->result();
		foreach($query as $row){
			return $row->total+$totalPembayaranPiutang;
		}
	}

	function pembayaranPiutangPertipeBayar($tanggal,$idKasir,$tipeBayar){
		$this->db->select("SUM(nilaiBayar) as total");
		$this->db->from("kl_piutang_pembayaran");
		$this->db->where("DATE(kl_piutang_pembayaran.tanggalBayar)",$tanggal);
		$this->db->where("kl_piutang_pembayaran.idUser",$idKasir);
		$this->db->where("kl_piutang_pembayaran.typeBayar",$tipeBayar);
		$query = $this->db->get()->result();
		foreach($query as $row){
			return $row->total;
		}
	}

	function statusClosing($tanggal,$idKasir){
		$this->db->from("closing_header");
		$this->db->where("DATE(tanggalTrx)",$tanggal);
		$this->db->where("idKasir",$idKasir);
		return $this->db->count_all_results();
	}

	function noClosing($today){
		$this->db->from("closing_header");
		$this->db->where("DATE(tanggalClosing)",$today);
		return $this->db->count_all_results();
	}

	function insertHeaderClosing($dataHeader){
		$this->db->insert("closing_header",$dataHeader);
		return $this->db->affected_rows();
	}

	function insertClosingValue($noClosing,$typeBayar,$subAccount,$value){
		$dataArray = array(
			"noClosing" => $noClosing,
			"typeBayar" => $typeBayar,
			"subAccount" => $subAccount,
			"nilaiClosing" => $value
		);

		$this->db->insert("closing_value",$dataArray);
	}

	function cekClosingIfExist($idKasir,$tanggal){
		$this->db->from("closing_header");
		$this->db->where("tanggalTrx",$tanggal);
		$this->db->where("idKasir",$idKasir);
		return $this->db->count_all_results();
	}

	function headerClosing($noClosing){
		$this->db->select(array("closing_header.noClosing","users.first_name","users.last_name","closing_header.tanggalClosing"));
		$this->db->from("closing_header");
		$this->db->join("users","users.id = closing_header.idUser");
		$this->db->where("closing_header.noClosing",$noClosing);
		$query = $this->db->get()->row();
		return $query;
	}

	function pendapatanActual($noClosing,$typeBayar,$subAccount){
		$this->db->select("nilaiClosing");
		$this->db->from("closing_value");
		$this->db->where("noClosing",$noClosing);
		$this->db->where("typeBayar",$typeBayar);
		if(!empty($subAccount)){
			$this->db->where("subAccount",$subAccount);
		}

		$query = $this->db->get()->result();
		foreach($query as $row){
			return $row->nilaiClosing;
		}
	}

	function hapusClosing($noClosing){
		$this->db->delete("closing_header",array("noClosing" => $noClosing));
		$this->db->delete("closing_value",array("noClosing" => $noClosing));
	}

	function getBankBayar($idPayment){
		$this->db->select(array("bank.kodeBank","coa_sub.namaSubAkun as bank"));
		$this->db->from("bank");
		$this->db->join("coa_sub","coa_sub.kodeSubAkun = bank.kodeBank");

		if($idPayment==2){
			$this->db->where("bank.debit",1);
		}

		if($idPayment==3){
			$this->db->where("bank.kredit",1);
		}

		if($idPayment==4){
			$this->db->where("bank.transfer",1);
		}

		$this->db->where("coa_sub.status",1);
		$this->db->where("coa_sub.isDelete",1);
		return $this->db->get()->result();
	}

	function dataBank($type){
		$this->db->select(array("coa_sub.namaSubAkun as account","bank.kodeBank as id_payment_account"));
		$this->db->from("bank");
		$this->db->join("coa_sub","coa_sub.kodeSubAkun = bank.kodeBank");

		if($type=='debit'){
			$this->db->where("bank.debit",1);
		}

		if($type=='kredit'){
			$this->db->where("bank.kredit",1);
		}

		return $this->db->get()->result();
	}

	function totalDiskon($noPendaftaran){
		$this->db->select("SUM(selisih) as total");
		$this->db->from("kl_tindakanorder");
		$this->db->where("noPendaftaran",$noPendaftaran);
		$query = $this->db->get()->result();
		foreach($query as $row){
			return $row->total; 
		}
	}
}
