<?php
class Zone_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	//
	public function get_zones_for_langugae_id($data)
	{
		//
		$this->db->limit($this->config->get_config('config_limit_admin'), $data['page']);
		$this->db->select('zone_id');
		//$this->db->from($this->db->dbprefix('zone'));
		$query = $this->db->get($this->db->dbprefix('zone')); 
		
		//统计记录条数
		$zones['count']=$this->db->count_all_results($this->db->dbprefix('zone'));
		
		if($query->num_rows() > 0){
			$row = $query->result_array();
			foreach($row as $value){
				$zones['zones'][] = $this->get_zone($value['zone_id']);
			}
			return $zones;
		}
		
		return FALSE;
	}

	//
	public function get_zone($zone_id='')
	{
		if(empty($zone_id)){
			return FALSE;
		}
		
		$this->db->where('zone.zone_id',$zone_id);
		$this->db->where('zone_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->where('country_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		
		$this->db->join('country_description', 'country_description.country_id = zone.country_id');
		$this->db->join('zone_description', 'zone_description.zone_id = zone.zone_id');
		$this->db->from($this->db->dbprefix('zone'));
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			return $query->row_array();
		}
		
		return FALSE;
	}
	
	//
	public function get_zones($country_id='')
	{
		if(empty($country_id)){
			return FALSE;
		}
		
		$this->db->where('zone.country_id',$country_id);
		$this->db->where('zone_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('zone_description', 'zone_description.zone_id = zone.zone_id');
		$this->db->from($this->db->dbprefix('zone'));
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			return $query->result_array();
		}
		
		return FALSE;
	}
	
	//
	public function get_zone_form($zone_id='')
	{
		if(empty($zone_id)){
			return FALSE;
		}
		
		$this->db->where('zone_id',$zone_id);
		$this->db->from($this->db->dbprefix('zone'));
		$query = $this->db->get();
		if($query->num_rows() > 0){
			$row=$query->row_array();
			$zone=$row;
			
			//查描述
			$this->db->where('zone_id', $row['zone_id']);
			$this->db->from($this->db->dbprefix('zone_description'));
			$query=$this->db->get();
			
			$descriptions=$query->result_array();
			foreach($descriptions as $key=>$value){
				$description[$descriptions[$key]['language_id']]=$value;
			}
			$zone['description']=$description;
			
			return $zone;
		}
		
		return FALSE;
	}
	
	public function edit($data)
	{
		//先删
		$this->db->delete($this->db->dbprefix('zone_description'), array('zone_id' => $this->input->get('zone_id')));
		
		foreach($data['description'] as $key=>$value){
			//组织数组
			$data['description'][$key]['language_id']=$key;
			$data['description'][$key]['zone_id']=$this->input->get('zone_id');
			
			$this->db->where('zone_id', $this->input->get('zone_id'));
			$this->db->where('language_id', $key);
			$this->db->insert($this->db->dbprefix('zone_description'), $data['description'][$key]);
			$this->db->reset_query();
		}
		
		$this->db->where('zone_id', $this->input->get('zone_id'));
		$this->db->update($this->db->dbprefix('zone'), $data['base']);
		
	}
	
	public function add($data)
	{
		$this->db->insert($this->db->dbprefix('zone'), $data['base']);
		
		//取最后查入的一第分类id
		$zone_id=$this->db->insert_id();
		
		foreach($data['description'] as $key=>$value){
			//组织数组
			$data['description'][$key]['zone_id']=$zone_id;
			$data['description'][$key]['language_id']=$key;
		}
		$this->db->insert_batch($this->db->dbprefix('zone_description'), $data['description']);
		$this->db->reset_query();
	}
	
	public function check_delete($data){
		if(empty($data)){
			return FALSE;
		}
		foreach($data as $key=>$value){
			$this->db->select('address_id');
			$this->db->where('address_id', $data[$key]);
			$this->db->from($this->db->dbprefix('address'));
			$query=$this->db->get();
			
			if($query->num_rows() > 0){
				return TRUE;
			}
		}
		
		return FALSE;
	}
	
	public function delete($data){
		foreach($data as $key=>$value){
			$this->db->delete($this->db->dbprefix('zone'), array('zone_id' => $data[$key]));
			$this->db->delete($this->db->dbprefix('zone_description'), array('zone_id' => $data[$key]));
		}
	}
}