<?php
class Banner_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	//
	public function get_banners($data)
	{
		//统计记录条数
		$banners['count']=$this->db->count_all_results($this->db->dbprefix('banner'));
		
		//
		$this->db->limit($this->config->get_config('config_limit_admin'), $data['page']);
		//$this->db->from($this->db->dbprefix('banner'));
		$query = $this->db->get($this->db->dbprefix('banner')); 
		
		if($query->num_rows() > 0){
			$banners['banners'] = $query->result_array();
			
			return $banners;
		}
		
		return FALSE;
	}
	
	public function get_banners_()
	{
		$this->db->where('status', '1');
		$query = $this->db->get($this->db->dbprefix('banner')); 
		
		if($query->num_rows() > 0){
			return $query->result_array();
			
		}
		
		return FALSE;
	}
	
	//
	public function get_banner($banner_id='')
	{
		if(empty($banner_id)){
			return FALSE;
		}
		
		$this->db->where('banner.banner_id',$banner_id);
		$this->db->from($this->db->dbprefix('banner'));
		
		$query = $this->db->get();
		
		$data=array();
		if($query->num_rows() > 0){
			$data=$query->row_array();
			
			//查图片
			$this->db->where('banner_id', $banner_id);
			$this->db->order_by('sort_order', 'ASC');
			$this->db->from($this->db->dbprefix('banner_image'));
			$query=$this->db->get();
			if($query->num_rows() > 0){
				$images=$query->result_array();
			}
			if(isset($images) && is_array($images)){
				foreach($images as $key=>$value){
					$this->db->where('banner_id', $banner_id);
					$this->db->where('banner_image_id', $images[$key]['banner_image_id']);
					$this->db->from($this->db->dbprefix('banner_image_description'));
					$query=$this->db->get();
					$images[$key]['description']=$query->result_array();
				}
				$data['image']=$images;
			}
			
			
			return $data;
		}
		
		return FALSE;
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

	public function edit($data)
	{
		//更新banner表
		$this->db->where('banner_id', $this->input->get('banner_id'));
		$this->db->update($this->db->dbprefix('banner'), $data['base']);
		$this->db->reset_query();
		
		//通过banner_id把banner_image、banner_image_description清掉
		$this->db->delete($this->db->dbprefix('banner_image'), array('banner_id' => $this->input->get('banner_id')));
		$this->db->delete($this->db->dbprefix('banner_image_description'), array('banner_id' => $this->input->get('banner_id')));
		
		//插入banner_image表、banner_image_description
		foreach($data['image'] as $key=>$value){
			//组织数组
			$banner_image[$key]['banner_id']=$this->input->get('banner_id');
			$banner_image[$key]['link']=$data['image'][$key]['link'];
			$banner_image[$key]['image']=$data['image'][$key]['image'];
			$banner_image[$key]['sort_order']=$data['image'][$key]['sort_order'];
			
			//插入banner_image
			$this->db->insert($this->db->dbprefix('banner_image'), $banner_image[$key]);
			//取最后一条banner_image_id
			$banner_image_id=$this->db->insert_id();
			$this->db->reset_query();
			
			//插入到banner_image_description表
			
			foreach($data['image'][$key]['descriptions'] as $k=>$v){
				$description[$k]['title']=$data['image'][$key]['descriptions'][$k]['title'];
				$description[$k]['language_id']=$k;
				$description[$k]['banner_id']=$this->input->get('banner_id');
				$description[$k]['banner_image_id']=$banner_image_id;
				
			}
			$this->db->insert_batch($this->db->dbprefix('banner_image_description'), $description);
			$this->db->reset_query();
		}
	}
	
	public function add($data)
	{
		$this->db->insert($this->db->dbprefix('banner'), $data['base']);
		
		//取最后查入的一条banner_id
		$banner_id=$this->db->insert_id();
		$this->db->reset_query();
		
		//插入banner_image表、banner_image_description
		foreach($data['image'] as $key=>$value){
			//组织数组
			$banner_image[$key]['banner_id']=$banner_id;
			$banner_image[$key]['link']=$data['image'][$key]['link'];
			$banner_image[$key]['image']=$data['image'][$key]['image'];
			$banner_image[$key]['sort_order']=$data['image'][$key]['sort_order'];
			
			//插入banner_image
			$this->db->insert($this->db->dbprefix('banner_image'), $banner_image[$key]);
			
			//取最后一条banner_image_id
			$banner_image_id=$this->db->insert_id();
			$this->db->reset_query();
			
			//插入到banner_image_description表
			foreach($data['image'][$key]['descriptions'] as $k=>$v){
				$description[$k]['title']=$data['image'][$key]['descriptions'][$k]['title'];
				$description[$k]['language_id']=$k;
				$description[$k]['banner_id']=$banner_id;
				$description[$k]['banner_image_id']=$banner_image_id;
			}
			$this->db->insert_batch($this->db->dbprefix('banner_image_description'), $description);
			$this->db->reset_query();
		}
	}
	
	public function check_delete($data){
		$this->db->select('setting');
		$this->db->where('code', 'slideshow');
		$query = $this->db->get($this->db->dbprefix('module')); 
		if($query->num_rows() > 0){
			$banners=$query->result_array();
			foreach ($banners as $value){
				$banner_ids[]=unserialize($value['setting'])['banner_id'];
			}
			unset($banners);
			
			foreach ($data as $value){
				if(in_array($value, $banner_ids)){
					return true;
				}
			}
		}
		
		return false;
	}

	public function delete($data){
		foreach($data as $key=>$value){
			$this->db->delete($this->db->dbprefix('banner'), array('banner_id' => $data[$key]));
			$this->db->delete($this->db->dbprefix('banner_image'), array('banner_id' => $data[$key]));
			$this->db->delete($this->db->dbprefix('banner_image_description'), array('banner_id' => $data[$key]));
		}
	}
}