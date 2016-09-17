<?php
class Download_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	//
	public function get_downloads_for_langugae_id($data)
	{
		//
		$this->db->limit($this->config->get_config('config_limit_admin'), $data['page']);
		$this->db->select('download_id');
		//$this->db->from($this->db->dbprefix('download'));
		$query = $this->db->get($this->db->dbprefix('download')); 
		
		//统计记录条数
		$downloads['count']=$this->db->count_all_results($this->db->dbprefix('download'));
		
		if($query->num_rows() > 0){
			$row = $query->result_array();
			foreach($row as $value){
				$downloads['downloads'][] = $this->get_download($value['download_id']);
			}
			return $downloads;
		}
		
		return FALSE;
	}
	
	//给分类用
	public function get_downloads_to_category()
	{
		$this->db->select('download_id');
		$query = $this->db->get($this->db->dbprefix('download')); 
		if($query->num_rows() > 0){
			$row = $query->result_array();
			foreach($row as $value){
				$downloads[] = $this->get_download($value['download_id']);
			}
			return $downloads;
		}
		
		return FALSE;
	}
	
	//
	public function get_download($download_id='')
	{
		if(empty($download_id)){
			return FALSE;
		}
		
		$this->db->where('download.download_id',$download_id);
		$this->db->where('download_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('download_description', 'download_description.download_id = download.download_id');
		$this->db->from($this->db->dbprefix('download'));
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			return $query->row_array();
		}
		
		return FALSE;
	}
	
	//
	public function get_download_form($download_id='')
	{
		if(empty($download_id)){
			return FALSE;
		}
		
		$this->db->where('download_id',$download_id);
		$this->db->from($this->db->dbprefix('download'));
		$query = $this->db->get();
		if($query->num_rows() > 0){
			$row=$query->row_array();
			$download=$row;
			
			//查描述
			$this->db->where('download_id', $row['download_id']);
			$this->db->from($this->db->dbprefix('download_description'));
			$query=$this->db->get();
			
			$descriptions=$query->result_array();
			foreach($descriptions as $key=>$value){
				$description[$descriptions[$key]['language_id']]=$value;
			}
			$download['description']=$description;
			
			return $download;
		}
		
		return FALSE;
	}
	
	public function edit($data)
	{
		$this->db->where('download_id', $this->input->get('download_id'));
		$this->db->update($this->db->dbprefix('download'), $data['base']);
		
		//先删
		$this->db->delete($this->db->dbprefix('download_description'), array('download_id' => $this->input->get('download_id')));
		
		foreach($data['description'] as $key=>$value){
			//组织数组
			$data['description'][$key]['language_id']=$key;
			$data['description'][$key]['download_id']=$this->input->get('download_id');
			
			$this->db->where('download_id', $this->input->get('download_id'));
			$this->db->where('language_id', $key);
			$this->db->insert($this->db->dbprefix('download_description'), $data['description'][$key]);
			$this->db->reset_query();
		}
	}
	
	public function add($data)
	{
		$this->db->insert($this->db->dbprefix('download'), $data['base']);
		
		//取最后查入的一第分类iddbprefix('download'));
		$download_id=$this->db->insert_id();
		
		foreach($data['description'] as $key=>$value){
			//组织数组
			$data['description'][$key]['download_id']=$download_id;
			$data['description'][$key]['language_id']=$key;
		}
		$this->db->insert_batch($this->db->dbprefix('download_description'), $data['description']);
		$this->db->reset_query();
	}
	
	public function check_delete($data){
		if(empty($data)){
			return FALSE;
		}
		foreach($data as $key=>$value){
			$this->db->select('product_id');
			$this->db->where('download_id', $data[$key]);
			$this->db->from($this->db->dbprefix('product_download'));
			$query=$this->db->get();
			
			if($query->num_rows() > 0){
				return TRUE;
			}
		}
		
		return FALSE;
	}
	
	public function delete($data){
		foreach($data as $key=>$value){
			$this->db->delete($this->db->dbprefix('download'), array('download_id' => $data[$key]));
			$this->db->delete($this->db->dbprefix('download_description'), array('download_id' => $data[$key]));
		}
	}
}