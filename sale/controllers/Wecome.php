<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wecome extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->language('wecome');
		$this->load->library(array('currency'));
		$this->load->model(array('product/product_model', 'order/order_model'));
	}

	public function index()
	{
		$this->document->setTitle('商家中心');
		
		$data['count']=$this->product_model->total_products();
		$data['orders']=$this->order_model->total_order();
		$total_order=$this->order_model->total_sum_order();
		
		//全部
		$total_all_=array();
		if($total_order['total_all']){
			foreach($total_order['total_all'] as $total_all){
				$total_all_[]=$total_all['total'] * $total_all['currency_value'];
			}
		}
		$data['total_all']=$this->currency->Compute(array_sum($total_all_));
		
		//未到帐
		$total_no_arrival_=array();
		if($total_order['total_no_arrival']){
			foreach($total_order['total_no_arrival'] as $total_no_arrival){
				$total_no_arrival_[]=$total_no_arrival['total'] * $total_no_arrival['currency_value'];
			}
		}
		$data['total_no_arrival']=$this->currency->Compute(array_sum($total_no_arrival_));
		
		//已到帐
		$total_success_=array();
		if($total_order['total_success']){
			foreach($total_order['total_success'] as $total_success){
				$total_success_[]=$total_success['total'] * $total_success['currency_value'];
			}
		}
		$data['total_success']=$this->currency->Compute(array_sum($total_success_));
		
		//已退款
		$total_refund_order_success_=array();
		if($total_order['total_refund_order_success']){
			foreach($total_order['total_refund_order_success'] as $total_refund_order_success){
				$total_refund_order_success_[]=$total_refund_order_success['total'] * $total_refund_order_success['currency_value'];
			}
		}
		$data['total_refund_order_success']=$this->currency->Compute(array_sum($total_refund_order_success_));
		
		$data['position_top']=$this->position_top->index();
		$data['position_left']=$this->position_left->index();
		$data['position_right']=$this->position_right->index();
		$data['position_bottom']=$this->position_bottom->index();
		
		$data['header']=$this->header->index();
		$data['top']=$this->header->top();
		$data['footer']=$this->footer->index();
		$this->load->view('theme/default/template/wecome',$data);
	}
}
