<?php
class Store_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	//取属性列表
	public function get_stores($data)
	{
		$this->db->limit($this->config->get_config('config_limit_admin'), $data['page']);
		$this->db->select('store_id');
		if(isset($data['check'])){
			$this->db->where('check', $data['check']);
		}
		
		$query=$this->db->get($this->db->dbprefix('store'));
		
		//统计记录条数
		if(isset($data['check'])){
			$this->db->where('check', $data['check']);
		}
		$store['count']   =$this->db->count_all_results($this->db->dbprefix('store'));
		
		if($query->num_rows() > 0){
			foreach($query->result_array() as $key=>$value){
				$store['stores'][]=$this->get_store($value['store_id']);
			}
			
			return $store;
		}
		return FALSE;
	}
	
	//取属性
	public function get_store($store_id)
	{
		$this->db->select('store.store_id, store.check, store.store_status, store.date_invalid, store.ratings, store.quality, store.attitude, store_description.store_name, user.user_id, user.nickname, user.email, user.telephone, user_group_description.name, sale_class_description.name as sale_class_name');
		$this->db->where('store.store_id', $store_id);
		$this->db->where('store_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->where('user_group_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->where('sale_class_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('store_description','store_description.store_id = store.store_id');
		$this->db->join('user','user.store_id = store.store_id');
		$this->db->join('sale_class_description','sale_class_description.sale_class_id = user.sale_class_id');
		$this->db->join('user_group_description','user_group_description.user_group_id = user.user_group_id');
		$this->db->from($this->db->dbprefix('store'));
		
		$query=$this->db->get();
		
		if($query->num_rows() > 0){
			$row = $query->row_array();
			//商品数量
			$this->db->select('total,quantity');
			$this->db->where('store_id',$row['store_id']);
			$this->db->from($this->db->dbprefix('order_product'));
			$query=$this->db->get();
			
			if($query->num_rows() > 0){
			$row['total_product']	=array_sum(array_column($query->result_array(),'quantity'));
			$row['total_price']		=array_sum(array_column($query->result_array(),'total'));
			}
			
			/*
			$this->db->where('address_id',$row['store_address_id']);
			$this->db->from($this->db->dbprefix('address'));
			$query=$this->db->get();
			if($query->num_rows() > 0){
				$address=$query->row_array();
				
			}
			*/
			
			return $row;
		}
		
		return FALSE;
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
	
	//屏蔽商店
	public function invalid($store_id,$data){
		$this->db->where('store_id', $store_id);
		$this->db->update($this->db->dbprefix('store'), $data);
	}
	
	public function pass($store_id){
		$this->db->set('check', '0');
		$this->db->where('store_id', $store_id);
		$this->db->update($this->db->dbprefix('store'));
	}
}