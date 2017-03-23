<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wechat_menu extends MY_Controller {
	
public function __construct() {
		parent::__construct();
		# 配置参数
		$config = array(
		'token'          => $this->config->get_config('encodingaeskey', 'wechat', '0'),
		'appid'          => $this->config->get_config('appID', 'wechat', '0'),
		'appsecret'      => $this->config->get_config('appsecret', 'wechat', '0'),
		'encodingaeskey' => $this->config->get_config('encodingaeskey', 'wechat', '0')
		);
		
		# 加载对应操作接口
		//文件夹名注意大写
		$this->load->library('Wechat/wechat_menu', $config);
		
		
		$this->load->language('wecome');
		if(!$this->user->hasPermission('access', 'admin/extension_config/overall/wechat_menu')){
			$this->session->set_flashdata('fali', '你没有访问权限！');
			redirect($this->config->item('admin'));
			exit;
		}
	}

	public function index()
	{
		$this->document->setTitle('微信公众号菜单设置');
		
		if($_SERVER['REQUEST_METHOD']=="POST" && $this->check_modify()){
			
			$menus=array();
			foreach($this->input->post()['menu']['button'] as $key=>$value){
				
			}
			var_dump($this->input->post()['menu']);
			//redirect($this->config->item('admin').'common/extension/overall');
			exit;
		}
		
		$data['action']=array(
				'click'						=>'点击事件',
				'view'						=>'跳转URL',
				'scancode_push'				=>'扫码推事件',
				'scancode_waitmsg'			=>'扫码推事件且弹出“消息接收中”提示框',
				'pic_sysphoto'				=>'弹出系统拍照发图',
				'pic_photo_or_album'		=>'弹出拍照或者相册发图',
				'pic_weixin'				=>'弹出微信相册发图器',
				'location_select'			=>'弹出地理位置选择器',
				'media_id'					=>'下发消息',
				'view_limited'				=>'跳转图文消息URL'
		);
		
		$data['menus'] = $this->wechat_menu->getMenu();
		
		$data['header']=$this->header->index();
		$data['top']=$this->header->top();
		$data['footer']=$this->footer->index();
		
		$this->load->view('theme/default/template/extension_config/overall/wechat_menu',$data);
	}
	
	public function check_modify(){
		if (!$this->user->hasPermission('modify', 'admin/extension_config/overall/wechat_menu')) {
			$this->session->set_flashdata('danger', '你无权修改，请联系管理员！');
			redirect($this->config->item('admin').'common/extension/overall');
			exit();
		}else {
			return true;
		}
	}
}
