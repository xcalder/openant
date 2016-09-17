<?php
/**
 * CodeIgniter
 *扩展ci控制器基类，以管理admin权限
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		if(!$this->user->isLogged()){
			//装载类
			$this->session->set_flashdata('fali', '登陆超时请重新登陆！');
			
			unset($_SESSION['user_id']);
			
			redirect(base_url('user/signin/login.html?url='.rawurlencode(all_current_url())));
			
			exit();
		}
	}
}
