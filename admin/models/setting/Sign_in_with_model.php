<?php
class Sign_in_with_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function get_sign_with($code, $name)
	{
		$this->db->select('module_id, setting, store_order');
		$this->db->where('code', $code);
		$this->db->where('name', $name);
		$this->db->from($this->db->dbprefix('module'));
		$query=$this->db->get();
		
		if($query->num_rows() > 0){
			$row=$query->row_array();
			$row['setting']=unserialize($row['setting']);
			return $row;
		}
		return FALSE;
	}
	
	public function add($data, $code, $name)
	{
		$arr['appid']=$data['appid'];unset($data['appid']);
		$arr['appkey']=$data['appkey'];unset($data['appkey']);
		$arr['extra']=$data['extra'];unset($data['extra']);
		$arr['status']=$data['status'];unset($data['status']);
		$arr['image']=$data['image'];unset($data['image']);
		
		$data['setting']=serialize($arr);
		$data['code']=$code;
		$data['name']=$name;
		
		if(isset($data['module_id'])){
			$this->db->where('module_id', $data['module_id']);
			$this->db->update($this->db->dbprefix('module'), $data);
		}else{
			$this->db->insert($this->db->dbprefix('module'), $data);
		}
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