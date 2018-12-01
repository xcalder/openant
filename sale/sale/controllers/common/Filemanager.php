<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FileManager extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->lang->load('common/filemanager', $_SESSION['language_name']);
		
		if(!$this->user->hasPermission('access', 'sale/common/filemanager')){
			$this->session->set_flashdata('fali', '你没有访问商家后台的权限！');
			redirect(base_url(), 'location', 301);
			exit;
		}
		
		$this->load->helper(array('utf8','string'));
		$user_added_date=$this->user->getDate_added();
		$user_directory=date("Y",strtotime($user_added_date)).'/'.date("m",strtotime($user_added_date)).'/'.date("d",strtotime($user_added_date)).'/'.$this->user->getId();
		
		if (!is_dir(IMGPATH . '/users/'.$user_directory)) {
			@mkdir(IMGPATH . '/users/'.$user_directory, 0777,true);
		}
		
	}
	
	public function index() {
		if ($this->input->get('filter_name')) {
			$filter_name = rtrim(str_replace(array('../', '..\\', '..', '*'), '', $this->input->get('filter_name')), '/');
		} else {
			$filter_name = null;
		}
		
		$user_added_date=$this->user->getDate_added();
		$user_directory=date("Y",strtotime($user_added_date)).'/'.date("m",strtotime($user_added_date)).'/'.date("d",strtotime($user_added_date)).'/'.$this->user->getId();
		

		// Make sure we have the correct directory
		if ($this->input->get('directory')) {
			
			$directory = rtrim(IMGPATH . '/users/'. $user_directory .'/'. str_replace(array('../', '..\\', '..'), '', $this->input->get('directory')), '/');
		} else {
			$directory = IMGPATH . '/users/'.$user_directory;
		}
		
		if ($this->input->get('page')) {
			$page = ceil($this->input->get('page') / 16); //ceil($page / 16)
		} else {
			$page = 1;
		}

		$data['images'] = array();

		// 获取目录
		$directories = glob($directory . '/' . $filter_name . '*', GLOB_ONLYDIR);

		if (!$directories) {
			$directories = array();
		}

		// 获取文件
		$files = glob($directory . '/' . $filter_name . '*.{jpg,jpeg,png,gif,JPG,JPEG,PNG,GIF}', GLOB_BRACE);

		if (!$files) {
			$files = array();
		}

		// 合并的目录和文件
		$images = array_merge($directories, $files);

		// 获取的文件和目录总数
		$image_total = count($images);

		// 拆分基于当前页码和每10页项目的最大数目的阵列
		$images = array_splice($images, ($page - 1) * 16, 16);

		foreach ($images as $image) {
			$name = str_split(basename($image), 14);

			if (is_dir($image)) {
				$url = '';

				if ($this->input->get('target')) {
					$url .= '&target=' . $this->input->get('target');
				}

				if ($this->input->get('thumb')) {
					$url .= '&thumb=' . $this->input->get('thumb');
				}
				
				$directory_name=explode('/', $image);
				
				$data['images'][] = array(
					'thumb' => '',
					'name'  => implode(' ', $name),
					'type'  => 'directory',
					'path'  => utf8_substr($image, utf8_strlen(IMGPATH)),
					'href'  => $this->config->item('sale').'/common/filemanager?directory=' . end($directory_name) . $url)
				;
			} elseif (is_file($image)) {
				// Find which protocol to use to pass the full image link back

				$data['images'][] = array(
					'thumb' => $this->image_common->resize(utf8_substr($image, utf8_strlen(IMGPATH)), 100, 100,'h'),
					'name'  => implode(' ', $name),
					'type'  => 'image',
					'path'  => utf8_substr($image, utf8_strlen(IMGPATH)),
					'href'  => 'resources/image'.utf8_substr($image, utf8_strlen(IMGPATH))
				);
			}
		}

		$data['token'] = $_SESSION['token'];

		if ($this->input->get('directory')) {
			$data['directory'] = urlencode($this->input->get('directory'));
			
		} else {
			$data['directory'] = isset($_SESSION['directory']) ? $_SESSION['directory'] : '';
		}

		if ($this->input->get('filter_name')) {
			$data['filter_name'] = $this->input->get('filter_name');
		} else {
			$data['filter_name'] = '';
		}

		// Return the target ID for the file manager to set the value
		if ($this->input->get('target')) {
			$data['target'] = $this->input->get('target');
		} else {
			$data['target'] = '';
		}

		// Return the thumbnail for the file manager to show a thumbnail
		if ($this->input->get('thumb')) {
			$data['thumb'] = $this->input->get('thumb');
		} else {
			$data['thumb'] = '';
		}

		// Parent
		$url = '';

		if ($this->input->get('directory')) {
			$pos = strrpos($this->input->get('directory'), '/');

			if ($pos) {
				$url .= '&directory=' . urlencode(substr($this->input->get('directory'), 0, $pos));
			}
		}

		if ($this->input->get('target')) {
			$url .= '&target=' . $this->input->get('target');
		}

		if ($this->input->get('thumb')) {
			$url .= '&thumb=' . $this->input->get('thumb');
		}

		$data['parent'] = $this->config->item('sale').'common/filemanager?token=' . $_SESSION['token'] . $url;

		// Refresh
		$url = '';

		if ($this->input->get('directory')) {
			
			$url .= '&directory=' . urlencode($this->input->get('directory'));
		}

		if ($this->input->get('target')) {
			$url .= '&target=' . $this->input->get('target');
		}

		if ($this->input->get('thumb')) {
			$url .= '&thumb=' . $this->input->get('thumb');
		}

		$data['refresh'] = $this->config->item('sale').'/common/filemanager?token=' . $_SESSION['token'] . $url;

		$url = '';

		if ($this->input->get('directory')) {
			
			$url .= '&directory=' . urlencode(html_entity_decode($this->input->get('directory'), ENT_QUOTES, 'UTF-8'));
		}

		if ($this->input->get('filter_name')) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->input->get('filter_name'), ENT_QUOTES, 'UTF-8'));
		}

		if ($this->input->get('target')) {
			$url .= '&target=' . $this->input->get('target');
		}

		if ($this->input->get('thumb')) {
			$url .= '&thumb=' . $this->input->get('thumb');
		}
		
		$config['base_url'] 					= $this->config->item('sale').'common/filemanager?token='.$_SESSION['token'].$url;
		$config['page_query_string']			= TRUE;
		$config['query_string_segment']			= 'page';
		//样式
		$config['full_tag_open'] 				= '<td colspan="2"><nav class="text-left" style="float:left"><ul class="pagination">';
		$config['full_tag_close'] 				= '</ul></nav></td><td colspan="2"><nav><ul class="pagination navbar-right"><li><a>共' . $image_total .'张图片</a></li></ul></nav></td>';
		$config['first_tag_open'] 				= '<li>';
		$config['first_tag_close'] 				= '</li>';
		$config['last_tag_open'] 				= '<li>';
		$config['last_tag_close'] 				= '</li>';
		$config['next_tag_open'] 				= '<li>';
		$config['next_tag_close'] 				= '</li>';
		$config['prev_tag_open'] 				= '<li>';
		$config['prev_tag_close'] 				= '</li>';
		$config['cur_tag_open'] 				= '<li class="active"><a>';
		$config['cur_tag_close'] 				= '</a></li>';
		$config['num_tag_open']					= '<li>';
		$config['num_tag_close']				= '</li>';
		$config['first_link'] 					= '<<';
		$config['last_link'] 					= '>>';
		//样式
		$config['total_rows'] 					= $image_total;
		$config['per_page'] 					= 16;

		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();

		$this->load->view('theme/default/template/common/filemanager',$data);
	}

	public function upload() {
		
		$json = array();

		// Check user has permission
		if (!$this->user->hasPermission('modify', 'sale/common/filemanager')) {
			$json['error'] = '没有修改权限';
		}

		$user_added_date=$this->user->getDate_added();
		$user_directory=date("Y",strtotime($user_added_date)).'/'.date("m",strtotime($user_added_date)).'/'.date("d",strtotime($user_added_date)).'/'.$this->user->getId();

		// Make sure we have the correct directory
		if ($this->input->get('directory')) {
			
			$directory = rtrim(IMGPATH . '/users/' . $user_directory . '/' . str_replace(array('../', '..\\', '..'), '', $this->input->get('directory')), '/');
		} else {
			$directory = IMGPATH . '/users/' . $user_directory;
		}

		// Check its a directory
		if (!is_dir($directory)) {
			$json['error'] = $this->lang->line('error_directory');
		}

		if (!$json) {
			if (isset($_FILES['file']['name']) && is_file($_FILES['file']['tmp_name'])) {
				// Sanitize the filename
				$filename = basename(html_entity_decode($_FILES['file']['name'], ENT_QUOTES, 'UTF-8'));

				// Validate the filename length
				/*
				if ((utf8_strlen($filename) < 3) || (utf8_strlen($filename) > 255)) {
					$json['error'] = $this->language->get('error_filename');
				}
				*/

				// Allowed file extension types
				$allowed = array(
					'jpg',
					'jpeg',
					'gif',
					'png'
				);

				if (!in_array(utf8_strtolower(utf8_substr(strrchr($filename, '.'), 1)), $allowed)) {
					$json['error'] = $this->lang->line('error_filetype');
				}

				// Allowed file mime types
				$allowed = array(
					'image/jpeg',
					'image/pjpeg',
					'image/png',
					'image/x-png',
					'image/gif'
				);

				if (!in_array($_FILES['file']['type'], $allowed)) {
					$json['error'] = $this->lang->line('error_filetype');
				}

				// Check to see if any PHP files are trying to be uploaded
				$content = file_get_contents($_FILES['file']['tmp_name']);

				if (preg_match('/\<\?php/i', $content)) {
					$json['error'] = $this->lang->line('error_filetype');
				}

				// Return any upload error
				if ($_FILES['file']['error'] != UPLOAD_ERR_OK) {
					$json['error'] = $this->lang->line('error_upload_') . $_FILES['file']['error'];
				}
			} else {
				$json['error'] = $this->lang->line('error_upload');
			}
		}

		if (!$json) {
			$filename = date("Ymdhms").random_string('alnum', 10).'.'.pathinfo($filename)['extension'];
			move_uploaded_file($_FILES['file']['tmp_name'], $directory . '/' . $filename);

			$json['success'] = $this->lang->line('text_uploaded');
		}

		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($json));
	}

	public function folder() {
		$json = array();

		// Check user has permission
		if (!$this->user->hasPermission('modify', 'sale/common/filemanager')) {
			$json['error'] = '没有修改权限';
		}
		
		$user_added_date=$this->user->getDate_added();
		$user_directory=date("Y",strtotime($user_added_date)).'/'.date("m",strtotime($user_added_date)).'/'.date("d",strtotime($user_added_date)).'/'.$this->user->getId();

		// Make sure we have the correct directory
		if ($this->input->get('directory')) {
			$directory = rtrim(IMGPATH . '/users/' . $user_directory . '/' . str_replace(array('../', '..\\', '..'), '', $this->input->get('directory')), '/');
		} else {
			$directory = IMGPATH . '/users/'.$user_directory;
		}

		// Check its a directory
		if (!is_dir($directory)) {
			$json['error'] = $this->lang->line('error_directory');
		}

		if (!$json) {
			// Sanitize the folder name
			$folder = str_replace(array('../', '..\\', '..'), '', basename(html_entity_decode($this->input->post('folder'), ENT_QUOTES, 'UTF-8')));

			// Validate the filename length
			if ((utf8_strlen($folder) < 2) || (utf8_strlen($folder) > 128)) {
				$json['error'] = $this->lang->line('error_folder');
			}

			// 检查目录已经存在或不
			if (is_dir($directory . '/' . $folder)) {
				$json['error'] = $this->lang->line('error_exists');
			}
			
			if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
			    if (preg_match("/[\x7f-\xff]/", $folder)) {
				  $json['error'] = 'windows 服务器文件名不能包含中文！';
				 } 
			}
		}

		if (!$json) {
			mkdir($directory . '/' . $folder, 0777);

			$json['success'] = $this->lang->line('text_directory');
		}

		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($json));
	}

	public function delete() {
		$json = array();

		// Check user has permission
		
		if (!$this->user->hasPermission('modify', 'sale/common/filemanager')) {
			$json['error'] = '没有修改权限';
		}
		

		if ($this->input->post('path')) {
			$paths = $this->input->post('path');
		} else {
			$paths = array();
		}

		// Loop through each path to run validations
		foreach ($paths as $path) {
			$path = rtrim(IMGPATH .'/'. str_replace(array('../', '..\\', '..'), '', $path), '/');

			// 检查路径存在
			if ($path == IMGPATH . '/users') {
				$json['error'] = $this->lang->line('error_delete');

				break;
			}
		}

		if (!$json) {
			// Loop through each path
			foreach ($paths as $path) {
				$path = rtrim(IMGPATH . '/' . str_replace(array('../', '..\\', '..'), '', $path), '/');

				// If path is just a file delete it
				if (is_file($path)) {
					unlink($path);

				// If path is a directory beging deleting each file and sub folder
				} elseif (is_dir($path)) {
					$files = array();

					// Make path into an array
					$path = array($path . '*');

					// While the path array is still populated keep looping through
					while (count($path) != 0) {
						$next = array_shift($path);

						foreach (glob($next) as $file) {
							// If directory add to path array
							if (is_dir($file)) {
								$path[] = $file . '/*';
							}

							// Add the file to the files to be deleted array
							$files[] = $file;
						}
					}

					// Reverse sort the file array
					rsort($files);

					foreach ($files as $file) {
						// If file just delete
						if (is_file($file)) {
							unlink($file);

						// If directory use the remove directory function
						} elseif (is_dir($file)) {
							rmdir($file);
						}
					}
				}
			}

			$json['success'] = $this->lang->line('text_delete');
		}

		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($json));
	}
}