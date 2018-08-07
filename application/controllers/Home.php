<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->library('session'); // session_start()
		$this->load->model('mlogin');
		$cek = $this->mlogin->cek();
		if($cek==""){
			redirect("");
			session_destroy();
		}
		date_default_timezone_set("Asia/Jakarta");
		ini_set('memory_limit', '-1');
		$this->load->model('mmenutop');
		$this->load->helper('my_helper');
	}
	
	public function index(){
		$data['sqlmenu'] = $this->mmenutop->get_data();
		$this->load->view('header');
		$this->load->view('navbar',$data);
		//$this->load->view('home/view',$data);
		$this->load->view($_SESSION['dashboard'],$data);
		$this->load->view('footer');
	}
}
