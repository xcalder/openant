<?php
class Mode_transport_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	//
	public function get_mode_transports()
	{
		//
		$this->db->select('m.mode_transport_id, md.name');
		$this->db->order_by('m.sort_order', 'ASC');
		
		$this->db->where('md.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('mode_transport_description AS md', 'm.mode_transport_id = md.mode_transport_id');
		
		$this->db->from($this->db->dbprefix('mode_transport') . ' AS m');
		$query = $this->db->get(); 
		
		if($query->num_rows() > 0){
			return $query->result_array();
		}
		
		return FALSE;
	}
}