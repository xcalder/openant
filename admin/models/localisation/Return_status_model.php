<?php
class Return_status_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	//
	public function get_return_statuss_for_langugae_id($data)
	{
		//
		$this->db->limit($this->config->get_config('config_limit_admin'), $data['page']);
		$this->db->select('return_status_id');
		//$this->db->from($this->db->dbprefix('return_status'));
		$query = $this->db->get($this->db->dbprefix('return_status')); 
		
		//统计记录条数
		$return_statuss['count']=$this->db->count_all_results($this->db->dbprefix('return_status'));
		
		if($query->num_rows() > 0){
			$row = $query->result_array();
			foreach($row as $value){
				$return_statuss['return_statuss'][] = $this->get_return_status($value['return_status_id']);
			}
			return $return_statuss;
		}
		
		return FALSE;
	}
	
	//
	public function get_return_status($return_status_id='')
	{
		if(empty($return_status_id)){
			return FALSE;
		}
		
		$this->db->where('return_status.return_status_id',$return_status_id);
		$this->db->where('return_status_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('return_status_description', 'return_status_description.return_status_id = return_status.return_status_id');
		$this->db->from($this->db->dbprefix('return_status'));
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			return $query->row_array();
		}
		
		return FALSE;
	}
	
	//
	public function get_return_status_form($return_status_id='')
	{
		if(empty($return_status_id)){
			return FALSE;
		}
		
		$this->db->where('return_status_id',$return_status_id);
		$this->db->from($this->db->dbprefix('return_status'));
		$query = $this->db->get();
		if($query->num_rows() > 0){
			$row=$query->row_array();
			$return_status=$row;
			
			//查描述
			$this->db->where('return_status_id', $row['return_status_id']);
			$this->db->from($this->db->dbprefix('return_status_description'));
			$query=$this->db->get();
			
			$descriptions=$query->result_array();
			foreach($descriptions as $key=>$value){
				$description[$descriptions[$key]['language_id']]=$value;
			}
			$return_status['description']=$description;
			
			return $return_status;
		}
		
		return FALSE;
	}
	
	public function edit($data)
	{
		$this->db->where('return_status_id', $this->input->get('return_status_id'));
		$this->db->update($this->db->dbprefix('return_status'), $data['base']);
		
		//先删
		$this->db->delete($this->db->dbprefix('return_status_description'), array('return_status_id' => $this->input->get('return_status_id')));
		
		foreach($data['description'] as $key=>$value){
			//组织数组
			$data['description'][$key]['language_id']=$key;
			$data['description'][$key]['return_status_id']=$this->input->get('return_status_id');
			
			$this->db->where('return_status_id', $this->input->get('return_status_id'));
			$this->db->where('language_id', $key);
			$this->db->insert($this->db->dbprefix('return_status_description'), $data['description'][$key]);
			$this->db->reset_query();
		}
	}
	
	public function add($data)
	{
		$this->db->insert($this->db->dbprefix('return_status'), $data['base']);
		
		//取最后查入的一第分类id
		$return_status_id=$this->db->insert_id();
		
		foreach($data['description'] as $key=>$value){
			//组织数组
			$data['description'][$key]['return_status_id']=$return_status_id;
			$data['description'][$key]['language_id']=$key;
		}
		$this->db->insert_batch($this->db->dbprefix('return_status_description'), $data['description']);
		$this->db->reset_query();
	}
	
	public function check_delete($data){
		if(empty($data)){
			return FALSE;
		}
		foreach($data as $key=>$value){
			$this->db->select('return_id');
			$this->db->where('return_status_id', $data[$key]);
			$this->db->from($this->db->dbprefix('return'));
			$query=$this->db->get();
			
			if($query->num_rows() > 0){
				return TRUE;
			}
			
			$this->db->select('return_history_id');
			$this->db->where('return_status_id', $data[$key]);
			$this->db->from($this->db->dbprefix('return_history'));
			$query=$this->db->get();
			
			if($query->num_rows() > 0){
				return TRUE;
			}
		}
		
		return FALSE;
	}
	
	public function delete($data){
		foreach($data as $key=>$value){
			$this->db->delete($this->db->dbprefix('return_status'), array('return_status_id' => $data[$key]));
			$this->db->delete($this->db->dbprefix('return_status_description'), array('return_status_id' => $data[$key]));
		}
	}
}