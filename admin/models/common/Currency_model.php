<?php
class Currency_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	//查所有语言
	public function get_currencys()
	{
		//查询语言
		$this->db->where('status','1');
		$this->db->order_by('currency_id', 'ASC');
		$this->db->from($this->db->dbprefix('currency'));
		$query = $this->db->get(); 
		
		$row = $query->result_array();
		
		return $row;
	}
	
	//用id查语言
	public function get_currency($currency_id='1')
	{
		$this->db->where('status','1');
		$this->db->where('currency_id',$currency_id);
		$this->db->from($this->db->dbprefix('currency'));
		$query = $this->db->get();
		
		$row = $query->row_array();
		
		return $row;
	}
	
	
	public function get_currencys_edit($data=array())
	{
		//
		//统计记录条数
		$currency['count']=$this->db->count_all_results($this->db->dbprefix('currency'));
		
		$this->db->limit($this->config->get_config('config_limit_admin'), $data['page']);
		$this->db->select('currency_id');
		$this->db->from($this->db->dbprefix('currency'));
		$query = $this->db->get(); 
		
		if($query->num_rows() > 0){
			
			$row = $query->result_array();
			foreach($row as $k=>$v){
				$currency['currencys'][] = $this->get_currency_edit($row[$k]['currency_id']);
			}
			
			return $currency;
		}
		
		return FALSE;
	}
	
	//
	public function get_currency_edit($currency_id='')
	{
		if(empty($currency_id)){
			return FALSE;
		}
		
		$this->db->where('currency_id',$currency_id);
		$this->db->from($this->db->dbprefix('currency'));
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
		
		$currency_id=$this->config->get_config('default_currency');
		if(in_array($currency_id, $data)){
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
			$this->db->delete($this->db->dbprefix('currency'), array('currency_id' => $value));
		}
	}
	
	public function add($data){
		$data['date_modified']=date("Y-m-d H:i:s");
		$data=array_filter($data);//过滤空元素
		$this->db->insert($this->db->dbprefix('currency'), $data);
	}
	
	public function edit($data){
		$data['date_modified']=date("Y-m-d H:i:s");
		$data=array_filter($data);//过滤空元素
		$this->db->where('currency_id', $this->input->get('currency_id'));
		$this->db->update($this->db->dbprefix('currency'), $data);
	}
}