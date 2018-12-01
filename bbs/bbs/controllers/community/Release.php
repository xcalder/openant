<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Release extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->helper(array('date', 'utf8'));
	}

	public function index()
	{
		$this->load->model('bbs/bbs_model');
		
		if($this->input->get('posting_id') != NULL){
			$data['action']														=$this->config->item('bbs').'/community/release?posting_id='.$this->input->get('posting_id');
			$data['plate_id']													=$this->input->get('posting_id');
				
			$posting															=$this->bbs_model->get_posting_release($this->input->get('posting_id'));
				
		}else{
			$data['action']														=$this->config->item('bbs').'/community/release';
		}
		
		if($_SERVER['REQUEST_METHOD']=="POST" && $this->user->isLogged()){
			if(utf8_strlen(strip_tags($this->input->post('description'))) > 20 && utf8_strlen(strip_tags($this->input->post('description'))) < 20000){
				if($this->input->get('posting_id') != NULL){
					$data['base']['posting_id']=$this->input->get('posting_id');
					$data['base']['plate_id']=$this->input->post('plate_id');
					$data['base']['user_id']=$this->user->getID();
					$data['base']['date_added']=date("Y-m-d H:i:s");
					$data['description']['language_id']=$_SESSION['language_id'];
					$data['description']['posting_id']=$this->input->get('posting_id');
					$data['description']['title']=utf8_substr($this->input->post('title'), 0, 35);
					$data['description']['description']=$this->input->post('description');
					$re=$this->bbs_model->edit_posting($data);
					if($re){
						$this->session->set_flashdata('success', '帖子编辑成功！');
						redirect($this->config->item('bbs').'/community/posting?posting_id='.$this->input->get('posting_id'));
						exit();
					}else{
						$this->session->set_flashdata('fali', '帖子编辑失败！');
						redirect(all_current_url());
						exit();
					}
					
				}else{
					$data['base']['plate_id']=$this->input->post('plate_id');
					$data['base']['user_id']=$this->user->getID();
					$data['base']['ip']=$this->input->ip_address();
					$data['base']['agent']=$this->input->user_agent();
					$data['base']['is_view']='1';
					$data['base']['very_good']='0';
					$data['base']['date_added']=date("Y-m-d H:i:s");
					$data['description']['language_id']=$_SESSION['language_id'];
					$data['description']['title']=utf8_substr($this->input->post('title'), 0, 35);
					$data['description']['description']=$this->input->post('description');
					$re=$this->bbs_model->add_posting($data);
					if($re){
						$this->session->set_flashdata('success', '帖子发布成功！');
						redirect($this->config->item('bbs').'/community/posting?posting_id='.$re);
					}else{
						$this->session->set_flashdata('fali', '帖子发布失败！');
						redirect(all_current_url());
					}
				}
			}else{
				$this->session->set_flashdata('fali', '帖子内容20——20000字符之间！');
				$posting['posting_id'] 											= $this->input->get('posting_id');
				$posting['title'] 												= utf8_substr($this->input->post('title'), 0, 35);
				$posting['description'] 										= $this->input->post('description');
				$posting['plate_id']											= $this->input->post('plate_id');
			}
		}
		
		$data['plates']=$this->bbs_model->get_plates();
		
		if(isset($posting) && $posting){
			$this->lang->load('wecome', $_SESSION['language_name']);
		
			$this->document->setTitle($posting['title']);
			$data['posting']=$posting;
			
		}else{
			$this->lang->load('wecome', $_SESSION['language_name']);
		
			$this->document->setTitle('发帖');
		}
		
		$this->document->setCopyright(lang_line('meta_copyright'));
		
		$data['position_top']=$this->position_top->index();
		$data['position_left']=$this->position_left->index();
		$data['position_right']=$this->position_right->index();
		$data['position_bottom']=$this->position_bottom->index();
		
		$data['header']=$this->header->index();
		$data['top']=$this->header->top();
		$data['footer']=$this->footer->index();
		
		$this->load->view('theme/default/template/community/release',$data);
	}
	
}
