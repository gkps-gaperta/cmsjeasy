<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class blood extends CI_Controller {

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
		$this->load->model('mblood');
		$this->load->model('mmenutop');
        $this->load->helper('my_helper');
	}

	function index2(){
		$data['acl'] = $this->hakakses('blood');
		$data['sqlmenu'] = $this->mmenutop->get_data();
		$this->load->view('header');
		$this->load->view('navbar',$data);
		$this->load->view('blood/gridblood');
		$this->load->view('footer');
	}
	function bumi(){
		$data['acl'] = $this->hakakses('blood');
		$data['sqlmenu'] = $this->mmenutop->get_data();
		$this->load->view('partials/header');
		$this->load->view('navbar',$data);
		$this->load->view('blood/gridblood3');
		$this->load->view('partials/footer');
	}
	function index(){
		$data['acl'] = $this->hakakses('blood');
		$data['sqlmenu'] = $this->mmenutop->get_data();
		$this->load->view('partials/header');
		$this->load->view('navbar',$data);
		$this->load->view('blood/gridblood2');
		$this->load->view('partials/footer');
	}
	function grid3(){
		$acl = $this->hakakses('blood');
		$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
		$rows = isset($_GET['rows']) ? intval($_GET['rows']) : 10;
		$sort = isset($_GET['sort']) ? strval($_GET['sort']) : 'bloodid';
		$order = isset($_GET['order']) ? strval($_GET['order']) : 'asc';
		
		$filterRules = isset($_GET['filterRules']) ? ($_GET['filterRules']) : '';
		$cond = '';
		if (!empty($filterRules)){
			$cond = ' where 1=1 ';
			$filterRules = json_decode($filterRules);

			foreach($filterRules as $rule){
				$rule = get_object_vars($rule);
				$field = $rule['field'];
				$op = $rule['op'];
				$value = $rule['value'];
				if (!empty($value)){
					if ($op == 'contains'){
						$cond .= " and ($field like '%$value%')";
					} else if ($op == 'greater'){
						$cond .= " and $field>$value";
					}
				}
			}
		}
		$where='';
		$sql = $this->mblood->count($cond,'tblblood1');
		$total = $sql->num_rows();
		$offset = ($page - 1) * $rows;
		$data = $this->mblood->getM($cond,$sort,$order,$rows,$offset)->result();
		// $total = count($data);
		$response = new stdClass;
		$response->total=$total;
		$response->rows = $data;
		$_SESSION['excel']= "asc|bloodid|";
		echo json_encode($response);
	}
	function grid2(){
		$acl = $this->hakakses('blood');
		$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
		$rows = isset($_GET['rows']) ? intval($_GET['rows']) : 10;
		$sort = isset($_GET['sort']) ? strval($_GET['sort']) : 'bloodid';
		$order = isset($_GET['order']) ? strval($_GET['order']) : 'asc';
		
		$filterRules = isset($_GET['filterRules']) ? ($_GET['filterRules']) : '';
		$cond = '';
		if (!empty($filterRules)){
			$cond = ' where 1=1 ';
			$filterRules = json_decode($filterRules);

			foreach($filterRules as $rule){
				$rule = get_object_vars($rule);
				$field = $rule['field'];
				$op = $rule['op'];
				$value = $rule['value'];
				if (!empty($value)){
					if ($op == 'contains'){
						$cond .= " and ($field like '%$value%')";
					} else if ($op == 'greater'){
						$cond .= " and $field>$value";
					}
				}
			}
		}
		$where='';
		$sql = $this->mblood->count($cond,'tblblood');
		$total = $sql->num_rows();
		$offset = ($page - 1) * $rows;
		$data = $this->mblood->getJ($cond,$sort,$order,$rows,$offset)->result();
		// $total = count($data);
		foreach($data as $row){
			if(substr($acl,0,1)==1){
				$view = '<button class="icon-view_detail" onclick="viewBlood(\''.$row->bloodid.'\')" style="width:16px;height:16px;border:0"></button> ';
				$edit = '<button class="icon-edit" onclick="editBlood(\''.$row->bloodid.'\')" style="width:16px;height:16px;border:0"></button> ';
				$del = '<button class="icon-remove" onclick="deleteBlood(\''.$row->bloodid.'\')" style="width:16px;height:16px;border:0"></button>';

			}
			$row->aksi = $view.$edit.$del;
		}
		$response = new stdClass;
		$response->total=$total;
		$response->rows = $data;
		$_SESSION['excel']= "asc|bloodid|";
		echo json_encode($response);
	}
	function grid(){

		$acl = $this->hakakses('blood');
		@$page = $_POST['page']; 
		@$limit = $_POST['rows']; 
		@$sidx = $_POST['sidx']; 
		@$sord = $_POST['sord']; 
		if (!$sidx)
		    $sidx = 1;
		@$totalrows = isset($_POST['totalrows']) ? $_POST['totalrows'] : false;
		if (@$totalrows) {
		   @$limit = $totalrows;
		}
		@$filters = $_POST['filters'];
		@$search = $_POST['_search'];

			$where = "";
       		if(($search==true) &&($filters != "")) {
				$where= $this->operation($filters);
		    }
		$sql = $this->mblood->count($where,'tblblood');
		$count = $sql->num_rows();
		if ($count > 0) {
		    @$total_pages = ceil($count / $limit);
		} else {
		    $total_pages = 0;
		}
		if ($page > $total_pages)
		    @$page = $total_pages;
		if ($limit < 0)
		    @$limit = 0;
			$start = $limit * $page - $limit;
		if ($start < 0)
		    @$start = 0;
		$data = $this->mblood->get($where, $sidx, $sord, $limit, $start);

		$_SESSION['excel']= $sord."|".$sidx."|".$where;
		@$responce->page = $page;
		@$responce->total = $total_pages;
		@$responce->records = $count;
		$i=0;
		foreach($data->result() as $row){
			if(substr($acl,0,1)==1){
				$view='<a href="#" id='.$row->bloodid.' title="view" class="btnview" style="float:left"><span class="ui-icon ui-icon-document"></span></a>';
			}
			else{
				$view='<span style="float:left" class="ui-state-disabled ui-icon ui-icon-document"></span>';
			}
			if(substr($acl,2,1)==1){
				$edit='<a href="#" id='.$row->bloodid.' title="Edit" class="btnedit" style="float:left"><span class="ui-icon ui-icon-pencil"></span></a>';
			}
			else{
				$edit='<span style="float:left" class="ui-state-disabled ui-icon ui-icon-pencil"></span>';
			}
			if(substr($acl,3,1)==1){
				$del='<a href="#" id='.$row->bloodid.' title="Del" class="btndel" style="float:left"><span class="ui-icon ui-icon-trash"></span></a>';
			}
			else{
				$del='<span class="ui-state-disabled ui-icon ui-icon-trash"></span>';
			}
			$responce->rows[$i]['id']   = $row->bloodid;

			$responce->rows[$i]['cell'] = array(
				$view.$edit.$del,
				$row->bloodid,
				$row->bloodname,
				$row->modifiedby,
				$row->modifiedonview
				);
			$i++;
		}
		
		// setcookie('pesan_transfer',json_encode($data->result()),time()+60,'/');
		echo json_encode($responce);
	}

	function form($form,$bloodid){
		$data["bloodid"] = $bloodid;
		$this->load->view('blood/'.$form,$data);
	}
	function form2($form,$bloodid){
		$data["bloodid"] = $bloodid;
		$this->load->view('blood/'.$form,$data);
	}
	function crud2($id=0){
		@$bloodid = @($_REQUEST['bloodid']);
		@$bloodname = @($_REQUEST['bloodname']);
		@$oper= @$_REQUEST['oper'];
		@$data = array(
			'bloodid' => @$bloodid,
			'bloodname' => @$bloodname,
			'modifiedby' => $_SESSION['username'],
			'modifiedon' => date("Y-m-d H:i:s")
		);
		switch ($oper) {
	        case 'add':
				$cek = $this->mblood->add("tblblood",$data);
				$status = $cek?"sukses":"gagal";
				$hasil = array(
			        'status' => $status
			    );
			    echo json_encode($hasil);
	            break;
            case 'del':
				$cek = $this->mblood->del("tblblood",$bloodid);
				$status = $cek?"sukses":"gagal";
				$hasil = array(
			        'status' => $status
			    );
			    echo json_encode($hasil);
	            break;
	        case 'edit':
				$cek = $this->mblood->edit("tblblood",$data,$bloodid);
				$status = $cek?"sukses":"gagal";
				$hasil = array(
			        'status' => $status
			    );
			    echo json_encode($hasil);
	            break;
	        default :
	        	$hasil = array(
			        'status' => 'Not Operation'
			    );
			    echo json_encode($hasil);
	           break;
		}
	}
	function crud(){
		@$oper=@$_POST['oper'];
	    @$bloodid=@$_POST['bloodid'];
		@$data = array(
			'bloodid' => @$_POST['bloodid'],
			'bloodname' => @$_POST['bloodname'],
			'modifiedby' => $_SESSION['username'],
			'modifiedon' => date("Y-m-d H:i:s")
			);
	    switch ($oper) {
	        case 'add':
				$this->mblood->add("tblblood",$data);
				$hasil = array(
			        'status' => 'sukses'
			    );
			    echo json_encode($hasil);
	            break;
	        case 'edit':
				$this->mblood->edit("tblblood",$data,$bloodid);
				$hasil = array(
			        'status' => 'sukses'
			    );
			    echo json_encode($hasil);
	            break;
	         case 'del':
				$this->mblood->del("tblblood",$bloodid);
				$hasil = array(
			        'status' => 'sukses'
			    );
			    echo json_encode($hasil);
	            break;
	        default :
	        	$hasil = array(
			        'status' => 'Not Operation'
			    );
			    echo json_encode($hasil);
	           break;
		}
	}

	function operation($filters){
        $filters = str_replace('\"','"' ,$filters);
        $filters = str_replace('"[','[' ,$filters);
        $filters = str_replace(']"',']' ,$filters);
		$filters = json_decode($filters);
		$where = " where ";
		$whereArray = array();
		$rules = $filters->rules;
		$groupOperation = $filters->groupOp;
		foreach($rules as $rule) {
		    $fieldName = $rule->field;
		    $fieldData  =escapeString($rule->data);
			   	switch ($rule->op) {
					case "eq": $fieldOperation = " = '".$fieldData."'"; break;
					case "ne": $fieldOperation = " != '".$fieldData."'"; break;
					case "lt": $fieldOperation = " < '".$fieldData."'"; break;
					case "gt": $fieldOperation = " > '".$fieldData."'"; break;
					case "le": $fieldOperation = " <= '".$fieldData."'"; break;
					case "ge": $fieldOperation = " >= '".$fieldData."'"; break;
					case "nu": $fieldOperation = " = ''"; break;
					case "nn": $fieldOperation = " != ''"; break;
					case "in": $fieldOperation = " IN (".$fieldData.")"; break;
					case "ni": $fieldOperation = " NOT IN '".$fieldData."'"; break;
					case "bw": $fieldOperation = " LIKE '".$fieldData."%'"; break;
					case "bn": $fieldOperation = " NOT LIKE '".$fieldData."%'"; break;
					case "ew": $fieldOperation = " LIKE '%".$fieldData."'"; break;
					case "en": $fieldOperation = " NOT LIKE '%".$fieldData."'"; break;
					case "cn": $fieldOperation = " LIKE '%".$fieldData."%'"; break;
					case "nc": $fieldOperation = " NOT LIKE '%".$fieldData."%'"; break;
					default: $fieldOperation = ""; break;
		        }
		    if($fieldOperation != "") {
		    	if($fieldName=="modifiedon"){
                	$whereArray[] = "DATE_FORMAT(modifiedon,'%d-%m-%Y %T')".$fieldOperation;
                }
                else{
                	$whereArray[] = $fieldName.$fieldOperation;
                }
		    }
		}

		if (count($whereArray)>0) {
		    $where .= join(" ".$groupOperation." ", $whereArray);
		} else {
		    $where = "";
		}
		return $where;
	}

	function excel(){
		$excel = $_SESSION['excel'];
		$splitexcel = explode("|",$excel);
		$sord = $splitexcel[0];
		$sidx= $splitexcel[1];
		$where = $splitexcel[2];
		$data['sql']=$this->db->query("SELECT *,
		DATE_FORMAT(modifiedon,'%d-%m-%Y') modifiedon
		FROM tblblood " . $where . " ORDER BY $sidx $sord");
		$this->load->view('blood/excel',$data);
	}

	function hakakses($x){
		$x = $this->mmenutop->get_menuid($x);
		return $x;
	}
}