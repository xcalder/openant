<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Roundabout_module extends CI_Extension {
	
	public function __construct() {
		parent::__construct();
		$this->load->common('image_common');
		$this->load->model('common/banner_model');
		$this->document->addScript(base_url('resources/public/module/roundabout/js/jquery.roundabout.js'));
		$this->document->addScript(base_url('resources/public/module/roundabout/js/script.js'));
		$this->document->addStyle(base_url('resources/public/module/roundabout/css/style.css'));
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
			
			return $this->load->view('theme/default/template/extension/module/roundabout_module', $data, TRUE);
		}else{
			return FALSE;
		}
		
	}
}