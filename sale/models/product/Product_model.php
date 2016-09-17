<?php
class Product_model extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('file');
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
			$this->load->model('store/store_model');
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
	
	//查单个商品
	public function get_product_to_form($product_id)
	{
		$product = array();
		//商品基本数据
		$this->db->select('*');
		$this->db->where('product.store_id', $this->user->getStore_id());
		$this->db->where('product.product_id', $product_id);
		$this->db->from($this->db->dbprefix('product'));//查商品表
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			$product = $query->row_array();
		}else{
			return FALSE;
		}
		
		if($product){
			//查描述
			//$this->db->where('language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
			$this->db->where('product_id', $product['product_id']);//查商品描述表
			$this->db->from('product_description');
			$query=$this->db->get();
			if($query->num_rows() > 0){
				$descriptions=$query->result_array();
				foreach($descriptions as $key=>$value){
					$description[$descriptions[$key]['language_id']]=$descriptions[$key];
				}
				unset($descriptions);
				$product['description']=$description;
			}
		}
		
		if($product){
			//查附加主图
			$this->db->select('image');
			$this->db->where('product_id',$product['product_id']);
			$this->db->order_by('sort_order', 'ASC');
			$this->db->from($this->db->dbprefix('product_image'));//查商折扣
			$query = $this->db->get();
			
			if($query->num_rows() > 0){
				$product['images'] = $query->result_array();
			}
		}
		
		if($product){
			//查商品折扣
			$this->db->select('*');
			$this->db->where('product_id',$product['product_id']);
			$this->db->from($this->db->dbprefix('product_discount'));//查商折扣
			$query = $this->db->get();
			
			if($query->num_rows() > 0){
				$product['discount'] = $query->result_array();
			}
		}

		if($product){
			//查商品选项
			$this->db->select('*');
			$this->db->where('product_id',$product['product_id']);
			$this->db->from($this->db->dbprefix('product_option_value'));//查商口选项
			$query = $this->db->get();
			if($query->num_rows() > 0){
				$row=$query->result_array();
				foreach($row as $key=>$value){
					if(isset($row[$key]['option_group_id']) && !empty($row[$key]['option_group_id'])){
						$option_group_id=explode('.', $row[$key]['option_group_id']);
						unset($row[$key]['option_group_id']);
					}
					if(isset($row[$key]['option_id']) && !empty($row[$key]['option_id'])){
						//查分类图片
						$this->db->select('option_id_first, image');
						$this->db->where('product_id',$product['product_id']);
						$this->db->where('option_id',$row[$key]['option_id']);
						$this->db->from($this->db->dbprefix('product_option_value_image'));//
						$query = $this->db->get();
						if($query->num_rows() > 0){
							$image=$query->row_array();
						}
						
						$option_id=explode('.', $row[$key]['option_id']);
						unset($row[$key]['option_id']);
					}
					foreach($option_id as $k=>$v){
						$row[$key]['child'][$k]['option_id']=$option_id[$k];
						$row[$key]['child'][$k]['option_group_id']=$option_group_id[$k];
						
						if(isset($image) && $image['option_id_first'] == $option_id[$k]){
							$row[$key]['child'][$k]['image']=$image['image'];
						}
						
					}
				}
				if(!empty($row)){
					$product['options'] = $row;
				}
			}
		}
		
		if($product){
			//查商品属性
			$this->db->select('*');
			$this->db->where('product_id',$product['product_id']);
			$this->db->from($this->db->dbprefix('product_attribute'));//查商口选项
			$query = $this->db->get();
			
			if($query->num_rows() > 0){
				$attributes = $query->result_array();
				$row=array();
				foreach($attributes as $key=>$value){
					if(!empty($attributes[$key]['language_id'])){
						$row[$attributes[$key]['language_id']][]=$attributes[$key];
					}
				}
				if(!empty($row)){
					$product['attributes'] = $row;
				}
			}
		}
		
		if($product){
			//查销售order_product
			$this->db->select('*');
			$this->db->where('product_id',$product['product_id']);
			$this->db->from($this->db->dbprefix('order_product'));//查商口选项
			$query = $this->db->get();
			
			if($query->num_rows() > 0){
				$product['order_product'] = $query->result_array();
			}
		}

		if($product){
			//查优惠
			$this->db->select('*');
			$this->db->where('product_id',$product['product_id']);
			$this->db->from($this->db->dbprefix('product_special'));//查
			$query = $this->db->get();
			
			if($query->num_rows() > 0){
				$product['special'] = $query->result_array();
			}
		}
		
		if($product){
			//查分类
			$this->db->select('category_id');
			$this->db->where('product_id',$product['product_id']);
			$this->db->from($this->db->dbprefix('product_to_category'));//查
			$query = $this->db->get();
			
			if($query->num_rows() > 0){
				$product['category'] = $query->row_array();
			}
		}
		
		if($product){
			//售后
			$this->db->where('product_id',$product['product_id']);
			$this->db->from($this->db->dbprefix('product_aftermarket'));//查
			$query = $this->db->get();
			
			if($query->num_rows() > 0){
				$product['aftermarkets'] = $query->result_array();
			}
		}
		
		if($product){
			//条码
			$this->db->where('product_id',$product['product_id']);
			$this->db->from($this->db->dbprefix('product_barcode'));//查
			$query = $this->db->get();
			
			if($query->num_rows() > 0){
				$product['barcodes'] = $query->result_array();
			}
		}
		
		if($product){
			//下载
			$this->db->where('product_id',$product['product_id']);
			$this->db->from($this->db->dbprefix('product_download'));//查
			$query = $this->db->get();
			
			if($query->num_rows() > 0){
				$product['downloads'] = $query->result_array();
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
		
		if(isset($data['status'])){
			$this->db->where('product.status', $data['status']);
		}
		
		if(isset($data['invalid'])){
			$this->db->where('product.invalid', $data['invalid']);
		}
		
		if(isset($data['time'])){
			$this->db->where('product.date_invalid > ', date("Y-m-d H:i:s"));
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
		
		if(isset($data['status'])){
			$this->db->where('product.status', $data['status']);
			$this->db->where('product.invalid', '0');
			$this->db->where('product.date_invalid < ', date("Y-m-d H:i:s"));
		}
		
		if(isset($data['invalid'])){
			$this->db->where('product.invalid', $data['invalid']);
		}
		
		if(isset($data['time'])){
			$this->db->where('product.date_invalid > ', date("Y-m-d H:i:s"));
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
		$this->db->where('product.store_id',$this->user->getStore_id());
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
		$this->db->where('category.store_id', $this->user->getStore_id());
		$this->db->order_by('category.sort_order', 'DESC');
		//$this->db->from($this->db->dbprefix('category'));//查
		$query = $this->db->get($this->db->dbprefix('category'), FALSE);
		
		//统计表记录
		$this->db->where('category.store_id', $this->user->getStore_id());
		$category_s['count']=$this->db->count_all_results($this->db->dbprefix('category'));
		
		if($query->num_rows() > 0){
			$categorys = $query->result_array();
			$categorys = array_flip(array_flip(array_column($categorys,'category_id')));
			foreach ($categorys as $category) {
				$category_s['categorys'][] = $this->get_category($category);
			}
			
			return $category_s;
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
		$this->db->where('category.store_id', $this->user->getStore_id());
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
	public function get_category_info($category_id)
	{
		$category = array();
		//基本数据
		$this->db->select('*');
		$this->db->where('category.store_id', $this->user->getStore_id());
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
		$this->db->select('category.category_id,category_description.name');
		$this->db->where('category.store_id', $this->user->getStore_id());
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
		$data['base']['date_modified']=date("Y-m-d H:i:s");
		$data['base']['store_id']=$this->user->getStore_id();
		$this->db->where('category_id', $this->input->get('category_id'));
		$this->db->update($this->db->dbprefix('category'), $data['base']);
		$this->db->reset_query();
		
		$this->db->delete($this->db->dbprefix('category_description'), array('category_id' => $this->input->get('category_id')));
		$this->db->reset_query();
		
		foreach($data['category_description'] as $key=>$value){
			$data['category_description'][$key]['language_id']=$key;
			$data['category_description'][$key]['category_id']=$this->input->get('category_id');
		}
		$this->db->insert_batch($this->db->dbprefix('category_description'), $data['category_description']);
		$this->db->reset_query();
	}
	
	public function add_category($data){
		$data['base']['date_added']=date("Y-m-d H:i:s");
		$data['base']['date_modified']=date("Y-m-d H:i:s");
		$data['base']['store_id']=$this->user->getStore_id();
		$this->db->insert($this->db->dbprefix('category'), $data['base']);
		
		//取最后查入的一第分类id
		$category_id=$this->db->insert_id();
		$this->db->reset_query();
		
		foreach($data['category_description'] as $key=>$value){
			$data['category_description'][$key]['language_id']=$key;
			$data['category_description'][$key]['category_id']=$category_id;
		}
		$this->db->insert_batch($this->db->dbprefix('category_description'), $data['category_description']);
		$this->db->reset_query();
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
		}
	}
	
	//商品上架
	public function added($data){
		if(empty($data)){
			return FALSE;
		}
		if(is_array($data)){
			foreach($data as $key=>$value){
				$status[$key]['status']='1';
				$status[$key]['product_id']=$value;
			}
			$this->db->update_batch($this->db->dbprefix('product'), $status, 'product_id');
			return TRUE;
		}
		
		$status['status']='1';
		$this->db->where('product_id', $data);
		$this->db->update($this->db->dbprefix('product'), $status);
		return TRUE;
	}
	
	//商品下架
	public function shelves($data){
		if(empty($data)){
			return FALSE;
		}
		if(is_array($data)){
			foreach($data as $key=>$value){
				$status[$key]['status']='0';
				$status[$key]['product_id']=$value;
			}
			$this->db->update_batch($this->db->dbprefix('product'), $status, 'product_id');
			return TRUE;
		}
		
		$status['status']='0';
		$this->db->where('product_id', $data);
		$this->db->update($this->db->dbprefix('product'), $status);
		return TRUE;
	}
	
	//删除商品
	public function delete_product($data){
		if(empty($data)){
			return FALSE;
		}
		
		if(is_array($data)){
			foreach($data as $key=>$value){
				$this->db->trans_start();
				$this->db->delete($this->db->dbprefix('product'), array('product_id' => $data[$key], 'store_id' => $this->user->getStore_id()));
				$this->db->delete($this->db->dbprefix('product_description'), array('product_id' => $data[$key]));
				$this->db->delete($this->db->dbprefix('product_attribute'), array('product_id' => $data[$key]));
				$this->db->delete($this->db->dbprefix('product_barcode'), array('product_id' => $data[$key]));
				$this->db->delete($this->db->dbprefix('product_discount'), array('product_id' => $data[$key]));
				$this->db->delete($this->db->dbprefix('product_download'), array('product_id' => $data[$key]));
				$this->db->delete($this->db->dbprefix('product_image'), array('product_id' => $data[$key]));
				$this->db->delete($this->db->dbprefix('product_review'), array('product_id' => $data[$key]));
				$this->db->delete($this->db->dbprefix('product_special'), array('product_id' => $data[$key]));
				$this->db->delete($this->db->dbprefix('product_to_category'), array('product_id' => $data[$key]));
				$this->db->delete($this->db->dbprefix('product_to_layout'), array('product_id' => $data[$key]));
				$this->db->trans_complete();
				
			}
			return TRUE;
		}
		
		$this->db->trans_start();
		$this->db->delete($this->db->dbprefix('product'), array('product_id' => $data, 'store_id' => $this->user->getStore_id()));
		$this->db->delete($this->db->dbprefix('product_description'), array('product_id' => $data));
		$this->db->delete($this->db->dbprefix('product_aftermarket'), array('product_id' => $data));
		$this->db->delete($this->db->dbprefix('product_attribute'), array('product_id' => $data));
		$this->db->delete($this->db->dbprefix('product_barcode'), array('product_id' => $data));
		$this->db->delete($this->db->dbprefix('product_discount'), array('product_id' => $data));
		$this->db->delete($this->db->dbprefix('product_download'), array('product_id' => $data));
		$this->db->delete($this->db->dbprefix('product_image'), array('product_id' => $data));
		$this->db->delete($this->db->dbprefix('product_option_value'), array('product_id' => $data));
		$this->db->delete($this->db->dbprefix('product_review'), array('product_id' => $data));
		$this->db->delete($this->db->dbprefix('product_special'), array('product_id' => $data));
		$this->db->delete($this->db->dbprefix('product_to_category'), array('product_id' => $data));
		$this->db->delete($this->db->dbprefix('product_to_layout'), array('product_id' => $data));
		$this->db->trans_complete();
		return TRUE;
	}
	
	//取一级分类给商品添加
	public function get_parent_categorys(){
		$this->db->select('category_description.category_id, category_description.name');
		$this->db->where('category.parent_id', '0');
		$this->db->where('category.store_id', '0');
		$this->db->where('category.status', '1');
		$this->db->order_by('category.sort_order', 'ASC');
		$this->db->where('category_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('category_description', 'category_description.category_id = category.category_id');//查
		$this->db->from($this->db->dbprefix('category'));
		$query=$this->db->get();
		if($query->num_rows() > 0){
			return $query->result_array();
		}
		
		return FALSE;
	}
	
	//取一级分类给商品添加
	public function get_child_categorys($parent_id){
		$this->db->select('category_description.category_id, category_description.name');
		$this->db->where('category.parent_id', $parent_id);
		$this->db->where('category.store_id', '0');
		$this->db->where('category.status', '1');
		$this->db->order_by('category.sort_order', 'ASC');
		$this->db->where('category_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('category_description', 'category_description.category_id = category.category_id');//查
		$this->db->from($this->db->dbprefix('category'));
		$query=$this->db->get();
		if($query->num_rows() > 0){
			return $query->result_array();
		}
		
		return FALSE;
	}
	
	//取一级分类给商品添加
	public function get_last_add(){
		$this->db->select('child_id, parent_id');
		$this->db->where('store_id', $this->user->getStore_id());
		$this->db->order_by('date_added', 'ASC');
		$this->db->from($this->db->dbprefix('product_to_category'));
		$query=$this->db->get();
		if($query->num_rows() > 0){
			return $query->row_array();
		}
		
		return FALSE;
	}
	
	//取category_option
	public function get_category_options($category_id, $type){
		$this->db->select('value, required');
		$this->db->where('category_id', $category_id);
		$this->db->where('type', $type);
		$this->db->order_by('value');
		$this->db->from($this->db->dbprefix('category_option'));
		$query=$this->db->get();
		if($query->num_rows() > 0){
			return $query->result_array();
		}
		
		return FALSE;
	}
	
	public function add_product($data){
		$this->db->trans_start();
		
		$data['base']['date_added']=date("Y-m-d H:i:s");
		$data['base']['store_id']=$this->user->getStore_id();
		if($data['base']['added'] == 'now'){
			$data['base']['status']='1';
		}
		unset($data['base']['added']);
		$bases=$data['base'];
		$this->db->insert($this->db->dbprefix('product'), $bases);
		$product_id=$this->db->insert_id();
		$this->db->reset_query();
		
		//
		foreach($data['description'] as $key=>$value){
			$data['description'][$key]['language_id']=$key;
			$data['description'][$key]['product_id']=$product_id;
		}
		$descriptions=$data['description'];
		$this->db->insert_batch($this->db->dbprefix('product_description'), $descriptions);
		$this->db->reset_query();
		
		//
		if(isset($data['image'])){
			foreach($data['image'] as $key=>$value){
				$data['image'][$key]['product_id']=$product_id;
				$data['image'][$key]['sort_order']=$key;
			}
			$images=$data['image'];
			$this->db->insert_batch($this->db->dbprefix('product_image'), $images);
			$this->db->reset_query();
		}
		
		//
		if(isset($data['special'])){
			$this->db->reset_query();
			foreach($data['special'] as $key=>$value){
				$data['special'][$key]['product_id']=$product_id;
			}
			$this->db->insert_batch($this->db->dbprefix('product_special'), $data['special']);
			$this->db->reset_query();
		}
		
		
		//
		if(isset($data['discount'])){
			foreach($data['discount'] as $key=>$value){
				$data['discount'][$key]['product_id']=$product_id;
			}
			$discounts=$data['discount'];
			$this->db->insert_batch($this->db->dbprefix('product_discount'), $discounts);
			$this->db->reset_query();
		}
		
		//
		if(isset($data['barcode'])){
			foreach($data['barcode'] as $key=>$value){
				$data['barcode'][$key]['product_id']=$product_id;
			}
			$barcodes=$data['barcode'];
			$this->db->insert_batch($this->db->dbprefix('product_barcode'), $barcodes);
		}
		
		//
		if(isset($data['aftermarket'])){
			foreach($data['aftermarket'] as $key=>$value){
				$data['aftermarket'][$key]['product_id']=$product_id;
			}
			$aftermarkets=$data['aftermarket'];
			$this->db->insert_batch($this->db->dbprefix('product_aftermarket'), $aftermarkets);
		}
		
		//
		if(isset($data['download'])){//var_dump($data['download']);
			foreach($data['download'] as $key=>$value){
				$data['download'][$key]['product_id']=$product_id;
				if(!isset($data['download'][$key]['filename'])){
					unset($data['download'][$key]);
				}elseif(isset($data['download'][$key]['cache_file']) && file_exists(FCPATH.$data['download'][$key]['cache_file'])){
					copy(FCPATH.$data['download'][$key]['cache_file'],FCPATH.$data['download'][$key]['filename']); //拷贝到新目录
					unlink(FCPATH.$data['download'][$key]['cache_file']); //删除旧目录下的文件
					unset($data['download'][$key]['cache_file']);
				}else{
					unset($data['download'][$key]['cache_file']);
				}
			}
		}
		//
		if(!empty($data['download']) && count($data['download']) > 0){
			//
			$this->db->insert_batch($this->db->dbprefix('product_download'), $data['download']);
		}
		
		//
		$data['category']['product_id']=$product_id;
		$data['category']['date_added']=date("Y-m-d H:i:s");
		$categorys=$data['category'];
		$this->db->insert($this->db->dbprefix('product_to_category'), $categorys);
		
		//
		if(isset($data['attribute'])){
			foreach($data['attribute'] as $key=>$value){
				foreach($data['attribute'][$key] as $c=>$b){
					foreach($data['attribute'][$key][$c] as $u=>$j){
						$data['attribute'][$key][$c][$u]['product_id']=$product_id;
						$data['attribute'][$key][$c][$u]['language_id']=$key;
						if(isset($data['attribute'][$key][$c][$u]['text']) && stripos($data['attribute'][$key][$c][$u]['text'], '-.-.--.-.--.-??.--.-.--.-.-')){
							$bb_text=explode('-.-.--.-.--.-??.--.-.--.-.-',$data['attribute'][$key][$c][$u]['text']);
							$data['attribute'][$key][$c][$u]['attribute_id']=$bb_text[0];
							$data['attribute'][$key][$c][$u]['text']=$bb_text[1];
						}
						if(!isset($data['attribute'][$key][$c][$u]['image'])){
							$data['attribute'][$key][$c][$u]['image']='';
						}
						if(!isset($data['attribute'][$key][$c][$u]['text'])){
							$data['attribute'][$key][$c][$u]['text']='';
						}
					}
					$this->db->insert_batch($this->db->dbprefix('product_attribute'), $data['attribute'][$key][$c]);
				}
			}
		}
		
		if(isset($data['options'])){
			foreach($data['options'] as $key=>$value){
				$option_group_id=array();
				$option_id=array();
				foreach($data['options'][$key]['child'] as $k=>$v){
					$option_id[] = $data['options'][$key]['child'][$k]['option_id'];
					$option_group_id[] = $data['options'][$key]['child'][$k]['option_group_id'];
					
					if(isset($data['options'][$key]['child'][$k]['image'])){
						$option_img[$key]['image']=$data['options'][$key]['child'][$k]['image'];
						$option_img[$key]['option_id_first']=$data['options'][$key]['child'][$k]['option_id'];
					}
				}
				unset($data['options'][$key]['child']);
				$option_id=implode('.', $option_id);
				$data['options'][$key]['option_id']=$option_id;
				$data['options'][$key]['option_group_id']=implode('.', $option_group_id);
				$data['options'][$key]['product_id']=$this->input->get('product_id');
				
				$option_img[$key]['option_id']=$option_id;
				$option_img[$key]['product_id']=$this->input->get('product_id');
			}
			$this->db->insert_batch($this->db->dbprefix('product_option_value'), $data['options']);
			$this->db->insert_batch($this->db->dbprefix('product_option_value_image'), $option_img);
		}
			
		$this->db->trans_complete();
	}
	
	
	public function edit_product($data){
		
		$this->db->trans_start();
		
		$data['base']['date_added']=date("Y-m-d H:i:s");
		if($data['base']['added'] == 'now'){
			$data['base']['status']='1';
		}
		unset($data['base']['added']);
		$bases=$data['base'];
		$this->db->where('product_id', $this->input->get('product_id'));
		$this->db->update($this->db->dbprefix('product'), $bases);
		$this->db->reset_query();
		
		//
		$this->db->delete($this->db->dbprefix('product_description'), array('product_id' => $this->input->get('product_id')));
		$this->db->reset_query();
		foreach($data['description'] as $key=>$value){
			$data['description'][$key]['language_id']=$key;
			$data['description'][$key]['product_id']=$this->input->get('product_id');
		}
		$descriptions=$data['description'];
		$this->db->insert_batch($this->db->dbprefix('product_description'), $descriptions);
		$this->db->reset_query();
		
		//
		$this->db->delete($this->db->dbprefix('product_image'), array('product_id' => $this->input->get('product_id')));
		$this->db->reset_query();
		if(isset($data['image'])){
			foreach($data['image'] as $key=>$value){
				$data['image'][$key]['product_id']=$this->input->get('product_id');
				$data['image'][$key]['sort_order']=$key;
			}
			$images=$data['image'];
			$this->db->insert_batch($this->db->dbprefix('product_image'), $images);
			$this->db->reset_query();
		}
		
		//
		$this->db->delete($this->db->dbprefix('product_special'), array('product_id' => $this->input->get('product_id')));
		if(isset($data['special'])){
			$this->db->reset_query();
			foreach($data['special'] as $key=>$value){
				$data['special'][$key]['product_id']=$this->input->get('product_id');
			}
			$this->db->insert_batch($this->db->dbprefix('product_special'), $data['special']);
			$this->db->reset_query();
		}
		
		
		//
		$this->db->delete($this->db->dbprefix('product_discount'), array('product_id' => $this->input->get('product_id')));
		if(isset($data['discount'])){
			foreach($data['discount'] as $key=>$value){
				$data['discount'][$key]['product_id']=$this->input->get('product_id');
			}
			$discounts=$data['discount'];
			$this->db->insert_batch($this->db->dbprefix('product_discount'), $discounts);
			$this->db->reset_query();
		}
		
		//
		$this->db->delete($this->db->dbprefix('product_barcode'), array('product_id' => $this->input->get('product_id')));
		if(isset($data['barcode'])){
			foreach($data['barcode'] as $key=>$value){
				$data['barcode'][$key]['product_id']=$this->input->get('product_id');
			}
			$barcodes=$data['barcode'];
			$this->db->insert_batch($this->db->dbprefix('product_barcode'), $barcodes);
			$this->db->reset_query();
		}
		
		//
		$this->db->delete($this->db->dbprefix('product_aftermarket'), array('product_id' => $this->input->get('product_id')));
		if(isset($data['aftermarket'])){
			foreach($data['aftermarket'] as $key=>$value){
				$data['aftermarket'][$key]['product_id']=$this->input->get('product_id');
			}
			$aftermarkets=$data['aftermarket'];
			$this->db->insert_batch($this->db->dbprefix('product_aftermarket'), $aftermarkets);
			$this->db->reset_query();
		}
		
		//
		if(isset($data['download'])){//var_dump($data['download']);
			foreach($data['download'] as $key=>$value){
				$data['download'][$key]['product_id']=$this->input->get('product_id');
				if(!isset($data['download'][$key]['filename'])){
					unset($data['download'][$key]);
				}elseif(isset($data['download'][$key]['cache_file']) && file_exists(FCPATH.$data['download'][$key]['cache_file'])){
					copy(FCPATH.$data['download'][$key]['cache_file'],FCPATH.$data['download'][$key]['filename']); //拷贝到新目录
					unlink(FCPATH.$data['download'][$key]['cache_file']); //删除旧目录下的文件
					unset($data['download'][$key]['cache_file']);
				}
			}
		}
		//
		if(!empty($data['download']) && count($data['download']) > 0){
			//
			$this->db->delete($this->db->dbprefix('product_download'), array('product_id' => $this->input->get('product_id')));
			$this->db->insert_batch($this->db->dbprefix('product_download'), $data['download']);
			$this->db->reset_query();
		}
		
		//
		$this->db->delete($this->db->dbprefix('product_to_category'), array('product_id' => $this->input->get('product_id')));
		$data['category']['product_id']=$this->input->get('product_id');
		$categorys=$data['category'];
		$this->db->insert($this->db->dbprefix('product_to_category'), $categorys);
		
		//
		$this->db->delete($this->db->dbprefix('product_attribute'), array('product_id' => $this->input->get('product_id')));
		if(isset($data['attribute'])){
			foreach($data['attribute'] as $key=>$value){
				foreach($data['attribute'][$key] as $c=>$b){
					foreach($data['attribute'][$key][$c] as $u=>$j){
						$data['attribute'][$key][$c][$u]['product_id']=$this->input->get('product_id');
						$data['attribute'][$key][$c][$u]['language_id']=$key;
						if(isset($data['attribute'][$key][$c][$u]['text']) && stripos($data['attribute'][$key][$c][$u]['text'], '-.-.--.-.--.-??.--.-.--.-.-')){
							$bb_text=explode('-.-.--.-.--.-??.--.-.--.-.-',$data['attribute'][$key][$c][$u]['text']);
							$data['attribute'][$key][$c][$u]['attribute_id']=$bb_text[0];
							$data['attribute'][$key][$c][$u]['text']=$bb_text[1];
						}
						if(!isset($data['attribute'][$key][$c][$u]['image'])){
							$data['attribute'][$key][$c][$u]['image']='';
						}
						if(!isset($data['attribute'][$key][$c][$u]['text'])){
							$data['attribute'][$key][$c][$u]['text']='';
						}
					}
					$this->db->insert_batch($this->db->dbprefix('product_attribute'), $data['attribute'][$key][$c]);
					$this->db->reset_query();
				}
			}
		}
		
		$this->db->delete($this->db->dbprefix('product_option_value'), array('product_id' => $this->input->get('product_id')));
		$this->db->delete($this->db->dbprefix('product_option_value_image'), array('product_id' => $this->input->get('product_id')));

		if(isset($data['options'])){
			foreach($data['options'] as $key=>$value){
				$option_group_id=array();
				$option_id=array();
				foreach($data['options'][$key]['child'] as $k=>$v){
					$option_id[] = $data['options'][$key]['child'][$k]['option_id'];
					$option_group_id[] = $data['options'][$key]['child'][$k]['option_group_id'];
					
					if(isset($data['options'][$key]['child'][$k]['image'])){
						$option_img[$key]['image']=$data['options'][$key]['child'][$k]['image'];
						$option_img[$key]['option_id_first']=$data['options'][$key]['child'][$k]['option_id'];
					}
				}
				unset($data['options'][$key]['child']);
				$option_id=implode('.', $option_id);
				$data['options'][$key]['option_id']=$option_id;
				$data['options'][$key]['option_group_id']=implode('.', $option_group_id);
				$data['options'][$key]['product_id']=$this->input->get('product_id');
				
				$option_img[$key]['option_id']=$option_id;
				$option_img[$key]['product_id']=$this->input->get('product_id');
			}
			$this->db->insert_batch($this->db->dbprefix('product_option_value'), $data['options']);
			$this->db->insert_batch($this->db->dbprefix('product_option_value_image'), $option_img);
		}
		
		$this->db->trans_complete();
	}
	
	//统计商品按在线状态分组
	public function total_products(){
		//所有商品
		$this->db->where('store_id', $this->user->getStore_id());
		$data['count_all']=$this->db->count_all_results($this->db->dbprefix('product'));
		
		//出售中商品
		$this->db->where('store_id', $this->user->getStore_id());
		$this->db->where("status", '1');
		$this->db->where("invalid", '0');
		$this->db->where('date_invalid < ', date("Y-m-d H:i:s"));
		$data['count_status']=$this->db->count_all_results($this->db->dbprefix('product'));
		
		//永久屏蔽商品
		$this->db->where('store_id', $this->user->getStore_id());
		$this->db->where("invalid", '1');
		$data['count_invalid']=$this->db->count_all_results($this->db->dbprefix('product'));
		
		//处罚商品
		$this->db->where('store_id', $this->user->getStore_id());
		$this->db->where('date_invalid > ', date("Y-m-d H:i:s"));
		$data['count_time']=$this->db->count_all_results($this->db->dbprefix('product'));
		
		return $data;
	}
}