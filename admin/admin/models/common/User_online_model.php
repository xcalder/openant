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
		$this->db->where('date_added > ', date("Y-m-d H:i:s",time()-60));
		$arr['count']=$this->db->count_all_results($this->db->dbprefix('user_online'));
		
		$limit=$this->config->get_config('config_limit_admin');
		$this->db->limit($limit,$data['page']);
		
		$this->db->select('*');
		$this->db->where('date_added > ', date("Y-m-d H:i:s",time()-60));
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
}