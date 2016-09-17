<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Check_permissions {
	
	public function __construct() {
		$this->CI =& get_instance();
	}

	public function check()
	{
		//if($this->CI->input->get('token') == NULL || $this->CI->input->get('token') !== $_SESSION['token'] || !$this->CI->user->isLogged()){
		if(!$this->CI->user->isLogged()){
			
			$this->CI->session->set_flashdata('fali', '登陆超时请重新登陆！');
			$this->no_login();
			
			exit();
		}
		
		if(!$this->CI->user->hasPermission_access('admin')){
			$this->CI->session->set_flashdata('fali', '非法访问，你不是一个管理员！');
			redirect(base_url(), 'location', 301);
			exit();
		}
		
		/*
		if(!$this->CI->user->has_competence('access','admin')){
			$this->CI->session->set_flashdata('fali', '非法访问，你不是一个管理员！');
			redirect(base_url(), 'location', 301);
			exit();
		}
		*/
	}
	
	private function no_login()
	{
		unset($_SESSION['user_id']);
		
		redirect(base_url('user/signin/login.html?url='.rawurlencode(all_current_url())));
		
		exit();
	}
}
