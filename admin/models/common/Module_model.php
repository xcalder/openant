<?php
class Module_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function get_modules(){
		$codes = array('sign_in_with', 'payment', 'delivery', 'overall');
		$this->db->where_not_in('code', $codes);
		
		$this->db->from($this->db->dbprefix('module'));
		$query=$this->db->get();
		
		return $query->result_array();
	}


	public function get_modules_for_code($code){
		$this->db->where('code', $code);
		$this->db->from($this->db->dbprefix('module'));
		$query=$this->db->get();
		
		if($query->num_rows() > 0){
			return $query->result_array();
		}
		return FALSE;
	}
	
	public function get_modules_for_module_id($module_id){
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
	
	public function update($data, $code){
		
		$data['setting']=serialize($data['setting']);
		$data['code']=$code;
		$this->db->where('module_id', $this->input->get('module_id'));
		$this->db->update($this->db->dbprefix('module'), $data);
	}
	
	public function add($data, $code){
		
		$data['setting']=serialize($data['setting']);
		$data['code']=$code;
		$this->db->insert($this->db->dbprefix('module'), $data);
	}
	
	public function delete($module_id){
		
		$this->db->where('module_id', $module_id);
		if($this->db->delete($this->db->dbprefix('module')) == FALSE){
			return FALSE;
		}
		return TRUE;
	}
}