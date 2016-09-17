<?php
class User_activity_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	//查所有语言
	public function add_activity($user_id,$key,$activity=array())
	{
		//查询语言
		$data = array(
			'user_id'					=>$user_id,
			'key'						=>$key,
			'data'						=>json_encode($activity),
			'date_added'				=>date("Y-m-d H:i:s"),
			'ip'						=>$this->input->ip_address(),
		);
		
		$this->db->insert($this->db->dbprefix('user_activity'), $data);
	}
}