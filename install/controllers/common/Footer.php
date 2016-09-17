<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Footer extends CI_Common {
	
	public function __construct() {
		parent::__construct();
		$this->load->helper(array('tools'));
	}

	public function index()
	{
		$this->lang->load('common/footer', $_SESSION['language_name']);
		
		$data ['scripts'] = $this->document->getScripts ();
		return $this->load->view('common/footer',$data,TRUE);
	}
}