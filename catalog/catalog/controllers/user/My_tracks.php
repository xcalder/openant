<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class My_tracks extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->helper(array('utf8'));
		$this->load->language('wecome');
		$this->load->model(array('setting/my_tracks_model', 'product/product_model', 'common/store_model'));
	}

	public function index()
	{
		$this->document->setTitle('我的足迹');
		
		//分页
		if ($this->input->get ( 'page' ) != NULL) {
			$data ['page'] = $this->input->get ( 'page' );
		} else {
			$data ['page'] = '0';
		}
		
		$tracks=$this->my_tracks_model->get_tracks($data);
		
		// 分页
		$config ['base_url'] = site_url ( 'user/my_tracks' );
		$config ['num_links'] = 2;
		$config ['page_query_string'] = TRUE;
		$config ['query_string_segment'] = 'page';
		$config ['full_tag_open'] = '<div class="text-left" style="float: left;line-hight: 34px;padding: 6px 12px">共'.@(floor($tracks['count'] / $this->config->get_config ( 'config_limit_admin' )) + 1) .'页/第'.@(floor($data['page'] / $this->config->get_config ( 'config_limit_admin' )) + 1) .'页</div><nav class="text-right"><ul class="pagination" style="margin: 0 0 10px 0">';
		$config ['full_tag_close'] = '</ul></nav>';
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
		$config ['total_rows'] = $tracks['count'];
		$config ['per_page'] = $this->config->get_config ( 'config_limit_admin' );
		
		$this->pagination->initialize ( $config );

		$data=array();
		
		$data['pagination'] = $this->pagination->create_links();
		
		if($tracks){
			$data_tracks=array();
			foreach($tracks['content'] as $k=>$v){
				$data_tracks[$k]['time']=$tracks['content'][$k]['date_added'];
				$data_tracks[$k]['product']=$this->product_model->get_product($tracks['content'][$k]['product_id']);
				$data_tracks[$k]['product']['store_name']=$this->store_model->get_store_name($data_tracks[$k]['product']['store_id'])['store_name'];
			}
			$data['tracks']=$data_tracks;
		}
		
		//var_dump($data_tracks);
		$data['position_top']=$this->position_top->index();
		$data['position_left']=$this->position_left->index();
		$data['position_right']=$this->position_right->index();
		$data['position_bottom']=$this->position_bottom->index();
		
		$data['header']=$this->header->index();
		$data['top']=$this->header->user_top();
		$data['footer']=$this->footer->index();
		$this->load->view('theme/default/template/user/my_tracks',$data);
	}
}
