<?php
class Return_reason_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	//
	public function get_return_reasons_for_langugae_id($data)
	{
		//
		$this->db->limit($this->config->get_config('config_limit_admin'), $data['page']);
		$this->db->select('return_reason_id');
		//$this->db->from($this->db->dbprefix('return_reason'));
		$query = $this->db->get($this->db->dbprefix('return_reason')); 
		
		//统计记录条数
		$return_reasons['count']=$this->db->count_all_results($this->db->dbprefix('return_reason'));
		
		if($query->num_rows() > 0){
			$row = $query->result_array();
			foreach($row as $value){
				$return_reasons['return_reasons'][] = $this->get_return_reason($value['return_reason_id']);
			}
			return $return_reasons;
		}
		
		return FALSE;
	}
	
	//
	public function get_return_reason($return_reason_id='')
	{
		if(empty($return_reason_id)){
			return FALSE;
		}
		
		$this->db->where('return_reason.return_reason_id',$return_reason_id);
		$this->db->where('return_reason_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('return_reason_description', 'return_reason_description.return_reason_id = return_reason.return_reason_id');
		$this->db->from($this->db->dbprefix('return_reason'));
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			return $query->row_array();
		}
		
		return FALSE;
	}
	
	//
	public function get_return_reason_form($return_reason_id='')
	{
		if(empty($return_reason_id)){
			return FALSE;
		}
		
		$this->db->where('return_reason_id',$return_reason_id);
		$this->db->from($this->db->dbprefix('return_reason'));
		$query = $this->db->get();
		if($query->num_rows() > 0){
			$row=$query->row_array();
			$return_reason=$row;
			
			//查描述
			$this->db->where('return_reason_id', $row['return_reason_id']);
			$this->db->from($this->db->dbprefix('return_reason_description'));
			$query=$this->db->get();
			
			$descriptions=$query->result_array();
			foreach($descriptions as $key=>$value){
				$description[$descriptions[$key]['language_id']]=$value;
			}
			$return_reason['description']=$description;
			
			return $return_reason;
		}
		
		return FALSE;
	}
	
	public function edit($data)
	{
		$this->db->where('return_reason_id', $this->input->get('return_reason_id'));
		$this->db->update($this->db->dbprefix('return_reason'), $data['base']);
		
		//先删
		$this->db->delete($this->db->dbprefix('return_reason_description'), array('return_reason_id' => $this->input->get('return_reason_id')));
		
		foreach($data['description'] as $key=>$value){
			//组织数组
			$data['description'][$key]['language_id']=$key;
			$data['description'][$key]['return_reason_id']=$this->input->get('return_reason_id');
			
			$this->db->where('return_reason_id', $this->input->get('return_reason_id'));
			$this->db->where('language_id', $key);
			$this->db->insert($this->db->dbprefix('return_reason_description'), $data['description'][$key]);
			$this->db->reset_query();
		}
	}
	
	public function add($data)
	{
		$this->db->insert($this->db->dbprefix('return_reason'), $data['base']);
		
		//取最后查入的一第分类id
		$return_reason_id=$this->db->insert_id();
		
		foreach($data['description'] as $key=>$value){
			//组织数组
			$data['description'][$key]['return_reason_id']=$return_reason_id;
			$data['description'][$key]['language_id']=$key;
		}
		
		$this->db->insert_batch($this->db->dbprefix('return_reason_description'), $data['description']);
		$this->db->reset_query();
	}
	
	public function check_delete($data){
		if(empty($data)){
			return FALSE;
		}
		foreach($data as $key=>$value){
			$this->db->select('return_id');
			$this->db->where('return_reason_id', $data[$key]);
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
			$this->db->delete($this->db->dbprefix('return_reason'), array('return_reason_id' => $data[$key]));
			$this->db->delete($this->db->dbprefix('return_reason_description'), array('return_reason_id' => $data[$key]));
		}
	}
}