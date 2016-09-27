<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends MY_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->language('wecome');
		if(!$this->user->hasPermission('access', 'sale/product/product')){
			$this->session->set_flashdata('fali', '你没有访问商家后台的权限！');
			redirect(base_url());
			exit;
		}
		$this->load->library(array('currency'));
		$this->load->model(array('product/product_model', 'common/language_model', 'product/address_model', 'product/attribute_model', 'product/option_model', 'product/manufacturer_model', 'product/barcode_model', 'product/stock_status_model', 'product/freight_model', 'product/aftermarket_model', 'product/tax_class_model', 'product/length_class_model', 'product/weight_class_model', 'product/user_class_model', 'product/download_model'));
	}

	public function index(){
		$this->document->setTitle('商品管理');
		
		$this->get_list();
	}
	
	//添加商品
	public function add(){
		$this->document->setTitle('添加商品');
		if(!$_SERVER['REQUEST_METHOD']=="POST" || $this->input->post('parent_id') == NULL){
			redirect(site_url('product/product/select_category'));
		}
		
		$this->get_form();
	}
	
	//添加商品
	public function add_product(){
		$this->document->setTitle('添加商品');
		if($_SERVER['REQUEST_METHOD']=="POST" && $this->check_modify()){
			$this->product_model->add_product($this->input->post());
			redirect(site_url('product/product'));
		}
		
		$this->get_form();
	}
	
	//编辑商品
	public function edit(){
		$this->document->setTitle('编辑商品');
		
		if($this->input->get('product_id') == NULL){
			redirect(site_url('product/product/select_category'));
		}
		
		if($_SERVER['REQUEST_METHOD']=="POST" && $this->check_modify()){
			$this->product_model->edit_product($this->input->post());
			redirect(site_url('product/product'));
		}
		$this->get_form();
	}
	
	//添加商品
	public function select_category(){
		$this->document->setTitle('选择分类');
		
		$data['parent_categorys']=$this->product_model->get_parent_categorys();
		$data['last_add']=$this->product_model->get_last_add();
		
		$data['action']						=site_url('product/product/add');
		
		$data['header']						=$this->header->index();
		$data['top']						=$this->header->top();
		$data['footer']						=$this->footer->index();
		
		$this->load->view('theme/default/template/product/select_category',$data);
	}
	
	public function added(){
		$this->document->setTitle('批量上架商品');
		
		if($_SERVER['REQUEST_METHOD']=="POST" && !empty($this->input->post('selected')) && $this->check_modify()){
			$this->product_model->added($this->input->post('selected'));
		}
		redirect(site_url('product/product'));
		
		$this->get_list();
	}
	
	public function shelves(){
		$this->document->setTitle('批量下架商品');
		
		if($_SERVER['REQUEST_METHOD']=="POST" && !empty($this->input->post('selected')) && $this->check_modify()){
			$this->product_model->shelves($this->input->post('selected'));
		}
		
		redirect(site_url('product/product'));
		
		$this->get_list();
	}
	public function delete(){
		$this->document->setTitle('批量下架商品');
		
		if($_SERVER['REQUEST_METHOD']=="POST" && !empty($this->input->post('selected')) && $this->check_modify()){
			$this->product_model->delete_product($this->input->post('selected'));
		}
		
		redirect(site_url('product/product'));
		
		$this->get_list();
	}
	
	public function get_form(){
		$this->document->addScript('public/min?f=public/resources/default/js/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js');
		$this->document->addStyle('public/min?f=public/resources/default/js/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css');
		
		$data['languages'] = $this->language_model->get_languages();
		$data['addresss']=$this->address_model->get_addresss($this->user->getId());
		
		if($this->input->get('product_id') != NULL){
			$product_info=$this->product_model->get_product_to_form($this->input->get('product_id'));
			$data['products']=$product_info;
		}
		
		if($this->input->post('base')){
			$data['bases']=$this->input->post('base');
		}elseif(isset($product_info)){
			$data['bases']=$product_info;
		}
		
		$data['child_id']=$this->input->post('child_id');
		$data['parent_id']=$this->input->post('parent_id');
		if($this->input->post('child_id') != NULL){
			$category_id=$this->input->post('child_id');
		}elseif($this->input->post('parent_id') != NULL){
			$category_id=$this->input->post('parent_id');
		}elseif(isset($product_info)){
			$category_id=$product_info['category']['category_id'];
		}elseif($this->input->post('category_id') != NULL){
			$category_id=$this->input->post('category_id');
		}
		$data['category_id']=$category_id;
		
		if($this->input->post('description') != NULL){
			$data['descriptions']=$this->input->post('description');
		}elseif(isset($product_info['description'])){
			$data['descriptions']=$product_info['description'];
		}
		
		if($this->input->post('options') != NULL){
			$product_options=$this->input->post('options');
		}elseif(isset($product_info['options'])){
			$product_options=$product_info['options'];
		}
		
		if($this->input->post('discount') != NULL){
			$data['product_discounts']=$this->input->post('discount');
		}elseif(isset($product_info['discount'])){
			$data['product_discounts']=$product_info['discount'];
		}
		
		if($this->input->post('barcode') != NULL){
			$data['product_barcodes']=$this->input->post('barcode');
		}elseif(isset($product_info['barcodes'])){
			$data['product_barcodes']=$product_info['barcodes'];
		}
		
		if($this->input->post('special') != NULL){
			$data['product_specials']=$this->input->post('special');
		}elseif(isset($product_info['special'])){
			$data['product_specials']=$product_info['special'];
		}
		
		if($this->input->post('attribute') != NULL){
			$product_attributes=$this->input->post('attribute');
		}elseif(isset($product_info['attributes'])){
			$product_attributes=$product_info['attributes'];
		}
		
		if($this->input->post('aftermarket') != NULL){
			$data['product_aftermarkets']=array_flip(array_flip(array_column($this->input->post('aftermarket'),'aftermarket_id')));
		}elseif(isset($product_info['aftermarkets'])){
			$data['product_aftermarkets']=array_flip(array_flip(array_column($product_info['aftermarkets'],'aftermarket_id')));
		}
		
		if($this->input->post('download') != NULL){
			$product_downloads=$this->input->post('download');
		}elseif(isset($product_info['downloads'])){
			$product_downloads=$product_info['downloads'];
		}
		
		
		if($this->input->post('image') != NULL){
			$data['images']=$this->input->post('image');
		}elseif(isset($product_info['images'])){
			$data['images']=$product_info['images'];
		}
		
		
		if(isset($category_id)){
			$manufacturers=$this->product_model->get_category_options($category_id, 'manufacturer');
			if($manufacturers){
				$manufacturers=array_flip(array_flip(array_column($manufacturers,'value')));
				$data['manufacturers']=$this->manufacturer_model->get_manufacturers($manufacturers);
			}
			
			$options=$this->product_model->get_category_options($category_id, 'option');
			if($options){
				$options=array_flip(array_flip(array_column($options,'value')));
				$option_groups=$this->option_model->get_option_group($options);
				if(isset($product_options)){
					$data['product_options']=$product_options;
				}
				
				$data['option_groups']=$option_groups;
			}
				
			$attributes=$this->product_model->get_category_options($category_id, 'attribute');
			if($attributes){
				$attributes=array_flip(array_flip(array_column($attributes,'value')));
				$attribute_groups=$this->attribute_model->get_attribute_group($attributes);
				if(isset($product_attributes)){
					$continue=FALSE;
					if($continue === FALSE){
						foreach($attribute_groups as $key=>$value){
							foreach($attribute_groups[$key]['attributes'] as $k=>$v){
								foreach($product_attributes as $b=>$c){
									foreach($product_attributes[$b] as $d=>$e){
										if(isset($product_attributes[$b][$d]['attribute_id']) && $attribute_groups[$key]['attributes'][$k]['attribute_id'] == $product_attributes[$b][$d]['attribute_id']){
											
											if(!empty($product_attributes[$b][$d]['text'])){
												$attribute_groups[$key]['attributes'][$k]['value'][$b]=$product_attributes[$b][$d]['text'];
											}elseif(!empty($product_attributes[$b][$d]['image'])){
												$attribute_groups[$key]['attributes'][$k]['value'][$b]=$product_attributes[$b][$d]['image'];
											}else{
												$attribute_groups[$key]['attributes'][$k]['value'][$b]=$product_attributes[$b][$d]['attribute_id'];
											}
											$continue=TRUE;
										}
									}
								}
							}
						}
					}
				}
				$data['attribute_groups']=$attribute_groups;
			}
			
			$barcodes=$this->product_model->get_category_options($category_id, 'barcode');
			if($barcodes){
				$barcodes=array_flip(array_flip(array_column($barcodes,'value')));
				$data['barcodes']=$this->barcode_model->get_barcodes($barcodes);
			}
			
			$stock_statuss=$this->product_model->get_category_options($category_id, 'stock_status');
			if($stock_statuss){
				$stock_statuss=array_flip(array_flip(array_column($stock_statuss,'value')));
				$data['stock_statuss']=$this->stock_status_model->get_stock_statuss($stock_statuss);
			}
			
			$aftermarkets=$this->product_model->get_category_options($category_id, 'aftermarket');
			if($aftermarkets){
				$aftermarkets=array_flip(array_flip(array_column($aftermarkets,'value')));
				$data['aftermarkets']=$this->aftermarket_model->get_aftermarkets($aftermarkets);
			}
			
			$downloads=$this->product_model->get_category_options($category_id, 'download');
			if($downloads){
				$downloads=array_flip(array_flip(array_column($downloads,'value')));
				$downloads=$this->download_model->get_downloads($downloads);
				
				if(isset($product_downloads)){
					$continue=FALSE;
					if($continue === FALSE){
						foreach($downloads as $key=>$value){
							foreach($product_downloads as $b=>$c){
								if($product_downloads[$b]['download_id'] == $downloads[$key]['download_id']){
									if(!empty($product_downloads[$b]['filename'])){
										$downloads[$key]['filename']=$product_downloads[$b]['filename'];
									}
									if(!empty($product_downloads[$b]['mask'])){
										$downloads[$key]['mask']=$product_downloads[$b]['mask'];
									}
									if(!empty($product_downloads[$b]['description'])){
										$downloads[$key]['description']=$product_downloads[$b]['description'];
									}
									if(!empty($product_downloads[$b]['date_added'])){
										$downloads[$key]['date_added']=$product_downloads[$b]['date_added'];
									}
									$continue=TRUE;
								}
							}
						}
					}
				}
				$data['downloads']=$downloads;
			}
			
			$tax_classs=$this->product_model->get_category_options($category_id, 'tax_class');
			if($tax_classs){
				$tax_classs=array_flip(array_flip(array_column($tax_classs,'value')));
				$data['tax_classs']=$this->tax_class_model->get_tax_classs($tax_classs);
			}
			
			unset($category_id);
		}
		
		$data['placeholder_image']='public/resources/default/image/no_image.jpg';
		$data['freight_templates']=$this->freight_model->get_freight_templates();
		$data['length_classs']=$this->length_class_model->get_length_classs();
		$data['weight_classs']=$this->weight_class_model->get_weight_classs();
		$data['user_classs']=$this->user_class_model->get_user_classs_to_product();
		
		$data['header']						=$this->header->index();
		$data['top']						=$this->header->top();
		$data['footer']						=$this->footer->index();
		
		if($this->input->get('product_id') != NULL){
			$data['action']					=site_url('product/product/edit?product_id=').$this->input->get('product_id');
		}else{
			$data['action']					=site_url('product/product/add_product');
		}
		$this->load->view('theme/default/template/product/product_form',$data);
	}
	
	public function get_list(){
		if($this->input->get('page')){
			$data['page']=$this->input->get('page');
		}else{
			$data['page']='0';
		}
		
		if($this->input->get('status') != NULL){
			$data['status']=$this->input->get('status');
			$url_pagination=site_url('product/product?status=').$this->input->get('status');
		}
		
		if($this->input->get('invalid') != NULL){
			$data['invalid']=$this->input->get('invalid');
			$url_pagination=site_url('product/product?invalid=').$this->input->get('invalid');
		}
		
		if($this->input->get('time') != NULL){
			$data['time']=$this->input->get('time');
			$url_pagination=site_url('product/product?time=').$this->input->get('time');
		}
		
		$product_list=$this->product_model->get_products($data);
		
		$data=array();
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
		
		$data['added']					=site_url('product/product/added');
		$data['shelves']				=site_url('product/product/shelves');
		$data['delete']					=site_url('product/product/delete');
		
		//分页
		$config['base_url'] 			= isset($url_pagination) ? $url_pagination : site_url('product/product');
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
		
		$this->load->view('theme/default/template/product/product_list',$data);
	}
	
	public function get_child_category(){
		$child_category = $this->product_model->get_child_categorys($this->input->get('parent_id'));
		$child_id=$this->product_model->get_last_add()['child_id'];
		$json=array();
		if($child_category){
			foreach($child_category as $key=>$value){
				if($child_category[$key]['category_id'] == $child_id){
					$json[$key]['child_id']=$child_id;
				}
				$json[$key]=$child_category[$key];
			}
			$json['child_id']=$child_id;
			$json=$child_category;
			unset($child_category);
			unset($child_id);
		}
		
		$this->output
		->set_content_type('application/json')
		->set_output(json_encode($json));

	}
	
	public function check_modify(){
		if (!$this->user->hasPermission('modify', 'sale/product/product')) {
			$this->session->set_flashdata('danger', '你无权修改，请联系管理员！');
			redirect(site_url('product/product'));
			exit();
		}else {
			return true;
		}
	}
}
