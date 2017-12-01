<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Plate extends MY_Controller{
	private $error = array();
	
	public function __construct(){
		parent::__construct();
		$this->load->language('extension_config/overall/plate_module');
		$this->load->model(array('bbs/bbs_model','common/language_model'));
		
		if(!$this->user->hasPermission('access', 'admin/extension_config/overall/plate')){
			$this->session->set_flashdata('fali', '你没有访问权限！');
			redirect($this->config->item('admin'));
			exit;
		}
	}

	public function index(){
		$this->document->setTitle('论坛版块管理');
		$this->get_list();
	}
	
	//修改
	public function edit(){
		$this->document->setTitle('论坛板块编辑');
		
		if($_SERVER['REQUEST_METHOD']=="POST" && $this->validateForm()){
			$this->bbs_model->edit($this->input->post());
			
			redirect($this->config->item('admin').'extension_config/overall/plate');
		}
		
		$this->get_form();
	}
	
	//添加
	public function add(){
		$this->document->setTitle('添加分类');
		
		if($_SERVER['REQUEST_METHOD']=="POST" && $this->validateForm()){
			$this->bbs_model->add($this->input->post());
			
			redirect($this->config->item('admin').'extension_config/overall/plate');
		}
		
		$this->get_form();
	}
	
	//添加
	public function delete(){
		$this->document->setTitle('删除板块');
		if($this->validate_delete($this->input->post('selected'))){
			$this->bbs_model->delete($this->input->post('selected'));
			
			redirect($this->config->item('admin').'extension_config/overall/plate');
		}
		$this->get_list();
	}
	
	//列表
	protected function get_list(){
		
		$data['delete']					=$this->config->item('admin').'extension_config/overall/plate/delete';
		
		$plates = $this->bbs_model->get_plates_for_list($this->input->get('page'));
		$data['plates']=$plates['plates'];
		
		//分页
		$data['count'] = $plates['count'];
		
		if(!$this->input->get('page')){
			$page = '0';
		}else{
			$page = $this->input->get('page');
		}
		
		$config['base_url'] = $this->config->item('admin').'extension_config/overall/plate';
		$config['num_links'] 			= 2;
		$config['page_query_string'] 	= TRUE;
		$config['query_string_segment'] = 'page';
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
		$config['total_rows'] 			= $plates['count'];
		$config['per_page'] 			= $this->config->get_config('config_limit_admin');

		$this->pagination->initialize($config);

		$data['pagination'] = $this->pagination->create_links();
		
		$data['header']=$this->header->index();
		$data['top']=$this->header->top();
		$data['footer']=$this->footer->index();
		
		$this->load->view('theme/default/template/extension_config/overall/plate_list',$data);
	}
	
	//修改分类
	protected function get_form(){
		$data['languages'] = $this->language_model->get_languages();
		
		if(isset($this->error['warning'])){
			$data['error_warning'] = $this->error['warning'];
		} else{
			$data['error_warning'] = '';
		}

		if(isset($this->error['title'])){
			$data['error_title'] = $this->error['title'];
		} else{
			$data['error_title'] = array();
		}

		if(isset($this->error['description'])){
			$data['error_description'] = $this->error['description'];
		} else{
			$data['error_description'] = array();
		}
		
		$plates = $this->bbs_model->get_plate_to_form($this->input->get('plate_id'));
	
		if($this->input->post('description')){
			$data['description']=$this->input->post('description');
		}elseif(isset($plates['description'])){
			$data['description']=$plates['description'];
		}
		
		if($this->input->post('base')['user_id']){
			$data['user_id']=$this->input->post('base')['user_id'];
		}elseif(isset($plates['user_id'])){
			$data['user_id']=$plates['user_id'];
		}else{
			$data['user_id']=$this->user->getID();
		}
		
		if($this->input->post('base')['label']){
			$data['label']=$this->input->post('base')['label'];
		}elseif(isset($plates['label'])){
			$data['label']=$plates['label'];
		}else{
			$data['label']='success';
		}
		
		if($this->input->post('base')['is_view']){
			$data['is_view']=$this->input->post('base')['is_view'];
		}elseif(isset($plates['is_view'])){
			$data['is_view']=$plates['is_view'];
		}else{
			$data['is_view']='1';
		}
		
		if($this->input->post('base')['is_menu']){
			$data['is_menu']=$this->input->post('base')['is_menu'];
		}elseif(isset($plates['is_menu'])){
			$data['is_menu']=$plates['is_menu'];
		}else{
			$data['is_menu']='1';
		}
		
		if($this->input->post('base')['allow_posting']){
			$data['allow_posting']=$this->input->post('base')['allow_posting'];
		}elseif(isset($plates['allow_posting'])){
			$data['allow_posting']=$plates['allow_posting'];
		}else{
			$data['allow_posting']='1';
		}
		
		if($this->input->post('base')['admin_ids']){
			$data['admin_ids']=$this->input->post('base')['admin_ids'];
		}elseif(isset($plates['admin_ids'])){
			$data['admin_ids']=$plates['admin_ids'];
		}else{
			$data['admin_ids']='';
		}
		
		if($this->input->get('plate_id')){
			$data['action'] = $this->config->item('admin').'extension_config/overall/plate/edit?plate_id='.$this->input->get('plate_id');
		}else{
			$data['action'] = $this->config->item('admin').'extension_config/overall/plate/add';
		}
		
		$data['header']=$this->header->index();
		$data['top_nav']=$this->header->top();
		$data['footer']=$this->footer->index();
		
		$this->load->view('theme/default/template/extension_config/overall/plate_form',$data);
	}
	
	//验证表单
	private function validateForm(){
		
		if (!$this->user->hasPermission('modify', 'admin/extension_config/overall/plate')) {
			$this->error['warning'] = '没有权限修改';
		}
		
		foreach($this->input->post('description') as $language_id => $value){
			if((utf8_strlen($value['title']) < 2) || (utf8_strlen($value['title']) > 30)){
				$this->error['title'][$language_id]['error_title'] = '分类名2——30字符';
			}

			if((utf8_strlen($value['description']) < 5) || (utf8_strlen($value['description']) > 255)){
				$this->error['description'][$language_id]['error_description'] = '内容5——255字符';
			}
		}

		return !$this->error;
	}
	
	//验证删除
	public function validate_delete($data){
		if (!$this->user->hasPermission('modify', 'admin/extension_config/overall/plate')) {
			$this->error['warning'] = '没有权限修改';
			$this->session->set_flashdata('danger', '你无权修改，请联系管理员！');
		}
		
		if($this->bbs_model->check_delete($this->input->post('selected'))){
			$this->error['wring_delete']='有一个待删除的板块正在被使用';
		}
		
		return !$this->error;
	}
}
