<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forget extends CI_Controller {
	private $error = array();
	
	public function __construct() {
		parent::__construct();
		$this->load->helper(array('string'));
		$this->load->model(array('common/user_model', 'common/forget_model'));
		
		$this->document->addStyle(base_url('resources/public/resources/default/css/ystep/ystep.css'));
		$this->document->addScript(base_url('resources/public/resources/default/js/ystep/ystep.js'));
	}

	public function index()
	{
		$this->document->setTitle('找回密码');
		
		if($this->user->isLogged()){
			redirect($this->config->item('catalog').'user/edit/edit_paswd');
		}
		
		if($_SERVER['REQUEST_METHOD']=="POST" && $this->user_model->get_user_for_email($this->input->post('email')) && $this->valid_index()){
			$check										=random_string('sha1');
			
			$data['to']									=$this->input->post('email');
			$data['name']								=unserialize($this->config->get_config('site_abbreviation'))[$_SESSION['language_id']].'帐号中心';
			$data['subject']							='密码重置：你收到这封邮件是因为你在'.unserialize($this->config->get_config('site_abbreviation'))[$_SESSION['language_id']].'申请了修改密码服务,如果不是你的操作，请忽略此邮件！';
			$massage									='<h3>重置你在'.unserialize($this->config->get_config('site_abbreviation'))[$_SESSION['language_id']].'的密码<h3>';
			$massage									.='<h5><br/>这是一封系统邮件，请不要直接回复<br/><h5>';
			$massage									.='<p>本次改密申请24小时内有效，如果超时请重新申请！<br/>你可以直接<a href="'.$this->config->item('catalog').'user/forget/edit?check='.$check.'">点击链接修改密码</a><br/><br/>当上面的链接不可用时，请复制下面的网址到地址栏直接访问！<br/><br/>'.$this->config->item('catalog').'user/forget/edit?check='.$check.'<p>';
			$data['message']							=$massage;
			$this->load->common('sender_email');
			if($this->sender_email->sender($data)){
				$data=array();
				$data['email']								=$this->input->post('email');
				$data['date_added']							=date("Y-m-d H:i:s");
				$data['check']								=$check;
				
				$this->forget_model->add($data);
				
				$data=array();
				$this->session->set_flashdata('forget_info', TRUE);
				redirect($this->config->item('catalog').'user/forget/info', 'location', 301);
			}else{
				$this->session->set_flashdata('fali', '服务器超时，请联系网站管理员！');
				redirect($this->config->item('catalog').'user/forget', 'location', 301);
			}
			
		}
		
		if(isset($this->error['error_times'])){
			$data['error_times']=$this->error['error_times'];
		}
		
		$data['position_top']=$this->position_top->index();
		$data['position_left']=$this->position_left->index();
		$data['position_right']=$this->position_right->index();
		$data['position_bottom']=$this->position_bottom->index();
		
		$data['header']=$this->header->index();
		$data['login_top']=$this->header->step_top();
		$data['login_footer']=$this->footer->index();
		$this->load->view('theme/default/template/user/forget',$data);
	}
	
	//找回密码发送邮件后的提示
	public function info()
	{
		if(!isset($_SESSION['forget_info'])){
			redirect($this->config->item('catalog').'user/forget', 'location', 301);
		}
		
		if($this->user->isLogged()){
			redirect($this->config->item('catalog').'user/edit/edit_paswd');
		}
		
		$this->document->setTitle('邮件发送成功');
		
		$data['position_top']=$this->position_top->index();
		$data['position_left']=$this->position_left->index();
		$data['position_right']=$this->position_right->index();
		$data['position_bottom']=$this->position_bottom->index();
		
		$data['header']=$this->header->index();
		$data['login_top']=$this->header->step_top();
		$data['login_footer']=$this->footer->index();
		$this->load->view('theme/default/template/user/forget_info',$data);
	}
	
	//找回密码发送邮件后的提示
	public function edit()
	{
		if($this->user->isLogged()){
			redirect($this->config->item('catalog').'user/edit/edit_paswd');
		}
		
		if($this->input->get('check') == NULL){
			$this->session->set_flashdata('warning', '密码重置失败！');
			redirect($this->config->item('catalog').'user/forget', 'location', 301);
		}

		$this->document->setTitle('重置密码');
		
		if($_SERVER['REQUEST_METHOD']=="POST" && $this->vali_edit()){
			$data['check']=$this->input->get('check');
			$data['password']=$this->input->post('password');
			
			if($this->forget_model->edit_password($data) == TRUE){
				$this->session->set_flashdata('success', '密码重置成功！');
				redirect($this->config->item('catalog').'user', 'location', 301);
			}else{
				$this->session->set_flashdata('fali', '密码重置失败,链接已经失效，请重新申请！');
				redirect($this->config->item('catalog').'user/forget', 'location', 301);
			}
			
		}
		
		$data['action']=$this->config->item('catalog').'user/forget/edit?check='.$this->input->get('check');
		
		$data['position_top']=$this->position_top->index();
		$data['position_left']=$this->position_left->index();
		$data['position_right']=$this->position_right->index();
		$data['position_bottom']=$this->position_bottom->index();
		
		$data['header']=$this->header->index();
		$data['login_top']=$this->header->step_top();
		$data['login_footer']=$this->footer->index();
		$this->load->view('theme/default/template/user/forget_edit',$data);
	}
	
	public function valid_index()
	{
		if($this->forget_model->check_times($this->input->post('email')) == FALSE){
			$this->error['error_times']='你提交的次数太多了，请过一天再试！';
		}
		
		return !$this->error;
	}
	
	public function vali_edit()
	{
		if($this->forget_model->check_code($this->input->get('check') == FALSE)){
			$this->error['error_check']='邮件超时或重复改密操作！';
		}
		
		return !$this->error;
	}
}
