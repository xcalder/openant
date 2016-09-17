<?php
class Aftermarket_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	//
	public function get_aftermarkets_for_langugae_id($data)
	{
		//
		$this->db->limit($this->config->get_config('config_limit_admin'), $data['page']);
		$this->db->select('aftermarket_id');
		//$this->db->from($this->db->dbprefix('aftermarket'));
		$query = $this->db->get($this->db->dbprefix('aftermarket')); 
		
		//统计记录条数
		$aftermarkets['count']=$this->db->count_all_results($this->db->dbprefix('aftermarket'));
		
		if($query->num_rows() > 0){
			$row = $query->result_array();
			foreach($row as $value){
				$aftermarkets['aftermarkets'][] = $this->get_aftermarket($value['aftermarket_id']);
			}
			return $aftermarkets;
		}
		
		return FALSE;
	}
	
	//给分类用
	public function get_aftermarkets_to_category()
	{
		$this->db->select('aftermarket_id');
		$query = $this->db->get($this->db->dbprefix('aftermarket')); 
		if($query->num_rows() > 0){
			$row = $query->result_array();
			foreach($row as $value){
				$aftermarkets[] = $this->get_aftermarket($value['aftermarket_id']);
			}
			return $aftermarkets;
		}
		
		return FALSE;
	}
	
	//
	public function get_aftermarkets_for_setting()
	{
		//
		$this->db->select('aftermarket_id');
		$this->db->from($this->db->dbprefix('aftermarket'));
		$query = $this->db->get(); 
		
		if($query->num_rows() > 0){
			$row = $query->result_array();
			foreach($row as $value){
				$aftermarkets[] = $this->get_aftermarket($value['aftermarket_id']);
			}
			return $aftermarkets;
		}
		
		return FALSE;
	}
	
	//
	public function get_aftermarket($aftermarket_id='')
	{
		if(empty($aftermarket_id)){
			return FALSE;
		}
		
		$this->db->where('aftermarket.aftermarket_id',$aftermarket_id);
		$this->db->where('aftermarket_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('aftermarket_description', 'aftermarket_description.aftermarket_id = aftermarket.aftermarket_id');
		$this->db->from($this->db->dbprefix('aftermarket'));
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			return $query->row_array();
		}
		
		return FALSE;
	}
	
	//
	public function get_aftermarket_form($aftermarket_id='')
	{
		if(empty($aftermarket_id)){
			return FALSE;
		}
		
		$this->db->where('aftermarket_id',$aftermarket_id);
		$this->db->from($this->db->dbprefix('aftermarket'));
		$query = $this->db->get();
		if($query->num_rows() > 0){
			$row=$query->row_array();
			$aftermarket=$row;
			
			//查描述
			$this->db->where('aftermarket_id', $row['aftermarket_id']);
			$this->db->from($this->db->dbprefix('aftermarket_description'));
			$query=$this->db->get();
			
			$descriptions=$query->result_array();
			foreach($descriptions as $key=>$value){
				$description[$descriptions[$key]['language_id']]=$value;
			}
			$aftermarket['description']=$description;
			
			return $aftermarket;
		}
		
		return FALSE;
	}
	
	public function edit($data)
	{
		$this->db->where('aftermarket_id', $this->input->get('aftermarket_id'));
		$this->db->update($this->db->dbprefix('aftermarket'), $data['base']);
		
		//先删
		$this->db->delete($this->db->dbprefix('aftermarket_description'), array('aftermarket_id' => $this->input->get('aftermarket_id')));
		
		foreach($data['description'] as $key=>$value){
			//组织数组
			$data['description'][$key]['language_id']=$key;
			$data['description'][$key]['aftermarket_id']=$this->input->get('aftermarket_id');
			
			$this->db->where('aftermarket_id', $this->input->get('aftermarket_id'));
			$this->db->where('language_id', $key);
			$this->db->insert($this->db->dbprefix('aftermarket_description'), $data['description'][$key]);
			$this->db->reset_query();
		}
		
		
	}
	
	public function add($data)
	{
		$this->db->insert($this->db->dbprefix('aftermarket'), $data['base']);
		
		//取最后查入的一第分类id
		$aftermarket_id=$this->db->insert_id();
		
		
		foreach($data['description'] as $key=>$value){
			//组织数组
			
			$data['description'][$key]['aftermarket_id']=$aftermarket_id;
			$data['description'][$key]['language_id']=$key;
		}
		$this->db->insert_batch($this->db->dbprefix('aftermarket_description'), $data['description']);
		$this->db->reset_query();
	}
	
	public function check_delete($data){
		if(empty($data)){
			return FALSE;
		}
		foreach($data as $key=>$value){
			$this->db->select('aftermarket_id');
			$this->db->where('aftermarket_id', $data[$key]);
			$this->db->from($this->db->dbprefix('product_aftermarket'));
			$query=$this->db->get();
			
			if($query->num_rows() > 0){
				return TRUE;
			}
		}
		
		return FALSE;
	}
	
	public function delete($data){
		foreach($data as $key=>$value){
			$this->db->delete($this->db->dbprefix('aftermarket'), array('aftermarket_id' => $data[$key]));
			$this->db->delete($this->db->dbprefix('aftermarket_description'), array('aftermarket_id' => $data[$key]));
		}
	}
}