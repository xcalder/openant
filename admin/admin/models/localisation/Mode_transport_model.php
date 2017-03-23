<?php
class Mode_transport_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	//
	public function get_mode_transports_for_langugae_id($data)
	{
		//
		$this->db->limit($this->config->get_config('config_limit_admin'), $data['page']);
		$this->db->select('mode_transport_id');
		$query = $this->db->get($this->db->dbprefix('mode_transport'));
		
		//统计记录条数
		$mode_transports['count']=$this->db->count_all_results($this->db->dbprefix('mode_transport'));
		
		if($query->num_rows() > 0){
			$row = $query->result_array();
			foreach($row as $value){
				$mode_transports['mode_transports'][] = $this->get_mode_transport($value['mode_transport_id']);
			}
			return $mode_transports;
		}
		
		return FALSE;
	}
	
	//
	public function get_mode_transports_to_setting()
	{
		//
		$this->db->select('mode_transport_id');
		$query = $this->db->get($this->db->dbprefix('mode_transport'));
	
		if($query->num_rows() > 0){
			$row = $query->result_array();
			foreach($row as $value){
				$mode_transports[] = $this->get_mode_transport($value['mode_transport_id']);
			}
			return $mode_transports;
		}
	
		return FALSE;
	}
	
	//
	public function get_mode_transport($mode_transport_id='')
	{
		if(empty($mode_transport_id)){
			return FALSE;
		}
		
		$this->db->where('ra.mode_transport_id',$mode_transport_id);
		$this->db->where('rad.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('mode_transport_description AS rad', 'rad.mode_transport_id = ra.mode_transport_id');
		$this->db->from($this->db->dbprefix('mode_transport') . ' AS ra');
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			return $query->row_array();
		}
		
		return FALSE;
	}
	
	//
	public function get_mode_transport_form($mode_transport_id='')
	{
		if(empty($mode_transport_id)){
			return FALSE;
		}
		
		$this->db->where('mode_transport_id',$mode_transport_id);
		$this->db->from($this->db->dbprefix('mode_transport'));
		$query = $this->db->get();
		if($query->num_rows() > 0){
			$row=$query->row_array();
			$mode_transport=$row;
			
			//查描述
			$this->db->where('mode_transport_id', $row['mode_transport_id']);
			$this->db->from($this->db->dbprefix('mode_transport_description'));
			$query=$this->db->get();
			
			$descriptions=$query->result_array();
			foreach($descriptions as $key=>$value){
				$description[$descriptions[$key]['language_id']]=$value;
			}
			$mode_transport['description']=$description;
			
			return $mode_transport;
		}
		
		return FALSE;
	}
	
	public function edit($data)
	{
		$this->db->where('mode_transport_id', $this->input->get('mode_transport_id'));
		$this->db->update($this->db->dbprefix('mode_transport'), $data['base']);
		
		//先删
		$this->db->delete($this->db->dbprefix('mode_transport_description'), array('mode_transport_id' => $this->input->get('mode_transport_id')));
		
		foreach($data['description'] as $key=>$value){
			//组织数组
			$data['description'][$key]['language_id']=$key;
			$data['description'][$key]['mode_transport_id']=$this->input->get('mode_transport_id');
			
			$this->db->where('mode_transport_id', $this->input->get('mode_transport_id'));
			$this->db->where('language_id', $key);
			$this->db->insert($this->db->dbprefix('mode_transport_description'), $data['description'][$key]);
			$this->db->reset_query();
		}
	}
	
	public function add($data)
	{
		$this->db->insert($this->db->dbprefix('mode_transport'), $data['base']);
		
		//取最后查入的一第分类id
		$mode_transport_id=$this->db->insert_id();
		
		foreach($data['description'] as $key=>$value){
			//组织数组
			
			$data['description'][$key]['mode_transport_id']=$mode_transport_id;
			$data['description'][$key]['language_id']=$key;
		}
		$this->db->insert_batch($this->db->dbprefix('mode_transport_description'), $data['description']);
		$this->db->reset_query();
	}
	
	public function check_delete($data){
		if(empty($data)){
			return FALSE;
		}
		foreach($data as $key=>$value){
			$this->db->select('return_id');
			$this->db->where('mode_transport_id', $data[$key]);
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
			$this->db->delete($this->db->dbprefix('mode_transport'), array('mode_transport_id' => $data[$key]));
			$this->db->delete($this->db->dbprefix('mode_transport_description'), array('mode_transport_id' => $data[$key]));
		}
	}
}