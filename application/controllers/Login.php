<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct() { 
		parent::__construct(); 
		// $this->load->library('session'); // session_start()
		$this->load->model('mlogin');
		$this->load->library('session');
	}

	public function index(){
		$adminId = $this->session->userdata('userpk');
        if(empty($adminId)){
            $this->load->view('login');
        }else{
            redirect('home');
        }
	}

	public function proses(){
		$userid = $this->input->post('userid');
		$password = md5($this->input->post('password'));
		$cek = $this->mlogin->login($userid,$password);

		if($cek!=""){
			foreach ($cek->result() as $row){
				$_SESSION['userpk']=$row->userpk;
				$_SESSION['userid']=$row->userid;
				$_SESSION['username']=$row->username;
				$_SESSION['userlevel']=$row->userlevel;
				$_SESSION['password']=$row->password;
				$_SESSION['dashboard']=$row->dashboard;
			}			
			redirect("home");
		}
		else{
			$data["error"]="Kombinasi userid Atau Password Salah";
			$this->load->view('login',$data);
			session_destroy();
		}	
	}
}

