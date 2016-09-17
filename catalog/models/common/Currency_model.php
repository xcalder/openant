<?php
class Currency_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	//查所有
	public function get_currencys()
	{
		$this->db->where('status','1');
		$this->db->order_by('currency_id', 'ASC');
		$this->db->from($this->db->dbprefix('currency'));
		$query = $this->db->get(); 
		
		$row = $query->result_array();
		
		return $row;
	}
	
	//用id查
	public function get_currency($currency_id='1')
	{
		$this->db->where('status','1');
		$this->db->where('currency_id',$currency_id);
		$this->db->from($this->db->dbprefix('currency'));
		$query = $this->db->get();
		
		$row = $query->row_array();
		
		return $row;
	}
}