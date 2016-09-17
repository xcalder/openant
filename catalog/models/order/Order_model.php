<?php
class Order_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function add_order($data){
		if($this->db->insert($this->db->dbprefix('order'), $data)){
			return $this->db->insert_id();
		}else{
			return FALSE;
		}
	}
	
	public function add_order_product($data){
		if($this->db->insert_batch($this->db->dbprefix('order_product'), $data)){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
	//修改订单状态
	public function edit_order_status($data){
		$this->db->update_batch('order', $data, 'order_id');
	}
	
	//
	public function get_orders($data=array())
	{
		$limit=$this->config->get_config('config_limit_admin');
		
		//统计表记录
		if($data['order_status']){
			$this->db->where('order_status_id', $data['order_status']);
		}
		$this->db->where('user_id', $this->user->getId());
		$orders['count']=$this->db->count_all_results($this->db->dbprefix('order'));
		
		$this->db->select('order.order_id');
		if($data['order_status']){
			if(is_array($data['order_status'])){
				$this->db->where_in('order.order_status_id', $data['order_status']);
			}else{
				$this->db->where('order.order_status_id', $data['order_status']);
			}
		}
		$this->db->where('order.user_id', $this->user->getId());
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
		$this->db->select('order.order_id, order.invoice_no, order.invoice_prefix, order.store_id, order.user_id, order.firstname, order.lastname, order.email, order.telephone, order.payment_firstname, order.payment_lastname, order.payment_address, order.payment_city, order.payment_postcode, order.payment_country, order.payment_country_id, order.payment_zone, order.payment_zone_id, order.payment_address_format, order.payment_method, order.payment_code, order.shipping_firstname, order.shipping_lastname, order.shipping_address, order.shipping_city, order.shipping_postcode, order.shipping_country, order.shipping_country_id, order.shipping_zone, order.shipping_zone_id, order.shipping_address_format, order.shipping_method, order.shipping_code, order.comment, order.total, order.order_status_id, order.language_id, order.currency_id, order.currency_code, order.currency_value, order.date_added, order.date_modified, store_description.store_name, store_description.description, store_description.logo, order_status_description.status_name, order_status_description.order_status_id, user.firstname AS u_firstname, user.lastname AS u_lastname, user.nickname AS u_nickname, user.email AS u_email, user.telephone AS u_telephone');
		$this->db->where('order.order_id', $order_id);
		$this->db->join('store', 'store.store_id = order.store_id');
		$this->db->join('user', 'user.store_id = order.store_id');
		$this->db->where('store_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('store_description','store_description.store_id = store.store_id');
		$this->db->where('order_status_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('order_status_description', 'order_status_description.order_status_id = order.order_status_id');
		
		$this->db->from($this->db->dbprefix('order'));
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			$orders=$query->row_array();
			
			if (!empty($orders['payment_address_format'])) {
				$format = $orders['payment_address_format'];
			} else {
				$format = '{firstname} {lastname}' . "\n" . '{address}' . "\n"  . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
			}
			
			$find = array(
					'{firstname}',
					'{lastname}',
					'{address}',
					'{city}',
					'{postcode}',
					'{zone}',
					'{country}'
			);

			$replace = array(
				'firstname' => $orders['payment_firstname'],
				'lastname'  => $orders['payment_lastname'],
				'address' 	=> $orders['payment_address'],
				'city'      => $orders['payment_city'],
				'postcode'  => $orders['payment_postcode'],
				'zone'      => $orders['payment_zone'],
				'country'   => $orders['payment_country']
			);
			
			$orders['payment_address'] = str_replace(array("\r\n", "\r", "\n"), '', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '', trim(str_replace($find, $replace, $format))));
			
			if (!empty($orders['shipping_address_format'])) {
				$format = $orders['shipping_address_format'];
			} else {
				$format = '{firstname} {lastname}' . "\n" . '{address}' . "\n"  . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
			}
			
			$find = array(
					'{firstname}',
					'{lastname}',
					'{address}',
					'{city}',
					'{postcode}',
					'{zone}',
					'{country}'
			);

			$replace = array(
				'firstname' => $orders['shipping_firstname'],
				'lastname'  => $orders['shipping_lastname'],
				'address' 	=> $orders['shipping_address'],
				'city'      => $orders['shipping_city'],
				'postcode'  => $orders['shipping_postcode'],
				'zone'      => $orders['shipping_zone'],
				'country'   => $orders['shipping_country']
			);
			
			$orders['shipping_address'] = str_replace(array("\r\n", "\r", "\n"), '', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '', trim(str_replace($find, $replace, $format))));
			
			$this->db->where('order_id', $order_id);
			$this->db->from($this->db->dbprefix('order_product'));
			$query = $this->db->get();
			
			if($query->num_rows() > 0){
				$orders['products']=$query->result_array();
			}
			
			return $orders;
		}
		return FALSE;
	}
	
	public function count_orders(){
		$this->db->select('order_status_id, COUNT(*) AS count');
		$this->db->where('user_id', $this->user->getId());
		$this->db->group_by('order_status_id');
		
		$this->db->from($this->db->dbprefix('order'));
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			return $query->result_array();
		}
		return FALSE;
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
	
	public function del_order($order_id){
		//所有交易
		$order_status=array(
			$this->config->get_config('to_be_delivered'),//待发货
			$this->config->get_config('inbound_state'),//待收货
			//$this->config->get_config('state_to_be_evaluated'),//待评价
			//$this->config->get_config('order_completion_status'),//交易成功
			$this->config->get_config('refund_order'),//交易成功
		);
		
		$this->db->select('order_id');
		$this->db->where_in('order_status_id', $order_status);
		$this->db->where_in('order_id', $order_id);
		
		$query = $this->db->get($this->db->dbprefix('order'));
		if($query->num_rows() > 0){
			return FALSE;
		}else{
			$this->db->trans_start();
			$this->db->delete($this->db->dbprefix('order'), array('order_id' => $order_id));
			$this->db->delete($this->db->dbprefix('order_callout'), array('order_id' => $order_id));
			$this->db->delete($this->db->dbprefix('order_product'), array('order_id' => $order_id));
			$this->db->trans_complete();
			return TRUE;
		}
		
		return FALSE;
	}
	
	//支付金额
	public function get_payment_amount($order_ids){
		if(!is_array($order_ids)){
			return FALSE;
		}
		
		$this->db->select('total, order_status_id');
		$this->db->where_in('order_id', $order_ids);
		$query = $this->db->get($this->db->dbprefix('order'));
		if($query->num_rows() > 0){
			$row=$query->result_array();
			
			foreach($row as $value){
				if($value['order_status_id'] != $this->config->get_config('default_order_status')){
					return FALSE;
					exit;
				}
			}
			$row=array_sum(array_column($row,'total'));
			return $row;
		}
		
		return FALSE;
	}
	
	public function get_orders_to_payment($order_ids){
		if(!is_array($order_ids)){
			return FALSE;
		}
		
		$this->db->where_in('order_id', $order_ids);
		$this->db->from($this->db->dbprefix('order'));
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			return $query->result_array();
		}
		return FALSE;
	}
	
	public function get_order_products_to_payment($order_ids){
		if(!is_array($order_ids)){
			return FALSE;
		}
		
		$this->db->select('product_id, rowid, order_id');
		$this->db->where_in('order_id', $order_ids);
		$this->db->from($this->db->dbprefix('order_product'));
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			$row=$query->result_array();
			foreach($row as $product){
				$data[]=$this->get_order_product($product['product_id'], $product['rowid'], $product['order_id']);
			}
			return $data;
		}
		return FALSE;
	}
	
	public function get_order_product($product_id, $rowid, $order_id){
		$this->db->select('order_product.order_id,order_product.rowid,order_product.store_id,order_product.product_option_value_id,order_product.product_id,order_product.name,order_product.image,order_product.quantity,order_product.price,order_product.total,order_product.value,order_product.tax, order_product.preferential_type, order_product.preferential_value, product.weight,product.weight_class_id,product.length, product.length_class_id,product.height, product.width');
		$this->db->where('order_product.product_id', $product_id);
		$this->db->where('order_product.rowid', $rowid);
		$this->db->where('order_product.order_id', $order_id);
		$this->db->join('product', 'product.product_id = order_product.product_id');
		$this->db->from($this->db->dbprefix('order_product'));
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			return $query->row_array();
		}
		return FALSE;
	}
}