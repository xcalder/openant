<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {
	private $error = array();
	
	public function __construct() {
		parent::__construct();
		$this->load->helper(array('string'));
		$this->load->language('wecome');
		$this->load->library(array('form_validation', 'currency'));
		$this->load->model(array('common/user_model', 'common/user_class_model', 'localisation/address_model','localisation/location_model', 'common/competence_model'));
	}
	
	public function index()
	{
		$this->document->setTitle('会员列表');
		
		$this->get_list();
	}
	
	public function edit()
	{
		$this->document->setTitle('编辑会员');
		
		if($_SERVER['REQUEST_METHOD']=="POST" && $this->input->get('user_id')){
			$user = $this->input->post('user');
			if($this->validation_user($user)){
				$user['user_id']=$this->input->get('user_id');
			
				$this->user_model->edit_user($user);
			}
			
			$address=$this->input->post('address');
			if($this->validation_address($address)){
				$this->user_model->edit_address($address, $this->input->get('user_id'));
			}
			
			$this->user_model->edit_user_competence($this->input->post('competence'), $this->input->get('user_id'));
			
			redirect(site_url('user/user'), 'location', 301);
		}
		
		$this->get_from();
	}

	private function get_list()
	{
		$this->document->addStyle('public/resources/default/js/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css');
		$this->document->addScript('public/resources/default/js/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js');
		$data=array();
		
		if($this->input->get()){
			if($this->input->get('nickname') != NULL){
				if($this->form_validation->no_special($this->input->get('nickname'))){
					$data['nickname']=$this->input->get('nickname');
				}else{
					$this->error['nickname']='昵称不能有特殊字符！';
				}
			}
			if($this->input->get('user_group_id') != NULL){
				if($this->form_validation->integer($this->input->get('user_group_id'))){
					$data['user_group_id']=$this->input->get('user_group_id');
				}else{
					$this->error['user_group_id']='用户组不对';
				}
			}
			if($this->input->get('approved') != NULL){
				if($this->form_validation->in_list($this->input->get('approved'),'0,1')){
					$data['approved']=$this->input->get('approved');
				}else{
					$this->error['approved']='approved不对';
				}
				
			}
			if($this->input->get('date_added') != NULL){
				if($this->form_validation->no_y_m_d($this->input->get('date_added'))){
					$data['date_added']=$this->input->get('date_added');
				}else{
					$this->error['date_added']='日期格式不正确';
				}
			}
			if($this->input->get('email') != NULL){
				if($this->form_validation->valid_email($this->input->get('email'))){
					$data['email']=$this->input->get('email');
				}else{
					$this->error['email']='邮箱格式不正确';
				}
			}
			if($this->input->get('status') != NULL){
				if($this->form_validation->in_list($this->input->get('status'),'0,1')){
					$data['status']=$this->input->get('status');
				}else{
					$this->error['status']='状态不正确';
				}
			}
			if($this->input->get('ip') != NULL){
				if($this->form_validation->valid_ip($this->input->get('ip'))){
					$data['ip']=$this->input->get('ip');
				}else{
					$this->error['ip']='ip格式不正确';
				}
			}
		}
		
		if($this->input->get('page')){
			$data['page']				=$this->input->get('page');
		}else{
			$data['page']				='0';
		}
		
		
		$users							= $this->user_model->get_users($data);
		$data['users']					= $users['users'];
		
		//分页
		$config['base_url'] 			= site_url('user/user');
		$config['num_links'] 			= 2;
		$config['page_query_string'] 	= TRUE;
		$config['query_string_segment'] = 'page';
		$config['full_tag_open'] 		= '<div class="text-left pagination" style="float: left;padding: 6px 0px;margin: 5px 0">共'.@(floor($users['count'] / $this->config->get_config ( 'config_limit_admin' )) + 1) .'页/第'.@(floor($data['page'] / $this->config->get_config ( 'config_limit_admin' )) + 1) .'页</div><ul class="pagination" style="float: right;margin: 5px 0">';
		$config['full_tag_close'] 		= '</ul>';
		$config['first_tag_open'] 		= '<li>';
		$config['first_tag_close'] 		= '</li>';
		$config['last_tag_open'] 		= '<li>';
		$config['last_tag_close'] 		= '</li>';
		$config['next_tag_open'] 		= '<li>';
		$config['next_tag_close'] 		= '</li>';
		$config['prev_tag_open'] 		= '<li>';
		$config['prev_tag_close'] 		= '</li>';
		$config['cur_tag_open'] 		= '<li class="active"><a>';
		$config['cur_tag_close'] 		= '</a></li>';
		$config['num_tag_open']			= '<li>';
		$config['num_tag_close']		= '</li>';
		$config['first_link'] 			= '<<';
		$config['last_link'] 			= '>>';
		$config['total_rows'] 			= $users['count'];
		$config['per_page'] 			= $this->config->get_config('config_limit_admin');

		$this->pagination->initialize($config);

		$data['pagination'] 			= $this->pagination->create_links();
		
		$data['action']					= site_url('user/user');
		
		$data['user_groups']			= $this->user_model->get_user_groups()['user_groups'];
		
		$data['header']=$this->header->index();
		$data['top']=$this->header->top();
		$data['footer']=$this->footer->index();
		$data['error']=$this->error;
		
		$this->load->view('theme/default/template/user/user_list',$data);
	}
	
	private function get_from()
	{
		//取权限表
		$data['competences']			=$this->competence_model->get_competences_for_user();
		
		
		$data['user_competences']		=$this->user_model->get_user_competence($this->input->get('user_id'));
		
		if($this->input->post('address') != NULL){
			$data['post_address']			=$this->input->post('address');
		}
		
		$user_info						=$this->user_model->get_user($this->input->get('user_id'));
		$addresss_info					=$this->address_model->get_addresss($this->input->get('user_id'));
		$data['addresss']				=$addresss_info;
		if($data['addresss']){
			$address_id					=array_flip(array_flip(array_column($data['addresss'],'address_id')));
			$max						=array_search(max($address_id), $address_id);
			$data['max_address_id']		=$address_id[$max] + 1;
			unset($max);
		}else{
			$data['max_address_id']		='1';
		}
		
		$data['user_groups']			= $this->user_model->get_user_groups()['user_groups'];
		$data['user_classs']			= $this->user_class_model->get_user_classs_to_setting();
		$data['countrys']				=$this->location_model->get_countrys();
		$user_history_info				=$this->get_user_historys('in');
		if($user_history_info){
			$data['user_historys']			=$user_history_info['user_historys'];
			$data['history_pagination']		=$user_history_info['pagination'];
		}
		
		$user_transactions				=$this->get_user_transactions('in');
		if($user_transactions){
			$data['user_transactions']	=$user_transactions['user_transactions'];
			$total_amount				=array_column($user_transactions['user_transactions'],'amount');
			$data['total_amount']		=array_sum($total_amount);
			$data['transactions_pagination']		=$user_transactions['pagination'];
		}
		
		$user_rewards					=$this->get_user_rewards('in');
		if($user_rewards){
			$data['user_rewards']		=$user_rewards['user_rewards'];
			$total_reward				=array_column($user_rewards['user_rewards'],'points');
			$data['total_rewards']		=array_sum($total_reward);
			$data['rewards_pagination']	=$user_rewards['pagination'];
		}
		
		$data['placeholder_image']		='public/resources/default/image/no_image.jpg';
		if($this->input->post('user')['image']){
			$data['image']				=$this->image_common->resize($this->input->post('user')['image'],100,100,'h');
			$data['image_old']			=$this->input->post('user')['image'];
		}elseif(isset($user_info['image'])){
			$data['image']				=$this->image_common->resize($user_info['image'],100,100,'h');
			$data['image_old']			=$user_info['image'];
		}else{
			$data['image']				='public/resources/default/image/no_image.jpg';
			$data['image_old']			='';
		}
		
		$users=$this->input->post('user');
		if(isset($users['user_group_id'])){
			$data['user_group_id']=$users['user_group_id'];
		}elseif(isset($user_info['user_group_id'])){
			$data['user_group_id']=$user_info['user_group_id'];
		}else{
			$data['user_group_id']='';
		}
		if(isset($users['user_class_id'])){
			$data['user_class_id']=$users['user_class_id'];
		}elseif(isset($user_info['user_class_id'])){
			$data['user_class_id']=$user_info['user_class_id'];
		}else{
			$data['user_class_id']='';
		}
		if(isset($users['nickname'])){
			$data['nickname']=$users['nickname'];
		}elseif(isset($user_info['nickname'])){
			$data['nickname']=$user_info['nickname'];
		}else{
			$data['nickname']='';
		}
		if(isset($users['firstname'])){
			$data['firstname']=$users['firstname'];
		}elseif(isset($user_info['firstname'])){
			$data['firstname']=$user_info['firstname'];
		}else{
			$data['firstname']='';
		}
		if(isset($users['lastname'])){
			$data['lastname']=$users['lastname'];
		}elseif(isset($user_info['lastname'])){
			$data['lastname']=$user_info['lastname'];
		}else{
			$data['lastname']='';
		}
		if(isset($users['email'])){
			$data['email']=$users['email'];
		}elseif(isset($user_info['email'])){
			$data['email']=$user_info['email'];
		}else{
			$data['email']='';
		}
		if(isset($users['telephone'])){
			$data['telephone']=$users['telephone'];
		}elseif(isset($user_info['telephone'])){
			$data['telephone']=$user_info['telephone'];
		}else{
			$data['telephone']='';
		}
		if(isset($users['newsletter'])){
			$data['newsletter']=$users['newsletter'];
		}elseif(isset($user_info['newsletter'])){
			$data['newsletter']=$user_info['newsletter'];
		}else{
			$data['newsletter']='';
		}
		if(isset($users['status'])){
			$data['status']=$users['status'];
		}elseif(isset($user_info['status'])){
			$data['status']=$user_info['status'];
		}else{
			$data['status']='';
		}
		if(isset($users['approved'])){
			$data['approved']=$users['approved'];
		}elseif(isset($user_info['approved'])){
			$data['approved']=$user_info['approved'];
		}else{
			$data['approved']='';
		}
		if(isset($users['safe'])){
			$data['safe']=$users['safe'];
		}elseif(isset($user_info['safe'])){
			$data['safe']=$user_info['safe'];
		}else{
			$data['safe']='';
		}
		if(isset($users['password'])){
			$data['password']=$users['password'];
		}else{
			$data['telephone']='';
		}
		
		
		$data['header']=$this->header->index();
		$data['top']=$this->header->top();
		$data['footer']=$this->footer->index();
		$data['error']=$this->error;
		
		if($this->input->get('user_id')){
			$data['action']=site_url('user/user/edit?user_id=').$this->input->get('user_id');
		}else{
			$data['action']=site_url('user/user/add');
		}
		
		if($this->input->get('user_id')){
			$data['user_id']=$this->input->get('user_id');
		}else{
			$data['user_id']='';
		}
		
		//error
		if(isset($this->error['error_nickname'])){
			$data['error_nickname']=$this->error['error_nickname'];
		}else{
			$data['error_nickname']='';
		}
		if(isset($this->error['error_firstname'])){
			$data['error_firstname']=$this->error['error_firstname'];
		}else{
			$data['error_firstname']='';
		}
		if(isset($this->error['error_email'])){
			$data['error_email']=$this->error['error_email'];
		}else{
			$data['error_email']='';
		}
		if(isset($this->error['address'])){
			$data['error_address']=$this->error['address'];
		}

		$this->load->view('theme/default/template/user/user_from',$data);
	}
	
	//调用户历史
	public function get_user_historys($in=''){
		if($this->input->get('user_id')){
			
			if($this->input->get('page')){
				$data['page']=$this->input->get('page');
			}else{
				$data['page']='0';
			}
			$data['user_id']=$this->input->get('user_id');
			
			$user_historys=$this->user_model->get_user_historys($data);
			if(!$user_historys){
				return FALSE;
			}
			
			$count=$user_historys['count'];
			
			$data=array();
			if($user_historys){
				$data['user_historys']=$user_historys['historys'];
			}
			
			//分页
			
			$config['base_url'] 			= site_url('user/user/get_user_historys?user_id=').$this->input->get('user_id');
			$config['num_links'] 			= 2;
			$config['page_query_string'] 	= TRUE;
			$config['query_string_segment'] = 'page';
			$config['full_tag_open'] 		= '<div class="text-left pagination" style="float: left;padding: 6px 0px;margin: 5px 0">共'.@(floor($count / $this->config->get_config ( 'config_limit_admin' )) + 1) .'页/第'.@(floor($data['page'] / $this->config->get_config ( 'config_limit_admin' )) + 1) .'页</div><ul class="pagination" style="float: right;margin: 5px 0">';
			$config['full_tag_close'] 		= '</ul>';
			$config['first_tag_open'] 		= '<li>';
			$config['first_tag_close'] 		= '</li>';
			$config['last_tag_open'] 		= '<li>';
			$config['last_tag_close'] 		= '</li>';
			$config['next_tag_open'] 		= '<li>';
			$config['next_tag_close'] 		= '</li>';
			$config['prev_tag_open'] 		= '<li>';
			$config['prev_tag_close'] 		= '</li>';
			$config['cur_tag_open'] 		= '<li class="active"><a>';
			$config['cur_tag_close'] 		= '</a></li>';
			$config['num_tag_open']			= '<li>';
			$config['num_tag_close']		= '</li>';
			$config['first_link'] 			= '<<';
			$config['last_link'] 			= '>>';
			$config['total_rows'] 			= $count;
			$config['per_page'] 			= $this->config->get_config('config_limit_admin');

			$this->pagination->initialize($config);

			$data['pagination'] 			=$this->pagination->create_links();
			
			if(empty($in)){
				$html=$this->load->view('theme/default/template/user/add_history', $data, TRUE);
				$this->output
				    ->set_content_type('application/html')
				    ->set_output($html);
				return;
			}else{
				return $data;
			}
		}
		return FALSE;
	}
	
	//调用户交易
	public function get_user_transactions($in=''){
		if($this->input->get('user_id')){
			if($this->input->get('page')){
				$data['page']=$this->input->get('page');
			}else{
				$data['page']='0';
			}
			
			$data['user_id']=$this->input->get('user_id');
			$user_transactions			=$this->user_model->get_user_transactions($data);
			
			if(!$user_transactions){
				return FALSE;
			}
			
			$count=$user_transactions['count'];
			
			$data=array();
			if($user_transactions){
				$data['user_transactions']	=$user_transactions['user_transactions'];
			}
			
			//分页
			
			$config['base_url'] 			= site_url('user/user/get_user_transactions?user_id=').$this->input->get('user_id');
			$config['num_links'] 			= 2;
			$config['page_query_string'] 	= TRUE;
			$config['query_string_segment'] = 'page';
			$config['full_tag_open'] 		= '<div class="text-left pagination" style="float: left;padding: 6px 0px;margin: 5px 0">共'.@(floor($count / $this->config->get_config ( 'config_limit_admin' )) + 1) .'页/第'.@(floor($data['page'] / $this->config->get_config ( 'config_limit_admin' )) + 1) .'页</div><ul class="pagination" style="float: right;margin: 5px 0">';
			$config['full_tag_close'] 		= '</ul>';
			$config['first_tag_open'] 		= '<li>';
			$config['first_tag_close'] 		= '</li>';
			$config['last_tag_open'] 		= '<li>';
			$config['last_tag_close'] 		= '</li>';
			$config['next_tag_open'] 		= '<li>';
			$config['next_tag_close'] 		= '</li>';
			$config['prev_tag_open'] 		= '<li>';
			$config['prev_tag_close'] 		= '</li>';
			$config['cur_tag_open'] 		= '<li class="active"><a>';
			$config['cur_tag_close'] 		= '</a></li>';
			$config['num_tag_open']			= '<li>';
			$config['num_tag_close']		= '</li>';
			$config['first_link'] 			= '<<';
			$config['last_link'] 			= '>>';
			$config['total_rows'] 			= $count;
			$config['per_page'] 			= $this->config->get_config('config_limit_admin');

			$this->pagination->initialize($config);

			$data['pagination'] 			=$this->pagination->create_links();
			
			$total_amount					=array_column($user_transactions['user_transactions'],'amount');
			$data['total_amount']			=array_sum($total_amount);
			if(empty($in)){
				$html=$this->load->view('theme/default/template/user/add_transaction', $data, TRUE);
				$this->output
				    ->set_content_type('application/html')
				    ->set_output($html);
				return;
			}else{
				return $data;
			}
		}
		return FALSE;
	}
	
	//调用户积分
	public function get_user_rewards($in=''){
		if($this->input->get('user_id')){
			if($this->input->get('page')){
				$data['page']				=$this->input->get('page');
			}else{
				$data['page']='0';
			}
			
			$data['user_id']				=$this->input->get('user_id');
			$user_rewards					=$this->user_model->get_user_rewards($data);
			
			if(!$user_rewards){
				return FALSE;
			}
			
			$count							=$user_rewards['count'];
			
			$data=array();
			if($user_rewards){
				$data['user_rewards']		=$user_rewards['user_rewards'];
			}
			
			//分页
			$config['base_url'] 			= site_url('user/user/get_user_rewards?user_id=').$this->input->get('user_id');
			$config['num_links'] 			= 2;
			$config['page_query_string'] 	= TRUE;
			$config['query_string_segment'] = 'page';
			$config['full_tag_open'] 		= '<div class="text-left pagination" style="float: left;padding: 6px 0px;margin: 5px 0">共'.@(floor($count / $this->config->get_config ( 'config_limit_admin' )) + 1) .'页/第'.@(floor($data['page'] / $this->config->get_config ( 'config_limit_admin' )) + 1) .'页</div><ul class="pagination" style="float: right;margin: 5px 0">';
			$config['full_tag_close'] 		= '</ul>';
			$config['first_tag_open'] 		= '<li>';
			$config['first_tag_close'] 		= '</li>';
			$config['last_tag_open'] 		= '<li>';
			$config['last_tag_close'] 		= '</li>';
			$config['next_tag_open'] 		= '<li>';
			$config['next_tag_close'] 		= '</li>';
			$config['prev_tag_open'] 		= '<li>';
			$config['prev_tag_close'] 		= '</li>';
			$config['cur_tag_open'] 		= '<li class="active"><a>';
			$config['cur_tag_close'] 		= '</a></li>';
			$config['num_tag_open']			= '<li>';
			$config['num_tag_close']		= '</li>';
			$config['first_link'] 			= '<<';
			$config['last_link'] 			= '>>';
			//$config['total_rows'] 			= 300;
			$config['total_rows'] 			= $count;
			$config['per_page'] 			= $this->config->get_config('config_limit_admin');

			$this->pagination->initialize($config);

			$data['pagination'] 			=$this->pagination->create_links();
			
			$total_reward					=array_column($user_rewards['user_rewards'],'points');
			$data['total_reward']			=array_sum($total_reward);
			
			if(empty($in)){
				$html=$this->load->view('theme/default/template/user/add_reward', $data, TRUE);
				$this->output
				    ->set_content_type('application/html')
				    ->set_output($html);
				return;
			}else{
				return $data;
			}
		}
		return FALSE;
	}

	public function add_history(){
		if($this->input->post('comment') != NULL && $this->input->get('user_id') != NULL){
			//验证数据
			if($this->form_validation->numeric($this->input->get('user_id')) && $this->form_validation->max_length($this->input->post('comment'),'2000')){
				$data['comment'] = $this->input->post('comment');
				$data['user_id'] = $this->input->get('user_id');
				$data['date_added'] = date("Y-m-d H:i:s");
				
				$this->user_model->add_history($data);
			}
		}else{
			return FALSE;
		}
		
		//获取新数据
		$user_history_info = $this->get_user_historys('in');
		if(!$user_history_info){
			return FALSE;
		}
		
		$data['user_historys']			=$user_history_info['user_historys'];
		$data['history_pagination']		=$user_history_info['pagination'];
			
		$html = $this->load->view('theme/default/template/user/add_history', $data, TRUE);
		$this->output
		    ->set_content_type('application/html')
		    ->set_output($html);
	}
	
	public function add_transaction(){
		if($this->input->post('amount') != NULL && $this->input->get('user_id') != NULL){
			//验证数据
			if($this->form_validation->numeric($this->input->get('user_id')) && $this->form_validation->numeric($this->input->post('amount')) && $this->form_validation->max_length($this->input->post('description'),'2000')){
				$data['description'] = $this->input->post('description');
				$data['user_id'] = $this->input->get('user_id');
				$data['amount'] = $this->input->post('amount');
				$data['date_added'] = date("Y-m-d H:i:s");
				
				$this->user_model->add_transaction($data);
			}
		}else{
			return FALSE;
		}
		
		//获取新数据
		$user_transactions				=$this->get_user_transactions('in');
		$data=array();
		if($user_transactions){
			$data['user_transactions']	=$user_transactions['user_transactions'];
			$total_amount				=array_column($user_transactions['user_transactions'],'amount');
			$data['total_amount']		=array_sum($total_amount);
			$data['transactions_pagination']		=$user_transactions['pagination'];
		}
			
		$html = $this->load->view('theme/default/template/user/add_transaction', $data, TRUE);
		$this->output
		    ->set_content_type('application/html')
		    ->set_output($html);
	}
	
	public function add_reward(){
		if($this->input->post('points') != NULL && $this->input->get('user_id') != NULL){
			//验证数据
			if($this->form_validation->numeric($this->input->get('user_id')) && $this->form_validation->numeric($this->input->post('points')) && $this->form_validation->max_length($this->input->post('description'),'2000')){
				$data['description'] = $this->input->post('description');
				$data['user_id'] = $this->input->get('user_id');
				$data['points'] = $this->input->post('points');
				$data['date_added'] = date("Y-m-d H:i:s");
				
				$this->user_model->add_reward($data);
			}
		}else{
			return FALSE;
		}
		
		//获取新数据
		$user_rewards					=$this->get_user_rewards('in');
		if($user_rewards){
			$data['user_rewards']		=$user_rewards['user_rewards'];
			$total_reward				=array_column($user_rewards['user_rewards'],'points');
			$data['total_rewards']		=array_sum($total_reward);
			$data['rewards_pagination']	=$user_rewards['pagination'];
		}
			
		$html = $this->load->view('theme/default/template/user/add_reward', $data, TRUE);
		$this->output
		    ->set_content_type('application/html')
		    ->set_output($html);
	}

	//验证user
	public function validation_user($user){
		if(!$this->form_validation->min_length($user['nickname'],'3') || !$this->form_validation->max_length($user['nickname'],'18')){
			$this->error['error_nickname']='昵称长度3——18字符';
		}
		if(!isset($user['firstname']) || empty($user['firstname'])){
			$this->error['error_firstname']='姓不能为空';
		}
		if(!isset($user['email']) || empty($user['email'])){
			$this->error['error_email']='邮箱为空';
		}
		
		if(!$this->form_validation->valid_email($user['email'])){
			$this->error['error_email']='邮箱格式不正确';
		}
		return !$this->error;
	}
	
	//验证地址
	public function validation_address($address=array()){
		if(!isset($address)){
			return FALSE;
		}
		foreach($address as $key=>$value){
			if(!isset($address[$key]['firstname']) || empty($address[$key]['firstname'])){
				$this->error['address'][$key]['error_firstname']='姓不能为空';
			}
			if(!isset($address[$key]['address']) || empty($address[$key]['address']) || !$this->form_validation->max_length($address[$key]['address'], '128')){
				$this->error['address'][$key]['error_address']='地址不能为空或大于128字符';
			}
			if(!isset($address[$key]['city']) || empty($address[$key]['city'])){
				$this->error['address'][$key]['error_city']='城市不能为空或大于128字符';
			}
			if(!isset($address[$key]['country_id']) || empty($address[$key]['country_id'])){
				$this->error['address'][$key]['error_country']='国家必填';
			}
			if(!isset($address[$key]['zone_id']) || empty($address[$key]['zone_id'])){
				$this->error['address']['error_zone']='省必填';
			}
		}
		return !$this->error;
	}
	
	//加黑名单
	public function add_ban_ip(){
		if($this->input->post('ip') != NULL && $this->form_validation->valid_ip($this->input->post('ip'))){
			$data['ip']=$this->input->post('ip');
			$this->user_model->add_ban_ip($data);
		}else{
			return FALSE;
		}
	}
}
