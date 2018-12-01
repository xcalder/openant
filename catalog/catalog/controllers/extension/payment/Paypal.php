<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Paypal extends MY_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->library(array('currency', 'length', 'weight'));
		$this->load->model(array('order/order_model', 'payment/paypal_model'));
	}
	
	public function index() {
		$config_currency=$this->config->get_config('paypal', 'payment');
		$encrypt=$this->input->get('encrypt');
		$order_ids=$this->input->get('order_ids');
		$payment_total=$this->input->get('payment_total');
		$order_ids=explode(',', $order_ids);
		unset($order_ids[0]);
		
		$_SESSION['paypal']['order_ids']=$order_ids;
		$input_encrypt=md5($_SESSION['token'].implode(',', $order_ids).$payment_total.$_SESSION['token']);
		$config_currency=unserialize($config_currency);
		
		if ($encrypt != $input_encrypt) {
			$resule['status']=FALSE;
			$resule['msg']='付款不成功，请不要非法修改参数！';
			$this->session->set_flashdata('result', $resule);
			
			redirect('user/confirm/payment_info');
			exit;
		}
		
		$payment_total=$this->currency->Compute_id($payment_total, $config_currency['currency'], false);
		$max_amount = $payment_total * 1.5;
		$max_amount = $this->currency->Compute($max_amount, false);

		// PayPal requires some countries to use zone code (not name) to be sent in SHIPTOSTATE
		$ship_to_state_codes = array(
			'30', // Brazil
			'38', // Canada
			'105', // Italy
			'138', // Mexico
			'223', // USA
		);

		$orders_info=$this->order_model->get_orders_to_payment($order_ids);
		
		foreach($orders_info as $key=>$order_info){
			
			if (in_array($order_info['shipping_country_id'], $ship_to_state_codes)) {
				$ship_to_state = $order_info['shipping_zone_code'];
			} else {
				$ship_to_state = $order_info['shipping_zone'];
			}

			$data_shipping = array(
				'PAYMENTREQUEST_'.$key.'_SHIPTONAME'        => html_entity_decode($order_info['shipping_firstname'] . ' ' . $order_info['shipping_lastname'], ENT_QUOTES, 'UTF-8'),
				'PAYMENTREQUEST_'.$key.'_SHIPTOSTREET'      => html_entity_decode($order_info['shipping_address'], ENT_QUOTES, 'UTF-8'),
				'PAYMENTREQUEST_'.$key.'_SHIPTOCITY'        => html_entity_decode($order_info['shipping_city'], ENT_QUOTES, 'UTF-8'),
				'PAYMENTREQUEST_'.$key.'_SHIPTOSTATE'       => html_entity_decode($ship_to_state, ENT_QUOTES, 'UTF-8'),
				'PAYMENTREQUEST_'.$key.'_SHIPTOZIP'         => html_entity_decode($order_info['shipping_postcode'], ENT_QUOTES, 'UTF-8'),
				'PAYMENTREQUEST_'.$key.'_SHIPTOCOUNTRYCODE' => $order_info['shipping_code']
			);
		}

		$data = array(
			'METHOD'             => 'SetExpressCheckout',
			'MAXAMT'             => (float)$max_amount,
			'RETURNURL'          => $this->config->item('catalog').'/extension/payment/paypal/checkoutreturn',
			'CANCELURL'          => $this->config->item('catalog').'/user/confirm/payment?order_ids='.$this->input->get('order_ids'),
			'REQCONFIRMSHIPPING' => 0,
			'NOSHIPPING'         => 0,
			'LOCALECODE'         => 'EN',
			'LANDINGPAGE'        => 'Login',
			'HDRIMG'             => 'resources/public/resources/default/image/payment_ico/paypal.jpg',
			'PAYFLOWCOLOR'       => '',
			'CHANNELTYPE'        => 'Merchant',
			'ALLOWNOTE'          => '0'
		);

		$data = array_merge($data, $data_shipping);

		$data = array_merge($data, $this->paypal_model->paymentRequestInfo($order_ids));

		$result = $this->paypal_model->call($data);

		/**
		 * If a failed PayPal setup happens, handle it.
		 */
		if (!isset($result['TOKEN'])) {
			$resule['status']=FALSE;
			$resule['msg']='付款不成功，请求参数错误！';
			$this->session->set_flashdata('result', $resule);
			
			redirect('user/confirm/payment_info');
			exit;
		}
		
		$_SESSION['paypal']['token']=$resule['TOKEN'];
		
		redirect('https://www.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=' . $result['TOKEN'] . '&useraction=commit');
	}

	public function checkoutreturn(){
		
		$data = array(
			'METHOD' => 'GetExpressCheckoutDetails',
			'TOKEN'  => $_SESSION['paypal']['token']
		);

		$result = $this->paypal_model->call($data);

		$_SESSION['paypal']['payerid'] = $result['PAYERID'];
		$_SESSION['paypal']['result'] = $result;

		$order_ids = $_SESSION['paypal']['order_ids'];

		$paypal_data = array(
			'TOKEN'                      => $_SESSION['paypal']['token'],
			'PAYERID'                    => $_SESSION['paypal']['payerid'],
			'METHOD'                     => 'DoExpressCheckoutPayment',
			'PAYMENTREQUEST_0_NOTIFYURL' => $this->config->item('catalog').'/user/confirm/payment?order_ids='.$_SESSION['paypal']['order_ids'],
			'RETURNFMFDETAILS'           => 1
		);

		$paypal_data = array_merge($paypal_data, $this->paypal_model->paymentRequestInfo($_SESSION['paypal']['order_ids']));

		$result = $this->paypal_model->call($paypal_data);

		if ($result['ACK'] == 'Success') {
			//handle order status
			switch($result['PAYMENTINFO_0_PAYMENTSTATUS']) {
				case 'Canceled_Reversal':
					$order_status_id = $this->config->get_config('default_order_status');//取消
					break;
				case 'Completed':
					$order_status_id = $this->config->get_config('to_be_delivered');//待发货
					break;
				case 'Denied':
					$order_status_id = $this->config->get_config('default_order_status');//被拒绝
					break;
				case 'Expired':
					$order_status_id = $this->config->get_config('order_completion_status');//过期
					break;
				case 'Failed':
					$order_status_id = $this->config->get_config('default_order_status');//失败
					break;
				case 'Pending':
					$order_status_id = $this->config->get_config('default_order_status');//处理中
					break;
				case 'Processed':
					$order_status_id = $this->config->get_config('default_order_status');//处理中
					break;
				case 'Refunded':
					$order_status_id = $this->config->get_config('refund_order_success');//退款
					break;
				case 'Reversed':
					$order_status_id = $this->config->get_config('refund_order_success');//退款
					break;
				case 'Voided':
					$order_status_id = $this->config->get_config('default_order_status');//无结果
					break;
			}
			
			foreach($_SESSION['order_ids'] as $key=>$order_id){
				$order_status[$key]['order_id']=$order_id;
				$order_status[$key]['order_status_id']=$order_status_id;
			}
			$this->order_model->edit_order_status($order_status);

		} else {
			if ($result['L_ERRORCODE0'] == '10486') {
				//重试
				if (isset($_SESSION['paypal_redirect_count'])) {

					if ($_SESSION['paypal_redirect_count'] == 2) {
						$_SESSION['paypal_redirect_count'] = 0;
						
						$resule['status']=FALSE;
						
						$resule['msg']='付款不成功：二次请求依然失败！';
						$this->session->set_flashdata('result', $resule);
						
						redirect('user/confirm/payment_info');
						exit;
					} else {
						$_SESSION['paypal_redirect_count']++;
					}
				} else {
					$_SESSION['paypal_redirect_count'] = 1;
				}

				$this->response->redirect('https://www.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=' . $_SESSION['paypal']['token']);
			}

			$resule['status']=FALSE;
						
			$resule['msg']='付款不成功，请选择其它方式付款！';
			$this->session->set_flashdata('result', $resule);
			
			redirect('user/confirm/payment_info');
			exit;
		}
	}
}