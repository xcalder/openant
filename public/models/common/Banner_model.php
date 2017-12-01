<?php
class Banner_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	//
	public function get_banner_to_layout($banner_id='')
	{
		if(empty($banner_id)){
			return FALSE;
		}
		$data=array();
		//
		$this->db->select('bi.link, bi.image, bid.title');
		$this->db->where('b.banner_id', $banner_id);
		$this->db->where('b.status', '1');
		
		$this->db->join('banner_image AS bi', 'bi.banner_id = b.banner_id');
		
		$this->db->where('bid.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('banner_image_description AS bid', 'bi.banner_image_id = bid.banner_image_id');
		
		$this->db->order_by('bi.sort_order', 'ASC');
		$this->db->from($this->db->dbprefix('banner') . ' AS b');
		$query=$this->db->get();
		if($query->num_rows() > 0){
			$data=$query->result_array();
			return $data;
		}
		
		return FALSE;
	}
}