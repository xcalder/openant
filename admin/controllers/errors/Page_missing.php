<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page_missing extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		set_status_header(404);
	}

	public function index()
	{
		$this->document->setTitle('页面不存在');
		$this->output->set_status_header(404);
		
		$data['image_404']=$this->image_common->resize('/public/404.png', 210 , 210);
		
		
		$data['position_top']=$this->position_top->index();
		$data['position_left']=$this->position_left->index();
		$data['position_right']=$this->position_right->index();
		$data['position_bottom']=$this->position_bottom->index();
		
		$data['header']=$this->header->index();
		$data['top']=$this->header->top();
		$data['footer']=$this->footer->index();
		$this->load->view('theme/default/template/errors/page_missing', $data);
	}
}
