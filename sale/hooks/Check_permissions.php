<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Check_permissions {
	
	public function __construct() {
		$this->CI =& get_instance();
	}

	public function check()
	{
		if(!$this->CI->user->isLogged()){
			$this->CI->session->set_flashdata('fali', '登陆超时请重新登陆！');
			$this->no_login();
			
			exit();
		}
	}
	
	private function no_login()
	{
		unset($_SESSION['user_id']);
		
		redirect(base_url('user/signin/login.html?url='.rawurlencode(all_current_url())));
		
		exit();
	}
}
