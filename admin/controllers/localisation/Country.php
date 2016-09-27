<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Country extends MY_Controller {
	private $error = array();
	
	public function __construct() {
		parent::__construct();
		$this->load->helper(array('utf8'));
		$this->load->language('wecome');
		if(!$this->user->hasPermission('access', 'admin/localisation/country')){
			$this->session->set_flashdata('fali', '你没有访问权限！');
			redirect(site_url());
			exit;
		}
		$this->load->library(array('form_validation'));
		$this->load->model(array('localisation/country_model', 'localisation/location_model', 'common/language_model'));
	}

	public function index(){
		$this->document->setTitle('国家设置设置');
		
		$this->get_list();
	}
	
	public function add()
	{
		$this->document->setTitle('添加国家设置设置');
		
		if($_SERVER['REQUEST_METHOD']=="POST" && $this->validate_form()){
			$this->country_model->add($this->input->post());
			
			redirect(site_url('localisation/country'));
		}
		
		$this->get_form();
	}
	
	public function edit()
	{
		$this->document->setTitle('修改国家设置设置');
		
		if($_SERVER['REQUEST_METHOD']=="POST" && $this->validate_form()){
			$this->country_model->edit($this->input->post());
			
			redirect(site_url('localisation/country'));
		}
		
		$this->get_form();
	}
	
	public function delete()
	{
		$this->document->setTitle('删除国家设置参数');
		
		if($_SERVER['REQUEST_METHOD']=="POST" && $this->validate_delete()){
			$this->country_model->delete($this->input->post('selected'));
			
			redirect(site_url('localisation/country'));
		}
		
		$this->get_list();
	}
	
	public function get_form()
	{
		if($this->input->get('country_id')){
			$country_info					=$this->country_model->get_country_form($this->input->get('country_id'));
		}
		
		if($this->input->post('description')){
			$data['description']			=$this->input->post('description');
		}elseif(isset($country_info['description'])){
			$data['description']			=$country_info['description'];
		}
		
		if($this->input->post('base')['iso_code_2']){
			$data['iso_code_2']			=$this->input->post('base')['iso_code_2'];
		}elseif(isset($country_info['iso_code_2'])){
			$data['iso_code_2']			=$country_info['iso_code_2'];
		}else{
			$data['iso_code_2']			='';
		}
		
		if($this->input->post('base')['iso_code_3']){
			$data['iso_code_3']			=$this->input->post('base')['iso_code_2'];
		}elseif(isset($country_info['iso_code_3'])){
			$data['iso_code_3']			=$country_info['iso_code_3'];
		}else{
			$data['iso_code_3']			='';
		}
		
		if($this->input->post('base')['address_format']){
			$data['address_format']			=$this->input->post('base')['address_format'];
		}elseif(isset($country_info['address_format'])){
			$data['address_format']			=$country_info['address_format'];
		}else{
			$data['address_format']			='';
		}
		
		if($this->input->post('base')['postcode_required']){
			$data['postcode_required']			=$this->input->post('base')['postcode_required'];
		}elseif(isset($country_info['postcode_required'])){
			$data['postcode_required']			=$country_info['postcode_required'];
		}else{
			$data['postcode_required']			='';
		}
		
		if($this->input->post('base')['status']){
			$data['status']			=$this->input->post('base')['status'];
		}elseif(isset($country_info['status'])){
			$data['status']			=$country_info['status'];
		}else{
			$data['status']			='';
		}
		
		if($this->input->get('country_id')){
			$data['action']					=site_url('localisation/country/edit?country_id=').$this->input->get('country_id');
		}else{
			$data['action']					=site_url('localisation/country/add');
		}
		
		if(isset($this->error['error_description'])){
			$data['error_description']		=$this->error['error_description'];
		}
		
		$data['languages']				=$this->language_model->get_languages();
		
		$data['header']=$this->header->index();
		$data['top']=$this->header->top();
		$data['footer']=$this->footer->index();
		$this->load->view('theme/default/template/localisation/country_form',$data);
	}

	public function get_list()
	{
		if($this->input->get('page')){
			$data['page']=$this->input->get('page');
		}else{
			$data['page']='0';
		}
		
		$countrys_info=$this->country_model->get_countrys_for_langugae_id($data);
		if($countrys_info){
			$data['countrys']			=$countrys_info['countrys'];
			$data['count']					=$countrys_info['count'];
		}
		
		
		//分页
		$config['base_url'] 			= site_url('localisation/country');
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
		$config['total_rows'] 			= $countrys_info['count'];
		$config['per_page'] 			= $this->config->get_config('config_limit_admin');

		$this->pagination->initialize($config);

		$data['pagination'] 			= $this->pagination->create_links();
		
		$data['delete']					=site_url('localisation/country/delete');
		
		$data['header']=$this->header->index();
		$data['top']=$this->header->top();
		$data['footer']=$this->footer->index();
		$this->load->view('theme/default/template/localisation/country_list',$data);
	}
	
	public function validate_delete(){
		if (!$this->user->hasPermission('modify', 'admin/localisation/country')) {
			$this->session->set_flashdata('danger', '你无权修改，请联系管理员！');
			$this->error['warning'] = '没有权限修改';
		}
		
		if($this->country_model->check_delete($this->input->post('selected'))){
			$this->error['wring_delete']='有一个删除的国家设置设置正在被使用';
		}
		
		return !$this->error;
	}
	
	//验证表单
	public function validate_form(){
		if (!$this->user->hasPermission('modify', 'admin/localisation/country')) {
			$this->session->set_flashdata('danger', '你无权修改，请联系管理员！');
			$this->error['warning'] = '没有权限修改';
		}
		
		$description=$this->input->post('description');
		foreach($description as $key=>$value){
			if((utf8_strlen($description[$key]['name']) < 2) || (utf8_strlen($description[$key]['name']) > 32)){
				$this->error['error_description'][$key]['error_name']='国家设置名称2——32字符';
			}
		}
		
		return !$this->error;
	}
	
	public function get_country()
	{
		$country_info = $this->location_model->get_country($this->input->get('country_id'));
		
		if ($country_info) {
			$json = array(
				'country_id'        => $country_info['country_id'],
				'name'              => $country_info['name'],
				'iso_code_2'        => $country_info['iso_code_2'],
				'iso_code_3'        => $country_info['iso_code_3'],
				'address_format'    => $country_info['address_format'],
				'postcode_required' => $country_info['postcode_required'],
				'zone'              => $this->location_model->get_zones($this->input->get('country_id')),
				'status'            => $country_info['status']
			);
		}
		
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($json));
		
	}
}
