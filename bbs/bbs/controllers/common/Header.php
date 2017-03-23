<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Header extends CI_Common {
	
	public function __construct() {
		parent::__construct();
		$this->load->helper(array('utf8'));
		$this->load->common(array('language_module', 'currency_common', 'cart_module', 'position_above'));
		$this->load->library(array('user_agent'));
		$this->load->model(array('common/tool_model', 'setting/sign_in_with_model', 'helper/information_model', 'bbs/bbs_model', 'common/user_activity_model'));
		
		//调ip黑名单，判断如果不在黑名单中则允许访问
		$this->tool_model->check_ban_ip();
		//写令牌
		$this->tool_model->writer_token();
	}

	public function index()
	{
		if(!empty($this->document->getTitle())){
			$data['title']									=$this->document->getTitle().'-'.unserialize($this->config->get_config('site_abbreviation'))[$_SESSION['language_id']];
		}else{
			$data['title']									=unserialize($this->config->get_config('site_name'))[$_SESSION['language_id']];
		}
		
		$data['description']								=$this->document->getDescription();
		$data['keywords']									=$this->document->getKeywords();
		$data['copyright']									=$this->document->getCopyright();
		$data['links']										=$this->document->getLinks();
		$data['styles']										=$this->document->getStyles();
		$data['scripts']									=$this->document->getScripts();
		
		return $this->load->view('theme/default/template/common/header',$data,TRUE);
	}
	
	public function top(){
		$data['position_above']=$this->position_above->index();
		$this->lang->load('common/header', $_SESSION['language_name']);

		if($this->user->hasPermission('access', 'admin/wecome')){
			$data['access_admin']							=TRUE;
		}
		
		if($this->user->hasPermission('access'. 'sale/wecome')){
			$data['access_sale']							=TRUE;
		}
		
		$data['nav_infomation']=$this->information_model->get_category_to_position('catalog_top');
		
		$data['url_admin']									= $this->config->item('admin');
		$data['url_sale']									= $this->config->item('sale');
		
		$data['language']									=$this->language_module->index();
		$data['currency']									=$this->currency_common->index();
		
		$data['sign_ins']									=$this->sign_in_with_model->get_sign_withs();
		
		$data['language_id']								=isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1';
		
		$data['menus']										=$this->bbs_model->get_plates('5');
		
		$this->load->model('bbs/bbs_model');
		
		$data['very_goods']									=$this->bbs_model->get_very_good('5');
		$data['actives']									=$this->bbs_model->get_active('5');
		
		$data['css']										='bbs';
		$data['activity_count']								=$this->user_activity_model->get_unread_message_count();
		$data['action_search']								=$this->input->get('search');
		return $this->load->view('theme/default/template/common/top',$data,TRUE);
	}
	
	public function no_find(){
		$this->output->set_status_header(404);
		
		$header												=$this->header->index();
		
		require_once(FCPATH.'public/view/page_missing.php');
		exit();
	}
}
