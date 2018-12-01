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
				'firstname' => $address_info['firstname'],
				'lastname'  => $address_info['lastname'],
				'address' 	=> $address_info['address'],
				'city'      => $address_info['city'],
				'postcode'  => $address_info['postcode'],
				'zone'      => $address_info['zone_name'],
				'country'   => $address_info['name']
			);
			
			return str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));
		}
		return FALSE;
	}
}