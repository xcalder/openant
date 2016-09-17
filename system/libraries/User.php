<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class CI_User {
	private $user_id;
	private $firstname;
	private $lastname;
	private $nickname;
	private $user_group_id;
	private $user_class_id;
	private $sale_class_id;
	private $email;
	private $telephone;
	private $newsletter;
	private $address_id;
	private $store_id;
	private $date_added;
	private $permission = array();
	private $competence = array();

	public function __construct() {
		$this->CI =& get_instance();
		$this->CI->load->library(array('session', 'cart'));
		$this->CI->load->database();//链接数据库

		if (isset($_SESSION['user_id'])) {
			
			$this->CI->db->where('user_id', $_SESSION['user_id']);
			$this->CI->db->where('status', '1');
			$this->CI->db->from($this->CI->db->dbprefix('user'));
			$user_query = $this->CI->db->get();
			
			if ($user_query->row_array()) {
				$this->user_id = $user_query->row_array()['user_id'];
				$this->firstname = $user_query->row_array()['firstname'];
				$this->lastname = $user_query->row_array()['lastname'];
				$this->nickname = $user_query->row_array()['nickname'];
				$this->user_group_id = $user_query->row_array()['user_group_id'];
				$this->user_class_id = $user_query->row_array()['user_class_id'];
				$this->sale_class_id = $user_query->row_array()['sale_class_id'];
				$this->email = $user_query->row_array()['email'];
				$this->telephone = $user_query->row_array()['telephone'];
				$this->store_id = $user_query->row_array()['store_id'];
				$this->date_added = $user_query->row_array()['date_added'];
				$this->newsletter = $user_query->row_array()['newsletter'];
				$this->address_id = $user_query->row_array()['address_id'];
				
				//判断用户组权限
				$this->CI->db->select('permission');
				$this->CI->db->where('user_group_id', $this->user_group_id);
				$this->CI->db->from($this->CI->db->dbprefix('user_group'));
				$query = $this->CI->db->get();
				
				if($query->num_rows() > 0){
					
					$permissions = $query->row_array()['permission'];
					$permissions = unserialize($permissions);

					foreach ($permissions as $key => $value) {
						$this->permission[$key] = $value;
					}
				}
				
				//判断单个用户权限
				$this->CI->db->select('value, key');
				$this->CI->db->where('user_id',$_SESSION['user_id']);
				$this->CI->db->from($this->CI->db->dbprefix('user_competence'));
				
				$query = $this->CI->db->get();
				if($query->num_rows() > 0){
					$row = $query->result_array();
					//$row = array_column($row,'value');
					foreach($row as $competence){
						$this->competence[]=$competence;
					}
					
				}
				
			} else {
				$this->logout();
			}
		}
	}

	public function login($email, $password, $override = false) {
		if ($override) {
			$user_query = $this->CI->db->query("SELECT * FROM " . $this->db->dbprefix('user') . " WHERE LOWER(email) = '" . $this->CI->db->escape($email) . "' AND status = '1'");
		} else {
			$user_query = $this->CI->db->query("SELECT * FROM " . $this->CI->db->dbprefix('user') . " WHERE LOWER(email) = " . $this->CI->db->escape($email) . " AND password = " . $this->CI->db->escape(md5($password)) . " AND status = '1' AND approved = '1'");
		}

		if ($user_query->row_array()) {
			$_SESSION['user_id'] = $user_query->row_array()['user_id'];
			
			/**
			* 把购物车信息从数据库取出写入到session中
			* @var 
			* 
			*/
			$this->CI->db->select('rowid, id, qty, price, name, options, points, preferential_type, preferential_value');
			$this->CI->db->where('user_id', $user_query->row_array()['user_id']);
			$this->CI->db->from($this->CI->db->dbprefix('user_cart'));
			$cart_query=$this->CI->db->get();
			if($cart_query->num_rows() > 0){
				$cart_contents=array();
				$cart_arr=$cart_query->result_array();
				foreach($cart_arr as $key=>$value){
					$cart_arr[$key]['options']=explode('.', $cart_arr[$key]['options']);
					$cart_contents[$cart_arr[$key]['rowid']]=$cart_arr[$key];
					$cart_contents[$cart_arr[$key]['rowid']]['subtotal']=$cart_arr[$key]['qty'] * $cart_arr[$key]['price'];
				}
				$cart_contents['cart_total']=array_sum(array_column($cart_contents,'price'));
				$cart_contents['total_items']=array_sum(array_column($cart_contents,'qty'));
				$_SESSION['cart_contents']=$cart_contents;
			}
			

			$this->user_id = $user_query->row_array()['user_id'];
			$this->firstname = $user_query->row_array()['firstname'];
			$this->lastname = $user_query->row_array()['lastname'];
			$this->nickname = $user_query->row_array()['nickname'];
			$this->user_group_id = $user_query->row_array()['user_group_id'];
			$this->user_class_id = $user_query->row_array()['user_class_id'];
			$this->sale_class_id = $user_query->row_array()['sale_class_id'];
			$this->email = $user_query->row_array()['email'];
			$this->telephone = $user_query->row_array()['telephone'];
			$this->newsletter = $user_query->row_array()['newsletter'];
			$this->address_id = $user_query->row_array()['address_id'];

			return true;
		} else {
			$this->CI->db->select('user_login_id');
			$this->CI->db->where('ip', $this->CI->input->ip_address());
			$this->CI->db->where('email', $email);
			$this->CI->db->from($this->CI->db->dbprefix('user_login'));
			$query=$this->CI->db->get();
			if($query->num_rows() > 0){
				$this->CI->db->query("UPDATE " . $this->CI->db->dbprefix('user_login') . " SET total = total + 1 , date_modified = '" . date("Y-m-d H:i:s") . "' WHERE ip = " . $this->CI->db->escape($this->CI->input->ip_address()) . " AND email = " . $this->CI->db->escape($email) . "");
			}else{
				$user_login['email']=$email;
				$user_login['ip']=$this->CI->input->ip_address();
				$user_login['total']='1';
				$user_login['date_added']=date("Y-m-d H:i:s");
				$user_login['date_modified']=date("Y-m-d H:i:s");
				$this->CI->db->insert($this->CI->db->dbprefix('user_login'), $user_login);
			}
			return false;
		}
	}

	public function logout() {
		unset($_SESSION['user_id']);
		unset($_SESSION['token']);
		$this->CI->cart->destroy();
		$this->user_id = '';
		$this->firstname = '';
		$this->lastname = '';
		$this->nickname = '';
		$this->user_group_id = '';
		$this->user_class_id = '';
		$this->sale_class_id = '';
		$this->email = '';
		$this->telephone = '';
		$this->newsletter = '';
		$this->address_id = '';
	}

	public function isLogged() {
		return $this->user_id;
	}
	
	public function hasPermission($key, $value) {
		if (isset($this->permission[$key])) {
			return in_array($value, $this->permission[$key]);
		} else {
			return false;
		}
	}
	
	//后台和卖家中心访问权限
	public function hasPermission_access($key) {
		if (isset($this->permission['access'])){
			foreach($this->permission['access'] as $k=>$v){
				if(strpos($this->permission['access'][$k], $key) !== false){
					return $this->permission['access'][$k];
				}else{
					$c=FALSE;
				}
			}
			if(isset($c)){
				return $c;
			}
		}else {
			return false;
		}
		return false;
	}

	public function getId() {
		return $this->user_id;
	}

	public function getFirstName() {
		return $this->firstname;
	}

	public function getLastName() {
		return $this->lastname;
	}
	
	public function getnickname() {
		return $this->nickname;
	}

	public function getGroupId() {
		return $this->user_group_id;
	}
	
	public function getUserclassId() {
		return $this->user_class_id;
	}
	
	public function getSaleclassId() {
		return $this->sale_class_id;
	}

	public function getEmail() {
		return $this->email;
	}

	public function getTelephone() {
		return $this->telephone;
	}

	public function getNewsletter() {
		return $this->newsletter;
	}
	
	public function getStore_id() {
		return $this->store_id;
	}
	
	public function getDate_added() {
		return $this->date_added;
	}

	public function getAddressId() {
		return $this->address_id;
	}

	public function getBalance() {
		$query = $this->db->query("SELECT SUM(amount) AS total FROM " . $this->CI->db->dbprefix('user_transaction') . " WHERE user_id = '" . (int)$this->user_id . "'");

		return $query->row['total'];
	}

	public function getRewardPoints() {
		$query = $this->db->query("SELECT SUM(points) AS total FROM " . $this->CI->db->dbprefix('user_reward') . " WHERE user_id = '" . (int)$this->user_id . "'");

		return $query->row['total'];
	}
	
	public function has_competence ($key,$value)
	{
		if(!isset($key) || !isset($value)){
			return FALSE;
		}
		if($this->isLogged()){
			foreach ($this->competence as $competence){
				foreach($competence as $key_=>$value_){
					if($key == $value_){
						$cpt = json_decode($competence['value']);
					}
				}
			}
			
			if(!isset($cpt) || !is_array($cpt)){
				return FALSE;
			}
			if(in_array($value,$cpt)){
				return TRUE;
			}
		}
		return FALSE;
	}
}
