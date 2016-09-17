<?php
class Option_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	//取属性列表
	public function get_options($data)
	{
		//统计记录条数
		$options['count']   =$this->db->count_all_results($this->db->dbprefix('option'));
		
		$this->db->limit($this->config->get_config('config_limit_admin'), $data['option_page']);
		$this->db->select('option_id');
		$this->db->from($this->db->dbprefix('option'));
		
		$query=$this->db->get();
		
		if($query->num_rows() > 0){
			foreach($query->result_array() as $value){
				$options['options'][]=$this->get_option_for_language($value['option_id']);
			}
			
			return $options;
		}
		return FALSE;
	}
	
	//取属性
	public function get_option_for_language($option_id)
	{
		$this->db->where('option.option_id', $option_id);
		$this->db->where('option_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('option_description','option_description.option_id = option.option_id');
		$this->db->where('option_group_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('option_group_description','option_group_description.option_group_id = option.option_group_id');
		$this->db->from($this->db->dbprefix('option'));
		
		$query=$this->db->get();
		
		if($query->num_rows() > 0){
			return $query->row_array();
		}
		
		return FALSE;
	}
	
	//取组
	public function get_option_groups($data=array()){
		//统计记录条数
		$row['count']   =$this->db->count_all_results($this->db->dbprefix('option_group'));
		
		if(isset($data['option_group_page'])){
			$this->db->limit($this->config->get_config('config_limit_admin'), $data['option_group_page']);
		}
		
		$this->db->select("option_group_id");
		$this->db->from($this->db->dbprefix('option_group'));
		$query=$this->db->get();
		
		if($query->num_rows() > 0){
			$re=$query->result_array();
			foreach($re as $key=>$value){
				$row['option_groups'][]=$this->get_option_group($re[$key]['option_group_id']);
			}
			
			return $row;
		}
		return FALSE;
	}
	
	//取组给分类用
	public function get_option_groups_to_category(){
		$this->db->select("option_group_id");
		$this->db->from($this->db->dbprefix('option_group'));
		$query=$this->db->get();
		
		if($query->num_rows() > 0){
			$re=$query->result_array();
			foreach($re as $key=>$value){
				$row[]=$this->get_option_group($re[$key]['option_group_id']);
			}
			
			return $row;
		}
		return FALSE;
	}
	
	//取组的单条
	public function get_option_group($option_group_id){
		$this->db->where('option_group.option_group_id',$option_group_id);
		$this->db->where('option_group_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('option_group_description','option_group_description.option_group_id = option_group.option_group_id');
		
		$this->db->from($this->db->dbprefix('option_group'));
		
		$query=$this->db->get();
		if($query->num_rows() > 0){
			return $query->row_array();
		}
		
		return FALSE;
	}
	
	//删除属性
	public function delete_option($data)
	{
		foreach($data as $key=>$value){
			$this->db->delete($this->db->dbprefix('option'), array('option_id' => $data[$key]));
			$this->db->delete($this->db->dbprefix('option_description'), array('option_id' => $data[$key]));
		}
	}
	
	//删除属性组
	public function delete_option_group($data)
	{
		foreach($data as $key=>$value){
			$this->db->delete($this->db->dbprefix('option_group'), array('option_group_id' => $data[$key]));
			$this->db->delete($this->db->dbprefix('option_group_description'), array('option_group_id' => $data[$key]));
		}
	}
	
	//验证属性是否被商品使用
	public function get_product_option_for_option_id($option_id){
		$this->db->where('option_id',$option_id);
		$this->db->from($this->db->dbprefix('product_option_value'));
		
		$query=$this->db->get();
		if($query->num_rows() > 0){
			return $query->result_array();
		}
		return FALSE;
	}
	
	//验证属性组是否被商品使用
	public function get_option_for_option_group_id($option_group_id){
		$this->db->where('option_group_id',$option_group_id);
		$this->db->from($this->db->dbprefix('option'));
		
		$query=$this->db->get();
		if($query->num_rows() > 0){
			return $query->result_array();
		}
		return FALSE;
	}
	
	//取单条属性为二维数组
	public function get_option_arr($option_id){
		$row['description']=FALSE;
		
		$this->db->where('option_id',$option_id);
		$this->db->from($this->db->dbprefix('option'));
		$query=$this->db->get();
		if($query->num_rows() > 0){
			$row=$query->row_array();
			
			//取描述
			$this->db->where('option_id',$option_id);
			$this->db->from($this->db->dbprefix('option_description'));
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
	public function get_option_group_arr($option_group_id){
		$row['description']=FALSE;
		
		$this->db->where('option_group_id',$option_group_id);
		$this->db->from($this->db->dbprefix('option_group'));
		$query=$this->db->get();
		if($query->num_rows() > 0){
			$row=$query->row_array();
			
			//取描述
			$this->db->where('option_group_id',$option_group_id);
			$this->db->from($this->db->dbprefix('option_group_description'));
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
	public function edit_option($data){
		//更新option表
		$this->db->where('option_id', $data['option_id']);
		$this->db->update($this->db->dbprefix('option'), $data['base']);
		
		$this->db->delete($this->db->dbprefix('option_description'), array('option_id' => $data['option_id']));
		//更新descript表
		foreach($data['description'] as $key=>$value){
			$data['description'][$key]['language_id']=$key;
			$data['description'][$key]['option_id']=$data['option_id'];
		}
		$this->db->insert_batch($this->db->dbprefix('option_description'), $data['description']);
		$this->db->reset_query();
	}
	
	//修改属性组
	public function edit_option_group($data){
		//更新option表
		$this->db->where('option_group_id', $data['option_group_id']);
		$this->db->update($this->db->dbprefix('option_group'), $data['group_base']);
		
		$this->db->delete($this->db->dbprefix('option_group_description'), array('option_group_id' => $data['option_group_id']));
		//更新descript表
		foreach($data['group_description'] as $key=>$value){
			$data['group_description'][$key]['language_id']=$key;
			$data['group_description'][$key]['option_group_id']=$data['option_group_id'];
		}
		$this->db->insert_batch($this->db->dbprefix('option_group_description'), $data['group_description']);
		$this->db->reset_query();
	}
	
	//添加属性
	public function add_option($data){
		//写入option表
		$this->db->insert($this->db->dbprefix('option'), $data['base']);
		
		//写入descript表
		//取最后查入的一第分类id
		$this->db->select('option_id');
		$this->db->order_by('option_id','DESC');
		$this->db->limit(0,1);
		$this->db->from($this->db->dbprefix('option'));
		$query=$this->db->get();
		$option_id=$query->row_array()['option_id'];
		
		foreach($data['description'] as $key=>$value){
			$data['description'][$key]['language_id']=$key;
			$data['description'][$key]['option_id']=$option_id;
		}
		$this->db->insert_batch($this->db->dbprefix('option_description'), $data['description']);
		$this->db->reset_query();
	}
	
	//添加属性组
	public function add_option_group($data){
		//写入option表
		$this->db->insert($this->db->dbprefix('option_group'), $data['group_base']);
		
		//写入descript表
		//取最后查入的一第分类id
		$this->db->select('option_group_id');
		$this->db->order_by('option_group_id','DESC');
		$this->db->limit(0,1);
		$this->db->from($this->db->dbprefix('option_group'));
		$query=$this->db->get();
		$option_group_id=$query->row_array()['option_group_id'];
		
		foreach($data['group_description'] as $key=>$value){
			$data['group_description'][$key]['language_id']=$key;
			$data['group_description'][$key]['option_group_id']=$option_group_id;
		}
		$this->db->insert_batch($this->db->dbprefix('option_group_description'), $data['group_description']);
		$this->db->reset_query();
	}
}