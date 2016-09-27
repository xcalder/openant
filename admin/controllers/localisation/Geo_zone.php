<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Geo_zone extends MY_Controller {
	private $error = array();
	
	public function __construct() {
		parent::__construct();
		$this->load->helper(array('utf8'));
		$this->load->language('wecome');
		if(!$this->user->hasPermission('access', 'admin/localisation/geo_zone')){
			$this->session->set_flashdata('fali', '你没有访问权限！');
			redirect(site_url());
			exit;
		}
		$this->load->library(array('form_validation'));
		$this->load->model(array('localisation/geo_zone_model', 'localisation/zone_model', 'localisation/country_model', 'common/language_model'));
	}

	public function index(){
		$this->document->setTitle('区域设置设置');
		
		$this->get_list();
	}
	
	public function add()
	{
		$this->document->setTitle('添加区域设置设置');
		
		if($_SERVER['REQUEST_METHOD']=="POST" && $this->validate_form()){
			$this->geo_zone_model->add($this->input->post());
			
			redirect(site_url('localisation/geo_zone'));
		}
		
		$this->get_form();
	}
	
	public function edit()
	{
		$this->document->setTitle('修改区域设置设置');
		
		if($_SERVER['REQUEST_METHOD']=="POST" && $this->validate_form()){
			$this->geo_zone_model->edit($this->input->post());
			
			redirect(site_url('localisation/geo_zone'));
		}
		
		$this->get_form();
	}
	
	public function delete()
	{
		$this->document->setTitle('删除区域设置参数');
		
		if($_SERVER['REQUEST_METHOD']=="POST" && $this->validate_delete()){
			$this->geo_zone_model->delete($this->input->post('selected'));
			
			redirect(site_url('localisation/geo_zone'));
		}
		
		$this->get_list();
	}
	
	public function get_form()
	{
		if($this->input->get('geo_zone_id')){
			$geo_zone_info					=$this->geo_zone_model->get_geo_zone_form($this->input->get('geo_zone_id'));
		}
		
		if($this->input->post('description')){
			$data['description']			=$this->input->post('description');
		}elseif(isset($geo_zone_info['description'])){
			$data['description']			=$geo_zone_info['description'];
		}
		
		if($this->input->post('zone_to_geo_zone') != NULL){
			$data['zone_to_geo_zones']			=$this->input->post('zone_to_geo_zone');
		}elseif(isset($geo_zone_info['zone_to_geo_zone'])){
			$data['zone_to_geo_zones']			=$geo_zone_info['zone_to_geo_zone'];
		}
		
		if($this->input->post('base')['sort_order']){
			$data['sort_order']			=$this->input->post('base')['sort_order'];
		}elseif(isset($geo_zone_info['sort_order'])){
			$data['sort_order']			=$geo_zone_info['sort_order'];
		}else{
			$data['sort_order']			='0';
		}
		
		if($this->input->get('geo_zone_id')){
			$data['action']					=site_url('localisation/geo_zone/edit?geo_zone_id=').$this->input->get('geo_zone_id');
		}else{
			$data['action']					=site_url('localisation/geo_zone/add');
		}
		
		if(isset($this->error['error_description'])){
			$data['error_description']		=$this->error['error_description'];
		}
		
		$data['languages']				=$this->language_model->get_languages();
		$data['countrys']				=$this->country_model->get_countrys();
		
		$data['header']=$this->header->index();
		$data['top']=$this->header->top();
		$data['footer']=$this->footer->index();
		$this->load->view('theme/default/template/localisation/geo_zone_form',$data);
	}

	public function get_list()
	{
		if($this->input->get('page')){
			$data['page']=$this->input->get('page');
		}else{
			$data['page']='0';
		}
		
		$geo_zones_info=$this->geo_zone_model->get_geo_zones_for_langugae_id($data);
		if($geo_zones_info){
			$data['geo_zones']				=$geo_zones_info['geo_zones'];
			$data['count']					=$geo_zones_info['count'];
		}
		
		//分页
		$config['base_url'] 			= site_url('localisation/geo_zone');
		$config['num_links'] 			= 2;
		$config['page_query_string'] 	= TRUE;
		$config['query_string_segment'] = 'page';
		$config['full_tag_open'] 		= '<nav class="text-left"><ul class="pagination">';
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
		$config['total_rows'] 			= $geo_zones_info['count'];
		$config['per_page'] 			= $this->config->get_config('config_limit_admin');

		$this->pagination->initialize($config);

		$data['pagination'] 			= $this->pagination->create_links();
		
		$data['delete']					=site_url('localisation/geo_zone/delete');
		
		$data['header']=$this->header->index();
		$data['top']=$this->header->top();
		$data['footer']=$this->footer->index();
		$this->load->view('theme/default/template/localisation/geo_zone_list',$data);
	}
	
	public function validate_delete(){
		if (!$this->user->hasPermission('modify', 'admin/localisation/geo_zone')) {
			$this->session->set_flashdata('danger', '你无权修改，请联系管理员！');
			$this->error['warning'] = '没有权限修改';
		}
		
		if($this->geo_zone_model->check_delete($this->input->post('selected'))){
			$this->error['wring_delete']='有一个删除的区域设置设置正在被使用';
		}
		
		return !$this->error;
	}
	
	//验证表单
	public function validate_form(){
		if (!$this->user->hasPermission('modify', 'admin/localisation/geo_zone')) {
			$this->session->set_flashdata('danger', '你无权修改，请联系管理员！');
			$this->error['warning'] = '没有权限修改';
		}
		
		$description=$this->input->post('description');
		foreach($description as $key=>$value){
			if((utf8_strlen($description[$key]['geo_zone_name']) < 2) || (utf8_strlen($description[$key]['geo_zone_name']) > 32)){
				$this->error['error_description'][$key]['error_geo_zone_name']='区域设置名称2——32字符';
			}
			if((utf8_strlen($description[$key]['geo_zone_description']) < 2) || (utf8_strlen($description[$key]['geo_zone_description']) > 32)){
				$this->error['error_description'][$key]['error_geo_zone_description']='区域设置名称2——32字符';
			}
		}
		
		return !$this->error;
	}
	
	public function zone(){
		$output = '<option value="0">所有地区</option>';

		$results = $this->zone_model->get_zones($this->input->get('country_id'));
		foreach ($results as $result) {
			$output .= '<option value="' . $result['zone_id'] . '"';
			if ($this->input->get('zone_id') == $result['zone_id']) {
				$output .= ' selected="selected"';
			}
			$output .= '>' . $result['zone_name'] . '</option>';
		}

		$this->output
		    ->set_content_type('application/html')
		    ->set_output($output);
	}
}
