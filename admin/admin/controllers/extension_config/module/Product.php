<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->language('wecome');
		if(!$this->user->hasPermission('access', 'admin/extension_config/module/product')){
			$this->session->set_flashdata('fali', '你没有访问权限！');
			redirect($this->config->item('admin'));
			exit;
		}
		$this->load->model(array('common/module_model', 'product/product_model'));
	}

	public function index()
	{
		$this->document->setTitle('商品模块插件的模块列表');
		$this->get_list();
	}
	
	public function edit(){
		$this->document->setTitle('商品模块模块修改');
		
		if($_SERVER['REQUEST_METHOD']=="POST" && $this->check_modify()){
			
			$this->module_model->update($this->input->post(),'product');
			
			$this->session->set_flashdata('success','商品模块修改成功！');
			redirect($this->config->item('admin').'/extension_config/module/product');
		}
		
		$this->get_form();
	}
	
	public function add(){
		$this->document->setTitle('商品模块插件的模块添加');
		
		if($_SERVER['REQUEST_METHOD']=="POST" && $this->check_modify()){
			
			$this->module_model->add($this->input->post(),'product');
			
			$this->session->set_flashdata('success','商品模块添加成功！');
			redirect($this->config->item('admin').'/extension_config/module/product');
		}
		
		$this->get_form();
	}
	
	public function delete(){
		$this->document->setTitle('删除商品模块插件的模块');
		
		if($this->input->get('module_id') == NULL){
			$this->session->set_flashdata('fali','商品模块删除失败！');
			redirect($this->config->item('admin').'/extension_config/module/product');
			return;
		}
		if($this->check_modify() && $this->module_model->delete($this->input->get('module_id'))){
			$this->session->set_flashdata('success','商品模块删除成功！');
			redirect($this->config->item('admin').'/extension_config/module/product');
		}
		
		$this->get_list();
	}
	
	public function get_list()
	{
		$data['modules']				=$this->module_model->get_modules_for_code('product');
		
		$data['header']					=$this->header->index();
		$data['top']					=$this->header->top();
		$data['footer']					=$this->footer->index();
		
		$this->load->view('theme/default/template/extension_config/module/product_list',$data);
	}
	
	public function get_form()
	{
		$cotegorys_select = $this->product_model->get_categorys_store();
		$parent_ids=array_flip(array_flip(array_column($cotegorys_select,'parent_id')));
		foreach($cotegorys_select as $k=>$v){
			if(in_array($cotegorys_select[$k]['category_id'], $parent_ids)){
				unset($cotegorys_select[$k]);
			}
		}
		
		$data['cotegorys_select'] = $cotegorys_select;
		
		if($this->input->get('module_id') != NULL){
			$data['action']=$this->config->item('admin').'/extension_config/module/product/edit?module_id='.$this->input->get('module_id');
			//查数据
			$module=$this->module_model->get_modules_for_module_id($this->input->get('module_id'));
			//var_dump($data['module']);
			
		}else{
			$data['action']=$this->config->item('admin').'/extension_config/module/product/add';
		}
		
		if($this->input->post() != NULL){
			$data['module']=$this->input->post();
		}elseif(isset($module) && $module){
			$data['module']=$module;
		}
		
		$data['header']					=$this->header->index();
		$data['top']					=$this->header->top();
		$data['footer']					=$this->footer->index();
		
		$this->load->view('theme/default/template/extension_config/module/product_form',$data);
	}
	
	public function check_modify(){
		if (!$this->user->hasPermission('modify', 'admin/extension_config/module/product')) {
			$this->session->set_flashdata('danger', '你无权修改，请联系管理员！');
			redirect($this->config->item('admin').'/extension_config/module/product');
			exit();
		}else {
			return true;
		}
	}
}
