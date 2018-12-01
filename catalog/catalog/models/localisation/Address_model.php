<?php
class Address_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	//查地址
	public function get_addresss($user_id='')
	{
		if(empty($user_id)){
			return FALSE;
		}
		$this->db->select('address.address_id');
		$this->db->where('address.user_id', $user_id);
		$this->db->from($this->db->dbprefix('address'));
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			$address_ids=$query->result_array();
			$address_ids=array_flip(array_flip(array_column($address_ids,'address_id')));
			
			foreach($address_ids as $key=>$address_id){
				$row[$key]['address_id']=$address_ids[$key];
				$row[$key]['address']=$this->get_address($address_ids[$key]);
			}
			return $row;
		}
		return FALSE;
	}
	
	public function get_address($address_id){
		if(empty($address_id)){
			return FALSE;
		}
		
		$this->db->select('address.lastname, address.firstname, address.address, address.postcode, address.city, country.address_format, country_description.name, zone_description.zone_name');
		$this->db->where('address.address_id', $address_id);
		$this->db->where('country_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->where('zone_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('country_description', 'country_description.country_id = address.country_id');
		$this->db->join('country', 'country.country_id = address.country_id');
		$this->db->join('zone_description', 'zone_description.zone_id = address.zone_id');
		$this->db->from($this->db->dbprefix('address'));
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			$address_info=$query->row_array();
			if (!empty($address_info['address_format'])) {
				$format = $address_info['address_format'];
			} else {
				$format = '{firstname} {lastname}' . "\n" . '{address}' . "\n"  . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
			}
			
			$find = array(
					'{firstname}',
					'{lastname}',
					'{address}',
					'{city}',
					'{postcode}',
					'{zone}',
					'{country}'
			);

			$replace = array(
				'firstname' => '姓氏：'.$address_info['firstname'],
				'lastname'  => '名字：'.$address_info['lastname'],
				'address' 	=> '地址：'.$address_info['address'],
				'city'      => '城市：'.$address_info['city'],
				'postcode'  => '邮编：'.$address_info['postcode'],
				'zone'      => '地区：'.$address_info['zone_name'],
				'country'   => '国家：'.$address_info['name']
			);
			
			return str_replace(array("\r\n", "\r", "\n"), '&nbsp;/&nbsp;', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '&nbsp;/&nbsp;', trim(str_replace($find, $replace, $format))));
		}
		return FALSE;
	}
	
	
	public function get_address_to_checkout($address_id){
		if(empty($address_id)){
			return FALSE;
		}
		
		$this->db->select('address.lastname, address.firstname, address.address, address.postcode, address.city, country.address_format, country_description.country_id, country_description.name as country, zone_description.zone_name as zone, zone_description.zone_id');
		$this->db->where('address.address_id', $address_id);
		$this->db->where('country_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->where('zone_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('country_description', 'country_description.country_id = address.country_id');
		$this->db->join('country', 'country.country_id = address.country_id');
		$this->db->join('zone_description', 'zone_description.zone_id = address.zone_id');
		$this->db->from($this->db->dbprefix('address'));
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			return $query->row_array();
		}
		return FALSE;
	}
	
	public function get_address_tofrom($address_id){
		if(empty($address_id)){
			return FALSE;
		}
		
		$this->db->select('lastname, firstname, address, postcode, city, country_id, zone_id');
		$this->db->where('address.address_id', $address_id);
		
		$this->db->from($this->db->dbprefix('address'));
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			$address_info=$query->row_array();
			return $address_info;
		}
		return FALSE;
	}
	
	public function updata_address($data){
		$this->db->trans_start();
		if(!empty($data['user_address_id'])){
			$user_address = array('address_id' => $data['user_address_id']);
			$this->db->where('user_id', $data['user_id']);
			if(!$this->db->update($this->db->dbprefix('user'), $user_address)){
				$fail=TRUE;
			}
		}
		unset($data['user_address_id']);
		
		$this->db->where('user_id', $data['user_id']);
		$this->db->where('address_id', $data['address_id']);
		if(!$this->db->update($this->db->dbprefix('address'), $data)){
			$fail=TRUE;
		}
		$this->db->trans_complete();
		
		if(isset($fail)){
			return FALSE;
		}else{
			return TRUE;
		}
	}
	
	public function add_address($data, $def=''){
		$this->db->trans_start();
		if($this->db->insert($this->db->dbprefix('address'), $data)){
			if(!empty($def)){
				$user_address = array('address_id' => $this->db->insert_id());
				$this->db->where('user_id', $data['user_id']);
				if(!$this->db->update($this->db->dbprefix('user'), $user_address)){
					$fail=TRUE;
				}
			}
		}else{
			$fail=TRUE;
		}
		$this->db->trans_complete();
		
		if(isset($fail)){
			return FALSE;
		}else{
			return TRUE;
		}
	}
	
	public function delete($address_id){
		return $this->db->delete($this->db->dbprefix('address'), array('address_id' => $address_id, 'user_id' => $this->user->getId()));
	}
	
	public function defaul ($address_id){
		$this->db->where('user_id', $this->user->getId());
		$address['address_id']=$address_id;
		if($this->db->update($this->db->dbprefix('user'), $address)){
			return TRUE;
		}
		return FALSE;
	}
}