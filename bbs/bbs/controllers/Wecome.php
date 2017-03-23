<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wecome extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->helper(array('date'));
	}

	public function index()
	{
		//活跃用户
		$this->document->addScript(base_url('resources/public/resources/default/js/easing/jquery.easing.1.3.js'));
		
		$this->load->model(array('bbs/bbs_model', 'common/user_model'));
		
		$users=$this->bbs_model->get_activity_user();
		$data['users']=$this->user_model->get_user_towecome($users);
		
		$title_ ='';
		
		//分页
		if($this->input->get('page') == NULL){
			$data['page'] = '0';
		}else{
			$data['page'] = $this->input->get('page');
		}
		
		$data['order_by']=$this->input->get('order_by');
		if($this->input->get('order_by') != NULL){
			$url['order_by']=$this->input->get('order_by');
			
			if($this->input->get('order_by') == 'time'){
				$title_ .= '活跃';
			}
			if($this->input->get('order_by') == 'good'){
				$title_ .= '精华';
			}
			if($this->input->get('order_by') == 'last'){
				$title_ .= '最近';
			}
			if($this->input->get('order_by') == 'no_reply'){
				$title_ .= '0回复';
			}
		}
		
		if($this->input->get('search') != NULL){
			$search = $this->input->get('search');
			$search = str_replace('？', '', $search);
			$search=str_replace('?', '', $search);
			$search=utf8_substr($search, 0, 30);
			
			$this->load->helper('text');
			$this->load->model('common/search_model');
			
			$data['search']=$search;
			$url['search']=$search;
			
			$data['search_key_words']=$this->search_model->get_top();
			$data['search_abouts']=$this->search_model->get_about($search);
			$data['label']=array('primary', 'success', 'info', 'warning', 'danger');
		}
		
		$data['plate_id']=$this->input->get('plate_id');
		if($this->input->get('plate_id') != NULL){
			$url['plate_id']=$this->input->get('plate_id');
		}
		
		$postings=$this->bbs_model->get_postings($data);
		
		if(isset($url) && !empty($url)){
			$url='?'.http_build_query($url);
		}else{
			$url='';
		}
		
		$data['postings']=$postings['postings'];
		
		
		$config['base_url'] 			= $this->config->item('bbs').$url;
		$config['num_links'] 			= 2;
		$config['page_query_string'] 	= TRUE;
		$config['query_string_segment'] = 'page';
		$config['full_tag_open'] 		= '<div class="text-left" style="float: left;line-hight: 34px;padding: 6px 12px">共'.@(floor($postings['count'] / $this->config->get_config ( 'config_limit_admin' )) + 1) .'页/第'.@(floor($data['page'] / $this->config->get_config ( 'config_limit_admin' )) + 1) .'页</div><nav class="text-right"><ul class="pagination" style="margin: 0 0 10px 0">';
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
		
		if($this->input->get('plate_id') != NULL){
			$plate=$this->bbs_model->get_plate($this->input->get('plate_id'));
		}
		
		$data['plate_description']=isset($plate['description']) ? $plate['description'] : false;
		
		$title='';
		if($postings['postings']){
			$titles=array_flip(array_flip(array_column($postings['postings'],'title')));
			$title .= implode(',', $titles);
		}
		
		if(isset($plate) && $plate){
			$this->document->setTitle($plate['title'].'-'.$title_);
		
			$title .= $plate['description'];
		}else{
			$this->document->setTitle(unserialize($this->config->get_config('bbs_meta_title'))[$_SESSION['language_id']]);
			
			$title .= unserialize($this->config->get_config('bbs_meta_keyword'))[$_SESSION['language_id']];
		}
		
		//提取关键词key
		$this->load->library('phpanalysis');
		$this->load->helper('string');
		$this->phpanalysis->SetSource (utf8_substr(DeleteHtml($title), 0, 800));
		$this->phpanalysis->StartAnalysis ( true );
			
		$tags = $this->phpanalysis->GetFinallyKeywords ( 20 ); // 获取文章中的五个关键字
		
		$this->document->setKeywords($tags);
		//提取关键词key
		
		$this->document->setDescription(utf8_substr(DeleteHtml($title), 0, 200));
		
		$this->document->setCopyright(unserialize($this->config->get_config('site_abbreviation'))[$_SESSION['language_id']]);
		
		$data['position_top']=$this->position_top->index();
		$data['position_left']=$this->position_left->index();
		$data['position_right']=$this->position_right->index();
		$data['position_bottom']=$this->position_bottom->index();
		
		$data['header']=$this->header->index();
		$data['top']=$this->header->top();
		$data['footer']=$this->footer->index();
		
		$this->load->view('theme/default/template/wecome',$data);
	}
	
	public function give_points(){
		if($this->user->isLogged()){
			$this->load->model('user/user_reward_model');
			if(!$this->user_reward_model->check_event('bbs_login', date("Y-m-d 00:00:00"), date("Y-m-d 23:59:59"), $_SESSION['user_id']) > 0){
				$data['description'] = '每日登陆论坛送积分！';
				$data['user_id'] = $_SESSION['user_id'];
				$data['points'] = (int)$this->config->get_config('bbs_login_points');
				$data['event'] = 'bbs_login';
		
				if($this->user_reward_model->add_reward($data)){
					$json['status']='success';
					$json['msg']='每日首次登陆论坛积分 +'.$this->config->get_config('bbs_login_points');
				}else{
					$json['status']='fail';
					//$json['msg']='取消关注成功！';
				}
			}else{
				$json['status']='fail';
				//$json['msg']='取消关注成功！';
			}
		}else{
			$json['status']='fail';
			//$json['msg']='取消关注成功！';
		}
		
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($json));
	}
	
	//添加搜索词
	public function add_search_keyword(){
		$search=$this->input->get('search');
		if(preg_match('/^[\x{4e00}-\x{9fa5}\w-]+$/u', $search) && mb_strlen($search,'UTF8') > 3 && mb_strlen($search,'UTF8') <= 30){
			$this->load->model('common/search_model');
			$this->search_model->add($search);
		}
	}
}
