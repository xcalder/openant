<?php
class User_reward_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	//添加交易
	public function add_reward($data){
		$data['date_added']=date("Y-m-d H:i:s");
		return $this->db->insert($this->db->dbprefix('user_reward'), $data);
	}
	
	//判断事由
	public function check_event($event, $date_start, $date_end, $user_id){
		//统计记录条数
		$this->db->where('event', $event);
		$this->db->where('date_added < ', $date_end);
		$this->db->where('date_added > ', $date_start);
		return $this->db->count_all_results($this->db->dbprefix('user_reward'));
	}
	
	public function get_user_rewards($data=array())
	{
		if(empty($data['user_id'])){
			return FALSE;
		}
	
		$this->db->where('user_id',$data['user_id']);
		//
		$row['count']   =$this->db->count_all_results($this->db->dbprefix('user_reward'));
	
		$this->db->limit($this->config->get_config('config_limit_admin'), $data['page']);
		$this->db->where('user_id',$data['user_id']);
		$query = $this->db->get($this->db->dbprefix('user_reward'));
	
		if($query->num_rows() > 0){
			$row['user_rewards']=$query->result_array();
			return $row;
		}
		return FALSE;
	}
}