<?php
class user_model extends CI_Model{
	public function getUser($data = array()){
		$this->db->select("*");
		$this->db->where("name", $data['username']);
		$this->db->or_where("email", $data['username']);
		$this->db->where("password", $data['password']);
		$result = $this->db->get("user")->result_array();
		if(count($result) > 0){
			return $result;
		}else{
			$result = array();
			return $result;
		}
	}

	public function userRegister($data = array()){
		$this->db->select("*");
		$this->db->where("name", $data['r_username']);
		$this->db->where("email", $data['r_email']);
		$this->db->where("role", $data['r_role']);
		$this->db->where("center", $data['center']);
		$exist = $this->db->get("user")->result_array();
		if(count($exist) > 0){
			return false;
		}else{
			date_default_timezone_set('America/New_York');
			$datet=date("Y-m-d");
			$arr = array('name'=>$data['r_username'],
						 'email' => $data['r_email'],
						 'password' => md5($data['r_password']),
						 'state' => '1',
						 'removed'=>0,
						 'reg_date' => $datet,
						 'role' => '1',
						 'center'=>''
						 );
			if(isset($data['r_role']))$arr['role'] = $data['r_role'];
			//if($arr['role']==2)$arr['state']=0;
			if(isset($data['center']))$arr['center'] = $data['center'];
			
			$this->db->insert('user', $arr);
			return true;
		}
	}

	public function getUserList($data = array()){
	    if(!isset($data['removed']))$data['removed']=0;
	    if(!isset($data['iflag']))$data['iflag']="";
	    $pass=md5($data['password']);
	    if($data['iflag']=='internal_login')$pass=$data['password'];
	    $this->db->select("*");
		$this->db->where("email", $data['email']);
		if($data['role']>0)$this->db->where("role", $data['role']);
		$this->db->where("password", $pass);
		$this->db->where("removed", $data['removed']);
		if($data['iflag']=='internal_login'){
		    $this->db->where("name", $data['name']);
		    
		    $this->db->where("center", $data['center']);
		}
		$result = $this->db->get("user")->result_array();
		
		if(count($result) > 0){
			//return $result;
		}else{
			
			if($data['role']==1){
				$this->db->select("*");
				$this->db->where("email", $data['email']);
				$this->db->where("role", 0);
				$this->db->where("removed", $data['removed']);
				$this->db->where("password", $pass);
				if($data['iflag']=='internal_login'){
        		    $this->db->where("name", $data['name']);
        		    $this->db->where("center", $data['center']);
        		}
				$result = $this->db->get("user")->result_array();
			}
		}
		if(count($result)==0)$result=array();
		else{
		    date_default_timezone_set('America/New_York');
		    $this->db->update('user',array("visited_count"=>$result[0]['email']+1,"last_visited_time"=>date("Y-m-d H:i:s")),array('email'=>$result[0]['email'],'role'=>$result[0]['role'],'password'=>$result[0]['password'],'name'=>$result[0]['name']));    
		}
		return $result;
	}
}