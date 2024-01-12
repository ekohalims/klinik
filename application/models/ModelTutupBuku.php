<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class ModelTutupBuku extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->load->database();
    }

    function cekTrxJurnalBefore($lastMonth,$lastYear){
        $this->db->from("jurnal");
        $this->db->where("MONTH(tanggal)",$lastMonth);
        $this->db->where("YEAR(tanggal)",$lastYear);
        return $this->db->count_all_results();
    }

    function totalPendapatanPerakun($bulan,$tahun){
        $this->db->select(array("SUM(jurnal.debit) as debit","SUM(jurnal.kredit) as kredit","coa_sub.namaSubAkun","coa_sub.kodeSubAkun"));
        $this->db->from("jurnal");
        $this->db->join("coa_sub","coa_sub.kodeSubAkun = jurnal.kodeAkun");
        $this->db->where("coa_sub.kodeAkun",41);
        $this->db->where("MONTH(jurnal.tanggal)",$bulan);
        $this->db->where("YEAR(jurnal.tanggal)",$tahun);
        $this->db->group_by("coa_sub.kodeSubAkun");
        return $this->db->get()->result();
    }

    function pindahkanStokAwal($bulan,$tahun){
       //simpan persediaan awal gudang
       $this->simpanPersediaanAwalGudang($bulan,$tahun);

       //simpan harga rata-rata 
       $this->simpanHargaAverage($bulan,$tahun);
    }

    function simpanPersediaanAwalGudang($bulan,$tahun){
        if($bulan != 12){
            $nextMonth = sprintf('%02d',$bulan+1);
            $nextYear = $tahun;
        } else {
            $nextMonth = '01';
            $nextYear = $tahun+1;
        }

        $this->db->select(array("ap_produk.id_produk","ap_produk.stok"));
        $this->db->from("ap_produk");
        $query = $this->db->get()->result();
 
        foreach($query as $row){
            $dataInsert[] = array(
                "idProduk" => $row->id_produk,
                "bulan" => $nextMonth,
                "tahun" => $nextYear,
                "stokAwal" => $row->stok,
                "tempat" => 0
            );
        }

        $this->db->insert_batch("tb_stokawal",$dataInsert);
    }

    function simpanHargaAverage($bulan,$tahun){
        if($bulan != 12){
            $nextMonth = sprintf('%02d',$bulan+1);
            $nextYear = $tahun;
        } else {
            $nextMonth = '01';
            $nextYear = $tahun+1;
        }

        $this->db->select(array("ap_produk.id_produk","ap_produk.hpp"));
        $this->db->from("ap_produk");
        $query = $this->db->get()->result();

        foreach($query as $row){
            $idProduk = $row->id_produk;
            $hpp = $row->hpp;

            $dataInsert[] = array(
                "idProduk" => $idProduk,
                "bulan" => $nextMonth,
                "tahun" => $nextYear,
                "hargaAwal" => $hpp
            );
        }
        
        $this->db->insert_batch("tb_hargaawal",$dataInsert);
         
    }

    function piutangMelebihiTempo(){
        $this->db->from("kl_piutang");
        $this->db->where("jatuhTempo < CURDATE()");
		$this->db->where("status",0);
		$this->db->or_where("status",1);
		return $this->db->count_all_results();
    }
    
    function dataPiutangMelebihiTempo(){
        $this->db->select(array("kl_piutang.noPendaftaran","kl_piutang.jatuhTempo","kl_invoice.grandTotal"));
        $this->db->from("kl_piutang");
        $this->db->join("kl_invoice","kl_invoice.noPendaftaran = kl_piutang.noPendaftaran");
        $this->db->where("jatuhTempo < CURDATE()");
		$this->db->where("status",0);
        $this->db->or_where("status",1);
        $this->db->group_by(array("kl_piutang.noPendaftaran","kl_piutang.jatuhTempo","kl_invoice.grandTotal"));
        return $this->db->get()->result();
    }

    function sisaPiutang($noPendaftaran){
        $this->db->select("kl_invoice.grandTotal");
        $this->db->from("kl_piutang");
        $this->db->join("kl_invoice","kl_invoice.noPendaftaran = kl_piutang.noPendaftaran");
		$this->db->where("kl_piutang.noPendaftaran",$noPendaftaran);
        $query = $this->db->get()->row();

        $hutangTerbayar = $this->hutangTerbayar($noPendaftaran);
        $sisaPiutang = $query->grandTotal-$hutangTerbayar;
        return $sisaPiutang;
    }

    function hutangTerbayar($noPendaftaran){
		$this->db->select_sum("nilaiBayar");
		$this->db->from("kl_piutang_pembayaran");
		$this->db->where("noPendaftaran",$noPendaftaran);
		$query = $this->db->get()->row();
		return $query->nilaiBayar;
	}

    function countSOGudang($bulan,$tahun){
        $this->db->from("stock_opname_info");
        $this->db->where("MONTH(tanggal)",$bulan);
        $this->db->where("YEAR(tanggal)",$tahun);
        $this->db->where("store",NULL);
        return $this->db->count_all_results();
    }

    function countSOToko($bulan,$tahun){
        $this->db->from("stock_opname_info");
        $this->db->where("MONTH(tanggal)",$bulan);
        $this->db->where("YEAR(tanggal)",$tahun);
        $this->db->where("store",1);
        return $this->db->count_all_results();
    }

    function dataAset(){
        $this->db->select(array("ak_aset.kodeAset","ak_aset.tanggalBeli as tanggalPerolehan","ak_aset.hargaBeli","ak_aset.nilaiResidu","ak_aset.umurEkonomis","ak_aset.metode","ak_aset.akunHarta","ak_aset.akumulasiDepresiasi","ak_aset.depresiasi"));
        $this->db->from("ak_aset");
        $this->db->where("metode",2);
        return $this->db->get()->result();        
    }

    function updateNilaiDepresiasi($kodeAset,$bebanDepresiasi){
        $currentDepresiasi = $this->currentDepresiasi($kodeAset); 

        $dataUpdate = array(
            "nilaiDepresiasi" => $currentDepresiasi+$bebanDepresiasi
        );

        $this->db->where("kodeAset",$kodeAset);
        $this->db->update("ak_aset",$dataUpdate);
    }

    function currentDepresiasi($kodeAset){
        $this->db->select("nilaiDepresiasi");
        $this->db->from("ak_aset");
        $this->db->where("kodeAset",$kodeAset);
        return $this->db->get()->row()->nilaiDepresiasi;
    }

    function simpanDepresiasiTable($dataDepresiasi){
        $this->db->insert_batch("ak_depresiasi",$dataDepresiasi);
    }

    function countMonthBetweenTwoDate($date1,$date2){
		$begin = new DateTime($date1);
    	$end = new DateTime($date2);
    	$end = $end->modify( '+1 day' );

    	$interval = DateInterval::createFromDateString('1 day');

    	$period = new DatePeriod($begin, $interval, $end);
    	$counter = 0;
    	foreach($period as $dt) {
        	$counter++;
    	}

    	return $counter;
    }
    
    function jumlahAkumulasiDepresiasi($kodeAset){
        $this->db->select("SUM(depresiasi) as jumlahDepresiasi");
        $this->db->from("ak_depresiasi");
        $this->db->where("kodeAset",$kodeAset);
        $query = $this->db->get()->result();

        foreach($query as $row){
            return $row->jumlahDepresiasi;
        }
    }

    function prosesDepresiasi($bulan,$tahun){
        $dataAset = $this->dataAset();

        $tanggal = date('d');

		if($tanggal >= 01 && $tanggal <= 03){
			//closing pada awal bulan, berarti ambil data bulan sebelumnya

			$bulanLalu = $tahun."-".$bulan."-"."01";
			$endDate = new DateTime($bulanLalu);
			
			$tanggalJurnal = $tahun."-".$bulan."-".$endDate->format('t');
		} elseif($tanggal >= 26 && $tanggal <= 31){
			//closing pada akhir bulan, berarti ambil data pada bulan ini
			$currentMonth = $bulan;
			$currentYear = $tahun;
			$tanggalJurnal = $currentYear."-".$currentMonth."-".date('t');
        }
        
        foreach($dataAset as $row){
			$kodeAset = $row->kodeAset;
			$tanggalPerolehan = $row->tanggalPerolehan;
			$hargaBeli = $row->hargaBeli;
			$nilaiResidu = $row->nilaiResidu;
			$umurEkonomis = $row->umurEkonomis;
			
			$metode = $row->metode;
			$akunHarta = $row->akunHarta;
			$akumulasiDepresiasi = $row->akumulasiDepresiasi;
			$depresiasi = $row->depresiasi;
			
			//hitung apakah bulan ini masuk depresiasi
			$hitungUsia = $this->countMonthBetweenTwoDate($tanggalPerolehan,$tanggalJurnal);
			$usia = round($hitungUsia/30);

			if($usia <= $umurEkonomis){
				if($metode != 1){
					//beban depresiasi perbulan
					$depresiasiPerbulan = (($hargaBeli-$nilaiResidu)/$umurEkonomis)/12;
					$bebanAkumulasiDepresiasi = (($hargaBeli-$nilaiResidu)/$umurEkonomis)/12*$usia;

                    //cek apakah nilai depresiasi didapatkan tanggal perolehannya lebih awal di banding periode akuntansi
                    $depresiasiTerinput = $this->jumlahAkumulasiDepresiasi($kodeAset);    
                    
                    if($depresiasiTerinput < 1){
                        //update nilai depresiasi pada database
                        $this->modelTutupBuku->updateNilaiDepresiasi($kodeAset,$bebanAkumulasiDepresiasi);
                        $nilaiDepresiasi = $bebanAkumulasiDepresiasi;
                    } else {
                        //update nilai depresiasi pada database
                        $this->modelTutupBuku->updateNilaiDepresiasi($kodeAset,$depresiasiPerbulan);
                        $nilaiDepresiasi = $depresiasiPerbulan;
                    }

                    //simpan nilai depresiasi ke database
					$dataDepresiasi[] = array(
						"kodeAset" => $kodeAset,
						"tanggal" => $tanggalJurnal,
						"depresiasi" => $nilaiDepresiasi
					);
				}
			}
	
        }
                
        $this->simpanDepresiasiTable($dataDepresiasi);
        $this->simpanJurnalDepresiasi($bulan,$tahun,$tanggalJurnal);
    }

    function noJurnal(){
        $today = date('Y-m-d');
        $this->db->from("jurnal");
        $this->db->group_by("noJurnal");
        $this->db->where("tanggal",$today);
        return $this->db->count_all_results();
    }

    function noJurnalAkhirBulan($tanggal){
        $this->db->from("jurnal");
        $this->db->group_by("noJurnal");
        $this->db->where("tanggal",$tanggal);
        return $this->db->count_all_results();
    }
    
    function simpanJurnalDepresiasi($bulan,$tahun,$tanggalJurnal){
        $dataDepresiasi = $this->akumulasiDepresiasiPerkategori($bulan,$tahun);
        
        foreach($dataDepresiasi as $row){
            $urutanNoJurnal = $this->noJurnalAkhirBulan($tanggalJurnal);

            $tanggalReff = date_format(date_create($tanggalJurnal),'ymd');

            $noJurnal = "JURN".$tanggalReff.sprintf('%04d',$urutanNoJurnal+1);
            $noReff = "CLOSE".$tahun.$bulan;
            $keterangan = "Depresiasi akhir bulan";

            $dataDebit = array(
                "noJurnal" => $noJurnal,
                "noReferrence" => $noReff,
                "tanggal" => $tanggalJurnal,
                "kodeAkun" => $row->depresiasi,
                "debit" => $row->nilaiDepresiasi,
                "keterangan" => $keterangan,
                "posisi" => 'D',
                "slug" => ''
            );

            $dataKredit = array(
                "noJurnal" => $noJurnal,
                "noReferrence" => $noReff,
                "tanggal" => $tanggalJurnal,
                "kodeAkun" => $row->akumulasiDepresiasi,
                "kredit" => $row->nilaiDepresiasi,
                "keterangan" => $keterangan,
                "posisi" => 'K',
                "slug" => ''
            );

            $this->db->insert("jurnal",$dataDebit);
            $this->db->insert("jurnal",$dataKredit);
        }
    }

    function akumulasiDepresiasiPerkategori($bulan,$tahun){
        $this->db->select(array("ak_aset.akumulasiDepresiasi","ak_aset.depresiasi","SUM(ak_depresiasi.depresiasi) as nilaiDepresiasi"));
        $this->db->from("ak_depresiasi");
        $this->db->join("ak_aset","ak_aset.kodeAset = ak_depresiasi.kodeAset");
        $this->db->where("MONTH(ak_depresiasi.tanggal)",$bulan);
        $this->db->where("YEAR(ak_depresiasi.tanggal)",$tahun);
        $this->db->group_by("ak_aset.kelompok");
        return $this->db->get()->result();
    }

    function simpanSaldoAwal($saldo){
        $this->db->insert_batch("ak_saldoawal",$saldo);
    }

    function simpanJurnalAwal($data){
        $this->db->insert_batch("jurnal",$data);
    }

    function viewDataStok(){
        $this->db->select(array("ap_produk.id_produk","ap_produk.stok","ap_produk.hpp"));
        $this->db->from("ap_produk");
        return $this->db->get()->result();
    }

    function insertKartuStok($data){
        $this->db->insert_batch("kartu_stok",$data);
    }

    function insertTutupBukuData($dataArray){
        $this->db->insert("ak_tutupbuku",$dataArray);
    }

    function isClosed($bulan,$tahun){
        $this->db->from("ak_tutupbuku");
        $this->db->where("bulan",$bulan);
        $this->db->where("tahun",$tahun);
        return $this->db->count_all_results();
    }
}