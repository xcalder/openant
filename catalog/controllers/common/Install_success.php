<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class install_success extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
	}

	public function index()
	{
		$this->lang->load('wecome', $_SESSION['language_name']);
		
		$this->document->addStyle('public/min?f=public/resources/default/css/ystep/ystep.css');
		$this->document->addScript('public/min?f=public/resources/default/js/ystep/ystep.js');
		
		if(unserialize($this->config->get_config('site_name'))[$_SESSION['language_id']]){
			$this->document->setTitle(unserialize($this->config->get_config('site_name'))[$_SESSION['language_id']]);
		}else{
			$this->document->setTitle(lang_line('title'));
		}
		
		$data['position_top']=$this->position_top->index();
		$data['position_left']=$this->position_left->index();
		$data['position_right']=$this->position_right->index();
		$data['position_bottom']=$this->position_bottom->index();
		
		$data['header']=$this->header->index();
		$data['top']=$this->header->step_top();
		$data['footer']=$this->footer->index();
		
		$this->load->view('theme/default/template/common/install_success',$data);
	}
	
}
