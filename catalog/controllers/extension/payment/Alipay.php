<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Alipay extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
	}

	public function index()
	{
		echo '用支付宝付款';
	}
}