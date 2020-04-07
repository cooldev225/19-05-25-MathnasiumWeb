<?php
class History_Model extends CI_Model{
	public function getHistory(){
		$this->db->select("*");
		$this->db->where("m_date", date("Y-m-d"));
		$result = $this->db->get("tbl_history")->result_array();
		if(count($result) > 0){
			return $result;
		}else{
			$result = array();
			return $result;
		}
	}

}