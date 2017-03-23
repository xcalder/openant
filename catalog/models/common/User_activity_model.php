<?php
class User_activity_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	//
	public function add_activity($user_id,$key,$activity=array())
	{
		//查询语言
		$data = array(
			'user_id'					=>$user_id,
			'key'						=>$key,
			'read'						=>0,
			'data'						=>serialize($activity),
			'date_added'				=>date("Y-m-d H:i:s"),
			'ip'						=>$this->input->ip_address(),
		);
		
		$this->db->insert($this->db->dbprefix('user_activity'), $data);
	}
	
	//统计未读消息数量
	public function get_unread_message_count(){
		if($this->user->isLogged()){
			$this->db->where('user_id', $_SESSION['user_id']);
			$this->db->where('read', '0');
			$this->db->from($this->db->dbprefix('user_activity'));
			return $this->db->count_all_results();
		}else{
			return '0';
		}
	}
	
	public function get_notices($data){
		$limit=$this->config->get_config('config_limit_admin');
		
		$this->db->where('user_id', $_SESSION['user_id']);
		$this->db->from($this->db->dbprefix('user_activity'));
		$row['count']=$this->db->count_all_results();
		
		$this->db->where('user_id', $_SESSION['user_id']);
		$this->db->limit($limit, $data['page']);
		$this->db->order_by('read', 'ASC');
		$this->db->order_by('date_added', 'DESC');
		$this->db->from($this->db->dbprefix('user_activity'));
		$query=$this->db->get();
		
		if($query->num_rows() > 0){
			$row['notices']=$query->result_array();
			
			return $row;
		}
		
		return false;
	}
	
	public function o_read($id){
		$this->db->set('read', '1');
		$this->db->where('activity_id', $id);
		return $this->db->update($this->db->dbprefix('user_activity'));
	}
}