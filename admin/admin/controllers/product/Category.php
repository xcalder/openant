<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends MY_Controller {
	private $error = array();
	
	public function __construct() {
		parent::__construct();
		$this->load->language('product/category');
		if(!$this->user->hasPermission('access', 'admin/product/category')){
			$this->session->set_flashdata('fali', '你没有访问权限！');
			redirect($this->config->item('admin'));
			exit;
		}
		$this->load->model(array('product/product_model','common/language_model', 'common/download_model', 'common/attribute_model', 'common/option_model', 'common/manufacturer_model', 'common/barcode_model', 'localisation/stock_status_model', 'localisation/aftermarket_model', 'localisation/tax_class_model'));
	}

	public function index()
	{
		$this->document->setTitle('分类管理');
		$this->get_list();
	}
	
	//修改
	public function edit(){
		$this->document->setTitle('分类编辑');
		
		if($_SERVER['REQUEST_METHOD']=="POST" && $this->validateForm()){
			$this->product_model->edit_category($this->input->post());
			
			redirect($this->config->item('admin').'/product/category');
		}
		
		$this->get_form();
	}
	
	//添加
	public function add(){
		$this->document->setTitle('添加分类');
		
		if($_SERVER['REQUEST_METHOD']=="POST" && $this->validateForm()){
			$this->product_model->add_category($this->input->post());
			
			redirect($this->config->item('admin').'/product/category');
		}
		
		$this->get_form();
	}
	
	//添加
	public function delete(){
		$this->document->setTitle('删除分类');
		if($this->validate_delete($this->input->post('selected'))){
			$this->product_model->delete_category($this->input->post('selected'));
			
			redirect($this->config->item('admin').'/product/category');
			return;
		}
		redirect($this->config->item('admin').'/product/category');
		$this->get_list();
	}
	
	//列表
	protected function get_list(){
		$data=array();
		
		$data['delete']					=$this->config->item('admin').'/product/category/delete';
		
		$categorys = $this->product_model->get_categorys($this->input->get('limit'));
		$data['categorys']=$categorys['categorys'];
		
		//分页
		if(!$this->input->get('limit')){
			$limit = '0';
		}else{
			$limit = $this->input->get('limit');
		}
		
		
		$config['base_url'] 			= $this->config->item('admin').'/product/category';
		$config['num_links'] 			= 2;
		$config['page_query_string'] 	= TRUE;
		$config['query_string_segment'] = 'limit';
		$config['full_tag_open'] 		= '<div class="text-left pagination" style="float: left;padding: 6px 0px;margin: 5px 0">共'.@(floor($categorys['count'] / $this->config->get_config ( 'config_limit_admin' )) + 1) .'页/第'.@(floor($limit / $this->config->get_config ( 'config_limit_admin' )) + 1) .'页</div><ul class="pagination" style="float: right;margin: 5px 0">';
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
		$config['total_rows'] 			= $categorys['count'];
		$config['per_page'] 			= $this->config->get_config('config_limit_admin');

		$this->pagination->initialize($config);

		$data['pagination'] = $this->pagination->create_links();
		
		$data['header']=$this->header->index();
		$data['top']=$this->header->top();
		$data['footer']=$this->footer->index();
		
		$this->load->view('theme/default/template/product/category_list',$data);
	}
	
	//修改分类
	protected function get_form()
	{
		$data['languages'] = $this->language_model->get_languages();
		
		$cotegorys_select = $this->product_model->get_categorys_store();
		foreach($cotegorys_select as $k=>$v){
			if($cotegorys_select[$k]['parent_id'] != '0'){
				unset($cotegorys_select[$k]);
			}
		}
		$data['cotegorys_select'] = $cotegorys_select;
		
		
		$data['attributes'] = $this->attribute_model->get_attribute_groups_to_category();
		$data['options'] = $this->option_model->get_option_groups_to_category();
		$data['manufacturers'] = $this->manufacturer_model->get_manufacturers_to_category();
		$data['barcodes'] = $this->barcode_model->get_barcodes_to_category();
		$data['stock_statuss'] = $this->stock_status_model->get_stock_statuss_to_category();
		$data['aftermarkets'] = $this->aftermarket_model->get_aftermarkets_to_category();
		$data['tax_classs'] = $this->tax_class_model->get_tax_classs_to_category();
		$data['downloads'] = $this->download_model->get_downloads_to_category();
		
		if($this->input->get('category_id') !== NULL){
			$category_option_info=$this->product_model->get_category_options($this->input->get('category_id'));
			
			if($category_option_info !== FALSE && is_array($category_option_info)){
				foreach($category_option_info as $key=>$value){
					if($category_option_info[$key]['type'] == 'attribute'){
						$attribute[]=$category_option_info[$key];
					}
					if($category_option_info[$key]['type'] == 'option'){
						$option[]=$category_option_info[$key];
					}
					if($category_option_info[$key]['type'] == 'manufacturer'){
						$manufacturer[]=$category_option_info[$key];
					}
					if($category_option_info[$key]['type'] == 'barcode'){
						$barcode[]=$category_option_info[$key];
					}
					if($category_option_info[$key]['type'] == 'stock_status'){
						$stock_status[]=$category_option_info[$key];
					}
					if($category_option_info[$key]['type'] == 'aftermarket'){
						$aftermarket[]=$category_option_info[$key];
					}
					if($category_option_info[$key]['type'] == 'tax_class'){
						$tax_class[]=$category_option_info[$key];
					}
					if($category_option_info[$key]['type'] == 'download'){
						$download[]=$category_option_info[$key];
					}
				}
				unset($category_option_info);
				if(isset($attribute)){
					$data['ol_attribute']=array_flip(array_flip(array_column($attribute,'value')));
					$data['ol_attribute_required']=array_flip(array_flip(array_column($attribute,'required')));
					unset($attribute);
				}
				
				if(isset($option)){
					$data['ol_option']=array_flip(array_flip(array_column($option,'value')));
					$data['ol_option_required']=array_flip(array_flip(array_column($option,'required')));
					$data['ol_options']=$option;
					unset($option);
				}
				
				if(isset($manufacturer)){
					$data['ol_manufacturer']=array_flip(array_flip(array_column($manufacturer,'value')));
					$data['ol_manufacturer_required']=array_flip(array_flip(array_column($manufacturer,'required')));
					unset($manufacturer);
				}
				if(isset($barcode)){
					$data['ol_barcode']=array_flip(array_flip(array_column($barcode,'value')));
					$data['ol_barcode_required']=array_flip(array_flip(array_column($barcode,'required')));
					unset($barcode);
				}
				if(isset($stock_status)){
					$data['ol_stock_status']=array_flip(array_flip(array_column($stock_status,'value')));
					$data['ol_stock_status_required']=array_flip(array_flip(array_column($stock_status,'required')));
					unset($stock_status);
				}
				if(isset($aftermarket)){
					$data['ol_aftermarket']=array_flip(array_flip(array_column($aftermarket,'value')));
					$data['ol_aftermarket_required']=array_flip(array_flip(array_column($aftermarket,'required')));
					unset($aftermarket);
				}
				if(isset($tax_class)){
					$data['ol_tax_class']=array_flip(array_flip(array_column($tax_class,'value')));
					$data['ol_tax_class_required']=array_flip(array_flip(array_column($tax_class,'required')));
					unset($tax_class);
				}
				if(isset($download)){
					$data['ol_download']=array_flip(array_flip(array_column($download,'value')));
					$data['ol_download_required']=array_flip(array_flip(array_column($download,'required')));
					unset($download);
				}
			}
		}
		
		
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = array();
		}
		
		$category_info = $this->product_model->get_category_info($this->input->get('category_id'));
		$data['placeholder_image']='resources/public/resources/default/image/no_image.jpg';
		
		if($this->input->post('image')){
			$data['image']=$this->image_common->resize($this->input->post('image'),100,100,'h');
		}elseif(!empty($category_info['image'])){
			$data['image']=$this->image_common->resize($category_info['image'],100,100,'h');
		}else{
			$data['image']='resources/public/resources/default/image/no_image.jpg';
		}
		
		if($this->input->post('category_description')){
			$data['category_description']=$this->input->post('category_description');
		}elseif(isset($category_info['category_description'])){
			$data['category_description']=$category_info['category_description'];
		}else{
			$data['category_description']=array();
		}
		
		if($this->input->post('parent_id')){
			$data['parent_id']=$this->input->post('parent_id');
		}elseif(isset($category_info['parent_id'])){
			$data['parent_id']=$category_info['parent_id'];
		}else{
			$data['parent_id']='';
		}
		
		if($this->input->post('sort_order')){
			$data['sort_order']=$this->input->post('sort_order');
		}elseif(isset($category_info['sort_order'])){
			$data['sort_order']=$category_info['sort_order'];
		}else{
			$data['sort_order']='';
		}
		
		if($this->input->post('status')){
			$data['status']=$this->input->post('status');
		}elseif(isset($category_info['status'])){
			$data['status']=$category_info['status'];
		}else{
			$data['status']='';
		}
		
		if($this->input->post('column')){
			$data['column']=$this->input->post('column');
		}elseif(isset($category_info['column'])){
			$data['column']=$category_info['column'];
		}else{
			$data['column']='';
		}
		
		if($this->input->post('top')){
			$data['top']=$this->input->post('top');
		}elseif(isset($category_info['top'])){
			$data['top']=$category_info['top'];
		}else{
			$data['top']='';
		}
		
		if($this->input->get('category_id')){
			$data['action'] = $this->config->item('admin').'/product/category/edit?category_id='.$this->input->get('category_id');
		}else{
			$data['action'] = $this->config->item('admin').'/product/category/add';
		}
		
		$data['header']=$this->header->index();
		$data['top_nav']=$this->header->top();
		$data['footer']=$this->footer->index();
		
		$this->load->view('theme/default/template/product/category_form',$data);
	}
	
	//验证表单
	private function validateForm(){
		if (!$this->user->hasPermission('modify', 'admin/product/category')) {
			$this->session->set_flashdata('danger', '你无权修改，请联系管理员！');
			redirect($this->config->item('admin').'/product/category');
			exit();
		}
		
		foreach ($this->input->post('category_description') as $language_id => $value) {
			if ((utf8_strlen($value['name']) < 2) || (utf8_strlen($value['name']) > 255)) {
				$this->error['name'][$language_id] = '分类名2——255字符';
			}
		}

		return !$this->error;
	}
	
	//验证删除
	public function validate_delete($data)
	{
		if (!$this->user->hasPermission('modify', 'admin/product/category')) {
			$this->session->set_flashdata('danger', '你无权修改，请联系管理员！');
			redirect($this->config->item('admin').'/product/category');
			exit();
		}
		
		if(empty($data)){
			return FALSE;
		}
		foreach($data as $key=>$value){
			if($this->product_model->get_product_to_category_for_category_id($data[$key]) != FALSE){
				$this->error[$key]['error_delete']='下在被使用';
			}
		}
		
		return !$this->error;
	}
}
