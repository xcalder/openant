<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Footer_html extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->language('wecome');
		if(!$this->user->hasPermission('access', 'admin/extension_config/overall/footer_html')){
			$this->session->set_flashdata('fali', '你没有访问权限！');
			redirect($this->config->item('admin'));
			exit;
		}
		$this->load->model(array('setting/overall_model'));
	}

	public function index()
	{
		$this->document->setTitle('全局底部设置');
		
		if($_SERVER['REQUEST_METHOD']=="POST" && $this->check_modify()){
			
			if($this->input->post('description') != NULL){
				$data['description']=$this->input->post('description');
				$data['module_id']=$this->input->post('module_id');
				$this->overall_model->add($data, 'overall', 'footer_html');
			}
			
			redirect($this->config->item('admin').'/common/extension/overall');
			exit;
		}
		
		$data['languages'] = $this->language_model->get_languages();
		$data['footer_htmls']=$this->overall_model->get_overall('overall', 'footer_html');
		
		$data['header']=$this->header->index();
		$data['top']=$this->header->top();
		$data['footer']=$this->footer->index();
		
		$this->load->view('theme/default/template/extension_config/overall/footer_html',$data);
	}
	
	public function check_modify(){
		if (!$this->user->hasPermission('modify', 'admin/extension_config/overall/footer_html')) {
			$this->session->set_flashdata('danger', '你无权修改，请联系管理员！');
			redirect($this->config->item('admin').'/common/extension/overall');
			exit();
		}else {
			return true;
		}
	}
}