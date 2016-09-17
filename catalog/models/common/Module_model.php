<?php
class Module_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function get_modules_for_module_id($module_id){
		$this->db->select('code, setting');
		$this->db->where('module_id', $module_id);
		$this->db->from($this->db->dbprefix('module'));
		$query=$this->db->get();
		
		if($query->num_rows() > 0){
			$data=$query->row_array();
			$data['setting']=unserialize($data['setting']);
			return $data;
		}
		return FALSE;
	}
}