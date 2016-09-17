<?php
class Stock_status_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	//
	public function get_stock_statuss_for_langugae_id($data)
	{
		//
		$this->db->limit($this->config->get_config('config_limit_admin'), $data['page']);
		$this->db->select('stock_status_id');
		//$this->db->from($this->db->dbprefix('stock_status'));
		$query = $this->db->get($this->db->dbprefix('stock_status')); 
		
		//统计记录条数
		$stock_statuss['count']=$this->db->count_all_results($this->db->dbprefix('stock_status'));
		
		if($query->num_rows() > 0){
			$row = $query->result_array();
			foreach($row as $value){
				$stock_statuss['stock_statuss'][] = $this->get_stock_status($value['stock_status_id']);
			}
			return $stock_statuss;
		}
		
		return FALSE;
	}
	
	//给分类用
	public function get_stock_statuss_to_category()
	{
		$this->db->select('stock_status_id');
		$query = $this->db->get($this->db->dbprefix('stock_status')); 
		if($query->num_rows() > 0){
			$row = $query->result_array();
			foreach($row as $value){
				$stock_statuss[] = $this->get_stock_status($value['stock_status_id']);
			}
			return $stock_statuss;
		}
		
		return FALSE;
	}
	
	//
	public function get_stock_status($stock_status_id='')
	{
		if(empty($stock_status_id)){
			return FALSE;
		}
		
		$this->db->where('stock_status.stock_status_id',$stock_status_id);
		$this->db->where('stock_status_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('stock_status_description', 'stock_status_description.stock_status_id = stock_status.stock_status_id');
		$this->db->from($this->db->dbprefix('stock_status'));
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			return $query->row_array();
		}
		
		return FALSE;
	}
	
	//
	public function get_stock_status_form($stock_status_id='')
	{
		if(empty($stock_status_id)){
			return FALSE;
		}
		
		$this->db->where('stock_status_id',$stock_status_id);
		$this->db->from($this->db->dbprefix('stock_status'));
		$query = $this->db->get();
		if($query->num_rows() > 0){
			$row=$query->row_array();
			$stock_status=$row;
			
			//查描述
			$this->db->where('stock_status_id', $row['stock_status_id']);
			$this->db->from($this->db->dbprefix('stock_status_description'));
			$query=$this->db->get();
			
			$descriptions=$query->result_array();
			foreach($descriptions as $key=>$value){
				$description[$descriptions[$key]['language_id']]=$value;
			}
			$stock_status['description']=$description;
			
			return $stock_status;
		}
		
		return FALSE;
	}
	
	public function edit($data)
	{
		$this->db->where('stock_status_id', $this->input->get('stock_status_id'));
		$this->db->update($this->db->dbprefix('stock_status'), $data['base']);
		
		//先删
		$this->db->delete($this->db->dbprefix('stock_status_description'), array('stock_status_id' => $this->input->get('stock_status_id')));
		
		foreach($data['description'] as $key=>$value){
			//组织数组
			$data['description'][$key]['language_id']=$key;
			$data['description'][$key]['stock_status_id']=$this->input->get('stock_status_id');
			
			$this->db->where('stock_status_id', $this->input->get('stock_status_id'));
			$this->db->where('language_id', $key);
			$this->db->insert($this->db->dbprefix('stock_status_description'), $data['description'][$key]);
			$this->db->reset_query();
		}
	}
	
	public function add($data)
	{
		$this->db->insert($this->db->dbprefix('stock_status'), $data['base']);
		
		//取最后查入的一第分类iddbprefix('stock_status'));
		$query=$this->db->get();
		$stock_status_id=$this->db->insert_id();
		
		foreach($data['description'] as $key=>$value){
			//组织数组
			$data['description'][$key]['stock_status_id']=$stock_status_id;
			$data['description'][$key]['language_id']=$key;
		}
		$this->db->insert_batch($this->db->dbprefix('stock_status_description'), $data['description']);
		$this->db->reset_query();
	}
	
	public function check_delete($data){
		if(empty($data)){
			return FALSE;
		}
		foreach($data as $key=>$value){
			$this->db->select('product_id');
			$this->db->where('stock_status_id', $data[$key]);
			$this->db->from($this->db->dbprefix('product'));
			$query=$this->db->get();
			
			if($query->num_rows() > 0){
				return TRUE;
			}
		}
		
		return FALSE;
	}
	
	public function delete($data){
		foreach($data as $key=>$value){
			$this->db->delete($this->db->dbprefix('stock_status'), array('stock_status_id' => $data[$key]));
			$this->db->delete($this->db->dbprefix('stock_status_description'), array('stock_status_id' => $data[$key]));
		}
	}
}