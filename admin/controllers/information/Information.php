<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class information extends MY_Controller{
	private $error = array();
	
	public function __construct(){
		parent::__construct();
		$this->load->language('information/information');
		if(!$this->user->hasPermission('access', 'admin/information/information')){
			$this->session->set_flashdata('fali', '你没有访问权限！');
			redirect(site_url());
			exit;
		}
		$this->load->model(array('information/information_model', 'information/information_category_model', 'common/language_model'));
	}

	public function index(){
		$this->document->setTitle('文章管理');
		$this->get_list();
	}
	
	//修改
	public function edit(){
		$this->document->setTitle('文章编辑');
		
		if($_SERVER['REQUEST_METHOD']=="POST" && $this->validateForm()){
			$this->information_model->edit($this->input->post());
			
			redirect(site_url('information/information'));
		}
		
		$this->get_form();
	}
	
	//添加
	public function add(){
		$this->document->setTitle('添加文章');
		
		if($_SERVER['REQUEST_METHOD']=="POST" && $this->validateForm()){
			$this->information_model->add($this->input->post());
			
			redirect(site_url('information/information'));
		}
		
		$this->get_form();
	}
	
	//添加
	public function delete(){
		$this->document->setTitle('删除文章');
		if($this->validate_delete($this->input->post('selected'))){
			$this->information_model->delete($this->input->post('selected'));
			
			redirect(site_url('information/information'));
		}
		$this->get_list();
	}
	
	//列表
	protected function get_list(){
		$data=array();
		
		$data['delete']					=site_url('information/information/delete');
		
		$informations = $this->information_model->get_informations($this->input->get('limit'));
		$data['informations']=$informations['informations'];
		//分页
		$data['count'] = $informations['count'];
		
		if(!$this->input->get('limit')){
			$limit = '0';
		}else{
			$limit = $this->input->get('limit');
		}
		
		
		$config['base_url'] 			= site_url('information/information');
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
		$config['total_rows'] 			= $informations['count'];
		$config['per_page'] 			= $this->config->get_config('config_limit_admin');

		$this->pagination->initialize($config);

		$data['pagination'] = $this->pagination->create_links();
		
		$data['header']=$this->header->index();
		$data['top']=$this->header->top();
		$data['footer']=$this->footer->index();
		
		$this->load->view('theme/default/template/information/information_list',$data);
	}
	
	//修改文章
	protected function get_form(){
		$data['languages'] = $this->language_model->get_languages();
		$data['information_categorys'] = $this->information_category_model->get_information_categorys_for_store();
		
		
		if(isset($this->error['warning'])){
			$data['error_warning'] = $this->error['warning'];
		}

		if(isset($this->error['information'])){
			$data['error_information'] = $this->error['information'];
		}
		
		$information_info = $this->information_model->get_information_info($this->input->get('information_id'));
		
		if($this->input->post('information_description')){
			$data['information_description']=$this->input->post('information_description');
		}elseif(isset($information_info['information_description'])){
			$data['information_description']=$information_info['information_description'];
		}
		
		if($this->input->post('base')['sort_order']){
			$data['sort_order']=$this->input->post('base')['sort_order'];
		}elseif(isset($information_info['sort_order'])){
			$data['sort_order']=$information_info['sort_order'];
		}else{
			$data['sort_order']='';
		}
		
		if($this->input->post('base')['status']){
			$data['status']=$this->input->post('base')['status'];
		}elseif(isset($information_info['status'])){
			$data['status']=$information_info['status'];
		}else{
			$data['status']='';
		}
		
		if($this->input->post('base')['information_category_id']){
			$data['information_category_id']=$this->input->post('base')['information_category_id'];
		}elseif(isset($information_info['information_category_id'])){
			$data['information_category_id']=$information_info['information_category_id'];
		}else{
			$data['information_category_id']='';
		}
		
		if($this->input->get('information_id')){
			$data['action'] = site_url('information/information/edit?information_id=').$this->input->get('information_id');
		}else{
			$data['action'] = site_url('information/information/add');
		}
		
		$data['header']=$this->header->index();
		$data['top_nav']=$this->header->top();
		$data['footer']=$this->footer->index();
		
		$this->load->view('theme/default/template/information/information_form',$data);
	}
	
	//验证表单
	private function validateForm(){
		if (!$this->user->hasPermission('modify', 'admin/information/information')) {
			$this->session->set_flashdata('danger', '你无权修改，请联系管理员！');
			$this->error['warning'] = '没有权限修改';
		}
		
		foreach($this->input->post('information_description') as $language_id => $value){
			if((utf8_strlen($value['title']) < 2) || (utf8_strlen($value['title']) > 255)){
				$this->error['information'][$language_id]['error_title'] = '文章名2——255字符';
			}

			if((utf8_strlen($value['description']) < 12) || (utf8_strlen($value['description']) > 20000)){
				$this->error['information'][$language_id]['error_description'] = '内容4——20000字符';
			}
		}

		return !$this->error;
	}
	
	//验证删除
	public function validate_delete($data){
		if (!$this->user->hasPermission('modify', 'admin/information/information')) {
			$this->session->set_flashdata('danger', '你无权修改，请联系管理员！');
			$this->error['warning'] = '没有权限修改';
		}
		
		if($this->information_model->check_delete($this->input->post('selected'))){
			$this->error['wring_delete']='有一个删除的货币设置正在被使用';
		}
		
		return !$this->error;
	}
}
