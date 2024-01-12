<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include_once APPPATH . '/third_party/fpdf/fpdf.php';
require APPPATH . '/libraries/BaseController.php';

class Item extends BaseController{
	function __construct(){
		parent::__construct();
		$this->load->model('modelItem');
		$this->isLoggedIn($this->global['idUser'],2,39);
	}

	function index(){
		$this->global['pageTitle'] = "SIMRS - Obat / Item";
		$this->loadViews("item/body",$this->global,NULL,"item/footer");
	}

	function viewItem(){
		$this->load->view("item/viewItem");
	}

	function datatable(){
		$draw = $_REQUEST['draw'];
		$length = $_REQUEST['length'];
		$start = $_REQUEST['start'];
		$search = $_REQUEST['search']["value"];

		$total = $this->modelPublic->countRow("ap_produk",NULL);
		$output = array();
		$output['draw']	 = $draw;
		$output['recordsTotal'] = $output['recordsFiltered']=$total;
		$output['data'] = array();

		if($search!=""){
			$query = $this->modelItem->viewItem($length,$start,$search);
			$output['recordsTotal'] = $output['recordsFiltered'] = $query->num_rows();
		} else {
			$query = $this->modelItem->viewItem($length,$start,$search);
		}

		$nomor_urut=$start+1;
		foreach ($query->result_array() as $dt) {
			$encoded = $this->enkripsi($dt['id_produk']);

			$output['data'][]=array(
				$nomor_urut,
				$dt['id_produk'],
				$dt['nama_produk'],
				$dt['kategori'],
				$dt['satuan'],
				$dt['stokMinimal'],
				$dt['stok'],
				number_format($dt['hpp'],'0',',','.'),
				number_format($dt['harga'],'0',',','.'),
				"<a class='edit' id='".$encoded."'><i class='fa fa-pencil'></i></a> <a class='hapus' id='".$encoded."'><i class='fa fa-trash'></i></a>"
			);
			$nomor_urut++;
		}

		echo json_encode($output);
	}

	function formTambah(){
		$data['kategori'] = $this->modelPublic->select("ap_kategori",NULL,NULL,array("kategori" => "ASC"));
		$data['satuan'] = $this->modelPublic->select("satuan",NULL,NULL,array("satuan" => "ASC"));
		$this->load->view("item/formTambah",$data);
	}

	function formEdit(){
		$idProduk = $this->dekripsi($this->input->post("id"));
		$data['kategori'] = $this->modelPublic->select("ap_kategori",NULL,NULL,array("kategori" => "ASC"));
		$data['satuan'] = $this->modelPublic->select("satuan",NULL,NULL,array("satuan" => "ASC"));
		$data['item'] = $this->db->get_where("ap_produk",array("id_produk" => $idProduk))->row();
		$this->load->view("item/formEdit",$data);
	}

	function editSQL(){
		$idProduk = $this->input->post("idProduk");
		$namaItem = $this->input->post("namaItem");
		$kategori = $this->input->post("kategori");
		$satuan = $this->input->post("satuan");
		$stokMinimal = $this->input->post("stokMinimal");
		$hargaBeli = $this->input->post("hargaBeli");
		$hargaJual = $this->input->post("hargaJual");

		$dataUpdate = array(
			"nama_produk" => $namaItem,
			"satuan" => $satuan,
			"hpp" => $hargaBeli,
			"harga" => $hargaJual,
			"id_kategori" => $kategori,
			"stok" => 0,
			"stokMinimal" => $stokMinimal
		);

		$this->modelPublic->update("ap_produk",array("id_produk" => $idProduk),$dataUpdate);
		$this->modelPublic->insertLog($this->global['idUser'],"Mengubah Produk, id : ".$idProduk);
	}	

	function tambahSQL(){
		$idProduk = $this->input->post("idProduk");
		$namaItem = $this->input->post("namaItem");
		$kategori = $this->input->post("kategori");
		$satuan = $this->input->post("satuan");
		$stokMinimal = $this->input->post("stokMinimal");
		$hargaBeli = $this->input->post("hargaBeli");
		$hargaJual = $this->input->post("hargaJual");

		$data = array(
			"id_produk" => $idProduk,
			"nama_produk" => $namaItem,
			"satuan" => $satuan,
			"hpp" => $hargaBeli,
			"harga" => $hargaJual,
			"id_kategori" => $kategori,
			"stok" => 0,
			"stokMinimal" => $stokMinimal
		);

		$this->modelPublic->insert("ap_produk",$data);
		$this->modelPublic->insertLog($this->global['idUser'],"Menambah Produk Baru, Data : ".$namaItem);
	}

	function hapusSQL(){
		$id = $this->dekripsi($this->input->post("id"));
		$this->modelPublic->delete("ap_produk",array("id_produk" => $id));
		$this->modelPublic->insertLog($this->global['idUser'],"Mengapus Produk, id : ".$id);
	}

	function cekKodeExist(){
		$kode = $this->input->post("kode");

		$cek = $this->modelPublic->countRow("ap_produk",array("id_produk" => $kode));

		if($cek > 0){
			echo 0;
		} else {
			echo 1;
		}
	}
}	