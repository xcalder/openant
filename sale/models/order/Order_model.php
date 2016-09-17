<?php
class Order_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	//
	public function get_orders($data=array())
	{
		$limit=$this->config->get_config('config_limit_admin');
		
		//统计表记录
		if($data['order_status']){
			$this->db->where('order_status_id', $data['order_status']);
		}
		$this->db->where('store_id', $this->user->getStore_id());
		$orders['count']=$this->db->count_all_results($this->db->dbprefix('order'));
		
		$this->db->select('order.order_id');
		if($data['order_status']){
			if(is_array($data['order_status'])){
				$this->db->where_in('order.order_status_id', $data['order_status']);
			}else{
				$this->db->where('order.order_status_id', $data['order_status']);
			}
		}
		$this->db->where('order.store_id', $this->user->getStore_id());
		$this->db->limit($limit, $data['page']);
		$this->db->order_by('order.date_added', 'DESC');
		$this->db->from($this->db->dbprefix('order'));
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			foreach($query->result_array() as $order_id){
				$orders['order'][]=$this->get_order($order_id['order_id']);
			}
			return $orders;
		}
		
		return FALSE;
	}
	
	public function get_order($order_id){
		$this->db->select('order.order_id, order.invoice_no, order.invoice_prefix, order.store_id, order.user_id, order.firstname, order.lastname, order.email, order.telephone, order.payment_firstname, order.payment_lastname, order.payment_address, order.payment_city, order.payment_postcode, order.payment_country, order.payment_country_id, order.payment_zone, order.payment_zone_id, order.payment_address_format, order.payment_method, order.payment_code, order.shipping_firstname, order.shipping_lastname, order.shipping_address, order.shipping_city, order.shipping_postcode, order.shipping_country, order.shipping_country_id, order.shipping_zone, order.shipping_zone_id, order.shipping_address_format, order.shipping_method, order.shipping_code, order.comment, order.total, order.order_status_id, order.language_id, order.currency_id, order.currency_code, order.currency_value, order.date_added, order.date_modified, store_description.store_name, store_description.description, store_description.logo, order_status_description.status_name, order_status_description.order_status_id');
		$this->db->where('order.order_id', $order_id);
		$this->db->join('store', 'store.store_id = order.store_id');
		$this->db->where('store_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('store_description','store_description.store_id = store.store_id');
		$this->db->where('order_status_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('order_status_description', 'order_status_description.order_status_id = order.order_status_id');
		
		$this->db->from($this->db->dbprefix('order'));
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			$orders=$query->row_array();
			
			$this->db->where('order_id', $order_id);
			$this->db->from($this->db->dbprefix('order_product'));
			$query = $this->db->get();
			
			if($query->num_rows() > 0){
				$orders['products']=$query->result_array();
			}
			
			$orders['callout']=$this->get_callout_for_order_id($order_id);
			
			return $orders;
		}
		return FALSE;
	}
	
	public function total_order()
	{
		//所有待处理订单
		$order_status=array(
			$this->config->get_config('to_be_delivered'),//待发货
			$this->config->get_config('inbound_state'),//待收货
			$this->config->get_config('refund_order'),//退款中
		);
		
		$this->db->where('store_id', $this->user->getStore_id());
		$this->db->where_in('order_status_id', $order_status);
		
		$data['order_all']=$this->db->count_all_results($this->db->dbprefix('order'));
		
		//待发货
		$this->db->where('store_id', $this->user->getStore_id());
		$this->db->where('order_status_id', $this->config->get_config('to_be_delivered'));
		
		$data['to_be_delivered']=$this->db->count_all_results($this->db->dbprefix('order'));
		
		//待收货
		$this->db->where('store_id', $this->user->getStore_id());
		$this->db->where('order_status_id', $this->config->get_config('inbound_state'));
		
		$data['inbound_state']=$this->db->count_all_results($this->db->dbprefix('order'));
		
		//退款中
		$this->db->where('store_id', $this->user->getStore_id());
		$this->db->where('order_status_id', $this->config->get_config('refund_order'));
		
		$data['refund_order']=$this->db->count_all_results($this->db->dbprefix('order'));
		
		return $data;
	}
	
	//交易额
	public function total_sum_order()
	{
		//所有交易额
		$order_status=array(
			$this->config->get_config('to_be_delivered'),//待发货
			$this->config->get_config('inbound_state'),//待收货
			$this->config->get_config('state_to_be_evaluated'),//待评价
			$this->config->get_config('order_completion_status'),//交易成功
		);
		
		$this->db->select('total, currency_value');
		$this->db->where('store_id', $this->user->getStore_id());
		$this->db->where_in('order_status_id', $order_status);
		
		$query = $this->db->get($this->db->dbprefix('order'));
		if($query->num_rows() > 0){
			$data['total_all']=$query->result_array();
		}else{
			$data['total_all']=FALSE;
		}
		
		//未到帐
		$order_status=array(
			$this->config->get_config('to_be_delivered'),//待发货
			$this->config->get_config('inbound_state'),//待收货
		);
		
		$this->db->select('total, currency_value');
		$this->db->where('store_id', $this->user->getStore_id());
		$this->db->where_in('order_status_id', $order_status);
		
		$query = $this->db->get($this->db->dbprefix('order'));
		if($query->num_rows() > 0){
			$data['total_no_arrival']=$query->result_array();
		}else{
			$data['total_no_arrival']=FALSE;
		}
		
		//已到帐
		$order_status=array(
			$this->config->get_config('state_to_be_evaluated'),//待评价
			$this->config->get_config('order_completion_status'),//交易成功
		);
		
		$this->db->select('total, currency_value');
		$this->db->where('store_id', $this->user->getStore_id());
		$this->db->where_in('order_status_id', $order_status);
		
		$query = $this->db->get($this->db->dbprefix('order'));
		if($query->num_rows() > 0){
			$data['total_success']=$query->result_array();
		}else{
			$data['total_success']=FALSE;
		}
		
		//退款成功
		$refund_order_success_id=$this->config->get_config('refund_order_success');
		$this->db->select('total, currency_value');
		$this->db->where('store_id', $this->user->getStore_id());
		$this->db->where('order_status_id', $refund_order_success_id);
		
		$query = $this->db->get($this->db->dbprefix('order'));
		if($query->num_rows() > 0){
			$data['total_refund_order_success']=$query->result_array();
		}else{
			$data['total_refund_order_success']=FALSE;
		}
		
		return $data;
	}
	
	public function count_orders_to_product($store_id){
		$this->db->select('order_status_id, COUNT(*) AS count');
		$this->db->where('store_id', $store_id);
		$this->db->group_by('order_status_id');
		
		$this->db->from($this->db->dbprefix('order'));
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			$counts=$query->result_array();
			$all=array_sum(array_column($counts,'count'));
			
			$refund_rate=array();
			$success_rate=array();
			foreach($counts as $k=>$v){
				if($this->config->get_config('refund_order') == $counts[$k]['order_status_id'] || $this->config->get_config('refund_order_success') == $counts[$k]['order_status_id']){
					$refund_rate[]=$counts[$k]['count'];
				}
				
				if($this->config->get_config('state_to_be_evaluated') == $counts[$k]['order_status_id'] || $this->config->get_config('order_completion_status') == $counts[$k]['order_status_id']){
					$success_rate[]=$counts[$k]['count'];
				}
				
			}
			$data['refund_rate']=sprintf("%.2f", (array_sum($refund_rate) / $all) * 100).'%';
			$data['success_rate']=sprintf("%.2f", (array_sum($success_rate) / $all) * 100).'%';
			
			return $data;
		}
		return FALSE;
	}
	
	public function get_callout_for_order_id($order_id, $type='', $user='sale'){
		$this->db->select('callout_content, callout_type');
		$this->db->where('order_id', $order_id);
		if(!empty($type)){
			$this->db->where('callout_type', $type);
		}
		if(!empty($user)){
			$this->db->where('callout_user', $user);
		}
		
		$query = $this->db->get($this->db->dbprefix('order_callout'));
		if($query->num_rows() > 0){
			return $query->row_array();
		}
		
		return FALSE;
	}
	
	public function add_callout($data){
		$this->db->select('callout_id');
		$this->db->where('order_id', $data['order_id']);
		//$this->db->where('callout_type', $data['callout_type']);
		$this->db->where('callout_user', $data['callout_user']);
		
		$query = $this->db->get($this->db->dbprefix('order_callout'));
		if($query->num_rows() > 0){
			$this->db->where('order_id', $data['order_id']);
			return $this->db->update($this->db->dbprefix('order_callout'), $data);
		}else{
			return $this->db->insert($this->db->dbprefix('order_callout'), $data);
		}
	}
}