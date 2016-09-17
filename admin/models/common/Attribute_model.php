<?php
class Attribute_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	//取属性列表
	public function get_attributes($data)
	{
		//统计记录条数
		$attributes['count']   =$this->db->count_all_results($this->db->dbprefix('attribute'));
		
		$this->db->limit($this->config->get_config('config_limit_admin'), $data['attribute_page']);
		$this->db->select('attribute_id');
		//$this->db->from($this->db->dbprefix('attribute'));
		
		$query=$this->db->get($this->db->dbprefix('attribute'));
		
		if($query->num_rows() > 0){
			foreach($query->result_array() as $value){
				$attributes['attributes'][]=$this->get_attribute_for_language($value['attribute_id']);
			}
			
			return $attributes;
		}
		return FALSE;
	}
	
	//取属性
	public function get_attribute_for_language($attribute_id)
	{
		$this->db->where('attribute.attribute_id', $attribute_id);
		$this->db->where('attribute_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('attribute_description','attribute_description.attribute_id = attribute.attribute_id');
		$this->db->where('attribute_group_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('attribute_group_description','attribute_group_description.attribute_group_id = attribute.attribute_group_id');
		$this->db->from($this->db->dbprefix('attribute'));
		
		$query=$this->db->get();
		
		if($query->num_rows() > 0){
			return $query->row_array();
		}
		
		return FALSE;
	}
	
	//取组
	public function get_attribute_groups($data=array()){
		
		//统计记录条数
		$row['count']   =$this->db->count_all_results($this->db->dbprefix('attribute_group'));
		
		if(isset($data['attribute_group_page'])){
			$this->db->limit($this->config->get_config('config_limit_admin'), $data['attribute_group_page']);
		}
		
		$this->db->select("attribute_group_id");
		//$this->db->from($this->db->dbprefix('attribute_group'));
		$query=$this->db->get($this->db->dbprefix('attribute_group'));
		
		if($query->num_rows() > 0){
			$re=$query->result_array();
			foreach($re as $key=>$value){
				$row['attribute_groups'][]=$this->get_attribute_group($re[$key]['attribute_group_id']);
			}
			
			return $row;
		}
		return FALSE;
	}
	
	//取组给分类用
	public function get_attribute_groups_to_category(){
		$this->db->select("attribute_group_id");
		$query=$this->db->get($this->db->dbprefix('attribute_group'));
		
		if($query->num_rows() > 0){
			$re=$query->result_array();
			foreach($re as $key=>$value){
				$row[]=$this->get_attribute_group($re[$key]['attribute_group_id']);
			}
			
			return $row;
		}
		return FALSE;
	}
	
	//取组的单条
	public function get_attribute_group($attribute_group_id){
		$this->db->where('attribute_group.attribute_group_id',$attribute_group_id);
		$this->db->where('attribute_group_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('attribute_group_description','attribute_group_description.attribute_group_id = attribute_group.attribute_group_id');
		
		$this->db->from($this->db->dbprefix('attribute_group'));
		
		$query=$this->db->get();
		if($query->num_rows() > 0){
			return $query->row_array();
		}
		
		return FALSE;
	}
	
	//删除属性
	public function delete_attribute($data)
	{
		foreach($data as $key=>$value){
			$this->db->delete($this->db->dbprefix('attribute'), array('attribute_id' => $data[$key]));
			$this->db->delete($this->db->dbprefix('attribute_description'), array('attribute_id' => $data[$key]));
		}
	}
	
	//删除属性组
	public function delete_attribute_group($data)
	{
		foreach($data as $key=>$value){
			$this->db->delete($this->db->dbprefix('attribute_group'), array('attribute_group_id' => $data[$key]));
			$this->db->delete($this->db->dbprefix('attribute_group_description'), array('attribute_group_id' => $data[$key]));
		}
	}
	
	//验证属性是否被商品使用
	public function get_product_attribute_for_attribute_id($attribute_id){
		$this->db->where('attribute_id',$attribute_id);
		$this->db->from($this->db->dbprefix('product_attribute'));
		
		$query=$this->db->get();
		if($query->num_rows() > 0){
			return $query->result_array();
		}
		return FALSE;
	}
	
	//验证属性组是否被商品使用
	public function get_attribute_for_attribute_group_id($attribute_group_id){
		$this->db->where('attribute_group_id',$attribute_group_id);
		$this->db->from($this->db->dbprefix('attribute'));
		
		$query=$this->db->get();
		if($query->num_rows() > 0){
			return $query->result_array();
		}
		return FALSE;
	}
	
	//取单条属性为二维数组
	public function get_attribute_arr($attribute_id){
		$row['description']=FALSE;
		
		$this->db->where('attribute_id',$attribute_id);
		$this->db->from($this->db->dbprefix('attribute'));
		$query=$this->db->get();
		if($query->num_rows() > 0){
			$row=$query->row_array();
			
			//取描述
			$this->db->where('attribute_id',$attribute_id);
			$this->db->from($this->db->dbprefix('attribute_description'));
			$query=$this->db->get();
			
			if($query->num_rows() > 0){
				$description=array();
				$de=$query->result_array();
				foreach($de as $key=>$value){
					$description[$de[$key]['language_id']]=$value;
				}
				$row['description']=$description;
			}
			
			return $row;
		}
		return FALSE;
	}
	
	//取单条属性组为二维数组
	public function get_attribute_group_arr($attribute_group_id){
		$row['description']=FALSE;
		
		$this->db->where('attribute_group_id',$attribute_group_id);
		$this->db->from($this->db->dbprefix('attribute_group'));
		$query=$this->db->get();
		if($query->num_rows() > 0){
			$row=$query->row_array();
			
			//取描述
			$this->db->where('attribute_group_id',$attribute_group_id);
			$this->db->from($this->db->dbprefix('attribute_group_description'));
			$query=$this->db->get();
			
			if($query->num_rows() > 0){
				$description=array();
				$de=$query->result_array();
				foreach($de as $key=>$value){
					$description[$de[$key]['language_id']]=$value;
				}
				$row['description']=$description;
			}
			
			return $row;
		}
		return FALSE;
	}
	
	//修改属性
	public function edit_attribute($data){
		//更新attribute表
		$this->db->where('attribute_id', $data['attribute_id']);
		$this->db->update($this->db->dbprefix('attribute'), $data['base']);
		
		$this->db->delete($this->db->dbprefix('attribute_description'), array('attribute_id' => $data['attribute_id']));
		
		//更新descript表
		foreach($data['description'] as $key=>$value){
			$data['description'][$key]['language_id']=$key;
			$data['description'][$key]['attribute_id']=$data['attribute_id'];
		}
		$this->db->insert_batch($this->db->dbprefix('attribute_description'), $data['description']);
	}
	
	//修改属性组
	public function edit_attribute_group($data){
		//更新attribute表
		$this->db->where('attribute_group_id', $data['attribute_group_id']);
		$this->db->update($this->db->dbprefix('attribute_group'), $data['group_base']);
		
		$this->db->delete($this->db->dbprefix('attribute_group_description'), array('attribute_group_id' => $data['attribute_group_id']));
		
		//更新descript表
		foreach($data['group_description'] as $key=>$value){
			$data['group_description'][$key]['language_id']=$key;
			$data['group_description'][$key]['attribute_group_id']=$data['attribute_group_id'];
		}
		
		$this->db->insert_batch($this->db->dbprefix('attribute_group_description'), $data['group_description']);
	}
	
	//添加属性
	public function add_attribute($data){
		//写入attribute表
		$this->db->insert($this->db->dbprefix('attribute'), $data['base']);
		
		//写入descript表
		//取最后查入的一第分类id
		$attribute_id=$this->db->insert_id();
		
		foreach($data['description'] as $key=>$value){
			$data['description'][$key]['language_id']=$key;
			$data['description'][$key]['attribute_id']=$attribute_id;
		}
		$this->db->insert_batch($this->db->dbprefix('attribute_description'), $data['description']);
	}
	
	//添加属性组
	public function add_attribute_group($data){
		//写入attribute表
		$this->db->insert($this->db->dbprefix('attribute_group'), $data['group_base']);
		
		//写入descript表
		//取最后查入的一第分类id
		$attribute_group_id=$this->db->insert_id();
		
		foreach($data['group_description'] as $key=>$value){
			$data['group_description'][$key]['language_id']=$key;
			$data['group_description'][$key]['attribute_group_id']=$attribute_group_id;
		}
		$this->db->insert_batch($this->db->dbprefix('attribute_group_description'), $data['group_description']);
	}
}