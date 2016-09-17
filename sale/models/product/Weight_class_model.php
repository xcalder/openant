<?php
class Weight_class_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	//取组
	public function get_weight_classs(){
		
		$this->db->select("weight_class_id");
		$this->db->from($this->db->dbprefix('weight_class'));
		$query=$this->db->get();
		
		if($query->num_rows() > 0){
			$re=$query->result_array();
			foreach($re as $key=>$value){
				$row[]=$this->get_weight_class($re[$key]['weight_class_id']);
			}
			
			return $row;
		}
		return FALSE;
	}

	//取组的单条
	public function get_weight_class($weight_class_id){
		$this->db->where('weight_class.weight_class_id',$weight_class_id);
		$this->db->where('weight_class_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('weight_class_description','weight_class_description.weight_class_id = weight_class.weight_class_id');
		
		$this->db->from($this->db->dbprefix('weight_class'));
		
		$query=$this->db->get();
		if($query->num_rows() > 0){
			return $query->row_array();
		}
		
		return FALSE;
	}
}