<?php
class Location_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('string');
	}
	
	//
	public function get_countrys()
	{
		//
		$this->db->select('country_id');
		$this->db->where('status','1');
		$this->db->order_by('country_id', 'ASC');
		$this->db->from($this->db->dbprefix('country'));
		$query = $this->db->get(); 
		
		if($query->num_rows() > 0){
			$row = $query->result_array();
			$row = array_flip(array_flip(array_column($row,'country_id')));
			foreach($row as $country_id){
				$countrys[] = $this->get_country($country_id);
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
		$this->db->where('country.status','1');
		$this->db->where('country.country_id',$country_id);
		$this->db->from($this->db->dbprefix('country'));
		$this->db->where('country_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('country_description','country_description.country_id = country.country_id');
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			return $query->row_array();
		}
		
		return FALSE;
	}
	
	//通过国家id查省份
	public function get_zones($country_id = ''){
		if(empty($country_id)){
			return FALSE;
		}
		$this->db->where('zone.country_id = '.$country_id);
		$this->db->where('zone.status = 1');
		$this->db->where('zone_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		
		$this->db->join('zone_description','zone_description.zone_id = zone.zone_id');
		$this->db->from($this->db->dbprefix('zone'));
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			$row = $query->result_array();
			foreach($row as $key=>$value){
				$row[$key]['name']=quotes_to_entities($row[$key]['zone_name']);
			}
			return $row;
		}
		return FALSE;
	}
}