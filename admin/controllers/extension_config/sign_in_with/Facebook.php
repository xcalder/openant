<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Facebook extends MY_Controller {
	private $error = array();
	
	public function __construct() {
		parent::__construct();
		$this->load->helper(array('directory'));
		$this->load->language('wecome');
		$this->load->model(array('setting/sign_in_with_model'));
	}

	public function index()
	{
		$this->document->setTitle('facebook登陆');
		
		$this->get_form();
	}
	public function add(){
		$this->document->setTitle('facebook登陆');
		
		if($_SERVER['REQUEST_METHOD']=="POST" && $this->validateForm()){
			$this->sign_in_with_model->add($this->input->post(), 'sign_in_with', 'facebook');
			
			redirect(site_url('common/extension/sign_in_with'), 'location', 301);
		}
		
		$this->get_form();
	}
	
	public function get_form()
	{
		$extension_setting=$this->sign_in_with_model->get_sign_with('sign_in_with', 'facebook');
		if($extension_setting){
			$data['module_id']=$extension_setting['module_id'];
		}
		if($this->input->post('appid') != NULL){
			$data['appid']=$this->input->post('appid');
		}elseif($extension_setting){
			$data['appid']=$extension_setting['setting']['appid'];
		}else{
			$data['appid']='';
		}
		
		if($this->input->post('appkey') != NULL){
			$data['appkey']=$this->input->post('appkey');
		}elseif($extension_setting){
			$data['appkey']=$extension_setting['setting']['appkey'];
		}else{
			$data['appkey']='';
		}
		
		if($this->input->post('extra') != NULL){
			$data['extra']=$this->input->post('extra');
		}elseif($extension_setting){
			$data['extra']=$extension_setting['setting']['extra'];
		}else{
			$data['extra']='';
		}
		
		if($this->input->post('status') != NULL){
			$data['status']=$this->input->post('status');
		}elseif($extension_setting){
			$data['status']=$extension_setting['setting']['status'];
		}else{
			$data['status']='1';
		}
		
		if($this->input->post('store_order') != NULL){
			$data['store_order']=$this->input->post('store_order');
		}elseif($extension_setting){
			$data['store_order']=$extension_setting['store_order'];
		}else{
			$data['store_order']='0';
		}
		
		//error
		if(isset($this->error['appid'])){
			$data['error_appid']=$this->error['appid'];
		}
		if(isset($this->error['appkey'])){
			$data['error_appkey']=$this->error['appkey'];
		}
		
		//$data['maps']					=directory_map('./public/resources/default/image/login_ico/', 1);
		$data['header']					=$this->header->index();
		$data['top']					=$this->header->top();
		$data['footer']					=$this->footer->index();
		
		$this->load->view('theme/default/template/extension_config/sign_in_with/facebook',$data);
	}
	
	//验证表单
	private function validateForm(){
		/*
		if (!$this->user->hasPermission('modify', 'information/information')) {
		$this->error['warning'] = '没有权限修改';
		}
		*/
		if((utf8_strlen($this->input->post('appid')) < 2) || (utf8_strlen($this->input->post('appid')) > 255)){
			$this->error['appid'] = 'App ID 2——255字符';
		}
		
		if((utf8_strlen($this->input->post('appkey')) < 2) || (utf8_strlen($this->input->post('appkey')) > 255)){
			$this->error['appkey'] = 'App Key 2——255字符';
		}
		
		return !$this->error;
	}
}
