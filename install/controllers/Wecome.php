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
		
		$data['header']=$this->header->index();
		$data['top']=$this->header->top();
		$data['footer']=$this->footer->index();
		
		$this->load->view('wecome',$data);
	}
	
}
