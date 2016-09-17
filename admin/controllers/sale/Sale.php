<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sale extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->language('wecome');
		$this->load->library(array('currency'));
		$this->load->model(array('sale/store_model'));
	}

	public function index()
	{
		$this->document->setTitle('商家管理');
		
		$this->get_list();
	}
	
	public function get_list()
	{
		//分页
		if($this->input->get('page')){
			$data['page']				=$this->input->get('page');
		}else{
			$data['page']				='0';
		}
		
		$stores							=$this->store_model->get_stores($data);
		
		if(!empty($stores)){
			$data['stores']				=$stores['stores'];
			$data['count']				=$stores['count'];
		}
		
		$config['base_url'] 			= site_url('sale/sale');
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
		$config['total_rows'] 			= $stores['count'];
		$config['per_page'] 			= $this->config->get_config('config_limit_admin');

		$this->pagination->initialize($config);

		$data['pagination'] 			= $this->pagination->create_links();
		
		$data['header']					=$this->header->index();
		$data['top']					=$this->header->top();
		$data['footer']					=$this->footer->index();
		
		$this->load->view('theme/default/template/sale/sale_list',$data);
	}
	
	public function invalid(){
		if(!$_SERVER['REQUEST_METHOD']=="POST"){
			return FALSE;
		}
		
		if($this->input->post('selected') != NULL){
			$data['invalid']='0';
			$data['date_invalid']=date('Y-m-d H:i:s',strtotime('+30 day'));
			foreach($this->input->post('selected') as $key=>$value){
				$this->store_model->invalid($this->input->post('selected')[$key], $data);
			}
		}
		
		if($this->input->post('store_id') != NULL && $this->input->post('date_invalid') != NULL && $this->input->post('date_invalid') != 'always'){
			$str='+'.$this->input->post('date_invalid').' day';
			$data['store_status']='0';
			$data['date_invalid']=date('Y-m-d H:i:s',strtotime($str));
			
			$this->store_model->invalid($this->input->post('store_id'), $data);
		}
		
		if($this->input->post('store_id') != NULL && $this->input->post('date_invalid') != NULL && $this->input->post('date_invalid') == 'always'){
			$data['store_status']='1';
			
			$this->store_model->invalid($this->input->post('store_id'), $data);
		}
		
		redirect(site_url('sale/sale'), 'location', 301);
	}
	
	public function uninvalid(){
		if(!$_SERVER['REQUEST_METHOD']=="POST"){
			return FALSE;
		}
		
		if($this->input->post('store_id') != NULL){
			$data['store_status']='0';
			$data['date_invalid']=date('Y-m-d H:i:s',strtotime('-1 day'));
			
			$this->store_model->invalid($this->input->post('store_id'), $data);
		}
		
		redirect(site_url('sale/sale'), 'location', 301);
	}
}
