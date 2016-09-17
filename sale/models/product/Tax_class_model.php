<?php
class Tax_class_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	//取条码
	public function get_tax_classs($data)
	{
		if(empty($data)){
			return FALSE;
		}
		foreach($data as $key=>$value){
			$row[]=$this->get_tax_class_for_language($data[$key]);
		}
		return $row;
	}

	//取条码
	public function get_tax_class_for_language($tax_class_id)
	{
		$this->db->select('tax_class.tax_class_id, tax_class_description.title, tax_class_description.description');
		$this->db->where('tax_class.tax_class_id', $tax_class_id);
		$this->db->where('tax_class_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('tax_class_description','tax_class_description.tax_class_id = tax_class.tax_class_id');
		$this->db->from($this->db->dbprefix('tax_class'));
		
		$query=$this->db->get();
		
		if($query->num_rows() > 0){
			return $query->row_array();
		}
		
		return FALSE;
	}
}