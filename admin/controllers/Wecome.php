<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wecome extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->language('wecome');
		$this->load->model(array('common/product_model'));
	}

	public function index()
	{
		$this->document->setTitle('管理中心');
		
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
