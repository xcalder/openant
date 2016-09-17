<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Language extends MY_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('common/language_model');
		$this->load->helper('cookie');
	}

	public function index(){
		if($this->input->get('language_id')){
			$language=$this->language_model->get_language($this->input->get('language_id'));
			$_SESSION['language_id']=$language['language_id'];
			$_SESSION['language_code']=isset($language['code']) ? $language['code'] : 'zh_CN';
			$_SESSION['language_name']=isset($language['language_name']) ? $language['language_name'] : 'chiness';
		}
	}
}
