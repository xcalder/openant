<?php
class Category_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	//所有分类
	public function get_categorys_all($page)
	{
		$limit=$this->config->get_config('config_limit_catalog');
		//统计记录条数
		$this->db->select('category_id');
		$this->db->where('status','1');
		$this->db->where('parent_id','0');
		$this->db->where('store_id','0');
		$result['count']=$this->db->count_all_results($this->db->dbprefix('category'));
		
		//
		$this->db->select('category_id');
		$this->db->where('status','1');
		$this->db->where('parent_id','0');
		$this->db->where('store_id','0');
		$this->db->order_by('sort_order', 'ASC');
		$this->db->limit($limit, $page);
		$this->db->from($this->db->dbprefix('category'));
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			$row = $query->result_array();
			foreach($row as $key=>$value){
				$categorys[$key] = $this->get_category($row[$key]['category_id']);
				$categorys[$key]['child']=$this->get_categorys_for_parent_id($row[$key]['category_id']);
			}
			
			$result['categorys']=$categorys;
			return $result;
		}
		
		return FALSE;
	}
	
	//top导航菜单
	public function get_categorys_to_top()
	{
		//
		$this->db->select('category_id');
		$this->db->where('status','1');
		$this->db->where('parent_id','0');
		$this->db->where('top','1');
		$this->db->where('store_id','0');
		$this->db->order_by('sort_order', 'ASC');
		$this->db->from($this->db->dbprefix('category'));
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			$row = $query->result_array();
			foreach($row as $key=>$value){
				$categorys[$key] = $this->get_category($row[$key]['category_id']);
				$categorys[$key]['child']=$this->get_categorys_for_parent_id($row[$key]['category_id']);
			}
			return $categorys;
		}
		
		return FALSE;
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
				//$categorys[$key]['child']=$this->get_categorys_for_parent_id($row[$key]['category_id']);
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
	
	public function get_categorys_for_parent_id($parent_id){
		
		$this->db->where('category.parent_id', $parent_id);
		$this->db->where('category_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('category_description', 'category_description.category_id = category.category_id');
		
		$this->db->from($this->db->dbprefix('category'));
		$query=$this->db->get();
		if($query->num_rows() > 0){
			return $query->result_array();
		}
		
		return FALSE;
	}
	
	public function get_category_to_category($id){
		if(empty($id)){
			return FALSE;
		}
		$ids=explode('_', $id);
		$category=$this->get_category($ids[0]);
		if($category){
			$childs=$this->get_categorys_for_parent_id($ids[0]);
			
			if(isset($ids[1])){
				if(!$this->get_category($ids[1])){
					return FALSE;
				}
				foreach($childs as $key=>$value){
					if($childs[$key]['category_id'] == $ids[1]){
						$childs[$key]['css']='active';
					}
				}
				$category['childs']=$childs;
			}
			
			return $category;
		}
		
		return FALSE;
	}
}