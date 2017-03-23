<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->helper(array('utf8', 'date'));
		$this->load->language('wecome');
		$this->load->model(array('common/user_model'));
	}

	public function index()
	{
		if($this->input->get('user_id') == NULL){
			$this->document->setTitle(lang_line('no_product'));
			$this->header->no_find();
			exit;
		}
		
		$this->load->model('bbs/bbs_model');
		
		$user_info=$this->bbs_model->get_bbs_user($this->input->get('user_id'));
		
		if(!$user_info){
			$this->document->setTitle(lang_line('no_product'));
			$this->header->no_find();
			exit;
		}
		
		$data['user']=$user_info;
		
		$this->document->setTitle($user_info['nickname'].'的个人主页');
		
		$this->document->setCopyright(unserialize($this->config->get_config('site_abbreviation'))[$_SESSION['language_id']]);
		
		$data['position_top']=$this->position_top->index();
		$data['position_left']=$this->position_left->index();
		$data['position_right']=$this->position_right->index();
		$data['position_bottom']=$this->position_bottom->index();
		
		$data['header']=$this->header->index();
		$data['top']=$this->header->top();
		$data['footer']=$this->footer->index();
		$this->load->view('theme/default/template/community/user',$data);
	}
	
	//个人帖子
	public function user_posting(){
		//他的帖子
		if($this->input->get('p_page') != NULL){
			$p_page=$this->input->get('p_page');
		}else{
			$p_page='0';
		}
		
		$postings=$this->bbs_model->get_posting_for_user_id($this->input->get('user_id'), $p_page);
		
		$data['postings']=$postings['postings'];
		
		$config['base_url'] 			= $this->config->item('bbs').'community/user/user_posting?user_id='.$this->input->get('user_id');
		$config['num_links'] 			= 2;
		$config['page_query_string'] 	= TRUE;
		$config['query_string_segment'] = 'p_page';
		$config['full_tag_open'] 		= '<div class="text-left" style="float: left;line-hight: 34px;padding: 6px 12px">回复共'.@(floor($postings['count'] / $this->config->get_config ( 'config_limit_admin' )) + 1) .'页/第'.@(floor($p_page / $this->config->get_config ( 'config_limit_admin' )) + 1) .'页</div><nav class="text-right"><ul class="pagination ajax-posting" style="margin: 0 0 10px 0">';
		$config['full_tag_close'] 		= '</ul></nav>';
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
		$config['total_rows'] 			= $postings['count'];
		$config['per_page'] 			= $this->config->get_config('config_limit_admin');
		
		$this->pagination->initialize($config);
		
		$data['pagination'] = $this->pagination->create_links();
		
		$html = $this->load->view('theme/default/template/community/user_posting', $data, true);
		echo $html;
	}
	
	//关注的帖子
	public function user_attention(){
		//他的帖子
		if($this->input->get('a_page') != NULL){
			$a_page=$this->input->get('a_page');
		}else{
			$a_page='0';
		}
		
		$postings=$this->bbs_model->get_posting_for_attention($this->input->get('user_id'), $a_page);
		
		$data['postings']=$postings['postings'];
	
		$config['base_url'] 			= $this->config->item('bbs').'community/user/user_attention?user_id='.$this->input->get('user_id');
		$config['num_links'] 			= 2;
		$config['page_query_string'] 	= TRUE;
		$config['query_string_segment'] = 'a_page';
		$config['full_tag_open'] 		= '<div class="text-left" style="float: left;line-hight: 34px;padding: 6px 12px">回复共'.@(floor($postings['count'] / $this->config->get_config ( 'config_limit_admin' )) + 1) .'页/第'.@(floor($a_page / $this->config->get_config ( 'config_limit_admin' )) + 1) .'页</div><nav class="text-right"><ul class="pagination ajax-attention" style="margin: 0 0 10px 0">';
		$config['full_tag_close'] 		= '</ul></nav>';
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
		$config['total_rows'] 			= $postings['count'];
		$config['per_page'] 			= $this->config->get_config('config_limit_admin');
		
		$this->pagination->initialize($config);
		
		$data['pagination'] = $this->pagination->create_links();
		
		$html = $this->load->view('theme/default/template/community/user_attention', $data, true);
		echo $html;
	}
	
	//关注user
	public function add_attention(){
		if($this->input->post('to_user_id') != null){
			$this->load->model('common/bs_model');
			$result = $this->bbs_model->add_user_attention($this->input->post('to_user_id'));
		}else{
			$result = false;
		}
	
		if($result){
			$json['status']='success';
			$json['msg']='关注成功！';
		}else{
			$json['status']='fail';
			$json['msg']='重复关注不成功！';
		}
	
		$this->output
		->set_content_type('application/json')
		->set_output(json_encode($json));
	}
	
	//取消关注user
	public function unattention(){
		if($this->input->post('to_user_id') != null){
			$this->load->model('bbs/bbs_model');
			$result=$this->bbs_model->unattention_user($this->input->post('to_user_id'));
		}else{
			$result = false;
		}
	
		if($result){
			$json['status']='success';
			$json['msg']='取消关注成功！';
		}else{
			$json['status']='fail';
			$json['msg']='取消关注不成功！';
		}
	
		$this->output
		->set_content_type('application/json')
		->set_output(json_encode($json));
	}
	
	//关注的成员
	public function users_to(){
		//他的帖子
		if($this->input->get('u_page') != NULL){
			$u_page=$this->input->get('u_page');
		}else{
			$u_page='0';
		}
	
		$users=$this->bbs_model->get_users($this->input->get('user_id'), $u_page, true);
	
		$data['users']=$users['users'];
		$data['count']=$users['count'];
		
		$config['base_url'] 			= $this->config->item('bbs').'community/user/users_to?user_id='.$this->input->get('user_id');
		$config['num_links'] 			= 2;
		$config['page_query_string'] 	= TRUE;
		$config['query_string_segment'] = 'u_page';
		$config['full_tag_open'] 		= '<div class="text-left" style="float: left;line-hight: 34px;padding: 6px 12px">回复共'.@(floor($postings['count'] / $this->config->get_config ( 'config_limit_admin' )) + 1) .'页/第'.@(floor($u_page / $this->config->get_config ( 'config_limit_admin' )) + 1) .'页</div><nav class="text-right"><ul class="pagination ajax-users" style="margin: 0 0 10px 0">';
		$config['full_tag_close'] 		= '</ul></nav>';
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
		$config['total_rows'] 			= $users['count'];
		$config['per_page'] 			= 6;
	
		$this->pagination->initialize($config);
	
		$data['pagination'] = $this->pagination->create_links();
	
		$html = $this->load->view('theme/default/template/community/users_to', $data, true);
		echo $html;
	}
	
	//关注的成员
	public function users_for(){
		//他的帖子
		if($this->input->get('u_page') != NULL){
			$u_page=$this->input->get('u_page');
		}else{
			$u_page='0';
		}
	
		$users=$this->bbs_model->get_users($this->input->get('user_id'), $u_page, false);
	
		$data['users']=$users['users'];
		$data['count']=$users['count'];
	
		$config['base_url'] 			= $this->config->item('bbs').'community/user/users_for?user_id='.$this->input->get('user_id');
		$config['num_links'] 			= 2;
		$config['page_query_string'] 	= TRUE;
		$config['query_string_segment'] = 'u_page';
		$config['full_tag_open'] 		= '<div class="text-left" style="float: left;line-hight: 34px;padding: 6px 12px">回复共'.@(floor($postings['count'] / $this->config->get_config ( 'config_limit_admin' )) + 1) .'页/第'.@(floor($u_page / $this->config->get_config ( 'config_limit_admin' )) + 1) .'页</div><nav class="text-right"><ul class="pagination ajax-users" style="margin: 0 0 10px 0">';
		$config['full_tag_close'] 		= '</ul></nav>';
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
		$config['total_rows'] 			= $users['count'];
		$config['per_page'] 			= 6;
	
		$this->pagination->initialize($config);
	
		$data['pagination'] = $this->pagination->create_links();
	
		$html = $this->load->view('theme/default/template/community/users_for', $data, true);
		echo $html;
	}
}
