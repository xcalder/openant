<?php
class Bbs_model extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function add_attention($posting_id){
		if(isset($_SESSION['user_id'])){
			$data['user_id']=$_SESSION['user_id'];
		}else {
			return false;
		}
		$data['posting_id']=$posting_id;
		
		$this->db->select('id');
		$this->db->where($data);
		$this->db->from($this->db->dbprefix('bbs_posting_attention'));
		$query = $this->db->get();
		if(!$query->num_rows() > 0){
			$data['date_added']=date("Y-m-d H:i:s");
			return $this->db->insert($this->db->dbprefix('bbs_posting_attention'), $data);
		}
		
		return false;
	}
	
	//取消关注
	public function unattention_posting($posting_id){
		if(isset($_SESSION['user_id'])){
			$user_id=$_SESSION['user_id'];
		}else {
			return false;
		}
		
		$this->db->where('user_id', $user_id);
		$this->db->where('posting_id', $posting_id);
		return $this->db->delete($this->db->dbprefix('bbs_posting_attention'));
	}
	
	public function add_user_attention($to_user_id){
		if(isset($_SESSION['user_id']) && $_SESSION['user_id'] != $to_user_id){
			$data['user_id']=$_SESSION['user_id'];
		}else {
			return false;
		}
		$data['to_user_id']=$to_user_id;
	
		$this->db->select('id');
		$this->db->where($data);
		$this->db->from($this->db->dbprefix('bbs_user_attention'));
		$query = $this->db->get();
		if(!$query->num_rows() > 0){
			$data['date_added']=date("Y-m-d H:i:s");
			return $this->db->insert($this->db->dbprefix('bbs_user_attention'), $data);
		}
	
		return false;
	}
	
	//取消关注
	public function unattention_user($to_user_id){
		if(isset($_SESSION['user_id']) && $_SESSION['user_id'] != $to_user_id){
			$user_id=$_SESSION['user_id'];
		}else {
			return false;
		}
	
		$this->db->where('user_id', $user_id);
		$this->db->where('to_user_id', $to_user_id);
		return $this->db->delete($this->db->dbprefix('bbs_user_attention'));
	}
	
	public function get_attentions($data){
		//统计记录条数
		$this->db->where('posting_id', $data['posting_id']);
		$row['count']=$this->db->count_all_results($this->db->dbprefix('bbs_posting_attention'));
		//获取关注者列表
		$this->db->select('bbs_posting_attention.user_id, bbs_posting_attention.date_added, u.nickname, u.image');
		$this->db->where('bbs_posting_attention.posting_id', $data['posting_id']);
		$this->db->join('user as u', 'u.user_id = bbs_posting_attention.user_id');
		$this->db->limit('11', $data['page']);
		$query = $this->db->get($this->db->dbprefix('bbs_posting_attention'));
		if($query->num_rows() > 0){
			$row['info']=$query->result_array();
			return $row;
		}
		return false;
	}
	
	
	public function get_users($user_id, $page, $to=true){
		//统计记录条数
		if($to){
			$this->db->where('user_id', $user_id);
		}else{
			$this->db->where('to_user_id', $user_id);
		}
		
		$row['count']=$this->db->count_all_results($this->db->dbprefix('bbs_user_attention'));
		//获取关注者列表
		if($to){
			$this->db->select('bbs_user_attention.to_user_id as user_id, bbs_user_attention.date_added, u.nickname, u.image');
			$this->db->where('bbs_user_attention.user_id', $user_id);
			$this->db->join('user as u', 'u.user_id = bbs_user_attention.to_user_id');
		}else{
			$this->db->select('bbs_user_attention.user_id, bbs_user_attention.date_added, u.nickname, u.image');
			$this->db->where('bbs_user_attention.to_user_id', $user_id);
			$this->db->join('user as u', 'u.user_id = bbs_user_attention.user_id');
		}
		
		$this->db->limit('6', $page);
		$query = $this->db->get($this->db->dbprefix('bbs_user_attention'));
		if($query->num_rows() > 0){
			$row['users']=$query->result_array();
			return $row;
		}
		return false;
	}
	
//精华帖
	public function get_very_good($limit='6'){
		$this->db->select('DISTINCT(posting_id)');
		$this->db->where('very_good', '1');
		
		$this->db->order_by('date_added', 'DESC');
		$this->db->limit($limit);
		
		$query = $this->db->get($this->db->dbprefix('bbs_posting'));
		
		if($query->num_rows() > 0){
			$row=array();
			$postings = $query->result_array();
			foreach ($postings as $posting) {
				$retule=$this->get_posting($posting['posting_id']);
				if(!empty($retule['title'])){
					$row[] = $retule;
				}
			}
			
			return $row;
		}
		
		return FALSE;
	}
	
	//热门帖
	public function get_active($limit='6'){
		$this->db->select('DISTINCT(posting_id), count(posting_id) as count');
		$this->db->group_by("posting_id");
		$this->db->order_by('count', 'DESC');
		$this->db->limit($limit);
		$this->db->from($this->db->dbprefix('bbs_activity'));//查
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			$row=array();
			$postings = $query->result_array();
			foreach ($postings as $posting) {
				$retule=$this->get_posting($posting['posting_id']);
				if(!empty($retule['title'])){
					$row[] = $retule;
				}
			}
			
			return $row;
		}
		
		return FALSE;
	}
	
	//
	public function get_plates($limit='0')
	{
		//文章基本数据
		$this->db->select('plate_id');
		$this->db->where('is_menu', '1');
		$this->db->where('is_view', '1');
		
		if(empty($limit)){
			$this->db->limit($limit);
		}
		
		$this->db->order_by('date_added', 'ASC');
		
		$query = $this->db->get($this->db->dbprefix('bbs_plate'));
		
		if($query->num_rows() > 0){
			$plates = $query->result_array();
			$plates = array_flip(array_flip(array_column($plates,'plate_id')));
			foreach ($plates as $plate_id) {
				$row[] = $this->get_plate($plate_id);
			}
			
			return $row;
		}else{
			return FALSE;
		}
	}
	
	public function get_plate($plate_id){
		$this->db->where('bbs_plate.plate_id', $plate_id);
		$this->db->where('bbs_plate_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('bbs_plate_description', 'bbs_plate_description.plate_id = bbs_plate.plate_id', 'left');
		
		$this->db->from($this->db->dbprefix('bbs_plate'));//查
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			return $query->row_array();
		}
		return FALSE;
	}

	//获取帖子
	public function get_postings($data){
		//统计表记录
		$this->db->where('is_view', '1');
		$row['count']=$this->db->count_all_results($this->db->dbprefix('bbs_posting'));
		
		$limit=$this->config->get_config('config_limit_admin');
		
		if(isset($data['limit'])){
			$limit=$data['limit'];
		}
		
		//帖子排序
		$this->db->order_by('bbs_posting.is_top', 'DESC');
		if(isset($data['order_by']) && $data['order_by'] == 'time'){
			$this->db->select('count(bbs_replies.replies_id) as count, bbs_posting.posting_id');
			$this->db->group_by("bbs_replies.posting_id");
			$this->db->join('bbs_replies', 'bbs_replies.posting_id = bbs_posting.posting_id', 'left');
			$this->db->order_by('count', 'DESC');
		}elseif(isset($data['order_by']) && $data['order_by'] == 'good'){
			$this->db->select('bbs_posting.posting_id');
			$this->db->order_by('bbs_posting.very_good', 'DESC');
			$this->db->order_by('bbs_posting.date_added', 'DESC');
		}elseif(isset($data['order_by']) && $data['order_by'] == 'last'){
			$this->db->select('bbs_posting.posting_id');
			$this->db->order_by('bbs_posting.date_added', 'DESC');
		}elseif(isset($data['order_by']) && $data['order_by'] == 'no_reply'){
			$this->db->select('count(bbs_replies.replies_id) as count, bbs_posting.posting_id');
			$this->db->group_by("bbs_replies.posting_id");
			$this->db->join('bbs_replies', 'bbs_replies.posting_id = bbs_posting.posting_id', 'left');
			$this->db->order_by('count', 'ASC');
		}else{
			$this->db->select('bbs_posting.posting_id');
			$this->db->order_by('bbs_posting.date_added', 'DESC');
		}
		
		if(isset($data['plate_id']) && !empty($data['plate_id'])){
			$this->db->where('bbs_posting.plate_id', $data['plate_id']);
		}
		
		if(isset($data['search'])){
			//提取关键词key
			$this->load->library('phpanalysis');
			$this->phpanalysis->SetSource ($data['search']);
			$this->phpanalysis->StartAnalysis ( true );
			$tags = $this->phpanalysis->GetFinallyKeywords ( 5 ); // 获取3个关键字

			$tags = explode(',', $tags);
			
			foreach ($tags as $k=>$v){
				if($k == 0){
					$this->db->like('bbs_posting_description.title', $tags[$k]);
					$this->db->or_like('bbs_posting_description.description', $tags[$k]);
				}else{
					$this->db->or_like('bbs_posting_description.title', $tags[$k]);
					$this->db->or_like('bbs_posting_description.description', $tags[$k]);
				}
			}
			$this->db->where('bbs_posting_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
			$this->db->join('bbs_posting_description', 'bbs_posting_description.posting_id = bbs_posting.posting_id', 'left');
		}
		
		$this->db->where('bbs_posting.is_view', '1');
		$this->db->limit($limit, $data['page']);
		
		$query = $this->db->get($this->db->dbprefix('bbs_posting'));
		
		if($query->num_rows() > 0){
			$row['postings']=array();
			$postings = $query->result_array();
			$postings = array_flip(array_flip(array_column($postings,'posting_id')));
			foreach ($postings as $posting_id) {
				$result=$this->get_posting($posting_id);
				if(!empty($result['title'])){
					$row['postings'][]=$result;
				}
			}
			
			return $row;
		}else{
			return FALSE;
		}
	}
	
	public function get_posting_for_user_id($user_id, $page){
		//统计表记录
		$this->db->where('is_view', '1');
		$row['count']=$this->db->count_all_results($this->db->dbprefix('bbs_posting'));
		
		$limit=$this->config->get_config('config_limit_admin');
		
		$this->db->select('bbs_posting.posting_id');
		$this->db->where('bbs_posting.is_view', '1');
		$this->db->where('bbs_posting.user_id', $user_id);
		$this->db->limit($limit, $page);
		$this->db->order_by('bbs_posting.date_added', 'DESC');
		
		$query = $this->db->get($this->db->dbprefix('bbs_posting'));
		
		if($query->num_rows() > 0){
			$postings = $query->result_array();
			$postings = array_flip(array_flip(array_column($postings,'posting_id')));
			foreach ($postings as $posting_id) {
				$row['postings'][] = $this->get_posting($posting_id);
			}
			
			return $row;
		}else{
			return FALSE;
		}
	}
	
	public function get_posting_for_attention($user_id, $page){
		//统计表记录
		$this->db->where('user_id', $user_id);
		$row['count']=$this->db->count_all_results($this->db->dbprefix('bbs_posting_attention'));
		
		$limit=$this->config->get_config('config_limit_admin');
		
		$this->db->select('posting_id, date_added as a_date_added');
		$this->db->where('user_id', $user_id);
		$this->db->limit($limit, $page);
		$this->db->order_by('date_added', 'DESC');
		
		$query = $this->db->get($this->db->dbprefix('bbs_posting_attention'));
		
		if($query->num_rows() > 0){
			$postings = $query->result_array();
			//$postings = array_flip(array_flip(array_column($postings,'posting_id')));
			foreach ($postings as $key=>$posting) {
				$row['postings'][$key] = $this->get_posting($posting['posting_id']);
				$row['postings'][$key]['a_date_added']=$posting['a_date_added'];
			}
			
			return $row;
		}else{
			return FALSE;
		}
	}
	
	//获取帖子内容到发帖
	public function get_posting_release($posting_id){
		$this->db->select('bbs_posting.posting_id, bbs_posting_description.title,bbs_posting_description.description');
		$this->db->where('bbs_posting.posting_id', $posting_id);
		$this->db->where('bbs_posting_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('bbs_posting_description', 'bbs_posting_description.posting_id = bbs_posting.posting_id', 'left');
		
		$this->db->from($this->db->dbprefix('bbs_posting'));//查
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			
			return $query->row_array();
		}
		
		return FALSE;
	}
	
	//获取帖子内容
public function get_posting($posting_id){
		$this->db->select('bbs_posting.user_id, bbs_posting.posting_id, bbs_posting.is_view, bbs_posting.very_good, bbs_posting.is_top, bbs_posting.date_added, bbs_posting_description.title, user.nickname,user.image , bbs_plate_description.plate_id, bbs_plate_description.title as plate_title, count(bbs_replies.replies_id) as count, bbs_plate.label');
		$this->db->where('bbs_posting.posting_id', $posting_id);
		$this->db->where('bbs_posting_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('bbs_posting_description', 'bbs_posting_description.posting_id = bbs_posting.posting_id', 'left');
		//版块名
		$this->db->where('bbs_plate_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('bbs_plate_description', 'bbs_plate_description.plate_id = bbs_posting.plate_id', 'left');
		//板块标签样式
		$this->db->join('bbs_plate', 'bbs_plate.plate_id = bbs_posting.plate_id', 'left');
		//用户发帖人
		$this->db->join('user', 'user.user_id = bbs_posting.user_id', 'left');
		
		//回帖数
		$this->db->join('bbs_replies', 'bbs_replies.posting_id = bbs_posting.posting_id', 'left');
		
		//回帖人信息
		$this->db->join('user as u', 'bbs_replies.user_id = u.user_id', 'left');
		
		$this->db->from($this->db->dbprefix('bbs_posting'));//查
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			$row=$query->row_array();
			
			//统计访问量
			$this->db->where('page', 'posting');
			$this->db->where('page_id', $posting_id);
			$row['access_count']=$this->db->count_all_results($this->db->dbprefix('page_access_total'));
			
			//查讨论的最后回复时间
			$this->db->select('user.user_id, user.image, user.nickname, bbs_activity.date_added');
			$this->db->where('bbs_activity.posting_id', $posting_id);
			
			$this->db->join('user', 'bbs_activity.user_id = user.user_id');
			
			$this->db->order_by('bbs_activity.date_added', 'DESC');
			$this->db->from($this->db->dbprefix('bbs_activity'));//查
			$query = $this->db->get();
			if($query->num_rows() > 0){
				//存在
				$activity=$query->row_array();
				$row['re_user_id']=$activity['user_id'];
				$row['re_date']=$activity['date_added'];
				$row['re_image']=$activity['image'];
				$row['re_nickname']=$activity['nickname'];
			}else{
				//不存在，用发帖时间
				$row['re_user_id']=$row['user_id'];
				$row['re_date']=$row['date_added'];
				$row['re_image']=$row['image'];
				$row['re_nickname']=$row['nickname'];
			}
			return $row;
		}
		return FALSE;
	}
	
	//获取帖子内容
	public function get_posting_content($posting_id, $page){
		$this->db->select('bbs_posting.posting_id,bbs_posting.plate_id, bbs_posting.user_id, bbs_posting.date_added, bbs_posting_description.title, bbs_posting_description.description, user.nickname,user.image , bbs_plate_description.title as plate_title, user_group_description.name as user_group_name, user_class_description.name as user_class_name, bbs_plate.label');
		$this->db->where('bbs_posting.posting_id', $posting_id);
		$this->db->where('bbs_posting.is_view', '1');
		$this->db->where('bbs_posting_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('bbs_posting_description', 'bbs_posting_description.posting_id = bbs_posting.posting_id', 'left');
		//版块名
		$this->db->where('bbs_plate_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('bbs_plate_description', 'bbs_plate_description.plate_id = bbs_posting.plate_id', 'left');
		//板块标签样式
		$this->db->join('bbs_plate', 'bbs_plate.plate_id = bbs_posting.plate_id', 'left');
		//用户发帖人
		$this->db->join('user', 'user.user_id = bbs_posting.user_id', 'left');
		//用户组
		$this->db->where('user_class_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('user_class_description', 'user.user_class_id = user_class_description.user_class_id', 'left');
		
		//用户组
		$this->db->where('user_group_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('user_group_description', 'user.user_group_id = user_group_description.user_group_id', 'left');
		
		$this->db->from($this->db->dbprefix('bbs_posting'));//查
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			
			$row=$query->row_array();
			
			//统计访问量
			$this->db->where('page', 'posting');
			$this->db->where('page_id', $posting_id);
			$row['access_count']=$this->db->count_all_results($this->db->dbprefix('page_access_total'));
			
			//统计关注量
			$this->db->where('posting_id', $posting_id);
			$row['attentions']=$this->db->count_all_results($this->db->dbprefix('bbs_posting_attention'));
			
			//判断是否已关注
			if(isset($_SESSION['user_id'])){
				$this->db->where('posting_id', $posting_id);
				$this->db->where('user_id', $_SESSION['user_id']);
				$row['is_attention']=$this->db->count_all_results($this->db->dbprefix('bbs_posting_attention'));
			}else{
				$row['is_attention']=0;
			}
			
			$limit=$this->config->get_config('config_limit_admin');
			
			$this->db->select('bbs_replies.replies_id, bbs_replies.user_id, bbs_replies.date_added, re_d.content, user.image, user.nickname');
			$this->db->where('is_view', '1');
			$this->db->where('posting_id', $posting_id);
			$this->db->order_by('date_added', 'DESC');
			
			//文章基本数据
			$this->db->limit($limit, $page);
			
			$this->db->where('re_d.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
			$this->db->join('bbs_replies_description as re_d', 'bbs_replies.replies_id = re_d.replies_id', 'left');
			
			//回帖人
			$this->db->join('user', 'user.user_id = bbs_replies.user_id', 'left');
			
			$this->db->from($this->db->dbprefix('bbs_replies'));//查
			$query = $this->db->get();
			if($query->num_rows() > 0){
				$replies=$query->result_array();
				
				foreach($replies as $key=>$replie){
					$replies[$key]['discuss']=$this->get_bbs_discuss($replie['replies_id']);
				}
				$row['replies']=$replies;
				$row['count']=count($replies);
			}else{
				$row['replies']=FALSE;
				$row['count']=0;
			}
			
			return $row;
		}
		return FALSE;
	}
	
	public function get_bbs_discuss($replies_id){
		
		$this->db->select('bbs_discuss.user_id, bbs_discuss.date_added, bds.content, user.image, user.nickname');

		$this->db->where('bbs_discuss.replies_id', $replies_id);
		$this->db->order_by('bbs_discuss.date_added', 'DESC');
		
		//文章基本数据
		
		$this->db->where('bds.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('bbs_discuss_description as bds', 'bbs_discuss.discuss_id = bds.discuss_id', 'left');
		
		//回帖人
		$this->db->join('user', 'user.user_id = bbs_discuss.user_id', 'left');
		
		$this->db->from($this->db->dbprefix('bbs_discuss'));//查
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result_array();
		}
		
		return FALSE;
	}
	
	public function replies($data){
		$this->db->insert($this->db->dbprefix('bbs_replies'), $data['base']);
		$replies_id=$this->db->insert_id();
		
		$data['description']['replies_id']=$replies_id;
		$this->db->insert($this->db->dbprefix('bbs_replies_description'), $data['description']);
		
		//写入到bbs动态表
		$activity['user_id']=$_SESSION['user_id'];
		$activity['key']='replies';
		$activity['posting_id']=$data['base']['posting_id'];
		$this->add_bbs_activity($activity);
	}
	
	public function discuss($data){
		$this->db->insert($this->db->dbprefix('bbs_discuss'), $data['base']);
		$discuss_id=$this->db->insert_id();
		
		$data['description']['discuss_id']=$discuss_id;
		if($this->db->insert($this->db->dbprefix('bbs_discuss_description'), $data['description'])){
			//写入动态
			$this->load->model('common/user_activity_model');
			$this->user_activity_model->add_activity($_SESSION['user_id'], 'release', array('title'=>'回复了一个帖子', 'msg'=>''));
			
			//写入到bbs动态表
			$activity['user_id']=$_SESSION['user_id'];
			$activity['key']='discuss';
			$activity['posting_id']=$data['base']['posting_id'];
			$this->add_bbs_activity($activity);
		}
	}
	
	public function get_bbs_user($user_id){
		$this->db->select('user.nickname, user.image, user.date_added, user_group_description.name as user_group_name, user_class_description.name as user_class_name');
		$this->db->where('user.user_id', $user_id);
		
		//用户组
		$this->db->where('user_class_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('user_class_description', 'user.user_class_id = user_class_description.user_class_id', 'left');
		
		//用户组
		$this->db->where('user_group_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('user_group_description', 'user.user_group_id = user_group_description.user_group_id', 'left');
		
		$this->db->from($this->db->dbprefix('user'));//查
		$query = $this->db->get();
		if($query->num_rows() > 0){
			$row=$query->row_array();
			
			$this->db->where('user_id',$user_id);
			$rep_count=$this->db->count_all_results($this->db->dbprefix('bbs_replies'));
			$this->db->where('user_id',$user_id);
			$bd_count=$this->db->count_all_results($this->db->dbprefix('bbs_discuss'));
			//发帖数
			$this->db->where('user_id',$user_id);
			$row['bp_count']=$this->db->count_all_results($this->db->dbprefix('bbs_posting'));
			//回帖数
			$row['re_count']=$rep_count + $bd_count;
			
			//查讨论的最后回复时间
			$this->db->select('user.user_id, user.image, user.nickname, bbs_activity.date_added');
			$this->db->where('bbs_activity.posting_id', $posting_id);
			
			$this->db->join('user', 'bbs_activity.user_id = user.user_id');
			
			$this->db->order_by('bbs_activity.date_added', 'DESC');
			$this->db->from($this->db->dbprefix('bbs_activity'));//查
			$query = $this->db->get();
			if($query->num_rows() > 0){
				//存在
				$activity=$query->row_array();
				$row['re_user_id']=$activity['user_id'];
				$row['re_date']=$activity['date_added'];
				$row['re_image']=$activity['image'];
				$row['re_nickname']=$activity['nickname'];
			}else{
				//不存在，用发帖时间
				$row['re_user_id']=$row['user_id'];
				$row['re_date']=$row['date_added'];
				$row['re_image']=$row['image'];
				$row['re_nickname']=$row['nickname'];
			}
			return $row;
		}
		
		return FALSE;
	}
	
	public function edit_posting($data){
		$this->db->where('posting_id', $data['base']['posting_id']);
		$this->db->update($this->db->dbprefix('bbs_posting'), $data['base']);
		
		$this->db->where('posting_id', $data['description']['posting_id']);
		if($this->db->update($this->db->dbprefix('bbs_posting_description'), $data['description'])){
			//写入动态
			$this->load->model('common/user_activity_model');
			$this->user_activity_model->add_activity($_SESSION['user_id'], 'release', array('title'=>'帖子修改成功', 'msg'=>$data['description']['title']));
			
			//写入到bbs动态表
			$activity['user_id']=$_SESSION['user_id'];
			$activity['key']='release';
			$activity['posting_id']=$posting_id;
			$this->add_bbs_activity($activity);
			
			return TRUE;
		}
		
		return FALSE;
	}
	
	public function add_posting($data){
		$this->db->insert($this->db->dbprefix('bbs_posting'), $data['base']);
		
		$posting_id=$this->db->insert_id();
		$data['description']['posting_id']=$this->db->insert_id();
		if($this->db->insert($this->db->dbprefix('bbs_posting_description'), $data['description'])){
			//写入动态
			$this->load->model('common/user_activity_model');
			$this->user_activity_model->add_activity($_SESSION['user_id'], 'release', array('title'=>'发帖成功', 'msg'=>$data['description']['title']));
			
			//写入到bbs动态表
			$activity['user_id']=$_SESSION['user_id'];
			$activity['key']='release';
			$activity['posting_id']=$posting_id;
			$this->add_bbs_activity($activity);
			
			return $posting_id;
		}
		
		return FALSE;
	}
	
	public function get_activity_user(){
		$this->db->select('user_id');
		$this->db->where('is_view', '1');
		$this->db->order_by('date_added', 'RANDOM');
		$this->db->group_by('user_id');
		$this->db->limit(50);
		$this->db->from($this->db->dbprefix('bbs_replies'));//查
		$query = $this->db->get();
		if($query->num_rows() > 0){
			$row['replies']=$query->result_array();
		}else{
			$row['replies']=array();
		}
		
		$this->db->select('user_id');
		$this->db->where('is_view', '1');
		$this->db->group_by('user_id');
		$this->db->limit(50);
		$this->db->order_by('date_added', 'RANDOM');
		$this->db->from($this->db->dbprefix('bbs_posting'));//查
		$query = $this->db->get();
		if($query->num_rows() > 0){
			$row['posting']=$query->result_array();
		}else{
			$row['posting']=array();
		}
		
		$arr=array_merge($row['replies'], $row['posting']);
		$arr=array_flip(array_flip(array_column($arr, 'user_id')));
		
		return $arr;
	}
	
	public function add_bbs_activity($data){
		$data['date_added']=date("Y-m-d H:i:s");
		$this->db->insert($this->db->dbprefix('bbs_activity'), $data);
	}
}