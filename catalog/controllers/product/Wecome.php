<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wecome extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->common(array('cart_module'));//装载公共类
		$this->lang->load('product/wecome', $_SESSION['language_name']);
		
		$this->load->library(array('currency'));
		$this->load->model(array('product/product_model'));
		if($this->input->get('product_id') == NULL){
			$this->document->setTitle(lang_line('no_product'));
			$this->header->no_find();
		}
	}

	public function index(){
		$product_info = $this->product_model->get_product($this->input->get('product_id'));
		
		if(!$product_info){
			$this->document->setTitle(lang_line('no_product'));
			$this->header->no_find();
		}
		$this->document->setTitle($product_info['name']);
		
		$this->document->setKeywords($product_info['name']);
		
		$this->document->setDescription($product_info['meta_description']);
		
		$this->document->addScript('public/min?f=public/resources/default/js/spinner/jquery.spinner.min.js');
		$this->document->addStyle('public/min?f=public/resources/default/css/spinner/bootstrap-spinner.css');

		if(isset($product_info['attribute'])){
			foreach($product_info['attribute'] as $key=>$value){
				if(empty($product_info['attribute'][$key]['text']) && empty($product_info['attribute'][$key]['image'])){
					unset($product_info['attribute'][$key]);
				}
			}
		}
		
		if($this->user->isLogged()){
			$this->load->model('setting/my_tracks_model');
			$tracks['product_id']=$this->input->get('product_id');
			$tracks['store_id']=$product_info['store_id'];
			$tracks['user_id']=$this->user->getId();
			$tracks['date_added']=date("Y-m-d H:i:s");
			
			$this->my_tracks_model->add_tracks($tracks);
		}
		
		$this->load->common('qr_code');
		$data['qr_code']=$this->qr_code->add_logo('product-'.$this->input->get('product_id').'.jpg', site_url('product?product_id=').$this->input->get('product_id'), 'H', 2);
		
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
		
		$data['product_id']=$this->input->get('product_id');
		
		$data['position_top']=$this->position_top->index();
		$data['position_left']=$this->position_left->index();
		$data['position_right']=$this->position_right->index();
		$data['position_bottom']=$this->position_bottom->index();
		
		$data['header']=$this->header->index();
		$data['top']=$this->header->top();
		$data['footer']=$this->footer->index();
		
		$this->load->view('theme/default/template/product/wecome',$data);
	}
}
