<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Will_move_text extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->language('wecome');
		if(!$this->user->hasPermission('access', 'admin/extension_config/module/will_move_text')){
			$this->session->set_flashdata('fali', '你没有访问权限！');
			redirect(site_url());
			exit;
		}
		$this->load->model(array('common/module_model', 'common/banner_model'));
	}

	public function index()
	{
		$this->document->setTitle('动画文字插件的模块列表');
		$this->get_list();
	}
	
	public function edit(){
		$this->document->setTitle('动画文字模块修改');
		
		if($_SERVER['REQUEST_METHOD']=="POST" && $this->check_modify()){
			
			$this->module_model->update($this->input->post(),'Will_move_text');
			
			$this->session->set_flashdata('success','动画文字修改成功！');
			redirect(site_url('extension_config/module/will_move_text'));
		}
		
		$this->get_form();
	}
	
	public function add(){
		$this->document->setTitle('动画文字插件的模块添加');
		
		if($_SERVER['REQUEST_METHOD']=="POST" && $this->check_modify()){
			
			$this->module_model->add($this->input->post(),'Will_move_text');
			
			$this->session->set_flashdata('success','动画文字添加成功！');
			redirect(site_url('extension_config/module/will_move_text'));
		}
		
		$this->get_form();
	}
	
	public function delete(){
		$this->document->setTitle('删除动画文字插件的模块');
		
		if($this->input->get('module_id') == NULL){
			$this->session->set_flashdata('fali','动画文字删除失败！');
			redirect(site_url('extension_config/module/will_move_text'));
			return;
		}
		if($this->check_modify() && $this->module_model->delete($this->input->get('module_id'))){
			$this->session->set_flashdata('success','动画文字删除成功！');
			redirect(site_url('extension_config/module/will_move_text'));
		}
		
		$this->get_list();
	}
	
	public function get_list()
	{
		$data['modules']				=$this->module_model->get_modules_for_code('Will_move_text');
		
		$data['header']					=$this->header->index();
		$data['top']					=$this->header->top();
		$data['footer']					=$this->footer->index();
		
		$this->load->view('theme/default/template/extension_config/module/will_move_text_list',$data);
	}
	
	public function get_form()
	{
		$data['languages']=$this->language_model->get_languages();
		
		if($this->input->get('module_id') != NULL){
			$data['action']=site_url('extension_config/module/will_move_text/edit?module_id=').$this->input->get('module_id');
			//查数据
			$module=$this->module_model->get_modules_for_module_id($this->input->get('module_id'));
			
		}else{
			$data['action']=site_url('extension_config/module/will_move_text/add');
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
		
		$this->load->view('theme/default/template/extension_config/module/will_move_text_form',$data);
	}
	
	public function check_modify(){
		if (!$this->user->hasPermission('modify', 'admin/extension_config/module/will_move_text')) {
			$this->session->set_flashdata('danger', '你无权修改，请联系管理员！');
			redirect(site_url('extension_config/module/will_move_text'));
			exit();
		}else {
			return true;
		}
	}
}
