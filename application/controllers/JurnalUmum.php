<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class JurnalUmum extends BaseController{
	function __construct(){
		parent::__construct();
		$this->load->model("modelJurnalUmum");
		$this->isLoggedIn($this->global['idUser'],2,37);
    }

    function index(){
        $this->global['pageTitle'] = "SIMRS - Jurnal Umum";
        $data['viewHeadAccount'] = $this->db->get("coa")->result();
		$this->loadViews("keuangan/jurnalumum/bodyJurnalUmum",$this->global,$data,"keuangan/jurnalumum/footerJurnalUmum");
    }

    function addTempJurnal(){
        $kodeAkun = $this->input->post("kodeAkun");

        $dataArray = array(
            "idUser" => $this->global['idUser'],
            "kodeAkun" => $kodeAkun,
            "debit" => '',
            "kredit" => '',
            "deskripsi" => ''
        );

        $this->modelJurnalUmum->addTempJurnal($dataArray);
    }

    function viewJurnal(){
        $idUser = $this->global['idUser'];
        $data['viewJurnal'] = $this->modelJurnalUmum->viewJurnalTemp($idUser);
        $this->load->view("keuangan/jurnalumum/viewJurnalTemp",$data);
    }

    function updateDebit(){
        $kodeAkun = $this->input->post("kodeAkun");
        $value = $this->input->post("value");

        $dataUpdate = array(
            "debit" => $value
        );

        $this->modelJurnalUmum->updateJurnalTemp($dataUpdate,$kodeAkun);
    }

    function updateKredit(){
        $kodeAkun = $this->input->post("kodeAkun");
        $value = $this->input->post("value");

        $dataUpdate = array(
            "kredit" => $value
        );

        $this->modelJurnalUmum->updateJurnalTemp($dataUpdate,$kodeAkun);
    }

    function updateDeskripsi(){
        $kodeAkun = $this->input->post("kodeAkun");
        $value = $this->input->post("value");

        $dataUpdate = array(
            "deskripsi" => $value
        );

        $this->modelJurnalUmum->updateJurnalTemp($dataUpdate,$kodeAkun);
    }

    function hapusAkun(){
        $kodeAkun = $this->input->post("kodeAkun");
        $this->modelJurnalUmum->hapusAkun($kodeAkun);
    }

    function submitJurnal(){
        $idUser = $this->global['idUser'];
        $cekUrutanJurnalHead = $this->modelJurnalUmum->urutanJurnalHead();
        $noHeadJurnal = "JURNUM".date('dmy').sprintf('%04d',$cekUrutanJurnalHead+1);

        $dataArray = array(
            "noJurnalUmum" => $noHeadJurnal,
            "tanggal" => date('Y-m-d H:i:s'),
            "idUser" => $idUser
         );

         $this->modelJurnalUmum->insertHeadJurnal($dataArray);

         $this->load->model("modelTrxJurnal");
         $urutanNoJurnal = $this->modelTrxJurnal->noJurnal();
         $noJurnal = "JURN".date('ymd').sprintf('%04d',$urutanNoJurnal+1);

         //insert trx jurnal
         $viewJurnalTemp = $this->modelJurnalUmum->viewJurnalTemp($idUser);

         foreach($viewJurnalTemp->result() as $row){
            $dataJurnal[] = array(
                "noJurnal" => $noJurnal,
                "noReferrence" => $noHeadJurnal,
                "tanggal" => date('Y-m-d'),
                "kodeAkun" => $row->kodeSubAkun,
                "debit" => $row->debit,
                "kredit" => $row->kredit,
                "keterangan" => $row->deskripsi
            );

            //CEK APA KODE AKUN TERMASUK DARI HARTA

            $cekKodeAkun = $this->modelJurnalUmum->cekKodeAkun($row->kodeSubAkun)."<br>";

            if($cekKodeAkun > 0){
                $this->modelJurnalUmum->updateSaldo($row->kodeSubAkun,$row->debit,$row->kredit);
            }
         }

         $this->modelJurnalUmum->insertBatchJurnalUmum($dataJurnal);

         //delete jurnal temp
         $this->modelJurnalUmum->hapusJurnalTemp($idUser);

         echo $this->enkripsi($noHeadJurnal);
    }

    function printJurnal(){
        $this->global['pageTitle'] = "SIMRS - Print Jurnal";
        $noHeadJurnal = $this->dekripsi($this->uri->segment(3));
        $data['header'] = $this->db->get_where("kl_klinikinfo",array("id" => 1))->row();
        $data['headerJurnal'] = $this->db->get_where("jurnal_umum_head",array("noJurnalUmum" => $noHeadJurnal))->row();
        $data['jurnal'] = $this->modelJurnalUmum->getJurnalPerNumber($noHeadJurnal);
        $this->loadViews("keuangan/jurnalumum/printJurnal",$this->global,$data,"footer_empty");
    }
}