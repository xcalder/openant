<?php
class Return_mode_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	//
	public function get_return_modes()
	{
		//
		$this->db->select('rm.return_mode_id, rmd.name');
		$this->db->order_by('rm.sort_order', 'ASC');
		
		$this->db->where('rmd.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('return_mode_description AS rmd', 'rm.return_mode_id = rmd.return_mode_id');
		
		$this->db->from($this->db->dbprefix('return_mode') . ' AS rm');
		$query = $this->db->get(); 
		
		if($query->num_rows() > 0){
			return $query->result_array();
		}
		
		return FALSE;
	}
}