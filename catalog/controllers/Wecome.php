<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wecome extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
	}

	public function index()
	{
		$this->lang->load('wecome', $_SESSION['language_name']);
		
		if(unserialize($this->config->get_config('site_name'))[$_SESSION['language_id']]){
			$this->document->setTitle(unserialize($this->config->get_config('site_name'))[$_SESSION['language_id']]);
		}else{
			$this->document->setTitle(lang_line('title'));
		}
		
		if($this->config->get_config('meta_keyword')){
			$this->document->setKeywords($this->config->get_config('meta_keyword'));
		}else{
			$this->document->setKeywords(lang_line('meta_keyword'));
		}
		
		if($this->config->get_config('meta_description')){
			$this->document->setDescription($this->config->get_config('meta_description'));
		}else{
			$this->document->setDescription(lang_line('meta_description'));
		}
		
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
