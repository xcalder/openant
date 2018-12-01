<?php
class User_class_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	//给设置
	public function get_user_classs_to_product()
	{
		$this->db->select('user_class.user_class_id');
		
		$this->db->order_by('user_class.sort_order','ASC');
		
		$query = $this->db->get($this->db->dbprefix('user_class'));
		
		
		if($query->num_rows() > 0){
			$user_classs = $query->result_array();
			$user_classs = array_flip(array_flip(array_column($user_classs,'user_class_id')));
			foreach ($user_classs as $user_class) {
				$user_class_s[] = $this->get_user_class($user_class);
			}
			
			return $user_class_s;
		}
		
		return FALSE;
	}

	public function get_user_class($user_class_id)
	{
		$this->db->select('*');
		$this->db->where('user_class.user_class_id',$user_class_id);
		$this->db->where('user_class_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('user_class_description','user_class_description.user_class_id = user_class.user_class_id');
		$this->db->from($this->db->dbprefix('user_class'));
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			return $query->row_array();
		}
		
		return FALSE;
	}
}