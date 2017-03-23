<?php
class Category_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	//header导航
	public function get_categorys_to_header()
	{
		//
		$this->db->select('category_id');
		$this->db->where('status','1');
		$this->db->where('parent_id','0');
		$this->db->where('store_id','0');
		$this->db->order_by('category_id', 'RANDOM');
		$this->db->limit(5);
		$this->db->from($this->db->dbprefix('category'));
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			$row = $query->result_array();
			foreach($row as $key=>$value){
				$categorys[$key] = $this->get_category($row[$key]['category_id']);
			}
			return $categorys;
		}
		
		return FALSE;
	}
	
	public function get_category($category_id){
		$this->db->where('category.category_id', $category_id);
		$this->db->where('category_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('category_description', 'category_description.category_id = category.category_id');
		
		$this->db->from($this->db->dbprefix('category'));
		$query=$this->db->get();
		if($query->num_rows() > 0){
			return $query->row_array();
		}
		
		return FALSE;
	}
}