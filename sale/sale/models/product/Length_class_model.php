<?php
class Length_class_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	//取组
	public function get_length_classs(){
		
		$this->db->select("length_class_id");
		$this->db->from($this->db->dbprefix('length_class'));
		$query=$this->db->get();
		
		if($query->num_rows() > 0){
			$re=$query->result_array();
			foreach($re as $key=>$value){
				$row[]=$this->get_length_class($re[$key]['length_class_id']);
			}
			
			return $row;
		}
		return FALSE;
	}

	//取组的单条
	public function get_length_class($length_class_id){
		$this->db->where('length_class.length_class_id',$length_class_id);
		$this->db->where('length_class_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('length_class_description','length_class_description.length_class_id = length_class.length_class_id');
		
		$this->db->from($this->db->dbprefix('length_class'));
		
		$query=$this->db->get();
		if($query->num_rows() > 0){
			return $query->row_array();
		}
		
		return FALSE;
	}
}