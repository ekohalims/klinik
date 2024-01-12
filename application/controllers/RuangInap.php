<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class RuangInap extends BaseController{
	function __construct(){
		parent::__construct();
        $this->load->model("modelJadwalDokter");
        $this->load->library("form_validation");
		$this->isLoggedIn($this->global['idUser'],2,53);
    }
    
    function index(){
        $this->global['pageTitle'] = "SIMRS - Ruang Inap";
		$this->loadViews("masterdata/ruanginap/body",$this->global,NULL,"masterdata/ruanginap/footer");
    }

    function viewPOSRanap(){
        $data['pos'] = $this->db->get("kl_kategoriruang");
        $this->load->view("masterdata/ruanginap/viewPOSRanap",$data);
    }

    function formPOSRanap(){
        $type = $this->input->post("type");
        $id = $this->input->post("id");
        
        if($type=='tambah'){
            $this->load->view("masterdata/ruanginap/formTambahPOSRanap");
        } else {
            $data['id'] = $id;
            $data['pos'] = $this->db->get_where("kl_kategoriruang",array("idPos" => $id))->row()->pos;
            $this->load->view("masterdata/ruanginap/formEditPOSRanap",$data);
        }
    }

    function formKelasRanap(){
        $type = $this->input->post("type");
        $id = $this->input->post("id");

        if($type=='tambah'){
            $this->load->view("masterdata/ruanginap/formTambahKelasRanap");
        } else {
            $data['id'] = $id;
            $data['kelas'] = $this->db->get_where("kl_kelasruang",array("idKelas" => $id))->row()->kelasruang;
            $this->load->view("masterdata/ruanginap/formEditKelasRanap",$data);
        }
    }

    function POSRanapSQL(){
        $pos = $this->input->post("pos");
        $aksi = $this->input->post("aksi");
        $id = $this->input->post("id");

        if($aksi=='tambah'){
            $this->modelPublic->tambahPOSRanap($pos);
            $this->modelPublic->insertLog($this->global['idUser'],"Menambah POS Ranap, Data : ".$pos);
        } elseif($aksi=='edit') {
            $dataUpdate = array(
                "pos" => $pos
            );

            $this->modelPublic->updatePOSRanap($dataUpdate,$id);
            $this->modelPublic->insertLog($this->global['idUser'],"Mengubah POS Ranap, Data : ".$pos);
        } elseif($aksi=='hapus') {
            $this->modelPublic->deletePOSRanap($id);
        }
    }

    function kelasRanapSQL(){
        $kelas = $this->input->post("kelas");
        $aksi = $this->input->post("aksi");
        $id = $this->input->post("id");

        if($aksi=='tambah'){
            $this->modelPublic->tambahKelasRanap($kelas);
            $this->modelPublic->insertLog($this->global['idUser'],"Menambah Kelas Ranap, Data : ".$kelas);
        } elseif($aksi=='edit') {
            $dataUpdate = array(
                "kelasruang" => $kelas
            );

            $this->modelPublic->updateKelasRanap($dataUpdate,$id);
            $this->modelPublic->insertLog($this->global['idUser'],"Mengubah Kelas Ranap, Data : ".$kelas);
        } elseif($aksi=='hapus') {
            $this->modelPublic->deleteKelasRanap($id);
        }
    }

    function viewKelasRanap(){
        $data['kelas'] = $this->db->get("kl_kelasruang");
        $this->load->view("masterdata/ruanginap/viewKelasRanap",$data);
    }

    function viewRuangInap(){
        $data['ruang'] = $this->modelPublic->viewRuangInap();
        $this->load->view("masterdata/ruanginap/viewGroupRuangan",$data);
    }

    function formRuangInap(){
        $type = $this->input->post("type");
        $id = $this->input->post("id");

        $data['pos'] = $this->db->get("kl_kategoriruang")->result();
        $data['kelas'] = $this->db->get("kl_kelasruang")->result();

        if($type == 'tambah'){
            $this->load->view("masterdata/ruanginap/formTambahRuangInap",$data);
        } else {
            $data['ranap'] = $this->db->get_where("kl_ruanggroup",array("kodeGroup" => $id))->row();
            $this->load->view("masterdata/ruanginap/formEditRuangInap",$data);
        }
    }

    function ruangInapSQL(){
        $id = $this->input->post("id");
        $aksi = $this->input->post("aksi");
        $namaRuang = $this->input->post("namaRuang");
        $pos = $this->input->post("pos");
        $kelas = $this->input->post("kelas");
        $kapasitas = $this->input->post("kapasitas");
        $banyakRuang = $this->input->post("banyakRuang");
        $tarif = $this->input->post("tarif");

        if($aksi=='tambah'){
            $rules = array(
                array(
                    'field' => 'namaRuang',
                    'label' => 'Nama Ruang',
                    'rules' => 'required'
                ),
                array(
                    'field' => 'pos',
                    'label' => 'POS',
                    'rules' => 'required'
                ),
                array(
                    'field' => 'kelas',
                    'label' => 'Kelas',
                    'rules' => 'required'
                ),
                array(
                    'field' => 'tarif',
                    'label' => 'Tarif',
                    'rules' => 'required'
                ),
                array(
                    'field' => 'kapasitas',
                    'label' => 'Kapasitas',
                    'rules' => 'required'
                )
            );

            $this->form_validation->set_rules($rules);

            if($this->form_validation->run() == FALSE){
                echo "error";
            } else {
                $dataArray = array(
                    "namaGroup" => $namaRuang,
                    "idKategori" => $pos,
                    "idKelas" => $kelas,
                    "tarif" => $tarif,
                    "kapasitas" => $kapasitas
                );

                $insert = $this->modelPublic->insertRuang($dataArray);
                echo $insert;

                //insert ruangan
                $this->modelPublic->insertNamaRuang($insert,$banyakRuang,$namaRuang);
                $this->modelPublic->insertLog($this->global['idUser'],"Menambah Ruang Ranap, Data : ".$namaRaung);
            }
        } elseif($aksi=='edit'){
            $rules = array(
                array(
                    'field' => 'namaRuang',
                    'label' => 'Nama Ruang',
                    'rules' => 'required'
                ),
                array(
                    'field' => 'pos',
                    'label' => 'POS',
                    'rules' => 'required'
                ),
                array(
                    'field' => 'kelas',
                    'label' => 'Kelas',
                    'rules' => 'required'
                ),
                array(
                    'field' => 'tarif',
                    'label' => 'Tarif',
                    'rules' => 'required'
                ),
                array(
                    'field' => 'kapasitas',
                    'label' => 'Kapasitas',
                    'rules' => 'required'
                )
            );

            $this->form_validation->set_rules($rules);

            if($this->form_validation->run() == FALSE){
                echo "error";
            } else {
                $dataArray = array(
                    "namaGroup" => $namaRuang,
                    "idKategori" => $pos,
                    "idKelas" => $kelas,
                    "tarif" => $tarif,
                    "kapasitas" => $kapasitas
                );

                $update = $this->modelPublic->updateRuangInap($dataArray,$id);
                echo $id;
                $this->modelPublic->insertLog($this->global['idUser'],"Mengupdate Ruang Inap, Data : ".$namaRujukan);
            }
        } elseif($aksi=='hapus'){
            $this->modelPublic->hapusRuangan($id);
        }
    }

    function formDaftarRuang(){
        $id = $this->input->post("id");
        $data['id'] = $id;
        $data['ruangGroup'] = $this->modelPublic->ruangGroupRow($id);
        $data['daftarRuangGroup'] = $this->modelPublic->daftarRuangGroup($id);
        $this->load->view("masterdata/ruanginap/formDaftarRuang",$data);
    }

    function updateDaftarRuang(){
        $count = count($_POST['kodeRuang']);

        for($i=0;$i<$count;$i++){
            $kodeRuang = $_POST['kodeRuang'][$i];
            $namaRuang = $_POST['namaRuang'][$i];
            $status = $_POST['status'.$kodeRuang];

            $dataUpdate[] = array(
                "kodeRuang" => $kodeRuang,
                "namaRuang" => $namaRuang,
                "status" => $status
            );
        }

        $this->modelPublic->updateBatchRuang($dataUpdate);
    }
}