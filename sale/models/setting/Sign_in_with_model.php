<?php
class Sign_in_with_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
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
}