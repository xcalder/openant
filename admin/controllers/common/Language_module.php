<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Language_module extends CI_Common{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('common/language_model');
		
		if(!isset($_SESSION['language_code'])){
			
			if($this->config->get_config('auto_language') == '1'){
				
				$this->load->library('user_agent');
				$auto_language=$this->language_model->get_language_like_locale($this->agent->languages());
				if($auto_language){
					$language_code=$auto_language['code'];
					$language_name=$auto_language['language_name'];
					$language_id=$auto_language['language_id'];
				}else{
					$language_code=$this->config->get_config('default_language');
					
					$def_language=$this->language_model->get_language_for_code($this->config->get_config('default_language'));
					$language_name=$def_language['language_name'];
					$language_id=$def_language['language_id'];
				}
			}else{
				$language_code=$this->config->get_config('default_language');
				
				$def_language=$this->language_model->get_language_for_code($this->config->get_config('default_language'));
				$language_name=$def_language['language_name'];
				$language_id=$def_language['language_id'];
			}
			
			$_SESSION['language_id']=$language_id;
			$_SESSION['language_code']= $language_code;
			$_SESSION['language_name']=$language_name;
		}
	}

	public function index()
	{
		$data['languages']=$this->language_model->get_languages();
		
		if(!isset($_SESSION['language_code'])){
			
			if($this->config->get_config('auto_language') == '1'){
				
				$this->load->library('user_agent');
				$auto_language=$this->language_model->get_language_like_locale($this->agent->languages());
				if($auto_language){
					$language=$auto_language;
				}else{
					$def_language=$this->language_model->get_language_for_code($this->config->get_config('default_language'));
					$language=$def_language;
				}
			}else{
				$def_language=$this->language_model->get_language_for_code($this->config->get_config('default_language'));
				$language=$def_language;
			}
			
			$data['language']=$language;
		}
		return $this->load->view('theme/default/template/common/language_module',$data,TRUE);
	}
}
