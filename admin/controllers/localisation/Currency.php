<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Currency extends MY_Controller {
	private $error = array();
	
	public function __construct() {
		parent::__construct();
		$this->load->helper(array('utf8'));
		$this->load->language('wecome');
		if(!$this->user->hasPermission('access', 'admin/localisation/currency')){
			$this->session->set_flashdata('fali', '你没有访问权限！');
			redirect(site_url(), 'location', 301);
			exit;
		}
		$this->load->library(array('form_validation'));
		$this->load->model(array('common/currency_model'));
	}

	public function index(){
		$this->document->setTitle('货币设置');
		
		$this->get_list();
	}
	
	public function add()
	{
		$this->document->setTitle('添加货币设置');
		
		if($_SERVER['REQUEST_METHOD']=="POST" && $this->validate_form()){
			$this->currency_model->add($this->input->post());
			
			redirect(site_url('localisation/currency'), 'location', 301);
		}
		
		$this->get_form();
	}
	
	public function edit()
	{
		$this->document->setTitle('修改货币设置');
		
		if($_SERVER['REQUEST_METHOD']=="POST" && $this->validate_form()){
			$this->currency_model->edit($this->input->post());
			
			redirect(site_url('localisation/currency'), 'location', 301);
		}
		
		$this->get_form();
	}
	
	public function delete()
	{
		$this->document->setTitle('删除货币参数');
		
		if($_SERVER['REQUEST_METHOD']=="POST" && $this->validate_delete()){
			$this->currency_model->delete($this->input->post('selected'));
			
			redirect(site_url('localisation/currency'), 'location', 301);
		}
		
		$this->get_list();
	}
	
	public function get_form()
	{
		if($this->input->get('currency_id')){
			$currency_info					=$this->currency_model->get_currency_edit($this->input->get('currency_id'));
		}
		
		if($this->input->post('title')){
			$data['title']					=$this->input->post('title');
		}elseif(isset($currency_info)){
			$data['title']					=$currency_info['title'];
		}else{
			$data['title']					='';
		}
		
		if($this->input->post('code')){
			$data['code']					=$this->input->post('code');
		}elseif(isset($currency_info)){
			$data['code']					=$currency_info['code'];
		}else{
			$data['code']					='';
		}
		
		if($this->input->post('symbol_left')){
			$data['symbol_left']					=$this->input->post('symbol_left');
		}elseif(isset($currency_info)){
			$data['symbol_left']					=$currency_info['symbol_left'];
		}else{
			$data['symbol_left']					='';
		}
		
		if($this->input->post('symbol_right')){
			$data['symbol_right']					=$this->input->post('symbol_right');
		}elseif(isset($currency_info)){
			$data['symbol_right']					=$currency_info['symbol_right'];
		}else{
			$data['symbol_right']					='';
		}
		
		if($this->input->post('decimal_place')){
			$data['decimal_place']					=$this->input->post('decimal_place');
		}elseif(isset($currency_info)){
			$data['decimal_place']					=$currency_info['decimal_place'];
		}else{
			$data['decimal_place']					='';
		}
		
		if($this->input->post('value')){
			$data['value']					=$this->input->post('value');
		}elseif(isset($currency_info)){
			$data['value']					=$currency_info['value'];
		}else{
			$data['value']					='';
		}
		
		if($this->input->post('status')){
			$data['status']					=$this->input->post('status');
		}elseif(isset($currency_info)){
			$data['status']					=$currency_info['status'];
		}else{
			$data['status']					='1';
		}
		
		if($this->input->get('currency_id')){
			$data['action']					=site_url('localisation/currency/edit?currency_id=').$this->input->get('currency_id');
		}else{
			$data['action']					=site_url('localisation/currency/add');
		}
		
		if(isset($this->error['error_title'])){
			$data['error_title']			=$this->error['error_title'];
		}
		
		if(isset($this->error['error_code'])){
			$data['error_code']				=$this->error['error_code'];
		}
		
		$data['header']=$this->header->index();
		$data['top']=$this->header->top();
		$data['footer']=$this->footer->index();
		$this->load->view('theme/default/template/localisation/currency_form',$data);
	}

	public function get_list()
	{
		if($this->input->get('page')){
			$data['page']=$this->input->get('page');
		}else{
			$data['page']='0';
		}
		
		$currencys_info=$this->currency_model->get_currencys_edit($data);
		
		if($currencys_info){
			$data['currencys_list']			=$currencys_info['currencys'];
			$data['count']					=$currencys_info['count'];
		}
		
		
		//分页
		$config['base_url'] 			= site_url('localisation/currency');
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
		$config['total_rows'] 			= $currencys_info['count'];
		$config['per_page'] 			= $this->config->get_config('config_limit_admin');

		$this->pagination->initialize($config);

		$data['pagination'] 			= $this->pagination->create_links();
		
		$data['delete']					=site_url('localisation/currency/delete');
		
		$data['header']=$this->header->index();
		$data['top']=$this->header->top();
		$data['footer']=$this->footer->index();
		$this->load->view('theme/default/template/localisation/currency_list',$data);
	}
	
	public function validate_delete(){
		
		if($this->currency_model->check_delete($this->input->post('selected'))){
			$this->error['wring_delete']='有一个删除的货币设置正在被使用';
		}
		
		return !$this->error;
	}
	
	//验证表单
	public function validate_form(){
		
		
		if((utf8_strlen($this->input->post('title')) < 2) || (utf8_strlen($this->input->post('title')) > 255)){
			$this->error['error_title']='货币名称2——255字符';
		}
		if((utf8_strlen($this->input->post('code')) != 3)){
			$this->error['error_code']='标签3字符';
		}
		
		return !$this->error;
	}
}
