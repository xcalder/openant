<?php
class Setting_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function get_setting($code,$store_id = 0)
	{
		$data = array();
		$this->db->where('store_id', $store_id);
		$this->db->where('code', $code);
		$this->db->from($this->db->dbprefix('setting'));
		$query = $this->db->get();
		
		foreach ($query->row_array() as $result) {
			if (!$result['serialized']) {
				$data[$result['key']] = $result['value'];
			} else {
				$data[$result['key']] = unserialize($result['value'], true);
			}
		}
		
		return $data;
	}
}