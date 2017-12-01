<?php
class User_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	public function get_user($user_id='')
	{
		if(empty($user_id)){
			return FALSE;
		}
		$this->db->select('*');
		$this->db->where('user.user_id',$user_id);
		$this->db->where('user_group_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('user_group_description','user_group_description.user_group_id = user.user_group_id');
		$this->db->from($this->db->dbprefix('user'));
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			return $query->row_array();
		}
		
		return FALSE;
	}
	
	public function get_user_info($user_id='')
	{
		if(empty($user_id)){
			return FALSE;
		}
		$this->db->select('*');
		$this->db->where('user.user_id',$user_id);
		$this->db->from($this->db->dbprefix('user'));
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			return $query->row_array();
		}
		
		return FALSE;
	}
	
	public function get_user_towecome($user_ids){
		if(empty($user_ids)){
			return FALSE;
		}
		$this->db->select('user_id, image, nickname');
		$this->db->where_in('user_id',$user_ids);
		$this->db->from($this->db->dbprefix('user'));
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			return $query->result_array();
		}
		
		return FALSE;
	}
}