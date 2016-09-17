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
}