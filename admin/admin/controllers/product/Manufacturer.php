<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manufacturer extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->language('wecome');
		if(!$this->user->hasPermission('access', 'admin/product/manufacturer')){
			$this->session->set_flashdata('fali', '你没有访问权限！');
			redirect($this->config->item('admin'));
			exit;
		}
		$this->load->model(array('common/manufacturer_model', 'common/language_model'));
	}

	public function index()
	{
		$this->document->setTitle('品牌维护');
		
		$this->get_list();
	}
	
	public function add()
	{
		$this->document->setTitle('添加品牌');
		
		if($_SERVER['REQUEST_METHOD']=="POST" && $this->check_modify()){
			$data['base']=$this->input->post('base');
			$data['description']=$this->input->post('description');
			
			$this->manufacturer_model->add_manufacturer($data);
			
			redirect($this->config->item('admin').'product/manufacturer');
		}
		
		$this->get_form();
	}
	
	public function edit()
	{
		$this->document->setTitle('修改品牌');
		
		if($_SERVER['REQUEST_METHOD']=="POST" && $this->check_modify()){
			$data['manufacturer_id']=$this->input->get('manufacturer_id');
			$data['base']=$this->input->post('base');
			$data['description']=$this->input->post('description');
			
			$this->manufacturer_model->edit_manufacturer($data);
			
			redirect($this->config->item('admin').'product/manufacturer');
		}
		
		$this->get_form();
	}
	
	public function delete ()
	{
		$this->document->setTitle('删除品牌');
		
		if($_SERVER['REQUEST_METHOD']=="POST" && $this->validate_delete($this->input->post('selected'))){
			
			$this->manufacturer_model->delete_manufacturer($this->input->post('selected'));
			
			redirect($this->config->item('admin').'product/manufacturer');
		}
		
		$this->get_list();
	}
	
	public function get_form ()
	{
		$data['languages'] = $this->language_model->get_languages();
		if($this->input->get('manufacturer_id')){
			$manufacturer_info=$this->manufacturer_model->get_manufacturer_arr($this->input->get('manufacturer_id'));
		}
		
		if($this->input->post('base')['image']){
			$data['image']=$this->image_common->resize($this->input->post('base')['image'],100,100,'h');
			$data['image_old']=$this->input->post('base')['image'];
		}elseif(!empty($manufacturer_info['image'])){
			$data['image']=$this->image_common->resize($manufacturer_info['image'],100 ,100, 'h');
			$data['image_old']=$manufacturer_info['image'];
		}else{
			$data['image']='resources/public/resources/default/image/no_image.jpg';
		}
		
		$data['placeholder_image']='resources/public/resources/default/image/no_image.jpg';
		
		if($this->input->post('description')){
			$data['descriptions']=$this->input->post('description');
		}elseif(isset($manufacturer_info['description'])){
			$data['descriptions']=$manufacturer_info['description'];
		}
		
		if($this->input->post('base')['sort_order']){
			$data['sort_order']=$this->input->post('base')['sort_order'];
		}elseif($manufacturer_info['sort_order']){
			$data['sort_order']=$manufacturer_info['sort_order'];
		}else{
			$data['sort_order']='0';
		}
		
		if($this->input->post('base')['status'] !== NULL){
			$data['status']=$this->input->post('base')['status'];
		}elseif($manufacturer_info['status'] !== NULL){
			$data['status']=$manufacturer_info['status'];
		}else{
			$data['status']='';
		}
		
		$data['header']=$this->header->index();
		$data['top']=$this->header->top();
		$data['footer']=$this->footer->index();
		
		if($this->input->get('manufacturer_id')){
			$data['action']=$this->config->item('admin').'product/manufacturer/edit?manufacturer_id='.$this->input->get('manufacturer_id');
		}else{
			$data['action']=$this->config->item('admin').'product/manufacturer/add';
		}
		
		$this->load->view('theme/default/template/product/manufacturer_form',$data);
	}
	
	public function get_list()
	{
		if($this->input->get('page')){
			$data['page']=$this->input->get('page');
		}else{
			$data['page']='0';
		}
		
		$manufacturers=$this->manufacturer_model->get_manufacturers($data);
		$data['manufacturers']=$manufacturers['manufacturer'];
		
		$data['delete']=$this->config->item('admin').'product/manufacturer/delete';
		
		//分页
		$config['base_url'] 			= $this->config->item('admin').'product/manufacturer';
		$config['num_links'] 			= 2;
		$config['page_query_string'] 	= TRUE;
		$config['query_string_segment'] = 'page';
		$config['full_tag_open'] 		= '<div class="text-left pagination" style="float: left;padding: 6px 0px;margin: 5px 0">共'.@(floor($manufacturers['count'] / $this->config->get_config ( 'config_limit_admin' )) + 1) .'页/第'.@(floor($data['page'] / $this->config->get_config ( 'config_limit_admin' )) + 1) .'页</div><ul class="pagination" style="float: right;margin: 5px 0">';
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
		$config['total_rows'] 			= $manufacturers['count'];
		$config['per_page'] 			= $this->config->get_config('config_limit_admin');

		$this->pagination->initialize($config);

		$data['pagination'] = $this->pagination->create_links();
		
		$data['header']=$this->header->index();
		$data['top']=$this->header->top();
		$data['footer']=$this->footer->index();
		
		$this->load->view('theme/default/template/product/manufacturer_list',$data);
	}
	
	//验证删除
	public function validate_delete($data)
	{
		if (!$this->user->hasPermission('modify', 'admin/product/manufacturer')) {
			$this->session->set_flashdata('danger', '你无权修改，请联系管理员！');
			redirect($this->config->item('admin').'product/manufacturer');
			exit();
		}
		
		if(empty($data)){
			return FALSE;
		}
		
		foreach($data as $key=>$value){
			if($this->manufacturer_model->get_product_manufacturer_for_manufacturer_id($data[$key]) != FALSE){
				$this->error[$key]['error_delete']='正在被使用';
			}
		}
		
		return !$this->error;
	}
	
	public function check_modify(){
		if (!$this->user->hasPermission('modify', 'admin/product/manufacturer')) {
			$this->session->set_flashdata('danger', '你无权修改，请联系管理员！');
			redirect($this->config->item('admin').'product/manufacturer');
			exit();
		}else {
			return true;
		}
	}
}
