<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_total extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->language('wecome');
		if(!$this->user->hasPermission('access', 'admin/order/order_total')){
			$this->session->set_flashdata('fali', '你没有访问权限！');
			redirect(site_url(), 'location', 301);
			exit;
		}
		$this->load->library(array('currency'));
		$this->load->model(array('order/order_model'));
	}

	public function index()
	{
		$this->document->setTitle('订单统计');
		
		$this->get_list();
	}
	
	public function get_list()
	{
		//分页
		if($this->input->get('page')){
			$data['page']				=$this->input->get('page');
		}else{
			$data['page']				='0';
		}
		
		$orders							=$this->order_model->get_orders($data);
		if(!empty($orders)){
			$data['orders']				=$orders['orders'];
			$data['count']				=$orders['count'];
		}
		
		$config['base_url'] 			= site_url('order/order_total');
		$config['num_links'] 			= 2;
		$config['page_query_string'] 	= TRUE;
		$config['query_string_segment'] = 'page';
		$config['full_tag_open'] 		= '<nav class="text-left"><ul class="pagination">';
		$config['full_tag_close'] 		= '</ul>';
		$config['first_tag_open'] 		= '<li>';
		$config['first_tag_close'] 		= '</li>';
		$config['last_tag_open'] 		= '<li>';
		$config['last_tag_close'] 		= '</li>';
		$config['next_tag_open'] 		= '<li>';
		$config['next_tag_close'] 		= '</li>';
		$config['prev_tag_open'] 		= '<li>';
		$config['prev_tag_close'] 		= '</li>';
		$config['cur_tag_open'] 		= '<li class="active"><a>';
		$config['cur_tag_close'] 		= '</a></li>';
		$config['num_tag_open']			= '<li>';
		$config['num_tag_close']		= '</li>';
		$config['first_link'] 			= '<<';
		$config['last_link'] 			= '>>';
		$config['total_rows'] 			= $orders['count'];
		$config['per_page'] 			= $this->config->get_config('config_limit_admin');

		$this->pagination->initialize($config);

		$data['pagination'] 			= $this->pagination->create_links();
		
		$data['header']					=$this->header->index();
		$data['top']					=$this->header->top();
		$data['footer']					=$this->footer->index();
		
		$this->load->view('theme/default/template/order/order_total',$data);
	}
}
