<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Footer extends CI_Common {
	
	public function __construct() {
		parent::__construct();
		$this->load->helper(array('tools'));
		$this->load->model ( array (
				'common/user_online_model',
				'setting/overall_model'
			));
		$this->user_online_model->add_user_online();
		$this->user_online_model->del_user_online();
	}

	public function index()
	{
		$footer_html=$this->overall_model->get_overall('overall', 'footer_html');
		//var_dump($_SESSION);
		$data['footer_html']=$footer_html['setting'][$_SESSION['language_code'] != NULL ? $_SESSION['language_code'] : 'zh-CN'];
		$data ['scripts'] = $this->document->getScripts ();
		return $this->load->view('theme/default/template/common/footer',$data,TRUE);
	}
}
