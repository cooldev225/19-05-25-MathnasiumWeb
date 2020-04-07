<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
//include_once ROOTPATH.'/vendor/mpdf/mpdf/src/Mpdf.php';
use Twilio\Rest\Client;
	class Instructor extends MY_Controller{
		public $view = array();
		public $_user_name="";
		public $_user_role=1;
		function __construct(){
			parent::__construct();
			$this->load->database();
			$this->load->model('import_Model', 'import');
			$this->view['header'] = 'header.php';
			$this->view['sidebar'] = 'instructor_sidebar.php';
			$this->view['footer'] = 'footer.php';
			
			$crossuser = $this->session->userdata(USER_CROSS_INFO);
			if(!isset($crossuser)){
                redirect(URL_PATH);
			}
			$this->view['_cross_user']=$crossuser;
			$nowuser = $this->session->userdata(USER_INFO);
			if(!isset($nowuser)){
                redirect(URL_PATH);
			}
			$this->view['_now_user']=$nowuser;
			$this->view['_user_sendable']=$nowuser['sendable'];
			$user = $this->session->userdata(USER_INFO);
			if(!isset($user)){
                redirect(URL_PATH);
			}
			$this->_user=$user;
			$this->_user_name=$user['name'];
			$this->_user_role=$user['role'];
			$this->_user_location=$user['center'];
			$this->load->helper('email');
			
			$this->view['centerpermission']="";
			if($user['role']==0){
    			foreach($this->import->getDataList("tbl_localsmtp",array(),array("center")) as $r){
    				if($r['center']!="")$this->view['centerpermission'].=($this->view['centerpermission']==""?"":"###").$r['center'];
    			}
			}else if($user['role']==1||$user['role']==2){
			    //$this->view['centerpermission']=$user['center'];
			    $us = $this->import->getDataList("user",array('email'=>$user['email'],'removed'=>0),array('role'));
			    $this->view['centerpermission']=$us[0]['center'];
    			foreach($this->import->getDataList("tbl_location_permission",array('email'=>$user['email']),array("center")) as $r){
    			    if($us[0]['center']!=$r['center'])
    			    $this->view['centerpermission'].=($this->view['centerpermission']==""?"":"###").$r['center'];
    			}
			}
		}
		public function extrahomework(){
			$this->view['_user_name']=$this->_user_name;
			$this->view['_user_location']=$this->_user_location;
			$this->view['content'] = 'instructor/extrahomework.php';
			$this->view['templatedata'] = $this->import->getDataList("tbl_template",array('center'=>$this->_user_location));
			$this->view['studentdata'] = $this->import->db->query("select * from tbl_student_view where replace(center,' ','')='".str_replace(' ','',$this->_user_location)."'")->result_array();
			$this->view['topickinddata'] = $this->import->getDataList("tbl_topickind");
			$this->view['ixldata'] = $this->import->getDataList("tbl_ixl");
			$this->load->view('container.php', $this->view);
		}
		
		public function chgcenter(){
		    $nowuser = $this->session->userdata(USER_INFO);
			if(!isset($nowuser)){
                redirect(URL_PATH);
			}
			$nowuser['center']=$_GET['c'];
		    $this->session->set_userdata(USER_INFO, $nowuser);
		    //redirect(URL_PATH.'instructor/index');
		    if("instructor/dailygame.php"==$_GET['p'])redirect(URL_PATH.'instructor/index');
		    else if("instructor/extrahomework.php"==$_GET['p'])redirect(URL_PATH.'instructor/extrahomework');
		    else if("instructor/report.php"==$_GET['p'])redirect(URL_PATH.'instructor/studentreport');
		    else if("instructor/template_rs.php"==$_GET['p'])redirect(URL_PATH.'instructor/rstemplate');
		    else if("instructor/template_rm.php"==$_GET['p'])redirect(URL_PATH.'instructor/rmtemplate');
		    else if("instructor/template_hs.php"==$_GET['p'])redirect(URL_PATH.'instructor/hstemplate');
		    else if("instructor/template_hm.php"==$_GET['p'])redirect(URL_PATH.'instructor/hmtemplate');
		    else if("instructor/template_im.php"==$_GET['p'])redirect(URL_PATH.'instructor/imtemplate');
		    else redirect(URL_PATH.'instructor/index');
		}
		
		
		
		public function index(){
			$this->view['_user_name']=$this->_user_name;
			$this->view['_user_location']=$this->_user_location;
			
			$this->view['content'] = 'instructor/dailygame.php';
			$this->view['instructordata'] = $this->import->getDataList("tbl_account");
			$this->view['studentdata'] = $this->import->db->query("select * from tbl_student_view where replace(center,' ','')='".str_replace(' ','',$this->_user_location)."'")->result_array();
			$this->view['topickinddata'] = $this->import->getDataList("tbl_topickind");
			$this->view['templatedata'] = $this->import->getDataList("tbl_template",array('center'=>$this->_user_location));
			if(isset($_POST['session_id']))if($_POST['session_id']!=""){
				$tempdata = $this->import->getDataList("tbl_session",array('idx'=>$_POST['session_id']),array("datex,idx"));
				if(count($tempdata)>0){
					$_POST['fixed_studentid']=$tempdata[0]['studentidx'];
					$_POST['fixed_datax']=$tempdata[0]['datex'];
				}
			}
			/*
			if(!isset($_POST['fixed_studentid']))$sessiondata = $this->import->getDataList("tbl_session",array('instructorx'=>$this->_user_name),array("datex,idx"));
			else $sessiondata = $this->import->getDataList("tbl_session",array('instructorx'=>$this->_user_name,'studentidx'=>$_POST['fixed_studentid']),array("datex,idx"));
			*/
			if(!isset($_POST['fixed_studentid']))$sessiondata = $this->import->getDataList("tbl_session",array(),array("datex,idx"));
			else $sessiondata = $this->import->getDataList("tbl_session",array('studentidx'=>$_POST['fixed_studentid']),array("datex,idx"));
			//$this->view['userdata'] = $this->session->userdata(USER_INFO);
			date_default_timezone_set('America/New_York');
			$this->view['sessiondata']=array(
				"studentx"=>"",
				"studentidx"=>"",
				"datex"=>date("Y-m-d"),
				"timex"=>"",
				"quiz1x"=>"","quiz2x"=>"","quiz3x"=>"","quiz4x"=>"","quiz5x"=>"","quiz6x"=>"","quiz7x"=>"","quiz8x"=>"","quiz9x"=>"","quiz10x"=>"",
				"quiz1xx"=>"","quiz2xx"=>"","quiz3xx"=>"","quiz4xx"=>"","quiz5xx"=>"","quiz6xx"=>"","quiz7xx"=>"","quiz8xx"=>"","quiz9xx"=>"","quiz10xx"=>"",
				"topic1x"=>"","topic2x"=>"","topic3x"=>"","topic4x"=>"","topic5x"=>"","topic6x"=>"","topic7x"=>"","topic8x"=>"","topic9x"=>"","topic10x"=>"",
				"comment1x"=>"","comment2x"=>"","comment3x"=>"","comment4x"=>"","comment5x"=>"","comment6x"=>"","comment7x"=>"","comment8x"=>"","comment9x"=>"","comment10x"=>"",
				"sign1x"=>"","sign2x"=>"","sign3x"=>""
			);
			$cnt=count($sessiondata);
			//if(!isset($_POST['session_id'])&&$cnt>0)$_POST['session_id']=-1;//$sessiondata[$cnt-1]['idx'];
			$this->view['sessionnumber']=$cnt+1;
			if(!isset($_POST['session_id'])||$cnt==0){
				$this->view['sessionid']=-1;
				$this->view['sessionprevid']=-1;
				$this->view['sessionnextid']=-1;
				if($cnt>0)$this->view['sessionprevid']=$sessiondata[$cnt-1]['idx'];
				
				if(isset($_POST['fixed_studentid']))if($_POST['fixed_studentid']!=''){
					$this->view['sessiondata']['studentidx']=$_POST['fixed_studentid'];
					$this->view['sessiondata']['datex']=$_POST['fixed_datex'];
					$tempdata = $this->import->getDataList("tbl_student_view",array('s_Id'=>$this->view['sessiondata']['studentidx']));
					if(count($tempdata)>0)$this->view['sessiondata']['studentx']=$tempdata[0]['First_Name'];
				}
			}else{
				if($_POST['session_id']<0){
					$this->view['sessionid']=-1;
					//$this->view['sessiondata']=$sessiondata[$cnt-1];
					$this->view['sessionprevid']=$sessiondata[$cnt-1]['idx'];
					$this->view['sessionnextid']=-1;
					$students=array();
					$sessiontempdata = $this->import->getDataList("tbl_session",array('instructorx'=>$this->_user_name,'datex'=>$this->view['sessiondata']['datex']));
					foreach($sessiontempdata as $row){
						$students[]=$row['studentidx'];
					}
					/*
					foreach($this->view['studentdata'] as $std){
						$i=0;
						for(;$i<count($students);$i++){
							if($std['s_Id']==$students[$i])break;
						}
						if($i==count($students)){
							$this->view['sessiondata']['studentidx']=$std['s_Id'];
							break;
						}
					}*/	
					if(isset($_POST['fixed_studentid']))if($_POST['fixed_studentid']!=''){
						$this->view['sessiondata']['studentidx']=$_POST['fixed_studentid'];
						$this->view['sessiondata']['datex']=$_POST['fixed_datex'];
						$tempdata = $this->import->getDataList("tbl_student_view",array('s_Id'=>$this->view['sessiondata']['studentidx']));
						if(count($tempdata)>0)$this->view['sessiondata']['studentx']=$tempdata[0]['First_Name'];
					}
				}else{
					for($i=0;$i<$cnt;$i++){
						//echo $_POST['session_id'].",".$sessiondata[$i]['idx'].",".$i."df";
						if($sessiondata[$i]['idx']==$_POST['session_id']){
							if($i)$this->view['sessionprevid']=$sessiondata[$i-1]['idx'];
							else $this->view['sessionprevid']=-1;
							if($i<$cnt-1)$this->view['sessionnextid']=$sessiondata[$i+1]['idx'];
							else $this->view['sessionnextid']=-1;
							
							$this->view['sessionid']=$sessiondata[$i]['idx'];
							$this->view['sessionnumber']=$i+1;
							$this->view['sessiondata']=$sessiondata[$i];
							break;
						}
					}
				}
			}
			/*
			for($i=0;$i<count($this->view['studentdata']);$i++){
				$this->view['studentdata'][$i]['linkinstructor']='';
				if($cnt>0){
					$sessiontempdata = $this->import->getDataList("tbl_session",array('studentidx'=>$this->view['studentdata'][$i]['s_Id'],'datex'=>$this->view['sessiondata']['datex']));
					if(count($sessiontempdata)>0)$this->view['studentdata'][$i]['linkinstructor']=$sessiontempdata[0]['instructorx'];
				}
			}
			*/
			
			//internal_email
			$this->view['internal_email']="";
			if(isset($this->view['sessiondata']['studentidx'])){
				$tempdata = $this->import->getDataList("tbl_student_view",array('s_Id'=>$this->view['sessiondata']['studentidx']));
				if(count($tempdata)>0)$this->view['internal_email']=str_replace(" ","",$tempdata[0]['Center']);
			}
			if($this->view['internal_email']!=""){
			    $tempdata = $this->import->db->query("select * from tbl_localsmtp where replace(center,' ','')='".str_replace(' ','',$this->view['internal_email'])."'")->result_array();
			    if(count($tempdata))$this->view['internal_email']=$tempdata[0]['from_'];
			}
			/*foreach($this->view['templatedata'] as $r){
				if($r['typex']==3){
					if($this->view['internal_email']==""){
						$this->view['internal_email']=$r['textx'];
					}
					if($r['textx']!=""){
						$arr=explode("@",$r['textx']);
						if(count($arr)>1){
							$this->view['internal_email'].="@{$arr[1]}";
						}
					}
				}
			}*/
			
			//$sql="select a.* from tbl_session a join tbl_student_view b on a.studentidx=b.s_Id where  a.instructorx='{$this->_user_name}' and a.studentidx='{$this->view['sessiondata']['studentidx']}' ";
			$sql="select a.* from tbl_session a join tbl_student_view b on a.studentidx=b.s_Id where  a.studentidx='{$this->view['sessiondata']['studentidx']}' ";
			$datearr=explode("-",$this->view['sessiondata']['datex']);
			if(count($datearr)>2){
				$sql.=" and a.datex>='{$datearr[0]}-{$datearr[1]}-01'";
				$sql.=" and a.datex<='{$datearr[0]}-{$datearr[1]}-31'";
			}
			$sql.=" order by a.datex desc";
			$this->view['selstudentdata']=$this->import->db->query($sql)->result_array();
			
			$this->view['currentsessionnum']=1;
			$k=0;
			$date1=explode("-",$this->view['sessiondata']['datex']);
			foreach($sessiondata as $ss){
				$date2=explode("-",$ss['datex']);
				if($date1[1]==$date2[1]){
					$k++;
				}
				if($ss['idx']==$this->view['sessionid']){
					$this->view['currentsessionnum']=$k;
					break;
				}
			}
			$this->load->view('container.php', $this->view);
		}

		
		public function studentreport(){
			$this->view['content'] = 'instructor/report.php';
			$this->view['_user_name'] = $this->_user_name;
			$this->view['_user_role'] = $this->_user_role;
			$this->view['_user_location']=$this->_user_location;
			$this->view['_user_sendable']=$this->_user['sendable'];
			$this->view['userdata'] = $this->import->getDataList("user",array("removed"=>0));
			
			$templatedata = $this->import->getDataList("tbl_template");
			$this->view['templatedata']=array();
			foreach($templatedata as $r){
			    if($r['typex']==1||$r['typex']==2||$r['typex']==4||$r['typex']==5||$r['typex']==6||$r['typex']==7)
			    $this->view['templatedata'][]=$r;
			}
			
			$ixldata = $this->import->getDataList("tbl_ixl");
			$this->view['ixldata']=array();
			foreach($ixldata as $r){
			    $this->view['ixldata'][$r['pk']]=(isset($this->view['ixldata'][$r['pk']])?",":"").$r['pk_descrip'];    
			    $this->view['ixlurldata'][$r['pk']]=(isset($this->view['ixldata'][$r['pk']])?"##":"").$r['ixl_URL'];    
			}
			
			$this->view['studentdata'] = $this->import->db->query("select * from tbl_student_view where replace(center,' ','')='".str_replace(' ','',$this->_user_location)."'")->result_array();
			//$sql="select a.*,b.First_Name,b.Last_Name,b.pFirst_Name,b.pLast_Name,b.pemail,b.pphone,b.center,c.name as iname from tbl_session a join student_by_parent b on a.studentidx=b.s_Id join user c on a.instructorx=c.name where a.idx>0 ";
			$sql="select a.*,b.First_Name,b.Last_Name,b.Center,c.from_ as internalMail from tbl_session a join tbl_student_view b on a.studentidx=b.s_Id join tbl_localsmtp c on replace(b.Center,' ','')=replace(c.Center,' ','') where a.idx>0 and replace(b.Center,' ','')='".str_replace(' ','',$this->_user_location)."' ";
			if(!isset($_POST['fromdate']))$this->view['fromdate']="";else $this->view['fromdate']=$_POST['fromdate'];
			if(!isset($_POST['todate']))$this->view['todate']="";else $this->view['todate']=$_POST['todate'];
			if($this->view['fromdate']=="NULL")$this->view['fromdate']="";
			if($this->view['todate']=="NULL")$this->view['todate']="";
			if(!isset($_POST['instructor']))$this->view['instructor']=$this->_user_name;else $this->view['instructor']=$_POST['instructor'];
			if(!isset($_POST['student']))$this->view['student']="";else $this->view['student']=$_POST['student'];
			if($this->view['fromdate']!="")$sql.=" and a.datex>='{$this->view['fromdate']}' ";
			if($this->view['todate']!="")$sql.=" and a.datex<='{$this->view['todate']}' ";
			if($this->view['instructor']!="")$sql.=" and a.instructorx='{$this->view['instructor']}' ";
			if($this->view['student']!="")$sql.=" and a.studentidx='{$this->view['student']}' ";
			else{
			    //$sql.=" and b.Account like '%{$this->_user_name}%'";
			}
			//$sql.=" and replace(b.center,' ','')='".str_replace(' ','',$this->_user_location)."'";
			$sql.=" order by a.datex DESC";//exit($sql);
			$this->view['sessiondata'] = $this->import->db->query($sql)->result_array();
			
			$sql="select a.*,b.First_Name,b.Last_Name from tbl_report a join tbl_student_view b on a.studentidx=b.s_Id where a.idx>0  and b.Center='{$this->_user_location}' ";
			if($this->view['fromdate']!="")$sql.=" and a.datex>='{$this->view['fromdate']}' ";
			if($this->view['todate']!="")$sql.=" and a.datex<='{$this->view['todate']}' ";
			if($this->view['instructor']!="")$sql.=" and a.senderx='{$this->view['instructor']}' ";
			if($this->view['student']!="")$sql.=" and a.studentidx='{$this->view['student']}' ";
			$sql.=" order by a.datex desc";//exit($sql);
			$this->view['reportdata'] = $this->import->db->query($sql)->result_array();
			
			for($i=0;$i<count($this->view['sessiondata']);$i++){
				$rr = $this->import->getDataList("tbl_report",array('sessionid'=>$this->view['sessiondata'][$i]['idx']));
				$this->view['sessiondata'][$i]['reportid0']="";
				$this->view['sessiondata'][$i]['reportreceiver0']="";
				$this->view['sessiondata'][$i]['reporttime0']="";
				$this->view['sessiondata'][$i]['reportid1']="";
				$this->view['sessiondata'][$i]['reportreceiver1']="";
				$this->view['sessiondata'][$i]['reporttime1']="";
				$this->view['sessiondata'][$i]['reportid2']="";
				$this->view['sessiondata'][$i]['reportreceiver2']="";
				$this->view['sessiondata'][$i]['reporttime2']="";
				$j1=0;$j2=0;$j3=0;
				for($j=0;$j<count($rr);$j++){
					if($rr[$j]['typex']==0||$rr[$j]['typex']==3){
						$this->view['sessiondata'][$i]['reportid0'].=($j1==0?"":"##").$rr[$j]['idx'];	
						$this->view['sessiondata'][$i]['reportreceiver0'].=($j1==0?"":"##").$rr[$j]['receiverx'];	
						$this->view['sessiondata'][$i]['reporttime0'].=($j1==0?"":"##").$rr[$j]['datex'];	
						$j1=1;
					}
					if($rr[$j]['typex']==1||$rr[$j]['typex']==4){
						$this->view['sessiondata'][$i]['reportid1'].=($j2==0?"":"##").$rr[$j]['idx'];	
						$this->view['sessiondata'][$i]['reportreceiver1'].=($j2==0?"":"##").$rr[$j]['receiverx'];
						$this->view['sessiondata'][$i]['reporttime1'].=($j2==0?"":"##").$rr[$j]['datex'];	
						$j2=1;
					}
					if($rr[$j]['typex']==2){
						$this->view['sessiondata'][$i]['reportid2'].=($j3==0?"":"##").$rr[$j]['idx'];	
						$this->view['sessiondata'][$i]['reportreceiver2'].=($j3==0?"":"##").$rr[$j]['receiverx'];	
						$this->view['sessiondata'][$i]['reporttime2'].=($j3==0?"":"##").$rr[$j]['datex'];	
						$j3=1;
					}
				}
			}
			//$this->view['reportdata'] = $this->import->getDataList("tbl_report",);
			if(isset($_POST['viewidx']))$this->view['viewidx']=$_POST['viewidx'];else $this->view['viewidx']="";
			if(isset($_POST['viewdatex']))$this->view['viewdatex']=$_POST['viewdatex'];else $this->view['viewdatex']="";			
			$this->load->view('container.php', $this->view);
		}
		
		public function reportexe(){
			$this->view['content'] = 'instructor/reportexe.php';
			$this->view['_user_name'] = $this->_user_name;
			$this->view['_user_role'] = $this->_user_role;
			$this->view['_user_location']=$this->_user_location;
			$this->view['_user_sendable']=$this->_user['sendable'];
			$this->view['userdata'] = $this->import->getDataList("user",array("removed"=>0));
			$this->view['userlocatioin'] = $this->import->getDataList("tbl_location_permission",array('email',$this->_user['email']));
			
			$templatedata = $this->import->getDataList("tbl_template");
			$this->view['templatedata']=array();
			foreach($templatedata as $r){
			    if($r['typex']==1||$r['typex']==2||$r['typex']==4||$r['typex']==5||$r['typex']==6||$r['typex']==7)
			    $this->view['templatedata'][]=$r;
			}
			
			/*
			$ixldata = $this->import->getDataList("tbl_ixl");
			$this->view['ixldata']=array();
			foreach($ixldata as $r){
			    $this->view['ixldata'][$r['pk']]=(isset($this->view['ixldata'][$r['pk']])?",":"").$r['pk_descrip'];    
			    $this->view['ixlurldata'][$r['pk']]=(isset($this->view['ixldata'][$r['pk']])?"##":"").$r['ixl_URL'];    
			}
			*/
			
			
			$this->view['studentdata'] = $this->import->db->query("select * from tbl_student_view where replace(center,' ','')='".str_replace(' ','',$this->_user_location)."'")->result_array();
			//$sql="select a.*,b.First_Name,b.Last_Name,b.pFirst_Name,b.pLast_Name,b.pemail,b.pphone,b.center,c.name as iname from tbl_session a join student_by_parent b on a.studentidx=b.s_Id join user c on a.instructorx=c.name where a.idx>0 ";
			$sql="select a.*,b.First_Name,b.Last_Name,b.Center,c.from_ as internalMail from tbl_session a join tbl_student_view b on a.studentidx=b.s_Id join tbl_localsmtp c on replace(b.Center,' ','')=replace(c.Center,' ','') where a.idx>0 and replace(b.Center,' ','')='".str_replace(' ','',$this->_user_location)."' ";
			if(!isset($_POST['fromdate']))$this->view['fromdate']="";else $this->view['fromdate']=$_POST['fromdate'];
			if(!isset($_POST['todate']))$this->view['todate']="";else $this->view['todate']=$_POST['todate'];
			if($this->view['fromdate']=="NULL")$this->view['fromdate']="";
			if($this->view['todate']=="NULL")$this->view['todate']="";
			if(!isset($_POST['instructor']))$this->view['instructor']=$this->_user_name;else $this->view['instructor']=$_POST['instructor'];
			if(!isset($_POST['student']))$this->view['student']="";else $this->view['student']=$_POST['student'];
			if($this->view['fromdate']!="")$sql.=" and a.datex>='{$this->view['fromdate']}' ";
			if($this->view['todate']!="")$sql.=" and a.datex<='{$this->view['todate']}' ";
			if($this->view['instructor']!="")$sql.=" and a.instructorx='{$this->view['instructor']}' ";
			if($this->view['student']!="")$sql.=" and a.studentidx='{$this->view['student']}' ";
			else{
			    //$sql.=" and b.Account like '%{$this->_user_name}%'";
			}
			//$sql.=" and replace(b.center,' ','')='".str_replace(' ','',$this->_user_location)."'";
			$sql.=" order by a.datex DESC";//exit($sql);
			/*$this->view['sessiondata'] = $this->import->db->query($sql)->result_array();
			*/
			
			/*
			$sql="select a.*,b.First_Name,b.Last_Name from tbl_report a join tbl_student_view b on a.studentidx=b.s_Id where a.idx>0  and b.Center='{$this->_user_location}' ";
			if($this->view['fromdate']!="")$sql.=" and a.datex>='{$this->view['fromdate']}' ";
			if($this->view['todate']!="")$sql.=" and a.datex<='{$this->view['todate']}' ";
			if($this->view['instructor']!="")$sql.=" and a.senderx='{$this->view['instructor']}' ";
			if($this->view['student']!="")$sql.=" and a.studentidx='{$this->view['student']}' ";
			$sql.=" order by a.datex desc";//exit($sql);
			$this->view['reportdata'] = $this->import->db->query($sql)->result_array();*/
			
			/*
			for($i=0;$i<count($this->view['sessiondata']);$i++){
				$rr = $this->import->getDataList("tbl_report",array('sessionid'=>$this->view['sessiondata'][$i]['idx']));
				$this->view['sessiondata'][$i]['reportid0']="";
				$this->view['sessiondata'][$i]['reportreceiver0']="";
				$this->view['sessiondata'][$i]['reporttime0']="";
				$this->view['sessiondata'][$i]['reportid1']="";
				$this->view['sessiondata'][$i]['reportreceiver1']="";
				$this->view['sessiondata'][$i]['reporttime1']="";
				$this->view['sessiondata'][$i]['reportid2']="";
				$this->view['sessiondata'][$i]['reportreceiver2']="";
				$this->view['sessiondata'][$i]['reporttime2']="";
				$j1=0;$j2=0;$j3=0;
				for($j=0;$j<count($rr);$j++){
					if($rr[$j]['typex']==0||$rr[$j]['typex']==3){
						$this->view['sessiondata'][$i]['reportid0'].=($j1==0?"":"##").$rr[$j]['idx'];	
						$this->view['sessiondata'][$i]['reportreceiver0'].=($j1==0?"":"##").$rr[$j]['receiverx'];	
						$this->view['sessiondata'][$i]['reporttime0'].=($j1==0?"":"##").$rr[$j]['datex'];	
						$j1=1;
					}
					if($rr[$j]['typex']==1||$rr[$j]['typex']==4){
						$this->view['sessiondata'][$i]['reportid1'].=($j2==0?"":"##").$rr[$j]['idx'];	
						$this->view['sessiondata'][$i]['reportreceiver1'].=($j2==0?"":"##").$rr[$j]['receiverx'];
						$this->view['sessiondata'][$i]['reporttime1'].=($j2==0?"":"##").$rr[$j]['datex'];	
						$j2=1;
					}
					if($rr[$j]['typex']==2){
						$this->view['sessiondata'][$i]['reportid2'].=($j3==0?"":"##").$rr[$j]['idx'];	
						$this->view['sessiondata'][$i]['reportreceiver2'].=($j3==0?"":"##").$rr[$j]['receiverx'];	
						$this->view['sessiondata'][$i]['reporttime2'].=($j3==0?"":"##").$rr[$j]['datex'];	
						$j3=1;
					}
				}
			}*/
			
			//$this->view['reportdata'] = $this->import->getDataList("tbl_report",);
			if(isset($_POST['viewidx']))$this->view['viewidx']=$_POST['viewidx'];else $this->view['viewidx']="";
			if(isset($_POST['viewdatex']))$this->view['viewdatex']=$_POST['viewdatex'];else $this->view['viewdatex']="";			
			$this->load->view('container.php', $this->view);
		}
		
		public function getreportdata(){
		    $ixldata = $this->import->getDataList("tbl_ixl");
			$this->view['ixldata']=array();
			foreach($ixldata as $r){
			    $this->view['ixldata'][$r['pk']]=(isset($this->view['ixldata'][$r['pk']])?",":"").$r['pk_descrip'];    
			    $this->view['ixlurldata'][$r['pk']]=(isset($this->view['ixldata'][$r['pk']])?"##":"").$r['ixl_URL'];    
			}
			//exit($this->view['ixldata']['3004']);
		    $sql=" from (select * from tbl_session where idx>0 ";
    		    if(!isset($_POST['fromdate']))$this->view['fromdate']="";else $this->view['fromdate']=$_POST['fromdate'];
    			if(!isset($_POST['todate']))$this->view['todate']="";else $this->view['todate']=$_POST['todate'];
    		    if($this->view['fromdate']=="NULL")$this->view['fromdate']="";
    			if($this->view['todate']=="NULL")$this->view['todate']="";
		    if($this->view['fromdate']!="")$sql.=" and datex>='{$this->view['fromdate']}' ";
			if($this->view['todate']!="")$sql.=" and datex<='{$this->view['todate']}' ";
			    if(!isset($_POST['instructor']))$this->view['instructor']=$this->_user_name;else $this->view['instructor']=$_POST['instructor'];
			if($this->view['instructor']!="")$sql.=" and instructorx='{$this->view['instructor']}' ";
		        if(!isset($_POST['student']))$this->view['student']="";else $this->view['student']=$_POST['student'];
			if($this->view['student']!="")$sql.=" and studentidx='{$this->view['student']}' ";
			$sql.=") a join (select * from tbl_student_view where replace(center,' ','')='".str_replace(' ','',$this->_user_location)."') b on a.studentidx=b.s_Id join tbl_localsmtp c on replace(b.Center,' ','')=replace(c.Center,' ','') where a.idx>0 ";
			if($_POST['search']['value']!=""){
			    $sch=$_POST['search']['value'];
			    $sql.=" and (b.First_Name like '%{$sch}%' or b.Last_Name like '%{$sch}%' or a.datex like '%{$sch}%' or a.sign1x like '%{$sch}%' ".
			    " or a.sign3x like '%{$sch}%' ".
			    " or a.topic1x like '%{$sch}%' or a.topic2x like '%{$sch}%' or a.topic3x like '%{$sch}%' or a.topic4x like '%{$sch}%' or a.topic5x like '%{$sch}%' or a.topic6x like '%{$sch}%' ".
			    " or a.comment1x like '%{$sch}%' or a.comment2x like '%{$sch}%' or a.comment3x like '%{$sch}%' or a.comment4x like '%{$sch}%' or a.comment5x like '%{$sch}%' or a.comment6x like '%{$sch}%' ".
			    "  ) ";
			}
			$sqlrst=$this->import->db->query("select count(*) as cnt {$sql}")->result_array();
			$total=$sqlrst[0]['cnt'];
			$ordercolumn=explode(",","a.datex,b.First_Name,a.sign1x");
			$sql.=" order by {$ordercolumn[$_POST['order'][0]['column']]} {$_POST['order'][0]['dir']}";
			$start=$_POST['start'];$length=$_POST['length'];
			$sql="select a.*,b.First_Name,b.Last_Name,b.Center,c.from_ as internalMail {$sql} limit {$start},{$length}";
			$sqlrst=$this->import->db->query($sql)->result_array();
			//$this->view['sessiondata'] = $this->import->db->query($sql)->result_array();
			//exit($sql);
			
			//exit(1);
			$color=explode(",","primary,success,info");
			$quiz=explode(",","...");
			$colorSys=explode(",","primary,success,info");
			$headerarr=explode(",","session,homework,internal");
			$res=array();$ri=0;
			
			for($i=0;$i<count($sqlrst);$i++){
				$rr = $this->import->getDataList("tbl_report",array('sessionid'=>$sqlrst[$i]['idx']));
				$sqlrst[$i]['reportid0']="";
				$sqlrst[$i]['reportreceiver0']="";
				$sqlrst[$i]['reporttime0']="";
				$sqlrst[$i]['reportid1']="";
				$sqlrst[$i]['reportreceiver1']="";
				$sqlrst[$i]['reporttime1']="";
				$sqlrst[$i]['reportid2']="";
				$sqlrst[$i]['reportreceiver2']="";
				$sqlrst[$i]['reporttime2']="";
				$j1=0;$j2=0;$j3=0;
				for($j=0;$j<count($rr);$j++){
					if($rr[$j]['typex']==0||$rr[$j]['typex']==3){
						$sqlrst[$i]['reportid0'].=($j1==0?"":"##").$rr[$j]['idx'];	
						$sqlrst[$i]['reportreceiver0'].=($j1==0?"":"##").$rr[$j]['receiverx'];	
						$sqlrst[$i]['reporttime0'].=($j1==0?"":"##").$rr[$j]['datex'];	
						$j1=1;
					}
					if($rr[$j]['typex']==1||$rr[$j]['typex']==4){
						$sqlrst[$i]['reportid1'].=($j2==0?"":"##").$rr[$j]['idx'];	
						$sqlrst[$i]['reportreceiver1'].=($j2==0?"":"##").$rr[$j]['receiverx'];
						$sqlrst[$i]['reporttime1'].=($j2==0?"":"##").$rr[$j]['datex'];	
						$j2=1;
					}
					if($rr[$j]['typex']==2){
						$sqlrst[$i]['reportid2'].=($j3==0?"":"##").$rr[$j]['idx'];	
						$sqlrst[$i]['reportreceiver2'].=($j3==0?"":"##").$rr[$j]['receiverx'];	
						$sqlrst[$i]['reporttime2'].=($j3==0?"":"##").$rr[$j]['datex'];	
						$j3=1;
					}
				}
				
				$datearr=explode("-",$sqlrst[$i]['datex']);
				for($ii=1;$ii<7;$ii++){
				    $arr=explode("@",$sqlrst[$i]["topic{$ii}x"]);
				    $descrip[$ii]="";
				    if(count($arr)>1){
				        $descrip[$ii]="{$arr[1]}";
				        if($arr[0]=="PK#"&&isset($this->view['ixldata'][$arr[1]]))$descrip[$ii]=$this->view['ixldata'][$arr[1]];
				    }
				    $ixl[$ii]="";
				    if(count($arr)>1){
				        $ixl[$ii]="{$arr[1]}";
				        if($arr[0]=="PK#"&&isset($this->view['ixlurldata'][$arr[1]]))$ixl[$ii]=$this->view['ixlurldata'][$arr[1]];
				    }
				}
				
				if($this->_user_role==1){
					$res[$ri]['date']="{$datearr[1]}/{$datearr[2]} {$sqlrst[$i]['sign2x']}";
					$res[$ri]['name']= "{$sqlrst[$i]['First_Name']}-{$sqlrst[$i]['Last_Name']}";
					$res[$ri]['check']= "{$sqlrst[$i]['sign3x']}".($sqlrst[$i]['sign1x']!=""&&$sqlrst[$i]['sign3x']!=""?"-":"")."{$sqlrst[$i]['sign1x']}";
				}else{
					$res[$ri]['date']= "<a href=\"#\" onclick=\"goGPN('{$sqlrst[$i]['idx']}');\">{$datearr[1]}/{$datearr[2]} {$sqlrst[$i]['sign2x']}</a>";
					$res[$ri]['name']= "<a href=\"#\" onclick=\"goGPN('{$sqlrst[$i]['idx']}');\">{$sqlrst[$i]['First_Name']}-{$sqlrst[$i]['Last_Name']}</a>";
					$res[$ri]['check']= "<a href=\"#\" onclick=\"goGPN('{$sqlrst[$i]['idx']}');\">{$sqlrst[$i]['sign3x']}".($sqlrst[$i]['sign1x']!=""&&$sqlrst[$i]['sign3x']!=""?"-":"")."{$sqlrst[$i]['sign1x']}</a>";
				}
				$s="";
				//for($i=1;$i<6;$i++)
				//	if($sqlrst[$i]["quiz{$i}x"]==1)echo "<span class=\"badge bg-red\">{$quiz[$i]}</span>";
				for($ii=1;$ii<7;$ii++){
					if($sqlrst[$i]["topic{$ii}x"]!=""){
						$arr=explode("@",$sqlrst[$i]["topic{$ii}x"]);
						$s.= "<span class=\"badge bg-yellow\">{$arr[0]}</span>";
						$s.= "<span class=\"badge bg-green\">{$arr[1]}</span>";
						$s.= "<span class=\"badge bg-red\">{$arr[2]}</span>";
					}
				}
				for($iii=0,$ii=1;$ii<7;$ii++){
					if($sqlrst[$i]["comment{$ii}x"]!=""){
					    //$wrap=10;
					    //for($iii=$wrap;$iii<strlen($sqlrst[$i]["comment{$ii}x"]);$iii+=$wrap){
					        //$sqlrst[$i]["comment{$ii}x"]=substr($sqlrst[$i]["comment{$ii}x"],0,$iii)."<br>".substr($sqlrst[$i]["comment{$ii}x"],$iii);
					        //$wrap+=4;
					    //}
					    if($iii%2)$s.= "<br><font style='color:#244f69;'>".$sqlrst[$i]["comment{$ii}x"]."</font>";
					    else $s.= "<br>".$sqlrst[$i]["comment{$ii}x"]."";
					    $iii++;
					}
				}
				$res[$ri]['content']= "<a href=\"#\" onclick=\"previewcontentpanel('{$datearr[1]}/{$datearr[2]}','{$sqlrst[$i]['timex']}','{$sqlrst[$i]['sign1x']}','{$sqlrst[$i]['sign2x']}','{$sqlrst[$i]['sign3x']}','{$sqlrst[$i]['First_Name']}','{$sqlrst[$i]['Last_Name']}','{$sqlrst[$i]['quiz1x']}','{$sqlrst[$i]['quiz2x']}','{$sqlrst[$i]['quiz3x']}','{$sqlrst[$i]['quiz4x']}','{$sqlrst[$i]['quiz5x']}','{$sqlrst[$i]['quiz1xx']}','{$sqlrst[$i]['quiz2xx']}','{$sqlrst[$i]['quiz3xx']}','{$sqlrst[$i]['quiz4xx']}','{$sqlrst[$i]['quiz5xx']}','{$sqlrst[$i]['topic1x']}','{$sqlrst[$i]['topic2x']}','{$sqlrst[$i]['topic3x']}','{$sqlrst[$i]['topic4x']}','{$sqlrst[$i]['topic5x']}','{$sqlrst[$i]['topic6x']}','{$sqlrst[$i]['comment1x']}','{$sqlrst[$i]['comment2x']}','{$sqlrst[$i]['comment3x']}','{$sqlrst[$i]['comment4x']}','{$sqlrst[$i]['comment5x']}','{$sqlrst[$i]['comment6x']}','{$descrip[1]}','{$descrip[2]}','{$descrip[3]}','{$descrip[4]}','{$descrip[5]}','{$descrip[6]}');\" data-toggle=\"modal\" data-target=\"#previewcontent\">{$s}</a>";
				for($ii=0;$ii<3;$ii++){
					$s="";//$('#msg_session_body').val(\"{$templatedata[$sqlrst[$i]['center']][4]}\");$('#sms_session_body').val(\"{$templatedata[$sqlrst[$i]['center']][1]}\");$('#msg_homework_body').val(\"{$templatedata[$sqlrst[$i]['center']][5]}\");$('#sms_homework_body').val(\"{$templatedata[$sqlrst[$i]['center']][2]}\");
					if($ii==0||($ii==1&&$this->_user['sendable']))$s.="<a href=\"#\"  data-toggle=\"modal\" data-target=\"#modal-resend-{$ii}\" onclick=\"sendAction({$ii},'{$sqlrst[$i]['idx']}','{$sqlrst[$i]['studentidx']}','".str_replace(" ","",$sqlrst[$i]['Center'])."','{$sqlrst[$i]['internalMail']}','{$sqlrst[$i]['sign3x']}','{$datearr[1]}/{$datearr[2]}','{$sqlrst[$i]['timex']}','{$sqlrst[$i]['sign1x']}','{$sqlrst[$i]['sign2x']}','{$sqlrst[$i]['sign3x']}','{$sqlrst[$i]['First_Name']}','{$sqlrst[$i]['Last_Name']}','{$sqlrst[$i]['quiz1x']}','{$sqlrst[$i]['quiz2x']}','{$sqlrst[$i]['quiz3x']}','{$sqlrst[$i]['quiz4x']}','{$sqlrst[$i]['quiz5x']}','{$sqlrst[$i]['quiz1xx']}','{$sqlrst[$i]['quiz2xx']}','{$sqlrst[$i]['quiz3xx']}','{$sqlrst[$i]['quiz4xx']}','{$sqlrst[$i]['quiz5xx']}','{$sqlrst[$i]['topic1x']}','{$sqlrst[$i]['topic2x']}','{$sqlrst[$i]['topic3x']}','{$sqlrst[$i]['topic4x']}','{$sqlrst[$i]['topic5x']}','{$sqlrst[$i]['topic6x']}','{$sqlrst[$i]['comment1x']}','{$sqlrst[$i]['comment2x']}','{$sqlrst[$i]['comment3x']}','{$sqlrst[$i]['comment4x']}','{$sqlrst[$i]['comment5x']}','{$sqlrst[$i]['comment6x']}','{$descrip[1]}','{$descrip[2]}','{$descrip[3]}','{$descrip[4]}','{$descrip[5]}','{$descrip[6]}','{$ixl[1]}','{$ixl[2]}','{$ixl[3]}','{$ixl[4]}','{$ixl[5]}','{$ixl[6]}');\"><span class=\"label label-{$color[$ii]}\">VIEW & SEND</span></a><br>";
					$idarr=explode("##",$sqlrst[$i]["reportid{$ii}"]);
					$rearr=explode("##",$sqlrst[$i]["reportreceiver{$ii}"]);
					$tiarr=explode("##",$sqlrst[$i]["reporttime{$ii}"]);
					//$s="<td>";//.count($idarr).",".count($sqlrst[$i]earr).",".count($tiarr)."<".$sqlrst[$i]["reporttime{$i}"]."><br>";
					for($j=0;$j<count($idarr);$j++){
						//$s.="{$idarr[$j]}";
						if($rearr[$j]!="")$s.="<a href=\"#\" type=\"button\" style=\"line-height: 1px;\"  data-toggle=\"modal\" data-target=\"#previewmondal\" onclick=\"selrow('".$idarr[$j]."','".$ii."','{$sqlrst[$i]['First_Name']}-{$sqlrst[$i]['Last_Name']}','{$tiarr[$j]}','{$rearr[$j]}');\"><!--span class=\"badge bg-primary\"-->{$rearr[$j]}<!--/span--></a><br>";
					}
					$s.="";
					$res[$ri][$headerarr[$ii]]= $s;
				}
				$ri++;
			}
			
			
			echo json_encode(array(
	            //'draw' => draw,
                'recordsFiltered' => $total,
                'recordsTotal' => $total,
                'data' => $res
            ));
		}
		public function getextrareportdata(){//exit(1);
		    if(!isset($_POST['fromdate']))$this->view['fromdate']="";else $this->view['fromdate']=$_POST['fromdate'];
			if(!isset($_POST['todate']))$this->view['todate']="";else $this->view['todate']=$_POST['todate'];
			if($this->view['fromdate']=="NULL")$this->view['fromdate']="";
			if($this->view['todate']=="NULL")$this->view['todate']="";
			if(!isset($_POST['instructor']))$this->view['instructor']=$this->_user_name;else $this->view['instructor']=$_POST['instructor'];
			if(!isset($_POST['student']))$this->view['student']="";else $this->view['student']=$_POST['student'];
			
			$sql=" from (select * from tbl_report where idx>0 ";
			if($this->view['fromdate']!="")$sql.=" and datex>='{$this->view['fromdate']}' ";
			if($this->view['todate']!="")$sql.=" and datex<='{$this->view['todate']}' ";
			if($this->view['instructor']!="")$sql.=" and senderx='{$this->view['instructor']}' ";
			if($this->view['student']!="")$sql.=" and studentidx='{$this->view['student']}' ";
			$sql.=") a join (select * from tbl_student_view where center='{$this->_user_location}') b on a.studentidx=b.s_Id where a.idx>0 ";
			if($_POST['search']['value']!=""){
			    $sch=$_POST['search']['value'];
			    $sql.=" and (b.First_Name like '%{$sch}%' or b.Last_Name like '%{$sch}%' or a.datex like '%{$sch}%' or a.receiverx like '%{$sch}%' ".
			    " or a.subjectx like '%{$sch}%' ".
			    " or a.bodyx like '%{$sch}%' ".
			    "  ) ";
			}
			$rst=$this->import->db->query("select count(*) as cnt {$sql}")->result_array();
			$total=$rst[0]['cnt'];
			$ordercolumn=explode(",","a.datex,b.First_Name,a.receiverx,a.subjectx,a.bodyx");
			$sql.=" order by {$ordercolumn[$_POST['order'][0]['column']]} {$_POST['order'][0]['dir']}";
			$start=$_POST['start'];$length=$_POST['length'];
			$this->view['reportdata'] = $this->import->db->query("select a.*,b.First_Name,b.Last_Name {$sql} limit {$start},{$length}")->result_array();
			//exit($sql);
			$res=array();$ri=0;
		    for($i=0;$i<count($this->view['reportdata']);$i++){
				$res[$ri]=$this->view['reportdata'][$i];
				$res[$ri]['First_Name']=$res[$ri]['First_Name'].'-'.$res[$ri]['Last_Name'];
				$ri++;
			}
			
			
			echo json_encode(array(
	            //'draw' => draw,
                'recordsFiltered' => $total,
                'recordsTotal' => $total,
                'data' => $res
            ));
		}
		
		public function getMessageData(){
			$sql="select * from tbl_report where idx='{$_POST['idx']}'";
			//exit($sql);
			$reportdata = $this->import->db->query($sql)->result_array();
			$result['error'] = "0";
			$result['msg'] = "";
			if(count($reportdata)){
				$result['msg'] = $reportdata[0]['bodyx'];
			}
			echo json_encode($result);	
		}

		public function submitsession(){
			$Fd=array();
			foreach($_POST as $key=>$val){
				if($key!="sessionid")$Fd[$key]=$val;
			}
			$user = $this->session->userdata(USER_INFO);
			if(!isset($user)){
                redirect(URL_PATH);
			}
			$Fd['instructorx']=$user['name'];
			
			for($i=1;$i<6;$i++){
				if(isset($_POST['comment'.$i.'x']))if($_POST['comment'.$i.'x']!=''){
					$tempdata = $this->import->getDataList("tbl_template",array('textx'=>$_POST['comment'.$i.'x'],'typex'=>0,'center'=>$this->_user_location));
					if(count($tempdata)==0)$this->import->db->insert("tbl_template",array('textx'=>$_POST['comment'.$i.'x'],'typex'=>0,'authorx'=>$user['name'],'orderx'=>0,'center'=>$this->_user_location));
				}
			}
			$result['error'] = "0";
			$result['sessionid']=$_POST['sessionid'];
			//$datestr=explode("/",$Fd['datex']);
			//if(count($datestr)>2)$Fd['datex']="{$datestr[2]}-{$datestr[0]}-{$datestr[1]}";
			if($_POST['sessionid']<0){
				$this->import->db->insert("tbl_session",$Fd);
				$tempdata = $this->import->getDataList("tbl_session",array('instructorx'=>$Fd['instructorx'],'studentidx'=>$Fd['studentidx'],'sign1x'=>$Fd['sign1x'],'datex'=>$Fd['datex'],'timex'=>$Fd['timex']));
				if(count($tempdata))$result['sessionid']=$tempdata[0]['idx'];
			}else{
				$this->import->db->where('idx', $_POST['sessionid']);
				$result['error']=$this->import->db->update("tbl_session",$Fd);
				
			}
			$result['error'] = "0";
			$result['msg'] = "Success";
			echo json_encode($result);	
		}

		public function getSessionIdByStdId(){
			//$sessiontempdata = $this->import->getDataList("tbl_session",array('datex'=>$_POST['datex'],'studentidx'=>$_POST['studentidx']));
			$sessiontempdata = $this->import->getDataList("tbl_session",array('studentidx'=>$_POST['studentidx']),array('datex desc'));
			if(count($sessiontempdata)>0){
				$result['error'] = "0";
				$result['sessionid'] = $sessiontempdata[0]['idx'];
			}else{
				$result['error'] = "1";
			}
			echo json_encode($result);	
		}

		public function getParentByStdId(){
			$result['name']='';
			$result['mail']='';
			$result['pnum']='';
			$result['error'] = "1";
			$result['stname']='';
			$parent = $this->import->getDataList("tbl_student_view",array('s_Id'=>$_POST['studentidx']));
			if(count($parent)>0){
				$result['stname']=$parent[0]['First_Name'];
				if($parent[0]['Account']!=""){
					//$parent=explode(",",str_replace(" ","",$parent[0]['Account']));
					$result['error'] = "0";
					//foreach($parent as $p){
						$parentdata = $this->import->getDataList("tbl_guardian_view",array('Account_Name'=>$parent[0]['Account'],'Email_OptOut'=>'False'));
						for($i=0;$i<count($parentdata);$i++){
							$result['name'] .= ($result['name']==""?"":"#").$parentdata[$i]['First_Name'];
							$result['mail'] .= ($result['mail']==""?"":"#"). $parentdata[$i]['Email'];
							$result['pnum'] .= ($result['pnum']==""?"":"#"). $parentdata[$i]['Mobile_Phone'];
						}
						/*$parentdata = $this->import->getDataList("tbl_guardian_view",array('Last_Name'=>$p,'Email_OptOut'=>'False'));
						if(count($parentdata)>0){
							$result['name'] .= ($result['name']==""?"":"#").$parentdata[0]['Last_Name'];
							$result['mail'] .= ($result['mail']==""?"":"#"). $parentdata[0]['Email'];
							$result['pnum'] .= ($result['pnum']==""?"":"#"). $parentdata[0]['Mobile_Phone'];
						}*/
					//}
				}
			}
			$result['url']="";
			$result['description']="";
			//$result['topic']='';
			if(isset($_POST["topic1x"])){
				for($i=1;$i<7;$i++){
					if($_POST["topic{$i}x"]!=""){
						$topic=explode("@",$_POST["topic{$i}x"]);
						if($topic[1]>0){
							
							if($result['description']!="")$result['description'].="##";
							$tempdata = $this->import->getDataList("tbl_ixl",array('pk'=>$topic[1]));
							for($j=0;$j<count($tempdata);$j++){
								$result['url'].=($result['url']==""?"":"##").$tempdata[$j]['ixl_URL'];//echo count($tempdata).">>>";
								$result['description'].=($j>0?",":"").$tempdata[$j]['pk_descrip'];
							}
						}
					}
				}
			}
			echo json_encode($result);	
		}

		public function sendingSmsMessage(){
		    $user = $this->session->userdata(USER_INFO);
		    $instructorname=$user['name'];
				if(isset($_POST['instructor']))$instructorname=$_POST['instructor'];
			$centername=$this->_user_location;
				if(isset($_POST['center']))$centername=$_POST['center'];
		    
		    $configdata = $this->import->db->query("select * from tbl_localsmtp where replace(center,' ','')='".str_replace(' ','',$centername)."'")->result_array();
		    if($configdata[0]['sms_flag']==0){
		        echo "sms disabled!";
		        return;
		    }
			require ROOTPATH.'vendor/autoload.php';
			$data = ['phone' => str_replace(" ","",$_POST['pnum']), 'text' => $_POST['body']];
			
			
			date_default_timezone_set('America/New_York');
			$Fd=array(
				'senderx'=>$instructorname,
				'receiverx'=>$_POST['pnum'],
				'studentidx'=>$_POST['student'],
				'sessionid'=>$_POST['sessionid'],
				'subjectx'=>$_POST['subj'],
				'bodyx'=>$_POST['body'],
				'resultx'=>'',//$res,
				'datex'=>date("Y-m-d H:i:n"),
				'typex'=>$_POST['type']
			);
			$this->import->db->insert("tbl_report",$Fd);
			echo ($this->sendSMS($data,$centername));
		}
		protected function sendSMS($data,$centername) {

				
				
		  $configdata = $this->import->db->query("select * from tbl_localsmtp where replace(center,' ','')='".str_replace(' ','',$centername)."'")->result_array();
		  $sid = $configdata[0]['sms_sid'];
		  //'AC425b0cdd1020c56a20376c99c8619f5d';
		  $token = $configdata[0]['sms_token'];
		  //'5c9b80ef59fc13ca71eaa56a244a4f01';
		  $client = new Client($sid, $token);
		  return $client->messages->create(
			  $data['phone'],
			  array(
				  "from" => $configdata[0]['sms_number'],//"+13012311977",
				  'body' => $data['text']
			  )
		  );
		  
	    }
		public function controlpanel(){
			$user = $this->session->userdata(USER_INFO);
			if(!isset($user)){
                redirect(URL_PATH);
            }
			$this->view['logined_user'] = $user;
			$this->view['_user_name'] = $user;
			$this->view['content'] = 'administrator/controlpanel.php';
			$center=$user['center'];
			if(isset($_POST['selcenter']))
				$center=$_POST['selcenter'];
			$this->view['smtpdata']=$this->import->getDataList("tbl_localsmtp",array("center"=>$center));
			$this->view['centerdata']="";
			if($user['role']==0){
				foreach($this->import->getDataList("tbl_localsmtp") as $r){
					$this->view['centerdata'].=($this->view['centerdata']==""?"":"###").$r['center'];
				}
			}else{
				foreach($this->import->getDataList("user",array("email"=>$user['email'],'removed'=>0)) as $r){
					$this->view['centerdata'].=($this->view['centerdata']==""?"":"###").$r['center'];
				}
			}
			$this->load->view('container.php', $this->view);
		}

		public function sendingEmail(){
		    $user = $this->session->userdata(USER_INFO);
		    $instructorname=$user['name'];
				if(isset($_POST['instructor']))$instructorname=$_POST['instructor'];
			$centername=$this->_user_location;
				if(isset($_POST['center']))$centername=$_POST['center'];
		    
			$result['error'] = "0";
			$result['msg'] = "Success";
			
				$this->load->helper(array('form', 'url'));
				$this->load->library('email');
				/*$this->load->library('mPDF');
				$pdf= new mPDF();
				$data = array();
				//load the view and saved it into $html variable
				//$html = $this->load->view('pdf_output',$data,true);
				//this the the PDF filename that user will get to download
				$pdfFilePath = "output_pdf_name.pdf";
				//generate the PDF from the given html
				$pdf->WriteHTML($_POST['body']);
				$pdf->Output($pdfFilePath,"D");*/
				
				//konfigurasi email
				
				$internalfromdata = $this->import->db->query("select * from tbl_localsmtp where replace(center,' ','')='".str_replace(' ','',$this->_user_location)."'")->result_array();
				$configdata = $this->import->db->query("select * from tbl_localsmtp where replace(center,' ','')='".str_replace(' ','',$centername)."'")->result_array();
				$config = array();
				$config['charset'] = 'utf-8';
				$config['useragent'] = 'Codeigniter';
				$config['protocol']= "smtp";
				$config['mailtype']= "html";
				$config['smtp_host']= $configdata[0]['smtp_host'];//"ssl://mail.arupmathnasium.com";
				$config['smtp_port']= $configdata[0]['smtp_port'];//465;
				$config['smtp_timeout']= "5";
				$config['smtp_user']= $configdata[0]['smtp_user'];//"sales@arupmathnasium.com";
				$config['smtp_pass']=$configdata[0]['smtp_pass'];// "mathmania25";        
				$config['crlf']="\r\n";
				$config['newline']="\r\n";

				$config['wordwrap'] = TRUE;
				
				$this->email->initialize($config);
				$this->email->from($configdata[0]['from_']); //from("arup.mondal@mathnasium.com");
			//	$this->email->from("Mathnasium of {$centername} {$configdata[0]['from_']}");
				$this->email->to($_POST['mail']);
				$this->email->subject($_POST['subj']);
				$this->email->message($_POST['body']);

				date_default_timezone_set('America/New_York');
				
				$Fd=array(
					'senderx'=>$instructorname,
					'receiverx'=>$_POST['mail'],
					'subjectx'=>$_POST['subj'],
					'sessionid'=>$_POST['sessionid'],
					'studentidx'=>$_POST['student'],
					'bodyx'=>$_POST['body'],
					'resultx'=>'',//$res,
					'datex'=>date("Y-m-d H:i:n"),
					'typex'=>$_POST['type']
				);
				$this->import->db->insert("tbl_report",$Fd);

				if($this->email->send()){
					echo $result['msg'] = "Success";
				}
				else{
					echo $result['msg']=str_replace("\n","<br>",$this->email->print_debugger());
					//show_error($this->email->print_debugger());
				}
				//mail($_POST['mail'], $_POST['subj'], $_POST['body']);
			
			//echo json_encode($result);	
		}
		
		function rstemplate(){$this->view['_user_location']=$this->_user_location;
			$this->view['_user_name']=$this->_user_name;
			$this->view['content'] = 'instructor/template_rs.php';
			$templatedata = $this->import->getDataList("tbl_template",array('center'=>$this->_user_location));
			foreach($templatedata as $row){$row['textx']=str_replace("<br>","\n",$row['textx']);
				$this->view['templatedata'][$row['typex']]=$row;
			}
			
			$templatedata = $this->import->getDataList("tbl_template",array('center'=>"SA_SAMPLE"));
			foreach($templatedata as $row){$row['textx']=str_replace("<br>","\n",$row['textx']);
				$this->view['stemplatedata'][$row['typex']]=$row;
			}
			$this->load->view('container.php', $this->view);
		}
		function rmtemplate(){$this->view['_user_location']=$this->_user_location;
			$this->view['_user_name']=$this->_user_name;
			$this->view['content'] = 'instructor/template_rm.php';
			$templatedata = $this->import->getDataList("tbl_template",array('center'=>$this->_user_location));
			$sessiondata=$this->import->getDataList("tbl_session",array(),array("datex desc"));
			foreach($templatedata as $row){$row['textx']=str_replace("<br>","\n",$row['textx']);
				if($row['typex']==7)$this->view['templatedata'][$row['typex']][]=$row;
				else if($row['typex']==0)$this->view['templatedata'][$row['typex']][]=$row;
				else $this->view['templatedata'][$row['typex']]=$row;
			}
			
			$templatedata = $this->import->getDataList("tbl_template",array('center'=>"SA_SAMPLE"));
			foreach($templatedata as $row){$row['textx']=str_replace("<br>","\n",$row['textx']);
				$this->view['stemplatedata'][$row['typex']]=$row;
			}
			
			
			date_default_timezone_set('America/New_York');
			$sqlrst=array(
				"studentx"=>"Arshia",
				"studentidx"=>"",
				"datex"=>date("Y-m-d"),
				"timex"=>"",
				"quiz1x"=>"","quiz2x"=>"","quiz3x"=>"","quiz4x"=>"","quiz5x"=>"","quiz6x"=>"","quiz7x"=>"","quiz8x"=>"","quiz9x"=>"","quiz10x"=>"",
				"quiz1xx"=>"","quiz2xx"=>"","quiz3xx"=>"","quiz4xx"=>"","quiz5xx"=>"","quiz6xx"=>"","quiz7xx"=>"","quiz8xx"=>"","quiz9xx"=>"","quiz10xx"=>"",
				"topic1x"=>"","topic2x"=>"","topic3x"=>"","topic4x"=>"","topic5x"=>"","topic6x"=>"","topic7x"=>"","topic8x"=>"","topic9x"=>"","topic10x"=>"",
				"comment1x"=>"","comment2x"=>"","comment3x"=>"","comment4x"=>"","comment5x"=>"","comment6x"=>"","comment7x"=>"","comment8x"=>"","comment9x"=>"","comment10x"=>"",
				"sign1x"=>"","sign2x"=>"","sign3x"=>""
			);
			if(count($sessiondata)>0)$this->view['sessiondata']=$sessiondata[0];
			$this->load->view('container.php', $this->view);
		}
		function hmtemplate(){$this->view['_user_location']=$this->_user_location;
			$this->view['_user_name']=$this->_user_name;
			$this->view['content'] = 'instructor/template_hm.php';
			$templatedata = $this->import->getDataList("tbl_template",array('center'=>$this->_user_location));
			foreach($templatedata as $row){$row['textx']=str_replace("<br>","\n",$row['textx']);
				$this->view['templatedata'][$row['typex']]=$row;
			}
			
			$templatedata = $this->import->getDataList("tbl_template",array('center'=>"SA_SAMPLE"));
			foreach($templatedata as $row){$row['textx']=str_replace("<br>","\n",$row['textx']);
				$this->view['stemplatedata'][$row['typex']]=$row;
			}
			
			$this->load->view('container.php', $this->view);
		}
		function extemplate(){$this->view['_user_location']=$this->_user_location;
			$this->view['_user_name']=$this->_user_name;
			$this->view['content'] = 'instructor/template_ex.php';
			$templatedata = $this->import->getDataList("tbl_template",array('center'=>$this->_user_location));
			foreach($templatedata as $row){$row['textx']=str_replace("<br>","\n",$row['textx']);
				$this->view['templatedata'][$row['typex']]=$row;
			}
			
			$templatedata = $this->import->getDataList("tbl_template",array('center'=>"SA_SAMPLE"));
			foreach($templatedata as $row){$row['textx']=str_replace("<br>","\n",$row['textx']);
				$this->view['stemplatedata'][$row['typex']]=$row;
			}
			
			$this->load->view('container.php', $this->view);
		}
		function hstemplate(){$this->view['_user_location']=$this->_user_location;
			$this->view['_user_name']=$this->_user_name;
			$this->view['content'] = 'instructor/template_hs.php';
			$templatedata = $this->import->getDataList("tbl_template",array('center'=>$this->_user_location));
			foreach($templatedata as $row){$row['textx']=str_replace("<br>","\n",$row['textx']);
				$this->view['templatedata'][$row['typex']]=$row;
			}
			
			$templatedata = $this->import->getDataList("tbl_template",array('center'=>"SA_SAMPLE"));
			foreach($templatedata as $row){$row['textx']=str_replace("<br>","\n",$row['textx']);
				$this->view['stemplatedata'][$row['typex']]=$row;
			}
			
			$this->load->view('container.php', $this->view);
		}
		function imtemplate(){$this->view['_user_location']=$this->_user_location;
			$this->view['_user_name']=$this->_user_name;
			$this->view['content'] = 'instructor/template_im.php';
			$templatedata = $this->import->getDataList("tbl_template",array('center'=>$this->_user_location));
			foreach($templatedata as $row){
			    $row['textx']=str_replace("<br>","\n",$row['textx']);
				if($row['typex']==7)$this->view['templatedata'][$row['typex']][]=$row;
				else if($row['typex']==0)$this->view['templatedata'][$row['typex']][]=$row;
				else $this->view['templatedata'][$row['typex']]=$row;
			}
			
			$templatedata = $this->import->getDataList("tbl_template",array('center'=>"SA_SAMPLE"));
			foreach($templatedata as $row){$row['textx']=str_replace("<br>","\n",$row['textx']);
				$this->view['stemplatedata'][$row['typex']]=$row;
			}
			
			//$this->view['locationdata'] = $this->import->db->query("select * from tbl_student_view ")->result_array();;
			$locationdata = $this->import->getDataList("tbl_student_view");
			foreach($locationdata as $row){
				$loc=str_replace(" ","",trim($row['Center']));
				if(!isset($this->view['locationdata'][$loc]))$this->view['locationdata'][$loc]=0;
				$this->view['locationdata'][$loc]++;
			}
			$this->load->view('container.php', $this->view);
		}
		public function saveTemplate(){
		    $templatedata = $this->import->getDataList("tbl_template",array('typex'=>$_POST['type'],'center'=>$this->_user_location));
		    $_POST['body']=str_replace("\n","<br>",$_POST['body']);
			if(count($templatedata)>0){
				$this->import->db->where('typex', $_POST['type']);
				$this->import->db->where('center',$this->_user_location);
				echo $result['error']=$this->import->db->update("tbl_template",array('textx'=>$_POST['body'],'authorx'=>$this->_user_name));
			}else{
				echo $this->db->insert("tbl_template",array('textx'=>$_POST['body'],'authorx'=>$this->_user_name,'typex'=>$_POST['type'],'center'=>$this->_user_location));
			}
		}
		function comment(){
		    $this->view['_sel_tab']=0;
		    if(isset($_POST['_sel_tab']))if($_POST['_sel_tab']==7)$this->view['_sel_tab']=$_POST['_sel_tab'];
		    $this->view['_user_location']=$this->_user_location;
			$this->view['_user_name']=$this->_user_name;
			$this->view['_user_center']=$this->_user_location;
			$this->view['content'] = 'instructor/comment.php';
			$this->view['commentdata'] = $this->import->getDataList("tbl_template",array('center'=>$this->_user_location));
			$this->load->view('container.php', $this->view);
		}
		public function saveIMTemp(){
			$templatedata = $this->import->getDataList("tbl_template",array('textx'=>$_POST['body'],'typex'=>$_POST['type'],'center'=>$this->_user_location));
			if(count($templatedata)==0)
				echo $this->db->insert("tbl_template",array('textx'=>$_POST['body'],'authorx'=>$this->_user_name,'typex'=>$_POST['type'],'center'=>$this->_user_location));
			else echo 1;
		}
		public function deleteIMTemp(){
			$this->db->delete("tbl_template",array('idx'=>$_POST['idx']));
			echo 1;
		}
	}

	
	




