<?php
class Product_model extends CI_Model{
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
	
	//查单个商品
	public function get_product($product_id){
		//商品基本数据
		$this->db->select('*');
		$this->db->where('product.product_id', $product_id);
		$this->db->where('product.status','1');
		$this->db->where('product.invalid','0');
		$this->db->where('product.date_invalid < ', date("Y-m-d H:i:s"));
		$this->db->from($this->db->dbprefix('product'));//查商品表
		$this->db->where('product_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		
		$this->db->join('product_description', 'product_description.product_id = product.product_id');//查商品描述表
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			$product = $query->row_array();
		}else{
			return FALSE;
		}
		
		if($product){
			//查店铺名
			$this->load->model('common/store_model');
			$product['store_name']=$this->store_model->get_store_name($product['store_id'])['store_name'];
			
			//查退款、成交率
			$this->load->model('order/order_model');
			$product['order_rate']=$this->order_model->count_orders_to_product($product['store_id']);
		}
		
		if($product){
			//查重量单位
			$this->db->select('*');
			$this->db->where('weight_class.weight_class_id',$product['weight_class_id']);
			$this->db->where('weight_class_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
			$this->db->join('weight_class_description','weight_class_description.weight_class_id = weight_class.weight_class_id');
			$this->db->from($this->db->dbprefix('weight_class'));//查
			$query = $this->db->get();
			
			if($query->num_rows() > 0){
				$product['weight_class'] = $query->row_array();
			}
		}
		
		if($product){
			//查尺寸单位
			$this->db->select('*');
			$this->db->where('length_class.length_class_id',$product['length_class_id']);
			$this->db->where('length_class_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
			$this->db->join('length_class_description','length_class_description.length_class_id = length_class.length_class_id');
			$this->db->from($this->db->dbprefix('length_class'));//查
			$query = $this->db->get();
			
			if($query->num_rows() > 0){
				$product['length_class'] = $query->row_array();
			}
		}
		
		if($product){
			//查税
			$this->db->select('rate, name, type');
			$this->db->where('tax_class.tax_class_id',$product['tax_class_id']);
			$this->db->where('tax_class_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
			$this->db->where('tax_rate_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
			$this->db->join('tax_class_description','tax_class_description.tax_class_id = tax_class.tax_class_id');
			$this->db->join('tax_rule','tax_rule.tax_class_id = tax_class.tax_class_id');
			$this->db->join('tax_rate','tax_rate.tax_rate_id = tax_rule.tax_rate_id');
			$this->db->join('tax_rate_description','tax_rate_description.tax_rate_id = tax_rule.tax_rate_id');
			$this->db->join('tax_rate_to_user_class','tax_rate_to_user_class.tax_rate_id = tax_rule.tax_rate_id');
			$this->db->from($this->db->dbprefix('tax_class'));//查
			$query = $this->db->get();
			
			if($query->num_rows() > 0){
				$product['taxs'] = $query->row_array();
			}
		}
		
		if($product){
			//查商品属性
			$this->db->select('attribute_group.attribute_group_id, attribute_group_description.group_name, attribute_description.name, product_attribute.text, product_attribute.image');
			$this->db->where('product_attribute.product_id',$product_id);
			$this->db->where('product_attribute.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
			$this->db->where('attribute_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
			$this->db->where('attribute_group_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
			$this->db->order_by('attribute_group.sort_order', 'ASC');
			$this->db->order_by('attribute.sort_order', 'ASC');
			$this->db->join('attribute', 'attribute.attribute_id = product_attribute.attribute_id');//查商品属性
			$this->db->join('attribute_description', 'attribute_description.attribute_id = attribute.attribute_id');//查商品属性
			$this->db->join('attribute_group', 'attribute_group.attribute_group_id = attribute.attribute_group_id');//查商品属性
			$this->db->join('attribute_group_description', 'attribute_group_description.attribute_group_id = attribute.attribute_group_id');//查商品属性
			$this->db->from($this->db->dbprefix('product_attribute'));//查商品属性表
			$query = $this->db->get();
			
			if($query->num_rows() > 0){
				$product['attribute'] = $query->result_array();
			}
		}
		
		if($product){
			//查商品主图
			$this->db->select('*');
			$this->db->where('product_id',$product['product_id']);
			$this->db->order_by('sort_order', 'ASC');
			$this->db->from($this->db->dbprefix('product_image'));//查商折扣
			$query = $this->db->get();
			
			if($query->num_rows() > 0){
				$product['images'] = $query->result_array();
			}
		}
		
		if($product){
			//查商品选项
			$this->db->select('*');
			$this->db->where('product_id',$product['product_id']);
			$this->db->from($this->db->dbprefix('product_option_value'));//查
			$query = $this->db->get();
			
			if($query->num_rows() > 0){
				$arr=$query->result_array();
				$option_group_ids=array_flip(array_flip(explode('.', implode('.', array_flip(array_flip(array_column($arr,'option_group_id')))))));
				$option_ids=array_flip(array_flip(explode('.', implode('.', array_flip(array_flip(array_column($arr,'option_id')))))));
				
				$op_arr=array();
				foreach($option_group_ids as $key=>$value){
					$this->db->select('option_group.option_group_id, option_group.type, option_group_description.option_group_name');
					$this->db->where('option_group.option_group_id', $option_group_ids[$key]);
					$this->db->where('option_group_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
					$this->db->join('option_group_description', 'option_group_description.option_group_id = option_group.option_group_id');
					$this->db->order_by('option_group.option_group_id');
					$this->db->from($this->db->dbprefix('option_group'));//查
					$query = $this->db->get();
					
					if($query->num_rows() > 0){
						$op_arr[$key]=$query->row_array();
						
						$this->db->select('option.option_id, option_description.name');
						$this->db->where('option.option_group_id', $option_group_ids[$key]);
						$this->db->where_in('option.option_id', $option_ids);
						$this->db->where('option_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
						$this->db->join('option_description', 'option_description.option_id = option.option_id');
						
						$this->db->from($this->db->dbprefix('option'));//查
						$query = $this->db->get();
						
						if($query->num_rows() > 0){
							$op_arr[$key]['options']=$query->result_array();
						}
					}
				}
				
				$product['options'] = $op_arr;
			}
		}
		
		if($product){
			//查评论
			$this->db->select('product_review.text, product_review.rating, product_review.date_added, product_review.date_modified, user.user_class_id, user.nickname, user.image');
			$this->db->where('product_review.product_id',$product['product_id']);
			$this->db->where('product_review.status','0');
			$this->db->join('user','user.user_id = product_review.user_id');
			$this->db->order_by('product_review.date_added', 'DESC');
			$this->db->from($this->db->dbprefix('product_review'));//查
			$query = $this->db->get();
			
			if($query->num_rows() > 0){
				$product['reviews'] = $query->result_array();
			}
		}

		if($product){
			//查商品折扣
			$this->db->select('quantity, value, date_start, date_end');
			$this->db->where('product_id',$product['product_id']);
			if($this->user->isLogged()){
				$this->db->where('user_class_id', $this->user->getUserclassId());
			}
			$this->db->from($this->db->dbprefix('product_discount'));//查商折扣
			$query = $this->db->get();
			
			if($query->num_rows() > 0){
				$product['discount'] = $query->row_array();
			}
		}
		
		if($product){
			//查优惠
			$this->db->select('quantity, price, date_start, date_end');
			$this->db->where('product_id',$product['product_id']);
			if($this->user->isLogged()){
				$this->db->where('user_class_id', $this->user->getUserclassId());
			}
			$this->db->from($this->db->dbprefix('product_special'));//查
			$query = $this->db->get();
			
			if($query->num_rows() > 0){
				$product['special'] = $query->row_array();
			}
		}
		
		if($product){
			//查分类
			$this->db->select('*');
			$this->db->where('product_id',$product['product_id']);
			$this->db->from($this->db->dbprefix('product_to_category'));//查
			$query = $this->db->get();
			
			if($query->num_rows() > 0){
				$product['categorys'] = $query->result_array();
			}
		}
		
		if($product){
			//查下载
			$this->db->select('product_download.product_id, product_download.download_id, product_download.mask, product_download.date_added, product_download.description, product_download.filename');
			$this->db->where('product_download.product_id',$product['product_id']);
			
			$this->db->order_by('product_download.sort_order', 'ASC');
			
			$this->db->from($this->db->dbprefix('product_download'));//查
			$query = $this->db->get();
			
			if($query->num_rows() > 0){
				$product['downloads'] = $query->result_array();
			}
		}
		
		if($product){
			//查条码
			$this->db->select('*');
			$this->db->where('product_barcode.product_id',$product['product_id']);
			$this->db->where('barcode_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
			$this->db->join('barcode_description','barcode_description.barcode_id = product_barcode.barcode_id');
			$this->db->from($this->db->dbprefix('product_barcode'));//查
			$query = $this->db->get();
			
			if($query->num_rows() > 0){
				$product['barcodes'] = $query->result_array();
			}
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
					$this->db->or_where('order.order_status_id',$value);
				}
				$this->db->group_end();
			}
			
			
			$this->db->select('order_product.quantity');
			$this->db->where('order_product.product_id',$product['product_id']);
			$this->db->join('order','order.order_id = order_product.order_id');
			$this->db->from($this->db->dbprefix('order_product'));//查
			$query = $this->db->get();
			
			if($query->num_rows() > 0){
				$seal_quantity_total=array_column($query->result_array(),'quantity');
				$product['seal_quantity_total'] = array_sum($seal_quantity_total);
			}
		}
		
		return $product;
	}
	
	//查商品分类下的商品
	public function get_products_to_category($data = array()){
		$this->db->limit($this->config->get_config('config_limit_catalog'), $data['page']);
		
		$products = array();
		if(isset($data['category_id'])){
			//查分类
			$this->db->where('product_to_category.category_id', $data['category_id']);
		}
		
		if(isset($data['manufacturer'])){
			//品牌
			$this->db->where('product.manufacturer_id', $data['manufacturer_id']);
		}
		
		if(isset($data['option']) && is_array($data['option'])){
			//选项
			//$this->db->where_in('product_option_value.option_value_id',$data['option']);
			//$this->db->join('product_option_value', 'product_option_value.product_id = product.product_id');//查商品选项
		}

		if(isset($data['order_by'])){
			$this->db->order_by($data['order_by']);
		}else{
			//默认排序
			$this->db->order_by('product.seo_order', 'DESC');
		}
		
		$this->db->where('product.status','1');
		$this->db->where('product.invalid','0');
		$this->db->where('product.date_invalid < ', date("Y-m-d H:i:s"));
		if(isset($data['store_id'])){
			$this->db->where('product.store_id',$data['store_id']);
		}
		
		$this->db->join('product', 'product.product_id = product_to_category.product_id');//查商品描述表
		
		if(isset($data['search'])){
			$this->db->like('product_description.name', $data['search']);
			$this->db->where('product_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
			$this->db->join('product_description', 'product_description.product_id = product.product_id');//查商品描述表
		}
		
		$this->db->where('store.store_status', '0');
		$this->db->where('store.date_invalid < ', date("Y-m-d H:i:s"));
		$this->db->join('store', 'store.store_id = product.store_id');//商店状态为0并且不在查封期间
		
		$this->db->from($this->db->dbprefix('product_to_category'));//查商品表
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			$products = $query->result_array();
			$products = array_flip(array_flip(array_column($products,'product_id')));
			//$products = array_column($products,'product_id');
			
			foreach($products as $product){
				if($this->get_product($product)){
					$product_s['products'][]=$this->get_product($product);
				}
			}
			
			//统计记录行数
			$this->db->reset_query();
			if(isset($data['category_id'])){
				//查分类
				$this->db->where('product_to_category.category_id', $data['category_id']);
			}
			
			if(isset($data['manufacturer'])){
				//品牌
				$this->db->where('product.manufacturer_id', $data['manufacturer_id']);
			}
			
			$this->db->where('product.status','1');
			$this->db->where('product.invalid','0');
			$this->db->where('product.date_invalid < ', date("Y-m-d H:i:s"));
			if(isset($data['store_id'])){
				$this->db->where('product.store_id',$data['store_id']);
			}
			$this->db->join('product', 'product.product_id = product_to_category.product_id');//查商品描述表
			
			if(isset($data['search'])){
				$this->db->like('product_description.name', $data['search']);
				$this->db->where('product_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
				$this->db->join('product_description', 'product_description.product_id = product.product_id');//查商品描述表
			}
			
			$product_s['count']=$this->db->count_all_results($this->db->dbprefix('product_to_category'));
			//
			
			return $product_s;
		}else{
			return FALSE;
		}
	}
	
	public function get_product_option($data){
		$row=array();
		$product_id=$data['product_id'];
		
		//查商品折扣
		$this->db->select('quantity, value, date_start, date_end');
		$this->db->where('product_id',$product_id);
		if($this->user->isLogged()){
			$this->db->where('user_class_id', $this->user->getUserclassId());
		}
		$this->db->from($this->db->dbprefix('product_discount'));//查商折扣
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			$row['discount'] = $query->row_array();
		}
		
		//查优惠
		$this->db->select('quantity, price, date_start, date_end');
		$this->db->where('product_id',$product_id);
		if($this->user->isLogged()){
			$this->db->where('user_class_id', $this->user->getUserclassId());
		}
		$this->db->from($this->db->dbprefix('product_special'));//查
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			$row['special'] = $query->row_array();
		}
		
		unset($data['product_id']);
		foreach($data as $key=>$value){
			$option_ids[]=$data[$key][1];
		}
		
		$option_ids=implode('.', $option_ids);

		//$row=$option_ids;
		$this->db->select('product_option_value.quantity, product_option_value.price, product_option_value.points');
		$this->db->where('product_id', $product_id);
		$this->db->where_in('option_id', $option_ids);
		
		$this->db->from($this->db->dbprefix('product_option_value'));//查商品表
		
		$query = $this->db->get();
		if($query->num_rows() > 0){
			$row['option']=$query->row_array();
		}
		return $row;
	}
	
	//查商品分类下的商品
	public function get_products($data = array()){
		$limit=$this->config->get_config('config_limit_admin');
		
		if(isset($data['manufacturer'])){
			//品牌
			$this->db->where('product.manufacturer_id', $data['manufacturer_id']);
		}
		
		if(isset($data['category_id'])){
			//查分类
			$this->db->where('product_to_category.category_id', $data['category_id']);
			$this->db->join('product_to_category', 'product_to_category.product_id = product.product_id');//查商品描述表
				
		}
		
		$this->db->where('product_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('product_description', 'product_description.product_id = product.product_id');//查商品描述表
		if(isset($data['store_id'])){
			$this->db->where('product.store_id',$data['store_id']);
		}
		//统计记录条数
		$row['count']   =$this->db->count_all_results($this->db->dbprefix('product'));
		
		//商品基本数据
		if(isset($data['order_by']) && $data['order_by'] == 'sales'){
			
			//$this->db->select('product.product_id, (SELECT SUM(op.quantity) FROM order_product AS op WHERE op.product_id = product.product_id) AS order_sum');
			$order_status=$this->config->get_config('to_be_delivered').','.$this->config->get_config('inbound_state').','.$this->config->get_config('state_to_be_evaluated').','.$this->config->get_config('order_completion_status');
			
			$this->db->select('product.product_id, (SELECT SUM(order_product.quantity) FROM `order_product` JOIN `order` ON `order`.`order_id` = `order_product`.`order_id` WHERE `order`.`order_status_id` IN('.$order_status.') AND order_product.product_id = product.product_id) AS order_sum');
			
			$this->db->order_by('order_sum', 'DESC');
		}else{
			$this->db->select('product.product_id');
		}
		
		if(isset($data['manufacturer'])){
			//品牌
			$this->db->where('product.manufacturer_id', $data['manufacturer_id']);
		}
		if(isset($data['category_id'])){
			//查分类
			$this->db->where('product_to_category.category_id', $data['category_id']);
			$this->db->join('product_to_category', 'product_to_category.product_id = product.product_id');//查商品描述表
			
		}
		
		if(isset($data['order_by']) && $data['order_by'] == 'time'){
			$this->db->order_by('product.date_added', 'DESC');
		}
		
		if(isset($data['order_by']) && $data['order_by'] == 'RANDOM'){
			$this->db->order_by('product.date_added', 'RANDOM');
		}
		
		$this->db->where('product.status','1');
		$this->db->where('product.invalid','0');
		$this->db->where('product.date_invalid < ', date("Y-m-d H:i:s"));
		
		$this->db->where('product_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('product_description', 'product_description.product_id = product.product_id');//查商品描述表
		if(isset($data['store_id'])){
			$this->db->where('product.store_id',$data['store_id']);
		}
		
		$this->db->where('store.store_status', '0');
		$this->db->where('store.date_invalid < ', date("Y-m-d H:i:s"));
		$this->db->join('store', 'store.store_id = product.store_id');//商店状态为0并且不在查封期间
		
		if(isset($data['limit'])){
			$this->db->limit($data['limit']);
		}else{
			$this->db->limit($limit, $data['page']);
		}
		
		$this->db->from($this->db->dbprefix('product'));//查商品表
		
		//echo $this->db->get_compiled_select();
		
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
	
	public function get_option_image($product_id, $option_id=''){
		//选项图片
		$this->db->select('option_id_first, image');
		
		$this->db->where('product_id', $product_id);
		if(!empty($option_id)){
			$this->db->where('option_id_first', $option_id);
			$this->db->from($this->db->dbprefix('product_option_value_image'));//
			$query = $this->db->get();
			if($query->num_rows() > 0){
				return $query->row_array();
			}
		}else{
			$this->db->from($this->db->dbprefix('product_option_value_image'));//
			$query = $this->db->get();
			if($query->num_rows() > 0){
				return $query->result_array();
			}
		}
		
		
		return FALSE;
	}
	
	public function get_add_cart_price($product_id, $option=''){
		if(is_array($option)){
			$option=implode('.', $option);
		}
		
		//商品基本数据
		$this->db->select('price, points, tax_class_id');
		$this->db->where('product.product_id', $product_id);
		$this->db->where('product.status','1');
		$this->db->where('product.invalid','0');
		$this->db->where('product.date_invalid < ', date("Y-m-d H:i:s"));
		$this->db->from($this->db->dbprefix('product'));//查商品表
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			$product = $query->row_array();
		}else{
			return FALSE;
		}
		
		if($product){
			//查商品选项
			$this->db->select('product_option_value.price, product_option_value.points');
			$this->db->where('product_id',$product_id);
			$this->db->where('option_id',$option);
			
			$this->db->from($this->db->dbprefix('product_option_value'));//查
			$query = $this->db->get();
			
			if($query->num_rows() > 0){
				
				$row=$query->row_array();
				$product['price']=$row['price'];
				$product['points']=$row['points'];
			}
		}
		
		if($product){
			//查商品折扣
			$this->db->select('quantity, value, date_start, date_end');
			$this->db->where('product_id',$product_id);
			if($this->user->isLogged()){
				$this->db->where('user_class_id', $this->user->getUserclassId());
			}
			$this->db->from($this->db->dbprefix('product_discount'));//查商折扣
			$query = $this->db->get();
			
			if($query->num_rows() > 0){
				$product['discount'] = $query->row_array();
			}
		}
		
		if($product){
			//查优惠
			$this->db->select('quantity, price, date_start, date_end');
			$this->db->where('product_id',$product_id);
			if($this->user->isLogged()){
				$this->db->where('user_class_id', $this->user->getUserclassId());
			}
			$this->db->from($this->db->dbprefix('product_special'));//查
			$query = $this->db->get();
			
			if($query->num_rows() > 0){
				$product['special'] = $query->row_array();
			}
		}
		
		if($product){
			//查税
			$this->db->select('rate, type');
			$this->db->where('tax_class.tax_class_id',$product['tax_class_id']);
			$this->db->where('tax_class_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
			$this->db->where('tax_rate_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
			$this->db->join('tax_class_description','tax_class_description.tax_class_id = tax_class.tax_class_id');
			$this->db->join('tax_rule','tax_rule.tax_class_id = tax_class.tax_class_id');
			$this->db->join('tax_rate','tax_rate.tax_rate_id = tax_rule.tax_rate_id');
			$this->db->join('tax_rate_description','tax_rate_description.tax_rate_id = tax_rule.tax_rate_id');
			$this->db->join('tax_rate_to_user_class','tax_rate_to_user_class.tax_rate_id = tax_rule.tax_rate_id');
			$this->db->from($this->db->dbprefix('tax_class'));//查
			$query = $this->db->get();
			
			if($query->num_rows() > 0){
				$product['taxs'] = $query->row_array();
			}
		}
		return $product;
	}
}