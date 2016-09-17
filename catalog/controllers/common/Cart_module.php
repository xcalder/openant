<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart_module extends CI_Common {
	
	public function __construct() {
		parent::__construct();
		$this->load->helper(array('utf8'));
		$this->load->language('common/header');
		$this->load->library(array('currency', 'cart'));
		$this->load->model(array('product/cart_model'));
		$this->lang->load('common/header',$_SESSION['language_name']);
	}

	public function index($request='')
	{
		if(isset($_SESSION['cart_contents'])){
			$data['carts']=$_SESSION['cart_contents'];
		}else{
			$data['carts']=FALSE;
		}
		
		if($data['carts']){
			foreach($data['carts'] as $key=>$value){
				if(isset($data['carts'][$key]['rowid'])){
					$data['carts'][$key]['image']=$this->cart_model->get_product_info($data['carts'][$key]['id'])['image'];
					$data['carts'][$key]['name']=utf8_substr($data['carts'][$key]['name'], 0, 8).'..';
					
					if(isset($data['carts'][$key]['options'])){
						$data['carts'][$key]['options']=utf8_substr($this->cart_model->get_product_options($data['carts'][$key]['id'], implode('.', $data['carts'][$key]['options'])), 0, 13);
					}
				}
			}
			
			//总价
			$data['total']=$this->currency->Compute(array_sum(array_column($data['carts'], 'subtotal')));
		}
		
		if($request == 'ajax'){
			return $this->load->view('theme/default/template/common/cart_module_update',$data,TRUE);
		}else{
			return $this->load->view('theme/default/template/common/cart_module',$data,TRUE);
		}
	}
}
