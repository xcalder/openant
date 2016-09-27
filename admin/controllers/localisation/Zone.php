<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Zone extends MY_Controller {
	private $error = array();
	
	public function __construct() {
		parent::__construct();
		$this->load->helper(array('utf8'));
		$this->load->language('wecome');
		if(!$this->user->hasPermission('access', 'admin/localisation/zone')){
			$this->session->set_flashdata('fali', '你没有访问权限！');
			redirect(site_url());
			exit;
		}
		$this->load->library(array('form_validation'));
		$this->load->model(array('localisation/zone_model', 'localisation/country_model', 'common/language_model'));
	}

	public function index(){
		$this->document->setTitle('地区设置');
		
		$this->get_list();
	}
	
	public function add()
	{
		$this->document->setTitle('添加地区设置');
		
		if($_SERVER['REQUEST_METHOD']=="POST" && $this->validate_form()){
			$this->zone_model->add($this->input->post());
			
			redirect(site_url('localisation/zone'));
		}
		
		$this->get_form();
	}
	
	public function edit()
	{
		$this->document->setTitle('修改地区设置');
		
		if($_SERVER['REQUEST_METHOD']=="POST" && $this->validate_form()){
			$this->zone_model->edit($this->input->post());
			
			redirect(site_url('localisation/zone'));
		}
		
		$this->get_form();
	}
	
	public function delete()
	{
		$this->document->setTitle('删除地区参数');
		
		if($_SERVER['REQUEST_METHOD']=="POST" && $this->validate_delete()){
			$this->zone_model->delete($this->input->post('selected'));
			
			redirect(site_url('localisation/zone'));
		}
		
		$this->get_list();
	}
	
	public function get_form()
	{
		if($this->input->get('zone_id')){
			$zone_info					=$this->zone_model->get_zone_form($this->input->get('zone_id'));
		}
		
		if($this->input->post('description')){
			$data['description']			=$this->input->post('description');
		}elseif(isset($zone_info['description'])){
			$data['description']			=$zone_info['description'];
		}
		
		if($this->input->post('base')['code']){
			$data['code']			=$this->input->post('base')['code'];
		}elseif(isset($zone_info['code'])){
			$data['code']			=$zone_info['code'];
		}else{
			$data['code']			='';
		}
		
		if($this->input->post('base')['status']){
			$data['status']			=$this->input->post('base')['status'];
		}elseif(isset($zone_info['status'])){
			$data['status']			=$zone_info['status'];
		}else{
			$data['status']			='';
		}
		
		if($this->input->post('base')['country_id']){
			$data['country_id']			=$this->input->post('base')['country_id'];
		}elseif(isset($zone_info['country_id'])){
			$data['country_id']			=$zone_info['country_id'];
		}else{
			$data['country_id']			='';
		}
		
		if($this->input->get('zone_id')){
			$data['action']					=site_url('localisation/zone/edit?zone_id=').$this->input->get('zone_id');
		}else{
			$data['action']					=site_url('localisation/zone/add');
		}
		
		if(isset($this->error['error_description'])){
			$data['error_description']		=$this->error['error_description'];
		}
		
		$data['languages']				=$this->language_model->get_languages();
		$data['countrys']				=$this->country_model->get_countrys();
		
		$data['header']=$this->header->index();
		$data['top']=$this->header->top();
		$data['footer']=$this->footer->index();
		$this->load->view('theme/default/template/localisation/zone_form',$data);
	}

	public function get_list()
	{
		if($this->input->get('page')){
			$data['page']=$this->input->get('page');
		}else{
			$data['page']='0';
		}
		
		$zones_info=$this->zone_model->get_zones_for_langugae_id($data);
		if($zones_info){
			$data['zones']			=$zones_info['zones'];
			$data['count']					=$zones_info['count'];
		}
		
		
		//分页
		$config['base_url'] 			= site_url('localisation/zone');
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
		$config['total_rows'] 			= $zones_info['count'];
		$config['per_page'] 			= $this->config->get_config('config_limit_admin');

		$this->pagination->initialize($config);

		$data['pagination'] 			= $this->pagination->create_links();
		
		$data['delete']					=site_url('localisation/zone/delete');
		
		$data['header']=$this->header->index();
		$data['top']=$this->header->top();
		$data['footer']=$this->footer->index();
		$this->load->view('theme/default/template/localisation/zone_list',$data);
	}
	
	public function validate_delete(){
		if (!$this->user->hasPermission('modify', 'admin/localisation/zone')) {
			$this->session->set_flashdata('danger', '你无权修改，请联系管理员！');
			$this->error['warning'] = '没有权限修改';
		}
		
		if($this->zone_model->check_delete($this->input->post('selected'))){
			$this->error['wring_delete']='有一个删除的地区设置正在被使用';
		}
		
		return !$this->error;
	}
	
	//验证表单
	public function validate_form(){
		if (!$this->user->hasPermission('modify', 'admin/localisation/zone')) {
			$this->session->set_flashdata('danger', '你无权修改，请联系管理员！');
			$this->error['warning'] = '没有权限修改';
		}
		
		$description=$this->input->post('description');
		foreach($description as $key=>$value){
			if((utf8_strlen($description[$key]['zone_name']) < 2) || (utf8_strlen($description[$key]['zone_name']) > 32)){
				$this->error['error_description'][$key]['error_zone_name']='地区名称2——32字符';
			}
		}
		
		return !$this->error;
	}
}
