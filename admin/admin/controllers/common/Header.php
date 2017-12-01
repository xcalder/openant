<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Header extends CI_Common{
	public function __construct(){
		parent::__construct ();
		$this->load->helper ( array ('cookie', 'utf8'));
		$this->load->common ( array ('language_module', 'currency_common', 'image', 'position_above'));
		$this->load->library ( array ('user_agent'));
		$this->load->model(array('common/tool_model', 'information/information_model', 'common/user_activity_model'));
		
		//调ip黑名单，判断如果不在黑名单中则允许访问
		$this->tool_model->check_ban_ip();
		//写令牌
		$this->tool_model->writer_token();
		
		if(!$this->user->hasPermission('access', 'admin/wecome')){
			$this->session->set_flashdata('fali', '你没有访问管理员后台的权限！');
			redirect(base_url(), 'location', 301);
			exit;
		}
	}
	public function index(){
		$data ['title'] = $this->document->getTitle ().'-'.unserialize($this->config->get_config('site_abbreviation'))[$_SESSION['language_id']];
		$data ['description'] = $this->document->getDescription ();
		$data ['keywords'] = $this->document->getKeywords ();
		$data['copyright']=$this->document->getCopyright();
		$data ['links'] = $this->document->getLinks ();
		$data ['styles'] = $this->document->getStyles ();
		$data ['scripts'] = $this->document->getScripts ();
		
		return $this->load->view ( 'theme/default/template/common/header', $data, TRUE );
	}
	public function top(){
		$data['position_above']=$this->position_above->index();
		
		$this->lang->load ( 'common/header', $_SESSION['language_name']);
		
		if($this->user->hasPermission('access', 'sale/wecome' )){
			$data ['access_sale'] = TRUE;
		}
		
		$data ['url_sale'] = $this->config->item('sale');
		$data ['language'] = $this->language_module->index ();
		$data ['currency'] = $this->currency_common->index ();
		
		$data['language_id']=isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1';
		
		$data['nav_infomation']=$this->information_model->get_category_to_position('admin_top');
		
		$data['css']='admin';
		$data['activity_count']=$this->user_activity_model->get_unread_message_count();
		
		return $this->load->view ( 'theme/default/template/common/top', $data, TRUE );
	}
	
	public function no_find(){
		$this->output->set_status_header(404);
	
		$header=$this->header->index();
	
		require_once(FCPATH.'public/view/page_missing.php');
		exit();
	}
}
