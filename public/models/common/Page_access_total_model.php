<?php
class Page_access_total_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	//
	public function add($page, $page_id)
	{
		$data['token']=$_SESSION['token'];
		if(isset($_SESSION['user_id'])){
			$data['user_id']=$_SESSION['user_id'];
		}else {
			$data['user_id']='0';
		}
		$data['page']=$page;
		$data['page_id']=$page_id;
		
		$this->db->select('id');
		$this->db->where($data);
		$this->db->from($this->db->dbprefix('page_access_total'));
		$query = $this->db->get();
		if(!$query->num_rows() > 0){
			$data['date_added']=date("Y-m-d H:i:s");
			
			$this->db->insert($this->db->dbprefix('page_access_total'), $data);
		}
	}
}