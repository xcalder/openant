<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Update_cart extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->common(array('cart_module'));//装载公共类
	}
	
	public function index(){
		$this->output
		    ->set_content_type('html')
		    ->set_output($this->cart_module->index('ajax'));
	}
}