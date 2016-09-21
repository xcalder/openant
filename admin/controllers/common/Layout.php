<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Layout extends MY_Controller{
	private $error = array();
	
	public function __construct(){
		parent::__construct();
		$this->load->helper(array('utf8'));
		$this->load->language('wecome');
		if(!$this->user->hasPermission('access', 'admin/common/layout')){
			$this->session->set_flashdata('fali', '你没有访问权限！');
			redirect(site_url(), 'location', 301);
			exit;
		}
		$this->load->library(array('form_validation'));
		$this->load->model(array('common/layout_model', 'common/module_model'));
	}

	public function index(){
		$this->document->setTitle('布局列表');
		
		$this->get_list();
	}
	
	public function delete(){
		$this->document->setTitle('删除布局');
		
		if($_SERVER['REQUEST_METHOD']=="POST"){
			$this->layout_model->delete($this->input->post('selected'));
			$this->session->set_flashdata('success', '成功：布局删除成功！');
			redirect(site_url('common/layout'), 'location', 301);
		}
		
		$this->get_list();
	}
	
	public function edit(){
		$this->document->setTitle('修改布局');
		
		if($_SERVER['REQUEST_METHOD']=="POST" && $this->validate_form()){
			//验证通过，更新表
			$this->layout_model->edit($this->input->post());
			$this->session->set_flashdata('success', '成功：布局修改成功！');
			redirect(site_url('common/layout'), 'location', 301);
		}
		$this->get_form();
	}
	
	public function add(){
		$this->document->setTitle('添加布局');
		
		if($_SERVER['REQUEST_METHOD']=="POST" && $this->validate_form()){
			//验证通过，更新表
			$this->layout_model->add($this->input->post());
			$this->session->set_flashdata('success', '成功：添加布局成功！');
			redirect(site_url('common/layout'), 'location', 301);
		}
		
		$this->get_form();
	}
	
	public function get_form(){
		if($this->input->get('layout_id')){
			$layout_info					=$this->layout_model->get_layout_to_form($this->input->get('layout_id'));
		}
		
		if($this->input->get('layout_id')){
			$data['action']				=site_url('common/layout/edit?layout_id=').$this->input->get('layout_id');
		}else{
			$data['action']				=site_url('common/layout/add');
		}
		
		if(isset($this->error['error_name'])){
			$data['error_name']				=$this->error['error_name'];
		}
		
		if($this->input->post('base')['name']){
			$data['name']				=$this->input->post('base')['name'];
		}elseif(isset($layout_info)){
			$data['name']				=$layout_info['name'];
		}else{
			$data['name']				='';
		}
		
		if($this->input->post('route')){
			$data['routes']				=$this->input->post('route');
		}elseif(isset($layout_info['routes'])){
			$data['routes']				=$layout_info['routes'];
		}
		
		if($this->input->post('layout_module')){
			$data['layout_modules']				=$this->input->post('layout_module');
		}elseif(isset($layout_info['layout_modules'])){
			$data['layout_modules']				=$layout_info['layout_modules'];
		}
		
		$data['modules']				=$this->module_model->get_modules();
		
		$data['header']					=$this->header->index();
		$data['top']					=$this->header->top();
		$data['footer']					=$this->footer->index();
		
		$this->load->view('theme/default/template/common/layout_form',$data);
	}
	
	public function get_list(){
		if($this->input->get('page')){
			$data['page']				=$this->input->get('page');
		}else{
			$data['page']				='0';
		}
		$layouts=$this->layout_model->get_layouts($data);
		$data['count']					=$layouts['count'];
		$data['layouts']				=$layouts['layouts'];
		
		//分页
		$config['base_url'] 			= site_url('common/layout');
		$config['num_links'] 			= 2;
		$config['page_query_string'] 	= TRUE;
		$config['query_string_segment'] = 'page';
		$config['full_tag_open'] 		= '<nav class="text-left"><ul class="pagination">';
		$config['full_tag_close'] 		= '</ul>';
		$config['first_tag_open'] 		= '<li>';
		$config['first_tag_close'] 		= '</li>';
		$config['last_tag_open'] 		= '<li>';
		$config['last_tag_close'] 		= '</li>';
		$config['next_tag_open'] 		= '<li>';
		$config['next_tag_close'] 		= '</li>';
		$config['prev_tag_open'] 		= '<li>';
		$config['prev_tag_close'] 		= '</li>';
		$config['cur_tag_open'] 		= '<li class="active"><a>';
		$config['cur_tag_close'] 		= '</a></li>';
		$config['num_tag_open']			= '<li>';
		$config['num_tag_close']		= '</li>';
		$config['first_link'] 			= '<<';
		$config['last_link'] 			= '>>';
		$config['total_rows'] 			= $layouts['count'];
		$config['per_page'] 			= $this->config->get_config('config_limit_admin');

		$this->pagination->initialize($config);

		$data['pagination'] 			= $this->pagination->create_links();
		
		$data['delete']					=site_url('common/layout/delete');
		$data['header']					=$this->header->index();
		$data['top']					=$this->header->top();
		$data['footer']					=$this->footer->index();
		
		$this->load->view('theme/default/template/common/layout_list',$data);
	}
	
	public function validate_form(){
		
		
		if((utf8_strlen($this->input->post('base')['name']) < 2) || (utf8_strlen($this->input->post('base')['name']) > 255)){
			$this->error['error_name']='名称2——255字符';
		}
		
		return !$this->error;
	}
}
