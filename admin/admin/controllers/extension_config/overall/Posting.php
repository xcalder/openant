<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Posting extends MY_Controller{
	private $error = array();
	
	public function __construct(){
		parent::__construct();
		$this->load->language('extension_config/overall/posting_module');
		$this->load->model(array('bbs/bbs_model', 'common/language_model'));
		
		if(!$this->user->hasPermission('access', 'admin/extension_config/overall/posting')){
			$this->session->set_flashdata('fali', '你没有访问权限！');
			redirect($this->config->item('admin'));
			exit;
		}
	}

	public function index(){
		$this->document->setTitle('帖子管理');
		
		$data['delete']					=$this->config->item('admin').'/extension_config/overall/posting/delete';
		
		$postings = $this->bbs_model->get_postings($this->input->get('page'));
		$data['postings']=$postings['postings'];
		//分页
		$data['count'] = $postings['count'];
		
		if(!$this->input->get('page')){
			$page = '0';
		}else{
			$page = $this->input->get('page');
		}
		
		$config['base_url'] 			= $this->config->item('admin').'/extension_config/overall/posting';
		$config['num_links'] 			= 2;
		$config['page_query_string'] 	= TRUE;
		$config['query_string_segment'] = 'page';
		$config['full_tag_open'] 		= '<ul class="pagination">';
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
		$config['total_rows'] 			= $postings['count'];
		$config['per_page'] 			= $this->config->get_config('config_limit_admin');

		$this->pagination->initialize($config);

		$data['pagination'] = $this->pagination->create_links();
		
		$data['header']=$this->header->index();
		$data['top']=$this->header->top();
		$data['footer']=$this->footer->index();
		
		$this->load->view('theme/default/template/extension_config/overall/posting_list',$data);
	}
	
	//修改
	public function edit_show(){
		if (!$this->user->hasPermission('modify', 'admin/extension_config/overall/posting')) {
			$this->session->set_flashdata('danger', '你无权修改，请联系管理员！');
			redirect($this->config->item('admin').'/extension_config/overall/posting');
			exit();
		}
		
		if($this->input->get('posting_id') != NULL && ($this->input->get('is_view') == '1' || $this->input->get('is_view') == '0')){
			if($this->bbs_model->edit_show($this->input->get('posting_id'), array('is_view'=>$this->input->get('is_view')))){
				$this->session->set_flashdata('success', '帖子状态修改成功');
			}else{
				$this->session->set_flashdata('fali', '帖子状态修改失败');
			}
			
		}elseif($this->input->get('posting_id') != NULL && ($this->input->get('very_good') == '1' || $this->input->get('very_good') == '0')){
			if($this->bbs_model->edit_show($this->input->get('posting_id'), array('very_good'=>$this->input->get('very_good')))){
				$this->session->set_flashdata('success', '帖子加精成功');
			}else{
				$this->session->set_flashdata('fali', '帖子加精失败');
			}
			
		}elseif($this->input->get('posting_id') != NULL && ($this->input->get('is_top') == '1' || $this->input->get('is_top') == '0')){
			if($this->bbs_model->edit_show($this->input->get('posting_id'), array('is_top'=>$this->input->get('is_top')))){
				$this->session->set_flashdata('success', '帖子加精成功');
			}else{
				$this->session->set_flashdata('fali', '帖子加精失败');
			}
			
		}else{
			$this->session->set_flashdata('fali', '帖子修改失败');
		}
		
		redirect($this->config->item('admin').'/extension_config/overall/posting');
	}
	
	//删除
	public function delete(){
		if (!$this->user->hasPermission('modify', 'admin/extension_config/overall/posting')) {
			$this->session->set_flashdata('danger', '你无权修改，请联系管理员！');
			redirect($this->config->item('admin').'/extension_config/overall/posting');
			exit();
		}
		
		$this->bbs_model->delete_posting($this->input->post('selected'));
		redirect($this->config->item('admin').'/extension_config/overall/posting');
	}

}
