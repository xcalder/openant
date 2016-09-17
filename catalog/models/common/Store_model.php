<?php
class Store_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	//查所有语言
	public function new_store($data)
	{
		$store['check']='1';
		$store['date_added']=date("Y-m-d H:i:s");
		$this->db->insert($this->db->dbprefix('store'), $store);
		
		$store_id=$this->db->insert_id();
		
		$description=array();
		$data=$data['description'];
		foreach($data as $key=>$value){
			$description[$key]['store_id']=$store_id;
			$description[$key]['language_id']=$key;
			$description[$key]['store_name']=$data[$key]['store_name'];
			$description[$key]['description']=$data[$key]['description'];
			$description[$key]['logo']=$data[$key]['logo'];
		}
		
		$this->db->insert_batch($this->db->dbprefix('store_description'), $description);
		
		//更新user表
		$user_store['store_id']=$store_id;
		$user_store['sale_class_id']=$this->config->get_config('default_sale_class');
		$this->db->where('user_id', $this->user->getId());
		$this->db->update($this->db->dbprefix('user'), $user_store);
	}
	
	public function get_store_name($store_id=''){
		$this->db->select('store_name as store_name');
		$this->db->where('language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->where('store_id', $store_id);
		
		$this->db->from($this->db->dbprefix('store_description'));
		$query=$this->db->get();
		
		if($query->num_rows() > 0){
			return $query->row_array();
		}
		return FALSE;
	}
}