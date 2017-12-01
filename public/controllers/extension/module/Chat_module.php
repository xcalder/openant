<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chat_module extends CI_Extension {
	
	public function __construct() {
		parent::__construct();
		$this->load->common('image_common');
		$this->document->addStyle(base_url('resources/public/module/chat/css/densigner_contest.css'));
		
	}

	public function index($setting=FALSE, $position)
	{
		if($setting){
			$data['position']												=$setting['position'];
			$chats=array();
			foreach ($setting['content'] as $content){
				$chats[]													=$content[$_SESSION['language_id']];
			}
			$data['name']													=@$setting['name'][$_SESSION['language_id']];
			$data['chats']													=$chats;
			return $this->load->view('theme/default/template/extension/module/chat_module', $data, TRUE);
		}else{
			return FALSE;
		}
		
	}
}