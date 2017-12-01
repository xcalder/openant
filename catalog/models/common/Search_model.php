<?php
class Search_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function add($key_word){
		$data['key_word']=$key_word;
		$data['date_added']=date("Y-m-d H:i:s");
		$data['type']='extension';
		
		if($this->user->isLogged()){
			$data['user_id']=$_SESSION['user_id'];
		}else{
			$data['user_id']=0;
		}
		
		$this->db->insert($this->db->dbprefix('search_key_word'), $data);
	}
	
	public function get_top(){
		$sql="SELECT DISTINCT count( * ) AS count, key_word FROM " . $this->db->dbprefix('search_key_word') . " WHERE type = 'extension' GROUP BY key_word ORDER BY count DESC LIMIT 50";
		$query = $this->db->query($sql);
		
		if($query->num_rows() > 0){
			return $query->result_array();
		}else{
			return false;
		}
	}
	
	public function get_about($search_key_word){
		$sql="SELECT DISTINCT count( * ) AS count, key_word FROM " . $this->db->dbprefix('search_key_word') . " WHERE type = 'extension' AND key_word LIKE '%" . $search_key_word . "%' GROUP BY key_word ORDER BY count DESC LIMIT 100";
		$query = $this->db->query($sql);
		
		if($query->num_rows() > 0){
			return $query->result_array();
		}else{
			return false;
		}
	}
}