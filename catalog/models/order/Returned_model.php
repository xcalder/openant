<?php
class Returned_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function get_order_product($rowid)
	{
		$this->db->select('order_product.order_id, order_product.rowid, order_product.name, order_product.image, order_product.quantity, order_product.price, order_product.total, order_product.tax, order_product.value, order_product.points');
		
		$this->db->where('rowid', $rowid);
		
		$this->db->from($this->db->dbprefix('order_product'));
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			return $query->row_array();
		}
		
		return FALSE;
	}
	
	//退换事件
	public function get_return_actions_to_returned()
	{
		$action_ids=array($this->config->get_config('action_return_and_refund'), $this->config->get_config('action_return'), $this->config->get_config('action_refund'));
		$this->db->where_in('return_action.return_action_id', $action_ids);
		$this->db->where('return_action_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('return_action_description', 'return_action_description.return_action_id = return_action.return_action_id');
		$this->db->from($this->db->dbprefix('return_action'));
	
		$query = $this->db->get();
	
		if($query->num_rows() > 0){
			return $query->result_array();
		}
	
		return FALSE;
	}
	
	//退换原因
	public function get_return_reason_to_returned()
	{
		$this->db->where('return_reason_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('return_reason_description', 'return_reason_description.return_reason_id = return_reason.return_reason_id');
		$this->db->from($this->db->dbprefix('return_reason'));
	
		$query = $this->db->get();
	
		if($query->num_rows() > 0){
			return $query->result_array();
		}
	
		return FALSE;
	}
}