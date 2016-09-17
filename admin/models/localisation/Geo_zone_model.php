<?php
class Geo_zone_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	//
	public function get_geo_zones_for_langugae_id($data)
	{
		//
		$this->db->limit($this->config->get_config('config_limit_admin'), $data['page']);
		$this->db->select('geo_zone_id');
		//$this->db->from($this->db->dbprefix('geo_zone'));
		$query = $this->db->get($this->db->dbprefix('geo_zone')); 
		
		//统计记录条数
		$geo_zone['count']=$this->db->count_all_results($this->db->dbprefix('geo_zone'));
		
		if($query->num_rows() > 0){
			$row = $query->result_array();
			foreach($row as $value){
				$geo_zone['geo_zones'][] = $this->get_geo_zone($value['geo_zone_id']);
			}
			return $geo_zone;
		}
		
		return FALSE;
	}
	
	//
	public function get_geo_zone($geo_zone_id='')
	{
		if(empty($geo_zone_id)){
			return FALSE;
		}
		
		$this->db->where('geo_zone.geo_zone_id',$geo_zone_id);
		$this->db->where('geo_zone_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('geo_zone_description', 'geo_zone_description.geo_zone_id = geo_zone.geo_zone_id');
		$this->db->from($this->db->dbprefix('geo_zone'));
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			return $query->row_array();
		}
		
		return FALSE;
	}
	
	//
	public function get_geo_zone_form($geo_zone_id='')
	{
		if(empty($geo_zone_id)){
			return FALSE;
		}
		
		$this->db->where('geo_zone_id',$geo_zone_id);
		$this->db->from($this->db->dbprefix('geo_zone'));
		$query = $this->db->get();
		if($query->num_rows() > 0){
			$row=$query->row_array();
			$geo_zone=$row;
			
			//查描述
			$this->db->where('geo_zone_id', $row['geo_zone_id']);
			$this->db->from($this->db->dbprefix('geo_zone_description'));
			$query=$this->db->get();
			
			$descriptions=$query->result_array();
			foreach($descriptions as $key=>$value){
				$description[$descriptions[$key]['language_id']]=$value;
			}
			$geo_zone['description']=$description;
			
			//查zone_to_geo_zone
			$this->db->reset_query();
			
			$this->db->where('geo_zone_id', $geo_zone_id);
			$this->db->from($this->db->dbprefix('zone_to_geo_zone'));
			$query=$this->db->get();
			
			$geo_zone['zone_to_geo_zone']=$query->result_array();
			
			return $geo_zone;
		}
		
		return FALSE;
	}
	
	public function edit($data)
	{
		foreach($data['description'] as $key=>$value){
			//组织数组
			$data['description'][$key]['language_id']=$key;
			$data['description'][$key]['geo_zone_id']=$this->input->get('geo_zone_id');
			
			$this->db->where('geo_zone_id', $this->input->get('geo_zone_id'));
			$this->db->where('language_id', $key);
			$this->db->replace($this->db->dbprefix('geo_zone_description'), $data['description'][$key]);
			$this->db->reset_query();
		}
		
		$base['geo_zone_id']=$this->input->get('geo_zone_id');
		$base['date_modified']=date("Y-m-d H:i:s");
		$this->db->where('geo_zone_id', $this->input->get('geo_zone_id'));
		$this->db->update($this->db->dbprefix('geo_zone'), $base);
		$this->db->reset_query();
		
		//先删
		$this->db->delete($this->db->dbprefix('zone_to_geo_zone'), array('geo_zone_id' => $this->input->get('geo_zone_id')));
		//再插入
		foreach($data['zone_to_geo_zone'] as $key=>$value){
			$data['zone_to_geo_zone'][$key]['geo_zone_id']=$this->input->get('geo_zone_id');
			$data['zone_to_geo_zone'][$key]['date_added']=date("Y-m-d H:i:s");
		}
		
		$this->db->insert_batch($this->db->dbprefix('zone_to_geo_zone'), $data['zone_to_geo_zone']);
		$this->db->reset_query();
	}
	
	public function add($data)
	{
		$base['date_added']=date("Y-m-d H:i:s");
		$base['date_modified']=date("Y-m-d H:i:s");
		$this->db->insert($this->db->dbprefix('geo_zone'), $base);
		
		//取最后查入的一第分类id
		$geo_zone_id=$this->db->insert_id();
		$this->db->reset_query();
		
		foreach($data['description'] as $key=>$value){
			//组织数组
			$data['description'][$key]['geo_zone_id']=$geo_zone_id;
			$data['description'][$key]['language_id']=$key;
		}
		
		$this->db->insert_batch($this->db->dbprefix('geo_zone_description'), $data['description']);
		$this->db->reset_query();
		
		//插入zone_to_geo_zone
		foreach($data['zone_to_geo_zone'] as $key=>$value){
			
			$data['zone_to_geo_zone'][$key]['date_added']=date("Y-m-d H:i:s");
			$data['zone_to_geo_zone'][$key]['geo_zone_id']=$geo_zone_id;
		}
		
		$this->db->insert_batch($this->db->dbprefix('zone_to_geo_zone'), $data['zone_to_geo_zone']);
		$this->db->reset_query();
	}
	
	public function check_delete($data){
		if(empty($data)){
			return FALSE;
		}
		foreach($data as $key=>$value){
			$this->db->select('tax_rate_id');
			$this->db->where('geo_zone_id', $data[$key]);
			$this->db->from($this->db->dbprefix('tax_rate'));
			$query=$this->db->get();
			
			if($query->num_rows() > 0){
				return TRUE;
			}
		}
		
		return FALSE;
	}
	
	public function delete($data){
		foreach($data as $key=>$value){
			$this->db->delete($this->db->dbprefix('geo_zone'), array('geo_zone_id' => $data[$key]));
			$this->db->delete($this->db->dbprefix('geo_zone_description'), array('geo_zone_id' => $data[$key]));
			$this->db->delete($this->db->dbprefix('zone_to_geo_zone'), array('geo_zone_id' => $data[$key]));
		}
	}
	
	public function get_geo_zones_to_other(){
		$this->db->select('geo_zone_id');
		$this->db->from($this->db->dbprefix('geo_zone'));
		$query=$this->db->get();
		
		if($query->num_rows() > 0){
			$result=$query->result_array();
			foreach($result as $key=>$value){
				$row[]=$this->get_geo_zone_for_language_id($result[$key]['geo_zone_id']);
			}
			
			return $row;
		}
		
		return FALSE;
	}
	
	public function get_geo_zone_for_language_id($geo_zone_id=''){
		if(empty($geo_zone_id)){
			return FALSE;
		}
		$this->db->where('geo_zone.geo_zone_id', $geo_zone_id);
		$this->db->join('geo_zone_description', 'geo_zone_description.geo_zone_id = geo_zone.geo_zone_id');
		$this->db->where('geo_zone_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->from($this->db->dbprefix('geo_zone'));
		$query=$this->db->get();
		
		if($query->num_rows() > 0){
			return $query->row_array();
		}
		return FALSE;
	}
}