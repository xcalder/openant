<?php
class Layout_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function get_layouts($data=array())
	{
		//统计记录条数
		$row_['count']   =$this->db->count_all_results($this->db->dbprefix('layout'));
		
		//查布局
		$this->db->limit($this->config->get_config('config_limit_admin'), $data['page']);
		$this->db->select("layout_id");
		$this->db->from($this->db->dbprefix('layout'));
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			$row = $query->result_array();
			
			foreach($row as $value){
				$row_['layouts'][]=$this->get_layout($value['layout_id']);
			}
			
			return $row_;
		}
		return FALSE;
	}
	
	//用id查布局
	public function get_layout($layout_id)
	{
		$this->db->where('layout.layout_id',$layout_id);
		
		$this->db->from($this->db->dbprefix('layout'));
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->row_array();
		}
		
		return FALSE;
	}
	
	//用id查布局
	public function get_layout_to_form($layout_id)
	{
		$this->db->where('layout_id',$layout_id);
		$this->db->from($this->db->dbprefix('layout'));
		$query = $this->db->get();
		
		$layouts=array();
		if($query->num_rows() > 0){
			$layouts = $query->row_array();
			
			//查路由
			$this->db->where('layout_id', $layout_id);
			$this->db->from($this->db->dbprefix('layout_route'));
			$query = $this->db->get();
			$layouts['routes']=$query->result_array();
			
			//查layout_module
			$this->db->where('layout_id', $layout_id);
			$this->db->from($this->db->dbprefix('layout_module'));
			$query = $this->db->get();
			$layouts['layout_modules']=$query->result_array();
			
			return $layouts;
		}
		
		return FALSE;
	}
	
	//更新表
	public function edit($data)
	{
		//更新layout表
		$this->db->where('layout_id', $this->input->get('layout_id'));
		$this->db->update($this->db->dbprefix('layout'), $data['base']);
		
		//删layout_module、layout_route表
		$this->db->delete($this->db->dbprefix('layout_module'), array('layout_id' => $this->input->get('layout_id')));
		$this->db->delete($this->db->dbprefix('layout_route'), array('layout_id' => $this->input->get('layout_id')));
		//更新layout_module表
		foreach($data['route'] as $key=>$value){
			$data['route'][$key]['layout_id']=$this->input->get('layout_id');
			$data['route'][$key]['store_id']='0';
		}
		
		$this->db->insert_batch($this->db->dbprefix('layout_route'), $data['route']);
		$this->db->reset_query();
		
		//更新layout_module表
		foreach($data['layout_module'] as $key=>$value){
			$arr[$key]=explode('.',$data['layout_module'][$key]['code']);
			$data['layout_module'][$key]['code']=$arr[$key][0];
			$data['layout_module'][$key]['module_id']=$arr[$key][1];
			$data['layout_module'][$key]['layout_id']=$this->input->get('layout_id');
		}
		$this->db->insert_batch($this->db->dbprefix('layout_module'), $data['layout_module']);
		$this->db->reset_query();
	}
	
	//添加布局
	public function add($data)
	{
		$this->db->insert($this->db->dbprefix('layout'), $data['base']);
		//取最后查入的layout_id
		$layout_id=$this->db->insert_id();
		
		foreach($data['route'] as $key=>$value){
			$data['route'][$key]['layout_id']=$layout_id;
			$data['route'][$key]['store_id']='0';
		}
		$this->db->insert_batch($this->db->dbprefix('layout_route'), $data['route']);
		$this->db->reset_query();
		
		foreach($data['layout_module'] as $key=>$value){
			$arr[$key]=explode('.',$data['layout_module'][$key]['code']);
			$data['layout_module'][$key]['code']=$arr[$key][0];
			$data['layout_module'][$key]['module_id']=$arr[$key][1];
			$data['layout_module'][$key]['layout_id']=$layout_id;
		}
		$this->db->insert_batch($this->db->dbprefix('layout_module'), $data['layout_module']);
		$this->db->reset_query();
	}
	
	public function delete($data)
	{
		if(empty($data)){
			return FALSE;
		}
		
		foreach($data as $key=>$value){
			$this->db->delete($this->db->dbprefix('layout'), array('layout_id' => $data[$key]));
			$this->db->delete($this->db->dbprefix('layout_module'), array('layout_id' => $data[$key]));
			$this->db->delete($this->db->dbprefix('layout_route'), array('layout_id' => $data[$key]));
		}
	}
	
	public function select_layout_ids(){
		
		$this->db->select('layout_id');
		$this->db->or_where('route', '%');
		$this->db->or_where('route', 'admin.php/%');
		if($this->uri->segment(4) !== NULL){
			$this->db->or_where('route', 'admin.php/'.$this->uri->segment(1).'/%');
			$this->db->or_where('route', 'admin.php/'.$this->uri->segment(1).'/'.$this->uri->segment(2).'/%');
			$this->db->or_where('route', 'admin.php/'.$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3).'/%');
			$this->db->or_where('route', 'admin.php/'.$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3).'/'.$this->uri->segment(4));
		}elseif($this->uri->segment(3) !== NULL){
			$this->db->or_where('route', 'admin.php/'.$this->uri->segment(1).'/%');
			$this->db->or_where('route', 'admin.php/'.$this->uri->segment(1).'/'.$this->uri->segment(2).'/%');
			$this->db->or_where('route', 'admin.php/'.$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3));
		}elseif($this->uri->segment(2) !== NULL){
			$this->db->or_where('route', 'admin.php/'.$this->uri->segment(1).'/%');
			$this->db->or_where('route', 'admin.php/'.$this->uri->segment(1).'/'.$this->uri->segment(2));
		}elseif($this->uri->segment(1) !== NULL){
			$this->db->or_where('route', 'admin.php/'.$this->uri->segment(1));
		}else{
			$this->db->or_where('route', 'admin.php/home');
		}
		
		
		$this->db->where('store_id', '0');
		
		
		$this->db->order_by('route','DESC');
		
		$this->db->from($this->db->dbprefix('layout_route'));
		
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->row_array()['layout_id'];
		}
		
		return FALSE;
	}
	
	public function select_module_ids($layout_id,$position){
		$this->db->select('module_id');
		$this->db->where('layout_id', $layout_id);
		$this->db->where('position', $position);
		$this->db->order_by('sort_order','ASC');
		$this->db->from($this->db->dbprefix('layout_module'));
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result_array();
		}
		
		return FALSE;
	}
}