<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Attribute extends MY_Controller {
	private $error = array();
	
	public function __construct() {
		parent::__construct();
		$this->load->helper(array('utf8'));
		$this->load->language('wecome');
		if(!$this->user->hasPermission('access', 'admin/product/attribute')){
			$this->session->set_flashdata('fali', '你没有访问权限！');
			redirect($this->config->item('admin'));
			exit;
		}
		$this->load->library(array('form_validation'));
		$this->load->model(array('common/attribute_model'));
	}

	public function index()
	{
		
		$this->document->setTitle('商品属性');
		
		$this->get_list();
	}
	
	public function edit_attribute()
	{
		$this->document->setTitle('修改属性');
		
		if($_SERVER['REQUEST_METHOD']=="POST" && $this->validate_attribute()){
			$data['attribute_id']=$this->input->get('attribute_id');
			$data['base']=$this->input->post('base');
			$data['description']=$this->input->post('description');
			
			$this->attribute_model->edit_attribute($data);
			
			redirect($this->config->item('admin').'product/attribute');
		}
		
		$this->get_form();
	}
	
	public function add_attribute()
	{
		$this->document->setTitle('添加属性');
		
		if($_SERVER['REQUEST_METHOD']=="POST" && $this->validate_attribute()){
			$data['base']=$this->input->post('base');
			$data['description']=$this->input->post('description');
			
			$this->attribute_model->add_attribute($data);
			
			redirect($this->config->item('admin').'product/attribute');
		}
		
		$this->get_form();
	}
	
	public function edit_attribute_group()
	{
		$this->document->setTitle('修改属性组');
		
		if($_SERVER['REQUEST_METHOD']=="POST" && $this->validate_attribute_group()){
			$data['attribute_group_id']=$this->input->get('attribute_group_id');
			$data['group_base']=$this->input->post('group_base');
			$data['group_description']=$this->input->post('group_description');
			
			$this->attribute_model->edit_attribute_group($data);
			
			redirect($this->config->item('admin').'product/attribute');
		}
		
		$this->get_form();
	}
	
	public function add_attribute_group()
	{
		$this->document->setTitle('添加属性组');
		
		if($_SERVER['REQUEST_METHOD']=="POST" && $this->validate_attribute_group()){
			$data['group_base']=$this->input->post('group_base');
			$data['group_description']=$this->input->post('group_description');
			
			$this->attribute_model->add_attribute_group($data);
			
			redirect($this->config->item('admin').'product/attribute');
		}
		
		$this->get_form();
	}
	
	public function delete_attribute()
	{
		$this->document->setTitle('删除属性');
		
		if(!empty($this->input->post('selected')) && $this->validate_delete_attribute($this->input->post('selected'))){
			$this->attribute_model->delete_attribute($this->input->post('selected'));
			
			redirect($this->config->item('admin').'product/attribute');
			
		}
		$this->get_list();
	}
	
	public function delete_attribute_group()
	{
		$this->document->setTitle('删除属性组');
		
		if(!empty($this->input->post('selected_group')) && $this->validate_delete_attribute_group($this->input->post('selected_group'))){
			$this->attribute_model->delete_attribute_group($this->input->post('selected_group'));
			
			redirect($this->config->item('admin').'product/attribute');
			
		}
		$this->get_list();
	}
	
	public function get_form()
	{
		$data['languages']				=$this->language_model->get_languages();
		$data['attribute_groups']		=$this->attribute_model->get_attribute_groups()['attribute_groups'];
		
		//商品属性
		if($this->input->get('attribute_id')){
			$attribute_info				=$this->attribute_model->get_attribute_arr($this->input->get('attribute_id'));
		}
		
		if($this->input->post('description')){
			$data['description']	=$this->input->post('description');
		}elseif(isset($attribute_info['description']) && $attribute_info['description']){
			$data['description']	=$attribute_info['description'];
		}
		
		if($this->input->post('base')['attribute_group_id']){
			$data['attribute_group_id']	=$this->input->post('base')['attribute_group_id'];
		}elseif(isset($attribute_info['attribute_group_id'])){
			$data['attribute_group_id']	=$attribute_info['attribute_group_id'];
		}
		
		if($this->input->post('base')['sort_order']){
			$data['attribute_sort_order']	=$this->input->post('base')['sort_order'];
		}elseif(isset($attribute_info['sort_order'])){
			$data['attribute_sort_order']	=$attribute_info['sort_order'];
		}
		
		//商品属性组
		if($this->input->get('attribute_group_id')){
			$attribute_group_info		=$this->attribute_model->get_attribute_group_arr($this->input->get('attribute_group_id'));
		}
		
		if($this->input->post('group_description')){
			$data['group_description']	=$this->input->post('group_description');
		}elseif(isset($attribute_group_info['description']) && $attribute_group_info['description']){
			$data['group_description']	=$attribute_group_info['description'];
		}
		
		if($this->input->post('group_base')['sort_order']){
			$data['attribute_group_sort_order']	=$this->input->post('group_base')['sort_order'];
		}elseif(isset($attribute_group_info['sort_order'])){
			$data['attribute_group_sort_order']	=$attribute_group_info['sort_order'];
		}
		
		if($this->input->post('group_base')['sale_type']){
			$data['attribute_group_sale_type']	=$this->input->post('group_base')['sale_type'];
		}elseif(isset($attribute_group_info['sale_type'])){
			$data['attribute_group_sale_type']	=$attribute_group_info['sale_type'];
		}
		
		
		if($this->input->get('attribute_id')){
			$data['attribute_action']	=$this->config->item('admin').'product/attribute/edit_attribute?attribute_id='.$this->input->get('attribute_id');
		}else{
			$data['attribute_action']	=$this->config->item('admin').'product/attribute/add_attribute';
		}
		
		if($this->input->get('attribute_group_id')){
			$data['attribute_group_action']	=$this->config->item('admin').'product/attribute/edit_attribute_group?attribute_group_id='.$this->input->get('attribute_group_id');
		}else{
			$data['attribute_group_action']	=$this->config->item('admin').'product/attribute/add_attribute_group';
		}
		
		if(isset($this->error['attribute_description'])){
			$data['error_attribute_description']=$this->error['attribute_description'];
		}
		
		if(isset($this->error['error_attribute_group_id'])){
			$data['error_attribute_group_id']=$this->error['error_attribute_group_id'];
		}
		
		if(isset($this->error['attribute_group_description'])){
			$data['attribute_group_description']=$this->error['attribute_group_description'];
		}
		
		$data['header']					=$this->header->index();
		$data['top']					=$this->header->top();
		$data['footer']					=$this->footer->index();
		
		$this->load->view('theme/default/template/product/attribute_form',$data);
	}
	
	public function get_list()
	{
		if($this->input->get('attribute_page')){
			$data['attribute_page']=$this->input->get('attribute_page');
		}else{
			$data['attribute_page']='0';
		}
		
		$attributes						=$this->attribute_model->get_attributes($data);
		$data['attributes']				=$attributes['attributes'];
		
		if($this->input->get('attribute_group_page')){
			$data['attribute_group_page']=$this->input->get('attribute_group_page');
		}else{
			$data['attribute_group_page']='0';
		}
		
		$attribute_groups				=$this->attribute_model->get_attribute_groups($data);
		$data['attribute_groups']		=$attribute_groups['attribute_groups'];
		
		//分页
		$config['base_url'] 			= $this->config->item('admin').'product/attribute';
		$config['num_links'] 			= 2;
		$config['page_query_string'] 	= TRUE;
		$config['query_string_segment'] = 'attribute_page';
		$config['full_tag_open'] 		= '<div class="text-left pagination" style="float: left;padding: 6px 0px;margin: 5px 0">共'.@(floor($attributes['count'] / $this->config->get_config ( 'config_limit_admin' )) + 1) .'页/第'.@(floor($data['attribute_page'] / $this->config->get_config ( 'config_limit_admin' )) + 1) .'页</div><ul class="pagination" style="float: right;margin: 5px 0">';
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
		$config['total_rows'] 			= $attributes['count'];
		$config['per_page'] 			= $this->config->get_config('config_limit_admin');

		$this->pagination->initialize($config);

		$data['attributes_pagination'] = $this->pagination->create_links();
		
		//分页
		$config1['base_url'] 			= $this->config->item('admin').'product/attribute';
		$config1['num_links'] 			= 2;
		$config1['page_query_string'] 	= TRUE;
		$config1['query_string_segment'] = 'attribute_group_page';
		$config1['full_tag_open'] 		= '<div class="text-left pagination" style="float: left;padding: 6px 0px;margin: 5px 0">共'.@(floor($attribute_groups['count'] / $this->config->get_config ( 'config_limit_admin' )) + 1) .'页/第'.@(floor($data['attribute_group_page'] / $this->config->get_config ( 'config_limit_admin' )) + 1) .'页</div><ul class="pagination" style="float: right;margin: 5px 0">';
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
		$config1['total_rows'] 			= $attribute_groups['count'];
		$config1['per_page'] 			= $this->config->get_config('config_limit_admin');

		$this->pagination->initialize($config1);

		$data['attribute_group_pagination'] = $this->pagination->create_links();
		
		$data['attribute_delete']		=$this->config->item('admin').'product/attribute/delete_attribute';
		$data['attribute_group_delete']	=$this->config->item('admin').'product/attribute/delete_attribute_group';
		
		$data['header']					=$this->header->index();
		$data['top']					=$this->header->top();
		$data['footer']					=$this->footer->index();
		
		$this->load->view('theme/default/template/product/attribute_list',$data);
	}
	
	
	public function validate_delete_attribute($data){
		if (!$this->user->hasPermission('modify', 'admin/product/attribute')) {
			$this->session->set_flashdata('danger', '你无权修改，请联系管理员！');
			$this->error['warning'] = '没有权限修改';
		}
		
		if(empty($data)){
			return FALSE;
		}
		
		foreach($data as $key=>$value){
			if($this->attribute_model->get_product_attribute_for_attribute_id($data[$key]) != FALSE){
				$this->error[$key]['error_attribute_delete']='正在在被使用';
			}
		}
		
		return !$this->error;
	}
	
	public function validate_delete_attribute_group($data){
		if (!$this->user->hasPermission('modify', 'admin/product/attribute')) {
			$this->session->set_flashdata('danger', '你无权修改，请联系管理员！');
			$this->error['warning'] = '没有权限修改';
		}
		
		if(empty($data)){
			return FALSE;
		}
		
		foreach($data as $key=>$value){
			if($this->attribute_model->get_attribute_for_attribute_group_id($data[$key]) != FALSE){
				$this->error[$key]['error_attribute_group_delete']='正在在被使用';
			}
		}
		
		return !$this->error;
	}
	
	public function validate_attribute()
	{
		if (!$this->user->hasPermission('modify', 'admin/product/attribute')) {
			$this->session->set_flashdata('danger', '你无权修改，请联系管理员！');
			$this->error['warning'] = '没有权限修改';
		}
		
		$description=$this->input->post('description');
		foreach($description as $key=>$value){
			if((utf8_strlen($description[$key]['name']) < 2) || (utf8_strlen($description[$key]['name']) > 255)){
				$this->error['attribute_description'][$key]['error_attribute_name']='属性名称2——255字符';
			}
		}
		
		if(!$this->form_validation->integer($this->input->post('base')['attribute_group_id'])){
			$this->error['error_attribute_group_id']='请选择属性组';
		}
		return !$this->error;
	}
	
	public function validate_attribute_group()
	{
		if (!$this->user->hasPermission('modify', 'admin/product/attribute')) {
			$this->session->set_flashdata('danger', '你无权修改，请联系管理员！');
			$this->error['warning'] = '没有权限修改';
		}
		
		$description=$this->input->post('group_description');
		foreach($description as $key=>$value){
			if((utf8_strlen($description[$key]['group_name']) < 2) || (utf8_strlen($description[$key]['group_name']) > 255)){
				$this->error['attribute_group_description'][$key]['error_attribute_group_name']='属性组名称2——255字符';
			}
		}
		
		return !$this->error;
	}
}
