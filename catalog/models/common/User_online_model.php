<?php
class User_online_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library(array('user_agent'));
	}
	
	//添加在线会员
	public function add_user_online()
	{
		if(!$this->agent->is_robot()){
			
			$data['ip']=$this->input->ip_address();
			
			if($this->user->isLogged()){
				$data['user_id']=$this->user->getId();
			}else{
				$data['user_id']='';
			}
			
			$data['url']=current_url();
			$data['referer']=$this->agent->referrer();
			$data['date_added']=date('Y-m-d H:i:s', time());
			
			$this->db->where('token', $_SESSION['token']);
			$this->db->update($this->db->dbprefix('user_online'), $data);
		}
	}
	
	//删除在线会员
	public function del_user_online()
	{
		$this->db->where('date_added < ', date("Y-m-d H:i:s",time()-1800));
		$this->db->delete($this->db->dbprefix('user_online'));
	}
}