<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Header extends CI_Common {
	
	public function __construct() {
		parent::__construct();
		$this->load->library(array('user_agent'));
		
		$this->document->addStyle('public/min?f=public/resources/default/css/ystep/ystep.css');
		$this->document->addScript('public/min?f=public/resources/default/js/ystep/ystep.js');
		
		if(!isset($_SESSION['language_id'])){
			
			$language_code_zh='zh,zh-hk,zh-tw,zh-cn,chinese';
			$language_code_zh=explode(',', $language_code_zh);
			if(in_array($this->agent->languages()[0], $language_code_zh)){
				$_SESSION['language_id']='1';
				$_SESSION['language_code']= 'zh-CN';
				$_SESSION['language_name']= 'chinese';
			}else{
				$_SESSION['language_id']='2';
				$_SESSION['language_code']= 'en';
				$_SESSION['language_name']= 'english';
			}
		}
	}

	public function index()
	{
		$data['title']=$this->document->getTitle();
		$data['links']=$this->document->getLinks();
		$data['styles']=$this->document->getStyles();
		$data['scripts']=$this->document->getScripts();
		
		return $this->load->view('common/header',$data,TRUE);
	}
	
	public function top(){
		$data=array();
		$this->lang->load('common/header', $_SESSION['language_name']);
		
		return $this->load->view('common/top',$data,TRUE);
	}
}
