<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Option extends MY_Controller {
	private $error = array();
	
	public function __construct() {
		parent::__construct();
		$this->load->helper(array('utf8'));
		$this->load->language('wecome');
		$this->load->library(array('form_validation'));
		$this->load->model(array('common/option_model'));
	}

	public function index()
	{
		
		$this->document->setTitle('商品选项');
		
		$this->get_list();
	}
	
	public function edit_option()
	{
		$this->document->setTitle('修改选项');
		
		if($_SERVER['REQUEST_METHOD']=="POST" && $this->validate_option()){
			$data['option_id']=$this->input->get('option_id');
			$data['base']=$this->input->post('base');
			$data['description']=$this->input->post('description');
			
			$this->option_model->edit_option($data);
			
			redirect(site_url('product/option'), 'location', 301);
		}
		
		$this->get_form();
	}
	
	public function add_option()
	{
		$this->document->setTitle('添加选项');
		
		if($_SERVER['REQUEST_METHOD']=="POST" && $this->validate_option()){
			$data['base']=$this->input->post('base');
			$data['description']=$this->input->post('description');
			
			$this->option_model->add_option($data);
			
			redirect(site_url('product/option'), 'location', 301);
		}
		
		$this->get_form();
	}
	
	public function edit_option_group()
	{
		$this->document->setTitle('修改选项组');
		
		if($_SERVER['REQUEST_METHOD']=="POST" && $this->validate_option_group()){
			$data['option_group_id']=$this->input->get('option_group_id');
			$data['group_base']=$this->input->post('group_base');
			$data['group_description']=$this->input->post('group_description');
			
			$this->option_model->edit_option_group($data);
			
			redirect(site_url('product/option'), 'location', 301);
		}
		
		$this->get_form();
	}
	
	public function add_option_group()
	{
		$this->document->setTitle('添加选项组');
		
		if($_SERVER['REQUEST_METHOD']=="POST" && $this->validate_option_group()){
			$data['group_base']=$this->input->post('group_base');
			$data['group_description']=$this->input->post('group_description');
			
			$this->option_model->add_option_group($data);
			
			redirect(site_url('product/option'), 'location', 301);
		}
		
		$this->get_form();
	}
	
	public function delete_option()
	{
		$this->document->setTitle('删除选项');
		
		if(!empty($this->input->post('selected')) && $this->validate_delete_option($this->input->post('selected'))){
			$this->option_model->delete_option($this->input->post('selected'));
			
			redirect(site_url('product/option'), 'location', 301);
			
		}
		$this->get_list();
	}
	
	public function delete_option_group()
	{
		$this->document->setTitle('删除选项组');
		
		if(!empty($this->input->post('selected_group')) && $this->validate_delete_option_group($this->input->post('selected_group'))){
			$this->option_model->delete_option_group($this->input->post('selected_group'));
			
			redirect(site_url('product/option'), 'location', 301);
			
		}
		$this->get_list();
	}
	
	public function get_form()
	{
		$data['languages']				=$this->language_model->get_languages();
		$data['option_groups']		=$this->option_model->get_option_groups()['option_groups'];
		
		//商品选项
		if($this->input->get('option_id')){
			$option_info				=$this->option_model->get_option_arr($this->input->get('option_id'));
		}
		
		if($this->input->post('description')){
			$data['description']	=$this->input->post('description');
		}elseif(isset($option_info['description']) && $option_info['description']){
			$data['description']	=$option_info['description'];
		}
		
		if($this->input->post('base')['option_group_id']){
			$data['option_group_id']	=$this->input->post('base')['option_group_id'];
		}elseif(isset($option_info['option_group_id'])){
			$data['option_group_id']	=$option_info['option_group_id'];
		}
		
		if($this->input->post('base')['sort_order']){
			$data['option_sort_order']	=$this->input->post('base')['sort_order'];
		}elseif(isset($option_info['sort_order'])){
			$data['option_sort_order']	=$option_info['sort_order'];
		}
		
		//商品选项组
		if($this->input->get('option_group_id')){
			$option_group_info		=$this->option_model->get_option_group_arr($this->input->get('option_group_id'));
		}
		
		if($this->input->post('group_description')){
			$data['group_description']	=$this->input->post('group_description');
		}elseif(isset($option_group_info['description']) && $option_group_info['description']){
			$data['group_description']	=$option_group_info['description'];
		}
		
		if($this->input->post('group_base')['sort_order']){
			$data['option_group_sort_order']	=$this->input->post('group_base')['sort_order'];
		}elseif(isset($option_group_info['sort_order'])){
			$data['option_group_sort_order']	=$option_group_info['sort_order'];
		}
		
		if($this->input->post('group_base')['type']){
			$data['option_group_type']	=$this->input->post('group_base')['type'];
		}elseif(isset($option_group_info['type'])){
			$data['option_group_type']	=$option_group_info['type'];
		}
		
		if($this->input->post('group_base')['sale_type']){
			$data['option_group_sale_type']	=$this->input->post('group_base')['sale_type'];
		}elseif(isset($option_group_info['sale_type'])){
			$data['option_group_sale_type']	=$option_group_info['sale_type'];
		}
		
		
		if($this->input->get('option_id')){
			$data['option_action']	=site_url('product/option/edit_option?option_id=').$this->input->get('option_id');
		}else{
			$data['option_action']	=site_url('product/option/add_option');
		}
		
		if($this->input->get('option_group_id')){
			$data['option_group_action']	=site_url('product/option/edit_option_group?option_group_id=').$this->input->get('option_group_id');
		}else{
			$data['option_group_action']	=site_url('product/option/add_option_group');
		}
		
		if(isset($this->error['option_description'])){
			$data['error_option_description']=$this->error['option_description'];
		}
		
		if(isset($this->error['error_option_group_id'])){
			$data['error_option_group_id']=$this->error['error_option_group_id'];
		}
		
		if(isset($this->error['option_group_description'])){
			$data['option_group_description']=$this->error['option_group_description'];
		}
		
		$data['header']					=$this->header->index();
		$data['top']					=$this->header->top();
		$data['footer']					=$this->footer->index();
		
		$this->load->view('theme/default/template/product/option_form',$data);
	}
	
	public function get_list()
	{
		if($this->input->get('option_page')){
			$data['option_page']=$this->input->get('option_page');
		}else{
			$data['option_page']='0';
		}
		
		$options						=$this->option_model->get_options($data);
		$data['options']				=$options['options'];
		
		if($this->input->get('option_group_page')){
			$data['option_group_page']=$this->input->get('option_group_page');
		}else{
			$data['option_group_page']='0';
		}
		
		$option_groups				=$this->option_model->get_option_groups($data);
		$data['option_groups']		=$option_groups['option_groups'];
		
		//分页
		$config['base_url'] 			= site_url('product/option');
		$config['num_links'] 			= 2;
		$config['page_query_string'] 	= TRUE;
		$config['query_string_segment'] = 'option_page';
		$config['full_tag_open'] 		= '<div class="text-left pagination" style="float: left;padding: 6px 0px;margin: 5px 0">共'.@(floor($options['count'] / $this->config->get_config ( 'config_limit_admin' )) + 1) .'页/第'.@(floor($data['option_page'] / $this->config->get_config ( 'config_limit_admin' )) + 1) .'页</div><ul class="pagination" style="float: right;margin: 5px 0">';
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
		$config['total_rows'] 			= $options['count'];
		$config['per_page'] 			= $this->config->get_config('config_limit_admin');

		$this->pagination->initialize($config);

		$data['options_pagination'] = $this->pagination->create_links();
		
		//分页
		$config1['base_url'] 			= site_url('product/option');
		$config1['num_links'] 			= 2;
		$config1['page_query_string'] 	= TRUE;
		$config1['query_string_segment'] = 'option_group_page';
		$config1['full_tag_open'] 		= '<div class="text-left pagination" style="float: left;padding: 6px 0px;margin: 5px 0">共'.@(floor($option_groups['count'] / $this->config->get_config ( 'config_limit_admin' )) + 1) .'页/第'.@(floor($data['option_group_page'] / $this->config->get_config ( 'config_limit_admin' )) + 1) .'页</div><ul class="pagination" style="float: right;margin: 5px 0">';
		$config1['full_tag_close'] 		= '</ul>';
		$config1['first_tag_open'] 		= '<li>';
		$config1['first_tag_close'] 		= '</li>';
		$config1['last_tag_open'] 		= '<li>';
		$config1['last_tag_close'] 		= '</li>';
		$config1['next_tag_open'] 		= '<li>';
		$config1['next_tag_close'] 		= '</li>';
		$config1['prev_tag_open'] 		= '<li>';
		$config1['prev_tag_close'] 		= '</li>';
		$config1['cur_tag_open'] 		= '<li class="active"><a>';
		$config1['cur_tag_close'] 		= '</a></li>';
		$config1['num_tag_open']			= '<li>';
		$config1['num_tag_close']		= '</li>';
		$config1['first_link'] 			= '<<';
		$config1['last_link'] 			= '>>';
		$config1['total_rows'] 			= $option_groups['count'];
		$config1['per_page'] 			= $this->config->get_config('config_limit_admin');

		$this->pagination->initialize($config1);

		$data['option_group_pagination'] = $this->pagination->create_links();
		
		$data['option_delete']		=site_url('product/option/delete_option');
		$data['option_group_delete']	=site_url('product/option/delete_option_group');
		
		$data['header']					=$this->header->index();
		$data['top']					=$this->header->top();
		$data['footer']					=$this->footer->index();
		
		$this->load->view('theme/default/template/product/option_list',$data);
	}
	
	
	public function validate_delete_option($data){
		if(empty($data)){
			return FALSE;
		}
		
		foreach($data as $key=>$value){
			if($this->option_model->get_product_option_for_option_id($data[$key]) != FALSE){
				$this->error[$key]['error_option_delete']='正在在被使用';
			}
		}
		
		return !$this->error;
	}
	
	public function validate_delete_option_group($data){
		if(empty($data)){
			return FALSE;
		}
		
		foreach($data as $key=>$value){
			if($this->option_model->get_option_for_option_group_id($data[$key]) != FALSE){
				$this->error[$key]['error_option_group_delete']='正在在被使用';
			}
		}
		
		return !$this->error;
	}
	
	public function validate_option()
	{
		$description=$this->input->post('description');
		foreach($description as $key=>$value){
			if((utf8_strlen($description[$key]['name']) < 2) || (utf8_strlen($description[$key]['name']) > 255)){
				$this->error['option_description'][$key]['error_option_name']='选项名称2——255字符';
			}
		}
		
		if(!$this->form_validation->integer($this->input->post('base')['option_group_id'])){
			$this->error['error_option_group_id']='请选择选项组';
		}
		return !$this->error;
	}
	
	public function validate_option_group()
	{
		$description=$this->input->post('group_description');
		foreach($description as $key=>$value){
			if((utf8_strlen($description[$key]['option_group_name']) < 2) || (utf8_strlen($description[$key]['option_group_name']) > 255)){
				$this->error['option_group_description'][$key]['error_option_group_name']='选项组名称2——255字符';
			}
		}
		
		return !$this->error;
	}
}
