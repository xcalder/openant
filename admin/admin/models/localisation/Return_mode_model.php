<?php
class Return_mode_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	//
	public function get_return_modes_for_langugae_id($data)
	{
		//
		$this->db->limit($this->config->get_config('config_limit_admin'), $data['page']);
		$this->db->select('return_mode_id');
		$query = $this->db->get($this->db->dbprefix('return_mode'));
		
		//统计记录条数
		$return_modes['count']=$this->db->count_all_results($this->db->dbprefix('return_mode'));
		
		if($query->num_rows() > 0){
			$row = $query->result_array();
			foreach($row as $value){
				$return_modes['return_modes'][] = $this->get_return_mode($value['return_mode_id']);
			}
			return $return_modes;
		}
		
		return FALSE;
	}
	
	//
	public function get_return_modes_to_setting()
	{
		//
		$this->db->select('return_mode_id');
		$query = $this->db->get($this->db->dbprefix('return_mode'));
	
		if($query->num_rows() > 0){
			$row = $query->result_array();
			foreach($row as $value){
				$return_modes[] = $this->get_return_mode($value['return_mode_id']);
			}
			return $return_modes;
		}
	
		return FALSE;
	}
	
	//
	public function get_return_mode($return_mode_id='')
	{
		if(empty($return_mode_id)){
			return FALSE;
		}
		
		$this->db->where('ra.return_mode_id',$return_mode_id);
		$this->db->where('rad.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('return_mode_description AS rad', 'rad.return_mode_id = ra.return_mode_id');
		$this->db->from($this->db->dbprefix('return_mode') . ' AS ra');
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			return $query->row_array();
		}
		
		return FALSE;
	}
	
	//
	public function get_return_mode_form($return_mode_id='')
	{
		if(empty($return_mode_id)){
			return FALSE;
		}
		
		$this->db->where('return_mode_id',$return_mode_id);
		$this->db->from($this->db->dbprefix('return_mode'));
		$query = $this->db->get();
		if($query->num_rows() > 0){
			$row=$query->row_array();
			$return_mode=$row;
			
			//查描述
			$this->db->where('return_mode_id', $row['return_mode_id']);
			$this->db->from($this->db->dbprefix('return_mode_description'));
			$query=$this->db->get();
			
			$descriptions=$query->result_array();
			foreach($descriptions as $key=>$value){
				$description[$descriptions[$key]['language_id']]=$value;
			}
			$return_mode['description']=$description;
			
			return $return_mode;
		}
		
		return FALSE;
	}
	
	public function edit($data)
	{
		$this->db->where('return_mode_id', $this->input->get('return_mode_id'));
		$this->db->update($this->db->dbprefix('return_mode'), $data['base']);
		
		//先删
		$this->db->delete($this->db->dbprefix('return_mode_description'), array('return_mode_id' => $this->input->get('return_mode_id')));
		
		foreach($data['description'] as $key=>$value){
			//组织数组
			$data['description'][$key]['language_id']=$key;
			$data['description'][$key]['return_mode_id']=$this->input->get('return_mode_id');
			
			$this->db->where('return_mode_id', $this->input->get('return_mode_id'));
			$this->db->where('language_id', $key);
			$this->db->insert($this->db->dbprefix('return_mode_description'), $data['description'][$key]);
			$this->db->reset_query();
		}
	}
	
	public function add($data)
	{
		$this->db->insert($this->db->dbprefix('return_mode'), $data['base']);
		
		//取最后查入的一第分类id
		$return_mode_id=$this->db->insert_id();
		
		foreach($data['description'] as $key=>$value){
			//组织数组
			
			$data['description'][$key]['return_mode_id']=$return_mode_id;
			$data['description'][$key]['language_id']=$key;
		}
		$this->db->insert_batch($this->db->dbprefix('return_mode_description'), $data['description']);
		$this->db->reset_query();
	}
	
	public function check_delete($data){
		if(empty($data)){
			return FALSE;
		}
		foreach($data as $key=>$value){
			$this->db->select('return_id');
			$this->db->where('return_mode_id', $data[$key]);
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
			$this->db->delete($this->db->dbprefix('return_mode'), array('return_mode_id' => $data[$key]));
			$this->db->delete($this->db->dbprefix('return_mode_description'), array('return_mode_id' => $data[$key]));
		}
	}
}