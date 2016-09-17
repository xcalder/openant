<?php
class Address_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	//查地址
	public function get_addresss($user_id='')
	{
		if(empty($user_id)){
			return FALSE;
		}
		$this->db->where('user_id', $user_id);
		$this->db->from($this->db->dbprefix('address'));
		$query = $this->db->get(); 
		
		if($query->num_rows() > 0){
			return $query->result_array();
		}
		
		return FALSE;
	}
	
	//用id查地址
	public function get_address($address_id='')
	{
		$this->db->where('address_id', $address_id);
		$this->db->from($this->db->dbprefix('address'));
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			return $query->row_array();
		}
		
		return FALSE;
	}
}