<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Twilio\Rest\Client;
class Login extends MY_Controller {
    
    public $data = array();

    function __construct(){
        parent::__construct();
        $this->load->database();
		$this->load->model('import_Model', 'import');
    }
	
	public function index(){
        $this->data['error'] = 0;
        $user = $this->session->userdata(USER_INFO);
        if(isset($user)){
            if($user['role'] == 1){
                redirect(URL_PATH.'administrator/viewuser');
            }else if($user['role'] == 2){
                redirect(URL_PATH.'instructor/index');
            }else{
                redirect(URL_PATH.'parentx/index');
            }
        }else{
            $this->load->view('login', $this->data);
        }
    }
    
    public function forget(){
        $this->data['error'] = 0;
        $this->data['centerdata']="";
        foreach($this->user_model->db->query("select * from user group by center ")->result_array() as $r){
			$this->data['centerdata'].=($this->data['centerdata']==""?"":"###").$r['center'];
		}
        $user = $this->session->userdata(USER_INFO);
        if(isset($user)){
            if($user['role'] == 1){
                redirect(URL_PATH.'administrator/index');
            }else if($user['role'] == 2){
                redirect(URL_PATH.'instructor/index');
            }else{
                redirect(URL_PATH.'parentx/index');
            }
        }else{
            $this->load->view('forget', $this->data);
        }
    }
    
    public function forgetin(){
        $this->data['error'] = 0;
        $this->data['status'] = 0;
        $code=(ord(substr($str=md5($_POST['email']),3%strlen($str),1))%9+1).(ord(substr($str,12%strlen($str),1))%7+1).(ord(substr($str,5%strlen($str),1))%9+1).(ord(substr($str,2352%strlen($str),1))%9+1).(ord(substr($str,56%strlen($str),1))%8+1);
        if($_POST['status']==0){
            $user = $this->import->getDataList("user",array('email'=>$_POST['email'],'removed'=>0));
            if(count($user)==0){
				$_POST['role'] = 3;
				$username="";
				$center="";
				$parent = $this->import->getDataList("tbl_guardian",array('Email'=>$_POST['email']));
				if(count($parent)>0){
					$username=$parent[0]['First_Name'];
					$center=str_replace(" ","",$parent[0]['Center']);
				}else{
					$parent = $this->import->getDataList("tbl_account",array('Email_Address'=>$_POST['email']));
					if(count($parent)>0){
						$username=$parent[0]['First_Name'];
						$center=str_replace(" ","",$parent[0]['Center']);
					}
				}
				if($center!=""){
					$user = $this->user_model->userRegister(array('r_username'=>$username,'r_email'=>$_POST['email'],'r_password'=>'welcome1','r_role'=>$_POST['role'],'center'=>$center));
				}
            }
            $user = $this->import->getDataList("user",array('email'=>$_POST['email'],'removed'=>0));
            if(count($user)==0){
                $this->data['error'] = 1;
                $this->data['message']="Please type correct email.";
                $this->load->view('forget', $this->data);
            }else{
                $user=$user[0];
                $this->data['error'] = "0";
    			$this->data['status'] = 1;
    			$this->data['massage'] = "Success";
    			$this->data['email'] = $_POST['email'];
    			
    			$this->load->helper(array('form', 'url'));
    			$this->load->library('email');
    			
    			$configdata = $this->import->db->query("select * from tbl_localsmtp where replace(center,' ','')='".str_replace(' ','',$user['center'])."'")->result_array();
    			$config = array();
    			$config['charset'] = 'utf-8';
    			$config['useragent'] = 'Codeigniter';
    			$config['protocol']= "smtp";
    			$config['mailtype']= "html";
    			$config['smtp_host']= $configdata[0]['smtp_host'];
    			$config['smtp_port']= $configdata[0]['smtp_port'];
    			$config['smtp_timeout']= "5";
    			$config['smtp_user']= $configdata[0]['smtp_user'];
    			$config['smtp_pass']=$configdata[0]['smtp_pass'];     
    			$config['crlf']="\r\n";
    			$config['newline']="\r\n";
    			$config['wordwrap'] = TRUE;
    			
    			$this->email->initialize($config);
    			$this->email->from($configdata[0]['from_']);
    			$this->email->to($_POST['email']);//("maxjerry0107@hotmail.com");////("maxjerry0107@hotmail.com");
    			$this->email->subject("Mathnasium Centroid");
    			
    			
    			$this->email->message("Your Code is {$code}");
    			
    			if($this->email->send()){
    				//echo $result['message'] = "Success";
    			}
    			else{
    			    $this->data['error'] = "1";
        			$this->data['status'] = 0;
        			$this->data['message'] = $this->email->print_debugger();
        			$this->data['email'] = $_POST['email'];
    				//echo $result['message']=str_replace("\n","<br>",$this->email->print_debugger());
    			}
                //echo ("Your Code is {$str}<br>".$configdata[0]['from_']."<br>".$config['smtp_host']."<br>".$config['smtp_port']."<br>".$config['smtp_user']."<br>".$config['smtp_pass']);
                $this->load->view('forget', $this->data);   
            }
        }else{
            if($_POST['password']!=""&&$_POST['email']!=""&&$_POST['code1']>0&&$_POST['code1']<10&&$_POST['code2']>0&&$_POST['code2']<10&&$_POST['code3']>0&&$_POST['code3']<10&&$_POST['code4']>0&&$_POST['code4']<10&&$_POST['code5']>0&&$_POST['code5']<10)
            {
                if($code=="{$_POST['code1']}{$_POST['code2']}{$_POST['code3']}{$_POST['code4']}{$_POST['code5']}"){
                    $sql="update user set password='".md5($_POST['password'])."' where email='{$_POST['email']}'";
                    $this->user_model->db->query($sql);
                    redirect(URL_PATH.'login');
                }else{
                    $this->data['error'] = "1";
        			$this->data['status'] = 1;
        			$this->data['message'] = "Wrong Code Numbers!";
        			$this->data['email'] = $_POST['email'];
                    $this->load->view('forget', $this->data);      
                }
            }else{
                $this->data['error'] = "1";
    			$this->data['status'] = 1;
    			$this->data['message'] = "Please type correct.";
    			$this->data['email'] = $_POST['email'];
    			$this->load->view('forget', $this->data);  
            }
        }
    }
    public function forgetin1(){    
        $this->data['error'] = 0;
        $this->data['centerdata']="";
        foreach($this->user_model->db->query("select * from user group by center ")->result_array() as $r){
			$this->data['centerdata'].=($this->data['centerdata']==""?"":"###").$r['center'];
		}
        $sql="select * from user where name like '%{$_POST['username']}%' and email='{$_POST['email']}' and role='{$_POST['role']}' and center='{$_POST['center']}'";
        $userdata=$this->user_model->db->query($sql)->result_array();
        if(count($userdata)==1){
            $sql="update user set password='".md5($_POST['password'])."' where name like '%{$_POST['username']}%' and email='{$_POST['email']}' and role='{$_POST['role']}' and center='{$_POST['center']}'";
            $this->user_model->db->query($sql);
            $this->data['message']="Successful!";
            $this->load->view('login', $this->data);
        }else{
            $this->data['error'] = 1;
            if(!count($this->user_model->db->query("select * from user where email='{$_POST['email']}'")->result_array())){
                $this->data['message']="There is no the email.";
                $this->load->view('forget', $this->data);
            }else if(!count($this->user_model->db->query("select * from user where name like '%{$_POST['username']}%'")->result_array())){
                $this->data['message']="There is no the name.";
                $this->load->view('forget', $this->data);
            }else{
                $this->data['message']=$sql."Please type correct.";
                $this->load->view('forget', $this->data);
            }
        }
    }
    public function signin_old(){
        $this->data['error'] = 0;
        
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('role', 'Role', 'required');
        if ($this->form_validation->run() == FALSE){
            $this->data['error'] = 1;                                                                   //please insert the form fields
            $this->data['message'] = "please insert the form fields";
            $this->load->view('login', $this->data);
        }else{
            $user = $this->user_model->getUserList($_POST);
			if(count($user)==0)if($_POST['role'] == 3&&$_POST['password']=="welcome1"){
				$username="";
				$center="";
				$parent = $this->import->getDataList("tbl_guardian",array('Email'=>$_POST['email']));
				if(count($parent)>0){
					$username=$parent[0]['First_Name'];
					$center=str_replace(" ","",$parent[0]['Center']);
				}else{
					$parent = $this->import->getDataList("tbl_account",array('Email_Address'=>$_POST['email']));
					if(count($parent)>0){
						$username=$parent[0]['First_Name'];
						$center=str_replace(" ","",$parent[0]['Center']);
					}
				}
				if($center!=""){
					$user = $this->user_model->userRegister(array('r_username'=>$username,'r_email'=>$_POST['email'],'r_password'=>$_POST['password'],'r_role'=>$_POST['role'],'center'=>$center));
					$user = $this->user_model->getUserList($_POST);
				}
			}
			if(count($user) > 0){
				if($user[0]['state']==0||$user[0]['state']==2){
					$this->data['error'] = 4;                                                            // unknown user role
                    $this->data['message'] = "Please waiting for accept of administrator.";
                    $this->load->view('login', $this->data);
					return;
				}
				
				$user[0]['sendable']=1;
				$field=explode(",","active0,active1,active2,active3,sending,overhead");
    		    $permissiondata=$this->user_model->db->query("select * from tbl_location where replace(center,' ','')='".str_replace(' ','',$user[0]['center'])."'")->result_array();
    		    if(count($permissiondata)&&$user[0]['role']){
    		        if(!$permissiondata[0]['active0']){
    		            $this->data['error'] = 4;                                                                // user does not exist      
                        $this->data['message'] = "Sorry. Please ask Administrator.";
        				$this->load->view('login', $this->data);
                        return;
    		        }
    		        if(!$permissiondata[0][$field[$user[0]['role']]]){
    		            $this->data['error'] = 5;                                                                // user does not exist      
                        $this->data['message'] = "Sorry. Please ask Administrator.";
        				$this->load->view('login', $this->data);
                        return;
    		        }
    		        $user[0]['sendable']=$permissiondata[0]['sending'];
    		    }
				
                $this->session->set_userdata(USER_INFO, $user[0]);
                if($user[0]['role'] < 2){
                    redirect(URL_PATH.'administrator/viewuser');
                }else if($user[0]['role'] == 2){
                    redirect(URL_PATH.'instructor/index');
                }else if($user[0]['role'] == 3){
                    redirect(URL_PATH.'parentx/index');
                }else{
                    $this->data['error'] = 3;                                                            // unknown user role
                    $this->data['message'] = "unknown user role";
                    $this->load->view('login', $this->data);
                }
            }else{
                $this->data['error'] = 2;                                                                // user does not exist      
                $this->data['message'] = "user does not exist";
				if($_POST['role'] == 3)$this->data['message']="Please try once again your password into \"welcome1\".";
                $this->load->view('login', $this->data);
            }
        }
    }
    
    public function signin(){
        $this->data['error'] = 0;
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('role', 'Role', 'required');
        if ($this->form_validation->run() == FALSE){
            $this->data['error'] = 1;                                                                   //please insert the form fields
            $this->data['message'] = "please insert the form fields";
            $this->load->view('login', $this->data);
        }else{
            $_POST['removed']=0;
            $user = $this->user_model->getUserList($_POST);
			/*if(count($user)==0)if($_POST['password']=="welcome1"){
			    $_POST['role'] = 3;
				$username="";
				$center="";
				$parent = $this->import->getDataList("tbl_guardian",array('Email'=>$_POST['email']));
				if(count($parent)>0){
					$username=$parent[0]['First_Name'];
					$center=str_replace(" ","",$parent[0]['Center']);
				}else{
					$parent = $this->import->getDataList("tbl_account",array('Email_Address'=>$_POST['email']));
					if(count($parent)>0){
						$username=$parent[0]['First_Name'];
						$center=str_replace(" ","",$parent[0]['Center']);
					}
				}
				if($center!=""){
					$user = $this->user_model->userRegister(array('r_username'=>$username,'r_email'=>$_POST['email'],'r_password'=>$_POST['password'],'r_role'=>$_POST['role'],'center'=>$center));
					$user = $this->user_model->getUserList($_POST);
				}
			}*/
			if(count($user) > 0){
				if($user[0]['state']==0||$user[0]['state']==2){
					$this->data['error'] = 4;                                                            // unknown user role
                    $this->data['message'] = "Please waiting for accept of administrator.";
                    $this->load->view('login', $this->data);
					return;
				}
				
				$user[0]['sendable']=1;
				$field=explode(",","active0,active1,active2,active3,sending,overhead");
    		    $permissiondata=$this->user_model->db->query("select * from tbl_location where replace(center,' ','')='".str_replace(' ','',$user[0]['center'])."'")->result_array();
    		    if(count($permissiondata)&&$user[0]['role']){
    		        if(!$permissiondata[0]['active0']){
    		            $this->data['error'] = 4;                                                                // user does not exist      
                        $this->data['message'] = "Sorry. Please ask Administrator.";
        				$this->load->view('login', $this->data);
                        return;
    		        }
    		        if(!$permissiondata[0][$field[$user[0]['role']]]){
    		            $this->data['error'] = 5;                                                                // user does not exist      
                        $this->data['message'] = "Sorry. Please ask Administrator.";
        				$this->load->view('login', $this->data);
                        return;
    		        }
    		        $user[0]['sendable']=$permissiondata[0]['sending'];
    		    }
				
                $this->session->set_userdata(USER_INFO, $user[0]);
                $this->user_model->db->select("*");
        		$this->user_model->db->where("email", $user[0]['email']);
        		$crossuser = $this->user_model->db->get("user")->result_array();
                if(!count($crossuser))$crossuser=array();
                $this->session->set_userdata(USER_CROSS_INFO, $crossuser);
                //$_SERVER['REMOTE_ADDR']
                if($user[0]['ip_lock']){
                    $sql="select * from tbl_ipinterlock where center='{$user[0]['center']}' and ip='{$_SERVER['REMOTE_ADDR']}'";
                    if(count($this->user_model->db->query($sql)->result_array())){
                        
                    }else{
                        $this->data['error'] = 6;                                                            // unknown user role
                        $this->data['message'] = "WRONG IP ADDRESS!";
                        $this->load->view('login', $this->data);
                        return;
                    }
                }
                if($user[0]['role'] < 2){
                    redirect(URL_PATH.'administrator/index');
                }else if($user[0]['role'] == 2){
                    redirect(URL_PATH.'instructor/index');
                }else if($user[0]['role'] == 3){
                    $fff=0;
                    if(isset($_POST['password']))if($_POST['password']=="welcome1")$fff=1;
                    if($fff==1)redirect(URL_PATH.'parentx/index?f=1');
                    else redirect(URL_PATH.'parentx/index');
                }else{
                    $this->data['error'] = 3;                                                            // unknown user role
                    $this->data['message'] = "unknown user role";
                    $this->load->view('login', $this->data);
                }
            }else{
                $user = $this->import->getDataList("user",array('email'=>$_POST['email'],'removed'=>0));
                $this->data['error'] = 2;                                                                // user does not exist      
                if(count($user)>0)$this->data['message'] = "Please type correct password!";
                else{
                $this->data['message'] = "user does not exist";
				if($_POST['role'] == 3)$this->data['message']="Please try once again your password into \"welcome1\".";
                }
                $this->load->view('login', $this->data);
            }
        }
    }
	
	function changepass(){
		if(md5($_POST['prevpass'])!=$_POST['pass']){
			echo 2;
			return;
		}
		$where=array(
			'name'=>$_POST['name'],
			'email'=>$_POST['email'],
			'role'=>$_POST['role'],
			'password'=>$_POST['newpass']
		);
		$users = $this->import->getDataList("user",$where);
		if(count($users)){
			echo 3;
			return;
		}
		$where['password']=$_POST['pass'];
		$this->import->db->update("user",array('password'=>md5($_POST['newpass'])),$where);
		echo 1;
	}

    public function signout(){
        $this->data['error'] = 0;
        $this->session->sess_destroy();
        $this->index();
    }
}