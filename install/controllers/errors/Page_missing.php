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
		
		$data['image_404']='image/public/404.png';
		
		$data['header']=$this->header->index();
		$data['top']=$this->header->top();
		$data['footer']=$this->footer->index();
		$this->load->view('errors/html/404', $data);
	}
}
