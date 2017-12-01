<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sale_class extends MY_Controller {
	
	private $error = array();
	
	public function __construct() {
		parent::__construct();
		$this->load->language('wecome');
		if(!$this->user->hasPermission('access', 'admin/sale/sale_class')){
			$this->session->set_flashdata('fali', '你没有访问权限！');
			redirect($this->config->item('admin'));
			exit;
		}
		$this->load->library(array('form_validation'));
		$this->load->model(array('common/sale_class_model','common/language_model'));
	}

	public function index()
	{
		$this->document->setTitle('商家组列表');
		
		$this->get_list();
	}
	
	public function add()
	{
		$this->document->setTitle('商家组添加');
		
		if($_SERVER['REQUEST_METHOD']=="POST" && $this->valid_sale_class_name($this->input->post('description'))){
			
			$this->sale_class_model->add_sale_class($this->input->post());
			
			redirect($this->config->item('admin').'sale/sale_class');
		}
		
		$this->get_from();
	}
	
	public function edit()
	{
		$this->document->setTitle('商家组修改');
		
		if($_SERVER['REQUEST_METHOD']=="POST" && $this->input->get('sale_class_id') && $this->valid_sale_class_name($this->input->post('description'))){
			//修改sale_class表
			$sale_classs				=$this->input->post('sale_class');
			$sale_classs['sale_class_id']=$this->input->get('sale_class_id');
			
			$this->sale_class_model->edit_sale_class($sale_classs);
			
			//修改描述表
			$description				=$this->input->post('description');
			foreach($description as $key=>$value){
				$description[$key]['sale_class_id']=$this->input->get('sale_class_id');
				$description[$key]['language_id']=$key;
			}
			
			$this->sale_class_model->edit_sale_class_description($this->input->get('sale_class_id'), $description);
			
			redirect($this->config->item('admin').'sale/sale_class');
		}
		
		$this->get_from();
	}
	
	public function delete (){
		$this->document->setTitle('删除商家组');
		
		if($_SERVER['REQUEST_METHOD']=="POST" && $this->valid_delete()){
			
			$this->sale_class_model->delete($this->input->post('selected'));
			
			$this->session->set_flashdata('success', '成功：商家组删除成功！');
			redirect($this->config->item('admin').'sale/sale_class');
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
		
		$sale_classs					=$this->sale_class_model->get_sale_classs($data);
		$data['sale_classs']			=$sale_classs['sale_classs'];
		$data['count']					=$sale_classs['count'];
		
		//分页
		$config['base_url'] 			= $this->config->item('admin').'sale/sale_class';
		$config['num_links'] 			= 2;
		$config['page_query_string'] 	= TRUE;
		$config['query_string_segment'] = 'page';
		$config['full_tag_open'] 		= '<td colspan="3"><nav class="text-left"><ul class="pagination">';
		$config['full_tag_close'] 		= '</ul></td>';
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
		$config['total_rows'] 			= $sale_classs['count'];
		$config['per_page'] 			= $this->config->get_config('config_limit_admin');

		$this->pagination->initialize($config);

		$data['pagination'] 			= $this->pagination->create_links();
		
		$data['delete']					=$this->config->item('admin').'sale/sale_class/delete';
		
		$data['header']=$this->header->index();
		$data['top']=$this->header->top();
		$data['footer']=$this->footer->index();
		
		$this->load->view('theme/default/template/sale/sale_class_list',$data);
	}
	
	public function get_from()
	{
		$data=array();
		
		if($this->input->get('sale_class_id') != NULL){
			$sale_class_info=$this->sale_class_model->get_sale_class_from($this->input->get('sale_class_id'));
		}
		
		if($this->input->post('description')){
			$data['description']=$this->input->post('description');
		}elseif(isset($sale_class_info)){
			$data['description']=$sale_class_info['description'];
		}
		
		if(isset($this->input->post('sale_class')['level'])){
			$data['level']=$this->input->post('sale_class')['level'];
		}elseif(isset($sale_class_info['sale_class']['level'])){
			$data['level']=$sale_class_info['sale_class']['level'];
		}
		
		if(isset($this->input->post('sale_class')['sort_order'])){
			$data['sort_order']=$this->input->post('sale_class')['sort_order'];
		}elseif(isset($sale_class_info['sale_class']['sort_order'])){
			$data['sort_order']=$sale_class_info['sale_class']['sort_order'];
		}
		
		$data['languages']				=$this->language_model->get_languages();
		
		$data['header']					=$this->header->index();
		$data['top']					=$this->header->top();
		$data['footer']					=$this->footer->index();
		
		$data['error']					=$this->error;
		
		if($this->input->get('sale_class_id')){
			$data['action']=$this->config->item('admin').'sale/sale_class/edit?sale_class_id='.$this->input->get('sale_class_id');
		}else{
			$data['action']=$this->config->item('admin').'sale/sale_class/add';
		}
		
		$this->load->view('theme/default/template/sale/sale_class_from',$data);
	}
	
	private function valid_sale_class_name($sale_class_description){
		if (!$this->user->hasPermission('modify', 'admin/sale/sale_class')) {
			$this->session->set_flashdata('danger', '你无权修改，请联系管理员！');
			$this->error['danger']='无权修改';
		}
		
		foreach($sale_class_description as $key=>$value){
			if(!$this->form_validation->min_length($sale_class_description[$key]['name'],'2') || !$this->form_validation->max_length($sale_class_description[$key]['name'],'32')){
				$this->error[$key]['error_name']='名称长度2——32字符';
			}
			if(!isset($sale_class_description[$key]['name']) || empty($sale_class_description[$key]['name'])){
				$this->error[$key]['error_name']='名称不能为空';
			}
		}
		
		return !$this->error;
	}
	
	private function valid_delete()
	{
		if (!$this->user->hasPermission('modify', 'admin/sale/sale_class')) {
			$this->session->set_flashdata('danger', '你无权修改，请联系管理员！');
			$this->error['danger']='无权修改';
		}
		
		foreach($this->input->post('selected') as $value){
			if($this->sale_class_model->check_delete($value) === FALSE){
				$this->session->set_flashdata('fali', '警告：你正在删除的商家组被使用，无法删除！');
				return FALSE;
			}
		}
		return TRUE;
	}
}
