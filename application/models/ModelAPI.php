<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ModelAPI extends CI_Model {

    public function __construct()
	{
		$this->db_server = $this->load->database('server', true);
	}
    
	public function getDataMahasiswa() {
		$curl_handle = curl_init();
		$url	 = 'http://172.26.80.234/tpa/index.php/API/MhsApi?id=871983273981723674364193593854759273948327582936598357698237529';
		curl_setopt($curl_handle, CURLOPT_URL, $url);
		curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
		$curl_data = curl_exec($curl_handle);
		//echo curl_errno($curl_handle);
		//echo curl_error($curl_handle);
		curl_close($curl_handle);
		$response_data = json_decode($curl_data);
		
		return $response_data;
		
	}
	
	public function getDataTendik() {
		$curl_handle = curl_init();
		$url	 = 'http://172.26.80.234/tpa/index.php/API/SdmApi?id=871983273981723674364193593854759273948327582936598357698237529';
		curl_setopt($curl_handle, CURLOPT_URL, $url);
		curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
		$curl_data = curl_exec($curl_handle);
		//echo curl_errno($curl_handle);
		//echo curl_error($curl_handle);
		curl_close($curl_handle);
		$response_data = json_decode($curl_data);
		
		return $response_data;
		
	}

    function dataMhs($nim = NULL){
		$sql = "SELECT ms.nim, ms.nama, ms.sex, ms.hp, ms.email, ms.tmplahir, ms.tgllahir,
        ms.alamat, lv_agama.namaagama, ms.nik, lv_statusnikah.namastatus, lv_statusmhs.namastatus AS statussemester, ms_unit.namaunit, ms_unit.kodeunit 
        FROM akademik.ms_mahasiswa ms
        INNER JOIN akademik.lv_agama ON ms.kodeagama = lv_agama.kodeagama 
        INNER JOIN akademik.lv_statusnikah ON ms.statusnikah = lv_statusnikah.statusnikah 
        INNER JOIN akademik.lv_statusmhs ON ms.statusmhs = lv_statusmhs.statusmhs 
        INNER JOIN gate.ms_unit ON ms.kodeunit = gate.ms_unit.kodeunit 
        where ms.statusmhs in ('A','X','N')";
        if(!empty($nim)){
            $sql .= " and ms.nim = '$nim' ";
        }
         $sql .= " order by ms.nim asc";
        
		return $this->db_server->query($sql);
	}

    function viewMhsDatatables($limit,$start,$search){
		$this->db_server->select(array("ms.nim", "ms.nama", "ms.sex", "ms.hp", "ms.email", "ms.tmplahir", "ms.tgllahir",
        "ms.alamat", "lv_agama.namaagama", "ms.nik", "lv_statusnikah.namastatus", "lv_statusmhs.namastatus AS statussemester", "ms_unit.namaunit", "ms_unit.kodeunit"));
		$this->db_server->from("akademik.ms_mahasiswa ms");
		$this->db_server->join("akademik.lv_agama","ms.kodeagama = lv_agama.kodeagama","inner");
		$this->db_server->join("akademik.lv_statusnikah","ms.statusnikah = lv_statusnikah.statusnikah ","inner");
		$this->db_server->join("akademik.lv_statusmhs","ms.statusmhs = lv_statusmhs.statusmhs","inner");
		$this->db_server->join("gate.ms_unit","ms.kodeunit = gate.ms_unit.kodeunit","inner");
        $where = "ms.statusmhs in ('A','X','N')";
        $this->db_server->where($where);

		if(!empty($search)){
			$this->db_server->like("ms.nim",$search);
			$this->db_server->or_like("ms.nama",$search);
			$this->db_server->or_like("ms.hp",$search);
		}

		$this->db_server->limit($limit,$start);

		return $this->db_server->get();
	}
    
    function dataTendik($npp = NULL){
		$sql = "SELECT dt_ketenagaan.npp, dt_ketenagaan.nama, dt_ketenagaan.nik, dt_ketenagaan.jenis_kelamin, dt_ketenagaan.email, dt_ketenagaan.hp, dt_ketenagaan.tempat_lahir,
        dt_ketenagaan.tanggal_lahir, dt_ketenagaan.agama, dt_ketenagaan.st_pegawai, dt_ketenagaan.st_dosen, dt_ketenagaan.alamat_domisili, dt_ketenagaan.rt, dt_ketenagaan.rw, 
        dt_ketenagaan.kecamatan, dt_ketenagaan.kelurahan, dt_ketenagaan.kota, dt_ketenagaan.alamat, dt_ketenagaan.st_keluarga FROM ketenagaan.dt_ketenagaan 
        WHERE del ='N' and st_pegawai in ('Tetap','Kontrak','')";
        if(!empty($npp)){
            $sql .= " and dt_ketenagaan.npp = '$npp' ";
        }
         $sql .= " order by dt_ketenagaan.npp asc";
        
		return $this->db_server->query($sql);
	}

    function viewTendikDatatables($limit,$start,$search){
		$this->db_server->select(array("dt_ketenagaan.npp", "dt_ketenagaan.nama", "dt_ketenagaan.nik", "dt_ketenagaan.jenis_kelamin", "dt_ketenagaan.email", "dt_ketenagaan.hp", "dt_ketenagaan.tempat_lahir",
        "dt_ketenagaan.tanggal_lahir", "dt_ketenagaan.agama", "dt_ketenagaan.st_pegawai", "dt_ketenagaan.st_dosen", "dt_ketenagaan.alamat_domisili", "dt_ketenagaan.rt", "dt_ketenagaan.rw", 
        "dt_ketenagaan.kecamatan", "dt_ketenagaan.kelurahan", "dt_ketenagaan.kota", "dt_ketenagaan.alamat", "dt_ketenagaan.st_keluarga"));
        $where = "del ='N' and st_pegawai in ('Tetap','Kontrak','')";
        $this->db_server->where($where);

		if(!empty($search)){
			$this->db_server->like("dt_ketenagaan.npp",$search);
			$this->db_server->or_like("dt_ketenagaan.nama",$search);
			$this->db_server->or_like("dt_ketenagaan.nik",$search);
		}

		$this->db_server->limit($limit,$start);

		return $this->db_server->get();
	}

    function cekPasien($nim){
        $sql = "select nomor from kl_pasien where nomor = '$nim'";
        return $this->db->query($sql)->row();
    }



	

}