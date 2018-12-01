<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload extends CI_Controller {
	
	private $user_directory;
	
	public function __construct() {
		parent::__construct();
		if(!$this->user->hasPermission('access', 'sale/common/upload')){
			$this->session->set_flashdata('fali', '你没有访问商家后台的权限！');
			redirect(base_url(), 'location', 301);
			exit;
		}
		$this->load->library(array('upload'));
		$user_added_date=$this->user->getDate_added();
		$this->user_directory=date("Y",strtotime($user_added_date)).'/'.date("m",strtotime($user_added_date)).'/'.date("d",strtotime($user_added_date)).'/'.$this->user->getId();
		
		if (!is_dir(FCPATH . 'resources/upload/'.$this->user_directory)) {
			@mkdir(FCPATH . 'resources/upload/'.$this->user_directory, 0777,true);
		}
		
		if (!is_dir(FCPATH . 'resources/upload/upload_cache/'.$this->user_directory)) {
			@mkdir(FCPATH . 'resources/upload/upload_cache/'.$this->user_directory, 0777,true);
		}
	}

	public function index() {
		$json = array();
		
		$config['upload_path']      = FCPATH .'resources/upload/upload_cache/'. $this->user_directory;
        $config['allowed_types']    = 'rar|zip|tar|7-zip|pdf|doc|docx';
        $config['file_name']    	= date("Ymdhis");
        $config['file_ext_tolower'] = TRUE;
        $config['max_size']    		= $this->config->get_config('upload_limit_size');
        
        $this->upload->initialize($config);
        
        if($this->check_modify()){
        	if (!$this->upload->do_upload('file'))
        	{
        		$json['error'] = $this->upload->display_errors('','');
        	
        	}
        	else
        	{
        		$json['success']['move_path'] = 'resources/upload/'. $this->user_directory.'/'.$this->upload->data()['file_name'];
        		$json['success']['cache_path'] = 'resources/upload/upload_cache/'. $this->user_directory.'/'.$this->upload->data()['file_name'];
        		$json['success']['client_name'] = $this->upload->data()['client_name'];
        	
        	}
        }else{
        	$json['error'] = '无权上传';
        }
       
        $this->output
			    ->set_content_type('application/json')
			    ->set_output(json_encode($json, JSON_UNESCAPED_UNICODE));
			    
	}
	
	public function check_modify(){
		if (!$this->user->hasPermission('modify', 'sale/common/upload')) {
			$this->session->set_flashdata('danger', '你无权修改，请联系管理员！');
			redirect($this->config->item('sale').'/extension_config/module/slideshow');
			exit();
		}else {
			return true;
		}
	}
}
