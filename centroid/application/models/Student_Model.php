<?php
class Student_Model extends CI_Model{
	public function getStudent($data = array()){
		$this->db->select("*");
		$this->db->where("name", $data['username']);
		$this->db->or_where("email", $data['username']);
		$this->db->where("password", $data['password']);
		$result = $this->db->get("users")->result_array();
		if(count($result) > 0){
			return $result;
		}else{
			$result = array();
			return $result;
		}
	}

	public function StudentRegister($data = array()){
		//date_default_timezone_set('Africa/Lagos');
		$this->db->insert('tbl_student', $data);
		return true;
	}

	public function importData($data = array()){
		$res = $this->db->insert_batch('tbl_student',$data);
		if($res){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	public function getStudentList($data = array()){
		$this->db->select("*");
		$this->db->where("email", $data['email']);
		$this->db->where("role", $data['role']);
		$this->db->where("password", md5($data['password']));
		$result = $this->db->get("user")->result_array();
		if(count($result) > 0){
			return $result;
		}else{
			$result = array();
			return $result;
		}
	}
}
