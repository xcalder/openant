<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Currency extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('common/currency_model');
		$this->load->helper('cookie');
		$this->load->library(array('currency'));
	}

	public function index()
	{
		if($this->input->get('currency_id')){
			$currency=$this->currency_model->get_currency($this->input->get('currency_id'));
			$_SESSION['currency_id']=$currency['currency_id'];
		}
	}
	
	public function compute(){
		if($this->input->get('currency') == NULL){
			$data['value']=$this->input->get('currency');
		}else{
			$data['value']=$this->currency->plus_sign($this->input->get('currency'));
		}
		
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($data));
	}
}
