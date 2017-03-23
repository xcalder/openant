<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tax_class extends MY_Controller {
	private $error = array();
	
	public function __construct() {
		parent::__construct();
		$this->load->helper(array('utf8'));
		$this->load->language('wecome');
		if(!$this->user->hasPermission('access', 'admin/localisation/tax_class')){
			$this->session->set_flashdata('fali', '你没有访问权限！');
			redirect($this->config->item('admin'));
			exit;
		}
		$this->load->library(array('form_validation'));
		$this->load->model(array('localisation/geo_zone_model', 'localisation/tax_class_model', 'common/language_model', 'common/user_model', 'localisation/tax_rate_model'));
	}

	public function index(){
		$this->document->setTitle('税率组设置');
		
		$this->get_list();
	}
	
	public function add()
	{
		$this->document->setTitle('添加税率组设置');
		
		if($_SERVER['REQUEST_METHOD']=="POST" && $this->validate_form()){
			$this->tax_class_model->add($this->input->post());
			
			redirect($this->config->item('admin').'localisation/tax_class');
		}
		
		$this->get_form();
	}
	
	public function edit()
	{
		$this->document->setTitle('修改税率组设置');
		
		if($_SERVER['REQUEST_METHOD']=="POST" && $this->validate_form()){
			$this->tax_class_model->edit($this->input->post());
			
			redirect($this->config->item('admin').'localisation/tax_class');
		}
		
		$this->get_form();
	}
	
	public function delete()
	{
		$this->document->setTitle('删除税率组参数');
		
		if($_SERVER['REQUEST_METHOD']=="POST" && $this->validate_delete()){
			$this->tax_class_model->delete_tax_class($this->input->post('selected'));
			
			redirect($this->config->item('admin').'localisation/tax_class');
		}
		
		$this->get_list();
	}
	
	public function get_form()
	{
		if($this->input->get('tax_class_id')){
			$tax_class_info					=$this->tax_class_model->get_tax_class_form($this->input->get('tax_class_id'));
		}
		
		if($this->input->post('description')){
			$data['description']			=$this->input->post('description');
		}elseif(isset($tax_class_info['description'])){
			$data['description']			=$tax_class_info['description'];
		}
		
		if($this->input->post('tax_rule')){
			$data['tax_rules']			=$this->input->post('tax_rule');
		}elseif(isset($tax_class_info['tax_rule'])){
			$data['tax_rules']			=$tax_class_info['tax_rule'];
		}
		
		if($this->input->get('tax_class_id')){
			$data['action']					=$this->config->item('admin').'localisation/tax_class/edit?tax_class_id='.$this->input->get('tax_class_id');
		}else{
			$data['action']					=$this->config->item('admin').'localisation/tax_class/add';
		}
		
		if(isset($this->error['error_description'])){
			$data['error_description']		=$this->error['error_description'];
		}
		
		$data['languages']				=$this->language_model->get_languages();
		$data['user_groups']			=$this->user_model->get_user_groups_to_other();
		$data['geo_zones']				=$this->geo_zone_model->get_geo_zones_to_other();
		$data['tax_rates']				=$this->tax_rate_model->get_tax_rates();
		
		$data['header']=$this->header->index();
		$data['top']=$this->header->top();
		$data['footer']=$this->footer->index();
		$this->load->view('theme/default/template/localisation/tax_class_form',$data);
	}

	public function get_list()
	{
		if($this->input->get('page')){
			$data['page']=$this->input->get('page');
		}else{
			$data['page']='0';
		}
		
		$tax_classs_info=$this->tax_class_model->get_tax_classs_for_langugae_id($data);
		if($tax_classs_info){
			$data['tax_classs']			=$tax_classs_info['tax_classs'];
			$data['count']					=$tax_classs_info['count'];
		}
		
		
		//分页
		$config['base_url'] 			= $this->config->item('admin').'localisation/tax_class';
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
		$config['total_rows'] 			= $tax_classs_info['count'];
		$config['per_page'] 			= $this->config->get_config('config_limit_admin');

		$this->pagination->initialize($config);

		$data['pagination'] 			= $this->pagination->create_links();
		
		$data['delete']					=$this->config->item('admin').'localisation/tax_class/delete';
		
		$data['header']=$this->header->index();
		$data['top']=$this->header->top();
		$data['footer']=$this->footer->index();
		$this->load->view('theme/default/template/localisation/tax_class_list',$data);
	}
	
	public function validate_delete(){
		if (!$this->user->hasPermission('modify', 'admin/localisation/tax_class')) {
			$this->session->set_flashdata('danger', '你无权修改，请联系管理员！');
			$this->error['warning'] = '没有权限修改';
		}
		
		if($this->tax_class_model->check_delete_tax_class($this->input->post('selected'))){
			$this->error['wring_delete']='有一个删除的税率组设置正在被使用';
		}
		
		return !$this->error;
	}
	
	//验证表单
	public function validate_form(){
		if (!$this->user->hasPermission('modify', 'admin/localisation/tax_class')) {
			$this->session->set_flashdata('danger', '你无权修改，请联系管理员！');
			$this->error['warning'] = '没有权限修改';
		}
		
		$description=$this->input->post('description');
		foreach($description as $key=>$value){
			if((utf8_strlen($description[$key]['title']) < 2) || (utf8_strlen($description[$key]['title']) > 32)){
				$this->error['error_description'][$key]['error_title']='税率组名称2——32字符';
			}
			
			if((utf8_strlen($description[$key]['description']) < 2) || (utf8_strlen($description[$key]['description']) > 64)){
				$this->error['error_description'][$key]['error_description']='税率组描述2——32字符';
			}
		}
		
		return !$this->error;
	}
}
