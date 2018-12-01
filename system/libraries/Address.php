<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class CI_Address {
	
	public function __construct() {
		$this->CI =& get_instance();
		$this->CI->load->database();//链接数据库
	}

	public function change_address($data, $country_id){
		$this->CI->db->select('address_format');
		$this->CI->db->where('country_id', $country_id);
		$this->CI->db->from($this->db->dbprefix('country'));
		$query=$this->CI->db->get();
		if($query->num_rows() > 0){
			$address_format=$query->row_array()['address_format'];
		}else{
			return implode($data, ' ');
		}
		
		$address_format=explode($address_format, ',');
	}
}
