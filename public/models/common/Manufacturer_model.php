<?php
class Manufacturer_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	//取品牌
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
		$this->db->select('m.manufacturer_id, m.image, md.name, md.description');
		$this->db->where('m.manufacturer_id', $manufacturer_id);
		$this->db->where('md.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('manufacturer_description AS md','md.manufacturer_id = m.manufacturer_id');
		$this->db->from($this->db->dbprefix('manufacturer') . ' AS m');
		
		$query=$this->db->get();
		
		if($query->num_rows() > 0){
			return $query->row_array();
		}
		
		return FALSE;
	}
}