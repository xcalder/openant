<?php
class Information_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	//查分类给position用
	public function get_category_to_position($position)
	{
		//基本数据
		$this->db->select('information_category_id');
		$this->db->where('store_id', '0');
		$this->db->where('position', $position);
		$this->db->order_by('information_category.sort_order', 'ASC');
		$this->db->from($this->db->dbprefix('information_category'));//查
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			$categorys=array();
			
			$category = $query->row_array();
			$categorys = $this->get_information_category($category['information_category_id']);
			$categorys['informations']=$this->get_informations_to_category_id($category['information_category_id'], '0', 5);

			return $categorys;
		}
		
		return FALSE;
	}
	
	//查分类
	public function get_information_category($category_id)
	{
		$information_category = array();
		//基本数据
		$this->db->select('information_category.information_category_id, information_category_description.name, information_category.column');
		$this->db->where('information_category.information_category_id', $category_id);
		$this->db->from($this->db->dbprefix('information_category'));//查
		$this->db->where('information_category_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('information_category_description', 'information_category_description.information_category_id = information_category.information_category_id');//查
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			return $query->row_array();
		}
			
		return FALSE;
	}
	
	public function get_informations_to_category_id($category_id, $store_id = '0', $limit='')
	{
		$this->db->select('information_description.information_id, information_description.title');
		$this->db->where('information.information_category_id', $category_id);
		$this->db->where('information.store_id', $store_id);
		$this->db->where('information.status', '1');
		$this->db->where('information_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('information_description', 'information_description.information_id = information.information_id');//查
		
		if(!empty($limit)){
			$this->db->limit($limit);
		}
		
		$this->db->from($this->db->dbprefix('information'));
		
		$query=$this->db->get();
		
		if($query->num_rows() > 0){
			return $query->result_array();
		}
		
		return FALSE;
	}
}