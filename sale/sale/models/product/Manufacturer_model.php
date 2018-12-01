<?php
class Manufacturer_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	//取品牌列表
	public function get_manufacturers($data)
	{
		if(empty($data)){
			return FALSE;
		}
		foreach($data as $key=>$value){
			$row[]=$this->get_manufacturer_for_language($data[$key]);
		}
		return $row;
	}

	//取品牌
	public function get_manufacturer_for_language($manufacturer_id)
	{
		$this->db->select('manufacturer.manufacturer_id, manufacturer_description.name');
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