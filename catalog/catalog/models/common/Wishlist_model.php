<?php
class Wishlist_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function get_wishlist_count(){
		if($this->user->isLogged()){
			$this->db->where('user_id', $_SESSION['user_id']);
			$this->db->from($this->db->dbprefix('user_wishlist'));
			return $this->db->count_all_results();
		}else{
			return 0;
		}
	}
	//
	public function get_wishlist($data)
	{
		$limit=$this->config->get_config('config_limit_admin');
		$this->db->where('user_id', $_SESSION['user_id']);
		$row['count']=$this->db->count_all_results($this->db->dbprefix('user_wishlist'));
		
		$this->db->select('product_id');
		$this->db->where('user_id', $_SESSION['user_id']);
		$this->db->limit($limit, $data['page']);
		$this->db->order_by('date_added', 'DESC');
		$this->db->from($this->db->dbprefix('user_wishlist'));
		
		$query=$this->db->get();
		if($query->num_rows() > 0){
			$results=$query->result_array();
			$this->load->model('product/product_model');
			foreach ($results as $value){
				$row['products'][]=$this->product_model->get_product($value['product_id']);
			}
			return $row;
		}
		
		return FALSE;
	}
	
	public function add($product_id){
		$data['user_id']=$_SESSION['user_id'];
		$data['product_id']=$product_id;
		$data['date_added']=date("Y-m-d H:i:s");
		
		$this->db->select('user_id');
		$this->db->where('user_id', $_SESSION['user_id']);
		$this->db->where('product_id', $product_id);
		
		$this->db->from($this->db->dbprefix('user_wishlist'));
		
		$query=$this->db->get();
		if($query->num_rows() > 0){
			$this->db->where('user_id', $data['user_id']);
			$this->db->where('product_id', $data['product_id']);
			return $this->db->update($this->db->dbprefix('user_wishlist'), $data);
		}else{
			return $this->db->insert($this->db->dbprefix('user_wishlist'), $data);
		}
	}
}