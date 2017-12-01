<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bbs_module extends CI_Extension {
	
	public function __construct() {
		parent::__construct();
		$this->load->common('image_common');
	}

	public function index($setting=FALSE, $position)
	{
		if($setting && $setting['status'] == '1'){
			$this->load->helper('date');
			$this->load->model('bbs/bbs_model');
			if($setting['type'] == 'very_good'){
				$data['title']=$setting['view_name'];
				$data['postings']=$this->bbs_model->get_very_good($setting['limit']);
			}
			
			if($setting['type'] == 'active'){
				$data['title']=$setting['view_name'];
				$data['postings']=$this->bbs_model->get_active($setting['limit']);
			}
			
			$html =false;
			
			if($position == 'left' || $position == 'right'){
				$html = $this->load->view('theme/default/template/extension/module/bbs_left_right_module', $data, TRUE);
			}
			
			if($position == 'top' || $position == 'bottom'){
				$html = $this->load->view('theme/default/template/extension/module/bbs_top_bottom_module', $data, TRUE);
			}
			
			if($position == 'above'){
				$html = $this->load->view('theme/default/template/extension/module/bbs_above_module', $data, TRUE);
			}
			
			return $html;
		}else{
			return FALSE;
		}
		
	}
}