<?php
class Setting_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function get_settings()
	{
		$this->db->select('key, value');
		$this->db->where('store_id', '0');
		$this->db->where('code', 'config');
		$this->db->from($this->db->dbprefix('setting'));
		$query=$this->db->get();
		
		if($query->num_rows() > 0){
			return $query->result_array();
		}
		
		return FALSE;
	}
	
	public function get_setting($code='config', $key='', $store_id = 0)
	{
		$this->db->select('value');
		$this->db->where('store_id', $store_id);
		$this->db->where('code', $code);
		
		if(!empty($key)){
			$this->db->where('key', $key);
		}
	
		$this->db->from($this->db->dbprefix('setting'));
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			
			$result=$query->row_array();
			$data = $result['value'];
			
			return $data;
		}
		return FALSE;
	}
	
	public function edit($data,$code='config')
	{
		if(empty($data)){
			return FALSE;
		}
		
		foreach($data as $key=>$value){
			if(is_array($data[$key])){
				$data[$key]=serialize($data[$key]);
			}
			
			//查是否存在，如果不存在放到另一个数组做添加，如果存在更新
			if($this->select_setting_id($key, $code)){
				$updata[$key]['key']=$key;
				$updata[$key]['code']=$code;
				$updata[$key]['value']=$data[$key];
			}else{
				$add[$key]['key']=$key;
				$add[$key]['code']=$code;
				$add[$key]['value']=$data[$key];
			}
		}
		
		//更新setting表
		if(isset($updata)){
			$this->db->update_batch($this->db->dbprefix('setting'), $updata, 'key');
			$this->db->reset_query();
		}
		
		if(isset($add)){
			$this->db->insert_batch($this->db->dbprefix('setting'), $add);
			$this->db->reset_query();
		}
		
		if(!isset($updata)){
			return FALSE;
		}
		if(!isset($add)){
			return FALSE;
		}
		
	}
	
	//用key查settting_id
	public function select_setting_id($key){
		$this->db->select('setting_id');
		$this->db->where('key', $key);
		$this->db->from($this->db->dbprefix('setting'));
		$query=$this->db->get();
		
		if($query->num_rows() > 0){
			return $query->row_array();
		}
		return FALSE;
	}
}