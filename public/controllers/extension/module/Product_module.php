<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_module extends CI_Extension{
	
	public function __construct(){
		parent::__construct();
		$this->load->common('image_common');
		$this->load->library(array('currency'));
		$this->load->model(array('common/product_module_model'));
		$this->lang->load('product/category', $_SESSION['language_name']);
	}

	public function index($setting=FALSE, $position){
		if($setting){
			$order['limit']=$setting['number'];
			if($setting['order'] == 'time'){
				$order['order_by']='time';
			}
			
			if($setting['order'] == 'sales'){
				$order['order_by']='sales';
			}
			
			if($setting['order'] == 'RANDOM'){
				$order['order_by']='RANDOM';
			}
			
			if(!empty($setting['category_id'])){
				$order['category_id']=$setting['category_id'];
			}
			
			$products=$this->product_module_model->get_products($order);
			
			$data['products']=$products['products'];
			$data['view_name']=$setting['name'];
			
			
			$html =false;
				
			if($position == 'left' || $position == 'right'){
				$html = $this->load->view('theme/default/template/extension/module/product_left_right_module', $data, TRUE);
			}
				
			if($position == 'top' || $position == 'bottom'){
				$html = $this->load->view('theme/default/template/extension/module/product_top_bottom_module', $data, TRUE);
			}
				
			if($position == 'above'){
				$html = $this->load->view('theme/default/template/extension/module/product_above_module', $data, TRUE);
			}
				
			return $html;
			
		}else{
			return FALSE;
		}
		
	}
}