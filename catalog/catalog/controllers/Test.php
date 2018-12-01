<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->language('wecome');
		$this->load->library('user_agent');
		$this->load->model(array('product/product_model', 'order/order_model', 'setting/my_tracks_model', 'common/language_model', 'order/user_balances_model'));
		$this->load->database();
		$this->load->config('memcached');
	}

	public function index()
	{
		$this->document->setTitle('楚雄蚂蚁开源软件工作室openant');
		$this->document->addStyle(base_url('resources/public/resources/default/css/common/circle.css'));
		if($this->config->get_config('meta_keyword')){
			$this->document->setKeywords($this->config->get_config('meta_keyword'));
		}
		
		if($this->config->get_config('meta_description')){
			$this->document->setDescription($this->config->get_config('meta_description'));
		}
		
		$this->session->set_flashdata('success', '登陆成功！');
		$data['position_top']=$this->position_top->index();
		$data['position_left']=$this->position_left->index();
		$data['position_right']=$this->position_right->index();
		$data['position_bottom']=$this->position_bottom->index();
		
		$data['header']=$this->header->index();
		$data['top']=$this->header->login_top();
		$data['login_footer']=$this->footer->index();
		
		$this->load->view('theme/default/template/test',$data);
	}
}
