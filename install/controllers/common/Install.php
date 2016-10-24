<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Install extends CI_Controller {
	
	private $error = array();
	
	public function __construct() {
		parent::__construct();
		$this->load->helper('utf8');
		$this->load->model('install_model');
	}

	public function index()
	{
		$this->lang->load('wecome', $_SESSION['language_name']);
		
		$this->document->setTitle(lang_line('title'));
		
		if (($_SERVER['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->install_model->database($this->input->post());
			$configs=array(
				FCPATH . 'catalog/config/config.php',
				FCPATH . 'admin/config/config.php',
				FCPATH . 'sale/config/config.php',
			);
			$databases=array(
				FCPATH . 'catalog/config/database.php',
				FCPATH . 'admin/config/database.php',
				FCPATH . 'sale/config/database.php',
			);
			$indexs=array(
				FCPATH . 'index.php',
				FCPATH . 'admin.php',
				FCPATH . 'sale.php',
				FCPATH . 'install.php',
			);
			foreach($configs as $config){
				$this->write_config($config);
			}
			
			foreach($databases as $database){
				$this->write_database($database, $this->input->post());
			}
			
			foreach($indexs as $index){
				$this->write_index($index);
			}
			
			$http_type = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';
			header("location: ".$http_type . $_SERVER['HTTP_HOST'].'index.php/common/install_success.html');
		}
		
		if(!empty($this->error)){
			foreach($this->error as $error){
				$this->session->set_flashdata('fali', $error);
			}
		}
		
		$data['header']=$this->header->index();
		$data['top']=$this->header->top();
		$data['footer']=$this->footer->index();
		
		$this->load->view('common/install',$data);
	}
	
	private function write_config($file_name){
		$url=substr(GetUrlToDomain(base_url()), 0, -1);
		$str=file_get_contents($file_name);
		$str= str_replace("openant.com", $url, $str);
		// w表示以写入的方式打开文件，如果文件不存在，系统会自动建立
		$file_pointer = fopen($file_name,"w");
		fwrite($file_pointer,$str);
		fclose($file_pointer);
	}
	
	private function write_index($file_name){
		$str=file_get_contents($file_name);
		$str= str_replace("install=TRUE", "install=FALSE", $str);
		// w表示以写入的方式打开文件，如果文件不存在，系统会自动建立
		$file_pointer = fopen($file_name,"w");
		fwrite($file_pointer,$str);
		fclose($file_pointer);
	}
	
	private function write_database($file_name, $data){
		$str=file_get_contents($file_name);
		$str= str_replace("openant.localhost", $data['hostname'], $str);
		$str= str_replace("openant.username", $data['username'], $str);
		$str= str_replace("openant.password", $data['passwd'], $str);
		$str= str_replace("openant.database", $data['dbname'], $str);
		$str= str_replace("openant.dbdriver", $data['db_driver'], $str);
		$str= str_replace("openant.dbprefix", '', $str);
		// w表示以写入的方式打开文件，如果文件不存在，系统会自动建立
		$file_pointer = fopen($file_name,"w");
		fwrite($file_pointer,$str);
		fclose($file_pointer);
	}
	
	private function validate() {
		if ($this->input->post('hostname') == NULL) {
			$this->error['hostname'] = '主机名空';
		}

		if ($this->input->post('username') == NULL) {
			$this->error['db_username'] = '数据库用户名空';
		}

		if ($this->input->post('dbname') == NULL) {
			$this->error['dbname'] = '数据库名空';
		}

		if ($this->input->post('prefix') == NULL && !preg_match('/[^a-z0-9_]/', $this->input->post('prefix'))) {
			//$this->error['prefix'] = '表前缀无效';
		}

		if ($this->input->post('db_driver')) {
			$config['hostname'] = $this->input->post('hostname');
			$config['username'] = $this->input->post('username');
			$config['password'] = $this->input->post('passwd');
			$config['database'] = $this->input->post('dbname');
			$config['dbdriver'] = $this->input->post('db_driver');
			$config['dbprefix'] = '';
			$config['pconnect'] = FALSE;
			$config['db_debug'] = TRUE;
			$config['cache_on'] = FALSE;
			$config['cachedir'] = '';
			$config['char_set'] = 'utf8';
			$config['dbcollat'] = 'utf8_general_ci';
			@$this->load->database($config);

			if (!empty($this->db->error()['message'])) {
				$this->error['warning'] = $this->db->error();
			} else {
				$this->db->close();
			}
		}	
		
		if ($this->input->post('apasswd') == NULL) {
			$this->error['apasswd'] = '密码不能为空';
		}

		if ((utf8_strlen($this->input->post('email')) > 96) || !filter_var($this->input->post('email'), FILTER_VALIDATE_EMAIL)) {
			$this->error['email'] = '邮件格式错误';
		}

		if (!is_writable(FCPATH . 'catalog/config/config.php')) {
			$this->error['warning'] = '没有写入权限' . FCPATH . 'catalog/config/config.php';
		}

		if (!is_writable(FCPATH . 'admin/config/config.php')) {
			$this->error['warning'] = '没有写入权限' . FCPATH . 'admin/config/config.php';
		}
		
		if (!is_writable(FCPATH . 'sale/config/config.php')) {
			$this->error['warning'] = '没有写入权限' . FCPATH . 'sale/config/config.php';
		}
		
		if (!is_writable(FCPATH . 'catalog/config/database.php')) {
			$this->error['warning'] = '没有写入权限' . FCPATH . 'catalog/config/database.php';
		}
		
		if (!is_writable(FCPATH . 'admin/config/database.php')) {
			$this->error['warning'] = '没有写入权限' . FCPATH . 'admin/config/database.php';
		}
		
		if (!is_writable(FCPATH . 'sale/config/database.php')) {
			$this->error['warning'] = '没有写入权限' . FCPATH . 'sale/config/database.php';
		}

		return !$this->error;
	}
}
