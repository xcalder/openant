<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sender_email extends CI_Common {
	
	public function __construct() {
		parent::__construct();
		$config['useragent'] = 'openant';
		if($this->config->get_config('email_protocol') == 'smtp'){
			$config['protocol'] = $this->config->get_config('email_protocol');
	    	$config['smtp_port'] = $this->config->get_config('email_smtp_port');
	    	$config['smtp_host'] = $this->config->get_config('email_smtp_host');
	    	$config['smtp_user'] = $this->config->get_config('email_smtp_user');
	    	$config['smtp_pass'] = $this->config->get_config('email_smtp_pass');
		}
		
    	$config['mailtype'] = 'html';
    	$config['charset'] = 'utf-8';
    	$config['smtp_timeout'] = $this->config->get_config('email_smtp_timeout');
    	$config['newline'] = "\r\n";
		$config['crlf'] = "\r\n";
		$this->load->library(array('email'));//加载email类
    	$this->email->initialize($config);//参数配置
	}

	public function sender($data)
	{
		if(!isset($data['from'])){
			$data['from']=$this->config->get_config('email_smtp_user');
		}
		if(!isset($data['name'])){
			$data['name']=unserialize($this->config->get_config('site_abbreviation'))[$_SESSION['language_id']];
		}
    	$this->email->from($data['from'], $data['name']);
    	
    	if(!isset($data['to'])){
			return FALSE;
		}
    	$this->email->to($data['to']);
    	
    	if(!isset($data['subject'])){
			return FALSE;
		}
    	$this->email->subject($data['subject']);
    	if(!isset($data['message'])){
			return FALSE;
		}
    	$this->email->message($this->config->get_config('email_send_header').$data['message'].$this->config->get_config('email_send_footer'));
    	if($this->email->send()){
    		return TRUE;
    	}else{
    		return FALSE;
    		}
	}
}
