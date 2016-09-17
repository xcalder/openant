<?php
class Download_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	//取条码
	public function get_downloads($data)
	{
		if(empty($data)){
			return FALSE;
		}
		foreach($data as $key=>$value){
			$row[]=$this->get_download_for_language($data[$key]);
		}
		return $row;
	}

	//取条码
	public function get_download_for_language($download_id)
	{
		$this->db->select('download.download_id, download_description.name');
		$this->db->where('download.download_id', $download_id);
		$this->db->where('download_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('download_description','download_description.download_id = download.download_id');
		$this->db->from($this->db->dbprefix('download'));
		
		$query=$this->db->get();
		
		if($query->num_rows() > 0){
			return $query->row_array();
		}
		
		return FALSE;
	}
}