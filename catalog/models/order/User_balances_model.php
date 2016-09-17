<?php
class User_balances_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function update($data){
		if(!isset($data['user_id']) || empty($data['user_id'])){
			return FALSE;
			exit;
		}
		
		if(!isset($data['money']) || empty($data['money'])){
			$row['status']=FALSE;
			$row['msg']='金额不能为空！';
			return $row;
			exit;
		}
		
		if(!isset($data['content']) || empty($data['content']) || !is_array($data['content'])){
			$row['status']=FALSE;
			$row['msg']='支付说明不能为空！';
			return $row;
			exit;
		}
		
		if(!isset($data['operators']) || empty($data['operators'])){
			$row['status']=FALSE;
			$row['msg']='支付类型不能为空！';
			return $row;
			exit;
		}
		
		$old_balances=$this->get_balances($data['user_id']);
		
		$error_count=$this->user_balances_log($data['user_id']);
		if($error_count > 2){
			$row['status']=FALSE;
			$row['msg']='今天支付密码错误超3次，请明天再来！';
			return $row;
			exit;
		}
		
		if(!isset($data['pay_password']) || empty($data['pay_password']) || $data['pay_password'] != $old_balances['pay_password']){
			//密码错误
			$log['user_id']		=$data['user_id'];
			$log['ip'] 			=$this->input->ip_address();
			$log['agent'] 		=$this->input->user_agent();
			$log['date_limit'] 	=date("Y-m-d");
			$log['date_added'] 	=date("Y-m-d H:i:s");
			
			$this->db->insert($this->db->dbprefix('user_balances_log'), $log);
			$row['status']=FALSE;
			$row['msg']='支付密码错误！你今天还有' . (3 - $error_count) . '次尝试机会！';
			return $row;
			exit;
		}
		
		if($old_balances){
			$balances_id=$old_balances['id'];
			
			if($data['operators'] == '+'){
				$this->db->set('balances', $old_balances['balances'] + $data['money']);
				$row['balances']=$old_balances['balances'] + $data['money'];//帐户余额
			}elseif($data['operators'] == '-'){
				$this->db->set('balances', $old_balances['balances'] - $data['money']);
				$row['balances']=$old_balances['balances'] - $data['money'];//帐户余额
			}
			
			$this->db->where('id', $old_balances['id']);
			$this->db->where('user_id', $old_balances['user_id']);
			if($this->db->update($this->db->dbprefix('user_balances'))){
				$re_balances=TRUE;
			}
		}else{
			$bala_in['user_id'] = $data['user_id'];
			
			if($data['operators'] == '+'){
				$bala_in['balances'] = '0' + $data['money'];
				$row['balances']='0' + $data['money'];//帐户余额
			}elseif($data['operators'] == '-'){
				$bala_in['balances'] = '0' - $data['money'];
				$row['balances']='0' - $data['money'];//帐户余额
			}

			if($this->db->insert($this->db->dbprefix('user_balances'), $bala_in)){
				$balances_id=$this->db->insert_id();
				$re_balances=TRUE;
			}
			
		}
		
		if(isset($re_balances)){
			$balances_activity = array(
			    'balances_id' 	=> $balances_id,
			    'operators' 	=> $data['operators'],
			    'money' 		=> $data['money'],
			    'balances' 		=> $row['balances'],
			    'ip' 			=> $this->input->ip_address(),
			    'agent' 		=> $this->input->user_agent(),
			    'content' 		=> serialize($data['content']),
			    'date_added' 	=> date("Y-m-d H:i:s")
			);
			if($this->db->insert($this->db->dbprefix('user_balances_activity'), $balances_activity)){
				
				$row['status']=TRUE;
				$row['msg']='恭喜你，支付成功!';
				$row['money']=$data['money'];
				return $row;
				exit;
			}else{
				return FALSE;
				exit;
			}
		}
		return FALSE;
		exit;
	}
	
	public function get_balances($user_id){
		if(empty($user_id)){
			return FALSE;
		}
		
		$this->db->where('user_id', $user_id);
		$this->db->from($this->db->dbprefix('user_balances'));
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			return $query->row_array();
		}
		
		return FALSE;
	}
	
	public function user_balances_log($user_id){
		$this->db->select('count(*) as count');
		$this->db->where('user_id', $user_id);
		$this->db->where('date_limit', date("Y-m-d"));
		$this->db->from($this->db->dbprefix('user_balances_log'));
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			return $query->row_array()['count'];
		}
		return FALSE;
	}
	
	public function edit_pay_password($data){
		$old=$this->get_balances($data['user_id']);
		if($old){
			$this->db->set('pay_password', $data['pay_password']);
			$this->db->where('id', $old['id']);
			$this->db->where('user_id', $old['user_id']);
			if($this->db->update($this->db->dbprefix('user_balances'))){
				return TRUE;
			}
		}else{
			$bala_in['user_id']=$data['user_id'];
			if($this->db->insert($this->db->dbprefix('user_balances'), $bala_in)){
				return TRUE;
			}
		}
		return FALSE;
	}
	
	public function get_balances_activitys($data){
		if(!isset($data['user_id'])){
			return FALSE;
		}
		
		$limit=$this->config->get_config('config_limit_admin');
		
		//统计表记录
		if(isset($data['operators']) && $data['operators'] == '+'){
			$this->db->where('user_balances.operators', '+');
		}
		
		if(isset($data['operators']) && $data['operators'] == '-'){
			$this->db->where('user_balances.operators', '-');
		}
		
		$this->db->where('user_balances.user_id', $data['user_id']);
		$this->db->join('user_balances_activity', 'user_balances_activity.balances_id = user_balances.id');
		$row['count']=$this->db->count_all_results($this->db->dbprefix('user_balances'));
		
		$this->db->select('user_balances_activity.money, user_balances_activity.balances, user_balances_activity.content, user_balances_activity.ip, user_balances_activity.date_added, user_balances_activity.operators');
		if(isset($data['operators']) && $data['operators'] == '+'){
			$this->db->where('user_balances.operators', '+');
		}
		
		if(isset($data['operators']) && $data['operators'] == '-'){
			$this->db->where('user_balances.operators', '-');
		}
		
		$this->db->where('user_balances.user_id', $data['user_id']);
		$this->db->join('user_balances_activity', 'user_balances_activity.balances_id = user_balances.id');
		
		$this->db->limit($limit, $data['page']);
		$this->db->order_by('user_balances_activity.date_added', 'DESC');
		$this->db->from($this->db->dbprefix('user_balances'));
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			$row['activitys']=$query->result_array();
			return $row;
		}
		
		return FALSE;
	}
}