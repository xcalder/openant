<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wechat_index extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		
		# 配置参数
		$config = array(
		'token'          => 'openant',
		'appid'          => 'wxfc790e2eb9601add',
		'appsecret'      => '39ea2b90c55ec14462b1967909316895',
		'encodingaeskey' => ''
		);
		
		# 加载对应操作接口
		//文件夹名注意大写
		$this->load->library('Wechat/wechat_menu', $config);
		
		//var_dump($this->wechat_user->getUserList());
	}
	
	public function index(){
		$data=array (
					  'button' => 
					  array (
					    0 => 
					    array (
					      'type' => 'click',
					      'name' => '今歌曲',
					      'key' => 'V1001_TODAY_MUSIC',
					    ),
					    1 => 
					    array (
					      'name' => '菜单',
					      'sub_button' => 
					      array (
					        0 => 
					        array (
					          'type' => 'view',
					          'name' => '搜索',
					          'url' => 'http://www.soso.com/',
					        ),
					        1 => 
					        array (
					          'type' => 'view',
					          'name' => '视频',
					          'url' => 'http://v.qq.com/',
					        ),
					        2 => 
					        array (
					          'type' => 'click',
					          'name' => '赞一下我们',
					          'key' => 'V1001_GOOD',
					        ),
					      ),
					    ),
					  ),
					);
		
		echo $this->wechat_menu->createMenu($data);
		var_dump($this->wechat_menu->getMenu());
		//echo $this->wechat_receive->getRevFrom();
		/*
		# 配置参数
		$config = array(
			'token'          => 'openant',
			'appid'          => 'wxfc790e2eb9601add',
			'appsecret'      => '39ea2b90c55ec14462b1967909316895',
			'encodingaeskey' => '',
		);

		# 加载对应操作接口
		$this->wechat->get('User', $config);
		//$userlist = $wechat->getUserList();
*/
		//var_dump($userlist);
		//var_dump($wechat->errMsg);
		//var_dump($wechat->errCode);
	}
}
