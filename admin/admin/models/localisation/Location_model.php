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
		$this->db->where('c.status','1');
		$this->db->where('c.country_id',$country_id);
		$this->db->from($this->db->dbprefix('country') . ' AS c');
		$this->db->where('cd.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('country_description AS cd','cd.country_id = c.country_id');
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
		$this->db->where('z.country_id = '.$country_id);
		$this->db->where('z.status = 1');
		$this->db->where('zd.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		
		$this->db->join('zone_description AS zd','zd.zone_id = z.zone_id');
		$this->db->from($this->db->dbprefix('zone') . ' AS z');
		
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