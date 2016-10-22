<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends MY_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->helper(array('utf8'));
		$this->load->language('wecome');
		$this->load->library(array('cart', 'currency'));
		$this->load->model(array('product/product_model', 'product/cart_model'));
	}

	public function index(){
		$this->document->setTitle('购物车');
		$this->document->addScript('public/min?f='.(SUBPATH == '/' ? '' : SUBPATH).'public/resources/default/js/spinner/jquery.spinner.min.js');
		$this->document->addStyle('public/min?f='.(SUBPATH == '/' ? '' : SUBPATH).'public/resources/default/css/spinner/bootstrap-spinner.css');
		
		$this->document->addStyle('public/min?f='.(SUBPATH == '/' ? '' : SUBPATH).'public/resources/default/css/ystep/ystep.css');
		$this->document->addScript('public/min?f='.(SUBPATH == '/' ? '' : SUBPATH).'public/resources/default/js/ystep/ystep.js');
		
		if(isset($_SESSION['cart_contents'])){
			$carts=$_SESSION['cart_contents'];
			
			foreach($carts as $key=>$value){
				if(isset($carts[$key]['rowid'])){
					$product_info=$this->cart_model->get_product_info($carts[$key]['id']);
					$carts[$key]['image']=$product_info['image'];
					$carts[$key]['store_id']=$product_info['store_id'];
					$carts[$key]['name']=$carts[$key]['name'];
					
					if(isset($carts[$key]['options'])){
						$carts[$key]['options']=$this->cart_model->get_product_options($carts[$key]['id'], implode('.', $carts[$key]['options']));
					}
				}
			}
			
			$stores=array_filter(array_unique(array_column($carts,'store_id')));
			
			$carts_product=array();
			foreach($stores as $key=>$value){
				$carts_product[$key]=$this->cart_model->get_store($stores[$key]);
				foreach($carts as $k=>$v){
					if(isset($carts_product[$key]['store_id']) && isset($carts[$k]['store_id']) && $carts_product[$key]['store_id'] == $carts[$k]['store_id']){
						$carts_product[$key]['products'][]=$carts[$k];
					}
				}
			}
			
		}else{
			$carts_product=FALSE;
		}
		
		$data['carts_product']=$carts_product;
		
		$data['position_top']=$this->position_top->index();
		$data['position_left']=$this->position_left->index();
		$data['position_right']=$this->position_right->index();
		$data['position_bottom']=$this->position_bottom->index();
		
		$data['header']=$this->header->index();
		$data['top']=$this->header->step_top();
		$data['footer']=$this->footer->index();
		
		$this->load->view('theme/default/template/user/cart',$data);
	}
	
	public function add(){
		
		if($this->input->post('qtys') != NULL){
			$qtys=$this->input->post('qtys');
		}else{
			$json['error']='添加购物车失败！';
		}
		
		if($this->input->post('product_ids') != NULL){
			$product_ids=$this->input->post('product_ids');
		}else{
			$json['error']='添加购物车失败！';
		}
		
		if($this->input->post('names') != NULL){
			$names=$this->input->post('names');
		}else{
			$json['error']='添加购物车失败！';
		}
		
		$product_price=$this->get_product_price($this->input->post('product_ids'), $this->input->post('option_id'));
		if(!$product_price){
			$json['error']='添加购物车失败！';
		}
		
		if(!isset($json)){
			if($this->input->post('option_id') != NULL && is_array($this->input->post('option_id'))){
				$options=$this->input->post('option_id');
				$data = array(
					'id'      => $product_ids,
					'qty'     => (int)$qtys,
					'price'   => round($product_price['price'], 4),
					'name'    => $names,
					'options' => $options,
					'points'  => $product_price['points']
					
				);
			}else{
				$data = array(
					'id'      => $product_ids,
					'qty'     => (int)$qtys,
					'price'   => round($product_price['price'], 4),
					'name'    => $names,
					'points'  => $product_price['points']
				);
			}
			
			if(isset($product_price['special_value'])){
				$data['preferential_type']='special';
				$data['preferential_value']=$product_price['special_value'];
			}
			
			if(isset($product_price['discount_value'])){
				$data['preferential_type']='discount';
				$data['preferential_value']=$product_price['discount_value'];
			}
			
			$rowid=$this->cart->insert($data);
			if($rowid){
				$json['success']='添加<a target="_blank" href="'.site_url('user/cart').'">'.utf8_substr($names, 0, 18).'</a>到购物车成功！';
				$json['rowid']=$rowid;
				$cart_array=$this->cart->contents(TRUE);
				$this->cart_model->add_cart($cart_array);
			}else{
				$json['error']='添加'.$names.'到购物车失败！';
			}
		}
		
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($json));
	}
	
	public function update(){
		$data=$this->input->post();
		if(!isset($data['rowid'])){
			$json['error']='系统错误，无法更新购物车！';
		}else{
			$update['rowid']=$data['rowid'];
		}
		
		if(isset($data['qty'])){
			$update['qty']=$data['qty'];
		}
		
		if(isset($data['options'])){
			$update['options']=explode('.', $data['options']);
		}
		
		if(!isset($json)){
			if($this->cart->update($update)){
				$json['success']='购物车更新成功！';
				$json['subtotal']=$this->currency->Compute($this->cart->get_item($update['rowid'])['subtotal']);
				
				$this->cart_model->update_cart($update);
			}else{
				$json['error']='更新购物车出错！';
			}
		}
		
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($json));
	}
	
	public function get_product_price($product_id, $option=''){
		$product_price = $this->product_model->get_add_cart_price($product_id, $option);
		
		//判断打折和会员价的时限，如果不在时间范围删掉
		if(!isset($product_price['discount']) || $product_price['discount']['date_start'] > date("Y-m-d H:i:s") || $product_price['discount']['date_end'] < date("Y-m-d H:i:s")){
			unset($product_price['discount']);
		}
		
		if(!isset($product_price['special']) || $product_price['special']['date_start'] > date("Y-m-d H:i:s") || $product_price['special']['date_end'] < date("Y-m-d H:i:s")){
			unset($product_price['special']);
		}
		
		if(isset($product_price['discount']) && isset($product_price['special'])){
			//会员和折扣都有
			if($product_price['price'] - $product_price['special']['price'] > $product_price['discount']['value'] * $product_price['price'] / 10){
				$product_price['price']=$product_price['discount']['value'] * $product_price['price'] / 10; //折扣价
				$product_price['discount_value']=$product_price['discount']['value']; //折扣
			}else{
				$product_price['price']=$product_price['price'] - $product_price['special']['price']; //会员价
				$product_price['special_value']=$product_price['special']['price']; //会员减价
			}
		}else if(isset($product_price['discount']) && !isset($product_price['special'])){
			$product_price['price']=$product_price['discount']['value'] * $product_price['price'] / 10; //折扣价
			$product_price['discount_value']=$product_price['discount']['value']; //折扣
		}else if(!isset($product_price['discount']) && isset($product_price['special'])){
			$product_price['price']=$product_price['price'] - $product_price['special']['price']; //会员价
			$product_price['special_value']=$product_price['special']['price']; //会员减价
		}
		
		if(isset($product_price['taxs'])){
			if($product_price['taxs']['type'] == 'F'){
				$product_price['price']=$product_price['price'] + $product_price['taxs']['rate'];
			}
			if($product_price['taxs']['type'] == 'P'){
				$product_price['price']=$product_price['price'] + ($product_price['price'] * $product_price['taxs']['rate']);
			}
		}
		unset($product_price['discount']);
		unset($product_price['special']);
		unset($product_price['tax_class_id']);
		
		if($product_price){
			return $product_price;
		}
		
		return FALSE;
	}
}