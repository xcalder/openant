<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Count extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		header('Access-Control-Allow-Origin:http://studio.openant.com');
	}

	public function add_useronline()
	{
		$this->load->model('common/user_online_model');
		$this->user_online_model->add_user_online();
	}
}
