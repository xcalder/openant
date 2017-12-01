<?php
class User_online_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	//添加在线会员
	public function add_user_online()
	{
		$data['ip']=$this->input->ip_address();
		$data['token']=$_SESSION['token'];
		if($this->user->isLogged()){
			$data['user_id']=$this->user->getId();
		}else{
			$data['user_id']='';
		}
		
		$data['date_added']=date('Y-m-d H:i:s', time());
		
		$this->db->replace($this->db->dbprefix('user_online'), $data);
	}
}