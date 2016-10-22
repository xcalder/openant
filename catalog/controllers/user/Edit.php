<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Edit extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->helper(array('utf8'));
		$this->load->language('wecome');
		$this->load->model(array('common/user_model'));
	}

	public function edit_paswd()
	{
		$this->document->setTitle('修改登陆密码');
		
		if($_SERVER['REQUEST_METHOD']=="POST"){
			$user_info=$this->user_model->get_user($this->user->getId());
			if(md5($this->input->post('current_password')) == $user_info['password'] && (utf8_strlen($this->input->post('current_password')) < 18 || utf8_strlen($this->input->post('current_password')) > 6) && $this->input->post('new_password') == $this->input->post('confirm_password')){
				//当前密码正确
				$updata['password']=md5($this->input->post('new_password'));
				$updata['user_id']=$this->user->getId();
				if($this->user_model->edit_user($updata)){
					
					$this->session->set_flashdata('success', '新密码修改成功！');
					redirect(site_url('user'), 'location', 301);
				}else{
					$this->session->set_flashdata('fali', '密码修改失败！');
					redirect(site_url('user/edit/edit_paswd'), 'location', 301);
				}
				
			}else{
				$this->session->set_flashdata('fali', '密码修改失败！');
				redirect(site_url('user/edit/edit_paswd'), 'location', 301);
			}
			exit;
		}
		
		$data['position_top']=$this->position_top->index();
		$data['position_left']=$this->position_left->index();
		$data['position_right']=$this->position_right->index();
		$data['position_bottom']=$this->position_bottom->index();
		
		$data['header']=$this->header->index();
		$data['top']=$this->header->user_top();
		$data['footer']=$this->footer->index();
		$this->load->view('theme/default/template/user/edit_paswd',$data);
	}
	
	public function verify_current_password(){
		$user_info=$this->user_model->get_user($this->user->getId());
		if(md5($this->input->get('current_password')) == $user_info['password']){
			echo 'true';
		}else{
			echo 'false';
		}
		exit();
	}
	
	public function edit_user_info()
	{
		$this->document->setTitle('修改个人信息');
		
		if($_SERVER['REQUEST_METHOD']=="POST"){
			$data['nickname']=$this->input->post('nickname');
			$data['firstname']=$this->input->post('firstname');
			$data['lastname']=$this->input->post('lastname');
			$data['gender']=$this->input->post('gender');
			$data['telephone']=$this->input->post('telephone');
			$data['email']=$this->input->post('email');
			$data['description']=$this->input->post('description');
			$data['user_id']=$this->user->getId();
			
			if($this->user_model->edit_user($data)){
					
				$this->session->set_flashdata('success', '个人资料修改成功！');
				redirect(site_url('user'), 'location', 301);
			}else{
				$this->session->set_flashdata('fali', '个人资料修改失败！');
				redirect(site_url('user/edit/edit_user_info'), 'location', 301);
			}
			exit;
		}
		
		$data=array();
		$data['user_info']=$this->user_model->get_user_info($_SESSION['user_id']);
		
		$data['position_top']=$this->position_top->index();
		$data['position_left']=$this->position_left->index();
		$data['position_right']=$this->position_right->index();
		$data['position_bottom']=$this->position_bottom->index();
		
		$data['header']=$this->header->index();
		$data['top']=$this->header->user_top();
		$data['footer']=$this->footer->index();
		$this->load->view('theme/default/template/user/edit_user_info',$data);
	}
	
	public function sender_email_check(){
		$this->load->model(array('common/forget_model'));
		$this->load->helper(array('string'));
		
		if($this->forget_model->check_times($this->input->post('email'))){
			$check										=random_string('sha1');
			$data['to']									=$this->input->post('email');
			$data['name']								=unserialize($this->config->get_config('site_abbreviation'))[$_SESSION['language_id']].'帐号中心';
			$data['subject']							='邮箱验证：你收到这封邮件是因为你在'.unserialize($this->config->get_config('site_abbreviation'))[$_SESSION['language_id']].'申请了邮箱验证相关服务,如果不是你的操作，请忽略此邮件！';
			$massage									='<h3>验证你在'.unserialize($this->config->get_config('site_abbreviation'))[$_SESSION['language_id']].'使用的邮箱<h3>';
			$massage									.='<h5><br/>这是一封系统邮件，请不要直接回复<br/><h5>';
			$massage									.='<p>本次验证申请24小时内有效，如果超时请重新申请！<br/><h4>验证码<h4><br/>'.substr($check,9,6);
			$data['message']							=$massage;
			$this->load->common('sender_email');
			if($this->sender_email->sender($data)){
				$data=array();
				$data['email']								=$this->input->post('email');
				$data['date_added']							=date("Y-m-d H:i:s");
				$data['check']								=substr($check,9,6);
				$data['class']								='check_email';
				
				$this->forget_model->add($data);
				
				$data=array();
				$data['status']='1';
				$data['message']='邮件发送成功，请登陆邮箱查看验证码！';
			}else{
				$data=array();
				$data['status']='0';
				$data['message']='邮件发送失败请重试！';
			}
		}else{
			$data['status']='0';
			$data['message']='同一个邮箱24小时内只允许发送三次';
		}
		
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($data));
	}
	
	public function verify_email_captcha(){
		$this->load->model(array('common/forget_model'));
		if($this->forget_model->check_code($this->input->get('email_captcha'))){
			echo 'true';
		}else{
			echo 'false';
		}
		exit();
	}
	
	public function edit_pay_password()
	{
		$this->document->setTitle('修改支付密码');
		
		if($_SERVER['REQUEST_METHOD']=="POST"){
			$user_info=$this->user_model->get_user_info($this->user->getId());
			if($this->input->post('current_password') == NULL || md5($this->input->post('current_password')) != $user_info['password']){
				$this->session->set_flashdata('fali', '信息验证失败，不能修改密码！');
				redirect(site_url('user/edit/edit_pay_password'), 'location', 301);
				exit;
			}
			
			if($this->input->post('new_password') == NULL || $this->input->post('new_password') != $this->input->post('confirm_password')){
				$this->session->set_flashdata('fali', '新密码为空或两次输入密码不一致，不能修改密码！');
				redirect(site_url('user/edit/edit_pay_password'), 'location', 301);
				exit;
			}
			
			$this->load->model('order/user_balances_model');
			$update['user_id']=$this->user->getId();
			$update['pay_password']=md5($this->input->post('new_password'));
			if($this->user_balances_model->edit_pay_password($update)){
				$this->session->set_flashdata('success', '支付密码修改成功！');
				redirect(site_url('user'), 'location', 301);
			}else{
				$this->session->set_flashdata('fali', '支付密码修改失败！');
				redirect(site_url('user/edit/edit_pay_password'), 'location', 301);
			}
		}
		
		$data['position_top']=$this->position_top->index();
		$data['position_left']=$this->position_left->index();
		$data['position_right']=$this->position_right->index();
		$data['position_bottom']=$this->position_bottom->index();
		
		$data['header']=$this->header->index();
		$data['top']=$this->header->user_top();
		$data['footer']=$this->footer->index();
		$this->load->view('theme/default/template/user/edit_pay_password',$data);
	}
	
	public function edit_avatar()
	{
		$this->document->setTitle('修改头像');
		
		$this->document->addStyle('public/min?f='.(SUBPATH == '/' ? '' : SUBPATH).'public/head_portrait_update/css/style.css');
		$this->document->addScript('public/min?f='.(SUBPATH == '/' ? '' : SUBPATH).'public/head_portrait_update/js/cropbox.js');
		
		$user=$this->user_model->get_user($_SESSION['user_id']);
		
		if(!empty($user['image'])){
			$data['image']=$this->image_common->resize($user['image'], 400 , 400);
		}else{
			$data['image']='public/resources/default/image/logo.jpg';
		}
		
		//$data['user']=$user;
		//var_dump($user);
		
		$data['position_top']=$this->position_top->index();
		$data['position_left']=$this->position_left->index();
		$data['position_right']=$this->position_right->index();
		$data['position_bottom']=$this->position_bottom->index();
		
		$data['header']=$this->header->index();
		$data['top']=$this->header->user_top();
		$data['footer']=$this->footer->index();
		$this->load->view('theme/default/template/user/edit_avatar',$data);
	}
	
	public function upload_avatar(){
		if($this->input->post('img') != NULL){
			$img=$_POST['img'];
		}else{
			$json['status']='1';
			$json['message']='头像为空，请检查！';
		}
		
		if(!isset($json)){
			$this->load->helper('string');
			$user_added_date=$this->user->getDate_added();
			$user_directory=date("Y",strtotime($user_added_date)).'/'.date("m",strtotime($user_added_date)).'/'.date("d",strtotime($user_added_date)).'/'.$this->user->getId();
			
			if (!is_dir(FCPATH . 'image/users/'.$user_directory)) {
				@mkdir(FCPATH . 'image/users/'.$user_directory, 0777,true);
			}
			
			if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $img, $result)){
				$type = $result[2];
				$path='/users/'.$user_directory.'/'.random_string('alnum', 16).'.'.$type;
				$new_file = FCPATH . 'image'.$path;
				if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $img)))){
					$json['status']='0';
					$json['message'] = '头像修改成功！';
					$this->session->set_flashdata('success', '头像修改成功！');
					
					$user=$this->user_model->get_user($_SESSION['user_id']);
					if(!empty($user['image'])){
						@unlink(FCPATH . 'image'.$user['image']);
					}
					
					$up_data['user_id']=$this->user->getId();
					$up_data['image']=$path;
					$this->user_model->edit_user($up_data);
				}else{
					$json['status']='1';
					$json['message'] = '头像上传失败，请重新上传！';
					$this->session->set_flashdata('fali', '头像修改失败！');
				}

			}else{
				$json['status']='1';
				$json['message'] = '头像上传失败，请重新上传！';
				$this->session->set_flashdata('fali', '头像修改失败！');
			}
		}
		
		//$json['message'] = $_POST['img'];
		
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($json));
	}
	
	public function edit_message_notification()
	{
		$this->document->setTitle('消息提醒设置');
		
		$user=$this->user_model->get_user($_SESSION['user_id']);
		
		if(!empty($user['image'])){
			$user['image']=$this->image_common->resize($user['image'], 50 , 50);
		}else{
			$user['image']='public/resources/default/image/logo.jpg';
		}
		
		$data['user']=$user;
		//var_dump($user);
		
		$data['position_top']=$this->position_top->index();
		$data['position_left']=$this->position_left->index();
		$data['position_right']=$this->position_right->index();
		$data['position_bottom']=$this->position_bottom->index();
		
		$data['header']=$this->header->index();
		$data['top']=$this->header->user_top();
		$data['footer']=$this->footer->index();
		$this->load->view('theme/default/template/user/edit_message_notification',$data);
	}
	
	public function edit_account_binding()
	{
		$this->document->setTitle('第三方登陆帐号绑定');
		
		$user=$this->user_model->get_user($_SESSION['user_id']);
		
		if(!empty($user['image'])){
			$user['image']=$this->image_common->resize($user['image'], 50 , 50);
		}else{
			$user['image']='public/resources/default/image/logo.jpg';
		}
		
		$data['user']=$user;
		//var_dump($user);
		
		$data['position_top']=$this->position_top->index();
		$data['position_left']=$this->position_left->index();
		$data['position_right']=$this->position_right->index();
		$data['position_bottom']=$this->position_bottom->index();
		
		$data['header']=$this->header->index();
		$data['top']=$this->header->user_top();
		$data['footer']=$this->footer->index();
		$this->load->view('theme/default/template/user/edit_account_binding',$data);
	}
}
