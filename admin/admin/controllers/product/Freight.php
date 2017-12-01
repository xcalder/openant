<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Freight extends MY_Controller
{
	private $error = array();

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('utf8'));
		$this->load->language('wecome');
		if(!$this->user->hasPermission('access', 'admin/product/freight')){
			$this->session->set_flashdata('fali', '你没有访问权限！');
			redirect($this->config->item('admin'));
			exit;
		}
		$this->load->library(array('form_validation'));
		$this->load->model(array('common/freight_model','localisation/location_model'));
	}

	public function index()
	{

		$this->document->setTitle('运费模板');

		$this->get_list();
	}

	public function edit_freight()
	{
		$this->document->setTitle('修改运费');

		if($_SERVER['REQUEST_METHOD'] == "POST" && $this->validate_freight())
		{
			$data['freight_id'] = $this->input->get('freight_id');
			$data['base'] = $this->input->post('base');
			$data['description'] = $this->input->post('description');

			$this->freight_model->edit_freight($data);

			redirect($this->config->item('admin').'product/freight');
		}

		$this->get_form();
	}

	public function add_freight()
	{
		$this->document->setTitle('添加运费');

		if($_SERVER['REQUEST_METHOD'] == "POST" && $this->validate_freight())
		{
			$data['base'] = $this->input->post('base');
			$data['description'] = $this->input->post('description');

			$this->freight_model->add_freight($data);

			redirect($this->config->item('admin').'product/freight');
		}

		$this->get_form();
	}

	public function edit_freight_template()
	{
		$this->document->setTitle('修改运费模板');

		if($_SERVER['REQUEST_METHOD'] == "POST" && $this->validate_freight_template())
		{
			$data['freight_template_id'] = $this->input->get('freight_template_id');
			$data['group_base'] = $this->input->post('group_base');
			$data['group_description'] = $this->input->post('group_description');

			$this->freight_model->edit_freight_template($data);

			redirect($this->config->item('admin').'product/freight');
		}

		$this->get_form();
	}

	public function add_freight_template()
	{
		$this->document->setTitle('添加运费模板');

		if($_SERVER['REQUEST_METHOD'] == "POST" && $this->validate_freight_template())
		{
			$data['group_base'] = $this->input->post('group_base');
			$data['group_description'] = $this->input->post('group_description');

			$this->freight_model->add_freight_template($data);

			redirect($this->config->item('admin').'product/freight');
		}

		$this->get_form();
	}

	public function delete_freight()
	{
		$this->document->setTitle('删除运费');

		if(!empty($this->input->post('selected')) && $this->validate_delete_freight($this->input->post('selected')))
		{
			$this->freight_model->delete_freight($this->input->post('selected'));

			redirect($this->config->item('admin').'product/freight');

		}
		$this->get_list();
	}

	public function delete_freight_template()
	{
		$this->document->setTitle('删除运费模板');

		if(!empty($this->input->post('selected_group')) && $this->validate_delete_freight_template($this->input->post('selected_group')))
		{
			$this->freight_model->delete_freight_template($this->input->post('selected_group'));

			redirect($this->config->item('admin').'product/freight');

		}
		$this->get_list();
	}

	public function get_form()
	{
		$data['languages'] = $this->language_model->get_languages();
		$data['freight_templates'] = $this->freight_model->get_freight_templates_to_form();
		$data['countrys'] = $this->location_model->get_countrys();

		//运费
		if($this->input->get('freight_id'))
		{
			$freight_info = $this->freight_model->get_freight_arr($this->input->get('freight_id'));
		}

		if($this->input->post('description'))
		{
			$data['description'] = $this->input->post('description');
		}
		elseif(isset($freight_info['description']) && $freight_info['description'])
		{
			$data['description'] = $freight_info['description'];
		}

		if($this->input->post('base')['freight_template_id'])
		{
			$data['freight_template_id'] = $this->input->post('base')['freight_template_id'];
		}
		elseif(isset($freight_info['freight_template_id']))
		{
			$data['freight_template_id'] = $freight_info['freight_template_id'];
		}

		if($this->input->post('base')['country_id'])
		{
			$data['country_id'] = $this->input->post('base')['country_id'];
		}
		elseif(isset($freight_info['country_id']))
		{
			$data['country_id'] = $freight_info['country_id'];
		}

		if($this->input->post('base')['zone_id'])
		{
			$data['zone_id'] = $this->input->post('base')['zone_id'];
		}
		elseif(isset($freight_info['zone_id']))
		{
			$data['zone_id'] = $freight_info['zone_id'];
		}

		if($this->input->post('base')['value'])
		{
			$data['freight_value'] = $this->input->post('base')['value'];
		}
		elseif(isset($freight_info['value']))
		{
			$data['freight_value'] = $freight_info['value'];
		}

		if($this->input->post('base')['sort_order'])
		{
			$data['freight_sort_order'] = $this->input->post('base')['sort_order'];
		}
		elseif(isset($freight_info['sort_order']))
		{
			$data['freight_sort_order'] = $freight_info['sort_order'];
		}

		//运费模板
		if($this->input->get('freight_template_id'))
		{
			$freight_template_info = $this->freight_model->get_freight_template_arr($this->input->get('freight_template_id'));
		}

		if($this->input->post('group_description'))
		{
			$data['group_description'] = $this->input->post('group_description');
		}
		elseif(isset($freight_template_info['description']) && $freight_template_info['description'])
		{
			$data['group_description'] = $freight_template_info['description'];
		}

		if($this->input->post('group_base')['value'])
		{
			$data['freight_template_value'] = $this->input->post('group_base')['value'];
		}
		elseif(isset($freight_template_info['value']))
		{
			$data['freight_template_value'] = $freight_template_info['value'];
		}

		if($this->input->post('group_base')['pricing'])
		{
			$data['freight_template_pricing'] = $this->input->post('group_base')['pricing'];
		}
		elseif(isset($freight_template_info['pricing']))
		{
			$data['freight_template_pricing'] = $freight_template_info['pricing'];
		}

		if($this->input->post('group_base')['sort_order'])
		{
			$data['freight_template_sort_order'] = $this->input->post('group_base')['sort_order'];
		}
		elseif(isset($freight_template_info['sort_order']))
		{
			$data['freight_template_sort_order'] = $freight_template_info['sort_order'];
		}

		if($this->input->get('freight_id'))
		{
			$data['freight_action'] = $this->config->item('admin').'product/freight/edit_freight?freight_id='.$this->input->get('freight_id');
		}
		else
		{
			$data['freight_action'] = $this->config->item('admin').'product/freight/add_freight';
		}

		if($this->input->get('freight_template_id'))
		{
			$data['freight_template_action'] = $this->config->item('admin').'product/freight/edit_freight_template?freight_template_id='.$this->input->get('freight_template_id');
		}
		else
		{
			$data['freight_template_action'] = $this->config->item('admin').'product/freight/add_freight_template';
		}

		if(isset($this->error['freight_description']))
		{
			$data['error_freight_description'] = $this->error['freight_description'];
		}

		if(isset($this->error['error_freight_template_id']))
		{
			$data['error_freight_template_id'] = $this->error['error_freight_template_id'];
		}

		if(isset($this->error['freight_template_description']))
		{
			$data['freight_template_description'] = $this->error['freight_template_description'];
		}

		$data['header'] = $this->header->index();
		$data['top'] = $this->header->top();
		$data['footer'] = $this->footer->index();

		$this->load->view('theme/default/template/product/freight_form',$data);
	}

	public function get_list()
	{
		if($this->input->get('freight_page'))
		{
			$data['freight_page'] = $this->input->get('freight_page');
		}
		else
		{
			$data['freight_page'] = '0';
		}

		$freights = $this->freight_model->get_freights($data);
		$data['freights'] = $freights['freights'];

		if($this->input->get('freight_template_page'))
		{
			$data['freight_template_page'] = $this->input->get('freight_template_page');
		}
		else
		{
			$data['freight_template_page'] = '0';
		}

		$freight_templates = $this->freight_model->get_freight_templates($data);
		$data['freight_templates'] = $freight_templates['freight_templates'];

		//分页
		$config['base_url'] = $this->config->item('admin').'product/freight';
		$config['num_links'] = 2;
		$config['page_query_string'] = TRUE;
		$config['query_string_segment'] = 'freight_page';
		$config['full_tag_open'] = '<div class="text-left pagination" style="float: left;padding: 6px 0px;margin: 5px 0">共'.@(floor($freights['count'] / $this->config->get_config ( 'config_limit_admin' )) + 1) .'页/第'.@(floor($data['freight_page'] / $this->config->get_config ( 'config_limit_admin' )) + 1) .'页</div><ul class="pagination" style="float: right;margin: 5px 0">';
		$config['full_tag_close'] = '</ul>';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['first_link'] = '<<';
		$config['last_link'] = '>>';
		$config['total_rows'] = $freights['count'];
		$config['per_page'] = $this->config->get_config('config_limit_admin');

		$this->pagination->initialize($config);

		$data['freights_pagination'] = $this->pagination->create_links();

		//分页
		$config1['base_url'] = $this->config->item('admin').'product/freight';
		$config1['num_links'] = 2;
		$config1['page_query_string'] = TRUE;
		$config1['query_string_segment'] = 'freight_template_page';
		$config1['full_tag_open'] = '<div class="text-left pagination" style="float: left;padding: 6px 0px;margin: 5px 0">共'.@(floor($freight_templates['count'] / $this->config->get_config ( 'config_limit_admin' )) + 1) .'页/第'.@(floor($data['freight_template_page'] / $this->config->get_config ( 'config_limit_admin' )) + 1) .'页</div><ul class="pagination" style="float: right;margin: 5px 0">';
		$config1['full_tag_close'] = '</ul>';
		$config1['first_tag_open'] = '<li>';
		$config1['first_tag_close'] = '</li>';
		$config1['last_tag_open'] = '<li>';
		$config1['last_tag_close'] = '</li>';
		$config1['next_tag_open'] = '<li>';
		$config1['next_tag_close'] = '</li>';
		$config1['prev_tag_open'] = '<li>';
		$config1['prev_tag_close'] = '</li>';
		$config1['cur_tag_open'] = '<li class="active"><a>';
		$config1['cur_tag_close'] = '</a></li>';
		$config1['num_tag_open'] = '<li>';
		$config1['num_tag_close'] = '</li>';
		$config1['first_link'] = '<<';
		$config1['last_link'] = '>>';
		$config1['total_rows'] = $freight_templates['count'];
		$config1['per_page'] = $this->config->get_config('config_limit_admin');

		$this->pagination->initialize($config1);

		$data['freight_template_pagination'] = $this->pagination->create_links();

		$data['freight_delete'] = $this->config->item('admin').'product/freight/delete_freight';
		$data['freight_template_delete'] = $this->config->item('admin').'product/freight/delete_freight_template';

		$data['header'] = $this->header->index();
		$data['top'] = $this->header->top();
		$data['footer'] = $this->footer->index();

		$this->load->view('theme/default/template/product/freight_list',$data);
	}


	public function validate_delete_freight($data)
	{
		if (!$this->user->hasPermission('modify', 'admin/product/freight')) {
			$this->session->set_flashdata('danger', '你无权修改，请联系管理员！');
			redirect($this->config->item('admin').'product/freight');
			exit();
		}
		
		if(empty($data))
		{
			return FALSE;
		}

		foreach($data as $key=>$value)
		{
			if($this->freight_model->get_product_freight_for_freight_id($data[$key]) != FALSE)
			{
				$this->error[$key]['error_freight_delete'] = '正在在被使用';
			}
		}

		return !$this->error;
	}

	public function validate_delete_freight_template($data)
	{
		if (!$this->user->hasPermission('modify', 'admin/product/freight')) {
			$this->session->set_flashdata('danger', '你无权修改，请联系管理员！');
			redirect($this->config->item('admin').'product/freight');
			exit();
		}
		
		if(empty($data))
		{
			return FALSE;
		}

		foreach($data as $key=>$value)
		{
			if($this->freight_model->get_freight_for_freight_template_id($data[$key]) != FALSE)
			{
				$this->error[$key]['error_freight_template_delete'] = '正在在被使用';
			}
		}

		return !$this->error;
	}

	public function validate_freight()
	{
		if (!$this->user->hasPermission('modify', 'admin/product/freight')) {
			$this->session->set_flashdata('danger', '你无权修改，请联系管理员！');
			redirect($this->config->item('admin').'product/freight');
			exit();
		}
		
		$description = $this->input->post('description');
		foreach($description as $key=>$value)
		{
			if((utf8_strlen($description[$key]['name']) < 2) || (utf8_strlen($description[$key]['name']) > 255))
			{
				$this->error['freight_description'][$key]['error_freight_name'] = '运费名称2——255字符';
			}
		}

		if(!$this->form_validation->integer($this->input->post('base')['freight_template_id']))
		{
			$this->error['error_freight_template_id'] = '请选择运费模板';
		}
		return !$this->error;
	}

	public function validate_freight_template()
	{
		if (!$this->user->hasPermission('modify', 'admin/product/freight')) {
			$this->session->set_flashdata('danger', '你无权修改，请联系管理员！');
			redirect($this->config->item('admin').'product/freight');
			exit();
		}
		
		$description = $this->input->post('group_description');
		foreach($description as $key=>$value)
		{
			if((utf8_strlen($description[$key]['freight_template_name']) < 2) || (utf8_strlen($description[$key]['freight_template_name']) > 255))
			{
				$this->error['freight_template_description'][$key]['error_freight_template_name'] = '运费模板名称2——255字符';
			}
		}

		return !$this->error;
	}
}
