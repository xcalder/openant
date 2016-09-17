<?php
/**
* 货币处理类
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class CI_Currency {

	private $symbol_left;//左符号
	private $symbol_right;//右符号
	private $decimal_place;//小数位数
	private $output_value;//输出汇率
	private $code;//货币符号

	public function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->database();//链接数据库
		log_message('info', 'Currency Class Initialized');
		
		$this->CI->db->where('currency_id', $_SESSION['currency_id'] !== NULL ? $_SESSION['currency_id'] : $this->CI->config->get_config('default_currency'));
		$this->CI->db->where('status', '1');
		$this->CI->db->from($this->CI->db->dbprefix('currency'));
		$query = $this->CI->db->get(); 
		
		if($query->num_rows() > 0){
			$row=$query->row_array();
			$this->symbol_left=$row['symbol_left'];
			$this->symbol_right=$row['symbol_right'];
			$this->decimal_place=$row['decimal_place'];
			$this->output_value=$row['value'];
			$this->code=$row['code'];
		}
	}
	
	//设置输出货币汇率,false不输出符号
	public function Compute($input_value, $unit=TRUE)
	{
		if($unit){
			return $this->symbol_left.sprintf('%.'.$this->decimal_place.'f', $input_value * $this->output_value).$this->symbol_right;
		}else{
			return sprintf('%.'.$this->decimal_place.'f', $input_value * $this->output_value);
		}
		
	}
	
	//加符号输出
	public function plus_sign($input_value)
	{
		return $this->symbol_left.sprintf('%.'.$this->decimal_place.'f', $input_value).$this->symbol_right;
	}
	
	public function get_code(){
		return $this->code;
	}
	
	//货币换算输出
	public function Compute_id($value, $currency_id, $unit=TRUE)
	{
		$this->CI->db->where('currency_id', $currency_id);
		
		$this->CI->db->from($this->CI->db->dbprefix('currency'));
		$query = $this->CI->db->get();
		
		if($query->num_rows() > 0){
			$row=$query->row_array();
			if($unit){
				return $row['symbol_left'].sprintf('%.'.$row['decimal_place'].'f', $value * $row['value']).$row['symbol_right'];
			}else{
				return sprintf('%.'.$row['decimal_place'].'f', $value * $row['value']);
			}
		}
		
		return FALSE;
	}
	
	//加符号输出
	public function plus_sign_id($value, $currency_id)
	{
		$this->CI->db->where('currency_id', $currency_id);
		
		$this->CI->db->from($this->CI->db->dbprefix('currency'));
		$query = $this->CI->db->get();
		
		if($query->num_rows() > 0){
			$row=$query->row_array();
			return $row['symbol_left'].$value.$row['symbol_right'];
		}
		
		return $value;
	}
	
	//获取货币币种
	public function get_code_id($currency_id){
		$this->CI->db->where('currency_id', $currency_id);
		
		$this->CI->db->from($this->CI->db->dbprefix('currency'));
		$query = $this->CI->db->get();
		
		if($query->num_rows() > 0){
			$row=$query->row_array();
			return $row['code'];
		}
		return FALSE;
	}
}
