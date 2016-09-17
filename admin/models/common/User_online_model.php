<?php
class User_online_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library(array('user_agent'));
	}
	
	public function get_user_onlines($data=array())
	{
		//统计记录条数
		$arr['count']=$this->db->count_all_results($this->db->dbprefix('user_online'));
		
		$limit=$this->config->get_config('config_limit_admin');
		$this->db->limit($limit,$data['page']);
		
		$this->db->select('*');
		//$this->db->from($this->db->dbprefix('user_online'));
		$query=$this->db->get($this->db->dbprefix('user_online'));
		
		if($query->num_rows() > 0){
			$row=$query->result_array();
			foreach($row as $key=>$value){
				if($row[$key]['user_id'] != '0'){
					$this->db->select('nickname');
					$this->db->where('user_id=',$row[$key]['user_id']);
					$this->db->from($this->db->dbprefix('user'));
					$query=$this->db->get();
					$row[$key]['nickname']=$query->row_array()['nickname'];
				}
			}
			
			$arr['user_onlines']=$row;
			return $arr;
		}
		return FALSE;
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