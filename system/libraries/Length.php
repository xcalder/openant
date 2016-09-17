<?php
/**
* 长度单位处理类
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class CI_Length {
	private $default_length_class;//默认长度单位
	
	public function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->database();//链接数据库
		
		$this->default_weight_class=$this->CI->config->get_config('default_length_class');
		
		log_message('info', 'length Class Initialized');
	}
	
	//货币换算输出
	public function Compute($value, $default_length_class='', $unit=TRUE)
	{
		if(empty($default_weight_class)){
			$default_weight_class=$this->default_length_class;
		}
		$this->CI->db->where('length_class_id', $default_length_class);
		
		$this->CI->db->where('length_class_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->CI->db->join('length_class_description', 'length_class_description.length_class_id = length_class.length_class_id');
		
		$this->CI->db->from($this->CI->db->dbprefix('length_class'));
		$query = $this->CI->db->get();
		
		if($query->num_rows() > 0){
			$row=$query->row_array();
			if($unit){
				return sprintf('%.2f', $value * $row['value']).$row['unit'];
			}else{
				return sprintf('%.2f', $value * $row['value']);
			}
		}
		
		return FALSE;
	}
	
	//加符号输出
	public function plus_sign($value, $length_class_id)
	{
		$this->CI->db->where('length_class_id', $length_class_id);
		
		$this->CI->db->where('length_class_description.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->CI->db->join('length_class_description', 'length_class_description.length_class_id = length_class.length_class_id');
		
		$this->CI->db->from($this->CI->db->dbprefix('length_class'));
		$query = $this->CI->db->get();
		
		if($query->num_rows() > 0){
			$row=$query->row_array();
			return $value.$row['unit'];
		}
		
		return $value;
	}
	
	//获取单位
	public function get_unit($default_length_class){
		if(empty($default_weight_class)){
			$default_weight_class=$this->default_length_class;
		}
		
		$this->CI->db->select('unit');
		$this->CI->db->where('language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
		$this->CI->db->where('length_class_id', $default_length_class);
		
		$this->CI->db->from($this->CI->db->dbprefix('length_class_description'));
		$query = $this->CI->db->get();
		
		if($query->num_rows() > 0){
			$row=$query->row_array();
			return $row['unit'];
		}
		return FALSE;
	}
}
