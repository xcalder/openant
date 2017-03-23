<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Posting extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->helper(array('date', 'utf8', 'string'));
	}

	public function index()
	{
		if($this->input->get('posting_id') == NULL){
			$this->document->setTitle(lang_line('no_product'));
			$this->header->no_find();
		}
		
		$this->load->model('bbs/bbs_model');
		
		if($_SERVER['REQUEST_METHOD']=="POST" && $this->user->isLogged()){
			if($this->input->post('content') != NULL && utf8_strlen($this->input->post('content')) < 2000){
				if($this->input->post('replies_id') == 0){
					$data['base']['posting_id']=$this->input->get('posting_id');
					$data['base']['user_id']=$this->user->getID();
					$data['base']['is_view']='1';
					$data['base']['date_added']=date("Y-m-d H:i:s");
					$data['description']['language_id']=$_SESSION['language_id'];
					$data['description']['content']=$this->input->post('content');
					$this->bbs_model->replies($data);
					$this->session->set_flashdata('success', '评论发表成功！');
				}else{
					$data['base']['posting_id']=$this->input->get('posting_id');
					$data['base']['user_id']=$this->user->getID();
					$data['base']['replies_id']=$this->input->post('replies_id');
					$data['base']['is_view']='1';
					$data['base']['date_added']=date("Y-m-d H:i:s");
					$data['description']['language_id']=$_SESSION['language_id'];
					$data['description']['content']=$this->input->post('content');
					$this->bbs_model->discuss($data);
					$this->session->set_flashdata('success', '评论发表成功！');
				}
				redirect(all_current_url());
			}else{
				$this->session->set_flashdata('fali', '评论发表失败！');
			}
		}
		
		$data=array();
		
		if($this->input->get('page') != NULL){
			$page=$this->input->get('page');
		}else{
			$page='0';
		}
		
		$posting_info=$this->bbs_model->get_posting_content($this->input->get('posting_id'), $page);
		
		
		if(!$posting_info){
			$this->document->setTitle(lang_line('no_product'));
			$this->header->no_find();
			exit;
		}
		$data['posting']=$posting_info;
		
		//相关帖子
		$about['page'] = 0;
		$about['limit'] = 10;
		$about['search'] = $posting_info['title'];
		$data['about_postings'] = $this->bbs_model->get_postings($about)['postings'];
		
		$this->lang->load('wecome', $_SESSION['language_name']);
		
		$this->document->setTitle($posting_info['title']);
		
		//提取关键词key
		$this->load->library('phpanalysis');
		$this->phpanalysis->SetSource (unserialize($this->config->get_config('site_name'))[$_SESSION['language_id']].$posting_info['title'].$posting_info['title'].utf8_substr(DeleteHtml($posting_info['description']), 0, 200));
		$this->phpanalysis->StartAnalysis ( true );
			
		$tags = $this->phpanalysis->GetFinallyKeywords ( 20 ); // 获取文章中的五个关键字
		
		$this->document->setKeywords($tags);
		//提取关键词key
		
		$this->document->setDescription(utf8_substr(DeleteHtml($posting_info['description']), 0, 200));
		
		$this->document->setCopyright(lang_line('meta_copyright'));
		
		$config['base_url'] 			= $this->config->item('bbs').'community/posting?posting_id='.$this->input->get('posting_id');
		$config['num_links'] 			= 2;
		$config['page_query_string'] 	= TRUE;
		$config['query_string_segment'] = 'page';
		$config['full_tag_open'] 		= '<div class="text-left" style="float: left;line-hight: 34px;padding: 6px 12px">回复共'.@(floor($posting_info['count'] / $this->config->get_config ( 'config_limit_admin' )) + 1) .'页/第'.@(floor($page / $this->config->get_config ( 'config_limit_admin' )) + 1) .'页</div><nav class="text-right"><ul class="pagination" style="margin: 0 0 10px 0">';
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
		$config['total_rows'] 			= $posting_info['count'];
		$config['per_page'] 			= $this->config->get_config('config_limit_admin');

		$this->pagination->initialize($config);

		$data['pagination'] = $this->pagination->create_links();
		
		$data['position_top']=$this->position_top->index();
		$data['position_left']=$this->position_left->index();
		$data['position_right']=$this->position_right->index();
		$data['position_bottom']=$this->position_bottom->index();
		
		$data['header']=$this->header->index();
		$data['top']=$this->header->top();
		$data['footer']=$this->footer->index();
		
		$this->load->view('theme/default/template/community/posting',$data);
	}
	
	//统计访问量
	public function total(){
		if($this->input->get('posting_id') != null){
			$this->load->model('common/page_access_total_model');
			$this->page_access_total_model->add('posting', $this->input->get('posting_id'));
		}
	}
	
	//关注帖子
	public function add_attention(){
		if($this->input->post('posting_id') != null){
			$this->load->model('common/bs_model');
			$result = $this->bbs_model->add_attention($this->input->post('posting_id'));
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
	
	//取消关注
	public function unattention_position(){
		if($this->input->post('posting_id') != null){
			$this->load->model('bbs/bbs_model');
			$result=$this->bbs_model->unattention_posting($this->input->post('posting_id'));
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
	
	//关注分页
	public function attention_page(){
		if($this->input->get('page') != null){
			$data['page']=$this->input->get('page');
		}else{
			$data['page']=0;
		}
		
		$data['posting_id']=$this->input->get('posting_id');
		
		$results=$this->bbs_model->get_attentions($data);
		if($results){
			$data['users']=$results['info'];
			$data['count']=$results['count'];
		}else{
			$data['users']=false;
		}
		
		$config['base_url'] 			= $this->config->item('bbs').'community/posting/attention_page?posting_id='.$this->input->get('posting_id');
		$config['num_links'] 			= 2;
		$config['page_query_string'] 	= TRUE;
		$config['query_string_segment'] = 'page';
		$config['full_tag_open'] 		= '<div class="text-left" style="float: left;line-hight: 34px;padding: 6px 12px">回复共'.@(floor($posting_info['count'] / 11) + 1) .'页/第'.@(floor($page / 11) + 1) .'页</div><nav class="text-right"><ul class="pagination posting-attention" style="margin: 0 0 10px 0">';
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
		$config['total_rows'] 			= @$results['count'];
		$config['per_page'] 			= '11';
		
		$this->pagination->initialize($config);
		
		$data['pagination'] = $this->pagination->create_links();
		
		$html = $this->load->view('theme/default/template/community/posting_attention', $data, true);
		echo $html;
	}
}
