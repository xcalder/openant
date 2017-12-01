<?php
class Information_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function get_information($information_id, $store_id = '0')
	{
		$this->db->where('i.information_id', $information_id);
		$this->db->where('i.store_id', $store_id);
		$this->db->where('i.status', '1');
		$this->db->where('id.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('information_description AS id', 'id.information_id = i.information_id');//查
		$this->db->from($this->db->dbprefix('information') . ' AS i');
		
		$query=$this->db->get();
		
		if($query->num_rows() > 0){
			return $query->row_array();
		}
		
		return FALSE;
	}
	
	public function get_informations_to_category_id($category_id, $store_id = '0', $limit='')
	{
		$this->db->select('id.information_id, id.title');
		$this->db->where('i.information_category_id', $category_id);
		$this->db->where('i.store_id', $store_id);
		$this->db->where('i.status', '1');
		$this->db->where('id.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('information_description AS id', 'id.information_id = i.information_id');//查
		
		if(!empty($limit)){
			$this->db->limit($limit);
		}
		
		$this->db->from($this->db->dbprefix('information') . ' AS i');
		
		$query=$this->db->get();
		
		if($query->num_rows() > 0){
			return $query->result_array();
		}
		
		return FALSE;
	}

	//查分类
	public function get_information_category_parent_id($parent_id)
	{
		$information_category = array();
		//基本数据
		$this->db->select('ic.information_category_id, icd.name, ic.column');
		$this->db->where('ic.parent_id', $parent_id);
		$this->db->from($this->db->dbprefix('information_category') . ' AS ic');//查
		$this->db->where('icd.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('information_category_description AS icd', 'icd.information_category_id = ic.information_category_id');//查
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			return $query->result_array();
		}
			
		return FALSE;
	}
	
	//查分类
	public function get_information_category($category_id)
	{
		$information_category = array();
		//基本数据
		$this->db->select('ic.information_category_id, icd.name, ic.column');
		$this->db->where('ic.information_category_id', $category_id);
		$this->db->from($this->db->dbprefix('information_category') . ' AS ic');//查
		$this->db->where('icd.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('information_category_description AS icd', 'icd.information_category_id = ic.information_category_id');//查
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			return $query->row_array();
		}
			
		return FALSE;
	}
	
	//查所有分类
	public function get_information_categorys()
	{
		//基本数据
		$this->db->select('information_category_id, parent_id');
		$this->db->where('store_id', '0');
		$this->db->order_by('information_category.sort_order', 'ASC');
		$this->db->from($this->db->dbprefix('information_category'));//查
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			$information_categorys = $query->result_array();
			foreach($information_categorys as $k=>$v){
				if($information_categorys[$k]['parent_id'] == '0'){
					$category[$k]=$this->get_information_category($information_categorys[$k]['information_category_id']);
					$category[$k]['childs']=$this->get_information_category_parent_id($information_categorys[$k]['information_category_id']);
				}
			}
			
			return $category;
		}
		
		return FALSE;
	}
	
	//查一级分类
	public function get_top_categorys()
	{
		//基本数据
		$this->db->select('information_category_id, parent_id');
		$this->db->where('store_id', '0');
		$this->db->order_by('information_category.sort_order', 'ASC');
		$this->db->from($this->db->dbprefix('information_category'));//查
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			$category=array();
			
			$information_categorys = $query->result_array();
			foreach($information_categorys as $k=>$v){
				if($information_categorys[$k]['parent_id'] == '0'){
					$category[]=$this->get_information_category($information_categorys[$k]['information_category_id']);
					//$category[$k]['childs']=$this->get_information_category($information_categorys[$k]['information_category_id']);
				}
			}
			
			return $category;
		}
		
		return FALSE;
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
			$categorys['informations']=$this->get_informations_to_category_id($category['information_category_id'], '0',5);

			return $categorys;
		}
		
		return FALSE;
	}
}