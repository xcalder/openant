<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Signin extends CI_Controller {
	private $error = array();
	
	public function __construct() {
		parent::__construct();
		$this->load->helper(array('utf8'));
		$this->load->library('form_validation');
		$this->load->model(array('common/user_model', 'common/user_activity_model'));
		$this->lang->load('user/signin', $_SESSION['language_name']);
		$this->lang->load('common/header', $_SESSION['language_name']);
	}

	public function login()
	{
		//用户帐号正常登陆
		$load=FALSE;
		if($this->config->get_config('login_window') == '0' || $this->agent->is_mobile() || $this->input->post('is_view') != '1'){
			$this->document->setTitle(lang_line('title'));
			
			if($this->input->get('url') != NULL){
				$url=rawurldecode($this->input->get('url'));
			}else{
				$url=base_url();
			}
			
			$data['position_top']=$this->position_top->index();
			$data['position_left']=$this->position_left->index();
			$data['position_right']=$this->position_right->index();
			$data['position_bottom']=$this->position_bottom->index();
			
			$data['header']=$this->header->index();
			$data['login_top']=$this->header->login_top();
			$data['login_footer']=$this->footer->index();
			
			$load=TRUE;
		}
		
		if($this->user->isLogged()){
			if($load){
				redirect($url);
			}else{
				$this->output
				    ->set_content_type('application/json')
				    ->set_output(json_encode(array('status' => '1' ,'msg' => lang_line('success_login'))));
			}
			return;
		}
		
		//验证提交
        if($this->valid_login() && $_SERVER['REQUEST_METHOD']=="POST"){
			if($this->user->login($this->input->post('email'),$this->input->post('password'))){
				$this->session->set_flashdata('success', lang_line('success_login'));
				//写入动态活动表
				$this->user_activity_model->add_activity($_SESSION['user_id'], 'login', array('title'=>lang_line('success_login'), 'msg'=>''));
				
				if($load == TRUE){
					redirect($url);
				}else{
					
					$this->output
					    ->set_content_type('application/json')
					    ->set_output(json_encode(array('status' => '1' ,'msg' => lang_line('success_login'))));
				}
			}else{
				if($this->user_model->check_login_times($this->input->ip_address(), $this->input->post('email')) == FALSE){
					if($load == TRUE){
						$this->session->set_flashdata('fali', lang_line('error_times'));
						redirect(all_current_url());
					}else{
						$this->output
						    ->set_content_type('application/json')
						    ->set_output(json_encode(array('status' => '0' ,'msg' => lang_line('error_times'))));
					}
				}else{
					if($load == TRUE){
						$this->session->set_flashdata('fali', lang_line('error_or'));
						redirect(all_current_url());
					}else{
						$this->output
						    ->set_content_type('application/json')
						    ->set_output(json_encode(array('status' => '0' ,'msg' => lang_line('error_or'))));
					}
				}
			}
		}else{
			if($this->user_model->check_login_times($this->input->ip_address(), $this->input->post('email')) == FALSE){
				if($load == TRUE){
					$this->session->set_flashdata('fali', lang_line('error_times'));
					//redirect(all_current_url());
				}else{
					$this->output
				    ->set_content_type('application/json')
				    ->set_output(json_encode(array('status' => '0' ,'msg' => lang_line('error_times'))));
				}
			}else{
				if($load == TRUE){
					$this->session->set_flashdata('fali', lang_line('error_or'));
					//redirect(all_current_url());
				}else{
					$this->output
				    ->set_content_type('application/json')
				    ->set_output(json_encode(array('status' => '0' ,'msg' => lang_line('error_or'))));
				}
			}
		}
		
		if($load == TRUE){
			$this->load->view('theme/default/template/user/signin',$data);
		}
	}
	
	public function logout ()
	{
		//$this->output->set_status_header(302);
		$this->user->logout();
		$this->session->set_flashdata('success', lang_line('success_loginout'));
	}
	
	public function signinup()
	{
		$load=FALSE;
		if($this->config->get_config('login_window') == '0' || $this->agent->is_mobile() || $this->input->post('is_view') != '1'){
			$this->document->setTitle(lang_line('titles'));
			
			if($this->input->get('url') != NULL){
				$url=rawurldecode($this->input->get('url'));
			}else{
				$url=base_url();
			}
			
			$data['position_top']=$this->position_top->index();
			$data['position_left']=$this->position_left->index();
			$data['position_right']=$this->position_right->index();
			$data['position_bottom']=$this->position_bottom->index();
			
			$data['header']=$this->header->index();
			$data['login_top']=$this->header->login_top();
			$data['login_footer']=$this->footer->index();
			
			$load=TRUE;
		}
		
		if($this->user->isLogged()){
			if($load){
				redirect($url);
			}else{
				$this->output
				    ->set_content_type('application/json')
				    ->set_output(json_encode(array('status' => '1' ,'msg' => lang_line('success_login'))));
			}
			return;
		}
		
		if($_SERVER['REQUEST_METHOD']=="POST"){
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
	        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|max_length[18]');
	        $this->form_validation->set_rules('nickname', 'nickname', 'required|min_length[3]|max_length[18]');
	        
	        if($this->form_validation->run() && preg_match("/^[\x{4e00}-\x{9fa5}A-Za-z0-9_]+$/u", $this->input->post('nickname')) && $this->input->post('agree') == '1' && $this->check_email($this->input->post('email'))){
	        	
	        	//
	        	$data['email']=$this->input->post('email');
	        	$data['nickname']=$this->input->post('nickname');
	        	$data['password']=$this->input->post('password');
	        	$data['user_class_id']=$this->config->get_config('default_user_class');
	        	
	        	$this->user_model->add_user($data);
	        	
	        	$user_id = $this->user_model->get_user_for_email($this->input->post('email'));
	        	if($user_id !== FALSE){
					$_SESSION['user_id']=$user_id['user_id'];
				}
				
				if($load == true){
					$this->session->set_flashdata('success', sprintf(lang_line('success_register'), $data['nickname']));
					redirect($url);
				}else{
					$this->output
					    ->set_content_type('application/json')
					    ->set_output(json_encode(array('status' => '1')));
				}
			}
		}
		
		if($load == TRUE){
			$this->load->view('theme/default/template/user/signup',$data);
		}
		
	}
	
	public function check_email($email)
	{
		if($this->user_model->get_user_for_email($email) == FALSE){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
	public function check_email_web()
	{
		if($this->user_model->get_user_for_email($this->input->get('email')) == FALSE){
			echo 'true';
		}else{
			echo 'false';
		}
	}
	
	public function valid_login()
	{
		
		if($this->user_model->check_login_times($this->input->ip_address(), $this->input->post('email')) == FALSE){
			$this->error['error_login']=lang_line('error_times');
		}
		
		if(!$this->form_validation->valid_email($this->input->post('email'))){
			$this->error['error_login']=lang_line('error_or');
		}
		if((utf8_strlen($this->input->post('password')) < 6) || (utf8_strlen($this->input->post('password')) > 18)){
			$this->error['error_login']=lang_line('error_or');
		}
		
		return !$this->error;
	}
}
