<?php
class User_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	//
	public function get_users($data=array())
	{
		if(isset($data['nickname'])){
			$this->db->where('nickname = '.$data['nickname']);
		}
		if(isset($data['user_group_id'])){
			$this->db->where('user_group_id = '.$data['user_group_id']);
		}
		
		if(isset($data['date_added'])){
			$this->db->like('date_added', $data['date_added']);
		}
		if(isset($data['email'])){
			$this->db->where('email', "'".$data['email']."'", FALSE);
		}
		if(isset($data['status'])){
			$this->db->where('status = '.$data['status']);
		}
		if(isset($data['ip'])){
			$this->db->where('ip = '.$data['ip']);
		}
		//统计表记录
		$user_s['count']=$this->db->count_all_results($this->db->dbprefix('user'));
		
		
		if(isset($data['page'])){
			$limit=$this->config->get_config('config_limit_admin');
			$this->db->limit($limit,$data['page']);
		}
		
		if(isset($data['order_dy'])){
			$this->db->order_by("," . $data['order_dy'] . ",");
		}else{
			$this->db->order_by('user_id','DESC');
		}
		
		if(isset($data['nickname'])){
			$this->db->where('nickname = '.$data['nickname']);
		}
		if(isset($data['user_group_id'])){
			$this->db->where('user_group_id = '.$data['user_group_id']);
		}
		
		if(isset($data['date_added'])){
			$this->db->like('date_added', $data['date_added']);
		}
		if(isset($data['email'])){
			$this->db->where('email', "'".$data['email']."'", FALSE);
		}
		if(isset($data['status'])){
			$this->db->where('status = '.$data['status']);
		}
		if(isset($data['ip'])){
			$this->db->where('ip = '.$data['ip']);
		}
		
		$this->db->select('user_id');
		
		//$this->db->from($this->db->dbprefix('user'));
		
		$query = $this->db->get($this->db->dbprefix('user'));
		
		if($query->num_rows() > 0){
			$users = $query->result_array();
			$users = array_flip(array_flip(array_column($users,'user_id')));
			foreach ($users as $user) {
				$user_s['users'][] = $this->get_user($user);
			}
			return $user_s;
		}
		
		return FALSE;
	}
	
	public function get_user($user_id='')
	{
		if(empty($user_id)){
			return FALSE;
		}
		$this->db->select('*');
		$this->db->where('user.user_id',$user_id);
		$this->db->where('user_group_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('user_group_description','user_group_description.user_group_id = user.user_group_id');
		$this->db->from($this->db->dbprefix('user'));
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			return $query->row_array();
		}
		
		return FALSE;
	}
	
	public function get_user_groups($data=array())
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
		$user_group_s['count']=$this->db->count_all_results($this->db->dbprefix('user_group'));
		
		if(isset($data['page'])){
			$limit=$this->config->get_config('config_limit_admin');
			$this->db->limit($limit,$data['page']);
		}
		
		$this->db->select('user_group.user_group_id');
		
		if(isset($data['order_dy'])){
			$this->db->order_by("," . $data['order_dy'] . ",");
		}else{
			$this->db->order_by('user_group.sort_order','ASC');
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
		//$this->db->from($this->db->dbprefix('user_group'));
		$query = $this->db->get($this->db->dbprefix('user_group'));
		
		
		if($query->num_rows() > 0){
			$user_groups = $query->result_array();
			$user_groups = array_flip(array_flip(array_column($user_groups,'user_group_id')));
			foreach ($user_groups as $user_group) {
				$user_group_s['user_groups'][] = $this->get_user_group($user_group);
			}
			
			return $user_group_s;
		}
		
		return FALSE;
	}
	
	public function get_user_groups_all()
	{
		$this->db->select('user_group.user_group_id');
		$this->db->order_by('user_group.sort_order','ASC');
		
		$this->db->from($this->db->dbprefix('user_group'));
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			$user_groups = $query->result_array();
			$user_groups = array_flip(array_flip(array_column($user_groups,'user_group_id')));
			foreach ($user_groups as $user_group) {
				$user_group_s[] = $this->get_user_group($user_group);
			}
			
			return $user_group_s;
		}
		
		return FALSE;
	}
	
	public function get_user_group($user_group_id)
	{
		$this->db->select('*');
		$this->db->where('user_group.user_group_id',$user_group_id);
		$this->db->where('user_group_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('user_group_description','user_group_description.user_group_id = user_group.user_group_id');
		$this->db->from($this->db->dbprefix('user_group'));
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			return $query->row_array();
		}
		
		return FALSE;
	}
	
	public function get_user_group_from($user_group_id)
	{
		$this->db->select('*');
		$this->db->where('user_group.user_group_id',$user_group_id);
		$this->db->from($this->db->dbprefix('user_group'));
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			$row['user_group']=$query->row_array();
			
			//查描述
			$this->db->where('user_group_description.user_group_id',$user_group_id);
			$this->db->from($this->db->dbprefix('user_group_description'));
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
	
	public function get_user_historys($data=array()){
		if(empty($data['user_id'])){
			return FALSE;
		}
		
		$this->db->where('user_id',$data['user_id']);
		//统计
		$row['count']   =$this->db->count_all_results($this->db->dbprefix('user_history'));
		
		$this->db->limit($this->config->get_config('config_limit_admin'), $data['page']);
		$this->db->where('user_id',$data['user_id']);
		//$this->db->from($this->db->dbprefix('user_history'));
		$query = $this->db->get($this->db->dbprefix('user_history'));
		
		
		if($query->num_rows() > 0){
			$row['historys']=$query->result_array();
			return $row;
		}
		return FALSE;
	}
	
	public function get_user_transactions($data=array())
	{
		if(empty($data['user_id'])){
			return FALSE;
		}
		
		$this->db->where('user_id',$data['user_id']);
		//统计
		$row['count']   =$this->db->count_all_results($this->db->dbprefix('user_transaction'));
		
		$this->db->limit($this->config->get_config('config_limit_admin'), $data['page']);
		$this->db->where('user_id',$data['user_id']);
		//$this->db->from($this->db->dbprefix('user_transaction'));
		$query = $this->db->get($this->db->dbprefix('user_transaction'));
		
		if($query->num_rows() > 0){
			$row['user_transactions']=$query->result_array();
			return $row;
		}
		return FALSE;
	}
	
	public function get_user_rewards($data=array())
	{
		if(empty($data['user_id'])){
			return FALSE;
		}
		
		$this->db->where('user_id',$data['user_id']);
		//
		$row['count']   =$this->db->count_all_results($this->db->dbprefix('user_reward'));
		
		
		$this->db->limit($this->config->get_config('config_limit_admin'), $data['page']);
		$this->db->where('user_id',$data['user_id']);
		//$this->db->from($this->db->dbprefix('user_reward'));
		$query = $this->db->get($this->db->dbprefix('user_reward'));
		
		if($query->num_rows() > 0){
			$row['user_rewards']=$query->result_array();
			return $row;
		}
		return FALSE;
	}
	
	//添加历史
	public function add_history($data){
		$this->db->insert($this->db->dbprefix('user_history'), $data);
	}
	//添加交易
	public function add_transaction($data){
		$this->db->insert($this->db->dbprefix('user_transaction'), $data);
	}
	
	//添加交易
	public function add_reward($data){
		$this->db->insert($this->db->dbprefix('user_reward'), $data);
	}
	
	//拉黑ip
	public function add_ban_ip($data){
		$this->db->replace($this->db->dbprefix('user_ban_ip'), $data);
	}
	
	//查ip黑名单
	public function get_ban_ips(){
		$this->db->select('ip');
		$this->db->from($this->db->dbprefix('user_ban_ip'));
		$query=$this->db->get();
		if($query->num_rows() > 0){
			$row=$query->result_array();
			$ban_ip=array_flip(array_flip(array_column($row,'ip')));
			return $ban_ip;
		}
		return array();
	}
	
	//修改用户
	public function edit_user($data){
		foreach($data as $key=>$value){
			if(empty($data[$key])){
				unset($data[$key]);
			}
		}
		
		$this->db->where('user_id', $data['user_id']);
		$this->db->update($this->db->dbprefix('user'), $data);
	}
	
	//修改用户
	public function edit_address($data, $user_id){
		
		if(empty($data) || !is_array($data) || !isset($user_id)){
			return FALSE;
		}
		
		$this->db->select('address_id');
		$this->db->where('user_id',$user_id);
		$this->db->from($this->db->dbprefix('address'));
		$query=$this->db->get();
		if($query->num_rows() > 0){
			$address_ids=$query->result_array();
			$address_ids=array_flip(array_flip(array_column($address_ids,'address_id')));
		}else{
			foreach($data as $key=>$value){
				$data[$key]['address_id']=$key;
				$data[$key]['user_id']=$user_id;
				//更新user表的address_id字段，也就是默认地址
				if($data[$key]['default'] == '1'){
					$up_user['address_id']=$data[$key]['address_id'];
					$this->db->where('user_id', $user_id);
					$this->db->update($this->db->dbprefix('user'), $up_user);
					$this->db->reset_query();
				}
				//插入数据
				unset($data[$key]['default']);
				unset($data[$key]['address_id']);
				$this->db->insert($this->db->dbprefix('address'), $data[$key]);
			}
			return;
		}
		foreach($data as $key=>$value){
			$new_ids[]=$key;
		}
		$diffs=array_diff($address_ids,$new_ids);
		foreach($diffs as $diff){
			$this->db->delete($this->db->dbprefix('address'), array('address_id' => $diff));
		}
		foreach($data as $key=>$value){
			$data[$key]['address_id']=$key;
			$data[$key]['user_id']=$user_id;
				//更新user表的address_id字段，也就是默认地址
				if($data[$key]['default'] == '1'){
					$up_user['address_id']=$data[$key]['address_id'];
					$this->db->where('user_id', $user_id);
					$this->db->update($this->db->dbprefix('user'), $up_user);
					$this->db->reset_query();
				}
			//更新address表
			unset($data[$key]['default']);
			$this->db->replace($this->db->dbprefix('address'), $data[$key]);
		}
		//$this->db->replace($this->db->dbprefix('address'), $data);
	}
	
	public function edit_user_group($data){
		$this->db->where('user_group_id', $data['user_group_id']);
		$this->db->update($this->db->dbprefix('user_group'), $data);
	}
	public function edit_user_group_description($user_group_id, $data){
		$this->db->delete($this->db->dbprefix('user_group_description'), array('user_group_id' => $user_group_id));
		$this->db->insert_batch($this->db->dbprefix('user_group_description'), $data);
	}
	
	public function get_user_groups_to_other()
	{
		$this->db->select('user_group_id');
		$this->db->from($this->db->dbprefix('user_group'));
		
		$query=$this->db->get();
		if($query->num_rows() > 0){
			$result=$query->result_array();
			foreach($result as $key=>$value){
				$row[]=$this->get_user_group($result[$key]['user_group_id']);
			}
			
			return $row;
		}
		
		return false;
	}
	
	public function add_user_group($data)
	{
		$permission['access']=$data['user_group']['access'];
		$permission['modify']=$data['user_group']['modify'];
		unset($data['user_group']['access']);
		unset($data['user_group']['modify']);
		$data['user_group']['permission']=serialize($permission);
		
		//写入user_group表
		$this->db->insert($this->db->dbprefix('user_group'), $data['user_group']);
		
		//写入descript表
		//取最后查入的一第分类id
		$user_group_id=$this->db->insert_id();
		
		foreach($data['description'] as $key=>$value){
			$data['description'][$key]['language_id']=$key;
			$data['description'][$key]['user_group_id']=$user_group_id;
		}
		
		$this->db->insert_batch($this->db->dbprefix('user_group_description'), $data['description']);
		$this->db->reset_query();
		
		return TRUE;
	}
	
	public function check_delete($user_group_id)
	{
		if(empty($user_group_id)){
			return FALSE;
		}
		
		$this->db->where('user_group_id', $user_group_id);
		$this->db->from($this->db->dbprefix('order'));
		$query=$this->db->get();
		if($query->num_rows() > 0){
			return FALSE;
		}
		
		$this->db->where('user_group_id', $user_group_id);
		$this->db->from($this->db->dbprefix('product_discount'));
		$query=$this->db->get();
		if($query->num_rows() > 0){
			return FALSE;
		}

		$this->db->where('user_group_id', $user_group_id);
		$this->db->from($this->db->dbprefix('product_special'));
		$query=$this->db->get();
		if($query->num_rows() > 0){
			return FALSE;
		}
		
		$this->db->where('user_group_id', $user_group_id);
		$this->db->from($this->db->dbprefix('tax_rate_to_user_group'));
		$query=$this->db->get();
		if($query->num_rows() > 0){
			return FALSE;
		}
		
		$this->db->where('user_group_id', $user_group_id);
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
			$this->db->delete($this->db->dbprefix('user_group'), array('user_group_id' => $value));
			$this->db->delete($this->db->dbprefix('user_group_description'), array('user_group_id' => $value));
		}
		return TRUE;
	}
	
	//取用户权限表
	public function get_user_competence($user_id){
		$this->db->select('value');
		$this->db->where('user_id', $user_id);
		$this->db->where('key', 'access');
		$query=$this->db->get($this->db->dbprefix('user_competence'));
		if($query->num_rows() > 0){
			$row['access']=json_decode($query->row_array()['value']);
		}
		
		$this->db->select('value');
		$this->db->where('user_id', $user_id);
		$this->db->where('key', 'edit');
		$query=$this->db->get($this->db->dbprefix('user_competence'));
		if($query->num_rows() > 0){
			$row['edit']=json_decode($query->row_array()['value']);
		}
		
		if(isset($row)){
			return $row;
		}else{
			return FALSE;
		}
	}
	
	//修改权限
	public function edit_user_competence($data, $user_id){
		$this->db->delete($this->db->dbprefix('user_competence'), array('user_id' => $user_id)); 
		
		$access['user_id']=$user_id;
		$access['key']='access';
		foreach($data['user_access'] as $k=>$v){   
		    if( !$v )   
		        unset($data['user_access'][$k] );
		}
		$access['value']=json_encode($data['user_access']);
		$this->db->insert($this->db->dbprefix('user_competence'), $access);
		
		$edit['user_id']=$user_id;
		$edit['key']='edit';
		foreach($data['user_edit'] as $k=>$v){   
		    if( !$v )   
		        unset($data['user_edit'][$k] );   
		}
		$edit['value']=json_encode($data['user_edit']);
		$this->db->insert($this->db->dbprefix('user_competence'), $edit);
	}
	
	public function update_user_to_user_id($data){
		$this->db->where('user_id', $data['user_id']);
		$this->db->update($this->db->dbprefix('user'), $data);
	}
}