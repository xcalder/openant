<?php
class Bbs_model extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	//精华帖
	public function get_very_good($limit='6'){
		$this->db->select('bbs_posting.posting_id');
		//$this->db->where('bbs_posting.very_good', '1');
		
		$this->db->order_by('date_added', 'RANDOM');
		$this->db->limit($limit);
		
		$query = $this->db->get($this->db->dbprefix('bbs_posting'));
		
		if($query->num_rows() > 0){
			$row=array();
			$postings = $query->result_array();
			$postings = array_flip(array_flip(array_column($postings,'posting_id')));
			foreach ($postings as $posting_id) {
				$retule=$this->get_posting_tomodule($posting_id);
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
		$this->db->select('count(bbr.replies_id) as count, bbp.posting_id');
		$this->db->group_by("bbr.posting_id");
		$this->db->join('bbs_replies AS bbr', 'bbr.posting_id = bbp.posting_id');
		$this->db->order_by('count', 'DESC');
		
		$this->db->where('bbp.is_view', '1');
		$this->db->limit($limit);
		
		$query = $this->db->get($this->db->dbprefix('bbs_posting') . ' AS bbp');
		
		if($query->num_rows() > 0){
			$row=array();
			$postings = $query->result_array();
			$postings = array_flip(array_flip(array_column($postings,'posting_id')));
			foreach ($postings as $posting_id) {
			$retule=$this->get_posting_tomodule($posting_id);
				if(!empty($retule['title'])){
					$row[] = $retule;
				}
			}
			
			return $row;
		}
		
		return FALSE;
	}
	
	//获取帖子内容
	public function get_posting_tomodule($posting_id){
		$this->db->select('bbp.user_id, bbp.posting_id, bbp.is_view, bbp.very_good, bbp.is_top, bbp.date_added, bbpd.title, uf.nickname,uf.image , bpdl.plate_id, bpdl.title as plate_title, count(br.replies_id) as count, bbpl.label');
		$this->db->where('bbp.posting_id', $posting_id);
		$this->db->where('bbpd.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('bbs_posting_description AS bbpd', 'bbpd.posting_id = bbp.posting_id', 'left');
		//版块名
		$this->db->where('bpdl.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('bbs_plate_description AS bpdl', 'bpdl.plate_id = bbp.plate_id', 'left');
		//板块标签样式
		$this->db->join('bbs_plate AS bbpl', 'bbpl.plate_id = bbp.plate_id', 'left');
		//用户发帖人
		$this->db->join('user AS uf', 'uf.user_id = bbp.user_id', 'left');
		
		//回帖数
		$this->db->join('bbs_replies AS br', 'br.posting_id = bbp.posting_id', 'left');
		
		//回帖人信息
		$this->db->join('user as u', 'br.user_id = u.user_id', 'left');
		
		$this->db->from($this->db->dbprefix('bbs_posting') . ' AS bbp');//查
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			$row=$query->row_array();
			
			//统计访问量
			$this->db->where('page', 'posting');
			$this->db->where('page_id', $posting_id);
			$row['access_count']=$this->db->count_all_results($this->db->dbprefix('page_access_total'));
			
			//查讨论的最后回复时间
			$this->db->select('u.user_id, u.image, u.nickname, ba.date_added');
			$this->db->where('ba.posting_id', $posting_id);
			
			$this->db->join('user AS u', 'ba.user_id = u.user_id');
			
			$this->db->order_by('ba.date_added', 'DESC');
			$this->db->from($this->db->dbprefix('bbs_activity') . ' AS ba');//查
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
	
	//admin管理函数
	public function get_plates_for_list($page='0')
	{
		//统计表记录
		$row['count']=$this->db->count_all_results($this->db->dbprefix('bbs_plate'));
		
		$limit=$this->config->get_config('config_limit_admin');
		
		//文章基本数据
		$this->db->select('plate_id');
		$this->db->limit($limit, $page);
		$this->db->order_by('date_added', 'ASC');
		
		$query = $this->db->get($this->db->dbprefix('bbs_plate'));
		
		if($query->num_rows() > 0){
			$plates = $query->result_array();
			$plates = array_flip(array_flip(array_column($plates,'plate_id')));
			foreach ($plates as $plate_id) {
				$row['plates'][] = $this->get_plate($plate_id);
			}
			
			return $row;
		}else{
			return FALSE;
		}
	}
	
	public function get_plate($plate_id){
		$this->db->where('bp.plate_id', $plate_id);
		$this->db->where('bpd.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('bbs_plate_description AS bpd', 'bpd.plate_id = bp.plate_id');
		
		$this->db->from($this->db->dbprefix('bbs_plate') . ' AS bp');//查
		$query = $this->db->get();
	
		if($query->num_rows() > 0){
			return $query->row_array();
		}
		return FALSE;
	}
	
	public function get_plate_to_form($plate_id){
		$this->db->where('plate_id', $plate_id);
		
		$this->db->from($this->db->dbprefix('bbs_plate'));//查
		$query = $this->db->get();
		
		$row=$query->row_array();
		
		$this->db->where('plate_id', $plate_id);
		$this->db->from($this->db->dbprefix('bbs_plate_description'));//查
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			$descriptions=$query->result_array();
			foreach($descriptions as $key=>$value){
				$description[$descriptions[$key]['language_id']]=$value;
			}
			$row['description']=$description;
			return $row;
		}
		return FALSE;
	}
	
	public function edit($data){
		$data['base']['plate_id']=$this->input->get('plate_id');
		
		$this->db->where('plate_id', $data['base']['plate_id']);
		$this->db->update($this->db->dbprefix('bbs_plate'), $data['base']);
		
		foreach($data['description'] as $key=>$value){
			$data['description'][$key]['plate_id']=$this->input->get('plate_id');
			$data['description'][$key]['language_id']=$key;
		}
		
		$this->db->delete($this->db->dbprefix('bbs_plate_description'), array('plate_id' => $this->input->get('plate_id')));
		$this->db->insert_batch($this->db->dbprefix('bbs_plate_description'), $data['description']);
	}
	
	public function add($data){
		$data['base']['date_added']=date("Y-m-d H:i:s");
		$this->db->insert($this->db->dbprefix('bbs_plate'), $data['base']);
		$plate_id=$this->db->insert_id();
		foreach($data['description'] as $key=>$value){
			$data['description'][$key]['plate_id']=$plate_id;
			$data['description'][$key]['language_id']=$key;
		}
		
		$this->db->insert_batch($this->db->dbprefix('bbs_plate_description'), $data['description']);
	}
	
	public function check_delete($data){
		$this->db->select('posting_id');
		$this->db->where_in('posting_id');
		$this->db->from($this->db->dbprefix('bbs_posting'));//查
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return TRUE;
		}
		
		return FALSE;
	}
	
	public function delete($data){
		foreach($data as $key=>$value){
			$this->db->delete($this->db->dbprefix('bbs_plate'), array('plate_id' => $data[$key]));
			$this->db->delete($this->db->dbprefix('bbs_plate_description'), array('plate_id' => $data[$key]));
		}
	}
	
	//删除帖子
	public function delete_posting($data){
		foreach($data as $key=>$value){
			$this->db->delete($this->db->dbprefix('bbs_posting'), array('posting_id' => $data[$key]));
			$this->db->delete($this->db->dbprefix('bbs_posting_description'), array('posting_id' => $data[$key]));
		}
	}
	
	//修改帖子状态
	public function edit_show($posting_id, $data){
		$this->db->where('posting_id', $posting_id);
		return $this->db->update($this->db->dbprefix('bbs_posting'), $data);	
	}
	
	//获取帖子
	public function get_postings($page){
		//统计表记录
		$row['count']=$this->db->count_all_results($this->db->dbprefix('bbs_posting'));
		
		$limit=$this->config->get_config('config_limit_admin');
		//
		$this->db->select('posting_id');
		$this->db->limit($limit, $page);
		$this->db->order_by('date_added', 'ASC');
		
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
	
	//获取帖子
	//获取帖子内容
	public function get_posting($posting_id){
		$this->db->select('bp.posting_id, bp.is_view, bp.is_top, bp.very_good, bp.date_added, bpd.title, bpd.description, u.nickname, bpld.title as plate_title, count(br.replies_id) as count');
		
		$this->db->where('bp.posting_id', $posting_id);
		$this->db->where('bpd.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('bbs_posting_description AS bpd', 'bpd.posting_id = bp.posting_id');
		//版块名
		$this->db->where('bpld.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('bbs_plate_description AS bpld', 'bpld.plate_id = bp.plate_id');
		
		//用户发帖人
		$this->db->join('user AS u', 'u.user_id = bp.user_id');
		
		//回帖数
		$this->db->join('bbs_replies AS br', 'br.posting_id = bp.posting_id', 'left');
		
		$this->db->from($this->db->dbprefix('bbs_posting') . ' AS bp');//查
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			return $query->row_array();
		}
		return FALSE;
	}
}