<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class TutupBuku extends BaseController{
	function __construct(){
		parent::__construct();
		$this->load->model("modelTutupBuku");
		$this->isLoggedIn($this->global['idUser'],2,35);
    }

    function index(){
		$this->global['pageTitle'] = "SIMRS - Tutup Buku";
		$bulan = date('m');
		$tahun = date('Y');

		$data['header'] = $this->db->get_where("kl_klinikinfo",array("id" => 1))->row();
		$data['piutangMelebihiTempo'] = $this->modelTutupBuku->piutangMelebihiTempo();
		$data['dataPiutangMelebihiTempo'] = $this->modelTutupBuku->dataPiutangMelebihiTempo();

		$data['SOGudang'] = $this->modelTutupBuku->countSOGudang($bulan,$tahun);
		$data['SOToko'] = $this->modelTutupBuku->countSOToko($bulan,$tahun);
		
		$bulanConvert = array(
			"01" => "Januari",
			"02" => "Februari",
			"03" => "Maret",
			"04" => "April",
			"05" => "Mei",
			"06" => "Juni",
			"07" => "Juli",
			"08" => "Agustus",
			"09" => "September",
			"10" => "Oktober",
			"11" => "November",
			"12" => "Desember"
		);

		$tanggal = sprintf('%01d',date('d'));

		if($tanggal >= 01 && $tanggal <= 03){
			//closing pada awal bulan, berarti ambil data bulan sebelumnya

			if($bulan != 01){
				$currentMonth = sprintf('%02d',$bulan-1);
				$currentYear = $tahun;
			} else {
				$currentMonth = 12;
				$currentYear = $tahun-1;
			}

			$data['periode'] = $bulanConvert[$currentMonth]." ".$currentYear;
			
			//cek apakah pada bulan sebelumnya terdapat transaksi, jika tidak dianggap
			//sebagai periode awal pembukuan
			$trxJurnalLastMonth = $this->modelTutupBuku->cekTrxJurnalBefore($currentMonth,$currentYear);

			if($trxJurnalLastMonth < 1){
				$views = "keuangan/jurnalpenutup/warningClosing";
			} else {
				//cek apa sudah closing
				$isClosed = $this->modelTutupBuku->isClosed($currentMonth,$currentYear);
				
				if($isClosed > 0){
					$views = "keuangan/jurnalpenutup/closed";
				} else {
					$views = "keuangan/jurnalpenutup/bodyJurnalPenutup";
				}
			}
		} elseif($tanggal >= 26 && $tanggal <= 31){
			//closing pada akhir bulan, berarti ambil data pada bulan ini
			$currentMonth = $bulan;
			$currentYear = $tahun;
			$isClosed = $this->modelTutupBuku->isClosed($currentMonth,$currentYear);
			$data['periode'] = $bulanConvert[$currentMonth]." ".$currentYear;
			if($isClosed > 0){
				$views = "keuangan/jurnalpenutup/closed";
			} else {
				$views = "keuangan/jurnalpenutup/bodyJurnalPenutup";
			}
		} else {
			$currentMonth = '';
			$currentYear = '';
			$views = "keuangan/jurnalpenutup/warningClosing";
		}
		
		$this->load->model("modelNeracaSaldo");
		$data['akun'] = $this->modelNeracaSaldo->viewNeracaSaldo($currentMonth,$currentYear);
		$this->loadViews($views,$this->global,$data,"keuangan/jurnalpenutup/footerJurnalPenutup");
	}
	
	function prosesTutupBuku(){
		$this->load->model("modelTrxJurnal");
	
		$noINV = "CLOSE".date("ym");

		//jika ada piutang yang akan di cadangkan
		$piutangDibatalkan = $this->input->post("dataPiutang");
		$piutangDecode = json_decode(stripcslashes($piutangDibatalkan));
		$nominalPerlengkapan = $this->input->post("nominalPerlengkapan");
		
		$tanggal = sprintf('%01d',date('d'));

		$bulan = date('m');
		$tahun = date('Y');

		if($tanggal >= 01 && $tanggal <= 03){
			//closing pada awal bulan, berarti ambil data bulan sebelumnya

			if($bulan != 01){
				$currentMonth = sprintf('%02d',$bulan-1);
				$currentYear = $tahun;
			} else {
				$currentMonth = 12;
				$currentYear = $tahun-1;
			}

			$bulanLalu = $currentYear."-".$currentMonth."-"."01";
			$endDate = new DateTime($bulanLalu);
			
			$tanggalJurnal = $currentYear."-".$currentMonth."-".$endDate->format('t');
		} elseif($tanggal >= 26 && $tanggal <= 31){
			//closing pada akhir bulan, berarti ambil data pada bulan ini
			$currentMonth = $bulan;
			$currentYear = $tahun;
			$tanggalJurnal = $currentYear."-".$currentMonth."-".date('t');
		}

		if($nominalPerlengkapan > 0){
			$akunDebit = '5107';
			$akunKredit = '1601';
			$keterangan ='Penyusutan beban perlengkapan ';
			$value = $nominalPerlengkapan;
			$this->modelTrxJurnal->insertJurnalAkhirBulan($noINV,$akunDebit,$akunKredit,$keterangan,$value,$tanggalJurnal);
		}

		if($piutangDecode != ''){
			$totalSisaPiutang = 0;
			foreach($piutangDecode as $row){
				$noPendaftaran = $row->noPendaftaran;
				$sisaPiutang = $this->modelTutupBuku->sisaPiutang($noPendaftaran);
			$totalSisaPiutang = $totalSisaPiutang+$sisaPiutang; }

			$akunDebit = '5206';
			$akunKredit = '1302';
			$keterangan = 'Alokasi Piutang Tak tertagih';
			$this->modelTrxJurnal->insertJurnalAkhirBulan($noINV,$akunDebit,$akunKredit,$keterangan,$totalSisaPiutang,$tanggalJurnal);
		}
	
		$this->pindahkanPersediaan($currentMonth,$currentYear);
		$this->hitungNilaiDepresiasi($currentMonth,$currentYear); //perbaiki yang depresiasi
		$this->pindahkanSaldoAwal($currentMonth,$currentYear);
		$this->pindahkanSaldoAwalJurnal($currentMonth,$currentYear);
		$this->pindahkanSaldoAwalBarangKartuStok($currentMonth,$currentYear);
		$this->tutupBukuData($currentMonth,$currentYear);
	}

	function tutupBukuData($bulan,$tahun){
		$noPenutupan = "CLOSE".date('ym');
		$idUser = $this->global['idUser'];
		$tanggal = date("Y-m-d H:i:s");
		
		$dataArray = array(
			"noPenutupan" => $noPenutupan,
			"idUser" => $idUser,
			"bulan" => $bulan,
			"tahun" => $tahun,
			"tanggal" => $tanggal
		);

		$this->modelTutupBuku->insertTutupBukuData($dataArray);
	}

	function pindahkanPersediaan($bulan,$tahun){
		$this->modelTutupBuku->pindahkanStokAwal($bulan,$tahun);	
	}

	function hitungNilaiDepresiasi($bulan,$tahun){
		$this->modelTutupBuku->prosesDepresiasi($bulan,$tahun);
	}

	function pindahkanSaldoAwal($bulan,$tahun){
		if($bulan != 12){
            $nextMonth = sprintf('%02d',$bulan+1);
            $nextYear = $tahun;
        } else {
            $nextMonth = '01';
            $nextYear = $tahun+1;
        }

		$this->load->model("modelNeracaSaldo");

		//akun harta
		$dataAset = $this->modelNeracaSaldo->hartaLancarNeraca($bulan,$tahun);
		
		foreach($dataAset as $row){
			$kodeAkun = $row->kodeSubAkun;
			$nilaiSaldo = $row->debit-$row->kredit;

			$dataHartaArray[] = array(
				"kodeAkun" => $kodeAkun,
				"bulan" => $nextMonth,
				"tahun" => $nextYear,
				"saldo" => $nilaiSaldo 
			);			
		}

		$this->modelTutupBuku->simpanSaldoAwal($dataHartaArray);

		//kewajiban dan modal
		$kewajiban = $this->modelNeracaSaldo->kewajibanNeraca($bulan,$tahun);
		foreach($kewajiban as $dt){
			$kodeAkunKewajiban = $dt->kodeSubAkun;
			$saldoKewajiban = $dt->kredit-$dt->debit;

			$dataKewajibanArray[] = array(
				"kodeAkun" => $kodeAkunKewajiban,
				"bulan" => $nextMonth,
				"tahun" => $nextYear,
				"saldo" => $saldoKewajiban
			);
		}

		$this->modelTutupBuku->simpanSaldoAwal($dataKewajibanArray);

		$this->load->model("modelLaporanPerubahanModal");

		$modal = $this->modelLaporanPerubahanModal->totalModal($bulan,$tahun);
        $totalPendapatan = $this->modelLaporanPerubahanModal->totalPendapatan($bulan,$tahun);
        $totalBeban = $this->modelLaporanPerubahanModal->totalBeban($bulan,$tahun);
        $hpp = $this->modelLaporanPerubahanModal->totalHPP($bulan,$tahun);
        $prive = $this->modelLaporanPerubahanModal->totalPrive($bulan,$tahun);

        $pendapatanBersih = $totalPendapatan-$totalBeban-$hpp;
		$modalAkhir = $modal+$pendapatanBersih-$prive;
		
		$dataSaldoAwalModal[] = array(
			"kodeAkun" => '3101',
			"bulan" => $nextMonth,
			"tahun" => $nextYear,
			"saldo" => $modalAkhir
		);

		$this->modelTutupBuku->simpanSaldoAwal($dataSaldoAwalModal);

		$historicalBalancing = $this->modelNeracaSaldo->historicalBalancing($bulan,$tahun);

		if($historicalBalancing > 0){
	
			$dataSaldoAwalHB[] = array(
				"kodeAkun" => '3103',
				"bulan" => $nextMonth,
				"tahun" => $nextYear,
				"saldo" => $historicalBalancing
			);

			$this->modelTutupBuku->simpanSaldoAwal($dataSaldoAwalHB);
		}
	}

	function pindahkanSaldoAwalJurnal($bulan,$tahun){
		if($bulan != 12){
            $nextMonth = sprintf('%02d',$bulan+1);
            $nextYear = $tahun;
        } else {
            $nextMonth = '01';
            $nextYear = $tahun+1;
        }

		$noJurnal = "JURN".$nextYear.$nextMonth.'01'.'0001';

		$this->load->model("modelNeracaSaldo");

		//akun harta
		$dataAset = $this->modelNeracaSaldo->hartaLancarNeraca($bulan,$tahun);
		
		foreach($dataAset as $row){
			$kodeAkun = $row->kodeSubAkun;
			$nilaiSaldo = $row->debit-$row->kredit;

			$dataHartaArray[] = array(
				"noJurnal" => $noJurnal,
				"noReferrence" => "SALDOAWAL".$nextYear.$nextMonth,
				"tanggal" => $nextYear.$nextMonth.'01',
				"kodeAkun" => $kodeAkun,
				"debit" => $nilaiSaldo,
				"posisi" => 'D',
				"keterangan" => "SALDO AWAL",
				"slug" => "SALDOAWAL" 
			);		

		}

		$this->modelTutupBuku->simpanJurnalAwal($dataHartaArray);

		//kewajiban dan modal
		$kewajiban = $this->modelNeracaSaldo->kewajibanNeraca($bulan,$tahun);
		foreach($kewajiban as $dt){
			$kodeAkunKewajiban = $dt->kodeSubAkun;
			$saldoKewajiban = $dt->kredit-$dt->debit;

			$dataKewajibanArray[] = array(
				"noJurnal" => $noJurnal,
				"noReferrence" => "SALDOAWAL".$nextYear.$nextMonth,
				"tanggal" => $nextYear.$nextMonth.'01',
				"kodeAkun" => $kodeAkunKewajiban,
				"kredit" => $saldoKewajiban,
				"posisi" => 'K',
				"keterangan" => "SALDO AWAL",
				"slug" => "SALDOAWAL" 
			);
		}

		$this->modelTutupBuku->simpanJurnalAwal($dataKewajibanArray);

		$this->load->model("modelLaporanPerubahanModal");

		$modal = $this->modelLaporanPerubahanModal->totalModal($bulan,$tahun);
        $totalPendapatan = $this->modelLaporanPerubahanModal->totalPendapatan($bulan,$tahun);
        $totalBeban = $this->modelLaporanPerubahanModal->totalBeban($bulan,$tahun);
        $hpp = $this->modelLaporanPerubahanModal->totalHPP($bulan,$tahun);
        $prive = $this->modelLaporanPerubahanModal->totalPrive($bulan,$tahun);

        $pendapatanBersih = $totalPendapatan-$totalBeban-$hpp;
		$modalAkhir = $modal+$pendapatanBersih-$prive;
		
		$dataSaldoAwalModal[] = array(
			"noJurnal" => $noJurnal,
			"noReferrence" => "SALDOAWAL".$nextYear.$nextMonth,
			"tanggal" => $nextYear.$nextMonth.'01',
			"kodeAkun" => '3101',
			"kredit" => $modalAkhir,
			"posisi" => 'K',
			"keterangan" => "SALDO AWAL",
			"slug" => "SALDOAWAL"
		);

		$this->modelTutupBuku->simpanJurnalAwal($dataSaldoAwalModal);

		$historicalBalancing = $this->modelNeracaSaldo->historicalBalancing($bulan,$tahun);

		if($historicalBalancing > 0){
	
			$dataSaldoAwalHB[] = array(
				"noJurnal" => $noJurnal,
				"noReferrence" => "SALDOAWAL".$nextYear.$nextMonth,
				"tanggal" => $nextYear."-".$nextMonth."-"."01",
				"kodeAkun" => '3103',
				"kredit" => $historicalBalancing,
				"posisi" => 'K',
				"keterangan" => "SALDO AWAL",
				"slug" => "SALDOAWAL"
			);

			$this->modelTutupBuku->simpanJurnalAwal($dataSaldoAwalHB);
		}
	}

	function pindahkanSaldoAwalBarangKartuStok($bulan,$tahun){
		if($bulan != 12){
            $nextMonth = sprintf('%02d',$bulan+1);
            $nextYear = $tahun;
        } else {
            $nextMonth = '01';
            $nextYear = $tahun+1;
		}
		
		$dataStok = $this->modelTutupBuku->viewDataStok();

		foreach($dataStok as $row){
			$dataArray[] = array(
				"noRefference" => "STOKAWAL",
				"tanggal" => $nextYear."-".$nextMonth."-"."01",
				"idUser" => $this->global['idUser'],
				"idProduk" => $row->id_produk,
				"currentStok" => '',
				"barangMasuk" => $row->stok,
				"barangKeluar" => '',
				"hargaSatuan" => $row->hpp,
				"jenisTrx" => "STOKAWAL",
				"type" => "GUDANG"
			);
		}

		$this->modelTutupBuku->insertKartuStok($dataArray);
	}
}