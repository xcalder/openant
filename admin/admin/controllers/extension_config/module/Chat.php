<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chat extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->language('wecome');
		if(!$this->user->hasPermission('access', 'admin/extension_config/module/chat')){
			$this->session->set_flashdata('fali', '你没有访问权限！');
			redirect($this->config->item('admin'));
			exit;
		}
		$this->load->model(array('common/module_model', 'common/banner_model'));
	}

	public function index()
	{
		$this->document->setTitle('客服模块列表');
		$this->get_list();
	}
	
	public function edit(){
		$this->document->setTitle('动画文字模块修改');
		
		if($_SERVER['REQUEST_METHOD']=="POST" && $this->check_modify()){
			
			$this->module_model->update($this->input->post(),'chat');
			
			$this->session->set_flashdata('success','动画文字修改成功！');
			redirect($this->config->item('admin').'extension_config/module/chat');
		}
		
		$this->get_form();
	}
	
	public function add(){
		$this->document->setTitle('客服模块添加');
		
		if($_SERVER['REQUEST_METHOD']=="POST" && $this->check_modify()){
			
			$this->module_model->add($this->input->post(),'chat');
			
			$this->session->set_flashdata('success','动画文字添加成功！');
			redirect($this->config->item('admin').'extension_config/module/chat');
		}
		
		$this->get_form();
	}
	
	public function delete(){
		$this->document->setTitle('删除客服模块');
		
		if($this->input->get('module_id') == NULL){
			$this->session->set_flashdata('fali','动画文字删除失败！');
			redirect($this->config->item('admin').'extension_config/module/chat');
			return;
		}
		if($this->check_modify() && $this->module_model->delete($this->input->get('module_id'))){
			$this->session->set_flashdata('success','动画文字删除成功！');
			redirect($this->config->item('admin').'extension_config/module/chat');
		}
		
		$this->get_list();
	}
	
	public function get_list()
	{
		$data['modules']				=$this->module_model->get_modules_for_code('chat');
		
		$data['header']					=$this->header->index();
		$data['top']					=$this->header->top();
		$data['footer']					=$this->footer->index();
		
		$this->load->view('theme/default/template/extension_config/module/chat_list',$data);
	}
	
	public function get_form()
	{
		$data['languages']=$this->language_model->get_languages();
		
		if($this->input->get('module_id') != NULL){
			$data['action']=$this->config->item('admin').'extension_config/module/chat/edit?module_id='.$this->input->get('module_id');
			//查数据
			$module=$this->module_model->get_modules_for_module_id($this->input->get('module_id'));
			
		}else{
			$data['action']=$this->config->item('admin').'extension_config/module/chat/add';
		}
		
		if($this->input->post() != NULL){
			$data['module']=$this->input->post();
		}elseif(isset($module) && $module){
			$data['module']=$module;
		}
		
		$data['banners']=$this->banner_model->get_banners_();
		
		$data['header']					=$this->header->index();
		$data['top']					=$this->header->top();
		$data['footer']					=$this->footer->index();
		
		$data ['placeholder_image'] = 'resources/public/resources/default/image/no_image.jpg';
		
		$this->load->view('theme/default/template/extension_config/module/chat_form',$data);
	}
	
	public function check_modify(){
		if (!$this->user->hasPermission('modify', 'admin/extension_config/module/chat')) {
			$this->session->set_flashdata('danger', '你无权修改，请联系管理员！');
			redirect($this->config->item('admin').'extension_config/module/chat');
			exit();
		}else {
			return true;
		}
	}
}
