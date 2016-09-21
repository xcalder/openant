<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barcode extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->language('wecome');
		if(!$this->user->hasPermission('access', 'admin/product/barcode')){
			$this->session->set_flashdata('fali', '你没有访问权限！');
			redirect(site_url(), 'location', 301);
			exit;
		}
		$this->load->model(array('common/barcode_model', 'common/language_model'));
	}

	public function index()
	{
		$this->document->setTitle('条码维护');
		
		$this->get_list();
	}
	
	public function add()
	{
		$this->document->setTitle('添加条码');
		
		if($_SERVER['REQUEST_METHOD']=="POST"){
			$data['base']=$this->input->post('base');
			$data['description']=$this->input->post('description');
			
			$this->barcode_model->add_barcode($data);
			
			redirect(site_url('product/barcode'), 'location', 301);
		}
		
		$this->get_form();
	}
	
	public function edit()
	{
		$this->document->setTitle('修改条码');
		
		if($_SERVER['REQUEST_METHOD']=="POST"){
			$data['barcode_id']=$this->input->get('barcode_id');
			$data['base']=$this->input->post('base');
			$data['description']=$this->input->post('description');
			
			$this->barcode_model->edit_barcode($data);
			
			redirect(site_url('product/barcode'), 'location', 301);
		}
		
		$this->get_form();
	}
	
	public function delete ()
	{
		$this->document->setTitle('删除条码');
		
		if($_SERVER['REQUEST_METHOD']=="POST" && $this->validate_delete($this->input->post('selected'))){
			
			$this->barcode_model->delete_barcode($this->input->post('selected'));
			
			redirect(site_url('product/barcode'), 'location', 301);
		}
		
		$this->get_list();
	}
	
	public function get_form ()
	{
		$data['languages'] = $this->language_model->get_languages();
		if($this->input->get('barcode_id')){
			$barcode_info=$this->barcode_model->get_barcode_arr($this->input->get('barcode_id'));
		}
		
		if($this->input->post('description')){
			$data['descriptions']=$this->input->post('description');
		}elseif(isset($barcode_info['description'])){
			$data['descriptions']=$barcode_info['description'];
		}
		
		$data['header']=$this->header->index();
		$data['top']=$this->header->top();
		$data['footer']=$this->footer->index();
		
		if($this->input->get('barcode_id')){
			$data['action']=site_url('product/barcode/edit?barcode_id=').$this->input->get('barcode_id');
		}else{
			$data['action']=site_url('product/barcode/add');
		}
		
		$this->load->view('theme/default/template/product/barcode_form',$data);
	}
	
	public function get_list()
	{
		if($this->input->get('page')){
			$data['page']=$this->input->get('page');
		}else{
			$data['page']='0';
		}
		
		$barcodes=$this->barcode_model->get_barcodes($data);
		$data['barcodes']=$barcodes['barcode'];
		
		$data['delete']=site_url('product/barcode/delete');
		
		//分页
		$config['base_url'] 			= site_url('product/barcode');
		$config['num_links'] 			= 2;
		$config['page_query_string'] 	= TRUE;
		$config['query_string_segment'] = 'page';
		$config['full_tag_open'] 		= '<div class="text-left pagination" style="float: left;padding: 6px 0px;margin: 5px 0">共'.@(floor($barcodes['count'] / $this->config->get_config ( 'config_limit_admin' )) + 1) .'页/第'.@(floor($data['page'] / $this->config->get_config ( 'config_limit_admin' )) + 1) .'页</div><ul class="pagination" style="float: right;margin: 5px 0">';
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
		$config['total_rows'] 			= $barcodes['count'];
		$config['per_page'] 			= $this->config->get_config('config_limit_admin');

		$this->pagination->initialize($config);

		$data['pagination'] = $this->pagination->create_links();
		
		$data['header']=$this->header->index();
		$data['top']=$this->header->top();
		$data['footer']=$this->footer->index();
		
		$this->load->view('theme/default/template/product/barcode_list',$data);
	}
	
	//验证删除
	public function validate_delete($data)
	{
		if(empty($data)){
			return FALSE;
		}
		foreach($data as $key=>$value){
			if($this->barcode_model->get_product_barcode_for_barcode_id($data[$key]) != FALSE){
				$this->error[$key]['error_delete']='正在被使用';
			}
		}
		
		return !$this->error;
	}
}
