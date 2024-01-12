<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class ModelPembatalanTransaksi extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->load->database();
    }

    function totalTransaksiNotCancel(){
        $this->db->from("kl_daftar");
        $this->db->where("status != 3");
        return $this->db->count_all_results();
    }

    function totalTransaksiCancel(){
        $this->db->from("kl_daftar");
        $this->db->where("status",3);
        return $this->db->count_all_results();
    }

    function viewDaftarTransaksi($limit,$start,$search){
        $this->db->select(array("kl_daftar.status","kl_daftar.noPendaftaran","kl_daftar.tanggalDaftar","kl_pasien.namaLengkap","kl_pasien.noPasien","kl_pasien.noID","kl_pasien.kelurahan","kl_pasien.tempatLahir","kl_pasien.tanggalLahir"));
        $this->db->from("kl_daftar");
        $this->db->join("kl_pasien","kl_pasien.noPasien = kl_daftar.idPasien");
        $this->db->where("kl_daftar.status != 3");

        if(!empty($search)){
            $this->db->like("kl_daftar.noPendaftaran",$search);
            $this->db->or_like("kl_pasien.namaLengkap",$search);
        }

        $this->db->limit($limit,$start);
        $this->db->group_by("kl_daftar.noPendaftaran");
        return $this->db->get();
    }

    function viewDaftarTransaksiDibatalkan($limit,$start,$search){
        $this->db->select(array("kl_daftar.status","kl_daftar.noPendaftaran","kl_daftar.tanggalDaftar","kl_pasien.namaLengkap","kl_pasien.noPasien","kl_pasien.noID","kl_pasien.kelurahan","kl_pasien.tempatLahir","kl_pasien.tanggalLahir"));
        $this->db->from("kl_daftar");
        $this->db->join("kl_pasien","kl_pasien.noPasien = kl_daftar.idPasien");
        $this->db->where("kl_daftar.status",3);

        if(!empty($search)){
            $this->db->like("kl_daftar.noPendaftaran",$search);
            $this->db->or_like("kl_pasien.namaLengkap",$search);
        }

        $this->db->limit($limit,$start);
        $this->db->group_by("kl_daftar.noPendaftaran");
        return $this->db->get();
    }

    function dataTransaksi($noPendaftaran){
        $this->db->select(array("kl_daftar.noPendaftaran","kl_daftar.idPasien","kl_pasien.namaLengkap","kl_pasien.tempatLahir","kl_pasien.tanggalLahir","kl_pasien.jenisKelamin","kl_daftar.tanggalDaftar","kl_poliklinik.poliklinik","kl_dokter.nama","kl_daftar.status"));
        $this->db->from("kl_daftar");
        $this->db->join("kl_pasien","kl_pasien.noPasien = kl_daftar.idPasien");
        $this->db->join("kl_poliklinik","kl_poliklinik.id_poliklinik = kl_daftar.idPoliklinik");
        $this->db->join("kl_dokter","kl_dokter.id_dokter = kl_daftar.idDokter");
        $this->db->where("kl_daftar.noPendaftaran",$noPendaftaran);
        $this->db->group_by("kl_daftar.noPendaftaran");
        return $this->db->get()->row();
    }

    function viewTindakan($noPendaftaran,$jenisTrx){
        if($jenisTrx=='RAJAL'){
            $table = "kl_tarifrajal";
        } else {
            $table = "kl_tarifranap";
        }

		$this->db->select(array($table.".namaTarif as namaTindakan","kl_tindakanorder.harga"));
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

    function typeBayar($noPendaftaran){
        $cekInvoiceExist = $this->cekInvoice($noPendaftaran);

        if($cekInvoiceExist < 1){
            $return = "--Belum Melakukan Pembayaran";
        } else {
            $this->db->select(array("ap_payment_type.payment_type","coa_sub.namaSubAkun","kl_invoice.typeBayar"));
            $this->db->from("kl_invoice");
            $this->db->join("ap_payment_type","ap_payment_type.id = kl_invoice.typeBayar","left");
            $this->db->join("coa_sub","coa_sub.kodeSubAkun = kl_invoice.subAccount","left");
            $this->db->where("kl_invoice.noPendaftaran",$noPendaftaran);
            $this->db->group_by("kl_invoice.noPendaftaran");
            $query = $this->db->get()->row();
            $return = $query->payment_type." ".$query->namaSubAkun;
        }
        
        return $return;
    }

    function idPaymentType($noPendaftaran){
        $this->db->select("kl_invoice.typeBayar");
        $this->db->from("kl_invoice");
        $this->db->where("noPendaftaran",$noPendaftaran);
        $query = $this->db->get();

        $numRows = $query->num_rows();

        if($numRows > 0){
            foreach($query->result() as $row){
                return $row->typeBayar;
            }
        } else {
            return NULL;
        }
    }

    function cekInvoice($noPendaftaran){
        $this->db->from("kl_invoice");
        $this->db->where("noPendaftaran",$noPendaftaran);
        return $this->db->count_all_results();
    }

    function statusFarmasi($noPendaftaran){
        $this->db->select("status");
        $this->db->from("kl_resepheader");
        $this->db->where("noPendaftaran",$noPendaftaran);
        $query = $this->db->get()->result();
        foreach($query as $row){
            return $row->status;
        }
    }

    function statusRadiologi($noPendaftaran){
        $this->db->select("status");
        $this->db->from("kl_orderradiologiheader");
        $this->db->where("noPendaftaran",$noPendaftaran);
        $query = $this->db->get()->result();
        foreach($query as $row){
            return $row->status;
        }
    }

    function statusLaboratorium($noPendaftaran){
        $this->db->select("status");
        $this->db->from("kl_orderlabheader");
        $this->db->where("noPendaftaran",$noPendaftaran);
        $query = $this->db->get()->result();
        foreach($query as $row){
            return $row->status;
        }
    }

    function formAkunBayar($kodeAkun){
        $this->db->select(array('coa_sub.kodeSubAkun','coa_sub.namaSubAkun'));
        $this->db->from("coa_sub");
        $this->db->where("kodeAkun",$kodeAkun);
        $this->db->where("isDelete",1);
        $this->db->where("status",1);
        return $this->db->get()->result();
    }

    function saldoAkun($idAkun){
        $this->db->select("saldo");
        $this->db->from("coa_sub");
        $this->db->where("kodeSubAkun",$idAkun);
        $query = $this->db->get()->row();
        return $query->saldo;
    }

    function updateStatusTableDaftar($noPendaftaran,$status){
        $dataUpdate = array(
            "status" => $status
        );

        $this->db->where("noPendaftaran",$noPendaftaran);
        $this->db->update("kl_daftar",$dataUpdate);
    }

    function updateStatusFarmasi($noPendaftaran,$status){
        $dataUpdate = array(
            "status" => $status
        );

        $this->db->where("noPendaftaran",$noPendaftaran);
        $this->db->update("kl_resepheader",$dataUpdate);
    }

    function updateStatusLab($noPendaftaran,$status){
        $dataUpdate = array(
            "status" => $status
        );

        $this->db->where("noPendaftaran",$noPendaftaran);
        $this->db->update("kl_orderlabheader",$dataUpdate);
    }

    function updateStatusRad($noPendaftaran,$status){
        $dataUpdate = array(
            "status" => $status
        );

        $this->db->where("noPendaftaran",$noPendaftaran);
        $this->db->update("kl_orderradiologiheader",$dataUpdate);
    }
}

