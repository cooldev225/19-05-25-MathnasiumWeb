<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

	class Parentx extends MY_Controller{
		public $view = array();
		public $_user_name="";
		function __construct(){
			parent::__construct();
			$this->load->database();
			$this->load->model('import_Model', 'import');
			$this->view['header'] = 'header.php';
			$this->view['sidebar'] = 'parent_sidebar.php';
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
			$this->_user_name=$user;
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
		
		public function chgcenter(){
		    $nowuser = $this->session->userdata(USER_INFO);
			if(!isset($nowuser)){
                redirect(URL_PATH);
			}
			$nowuser['center']=$_GET['c'];
		    $this->session->set_userdata(USER_INFO, $nowuser);
		    redirect(URL_PATH.'parentx/index');
		}

		public function index1(){
		    if(isset($_GET['f']))if($_GET['f']==1)$this->view['confirm_msg']="Please update your default password from 'welcome1'.";
			$this->view['content'] = 'parent/report.php';
			$this->view['_user_name'] = $this->_user_name;
			$this->view['_user_sendable']=$this->_user_name['sendable'];
			$user = $this->session->userdata(USER_INFO);
			if(!isset($user)){
                redirect(URL_PATH);
            }
            
            $templatedata = $this->import->getDataList("tbl_template");
			$this->view['templatedata']=array();
			foreach($templatedata as $r){
			    if($r['typex']==1||$r['typex']==2||$r['typex']==4||$r['typex']==5)
			    $this->view['templatedata'][]=$r;
			}
			
			$this->view['userdata'] = $this->import->getDataList("user");
			$ixldata = $this->import->getDataList("tbl_ixl");
			$this->view['ixldata']=array();
			foreach($ixldata as $r){
			    $this->view['ixldata'][$r['pk']]=(isset($this->view['ixldata'][$r['pk']])?",":"").$r['pk_descrip'];    
			    $this->view['ixlurldata'][$r['pk']]=(isset($this->view['ixldata'][$r['pk']])?"##":"").$r['ixl_URL'];    
			}
			$this->view['studentdata'] = $this->import->db->query("SELECT * FROM `student_by_parent` where pemail='{$user['email']}' ")->result_array();//and replace(center,' ','')='".str_replace(' ','',$user['center'])."'
			$sql="select a.*,b.First_Name,b.Last_Name,b.pFirst_Name,b.pLast_Name,b.pemail,b.pphone,b.center,c.name as iname from tbl_session a join student_by_parent b on a.studentidx=b.s_Id join user c on a.instructorx=c.name where a.idx>0 ";
			if(!isset($_POST['fromdate']))$this->view['fromdate']="";else $this->view['fromdate']=$_POST['fromdate'];
			if(!isset($_POST['todate']))$this->view['todate']="";else $this->view['todate']=$_POST['todate'];
			if($this->view['fromdate']=="NULL")$this->view['fromdate']="";
			if($this->view['todate']=="NULL")$this->view['todate']="";
			//if(!isset($_POST['instructor']))$this->view['instructor']=$this->_user_name;else $this->view['instructor']=$_POST['instructor'];
			if(!isset($_POST['student']))$this->view['student']="";else $this->view['student']=$_POST['student'];
			if($this->view['fromdate']!="")$sql.=" and a.datex>='{$this->view['fromdate']}' ";
			if($this->view['todate']!="")$sql.=" and a.datex<='{$this->view['todate']}' ";
			//if($this->view['instructor']!="")$sql.=" and a.instructorx='{$this->view['instructor']}' ";
			if($this->view['student']!="")$sql.=" and a.studentidx='{$this->view['student']}' ";
			else{
			    $sql.=" and b.pemail='{$user['email']}'";
			}
			//$sql.=" and replace(b.center,' ','')='".str_replace(' ','',$user['center'])."'";
			$sql.=" order by a.datex desc";//exit($sql);
			$this->view['sessiondata'] = $this->import->db->query($sql)->result_array();
			for($i=0;$i<count($this->view['sessiondata']);$i++){
				$rr = $this->import->getDataList("tbl_report",array('sessionid'=>$this->view['sessiondata'][$i]['idx']),array('datex desc'));
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
				$this->view['sessiondata'][$i]['reporttwice0']="";
				$this->view['sessiondata'][$i]['reporttwice1']="";
				$this->view['sessiondata'][$i]['reporttwice2']="";
				for($j=0;$j<count($rr);$j++){
					if($rr[$j]['typex']==0||$rr[$j]['typex']==3){
						$this->view['sessiondata'][$i]['reportid0'].=($j1==0?"":"##").$rr[$j]['idx'];	
						$this->view['sessiondata'][$i]['reportreceiver0'].=($j1==0?"":"##").$rr[$j]['receiverx'];	
						$this->view['sessiondata'][$i]['reporttime0'].=($j1==0?"":"##").$rr[$j]['datex'];	
						if(!isset($this->view['sessiondata'][$i][0][$rr[$j]['receiverx']])){
						    $this->view['sessiondata'][$i][0][$rr[$j]['receiverx']]=1;
						    if(isset($this->view['sessiondata'][$i]['reporttwice0']))$this->view['sessiondata'][$i]['reporttwice0'].="@@";
						    else $this->view['sessiondata'][$i]['reporttwice0']="";
						    $this->view['sessiondata'][$i]['reporttwice0'].=$rr[$j]['idx']."##".$rr[$j]['receiverx']."##".$rr[$j]['datex'];
						}
						$j1=1;
					}
					if($rr[$j]['typex']==1||$rr[$j]['typex']==4){
						$this->view['sessiondata'][$i]['reportid1'].=($j2==0?"":"##").$rr[$j]['idx'];	
						$this->view['sessiondata'][$i]['reportreceiver1'].=($j2==0?"":"##").$rr[$j]['receiverx'];
						$this->view['sessiondata'][$i]['reporttime1'].=($j2==0?"":"##").$rr[$j]['datex'];	
						if(!isset($this->view['sessiondata'][$i][1][$rr[$j]['receiverx']])){
						    if(isset($this->view['sessiondata'][$i]['reporttwice1']))$this->view['sessiondata'][$i]['reporttwice1'].="@@";
						    else $this->view['sessiondata'][$i]['reporttwice1']="";
						    $this->view['sessiondata'][$i][1][$rr[$j]['receiverx']]=1;
						    $this->view['sessiondata'][$i]['reporttwice1'].=$rr[$j]['idx']."##".$rr[$j]['receiverx']."##".$rr[$j]['datex'];
						}
						$j2=1;
					}
					if($rr[$j]['typex']==2){
						$this->view['sessiondata'][$i]['reportid2'].=($j3==0?"":"##").$rr[$j]['idx'];	
						$this->view['sessiondata'][$i]['reportreceiver2'].=($j3==0?"":"##").$rr[$j]['receiverx'];	
						$this->view['sessiondata'][$i]['reporttime2'].=($j3==0?"":"##").$rr[$j]['datex'];	
						if(!isset($this->view['sessiondata'][$i][2][$rr[$j]['receiverx']])){
						    if(isset($this->view['sessiondata'][$i]['reporttwice2']))$this->view['sessiondata'][$i]['reporttwice2'].="@@";
						    else $this->view['sessiondata'][$i]['reporttwice2']="";
						    $this->view['sessiondata'][$i][2][$rr[$j]['receiverx']]=1;
						    $this->view['sessiondata'][$i]['reporttwice2'].=$rr[$j]['idx']."##".$rr[$j]['receiverx']."##".$rr[$j]['datex'];
						}
						$j3=1;
					}
				}
			}
			//$this->view['reportdata'] = $this->import->getDataList("tbl_report",);
			if(isset($_POST['viewidx']))$this->view['viewidx']=$_POST['viewidx'];else $this->view['viewidx']="";
			if(isset($_POST['viewdatex']))$this->view['viewdatex']=$_POST['viewdatex'];else $this->view['viewdatex']="";			
			$this->load->view('container.php', $this->view);
			
		}
		
		public function index(){
		    
			$this->view['content'] = 'parent/reportexe.php';
			$this->view['_user_name'] = $this->_user_name;
			$this->view['_user_sendable']=$this->_user_name['sendable'];
			$user = $this->session->userdata(USER_INFO);
			if(!isset($user)){
                redirect(URL_PATH);
            }
            
            $templatedata = $this->import->getDataList("tbl_template");
			$this->view['templatedata']=array();
			foreach($templatedata as $r){
			    if($r['typex']==1||$r['typex']==2||$r['typex']==4||$r['typex']==5)
			    $this->view['templatedata'][]=$r;
			}
			
			$this->view['userdata'] = $this->import->getDataList("user",array('removed'=>0));
			
			$this->view['studentdata'] = $this->import->db->query("SELECT * FROM `student_by_parent` where pemail='{$user['email']}' ")->result_array();//and replace(center,' ','')='".str_replace(' ','',$user['center'])."'
			
			if(!isset($_POST['fromdate']))$this->view['fromdate']="";else $this->view['fromdate']=$_POST['fromdate'];
			if(!isset($_POST['todate']))$this->view['todate']="";else $this->view['todate']=$_POST['todate'];
			if($this->view['fromdate']=="NULL")$this->view['fromdate']="";
			if($this->view['todate']=="NULL")$this->view['todate']="";
			if(!isset($_POST['student']))$this->view['student']="";else $this->view['student']=$_POST['student'];
			if(isset($_POST['viewidx']))$this->view['viewidx']=$_POST['viewidx'];else $this->view['viewidx']="";
			if(isset($_POST['viewdatex']))$this->view['viewdatex']=$_POST['viewdatex'];else $this->view['viewdatex']="";			
			
			//if(isset($_GET['f']))if($_GET['f']==1){
		    if(md5("welcome1")==$user['password']){
		    //    $this->view['confirm_msg']="Excuse me, You must update your default password 'welcome1' to a new one.";
		    //    $this->session->sess_destroy();
		    }
		    $this->load->view('container.php', $this->view);
		}
		public function getreportdata(){
		    $this->view['_user_name'] = $this->_user_name;
			$user = $this->session->userdata(USER_INFO);
			if(!isset($user)){
                redirect(URL_PATH);
            }
            
            $templatedata = $this->import->getDataList("tbl_template");
			$this->view['templatedata']=array();
			foreach($templatedata as $r){
			    if($r['typex']==1||$r['typex']==2||$r['typex']==4||$r['typex']==5)
			    $this->view['templatedata'][]=$r;
			}
			
			$this->view['userdata'] = $this->import->getDataList("user",array('removed'=>0));
			$ixldata = $this->import->getDataList("tbl_ixl");
			$this->view['ixldata']=array();
			foreach($ixldata as $r){
			    $this->view['ixldata'][$r['pk']]=(isset($this->view['ixldata'][$r['pk']])?",":"").$r['pk_descrip'];    
			    $this->view['ixlurldata'][$r['pk']]=(isset($this->view['ixldata'][$r['pk']])?"##":"").$r['ixl_URL'];    
			}
			
			$this->view['studentdata'] = $this->import->db->query("SELECT * FROM `student_by_parent` where pemail='{$user['email']}' ")->result_array();//and replace(center,' ','')='".str_replace(' ','',$user['center'])."'
			$sql=" from tbl_session a join student_by_parent b on a.studentidx=b.s_Id join user c on a.instructorx=c.name where a.idx>0 ";
			if(!isset($_POST['fromdate']))$this->view['fromdate']="";else $this->view['fromdate']=$_POST['fromdate'];
			if(!isset($_POST['todate']))$this->view['todate']="";else $this->view['todate']=$_POST['todate'];
			if($this->view['fromdate']=="NULL")$this->view['fromdate']="";
			if($this->view['todate']=="NULL")$this->view['todate']="";
			if(!isset($_POST['student']))$this->view['student']="";else $this->view['student']=$_POST['student'];
			if($this->view['fromdate']!="")$sql.=" and a.datex>='{$this->view['fromdate']}' ";
			if($this->view['todate']!="")$sql.=" and a.datex<='{$this->view['todate']}' ";
			//if($this->view['instructor']!="")$sql.=" and a.instructorx='{$this->view['instructor']}' ";
			if($this->view['student']!=""){
			    $sql=str_replace("tbl_session","(select * from tbl_session where studentidx='{$this->view['student']}')",$sql);
			    $sql=str_replace("student_by_parent","(select * from student_by_parent where s_Id='{$this->view['student']}')",$sql);
			}else{
			    $sql=str_replace("student_by_parent","(select * from student_by_parent where pemail='{$user['email']}')",$sql);
			}//			$sql.=" order by a.datex desc";
			
			
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
			$sql="select a.*,b.First_Name,b.Last_Name,b.pFirst_Name,b.pLast_Name,b.pemail,b.pphone,b.center,c.name as iname {$sql} limit {$start},{$length}";
			
		//	exit($sql);
			$sessiondata = $this->import->db->query($sql)->result_array();
			$res=array();
			for($i=0;$i<count($sessiondata);$i++){
				$rr = $this->import->getDataList("tbl_report",array('sessionid'=>$sessiondata[$i]['idx']),array('datex desc'));
				$sessiondata[$i]['reportid0']="";
				$sessiondata[$i]['reportreceiver0']="";
				$sessiondata[$i]['reporttime0']="";
				$sessiondata[$i]['reportid1']="";
				$sessiondata[$i]['reportreceiver1']="";
				$sessiondata[$i]['reporttime1']="";
				$sessiondata[$i]['reportid2']="";
				$sessiondata[$i]['reportreceiver2']="";
				$sessiondata[$i]['reporttime2']="";
				$j1=0;$j2=0;$j3=0;
				$sessiondata[$i]['reporttwice0']="";
				$sessiondata[$i]['reporttwice1']="";
				$sessiondata[$i]['reporttwice2']="";
				
				$color=explode(",","primary,success,info");
				$quiz=explode(",","...");
				$colorSys=explode(",","primary,success,info");
				
				
				for($j=0;$j<count($rr);$j++){
					if($rr[$j]['typex']==0||$rr[$j]['typex']==3){
						$sessiondata[$i]['reportid0'].=($j1==0?"":"##").$rr[$j]['idx'];	
						$sessiondata[$i]['reportreceiver0'].=($j1==0?"":"##").$rr[$j]['receiverx'];	
						$sessiondata[$i]['reporttime0'].=($j1==0?"":"##").$rr[$j]['datex'];	
						if(!isset($sessiondata[$i][0][$rr[$j]['receiverx']])){
						    $sessiondata[$i][0][$rr[$j]['receiverx']]=1;
						    if(isset($sessiondata[$i]['reporttwice0']))$sessiondata[$i]['reporttwice0'].="@@";
						    else $sessiondata[$i]['reporttwice0']="";
						    $sessiondata[$i]['reporttwice0'].=$rr[$j]['idx']."##".$rr[$j]['receiverx']."##".$rr[$j]['datex'];
						}
						$j1=1;
					}
					if($rr[$j]['typex']==1||$rr[$j]['typex']==4){
						$sessiondata[$i]['reportid1'].=($j2==0?"":"##").$rr[$j]['idx'];	
						$sessiondata[$i]['reportreceiver1'].=($j2==0?"":"##").$rr[$j]['receiverx'];
						$sessiondata[$i]['reporttime1'].=($j2==0?"":"##").$rr[$j]['datex'];	
						if(!isset($sessiondata[$i][1][$rr[$j]['receiverx']])){
						    if(isset($sessiondata[$i]['reporttwice1']))$sessiondata[$i]['reporttwice1'].="@@";
						    else $sessiondata[$i]['reporttwice1']="";
						    $sessiondata[$i][1][$rr[$j]['receiverx']]=1;
						    $sessiondata[$i]['reporttwice1'].=$rr[$j]['idx']."##".$rr[$j]['receiverx']."##".$rr[$j]['datex'];
						}
						$j2=1;
					}
					if($rr[$j]['typex']==2){
						$sessiondata[$i]['reportid2'].=($j3==0?"":"##").$rr[$j]['idx'];	
						$sessiondata[$i]['reportreceiver2'].=($j3==0?"":"##").$rr[$j]['receiverx'];	
						$sessiondata[$i]['reporttime2'].=($j3==0?"":"##").$rr[$j]['datex'];	
						if(!isset($sessiondata[$i][2][$rr[$j]['receiverx']])){
						    if(isset($sessiondata[$i]['reporttwice2']))$sessiondata[$i]['reporttwice2'].="@@";
						    else $sessiondata[$i]['reporttwice2']="";
						    $sessiondata[$i][2][$rr[$j]['receiverx']]=1;
						    $sessiondata[$i]['reporttwice2'].=$rr[$j]['idx']."##".$rr[$j]['receiverx']."##".$rr[$j]['datex'];
						}
						$j3=1;
					}
				}
				
				for($iiiii=1;$iiiii<7;$iiiii++){
				    $arr=explode("@",$sessiondata[$i]["topic{$iiiii}x"]);
				    $descrip[$iiiii]="";
				    if(count($arr)>1){
				        $descrip[$iiiii]="{$arr[1]}";
				        if($arr[0]=="PK#"&&isset($ixldata[$arr[1]]))$descrip[$iiiii]=$ixldata[$arr[1]];
				    }
				    $ixl[$iiiii]="";
				    if(count($arr)>1){
				        $ixl[$iiiii]="{$arr[1]}";
				        if($arr[0]=="PK#"&&isset($ixlurldata[$arr[1]]))$ixl[$iiiii]=$ixlurldata[$arr[1]];
				    }
				}
				$datearr=explode("-",$sessiondata[$i]['datex']);
				$res[$i]['date']= "<a href=\"#\" onclick=\"previewcontentpanel('{$datearr[1]}/{$datearr[2]}','{$sessiondata[$i]['timex']}','{$sessiondata[$i]['sign1x']}','{$sessiondata[$i]['sign2x']}','{$sessiondata[$i]['sign3x']}','{$sessiondata[$i]['First_Name']}','{$sessiondata[$i]['Last_Name']}','{$sessiondata[$i]['quiz1x']}','{$sessiondata[$i]['quiz2x']}','{$sessiondata[$i]['quiz3x']}','{$sessiondata[$i]['quiz4x']}','{$sessiondata[$i]['quiz5x']}','{$sessiondata[$i]['quiz1xx']}','{$sessiondata[$i]['quiz2xx']}','{$sessiondata[$i]['quiz3xx']}','{$sessiondata[$i]['quiz4xx']}','{$sessiondata[$i]['quiz5xx']}','{$sessiondata[$i]['topic1x']}','{$sessiondata[$i]['topic2x']}','{$sessiondata[$i]['topic3x']}','{$sessiondata[$i]['topic4x']}','{$sessiondata[$i]['topic5x']}','{$sessiondata[$i]['topic6x']}','{$sessiondata[$i]['comment1x']}','{$sessiondata[$i]['comment2x']}','{$sessiondata[$i]['comment3x']}','{$sessiondata[$i]['comment4x']}','{$sessiondata[$i]['comment5x']}','{$sessiondata[$i]['comment6x']}','{$descrip[1]}','{$descrip[2]}','{$descrip[3]}','{$descrip[4]}','{$descrip[5]}','{$descrip[6]}');\" data-toggle=\"modal\" data-target=\"#previewcontent\">{$datearr[1]}/{$datearr[2]} {$sessiondata[$i]['sign2x']}</a>";
				$res[$i]['name']= "<a href=\"#\" onclick=\"previewcontentpanel('{$datearr[1]}/{$datearr[2]}','{$sessiondata[$i]['timex']}','{$sessiondata[$i]['sign1x']}','{$sessiondata[$i]['sign2x']}','{$sessiondata[$i]['sign3x']}','{$sessiondata[$i]['First_Name']}','{$sessiondata[$i]['Last_Name']}','{$sessiondata[$i]['quiz1x']}','{$sessiondata[$i]['quiz2x']}','{$sessiondata[$i]['quiz3x']}','{$sessiondata[$i]['quiz4x']}','{$sessiondata[$i]['quiz5x']}','{$sessiondata[$i]['quiz1xx']}','{$sessiondata[$i]['quiz2xx']}','{$sessiondata[$i]['quiz3xx']}','{$sessiondata[$i]['quiz4xx']}','{$sessiondata[$i]['quiz5xx']}','{$sessiondata[$i]['topic1x']}','{$sessiondata[$i]['topic2x']}','{$sessiondata[$i]['topic3x']}','{$sessiondata[$i]['topic4x']}','{$sessiondata[$i]['topic5x']}','{$sessiondata[$i]['topic6x']}','{$sessiondata[$i]['comment1x']}','{$sessiondata[$i]['comment2x']}','{$sessiondata[$i]['comment3x']}','{$sessiondata[$i]['comment4x']}','{$sessiondata[$i]['comment5x']}','{$sessiondata[$i]['comment6x']}','{$descrip[1]}','{$descrip[2]}','{$descrip[3]}','{$descrip[4]}','{$descrip[5]}','{$descrip[6]}');\" data-toggle=\"modal\" data-target=\"#previewcontent\">{$sessiondata[$i]['First_Name']}-{$sessiondata[$i]['Last_Name']}</a>";
				$res[$i]['check']= "<a href=\"#\" onclick=\"previewcontentpanel('{$datearr[1]}/{$datearr[2]}','{$sessiondata[$i]['timex']}','{$sessiondata[$i]['sign1x']}','{$sessiondata[$i]['sign2x']}','{$sessiondata[$i]['sign3x']}','{$sessiondata[$i]['First_Name']}','{$sessiondata[$i]['Last_Name']}','{$sessiondata[$i]['quiz1x']}','{$sessiondata[$i]['quiz2x']}','{$sessiondata[$i]['quiz3x']}','{$sessiondata[$i]['quiz4x']}','{$sessiondata[$i]['quiz5x']}','{$sessiondata[$i]['quiz1xx']}','{$sessiondata[$i]['quiz2xx']}','{$sessiondata[$i]['quiz3xx']}','{$sessiondata[$i]['quiz4xx']}','{$sessiondata[$i]['quiz5xx']}','{$sessiondata[$i]['topic1x']}','{$sessiondata[$i]['topic2x']}','{$sessiondata[$i]['topic3x']}','{$sessiondata[$i]['topic4x']}','{$sessiondata[$i]['topic5x']}','{$sessiondata[$i]['topic6x']}','{$sessiondata[$i]['comment1x']}','{$sessiondata[$i]['comment2x']}','{$sessiondata[$i]['comment3x']}','{$sessiondata[$i]['comment4x']}','{$sessiondata[$i]['comment5x']}','{$sessiondata[$i]['comment6x']}','{$descrip[1]}','{$descrip[2]}','{$descrip[3]}','{$descrip[4]}','{$descrip[5]}','{$descrip[6]}');\" data-toggle=\"modal\" data-target=\"#previewcontent\">{$sessiondata[$i]['sign1x']}".($sessiondata[$i]['sign1x']!=""&&$sessiondata[$i]['sign3x']!=""?"-":"")."{$sessiondata[$i]['sign3x']}</a>";
				$s="";
				for($iiiii=1;$iiiii<7;$iiiii++){
					if($sessiondata[$i]["topic{$iiiii}x"]!=""){
						$arr=explode("@",$sessiondata[$i]["topic{$iiiii}x"]);
						$s.= "<span class=\"badge bg-yellow\">{$arr[0]}</span>";
						$s.= "<span class=\"badge bg-green\">{$arr[1]}</span>";
						$s.= "<span class=\"badge bg-red\">{$arr[2]}</span>";
					}
				}
				$kk=0;
				for($iiiiii=0,$iiiii=1;$iiiii<7;$iiiii++){//
					if($sessiondata[$i]["comment{$iiiii}x"]!=""){
					    //if($kk>0)$s.=",";$kk=1;
					    if($iiiiii%2)$s.= "<br><font style='color:#244f69;'>".$sessiondata[$i]["comment{$iiiii}x"]."</font>";
					    else $s.= "<br>".$sessiondata[$i]["comment{$iiiii}x"]."";
					    $iiiiii++;
					}
				}
				//$s="";
				$res[$i]['content']= "<a href=\"#\" onclick=\"previewcontentpanel('{$datearr[1]}/{$datearr[2]}','{$sessiondata[$i]['timex']}','{$sessiondata[$i]['sign1x']}','{$sessiondata[$i]['sign2x']}','{$sessiondata[$i]['sign3x']}','{$sessiondata[$i]['First_Name']}','{$sessiondata[$i]['Last_Name']}','{$sessiondata[$i]['quiz1x']}','{$sessiondata[$i]['quiz2x']}','{$sessiondata[$i]['quiz3x']}','{$sessiondata[$i]['quiz4x']}','{$sessiondata[$i]['quiz5x']}','{$sessiondata[$i]['quiz1xx']}','{$sessiondata[$i]['quiz2xx']}','{$sessiondata[$i]['quiz3xx']}','{$sessiondata[$i]['quiz4xx']}','{$sessiondata[$i]['quiz5xx']}','{$sessiondata[$i]['topic1x']}','{$sessiondata[$i]['topic2x']}','{$sessiondata[$i]['topic3x']}','{$sessiondata[$i]['topic4x']}','{$sessiondata[$i]['topic5x']}','{$sessiondata[$i]['topic6x']}','{$sessiondata[$i]['comment1x']}','{$sessiondata[$i]['comment2x']}','{$sessiondata[$i]['comment3x']}','{$sessiondata[$i]['comment4x']}','{$sessiondata[$i]['comment5x']}','{$sessiondata[$i]['comment6x']}','{$descrip[1]}','{$descrip[2]}','{$descrip[3]}','{$descrip[4]}','{$descrip[5]}','{$descrip[6]}');\" data-toggle=\"modal\" data-target=\"#previewcontent\">{$s}</a>";
				for($iiiii=0;$iiiii<2;$iiiii++){
					$s="";
					if($iiiii==0||($iiiii==1&&$this->_user_name['sendable']))$s.="<a href=\"#\"  data-toggle=\"modal\" data-target=\"#modal-resend-{$iiiii}\" onclick=\"sendAction({$iiiii},'{$sessiondata[$i]['idx']}','{$sessiondata[$i]['studentidx']}','".str_replace(" ","",$sessiondata[$i]['center'])."','{$sessiondata[$i]['iname']}','{$sessiondata[$i]['sign3x']}','{$sessiondata[$i]['pFirst_Name']}','{$sessiondata[$i]['pemail']}','{$sessiondata[$i]['pphone']}','{$datearr[1]}/{$datearr[2]}','{$sessiondata[$i]['timex']}','{$sessiondata[$i]['sign1x']}','{$sessiondata[$i]['sign2x']}','{$sessiondata[$i]['sign3x']}','{$sessiondata[$i]['First_Name']}','{$sessiondata[$i]['Last_Name']}','{$sessiondata[$i]['quiz1x']}','{$sessiondata[$i]['quiz2x']}','{$sessiondata[$i]['quiz3x']}','{$sessiondata[$i]['quiz4x']}','{$sessiondata[$i]['quiz5x']}','{$sessiondata[$i]['quiz1xx']}','{$sessiondata[$i]['quiz2xx']}','{$sessiondata[$i]['quiz3xx']}','{$sessiondata[$i]['quiz4xx']}','{$sessiondata[$i]['quiz5xx']}','{$sessiondata[$i]['topic1x']}','{$sessiondata[$i]['topic2x']}','{$sessiondata[$i]['topic3x']}','{$sessiondata[$i]['topic4x']}','{$sessiondata[$i]['topic5x']}','{$sessiondata[$i]['topic6x']}','{$sessiondata[$i]['comment1x']}','{$sessiondata[$i]['comment2x']}','{$sessiondata[$i]['comment3x']}','{$sessiondata[$i]['comment4x']}','{$sessiondata[$i]['comment5x']}','{$sessiondata[$i]['comment6x']}','{$descrip[1]}','{$descrip[2]}','{$descrip[3]}','{$descrip[4]}','{$descrip[5]}','{$descrip[6]}','{$ixl[1]}','{$ixl[2]}','{$ixl[3]}','{$ixl[4]}','{$ixl[5]}','{$ixl[6]}');\"><span class=\"label label-".($iiiii==0?"primary":"success")."\">VIEW & SEND</span></a><br>";
					
					$twicearr=explode("@@",$sessiondata[$i]["reporttwice{$iiiii}"]);
					for($j=0;$j<count($twicearr);$j++){
					    $temparr=explode("##",$twicearr[$j]);
					    if(count($temparr)<3)continue;
					    $idd=$temparr[0];$ree=$temparr[1];$tii=$temparr[2];
					    $s.="<a href=\"#\" type=\"button\" style=\"line-height: 1px;\"  data-toggle=\"modal\" data-target=\"#previewmondal\" onclick=\"selrow('".$idd."','".$iiiii."','{$sessiondata[$i]['First_Name']}-{$sessiondata[$i]['Last_Name']}','{$tii}','{$ree}');\"><!--span class=\"badge bg-primary\"-->{$ree}<!--/span--></a><br>";
					}
					if($iiiii==0)$res[$i]['session']= $s;
					else $res[$i]['homework']= $s;
				}
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
	}
	




