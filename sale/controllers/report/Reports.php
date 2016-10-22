<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->language('wecome');
		if(!$this->user->hasPermission('access', 'sale/report/reports')){
			$this->session->set_flashdata('fali', '你没有访问商家后台的权限！');
			redirect(base_url(), 'location', 301);
			exit;
		}
		$this->load->model(array('product/product_model'));
	}

	public function index()
	{
		$data=array();
		
		$this->document->setTitle('报表');
		$this->document->addScript('public/min?f='.(SUBPATH == '/' ? '' : SUBPATH).'public/resources/default/js/chart.min.js');
		
		$data['header']=$this->header->index();
		$data['top']=$this->header->top();
		$data['footer']=$this->footer->index();
		$this->load->view('theme/default/template/report/reports',$data);
	}
}
