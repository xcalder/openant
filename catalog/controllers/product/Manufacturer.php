<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manufacturer extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->library(array('currency'));
		$this->load->model(array('product/product_model', '/category/manufacturer_model'));
	}

	public function index()
	{
		$this->lang->load('product/category', $_SESSION['language_name']);
		
		if($this->input->get('page')){
			$data['page']=$this->input->get('page');
		}else{
			$data['page']='0';
		}
		
		if($this->input->get('id')){
			$data['manufacturer_id']=$this->input->get('id');
		}else{
			$data['manufacturer_id']='0';
		}
		
		$data['manufacturer']=$this->manufacturer_model->get_manufacturer_for_language($this->input->get('id'));;
		
		$products_info=$this->product_model->get_products($data);

		if($products_info){
			$data['products']=$products_info['products'];
			$data['count']=$products_info['count'];
		}
		
		//分页
		$config['base_url'] 			= site_url('product/manufacturer').'?id='.$this->input->get('id');
		$config['num_links'] 			= 2;
		$config['page_query_string'] 	= TRUE;
		$config['query_string_segment'] = 'page';
		$config['full_tag_open'] 		= sprintf(lang_line('page'), @(floor($products_info['count'] / $this->config->get_config ( 'config_limit_catalog' )) + 1), @(floor($data['page'] / $this->config->get_config ( 'config_limit_catalog' )) + 1));
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
		$config['total_rows'] 			= isset($products_info['count']) ? $products_info['count'] : '0';
		$config['per_page'] 			= $this->config->get_config('config_limit_catalog');

		$this->pagination->initialize($config);

		$data['pagination'] 			= $this->pagination->create_links();
		
		$this->document->setTitle((isset($data['manufacturer']['name']) ? $data['manufacturer']['name'] : ''));
		
		$data['position_top']=$this->position_top->index();
		$data['position_left']=$this->position_left->index();
		$data['position_right']=$this->position_right->index();
		$data['position_bottom']=$this->position_bottom->index();
		
		$data['header']=$this->header->index();
		$data['top']=$this->header->top();
		$data['footer']=$this->footer->index();
		
		$this->load->view('theme/default/template/product/manufacturer',$data);
	}
	
	public function manufacturer_all()
	{
		$this->lang->load('product/category', $_SESSION['language_name']);
		
		$this->document->setTitle('所有品牌');
		
		if($this->input->get('page')){
			$page=$this->input->get('page');
		}else{
			$page='0';
		}
		
		$this->load->model('common/manufacturer_model');
		$row=$this->manufacturer_model->get_manufacturers_all($page);
		
		$data['manufacturers']=$row['manufacturers'];
		
		//分页
		$config['base_url'] 			= site_url('product/category/manufacturer_all');
		$config['num_links'] 			= 2;
		$config['page_query_string'] 	= TRUE;
		$config['query_string_segment'] = 'page';
		$config['full_tag_open'] 		= sprintf(lang_line('page'), @(floor($row['count'] / $this->config->get_config ( 'config_limit_catalog' )) + 1), @(floor($page / $this->config->get_config ( 'config_limit_catalog' )) + 1));
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
		$config['total_rows'] 			= isset($row['count']) ? $row['count'] : '0';
		$config['per_page'] 			= $this->config->get_config('config_limit_catalog');

		$this->pagination->initialize($config);

		$data['pagination'] 			= $this->pagination->create_links();
		
		$data['position_top']=$this->position_top->index();
		$data['position_left']=$this->position_left->index();
		$data['position_right']=$this->position_right->index();
		$data['position_bottom']=$this->position_bottom->index();
		
		$data['header']=$this->header->index();
		$data['top']=$this->header->top();
		$data['footer']=$this->footer->index();
		
		$this->load->view('theme/default/template/product/manufacturer_all',$data);
	}
}
