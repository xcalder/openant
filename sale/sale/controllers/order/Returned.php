<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class returned extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->language('wecome');
		$this->load->model(array('order/returned_model'));
		$this->load->library('currency');
	}

	public function index(){
		$this->document->setTitle('退换货商品列表');
		
		if ($this->input->get ( 'page' ) != NULL) {
			$data ['page'] = $this->input->get ( 'page' );
		} else {
			$data ['page'] = '0';
		}
		
		if ($this->input->get ( 'status_id' ) != NULL) {
			$data ['return_status_id'] = $this->input->get ( 'status_id' );
		}
		
		$return_list=$this->returned_model->get_list($data);
		
		if ($return_list) {
			$data['returns']=$return_list['returns'];
		}else{
			$data['returns']=false;
		}
		
		// 分页
		$config ['base_url'] = site_url ('order/returned');
		$config ['num_links'] = 2;
		$config ['page_query_string'] = TRUE;
		$config ['query_string_segment'] = 'page';
		$config ['full_tag_open'] = '<div class="text-left" style="float: left;line-hight: 34px;padding: 6px 12px">共'.@(floor($return_list['count'] / $this->config->get_config ( 'config_limit_admin' )) + 1) .'页/第'.@(floor($data['page'] / $this->config->get_config ( 'config_limit_admin' )) + 1) .'页</div><nav class="text-right"><ul class="pagination" style="margin: 0 0 10px 0">';
		$config ['full_tag_close'] = '</ul>';
		$config ['first_tag_open'] = '<li>';
		$config ['first_tag_close'] = '</li>';
		$config ['last_tag_open'] = '<li>';
		$config ['last_tag_close'] = '</li>';
		$config ['next_tag_open'] = '<li>';
		$config ['next_tag_close'] = '</li>';
		$config ['prev_tag_open'] = '<li>';
		$config ['prev_tag_close'] = '</li>';
		$config ['cur_tag_open'] = '<li class="active"><a>';
		$config ['cur_tag_close'] = '</a></li>';
		$config ['num_tag_open'] = '<li>';
		$config ['num_tag_close'] = '</li>';
		$config ['first_link'] = '<<';
		$config ['last_link'] = '>>';
		$config ['total_rows'] = $return_list['count'];
		$config ['per_page'] = $this->config->get_config ( 'config_limit_admin' );
		
		$this->pagination->initialize ( $config );
		
		$data['pagination'] = $this->pagination->create_links();
		
		$data['position_top']=$this->position_top->index();
		$data['position_left']=$this->position_left->index();
		$data['position_right']=$this->position_right->index();
		$data['position_bottom']=$this->position_bottom->index();
		
		$data['return_actions']=$this->returned_model->get_return_actions_to_returned();
		$data['return_reasons']=$this->returned_model->get_return_reason_to_returned();
		
		$data['header']=$this->header->index();
		$data['top']=$this->header->top();
		$data['footer']=$this->footer->index();
		$this->load->view('theme/default/template/order/returned_list',$data);
	}
	
	public function info()
	{
		$this->document->setTitle('退换货商品');
	
		$data['return_info']=$this->returned_model->get_info($this->input->get('rowid'));
	
		if($data['return_info'] == false){
			$this->document->setTitle('找不到退款订单');
			$this->header->no_find();
		}
		
		$data['position_top']=$this->position_top->index();
		$data['position_left']=$this->position_left->index();
		$data['position_right']=$this->position_right->index();
		$data['position_bottom']=$this->position_bottom->index();
	
		$data['return_actions']=$this->returned_model->get_return_actions_to_returned();
		$data['return_reasons']=$this->returned_model->get_return_reason_to_returned();
	
		//运输方式
		$this->load->model('localisation/return_mode_model');
		$data['return_modes']=$this->return_mode_model->get_return_modes();
		
		$data['header']=$this->header->index();
		$data['top']=$this->header->top();
		$data['footer']=$this->footer->index();
		$this->load->view('theme/default/template/order/returned_info',$data);
	}
	
	public function action(){
		$rowid=$this->input->get('rowid');
		$return_id=$this->returned_model->get_return_id($rowid);
		if($return_id = $this->input->post('return_id') && $this->input->get('token') == $_SESSION['token']){
			$return['return_id']=$this->input->post('return_id');
			$return['comment']=$this->input->post('comment');
			$return['date_added']=date("Y-m-d H:i:s");
			
			if($this->input->post('action') == 'agree'){
				if($this->input->post('return_action_id') == $this->config->get_config('action_return_and_refund') || $this->input->post('return_action_id') == $this->config->get_config('action_return')){
					$return['return_status_id']=$this->config->get_config('wait_returns');
				}else{
					$return['return_status_id']=$this->config->get_config('waiting_c_payments');
				}
				$a_title='你同意了一个商品退换';
				$u_title='商家同意了你的商品退换申请';
				$a_msg='你同意了一个<a href="'.$this->config->item('sale').'order/returned/info?rowid='.$this->input->get('rowid').'">商品退换</a>';
				$u_msg='商家同意了你的<a href="'.$this->config->item('sale').'order/returned/info?rowid='.$this->input->get('rowid').'">商品退换</a>申请';
			}
			
			if($this->input->post('action') == 'refuse'){
				$return['return_status_id']=$this->config->get_config('merchant_refused');
				
				$a_title='你拒绝了一个商品退换';
				$u_title='商家拒绝了你的商品退换申请';
				$a_msg='你拒绝了一个<a href="'.$this->config->item('sale').'order/returned/info?rowid='.$this->input->get('rowid').'">商品退换</a>';
				$u_msg='商家拒绝了你的<a href="'.$this->config->item('sale').'order/returned/info?rowid='.$this->input->get('rowid').'">商品退换</a>申请';
			}
			
			
			$return_history_id=$this->returned_model->add_history($return);
			
			//更新return表
			$re['return_id']=$this->input->post('return_id');
			$re['return_status_id']=$return['return_status_id'];
			$this->returned_model->updata_return($re);
			
			//添加动态
			$this->load->model('common/user_activity_model');
			$this->user_activity_model->add_activity($_SESSION['user_id'], 'return', array('title'=>$a_title, 'msg'=>$a_msg));
			
			$this->user_activity_model->add_activity($this->input->post('user_id'), 'return', array('title'=>$u_title, 'msg'=>$u_msg));
		
			redirect($this->config->item('sale').'order/returned');
		}
	}
	
	public function mode(){
		$rowid=$this->input->get('rowid');
		$return_id=$this->returned_model->get_return_id($rowid);
		if($return_id = $this->input->post('return_id') && $this->input->get('token') == $_SESSION['token']){
			$return['return_id']=$this->input->post('return_id');
			$return['comment']=$this->input->post('comment');
			$return['date_added']=date("Y-m-d H:i:s");
			$return['return_status_id']=$this->config->get_config('waiting_c_payments');
				
			$return_history_id=$this->returned_model->add_history($return);
				
			//更新return表
			$re['return_id']=$this->input->post('return_id');
			$re['return_mode_id']=$this->input->post('return_mode_id');
			$re['return_status_id']=$return['return_status_id'];
			$this->returned_model->updata_return($re);
				
			//添加动态
			$this->load->model('common/user_activity_model');
			$this->user_activity_model->add_activity($_SESSION['user_id'], 'return', array('title'=>'商家已经给你退款，请确认', 'msg'=>'商家已经给你<a href="'.$this->config->item('sale').'user/returned/info?rowid='.$this->input->get('rowid')).'">退款，请确认</a>');
				
			$this->user_activity_model->add_activity($this->input->post('user_id'), 'return', array('title'=>$this->user->getnickname().'商家已经给你退款，请确认', 'msg'=>$this->user->getnickname().'商家已经给你<a href="'.$this->config->item('sale').'user/returned/info?rowid='.$this->input->get('rowid')).'">退款，请确认');
				
			redirect($this->config->item('sale').'order/returned');
		}
	}
}
