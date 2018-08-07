<?php
Class Mlogin extends CI_Model{
	function login($userid, $password){
		$this->db->from('tbluser');
		$this->db->where('userid', $userid);
		$this->db->where('password', $password);
		$this->db->limit(1);
		$sql = $this->db->get();
		if($sql->num_rows()==1){
			return $sql;
		}
		else{
			return false;
		}
	}
	function cek(){
		@$userid = $_SESSION['userid'];
		@$userlevel = $_SESSION['userlevel'];
		@$username = $_SESSION['username'];
		@$password = $_SESSION['password'];

		$this->db->from('tbluser');
		$this->db->where('userid', $userid);
		$this->db->where('userlevel', $userlevel);
		$this->db->where('username', $username);
		$this->db->where('password', $password);
		
		$this->db->limit(1);
		$sql = $this->db->get();
		if($sql->num_rows()==1){
			return $sql;
		}
		else{
			return false;
		}
	}
}
?>
