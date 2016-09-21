<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Header extends CI_Common {
	
	public function __construct() {
		parent::__construct();
		$this->load->helper(array('utf8'));
		$this->load->common(array('language_module','currency_common', 'position_above'));
		$this->load->library(array('user_agent'));
		$this->load->model(array('setting/sign_in_with_model', 'common/information_model'));
		
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
		
		if(!$this->user->hasPermission('access', 'sale/wecome')){
			$this->session->set_flashdata('fali', '你没有访问商家后台的权限！');
			redirect(base_url(), 'location', 301);
			exit;
		}
	}

	public function index()
	{
		if(!empty($this->document->getTitle())){
			$data['title']=$this->document->getTitle().'-'.unserialize($this->config->get_config('site_abbreviation'))[$_SESSION['language_id']];
		}else{
			$data['title']=unserialize($this->config->get_config('site_name'))[$_SESSION['language_id']].'-'.unserialize($this->config->get_config('site_abbreviation'))[$_SESSION['language_id']];
		}
		
		$data['description']=$this->document->getDescription();
		$data['keywords']=$this->document->getKeywords();
		$data['links']=$this->document->getLinks();
		$data['styles']=$this->document->getStyles();
		$data['scripts']=$this->document->getScripts();
		
		return $this->load->view('theme/default/template/common/header',$data,TRUE);
	}
	
	public function top(){
		$data['position_above']=$this->position_above->index();
		
		$this->lang->load('common/header',$_SESSION['language_name']);
		
		if($this->user->hasPermission('access', 'admin/wecome')){
			$data['access_admin']=TRUE;
		}
		
		$data['url_admin']='admin.php';
		
		$data['language']=$this->language_module->index();
		$data['currency']=$this->currency_common->index();
		
		$data['language_id']=isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1';
		
		$data['nav_infomation']=$this->information_model->get_category_to_position('sale_top');
		
		return $this->load->view('theme/default/template/common/top',$data,TRUE);
	}
}
