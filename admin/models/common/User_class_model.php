<?php
class User_class_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function get_user_classs($data=array())
	{
		if(isset($data['where'])){
			if(is_array($data['where'])){
				foreach($data['where'] as $where){
					$this->db->where("," . $where . ",");
				}
			}else{
				$this->db->where("," . $data['where'] . ",");
			}
		}
		//统计表记录
		$user_class_s['count']=$this->db->count_all_results($this->db->dbprefix('user_class'));
		
		if(isset($data['page'])){
			$limit=$this->config->get_config('config_limit_admin');
			$this->db->limit($limit,$data['page']);
		}
		
		$this->db->select('user_class.user_class_id');
		
		if(isset($data['order_dy'])){
			$this->db->order_by("," . $data['order_dy'] . ",");
		}else{
			$this->db->order_by('user_class.sort_order','ASC');
		}
		
		if(isset($data['where'])){
			if(is_array($data['where'])){
				foreach($data['where'] as $where){
					$this->db->where("," . $where . ",");
				}
			}else{
				$this->db->where("," . $data['where'] . ",");
			}
		}
		//$this->db->from($this->db->dbprefix('user_class'));
		$query = $this->db->get($this->db->dbprefix('user_class'));
		
		
		if($query->num_rows() > 0){
			$user_classs = $query->result_array();
			$user_classs = array_flip(array_flip(array_column($user_classs,'user_class_id')));
			foreach ($user_classs as $user_class) {
				$user_class_s['user_classs'][] = $this->get_user_class($user_class);
			}
			
			return $user_class_s;
		}
		
		return FALSE;
	}
	
	//给设置
	public function get_user_classs_to_setting()
	{
		$this->db->select('user_class.user_class_id');
		
		$this->db->order_by('user_class.sort_order','ASC');
		
		$query = $this->db->get($this->db->dbprefix('user_class'));
		
		
		if($query->num_rows() > 0){
			$user_classs = $query->result_array();
			$user_classs = array_flip(array_flip(array_column($user_classs,'user_class_id')));
			foreach ($user_classs as $user_class) {
				$user_class_s[] = $this->get_user_class($user_class);
			}
			
			return $user_class_s;
		}
		
		return FALSE;
	}
	
	public function get_user_classs_all()
	{
		$this->db->select('user_class.user_class_id');
		$this->db->order_by('user_class.sort_order','ASC');
		
		$this->db->from($this->db->dbprefix('user_class'));
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			$user_classs = $query->result_array();
			$user_classs = array_flip(array_flip(array_column($user_classs,'user_class_id')));
			foreach ($user_classs as $user_class) {
				$user_class_s[] = $this->get_user_class($user_class);
			}
			
			return $user_class_s;
		}
		
		return FALSE;
	}
	
	public function get_user_class($user_class_id)
	{
		$this->db->select('*');
		$this->db->where('user_class.user_class_id',$user_class_id);
		$this->db->where('user_class_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('user_class_description','user_class_description.user_class_id = user_class.user_class_id');
		$this->db->from($this->db->dbprefix('user_class'));
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			return $query->row_array();
		}
		
		return FALSE;
	}
	
	public function get_user_class_from($user_class_id)
	{
		$this->db->select('*');
		$this->db->where('user_class.user_class_id',$user_class_id);
		$this->db->from($this->db->dbprefix('user_class'));
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			$row['user_class']=$query->row_array();
			
			//查描述
			$this->db->where('user_class_description.user_class_id',$user_class_id);
			$this->db->from($this->db->dbprefix('user_class_description'));
			$query = $this->db->get();
			if($query->num_rows() > 0){
				$descriptions = $query->result_array();
				foreach($descriptions as $key=>$value){
					$description[$descriptions[$key]['language_id']]=$value;
				}
				
				$row['description']=$description;
			}
			
			return $row;
		}
		
		return FALSE;
	}

	public function edit_user_class($data){
		$this->db->where('user_class_id', $data['user_class_id']);
		$this->db->update($this->db->dbprefix('user_class'), $data);
	}
	public function edit_user_class_description($user_class_id, $data){
		$this->db->delete($this->db->dbprefix('user_class_description'), array('user_class_id' => $user_class_id));
		$this->db->insert_batch($this->db->dbprefix('user_class_description'), $data);
	}

	public function add_user_class($data)
	{
		//写入user_class表
		$this->db->insert($this->db->dbprefix('user_class'), $data['user_class']);
		
		//写入descript表
		//取最后查入的一第分类id
		$user_class_id=$this->db->insert_id();
		
		foreach($data['description'] as $key=>$value){
			$data['description'][$key]['language_id']=$key;
			$data['description'][$key]['user_class_id']=$user_class_id;
		}
		
		$this->db->insert_batch($this->db->dbprefix('user_class_description'), $data['description']);
		$this->db->reset_query();
		
		return TRUE;
	}
	
	public function check_delete($user_class_id)
	{
		if(empty($user_class_id)){
			return FALSE;
		}
		
		$this->db->where('user_class_id', $user_class_id);
		$this->db->from($this->db->dbprefix('order'));
		$query=$this->db->get();
		if($query->num_rows() > 0){
			return FALSE;
		}
		
		$this->db->where('user_class_id', $user_class_id);
		$this->db->from($this->db->dbprefix('product_discount'));
		$query=$this->db->get();
		if($query->num_rows() > 0){
			return FALSE;
		}
		
		$this->db->where('user_class_id', $user_class_id);
		$this->db->from($this->db->dbprefix('product_special'));
		$query=$this->db->get();
		if($query->num_rows() > 0){
			return FALSE;
		}
		
		$this->db->where('user_class_id', $user_class_id);
		$this->db->from($this->db->dbprefix('tax_rate_to_user_class'));
		$query=$this->db->get();
		if($query->num_rows() > 0){
			return FALSE;
		}
		
		$this->db->where('user_class_id', $user_class_id);
		$this->db->from($this->db->dbprefix('user'));
		$query=$this->db->get();
		if($query->num_rows() > 0){
			return FALSE;
		}
		
		return TRUE;
	}
	
	public function delete($data)
	{
		foreach($data as $value){
			$this->db->delete($this->db->dbprefix('user_class'), array('user_class_id' => $value));
			$this->db->delete($this->db->dbprefix('user_class_description'), array('user_class_id' => $value));
		}
		return TRUE;
	}
}