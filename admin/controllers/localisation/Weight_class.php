<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Weight_class extends MY_Controller {
	private $error = array();
	
	public function __construct() {
		parent::__construct();
		$this->load->helper(array('utf8'));
		$this->load->language('wecome');
		if(!$this->user->hasPermission('access', 'admin/localisation/weight_class')){
			$this->session->set_flashdata('fali', '你没有访问权限！');
			redirect(site_url());
			exit;
		}
		$this->load->library(array('form_validation'));
		$this->load->model(array('localisation/weight_class_model', 'common/language_model'));
	}

	public function index(){
		$this->document->setTitle('重量设置');
		
		$this->get_list();
	}
	
	public function add()
	{
		$this->document->setTitle('添加重量设置');
		
		if($_SERVER['REQUEST_METHOD']=="POST" && $this->validate_form()){
			$this->weight_class_model->add($this->input->post());
			
			redirect(site_url('localisation/weight_class'));
		}
		
		$this->get_form();
	}
	
	public function edit()
	{
		$this->document->setTitle('修改重量设置');
		
		if($_SERVER['REQUEST_METHOD']=="POST" && $this->validate_form()){
			$this->weight_class_model->edit($this->input->post());
			
			redirect(site_url('localisation/weight_class'));
		}
		
		$this->get_form();
	}
	
	public function delete()
	{
		$this->document->setTitle('删除重量参数');
		
		if($_SERVER['REQUEST_METHOD']=="POST" && $this->validate_delete()){
			$this->weight_class_model->delete($this->input->post('selected'));
			
			redirect(site_url('localisation/weight_class'));
		}
		
		$this->get_list();
	}
	
	public function get_form()
	{
		if($this->input->get('weight_class_id')){
			$weight_class_info					=$this->weight_class_model->get_weight_class_form($this->input->get('weight_class_id'));
		}
		
		if($this->input->post('description')){
			$data['description']			=$this->input->post('description');
		}elseif(isset($weight_class_info['description'])){
			$data['description']			=$weight_class_info['description'];
		}
		
		if($this->input->post('base')['value']){
			$data['value']			=$this->input->post('base')['value'];
		}elseif(isset($weight_class_info['value'])){
			$data['value']			=$weight_class_info['value'];
		}else{
			$data['value']			='';
		}
		
		if($this->input->get('weight_class_id')){
			$data['action']					=site_url('localisation/weight_class/edit?weight_class_id=').$this->input->get('weight_class_id');
		}else{
			$data['action']					=site_url('localisation/weight_class/add');
		}
		
		if(isset($this->error['error_description'])){
			$data['error_description']		=$this->error['error_description'];
		}
		
		$data['languages']				=$this->language_model->get_languages();
		
		$data['header']=$this->header->index();
		$data['top']=$this->header->top();
		$data['footer']=$this->footer->index();
		$this->load->view('theme/default/template/localisation/weight_class_form',$data);
	}

	public function get_list()
	{
		if($this->input->get('page')){
			$data['page']=$this->input->get('page');
		}else{
			$data['page']='0';
		}
		
		$weight_classs_info=$this->weight_class_model->get_weight_classs_for_langugae_id($data);
		if($weight_classs_info){
			$data['weight_classs']			=$weight_classs_info['weight_classs'];
			$data['count']					=$weight_classs_info['count'];
		}
		
		
		//分页
		$config['base_url'] 			= site_url('localisation/weight_class');
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
		$config['total_rows'] 			= $weight_classs_info['count'];
		$config['per_page'] 			= $this->config->get_config('config_limit_admin');

		$this->pagination->initialize($config);

		$data['pagination'] 			= $this->pagination->create_links();
		
		$data['delete']					=site_url('localisation/weight_class/delete');
		
		$data['header']=$this->header->index();
		$data['top']=$this->header->top();
		$data['footer']=$this->footer->index();
		$this->load->view('theme/default/template/localisation/weight_class_list',$data);
	}
	
	public function validate_delete(){
		if (!$this->user->hasPermission('modify', 'admin/localisation/weight_class')) {
			$this->session->set_flashdata('danger', '你无权修改，请联系管理员！');
			$this->error['warning'] = '没有权限修改';
		}
		
		if($this->weight_class_model->check_delete($this->input->post('selected'))){
			$this->error['wring_delete']='有一个删除的重量设置正在被使用';
		}
		
		return !$this->error;
	}
	
	//验证表单
	public function validate_form(){
	if (!$this->user->hasPermission('modify', 'admin/localisation/weight_class')) {
			$this->session->set_flashdata('danger', '你无权修改，请联系管理员！');
			$this->error['warning'] = '没有权限修改';
		}
		
		$description=$this->input->post('description');
		foreach($description as $key=>$value){
			if((utf8_strlen($description[$key]['title']) < 2) || (utf8_strlen($description[$key]['title']) > 32)){
				$this->error['error_description'][$key]['error_title']='重量名称2——32字符';
			}
			
			if((utf8_strlen($description[$key]['unit']) < 1) || (utf8_strlen($description[$key]['unit']) > 4)){
				$this->error['error_description'][$key]['error_unit']='重量名称1——4字符';
			}
		}
		
		return !$this->error;
	}
}
