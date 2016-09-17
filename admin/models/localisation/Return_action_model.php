<?php
class Return_action_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	//
	public function get_return_actions_for_langugae_id($data)
	{
		//
		$this->db->limit($this->config->get_config('config_limit_admin'), $data['page']);
		$this->db->select('return_action_id');
		//$this->db->from($this->db->dbprefix('return_action'));
		$query = $this->db->get($this->db->dbprefix('return_action'));
		
		//统计记录条数
		$return_actions['count']=$this->db->count_all_results($this->db->dbprefix('return_action'));
		
		if($query->num_rows() > 0){
			$row = $query->result_array();
			foreach($row as $value){
				$return_actions['return_actions'][] = $this->get_return_action($value['return_action_id']);
			}
			return $return_actions;
		}
		
		return FALSE;
	}
	
	//
	public function get_return_action($return_action_id='')
	{
		if(empty($return_action_id)){
			return FALSE;
		}
		
		$this->db->where('return_action.return_action_id',$return_action_id);
		$this->db->where('return_action_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('return_action_description', 'return_action_description.return_action_id = return_action.return_action_id');
		$this->db->from($this->db->dbprefix('return_action'));
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			return $query->row_array();
		}
		
		return FALSE;
	}
	
	//
	public function get_return_action_form($return_action_id='')
	{
		if(empty($return_action_id)){
			return FALSE;
		}
		
		$this->db->where('return_action_id',$return_action_id);
		$this->db->from($this->db->dbprefix('return_action'));
		$query = $this->db->get();
		if($query->num_rows() > 0){
			$row=$query->row_array();
			$return_action=$row;
			
			//查描述
			$this->db->where('return_action_id', $row['return_action_id']);
			$this->db->from($this->db->dbprefix('return_action_description'));
			$query=$this->db->get();
			
			$descriptions=$query->result_array();
			foreach($descriptions as $key=>$value){
				$description[$descriptions[$key]['language_id']]=$value;
			}
			$return_action['description']=$description;
			
			return $return_action;
		}
		
		return FALSE;
	}
	
	public function edit($data)
	{
		$this->db->where('return_action_id', $this->input->get('return_action_id'));
		$this->db->update($this->db->dbprefix('return_action'), $data['base']);
		
		//先删
		$this->db->delete($this->db->dbprefix('return_action_description'), array('return_action_id' => $this->input->get('return_action_id')));
		
		foreach($data['description'] as $key=>$value){
			//组织数组
			$data['description'][$key]['language_id']=$key;
			$data['description'][$key]['return_action_id']=$this->input->get('return_action_id');
			
			$this->db->where('return_action_id', $this->input->get('return_action_id'));
			$this->db->where('language_id', $key);
			$this->db->insert($this->db->dbprefix('return_action_description'), $data['description'][$key]);
			$this->db->reset_query();
		}
	}
	
	public function add($data)
	{
		$this->db->insert($this->db->dbprefix('return_action'), $data['base']);
		
		//取最后查入的一第分类id
		$return_action_id=$this->db->insert_id();
		
		foreach($data['description'] as $key=>$value){
			//组织数组
			
			$data['description'][$key]['return_action_id']=$return_action_id;
			$data['description'][$key]['language_id']=$key;
		}
		$this->db->insert_batch($this->db->dbprefix('return_action_description'), $data['description']);
		$this->db->reset_query();
	}
	
	public function check_delete($data){
		if(empty($data)){
			return FALSE;
		}
		foreach($data as $key=>$value){
			$this->db->select('return_id');
			$this->db->where('return_action_id', $data[$key]);
			$this->db->from($this->db->dbprefix('return'));
			$query=$this->db->get();
			
			if($query->num_rows() > 0){
				return TRUE;
			}
		}
		
		return FALSE;
	}
	
	public function delete($data){
		foreach($data as $key=>$value){
			$this->db->delete($this->db->dbprefix('return_action'), array('return_action_id' => $data[$key]));
			$this->db->delete($this->db->dbprefix('return_action_description'), array('return_action_id' => $data[$key]));
		}
	}
}