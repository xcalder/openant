<?php
class Stock_status_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	//取条码
	public function get_stock_statuss($data)
	{
		if(empty($data)){
			return FALSE;
		}
		foreach($data as $key=>$value){
			$row[]=$this->get_stock_status_for_language($data[$key]);
		}
		return $row;
	}

	//取条码
	public function get_stock_status_for_language($stock_status_id)
	{
		$this->db->select('stock_status.stock_status_id, stock_status_description.name');
		$this->db->where('stock_status.stock_status_id', $stock_status_id);
		$this->db->where('stock_status_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('stock_status_description','stock_status_description.stock_status_id = stock_status.stock_status_id');
		$this->db->from($this->db->dbprefix('stock_status'));
		
		$query=$this->db->get();
		
		if($query->num_rows() > 0){
			return $query->row_array();
		}
		
		return FALSE;
	}
}