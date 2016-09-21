<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Review extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->language('wecome');
		if(!$this->user->hasPermission('access', 'admin/product/review')){
			$this->session->set_flashdata('fali', '你没有访问权限！');
			redirect(site_url(), 'location', 301);
			exit;
		}
		$this->load->model(array('common/review_model'));
	}

	public function index()
	{
		$this->document->setTitle('商品评论');
		
		$this->get_list();
	}
	
	public function delete(){
		
		if($_SERVER['REQUEST_METHOD']=="POST" && !empty($this->input->post('selected'))){
			
			$this->review_model->del_review($this->input->post('selected'));
		}
		redirect(site_url('product/review'), 'location', 301);
		
		$this->get_list();
	}
	
	public function get_list()
	{
		if($this->input->get('page')){
			$data['page']=$this->input->get('page');
		}else{
			$data['page']='0';
		}
		
		$reviews_nifo=$this->review_model->get_reviews($data);
		$data['reviews']=$reviews_nifo['reviews'];
		
		$data['delete']=site_url('product/review/delete');
		
		//分页
		$config['base_url'] 			= site_url('product/review');
		$config['num_links'] 			= 2;
		$config['page_query_string'] 	= TRUE;
		$config['query_string_segment'] = 'page';
		$config['full_tag_open'] 		= '<div class="text-left pagination" style="float: left;padding: 6px 0px;margin: 5px 0">共'.@(floor($reviews_nifo['count'] / $this->config->get_config ( 'config_limit_admin' )) + 1) .'页/第'.@(floor($data['page'] / $this->config->get_config ( 'config_limit_admin' )) + 1) .'页</div><ul class="pagination" style="float: right;margin: 5px 0">';
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
		$config['total_rows'] 			= $reviews_nifo['count'];
		$config['per_page'] 			= $this->config->get_config('config_limit_admin');

		$this->pagination->initialize($config);

		$data['pagination'] = $this->pagination->create_links();
		
		
		$data['header']=$this->header->index();
		$data['top']=$this->header->top();
		$data['footer']=$this->footer->index();
		
		$this->load->view('theme/default/template/product/review',$data);
	}
}
