<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_module extends CI_Extension {
	
	public function __construct() {
		parent::__construct();
		$this->load->common('image_common');
		$this->load->library(array('currency'));
		$this->load->model(array('common/product_model'));
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
			
			$products=$this->product_model->get_products($order);
			
			$data['products']=$products['products'];
			$data['view_name']=$setting['name'];
			return $this->load->view('theme/default/template/extension/module/product_'.$position.'_module', $data, TRUE);
		}else{
			return FALSE;
		}
		
	}
}