<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class QR_code extends CI_Common {
	public function __construct() {
		parent::__construct();
	}
	
	public function add_logo($filename, $text, $errorCorrectionLevel = 'H', $matrixPointSize = '3'){
		$qr_path=IMGPATH.'/cache/qrcode/'.$filename;
		if (!is_file($qr_path)) {
			if (!is_dir(IMGPATH . '/cache/qrcode')) {
				@mkdir(IMGPATH . '/cache/qrcode', 0777);
			}
			
			include BASEPATH.'third_party/phpqrcode.php';
			$value = $text; //二维码内容 
			//$errorCorrectionLevel = 'L';//容错级别   
			//$errorCorrectionLevel = 'H';//容错级别   
			//$matrixPointSize = 3;//生成图片大小   
			//生成二维码图片   
			QRcode::png($value, $qr_path, $errorCorrectionLevel, $matrixPointSize, 2);
			
			$logo=$this->config->get_config('site_image');
			if(empty($logo)){
				$logo=FCPATH.'public/resources/default/image/qr_logo.png';
			} 
			//$logo = $logo;//准备好的logo图片   
			$QR = $qr_path;//已经生成的原始二维码图   

			if ($logo !== FALSE) {
			    $QR = imagecreatefromstring(file_get_contents($QR));   
			    $logo = imagecreatefromstring(file_get_contents($logo));   
			    $QR_width = imagesx($QR);//二维码图片宽度   
			    $QR_height = imagesy($QR);//二维码图片高度   
			    $logo_width = imagesx($logo);//logo图片宽度   
			    $logo_height = imagesy($logo);//logo图片高度   
			    $logo_qr_width = $QR_width / 4;
			    $scale = $logo_width/$logo_qr_width;   
			    $logo_qr_height = $logo_height/$scale;   
			    $from_width = ($QR_width - $logo_qr_width) / 2;   
			    //重新组合图片并调整大小   
			    imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width,   
			    $logo_qr_height, $logo_width, $logo_height);   
			}
			//输出图片   
			imagepng($QR, $qr_path);
		}
		return 'image/cache/qrcode/'.$filename;
	}
}