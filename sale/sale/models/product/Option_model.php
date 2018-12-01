<?php
class Option_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	//取属性
	public function get_option_for_group_id($option_group_id)
	{
		$this->db->where('option.option_group_id', $option_group_id);
		$this->db->where('option_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('option_description','option_description.option_id = option.option_id');
		$this->db->where('option_group_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('option_group_description','option_group_description.option_group_id = option.option_group_id');
		$this->db->from($this->db->dbprefix('option'));
		
		$query=$this->db->get();
		
		if($query->num_rows() > 0){
			return $query->result_array();
		}
		
		return FALSE;
	}
	
	//取组
	public function get_option_group($option){
		if(empty($option)){
			return FALSE;
		}
		
		foreach($option as $key=>$option_group_id){
			$this->db->where('option_group.option_group_id',$option[$key]);
			$this->db->where('option_group_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
			$this->db->join('option_group_description','option_group_description.option_group_id = option_group.option_group_id');
			
			$this->db->from($this->db->dbprefix('option_group'));
			
			$query=$this->db->get();
			if($query->num_rows() > 0){
				$row[$key]=$query->row_array();
				$row[$key]['options']=$this->get_option_for_group_id($option[$key]);
			}
		}
		return $row;
	}
}