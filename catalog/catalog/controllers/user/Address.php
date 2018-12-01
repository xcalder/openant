<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Address extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->language('wecome');
		$this->load->model(array('common/user_model', 'localisation/address_model', 'localisation/location_model'));
	}

	public function index()
	{
		$this->document->setTitle('地址管理');
		
		$data['addresss']=$this->address_model->get_addresss($this->user->getId());
		$data['countrys']=$this->location_model->get_countrys();
		
		if($this->input->get('address_id') != NULL){
			$data['address_info']=$this->address_model->get_address_tofrom($this->input->get('address_id'));
		}else{
			$data['address_info']=FALSE;
		}
		
		$data['position_top']=$this->position_top->index();
		$data['position_left']=$this->position_left->index();
		$data['position_right']=$this->position_right->index();
		$data['position_bottom']=$this->position_bottom->index();
		
		$data['header']=$this->header->index();
		$data['top']=$this->header->user_top();
		$data['footer']=$this->footer->index();
		$this->load->view('theme/default/template/user/address',$data);
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
	
	public function set_def(){
		if($this->input->post('address_id') == NULL){
			$this->session->set_flashdata('fali', '设为默认不成功');
			//redirect('user/address');
			//return;
		}
		
		if($this->address_model->defaul($this->input->post('address_id'))){
			$this->session->set_flashdata('success', '设置默认成功！');
			//redirect('user/address');
		}else{
			$this->session->set_flashdata('fali', '设为默认不成功');
			//redirect('user/address');
		}
	}
}
