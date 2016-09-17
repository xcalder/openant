<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Slideshow_module extends CI_Extension {
	
	public function __construct() {
		parent::__construct();
		$this->load->common('image_common');
		$this->load->model('common/banner_model');
	}

	public function index($setting=FALSE)
	{
		if($setting){
			$banners=$this->banner_model->get_banner_to_layout($setting['banner_id']);
			if(!$banners){
				return FALSE;
			}
			
			foreach($banners as $key=>$value){
				$banners[$key]['image']=$this->image_common->resize($banners[$key]['image'], $setting['width'], $setting['height'],'w');
			}
			$data['banners']=$banners;
			$data['setting']=$setting;
			
			return $this->load->view('theme/default/template/extension/module/slideshow_module', $data, TRUE);
		}else{
			return FALSE;
		}
		
	}
}