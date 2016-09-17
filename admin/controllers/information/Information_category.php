<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Information_category extends MY_Controller{
	private $error = array();
	
	public function __construct(){
		parent::__construct();
		$this->load->language('information/information_category');
		$this->load->model(array('information/information_category_model','common/language_model'));
	}

	public function index(){
		$this->document->setTitle('分类管理');
		$this->get_list();
	}
	
	//修改
	public function edit(){
		$this->document->setTitle('分类编辑');
		
		if($_SERVER['REQUEST_METHOD']=="POST" && $this->validateForm()){
			$this->information_category_model->edit($this->input->post());
			
			redirect(site_url('information/information_category'), 'location', 301);
		}
		
		$this->get_form();
	}
	
	//添加
	public function add(){
		$this->document->setTitle('添加分类');
		
		if($_SERVER['REQUEST_METHOD']=="POST" && $this->validateForm()){
			$this->information_category_model->add($this->input->post());
			
			redirect(site_url('information/information_category'), 'location', 301);
		}
		
		$this->get_form();
	}
	
	//添加
	public function delete(){
		$this->document->setTitle('删除分类');
		if($this->validate_delete($this->input->post('selected'))){
			$this->information_category_model->delete($this->input->post('selected'));
			
			redirect(site_url('information/information_category'), 'location', 301);
		}
		$this->get_list();
	}
	
	//列表
	protected function get_list(){
		$data=array();
		
		$data['delete']					=site_url('information/information_category/delete');
		
		$information_categorys = $this->information_category_model->get_information_categorys($this->input->get('limit'));
		$data['information_categorys']=$information_categorys['information_categorys'];
		
		//分页
		$data['count'] = $information_categorys['count'];
		
		if(!$this->input->get('limit')){
			$limit = '0';
		}else{
			$limit = $this->input->get('limit');
		}
		
		
		$config['base_url'] = site_url('information/information_category');
		$config['num_links'] 			= 2;
		$config['page_query_string'] 	= TRUE;
		$config['query_string_segment'] = 'limit';
		$config['full_tag_open'] 		= '<ul class="pagination">';
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
		$config['total_rows'] 			= $information_categorys['count'];
		$config['per_page'] 			= $this->config->get_config('config_limit_admin');

		$this->pagination->initialize($config);

		$data['pagination'] = $this->pagination->create_links();
		
		$data['header']=$this->header->index();
		$data['top']=$this->header->top();
		$data['footer']=$this->footer->index();
		
		$this->load->view('theme/default/template/information/information_category_list',$data);
	}
	
	//修改分类
	protected function get_form(){
		$data=array();
		
		$data['languages'] = $this->language_model->get_languages();
		$data['cotegorys_select'] = $this->information_category_model->get_information_categorys_form();
		
		if(isset($this->error['warning'])){
			$data['error_warning'] = $this->error['warning'];
		} else{
			$data['error_warning'] = '';
		}

		if(isset($this->error['name'])){
			$data['error_name'] = $this->error['name'];
		} else{
			$data['error_name'] = array();
		}

		if(isset($this->error['description'])){
			$data['error_description'] = $this->error['description'];
		} else{
			$data['error_description'] = array();
		}
		
		$information_category_info = $this->information_category_model->get_information_category_info($this->input->get('information_category_id'));
		
		if($this->input->post('information_category_description')){
			$data['information_category_description']=$this->input->post('information_category_description');
		}elseif(isset($information_category_info['information_category_description'])){
			$data['information_category_description']=$information_category_info['information_category_description'];
		}
		
		if($this->input->post('base')['parent_id']){
			$data['parent_id']=$this->input->post('base')['parent_id'];
		}elseif(isset($information_category_info['parent_id'])){
			$data['parent_id']=$information_category_info['parent_id'];
		}else{
			$data['parent_id']='';
		}
		
		if($this->input->post('base')['sort_order']){
			$data['sort_order']=$this->input->post('base')['sort_order'];
		}elseif(isset($information_category_info['sort_order'])){
			$data['sort_order']=$information_category_info['sort_order'];
		}else{
			$data['sort_order']='';
		}
		
		if($this->input->post('base')['status']){
			$data['status']=$this->input->post('base')['status'];
		}elseif(isset($information_category_info['status'])){
			$data['status']=$information_category_info['status'];
		}else{
			$data['status']='';
		}
		
		if($this->input->post('base')['position']){
			$data['position']=$this->input->post('base')['position'];
		}elseif(isset($information_category_info['position'])){
			$data['position']=$information_category_info['position'];
		}else{
			$data['position']='';
		}
		
		if($this->input->get('information_category_id')){
			$data['action'] = site_url('information/information_category/edit?information_category_id=').$this->input->get('information_category_id');
		}else{
			$data['action'] = site_url('information/information_category/add');
		}
		
		$data['header']=$this->header->index();
		$data['top_nav']=$this->header->top();
		$data['footer']=$this->footer->index();
		
		$this->load->view('theme/default/template/information/information_category_form',$data);
	}
	
	//验证表单
	private function validateForm(){
		/*
		if (!$this->user->hasPermission('modify', 'information/information_category')) {
		$this->error['warning'] = '没有权限修改';
		}
		*/
		foreach($this->input->post('information_category_description') as $language_id => $value){
			if((utf8_strlen($value['name']) < 2) || (utf8_strlen($value['name']) > 255)){
				$this->error['name'][$language_id]['error_name'] = '分类名2——255字符';
			}

			if((utf8_strlen($value['description']) < 5) || (utf8_strlen($value['description']) > 2000)){
				$this->error['description'][$language_id]['error_description'] = '内容5——2000字符';
			}
		}

		return !$this->error;
	}
	
	//验证删除
	public function validate_delete($data){
		if($this->information_category_model->check_delete($this->input->post('selected'))){
			$this->error['wring_delete']='有一个删除的货币设置正在被使用';
		}
		
		return !$this->error;
	}
}
