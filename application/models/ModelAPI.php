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
         $sql .= " order by ms.nim";
        
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

    function cekPasien($nim){
        $sql = "select nomor from kl_pasien where nomor = '$nim'";
        return $this->db->query($sql)->row();
    }



	

}