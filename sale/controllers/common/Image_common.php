<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Image_common extends CI_Common {
	public function __construct() {
		parent::__construct();
		$this->load->helper(array('utf8'));
		$this->load->library(array('image_lib', 'user_agent'));
	}
	
	public function resize($filename, $width, $height, $master_dim='h') {
		if(empty($width)){
			$width='100';
		}
		if(empty($height)){
			$height='100';
		}
		
		if($this->agent->is_mobile()){
			$quality=$this->config->get_config('output_compression_level') / 2;
			$device='-wap-';
			if($width > 640){
				$width = '640';
				$master_dim = 'w';
				$maintain_ratio=TRUE;
			}
		}else{
			$quality=$this->config->get_config('output_compression_level');
			$device='-pc-';
		}
		
		if (!is_file(IMGPATH . $filename)) {
			
			if (!is_dir(IMGPATH . '/cache/no_image')) {
				@mkdir(IMGPATH . '/cache/no_image', 0777);
			}
			
			$no_image						 = 'no_image-'.$width.'-'.$height.'-'.$master_dim.'.png';
			$config['source_image']			 = 'public/resources/default/image/no_image.jpg';
			$config['file_permissions'] 	 = '0777';
			$config['new_image'] 	 		 = IMGPATH .'/cache/no_image/'. $no_image;
			$config['width'] 	 		 	 = $width;
			$config['height'] 	 		 	 = $height;
			$config['maintain_ratio'] 	 	 = isset($maintain_ratio) ? $maintain_ratio : FALSE;
			$config['quality'] 	 	 		 = isset($quality) ? $quality : $this->config->get_config('output_compression_level');
			if($master_dim == 'w'){
				$config['master_dim']		 = 'width';
			}
			if($master_dim == 'h'){
				$config['master_dim']		 = 'height';
			}
			
			$this->image_lib->initialize($config);
			$this->image_lib->resize();
			return 'image/cache/no_image/'.$no_image;
		}

		$extension = pathinfo($filename, PATHINFO_EXTENSION);

		$old_image = $filename;
		$new_image = '/cache' . utf8_substr($filename, 0, utf8_strrpos($filename, '.')) . $device . $width . 'x' . $height . '.' . $extension;
		
		if (!is_file(IMGPATH . $new_image) || (filectime(IMGPATH . $old_image) > filectime(IMGPATH . $new_image))) {
			$path = '';

			$directories = explode('/', dirname(str_replace('../', '', $new_image)));

			foreach ($directories as $directory) {
				$path = $path . '/' . $directory;

				if (!is_dir(IMGPATH . $path)) {
					@mkdir(IMGPATH . $path, 0777);
				}
			}

			list($width_orig, $height_orig) = getimagesize(IMGPATH . $old_image);

			if ($width_orig != $width || $height_orig != $height) {
				
				$config['source_image']			 = IMGPATH . $old_image;
				$config['file_permissions'] 	 = '0777';
				$config['new_image'] 	 		 = IMGPATH .'/'. $new_image;
				$config['width'] 	 		 	 = $width;
				$config['height'] 	 		 	 = $height;
				$config['maintain_ratio'] 	 	 = isset($maintain_ratio) ? $maintain_ratio : FALSE;
				$config['quality'] 	 	 		 = isset($quality) ? $quality : $this->config->get_config('output_compression_level');
				if($master_dim == 'w'){
					$config['master_dim']		 = 'width';
				}
				if($master_dim == 'h'){
					$config['master_dim']		 = 'height';
				}
				
				$this->image_lib->initialize($config);
				$this->image_lib->resize();
				
			} else {
				copy(IMGPATH . $old_image, IMGPATH . $new_image);
			}
		}

		return base_url('image/') . $new_image;
	}
}