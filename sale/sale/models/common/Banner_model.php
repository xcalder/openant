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
		//查图片
		$this->db->select('banner_image.link, banner_image.image, banner_image_description.title');
		$this->db->where('banner.banner_id', $banner_id);
		$this->db->where('banner.status', '1');
		
		$this->db->join('banner_image', 'banner_image.banner_id = banner.banner_id');
		
		$this->db->where('banner_image_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('banner_image_description', 'banner_image.banner_image_id = banner_image_description.banner_image_id');
		
		$this->db->order_by('banner_image.sort_order', 'ASC');
		$this->db->from($this->db->dbprefix('banner'));
		$query=$this->db->get();
		if($query->num_rows() > 0){
			$data=$query->result_array();
			return $data;
		}
		
		return FALSE;
	}
}