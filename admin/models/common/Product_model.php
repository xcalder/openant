<?php
class Product_model extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	//查单个商品
	public function get_product($product_id){
		//$product = array();
		//商品基本数据
		$this->db->select('*');
		$this->db->where('product.product_id', $product_id);
		//$this->db->where('product.status','1');
		//$this->db->where('product.invalid','0');
		//$this->db->where('product.date_invalid < ', date("Y-m-d H:i:s"));
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
			$this->load->model('sale/store_model');
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
				
				$product['quantity']=array_sum(array_column($arr,'quantity'));
				
				$op_arr=array();
				foreach($option_group_ids as $key=>$value){
					$this->db->select('option_group.option_group_id, option_group.type, option_group_description.option_group_name');
					$this->db->where('option_group.option_group_id', $option_group_ids[$key]);
					$this->db->where('option_group_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
					$this->db->join('option_group_description', 'option_group_description.option_group_id = option_group.option_group_id');
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
			$this->db->select('price');
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
	public function get_products($data = array()){
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
		
		if(isset($data['limit'])){
			$this->db->limit($data['limit']);
		}else{
			$this->db->limit($this->config->get_config('config_limit_admin'), $data['page']);
		}
		
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
		
		$this->db->where('product_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('product_description', 'product_description.product_id = product.product_id');//查商品描述表
		if(isset($data['store_id'])){
			$this->db->where('product.store_id',$data['store_id']);
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
	
	
	//按条件查分类id
	public function get_categorys($offset='0')
	{
		$limit=$this->config->get_config('config_limit_admin');
		
		$categorys = array();
		//商品基本数据
		$this->db->select('category_id');
		$this->db->limit($limit, $offset);
		$this->db->where('store_id','0');
		//$this->db->where_not_in('parent_id','0');
		$this->db->order_by('category_id', 'ASC');
		$query = $this->db->get($this->db->dbprefix('category'));
		
		//统计表记录
		$this->db->where('store_id','0');
		//$this->db->where_not_in('parent_id','0');
		$row['count']=$this->db->count_all_results($this->db->dbprefix('category'));
		$this->db->reset_query();
		
		if($query->num_rows() > 0){
			$categorys = $query->result_array();
			$categorys = array_flip(array_flip(array_column($categorys,'category_id')));
			foreach ($categorys as $category) {
				$category_s[]= $this->get_category($category);
			}
			foreach($category_s as $key=>$value){
				$row['categorys'][$key]=$category_s[$key];
				if($this->get_category_for_parent_id($category_s[$key]['category_id'])){
					$row['categorys'][$key]['childs']=$this->get_category_for_parent_id($category_s[$key]['category_id']);
				}
			}
			return $row;
		}else{
			return FALSE;
		}
	}
	
	//查分类
	public function get_category($category_id)
	{
		$category = array();
		//基本数据
		$this->db->select('*');
		$this->db->where('category.category_id', $category_id);
		$this->db->where('store_id','0');
		//$this->db->where('category.status','1');
		$this->db->from($this->db->dbprefix('category'));//查
		$this->db->where('category_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('category_description', 'category_description.category_id = category.category_id');//查
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			return $query->row_array();
		}
			
		return FALSE;
	}
	
	//查分类
	public function get_category_for_parent_id($category_id)
	{
		$category = array();
		//基本数据
		$this->db->select('*');
		$this->db->where('category.parent_id', $category_id);
		$this->db->where('category.store_id','0');
		//$this->db->where('category.status','1');
		$this->db->from($this->db->dbprefix('category'));//查
		$this->db->where('category_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('category_description', 'category_description.category_id = category.category_id');//查
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			return $query->result_array();
		}
			
		return FALSE;
	}
	
	//查分类
	public function get_category_info($category_id)
	{
		$category = array();
		//基本数据
		$this->db->select('*');
		$this->db->where('category.store_id','0');
		$this->db->where('category.category_id', $category_id);
		$this->db->from($this->db->dbprefix('category'));//查
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			$row = $query->row_array();
		}
		if(isset($row)){
			$this->db->select('*');
			$this->db->where('category_id',$row['category_id']);
			$this->db->from($this->db->dbprefix('category_description'));
			$query = $this->db->get();
			
			$category_description = $query->result_array();
			//把language_id取出来，做为数组键名
			$arr=array();
			foreach($category_description as $k=>$v){
				$arr[$category_description[$k]['language_id']]=$v;
			}
			$row['category_description'] = $arr;
			
			return $row;
		}
			
		return FALSE;
	}
	
	//查分类store_id=0
	public function get_categorys_store()
	{
		$categorys = array();
		//商品基本数据
		$this->db->select('category.category_id, category.parent_id, category_description.name');
		$this->db->where('category.store_id','0');
		$this->db->where('category_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('category_description', 'category_description.category_id = category.category_id');//查
		
		$this->db->order_by('category.sort_order', 'DESC');
		$this->db->from($this->db->dbprefix('category'));//查
		
		$query = $this->db->get();
		if($query->num_rows() > 0){
			$categorys = $query->result_array();
			return $categorys;
		}else{
			return FALSE;
		}
	}
	
	//查stores
	public function get_stores()
	{
		$stores = array();
		//商品基本数据
		$this->db->select('*');
		$this->db->where('store_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('store_description', 'store_description.store_id = store.store_id');//查
		
		$this->db->from($this->db->dbprefix('store'));//查
		
		$query = $this->db->get();
		if($query->num_rows() > 0){
			$stores = $query->result_array();
			return $stores;
		}else{
			return FALSE;
		}
	}
	
	public function edit_category($data){
		$data['date_modified']=date("Y-m-d H:i:s");
		$this->db->where('category_id', $this->input->get('category_id'));
		$this->db->update($this->db->dbprefix('category'), $data['base']);
		$this->db->reset_query();
		
		$this->db->delete($this->db->dbprefix('category_description'), array('category_id' => $this->input->get('category_id')));
		$this->db->delete($this->db->dbprefix('category_option'), array('category_id' => $this->input->get('category_id')));
		
		foreach($data['category_description'] as $key=>$value){
			$data['category_description'][$key]['language_id']=$key;
			$data['category_description'][$key]['category_id']=$this->input->get('category_id');
		}
		$this->db->insert_batch($this->db->dbprefix('category_description'), $data['category_description']);
		$this->db->reset_query();
		
		//遍历选项
		if(!empty($data['attribute'])){
			foreach($data['attribute'] as $key=>$value){
				if(empty($data['attribute'][$key]['value'])){
					unset($data['attribute'][$key]);
				}else{
					$data['attribute'][$key]['type']='attribute';
					$data['attribute'][$key]['category_id']=$this->input->get('category_id');
				}
			}
			if(!empty($data['attribute']) && is_array($data['attribute'])){
				$this->db->insert_batch($this->db->dbprefix('category_option'), $data['attribute']);
			}
		}
		
		if(!empty($data['option'])){
			foreach($data['option'] as $key=>$value){
				if(empty($data['option'][$key]['value'])){
					unset($data['option'][$key]);
				}else{
					$data['option'][$key]['type']='option';
					$data['option'][$key]['category_id']=$this->input->get('category_id');
				}
			}
			if(!empty($data['option']) && is_array($data['option'])){
				$this->db->insert_batch($this->db->dbprefix('category_option'), $data['option']);
			}
		}
		
		if(!empty($data['manufacturer'])){
			foreach($data['manufacturer'] as $key=>$value){
				if(empty($data['manufacturer'][$key]['value'])){
					unset($data['manufacturer'][$key]);
				}else{
					$data['manufacturer'][$key]['type']='manufacturer';
					$data['manufacturer'][$key]['category_id']=$this->input->get('category_id');
				}
			}
			if(!empty($data['manufacturer']) && is_array($data['manufacturer'])){
				$this->db->insert_batch($this->db->dbprefix('category_option'), $data['manufacturer']);
			}
		}
		
		if(!empty($data['barcode'])){
			foreach($data['barcode'] as $key=>$value){
				if(empty($data['barcode'][$key]['value'])){
					unset($data['barcode'][$key]);
				}else{
					$data['barcode'][$key]['type']='barcode';
					$data['barcode'][$key]['category_id']=$this->input->get('category_id');
				}
			}
			if(!empty($data['barcode']) && is_array($data['barcode'])){
				$this->db->insert_batch($this->db->dbprefix('category_option'), $data['barcode']);
			}
		}
		
		if(!empty($data['stock_status'])){
			foreach($data['stock_status'] as $key=>$value){
				if(empty($data['stock_status'][$key]['value'])){
					unset($data['stock_status'][$key]);
				}else{
					$data['stock_status'][$key]['type']='stock_status';
					$data['stock_status'][$key]['category_id']=$this->input->get('category_id');
				}
			}
			if(!empty($data['stock_status']) && is_array($data['stock_status'])){
				$this->db->insert_batch($this->db->dbprefix('category_option'), $data['stock_status']);
			}
		}
		
		if(!empty($data['aftermarket'])){
			foreach($data['aftermarket'] as $key=>$value){
				if(empty($data['aftermarket'][$key]['value'])){
					unset($data['aftermarket'][$key]);
				}else{
					$data['aftermarket'][$key]['type']='aftermarket';
					$data['aftermarket'][$key]['category_id']=$this->input->get('category_id');
				}
			}
			if(!empty($data['aftermarket']) && is_array($data['aftermarket'])){
				$this->db->insert_batch($this->db->dbprefix('category_option'), $data['aftermarket']);
			}
		}
		
		if(!empty($data['tax_class'])){
			foreach($data['tax_class'] as $key=>$value){
				if(empty($data['tax_class'][$key]['value'])){
					unset($data['tax_class'][$key]);
				}else{
					$data['tax_class'][$key]['type']='tax_class';
					$data['tax_class'][$key]['category_id']=$this->input->get('category_id');
				}
			}
			if(!empty($data['tax_class']) && is_array($data['tax_class'])){
				$this->db->insert_batch($this->db->dbprefix('category_option'), $data['tax_class']);
			}
		}
		
		if(!empty($data['download'])){
			foreach($data['download'] as $key=>$value){
				if(empty($data['download'][$key]['value'])){
					unset($data['download'][$key]);
				}else{
					$data['download'][$key]['type']='download';
					$data['download'][$key]['category_id']=$this->input->get('category_id');
				}
			}
			if(!empty($data['download']) && is_array($data['download'])){
				$this->db->insert_batch($this->db->dbprefix('category_option'), $data['download']);
			}
		}
	}
	
	public function add_category($data){
		$data['base']['date_added']=date("Y-m-d H:i:s");
		$data['base']['date_modified']=date("Y-m-d H:i:s");
		$this->db->insert($this->db->dbprefix('category'), $data['base']);
		
		//取最后查入的一第分类id
		$category_id=$this->db->insert_id();
		
		foreach($data['category_description'] as $key=>$value){
			$data['category_description'][$key]['language_id']=$key;
			$data['category_description'][$key]['category_id']=$category_id;
		}
		$this->db->insert_batch($this->db->dbprefix('category_description'), $data['category_description']);
		$this->db->reset_query();
		
		//遍历选项
		if(!empty($data['attribute'])){
			foreach($data['attribute'] as $key=>$value){
				if(empty($data['attribute'][$key]['value'])){
					unset($data['attribute'][$key]);
				}else{
					$data['attribute'][$key]['type']='attribute';
					$data['attribute'][$key]['category_id']=$this->input->get('category_id');
				}
			}
			if(!empty($data['attribute']) && is_array($data['attribute'])){
				$this->db->insert_batch($this->db->dbprefix('category_option'), $data['attribute']);
			}
		}
		
		if(!empty($data['option'])){
			foreach($data['option'] as $key=>$value){
				if(empty($data['option'][$key]['value'])){
					unset($data['option'][$key]);
				}else{
					$data['option'][$key]['type']='option';
					$data['option'][$key]['category_id']=$this->input->get('category_id');
				}
			}
			if(!empty($data['option']) && is_array($data['option'])){
				$this->db->insert_batch($this->db->dbprefix('category_option'), $data['option']);
			}
		}
		
		if(!empty($data['manufacturer'])){
			foreach($data['manufacturer'] as $key=>$value){
				if(empty($data['manufacturer'][$key]['value'])){
					unset($data['manufacturer'][$key]);
				}else{
					$data['manufacturer'][$key]['type']='manufacturer';
					$data['manufacturer'][$key]['category_id']=$this->input->get('category_id');
				}
			}
			if(!empty($data['manufacturer']) && is_array($data['manufacturer'])){
				$this->db->insert_batch($this->db->dbprefix('category_option'), $data['manufacturer']);
			}
		}
		
		if(!empty($data['barcode'])){
			foreach($data['barcode'] as $key=>$value){
				if(empty($data['barcode'][$key]['value'])){
					unset($data['barcode'][$key]);
				}else{
					$data['barcode'][$key]['type']='barcode';
					$data['barcode'][$key]['category_id']=$this->input->get('category_id');
				}
			}
			if(!empty($data['barcode']) && is_array($data['barcode'])){
				$this->db->insert_batch($this->db->dbprefix('category_option'), $data['barcode']);
			}
		}
		
		if(!empty($data['stock_status'])){
			foreach($data['stock_status'] as $key=>$value){
				if(empty($data['stock_status'][$key]['value'])){
					unset($data['stock_status'][$key]);
				}else{
					$data['stock_status'][$key]['type']='stock_status';
					$data['stock_status'][$key]['category_id']=$this->input->get('category_id');
				}
			}
			if(!empty($data['stock_status']) && is_array($data['stock_status'])){
				$this->db->insert_batch($this->db->dbprefix('category_option'), $data['stock_status']);
			}
		}
		
		if(!empty($data['aftermarket'])){
			foreach($data['aftermarket'] as $key=>$value){
				if(empty($data['aftermarket'][$key]['value'])){
					unset($data['aftermarket'][$key]);
				}else{
					$data['aftermarket'][$key]['type']='aftermarket';
					$data['aftermarket'][$key]['category_id']=$this->input->get('category_id');
				}
			}
			if(!empty($data['aftermarket']) && is_array($data['aftermarket'])){
				$this->db->insert_batch($this->db->dbprefix('category_option'), $data['aftermarket']);
			}
		}
		
		if(!empty($data['tax_class'])){
			foreach($data['tax_class'] as $key=>$value){
				if(empty($data['tax_class'][$key]['value'])){
					unset($data['tax_class'][$key]);
				}else{
					$data['tax_class'][$key]['type']='tax_class';
					$data['tax_class'][$key]['category_id']=$this->input->get('category_id');
				}
			}
			if(!empty($data['tax_class']) && is_array($data['tax_class'])){
				$this->db->insert_batch($this->db->dbprefix('category_option'), $data['tax_class']);
			}
		}
		
		if(!empty($data['download'])){
			foreach($data['download'] as $key=>$value){
				if(empty($data['download'][$key]['value'])){
					unset($data['download'][$key]);
				}else{
					$data['download'][$key]['type']='download';
					$data['download'][$key]['category_id']=$this->input->get('category_id');
				}
			}
			if(!empty($data['download']) && is_array($data['download'])){
				$this->db->insert_batch($this->db->dbprefix('category_option'), $data['download']);
			}
		}
	}
	
	public function get_product_to_category_for_category_id($category_id=''){
		if($category_id = ''){
			return FALSE;
		}
		$this->db->where('category_id',$category_id);
		$this->db->from($this->db->dbprefix('product_to_category'));
		
		$query=$this->db->get();
		if($query->num_rows() > 0){
			return $query->result_array();
		}
		return FALSE;
	}
	
	//删除分类
	public function delete_category($data){
		foreach($data as $key=>$value){
			$this->db->delete($this->db->dbprefix('category'), array('category_id' => $data[$key]));
			$this->db->delete($this->db->dbprefix('category_description'), array('category_id' => $data[$key]));
			$this->db->delete($this->db->dbprefix('category_option'), array('category_id' => $data[$key]));
		}
	}
	
	//屏蔽商品
	public function invalid($product_id,$data){
		$this->db->where('product_id', $product_id);
		$this->db->update($this->db->dbprefix('product'), $data);
	}
	
	//查category_option
	public function get_category_options($category_id){
		$this->db->where('category_id', $category_id);
		$this->db->from($this->db->dbprefix('category_option'));
		
		$query=$this->db->get();
		if($query->num_rows() > 0){
			return $query->result_array();
		}
		return FALSE;
	}
}