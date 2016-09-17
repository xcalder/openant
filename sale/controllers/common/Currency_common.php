<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Currency_common extends CI_Common{
	public function __construct(){
		parent::__construct ();
		$this->load->model ( 'common/currency_model' );
		$this->load->helper ( 'cookie' );
		
		if(!isset($_SESSION['currency_id'])){
			$_SESSION['currency_id']=$this->config->get_config ( 'default_currency' );
		}
	}
	public function index(){
		$data ['currencys'] = $this->currency_model->get_currencys ();
		
		if(!isset($_SESSION['currency_id'])){
			$data ['currency'] = $this->currency_model->get_currency ( $this->config->get_config ( 'default_currency' ) );
		}
		return $this->load->view ( 'theme/default/template/common/currency_common', $data, TRUE );
	}
}
