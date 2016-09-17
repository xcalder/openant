<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Currency extends MY_Controller{
	public function __construct(){
		parent::__construct ();
		$this->load->model ( 'common/currency_model' );
		$this->load->helper ( 'cookie' );
	}
	public function index(){
		if($this->input->get ( 'currency_id' )){
			$currency = $this->currency_model->get_currency ( $this->input->get ( 'currency_id' ) );
			$_SESSION ['currency_id'] = $currency ['currency_id'];
		}
	}
}
