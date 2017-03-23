<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Custom_html_module extends CI_Extension {
	
	public function __construct() {
		parent::__construct();
		$this->load->common('image_common');
	}

	public function index($setting=FALSE)
	{
		if($setting){
			$data['html']=$setting[$_SESSION['language_code'] != NULL ? $_SESSION['language_code'] : 'zh-CN'];
			return $this->load->view('theme/default/template/extension/module/custom_html_module', $data, TRUE);
		}else{
			return FALSE;
		}
		
	}
}