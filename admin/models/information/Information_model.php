<?php
class Information_model extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	//
	public function get_informations($offset='0')
	{
		//统计表记录
		$information_s['count']=$this->db->count_all_results($this->db->dbprefix('information'));
		
		$limit=$this->config->get_config('config_limit_admin');
		
		$informations = array();
		//文章基本数据
		$this->db->select('information_id');
		$this->db->limit($limit, $offset);
		$this->db->order_by('information.sort_order', 'ASC');
		//$this->db->from($this->db->dbprefix('information'));//查
		
		$query = $this->db->get($this->db->dbprefix('information'));
		
		if($query->num_rows() > 0){
			$informations = $query->result_array();
			$informations = array_flip(array_flip(array_column($informations,'information_id')));
			foreach ($informations as $information) {
				$information_s['informations'][] = $this->get_information($information);
			}
			
			return $information_s;
		}else{
			return FALSE;
		}
	}
	
	//查文章
	public function get_information($information_id)
	{
		$information = array();
		//基本数据
		$this->db->select('*');
		$this->db->where('information.information_id', $information_id);
		$this->db->from($this->db->dbprefix('information'));//查
		$this->db->where('information_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('information_description', 'information_description.information_id = information.information_id');//查
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			return $query->row_array();
		}
			
		return FALSE;
	}
	
	//查文章
	public function get_information_info($information_id)
	{
		$information = array();
		//基本数据
		$this->db->select('*');
		$this->db->where('information.information_id', $information_id);
		$this->db->from($this->db->dbprefix('information'));//查
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			$row = $query->row_array();
		}
		if(isset($row)){
			$this->db->select('*');
			$this->db->where('information_id',$row['information_id']);
			$this->db->from($this->db->dbprefix('information_description'));
			$query = $this->db->get();
			
			$information_description = $query->result_array();
			//把language_id取出来，做为数组键名
			$arr=array();
			foreach($information_description as $k=>$v){
				$arr[$information_description[$k]['language_id']]=$v;
			}
			$row['information_description'] = $arr;
			
			return $row;
		}
			
		return FALSE;
	}

	public function edit($data)
	{
		$data['base']['date_modified']=date("Y-m-d H:i:s");
		$this->db->where('information_id', $this->input->get('information_id'));
		$this->db->update($this->db->dbprefix('information'), $data['base']);
		$this->db->reset_query();
		
		//清描述表
		$this->db->delete($this->db->dbprefix('information_description'), array('information_id' => $this->input->get('information_id')));
		$this->db->reset_query();
		
		//写入描述表
		if(!empty($data['information_description'])){
			foreach($data['information_description'] as $key=>$value){
				$data['information_description'][$key]['information_id']=$this->input->get('information_id');
				$data['information_description'][$key]['language_id']=$key;
			}
			
			$this->db->insert_batch($this->db->dbprefix('information_description'), $data['information_description']);
			$this->db->reset_query();
		}
	}

	public function add($data)
	{
		$data['base']['date_modified']=date("Y-m-d H:i:s");
		$data['base']['date_added']=date("Y-m-d H:i:s");
		$this->db->insert($this->db->dbprefix('information'), $data['base']);
		
		//取最后查入的一第文章id
		$information_id=$this->db->insert_id();
		
		foreach($data['information_description'] as $key=>$value){
			$data['information_description'][$key]['language_id']=$key;
			$data['information_description'][$key]['information_id']=$information_id;
		}
		
		$this->db->insert_batch($this->db->dbprefix('information_description'), $data['information_description']);
		$this->db->reset_query();
	}

	//验证删除
	public function check_delete($data){
		if(empty($data)){
			return FALSE;
		}
		foreach($data as $key=>$value){
			if($value == $this->config->get_config('registration_terms')){
				return TRUE;
			}
			if($value == $this->config->get_config('sale_terms')){
				return TRUE;
			}
		}
		
		return FALSE;
	}
	
	//删除文章
	public function delete($data){
		foreach($data as $key=>$value){
			$this->db->delete($this->db->dbprefix('information'), array('information_id' => $data[$key]));
			$this->db->delete($this->db->dbprefix('information_description'), array('information_id' => $data[$key]));
		}
	}
	
	//取管理员的文章
	public function get_informations_where_store()
	{
		$this->db->select('information_id');
		$this->db->where('store_id', '0');
		$this->db->order_by('sort_order', 'ASC');
		$this->db->from($this->db->dbprefix('information'));
		$query=$this->db->get();
		
		if($query->num_rows() > 0){
			$arr=$query->result_array();
			$arr=array_flip(array_flip(array_column($arr,'information_id')));
			foreach($arr as $inforamtion_id){
				$row[]=$this->get_information($inforamtion_id);
			}
			return $row;
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
		$this->db->order_by('information_category.sort_order', 'DESC');
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