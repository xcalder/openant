<?php
class Paypal_model extends CI_Model {

	public function paymentRequestInfo($order_ids) {
		$config_currency=$this->config->get_config('paypal', 'payment');
		$config_currency=unserialize($config_currency);
		
		$data['PAYMENTREQUEST_0_SHIPPINGAMT'] = '';
		$data['PAYMENTREQUEST_0_CURRENCYCODE'] = $this->currency->get_code_id($config_currency['currency']);
		$data['PAYMENTREQUEST_0_PAYMENTACTION'] = 'Sale';

		$i = 0;
		$item_total = 0;

		$products=$this->order_model->get_order_products_to_payment($order_ids);
		foreach ($products as $item) {
			$data['L_PAYMENTREQUEST_0_DESC' . $i] = utf8_substr($item['value'], 0, 126);

			$item_price = $this->currency->Compute_id($item['price'], $config_currency['currency'], false);

			$data['L_PAYMENTREQUEST_0_NAME' . $i] = $item['name'];
			//$data['L_PAYMENTREQUEST_0_NUMBER' . $i] = $item['product_option_value_id'];
			$data['L_PAYMENTREQUEST_0_AMT' . $i] = (float)number_format($item_price, 2, '.', '');

			$item_total += $item_price * $item['quantity'];

			$data['L_PAYMENTREQUEST_0_QTY' . $i] = $item['quantity'];

			$data['L_PAYMENTREQUEST_0_ITEMURL' . $i] = $this->config->item('catalog').'product?product_id=' . $item['product_id'];

			if ($item['weight'] > 0) {
				$weight = $this->weight->Compute($item['weight'], $item['weight_class_id'], $this->config->get_config('default_weight_class'), FALSE);
				$data['L_PAYMENTREQUEST_0_ITEMWEIGHTVALUE' . $i] = (string)number_format($weight * $item['quantity'], 2, '.', '');
				$data['L_PAYMENTREQUEST_0_ITEMWEIGHTUNIT' . $i] = $this->weight->get_unit($this->config->get_config('default_weight_class'));
			}

			if ($item['length'] > 0 || $item['width'] > 0 || $item['height'] > 0) {
				$unit = $this->length->get_unit($item['length_class_id']);
				$data['L_PAYMENTREQUEST_0_ITEMLENGTHVALUE' . $i] = (string)number_format($item['length'], 2, '.', '');
				$data['L_PAYMENTREQUEST_0_ITEMLENGTHUNIT' . $i] = $unit;
				$data['L_PAYMENTREQUEST_0_ITEMWIDTHVALUE' . $i] = (string)number_format($item['width'], 2, '.', '');
				$data['L_PAYMENTREQUEST_0_ITEMWIDTHUNIT' . $i] = $unit;
				$data['L_PAYMENTREQUEST_0_ITEMHEIGHTVALUE' . $i] = (string)number_format($item['height'], 2, '.', '');
				$data['L_PAYMENTREQUEST_0_ITEMHEIGHTUNIT' . $i] = $unit;
			}
			
			$i++;
		}

		// Totals
		$data['PAYMENTREQUEST_0_ITEMAMT'] = number_format($item_total, 2, '.', '');
		$data['PAYMENTREQUEST_0_AMT'] = number_format($item_total, 2, '.', '');

		return $data;
	}

	public function call($data) {
		$api_url = 'https://api-3t.paypal.com/nvp';
		
		$config_paypal=unserialize($this->config->get_config('paypal', 'payment'));
		
		$api_user = $config_paypal['apiusername'];
		$api_password = $config_paypal['apikey'];
		$api_signature = $config_paypal['apisecret'];

		$settings = array(
			'USER'         => $api_user,
			'PWD'          => $api_password,
			'SIGNATURE'    => $api_signature,
			'VERSION'      => '109.0',
			'BUTTONSOURCE' => 'OpenAnt0.0.0.1'
		);

		//日志

		$defaults = array(
			CURLOPT_POST => 1,
			CURLOPT_HEADER => 0,
			CURLOPT_URL => $api_url,
			CURLOPT_USERAGENT => "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1",
			CURLOPT_FRESH_CONNECT => 1,
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_FORBID_REUSE => 1,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_SSL_VERIFYPEER => 0,
			CURLOPT_SSL_VERIFYHOST => 0,
			CURLOPT_POSTFIELDS => http_build_query(array_merge($data, $settings), '', "&"),
		);

		$ch = curl_init();

		curl_setopt_array($ch, $defaults);

		if (!$result = curl_exec($ch)) {
			//$this->log(array('error' => curl_error($ch), 'errno' => curl_errno($ch)), 'cURL failed');
		}

		//$this->log($result, 'Result');

		curl_close($ch);

		return $this->cleanReturn($result);
	}

	public function cleanReturn($data) {
		$data = explode('&', $data);

		$arr = array();

		foreach ($data as $k=>$v) {
			$tmp = explode('=', $v);
			$arr[$tmp[0]] = isset($tmp[1]) ? urldecode($tmp[1]) : '';
		}

		return $arr;
	}
}