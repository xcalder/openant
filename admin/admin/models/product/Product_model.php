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
		$this->db->where('p.product_id', $product_id);
		$this->db->from($this->db->dbprefix('product') . ' AS p');//查商品表
		$this->db->where('pd.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		
		$this->db->join('product_description AS pd', 'pd.product_id = p.product_id');//查商品描述表
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			$product = $query->row_array();
		}else{
			return FALSE;
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
			$this->db->join('order AS o','o.order_id = op.order_id');
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
		if(isset($data['manufacturer'])){
			//品牌
			$this->db->where('p.manufacturer_id', $data['manufacturer_id']);
		}
		
		if(isset($data['category_id'])){
			//查分类
			$this->db->where('ptc.category_id', $data['category_id']);
			$this->db->join('product_to_category AS ptc', 'ptc.product_id = p.product_id');//查商品描述表
				
		}
		
		$this->db->where('pd.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('product_description AS pd', 'pd.product_id = p.product_id');//查商品描述表
		if(isset($data['store_id'])){
			$this->db->where('p.store_id',$data['store_id']);
		}
		//统计记录条数
		$row['count']   =$this->db->count_all_results($this->db->dbprefix('product') . ' AS p');
		
		if(isset($data['limit'])){
			$this->db->limit($data['limit']);
		}else{
			$this->db->limit($this->config->get_config('config_limit_admin'), $data['page']);
		}
		
		//商品基本数据
		if(isset($data['order_by']) && $data['order_by'] == 'sales'){
			
			$order_status=$this->config->get_config('to_be_delivered').','.$this->config->get_config('inbound_state').','.$this->config->get_config('state_to_be_evaluated').','.$this->config->get_config('order_completion_status');
			
			$this->db->select('p.product_id, (SELECT SUM(op.quantity) FROM `order_product` AS `op` JOIN `'.$this->db->dbprefix('order').'` AS o ON `o`.`order_id` = `op`.`order_id` WHERE `o`.`order_status_id` IN('.$order_status.') AND op.product_id = p.product_id) AS order_sum');
			
			$this->db->order_by('order_sum', 'DESC');
		}else{
			$this->db->select('p.product_id');
		}
		
		if(isset($data['manufacturer'])){
			//品牌
			$this->db->where('p.manufacturer_id', $data['manufacturer_id']);
		}
		if(isset($data['category_id'])){
			//查分类
			$this->db->where('ptc.category_id', $data['category_id']);
			$this->db->join('product_to_category AS ptc', 'ptc.product_id = p.product_id');//查商品描述表
			
		}
		
		if(isset($data['order_by']) && $data['order_by'] == 'time'){
			$this->db->order_by('p.date_added', 'DESC');
		}
		
		if(isset($data['order_by']) && $data['order_by'] == 'RANDOM'){
			$this->db->order_by('p.date_added', 'RANDOM');
		}
		
		$this->db->where('pd.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('product_description AS pd', 'pd.product_id = p.product_id');//查商品描述表
		if(isset($data['store_id'])){
			$this->db->where('p.store_id',$data['store_id']);
		}
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
		$this->db->where('c.category_id', $category_id);
		$this->db->where('store_id','0');
		//$this->db->where('c.status','1');
		$this->db->from($this->db->dbprefix('category') . ' AS c');//查
		$this->db->where('cd.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('category_description AS cd', 'cd.category_id = c.category_id');//查
		
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
		$this->db->where('c.parent_id', $category_id);
		$this->db->where('c.store_id','0');
		//$this->db->where('c.status','1');
		$this->db->from($this->db->dbprefix('category') . ' AS c');//查
		$this->db->where('cd.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('category_description AS cd', 'cd.category_id = c.category_id');//查
		
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
		$this->db->where('c.store_id','0');
		$this->db->where('c.category_id', $category_id);
		$this->db->from($this->db->dbprefix('category') . ' AS c');//查
		
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
		$this->db->select('c.category_id, c.parent_id, cd.name');
		$this->db->where('c.store_id','0');
		$this->db->where('cd.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('category_description AS cd', 'cd.category_id = c.category_id');//查
		
		$this->db->order_by('c.sort_order', 'DESC');
		$this->db->from($this->db->dbprefix('category') . ' AS c');//查
		
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
		$this->db->where('sd.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('store_description AS sd', 'sd.store_id = s.store_id');//查
		
		$this->db->from($this->db->dbprefix('store') . ' AS s');//查
		
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
		$this->db->from($this->db->dbprefix('product_to_category') . ' AS ptc');
		
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