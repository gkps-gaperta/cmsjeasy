<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Besuk extends CI_Controller {

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

		$this->load->model('mbesuk');
		$this->load->model('mgender');
		$this->load->model('mpstatus');
		$this->load->model('mblood');
		$this->load->model('mkebaktian');
		$this->load->model('mpersekutuan');
		$this->load->model('mrayon');
		$this->load->model('mmenutop');
		$this->load->helper('my_helper');
		
		$this->load->model('mjemaat');
		$this->load->model('mgender');
		$this->load->model('mpstatus');
		$this->load->model('mparameter');
		$this->load->model('mblood');
		$this->load->model('mkebaktian');
		$this->load->model('mpersekutuan');
		$this->load->model('mrayon');
		$this->load->model('mserving');
		$this->load->model('mmenu');
	}

	function set(){
		$_SESSION['recno'] = $_GET['recno'];
	}

	function index(){
		if(empty($_SESSION['recno'])){
			echo" Empty";
		}
		else{
			$data['recno'] = $_SESSION['recno'];
			$data['sql'] = $this->mbesuk->getwhere($_SESSION['recno']);

			$data['statusid'] = $this->uri->segment(2);
		//if($this->uri->segment(2)==""){
			$data['acl'] = $this->hakakses($_GET['op']);
			//$data['acl'] = $this->hakakses($this->uri->segment(1));
		//}
		//else{
		//	$data['acl'] = $this->hakakses($this->uri->segment(1)."/".$this->uri->segment(2));
		//}
		$data['sqlmenu'] = $this->mmenutop->get_data();

		$data['sqlgender'] = $this->mgender->get_jemaat();
		$data['sqlpstatus'] = $this->mpstatus->get_jemaat();
		$data['sqlstatusidv'] = $this->mparameter->get_jemaat();
		$data['sqlblood'] = $this->mblood->get_jemaat();
		$data['sqlkebaktian'] = $this->mkebaktian->get_jemaat();
		$data['sqlpersekutuan'] = $this->mpersekutuan->get_jemaat();
		$data['sqlrayon'] = $this->mrayon->get_jemaat();
		
		$data['gender'] = $this->mgender->get_combo();
		$data['pstatus'] = $this->mpstatus->get_combo();
		$data['statusidv'] = $this->mparameter->get_combo();
		$data['blood'] = $this->mblood->get_combo();
		$data['kebaktian'] = $this->mkebaktian->get_combo();
		$data['persekutuan'] = $this->mpersekutuan->get_combo();
		$data['rayon'] = $this->mrayon->get_combo();
		
		$data['bgfilter'] = $this->mparameter->get_bgfilter();
		$data['bgsortira'] = $this->mparameter->get_bgsortira();
		$data['bgsortird'] = $this->mparameter->get_bgsortird();


			//$this->load->view('header');
			//$this->load->view('navbar',$data);
			$this->load->view('jemaat/gridbesuk',$data);
			//$this->load->view('jemaat/gridjemaat',$data);
			//$this->load->view('footer');
		}
	}

	function grid($recno){
		$acl = $this->hakakses("jemaat");
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
			$where = " where recno='".$recno."'";
       		if (isset($filters)) {
				$where= $this->operation($filters,$recno);
		    }
		$sql = $this->mbesuk->count($where);
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
		$data = $this->mbesuk->get($where, $sidx, $sord, $limit, $start);
		$_SESSION['excelbesuk']= $sord."|".$sidx."|".$where;
		@$responce->page = $page;
		@$responce->total = $total_pages;
		@$responce->records = $count;
		$i=0;
		foreach($data->result() as $row){
			if(substr($acl,0,1)==1){
				$view='<a href="#" recno='.$row->recno.' besukid='.$row->besukid.' title="view" class="btnviewbesuk" style="float:left"><span class="ui-icon ui-icon-document"></span></a>';
			}
			else{
				$view='<span style="float:left" class="ui-state-disabled ui-icon ui-icon-document"></span>';
			}
			if(substr($acl,2,1)==1){
				$edit='<a href="#" recno='.$row->recno.' besukid='.$row->besukid.' title="Edit" class="btneditbesuk" style="float:left"><span class="ui-icon ui-icon-pencil"></span></a>';
			}
			else{
				$edit='<span style="float:left" class="ui-state-disabled ui-icon ui-icon-pencil"></span>';
			}
			if(substr($acl,3,1)==1){
				$del='<a href="#" recno='.$row->recno.' besukid='.$row->besukid.' title="Del" class="btndelbesuk" style="float:left"><span class="ui-icon ui-icon-trash"></span></a>';
			}
			else{
				$del='<span class="ui-state-disabled ui-icon ui-icon-trash"></span>';
			}
			$responce->rows[$i]['id']   = $row->besukid;
			$responce->rows[$i]['cell'] = array(
				$row->besukid,
				$view.$edit.$del,
				$row->recno,
				$row->besukdateview,
				$row->pembesuk,
				$row->pembesukdari,
				$row->remark,
				$row->besuklanjutan,
				$row->modifiedby,
				$row->modifiedonview,
				);
			$i++;
		}
		echo json_encode($responce);
	}

	function form($form,$besukid,$recno){
		$data["besukid"] = $besukid;
		$data["recno"] = $recno;
		$data['sql'] = $this->mbesuk->getwhere($recno);
		$this->load->view('besuk/'.$form,$data);
	}

	function crud(){
		@$oper=@$_POST['oper'];
	    @$besukid=@$_POST['besukid'];
	    
	    @$besukdate = $_POST['besukdate'];
	    @$exp1 = explode('-',$besukdate);
		@$besukdate = $exp1[2]."-".$exp1[1]."-".$exp1[0]." ".date("H:i:s");
		
		@$data = array(
			'recno' => @$_POST['recno'],
			'besukdate' => @$besukdate,
			'pembesuk' => @$_POST['pembesuk'],
			'pembesukdari' => @$_POST['pembesukdari'],
			'remark' => @$_POST['remark'],
			'besuklanjutan' => @$_POST['besuklanjutan'],
			'modifiedby' => $_SESSION['username'],
			'modifiedon' => date("Y-m-d H:i:s")
			);
	    switch ($oper) {
	        case 'add':
				$this->mbesuk->add("tblbesuk",$data);
				$hasil = array(
			        'status' => 'sukses'
			    );
			    echo json_encode($hasil);
	            break;
	        case 'edit':
				$this->mbesuk->edit("tblbesuk",$data,$besukid);
				$hasil = array(
			        'status' => 'sukses'
			    );
			    echo json_encode($hasil);
	            break;
	         case 'del':
				$this->mbesuk->del("tblbesuk",$besukid);
				$hasil = array(
			        'status' => 'sukses'
			    );
			    echo json_encode($hasil);
	            break;
		}
	}

	function operation($filters,$recno){
		$filters = json_decode($filters);
		$where = " where recno='".$recno."'";
		$whereArray = array();
		$rules = $filters->rules;
		$groupOperation = $filters->groupOp;
		foreach($rules as $rule) {
		    $fieldName = $rule->field;
		    $fieldData = escapeString($rule->data);
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
		    	if($fieldName=="besukdate"){
                	$whereArray[] = "DATE_FORMAT(besukdate,'%d-%m-%Y')".$fieldOperation;
                }
                else if($fieldName=="modifiedon"){
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
		$excel = $_SESSION['excelbesuk'];
		$splitexcel = explode("|",$excel);
		$sord = $splitexcel[0];
		$sidx= $splitexcel[1];
		$where = $splitexcel[2];
		$data['sql']=$this->db->query("SELECT *,
		DATE_FORMAT(modifiedon,'%d-%m-%Y') modifiedon
		FROM tblbesuk " . $where . " ORDER BY $sidx $sord");
		$this->load->view('besuk/excel',$data);
	}

	function hakakses($x){
		$x = $this->mmenutop->get_menuid($x);
		return $x;
	}

}