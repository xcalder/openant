<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wecome extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
	}

	public function index()
	{
		$this->document->setTitle(unserialize($this->config->get_config('site_name'))[$_SESSION['language_id']]);
		$this->document->setKeywords(unserialize($this->config->get_config('meta_keyword'))[$_SESSION['language_id']]);
		$this->document->setDescription(unserialize($this->config->get_config('meta_description'))[$_SESSION['language_id']]);
		$this->document->setCopyright(unserialize($this->config->get_config('site_abbreviation'))[$_SESSION['language_id']]);
		
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
