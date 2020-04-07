<?php
class Import_Model extends CI_Model{
	public function importData($table,$data = array(),$role,$center){
		$this->db->trans_start(TRUE);
		//$fw=fopen(date("Y_m_d")."_".$table."_ipmort.txt","w");
		$sql="delete from {$table}";
		if($table!="tbl_ixl"&&$role)$sql.=" where replace(center,' ','')='".str_replace(' ','',$center)."' ";
		$this->db->query($sql);
		for($i=0;$i<count($data);$i++){
				//$fetch[]=$data[$i];
				//$res = $this->db->insert_batch($table,$fetch);
			/*$fields="";
			$vals="";
			foreach($data[$i] as $key=>$value){
				$value = str_replace("'", "\'", $value);
				$value = str_replace('"', '\"', $value);
				$fields.=($fields==""?"":",").$key;
				$vals.=($vals==""?"":",")."'{$value}'";
			}
			$sql="insert into {$table} ({$fields}) values({$vals});";
			try{
				$this->db->query($sql);
			}*/
			try{
				
				if($table!="tbl_ixl"&&$role){
					//if(str_replace(" ","",$data[$i]['Center'])==$center)
						$this->db->insert($table,$data[$i]);
				}
				else $this->db->insert($table,$data[$i]);
			}
			catch(Exception $e){
				//fwrite($fw,$sql."\n");//$data[0]."\t".$date[1]."\t".$date[1]."\t".$date[2]."\t".$date[3]."\t".$date[4]."\t".$date[5]);
				//fwrite($fw,$sql."\n");
			}
			if ($this->db->trans_status() === FALSE)
			{
				$this->db->trans_rollback();
				//fwrite($fw,$sql."\n");
			}
			else
			{
				$this->db->trans_commit();
			}
		}

	}

	public function getDataList($table,$data = array(),$order = array()){
		$this->db->select("*");
		foreach($data as $key=>$val){
			$this->db->where($key, $val);
		}
		foreach($order as $val){
			try {
				$this->db->order_by($val);
			} catch (\Exception $th) {
				//throw $th;
				echo $th->getMessage()."";
			}
		}
		$result = $this->db->get($table)->result_array();
		if(count($result) > 0){
			return $result;
		}else{
			$result = array();
			return $result;
		}
	}
}
