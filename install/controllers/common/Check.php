<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Check extends CI_Controller {
	private $error = array();
	
	public function __construct() {
		parent::__construct();
	}

	public function index()
	{
		$this->lang->load('wecome', $_SESSION['language_name']);
		
		$this->document->setTitle(lang_line('title'));
		
		$db = array(
			'mysqli', 
			'pgsql', 
			'pdo'
		);

		if (!array_filter($db, 'extension_loaded')) {
			$data['db'] = false;
		} else {
			$data['db'] = true;
		}
		
		$data['header']=$this->header->index();
		$data['top']=$this->header->top();
		$data['footer']=$this->footer->index();
		
		$this->load->view('common/check',$data);
	}
}
