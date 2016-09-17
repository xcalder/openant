<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->language('wecome');
	}

	public function index()
	{
		$this->get_list();
	}
	
	public function get_list()
	{
		$data=array();
		$this->load->view('theme/default/template/extension/payment/test',$data);
	}
}
