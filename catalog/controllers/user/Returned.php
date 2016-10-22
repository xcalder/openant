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
			$data['order_product']=$this->returned_model->get_order_product($this->input->get('rowid'));
		}else{
			$data['order_product']=FALSE;
		}
		
		if($_SERVER['REQUEST_METHOD']=="POST" && $data['order_product']){
			$order_product=$data['order_product'];
			if($order_product['total'] - ($order_product['tax'] * $order_product['quantity']) < $this->input->post('return_amount')){
				$this->session->set_flashdata('fali', '退款金额大于可退金额，请重新输入');
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
	
	public function add(){
		if($this->input->post('address_id') != NULL){
			$updata['address_id']=$this->input->post('address_id');
			$updata['firstname']=$this->input->post('firstname');
			$updata['lastname']=$this->input->post('lastname');
			$updata['postcode']=$this->input->post('postcode');
			$updata['address']=$this->input->post('address');
			$updata['city']=$this->input->post('city');
			$updata['country_id']=$this->input->post('country_id');
			$updata['zone_id']=$this->input->post('zone_id');
			$updata['user_address_id']=($this->input->post('user_address_id') != NULL) ? $this->input->post('user_address_id') : '';
			$updata['user_id']=$this->user->getId();
			
			if($this->address_model->updata_address($updata)){
				$this->session->set_flashdata('success', '修改地址成功！');
				redirect('user/address');
			}else{
				$this->session->set_flashdata('fali', '地址修改不成功');
				redirect('user/address');
			}
			
		}else{
			$updata['firstname']=$this->input->post('firstname');
			$updata['lastname']=$this->input->post('lastname');
			$updata['postcode']=$this->input->post('postcode');
			$updata['address']=$this->input->post('address');
			$updata['city']=$this->input->post('city');
			$updata['country_id']=$this->input->post('country_id');
			$updata['zone_id']=$this->input->post('zone_id');
			if($this->input->post('user_address_id') != NULL){
				$def='on';
			}else{
				$def='';
			}
			
			$updata['user_id']=$this->user->getId();
			
			if($this->address_model->add_address($updata, $def)){
				$this->session->set_flashdata('success', '添加地址成功！');
				redirect('user/address');
			}else{
				$this->session->set_flashdata('fali', '地址添加不成功');
				redirect('user/address');
			}
		}
	}
	
	public function delete(){
		if($this->input->get('address_id') == NULL){
			redirect('user/address');
		}
		
		if($this->address_model->delete($this->input->get('address_id'))){
			$this->session->set_flashdata('success', '地址删除成功！');
			redirect('user/address');
		}else{
			$this->session->set_flashdata('fali', '地址删除不成功');
			redirect('user/address');
		}
		
	}
}
