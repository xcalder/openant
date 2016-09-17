<?php
class Scheduling_module_model extends CI_Model {
	//布局总调度模型
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
}