<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Language extends MY_Controller {
	private $error = array();
	
	public function __construct() {
		parent::__construct();
		$this->load->helper(array('utf8'));
		$this->load->language('wecome');
		if(!$this->user->hasPermission('access', 'admin/localisation/language')){
			$this->session->set_flashdata('fali', '你没有访问权限！');
			redirect(site_url(), 'location', 301);
			exit;
		}
		$this->load->library(array('form_validation'));
		$this->load->model(array('common/language_model'));
	}

	public function index(){
		$this->document->setTitle('语言设置');
		
		$this->get_list();
	}
	
	public function add()
	{
		$this->document->setTitle('添加语言设置');
		
		if($_SERVER['REQUEST_METHOD']=="POST" && $this->validate_form()){
			$this->language_model->add($this->input->post());
			
			redirect(site_url('localisation/language'), 'location', 301);
		}
		
		$this->get_form();
	}
	
	public function edit()
	{
		$this->document->setTitle('修改语言设置');
		
		if($_SERVER['REQUEST_METHOD']=="POST" && $this->validate_form()){
			$this->language_model->edit($this->input->post());
			
			redirect(site_url('localisation/language'), 'location', 301);
		}
		
		$this->get_form();
	}
	
	public function delete()
	{
		$this->document->setTitle('删除语言参数');
		
		if($_SERVER['REQUEST_METHOD']=="POST" && $this->validate_delete()){
			$this->language_model->delete($this->input->post('selected'));
			
			redirect(site_url('localisation/language'), 'location', 301);
		}
		
		$this->get_list();
	}
	
	public function get_form()
	{
		if($this->input->get('language_id')){
			$language_info					=$this->language_model->get_language_edit($this->input->get('language_id'));
		}
		
		if($this->input->post('name')){
			$data['name']					=$this->input->post('name');
		}elseif(isset($language_info)){
			$data['name']					=$language_info['name'];
		}else{
			$data['name']					='';
		}
		
		if($this->input->post('code')){
			$data['code']					=$this->input->post('code');
		}elseif(isset($language_info)){
			$data['code']					=$language_info['code'];
		}else{
			$data['code']					='';
		}
		
		if($this->input->post('locale')){
			$data['locale']					=$this->input->post('locale');
		}elseif(isset($language_info)){
			$data['locale']					=$language_info['locale'];
		}else{
			$data['locale']					='';
		}
		
		if($this->input->post('image')){
			$data['image']					=$this->input->post('image');
		}elseif(isset($language_info)){
			$data['image']					=$language_info['image'];
		}else{
			$data['image']					='';
		}
		
		if($this->input->post('language_name')){
			$data['language_name']					=$this->input->post('language_name');
		}elseif(isset($language_info)){
			$data['language_name']					=$language_info['language_name'];
		}else{
			$data['language_name']					='';
		}
		
		if($this->input->post('sort_order')){
			$data['sort_order']					=$this->input->post('sort_order');
		}elseif(isset($language_info)){
			$data['sort_order']					=$language_info['sort_order'];
		}else{
			$data['sort_order']					='';
		}
		
		if($this->input->post('status')){
			$data['status']					=$this->input->post('status');
		}elseif(isset($language_info)){
			$data['status']					=$language_info['status'];
		}else{
			$data['status']					='1';
		}
		
		if($this->input->get('language_id')){
			$data['action']					=site_url('localisation/language/edit?language_id=').$this->input->get('language_id');
		}else{
			$data['action']					=site_url('localisation/language/add');
		}
		
		if(isset($this->error['error_name'])){
			$data['error_name']			=$this->error['error_name'];
		}
		
		if(isset($this->error['error_code'])){
			$data['error_code']				=$this->error['error_code'];
		}
		
		if(isset($this->error['error_image'])){
			$data['error_image']			=$this->error['error_image'];
		}
		
		if(isset($this->error['error_language_name'])){
			$data['error_language_name']	=$this->error['error_language_name'];
		}
		
		$data['header']=$this->header->index();
		$data['top']=$this->header->top();
		$data['footer']=$this->footer->index();
		$this->load->view('theme/default/template/localisation/language_form',$data);
	}

	public function get_list()
	{
		if($this->input->get('page')){
			$data['page']=$this->input->get('page');
		}else{
			$data['page']='0';
		}
		
		$languages_info=$this->language_model->get_languages_edit($data);
		
		if($languages_info){
			$data['languages_list']			=$languages_info['languages'];
			$data['count']					=$languages_info['count'];
		}
		
		
		//分页
		$config['base_url'] 			= site_url('localisation/language');
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
		$config['total_rows'] 			= $languages_info['count'];
		$config['per_page'] 			= $this->config->get_config('config_limit_admin');

		$this->pagination->initialize($config);

		$data['pagination'] 			= $this->pagination->create_links();
		
		$data['delete']					=site_url('localisation/language/delete');
		
		$data['header']=$this->header->index();
		$data['top']=$this->header->top();
		$data['footer']=$this->footer->index();
		$this->load->view('theme/default/template/localisation/language_list',$data);
	}
	
	public function validate_delete(){
		
		if($this->language_model->check_delete($this->input->post('selected'))){
			$this->error['wring_delete']='有一个删除的语言设置正在被使用';
		}
		
		return !$this->error;
	}
	
	//验证表单
	public function validate_form(){
		
		
		if((utf8_strlen($this->input->post('name')) < 2) || (utf8_strlen($this->input->post('name')) > 32)){
			$this->error['error_name']='语言名称2——32字符';
		}
		if((utf8_strlen($this->input->post('code')) < 1) || (utf8_strlen($this->input->post('code')) > 5)){
			$this->error['error_code']='语言标码1——5字符';
		}
		if((utf8_strlen($this->input->post('image')) < 1) || (utf8_strlen($this->input->post('image')) > 64)){
			$this->error['error_image']='语言标码1——64字符';
		}
		if((utf8_strlen($this->input->post('language_name')) < 1) || (utf8_strlen($this->input->post('language_name')) > 32)){
			$this->error['error_language_name']='语言所在文件1——64字符';
		}
		
		return !$this->error;
	}
}
