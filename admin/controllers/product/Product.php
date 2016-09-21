<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->helper(array('utf8'));
		$this->load->language('wecome');
		if(!$this->user->hasPermission('access', 'admin/product/product')){
			$this->session->set_flashdata('fali', '你没有访问权限！');
			redirect(site_url(), 'location', 301);
			exit;
		}
		$this->load->library(array('currency'));
		$this->load->model(array('common/product_model'));
	}

	public function index()
	{
		$this->document->setTitle('商品管理');
		
		$this->get_list();
	}
	
	public function get_list()
	{
		if($this->input->get('page')){
			$data['page']=$this->input->get('page');
		}else{
			$data['page']='0';
		}
		
		$product_list=$this->product_model->get_products($data);
		
		if($product_list){
			//取缩略图
			$products=$product_list['products'];
			foreach($products as $key=>$value){
				$products[$key]['image']=$this->image_common->resize($products[$key]['image'], $this->config->get_config('wish_cart_image_size_b_w'), $this->config->get_config('wish_cart_image_size_b_h') ,'h');
				//商品库存量
				if(isset($products[$key]['seal_quantity_total']) && !empty($products[$key]['seal_quantity_total'])){
					//总销量
					$products[$key]['sales']		=$products[$key]['seal_quantity_total'];
				}else{
					$products[$key]['sales']		='0';
				}
			}
			$data['products']					=$products;
		}
		
		$data['invalid']					=site_url('product/product/invalid');
		
		//分页
		$config['base_url'] 			= site_url('product/product');
		$config['num_links'] 			= 2;
		$config['page_query_string'] 	= TRUE;
		$config['query_string_segment'] = 'page';
		$config['full_tag_open'] 		= '<div class="text-left pagination" style="float: left;padding: 6px 0px;margin: 5px 0">共'.@(floor($product_list['count'] / $this->config->get_config ( 'config_limit_admin' )) + 1) .'页/第'.@(floor($data['page'] / $this->config->get_config ( 'config_limit_admin' )) + 1) .'页</div><ul class="pagination" style="float: right;margin: 5px 0">';
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
		$config['total_rows'] 			= isset($product_list['count']) ? $product_list['count'] : '0';
		$config['per_page'] 			= $this->config->get_config('config_limit_admin');

		$this->pagination->initialize($config);

		$data['pagination'] = $this->pagination->create_links();
		
		$data['header']						=$this->header->index();
		$data['top']						=$this->header->top();
		$data['footer']						=$this->footer->index();
		
		$this->load->view('theme/default/template/product/product',$data);
	}
	
	public function invalid(){
		if(!$_SERVER['REQUEST_METHOD']=="POST"){
			return FALSE;
		}
		
		if($this->input->post('selected') != NULL){
			$data['invalid']='0';
			$data['date_invalid']=date('Y-m-d H:i:s',strtotime('+30 day'));
			foreach($this->input->post('selected') as $key=>$value){
				$this->product_model->invalid($this->input->post('selected')[$key], $data);
			}
		}
		
		if($this->input->post('product_id') != NULL && $this->input->post('date_invalid') != NULL && $this->input->post('date_invalid') != 'always'){
			$str='+'.$this->input->post('date_invalid').' day';
			$data['invalid']='0';
			$data['date_invalid']=date('Y-m-d H:i:s',strtotime($str));
			
			$this->product_model->invalid($this->input->post('product_id'), $data);
		}
		
		if($this->input->post('product_id') != NULL && $this->input->post('date_invalid') != NULL && $this->input->post('date_invalid') == 'always'){
			$data['invalid']='1';
			
			$this->product_model->invalid($this->input->post('product_id'), $data);
		}
		
		redirect(site_url('product/product'), 'location', 301);
	}
	
	public function uninvalid(){
		if(!$_SERVER['REQUEST_METHOD']=="POST"){
			return FALSE;
		}
		
		if($this->input->post('product_id') != NULL){
			$data['invalid']='0';
			$data['date_invalid']=date('Y-m-d H:i:s',strtotime('-1 day'));
			
			$this->product_model->invalid($this->input->post('product_id'), $data);
		}
		
		redirect(site_url('product/product'), 'location', 301);
	}
}
