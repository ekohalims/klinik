<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Bahan_masuk extends BaseController{
	function __construct(){
		parent::__construct();
		$this->load->model("modelBahanMasukMaterial");
		$this->isLoggedIn($this->global['idUser'],2,17);
	}

	function index(){
		$data['supplier'] = $this->db->get("supplier")->result();
		$this->global['pageTitle'] = "SIMRS - Barang Masuk";
		$this->loadViews("bahan_masuk/body_bahan_masuk",$this->global,$data,"bahan_masuk/footerBahanMasuk");
	}

	function POFilter(){
		$data['tanggalPO'] = $_POST['tanggalPO'];
		$data['tanggalKirim'] = $_POST['tanggalKirim'];
		$data['supplier'] = $_POST['supplier'];
		$data['status'] = $_POST['status'];

		$this->load->view("bahan_masuk/POFilter",$data);
	}

	function datatablesPO(){
		$draw = $_REQUEST['draw'];
		$length = $_REQUEST['length'];
		$start = $_REQUEST['start'];
		$search = $_REQUEST['search']["value"];

		$total = $this->modelBahanMasukMaterial->totalPOProduk();
		$output = array();
		$output['draw']	= $draw;
		$output['recordsTotal'] = $output['recordsFiltered']=$total;
		$output['data'] = array();

		if($search!=""){
			$query = $this->modelBahanMasukMaterial->viewPOProduk($length,$start,$search);
			$output['recordsTotal'] = $output['recordsFiltered'] = $query->num_rows();
		} else {
			$query = $this->modelBahanMasukMaterial->viewPOProduk($length,$start,$search);
		}

		$nomor_urut=$start+1;
		foreach ($query->result_array() as $dt) {
			$status = $dt['status'];

			if($status==0){
				$button = '<a href="'.base_url('bahan_masuk/good_receipt?no_po='.$dt['no_po']).'"><span class="label label-primary">Menunggu Approve</span></a>';
			} elseif($status==1){
				$button = '<a href="'.base_url('bahan_masuk/good_receipt?no_po='.$dt['no_po']).'"><span class="label label-success">Diterima</span></a>';
			} elseif($status==2){
				$button = '<a href="'.base_url('bahan_masuk/good_receipt?no_po='.$dt['no_po']).'"><span class="label label-danger">Ditolak</span></a>';
			} elseif($status==3){
				$button = '<a href="'.base_url('bahan_masuk/good_receipt?no_po='.$dt['no_po']).'"><span class="label label-info">Selesai</span></a>';
			}

			$output['data'][]=array($nomor_urut,"<a href='#'>".$dt['no_po']."</a>",$dt['tanggal_po'],$dt['tanggal_kirim'],$dt['supplier'],$dt['first_name'],$button);
			$nomor_urut++;
		}

		echo json_encode($output);
	}

	function datatablesPOFilter(){
		$tanggalPO = $_POST['tanggalPO'];
		$tanggalKirim = $_POST['tanggalKirim'];
		$supplier = $_POST['supplier'];
		$status = $_POST['status'];

		$draw 		= $_REQUEST['draw'];
		$length 	= $_REQUEST['length'];
		$start 		= $_REQUEST['start'];
		$search 	= $_REQUEST['search']["value"];

		$total 			 			= $this->modelBahanMasukMaterial->totalPOProdukFilter($tanggalPO,$tanggalKirim,$supplier,$status);
		$output 					= array();
		$output['draw']	 			= $draw;
		$output['recordsTotal'] 	= $output['recordsFiltered']=$total;
		$output['data'] 			= array();

		if($search!=""){
			$query = $this->modelBahanMasukMaterial->viewPOProdukFilter($length,$start,$search,$tanggalPO,$tanggalKirim,$supplier,$status);
			$output['recordsTotal'] = $output['recordsFiltered'] = $query->num_rows();
		} else {
			$query = $this->modelBahanMasukMaterial->viewPOProdukFilter($length,$start,$search,$tanggalPO,$tanggalKirim,$supplier,$status);
		}

		$nomor_urut=$start+1;
		foreach ($query->result_array() as $dt) {
			$status = $dt['status'];

			if($status==0){
				$button = '<a href="'.base_url('bahan_masuk/good_receipt?no_po='.$dt['no_po']).'"><span class="label label-primary">Menunggu Approve</span></a>';
			} elseif($status==1){
				$button = '<a href="'.base_url('bahan_masuk/good_receipt?no_po='.$dt['no_po']).'"><span class="label label-success">Diterima</span></a>';
			} elseif($status==2){
				$button = '<a href="'.base_url('bahan_masuk/good_receipt?no_po='.$dt['no_po']).'"><span class="label label-danger">Ditolak</span></a>';
			} elseif($status==3){
				$button = '<a href="'.base_url('bahan_masuk/good_receipt?no_po='.$dt['no_po']).'"><span class="label label-info">Selesai</span></a>';
			}

			$output['data'][]=array($nomor_urut,"<a href='#'>".$dt['no_po']."</a>",$dt['tanggal_po'],$dt['tanggal_kirim'],$dt['supplier'],$dt['first_name'],$button);
			$nomor_urut++;
		}

		echo json_encode($output);
	}

	function change_po_status(){
		$status 		= $_GET['status'];
		$no_po 	 		= $_GET['no_po'];

		$data_update = array(
								"status"	=> $status
							);

		$this->modelBahanMasukMaterial->changePOStatus($no_po,$data_update);
		redirect("bahan_masuk/good_receipt?no_po=".$no_po);
	}

	function prosesReceiveItem(){
		$id_user = sprintf("%03d",$this->global['idUser']);
		$received_by = $_POST['diterimaOleh'];
		$checked_by = $_POST['diperiksaOleh'];
		$tanggal_terima = $_POST['tanggalTerima'];
		$no_po = $_POST['noPO'];
		$id_supplier = $_POST['idSupplier'];
		$diterimaDi = $_POST['diterimaDi'];

		$cek_terima = $this->modelBahanMasukMaterial->cekTanggalReceive($tanggal_terima);

		$create_date = date_create($tanggal_terima);
		$convert_date = date_format($create_date,'y').date_format($create_date,'m').date_format($create_date,'d');

		$no_inv = 'RCV'.$convert_date.$id_user.sprintf("%03d",$cek_terima+1);


		$data_receive = array(
			"no_receive" => $no_inv,
			"no_po"	=> $no_po,
			"received_by" => $received_by,
			"checked_by" => $checked_by,
			"tanggal_terima" => $tanggal_terima,
			"id_pic" => $this->global['idUser'],
			"id_supplier" => $id_supplier,
			"diterimaDi" => $diterimaDi
		);

		$this->modelBahanMasukMaterial->insertReceiveOrder($data_receive);

		$count = count($_POST['qty']);
		for($i=0;$i<$count;$i++){
			$sku = $_POST['id'][$i];
			$qty = $_POST['qty'][$i];
			$price = $this->modelBahanMasukMaterial->hargaBeli($sku,$no_po);
			$tanggalExpired = $_POST['tanggalExpired'][$i];
			$batchNo = $_POST['noBatch'][$i];

			$data_insert[] = array(
				"no_receive" => $no_inv,
				"sku" => $sku,
				"qty" => $qty,
				"price" => $price,
				"tanggal" => $tanggal_terima,
				"expiredDate" => $tanggalExpired
			);

			//insert stok produk yang memiliki tanggal expired
			if(!empty($tanggalExpired)){
				//cek if stok produk exp exist before
				$cekExpProduk = $this->modelBahanMasukMaterial->cekExpProduk($sku,$tanggalExpired);

				if($cekExpProduk > 0){
					$currentStokExp = $this->modelBahanMasukMaterial->currentStokExpired($sku,$tanggalExpired);
					
					$dataUpdateStokExp = array(
						"stok" => $currentStokExp+$qty
					);

					$this->modelBahanMasukMaterial->updateStokExp($dataUpdateStokExp,$sku,$tanggalExpired);
				} else {
					$dataExpStok = array(
						"id_produk" => $sku,
						"expiredDate" => $tanggalExpired,
						"stok" => $qty
					);

					$this->modelBahanMasukMaterial->insertStokExp($dataExpStok);
				}
			}

			if(!empty($batchNo)){
				$batchNumRows = $this->modelPublic->countRow("ap_produk_batch",array("noBatch" => $batchNo,"id_produk" => $sku));

				if($batchNumRows > 0){
					$currentBatchStok = $this->modelPublic->getValueOfTable("ap_produk_batch","qty",
						array(
							"id_produk" => $sku,
							"noBatch" => $batchNo
						)
					);

					$dataUpdateBatchNo = array(
						"qty" => $currentBatchStok+$QTY
					);

					$this->modelPublic->update("ap_produk_batch",
						array(
							"id_produk" => $sku,
							"noBatch" => $batchNo
						),$dataUpdateBatchNo
					);
				} else {
					$dataArray = array(
						"id_produk" => $sku,
						"noBatch" => $batchNo,
						"qty" => $qty
					);

					$this->modelPublic->insert("ap_produk_batch",$dataArray);
				}
			}

			//stok lama produk
			$currentStokGudang = $this->modelPublic->currentStokGudang($sku);

			$data_stok[] = array(
				"id_produk" => $sku,
				"stok"	=> $currentStokGudang+$qty
			);

			//sisipkan kartu stok gudang
			$dataKartuStok[] = array(
				"noRefference" => $no_inv,
				"tanggal" => date('Y-m-d'),
				"idUser" => $this->global['idUser'],
				"idProduk" => $sku,
				"currentStok" => $currentStokGudang,
				"barangMasuk" => $qty,
				"hargaSatuan" => $price,
				"jenisTrx" => 'PENERIMAAN',
				"type" => 'GUDANG',
				"noBatch" => $batchNo,
				"tanggalExpired" => $tanggalExpired,
				"supplier" => $id_supplier
			);

			//cek apakah sudah ada penerimaan sebelumnya 
			$cekPenerimaan = $this->modelBahanMasukMaterial->cekPenerimaan($sku);

			if($cekPenerimaan > 0){
				$rpMasuk = $this->modelBahanMasukMaterial->rpMasuk($sku);
				$rpKeluar = $this->modelBahanMasukMaterial->rpKeluar($sku);
				$qtyMasuk = $this->modelBahanMasukMaterial->qtyMasuk($sku);
				$qtyKeluar = $this->modelBahanMasukMaterial->qtyKeluar($sku);

				$hargaAverage = (($rpMasuk+$qty*$price)-$rpKeluar)/($qtyMasuk+$qty-$qtyKeluar);
				
				//update harga average
				$dataHargaAverage[] = array(
					"id_produk" => $sku,
					"hpp" => $hargaAverage
				);

				$hargaAverage;
			} else {
				$hargaAverage = ($price*$qty)/$qty;
				
				//update harga average
				$dataHargaAverage[] = array(
					"id_produk" => $sku,
					"hpp" => $hargaAverage
				);
			}
		}
		
		$this->modelBahanMasukMaterial->penerimaanGudang($data_stok);
		$this->modelBahanMasukMaterial->insertBatchReceiveItem($data_insert);
		$this->modelBahanMasukMaterial->updateHargaAverage($dataHargaAverage);
		$this->modelPublic->insertKartuStok($dataKartuStok);
		
		//PROSES PENERBITAN HUTANG
		//SET INSERT HUTANG 
		//cek if exist
		$cek_penerbitan_hutang = $this->modelBahanMasukMaterial->cek_penerbitan_hutang($no_po);

		if($cek_penerbitan_hutang < 1){
			$data_tagihan = array(
									"no_tagihan"		=> $no_po,
									"status_hutang" 	=> 0
								 );

			$this->modelBahanMasukMaterial->terbitkanStatusHutang($data_tagihan);
		}

		//proses penyisipan jurnal 

		$this->load->model("modelTrxJurnal");

		$akunDebit = '1401';
		$akunKredit = '2101';
		$keterangan ='Penerimaan Barang No Receive '.$no_inv;
		$value = $this->modelBahanMasukMaterial->hutangSesuaiBarangYangDiterima($no_inv);
		$this->modelTrxJurnal->insertJurnal($no_inv,$akunDebit,$akunKredit,$keterangan,$value);
		
		echo $no_inv;
	}

	function good_receipt(){
		$no_po 	= $_GET['no_po'];
		$data['header'] = $this->db->get_where("kl_klinikinfo",array("id" => 1))->row();
		$data['purchase_item'] = $this->modelBahanMasukMaterial->purchase_item($no_po);
		$data['received_invoice'] = $this->modelBahanMasukMaterial->received_invoice($no_po);
		$data['noteInfo'] = $this->modelBahanMasukMaterial->noteInfoPO($no_po);

		$this->global['pageTitle'] = "SIMRS - Goods Receipt";
		$this->loadViews("bahan_masuk/body_good_receipt",$this->global,$data,"bahan_masuk/footerBarangMasuk");
	}

	function invoice_receive(){
		$data['header'] = $this->db->get_where("kl_klinikinfo",array("id" => 1))->row();
		$no_receive = $_GET['no_receive'];
		$data['dataReceive'] = $this->modelBahanMasukMaterial->dataReceive($no_receive);
		$data['receive_item'] = $this->modelBahanMasukMaterial->received_item($no_receive);

		$this->global['pageTitle'] = "SIMRS - Invoice Penerimaan";
		$this->loadViews("bahan_masuk/body_invoice_receive",$this->global,$data,"footer_empty");
	}

	function detailOrder(){
		$no_po = $_POST['noPo'];
		$data['no_po'] = $no_po;
		$data['purchase_item'] = $this->modelBahanMasukMaterial->purchase_item($no_po);
		$this->load->view("bahan_masuk/detailOrder",$data);
	}

	function invoiceReceive(){
		$no_po 	= $_POST['noPo'];
		$data['received_invoice'] = $this->modelBahanMasukMaterial->received_invoice($no_po);
		$this->load->view("bahan_masuk/invoiceReceive",$data);
	}

	function riwayatPenerimaan(){
		$noPo = $_POST['noPo'];
		$data['riwayatPenerimaan'] = $this->modelBahanMasukMaterial->riwayatPenerimaanProduk($noPo);
		$this->load->view("bahan_masuk/riwayatPenerimaan",$data);
	}

	function qtyReceived(){
		$idProduk 	= $_POST['idProduk'];
		$noPo 		= $_POST['noPo'];

		$qtyReceived = $this->modelBahanMasukMaterial->qtyDiterima($idProduk,$noPo);
		echo $qtyReceived;
	}
}