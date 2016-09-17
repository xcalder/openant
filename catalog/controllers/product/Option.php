<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Option extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->lang->load('product/option', $_SESSION['language_name']);
		$this->load->library(array('currency'));
		$this->load->model(array('product/product_model'));
	}
	
	public function index(){
		$data=$this->input->post('arr');
		$product_id=$this->input->get('product_id');
		foreach($data as $key=>$value){
			if(!is_array($data[$key]) || empty($data[$key])){
				unset($data[$key]);
			}
		}
		
		$data['product_id']=$product_id;
		$product_option_info=$this->product_model->get_product_option($data);
		
		//判断打折和会员价的时限，如果不在时间范围删掉
		if(!isset($product_option_info['discount']) || $product_option_info['discount']['date_start'] > date("Y-m-d H:i:s") || $product_option_info['discount']['date_end'] < date("Y-m-d H:i:s")){
			unset($product_option_info['discount']);
		}
		
		if(!isset($product_option_info['special']) || $product_option_info['special']['date_start'] > date("Y-m-d H:i:s") || $product_option_info['special']['date_end'] < date("Y-m-d H:i:s")){
			unset($product_option_info['special']);
		}
		
		if(isset($product_option_info['discount']) && isset($product_option_info['special'])){
			//会员和折扣都有
			if($product_option_info['option']['price'] - $product_option_info['special']['price'] > $product_option_info['discount']['value'] * $product_option_info['option']['price'] / 10){
				$product_option_info['discount_price']=$product_option_info['discount']['value'] * $product_option_info['option']['price'] / 10; //折扣价
				$product_option_info['discount_value']=$product_option_info['discount']['value']; //折扣价
			}else{
				$product_option_info['special_price']=$product_option_info['option']['price'] - $product_option_info['special']['price']; //会员价
				$product_option_info['special_value']=$product_option_info['special']['price']; //会员减价
			}
		}else if(isset($product_option_info['discount']) && !isset($product_option_info['special'])){
			$product_option_info['discount_price']=$product_option_info['discount']['value'] * $product_option_info['option']['price'] / 10; //折扣价
			$product_option_info['discount_value']=$product_option_info['discount']['value']; //折扣价
		}else if(!isset($product_option_info['discount']) && isset($product_option_info['special'])){
			$product_option_info['special_price']=$product_option_info['option']['price'] - $product_option_info['special']['price']; //会员价
			$product_option_info['special_value']=$product_option_info['special']['price']; //会员减价
		}
		unset($product_option_info['discount']);
		unset($product_option_info['special']);
		
		if($this->input->post('taxs') != NULL){
			$taxs=$this->input->post('taxs');
			$tax_type=substr($taxs, 0, stripos($taxs, '+.+'));
			$tax_rate=substr($taxs, stripos($taxs, '+.+')+3);
		}else{
			$tax_type='';
			$tax_rate='';
		}
		
		
		$data=array();
		if($product_option_info['option']){
			$data['quantity']=sprintf(lang_line('in_stock'), $product_option_info['option']['quantity']);
			
			if($tax_type == 'F'){
				$tax_num = $tax_rate;
			}elseif($tax_type == 'P'){
				if(isset($product_option_info['discount_price'])){
					$tax_num = $tax_rate * $product_option_info['discount_price'];
				}else if(isset($product_option_info['special_price'])){
					$tax_num = $tax_rate * $product_option_info['special_price'];
				}
			}
			else
			{
				$tax_num = '0';
			}
			
			$data['sale']='success';
			if(isset($product_option_info['discount_price'])){
				$data['price']=$this->currency->Compute($product_option_info['discount_price']).html_entity_decode(sprintf(lang_line('after_tax'), ($this->currency->Compute($product_option_info['discount_price'] + $tax_num))));
				$data['cart_price']=$product_option_info['discount_price'] + $tax_num;
				$data['value']=$this->currency->Compute($product_option_info['discount_value']);
				$data['type']='discount';
			}else if(isset($product_option_info['special_price'])){
				$data['price']=$this->currency->Compute($product_option_info['special_price']).html_entity_decode(sprintf(lang_line('after_tax'), ($this->currency->Compute($product_option_info['special_price'] + $tax_num))));
				$data['cart_price']=$product_option_info['special_price'] + $tax_num;
				$data['value']=$this->currency->Compute($product_option_info['special_value']);
				$data['type']='special';
			}else{
				$data['price']=$this->currency->Compute($product_option_info['option']['price'] + $tax_num);
				$data['cart_price']=$product_option_info['option']['price'] + $tax_num;
				$data['value']=$this->currency->Compute('0');
				$data['type']='none';
			}
			
			$data['default_price']=$this->currency->Compute($product_option_info['option']['price']).html_entity_decode(sprintf(lang_line('after_tax'), ($this->currency->Compute($product_option_info['option']['price'] + $tax_num))));
			$data['points']=$product_option_info['option']['points'];
		}else{
			$data['sale']='fail';
			$data['quantity']=lang_line('not_buy');
			$data['price']=$this->currency->Compute('0');
			$data['cart_price']='0';
			$data['value']=$this->currency->Compute('0');
			$data['type']='none';
			$data['default_price']=$this->currency->Compute('0');
			$data['points']='0';
		}
		
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($data));
		//return;
	}
	
	public function cart_option_update(){
		$data=$this->input->post('arr');
		$rowid=$this->input->post('rowids');
		$product_id=$this->input->get('product_id');
		foreach($data as $key=>$value){
			if(!is_array($data[$key]) || empty($data[$key])){
				unset($data[$key]);
			}
		}
		
		if(!is_array($data) || empty($rowid) || empty($product_id)){
			return;
		}
		
		foreach($data as $key=>$value){
			$op_id[]=$data[$key][1];
		}
		$option_id=implode('.', $op_id);
		
		$data['product_id']=$product_id;
		$product_option_info=$this->product_model->get_product_option($data);
		
		//判断打折和会员价的时限，如果不在时间范围删掉
		if(!isset($product_option_info['discount']) || $product_option_info['discount']['date_start'] > date("Y-m-d H:i:s") || $product_option_info['discount']['date_end'] < date("Y-m-d H:i:s")){
			unset($product_option_info['discount']);
		}
		
		if(!isset($product_option_info['special']) || $product_option_info['special']['date_start'] > date("Y-m-d H:i:s") || $product_option_info['special']['date_end'] < date("Y-m-d H:i:s")){
			unset($product_option_info['special']);
		}
		
		if(isset($product_option_info['discount']) && isset($product_option_info['special'])){
			//会员和折扣都有
			if($product_option_info['option']['price'] - $product_option_info['special']['price'] > $product_option_info['discount']['value'] * $product_option_info['option']['price'] / 10){
				$product_option_info['discount_price']=$product_option_info['discount']['value'] * $product_option_info['option']['price'] / 10; //折扣价
				$product_option_info['discount_value']=$product_option_info['discount']['value']; //折扣价
			}else{
				$product_option_info['special_price']=$product_option_info['option']['price'] - $product_option_info['special']['price']; //会员价
				$product_option_info['special_value']=$product_option_info['special']['price']; //会员减价
			}
		}else if(isset($product_option_info['discount']) && !isset($product_option_info['special'])){
			$product_option_info['discount_price']=$product_option_info['discount']['value'] * $product_option_info['option']['price'] / 10; //折扣价
			$product_option_info['discount_value']=$product_option_info['discount']['value']; //折扣价
		}else if(!isset($product_option_info['discount']) && isset($product_option_info['special'])){
			$product_option_info['special_price']=$product_option_info['option']['price'] - $product_option_info['special']['price']; //会员价
			$product_option_info['special_value']=$product_option_info['special']['price']; //会员减价
		}
		unset($product_option_info['discount']);
		unset($product_option_info['special']);
		
		if($this->input->post('taxs') != NULL){
			$taxs=$this->input->post('taxs');
			$tax_type=substr($taxs, 0, stripos($taxs, '+.+'));
			$tax_rate=substr($taxs, stripos($taxs, '+.+')+3);
		}else{
			$tax_type='';
			$tax_rate='';
		}
		
		
		$data=array();
		if($product_option_info['option']){
			$data['quantity']=sprintf(lang_line('in_stock'), $product_option_info['option']['quantity']);
			
			if($tax_type == 'F'){
				$tax_num = $tax_rate;
			}elseif($tax_type == 'P'){
				if(isset($product_option_info['discount_price'])){
					$tax_num = $tax_rate * $product_option_info['discount_price'];
				}else if(isset($product_option_info['special_price'])){
					$tax_num = $tax_rate * $product_option_info['special_price'];
				}
			}
			else
			{
				$tax_num = '0';
			}
			
			if($product_option_info['option']['quantity'] == 0){
				$data['sale']='fail';
				$data['quantity']=lang_line('not_buy');
			}else{
				
				//更新购物车、更新user_cart
				$update['rowid']=$rowid;
				$update['qty']=$this->input->post('number');
				
				if(isset($product_option_info['discount_price'])){
					$update['price']=$product_option_info['discount_price'];
					
					$update['preferential_type']='discount';
					$update['preferential_value']=$product_option_info['discount_value'];
					
					$data['price']=$this->currency->Compute($product_option_info['discount_price']);
					$data['tax_price']=$this->currency->Compute($product_option_info['discount_price']);
					$data['total_price']=$this->currency->Compute(($product_option_info['discount_price']) * $this->input->post('number'));
					$data['default_price']=$product_option_info['discount_price'];
				}else if(isset($product_option_info['special_price'])){
					$update['price']=$product_option_info['special_price'];
					
					$update['preferential_type']='special';
					$update['preferential_value']=$product_option_info['special_value'];
					
					$data['price']=$this->currency->Compute($product_option_info['special_price']);
					$data['tax_price']=$this->currency->Compute($product_option_info['special_price']);
					$data['total_price']=$this->currency->Compute(($product_option_info['special_price']) * $this->input->post('number'));
					$data['default_price']=$product_option_info['special_price'];
				}else{
					$update['price']=$product_option_info['option']['price'] + $tax_num;
					$data['price']=$this->currency->Compute($product_option_info['option']['price'] + $tax_num);
					$data['tax_price']=$this->currency->Compute($product_option_info['option']['price'] + $tax_num);
					$data['default_price']=$product_option_info['option']['price'] + $tax_num;
					$data['total_price']=$this->currency->Compute(($product_option_info['option']['price'] + $tax_num) * $this->input->post('number'));
				}
				
				$update['points']=$product_option_info['option']['points'];
				$update['options']=explode('.', $option_id);
				
				if($this->cart->update($update)){
					$data['sale']='success';
					$update['options']=$option_id;
					$this->cart_model->update_cart($update);
				}else{
					$data['sale']='fail';
				}
			}
			
			$data['points']=$product_option_info['option']['points'];
			$data['options']=$this->cart_model->get_product_options($product_id, $option_id);
		}else{
			$data['sale']='fail';
			$data['quantity']=lang_line('not_buy');
			$data['price']=$this->currency->Compute('0');
			$data['tax_price']=$this->currency->Compute('0');
			$data['default_price']='0';
			$data['points']='0';
			$data['total_price']=$this->currency->Compute('0');
			$data['options']='';
		}
		
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($data));
		//return;
	}
	
	public function cart_option(){
		if($this->input->post('product_id') == NULL){
			$html=lang_line('get_option_fail');
		}
		
		if(!isset($html)){
			$data['rowid']=$this->input->post('rowid');
			$product_info = $this->product_model->get_product($this->input->post('product_id'));
			//判断打折和会员价的时限，如果不在时间范围删掉
			if(!isset($product_info['discount']) || $product_info['discount']['date_start'] > date("Y-m-d H:i:s") || $product_info['discount']['date_end'] < date("Y-m-d H:i:s")){
				unset($product_info['discount']);
			}
			
			if(!isset($product_info['special']) || $product_info['special']['date_start'] > date("Y-m-d H:i:s") || $product_info['special']['date_end'] < date("Y-m-d H:i:s")){
				unset($product_info['special']);
			}
			
			if(isset($product_info['discount']) && isset($product_info['special'])){
				//会员和折扣都有
				if($product_info['price'] - $product_info['special']['price'] > $product_info['discount']['value'] * $product_info['price'] / 10){
					$product_info['discount_price']=$product_info['discount']['value'] * $product_info['price'] / 10; //折扣价
					$product_info['discount_value']=$product_info['discount']['value']; //折扣价
				}else{
					$product_info['special_price']=$product_info['price'] - $product_info['special']['price']; //会员价
					$product_info['special_value']=$product_info['special']['price']; //会员减价
				}
			}else if(isset($product_info['discount']) && !isset($product_info['special'])){
				$product_info['discount_price']=$product_info['discount']['value'] * $product_info['price'] / 10; //折扣价
				$product_info['discount_value']=$product_info['discount']['value']; //折扣价
			}else if(!isset($product_info['discount']) && isset($product_info['special'])){
				$product_info['special_price']=$product_info['price'] - $product_info['special']['price']; //会员价
				$product_info['special_value']=$product_info['special']['price']; //会员减价
			}
			unset($product_info['discount']);
			unset($product_info['special']);
			
			$data['product']=$product_info;
			
			$option_images_re=$this->product_model->get_option_image($this->input->get('product_id'));
			if($option_images_re){
				foreach($option_images_re as $option_images){
					$option_image[$option_images['option_id_first']]=$option_images;
				}
				$data['option_image']=$option_image;
			}
			
			$html=$this->load->view('theme/default/template/product/cart_option',$data,TRUE);
		}
		
		$this->output
		    ->set_content_type('application/html')
		    ->set_output($html);
	}
	
	public function remove_cart(){
		$rowid=$this->input->post('rowid');
		$name=$this->cart->get_item($rowid)['name'];
		if(empty($rowid)){
			$data['error']=sprintf(lang_line('error_del'), $name);
		}else{
			if($this->cart->remove($rowid)){
				$data['success']=sprintf(lang_line('success_del'), $name);
				$this->cart_model->delete($rowid);
			}else{
				$data['error']=sprintf(lang_line('error_del'), $name);
			}
			
		}
		
		$this->output
		    ->set_content_type('application/html')
		    ->set_output(json_encode($data));
	}
}