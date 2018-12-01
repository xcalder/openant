<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Country extends MY_Controller {
	private $error = array();
	
	public function __construct() {
		parent::__construct();
		if(!$this->user->hasPermission('access', 'sale/localisation/country')){
			$this->session->set_flashdata('fali', '你没有访问商家后台的权限！');
			redirect(base_url(), 'location', 301);
			exit;
		}
		$this->load->model(array('localisation/location_model'));
	}
	public function get_country()
	{
		$country_info = $this->location_model->get_country($this->input->get('country_id'));
		
		if ($country_info) {
			$json = array(
				'country_id'        => $country_info['country_id'],
				'name'              => $country_info['name'],
				'iso_code_2'        => $country_info['iso_code_2'],
				'iso_code_3'        => $country_info['iso_code_3'],
				'address_format'    => $country_info['address_format'],
				'postcode_required' => $country_info['postcode_required'],
				'zone'              => $this->location_model->get_zones($this->input->get('country_id')),
				'status'            => $country_info['status']
			);
		}
		
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($json));
		
	}
}