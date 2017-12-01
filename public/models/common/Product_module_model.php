<?php
class Product_module_model extends CI_Model{
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
	
	//查单个商品
	public function get_product($product_id){
		//商品基本数据
		$this->db->select('p.image, pd.name, p.price, p.store_id, sd.store_name, p.product_id');
		$this->db->where('p.product_id', $product_id);
		$this->db->where('p.status','1');
		$this->db->where('p.invalid','0');
		$this->db->where('p.date_invalid < ', date("Y-m-d H:i:s"));
		$this->db->from($this->db->dbprefix('product') . ' AS p');//查商品表
		$this->db->where('pd.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		
		//查商品描述表
		$this->db->join($this->db->dbprefix('product_description') . ' AS pd', 'pd.product_id = p.product_id');
		
		//商店名
		$this->db->where('sd.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join($this->db->dbprefix('store_description') . ' AS sd', 'sd.store_id = p.store_id');
		
		//echo $this->db->get_compiled_select();
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			$product = $query->row_array();
		}else{
			return FALSE;
		}
		
		if($product){
			//查退款、成交率
			$product['order_rate']=$this->count_orders_to_product($product['store_id']);
		}

		if($product){
			//销量
			$order_status[]=$this->config->get_config('to_be_delivered');
			$order_status[]=$this->config->get_config('inbound_state');
			$order_status[]=$this->config->get_config('state_to_be_evaluated');
			$order_status[]=$this->config->get_config('order_completion_status');
			
			if(isset($order_status) && is_array($order_status)){
				$order_status=array_unique($order_status);
				$this->db->group_start();
				foreach($order_status as $value){
					$this->db->or_where('o.order_status_id',$value);
				}
				$this->db->group_end();
			}
			
			
			$this->db->select('op.quantity');
			$this->db->where('op.product_id',$product['product_id']);
			$this->db->join($this->db->dbprefix('order') . ' AS o','o.order_id = op.order_id');
			$this->db->from($this->db->dbprefix('order_product') . ' AS op');//查
			$query = $this->db->get();
			
			if($query->num_rows() > 0){
				$seal_quantity_total=array_column($query->result_array(),'quantity');
				$product['seal_quantity_total'] = array_sum($seal_quantity_total);
			}
		}
		
		return $product;
	}

	//查商品分类下的商品
	public function get_products($data = array()){
		//商品基本数据
		if(isset($data['order_by']) && $data['order_by'] == 'sales'){
			
			$order_status=$this->config->get_config('to_be_delivered').','.$this->config->get_config('inbound_state').','.$this->config->get_config('state_to_be_evaluated').','.$this->config->get_config('order_completion_status');
			
			$this->db->select('p.product_id, (SELECT SUM(op.quantity) FROM `order_product` AS `op` JOIN `'.$this->db->dbprefix('order').'` AS o ON `o`.`order_id` = `op`.`order_id` WHERE `o`.`order_status_id` IN('.$order_status.') AND op.product_id = p.product_id) AS order_sum');
			
			$this->db->order_by('order_sum', 'DESC');
		}else{
			$this->db->select('p.product_id');
		}
		
		if(isset($data['category_id'])){
			//查分类
			$this->db->where('ptc.category_id', $data['category_id']);
			$this->db->join($this->db->dbprefix('product_to_category') . ' AS ptc', 'ptc.product_id = p.product_id');//查商品描述表
			
		}
		
		if(isset($data['order_by']) && $data['order_by'] == 'time'){
			$this->db->order_by('p.date_added', 'DESC');
		}
		
		if(isset($data['order_by']) && $data['order_by'] == 'RANDOM'){
			$this->db->order_by('p.date_added', 'RANDOM');
		}
		
		$this->db->where('p.status','1');
		$this->db->where('p.invalid','0');
		$this->db->where('p.date_invalid < ', date("Y-m-d H:i:s"));
		
		$this->db->where('s.store_status', '0');
		$this->db->where('s.date_invalid < ', date("Y-m-d H:i:s"));
		$this->db->join($this->db->dbprefix('store') . ' AS s', 's.store_id = p.store_id');//商店状态为0并且不在查封期间
		
		$this->db->limit($data['limit']);
		
		$this->db->from($this->db->dbprefix('product') . ' AS p');//查商品表
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			$products = $query->result_array();
			$products = array_flip(array_flip(array_column($products,'product_id')));
			foreach($products as $product){
				$products_[]=$this->get_product($product);
			}
			$row['products']=$products_;
			
			return $row;
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
}