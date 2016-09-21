<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wecome extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->helper(array('utf8'));
		$this->load->language('wecome');
		$this->load->library(array('currency'));
		$this->load->model(array('common/user_model', 'order/order_model', 'order/user_balances_model'));
	}

	public function index()
	{
		$this->document->setTitle('个人中心');
		
		$user=$this->user_model->get_user($_SESSION['user_id']);
		
		if(!empty($user['image'])){
			$user['image']=$this->image_common->resize($user['image'], 50 , 50);
		}else{
			$user['image']='public/resources/default/image/logo.jpg';
		}
		
		$data['user']=$user;
		
		$data['balances']=$this->user_balances_model->get_balances($this->user->getId())['balances'];
		
		$count_orders=$this->order_model->count_orders();
		
		if($count_orders){
			foreach($count_orders as $k=>$v){
				if($count_orders[$k]['order_status_id'] == $this->config->get_config('default_order_status')){
					$data['count_default_order']=$count_orders[$k]['count'];
				}
				
				if($count_orders[$k]['order_status_id'] == $this->config->get_config('to_be_delivered')){
					$data['count_to_be_delivered']=$count_orders[$k]['count'];
				}
				
				if($count_orders[$k]['order_status_id'] == $this->config->get_config('inbound_state')){
					$data['count_inbound_state']=$count_orders[$k]['count'];
				}
				
				if($count_orders[$k]['order_status_id'] == $this->config->get_config('state_to_be_evaluated')){
					$data['count_to_be_evaluated']=$count_orders[$k]['count'];
				}
				
				if($count_orders[$k]['order_status_id'] == $this->config->get_config('refund_order')){
					$data['count_refund_order']=$count_orders[$k]['count'];
				}
			}
		}
		
		//待收货订单
		$data ['page'] = '0';
		
		$data ['order_status'] = $this->config->get_config('inbound_state');
		
		$orders=$this->order_model->get_orders($data);
		
		if ($orders) {
			$data['orders']=$orders['order'];
			$data ['count'] = $orders['count'];
		}
		
		// 分页
		$config ['base_url'] = site_url ( 'user/wecome/get_order_wecome' );
		$config ['num_links'] = 2;
		$config ['page_query_string'] = TRUE;
		$config ['query_string_segment'] = 'page';
		$config ['full_tag_open'] = '<div class="text-left" style="float: left;line-hight: 34px;padding: 6px 12px">共'.@(floor($orders['count'] / $this->config->get_config ( 'config_limit_admin' )) + 1) .'页/第'.@(floor($data['page'] / $this->config->get_config ( 'config_limit_admin' )) + 1) .'页</div><nav class="text-right"><ul class="pagination" style="margin: 0 0 10px 0">';
		$config ['full_tag_close'] = '</ul>';
		$config ['first_tag_open'] = '<li>';
		$config ['first_tag_close'] = '</li>';
		$config ['last_tag_open'] = '<li>';
		$config ['last_tag_close'] = '</li>';
		$config ['next_tag_open'] = '<li>';
		$config ['next_tag_close'] = '</li>';
		$config ['prev_tag_open'] = '<li>';
		$config ['prev_tag_close'] = '</li>';
		$config ['cur_tag_open'] = '<li class="active"><a>';
		$config ['cur_tag_close'] = '</a></li>';
		$config ['num_tag_open'] = '<li>';
		$config ['num_tag_close'] = '</li>';
		$config ['first_link'] = '<<';
		$config ['last_link'] = '>>';
		$config ['total_rows'] = $orders['count'];
		$config ['per_page'] = $this->config->get_config ( 'config_limit_admin' );
		
		$this->pagination->initialize ( $config );

		$data['pagination'] = $this->pagination->create_links();
		//待收货订单
		
		
		$data['position_top']=$this->position_top->index();
		$data['position_left']=$this->position_left->index();
		$data['position_right']=$this->position_right->index();
		$data['position_bottom']=$this->position_bottom->index();
		
		$data['header']=$this->header->index();
		$data['top']=$this->header->user_top();
		$data['footer']=$this->footer->index();
		$this->load->view('theme/default/template/user/wecome',$data);
	}
	
	public function get_order_wecome(){
		//待收货订单
		if($this->input->get('page') != NULL){
			$data ['page'] = $this->input->get('page');
		}else{
			$data ['page'] = '0';
		}
		
		
		$data ['order_status'] = $this->config->get_config('inbound_state');
		
		$orders=$this->order_model->get_orders($data);
		
		if ($orders) {
			$data['orders']=$orders['order'];
			$data ['count'] = $orders['count'];
		}
		
		// 分页
		$config ['base_url'] = site_url ( 'user/wecome/get_order_wecome' );
		$config ['num_links'] = 2;
		$config ['page_query_string'] = TRUE;
		$config ['query_string_segment'] = 'page';
		$config ['full_tag_open'] = '<div class="text-left" style="float: left;line-hight: 34px;padding: 6px 12px">共'.@(floor($orders['count'] / $this->config->get_config ( 'config_limit_admin' )) + 1) .'页/第'.@(floor($data['page'] / $this->config->get_config ( 'config_limit_admin' )) + 1) .'页</div><nav class="text-right"><ul class="pagination" style="margin: 0 0 10px 0">';
		$config ['full_tag_close'] = '</ul>';
		$config ['first_tag_open'] = '<li>';
		$config ['first_tag_close'] = '</li>';
		$config ['last_tag_open'] = '<li>';
		$config ['last_tag_close'] = '</li>';
		$config ['next_tag_open'] = '<li>';
		$config ['next_tag_close'] = '</li>';
		$config ['prev_tag_open'] = '<li>';
		$config ['prev_tag_close'] = '</li>';
		$config ['cur_tag_open'] = '<li class="active"><a>';
		$config ['cur_tag_close'] = '</a></li>';
		$config ['num_tag_open'] = '<li>';
		$config ['num_tag_close'] = '</li>';
		$config ['first_link'] = '<<';
		$config ['last_link'] = '>>';
		$config ['total_rows'] = $orders['count'];
		$config ['per_page'] = $this->config->get_config ( 'config_limit_admin' );
		
		$this->pagination->initialize ( $config );

		$data['pagination'] = $this->pagination->create_links();
		//待收货订单
		$html=$this->load->view('theme/default/template/user/get_order_wecome', $data, TRUE);
		
		$this->output
		    ->set_content_type('html')
		    ->set_output($html);
		    
		return;
	}
}
