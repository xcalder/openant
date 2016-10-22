<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->language('wecome');
		$this->load->library('user_agent');
		$this->load->model(array('product/product_model', 'order/order_model', 'setting/my_tracks_model', 'common/language_model', 'order/user_balances_model'));
		$this->load->database();
	}

	public function index()
	{
		$this->document->setTitle('楚雄蚂蚁开源软件工作室openant');
		if($this->config->get_config('meta_keyword')){
			$this->document->setKeywords($this->config->get_config('meta_keyword'));
		}
		
		if($this->config->get_config('meta_description')){
			$this->document->setDescription($this->config->get_config('meta_description'));
		}
		
		$this->session->set_flashdata('success', '登陆成功！');
		$data['position_top']=$this->position_top->index();
		$data['position_left']=$this->position_left->index();
		$data['position_right']=$this->position_right->index();
		$data['position_bottom']=$this->position_bottom->index();
		
		$data['header']=$this->header->index();
		$data['top']=$this->header->login_top();
		$data['login_footer']=$this->footer->index();
		
		/*
		$dir_file = $_SERVER['SCRIPT_NAME'];
		$filename = basename($dir_file);
		echo $filename;
		*/
		//echo FCPATH;
		/*
		$qr_path=IMGPATH.'/cache/qrcode/';
		//echo $qr_path.'/cache/qrcode/';
		include BASEPATH.'third_party/phpqrcode.php'; 
		$value = all_current_url(); //二维码内容 
		//$errorCorrectionLevel = 'L';//容错级别   
		$errorCorrectionLevel = 'H';//容错级别   
		$matrixPointSize = 3;//生成图片大小   
		//生成二维码图片   
		QRcode::png($value, $qr_path.'qrcode.png', $errorCorrectionLevel, $matrixPointSize, 2);
		
		$logo=$this->config->get_config('site_image');
		if(empty($logo)){
			$logo=FCPATH.'public/resources/default/image/qr_logo.png';
		} 
		//$logo = $logo;//准备好的logo图片   
		$QR = $qr_path.'qrcode.png';//已经生成的原始二维码图   

		if ($logo !== FALSE) {
		    $QR = imagecreatefromstring(file_get_contents($QR));   
		    $logo = imagecreatefromstring(file_get_contents($logo));   
		    $QR_width = imagesx($QR);//二维码图片宽度   
		    $QR_height = imagesy($QR);//二维码图片高度   
		    $logo_width = imagesx($logo);//logo图片宽度   
		    $logo_height = imagesy($logo);//logo图片高度   
		    $logo_qr_width = $QR_width / 3.5;
		    $scale = $logo_width/$logo_qr_width;   
		    $logo_qr_height = $logo_height/$scale;   
		    $from_width = ($QR_width - $logo_qr_width) / 2;   
		    //重新组合图片并调整大小   
		    imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width,   
		    $logo_qr_height, $logo_width, $logo_height);   
		}
		//输出图片   
		imagepng($QR, $qr_path.'helloweixin.png');
		echo '<img src="image/cache/qrcode/helloweixin.png">';
		*/
		/*
		$this->load->common('qr_code');
		echo $this->qr_code->add_logo('123.jpg', base_url());
		
		var_dump($_SESSION);
		*/
		//$this->load->view('theme/default/template/user/signin',$data);
		//var_dump($this->agent->languages());
		//var_dump($this->language_model->get_language_like_locale($this->agent->languages()));
		$tp='F:\www\demo\lv\public\min';$cp='F:/www/demo/lv/';
		$subpath=str_replace('/min', '/',str_replace($cp, '', str_replace('\\', '/', $tp)));
		$jss = array('resources/default/js/jquery-1.12.0.min.js', 'resources/default/js/bootstrap.js', 'resources/default/js/jquery.validate/jquery.validate.js', 'resources/default/js/jquery.goup.min.js', 'resources/default/js/jquery.form.js', 'resources/default/js/bootstrap-notify.min.js', 'resources/default/js/nprogress/nprogress.js', 'resources/default/js/jquery.lazyload.js', 'summernote/summernote.min.js', 'resources/default/js/hammer/hammer.min.js', 'resources/default/js/hammer/jquery.hammer.js', 'nav/js/bootsnav.js', 'resources/default/js/base.js');
		foreach ($jss as $js){
			$js_s[]='//'.$subpath.$js;
		}
		
		$csss=array('resources/default/css/bootstrap.min.css', 'resources/default/css/bootstrap-responsive.min.css', 'summernote/summernote.css', 'resources/default/js/nprogress/nprogress.css', 'nav/css/bootsnav.css', 'nav/css/overwrite.css', 'nav/skins/color.css', 'resources/default/css/style.css');
		foreach ($csss as $css){
			$css_s[]='//'.$subpath.$css;
		}
		var_dump($css_s);
		echo '<br/><br/>';
		var_dump($js_s);
		//echo json_code($dd);
		$this->load->view('theme/default/template/test',$data);
	}
	
	function file_list($path)
	{
		if ($handle = opendir($path))//打开路径成功
		{
			while (false !== ($file = readdir($handle)))//循环读取目录中的文件名并赋值给$file
			{
				if ($file != "." && $file != "..")//排除当前路径和前一路径
				{
					if (is_dir($path."/".$file))
					{
						//                    echo $path.": ".$file."<br>";//去掉此行显示的是所有的非目录文件
						$this->file_list($path."/".$file);
					}
					else
					{
						echo $path."/".$file."<br>";
					}
				}
			}
		}
	}
	
}
