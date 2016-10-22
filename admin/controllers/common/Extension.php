<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Extension extends MY_Controller{
	private $error = array ();
	public function __construct(){
		parent::__construct ();
		$this->load->helper ( array ('utf8', 'directory'));
		$this->load->language ( 'wecome' );
		
		if(!$this->user->hasPermission('access', 'admin/common/extension')){
			$this->session->set_flashdata('fali', '你没有访问权限！');
			redirect(site_url(), 'location', 301);
			exit;
		}
		
		$this->load->library ( array ('form_validation'));
		$this->load->model ( array ('common/extension_model'));
	}
	public function install_module(){
		$this->document->setTitle ( '扩展模块安装' );
		
		if($this->check_modify() && $this->input->get ( 'extension' )){
			$data ['code'] = $this->input->get ( 'extension' );
			$data ['type'] = 'module';
			$this->extension_model->install ( $data );
			$this->session->set_flashdata ( 'success', '成功：模块安装成功！' );
			redirect ( site_url ( 'common/extension/module' ), 'location', 301 );
		}
		
		$this->get_list ( 'module' );
	}
	public function install_payment(){
		$this->document->setTitle ( '支付模块安装' );
		
		if($this->check_modify() && $this->input->get ( 'extension' )){
			$data ['code'] = $this->input->get ( 'extension' );
			$data ['type'] = 'payment';
			$this->extension_model->install ( $data );
			$this->session->set_flashdata ( 'success', '成功：支付扩展安装成功！' );
			redirect ( site_url ( 'common/extension/payment' ), 'location', 301 );
		}
		
		$this->get_list ( 'payment' );
	}
	
	// 配送
	public function install_delivery(){
		$this->document->setTitle ( '配送模块安装' );
		
		if($this->check_modify() && $this->input->get ( 'extension' )){
			$data ['code'] = $this->input->get ( 'extension' );
			$data ['type'] = 'delivery';
			$this->extension_model->install ( $data );
			$this->session->set_flashdata ( 'success', '成功：配送模块安装成功！' );
			redirect ( site_url ( 'common/extension/delivery' ), 'location', 301 );
		}
		
		$this->get_list ( 'delivery' );
	}
	
	// 全局
	public function install_overall(){
		$this->document->setTitle ( '全局模块安装' );
		
		if($this->check_modify() && $this->input->get ( 'extension' )){
			$data ['code'] = $this->input->get ( 'extension' );
			$data ['type'] = 'overall';
			$this->extension_model->install ( $data );
			$this->session->set_flashdata ( 'success', '成功：全局模块安装成功！' );
			redirect ( site_url ( 'common/extension/overall' ), 'location', 301 );
		}
		
		$this->get_list ( 'overall' );
	}
	
	// 第三方登陆
	public function install_sign_in_with(){
		$this->document->setTitle ( '第三方登陆安装' );
		
		if($this->check_modify() && $this->input->get ( 'extension' )){
			$data ['code'] = $this->input->get ( 'extension' );
			$data ['type'] = 'sign_in_with';
			$this->extension_model->install ( $data );
			$this->session->set_flashdata ( 'success', '成功：第三方登陆模块安装成功！' );
			redirect ( site_url ( 'common/extension/sign_in_with' ), 'location', 301 );
		}
		
		$this->get_list ( 'sign_in_with' );
	}
	public function uninstall_module(){
		$this->document->setTitle ( '扩展模块卸载' );
		
		if($this->check_modify() && $this->input->get ( 'extension' )){
			$data ['code'] = $this->input->get ( 'extension' );
			$data ['type'] = 'module';
			$this->extension_model->uninstall ( $data );
			$this->session->set_flashdata ( 'success', '成功：module卸载成功！' );
			redirect ( site_url ( 'common/extension/module' ), 'location', 301 );
		}
		
		$this->get_list ( 'module' );
	}
	
	// 第三方登陆
	public function uninstall_sign_in_with(){
		$this->document->setTitle ( '第三方登陆卸载' );
		
		if($this->check_modify() && $this->input->get ( 'extension' )){
			$data ['code'] = $this->input->get ( 'extension' );
			$data ['type'] = 'sign_in_with';
			$this->extension_model->uninstall ( $data );
			$this->session->set_flashdata ( 'success', '成功：第三方登陆模块卸载成功！' );
			redirect ( site_url ( 'common/extension/sign_in_with' ), 'location', 301 );
		}
		
		$this->get_list ( 'sign_in_with' );
	}
	
	// 全局
	public function uninstall_overall(){
		$this->document->setTitle ( '全局模块卸载' );
		
		if($this->check_modify() && $this->input->get ( 'extension' )){
			$data ['code'] = $this->input->get ( 'extension' );
			$data ['type'] = 'overall';
			$this->extension_model->uninstall ( $data );
			$this->session->set_flashdata ( 'success', '成功：全局模块卸载成功！' );
			redirect ( site_url ( 'common/extension/overall' ), 'location', 301 );
		}
		
		$this->get_list ( 'overall' );
	}
	
	// 配送
	public function uninstall_delivery(){
		$this->document->setTitle ( '配送模块卸载' );
		
		if($this->check_modify() && $this->input->get ( 'extension' )){
			$data ['code'] = $this->input->get ( 'extension' );
			$data ['type'] = 'delivery';
			$this->extension_model->uninstall ( $data );
			$this->session->set_flashdata ( 'success', '成功：配送模块卸载成功！' );
			redirect ( site_url ( 'common/extension/delivery' ) , 'location', 301 );
		}
		
		$this->get_list ( 'delivery' );
	}
	public function uninstall_payment(){
		$this->document->setTitle ( '支付模块卸载' );
		
		if($this->check_modify() && $this->input->get ( 'extension' )){
			$data ['code'] = $this->input->get ( 'extension' );
			$data ['type'] = 'payment';
			$this->extension_model->uninstall ( $data );
			$this->session->set_flashdata ( 'success', '成功：支付模块卸载成功！' );
			redirect ( site_url ( 'common/extension/payment' ), 'location', 301 );
		}
		
		$this->get_list ( 'module' );
	}
	public function module(){
		$this->document->setTitle ( '模块扩展' );
		
		$this->get_list ( 'module' );
	}
	
	// 第三方登陆
	public function sign_in_with(){
		$this->document->setTitle ( '第三方登陆' );
		
		$this->get_list ( 'sign_in_with' );
	}
	
	// 整体
	public function overall(){
		$this->document->setTitle ( '全局模块' );
		
		$this->get_list ( 'overall' );
	}
	
	// 配送
	public function delivery(){
		$this->document->setTitle ( '配送管理' );
		
		$this->get_list ( 'delivery' );
	}
	public function payment(){
		$this->document->setTitle ( '支付管理' );
		
		$this->get_list ( 'payment' );
	}
	public function get_list($type = ''){
		$maps = directory_map ( './admin/controllers/extension_config/' . $type . '/', 1 );
		if(! empty ( $maps )){
			$maps = $this->change_array ( $maps );
			
			foreach( $maps as $key => $value ){
				if(! strpos ( $maps [$key], '.php' ) !== false){
					// 排除非php文件
					unset ( $maps [$key] );
				} else{
					// 去掉文件后缀
					$maps [$key] = str_replace ( '.php', '', $maps [$key] );
				}
			}
		}
		
		// 已安装的插件
		$installed_extension = $this->extension_model->get_extensions ( $type );
		$extensions = array ();
		if(! empty ( $maps )){
			foreach( $maps as $key => $value ){
				// 装载语言
				$this->lang->load ( 'extension/' . $type . '/' . $maps [$key].'_module', $_SESSION['language_name']);
				$extensions [$key] ['name'] = $this->lang->line ( 'heading_title' );
				$extensions [$key] ['code'] = $maps [$key];
				// 插件设置
				$extensions [$key] ['action'] = strtolower(site_url ( 'extension_config/' . $type . '/' . str_replace('_module', '', $maps [$key])));
				
				if(is_array ( $installed_extension )){
					foreach( $installed_extension as $k => $v ){
						if(in_array ( $maps [$key], $installed_extension [$k] )){
							$extensions [$key] ['installed'] = TRUE;
							$extensions [$key] ['extension_id'] = $installed_extension [$k] ['extension_id'];
						}
					}
				}
			}
		}
		
		$data ['extensions'] = $extensions;
		
		$data ['install_action'] = site_url ( 'common/extension/install_' . $type );
		$data ['uninstall_action'] = site_url ( 'common/extension/uninstall_' . $type );
		
		$data ['header'] = $this->header->index ();
		$data ['top'] = $this->header->top ();
		$data ['footer'] = $this->footer->index ();
		
		$this->load->view ( 'theme/default/template/common/extension', $data );
	}
	
	//
	private function change_array($data = array()){
		$arr = array ();
		foreach( $data as $key => $val ){
			if(is_array ( $val )){
				foreach( $val as $k => $v ){
					if(is_array ( $v )){
						$this->change_array ( $v );
					} else{
						$arr [] = str_replace ( '\\', '/', $key . strtolower ( $v ) );
					}
				}
			} else{
				if(is_numeric ( $key )){
					if(isset ( $val ) && ! empty ( $val )){
						$arr [] = str_replace ( '\\', '/', strtolower ( $val ) );
					}
				} else{
					$arr [] = str_replace ( '\\', '/', $key . '/' . strtolower ( $val ) );
				}
			}
		}
		return $arr;
	}
	
	public function check_modify(){
		if (!$this->user->hasPermission('modify', 'admin/common/extension')) {
			$this->session->set_flashdata('danger', '你无权修改，请联系管理员！');
			redirect(site_url('common/extension/module'));
			exit();
		}else{
			return TRUE;
		}
	}
}
