<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Slideshow extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->language('wecome');
		$this->load->model(array('common/module_model', 'common/banner_model'));
	}

	public function index()
	{
		$this->document->setTitle('幻灯片插件的模块列表');
		$this->get_list();
	}
	
	public function edit(){
		$this->document->setTitle('幻灯片模块修改');
		
		if($_SERVER['REQUEST_METHOD']=="POST"){
			
			$this->module_model->update($this->input->post(),'slideshow');
			
			$this->session->set_flashdata('success','幻灯片修改成功！');
			redirect(site_url('extension_config/module/slideshow'), 'location', 301);
		}
		
		$this->get_form();
	}
	
	public function add(){
		$this->document->setTitle('幻灯片插件的模块添加');
		
		if($_SERVER['REQUEST_METHOD']=="POST"){
			
			$this->module_model->add($this->input->post(),'slideshow');
			
			$this->session->set_flashdata('success','幻灯片添加成功！');
			redirect(site_url('extension_config/module/slideshow'), 'location', 301);
		}
		
		$this->get_form();
	}
	
	public function delete(){
		$this->document->setTitle('删除幻灯片插件的模块');
		
		if($this->input->get('module_id') == NULL){
			$this->session->set_flashdata('fali','幻灯片删除失败！');
			redirect(site_url('extension_config/module/slideshow'), 'location', 301);
			return;
		}
		if($this->module_model->delete($this->input->get('module_id'))){
			$this->session->set_flashdata('success','幻灯片删除成功！');
			redirect(site_url('extension_config/module/slideshow'), 'location', 301);
		}
		
		$this->get_list();
	}
	
	public function get_list()
	{
		$data['modules']				=$this->module_model->get_modules_for_code('slideshow');
		
		$data['header']					=$this->header->index();
		$data['top']					=$this->header->top();
		$data['footer']					=$this->footer->index();
		
		$this->load->view('theme/default/template/extension_config/module/slideshow_list',$data);
	}
	
	public function get_form()
	{
		if($this->input->get('module_id') != NULL){
			$data['action']=site_url('extension_config/module/slideshow/edit?module_id=').$this->input->get('module_id');
			//查数据
			$module=$this->module_model->get_modules_for_module_id($this->input->get('module_id'));
			//var_dump($data['module']);
			
		}else{
			$data['action']=site_url('extension_config/module/slideshow/add');
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
		
		$this->load->view('theme/default/template/extension_config/module/slideshow_form',$data);
	}
}
