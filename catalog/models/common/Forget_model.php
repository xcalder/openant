<?php
class Forget_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function check_times($email)
	{
		$this->delete();
		
		if(empty($email)){
			return FALSE;
		}
		
		$this->db->select('forget_id');
		$this->db->where('email', $email);
		$this->db->from($this->db->dbprefix('user_forget'));//查
		
		$query=$this->db->get();
		if($query->num_rows() >= 3){
			return FALSE;
		}
		
		return TRUE;
	}
	
	public function delete()
	{
		$this->db->where('date_added < ', date("Y-m-d H:i:s",strtotime("-1 day")));
		$this->db->delete($this->db->dbprefix('user_forget'));
	}
	
	public function add($data)
	{
		$this->db->insert($this->db->dbprefix('user_forget'), $data);
	}
	
	public function check_code($check)
	{
		$this->delete();
		
		if(empty($check)){
			return FALSE;
		}
		
		$this->db->where('check', $check);
		$this->db->from($this->db->dbprefix('user_forget'));//查
		
		$query=$this->db->get();
		if($query->num_rows() > 0){
			return TRUE;
		}
		
		return FALSE;
	}
	
	public function edit_password($data)
	{
		if(empty($data['check'])){
			return FALSE;
		}
		
		$this->db->where('check', $data['check']);
		$this->db->from($this->db->dbprefix('user_forget'));//查
		
		$query=$this->db->get();
		if($query->num_rows() > 0){
			$row=$query->row_array();
			$email=$row['email'];
			
			$password['password']=md5($data['password']);
			$this->db->where('email', $email);
			$this->db->update($this->db->dbprefix('user'), $password);
			
			$this->db->where('email', $email);
			$this->db->delete($this->db->dbprefix('user_forget'));
			
			return TRUE;
		}
		
		return FALSE;
	}
}