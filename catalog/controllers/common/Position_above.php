<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class position_above extends CI_Common{
	private $html = '';
	
	public function __construct() {
		parent::__construct ();
		$this->load->model ( array ('common/layout_model', 'common/module_model'));
		
		$layout_id=$this->layout_model->select_layout_ids();
		if(!$layout_id){
			return;
		}
		$modules_id=$this->layout_model->select_module_ids($layout_id, 'above');
		
		if(!$modules_id){
			return;
		}
		
		foreach($modules_id as $module_id){
			$modules[]=$this->module_model->get_modules_for_module_id($module_id['module_id']);
		}
		
		if(empty($modules)){
			return FALSE;
		}
		
		$data['modules']=array();
		foreach($modules as $key=>$module){
			if((isset($modules[$key]['setting']['status']) && $modules[$key]['setting']['status']==0) || !$modules[$key]){
				unset($modules[$key]);
			}else{
				$module_name=strtolower($modules[$key]['code'].'_module');
				$this->load->extension('module/'.$module_name);
				$data['modules'][]=$this->$module_name->index($modules[$key]['setting']);
			}
		}
		$this->html=$this->load->view('theme/default/template/common/position_above', $data, true);
	}
	public function index() {
		
		return $this->html;
	}
}
