<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_activity extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->language('wecome');
		$this->load->model(array('common/user_activity_model'));
	}

	public function index()
	{
		$this->document->setTitle('会员活动');
		
		
		$data=array();
		
		//分页
		if($this->input->get('page')){
			$data['page']				=$this->input->get('page');
		}else{
			$data['page']				='0';
		}
		
		$user_activitys					=$this->user_activity_model->get_user_activetys($data);
		
		$config['base_url'] 			= site_url('user/user_activity');
		$config['num_links'] 			= 2;
		$config['page_query_string'] 	= TRUE;
		$config['query_string_segment'] = 'page';
		$config['full_tag_open'] 		= '<div class="text-left pagination" style="float: left;padding: 6px 0px;margin: 5px 0">共'.@(floor($user_activitys['count'] / $this->config->get_config ( 'config_limit_admin' )) + 1) .'页/第'.@(floor($data['page'] / $this->config->get_config ( 'config_limit_admin' )) + 1) .'页</div><ul class="pagination" style="float: right;margin: 5px 0">';
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
		$config['total_rows'] 			= $user_activitys['count'];
		$config['per_page'] 			= $this->config->get_config('config_limit_admin');

		$this->pagination->initialize($config);

		$data['pagination'] 			= $this->pagination->create_links();
		
		
		$activitys						=array();
		
		if($user_activitys){
			foreach($user_activitys['user_activitys'] as $key=>$value){
				$comment[$key]				=json_decode($user_activitys['user_activitys'][$key]['data']);
				$activitys[$key]['user_id']	=$user_activitys['user_activitys'][$key]['user_id'];
				$activitys[$key]['key']		=$user_activitys['user_activitys'][$key]['key'];
				$activitys[$key]['ip']		=$user_activitys['user_activitys'][$key]['ip'];
				$activitys[$key]['date_added']		=$user_activitys['user_activitys'][$key]['date_added'];
				
				if(isset($user_activitys['user_activitys'][$key]['key']) && $user_activitys['user_activitys'][$key]['key'] == 'order_guest'){
					$activitys[$key]['comment']='游客'.$comment[$key]->nickname.'提交一个<a href="'.$comment[$key]->order_id.'">新订单</a>';
				}
				if(isset($user_activitys['user_activitys'][$key]['key']) && $user_activitys['user_activitys'][$key]['key'] == 'register'){
					$activitys[$key]['comment']='<a href="'. $comment[$key]->user_id .'">'.$comment[$key]->nickname.'</a>注册了一个新帐号';
				}
				if(isset($user_activitys['user_activitys'][$key]['key']) && $user_activitys['user_activitys'][$key]['key'] == 'order_account'){
					$activitys[$key]['comment']='<a href="'.$comment[$key]->user_id.'">'.$comment[$key]->nickname.'</a>提交了一个<a href="'.$comment[$key]->order_id.'">新订单</a>';
				}
			}
		}
		
		$data['user_activitys']			=$activitys;
		
		$data['header']					=$this->header->index();
		$data['top']					=$this->header->top();
		$data['footer']					=$this->footer->index();
		
		$this->load->view('theme/default/template/user/user_activity',$data);
	}
}
