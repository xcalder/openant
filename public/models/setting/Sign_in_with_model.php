<?php
class Sign_in_with_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function get_sign_with($name)
	{
		$this->db->select('setting, name');
		$this->db->where('code', 'sign_in_with');
		$this->db->where('name', $name);
		$this->db->from($this->db->dbprefix('module'));
		$query=$this->db->get();
		
		if($query->num_rows() > 0){
			$array=array();
			$row					=$query->row_array();
			$setting				=unserialize($row['setting']);
			
			$array['name']			=$row['name'];
			$array['id']			=$setting['appid'];
			$array['secret']		=$setting['appkey'];
			$array['extra']			=$setting['extra'];
			
			return $array;
		}
		return FALSE;
	}
	
	public function get_sign_with_toedit()
	{
		$this->db->select('*');
		$this->db->where('user_id', $_SESSION['user_id']);
		$this->db->from($this->db->dbprefix('user_sign_in_with'));
		$query=$this->db->get();
		if($query->num_rows() > 0){
			return $query->result_array();
		}
		return FALSE;
	}

	public function get_sign_withs(){
		$this->db->select('setting, name');
		$this->db->where('code', 'sign_in_with');
		$this->db->order_by('store_order', 'ASC');
		$this->db->from($this->db->dbprefix('module'));
		$query=$this->db->get();
		
		if($query->num_rows() > 0){
			$array=array();
			$row=$query->result_array();
			foreach($row as $key=>$value){
				$array[$row[$key]['name']]['setting']=unserialize($row[$key]['setting']);
				if($array[$row[$key]['name']]['setting']['status'] == '0'){
					unset($array[$row[$key]['name']]);
				}
			}
			return $array;
		}
		return FALSE;
	}
	
	public function select_user_for_vid($via, $uid){
		$this->db->select('user_id');
		$this->db->where('via', $via);
		$this->db->where('uid', $uid);
		$this->db->from($this->db->dbprefix('user_sign_in_with'));
		$query=$this->db->get();
		
		if($query->num_rows() > 0){
			return $query->row_array()['user_id'];
		}
		return FALSE;
	}
	
	public function add_user_sign_in_with($data){
		
		$this->db->insert($this->db->dbprefix('user'), $data['adduser']);
		$data['addsgin']['user_id']=$this->db->insert_id();
		$_SESSION['user_id']=$data['addsgin']['user_id'];
		
		$this->db->insert($this->db->dbprefix('user_sign_in_with'), $data['addsgin']);
		
		$this->load->model('common/user_activity_model');
		$this->user_activity_model->add_activity($data['addsgin']['user_id'], 'register', array('title'=>sprintf(lang_line('success_bind_login'), $data['adduser']['nickname']), 'msg'=>''));
	}
	
	//帐号绑定
	public function add_bind_accounts($data){
		$data['addsgin']['user_id']=$_SESSION['user_id'];
		$this->db->insert($this->db->dbprefix('user_sign_in_with'), $data['addsgin']);
		
		$this->load->model('common/user_activity_model');
		
		$this->user_activity_model->add_activity($data['addsgin']['user_id'], 'bind', array('title'=>sprintf(lang_line('success_bind'), $data['adduser']['nickname']), 'msg'=>''));
	}
	
	//解绑
	public function unbundling($via, $nickname){
		$this->db->where('via', $via);
		$this->db->where('user_id', $_SESSION['user_id']);
		$this->db->delete($this->db->dbprefix('user_sign_in_with'));
	}
}