<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include_once APPPATH . '/third_party/fpdf/fpdf.php';
require APPPATH . '/libraries/BaseController.php';

class DataStokExpired extends BaseController{
	function __construct(){
		parent::__construct();
		$this->load->model("modelDataStok");
		$this->isLoggedIn($this->global['idUser'],2,17);
    }

    function index(){
        $this->global['pageTitle'] = "SIMRS - Data Stok Expired";
		$this->loadViews("data_stok/expired/bodyDataExpired",$this->global,NULL,"data_stok/expired/footerDataExpired");
    }

    function viewDatatablesExpired(){
        $data['param'] = $this->input->post("param");
        $this->load->view("data_stok/expired/viewDatatables",$data);
    }

	function buttonExport(){
		$data['param'] = $this->input->post("param");
		$this->load->view("data_stok/expired/buttonExport",$data);
	}

    function datatablesExpiredItem(){
        $param = $_POST['param'];

        if(empty($param)){
            $expiredMax = '';
        } else {
            $expiredMax = $param;
        }
        

        $draw = $_REQUEST['draw'];
		$length = $_REQUEST['length'];
		$start = $_REQUEST['start'];
		$search = $_REQUEST['search']["value"];

		$total = $this->modelDataStok->totalProdukExpired($expiredMax);
		$output = array();
		$output['draw']	 = $draw;
		$output['recordsTotal'] = $output['recordsFiltered']=$total;
		$output['data'] = array();

		if($search!=""){
			$query = $this->modelDataStok->viewExpiredItem($length,$start,$search,$expiredMax);
			$output['recordsTotal'] = $output['recordsFiltered'] = $query->num_rows();
		} else {
			$query = $this->modelDataStok->viewExpiredItem($length,$start,$search,$expiredMax);
		}

		$nomor_urut=$start+1;
		foreach ($query->result_array() as $dt) {
			$output['data'][]=array($nomor_urut,$dt['id_produk'],$dt['nama_produk'],date_format(date_create($dt['expiredDate']),'d M Y'),number_format($dt['hpp'],'0',',','.'),$dt['stok'],$dt['satuan']);
			$nomor_urut++;
		}

		echo json_encode($output);
    }

	function exportExcel(){
		$this->load->library("excel/PHPExcel");

		$objPHPExcel = new PHPExcel();

		$objPHPExcel->getActiveSheet()->setCellValue('A1','No')
									  ->setCellValue('B1','Kode Item')
									  ->setCellValue('C1','Nama Item')
									  ->setCellValue('D1','Tanggal Expired')
									  ->setCellValue('E1','Harga Average')
									  ->setCellValue('F1','Stok')	
									  ->setCellValue('G1','Satuan');	

		$param = $this->input->get("param");

		$dataStok = $this->modelDataStok->viewExpiredItemExport($param);

		$i=2;
		foreach($dataStok as $row){
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$i,$i-1)
									  ->setCellValue('B'.$i,$row->id_produk)
									  ->setCellValue('C'.$i,$row->nama_produk)
									  ->setCellValue('D'.$i,$row->expiredDate)
									  ->setCellValue('E'.$i,$row->hpp)
									  ->setCellValue('F'.$i,$row->stok)
									  ->setCellValue('G'.$i,$row->satuan);
		$i++; }

		//set title pada sheet (me rename nama sheet)
	  	$objPHPExcel->getActiveSheet()->setTitle('Sheet 1');

	    // Set document properties
		$objPHPExcel->getProperties()->setCreator("Rifal")
								->setLastModifiedBy("Rifal")
								->setTitle("TukuWebsite")
								->setSubject("TukuWebsite")
								->setDescription("Export Data")
								->setKeywords("office 2007 openxml php")
								->setCategory("Data SO");
	 
	     //mulai menyimpan excel format xlsx, kalau ingin xls ganti Excel2007 menjadi Excel5          
	    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	 
	   	//sesuaikan headernya 
	    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	   	header("Cache-Control: no-store, no-cache, must-revalidate");
	    header("Cache-Control: post-check=0, pre-check=0", false);
	    header("Pragma: no-cache");
	    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	    //ubah nama file saat diunduh
	    header('Content-Disposition: attachment;filename=DataStokExpired'.date('d/m/y').'.xlsx');
	    //unduh file
	    $objWriter->save("php://output");
	}

	function exportPDF(){
		$pdf = new FPDF('P','mm','A4');

		$pdf->AddPage();
		// setting jenis font yang akan digunakan
        $pdf->SetFont('Arial','B',16);
        // mencetak string 
        $pdf->Cell(190,7,'LAPORAN DATA STOK EXPIRED',0,1,'C');
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(190,7,'Periode '.date('d M Y'),0,1,'C');

        //add space
        $pdf->Cell(10,7,'',0,1);
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(10,6,'No',1,0);
        $pdf->Cell(30,6,'Kode Item',1,0);
        $pdf->Cell(50,6,'Nama Produk',1,0);
        $pdf->Cell(30,6,'Tanggal Expired',1,0);
        $pdf->Cell(30,6,'Harga Average',1,0);
		$pdf->Cell(20,6,'Stok',1,0);
		$pdf->Cell(20,6,'Satuan',1,1);
        $pdf->SetFont('Arial','',10);

		$param = $this->input->get("param");
        $dataStok = $this->modelDataStok->viewExpiredItemExport($param);

        $i=1;
        foreach($dataStok as $row){
        	$pdf->Cell(10,6,$i,1,0);
	        $pdf->Cell(30,6,$row->id_produk,1,0);
	        $pdf->Cell(50,6,$row->nama_produk,1,0);
	        $pdf->Cell(30,6,date_format(date_create($row->expiredDate),'d/m/Y'),1,0);
	        $pdf->Cell(30,6,number_format($row->hpp,'0',',','.'),1,0);
	        $pdf->Cell(20,6,$row->stok,1,0);
	        $pdf->Cell(20,6,$row->satuan,1,1);
        $i++; }

        $pdf->Output();
	}
}