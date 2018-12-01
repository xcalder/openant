<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Detailed_list extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->helper(array('utf8'));
		$this->load->language('wecome');
		$this->load->library(array('currency'));
		$this->load->model(array('order/user_balances_model'));
	}

	public function index()
	{
		$this->document->setTitle('账目详单');
		
		if ($this->input->get ( 'page' ) != NULL) {
			$data ['page'] = $this->input->get ( 'page' );
		} else {
			$data ['page'] = '0';
		}
		
		if ($this->input->get ( 'operators' ) != NULL) {
			$data ['operators'] = $this->input->get ( 'operators' );
		}
		
		$data['user_id']=$this->user->getId();
		$activitys=$this->user_balances_model->get_balances_activitys($data);
		
		if ($activitys) {
			$data['activitys']=$activitys['activitys'];
			$data ['count'] = $activitys['count'];
		}
		
		// 分页
		$config ['base_url'] = site_url ('user/detailed_list').(($this->input->get('operators') != NULL) ? '?operators='.$this->input->get('operators') : '');
		$config ['num_links'] = 2;
		$config ['page_query_string'] = TRUE;
		$config ['query_string_segment'] = 'page';
		$config ['full_tag_open'] = '<div class="text-left" style="float: left;line-hight: 34px;padding: 6px 12px">共'.@(floor($activitys['count'] / $this->config->get_config ( 'config_limit_admin' )) + 1) .'页/第'.@(floor($data['page'] / $this->config->get_config ( 'config_limit_admin' )) + 1) .'页</div><nav class="text-right"><ul class="pagination" style="margin: 0 0 10px 0">';
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
		$config ['total_rows'] = $activitys['count'];
		$config ['per_page'] = $this->config->get_config ( 'config_limit_admin' );
		
		$this->pagination->initialize ( $config );
		$data['pagination'] 			= $this->pagination->create_links();
		
		$data['position_top']=$this->position_top->index();
		$data['position_left']=$this->position_left->index();
		$data['position_right']=$this->position_right->index();
		$data['position_bottom']=$this->position_bottom->index();
		
		$data['header']=$this->header->index();
		$data['top']=$this->header->user_top();
		$data['footer']=$this->footer->index();
		$this->load->view('theme/default/template/user/detailed_list',$data);
	}
}
