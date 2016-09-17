<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Header extends CI_Common {
	
	public function __construct() {
		parent::__construct();
		$this->load->helper(array('utf8'));
		$this->load->common(array('language_module', 'currency_common', 'cart_module', 'position_above'));
		$this->load->library(array('user_agent'));
		$this->load->model(array('category/category_model', 'setting/sign_in_with_model', 'helper/information_model', 'common/manufacturer_model'));
		$this->lang->load('common/header',$_SESSION['language_name']);
		
		//调ip黑名单，判断如果不在黑名单中则允许访问
		$this->load->database();
		$this->db->select('ip');
		$this->db->where('ip', $this->input->ip_address());
		$this->db->from($this->db->dbprefix('user_ban_ip'));
		$query = $this->db->get();
		if($query->num_rows() > 0){
			
			$this->session->set_flashdata('fali', '被禁止访问的ip地址！');
			unset($_SESSION['user_id']);
		}
		
		//写令牌
		
		if(!isset($_SESSION['token'])){
			$str = uniqid(mt_rand(),1);
			$this->session->set_userdata('token', md5($str));
			//在线用户
			$this->db->insert($this->db->dbprefix('user_online'), array('token'=>$_SESSION['token']));
		}
	}

	public function index()
	{
		if(!empty($this->document->getTitle())){
			$data['title']=$this->document->getTitle().'-'.unserialize($this->config->get_config('site_abbreviation'))[$_SESSION['language_id']];
		}else{
			$data['title']=unserialize($this->config->get_config('site_abbreviation'))[$_SESSION['language_id']];
		}
		
		$data['description']=$this->document->getDescription();
		$data['copyright']=$this->document->getCopyright();
		$data['keywords']=$this->document->getKeywords();
		$data['copyright']=$this->document->getCopyright();
		$data['links']=$this->document->getLinks();
		$data['styles']=$this->document->getStyles();
		$data['scripts']=$this->document->getScripts();
		
		return $this->load->view('theme/default/template/common/header',$data,TRUE);
	}
	
	public function top(){
		
		$data['position_above']=$this->position_above->index();

		if($this->user->hasPermission_access('admin')){
			$data['access_admin']=TRUE;
		}
		
		if($this->user->hasPermission_access('sale')){
			$data['access_sale']=TRUE;
		}
		
		$data['nav_infomation']=$this->information_model->get_category_to_position('catalog_top');
		
		$data['menus']=$this->category_model->get_categorys_to_top();
		
		$data['url_admin']='admin.php';
		$data['url_sale']='sale.php';
		
		$data['action_id']=$this->input->get('id');
		$data['action_search']=$this->input->get('search');
		
		$data['language']=$this->language_module->index();
		$data['currency']=$this->currency_common->index();
		
		$data['cart_module']=$this->cart_module->index();
		
		$data['sign_ins']=$this->sign_in_with_model->get_sign_withs();
		
		$data['language_id']=isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1';
		
		$data['manufacturers']=$this->manufacturer_model->get_manufacturers_to_header();
		$data['categorys']=$this->category_model->get_categorys_to_header();

		return $this->load->view('theme/default/template/common/top',$data,TRUE);
	}
	
	public function faq_top(){
		$this->load->model('helper/information_model');
		$data['position_above']=$this->position_above->index();

		if($this->user->hasPermission_access('admin')){
			$data['access_admin']=TRUE;
		}
		
		if($this->user->hasPermission_access('sale')){
			$data['access_sale']=TRUE;
		}
		
		$data['nav_infomation']=$this->information_model->get_category_to_position('catalog_top');
		
		$data['menus']=$this->information_model->get_top_categorys();
		
		$data['url_admin']='admin.php';
		$data['url_sale']='sale.php';
		
		$data['action_id']=$this->input->get('id');
		$data['action_search']=$this->input->get('search');
		
		$data['language']=$this->language_module->index();
		$data['currency']=$this->currency_common->index();
		
		$data['cart_module']=$this->cart_module->index();
		
		$data['sign_ins']=$this->sign_in_with_model->get_sign_withs();
		
		$data['language_id']=isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1';
		
		return $this->load->view('theme/default/template/common/faq_top',$data,TRUE);
	}
	
	public function user_top(){
		$this->load->model(array('order/order_model'));
		
		$count_orders=$this->order_model->count_orders();
		
		$count_status=array();
		if($count_status){
			foreach($count_orders as $k=>$v){
				if($count_orders[$k]['order_status_id'] == $this->config->get_config('default_order_status')){
					$data['count_default_order']=$count_orders[$k]['count'];
					$count_status[]=$count_orders[$k]['count'];
				}
				
				if($count_orders[$k]['order_status_id'] == $this->config->get_config('to_be_delivered')){
					$data['count_to_be_delivered']=$count_orders[$k]['count'];
					$count_status[]=$count_orders[$k]['count'];
				}
				
				if($count_orders[$k]['order_status_id'] == $this->config->get_config('inbound_state')){
					$data['count_inbound_state']=$count_orders[$k]['count'];
					$count_status[]=$count_orders[$k]['count'];
				}
				
				if($count_orders[$k]['order_status_id'] == $this->config->get_config('state_to_be_evaluated')){
					$data['count_to_be_evaluated']=$count_orders[$k]['count'];
					$count_status[]=$count_orders[$k]['count'];
				}
				
				if($count_orders[$k]['order_status_id'] == $this->config->get_config('refund_order')){
					$data['count_refund_order']=$count_orders[$k]['count'];
				}
			}
		}
		
		if(!empty($count_status)){
			$data['count_sum']=array_sum($count_status);
		}
		
		$data['position_above']=$this->position_above->index();
		
		if($this->user->hasPermission_access('admin')){
			$data['access_admin']=TRUE;
		}
		
		if($this->user->hasPermission_access('sale')){
			$data['access_sale']=TRUE;
		}
		
		$data['language']=$this->language_module->index();
		$data['currency']=$this->currency_common->index();
		
		$data['action_id']=$this->input->get('id');
		$data['action_search']=$this->input->get('search');
		
		$data['url_admin']='admin.php';
		$data['url_sale']='sale.php';
		
		$data['cart_module']=$this->cart_module->index();
		
		$data['language_id']=isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1';
		
		$data['nav_infomation']=$this->information_model->get_category_to_position('catalog_top');
		
		$data['manufacturers']=$this->manufacturer_model->get_manufacturers_to_header();
		$data['categorys']=$this->category_model->get_categorys_to_header();
		
		return $this->load->view('theme/default/template/common/user_top',$data,TRUE);
	}
	
	public function step_top(){
		$data['position_above']=$this->position_above->index();
		
		if($this->user->hasPermission_access('admin')){
			$data['access_admin']=TRUE;
		}
		
		if($this->user->hasPermission_access('sale')){
			$data['access_sale']=TRUE;
		}
		
		$data['language']=$this->language_module->index();
		$data['currency']=$this->currency_common->index();
		
		$data['action_id']=$this->input->get('id');
		$data['action_search']=$this->input->get('search');
		
		$data['url_admin']='admin.php';
		$data['url_sale']='sale.php';
		
		$data['sign_ins']=$this->sign_in_with_model->get_sign_withs();
		
		$data['cart_module']=$this->cart_module->index();
		
		$data['language_id']=isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1';
		
		$data['nav_infomation']=$this->information_model->get_category_to_position('catalog_top');
		
		$data['manufacturers']=$this->manufacturer_model->get_manufacturers_to_header();
		$data['categorys']=$this->category_model->get_categorys_to_header();
		
		return $this->load->view('theme/default/template/common/step_top',$data,TRUE);
	}
	
	public function login_top(){
		$data['position_above']=$this->position_above->index();
		
		$data['sign_ins']=$this->sign_in_with_model->get_sign_withs();
		
		$data['language']=$this->language_module->index();
		$data['currency']=$this->currency_common->index();
		
		$data['language_id']=isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1';
		
		$data['nav_infomation']=$this->information_model->get_category_to_position('catalog_top');

		$data['manufacturers']=$this->manufacturer_model->get_manufacturers_to_header();
		$data['categorys']=$this->category_model->get_categorys_to_header();
		
		return $this->load->view('theme/default/template/common/login_top',$data,TRUE);
	}
	
	public function no_find(){
		$position_top=$this->position_top->index();
		$position_left=$this->position_left->index();
		$position_right=$this->position_right->index();
		$position_bottom=$this->position_bottom->index();
		$this->output->set_status_header(404);
		
		$image_404=$this->image_common->resize('/public/404.png', 210 , 210);
		
		$header=$this->header->index();
		$top=$this->header->top();
		$footer=$this->footer->index();
		
		$nav_infomation=$this->information_model->get_category_to_position('catalog_top');
		
		require_once(FCPATH.'catalog/views/theme/default/template/errors/page_missing.php');
		exit();
	}
}
