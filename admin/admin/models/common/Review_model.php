<?php
class Review_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function get_reviews($data=array())
	{
		//统计记录条数
		$row['count']=$this->db->count_all_results($this->db->dbprefix('product_review'));
		
		$limit=$this->config->get_config('config_limit_admin');
		$this->db->limit($limit,$data['page']);
		
		$this->db->select('pd.name, pr.product_id, pr.review_id, pr.status, pr.author, pr.text, pr.date_added, pr.date_modified, p.image');
		$this->db->where('p.store_id', $this->user->getStore_id());
		$this->db->join('product AS p', 'p.product_id = pr.product_id');
		$this->db->where('pd.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('product_description AS pd', 'pd.product_id = pr.product_id');
		$query=$this->db->get($this->db->dbprefix('product_review') . ' AS pr');
		
		$this->db->reset_query();
		
		if($query->num_rows() > 0){
			$row['reviews']=$query->result_array();
			return $row;
		}
		return FALSE;
	}
	
	//删除
	public function del_review($data)
	{
		foreach($data as $key=>$value){
			$this->db->where('review_id', $data[$key]);
			$this->db->delete($this->db->dbprefix('product_review'));
		}
	}
}