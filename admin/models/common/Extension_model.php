<?php
class Extension_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	//扩展列表
	public function get_extensions($type='module')
	{
		$this->db->where('type', $type);
		$this->db->from($this->db->dbprefix('extension'));
		
		$query=$this->db->get();
		
		if($query->num_rows() > 0){
			return $query->result_array();
		}
		return FALSE;
	}
	
	//安装
	public function install($data){
		$this->db->insert($this->db->dbprefix('extension'), $data);
	}
	
	//卸载
	public function uninstall($data){
		$this->db->where('type', $data['type']);
		$this->db->where('code', $data['code']);
		$this->db->delete($this->db->dbprefix('extension'));
	}
}