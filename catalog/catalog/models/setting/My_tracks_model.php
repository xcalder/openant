<?php
class My_tracks_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function get_tracks($data=array())
	{
		$limit=$this->config->get_config('config_limit_admin');
		
		//统计记录条数
		$this->db->where('user_id', $this->user->getId());
		$result['count']=$this->db->count_all_results($this->db->dbprefix('my_tracks'));
		
		
		$this->db->select('product_id, date_added');
		$this->db->where('user_id', $this->user->getId());
		$this->db->order_by('date_added', 'DESC');
		
		$this->db->limit($limit, $data['page']);
		
		$this->db->from($this->db->dbprefix('my_tracks'));
		$query=$this->db->get();
		
		if($query->num_rows() > 0){
			$result['content']=$query->result_array();
			
			return $result;
		}
		return FALSE;
	}

	public function add_tracks($data){
		$dat="'date_added < ".date("Y-m-d H:i:s",strtotime("-3 month"))."'";
		$this->db->where($dat);
		$this->db->delete($this->db->dbprefix('my_tracks'));
		$this->db->reset_query();
		
		$this->db->select('tracks_id');
		$this->db->where('product_id', $data['product_id']);
		$this->db->where('user_id', $data['user_id']);
		$this->db->where('store_id', $data['store_id']);
		
		$this->db->from($this->db->dbprefix('my_tracks'));
		$query=$this->db->get();
		
		if($query->num_rows() > 0){
			$this->db->where('product_id', $data['product_id']);
			$this->db->where('user_id', $data['user_id']);
			$this->db->where('store_id', $data['store_id']);
			$this->db->update($this->db->dbprefix('my_tracks'), $data);
		}else{
			$this->db->insert($this->db->dbprefix('my_tracks'), $data);
		}
	}
}