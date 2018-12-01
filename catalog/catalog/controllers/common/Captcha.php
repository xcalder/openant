<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Captcha extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->library(array('validate_code'));
	}

	public function index()
	{
		
		$this->validate_code->doimg();
		$this->session->set_userdata('captcha_code', $this->validate_code->getCode());
	}
	
	//ajax远程异步验证、
	public function veri(){
		if(strtolower($this->input->get('captcha')) == $this->session->userdata('captcha_code')){
			echo 'true';
		}else{
			echo 'false';
		}
		exit();
	}
	
}
