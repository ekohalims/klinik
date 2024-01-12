<?php 
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class BaseController extends CI_Controller {
	protected $global = array ();
	
	/**
	 * Takes mixed data and optionally a status code, then creates the response
	 *
	 * @access public
	 * @param array|NULL $data
	 *        	Data to output to the user
	 *        	running the script; otherwise, exit
	 */
	/**
     * This function used to load views
     * @param {string} $viewName : This is view name
     * @param {mixed} $headerInfo : This is array of header information
     * @param {mixed} $pageInfo : This is array of page information
     * @param {mixed} $footerInfo : This is array of footer information
     * @return {null} $result : null
     */

	function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->library('ion_auth');
		$this->load->model('model1');
		$idUser = $this->ion_auth->user()->row()->id;
		$this->global['navigation'] = $this->model1->callNavigation();
		$this->global['permitAccess'] = $this->model1->permitAccess($idUser);
		$this->global['permitAccessSub'] = $this->model1->permitAccessSub($idUser);
		$this->global['idUser'] = $idUser;
		$this->global['footer'] = $this->model1->footertext();
	}

	/**
	 * This function is used to load the set of views
	 */
	function accessDenied(){
		$this->global ['pageTitle'] = 'SIM RS- Access Denied';

		$this->global['navigation'] = $this->model1->callNavigation();
		
		$this->load->view ('navigation', $this->global);
		$this->load->view ('access_denied');
		$this->load->view ('footer_empty');
	}

	/**
	 * This function is used to logged out user from system
	 */

	/**
	 * This function used to check the user is logged in or not
	 */
	function isLoggedIn($idUser,$type,$code){
		if (!$this->ion_auth->logged_in()){	
			redirect("login");
		} else {
			$cekMyAccess = $this->model1->cekMyAccess($idUser,$type,$code);
			if($cekMyAccess < 1){
				$this->accessDenied();
			}
		}
	}

    function loadViews($viewName = "", $headerInfo = NULL, $pageInfo = NULL, $footerName = ""){
    	
        $this->load->view('navigation',$headerInfo);
        $this->load->view($viewName, $pageInfo);
        $this->load->view($footerName);
    }

    function permitAccess(){
    	$idUser = $this->ion_auth->user()->row()->id;
    	return $this->model1->permitAccess($idUser);
    }
	
	function logout() {
		$this->session->sess_destroy ();

		redirect ( 'login' );
	}

	function dekripsi($value){
		$nilai = strtr($value,array('.' => '+', '-' => '=', '~' => '/'));
		$decoded = $this->encryption->decrypt($nilai);
		return $decoded;
	}

	function enkripsi($value){
		$nilai = $this->encryption->encrypt($value);
		$encoded = strtr($nilai,array('+' => '.', '=' => '-', '/' => '~'));
		return $encoded;
	}

	function hitungUmur($tanggal_lahir) {
	    list($year,$month,$day) = explode("-",$tanggal_lahir);
	    $year_diff  = date("Y") - $year;
	    $month_diff = date("m") - $month;
	    $day_diff   = date("d") - $day;
	    if ($month_diff < 0) $year_diff--;
	        elseif (($month_diff==0) && ($day_diff < 0)) $year_diff--;
	    return $year_diff;
	}

	function convertDate($format,$value){
		if($format=='dmyhi'){
			$convert = date_format(date_create($value),'d M Y H:i');
		} elseif($format=='dmy'){
			$convert = date_format(date_create($value),'d M Y');
		}

		return $convert;
	}

	function penyebut($nilai) {
		$nilai = abs($nilai);
		$huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
		$temp = "";
		if ($nilai < 12) {
			$temp = " ". $huruf[$nilai];
		} else if ($nilai <20) {
			$temp = $this->penyebut($nilai - 10). " belas";
		} else if ($nilai < 100) {
			$temp = $this->penyebut($nilai/10)." puluh". $this->penyebut($nilai % 10);
		} else if ($nilai < 200) {
			$temp = " seratus" . $this->penyebut($nilai - 100);
		} else if ($nilai < 1000) {
			$temp = $this->penyebut($nilai/100) . " ratus" . $this->penyebut($nilai % 100);
		} else if ($nilai < 2000) {
			$temp = " seribu" . $this->penyebut($nilai - 1000);
		} else if ($nilai < 1000000) {
			$temp = $this->penyebut($nilai/1000) . " ribu" . $this->penyebut($nilai % 1000);
		} else if ($nilai < 1000000000) {
			$temp = $this->penyebut($nilai/1000000) . " juta" . $this->penyebut($nilai % 1000000);
		} else if ($nilai < 1000000000000) {
			$temp = $this->penyebut($nilai/1000000000) . " milyar" . $this->penyebut(fmod($nilai,1000000000));
		} else if ($nilai < 1000000000000000) {
			$temp = $this->penyebut($nilai/1000000000000) . " trilyun" . $this->penyebut(fmod($nilai,1000000000000));
		}     
		return $temp;
	}
 
	function terbilang($nilai) {
		if($nilai<0) {
			$hasil = "minus ". trim($this->$this->penyebut($nilai));
		} else {
			$hasil = trim($this->penyebut($nilai));
		}     		
		return $hasil;
	}

}
