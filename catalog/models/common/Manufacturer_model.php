<?php
class Manufacturer_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	//取品牌到header
	public function get_manufacturers_all($page)
	{
		$limit=$this->config->get_config('config_limit_catalog');
		//统计记录条数
		$this->db->select('manufacturer_id');
		$this->db->where('status', '0');
		$result['count']=$this->db->count_all_results($this->db->dbprefix('manufacturer'));
		
		$this->db->select('manufacturer_id');
		$this->db->where('status', '0');
		$this->db->limit($limit, $page);
		$this->db->from($this->db->dbprefix('manufacturer'));
		$query=$this->db->get();
		if($query->num_rows() > 0){
			foreach($query->result_array() as $value){
				$row[]=$this->get_manufacturer_for_language($value['manufacturer_id']);
			}
			$result['manufacturers']=$row;
			return $result;
		}
		return FALSE;
	}
	
	//取品牌到header
	public function get_manufacturers_to_header()
	{
		$this->db->select('manufacturer_id');
		$this->db->where('status', '0');
		$this->db->limit(5);
		$this->db->order_by('manufacturer_id', 'RANDOM');
		$this->db->from($this->db->dbprefix('manufacturer'));
		$query=$this->db->get();
		if($query->num_rows() > 0){
			foreach($query->result_array() as $value){
				$row[]=$this->get_manufacturer_for_language($value['manufacturer_id']);
			}
			return $row;
		}
		return FALSE;
	}
	
	//取品牌
	public function get_manufacturer_for_language($manufacturer_id)
	{
		$this->db->select('manufacturer.manufacturer_id, manufacturer.image, manufacturer_description.name, manufacturer_description.description');
		$this->db->where('manufacturer.manufacturer_id', $manufacturer_id);
		$this->db->where('manufacturer_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('manufacturer_description','manufacturer_description.manufacturer_id = manufacturer.manufacturer_id');
		$this->db->from($this->db->dbprefix('manufacturer'));
		
		$query=$this->db->get();
		
		if($query->num_rows() > 0){
			return $query->row_array();
		}
		
		return FALSE;
	}
}