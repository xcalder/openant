<?php
class Layout_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function select_layout_ids(){
		
		$this->db->select('layout_id');
		$this->db->or_where('route', '%');
		$this->db->or_where('route', 'sale.php/%');
		if($this->uri->segment(4) !== NULL){
			$this->db->or_where('route', 'sale.php/'.$this->uri->segment(1).'/%');
			$this->db->or_where('route', 'sale.php/'.$this->uri->segment(1).'/'.$this->uri->segment(2).'/%');
			$this->db->or_where('route', 'sale.php/'.$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3).'/%');
			$this->db->or_where('route', 'sale.php/'.$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3).'/'.$this->uri->segment(4));
		}elseif($this->uri->segment(3) !== NULL){
			$this->db->or_where('route', 'sale.php/'.$this->uri->segment(1).'/%');
			$this->db->or_where('route', 'sale.php/'.$this->uri->segment(1).'/'.$this->uri->segment(2).'/%');
			$this->db->or_where('route', 'sale.php/'.$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3));
		}elseif($this->uri->segment(2) !== NULL){
			$this->db->or_where('route', 'sale.php/'.$this->uri->segment(1).'/%');
			$this->db->or_where('route', 'sale.php/'.$this->uri->segment(1).'/'.$this->uri->segment(2));
		}elseif($this->uri->segment(1) !== NULL){
			$this->db->or_where('route', 'sale.php/'.$this->uri->segment(1));
		}else{
			$this->db->or_where('route', 'sale.php/home');
		}
		
		
		if($this->input->get('store_id') != NULL){
			$this->db->where('store_id', $this->input->get('store_id'));
		}
		
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