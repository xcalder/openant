<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_class extends MY_Controller {
	
	private $error = array();
	
	public function __construct() {
		parent::__construct();
		$this->load->language('wecome');
		if(!$this->user->hasPermission('access', 'admin/user/user_class')){
			$this->session->set_flashdata('fali', '你没有访问权限！');
			redirect(site_url(), 'location', 301);
			exit;
		}
		$this->load->library(array('form_validation'));
		$this->load->model(array('common/user_class_model','common/language_model'));
	}

	public function index()
	{
		$this->document->setTitle('买家组列表');
		
		$this->get_list();
	}
	
	public function add()
	{
		$this->document->setTitle('买家组添加');
		
		if($_SERVER['REQUEST_METHOD']=="POST" && $this->valid_user_class_name($this->input->post('description'))){
			
			$this->user_class_model->add_user_class($this->input->post());
			
			redirect(site_url('user/user_class'), 'location', 301);
		}
		
		$this->get_from();
	}
	
	public function edit()
	{
		$this->document->setTitle('买家组修改');
		
		if($_SERVER['REQUEST_METHOD']=="POST" && $this->input->get('user_class_id') && $this->valid_user_class_name($this->input->post('description'))){
			//修改user_class表
			$user_classs				=$this->input->post('user_class');
			$user_classs['user_class_id']=$this->input->get('user_class_id');
			
			$this->user_class_model->edit_user_class($user_classs);
			
			//修改描述表
			$description				=$this->input->post('description');
			foreach($description as $key=>$value){
				$description[$key]['user_class_id']=$this->input->get('user_class_id');
				$description[$key]['language_id']=$key;
			}
			
			$this->user_class_model->edit_user_class_description($this->input->get('user_class_id'), $description);
			
			redirect(site_url('user/user_class'), 'location', 301);
		}
		
		$this->get_from();
	}
	
	public function delete (){
		$this->document->setTitle('删除买家组');
		
		if($_SERVER['REQUEST_METHOD']=="POST" && $this->valid_delete()){
			
			$this->user_class_model->delete($this->input->post('selected'));
			
			$this->session->set_flashdata('success', '成功：买家组删除成功！');
			redirect(site_url('user/user_class'), 'location', 301);
		}
		
		$this->get_list();
	}
	
	public function get_list(){
		$data=array();
		
		if($this->input->get('page')){
			$data['page']				=$this->input->get('page');
		}else{
			$data['page']				='0';
		}
		
		$user_classs					=$this->user_class_model->get_user_classs($data);
		$data['user_classs']			=$user_classs['user_classs'];
		
		//分页
		$config['base_url'] 			= site_url('user/user_class');
		$config['num_links'] 			= 2;
		$config['page_query_string'] 	= TRUE;
		$config['query_string_segment'] = 'page';
		$config['full_tag_open'] 		= '<div class="text-left pagination" style="float: left;padding: 6px 0px;margin: 5px 0">共'.@(floor($user_classs['count'] / $this->config->get_config ( 'config_limit_admin' )) + 1) .'页/第'.@(floor($data['page'] / $this->config->get_config ( 'config_limit_admin' )) + 1) .'页</div><ul class="pagination" style="float: right;margin: 5px 0">';
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
		$config['total_rows'] 			= $user_classs['count'];
		$config['per_page'] 			= $this->config->get_config('config_limit_admin');

		$this->pagination->initialize($config);

		$data['pagination'] 			= $this->pagination->create_links();
		
		$data['delete']					=site_url('user/user_class/delete');
		
		$data['header']=$this->header->index();
		$data['top']=$this->header->top();
		$data['footer']=$this->footer->index();
		
		$this->load->view('theme/default/template/user/user_class_list',$data);
	}
	
	public function get_from()
	{
		$data=array();
		
		if($this->input->get('user_class_id') != NULL){
			$user_class_info=$this->user_class_model->get_user_class_from($this->input->get('user_class_id'));
		}
		
		if($this->input->post('description')){
			$data['description']=$this->input->post('description');
		}elseif(isset($user_class_info)){
			$data['description']=$user_class_info['description'];
		}
		
		if(isset($this->input->post('user_class')['level'])){
			$data['level']=$this->input->post('user_class')['level'];
		}elseif(isset($user_class_info['user_class']['level'])){
			$data['level']=$user_class_info['user_class']['level'];
		}
		
		if(isset($this->input->post('user_class')['sort_order'])){
			$data['sort_order']=$this->input->post('user_class')['sort_order'];
		}elseif(isset($user_class_info['user_class']['sort_order'])){
			$data['sort_order']=$user_class_info['user_class']['sort_order'];
		}
		
		$data['languages']				=$this->language_model->get_languages();
		
		$data['header']					=$this->header->index();
		$data['top']					=$this->header->top();
		$data['footer']					=$this->footer->index();
		
		$data['error']					=$this->error;
		
		if($this->input->get('user_class_id')){
			$data['action']=site_url('user/user_class/edit?user_class_id=').$this->input->get('user_class_id');
		}else{
			$data['action']=site_url('user/user_class/add');
		}
		
		$this->load->view('theme/default/template/user/user_class_from',$data);
	}
	
	private function valid_user_class_name($user_class_description){
		
		foreach($user_class_description as $key=>$value){
			if(!$this->form_validation->min_length($user_class_description[$key]['name'],'2') || !$this->form_validation->max_length($user_class_description[$key]['name'],'32')){
				$this->error[$key]['error_name']='名称长度2——32字符';
			}
			if(!isset($user_class_description[$key]['name']) || empty($user_class_description[$key]['name'])){
				$this->error[$key]['error_name']='名称不能为空';
			}
		}
		
		return !$this->error;
	}
	
	private function valid_delete()
	{
		foreach($this->input->post('selected') as $value){
			if($this->user_class_model->check_delete($value) === FALSE){
				$this->session->set_flashdata('fali', '警告：你正在删除的买家组被使用，无法删除！');
				return FALSE;
			}
		}
		return TRUE;
	}
}
