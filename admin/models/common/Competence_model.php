<?php
class Competence_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	//
	public function get_competences_for_langugae_id($data)
	{
		//
		$this->db->limit($this->config->get_config('config_limit_admin'), $data['page']);
		$this->db->select('competence_id');
		//$this->db->from($this->db->dbprefix('competence'));
		$query = $this->db->get($this->db->dbprefix('competence')); 
		
		//统计记录条数
		$competences['count']=$this->db->count_all_results($this->db->dbprefix('competence'));
		
		if($query->num_rows() > 0){
			$row = $query->result_array();
			foreach($row as $value){
				$competences['competences'][] = $this->get_competence($value['competence_id']);
			}
			return $competences;
		}
		
		return FALSE;
	}
	
	public function get_competences_for_user()
	{
		$this->db->select('competence_id');
		$query = $this->db->get($this->db->dbprefix('competence')); 
		
		if($query->num_rows() > 0){
			$row = $query->result_array();
			foreach($row as $value){
				$competences[] = $this->get_competence($value['competence_id']);
			}
			unset($row);
			
			foreach($competences as $key=>$value){
				if($competences[$key]['key'] == 'access'){
					$row['access'][]=$value;
				}
				if($competences[$key]['key'] == 'edit'){
					$row['edit'][]=$value;
				}
			}
			unset($competences);
			return $row;
		}
		
		return FALSE;
	}
	
	//
	public function get_competences_for_setting()
	{
		//
		$this->db->select('competence_id');
		$this->db->from($this->db->dbprefix('competence'));
		$query = $this->db->get(); 
		
		if($query->num_rows() > 0){
			$row = $query->result_array();
			foreach($row as $value){
				$competences[] = $this->get_competence($value['competence_id']);
			}
			return $competences;
		}
		
		return FALSE;
	}
	
	//
	public function get_competence($competence_id='')
	{
		if(empty($competence_id)){
			return FALSE;
		}
		
		$this->db->where('competence.competence_id',$competence_id);
		$this->db->where('competence_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('competence_description', 'competence_description.competence_id = competence.competence_id');
		$this->db->from($this->db->dbprefix('competence'));
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			return $query->row_array();
		}
		
		return FALSE;
	}
	
	//
	public function get_competence_form($competence_id='')
	{
		if(empty($competence_id)){
			return FALSE;
		}
		
		$this->db->where('competence_id',$competence_id);
		$this->db->from($this->db->dbprefix('competence'));
		$query = $this->db->get();
		if($query->num_rows() > 0){
			$row=$query->row_array();
			$competence=$row;
			
			//查描述
			$this->db->where('competence_id', $row['competence_id']);
			$this->db->from($this->db->dbprefix('competence_description'));
			$query=$this->db->get();
			
			$descriptions=$query->result_array();
			foreach($descriptions as $key=>$value){
				$description[$descriptions[$key]['language_id']]=$value;
			}
			$competence['description']=$description;
			
			return $competence;
		}
		
		return FALSE;
	}
	
	public function edit($data)
	{
		$this->db->where('competence_id', $this->input->get('competence_id'));
		$this->db->update($this->db->dbprefix('competence'), $data['base']);
		
		//先删
		$this->db->delete($this->db->dbprefix('competence_description'), array('competence_id' => $this->input->get('competence_id')));
		
		foreach($data['description'] as $key=>$value){
			//组织数组
			$data['description'][$key]['language_id']=$key;
			$data['description'][$key]['competence_id']=$this->input->get('competence_id');
			
			$this->db->where('competence_id', $this->input->get('competence_id'));
			$this->db->where('language_id', $key);
			$this->db->insert($this->db->dbprefix('competence_description'), $data['description'][$key]);
			$this->db->reset_query();
		}
		
		
	}
	
	public function add($data)
	{
		$this->db->insert($this->db->dbprefix('competence'), $data['base']);
		
		//取最后查入的一第分类id
		$competence_id=$this->db->insert_id();
		
		
		foreach($data['description'] as $key=>$value){
			//组织数组
			$data['description'][$key]['competence_id']=$competence_id;
			$data['description'][$key]['language_id']=$key;
		}
		$this->db->insert_batch($this->db->dbprefix('competence_description'), $data['description']);
		$this->db->reset_query();
	}
	
	public function delete($data){
		foreach($data as $key=>$value){
			$this->db->delete($this->db->dbprefix('competence'), array('competence_id' => $data[$key]));
			$this->db->delete($this->db->dbprefix('competence_description'), array('competence_id' => $data[$key]));
		}
	}
}