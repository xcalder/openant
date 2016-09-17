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
		//
		$data = array(
			'user_id'					=>$user_id,
			'key'						=>$key,
			'data'						=>json_encode($activity),
			'date_added'				=>date("Y-m-d H:i:s"),
			'ip'						=>$this->input->ip_address(),
		);
		
		$this->db->insert($this->db->dbprefix('user_activity'), $data);
	}
	
	public function get_user_activetys($data=array())
	{
		//统计记录条数
		$row['count']=$this->db->count_all_results($this->db->dbprefix('user_activity'));
		
		$limit=$this->config->get_config('config_limit_admin');
		$this->db->limit($limit,$data['page']);
		$query=$this->db->get($this->db->dbprefix('user_activity'));
		
		$this->db->reset_query();
		
		if($query->num_rows() > 0){
			$row['user_activitys']=$query->result_array();
			return $row;
		}
		
		return FALSE;
	}
}