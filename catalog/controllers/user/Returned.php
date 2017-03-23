<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class returned extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->language('wecome');
		$this->load->model(array('order/returned_model'));
		$this->load->library('currency');
	}

	public function index()
	{
		$this->document->setTitle('退换货申请');
		
		if($this->input->get('token') != NULL && $this->input->get('token') == $_SESSION['token'] && $this->input->get('rowid') != NULL){
			if($this->returned_model->check_return($this->input->get('rowid'))){
				redirect($this->config->item('catalog').'user/returned/info?rowid='.$this->input->get('rowid'));
				exit();
			}
			$data['order_product']=$this->returned_model->get_order_product($this->input->get('rowid'));
		}else{
			$data['order_product']=FALSE;
		}
		
		if($_SERVER['REQUEST_METHOD']=="POST" && $data['order_product']){
			$order_product=$data['order_product'];
			if($order_product['total'] * $order_product['currency_value'] - ($order_product['tax'] * $order_product['quantity'] * $order_product['currency_value']) < $this->input->post('return_amount')){
				$this->session->set_flashdata('fali', '退款金额大于可退金额，请重新输入');
				redirect(all_current_url());
				exit();
			}
			
			$return=array(
					'order_id'						=>$data['order_product']['order_id'],
					'rowid'							=>$this->input->get('rowid'),
					'product_id'					=>$data['order_product']['product_id'],
					'option'						=>$data['order_product']['value'],
					'user_id'						=>$_SESSION['user_id'],
					'quantity'						=>$data['order_product']['quantity'],
					'opened'						=>$this->input->post('opened'),
					'return_reason_id'				=>$this->input->post('return_reason_id'),
					'return_action_id'				=>$this->input->post('return_action_id'),
					'return_amount'					=>$this->input->post('return_amount'),
					'return_status_id'				=>$this->config->get_config('request_refund'),
					'date_added'					=>date("Y-m-d H:i:s")
			);
			$return_id=false;
			$return_id=$this->returned_model->add($return);
			if($return_id !== false){
				$history['comment']						=$this->input->post('return_instructions');
				$history['return_id']					=$return_id;
				$history['return_status_id']			=$this->config->get_config('request_refund');
				$history['date_added']					=date("Y-m-d H:i:s");
				$this->returned_model->add_history($history);
				
				//修改订单状态
				$this->load->model('order/order_model');
				$o_status[0]=array(
						'order_id'							=>$return['order_id'],
						'order_status_id'					=>$this->config->get_config('refund_order')
				);
				$this->order_model->edit_order_status($o_status);
				
				//添加动态
				$this->load->model('common/user_activity_model');
				$this->user_activity_model->add_activity($_SESSION['user_id'], 'return', array('title'=>'你申请了一个商品退换', 'msg'=>'你申请了一个<a href="'.$this->config->item('catalog').'user/returned/info?rowid='.$this->input->get('rowid')).'">商品退换</a>');
				
				$this->user_activity_model->add_activity($data['order_product']['user_id'], 'return', array('title'=>$this->user->getnickname().'申请了一个商品退换', 'msg'=>$this->user->getnickname().'申请了一个<a href="'.$this->config->item('catalog').'user/returned/info?rowid='.$this->input->get('rowid')).'">商品退换</a>');
				
				redirect($this->config->item('catalog').'user/returned/info?rowid='.$this->input->get('rowid'));
				exit();
			}else{
				redirect(all_current_url());
				exit();
			}
		}
		
		$data['position_top']=$this->position_top->index();
		$data['position_left']=$this->position_left->index();
		$data['position_right']=$this->position_right->index();
		$data['position_bottom']=$this->position_bottom->index();
		
		$data['return_actions']=$this->returned_model->get_return_actions_to_returned();
		$data['return_reasons']=$this->returned_model->get_return_reason_to_returned();
		
		$data['header']=$this->header->index();
		$data['top']=$this->header->user_top();
		$data['footer']=$this->footer->index();
		$this->load->view('theme/default/template/user/returned',$data);
	}
	
	public function info(){
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
		$this->load->model('localisation/mode_transport_model');
		$data['mode_transports']=$this->mode_transport_model->get_Mode_transports();
		
		$data['header']=$this->header->index();
		$data['top']=$this->header->user_top();
		$data['footer']=$this->footer->index();
		$this->load->view('theme/default/template/user/returned_info',$data);
	}
	
	public function returned_list(){
		$this->document->setTitle('退换货商品列表');
		
		if ($this->input->get ( 'page' ) != NULL) {
			$data ['page'] = $this->input->get ( 'page' );
		} else {
			$data ['page'] = '0';
		}
		
		$return_list=$this->returned_model->get_list($data);
		
		if ($return_list) {
			$data['returns']=$return_list['returns'];
		}else{
			$data['returns']=false;
		}
		
		// 分页
		$config ['base_url'] = site_url ('user/returned/returned_list');
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
		$data['top']=$this->header->user_top();
		$data['footer']=$this->footer->index();
		$this->load->view('theme/default/template/user/returned_list',$data);
	}
	
	public function action(){
		$rowid=$this->input->get('rowid');
		$return_id=$this->returned_model->get_return_id($rowid);
		if($return_id = $this->input->post('return_id') && $this->input->get('token') == $_SESSION['token']){
			$return['return_id']=$this->input->post('return_id');
			$return['comment']=$this->input->post('comment');
			$return['date_added']=date("Y-m-d H:i:s");
				
			if($this->input->post('action') == 'refuse'){
				$return['return_status_id']=$this->config->get_config('cancellation_refund');
				
				$a_title='你撤销了一个商品退换';
				$u_title='客户撤销了商品退换申请';
				$a_msg='你撤销了一个<a href="'.$this->config->item('catalog').'user/returned/info?rowid='.$this->input->get('rowid').'">商品退换</a>';
				$u_msg='客户撤销了<a href="'.$this->config->item('catalog').'user/returned/info?rowid='.$this->input->get('rowid').'">商品退换</a>申请';
			}
				
			if($this->input->post('action') == 'agree'){
				$return['return_status_id']=$this->config->get_config('intervention');
	
				$a_title='你申请平台介入了一个商品退换';
				$u_title='客户申请平台介入了你的商品退换申请';
				$a_msg='你申请平台介入了一个<a href="'.$this->config->item('catalog').'user/returned/info?rowid='.$this->input->get('rowid').'">商品退换</a>';
				$u_msg='客户申请平台介入了你的<a href="'.$this->config->item('catalog').'user/returned/info?rowid='.$this->input->get('rowid').'">商品退换</a>申请';
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
	
			redirect($this->config->item('catalog').'user/returned/returned_list');
		}
	}
	
	public function mode(){
		$rowid=$this->input->get('rowid');
		$return_id=$this->returned_model->get_return_id($rowid);
		if($return_id = $this->input->post('return_id') && $this->input->get('token') == $_SESSION['token']){
			$return['return_id']=$this->input->post('return_id');
			$return['comment']=$this->input->post('comment');
			$return['date_added']=date("Y-m-d H:i:s");
			$return['return_status_id']=$this->config->get_config('wait_m_returns');
			
			$return_history_id=$this->returned_model->add_history($return);
			
			//更新return表
			$re['return_id']=$this->input->post('return_id');
			$re['mode_transport_id']=$this->input->post('mode_transport_id');
			$re['logistics']=$this->input->post('logistics');
			$re['return_status_id']=$return['return_status_id'];
			$this->returned_model->updata_return($re);
			
			//添加动态
			$this->load->model('common/user_activity_model');
			$this->user_activity_model->add_activity($_SESSION['user_id'], 'return', array('title'=>'你上传了退款商品运单号', 'msg'=>'你上传了<a href="'.$this->config->item('catalog').'user/returned/info?rowid='.$this->input->get('rowid')).'">退款商品</a>运单号');
			
			$this->user_activity_model->add_activity($this->input->post('user_id'), 'return', array('title'=>$this->user->getnickname().'上传了退款商品运单号', 'msg'=>$this->user->getnickname().'上传了<a href="'.$this->config->item('catalog').'user/returned/info?rowid='.$this->input->get('rowid')).'">退款商品</a>运单号');
			
			redirect($this->config->item('catalog').'user/returned/returned_list');
		}
	}
	
	public function c_action(){
		$rowid=$this->input->get('rowid');
		$return_id=$this->returned_model->get_return_id($rowid);
		if($return_id = $this->input->post('return_id') && $this->input->get('token') == $_SESSION['token']){
			$return['return_id']=$this->input->post('return_id');
			$return['comment']=$this->input->post('comment');
			$return['date_added']=date("Y-m-d H:i:s");
	
			if($this->input->post('action') == 'refuse'){
				$return['return_status_id']=$this->config->get_config('intervention');
	
				$a_title='你未收到退款，平台介入';
				$u_title='客户未收到你的退款';
				$a_msg='你未收到<a href="'.$this->config->item('catalog').'user/returned/info?rowid='.$this->input->get('rowid').'">商品退换</a>的商家退款，平台介入处理';
				$u_msg='客户未收到<a href="'.$this->config->item('catalog').'user/returned/info?rowid='.$this->input->get('rowid').'">商品退换</a>，平台介入处理';
			}
	
			if($this->input->post('action') == 'agree'){
				$return['return_status_id']=$this->config->get_config('returns_goods_success');
	
				$a_title='你已收到了商家的退款，退换货成功';
				$u_title='客户已收到你的退款，退换货成功';
				$a_msg='你已收到了商家的退款，<a href="'.$this->config->item('catalog').'user/returned/info?rowid='.$this->input->get('rowid').'">退换货成功</a>';
				$u_msg='客户已收到你的退款，<a href="'.$this->config->item('catalog').'user/returned/info?rowid='.$this->input->get('rowid').'">退换货成功</a>';
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
	
			redirect($this->config->item('catalog').'user/returned/returned_list');
		}
	}
}
