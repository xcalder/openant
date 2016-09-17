<?php
class Language_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	//查所有语言
	public function get_languages()
	{
		//查询语言
		//$this->db->select('language_id,name,code,image');
		$this->db->where('status','1');
		$this->db->order_by('sort_order', 'ASC');
		$this->db->from($this->db->dbprefix('language'));
		$query = $this->db->get(); 
		
		$row = $query->result_array();
		
		return $row;
	}
	
	//用id查语言
	public function get_language($language_id='1')
	{
		$this->db->where('status','1');
		$this->db->where('language_id',$language_id);
		$this->db->from($this->db->dbprefix('language'));
		$query = $this->db->get();
		
		$row = $query->row_array();
		
		return $row;
	}
	
	//用code查语言
	public function get_language_for_code($code)
	{
		$this->db->where('status','1');
		$this->db->where('code',$code);
		$this->db->from($this->db->dbprefix('language'));
		$query = $this->db->get();
		
		$row = $query->row_array();
		
		return $row;
	}
	
	//用locale模糊查语言
	public function get_language_like_locale($locale='')
	{
		if(empty($locale)){
			return FALSE;
		}
		
		$this->db->where('status','1');
		
		$this->db->like('locale', $locale[0]);
		unset($locale[0]);
		
		if(!empty($locale)){
			foreach($locale as $value){
				$this->db->or_like('locale', $value);
			}
		}
		
		$this->db->order_by('sort_order');
		$this->db->from($this->db->dbprefix('language'));
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			return $query->row_array();
		}
		
		return FALSE;
	}
	
	public function get_languages_edit($data){
		//统计记录条数
		$language['count']=$this->db->count_all_results($this->db->dbprefix('language'));
		
		$this->db->limit($this->config->get_config('config_limit_admin'), $data['page']);
		$this->db->select('language_id');
		$this->db->from($this->db->dbprefix('language'));
		$query = $this->db->get(); 
		
		if($query->num_rows() > 0){
			
			$row = $query->result_array();
			foreach($row as $k=>$v){
				$language['languages'][] = $this->get_language_edit($row[$k]['language_id']);
			}
			
			return $language;
		}
		
		return FALSE;
	}
	
	//
	public function get_language_edit($language_id='')
	{
		if(empty($language_id)){
			return FALSE;
		}
		
		$this->db->where('language_id',$language_id);
		$this->db->from($this->db->dbprefix('language'));
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			return $query->row_array();
		}
		
		return FALSE;
	}
	
	//货币设置删除验证
	public function check_delete($data)
	{
		if(empty($data)){
			return FALSE;
		}
		
		$language_id=$this->config->get_config('default_language');
		if(in_array($language_id, $data)){
			return TRUE;
		}
		
		return FALSE;
	}
	
	//删除
	public function delete($data=array()){
		if(empty($data)){
			return FALSE;
		}
		
		foreach($data as $value){
			$this->db->delete($this->db->dbprefix('language'), array('language_id' => $value));
		}
	}
	
	public function add($data){
		$data=array_filter($data);//过滤空元素
		$this->db->insert($this->db->dbprefix('language'), $data);
	}
	
	public function edit($data){
		$data=array_filter($data);//过滤空元素
		$this->db->where('language_id', $this->input->get('language_id'));
		$this->db->update($this->db->dbprefix('language'), $data);
	}
}