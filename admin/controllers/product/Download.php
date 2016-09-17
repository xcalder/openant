<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Download extends MY_Controller {
	private $error = array();
	
	public function __construct() {
		parent::__construct();
		$this->load->helper(array('utf8'));
		$this->load->language('wecome');
		$this->load->library(array('form_validation'));
		$this->load->model(array('common/download_model', 'common/language_model'));
	}

	public function index(){
		$this->document->setTitle('下载商品设置');
		
		$this->get_list();
	}
	
	public function add()
	{
		$this->document->setTitle('添加下载商品设置');
		
		if($_SERVER['REQUEST_METHOD']=="POST" && $this->validate_form()){
			$this->download_model->add($this->input->post());
			
			redirect(site_url('product/download'), 'location', 301);
		}
		
		$this->get_form();
	}
	
	public function edit()
	{
		$this->document->setTitle('修改下载商品设置');
		
		if($_SERVER['REQUEST_METHOD']=="POST" && $this->validate_form()){
			$this->download_model->edit($this->input->post());
			
			redirect(site_url('product/download'), 'location', 301);
		}
		
		$this->get_form();
	}
	
	public function delete()
	{
		$this->document->setTitle('删除下载商品参数');
		
		if($_SERVER['REQUEST_METHOD']=="POST" && $this->validate_delete()){
			$this->download_model->delete($this->input->post('selected'));
			
			redirect(site_url('product/download'), 'location', 301);
		}
		
		$this->get_list();
	}
	
	public function get_form()
	{
		if($this->input->get('download_id')){
			$download_info					=$this->download_model->get_download_form($this->input->get('download_id'));
		}
		
		if($this->input->post('description')){
			$data['description']			=$this->input->post('description');
		}elseif(isset($download_info['description'])){
			$data['description']			=$download_info['description'];
		}
		
		if($this->input->post('base')['sort_order']){
			$data['sort_order']			=$this->input->post('base')['sort_order'];
		}elseif(isset($download_info['sort_order'])){
			$data['sort_order']			=$download_info['sort_order'];
		}else{
			$data['sort_order']			='0';
		}
		
		if($this->input->get('download_id')){
			$data['action']					=site_url('product/download/edit?download_id=').$this->input->get('download_id');
		}else{
			$data['action']					=site_url('product/download/add');
		}
		
		if(isset($this->error['error_description'])){
			$data['error_description']		=$this->error['error_description'];
		}
		
		$data['languages']				=$this->language_model->get_languages();
		
		$data['header']=$this->header->index();
		$data['top']=$this->header->top();
		$data['footer']=$this->footer->index();
		$this->load->view('theme/default/template/product/download_form',$data);
	}

	public function get_list()
	{
		if($this->input->get('page')){
			$data['page']=$this->input->get('page');
		}else{
			$data['page']='0';
		}
		
		$downloads_info=$this->download_model->get_downloads_for_langugae_id($data);
		if($downloads_info){
			$data['downloads']			=$downloads_info['downloads'];
			$data['count']					=$downloads_info['count'];
		}
		
		
		//分页
		$config['base_url'] 			= site_url('product/download');
		$config['num_links'] 			= 2;
		$config['page_query_string'] 	= TRUE;
		$config['query_string_segment'] = 'page';
		$config['full_tag_open'] 		= '<div class="text-left" style="float: left;line-hight: 34px;padding: 6px 12px">共'.@(floor($downloads_info['count'] / $this->config->get_config ( 'config_limit_admin' )) + 1) .'页/第'.@(floor($data['page'] / $this->config->get_config ( 'config_limit_admin' )) + 1) .'页</div><nav class="text-right"><ul class="pagination" style="margin: 0 0 10px 0">';
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
		$config['total_rows'] 			= $downloads_info['count'];
		$config['per_page'] 			= $this->config->get_config('config_limit_admin');

		$this->pagination->initialize($config);

		$data['pagination'] 			= $this->pagination->create_links();
		
		$data['delete']					=site_url('product/download/delete');
		
		$data['header']=$this->header->index();
		$data['top']=$this->header->top();
		$data['footer']=$this->footer->index();
		$this->load->view('theme/default/template/product/download_list',$data);
	}
	
	public function validate_delete(){
		
		if($this->download_model->check_delete($this->input->post('selected'))){
			$this->error['wring_delete']='有一个删除的下载商品设置正在被使用';
		}
		
		return !$this->error;
	}
	
	//验证表单
	public function validate_form(){
		
		$description=$this->input->post('description');
		foreach($description as $key=>$value){
			if((utf8_strlen($description[$key]['name']) < 2) || (utf8_strlen($description[$key]['name']) > 32)){
				$this->error['error_description'][$key]['error_name']='下载商品名称2——32字符';
			}
		}
		
		return !$this->error;
	}
}
