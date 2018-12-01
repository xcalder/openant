<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page_missing extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->output->set_status_header(404);
	}

	public function index()
	{
		$this->document->setTitle('页面不存在');
		
		$data['header']=$this->header->index();
		
		$this->load->view('theme/default/template/errors/page_missing', $data);
	}
}
