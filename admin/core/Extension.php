<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class CI_Extension {

	public function __construct()
	{
		log_message('info', 'Extension Class Initialized');
	}

	public function __get($key)
	{
		return get_instance()->$key;
	}

}