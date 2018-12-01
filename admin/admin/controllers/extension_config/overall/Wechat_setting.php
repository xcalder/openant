<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wechat_setting extends MY_Controller {
	
public function __construct() {
		parent::__construct();
		$this->load->language('wecome');
		if(!$this->user->hasPermission('access', 'admin/extension_config/overall/wechat_setting')){
			$this->session->set_flashdata('fali', '你没有访问权限！');
			redirect($this->config->item('admin'));
			exit;
		}
	}

	public function index()
	{
		$this->document->setTitle('全局底部设置');
		
		if($_SERVER['REQUEST_METHOD']=="POST" && $this->check_modify()){
			$this->load->model('setting/setting_model');
			$this->setting_model->edit($this->input->post(), 'wechat');
			redirect($this->config->item('admin').'/common/extension/overall');
			exit;
		}
		
		if($this->input->post('appID') != NULL)
		{
			$data['appID'] = $this->input->post('appID');
		}
		elseif($this->config->get_config('appID', 'wechat', '0'))
		{
			$data['appID'] = $this->config->get_config('appID', 'wechat', '0');
		}
			
		if($this->input->post('appsecret') != NULL)
		{
			$data['appsecret'] = $this->input->post('appsecret');
		}
		elseif($this->config->get_config('appsecret', 'wechat', '0'))
		{
			$data['appsecret'] = $this->config->get_config('appsecret', 'wechat', '0');
		}
			
		if($this->input->post('token') != NULL)
		{
			$data['token'] = $this->input->post('token');
		}
		elseif($this->config->get_config('token', 'wechat', '0'))
		{
			$data['token'] = $this->config->get_config('token', 'wechat', '0');
		}
			
		if($this->input->post('encodingaeskey') != NULL)
		{
			$data['encodingaeskey'] = $this->input->post('encodingaeskey');
		}
		elseif($this->config->get_config('encodingaeskey', 'wechat', '0'))
		{
			$data['encodingaeskey'] = $this->config->get_config('encodingaeskey', 'wechat', '0');
		}
		
		$data['header']=$this->header->index();
		$data['top']=$this->header->top();
		$data['footer']=$this->footer->index();
		
		$this->load->view('theme/default/template/extension_config/overall/wechat_setting',$data);
	}
	
	public function check_modify(){
		if (!$this->user->hasPermission('modify', 'admin/extension_config/overall/wechat_setting')) {
			$this->session->set_flashdata('danger', '你无权修改，请联系管理员！');
			redirect($this->config->item('admin').'/common/extension/overall');
			exit();
		}else {
			return true;
		}
	}
}
