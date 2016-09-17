<?php
class Tax_class_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	//
	public function get_tax_classs_for_langugae_id($data)
	{
		//
		$this->db->limit($this->config->get_config('config_limit_admin'), $data['page']);
		$this->db->select('tax_class_id');
		//$this->db->from($this->db->dbprefix('tax_class'));
		$query = $this->db->get($this->db->dbprefix('tax_class')); 
		
		//统计记录条数
		$tax_classs['count']=$this->db->count_all_results($this->db->dbprefix('tax_class'));
		
		if($query->num_rows() > 0){
			$row = $query->result_array();
			foreach($row as $value){
				$tax_classs['tax_classs'][] = $this->get_tax_class($value['tax_class_id']);
			}
			return $tax_classs;
		}
		
		return FALSE;
	}
	
	//给分类用
	public function get_tax_classs_to_category()
	{
		$this->db->select('tax_class_id');
		$query = $this->db->get($this->db->dbprefix('tax_class')); 
		if($query->num_rows() > 0){
			$row = $query->result_array();
			foreach($row as $value){
				$tax_classs[] = $this->get_tax_class($value['tax_class_id']);
			}
			return $tax_classs;
		}
		
		return FALSE;
	}
	
	//
	public function get_tax_class($tax_class_id='')
	{
		if(empty($tax_class_id)){
			return FALSE;
		}
		
		$this->db->where('tax_class.tax_class_id',$tax_class_id);
		$this->db->where('tax_class_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('tax_class_description', 'tax_class_description.tax_class_id = tax_class.tax_class_id');
		
		$this->db->from($this->db->dbprefix('tax_class'));
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			return $query->row_array();
		}
		
		return FALSE;
	}
	
	//
	public function get_tax_class_form($tax_class_id='')
	{
		if(empty($tax_class_id)){
			return FALSE;
		}
		
		$this->db->where('tax_class_id',$tax_class_id);
		$this->db->from($this->db->dbprefix('tax_class'));
		$query = $this->db->get();
		if($query->num_rows() > 0){
			$row=$query->row_array();
			$tax_class=$row;
			
			//查描述
			$this->db->where('tax_class_id', $row['tax_class_id']);
			$this->db->from($this->db->dbprefix('tax_class_description'));
			$query=$this->db->get();
			
			$description=array();
			$descriptions=$query->result_array();
			foreach($descriptions as $key=>$value){
				$description[$descriptions[$key]['language_id']]=$value;
			}
			$tax_class['description']=$description;
			
			$tax_class['tax_rule']=$this->get_tax_rule($tax_class_id);
			
			return $tax_class;
		}
		
		return FALSE;
	}
	
	public function get_tax_rule($tax_class_id){
		$this->db->where('tax_rule.tax_class_id', $tax_class_id);
		$this->db->where('tax_class_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->where('tax_rate_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		
		$this->db->join('tax_rate_description','tax_rate_description.tax_rate_id = tax_rule.tax_rate_id');
		$this->db->join('tax_class_description','tax_class_description.tax_class_id = tax_rule.tax_class_id');
		$this->db->from($this->db->dbprefix('tax_rule'));
		$query=$this->db->get();
		
		if($query->num_rows() > 0){
			return $query->result_array();
		}
		
		return FALSE;
	}
	
	public function edit($data)
	{
		foreach($data['description'] as $key=>$value){
			//组织数组
			$data['description'][$key]['language_id']=$key;
			$data['description'][$key]['tax_class_id']=$this->input->get('tax_class_id');
			
			$this->db->where('tax_class_id', $this->input->get('tax_class_id'));
			$this->db->where('language_id', $key);
			$this->db->update($this->db->dbprefix('tax_class_description'), $data['description'][$key]);
			$this->db->reset_query();
		}
		
		$this->db->set('date_modified', date("Y-m-d H:i:s"));
		$this->db->where('tax_class_id', $this->input->get('tax_class_id'));
		$this->db->update($this->db->dbprefix('tax_class'));
		$this->db->reset_query();
		
		//先删tax_rule
		$this->db->delete($this->db->dbprefix('tax_rule'), array('tax_class_id' => $this->input->get('tax_class_id')));
		//再插入
		foreach($data['tax_rule'] as $key=>$value){
			$data['tax_rule'][$key]['tax_class_id']=$this->input->get('tax_class_id');
		}
		$this->db->insert_batch($this->db->dbprefix('tax_rule'), $data['tax_rule']);
		
	}
	
	public function add($data)
	{
		$insert_data['date_added']=date("Y-m-d H:i:s");
		$insert_data['date_modified']=date("Y-m-d H:i:s");
		$this->db->insert($this->db->dbprefix('tax_class'), $insert_data);
		
		//取最后查入的一第分类id
		$tax_class_id=$this->db->insert_id();
		
		foreach($data['description'] as $key=>$value){
			//组织数组
			$data['description'][$key]['tax_class_id']=$tax_class_id;
			$data['description'][$key]['language_id']=$key;
		}
		$this->db->insert_batch($this->db->dbprefix('tax_class_description'), $data['description']);
		$this->db->reset_query();
		
		//插入
		foreach($data['tax_rule'] as $key=>$value){
			$data['tax_rule'][$key]['tax_class_id']=$tax_class_id;
		}
		$this->db->insert_batch($this->db->dbprefix('tax_rule'), $data['tax_rule']);
		$this->db->reset_query();
	}
	
	public function check_delete_tax_class($data){
		if(empty($data)){
			return FALSE;
		}
		foreach($data as $key=>$value){
			$this->db->select('product_id');
			$this->db->where('tax_class_id', $data[$key]);
			$this->db->from($this->db->dbprefix('product'));
			$query=$this->db->get();
			
			if($query->num_rows() > 0){
				return TRUE;
			}
		}
		
		return FALSE;
	}
	
	public function delete_tax_class($data){
		foreach($data as $key=>$value){
			$this->db->delete($this->db->dbprefix('tax_class'), array('tax_class_id' => $data[$key]));
			$this->db->delete($this->db->dbprefix('tax_class_description'), array('tax_class_id' => $data[$key]));
			$this->db->delete($this->db->dbprefix('tax_rule'), array('tax_class_id' => $data[$key]));
		}
	}
}