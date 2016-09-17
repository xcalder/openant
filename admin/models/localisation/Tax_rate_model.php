<?php
class Tax_rate_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	//
	public function get_tax_rates_for_langugae_id($data)
	{
		//
		$this->db->limit($this->config->get_config('config_limit_admin'), $data['page']);
		$this->db->select('tax_rate_id');
		//$this->db->from($this->db->dbprefix('tax_rate'));
		$query = $this->db->get($this->db->dbprefix('tax_rate')); 
		
		//统计记录条数
		$tax_rates['count']=$this->db->count_all_results($this->db->dbprefix('tax_rate'));
		
		if($query->num_rows() > 0){
			$row = $query->result_array();
			foreach($row as $value){
				$tax_rates['tax_rates'][] = $this->get_tax_rate($value['tax_rate_id']);
			}
			return $tax_rates;
		}
		
		return FALSE;
	}
	
	public function get_tax_rates()
	{
		$this->db->select('tax_rate_id');
		$this->db->from($this->db->dbprefix('tax_rate'));
		$query = $this->db->get(); 
		
		if($query->num_rows() > 0){
			$row = $query->result_array();
			foreach($row as $value){
				$tax_rates[] = $this->get_tax_rate($value['tax_rate_id']);
			}
			return $tax_rates;
		}
		
		return FALSE;
	}
	
	//
	public function get_tax_rate($tax_rate_id='')
	{
		if(empty($tax_rate_id)){
			return FALSE;
		}
		
		$this->db->where('tax_rate.tax_rate_id',$tax_rate_id);
		$this->db->where('tax_rate_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->where('geo_zone_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('tax_rate_description', 'tax_rate_description.tax_rate_id = tax_rate.tax_rate_id');
		$this->db->join('geo_zone', 'geo_zone.geo_zone_id = tax_rate.geo_zone_id');
		$this->db->join('geo_zone_description', 'geo_zone_description.geo_zone_id = geo_zone.geo_zone_id');
		
		$this->db->from($this->db->dbprefix('tax_rate'));
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			return $query->row_array();
		}
		
		return FALSE;
	}
	
	//
	public function get_tax_rate_form($tax_rate_id='')
	{
		if(empty($tax_rate_id)){
			return FALSE;
		}
		
		$this->db->where('tax_rate_id',$tax_rate_id);
		$this->db->from($this->db->dbprefix('tax_rate'));
		$query = $this->db->get();
		if($query->num_rows() > 0){
			$row=$query->row_array();
			$tax_rate=$row;
			
			//查描述
			$this->db->where('tax_rate_id', $row['tax_rate_id']);
			$this->db->from($this->db->dbprefix('tax_rate_description'));
			$query=$this->db->get();
			
			$descriptions=$query->result_array();
			foreach($descriptions as $key=>$value){
				$description[$descriptions[$key]['language_id']]=$value;
			}
			$tax_rate['description']=$description;
			
			return $tax_rate;
		}
		
		return FALSE;
	}
	
	public function edit($data)
	{
		//先删tax_rule
		$this->db->delete($this->db->dbprefix('tax_rate_description'), array('tax_rate_id' => $this->input->get('tax_rate_id')));
		
		foreach($data['description'] as $key=>$value){
			//组织数组
			$data['description'][$key]['language_id']=$key;
			$data['description'][$key]['tax_rate_id']=$this->input->get('tax_rate_id');
			
			$this->db->where('tax_rate_id', $this->input->get('tax_rate_id'));
			$this->db->where('language_id', $key);
			$this->db->insert($this->db->dbprefix('tax_rate_description'), $data['description'][$key]);
			$this->db->reset_query();
		}
		
		$this->db->where('tax_rate_id', $this->input->get('tax_rate_id'));
		$this->db->update($this->db->dbprefix('tax_rate'), $data['base']);
		$this->db->reset_query();
		
		$this->db->where('tax_rate_id', $this->input->get('tax_rate_id'));
		$this->db->update($this->db->dbprefix('tax_rate_to_user_group'), $data['user_group']);
	}
	
	public function add($data)
	{
		$this->db->insert($this->db->dbprefix('tax_rate'), $data['base']);
		
		//取最后查入的一第分类id
		$tax_rate_id=$this->db->insert_id();
		
		foreach($data['description'] as $key=>$value){
			//组织数组
			$data['description'][$key]['tax_rate_id']=$tax_rate_id;
			$data['description'][$key]['language_id']=$key;
		}
		$this->db->insert_batch($this->db->dbprefix('tax_rate_description'), $data['description']);
		$this->db->reset_query();
		
		$data['user_group']['tax_rate_id']=$tax_rate_id;
		$this->db->insert($this->db->dbprefix('tax_rate_to_user_group'), $data['user_group']);
	}
	
	public function check_delete_tax_rate($data){
		if(empty($data)){
			return FALSE;
		}
		foreach($data as $key=>$value){
			$this->db->select('tax_rule_id');
			$this->db->where('tax_rate_id', $data[$key]);
			$this->db->from($this->db->dbprefix('tax_rule'));
			$query=$this->db->get();
			
			if($query->num_rows() > 0){
				return TRUE;
			}
		}
		
		return FALSE;
	}
	
	public function delete_tax_rate($data){
		foreach($data as $key=>$value){
			$this->db->delete($this->db->dbprefix('tax_rate'), array('tax_rate_id' => $data[$key]));
			$this->db->delete($this->db->dbprefix('tax_rate_description'), array('tax_rate_id' => $data[$key]));
			$this->db->delete($this->db->dbprefix('tax_rate_to_user_group'), array('tax_rate_id' => $data[$key]));
			$this->db->delete($this->db->dbprefix('tax_rule'), array('tax_rate_id' => $data[$key]));
		}
	}
}