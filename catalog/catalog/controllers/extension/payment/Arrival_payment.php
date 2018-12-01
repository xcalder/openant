<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Arrival_payment extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
	}

	public function index()
	{
		$encrypt=$this->input->get('encrypt');
		$order_ids=$this->input->get('order_ids');
		$payment_total=$this->input->get('payment_total');
		$order_ids=explode(',', $order_ids);
		unset($order_ids[0]);
		
		$input_encrypt=md5($_SESSION['token'].implode(',', $order_ids).$payment_total.$_SESSION['token']);
		
		if ($encrypt != $input_encrypt) {
			$resule['status']=FALSE;
			$resule['msg']='付款不成功，请不要非法修改参数！';
			$this->session->set_flashdata('result', $resule);
				
			redirect('user/confirm/payment_info');
			exit;
		}
		
		//$value=$this->config->get_config('arrival_payment', 'payment');
		//$value=unserialize($value);
		
		$this->load->model('order/order_model');
		$this->load->model('order/user_balances_model');
		
		//添加用户付款记录
		$data['user_id']			=$this->user->getId();
		$data['money']				=$payment_total;
		$data['content']			=array('title'=>'付款', 'description'=>'支付订单id号:'.implode(',', $order_ids));
		$data['operators']			='-';
		
		$pay=$this->user_balances_model->add_blances_activity($data);
		
		foreach ($order_ids as $key=>$order_id){
			$orders[$key]['order_id']=$order_id;
			$orders[$key]['order_status_id']=$this->config->get_config('to_be_delivered');
			$orders[$key]['payment_method']='货到付款';
			
		}
		if($pay){
			$this->order_model->edit_order_status($orders);
		}
	}
}
