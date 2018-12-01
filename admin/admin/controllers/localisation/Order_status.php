<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_status extends MY_Controller {
	private $error = array();
	
	public function __construct() {
		parent::__construct();
		$this->load->helper(array('utf8'));
		$this->load->language('wecome');
		if(!$this->user->hasPermission('access', 'admin/localisation/order_status')){
			$this->session->set_flashdata('fali', '你没有访问权限！');
			redirect($this->config->item('admin'));
			exit;
		}
		$this->load->library(array('form_validation'));
		$this->load->model(array('localisation/order_status_model', 'common/language_model'));
	}

	public function index(){
		$this->document->setTitle('订单状态设置');
		
		$this->get_list();
	}
	
	public function add()
	{
		$this->document->setTitle('添加订单状态设置');
		
		if($_SERVER['REQUEST_METHOD']=="POST" && $this->validate_form()){
			$this->order_status_model->add($this->input->post());
			
			redirect($this->config->item('admin').'/localisation/order_status');
		}
		
		$this->get_form();
	}
	
	public function edit()
	{
		$this->document->setTitle('修改订单状态设置');
		
		if($_SERVER['REQUEST_METHOD']=="POST" && $this->validate_form()){
			$this->order_status_model->edit($this->input->post());
			
			redirect($this->config->item('admin').'/localisation/order_status');
		}
		
		$this->get_form();
	}
	
	public function delete()
	{
		$this->document->setTitle('删除订单状态参数');
		
		if($_SERVER['REQUEST_METHOD']=="POST" && $this->validate_delete()){
			$this->order_status_model->delete($this->input->post('selected'));
			
			redirect($this->config->item('admin').'/localisation/order_status');
		}
		
		$this->get_list();
	}
	
	public function get_form()
	{
		if($this->input->get('order_status_id')){
			$order_status_info					=$this->order_status_model->get_order_status_form($this->input->get('order_status_id'));
		}
		
		if($this->input->post('description')){
			$data['description']			=$this->input->post('description');
		}elseif(isset($order_status_info['description'])){
			$data['description']			=$order_status_info['description'];
		}
		
		if($this->input->post('base')['sort_order']){
			$data['sort_order']			=$this->input->post('base')['sort_order'];
		}elseif(isset($order_status_info['sort_order'])){
			$data['sort_order']			=$order_status_info['sort_order'];
		}else{
			$data['sort_order']			='0';
		}
		
		if($this->input->get('order_status_id')){
			$data['action']					=$this->config->item('admin').'/localisation/order_status/edit?order_status_id='.$this->input->get('order_status_id');
		}else{
			$data['action']					=$this->config->item('admin').'/localisation/order_status/add';
		}
		
		if(isset($this->error['error_description'])){
			$data['error_description']		=$this->error['error_description'];
		}
		
		$data['languages']				=$this->language_model->get_languages();
		
		$data['header']=$this->header->index();
		$data['top']=$this->header->top();
		$data['footer']=$this->footer->index();
		$this->load->view('theme/default/template/localisation/order_status_form',$data);
	}

	public function get_list()
	{
		if($this->input->get('page')){
			$data['page']=$this->input->get('page');
		}else{
			$data['page']='0';
		}
		
		$order_statuss_info=$this->order_status_model->get_order_statuss_for_langugae_id($data);
		if($order_statuss_info){
			$data['order_statuss']			=$order_statuss_info['order_statuss'];
			$data['count']					=$order_statuss_info['count'];
		}
		
		
		//分页
		$config['base_url'] 			= $this->config->item('admin').'/localisation/order_status';
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
		$config['total_rows'] 			= $order_statuss_info['count'];
		$config['per_page'] 			= $this->config->get_config('config_limit_admin');

		$this->pagination->initialize($config);

		$data['pagination'] 			= $this->pagination->create_links();
		
		$data['delete']					=$this->config->item('admin').'/localisation/order_status/delete';
		
		$data['header']=$this->header->index();
		$data['top']=$this->header->top();
		$data['footer']=$this->footer->index();
		$this->load->view('theme/default/template/localisation/order_status_list',$data);
	}
	
	public function validate_delete(){
		if (!$this->user->hasPermission('modify', 'admin/localisation/order_status')) {
			$this->session->set_flashdata('danger', '你无权修改，请联系管理员！');
			$this->error['warning'] = '没有权限修改';
		}
		
		if($this->order_status_model->check_delete($this->input->post('selected'))){
			$this->error['wring_delete']='有一个删除的订单状态设置正在被使用';
		}
		
		return !$this->error;
	}
	
	//验证表单
	public function validate_form(){
		if (!$this->user->hasPermission('modify', 'admin/localisation/order_status')) {
			$this->session->set_flashdata('danger', '你无权修改，请联系管理员！');
			$this->error['warning'] = '没有权限修改';
		}
		
		$description=$this->input->post('description');
		foreach($description as $key=>$value){
			if((utf8_strlen($description[$key]['status_name']) < 2) || (utf8_strlen($description[$key]['status_name']) > 32)){
				$this->error['error_description'][$key]['error_status_name']='订单状态名称2——32字符';
			}
		}
		
		return !$this->error;
	}
}
