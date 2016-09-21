<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Paypal extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->language('wecome');
		if(!$this->user->hasPermission('access', 'admin/extension/payment/paypal')){
			$this->session->set_flashdata('fali', '你没有访问权限！');
			redirect(site_url(), 'location', 301);
			exit;
		}
		$this->load->model(array('setting/setting_model', 'common/currency_model'));
	}

	public function index()
	{
		$this->document->setTitle('paypal支付接口');
		
		$data['currencys']=$this->currency_model->get_currencys();
		
		if($_SERVER['REQUEST_METHOD']=="POST"){
			
			$this->setting_model->edit($this->input->post(),'payment');
			
			$this->session->set_flashdata('success','paypal支付接口修改成功！');
			redirect(site_url('common/extension/payment'), 'location', 301);
		}
		
		$value=$this->setting_model->get_setting('payment', 'paypal');
		$data['value']					=unserialize($value);
		
		$data['header']					=$this->header->index();
		$data['top']					=$this->header->top();
		$data['footer']					=$this->footer->index();
		
		$this->load->view('theme/default/template/extension_config/payment/paypal_form',$data);
	}
}
