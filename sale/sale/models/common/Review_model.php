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
		$this->db->where('product_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->where('product.store_id', $this->user->getStore_id());
		$this->db->join('product', 'product.product_id = product_review.product_id');
		$this->db->join('product_description', 'product_description.product_id = product_review.product_id');
		$row['count']=$this->db->count_all_results($this->db->dbprefix('product_review'));
		
		$limit=$this->config->get_config('config_limit_admin');
		$this->db->limit($limit,$data['page']);
		$this->db->select('product_description.name, product_review.product_id, product_review.review_id, product_review.author, product_review.text, product_review.date_added, product_review.date_modified, product.image');
		$this->db->where('product.store_id', $this->user->getStore_id());
		$this->db->join('product', 'product.product_id = product_review.product_id');
		$this->db->where('product_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('product_description', 'product_description.product_id = product_review.product_id');
		$query=$this->db->get($this->db->dbprefix('product_review'));
		
		$this->db->reset_query();
		
		if($query->num_rows() > 0){
			$row['reviews']=$query->result_array();
			return $row;
		}
		return FALSE;
	}

}