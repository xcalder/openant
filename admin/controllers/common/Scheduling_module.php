<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//布局总调度控制器
class Scheduling_module extends CI_Common{
	
	public function __construct(){
		parent::__construct();
		$this->load->helper(array('utf8'));
		$this->load->model('common/Scheduling_module_model');
	}

	public function above(){
		//在导航之上的位置
		
	}
	
	public function top(){
		//菜单之下，页面之上的位置
		
	}
	
	public function left(){
		//页面左边
	}
	
	public function right(){
		//页面右边
	}
	
	public function bottom(){
		//页面底部的位置
	}
}
