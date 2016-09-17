<?php
class Country_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	//
	public function get_countrys_for_langugae_id($data)
	{
		//
		$this->db->limit($this->config->get_config('config_limit_admin'), $data['page']);
		$this->db->select('country_id');
		//$this->db->from($this->db->dbprefix('country'));
		$query = $this->db->get($this->db->dbprefix('country')); 
		
		//统计记录条数
		$countrys['count']=$this->db->count_all_results($this->db->dbprefix('country'));
		
		if($query->num_rows() > 0){
			$row = $query->result_array();
			foreach($row as $value){
				$countrys['countrys'][] = $this->get_country($value['country_id']);
			}
			return $countrys;
		}
		
		return FALSE;
	}
	
	//
	public function get_countrys()
	{
		//
		$this->db->select('country_id');
		$this->db->from($this->db->dbprefix('country'));
		$query = $this->db->get(); 
		
		if($query->num_rows() > 0){
			$row = $query->result_array();
			foreach($row as $value){
				$countrys[] = $this->get_country($value['country_id']);
			}
			return $countrys;
		}
		
		return FALSE;
	}
	
	//
	public function get_country($country_id='')
	{
		if(empty($country_id)){
			return FALSE;
		}
		
		$this->db->where('country.country_id',$country_id);
		$this->db->where('country_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('country_description', 'country_description.country_id = country.country_id');
		$this->db->from($this->db->dbprefix('country'));
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			return $query->row_array();
		}
		
		return FALSE;
	}
	
	//
	public function get_country_form($country_id='')
	{
		if(empty($country_id)){
			return FALSE;
		}
		
		$this->db->where('country_id',$country_id);
		$this->db->from($this->db->dbprefix('country'));
		$query = $this->db->get();
		if($query->num_rows() > 0){
			$row=$query->row_array();
			$country=$row;
			
			//查描述
			$this->db->where('country_id', $row['country_id']);
			$this->db->from($this->db->dbprefix('country_description'));
			$query=$this->db->get();
			
			$descriptions=$query->result_array();
			foreach($descriptions as $key=>$value){
				$description[$descriptions[$key]['language_id']]=$value;
			}
			$country['description']=$description;
			
			return $country;
		}
		
		return FALSE;
	}
	
	public function edit($data)
	{
		$this->db->where('country_id', $this->input->get('country_id'));
		$this->db->update($this->db->dbprefix('country'), $data['base']);
		
		$this->db->delete($this->db->dbprefix('country_description'), array('country_id' => $this->input->get('country_id')));
		
		foreach($data['description'] as $key=>$value){
			//组织数组
			$data['description'][$key]['language_id']=$key;
			$data['description'][$key]['country_id']=$this->input->get('country_id');
			
			$this->db->where('country_id', $this->input->get('country_id'));
			$this->db->where('language_id', $key);
		}
		
		$this->db->insert_batch($this->db->dbprefix('country_description'), $data['description']);
		$this->db->reset_query();
	}
	
	public function add($data)
	{
		$this->db->insert($this->db->dbprefix('country'), $data['base']);
		
		//取最后查入的一第分类id
		$country_id=$this->db->insert_id();
		
		foreach($data['description'] as $key=>$value){
			//组织数组
			$data['description'][$key]['country_id']=$country_id;
			$data['description'][$key]['language_id']=$key;
		}
		
		$this->db->insert_batch($this->db->dbprefix('country_description'), $data['description']);
		$this->db->reset_query();
	}
	
	public function check_delete($data){
		if(empty($data)){
			return FALSE;
		}
		foreach($data as $key=>$value){
			$this->db->select('address_id');
			$this->db->where('country_id', $data[$key]);
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
			$this->db->delete($this->db->dbprefix('country'), array('country_id' => $data[$key]));
			$this->db->delete($this->db->dbprefix('country_description'), array('country_id' => $data[$key]));
		}
	}
}