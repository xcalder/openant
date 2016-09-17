<?php
class Freight_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	//取组
	public function get_freight_templates(){
		
		$this->db->select("freight_template_id");
		$this->db->where('store_id', $this->user->getStore_id());
		$this->db->from($this->db->dbprefix('freight_template'));
		$query=$this->db->get();
		
		if($query->num_rows() > 0){
			$re=$query->result_array();
			foreach($re as $key=>$value){
				$row[]=$this->get_freight_template($re[$key]['freight_template_id']);
			}
			
			return $row;
		}
		return FALSE;
	}

	//取组的单条
	public function get_freight_template($freight_template_id){
		$this->db->where('freight_template.freight_template_id',$freight_template_id);
		$this->db->where('freight_template_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('freight_template_description','freight_template_description.freight_template_id = freight_template.freight_template_id');
		
		$this->db->from($this->db->dbprefix('freight_template'));
		
		$query=$this->db->get();
		if($query->num_rows() > 0){
			return $query->row_array();
		}
		
		return FALSE;
	}
}