<?php
class information_category_model extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	//
	public function get_information_categorys($offset='0')
	{
		//统计表记录
		$information_category_s['count']=$this->db->count_all_results($this->db->dbprefix('information_category'));
		
		$limit=$this->config->get_config('config_limit_admin');
		
		$information_categorys = array();
		//文章基本数据
		$this->db->select('information_category_id, parent_id');
		$this->db->limit($limit, $offset);
		$this->db->order_by('information_category.sort_order', 'ASC');
		
		$query = $this->db->get($this->db->dbprefix('information_category'));
		
		if($query->num_rows() > 0){
			$information_categorys = $query->result_array();
			
			foreach($information_categorys as $k=>$v){
				if($information_categorys[$k]['parent_id'] == '0'){
					$information_category_s['information_categorys'][$k]=$this->get_information_category($information_categorys[$k]['information_category_id']);
					$information_category_s['information_categorys'][$k]['childs']=$this->get_information_category_parent_id($information_categorys[$k]['information_category_id']);
				}
			}
			
			return $information_category_s;
		}else{
			return FALSE;
		}
	}
	
	//查分类
	public function get_information_category_parent_id($parent_id)
	{
		$information_category = array();
		//基本数据
		$this->db->where('ic.parent_id', $parent_id);
		
		$this->db->where('icd.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('information_category_description AS icd', 'icd.information_category_id = ic.information_category_id');//查
		
		$this->db->from($this->db->dbprefix('information_category') . ' AS ic');//查
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			return $query->result_array();
		}
			
		return FALSE;
	}
	
	//store_id=0
	public function get_information_categorys_for_store()
	{
		$this->db->select('information_category_id');
		$this->db->where('store_id', '0');
		$this->db->order_by('information_category.sort_order', 'ASC');
		$this->db->from($this->db->dbprefix('information_category'));//查
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			$information_categorys = $query->result_array();
			$information_categorys = array_flip(array_flip(array_column($information_categorys,'information_category_id')));
			foreach ($information_categorys as $information_category) {
				$information_category_s[] = $this->get_information_category($information_category);
			}
			
			return $information_category_s;
		}else{
			return FALSE;
		}
	}
	
	//只查一级分类
	public function get_information_categorys_form()
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
				}
			}
			
			return $category;
		}
		
		return FALSE;
	}
	
	//查分类
	public function get_information_category($information_category_id)
	{
		$information_category = array();
		//基本数据
		$this->db->select('*');
		$this->db->where('ic.information_category_id', $information_category_id);
		$this->db->from($this->db->dbprefix('information_category') . ' AS ic');//查
		$this->db->where('icd.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('information_category_description AS icd', 'icd.information_category_id = ic.information_category_id');//查
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			return $query->row_array();
		}
			
		return FALSE;
	}
	
	//查分类
	public function get_information_category_info($information_category_id)
	{
		$information_category = array();
		//基本数据
		$this->db->select('*');
		$this->db->where('information_category.information_category_id', $information_category_id);
		$this->db->from($this->db->dbprefix('information_category'));//查
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			$row = $query->row_array();
		}
		if(isset($row)){
			$this->db->select('*');
			$this->db->where('information_category_id',$row['information_category_id']);
			$this->db->from($this->db->dbprefix('information_category_description'));
			$query = $this->db->get();
			
			$information_category_description = $query->result_array();
			//把language_id取出来，做为数组键名
			$arr=array();
			foreach($information_category_description as $k=>$v){
				$arr[$information_category_description[$k]['language_id']]=$v;
			}
			$row['information_category_description'] = $arr;
			
			return $row;
		}
			
		return FALSE;
	}

	public function edit($data){
		$this->db->where('information_category_id', $this->input->get('information_category_id'));
		$this->db->update($this->db->dbprefix('information_category'), $data['base']);
		$this->db->reset_query();
		
		//清描述表
		$this->db->delete($this->db->dbprefix('information_category_description'), array('information_category_id' => $this->input->get('information_category_id')));
		$this->db->reset_query();
		
		//写入描述表
		if(!empty($data['information_category_description'])){
			foreach($data['information_category_description'] as $key=>$value){
				$data['information_category_description'][$key]['information_category_id']=$this->input->get('information_category_id');
				$data['information_category_description'][$key]['language_id']=$key;
			}
			
			$this->db->insert_batch($this->db->dbprefix('information_category_description'), $data['information_category_description']);
			$this->db->reset_query();
		}
	}

	public function add($data){
		$this->db->insert($this->db->dbprefix('information_category'), $data['base']);
		
		//取最后查入的一第分类id
		$information_category_id=$this->db->insert_id();
		
		foreach($data['information_category_description'] as $key=>$value){
			$data['information_category_description'][$key]['language_id']=$key;
			$data['information_category_description'][$key]['information_category_id']=$information_category_id;
		}
		
		$this->db->insert_batch($this->db->dbprefix('information_category_description'), $data['information_category_description']);
	}

	//验证删除
	public function check_delete($data){
		if(empty($data)){
			return FALSE;
		}
		foreach($data as $key=>$value){
			$this->db->select('information_category_id');
			$this->db->where('parent_id', $data[$key]);
			$this->db->from($this->db->dbprefix('information_category'));
			$query=$this->db->get();
			if($query->num_rows > 0){
				//有子分类
				return true;
			}
			
			$this->db->select('information_id');
			$this->db->where('information_category_id', $data[$key]);
			$this->db->from($this->db->dbprefix('information'));
			$query=$this->db->get();
			if($query->num_rows > 0){
				//有文章
				return true;
			}
		}
		
		return false;
	}
	
	//删除分类
	public function delete($data){
		foreach($data as $key=>$value){
			$this->db->delete($this->db->dbprefix('information_category'), array('information_category_id' => $data[$key]));
			$this->db->delete($this->db->dbprefix('information_category_description'), array('information_category_id' => $data[$key]));
		}
	}
}