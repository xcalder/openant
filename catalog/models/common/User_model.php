<?php
class User_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	//查所有语言
	public function add_user($data)
	{
		//查询语言
		$user = array(
			'user_group_id'				=>$this->config->get_config('register_group') != null ? $this->config->get_config('register_group') : '1',
			'nickname'					=>$data['nickname'],
			'email'						=>$data['email'],
			'password'					=>md5($data['password']),
			'status'					=>'1',
			'date_added'				=>date("Y-m-d H:i:s"),
			'ip'						=>$this->input->ip_address(),
			'user_class_id'				=>$data['user_class_id'],
		);
		
		$this->db->insert($this->db->dbprefix('user'), $user);
		
		$this->load->model('common/user_activity_model');
		
		//查user_id
		$user_id=$this->db->insert_id();
		
		$this->user_activity_model->add_activity($user_id,'register',array('title'=>sprintf(lang_line('success_register'), $data['nickname']), 'msg'=>''));
	}
	
	public function get_user_for_email($email)
	{
		if(empty($email)){
			return FALSE;
		}
		
		$this->db->where('email',$email);
		$this->db->where('status','1');
		$this->db->from($this->db->dbprefix('user'));
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			return $query->row_array();
		}
		
		return FALSE;
	}
	
	public function check_login_times($ip,$email)
	{
		if(empty($ip) || empty($email)){
			return FALSE;
		}
		
		$this->db->where('date_modified < ', date("Y-m-d H:i:s",strtotime("- 30min")));
		$this->db->delete($this->db->dbprefix('user_login'));
		$this->db->reset_query();
		
		$this->db->select('total');
		$this->db->where('ip', $ip);
		$this->db->where('email', $email);
		$this->db->from($this->db->dbprefix('user_login'));
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			if($query->row_array()['total'] > 4){
				return FALSE;
			}else{
				return TRUE;
			}
		}
		
		return TRUE;
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
	
	public function edit_user($data)
	{
		return $this->db->update($this->db->dbprefix('user'), $data, 'user_id = '.$data['user_id']);
	}
}