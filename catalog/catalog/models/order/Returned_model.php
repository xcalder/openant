<?php
class Returned_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function get_order_product($rowid)
	{
		$this->db->select('op.order_id, op.rowid, op.product_id, op.name, op.image, op.quantity, op.price, op.total, op.tax, op.value, op.points, o.currency_value, u.user_id');
		
		$this->db->where('op.rowid', $rowid);
		
		$this->db->join('order AS o', 'o.order_id = op.order_id');
		
		$this->db->join('user AS u', 'u.store_id = o.store_id');
		
		$this->db->from($this->db->dbprefix('order_product') . ' AS op');
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
		$this->db->select('rad.name,ra.return_action_id');
		$this->db->where_in('ra.return_action_id', $action_ids);
		
		$this->db->where('rad.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('return_action_description AS rad', 'rad.return_action_id = ra.return_action_id');
		
		$this->db->from($this->db->dbprefix('return_action') . ' AS ra');
	
		$query = $this->db->get();
	
		if($query->num_rows() > 0){
			return $query->result_array();
		}
	
		return FALSE;
	}
	
	//退换原因
	public function get_return_reason_to_returned()
	{
		$this->db->select('rrd.name,rr.return_reason_id');
		$this->db->where('rrd.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('return_reason_description AS rrd', 'rrd.return_reason_id = rr.return_reason_id');
		$this->db->from($this->db->dbprefix('return_reason') . ' AS rr');
	
		$query = $this->db->get();
	
		if($query->num_rows() > 0){
			return $query->result_array();
		}
	
		return FALSE;
	}
	
	public function add($data){
		$this->db->insert($this->db->dbprefix('return'), $data);
		return $this->db->insert_id();
	}
	
	public function add_history($data){
		$this->db->insert($this->db->dbprefix('return_history'), $data);
		return $this->db->insert_id();
	}
	
	public function check_return($rowid){
		$this->db->select('return_id');
		$this->db->where('rowid', $rowid);
		$this->db->from($this->db->dbprefix('return'));
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			return true;
		}
		
		return false;
	}
	
	public function get_info($rowid){
		//$this->db->select('*');
		$this->db->select('rad.name as return_action, r.logistics as re_logistics, o.logistic, r.return_mode_id, r.return_action_id, r.user_id, r.rowid, r.return_id, r.logistics, r.return_amount, r.order_id, r.product_id, r.option, r.firstname, r.lastname, r.email, r.telephone, r.quantity, r.opened, r.date_added, pd.name, p.image, sd.store_name, u.nickname as s_nickname, u.image as s_image, u.firstname as s_firstname, u.lastname as s_lastname, u.user_id as s_user_id, u.telephone as s_telephone, u.email as s_email, o.order_status_id, o.invoice_no as o_invoice_no, op.price, o.date_added as o_date_added, o.currency_value, osd.status_name');
		$this->db->where('r.rowid', $rowid);
		$this->db->where('pd.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('product_description AS pd', 'pd.product_id = r.product_id');
		
		$this->db->where('rrd.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('return_reason_description AS rrd', 'rrd.return_reason_id = r.return_reason_id');
		
		$this->db->where('rad.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('return_action_description AS rad', 'rad.return_action_id = r.return_action_id');
		
		$this->db->join('product AS p', 'p.product_id = r.product_id');
		
		$this->db->where('sd.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('store_description AS sd', 'sd.store_id = p.store_id');
		
		$this->db->join('user AS u', 'u.store_id = p.store_id');
		
		$this->db->join('order AS o', 'o.order_id = r.order_id');
		
		$this->db->where('osd.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('order_status_description AS osd', 'o.order_status_id = osd.order_status_id');
		
		$this->db->join('order_product AS op', 'r.rowid = op.rowid');
		
		
		$this->db->from($this->db->dbprefix('return') . ' AS r');
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			$return=$query->row_array();
			
			$this->db->select('rh.return_status_id, rh.notify, rh.comment, rh.date_added, rsd.name');
			
			$this->db->where('rsd.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
			$this->db->join('return_status_description AS rsd', 'rsd.return_status_id = rh.return_status_id');
			
			$this->db->where('rh.return_id', $return['return_id']);
			$this->db->from($this->db->dbprefix('return_history') . ' AS rh');
			
			$this->db->order_by('rh.date_added', 'DESC');
			$query = $this->db->get();
			
			if($query->num_rows() > 0){
				$return['return_history']=$query->result_array();
			}else{
				$return['return_history']=array();
			}
			
			$this->db->select('name');
			$this->db->where('language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
			$this->db->where('return_mode_id', $return['return_mode_id']);
			$this->db->from($this->db->dbprefix('return_mode_description'));
			$query = $this->db->get();
			if($query->num_rows() > 0){
				$return['re_mode']=$query->row_array()['name'];
			}else{
				$return['re_mode']='';
			}
			
			return $return;
		}
		
		return FALSE;
	}
	
	public function get_list($data){
		$limit=$this->config->get_config('config_limit_admin');
		
		$this->db->where('user_id', $_SESSION['user_id']);
		$return['count']=$this->db->count_all_results($this->db->dbprefix('return'));
		
		$this->db->select('distinct(return_id)');
		$this->db->limit($limit, $data['page']);
		$this->db->where('user_id', $_SESSION['user_id']);
		
		$this->db->order_by('date_added', 'DESC');
		$this->db->from($this->db->dbprefix('return'));
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			$return_ids=$query->result_array();
			foreach ($return_ids as $return_id){
				$return['returns'][]=$this->get_return($return_id['return_id']);
			}
			return $return;
		}
		return false;
	}
	
	public function get_return($return_id){
		
		$this->db->select('rad.name as return_action, r.rowid, r.return_id, r.logistics, r.return_amount, r.quantity, r.order_id, r.product_id, r.option, r.date_added, pd.name, p.image, sd.store_name, o.order_status_id, o.invoice_no as o_invoice_no, op.price, o.date_added as o_date_added, o.currency_value, rsd.name as status_name');
		
		$this->db->where('pd.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('product_description AS pd', 'pd.product_id = r.product_id');
		
		$this->db->where('rrd.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('return_reason_description AS rrd', 'rrd.return_reason_id = r.return_reason_id');
		
		$this->db->where('rad.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('return_action_description AS rad', 'rad.return_action_id = r.return_action_id');
		
		$this->db->join('product AS p', 'p.product_id = r.product_id');
		
		$this->db->where('sd.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('store_description AS sd', 'sd.store_id = p.store_id');
		
		$this->db->where('rsd.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('return_status_description AS rsd', 'r.return_status_id = rsd.return_status_id');
		
		$this->db->join('order_product AS op', 'r.rowid = op.rowid');
		
		$this->db->join('order AS o', 'o.order_id = op.order_id');
		
		$this->db->where('r.return_id', $return_id);
		$this->db->from($this->db->dbprefix('return') . ' AS r');
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			return $query->row_array();
		}
		
		return FALSE;
	}
	
	public function get_return_id($rowid){
		$this->db->select('return_id');
		$this->db->where('rowid', $rowid);
	
		$this->db->from($this->db->dbprefix('return'));
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->row_array()['return_id'];
		}
		return false;
	}
	
	public function updata_return($data){
		$this->db->where('return_id', $data['return_id']);
		$this->db->update($this->db->dbprefix('return'), $data);
	}
}