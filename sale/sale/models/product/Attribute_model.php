<?php
class Attribute_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	//取属性
	public function get_attribute_for_group_id($attribute_group_id)
	{
		$this->db->where('attribute.attribute_group_id', $attribute_group_id);
		$this->db->where('attribute_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('attribute_description','attribute_description.attribute_id = attribute.attribute_id');
		$this->db->where('attribute_group_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('attribute_group_description','attribute_group_description.attribute_group_id = attribute.attribute_group_id');
		$this->db->from($this->db->dbprefix('attribute'));
		
		$query=$this->db->get();
		
		if($query->num_rows() > 0){
			return $query->result_array();
		}
		
		return FALSE;
	}

	//取组的单条
	public function get_attribute_group($attributes){
		if(empty($attributes)){
			return FALSE;
		}
		
		foreach($attributes as $key=>$attribute_group_id){
			$this->db->where('attribute_group.attribute_group_id',$attributes[$key]);
			$this->db->where('attribute_group_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
			$this->db->join('attribute_group_description','attribute_group_description.attribute_group_id = attribute_group.attribute_group_id');
			
			$this->db->from($this->db->dbprefix('attribute_group'));
			
			$query=$this->db->get();
			if($query->num_rows() > 0){
				$row[$key]=$query->row_array();
				$row[$key]['attributes']=$this->get_attribute_for_group_id($attributes[$key]);
			}
		}
		return $row;
	}
}