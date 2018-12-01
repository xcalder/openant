<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Official_setting extends MY_Controller{
	private $error = array();
	
	public function __construct(){
		parent::__construct();
		$this->load->language('extension_config/overall/official_setting_module');
		$this->load->model(array('setting/setting_model','common/language_model'));
		
		if(!$this->user->hasPermission('access', 'admin/extension_config/overall/official_setting')){
			$this->session->set_flashdata('fali', '你没有访问权限！');
			redirect($this->config->item('admin'));
			exit;
		}
	}

	public function index(){
		$this->document->setTitle('官网基本配置');
		
		$data['languages'] = $this->language_model->get_languages();
		
		if(isset($this->error['warning'])){
			$data['error_warning'] = $this->error['warning'];
		} else{
			$data['error_warning'] = '';
		}
		
		if($_SERVER['REQUEST_METHOD']=="POST" && $this->check_modify()){
				
			$this->setting_model->edit($this->input->post(), 'config');
			$this->session->set_flashdata('success', '成功：修改官网配置成功！');
			
			redirect($this->config->item('admin').'/common/extension/overall');
			exit;
		}

		if($this->input->post('official_meta_title') != null){
			$data['official_meta_title']=$this->input->post('official_meta_title');
		}else{
			$data['official_meta_title']=unserialize($this->config->get_config('official_meta_title'));
		}

		if($this->input->post('official_meta_keyword') != null){
			$data['official_meta_keyword']=$this->input->post('official_meta_keyword');
		}else{
			$data['official_meta_keyword']=unserialize($this->config->get_config('official_meta_keyword'));
		}

		if($this->input->post('official_meta_description') != null){
			$data['official_meta_description']=$this->input->post('official_meta_description');
		}else{
			$data['official_meta_description']=unserialize($this->config->get_config('official_meta_description'));
		}
		
		$data['action'] = $this->config->item('admin').'/extension_config/overall/official_setting';
		
		$data['header']=$this->header->index();
		$data['top_nav']=$this->header->top();
		$data['footer']=$this->footer->index();
		
		$this->load->view('theme/default/template/extension_config/overall/official_setting',$data);
	}
	
	//验证表单
	private function check_modify(){
		
		if (!$this->user->hasPermission('modify', 'admin/extension_config/overall/official_setting')) {
			$this->error['warning'] = '没有权限修改';
		}
	
		return !$this->error;
	}
}
