<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Will_move_text_module extends CI_Extension {
	
	public function __construct() {
		parent::__construct();
		$this->load->model(array('common/module_model'));
		$this->document->addScript(base_url('resources/public/module/will_move_text/jquery.lettering.js'));
		$this->document->addScript(base_url('resources/public/module/will_move_text/jquery.textillate.js'));
		$this->document->addStyle(base_url('resources/public/module/will_move_text/animate.css'));
	}

	public function index($setting=FALSE)
	{
		if($setting){
			
			$setting['content']=explode(';', $setting['content'][$_SESSION['language_id']]);
			$data['setting']=$setting;
			return $this->load->view('theme/default/template/extension/module/will_move_text_module', $data, TRUE);
		}else{
			return FALSE;
		}
		
	}
}