<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class CI_Common {

	public function __construct()
	{
		log_message('info', 'Commod Class Initialized');
	}

	public function __get($key)
	{
		return get_instance()->$key;
	}

}
