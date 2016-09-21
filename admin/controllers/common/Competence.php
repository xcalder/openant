<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Competence extends MY_Controller {
	private $error = array();
	
	public function __construct() {
		parent::__construct();
		$this->load->helper(array('utf8'));
		$this->load->language('wecome');
		if(!$this->user->hasPermission('access', 'admin/common/competence')){
			$this->session->set_flashdata('fali', '你没有访问权限！');
			redirect(site_url(), 'location', 301);
			exit;
		}
		$this->load->library(array('form_validation'));
		$this->load->model(array('common/competence_model', 'common/language_model'));
	}

	public function index(){
		$this->document->setTitle('权限设置');
		
		$this->get_list();
	}
	
	public function add()
	{
		$this->document->setTitle('添加权限设置');
		
		if($_SERVER['REQUEST_METHOD']=="POST" && $this->validate_form()){
			$this->competence_model->add($this->input->post());
			
			redirect(site_url('common/competence'), 'location', 301);
		}
		
		$this->get_form();
	}
	
	public function edit()
	{
		$this->document->setTitle('修改权限设置');
		
		if($_SERVER['REQUEST_METHOD']=="POST" && $this->validate_form()){
			$this->competence_model->edit($this->input->post());
			
			redirect(site_url('common/competence'), 'location', 301);
		}
		
		$this->get_form();
	}
	
	public function delete()
	{
		$this->document->setTitle('删除权限参数');
		
		if($_SERVER['REQUEST_METHOD']=="POST"){
			$this->competence_model->delete($this->input->post('selected'));
			
			redirect(site_url('common/competence'), 'location', 301);
		}
		
		$this->get_list();
	}
	
	public function get_form()
	{
		if($this->input->get('competence_id')){
			$competence_info					=$this->competence_model->get_competence_form($this->input->get('competence_id'));
		}
		
		if($this->input->post('description')){
			$data['description']			=$this->input->post('description');
		}elseif(isset($competence_info['description'])){
			$data['description']			=$competence_info['description'];
		}
		
		if($this->input->post('base')['key']){
			$data['key']			=$this->input->post('base')['key'];
		}elseif(isset($competence_info['key'])){
			$data['key']			=$competence_info['key'];
		}else{
			$data['key']			='';
		}
		
		if($this->input->post('base')['value']){
			$data['value']			=$this->input->post('base')['value'];
		}elseif(isset($competence_info['value'])){
			$data['value']			=$competence_info['value'];
		}else{
			$data['value']			='';
		}
		
		if($this->input->post('base')['sort_order']){
			$data['sort_order']			=$this->input->post('base')['sort_order'];
		}elseif(isset($competence_info['sort_order'])){
			$data['sort_order']			=$competence_info['sort_order'];
		}else{
			$data['sort_order']			='0';
		}
		
		if($this->input->get('competence_id')){
			$data['action']					=site_url('common/competence/edit?competence_id=').$this->input->get('competence_id');
		}else{
			$data['action']					=site_url('common/competence/add');
		}
		
		if(isset($this->error['error_description'])){
			$data['error_description']		=$this->error['error_description'];
		}
		
		$data['languages']				=$this->language_model->get_languages();
		
		$data['header']=$this->header->index();
		$data['top']=$this->header->top();
		$data['footer']=$this->footer->index();
		$this->load->view('theme/default/template/common/competence_form',$data);
	}

	public function get_list()
	{
		if($this->input->get('page')){
			$data['page']=$this->input->get('page');
		}else{
			$data['page']='0';
		}
		
		$competences_info=$this->competence_model->get_competences_for_langugae_id($data);
		if($competences_info){
			$data['competences']			=$competences_info['competences'];
			$data['count']					=$competences_info['count'];
		}
		
		
		//分页
		$config['base_url'] 			= site_url('common/competence');
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
		$config['total_rows'] 			= $competences_info['count'];
		$config['per_page'] 			= $this->config->get_config('config_limit_admin');

		$this->pagination->initialize($config);

		$data['pagination'] 			= $this->pagination->create_links();
		
		$data['delete']					=site_url('common/competence/delete');
		
		$data['header']=$this->header->index();
		$data['top']=$this->header->top();
		$data['footer']=$this->footer->index();
		$this->load->view('theme/default/template/common/competence_list',$data);
	}

	//验证表单
	public function validate_form(){
		
		$description=$this->input->post('description');
		foreach($description as $key=>$value){
			if((utf8_strlen($description[$key]['title']) < 2) || (utf8_strlen($description[$key]['title']) > 32)){
				$this->error['error_description'][$key]['error_title']='权限名称2——32字符';
			}
		}
		
		return !$this->error;
	}
}
