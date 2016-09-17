<?php
class Freight_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	//取运费列表
	public function get_freights($data)
	{
		//统计记录条数
		$this->db->where('store_id', $this->user->getStore_id());
		$freights['count']   =$this->db->count_all_results($this->db->dbprefix('freight'));
		
		$this->db->limit($this->config->get_config('config_limit_admin'), $data['freight_page']);
		$this->db->select('freight_id');
		$this->db->where('store_id', $this->user->getStore_id());
		$this->db->from($this->db->dbprefix('freight'));
		
		$query=$this->db->get();
		
		if($query->num_rows() > 0){
			foreach($query->result_array() as $value){
				$freights['freights'][]=$this->get_freight_for_language($value['freight_id']);
			}
			
			return $freights;
		}
		return FALSE;
	}
	
	//取运费
	public function get_freight_for_language($freight_id)
	{
		$this->db->where('freight.freight_id', $freight_id);
		$this->db->where('freight_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('freight_description','freight_description.freight_id = freight.freight_id');
		$this->db->where('freight_template_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('freight_template_description','freight_template_description.freight_template_id = freight.freight_template_id');
		$this->db->where('freight.store_id', $this->user->getStore_id());
		$this->db->from($this->db->dbprefix('freight'));
		
		$query=$this->db->get();
		
		if($query->num_rows() > 0){
			return $query->row_array();
		}
		
		return FALSE;
	}
	
	//取组
	public function get_freight_templates($data=array()){
		//统计记录条数
		$this->db->where('freight_template.store_id', $this->user->getStore_id());
		$row['count']   =$this->db->count_all_results($this->db->dbprefix('freight_template'));
		
		if(isset($data['freight_template_page'])){
			$this->db->limit($this->config->get_config('config_limit_admin'), $data['freight_template_page']);
		}
		
		$this->db->select("freight_template_id");
		$this->db->where('freight_template.store_id', $this->user->getStore_id());
		$this->db->from($this->db->dbprefix('freight_template'));
		$query=$this->db->get();
		
		if($query->num_rows() > 0){
			$re=$query->result_array();
			foreach($re as $key=>$value){
				$row['freight_templates'][]=$this->get_freight_template($re[$key]['freight_template_id']);
			}
			
			return $row;
		}
		return FALSE;
	}
	
	//取组给form
	public function get_freight_templates_to_form(){
		$this->db->select("freight_template_id");
		$this->db->where('store_id', $this->user->getStore_id());
		$this->db->from($this->db->dbprefix('freight_template'));
		$query=$this->db->get();
		
		if($query->num_rows() > 0){
			$re=$query->result_array();
			foreach($re as $key=>$value){
				$row[]=$this->get_freight_template($re[$key]['freight_template_id']);
			}
			
			return $row;
		}
		return FALSE;
	}

	//取组的单条
	public function get_freight_template($freight_template_id){
		$this->db->where('freight_template.freight_template_id',$freight_template_id);
		$this->db->where('freight_template.store_id', $this->user->getStore_id());
		$this->db->where('freight_template_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->db->join('freight_template_description','freight_template_description.freight_template_id = freight_template.freight_template_id');
		
		$this->db->from($this->db->dbprefix('freight_template'));
		
		$query=$this->db->get();
		if($query->num_rows() > 0){
			return $query->row_array();
		}
		
		return FALSE;
	}
	
	//删除运费
	public function delete_freight($data)
	{
		foreach($data as $key=>$value){
			$this->db->delete($this->db->dbprefix('freight'), array('freight_id' => $data[$key], 'store_id' => $this->user->getStore_id()));
			$this->db->delete($this->db->dbprefix('freight_description'), array('freight_id' => $data[$key]));
		}
	}
	
	//删除运费模板
	public function delete_freight_template($data)
	{
		foreach($data as $key=>$value){
			$this->db->delete($this->db->dbprefix('freight_template'), array('freight_template_id' => $data[$key], 'store_id' => $this->user->getStore_id()));
			$this->db->delete($this->db->dbprefix('freight_template_description'), array('freight_template_id' => $data[$key]));
		}
	}
	
	//验证运费是否被商品使用
	public function get_product_freight_for_freight_id($freight_id){
		$this->db->where('freight_id',$freight_id);
		$this->db->from($this->db->dbprefix('product_freight'));
		
		$query=$this->db->get();
		if($query->num_rows() > 0){
			return $query->result_array();
		}
		return FALSE;
	}
	
	//验证运费模板是否被商品使用
	public function get_freight_for_freight_template_id($freight_template_id){
		$this->db->where('freight_template_id',$freight_template_id);
		$this->db->from($this->db->dbprefix('freight'));
		
		$query=$this->db->get();
		if($query->num_rows() > 0){
			return $query->result_array();
		}
		return FALSE;
	}
	
	//取单条运费为二维数组
	public function get_freight_arr($freight_id){
		$row['description']=FALSE;
		
		$this->db->where('freight_id',$freight_id);
		$this->db->where('store_id', $this->user->getStore_id());
		$this->db->from($this->db->dbprefix('freight'));
		$query=$this->db->get();
		if($query->num_rows() > 0){
			$row=$query->row_array();
			
			//取描述
			$this->db->where('freight_id',$freight_id);
			$this->db->from($this->db->dbprefix('freight_description'));
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
	
	//取单条运费模板为二维数组
	public function get_freight_template_arr($freight_template_id){
		$row['description']=FALSE;
		
		$this->db->where('freight_template_id',$freight_template_id);
		$this->db->where('freight_template.store_id', $this->user->getStore_id());
		$this->db->from($this->db->dbprefix('freight_template'));
		$query=$this->db->get();
		if($query->num_rows() > 0){
			$row=$query->row_array();
			
			//取描述
			$this->db->where('freight_template_id',$freight_template_id);
			$this->db->from($this->db->dbprefix('freight_template_description'));
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
	
	//修改运费
	public function edit_freight($data){
		//更新freight表
		$this->db->where('freight_id', $data['freight_id']);
		$data['base']['store_id']= $this->user->getStore_id();
		$this->db->update($this->db->dbprefix('freight'), $data['base']);
		
		$this->db->delete($this->db->dbprefix('freight_description'), array('freight_id' => $data['freight_id']));
		//更新descript表
		foreach($data['description'] as $key=>$value){
			$data['description'][$key]['language_id']=$key;
			$data['description'][$key]['freight_id']=$data['freight_id'];
		}
		$this->db->insert_batch($this->db->dbprefix('freight_description'), $data['description']);
		$this->db->reset_query();
	}
	
	//修改运费模板
	public function edit_freight_template($data){
		//更新freight表
		$this->db->where('freight_template_id', $data['freight_template_id']);
		$data['group_base']['store_id']= $this->user->getStore_id();
		$this->db->update($this->db->dbprefix('freight_template'), $data['group_base']);
		
		$this->db->delete($this->db->dbprefix('freight_template_description'), array('freight_template_id' => $data['freight_template_id']));
		//更新descript表
		foreach($data['group_description'] as $key=>$value){
			$data['group_description'][$key]['language_id']=$key;
			$data['group_description'][$key]['freight_template_id']=$data['freight_template_id'];
		}
		$this->db->insert_batch($this->db->dbprefix('freight_template_description'), $data['group_description']);
		$this->db->reset_query();
	}
	
	//添加运费
	public function add_freight($data){
		//写入freight表
		$data['base']['store_id']= $this->user->getStore_id();
		$this->db->insert($this->db->dbprefix('freight'), $data['base']);
		
		//写入descript表
		//取最后查入的一第分类id
		$freight_id=$this->db->insert_id();
		
		foreach($data['description'] as $key=>$value){
			$data['description'][$key]['language_id']=$key;
			$data['description'][$key]['freight_id']=$freight_id;
		}
		$this->db->insert_batch($this->db->dbprefix('freight_description'), $data['description']);
		$this->db->reset_query();
	}
	
	//添加运费模板
	public function add_freight_template($data){
		//写入freight表
		$data['group_base']['store_id']= $this->user->getStore_id();
		$this->db->insert($this->db->dbprefix('freight_template'), $data['group_base']);
		
		//写入descript表
		//取最后查入的一第分类id
		$freight_template_id=$this->db->insert_id();
		
		foreach($data['group_description'] as $key=>$value){
			$data['group_description'][$key]['language_id']=$key;
			$data['group_description'][$key]['freight_template_id']=$freight_template_id;
		}
		$this->db->insert_batch($this->db->dbprefix('freight_template_description'), $data['group_description']);
		$this->db->reset_query();
	}
}