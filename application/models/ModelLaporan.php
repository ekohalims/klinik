<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class ModelLaporan extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	function viewReportPendapatan($dateStart,$dateEnd,$poli,$dokter,$pasien,$typeBayar,$subAccount,$jenis){
		$this->db->select(array("kl_invoice.noInvoice","kl_invoice.noPendaftaran","kl_invoice.tanggalBayar","kl_pasien.namaLengkap","ap_payment_type.payment_type","coa_sub.namaSubAkun as account","kl_invoice.diskon","kl_invoice.grandTotal"));
		$this->db->from("kl_invoice");
		$this->db->join("ap_payment_type","ap_payment_type.id = kl_invoice.typeBayar","left");
		$this->db->join("coa_sub","coa_sub.kodeSubAkun = kl_invoice.subAccount","left");
		$this->db->join("kl_daftar","kl_daftar.noPendaftaran = kl_invoice.noPendaftaran");		
		$this->db->join("kl_pasien","kl_pasien.noPasien = kl_daftar.idPasien");

		if(!empty($dateStart) && !empty($dateEnd)){
			$this->db->where("DATE(kl_invoice.tanggalBayar) BETWEEN '$dateStart' AND '$dateEnd'");
		}

		if(!empty($poli)){
			$this->db->where("kl_daftar.idPoliklinik",$poli);
		}

		if(!empty($dokter)){
			$this->db->where("kl_daftar.idDokter",$dokter);
		}

		if(!empty($pasien)){
			$this->db->where("kl_daftar.idPasien",$pasien);
		}

		if(!empty($typeBayar)){
			$this->db->where("kl_invoice.typeBayar",$typeBayar);
		}

		if(!empty($subAccount)){
			$this->db->where("kl_invoice.subAccount",$subAccount);
		}

		if(!empty($jenis)){
			$this->db->where("kl_daftar.asalDaftar",$jenis);
		}

		return $this->db->get();
	}

	function viewRekamMedis($dateStart,$dateEnd,$poli,$dokter,$pasien,$diagnosa,$jenis){
		$this->db->select(array("kl_daftar.noPendaftaran","kl_pasien.noPasien","kl_pasien.namaLengkap","kl_pasien.alamat","kl_daftar.tanggalDaftar","kl_dokter.nama as namaDokter","kl_poliklinik.poliklinik","kl_daftar.status","kl_pasien.jenisKelamin"));
		$this->db->from("kl_daftar");
		$this->db->join("kl_pasien","kl_pasien.noPasien = kl_daftar.idPasien");
		$this->db->join("kl_dokter","kl_dokter.id_dokter = kl_daftar.idDokter");
		$this->db->join("kl_poliklinik","kl_poliklinik.id_poliklinik = kl_daftar.idPoliklinik");
		$this->db->join("kl_diagnosa","kl_diagnosa.noPendaftaran = kl_daftar.noPendaftaran");
		$this->db->where("kl_daftar.status > 0");

		if(!empty($dateStart) && !empty($dateEnd)){
			$this->db->where("DATE(kl_daftar.tanggalDaftar) BETWEEN '$dateStart' AND '$dateEnd'");
		}

		if(!empty($poli)){
			$this->db->where("kl_daftar.idPoliklinik",$poli);
		}

		if(!empty($dokter)){
			$this->db->where("kl_daftar.idDokter",$dokter);
		}

		if(!empty($pasien)){
			$this->db->where("kl_daftar.idPasien",$pasien);
		}

		if(!empty($diagnosa)){
			$this->db->where("kl_diagnosa.idDiagnosa",$diagnosa);
		}

		if(!empty($jenis)){
			$this->db->where("kl_daftar.asalDaftar",$jenis);
		}

		$this->db->group_by("kl_daftar.noPendaftaran");
		$this->db->order_by("kl_daftar.tanggalDaftar","DESC");
		return $this->db->get()->result();
	}

	function viewDiagnosa($noPendaftaran){
		$this->db->select(array("kl_icd.STR as diagnosa","kl_icd.CODE","kl_diagnosa.keterangan"));
		$this->db->from("kl_diagnosa");
		$this->db->join("kl_icd","kl_icd.id = kl_diagnosa.idDiagnosa",$noPendaftaran);
		$this->db->where("kl_diagnosa.noPendaftaran",$noPendaftaran);
		return $this->db->get();
	}

	function viewCatatan($noPendaftaran){
		$this->db->select("catatan");
		$this->db->from("kl_catatan");
		$this->db->where("noPendaftaran",$noPendaftaran);
		return $this->db->get();
	}

	function viewTindakLanjut($noPendaftaran){
		$this->db->select(array("kl_tindaklanjut.namaTindakLanjut","kl_tindaklanjutpasien.keterangan"));
		$this->db->from("kl_tindaklanjutpasien");
		$this->db->join("kl_tindaklanjut","kl_tindaklanjut.idTindakLanjut = kl_tindaklanjutpasien.idTindakLanjut");
		$this->db->where("kl_tindaklanjutpasien.noPendaftaran",$noPendaftaran);
		return $this->db->get();
	}

	function viewLaporanKunjungan($dateStart,$dateEnd,$poli,$dokter,$pasien,$diagnosa){
		$this->db->select(array("kl_daftar.noPendaftaran","kl_pasien.noPasien","kl_pasien.namaLengkap","kl_pasien.alamat","kl_daftar.tanggalDaftar","kl_dokter.nama as namaDokter","kl_poliklinik.poliklinik","kl_daftar.status","kl_pasien.jenisKelamin"));
		$this->db->from("kl_daftar");
		$this->db->join("kl_pasien","kl_pasien.noPasien = kl_daftar.idPasien");
		$this->db->join("kl_dokter","kl_dokter.id_dokter = kl_daftar.idDokter");
		$this->db->join("kl_poliklinik","kl_poliklinik.id_poliklinik = kl_daftar.idPoliklinik");
		$this->db->join("kl_diagnosa","kl_diagnosa.noPendaftaran = kl_daftar.noPendaftaran");
		$this->db->where("kl_daftar.status > 0");

		if(!empty($dateStart) && !empty($dateEnd)){
			$this->db->where("DATE(kl_daftar.tanggalDaftar) BETWEEN '$dateStart' AND '$dateEnd'");
		}

		if(!empty($poli)){
			$this->db->where("kl_daftar.idPoliklinik",$poli);
		}

		if(!empty($dokter)){
			$this->db->where("kl_daftar.idDokter",$dokter);
		}

		if(!empty($pasien)){
			$this->db->where("kl_daftar.idPasien",$pasien);
		}

		if(!empty($diagnosa)){
			$this->db->where("kl_diagnosa.idDiagnosa",$diagnosa);
		}

		$this->db->group_by("kl_daftar.noPendaftaran");
		$this->db->order_by("kl_daftar.tanggalDaftar","DESC");
		return $this->db->get();
	}

	function viewKomisiDokter($dateStart,$dateEnd,$dokter,$jenis){
		if($jenis=='RAJAL'){
			$table = "kl_tarifrajal";
		} else {
			$table = "kl_tarifranap";
		}

		$this->db->select(array($table.".namaTarif as namaTindakan","kl_tindakanorder.idTindakan"));
		$this->db->from("kl_tindakanorder");
		$this->db->join($table,$table.".kode = kl_tindakanorder.idTindakan");
		$this->db->join("kl_daftar","kl_daftar.noPendaftaran = kl_tindakanorder.noPendaftaran");

		if(!empty($dateStart) && !empty($dateEnd)){
			$this->db->where("DATE(kl_daftar.tanggalDaftar) BETWEEN '$dateStart' AND '$dateEnd'");
		}

		if(!empty($dokter)){
			$this->db->where("kl_daftar.idDokter",$dokter);
		}

		$this->db->group_by("kl_tindakanorder.idTindakan");
		return $this->db->get();
	}

	function dataKomisi($dateStart,$dateEnd,$dokter,$jenis,$idTindakan){
		if($jenis=='RAJAL'){
			$table = "kl_tarifrajal";
		} else {
			$table = "kl_tarifranap";
		}

		$this->db->select(array("kl_pasien.noPasien","kl_tindakanorder.noPendaftaran","kl_daftar.tanggalDaftar","kl_pasien.namaLengkap as namaPasien","kl_dokter.nama as namaDokter","kl_tindakanorder.komisi"));
		$this->db->from("kl_tindakanorder");
		$this->db->join($table,$table.".kode = kl_tindakanorder.idTindakan");
		$this->db->join("kl_daftar","kl_daftar.noPendaftaran = kl_tindakanorder.noPendaftaran");
		$this->db->join("kl_pasien","kl_pasien.noPasien = kl_daftar.idPasien");
		$this->db->join("kl_dokter","kl_dokter.id_dokter = kl_daftar.idDokter");

		if(!empty($dateStart) && !empty($dateEnd)){
			$this->db->where("DATE(kl_daftar.tanggalDaftar) BETWEEN '$dateStart' AND '$dateEnd'");
		}

		if(!empty($dokter)){
			$this->db->where("kl_daftar.idDokter",$dokter);
		}

		$this->db->where("kl_tindakanorder.idTindakan",$idTindakan);
		return $this->db->get();
	}

	function viewReportPengeluaranObatAkumulasi($dateStart,$dateEnd,$poli,$dokter,$pasien){
		$this->db->select(array("ap_produk.id_produk","ap_produk.nama_produk","kl_resep.harga","SUM(kl_resep.jumlah) as jumlah","ap_produk.satuan"));
		$this->db->from("kl_resep");
		$this->db->join("ap_produk","ap_produk.id_produk = kl_resep.idObat");
		$this->db->join("kl_resepheader","kl_resepheader.noPendaftaran = kl_resep.noPendaftaran");
		$this->db->join("kl_daftar","kl_daftar.noPendaftaran = kl_resep.noPendaftaran");
		$this->db->where("kl_resepheader.status",2);

		if(!empty($dateStart) && !empty($dateEnd)){
			$this->db->where("DATE(kl_resepheader.tanggal) BETWEEN '$dateStart' AND '$dateEnd'");
		}

		if(!empty($poli)){
			$this->db->where("kl_daftar.idPoliklinik",$poli);
		}

		if(!empty($dokter)){
			$this->db->where("kl_daftar.idDokter",$dokter);
		}

		if(!empty($pasien)){
			$this->db->where("kl_daftar.idPasien",$pasien);
		}

		$this->db->group_by(array("kl_resep.idObat","kl_resep.harga"));
		return $this->db->get();
	}

	function headerResep($dateStart,$dateEnd,$poli,$dokter,$pasien){
		$this->db->select(array("kl_resepheader.noPendaftaran","kl_resepheader.tanggal","kl_poliklinik.poliklinik","kl_dokter.nama as namaDokter","kl_pasien.namaLengkap as namaPasien"));
		$this->db->from("kl_resepheader");
		$this->db->join("kl_daftar","kl_daftar.noPendaftaran = kl_resepheader.noPendaftaran");
		$this->db->join("kl_poliklinik","kl_poliklinik.id_poliklinik = kl_daftar.idPoliklinik");
		$this->db->join("kl_dokter","kl_dokter.id_dokter = kl_daftar.idDokter");
		$this->db->join("kl_pasien","kl_pasien.noPasien = kl_daftar.idPasien");

		if(!empty($dateStart) && !empty($dateEnd)){
			$this->db->where("DATE(kl_resepheader.tanggal) BETWEEN '$dateStart' AND '$dateEnd'");
		}

		if(!empty($poli)){
			$this->db->where("kl_daftar.idPoliklinik",$poli);
		}

		if(!empty($dokter)){
			$this->db->where("kl_daftar.idDokter",$dokter);
		}

		if(!empty($pasien)){
			$this->db->where("kl_daftar.idPasien",$pasien);
		}

		$this->db->where("kl_resepheader.status",2);
		$this->db->group_by("kl_resepheader.noPendaftaran");

		return $this->db->get();
	}

	function daftarObatPerinvoice($noPendaftaran){
		$this->db->select(array("ap_produk.id_produk","ap_produk.nama_produk","kl_resep.harga","kl_resep.jumlah","ap_produk.satuan"));
		$this->db->from("kl_resep");
		$this->db->join("ap_produk","ap_produk.id_produk = kl_resep.idObat");
		$this->db->where("kl_resep.noPendaftaran",$noPendaftaran);
		return $this->db->get();
	}

	function viewLaporanLab($dateStart,$dateEnd,$dokter,$pasien,$itemLab){
		$this->db->select(array("kl_orderlabheader.noPendaftaran","kl_orderlabheader.tanggal","kl_pasien.namaLengkap as namaPasien","kl_poliklinik.poliklinik","kl_dokter.nama as namaDokter"));
		$this->db->from("kl_orderlabheader");
		$this->db->join("kl_orderlab","kl_orderlab.noPendaftaran = kl_orderlabheader.noPendaftaran");
		$this->db->join("kl_daftar","kl_daftar.noPendaftaran = kl_orderlabheader.noPendaftaran");
		$this->db->join("kl_poliklinik","kl_poliklinik.id_poliklinik = kl_daftar.idPoliklinik");
		$this->db->join("kl_dokter","kl_dokter.id_dokter = kl_daftar.idDokter");
		$this->db->join("kl_pasien","kl_pasien.noPasien = kl_daftar.idPasien");

		if(!empty($dateStart) && !empty($dateEnd)){
			$this->db->where("DATE(kl_orderlabheader.tanggal) BETWEEN '$dateStart' AND '$dateEnd'");
		}

		if(!empty($dokter)){
			$this->db->where("kl_daftar.idDokter",$dokter);
		}

		if(!empty($pasien)){
			$this->db->where("kl_daftar.idPasien",$pasien);
		}

		if(!empty($itemLab)){
			$this->db->where("kl_orderlab.idLab",$itemLab);
		}

		$this->db->where("kl_orderlabheader.status",2);

		$this->db->group_by("kl_orderlabheader.noPendaftaran");
		return $this->db->get();
	}

	function itemLabResult($noPendaftaran){
		$this->db->select(array("kl_orderlab.harga","kl_orderlab.hasil","kl_labitem.namaLab"));
		$this->db->from("kl_orderlab");
		$this->db->join("kl_labitem","kl_labitem.id = kl_orderlab.idLab");
		$this->db->where("kl_orderlab.noPendaftaran",$noPendaftaran);
		return $this->db->get()->result();
	}

	function viewLaporanRadiologi($dateStart,$dateEnd,$dokter,$pasien,$itemRadiologi){
		$this->db->select(array("kl_orderradiologiheader.noPendaftaran","kl_orderradiologiheader.tanggal","kl_pasien.namaLengkap as namaPasien","kl_poliklinik.poliklinik","kl_dokter.nama as namaDokter"));
		$this->db->from("kl_orderradiologiheader");
		$this->db->join("kl_orderradiologi","kl_orderradiologi.noPendaftaran = kl_orderradiologiheader.noPendaftaran");
		$this->db->join("kl_daftar","kl_daftar.noPendaftaran = kl_orderradiologiheader.noPendaftaran");
		$this->db->join("kl_poliklinik","kl_poliklinik.id_poliklinik = kl_daftar.idPoliklinik");
		$this->db->join("kl_dokter","kl_dokter.id_dokter = kl_daftar.idDokter");
		$this->db->join("kl_pasien","kl_pasien.noPasien = kl_daftar.idPasien");

		if(!empty($dateStart) && !empty($dateEnd)){
			$this->db->where("DATE(kl_orderradiologiheader.tanggal) BETWEEN '$dateStart' AND '$dateEnd'");
		}

		if(!empty($dokter)){
			$this->db->where("kl_daftar.idDokter",$dokter);
		}

		if(!empty($pasien)){
			$this->db->where("kl_daftar.idPasien",$pasien);
		}

		if(!empty($itemLab)){
			$this->db->where("kl_orderlab.idLab",$itemLab);
		}

		$this->db->where("kl_orderradiologiheader.status",2);

		$this->db->group_by("kl_orderradiologiheader.noPendaftaran");
		return $this->db->get();
	}

	function itemRadiologiResult($noPendaftaran){
		$this->db->select(array("kl_orderradiologi.harga","kl_orderradiologi.hasil","kl_radiologiitem.namaRadiologi"));
		$this->db->from("kl_orderradiologi");
		$this->db->join("kl_radiologiitem","kl_radiologiitem.id = kl_orderradiologi.idRadiologi");
		$this->db->where("kl_orderradiologi.noPendaftaran",$noPendaftaran);
		return $this->db->get()->result();
	}

	function viewReportPurchaseOrder($dateStart,$dateEnd,$supplier,$status){
		$dataSelect = array(
			"purchase_order.no_po","purchase_order.tanggal_po","purchase_order.tanggal_kirim","supplier.supplier","users.first_name","purchase_order.status","purchase_order.keterangan"
		);

		$this->db->select($dataSelect);
		$this->db->from("purchase_order");
		$this->db->join("supplier","supplier.id_supplier = purchase_order.id_supplier");
		$this->db->join("users","users.id = purchase_order.id_pic","left");

		if(!empty($dateStart) && !empty($dateEnd)){
			$this->db->where("purchase_order.tanggal_po BETWEEN '$dateStart' AND '$dateEnd'");
		}

		if(!empty($supplier)){
			$this->db->where("purchase_order.id_supplier",$supplier);	
		}

		if(!empty($status)){
			$this->db->where("purchase_order.status",$status);
		}

		$this->db->order_by("purchase_order.tanggal_po","DESC");
		$this->db->order_by("purchase_order.no_po","DESC");
		$this->db->where('type',0);
		return $this->db->get()->result();
	}

	function purchaseItem($no_po){
		$this->db->select(array("ap_produk.nama_produk","purchase_item.qty","ap_produk.satuan","purchase_item.harga","(purchase_item.harga*purchase_item.qty) as total","ap_produk.id_produk"));
		$this->db->from("purchase_item");
		$this->db->join("ap_produk","ap_produk.id_produk = purchase_item.sku","left");
		$this->db->where("purchase_item.no_po",$no_po);
		return $this->db->get()->result();
	}

	function delivered_qty($no_po,$sku){
		$this->db->select("SUM(qty) as qty");
		$this->db->from("receive_item");
		$this->db->join("receive_order","receive_order.no_receive = receive_item.no_receive","left");
		$this->db->where("receive_order.no_po",$no_po);
		$this->db->where("receive_item.sku",$sku);
		$query = $this->db->get();
		foreach($query->result() as $row){
			return $row->qty;
		}
	}

	function returItem($noPO,$idProduk){
		$this->db->select("SUM(qty) as qty");
		$this->db->from("retur_item");
		$this->db->join("retur","retur.no_retur = retur_item.no_retur");
		$this->db->where("retur.no_po",$noPO);
		$this->db->where("retur_item.sku",$idProduk);
		$this->db->group_by("retur_item.sku");
		$query = $this->db->get()->result();
		foreach($query as $row){
			return $row->qty;
		}
	}

	function hutangTerbayar($noTagihan){
		$this->db->select_sum("pembayaran");
		$this->db->from("hutang_order");
		$this->db->where("no_po",$noTagihan);
		$query = $this->db->get()->row();
		return $query->pembayaran;
	}

	function hutang_ditagih($supplier=''){
		$query = "SELECT supplier.supplier,hutang.no_tagihan,purchase_order.jatuh_tempo,total_hutang,total_retur,purchase_order.tanggal_po, users.first_name, total_terbayar
				  FROM hutang
				  LEFT JOIN purchase_order ON purchase_order.no_po = hutang.no_tagihan
				  LEFT JOIN retur ON retur.no_po = hutang.no_tagihan
				  LEFT JOIN supplier ON supplier.id_supplier = purchase_order.id_supplier
				  LEFT JOIN receive_order ON receive_order.no_po = hutang.no_tagihan
				  LEFT JOIN users ON users.id = purchase_order.id_pic
				  LEFT JOIN (SELECT SUM(receive_item.qty*receive_item.price) as total_hutang,receive_item.no_receive
							 FROM receive_item
							 LEFT JOIN receive_order ON receive_order.no_receive = receive_item.no_receive
							 GROUP BY receive_order.no_po) as receiveItemJoin ON receiveItemJoin.no_receive = receive_order.no_receive
				  LEFT JOIN (SELECT SUM(retur_item.harga*retur_item.qty) as total_retur,retur_item.no_retur
				  			 FROM retur_item
				  			 LEFT JOIN retur ON retur.no_retur = retur_item.no_retur
				  			 GROUP BY retur.no_po) as returJoin ON returJoin.no_retur = retur.no_retur
				  LEFT JOIN (SELECT SUM(hutang_order.pembayaran) as total_terbayar,hutang_order.no_po
				  			FROM hutang_order
				  			LEFT JOIN hutang ON hutang.no_tagihan = hutang_order.no_po
				  			GROUP BY hutang_order.no_po) as hutangOrderJoin ON hutangOrderJoin.no_po = hutang.no_tagihan
				  WHERE (hutang.status_hutang = 0 OR hutang.status_hutang = 1)";
			
			if(!empty($supplier)){
				$query .= " AND purchase_order.id_supplier='$supplier'";	  
			}

			$query .= " GROUP BY hutang.no_tagihan 
				  ORDER BY supplier.supplier DESC, purchase_order.jatuh_tempo ASC";
		return $this->db->query($query);
	}

	function hutang_ditagih_filter($supplier,$tanggalPO,$jatuhTempo){
		$query = "SELECT supplier.supplier,hutang.no_tagihan,purchase_order.jatuh_tempo,total_hutang,total_retur,purchase_order.tanggal_po, users.first_name, total_terbayar
				  FROM hutang
				  LEFT JOIN purchase_order ON purchase_order.no_po = hutang.no_tagihan
				  LEFT JOIN retur ON retur.no_po = hutang.no_tagihan
				  LEFT JOIN supplier ON supplier.id_supplier = purchase_order.id_supplier
				  LEFT JOIN receive_order ON receive_order.no_po = hutang.no_tagihan
				  LEFT JOIN users ON users.id = purchase_order.id_pic
				  LEFT JOIN (SELECT SUM(receive_item.qty*receive_item.price) as total_hutang,receive_item.no_receive
							 FROM receive_item
							 LEFT JOIN receive_order ON receive_order.no_receive = receive_item.no_receive
							 GROUP BY receive_order.no_po) as receiveItemJoin ON receiveItemJoin.no_receive = receive_order.no_receive
				  LEFT JOIN (SELECT SUM(retur_item.harga*retur_item.qty) as total_retur,retur_item.no_retur
				  			 FROM retur_item
				  			 LEFT JOIN retur ON retur.no_retur = retur_item.no_retur
				  			 GROUP BY retur.no_po) as returJoin ON returJoin.no_retur = retur.no_retur
				  LEFT JOIN (SELECT SUM(hutang_order.pembayaran) as total_terbayar,hutang_order.no_po
				  			FROM hutang_order
				  			LEFT JOIN hutang ON hutang.no_tagihan = hutang_order.no_po
				  			GROUP BY hutang_order.no_po) as hutangOrderJoin ON hutangOrderJoin.no_po = hutang.no_tagihan
				  WHERE ( hutang.status_hutang = 0 OR hutang.status_hutang = 1 )"; 
		
		if(!empty($supplier)){
			$query .= "AND purchase_order.id_supplier='".$supplier."'";
		}

		if(!empty($tanggalPO)){
			$query .= "AND purchase_order.tanggal_po='".$tanggalPO."'";
		}

		if(!empty($jatuhTempo)){
			$query .= "AND purchase_order.jatuh_tempo='".$jatuhTempo."'";
		}

		$query .= "GROUP BY hutang.no_tagihan 
				  ORDER BY supplier.supplier DESC, purchase_order.jatuh_tempo ASC";
		return $this->db->query($query);
	}

	function hutangJatuhTempo(){
		$query = "SELECT supplier.supplier,hutang.no_tagihan,purchase_order.jatuh_tempo,total_hutang,total_retur,purchase_order.tanggal_po, users.first_name, total_terbayar
				  FROM hutang
				  LEFT JOIN purchase_order ON purchase_order.no_po = hutang.no_tagihan
				  LEFT JOIN retur ON retur.no_po = hutang.no_tagihan
				  LEFT JOIN supplier ON supplier.id_supplier = purchase_order.id_supplier
				  LEFT JOIN receive_order ON receive_order.no_po = hutang.no_tagihan
				  LEFT JOIN users ON users.id = purchase_order.id_pic
				  LEFT JOIN (SELECT SUM(receive_item.qty*receive_item.price) as total_hutang,receive_item.no_receive
							 FROM receive_item
							 LEFT JOIN receive_order ON receive_order.no_receive = receive_item.no_receive
							 GROUP BY receive_order.no_po) as receiveItemJoin ON receiveItemJoin.no_receive = receive_order.no_receive
				  LEFT JOIN (SELECT SUM(retur_item.harga*retur_item.qty) as total_retur,retur_item.no_retur
				  			 FROM retur_item
				  			 LEFT JOIN retur ON retur.no_retur = retur_item.no_retur
				  			 GROUP BY retur.no_po) as returJoin ON returJoin.no_retur = retur.no_retur
				  LEFT JOIN (SELECT SUM(hutang_order.pembayaran) as total_terbayar,hutang_order.no_po
				  			FROM hutang_order
				  			LEFT JOIN hutang ON hutang.no_tagihan = hutang_order.no_po
				  			GROUP BY hutang_order.no_po) as hutangOrderJoin ON hutangOrderJoin.no_po = hutang.no_tagihan
				  WHERE ( hutang.status_hutang = 0 OR hutang.status_hutang = 1 ) AND purchase_order.jatuh_tempo <= current_date()
				  GROUP BY hutang.no_tagihan 
				  ORDER BY supplier.supplier DESC, purchase_order.jatuh_tempo ASC";
		return $this->db->query($query);
	}

	function hutangJatuhTempoFilter($supplier){
		$query = "SELECT supplier.supplier,hutang.no_tagihan,purchase_order.jatuh_tempo,total_hutang,total_retur,purchase_order.tanggal_po, users.first_name, total_terbayar
				  FROM hutang
				  LEFT JOIN purchase_order ON purchase_order.no_po = hutang.no_tagihan
				  LEFT JOIN retur ON retur.no_po = hutang.no_tagihan
				  LEFT JOIN supplier ON supplier.id_supplier = purchase_order.id_supplier
				  LEFT JOIN receive_order ON receive_order.no_po = hutang.no_tagihan
				  LEFT JOIN users ON users.id = purchase_order.id_pic
				  LEFT JOIN (SELECT SUM(receive_item.qty*receive_item.price) as total_hutang,receive_item.no_receive
							 FROM receive_item
							 LEFT JOIN receive_order ON receive_order.no_receive = receive_item.no_receive
							 GROUP BY receive_order.no_po) as receiveItemJoin ON receiveItemJoin.no_receive = receive_order.no_receive
				  LEFT JOIN (SELECT SUM(retur_item.harga*retur_item.qty) as total_retur,retur_item.no_retur
				  			 FROM retur_item
				  			 LEFT JOIN retur ON retur.no_retur = retur_item.no_retur
				  			 GROUP BY retur.no_po) as returJoin ON returJoin.no_retur = retur.no_retur
				  LEFT JOIN (SELECT SUM(hutang_order.pembayaran) as total_terbayar,hutang_order.no_po
				  			FROM hutang_order
				  			LEFT JOIN hutang ON hutang.no_tagihan = hutang_order.no_po
				  			GROUP BY hutang_order.no_po) as hutangOrderJoin ON hutangOrderJoin.no_po = hutang.no_tagihan
				  WHERE ( hutang.status_hutang = 0 OR hutang.status_hutang = 1 ) AND purchase_order.jatuh_tempo <= current_date() AND purchase_order.id_supplier = '$supplier'
				  GROUP BY hutang.no_tagihan 
				  ORDER BY supplier.supplier DESC, purchase_order.jatuh_tempo ASC";
		return $this->db->query($query);
	}

	function laporanHutangTerbayar($dateStart,$dateEnd,$supplier,$tipeBayar,$noPO,$noPayment){
		$this->db->select(array("hutang_order.no_payment","hutang_order.no_po","users.first_name","hutang_order.tanggal_pembayaran","hutang_order.keterangan","hutang_order.pembayaran","payment_type_debt.paymentType","supplier.supplier"));
		$this->db->from("hutang_order");
		$this->db->join("purchase_order","purchase_order.no_po = hutang_order.no_po","left");
		$this->db->join("supplier","supplier.id_supplier = purchase_order.id_supplier","left");
		$this->db->join("users","users.id = hutang_order.id_pic","left");
		$this->db->join("payment_type_debt","payment_type_debt.id = hutang_order.id_payment","left");

		if(!empty($dateStart) && !empty($dateEnd)){
			$this->db->where("DATE(hutang_order.tanggal_pembayaran) BETWEEN '$dateStart' AND '$dateEnd'");
		}

		if(!empty($supplier)){
			$this->db->where("purchase_order.id_supplier",$supplier);
		}

		if(!empty($tipeBayar)){
			$this->db->where("hutang_order.id_payment",$tipeBayar);
		}

		if(!empty($noPO)){
			$this->db->where("hutang_order.no_po",$noPO);
		}

		if(!empty($noPayment)){
			$this->db->where("hutang_order.no_payment",$noPayment);
		}

		$this->db->group_by("hutang_order.no_payment");
		$this->db->order_by("hutang_order.tanggal_pembayaran","DESC");
		return $this->db->get();
	}

	function hutang_harian($no_tagihan){
		$query = "SELECT supplier.supplier,hutang.no_tagihan,purchase_order.jatuh_tempo,total_hutang,total_retur, total_terbayar
				  FROM hutang
				  LEFT JOIN purchase_order ON purchase_order.no_po = hutang.no_tagihan
				  LEFT JOIN retur ON retur.no_po = hutang.no_tagihan
				  LEFT JOIN supplier ON supplier.id_supplier = purchase_order.id_supplier
				  LEFT JOIN receive_order ON receive_order.no_po = hutang.no_tagihan
				  LEFT JOIN (SELECT SUM(receive_item.qty*receive_item.price) as total_hutang,receive_item.no_receive
							 FROM receive_item
							 LEFT JOIN receive_order ON receive_order.no_receive = receive_item.no_receive
							 GROUP BY receive_order.no_po) as receiveItemJoin ON receiveItemJoin.no_receive = receive_order.no_receive
				  LEFT JOIN (SELECT SUM(retur_item.harga*retur_item.qty) as total_retur,retur_item.no_retur
				  			 FROM retur_item
				  			 LEFT JOIN retur ON retur.no_retur = retur_item.no_retur
				  			 GROUP BY retur.no_po) as returJoin ON returJoin.no_retur = retur.no_retur
				  LEFT JOIN (SELECT SUM(hutang_order.pembayaran) as total_terbayar,hutang_order.no_po
				  			FROM hutang_order
				  			LEFT JOIN hutang ON hutang.no_tagihan = hutang_order.no_po
				  			GROUP BY hutang_order.no_po) as hutangOrderJoin ON hutangOrderJoin.no_po = hutang.no_tagihan
				  WHERE hutang.no_tagihan = '$no_tagihan' AND purchase_order.jatuh_tempo = current_date()
				  GROUP BY hutang.no_tagihan 
				  ";
		$result = $this->db->query($query);

		foreach($result->result() as $row){
			return $row->total_hutang-($row->total_retur+$row->total_terbayar);
		}
	}

	function hutang_7_hari($no_tagihan){
		$query = "SELECT supplier.supplier,hutang.no_tagihan,purchase_order.jatuh_tempo,total_hutang,total_retur, total_terbayar
				  FROM hutang
				  LEFT JOIN purchase_order ON purchase_order.no_po = hutang.no_tagihan
				  LEFT JOIN retur ON retur.no_po = hutang.no_tagihan
				  LEFT JOIN supplier ON supplier.id_supplier = purchase_order.id_supplier
				  LEFT JOIN receive_order ON receive_order.no_po = hutang.no_tagihan
				  LEFT JOIN (SELECT SUM(receive_item.qty*receive_item.price) as total_hutang,receive_item.no_receive
							 FROM receive_item
							 LEFT JOIN receive_order ON receive_order.no_receive = receive_item.no_receive
							 GROUP BY receive_order.no_po) as receiveItemJoin ON receiveItemJoin.no_receive = receive_order.no_receive
				  LEFT JOIN (SELECT SUM(retur_item.harga*retur_item.qty) as total_retur,retur_item.no_retur
				  			 FROM retur_item
				  			 LEFT JOIN retur ON retur.no_retur = retur_item.no_retur
				  			 GROUP BY retur.no_po) as returJoin ON returJoin.no_retur = retur.no_retur
				  LEFT JOIN (SELECT SUM(hutang_order.pembayaran) as total_terbayar,hutang_order.no_po
				  			FROM hutang_order
				  			LEFT JOIN hutang ON hutang.no_tagihan = hutang_order.no_po
				  			GROUP BY hutang_order.no_po) as hutangOrderJoin ON hutangOrderJoin.no_po = hutang.no_tagihan
				  WHERE hutang.no_tagihan = '$no_tagihan' AND (purchase_order.jatuh_tempo > current_date() AND date_sub(purchase_order.jatuh_tempo,INTERVAL 7 day) <= current_date())
				  GROUP BY hutang.no_tagihan 
				  ";
		$result = $this->db->query($query);

		foreach($result->result() as $row){
			return $row->total_hutang-($row->total_retur+$row->total_terbayar);
		}
	}

	function hutang_14_hari($no_tagihan){
		$query = "SELECT supplier.supplier,hutang.no_tagihan,purchase_order.jatuh_tempo,total_hutang,total_retur, total_terbayar
				  FROM hutang
				  LEFT JOIN purchase_order ON purchase_order.no_po = hutang.no_tagihan
				  LEFT JOIN retur ON retur.no_po = hutang.no_tagihan
				  LEFT JOIN supplier ON supplier.id_supplier = purchase_order.id_supplier
				  LEFT JOIN receive_order ON receive_order.no_po = hutang.no_tagihan
				  LEFT JOIN (SELECT SUM(receive_item.qty*receive_item.price) as total_hutang,receive_item.no_receive
							 FROM receive_item
							 LEFT JOIN receive_order ON receive_order.no_receive = receive_item.no_receive
							 GROUP BY receive_order.no_po) as receiveItemJoin ON receiveItemJoin.no_receive = receive_order.no_receive
				  LEFT JOIN (SELECT SUM(retur_item.harga*retur_item.qty) as total_retur,retur_item.no_retur
				  			 FROM retur_item
				  			 LEFT JOIN retur ON retur.no_retur = retur_item.no_retur
				  			 GROUP BY retur.no_po) as returJoin ON returJoin.no_retur = retur.no_retur
				  LEFT JOIN (SELECT SUM(hutang_order.pembayaran) as total_terbayar,hutang_order.no_po
				  			FROM hutang_order
				  			LEFT JOIN hutang ON hutang.no_tagihan = hutang_order.no_po
				  			GROUP BY hutang_order.no_po) as hutangOrderJoin ON hutangOrderJoin.no_po = hutang.no_tagihan
				  WHERE hutang.no_tagihan = '$no_tagihan' AND (date_sub(purchase_order.jatuh_tempo,INTERVAL 7 day) > current_date() AND date_sub(purchase_order.jatuh_tempo,INTERVAL 14 day) <= current_date())
				  GROUP BY hutang.no_tagihan 
				  ";
		$result = $this->db->query($query);

		foreach($result->result() as $row){
			return $row->total_hutang-($row->total_retur+$row->total_terbayar);
		}
	}

	function hutang_less_25($no_tagihan){
		$query = "SELECT supplier.supplier,hutang.no_tagihan,purchase_order.jatuh_tempo,total_hutang,total_retur, total_terbayar
				  FROM hutang
				  LEFT JOIN purchase_order ON purchase_order.no_po = hutang.no_tagihan
				  LEFT JOIN retur ON retur.no_po = hutang.no_tagihan
				  LEFT JOIN supplier ON supplier.id_supplier = purchase_order.id_supplier
				  LEFT JOIN receive_order ON receive_order.no_po = hutang.no_tagihan
				  LEFT JOIN (SELECT SUM(receive_item.qty*receive_item.price) as total_hutang,receive_item.no_receive
							 FROM receive_item
							 LEFT JOIN receive_order ON receive_order.no_receive = receive_item.no_receive
							 GROUP BY receive_order.no_po) as receiveItemJoin ON receiveItemJoin.no_receive = receive_order.no_receive
				  LEFT JOIN (SELECT SUM(retur_item.harga*retur_item.qty) as total_retur,retur_item.no_retur
				  			 FROM retur_item
				  			 LEFT JOIN retur ON retur.no_retur = retur_item.no_retur
				  			 GROUP BY retur.no_po) as returJoin ON returJoin.no_retur = retur.no_retur
				  LEFT JOIN (SELECT SUM(hutang_order.pembayaran) as total_terbayar,hutang_order.no_po
				  			FROM hutang_order
				  			LEFT JOIN hutang ON hutang.no_tagihan = hutang_order.no_po
				  			GROUP BY hutang_order.no_po) as hutangOrderJoin ON hutangOrderJoin.no_po = hutang.no_tagihan
				  WHERE hutang.no_tagihan = '$no_tagihan' AND (date_sub(purchase_order.jatuh_tempo,INTERVAL 14 day) > current_date() AND date_sub(purchase_order.jatuh_tempo,INTERVAL 25 day) <= current_date())
				  GROUP BY hutang.no_tagihan 
				  ";
		$result = $this->db->query($query);

		foreach($result->result() as $row){
			return $row->total_hutang-($row->total_retur+$row->total_terbayar);
		}
	}

	function hutang_25($no_tagihan){
		$query = "SELECT supplier.supplier,hutang.no_tagihan,purchase_order.jatuh_tempo,total_hutang,total_retur, total_terbayar
				  FROM hutang
				  LEFT JOIN purchase_order ON purchase_order.no_po = hutang.no_tagihan
				  LEFT JOIN retur ON retur.no_po = hutang.no_tagihan
				  LEFT JOIN supplier ON supplier.id_supplier = purchase_order.id_supplier
				  LEFT JOIN receive_order ON receive_order.no_po = hutang.no_tagihan
				  LEFT JOIN (SELECT SUM(receive_item.qty*receive_item.price) as total_hutang,receive_item.no_receive
							 FROM receive_item
							 LEFT JOIN receive_order ON receive_order.no_receive = receive_item.no_receive
							 GROUP BY receive_order.no_po) as receiveItemJoin ON receiveItemJoin.no_receive = receive_order.no_receive
				  LEFT JOIN (SELECT SUM(retur_item.harga*retur_item.qty) as total_retur,retur_item.no_retur
				  			 FROM retur_item
				  			 LEFT JOIN retur ON retur.no_retur = retur_item.no_retur
				  			 GROUP BY retur.no_po) as returJoin ON returJoin.no_retur = retur.no_retur
				  LEFT JOIN (SELECT SUM(hutang_order.pembayaran) as total_terbayar,hutang_order.no_po
				  			FROM hutang_order
				  			LEFT JOIN hutang ON hutang.no_tagihan = hutang_order.no_po
				  			GROUP BY hutang_order.no_po) as hutangOrderJoin ON hutangOrderJoin.no_po = hutang.no_tagihan
				  WHERE hutang.no_tagihan = '$no_tagihan' AND date_sub(purchase_order.jatuh_tempo,INTERVAL 25 day) > current_date()
				  GROUP BY hutang.no_tagihan 
				  ";
		$result = $this->db->query($query);

		foreach($result->result() as $row){
			return $row->total_hutang-($row->total_retur+$row->total_terbayar);
		}
	}

	function hutang_lebih_tempo($no_tagihan){
		$query = "SELECT supplier.supplier,hutang.no_tagihan,purchase_order.jatuh_tempo,total_hutang,total_retur, total_terbayar
				  FROM hutang
				  LEFT JOIN purchase_order ON purchase_order.no_po = hutang.no_tagihan
				  LEFT JOIN retur ON retur.no_po = hutang.no_tagihan
				  LEFT JOIN supplier ON supplier.id_supplier = purchase_order.id_supplier
				  LEFT JOIN receive_order ON receive_order.no_po = hutang.no_tagihan
				  LEFT JOIN (SELECT SUM(receive_item.qty*receive_item.price) as total_hutang,receive_item.no_receive
							 FROM receive_item
							 LEFT JOIN receive_order ON receive_order.no_receive = receive_item.no_receive
							 GROUP BY receive_order.no_po) as receiveItemJoin ON receiveItemJoin.no_receive = receive_order.no_receive
				  LEFT JOIN (SELECT SUM(retur_item.harga*retur_item.qty) as total_retur,retur_item.no_retur
				  			 FROM retur_item
				  			 LEFT JOIN retur ON retur.no_retur = retur_item.no_retur
				  			 GROUP BY retur.no_po) as returJoin ON returJoin.no_retur = retur.no_retur
				  LEFT JOIN (SELECT SUM(hutang_order.pembayaran) as total_terbayar,hutang_order.no_po
				  			FROM hutang_order
				  			LEFT JOIN hutang ON hutang.no_tagihan = hutang_order.no_po
				  			GROUP BY hutang_order.no_po) as hutangOrderJoin ON hutangOrderJoin.no_po = hutang.no_tagihan
				  WHERE hutang.no_tagihan = '$no_tagihan'AND purchase_order.jatuh_tempo < current_date()
				  GROUP BY hutang.no_tagihan 
				  ";
		$result = $this->db->query($query);

		foreach($result->result() as $row){
			return $row->total_hutang-($row->total_retur+$row->total_terbayar);
		}
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

	function viewReportWaste($dateStart,$dateEnd,$idProduk){
		$this->db->select(array("ap_produk.id_produk","ap_produk.nama_produk","waste_item.harga","waste_item.qty","(waste_item.harga*waste_item.qty) as total"));
		$this->db->from("waste_item");
		$this->db->join("ap_produk","ap_produk.id_produk = waste_item.sku","left");
		$this->db->where("waste_item.tanggal BETWEEN '$dateStart' AND '$dateEnd'");

		if(!empty($idProduk)){
			$this->db->where("waste_item.sku",$idProduk);
		}

		return $this->db->get()->result();
	}

	function rowPenerimaanBarang($dateStart,$dateEnd,$tempatPenerimaan='',$supplier=''){
		$this->db->from("receive_order");

		if(!empty($dateStart) && !empty($dateEnd)){
			$this->db->where("receive_order.tanggal_terima BETWEEN '$dateStart' AND '$dateEnd'");
		}

		if(!empty($tempatPenerimaan)){
			$this->db->where("receive_order.diterimaDi",$tempatPenerimaan);
		}

		if(!empty($supplier)){
			$this->db->where("receive_order.id_supplier",$supplier);
		}

		$this->db->where("type",NULL);

		return $this->db->count_all_results();
	}

	function viewPenerimaanBarang($limit,$start,$search='',$dateStart,$dateEnd,$tempatPenerimaan='',$supplier=''){
		$this->db->select(array("receive_order.no_receive","receive_order.no_po","receive_order.tanggal_terima","receive_order.received_by as penerima","receive_order.checked_by as pemeriksa","supplier.supplier","ap_store.store","receive_order.diterimaDi"));
		$this->db->from("receive_order");
		$this->db->join("supplier","supplier.id_supplier = receive_order.id_supplier","left");
		$this->db->join("ap_store","ap_store.id_store = receive_order.diterimaDi","left");

		if(!empty($dateStart) && !empty($dateEnd)){
			$this->db->where("receive_order.tanggal_terima BETWEEN '$dateStart' AND '$dateEnd'");
		}

		if(!empty($tempatPenerimaan)){
			$this->db->where("receive_order.diterimaDi",$tempatPenerimaan);
		}

		if(!empty($supplier)){
			$this->db->where("receive_order.id_supplier",$supplier);
		}

		$this->db->where("receive_order.type",NULL);

		if(!empty($search)){
			$this->db->like("receive_order.no_receive",$search);
			$this->db->or_like("receive_order.no_po",$search);
		}

		$this->db->limit($limit,$start);

		$this->db->order_by("receive_order.tanggal_terima","DESC");
		return $this->db->get();
	}

	function qtyPeritemPenerimaan($dateStart,$dateEnd,$tempatPenerimaan,$supplier,$idProduk){
		$this->db->select("SUM(receive_item.qty) as qty");
		$this->db->from("receive_item");
		$this->db->join("receive_order","receive_order.no_receive = receive_item.no_receive");
		$this->db->join("ap_produk","ap_produk.id_produk = receive_item.sku","left");
		$this->db->join("supplier","supplier.id_supplier = receive_order.id_supplier","left");
		$this->db->join("ap_store","ap_store.id_store = receive_order.diterimaDi","left");

		if(!empty($dateStart) && !empty($dateEnd)){
			$this->db->where("receive_item.tanggal BETWEEN '$dateStart' AND '$dateEnd'");
		}

		if(!empty($tempatPenerimaan)){
			$this->db->where("receive_order.diterimaDi",$tempatPenerimaan);
		}

		if(!empty($supplier)){
			$this->db->where("receive_order.id_supplier",$supplier);
		}

		if(!empty($idProduk)){
			$this->db->where("ap_produk.id_produk",$idProduk);
		}

		$this->db->where("receive_order.type",NULL);

		if(!empty($search)){
			$this->db->like("receive_order.no_receive",$search);
			$this->db->or_like("receive_order.no_po",$search);
		}
		return $this->db->get()->row()->qty;
	}

	function rowPenerimaanBarangPeritem($dateStart,$dateEnd,$tempatPenerimaan='',$supplier='',$idProduk){
		$this->db->from("receive_item");
		$this->db->join("receive_order","receive_order.no_receive = receive_item.no_receive");
		if(!empty($dateStart) && !empty($dateEnd)){
			$this->db->where("receive_item.tanggal BETWEEN '$dateStart' AND '$dateEnd'");
		}

		if(!empty($tempatPenerimaan)){
			$this->db->where("receive_order.diterimaDi",$tempatPenerimaan);
		}

		if(!empty($supplier)){
			$this->db->where("receive_order.id_supplier",$supplier);
		}

		$this->db->where("type",NULL);

		return $this->db->count_all_results();
	}

	function viewPenerimaanBarangPeritem($limit,$start,$search='',$dateStart,$dateEnd,$tempatPenerimaan='',$supplier='',$idProduk){
		$this->db->select(array("receive_order.no_receive","receive_order.no_po","receive_item.tanggal","receive_order.received_by as penerima","receive_order.checked_by as pemeriksa","supplier.supplier","ap_store.store","receive_order.diterimaDi","ap_produk.nama_produk","ap_produk.id_produk","receive_item.qty"));
		$this->db->from("receive_item");
		$this->db->join("receive_order","receive_order.no_receive = receive_item.no_receive");
		$this->db->join("ap_produk","ap_produk.id_produk = receive_item.sku","left");
		$this->db->join("supplier","supplier.id_supplier = receive_order.id_supplier","left");
		$this->db->join("ap_store","ap_store.id_store = receive_order.diterimaDi","left");

		if(!empty($dateStart) && !empty($dateEnd)){
			$this->db->where("receive_item.tanggal BETWEEN '$dateStart' AND '$dateEnd'");
		}

		if(!empty($tempatPenerimaan)){
			$this->db->where("receive_order.diterimaDi",$tempatPenerimaan);
		}

		if(!empty($supplier)){
			$this->db->where("receive_order.id_supplier",$supplier);
		}

		if(!empty($idProduk)){
			$this->db->where("ap_produk.id_produk",$idProduk);
		}

		$this->db->where("receive_order.type",NULL);

		if(!empty($search)){
			$this->db->like("receive_order.no_receive",$search);
			$this->db->or_like("receive_order.no_po",$search);
		}

		$this->db->limit($limit,$start);

		$this->db->order_by("receive_order.tanggal_terima","DESC");
		return $this->db->get();
	}

	function ajaxProduk($q){
		$this->db->select(array("ap_produk.id_produk","ap_produk.nama_produk"));
		$this->db->from("ap_produk");
		$this->db->like("ap_produk.id_produk",$q);
		$this->db->or_like("ap_produk.nama_produk",$q);
		return $this->db->get();
	}

	function totalRowSO($tahun){
		$this->db->from("stock_opname_info");
		if(!empty($tahun)){
			$this->db->where("YEAR(tanggal)",$tahun);
		}
		return $this->db->count_all_results();
	}

	function viewLaporanSO($limit,$start,$search,$tahun){
		$this->db->select(array("stock_opname_info.noSO","stock_opname_info.tanggal","stock_opname_info.keterangan","users.first_name"));
		$this->db->from("stock_opname_info");
		$this->db->join("users","users.id = stock_opname_info.idUser");

		if(!empty($tahun)){
			$this->db->where("YEAR(stock_opname_info.tanggal)",$tahun);
		}

		if(!empty($search)){
			$this->db->like("stock_opname_info.noSO".$search);
		}

		$this->db->limit($limit,$start);
		$this->db->group_by("stock_opname_info.noSO");
		return $this->db->get();
	}

	function viewReportReturPembelian($dateStart,$dateEnd,$supplier){
		$this->db->select(array("retur.no_po","retur.tanggal_retur","supplier.supplier","users.first_name"));
		$this->db->from("retur");
		$this->db->join("purchase_order","purchase_order.no_po = retur.no_po","left");
		$this->db->join("supplier","supplier.id_supplier = purchase_order.id_supplier","left");
		$this->db->join("users","users.id = retur.id_pic");

		if(!empty($dateStart) && !empty($dateEnd)){
			$this->db->where("DATE(retur.tanggal_retur) BETWEEN '$dateStart' AND '$dateEnd'");
		}

		if(!empty($supplier)){
			$this->db->where("purchase_order.id_supplier",$supplier);
		}

		$this->db->group_by("retur.no_po");
		return $this->db->get()->result();
	}	

	function dataRetur($noPO){
		$this->db->select(array("ap_produk.id_produk","ap_produk.nama_produk","retur_item.qty","retur_item.harga","ap_produk.satuan","(retur_item.qty*retur_item.harga) as total","retur_item.tanggal"));
		$this->db->from("retur_item");
		$this->db->join("ap_produk","ap_produk.id_produk = retur_item.sku");
		$this->db->join("retur","retur.no_retur = retur_item.no_retur");
		$this->db->where("retur.no_po",$noPO);
		return $this->db->get()->result();
	}

	function laporanPenjualanPerkriteria($start,$end,$typeBayar,$subAccount){
		$this->db->select(array("ap_invoice_number.diskon_otomatis","ap_invoice_number.tanggal","ap_payment_type.payment_type","ap_payment_account.account","ap_invoice_number.no_invoice","ap_invoice_number.tipe_bayar","ap_invoice_number.total","ap_invoice_number.ongkir","ap_invoice_number.diskon","ap_invoice_number.diskon_free","ap_invoice_number.poin_value","((ap_invoice_number.total+ap_invoice_number.ongkir)-(ap_invoice_number.diskon+ap_invoice_number.diskon_free+ap_invoice_number.poin_value)) as grand_total"));
		$this->db->from("ap_invoice_number");
		$this->db->join("ap_payment_type","ap_payment_type.id = ap_invoice_number.tipe_bayar","left");
		$this->db->join("ap_payment_account","ap_payment_account.id_payment_account = ap_invoice_number.sub_account","left");
		$this->db->where("ap_invoice_number.tanggal BETWEEN '$start 00:00:00' AND '$end 23:59:59'");

		if(!empty($typeBayar)){
			$this->db->where("ap_invoice_number.tipe_bayar",$typeBayar);
		}

		if(!empty($subAccount)){
			$this->db->where("ap_invoice_number.sub_account",$subAccount);
		}

		$this->db->order_by("ap_invoice_number.tanggal","DESC");
		$this->db->group_by("ap_invoice_number.no_invoice");
		return $this->db->get();
	}

	function penjualanPerkriteriaProduk($start,$end){
		$this->db->select(array("ap_produk.id_produk","ap_produk.nama_produk","ap_produk.satuan","ap_produk.hpp as harga_beli","ap_invoice_item.harga_jual as harga_jual","SUM(ap_invoice_item.qty) as qty_terjual"));
		$this->db->from("ap_invoice_item");
		$this->db->join("ap_produk","ap_produk.id_produk = ap_invoice_item.id_produk","left");
		$this->db->join("ap_invoice_number","ap_invoice_number.no_invoice = ap_invoice_item.no_invoice");
		$this->db->where("ap_invoice_item.tanggal BETWEEN '$start' AND '$end'");

		$this->db->group_by("ap_invoice_item.id_produk");
		$this->db->order_by("qty_terjual","DESC");
		$query = $this->db->get();
		return $query;
	}
}

