<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tax_rate extends MY_Controller {
	private $error = array();
	
	public function __construct() {
		parent::__construct();
		$this->load->helper(array('utf8'));
		$this->load->language('wecome');
		if(!$this->user->hasPermission('access', 'admin/localisation/tax_rate')){
			$this->session->set_flashdata('fali', '你没有访问权限！');
			redirect(site_url(), 'location', 301);
			exit;
		}
		$this->load->library(array('form_validation'));
		$this->load->model(array('localisation/geo_zone_model', 'localisation/Tax_rate_model', 'common/language_model', 'common/user_model'));
	}

	public function index(){
		$this->document->setTitle('税率设置');
		
		$this->get_list();
	}
	
	public function add()
	{
		$this->document->setTitle('添加税率设置');
		
		if($_SERVER['REQUEST_METHOD']=="POST" && $this->validate_form()){
			$this->Tax_rate_model->add($this->input->post());
			
			redirect(site_url('localisation/tax_rate'), 'location', 301);
		}
		
		$this->get_form();
	}
	
	public function edit()
	{
		$this->document->setTitle('修改税率设置');
		
		if($_SERVER['REQUEST_METHOD']=="POST" && $this->validate_form()){
			$this->Tax_rate_model->edit($this->input->post());
			
			redirect(site_url('localisation/tax_rate'), 'location', 301);
		}
		
		$this->get_form();
	}
	
	public function delete()
	{
		$this->document->setTitle('删除税率参数');
		
		if($_SERVER['REQUEST_METHOD']=="POST" && $this->validate_delete()){
			$this->Tax_rate_model->delete_tax_rate($this->input->post('selected'));
			
			redirect(site_url('localisation/tax_rate'), 'location', 301);
		}
		
		$this->get_list();
	}
	
	public function get_form()
	{
		if($this->input->get('tax_rate_id')){
			$tax_rate_info					=$this->Tax_rate_model->get_tax_rate_form($this->input->get('tax_rate_id'));
		}
		
		if($this->input->post('description')){
			$data['description']			=$this->input->post('description');
		}elseif(isset($tax_rate_info['description'])){
			$data['description']			=$tax_rate_info['description'];
		}
		
		if($this->input->post('base')['rate']){
			$data['rate']			=$this->input->post('base')['rate'];
		}elseif(isset($tax_rate_info['rate'])){
			$data['rate']			=$tax_rate_info['rate'];
		}else{
			$data['rate']			='';
		}
		
		if($this->input->post('base')['type']){
			$data['type']			=$this->input->post('base')['type'];
		}elseif(isset($tax_rate_info['rate'])){
			$data['type']			=$tax_rate_info['type'];
		}else{
			$data['type']			='F';
		}
		
		if($this->input->post('base')['geo_zone_id']){
			$data['geo_zone_id']			=$this->input->post('base')['geo_zone_id'];
		}elseif(isset($tax_rate_info['rate'])){
			$data['geo_zone_id']			=$tax_rate_info['geo_zone_id'];
		}else{
			$data['geo_zone_id']			='';
		}
		
		if($this->input->post('user_class')['user_class_id']){
			$data['user_class_id']			=$this->input->post('user_group')['user_class_id'];
		}elseif(isset($tax_rate_info['user_class_id'])){
			$data['user_class_id']			=$tax_rate_info['user_class_id'];
		}else{
			$data['user_class_id']			='';
		}
		
		if($this->input->get('tax_rate_id')){
			$data['action']					=site_url('localisation/tax_rate/edit?tax_rate_id=').$this->input->get('tax_rate_id');
		}else{
			$data['action']					=site_url('localisation/tax_rate/add');
		}
		
		if(isset($this->error['error_description'])){
			$data['error_description']		=$this->error['error_description'];
		}
		
		if(isset($this->error['error_rate'])){
			$data['error_rate']			=$this->error['error_rate'];
		}
		
		$data['languages']				=$this->language_model->get_languages();
		$data['user_groups']			=$this->user_model->get_user_groups_to_other();
		$data['geo_zones']				=$this->geo_zone_model->get_geo_zones_to_other();
		
		$data['header']=$this->header->index();
		$data['top']=$this->header->top();
		$data['footer']=$this->footer->index();
		$this->load->view('theme/default/template/localisation/tax_rate_form',$data);
	}

	public function get_list()
	{
		if($this->input->get('page')){
			$data['page']=$this->input->get('page');
		}else{
			$data['page']='0';
		}
		
		$tax_rates_info=$this->Tax_rate_model->get_tax_rates_for_langugae_id($data);
		if($tax_rates_info){
			$data['tax_rates']			=$tax_rates_info['tax_rates'];
			$data['count']					=$tax_rates_info['count'];
		}
		
		
		//分页
		$config['base_url'] 			= site_url('localisation/tax_rate');
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
		$config['total_rows'] 			= $tax_rates_info['count'];
		$config['per_page'] 			= $this->config->get_config('config_limit_admin');

		$this->pagination->initialize($config);

		$data['pagination'] 			= $this->pagination->create_links();
		
		$data['delete']					=site_url('localisation/tax_rate/delete');
		
		$data['header']=$this->header->index();
		$data['top']=$this->header->top();
		$data['footer']=$this->footer->index();
		$this->load->view('theme/default/template/localisation/tax_rate_list',$data);
	}
	
	public function validate_delete(){
		
		if($this->Tax_rate_model->check_delete_tax_rate($this->input->post('selected'))){
			$this->error['wring_delete']='有一个删除的税率设置正在被使用';
		}
		
		return !$this->error;
	}
	
	//验证表单
	public function validate_form(){
		
		$description=$this->input->post('description');
		foreach($description as $key=>$value){
			if((utf8_strlen($description[$key]['name']) < 2) || (utf8_strlen($description[$key]['name']) > 32)){
				$this->error['error_description'][$key]['error_name']='税率名称2——32字符';
			}
		}
		
		if((utf8_strlen($this->input->post('base')['rate']) < 1) || (utf8_strlen($this->input->post('base')['rate']) > 32)){
			$this->error['error_rate']='税率2——32字符';
		}
		
		return !$this->error;
	}
}
