<?php
class Barcode_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	//取条码
	public function get_barcodes($data)
	{
		if(empty($data)){
			return FALSE;
		}
		foreach($data as $key=>$value){
			$row[]=$this->get_barcode_for_language($data[$key]);
		}
		return $row;
	}

	//取条码
	public function get_barcode_for_language($barcode_id)
	{
		$this->db->select('barcode.barcode_id, barcode_description.name');
		$this->db->where('barcode.barcode_id', $barcode_id);
		$this->db->where('barcode_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('barcode_description','barcode_description.barcode_id = barcode.barcode_id');
		$this->db->from($this->db->dbprefix('barcode'));
		
		$query=$this->db->get();
		
		if($query->num_rows() > 0){
			return $query->row_array();
		}
		
		return FALSE;
	}
}