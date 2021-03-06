<?php
Class Mbesuk extends CI_Model{

	function count($where){
		$sql = $this->db->query("SELECT besukid FROM tblbesuk " . $where);
        return $sql;
	}
	function get($where, $sidx, $sord, $limit, $start){
		$sql = $this->db->query("SELECT *,
		DATE_FORMAT(besukdate,'%d-%m-%Y') besukdateview, 
		DATE_FORMAT(modifiedon,'%d-%m-%Y %T') modifiedonview
		FROM tblbesuk " . $where . " ORDER BY $sidx $sord LIMIT $start , $limit");
		return $sql;
	}
	function add($tabel,$data){
		$sql = $this->db->insert($tabel,$data);
	}
	function edit($tabel,$data,$id){
		$query = $this->db->where("besukid",$id);
		$query = $this->db->update($tabel,$data);
	}
	function getwhere($recno){
		$sql = $this->db->query("SELECT *,
		DATE_FORMAT(dob,'%d-%m-%Y') dob, 
		DATE_FORMAT(tglbesuk,'%d-%m-%Y') tglbesuk,
		DATE_FORMAT(baptismdate,'%d-%m-%Y') baptismdate,
		DATE_FORMAT(modifiedon,'%d-%m-%Y %T') modifiedon
		FROM tblmember WHERE recno ='$recno' LIMIT 0,1");
		return $sql;
	}
	function del($tabel,$id){
		$query = $this->db->where("besukid",$id);
		$sql = $this->db->delete($tabel);
		return $sql;
	}
}
?>
