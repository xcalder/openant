<?php
class Barcode_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	//取条码列表
	public function get_barcodes($data)
	{
		//统计记录条数
		$row['count']   =$this->db->count_all_results($this->db->dbprefix('barcode'));
		
		$this->db->limit($this->config->get_config('config_limit_admin'), $data['page']);
		$this->db->select('barcode_id');
		//$this->db->from($this->db->dbprefix('barcode'));
		
		$query=$this->db->get($this->db->dbprefix('barcode'));
		
		if($query->num_rows() > 0){
			foreach($query->result_array() as $value){
				$row['barcode'][]=$this->get_barcode_for_language($value['barcode_id']);
			}
			
			return $row;
		}
		return FALSE;
	}
	
	//取条码给分类
	public function get_barcodes_to_category()
	{
		$this->db->select('barcode_id');
		$query=$this->db->get($this->db->dbprefix('barcode'));
		if($query->num_rows() > 0){
			foreach($query->result_array() as $value){
				$row[]=$this->get_barcode_for_language($value['barcode_id']);
			}
			return $row;
		}
		return FALSE;
	}
	
	//取条码
	public function get_barcode_for_language($barcode_id)
	{
		$this->db->where('barcode.barcode_id', $barcode_id);
		$this->db->where('barcode_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('barcode_description','barcode_description.barcode_id = barcode.barcode_id');
		$this->db->from($this->db->dbprefix('barcode'));
		
		$query=$this->db->get();
		
		if($query->num_rows() > 0){
			return $query->row_array();
		}
		
		return FALSE;
	}
	
	//删除条码
	public function delete_barcode($data)
	{
		foreach($data as $key=>$value){
			$this->db->delete($this->db->dbprefix('barcode'), array('barcode_id' => $data[$key]));
			$this->db->delete($this->db->dbprefix('barcode_description'), array('barcode_id' => $data[$key]));
		}
	}
	
	//验证条码是否被商品使用
	public function get_product_barcode_for_barcode_id($barcode_id){
		$this->db->where('barcode_id',$barcode_id);
		$this->db->from($this->db->dbprefix('product_barcode'));
		
		$query=$this->db->get();
		if($query->num_rows() > 0){
			return $query->result_array();
		}
		return FALSE;
	}
	
	//取单条条码为二维数组
	public function get_barcode_arr($barcode_id){
		$row['description']=FALSE;
		
		$this->db->where('barcode_id',$barcode_id);
		$this->db->from($this->db->dbprefix('barcode'));
		$query=$this->db->get();
		if($query->num_rows() > 0){
			$row=$query->row_array();
			
			//取描述
			$this->db->where('barcode_id',$barcode_id);
			$this->db->from($this->db->dbprefix('barcode_description'));
			$query=$this->db->get();
			
			if($query->num_rows() > 0){
				$description=array();
				$de=$query->result_array();
				foreach($de as $key=>$value){
					$description[$de[$key]['language_id']]=$value;
				}
				$row['description']=$description;
			}
			
			return $row;
		}
		return FALSE;
	}

	//修改条码
	public function edit_barcode($data){
		//更新attribute表
		$this->db->where('barcode_id', $data['barcode_id']);
		$this->db->update($this->db->dbprefix('barcode'), $data['base']);
		
		$this->db->delete($this->db->dbprefix('barcode_description'), array('barcode_id' => $data['barcode_id']));
		
		//更新descript表
		foreach($data['description'] as $key=>$value){
			$data['description'][$key]['language_id']=$key;
			$data['description'][$key]['barcode_id']=$data['barcode_id'];
		}
		$this->db->insert_batch($this->db->dbprefix('barcode_description'), $data['description']);
		$this->db->reset_query();
	}

	//添加条码
	public function add_barcode($data){
		//写入attribute表
		$this->db->insert($this->db->dbprefix('barcode'), $data['base']);
		
		//写入descript表
		//取最后查入的一第分类id
		$barcode_id=$this->db->insert_id();
		
		foreach($data['description'] as $key=>$value){
			$data['description'][$key]['language_id']=$key;
			$data['description'][$key]['barcode_id']=$barcode_id;
		}
		$this->db->insert_batch($this->db->dbprefix('barcode_description'), $data['description']);
		$this->db->reset_query();
	}
}