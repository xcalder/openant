<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Banner extends MY_Controller {
	private $error = array ();
	public function __construct() {
		parent::__construct ();
		$this->load->helper ( array ('utf8') );
		$this->load->language ( 'wecome' );
		
		if(!$this->user->hasPermission('access', 'admin/common/banner')){
			$this->session->set_flashdata('fali', '你没有访问权限！');
			redirect(site_url(), 'location', 301);
			exit;
		}
		
		$this->load->library (array('form_validation'));
		$this->load->model ( array ('common/banner_model','common/language_model' ) );
	}
	public function index() {
		$this->document->setTitle ( 'Banner设置' );
		
		$this->get_list ();
	}
	public function add() {
		$this->document->setTitle ( '添加Banner' );
		
		if ($_SERVER ['REQUEST_METHOD'] == "POST" && $this->validate_form ()) {
			$this->banner_model->add ( $this->input->post () );
			$this->session->set_flashdata ( 'success', '成功：添加Banner成功！' );
			redirect ( site_url ( 'common/banner' ), 'location', 301 );
		}
		
		$this->get_form ();
	}
	public function edit() {
		$this->document->setTitle ( '修改Banner' );
		
		if ($_SERVER ['REQUEST_METHOD'] == "POST" && $this->validate_form ()) {
			$this->banner_model->edit ( $this->input->post () );
			$this->session->set_flashdata ( 'success', '成功：修改Banner成功！' );
			redirect ( site_url ( 'common/banner' ), 'location', 301 );
		}
		
		$this->get_form ();
	}
	public function delete() {
		$this->document->setTitle ( '删除Banner' );
		
		if ($_SERVER ['REQUEST_METHOD'] == "POST") {
			$this->banner_model->delete ( $this->input->post ( 'selected' ) );
			$this->session->set_flashdata ( 'success', '成功：删除Banner成功！' );
			redirect ( site_url ( 'common/banner' ), 'location', 301 );
		}
		
		$this->get_list ();
	}
	public function get_form() {
		if ($this->input->get ( 'banner_id' )) {
			$banner_info = $this->banner_model->get_banner ( $this->input->get ( 'banner_id' ) );
			if (isset ( $banner_info ['image'] ) && is_array ( $banner_info ['image'] )) {
				foreach ( $banner_info ['image'] as $key => $value ) {
					foreach ( $banner_info ['image'] [$key] ['description'] as $k => $v ) {
						$banner_info ['image'] [$key] ['sm_image'] = $this->image_common->resize ( $banner_info ['image'] [$key] ['image'], 100, 100, 'w' );
						$banner_info ['image'] [$key] ['descriptions'] [$banner_info ['image'] [$key] ['description'] [$k] ['language_id']] = $v;
					}
				}
				unset ( $banner_info ['image'] [$key] ['description'] );
			}
		}
		
		if ($this->input->post ( 'base' )['name']) {
			$data ['name'] = $this->input->post ( 'base' )['name'];
		} elseif (isset ( $banner_info ['name'] )) {
			$data ['name'] = $banner_info ['name'];
		} else {
			$data ['name'] = '';
		}
		
		if ($this->input->post ( 'base' )['status']) {
			$data ['status'] = $this->input->post ( 'base' )['status'];
		} elseif (isset ( $banner_info ['status'] )) {
			$data ['status'] = $banner_info ['status'];
		} else {
			$data ['status'] = '';
		}
		
		if ($this->input->post ( 'image' )) {
			$images = $this->input->post ( 'image' );
			foreach ( $images as $key => $value ) {
				$images [$key] ['sm_image'] = $this->image_common->resize ( $images [$key] ['image'], 100, 100, 'h' );
			}
			$data ['images'] = $images;
		} elseif (isset ( $banner_info ['image'] )) {
			$data ['images'] = $banner_info ['image'];
		}
		
		if ($this->input->get ( 'banner_id' )) {
			$data ['action'] = site_url ( 'common/banner/edit?banner_id=' ) . $this->input->get ( 'banner_id' );
		} else {
			$data ['action'] = site_url ( 'common/banner/add' );
		}
		
		if (isset ( $this->error ['error_name'] )) {
			$data ['error_name'] = $this->error ['error_name'];
		}
		
		$data ['languages'] = $this->language_model->get_languages ();
		$data ['placeholder_image'] = 'public/resources/default/image/no_image.jpg';
		
		$data ['header'] = $this->header->index ();
		$data ['top'] = $this->header->top ();
		$data ['footer'] = $this->footer->index ();
		$this->load->view ( 'theme/default/template/common/banner_form', $data );
	}
	public function get_list() {
		if ($this->input->get ( 'page' )) {
			$data ['page'] = $this->input->get ( 'page' );
		} else {
			$data ['page'] = '0';
		}
		
		$banners_info = $this->banner_model->get_banners ( $data );
		if ($banners_info) {
			$data ['banners'] = $banners_info ['banners'];
			$data ['count'] = $banners_info ['count'];
		}
		
		// 分页
		$config ['base_url'] = site_url ( 'common/banner' );
		$config ['num_links'] = 2;
		$config ['page_query_string'] = TRUE;
		$config ['query_string_segment'] = 'page';
		$config ['full_tag_open'] = '<nav class="text-left"><ul class="pagination">';
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
		$config ['total_rows'] = $banners_info ['count'];
		$config ['per_page'] = $this->config->get_config ( 'config_limit_admin' );
		
		$this->pagination->initialize ( $config );
		
		$data ['pagination'] = $this->pagination->create_links ();
		
		$data ['delete'] = site_url ( 'common/banner/delete' );
		
		$data ['header'] = $this->header->index ();
		$data ['top'] = $this->header->top ();
		$data ['footer'] = $this->footer->index ();
		$this->load->view ( 'theme/default/template/common/banner_list', $data );
	}
	
	// 验证表单
	public function validate_form() {
		if ((utf8_strlen ( $this->input->post ( 'base' )['name'] ) < 1) || (utf8_strlen ( $this->input->post ( 'base' )['name'] ) > 64)) {
			$this->error ['error_name'] = 'Banner名称1——64字符';
		}
		
		return ! $this->error;
	}
}
