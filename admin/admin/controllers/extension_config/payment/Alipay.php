<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Alipay extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->language('wecome');
		if(!$this->user->hasPermission('access', 'admin/extension_config/payment/alipay')){
			$this->session->set_flashdata('fali', '你没有访问权限！');
			redirect($this->config->item('admin'));
			exit;
		}
		$this->load->model(array('setting/setting_model'));
	}

	public function index()
	{
		$this->document->setTitle('支付宝支付接口');
		
		if($_SERVER['REQUEST_METHOD']=="POST" && $this->check_modify()){
			
			$this->setting_model->edit($this->input->post(),'payment');
			
			$this->session->set_flashdata('success','支付宝支付接口修改成功！');
			redirect($this->config->item('admin').'common/extension/payment');
		}
		
		$value=$this->setting_model->get_setting('payment', 'alipay');
		$data['value']					=unserialize($value);
		
		$data['header']					=$this->header->index();
		$data['top']					=$this->header->top();
		$data['footer']					=$this->footer->index();
		
		$this->load->view('theme/default/template/extension_config/payment/alipay_form',$data);
	}
	
	public function check_modify(){
		if (!$this->user->hasPermission('modify', 'admin/extension_config/payment/alipay')) {
			$this->session->set_flashdata('danger', '你无权修改，请联系管理员！');
			redirect($this->config->item('admin').'common/extension/payment');
			exit();
		}else {
			return true;
		}
	}
}
