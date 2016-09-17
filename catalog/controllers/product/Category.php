<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->library(array('currency'));
		$this->load->model(array('product/product_model', '/category/category_model'));
	}

	public function index()
	{
		$this->lang->load('product/category', $_SESSION['language_name']);
		
		if($this->input->get('page')){
			$data['page']=$this->input->get('page');
		}else{
			$data['page']='0';
		}
		
		if($this->input->get('search') != NULL){
			$data['search']=$this->input->get('search');
		}
		
		if($this->input->get('id')){
			$ids=explode('_', $this->input->get('id'));
			if(isset($ids[1])){
				$data['category_id']=$ids[1];
			}else{
				$data['category_id']=$ids[0];
			}
		}
		
		$category_info=$this->category_model->get_category_to_category($this->input->get('id'));
		
		$data['categorys']=$category_info;
		
		$products_info=$this->product_model->get_products_to_category($data);

		if($products_info){
			$data['products']=$products_info['products'];
			$data['count']=$products_info['count'];
		}
		
		//分页
		$config['base_url'] 			= site_url('product/category').'?id='.$this->input->get('id');
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
		
		if($this->input->get('search') != NULL){
			$title=$this->input->get('search');
		}elseif($category_info){
			if(isset($category_info['childs'])){
				foreach($category_info['childs'] as $child){
					if($child['category_id'] == $data['category_id']){
						$title=$child['name'];
						$this->document->setKeywords($child['meta_keyword']);
						$this->document->setDescription($child['meta_description']);
					}else{
						$title=$category_info['name'];
						$this->document->setKeywords($category_info['meta_keyword']);
						$this->document->setDescription($category_info['meta_description']);
					}
				}
			}else{
				$title=$category_info['name'];
				$this->document->setKeywords($category_info['meta_keyword']);
				$this->document->setDescription($category_info['meta_description']);
			}
			$data['category_name']=$category_info['name'];
			$data['category_id']=$category_info['category_id'];
			
		}else{
			$title=lang_line('all_product');
			if($this->config->get_config('meta_keyword')){
				$this->document->setKeywords($this->config->get_config('meta_keyword'));
			}
			
			if($this->config->get_config('meta_description')){
				$this->document->setDescription($this->config->get_config('meta_description'));
			}
		}
		
		$this->document->setTitle($title);
		
		$data['keyword']=$title;
		
		$data['position_top']=$this->position_top->index();
		$data['position_left']=$this->position_left->index();
		$data['position_right']=$this->position_right->index();
		$data['position_bottom']=$this->position_bottom->index();
		
		$data['header']=$this->header->index();
		$data['top']=$this->header->top();
		$data['footer']=$this->footer->index();
		
		$this->load->view('theme/default/template/product/category',$data);
	}
	
	public function category_all()
	{
		$this->lang->load('product/category', $_SESSION['language_name']);
		
		$this->document->setTitle('所有分类');
		
		if($this->input->get('page')){
			$page=$this->input->get('page');
		}else{
			$page='0';
		}
		
		$row=$this->category_model->get_categorys_all($page);
		
		$data['categorys']=$row['categorys'];
		
		//分页
		$config['base_url'] 			= site_url('product/category/category_all');
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
		
		$this->load->view('theme/default/template/product/category_all',$data);
	}
}
