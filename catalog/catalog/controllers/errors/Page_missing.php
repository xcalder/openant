<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page_missing extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
	}

	public function index()
	{
		$this->output->set_status_header(404);
		
		$this->document->setTitle('页面不存在');
		
		$data['header']=$this->header->index();
		
		$this->load->view('theme/default/template/errors/page_missing', $data);
	}
	
	public function go_to()
	{
		echo '跳转中<br/>请稍候...';
		sleep(1);
		$go_to=all_current_url();
		$go_to=str_ireplace(base_url('errors/page_missing/go_to?go_to='), '', $go_to);
		redirect(prep_url($go_to));
	}
}
