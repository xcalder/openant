<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wecome extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
	}

	public function index()
	{
		$this->lang->load('wecome', $_SESSION['language_name']);
		
		$this->document->setTitle(lang_line('title'));
		
		$this->document->addStyle('public/min?f=public/resources/default/css/home/home.css');
		
		$data['header']=$this->header->index();
		$data['top']=$this->header->top();
		$data['footer']=$this->footer->index();
		
		$this->load->view('wecome',$data);
	}
	
}
