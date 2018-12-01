<?php
class Aftermarket_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	//取条码
	public function get_aftermarkets($data)
	{
		if(empty($data)){
			return FALSE;
		}
		foreach($data as $key=>$value){
			$row[]=$this->get_aftermarket_for_language($data[$key]);
		}
		return $row;
	}

	//取条码
	public function get_aftermarket_for_language($aftermarket_id)
	{
		$this->db->select('aftermarket.aftermarket_id, aftermarket_description.name');
		$this->db->where('aftermarket.aftermarket_id', $aftermarket_id);
		$this->db->where('aftermarket_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('aftermarket_description','aftermarket_description.aftermarket_id = aftermarket.aftermarket_id');
		$this->db->from($this->db->dbprefix('aftermarket'));
		
		$query=$this->db->get();
		
		if($query->num_rows() > 0){
			return $query->row_array();
		}
		
		return FALSE;
	}
}