<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Download extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->language('wecome');
		$this->load->library(array('currency'));
		$this->load->model(array('product/product_model'));
	}
	
	public function index(){
		if($this->input->get('name') != NULL && $this->input->get('filename') != NULL){
			$name=$this->input->get('name');
			$filename=$this->input->get('filename');
		}else{
			return FALSE;
		}
		$data=file_get_contents(FCPATH.$filename);
		$name = $name.substr($filename, strripos($filename, '.'));
		force_download($name, $data, TRUE);
	}
}