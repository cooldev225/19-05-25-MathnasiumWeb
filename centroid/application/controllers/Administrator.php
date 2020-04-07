<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

	class Administrator extends MY_Controller{
		public $view = array();
		function __construct(){
			parent::__construct();
			$this->load->database();
			$this->load->model('import_Model', 'import');
			$this->view['header'] = 'header.php';
			
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
			
			$this->view['sidebar'] = 'sidebar.php';
			$this->view['footer'] = 'footer.php';
			
			
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
		
		public function sendsmsview(){
		    $user = $this->session->userdata(USER_INFO);
			if(!isset($user)){
                redirect(URL_PATH);
            }
			$this->view['_user_name'] = $user;
			$this->view['content'] = 'administrator/excel1.php';
			
			$user = $this->session->userdata(USER_INFO);
			$centername=$this->_user_location;
		    $configdata = $this->import->db->query("select * from tbl_localsmtp where replace(center,' ','')='".str_replace(' ','',$centername)."'")->result_array();
		    $this->view['sid111'] = $configdata[0]['sms_sid'];
		    $this->view['token'] = $configdata[0]['sms_token'];
		    $this->view['fromnumber']=$configdata[0]['sms_number'];
		   // exit($centername.">".$configdata[0]['sms_sid']);
		    
			$this->load->view('container.php', $this->view);
		}public function sendsmsaction(){
			require ROOTPATH.'vendor/autoload.php';
			  $client = new Client($_POST['sid'], $_POST['token']);
    		  return $client->messages->create(
    			  $_POST['tonumber'],
    			  array(
    				  "from" => $_POST['fromnumber'],//"+13012311977",
    				  'body' => $_POST['smsbody']
    			  )
    		  );
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
		public function studentreport(){
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
			
			$this->view['studentdata'] = $this->import->db->query("select * from tbl_student_view where replace(center,' ','')='".str_replace(' ','',$this->_user_location)."'")->result_array();
			if(!isset($_POST['fromdate']))$this->view['fromdate']="";else $this->view['fromdate']=$_POST['fromdate'];
			if(!isset($_POST['todate']))$this->view['todate']="";else $this->view['todate']=$_POST['todate'];
			if($this->view['fromdate']=="NULL")$this->view['fromdate']="";
			if($this->view['todate']=="NULL")$this->view['todate']="";
			if(!isset($_POST['instructor']))$this->view['instructor']=$this->_user_name;else $this->view['instructor']=$_POST['instructor'];
			if(!isset($_POST['student']))$this->view['student']="";else $this->view['student']=$_POST['student'];
			if(isset($_POST['viewidx']))$this->view['viewidx']=$_POST['viewidx'];else $this->view['viewidx']="";
			if(isset($_POST['viewdatex']))$this->view['viewdatex']=$_POST['viewdatex'];else $this->view['viewdatex']="";			
			$this->load->view('container.php', $this->view);
		}
		public function chgcenter(){
		    $nowuser = $this->session->userdata(USER_INFO);
			if(!isset($nowuser)){
                redirect(URL_PATH);
			}
			$nowuser['center']=$_GET['c'];
		    $this->session->set_userdata(USER_INFO, $nowuser);
		    if("instructor/dailygame.php"==$_GET['p'])redirect(URL_PATH.'administrator/index');
		    else if("instructor/extrahomework.php"==$_GET['p'])redirect(URL_PATH.'administrator/extrahomework');
		    else if("instructor/reportexe.php"==$_GET['p'])redirect(URL_PATH.'administrator/studentreport');
		    else if("administrator/excel.php"==$_GET['p'])redirect(URL_PATH.'administrator/excelimport');
		    else if("instructor/template_rs.php"==$_GET['p'])redirect(URL_PATH.'administrator/rstemplate');
		    else if("instructor/template_rm.php"==$_GET['p'])redirect(URL_PATH.'administrator/rmtemplate');
		    else if("instructor/template_hs.php"==$_GET['p'])redirect(URL_PATH.'administrator/hstemplate');
		    else if("instructor/template_hm.php"==$_GET['p'])redirect(URL_PATH.'administrator/hmtemplate');
		    else if("instructor/template_im.php"==$_GET['p'])redirect(URL_PATH.'administrator/imtemplate');
		    else if("administrator/viewuser.php"==$_GET['p'])redirect(URL_PATH.'administrator/viewuser');
		    else if("administrator/adduser.php"==$_GET['p'])redirect(URL_PATH.'administrator/adduser');
		    else if("administrator/controlpanel.php"==$_GET['p'])redirect(URL_PATH.'administrator/controlpanel');
		    else redirect(URL_PATH.'administrator/index');
		    
		}
		
		
		
		public function index(){
		    $user = $this->session->userdata(USER_INFO);
			if(!isset($user)){
                redirect(URL_PATH);
            }
            
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
			$sql.=" order by a.datex desc";//exit($sql);
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

		public function viewuser(){
			$user = $this->session->userdata(USER_INFO);
			if(!isset($user)){
                redirect(URL_PATH);
            }
			$this->view['_user_name'] = $user;
			$this->view['content'] = 'administrator/viewuser.php';
			//if($user['role']==0){
			//	$this->view['admindata'] = $this->import->getDataList("user",array("role"=>"1",'removed'=>0));
			//	$this->view['instructordata'] = $this->import->getDataList("user",array("role"=>"2",'removed'=>0));
			//	$this->view['parentdata'] = $this->import->getDataList("user",array("role"=>"3",'removed'=>0));
			//}else{
				//$this->view['admindata'] = $this->import->getDataList("user",array("role"=>">0","role"=>"1","center"=>$user['center'],'removed'=>0));
				//$this->view['instructordata'] = $this->import->getDataList("user",array("role"=>"2","center"=>$user['center'],'removed'=>0));
				//$this->view['parentdata'] = $this->import->getDataList("user",array("role"=>"3","center"=>$user['center'],'removed'=>0));
				$arr=$this->import->getDataList("user",array('removed'=>0));
				$this->view['admindata']=array();
				$this->view['instructordata']=array();
				$this->view['parentdata']=array();
				$this->view['removeddata']=$this->import->getDataList("user",array('removed'=>1));
				foreach($arr as $r){
				    $f=0;
				    if(str_replace(" ","",$r['center'])==str_replace(" ","",$user['center']))$f=1;
				    if($f==0){
				        $arrr=$this->import->getDataList("tbl_location_permission",array('email'=>$r['email'],'center'=>$user['center']));
				        if(count($arrr)>0)$f=1;
				    }
				    if($f==1){
    				    if($r['role']==0|$r['role']==1){
    				        $this->view['admindata'][]=$r;
    				    }else if($r['role']==2){
    				        $this->view['instructordata'][]=$r;
    				    }else if($r['role']==3){
    				        $this->view['parentdata'][]=$r;
    				    }
				    }
				    
				}
			//}
			$this->view['state'] = array("request","accept","reject");
			
			
			//$this->view['centerpermission']="BurlingtonLexington###Ellicott City";
			$this->view['centeremail']="";$prev="";
			foreach($this->import->getDataList("user",array('removed'=>0),array("email")) as $r){
				if($user['role']!=3){
				    if($r['email']!=$prev){
				        $prev=$r['email'];$f=0;
				        foreach(explode("###",$this->view['centerpermission']) as $c){
    				        if($c==$r['center']){
    				            $f=1;
    				            break;
    				        }
				        }
				        if($f)$this->view['centeremail'].=($this->view['centeremail']==""?"":"###").$r['name'].",".$r['email'];
				    }        
			    }
			}
			$rst = $this->import->getDataList("tbl_location_permission",array(),array('center'));
			foreach($rst as $r){
			    if(!isset($this->view['addedlocation'][$r['email']]))$this->view['addedlocation'][$r['email']]=$r['center'];
			    else $this->view['addedlocation'][$r['email']].=",".$r['center'];
			    //echo $r['email'].",".$this->view['addedlocation'][$r['email']].">>";
			}//exit();
			$this->view['tab']="1";if(isset($_GET['tab']))$this->view['tab']=$_GET['tab'];
			$this->load->view('container.php', $this->view);
		}
		public function getlocation(){//num,rolename,email,location,actioin
		    $rs = $this->import->getDataList("tbl_location_permission",array(),array('email','center'));
		    $role=explode(",","SuperAdmin,LocalAdmin,Instructor,Parent");
		    for($i=0;$i<count($rs);$i++){
		        $rs[$i]['rolename']=$role[$rs[$i]['role']];
		        $us = $this->import->getDataList("user",array('email'=>$rs[$i]['email'],'removed'=>0),array('role'));
		        $rs[$i]['baselocation']=$us[0]['center'];
		        if(!isset($hash[$rs[$i]['email']]))$hash[$rs[$i]['email']]="";
		        if(!isset($cnt[$rs[$i]['email']]))$cnt[$rs[$i]['email']]=1;else $cnt[$rs[$i]['email']]++;
		        if($hash[$rs[$i]['email']]!=""){
		            $hash[$rs[$i]['email']].=",";
		            if(isset($prev[$rs[$i]['email']]))$delr[$prev[$rs[$i]['email']]]=1;
		        }
		        $prev[$rs[$i]['email']]=$i;
		        $hash[$rs[$i]['email']].=$rs[$i]['center'];
		        $rs[$i]['location']=$hash[$rs[$i]['email']];
		        $rs[$i]['num']=$cnt[$rs[$i]['email']];
		        $rs[$i]['action']="<button onclick='deleteLocation(\"{$rs[$i]['email']}\");' type='button' class='btn bg-maroon btn-xs'>delete</button>";
		    }
		    foreach(explode('###',$this->view['centerpermission']) as $pc)$perm[$pc]=1;
		    $rrs=array();$rrscnt=0;
		    for($i=0;$i<count($rs);$i++)if(!isset($delr[$i])){
		        $f=0;
		        foreach(explode(',',$rs[$i]['location']) as $pc)if(isset($perm[$pc])){$f=1;break;}
		        if($f==1){
                    $rrs[$rrscnt]=$rs[$i];
                    $rrs[$rrscnt]['num']=$rrscnt+1;
                    $rrscnt++;
    		    }
		    }
            echo json_encode($rrs);
		}
		public function addlocation(){
		    $rs = $this->import->getDataList("user",array('email'=>$_POST['email'],'removed'=>0),array('role'));
		    if($_POST['center']==$rs[0]['center'])exit('no');
		    $role=$rs[0]['role'];
		    $rs = $this->import->getDataList("tbl_location_permission",array('email'=>$_POST['email'],'center'=>$_POST['center']));
		    if(count($rs)==0){
		        $this->import->db->insert('tbl_location_permission',array('email'=>$_POST['email'],'center'=>$_POST['center'],'role'=>$role));
		        echo json_encode(array("res"=>"ok"));
		    }else echo "duplicate";
		}
		public function deletelocation(){
		    if(!isset($_POST['center'])){
		        $rs=$this->import->getDataList("tbl_location_permission",array('email'=>$_POST['email']),array("center"));
	            $this->import->db->delete('tbl_location_permission',array('email'=>$_POST['email'],'center'=>$rs[count($rs)-1]['center']));
		    }else{
		        $this->import->db->delete('tbl_location_permission',array('email'=>$_POST['email'],'center'=>$_POST['center']));
	            echo json_encode(array("res"=>"ok"));
		    }
		}
		public function islocationcenter(){
		    $rs=$this->import->getDataList('tbl_location_permission',array('email'=>$_POST['email'],'center'=>$_POST['center']));
	        echo json_encode(array("res"=>count($rs)));
		}
        
		public function excelimport(){
			$user = $this->session->userdata(USER_INFO);
			if(!isset($user)){
                redirect(URL_PATH);
            }
			$this->view['_user_name'] = $user;
			$this->view['content'] = 'administrator/excel.php';
			$this->load->view('container.php', $this->view);
		}

		public function importStudent($fid){
			$user = $this->session->userdata(USER_INFO);
			if(!isset($user)){
                redirect(URL_PATH);
            }
			$this->view['_user_name'] = $user;
			$fname=explode(",","student,account,guardian,ixl");
			$this->view['content'] = 'administrator/excel.php';
			if (isset($_FILES["{$fname[$fid]}file"])) {
				$path= './uploads/';
				$config['upload_path'] = $path;
				$config['allowed_types'] = 'xlsx|xls|jpg|png';
				$config['remove_spaces'] = TRUE;
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				//unlink("$path{$_FILES["{$fname[$fid]}file"]['name']}");
				if (!$this->upload->do_upload("{$fname[$fid]}file")) {
					$this->view['error'] = $this->upload->display_errors();
					redirect(URL_PATH."administrator/excelimport");
					
				} else {
					$data = array('upload_data' => $this->upload->data());
				}

				if (!empty($data['upload_data']['file_name'])) {
					$import_xls_file = $data['upload_data']['file_name'];
				} else {
					$import_xls_file = $data['upload_data']['file_name'];
				}
				$inputFileName = $path . $import_xls_file;
				try {
					$inputFileType = PHPExcel_IOFactory::identify($inputFileName);
					$objReader = PHPExcel_IOFactory::createReader($inputFileType);
					$objPHPExcel = $objReader->load($inputFileName);
				} catch (Exception $e) {
					die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME).'": ' . $e->getMessage());
				}
				$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);

				$arrayCount = count($allDataInSheet);
				$flag = 0;
				$createArray=array('StudentId', 'FirstName', 'LastName');
				$makeArray = array('StudentId' => 's_Id', 'FirstName' => 'First_Name', 'LastName' => 'Last_Name');
				if($fid==0){
					$createArray=array('StudentId', 'FirstName', 'LastName','MailingStreet1'	,'MailingStreet2',	'MailingCity',	'MailingState',	'MailingCountry',	'MailingZipCode',	'BillingStreet1',	'BillingStreet2',	'BillingCity',	'BillingState',	'BillingCountry',	'BillingZipCode',	'Grade',	'SchoolYear',	'SchoolId','School',	'Teacher',	'TeacherId',	'LeadId',	'Account',   'EnrollmentStatus',	'EnrollmentStartDate',	'EnrollmentEndDate',	'LastAttendanceDate'	,'LastPRSent',	'Gender','DateofBirth',	'Description',	'ConsenttoMediaRelease',	'ConsenttoContactTeacher'	,'ConsenttoLeaveUnescorted',	'EmergencyContact',	'EmergencyPhone',	'MedicalInformation',	'Scholarship'	,'School[WebLead]'	,'Teacher[WebLead]',	'CreatedBy',	'CreatedDate',	'LastModifiedBy',	'LastModifiedOn',	'Center');//,	'Center1');
					$makeArray = array('StudentId'=>'s_Id', 'FirstName'=>'First_Name', 'LastName'=>'Last_Name','MailingStreet1'=>'Mailing_Street1'	,'MailingStreet2'=>'Mailing_Street2',	'MailingCity'=>'Mailing_City',	'MailingState'=>'Mailing_State',	'MailingCountry'=>'Mailing_Country',	'MailingZipCode'=>'Mailing_Zip_Code',	'BillingStreet1'=>'Billing_Street1',	'BillingStreet2'=>'Billing_Street2',	'BillingCity'=>'Billing_City',	'BillingState'=>'Billing_State',	'BillingCountry'=>'Billing_Country',	'BillingZipCode'=>'Billing_Zip_Code',	'Grade'=>'Grade',	'SchoolYear'=>'School_Year',	'SchoolId'=>'School_Id',	'School'=>'School',	'Teacher'=>'Teacher',	'TeacherId'=>'Teacher_Id',	'LeadId'=>'Lead_Id',	'Account'=>'Account', 'EnrollmentStatus'=>'Enrollment_Status',	'EnrollmentStartDate'=>'Enrollment_Start_Date',	'EnrollmentEndDate'=>'Enrollment_End_Date',	'LastAttendanceDate'=>'Last_Attendance_Date'	,'LastPRSent'=>'Last_PR_Sent',	'Gender'=>'Gender','DateofBirth'=>'Date_of_Birth',	'Description'=>'Description',	'ConsenttoMediaRelease'=>'Consent_to_Media_Release',	'ConsenttoContactTeacher'=>'Consent_to_Contact_Teacher'	,'ConsenttoLeaveUnescorted'=>'Consent_to_Leave_Unescorted',	'EmergencyContact'=>'Emergency_Contact',	'EmergencyPhone'=>'Emergency_Phone',	'MedicalInformation'=>'Medical_Information',	'Scholarship'=>'Scholarship'	,'School[WebLead]'=>'School_WebLead'	,'Teacher[WebLead]'=>'Teacher_WebLead',	'CreatedBy'=>'Created_By',	'CreatedDate'=>'Created_Date',	'LastModifiedBy'=>'Last_Modified_By',	'LastModifiedOn'=>'Last_Modified_On',	'Center'=>'Center');//,	'Center1'=>'Center1');
				}else if($fid==1){
					$createArray=array('FirstName','LastName','Center',	'MobilePhone'	,'AccountId',	'EnrollmentStatus'	,'EmailAddress'	,'HomePhone',	'OtherPhone',	'BillingStreet1'	,'BillingStreet2'	,'BillingCity'	,'BillingState'	,'BillingZipCode'	,'BillingCountry',	'DateofBirth',	'CreatedBy',	'Description'	,'LastModifiedBy'	,'MailingStreet1'	,'MailingStreet2',	'MailingCity','MailingState',	'MailingZipCode'	,'MailingCountry',	'CustomerComments'	,'EmergencyPhoneNumber',	'LastTriMathlonReg.Date',	'ReferralAccount'	,'AccountRelation'	,'EmergencyContact'	,'LastModifiedBy'	,'LastModifiedDate',	'CreatedDate');
					$makeArray = array('FirstName'=>'First_Name','LastName'=>'Last_Name','Center'=>'Center','MobilePhone'=>'Mobile_Phone','AccountId'=>'Account_Id','EnrollmentStatus'=>'Enrollment_Status'	,'EmailAddress'=>'Email_Address'	,'HomePhone'=>'Home_Phone',	'OtherPhone'=>'Other_Phone',	'BillingStreet1'=>'Billing_Street1'	,'BillingStreet2'=>'Billing_Street2'	,'BillingCity'=>'Billing_City'	,'BillingState'=>'Billing_State'	,'BillingZipCode'=>'Billing_Zip_Code'	,'BillingCountry'=>'Billing_Country',	'DateofBirth'=>'Date_of_Birth',	'CreatedBy'=>'Created_By',	'Description'=>'Description'	,'LastModifiedBy'=>'Last_Modified_By'	,'MailingStreet1'=>'Mailing_Street1'	,'MailingStreet2'=>'Mailing_Street2',	'MailingCity'=>'Mailing_City','MailingState'=>'Mailing_State',	'MailingZipCode'=>'Mailing_Zip_Code'	,'MailingCountry'=>'Mailing_Country',	'CustomerComments'=>'Customer_Comments'	,'EmergencyPhoneNumber'=>'Emergency_Phone_Number',	'LastTriMathlonReg.Date'=>'Last_TriMathlon_Reg_Date',	'ReferralAccount'=>'Referral_Account'	,'AccountRelation'=>'Account_Relation'	,'EmergencyContact'=>'Emergency_Contact'	,'LastModifiedBy'=>'Last_Modified_By'	,'LastModifiedDate'=>'Last_Modified_Date',	'CreatedDate'=>'Created_Date');
				}else  if($fid==2){//lblCenterId                          Center Id
					$createArray=array('GuardianId','FirstName','LastName','LeadId','AccountName','MobilePhone','Email','MailingStreet1','MailingStreet2','City','State','ZipCode','Country','Center','CenterId','BlockedEmails','CreatedDate','EmailOptOut','OtherPhone','CreatedBy','Description','Gender','LastModifiedBy','Phone','Relation','Salutation','LastModifiedDate');
					$makeArray = array('GuardianId'=>'Guardian_Id','FirstName'=>'First_Name','LastName'=>'Last_Name','LeadId'=>'Lead_Id','AccountName'=>'Account_Name','MobilePhone'=>'Mobile_Phone','Email'=>'Email','MailingStreet1'=>'Mailing_Street1','MailingStreet2'=>'Mailing_Street2','City'=>'City','State'=>'State','ZipCode'=>'Zip_Code','Country'=>'Country','Center'=>'Center','CenterId'=>'lblCenterId','BlockedEmails'=>'Blocked_Emails','CreatedDate'=>'Created_Date','EmailOptOut'=>'Email_OptOut','OtherPhone'=>'Other_Phone','CreatedBy'=>'Created_By','Description'=>'Description','Gender'=>'Gender','LastModifiedBy'=>'Last_Modified_By','Phone'=>'Phone','Relation'=>'Relation','Salutation'=>'Salutation','LastModifiedDate'=>'Last_Modified_Date');
				}else if($fid==3){
					$createArray=array('pk','pk-descrip','Hints','ixl_pretty_code','ixl_description','ixl_URL');
					$makeArray = array('pk'=>'pk','pk-descrip'=>'pk_descrip','Hints'=>'Hints','ixl_pretty_code'=>'ixl_pretty_code','ixl_description'=>'ixl_description','ixl_URL'=>'ixl_URL');
				}
				$SheetDataKey = array();
				foreach ($allDataInSheet as $dataInSheet) {
					$f=0;
					foreach ($dataInSheet as $key => $value) {
						$value = preg_replace('/\s+/', '', $value);
						
						if (in_array($value, $createArray)) {

							$SheetDataKey[trim($value)] = $key;
							$f=1;
						}
					}
					if($f)break;
				}
				//$data = array_diff_key($makeArray, $SheetDataKey);
				foreach ($makeArray as $key => $value) {
					$flag=0;
					foreach ($SheetDataKey as $key1 => $value1) {
    					if($key==$key1){
    						$flag=1;
    						break;
    					}
					}
					if(!$flag)break;
				}
				if(1){//$flag){
				    $fetchData=array();
					for ($i = 2; $i <= $arrayCount; $i++) {
						if(isset($SheetDataKey["Center"])&&$user['role']){
						$v1=str_replace(" ","",$allDataInSheet[$i][$SheetDataKey["Center"]]);
						$v2=str_replace(" ","",$user['center']);
						//if($i<10)
						
						if($v1!=$v2)continue;
						//echo $v1.",".$v2."<br>";
						}
						$row = array();
						foreach ($makeArray as $key => $field){
						    //echo "testing 1";
						    //echo $SheetDataKey[$key];
							$row[$field]=$allDataInSheet[$i][$SheetDataKey[$key]];}
						$fetchData[]=$row;
					}
					//echo $user;
					$data['employeeInfo'] = $fetchData;
					//echo count($fetchData);
					$this->import->importData("tbl_{$fname[$fid]}",$fetchData,$user['role'],$user['center']);

				} else {
					$this->view['error'] = "Please import correct file";
					redirect(URL_PATH."administrator/excelimport");
					exit();
				}
			}else{
				$this->view['error'] = "Please select file";
				redirect(URL_PATH."administrator/excelimport");
				exit();
			}
			redirect(URL_PATH."administrator/excelimport");
		}

		public function adduser(){
			$user = $this->session->userdata(USER_INFO);
			if(!isset($user)){
                redirect(URL_PATH);
            }
			$this->view['_user_name'] = $user;
			$this->view['content'] = 'administrator/adduser.php';
			$this->view['instructordata'] = $this->import->getDataList("tbl_account");
			$this->view['parentdata'] = $this->import->getDataList("tbl_guardian");
			$this->load->view('container.php', $this->view);
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
			if(isset($_POST['selcenter']))$center=$_POST['selcenter'];
			$this->view['smtpdata']=$this->import->getDataList("tbl_localsmtp",array("center"=>$center));
			$this->view['ipdata']=$this->import->getDataList("tbl_ipinterlock",array("center"=>$center));
			$this->view['selcenter']=$center;
			$this->view['centerdata']="";
			if($user['role']==0){
				foreach($this->import->getDataList("tbl_localsmtp",array(),array("center")) as $r){
					$this->view['centerdata'].=($this->view['centerdata']==""?"":"###").$r['center'];
				}
        		$this->view['superdata']=array();
    			foreach(explode("###",$this->view['centerdata']) as $r){
    			    $r=str_replace(' ','',$r);
    				$st=$this->import->db->query("select count(*) as cnt from tbl_student where replace(center,' ','')='{$r}'")->result_array();
			        $ste=$this->import->db->query("select count(*) as cnt from tbl_student where replace(Enrollment_Status,' ','')='Enrolled' and replace(center,' ','')='{$r}'")->result_array();
    				$s=$this->import->getDataList("tbl_location",array('center'=>$r));
    				if(!count($s)){
    				    $this->import->db->insert("tbl_location",array('center'=>$r,'active0'=>1,'active1'=>1,'active2'=>1,'active3'=>1,'sending'=>1,'overhead'=>""));
    				}
    				$this->import->db->update("tbl_location",array('enrolled'=>$st[0]['cnt'],'enrolled1'=>$ste[0]['cnt']),array('center'=>$r));
    				$s=$this->import->getDataList("tbl_location",array('center'=>$r));
    			    $this->view['superdata'][$r]=$s[0];
    			}
			}else{
				foreach($this->import->getDataList("user",array("email"=>$user['email'],'removed'=>0)) as $r){
					$this->view['centerdata'].=($this->view['centerdata']==""?"":"###").$r['center'];
				}
			}
			$this->view['active_tab']=1;
			if(isset($_POST['active_tab']))$this->view['active_tab']=$_POST['active_tab'];
			$this->load->view('container.php', $this->view);
		}
		public function smtpsave(){
			$user = $this->session->userdata(USER_INFO);
			if(!isset($user)){
                redirect(URL_PATH);
            }
			$table="tbl_localsmtp";
			$Fd=array(
				'smtp_host'=>$_POST['host'],
				'smtp_user'=>$_POST['user'],
				'smtp_port'=>$_POST['port'],
				'from_'=>$_POST['frome'],//$user['email'],
				'smtp_pass'=>$_POST['pass'],
				'sms_number'=>$_POST['number'],
				'sms_sid'=>$_POST['sid'],
				'sms_token'=>$_POST['token'],
				'sms_flag'=>$_POST['sflag']
			);
			$where=array('center'=>$_POST['center']);
			if(count($this->import->getDataList($table,$where))){
				$this->import->db->update($table,$Fd,$where);
			}else{
				$Fd['center']=$where['center'];
				$this->import->db->insert($table,$Fd);
			}
			echo "1";
		}
		public function submituser(){
		    $_POST['removed']=0;
			$user = $this->session->userdata(USER_INFO);
			if(!isset($user)){
                redirect(URL_PATH);
            }
			$this->view['_user_name'] = $user;
			$this->form_validation->set_rules('r_username', 'Username', 'required');
			$this->form_validation->set_rules('r_password', 'Password', 'required');
			$this->form_validation->set_rules('r_email', 'Email', 'required');
			$this->form_validation->set_rules('r_repeatpwd', 'Repeatpwd', 'required');
			if (0&&$this->form_validation->run() == FALSE)
			{
				$result['error'] = "1";
				$result['msg'] = "Please fill all fields.";
			}
			else
			{
				//if(count($this->import->getDataList("user",array("name"=>$_POST['r_username'],'removed'=>0)))>0){//registed user name
			    //exit(json_encode(array("error"=>"2","msg"=>"Please fill name field again")));
				//}
				if(count($this->import->getDataList("user",array("email"=>$_POST['r_email'],'removed'=>0)))>0){
				//if(count($this->import->getDataList("user",array("email"=>$_POST['r_email'],'removed'=>0,"role"=>$_POST['r_role'],"name"=>$_POST['r_username'],"center"=>$_POST['center'])))>0){//registed user name
					exit(json_encode(array("error"=>"3","msg"=>"Duplicated user!!!")));
				}
				$this->load->model('User_Model', 'user');
				if($this->user->userRegister($_POST)){
					$result['error'] = "0";
					$result['msg'] = "Success";
				}else{
					$result['error'] = "4";
					$result['msg'] = "Invalid user";
				}
			}
			echo json_encode($result);			
		}

		public function setuser(){
			$user = $this->session->userdata(USER_INFO);
			if(!isset($user)){
                redirect(URL_PATH);
            }
			
			$id="";
			$role="";
			if(isset($_POST['id']))$id=$_POST['id'];
			if(isset($_POST['role']))$role=$_POST['role'];
			$this->load->model('User_Model', 'user');
			if($id!=""){
				if($role=="1")$this->user->db->update('user', array("state"=>"1"),array("id"=>$id));
				else if($role=="2")$this->user->db->update('user', array("state"=>"2"),array("id"=>$id));
				else if($role=="3"){
				    //$this->user->db->delete('user', array("id"=>$id));
				    $this->user->db->update('user', array("removed"=>"1"),array("id"=>$id));
				}
			}
			//redirect(URL_PATH."administrator/viewuser");
		}
		
		public function setiplock(){
			$user = $this->session->userdata(USER_INFO);
			if(!isset($user)){
                redirect(URL_PATH);
            }
			
			$id="";
			if(isset($_POST['id']))$id=$_POST['id'];
			$this->load->model('User_Model', 'user');
			if($id!=""){
				$this->user->db->query("update user set ip_lock=1-ip_lock where id='{$id}'");
				echo 1;
			}
			echo 0;
		}
		
		public function setipaddress(){
			$user = $this->session->userdata(USER_INFO);
			if(!isset($user)){
                redirect(URL_PATH);
            }
			$res=0;
			$fd=array("center"=>$_POST['center'],"ip"=>$_POST['ip']);
			if($_POST['flag']==1)$this->import->db->delete("tbl_ipinterlock",$fd);
			else if($_POST['flag']==0){
			    if($this->import->getDataList("tbl_ipinterlock",$fd))$res=1;
			    else $this->import->db->insert("tbl_ipinterlock",$fd);
			}
			echo $res;
		}
		
		public function activesave(){
			$field=explode(",","active0,active1,active2,active3,sending,overhead");
			$sql="update tbl_location set ";
			if($_POST['flag']<5)$sql.="{$field[$_POST['flag']]}=1-{$field[$_POST['flag']]}";
			else $sql.="{$field[$_POST['flag']]}='{$_POST['value']}'";
			$sql.=" where center='{$_POST['center']}'";
		    $this->import->db->query($sql);
			echo 1;
		}
		
		
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		function rstemplate(){$this->view['_user_location']="Sample";
			//$this->view['_user_name']=$this->_user_name;
			$this->view['content'] = 'instructor/template_rs.php';
			$this->view['_user_location']=$center=$this->_user_location;
			if($this->_user_role==0){$center="SA_SAMPLE";$this->view['_user_location']="<font style=\"color:red;\">Sample</font>";}
			$templatedata = $this->import->getDataList("tbl_template",array('center'=>$center));
			foreach($templatedata as $row){$row['textx']=str_replace("<br>","\n",$row['textx']);
				$this->view['templatedata'][$row['typex']]=$row;
			}
			$this->load->view('container.php', $this->view);
		}
		function rmtemplate(){$this->view['_user_location']="Sample";
			//$this->view['_user_name']=$this->_user_name;
			$this->view['content'] = 'instructor/template_rm.php';
			$this->view['_user_location']=$center=$this->_user_location;
			if($this->_user_role==0){$center="SA_SAMPLE";$this->view['_user_location']="<font style=\"color:red;\">Sample</font>";}
			$templatedata = $this->import->getDataList("tbl_template",array('center'=>$center));
			$sessiondata=$this->import->getDataList("tbl_session",array(),array("datex desc"));
			foreach($templatedata as $row){$row['textx']=str_replace("<br>","\n",$row['textx']);
				if($row['typex']==7)$this->view['templatedata'][$row['typex']][]=$row;
				else if($row['typex']==0)$this->view['templatedata'][$row['typex']][]=$row;
				else $this->view['templatedata'][$row['typex']]=$row;
			}
			date_default_timezone_set('America/New_York');
			$this->view['sessiondata']=array(
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
		function hmtemplate(){$this->view['_user_location']="Sample";
			//$this->view['_user_name']=$this->_user_name;
			$this->view['content'] = 'instructor/template_hm.php';
			$this->view['_user_location']=$center=$this->_user_location;
			if($this->_user_role==0){$center="SA_SAMPLE";$this->view['_user_location']="<font style=\"color:red;\">Sample</font>";}
			$templatedata = $this->import->getDataList("tbl_template",array('center'=>$center));
			foreach($templatedata as $row){$row['textx']=str_replace("<br>","\n",$row['textx']);
				$this->view['templatedata'][$row['typex']]=$row;
			}
			$this->load->view('container.php', $this->view);
		}
		function extemplate(){$this->view['_user_location']="Sample";
			//$this->view['_user_name']=$this->_user_name;
			$this->view['content'] = 'instructor/template_ex.php';
			$this->view['_user_location']=$center=$this->_user_location;
			if($this->_user_role==0){$center="SA_SAMPLE";$this->view['_user_location']="<font style=\"color:red;\">Sample</font>";}
			$templatedata = $this->import->getDataList("tbl_template",array('center'=>$center));
			foreach($templatedata as $row){$row['textx']=str_replace("<br>","\n",$row['textx']);
				$this->view['templatedata'][$row['typex']]=$row;
			}
			$this->load->view('container.php', $this->view);
		}
		function hstemplate(){$this->view['_user_location']="Sample";
			//$this->view['_user_name']=$this->_user_name;
			$this->view['content'] = 'instructor/template_hs.php';
			$this->view['_user_location']=$center=$this->_user_location;
			if($this->_user_role==0){$center="SA_SAMPLE";$this->view['_user_location']="<font style=\"color:red;\">Sample</font>";}
			$templatedata = $this->import->getDataList("tbl_template",array('center'=>$center));
			foreach($templatedata as $row){$row['textx']=str_replace("<br>","\n",$row['textx']);
				$this->view['templatedata'][$row['typex']]=$row;
			}
			$this->load->view('container.php', $this->view);
		}
		function imtemplate(){
			//$this->view['_user_name']=$this->_user_name;
			$this->view['content'] = 'instructor/template_im.php';
			$this->view['_user_location']=$center=$this->_user_location;
			if($this->_user_role==0){$center="SA_SAMPLE";$this->view['_user_location']="<font style=\"color:red;\">Sample</font>";}
			$templatedata = $this->import->getDataList("tbl_template",array('center'=>$center));
			foreach($templatedata as $row){
			    $row['textx']=str_replace("<br>","\n",$row['textx']);
				if($row['typex']==7)$this->view['templatedata'][$row['typex']][]=$row;
				else if($row['typex']==0)$this->view['templatedata'][$row['typex']][]=$row;
				else $this->view['templatedata'][$row['typex']]=$row;
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
		    $nowuser = $this->session->userdata(USER_INFO);
			if(!isset($nowuser)){
                redirect(URL_PATH);
			}
			$this->view['_user_location']=$center=$this->_user_location;
			if($this->_user_role==0){$center="SA_SAMPLE";$this->view['_user_location']="<font style=\"color:red;\">Sample</font>";}
		    $templatedata = $this->import->getDataList("tbl_template",array('typex'=>$_POST['type'],'center'=>$center));
		    $_POST['body']=str_replace("\n","<br>",$_POST['body']);
			if(count($templatedata)>0){
				$this->import->db->where('typex', $_POST['type']);
				$this->import->db->where('center',$center);
				echo $result['error']=$this->import->db->update("tbl_template",array('textx'=>$_POST['body'],'authorx'=>$nowuser['name']));
			}else{
				echo $this->db->insert("tbl_template",array('textx'=>$_POST['body'],'authorx'=>$nowuser['name'],'typex'=>$_POST['type'],'center'=>$center));
			}
		}
	}
	




