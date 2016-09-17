<?php
class Order_status_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	//
	public function get_order_statuss_for_langugae_id($data)
	{
		//
		$this->db->limit($this->config->get_config('config_limit_admin'), $data['page']);
		$this->db->select('order_status_id');
		//$this->db->from($this->db->dbprefix('order_status'));
		$query = $this->db->get($this->db->dbprefix('order_status')); 
		
		//统计记录条数
		$order_statuss['count']=$this->db->count_all_results($this->db->dbprefix('order_status'));
		
		if($query->num_rows() > 0){
			$row = $query->result_array();
			foreach($row as $value){
				$order_statuss['order_statuss'][] = $this->get_order_status($value['order_status_id']);
			}
			return $order_statuss;
		}
		
		return FALSE;
	}
	
	//
	public function get_order_statuss_for_setting()
	{
		//
		$this->db->select('order_status_id');
		$this->db->from($this->db->dbprefix('order_status'));
		$query = $this->db->get(); 
		
		if($query->num_rows() > 0){
			$row = $query->result_array();
			foreach($row as $value){
				$order_statuss[] = $this->get_order_status($value['order_status_id']);
			}
			return $order_statuss;
		}
		
		return FALSE;
	}
	
	//
	public function get_order_status($order_status_id='')
	{
		if(empty($order_status_id)){
			return FALSE;
		}
		
		$this->db->where('order_status.order_status_id',$order_status_id);
		$this->db->where('order_status_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('order_status_description', 'order_status_description.order_status_id = order_status.order_status_id');
		$this->db->from($this->db->dbprefix('order_status'));
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			return $query->row_array();
		}
		
		return FALSE;
	}
	
	//
	public function get_order_status_form($order_status_id='')
	{
		if(empty($order_status_id)){
			return FALSE;
		}
		
		$this->db->where('order_status_id',$order_status_id);
		$this->db->from($this->db->dbprefix('order_status'));
		$query = $this->db->get();
		if($query->num_rows() > 0){
			$row=$query->row_array();
			$order_status=$row;
			
			//查描述
			$this->db->where('order_status_id', $row['order_status_id']);
			$this->db->from($this->db->dbprefix('order_status_description'));
			$query=$this->db->get();
			
			$descriptions=$query->result_array();
			foreach($descriptions as $key=>$value){
				$description[$descriptions[$key]['language_id']]=$value;
			}
			$order_status['description']=$description;
			
			return $order_status;
		}
		
		return FALSE;
	}
	
	public function edit($data)
	{
		$this->db->where('order_status_id', $this->input->get('order_status_id'));
		$this->db->update($this->db->dbprefix('order_status'), $data['base']);
		
		//先删
		$this->db->delete($this->db->dbprefix('order_status_description'), array('order_status_id' => $this->input->get('order_status_id')));
		
		foreach($data['description'] as $key=>$value){
			//组织数组
			$data['description'][$key]['language_id']=$key;
			$data['description'][$key]['order_status_id']=$this->input->get('order_status_id');
			
			$this->db->where('order_status_id', $this->input->get('order_status_id'));
			$this->db->where('language_id', $key);
			$this->db->insert($this->db->dbprefix('order_status_description'), $data['description'][$key]);
			$this->db->reset_query();
		}
		
		
	}
	
	public function add($data)
	{
		$this->db->insert($this->db->dbprefix('order_status'), $data['base']);
		
		//取最后查入的一第分类id
		$order_status_id=$this->db->insert_id();
		
		
		foreach($data['description'] as $key=>$value){
			//组织数组
			
			$data['description'][$key]['order_status_id']=$order_status_id;
			$data['description'][$key]['language_id']=$key;
		}
		$this->db->insert_batch($this->db->dbprefix('order_status_description'), $data['description']);
		$this->db->reset_query();
	}
	
	public function check_delete($data){
		if(empty($data)){
			return FALSE;
		}
		foreach($data as $key=>$value){
			$this->db->select('order_id');
			$this->db->where('order_status_id', $data[$key]);
			$this->db->from($this->db->dbprefix('order'));
			$query=$this->db->get();
			
			if($query->num_rows() > 0){
				return TRUE;
			}
		}
		
		return FALSE;
	}
	
	public function delete($data){
		foreach($data as $key=>$value){
			$this->db->delete($this->db->dbprefix('order_status'), array('order_status_id' => $data[$key]));
			$this->db->delete($this->db->dbprefix('order_status_description'), array('order_status_id' => $data[$key]));
		}
	}
}