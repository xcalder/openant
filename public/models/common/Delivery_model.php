<?php
class Delivery_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	//
	public function get_deliverys()
	{
		$this->db->select('ip');
		$this->db->where('ip', $this->input->ip_address());
		$this->db->from($this->db->dbprefix('user_ban_ip'));
		$query = $this->db->get();
		if($query->num_rows() > 0){
			$this->session->set_flashdata('fali', '被禁止访问的ip地址！');
			unset($_SESSION['user_id']);
			$this->output->set_status_header(404);
			exit('被禁止访问的ip地址！');
		}
	}
}