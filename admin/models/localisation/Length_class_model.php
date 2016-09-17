<?php
class Length_class_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	//
	public function get_length_classs()
	{
		//
		$this->db->select('length_class_id');
		$this->db->from($this->db->dbprefix('length_class'));
		$query = $this->db->get(); 
		
		if($query->num_rows() > 0){
			$row = $query->result_array();
			foreach($row as $value){
				$length_classs[] = $this->get_length_class($value['length_class_id']);
			}
			return $length_classs;
		}
		
		return FALSE;
	}
	
	//
	public function get_length_classs_for_langugae_id($data)
	{
		//
		$this->db->limit($this->config->get_config('config_limit_admin'), $data['page']);
		$this->db->select('length_class_id');
		//$this->db->from($this->db->dbprefix('length_class'));
		$query = $this->db->get($this->db->dbprefix('length_class')); 
		
		//统计记录条数
		$length_classs['count']=$this->db->count_all_results($this->db->dbprefix('length_class'));
		
		if($query->num_rows() > 0){
			$row = $query->result_array();
			foreach($row as $value){
				$length_classs['length_classs'][] = $this->get_length_class($value['length_class_id']);
			}
			return $length_classs;
		}
		
		return FALSE;
	}
	
	//
	public function get_length_class($length_class_id='')
	{
		if(empty($length_class_id)){
			return FALSE;
		}
		
		$this->db->where('length_class.length_class_id',$length_class_id);
		$this->db->where('length_class_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('length_class_description', 'length_class_description.length_class_id = length_class.length_class_id');
		$this->db->from($this->db->dbprefix('length_class'));
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			return $query->row_array();
		}
		
		return FALSE;
	}
	
	//
	public function get_length_class_form($length_class_id='')
	{
		if(empty($length_class_id)){
			return FALSE;
		}
		
		$this->db->where('length_class_id',$length_class_id);
		$this->db->from($this->db->dbprefix('length_class'));
		$query = $this->db->get();
		if($query->num_rows() > 0){
			$row=$query->row_array();
			$length_class=$row;
			
			//查描述
			$this->db->where('length_class_id', $row['length_class_id']);
			$this->db->from($this->db->dbprefix('length_class_description'));
			$query=$this->db->get();
			
			$descriptions=$query->result_array();
			foreach($descriptions as $key=>$value){
				$description[$descriptions[$key]['language_id']]=$value;
			}
			$length_class['description']=$description;
			
			return $length_class;
		}
		
		return FALSE;
	}
	
	public function edit($data)
	{
		$this->db->where('length_class_id', $this->input->get('length_class_id'));
		$this->db->update($this->db->dbprefix('length_class'), $data['base']);
		
		//先删
		$this->db->delete($this->db->dbprefix('length_class_description'), array('length_class_id' => $this->input->get('length_class_id')));
		
		foreach($data['description'] as $key=>$value){
			//组织数组
			$data['description'][$key]['language_id']=$key;
			$data['description'][$key]['length_class_id']=$this->input->get('length_class_id');
			
			$this->db->where('length_class_id', $this->input->get('length_class_id'));
			$this->db->where('language_id', $key);
			$this->db->insert($this->db->dbprefix('length_class_description'), $data['description'][$key]);
			$this->db->reset_query();
		}
	}
	
	public function add($data)
	{
		$this->db->insert($this->db->dbprefix('length_class'), $data['base']);
		
		//取最后查入的一第分类id
		$length_class_id=$this->db->insert_id();
		
		foreach($data['description'] as $key=>$value){
			//组织数组
			
			$data['description'][$key]['length_class_id']=$length_class_id;
			$data['description'][$key]['language_id']=$key;
		}
		
		$this->db->insert_batch($this->db->dbprefix('length_class_description'), $data['description']);
		$this->db->reset_query();
	}
	
	public function check_delete($data){
		if(empty($data)){
			return FALSE;
		}
		foreach($data as $key=>$value){
			$this->db->select('product_id');
			$this->db->where('length_class_id', $data[$key]);
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
			$this->db->delete($this->db->dbprefix('length_class'), array('length_class_id' => $data[$key]));
			$this->db->delete($this->db->dbprefix('length_class_description'), array('length_class_id' => $data[$key]));
		}
	}
}