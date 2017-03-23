<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Confirm extends MY_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->language('wecome');
		$this->load->library(array('currency'));
		$this->load->model(array('product/product_model', 'product/cart_model', 'localisation/address_model', 'localisation/location_model'));
	}

	public function index(){
		$this->document->setTitle('确认订单');
		
		$this->document->addStyle(base_url('resources/public/resources/default/css/ystep/ystep.css'));
		$this->document->addScript(base_url('resources/public/resources/default/js/ystep/ystep.js'));
		
		$data['addresss']=$this->address_model->get_addresss($this->user->getId());
		
		if($data['addresss']){
			$data['check_out']=TRUE;
		}else{
			$data['check_out']=FALSE;
		}
		
		$data['total']='';
		
		$carts=$this->cart_model->get_carts();
		
		if($carts){
			$selected=$this->input->post('selected');

			foreach($carts as $key=>$value){
				if(isset($carts[$key]['rowid']) && in_array($key, $selected)){
					$product_info=$this->cart_model->get_product_info($carts[$key]['id']);
					$carts[$key]['image']=$product_info['image'];
					$carts[$key]['store_id']=$product_info['store_id'];
					$carts[$key]['name']=$carts[$key]['name'];
					
					if(isset($carts[$key]['options'])){
						$carts[$key]['options']=$this->cart_model->get_product_options($carts[$key]['id'], implode('.', $carts[$key]['options']));
					}
				}else{
					unset($carts[$key]);
				}
			}
			
			$stores=array_filter(array_unique(array_column($carts,'store_id')));
			
			$carts_product=array();
			foreach($stores as $key=>$value){
				$carts_product[$key]=$this->cart_model->get_store($stores[$key]);
				foreach($carts as $k=>$v){
					if($carts_product[$key]['store_id'] == $carts[$k]['store_id']){
						$carts_product[$key]['products'][]=$carts[$k];
					}
				}
			}
			
			//总价
			$data['total']=$this->currency->Compute(array_sum(array_column($carts,'subtotal')));
			
		}else{
			$carts_product=FALSE;
		}
		
		if(!$carts_product || empty($carts_product)){
			redirect('/user/cart', 'location', 301);
		}
		
		//var_dump($carts_product);
		$data['carts_product']=$carts_product;
		
		$data['position_top']=$this->position_top->index();
		$data['position_left']=$this->position_left->index();
		$data['position_right']=$this->position_right->index();
		$data['position_bottom']=$this->position_bottom->index();
		
		$data['header']=$this->header->index();
		$data['top']=$this->header->step_top();
		$data['footer']=$this->footer->index();
		
		$this->load->view('theme/default/template/user/confirm',$data);
	}
	
	public function payment(){
		$this->document->setTitle('支付页面');
		
		$this->document->addStyle(base_url('resources/public/resources/default/css/ystep/ystep.css'));
		$this->document->addScript(base_url('resources/public/resources/default/js/ystep/ystep.js'));
		
		$order_ids=$this->input->get('order_ids');
		$order_ids=explode(',', $order_ids);
		
		if(!isset($order_ids[0]) || $order_ids[0] != $_SESSION['token']){
			$data['retun']=FALSE;
		}else{
			$data['retun']=TRUE;
			
			$this->load->model('setting/setting_model');
			$payment_methods=$this->setting_model->get_setting('payment');
			if(!$payment_methods){
				$data['return']=FALSE;
			}
			$data['payment_methods']=$payment_methods;
			
		}
		
		$this->load->model('order/user_balances_model');
		$balances=$this->user_balances_model->get_balances($this->user->getId());
		$data['balances']=$balances['balances'];
		
		$this->load->model('order/order_model');
		
		unset($order_ids['0']);
		$data['payment_total']='';
		
		if(!is_array($order_ids) || empty($order_ids)){
			$data['return']=FALSE;
		}else{
			$payment_total=$this->order_model->get_payment_amount($order_ids);
			if(!$payment_total){
				
				
				$resule['status']=FALSE;
				$resule['msg']='付款不成功，付款订单中有已付款订单，请不要重复为相同订单付费，谢谢！';
				$this->session->set_flashdata('result', $resule);
				
				redirect('user/confirm/payment_info');
				exit;
			}else{
				$data['payment_total']=$payment_total;
			}
		}
		
		$data['encrypt']=md5($_SESSION['token'].implode(',', $order_ids).$data['payment_total'].$_SESSION['token']);
		
		$data['position_top']=$this->position_top->index();
		$data['position_left']=$this->position_left->index();
		$data['position_right']=$this->position_right->index();
		$data['position_bottom']=$this->position_bottom->index();
		
		$data['header']=$this->header->index();
		$data['top']=$this->header->step_top();
		$data['footer']=$this->footer->index();
		
		$this->load->view('theme/default/template/user/payment',$data);
	}
	
	public function payment_operation(){
		$encrypt=$this->input->get('encrypt');
		$payment_total=$this->input->post('payment_total');
		$order_ids=$this->input->post('order_ids');
		$order_ids=explode(',', $order_ids);
		$pay_password=md5($this->input->post('pay_password'));
		$payment_method=$this->input->post('payment_method');
		
		if($this->input->post('balances') == NULL && $this->input->post('payment_method') == NULL){
			$resule['status']=FALSE;
			$resule['msg']='付款不成功，请选择一个支付方式！';
			$this->session->set_flashdata('result', $resule);
			
			redirect('user/confirm/payment_info');
			exit;
		}
		
		unset($order_ids[0]);
		$input_encrypt=md5($_SESSION['token'].implode(',', $order_ids).$payment_total.$_SESSION['token']);
		
		if($input_encrypt == $encrypt && $this->input->post('balances') != NULL && $this->input->post('balances') == '1'){
			//余额支付
			$this->load->model('order/user_balances_model');
			$data['user_id']			=$this->user->getId();
			$data['money']				=$payment_total;
			$data['content']			=array('title'=>'付款', 'description'=>'支付订单id号:'.implode(',', $order_ids));
			$data['operators']			='-';
			$data['pay_password']		=$pay_password;
			
			$resule=$this->user_balances_model->update($data);
			if($resule['status']){
				foreach($order_ids as $key=>$order_id){
					$order[$key]['order_id']=$order_id;
					$order[$key]['order_status_id']=$this->config->get_config('to_be_delivered');
					$order[$key]['payment_method']='balances';
				}
				
				$this->load->model('order/order_model');
				$this->order_model->edit_order_status($order);
				
				$resule['order_ids']=implode(',', $order_ids);
				$this->session->set_flashdata('result', $resule);
				redirect('user/confirm/payment_info');
			}else{
				$this->session->set_flashdata('result', $resule);
				redirect('user/confirm/payment_info');
			}
		}else{
			//支付接口付款
			$this->load->model('order/user_balances_model');
			$blances=$this->user_balances_model->get_balances($this->user->getId());
			if(!$blances){
				$resule['status']=FALSE;
				$resule['msg']='付款不成功，请先设置支付密码！';
				$this->session->set_flashdata('result', $resule);
				
				redirect('user/confirm/payment_info');
				exit;
			}
			if($blances['pay_password'] != $pay_password){
				$resule['status']=FALSE;
				$resule['msg']='付款不成功，支付密码错误！';
				$this->session->set_flashdata('result', $resule);
				
				redirect('user/confirm/payment_info');
				exit;
			}
			if(empty($payment_method)){
				$resule['status']=FALSE;
				$resule['msg']='付款不成功，请选择一个支付方式！';
				$this->session->set_flashdata('result', $resule);
				
				redirect('user/confirm/payment_info');
				exit;
			}
			
			redirect('extension/payment/'.$payment_method.'?encrypt='.$encrypt.'&order_ids='.$this->input->post('order_ids').'&payment_total='.$payment_total);
		}
	}
	
	public function payment_info(){
		$this->document->setTitle('支付信息返回页面');
		
		$this->document->addStyle(base_url('resources/public/resources/default/css/ystep/ystep.css'));
		$this->document->addScript(base_url('resources/public/resources/default/js/ystep/ystep.js'));
		
		$data['position_top']=$this->position_top->index();
		$data['position_left']=$this->position_left->index();
		$data['position_right']=$this->position_right->index();
		$data['position_bottom']=$this->position_bottom->index();
		
		$data['header']=$this->header->index();
		$data['top']=$this->header->step_top();
		$data['footer']=$this->footer->index();
		
		$this->load->view('theme/default/template/user/payment_info',$data);
	}
	
	public function checkout(){
		$carts=$this->cart_model->get_carts();
		if($carts && $this->input->post('rowid') != NULL){
			
			$selected=$this->input->post('rowid');

			foreach($carts as $key=>$value){
				if(isset($carts[$key]['rowid']) && in_array($key, $selected)){
					$product_info=$this->cart_model->get_product_info($carts[$key]['id']);
					$carts[$key]['image']=$product_info['image'];
					$carts[$key]['store_id']=$product_info['store_id'];
					$carts[$key]['name']=$carts[$key]['name'];
					
					$taxs=$this->cart_model->get_tax_for_cart($product_info['tax_class_id']);
					
					if($taxs){
						if($taxs['type'] == 'F'){
							$carts[$key]['taxes'] = $taxs['rate'];
						}
						elseif($taxs['type'] == 'P'){
							$carts[$key]['taxes'] = $taxs['rate'] * $product_info['price'];
						}
						else
						{
							$carts[$key]['taxes'] = '0';
						}
					}else{
						$carts[$key]['taxes'] = '0';
					}
					
					if(isset($carts[$key]['options'])){
						$carts[$key]['option_value_id']=implode('.', $carts[$key]['options']);
						$carts[$key]['options']=$this->cart_model->get_product_options($carts[$key]['id'], implode('.', $carts[$key]['options']));
					}
				}else{
					unset($carts[$key]);
				}
			}
			
			$stores=array_filter(array_unique(array_column($carts,'store_id')));
			
			$carts_product=array();
			foreach($stores as $key=>$value){
				$carts_product[$key]=$this->cart_model->get_store($stores[$key]);
				foreach($carts as $k=>$v){
					if($carts_product[$key]['store_id'] == $carts[$k]['store_id']){
						$carts_product[$key]['products'][]=$carts[$k];
					}
				}
			}
			
			$payment_address=$this->address_model->get_address_to_checkout($this->input->post('order')['payment_id']);
			$shipping_address=$this->address_model->get_address_to_checkout($this->input->post('order')['address_id']);
			
			$this->load->model(array('common/currency_model', 'commen/language_model', 'order/order_model'));
			$this->load->library(array('user_agent', 'user_lang'));
			$language_id=$this->language_model->get_language_for_code($_SESSION['language_code'])['language_id'];
			
			$currency=$this->currency_model->get_currency($_SESSION['currency_id']);
			$currency_code=$currency['code'];
			$currency_value=$currency['value'];
			
			$order_ids[0]=$_SESSION['token'];
			foreach($carts_product as $key=>$value){
				//order
				$order[$key]['store_id']=$carts_product[$key]['store_id'];
				$order[$key]['user_id']=$this->user->getId();
				$order[$key]['user_class_id']=$this->user->getUserclassId();
				$order[$key]['firstname']=$this->user->getFirstName();
				$order[$key]['lastname']=$this->user->getLastName();
				$order[$key]['email']=$this->user->getEmail();
				$order[$key]['telephone']=$this->user->getTelephone();
				$order[$key]['payment_firstname']=$payment_address['firstname'];
				$order[$key]['payment_lastname']=$payment_address['lastname'];
				$order[$key]['payment_address']=$payment_address['address'];
				$order[$key]['payment_city']=$payment_address['city'];
				$order[$key]['payment_postcode']=$payment_address['postcode'];
				$order[$key]['payment_country']=$payment_address['country'];
				$order[$key]['payment_country_id']=$payment_address['country_id'];
				
				$order[$key]['payment_address_format']=$this->location_model->get_country($payment_address['country_id'])['address_format'];
				
				$order[$key]['payment_zone_id']=$payment_address['zone_id'];
				$order[$key]['payment_zone']=$payment_address['zone'];
				$order[$key]['shipping_firstname']=$shipping_address['firstname'];
				$order[$key]['shipping_lastname']=$shipping_address['lastname'];
				$order[$key]['shipping_address']=$shipping_address['address'];
				$order[$key]['shipping_city']=$shipping_address['city'];
				$order[$key]['shipping_postcode']=$shipping_address['postcode'];
				$order[$key]['shipping_country']=$shipping_address['country'];
				$order[$key]['shipping_country_id']=$shipping_address['country_id'];
				
				$order[$key]['shipping_address_format']=$this->location_model->get_country($shipping_address['country_id'])['address_format'];
				
				$order[$key]['shipping_zone']=$shipping_address['zone'];
				$order[$key]['shipping_zone_id']=$shipping_address['zone_id'];
				$order[$key]['comment']=$this->input->post('order')[$carts_product[$key]['store_id']]['message'];
				//总价
				$order[$key]['total']=array_sum(array_column($carts_product[$key]['products'],'subtotal'));
				
				$order[$key]['order_status_id']=$this->config->get_config('default_order_status');
				$order[$key]['language_id']=$language_id;
				$order[$key]['currency_id']=$_SESSION['currency_id'];
				$order[$key]['currency_code']=$currency_code;
				$order[$key]['currency_value']=$currency_value;
				$order[$key]['ip']=$this->input->ip_address();
				$order[$key]['user_agent']=$this->agent->agent_string();
				$order[$key]['accept_language']=$this->user_lang->get();
				$order[$key]['date_added']=date("Y-m-d H:i:s");
				
				$order_id=$this->order_model->add_order($order[$key]);
				
				$order_ids[$key + 1]=$order_id;
				if($order_id){
					//products
					foreach($carts_product[$key]['products'] as $k=>$v){
						$products[$key][$k]['order_id']=$order_id;
						$products[$key][$k]['rowid']=$carts_product[$key]['products'][$k]['rowid'];
						$products[$key][$k]['store_id']=$carts_product[$key]['products'][$k]['store_id'];
						$products[$key][$k]['product_id']=$carts_product[$key]['products'][$k]['id'];
						$products[$key][$k]['name']=$carts_product[$key]['products'][$k]['name'];
						$products[$key][$k]['quantity']=$carts_product[$key]['products'][$k]['qty'];
						$products[$key][$k]['price']=$carts_product[$key]['products'][$k]['price'];
						$products[$key][$k]['total']=$carts_product[$key]['products'][$k]['subtotal'];
						$products[$key][$k]['image']=$carts_product[$key]['products'][$k]['image'];
						$products[$key][$k]['points']=$carts_product[$key]['products'][$k]['points'];
						
						if(isset($carts_product[$key]['products'][$k]['preferential_type'])){
							$products[$key][$k]['preferential_type']=$carts_product[$key]['products'][$k]['preferential_type'];
						}
						if(isset($carts_product[$key]['products'][$k]['preferential_value'])){
							$products[$key][$k]['preferential_value']=$carts_product[$key]['products'][$k]['preferential_value'];
						}
						
						if(!empty($carts_product[$key]['products'][$k]['option_value_id'])){
							$products[$key][$k]['product_option_value_id']=$carts_product[$key]['products'][$k]['option_value_id'];
							$products[$key][$k]['value']=$carts_product[$key]['products'][$k]['options'];
							$products[$key][$k]['tax']=$carts_product[$key]['products'][$k]['taxes'];
						}else{
							$products[$key][$k]['product_option_value_id']='0';
							$products[$key][$k]['value']='0';
							$products[$key][$k]['tax']='0';
						}
						
						$this->cart_model->delete($carts_product[$key]['products'][$k]['rowid']);
						
					}
					unset($carts_product[$key]['products']);
					if(isset($products[$key])){
						$this->order_model->add_order_product($products[$key]);
						
						//更新session
						$str = uniqid(mt_rand(),1);
						$this->session->set_userdata('cart_id', md5($str));
					}
					
					//添加动态
					$this->load->model('common/user_activity_model');
					$this->user_activity_model->add_activity($_SESSION['user_id'], 'order', array('title'=>'添加了一个新订单！', 'msg'=>'你添加了一个<a href="'.$this->config->item('catalog').'user/orders/order_info?order_id='.$order_id).'">新订单</a>');
				}else{
					echo '数据错误！';
				}
			}
		}else{
			redirect('/user/cart', 'location', 301);
		}
		redirect('/user/confirm/payment?order_ids='.implode(',', $order_ids), 'location', 301);
	}
	
	//更新修改地址
	public function edit_addres(){
		if($this->input->post('address_id') == NULL){
			$data['error']='系统错误，请稍候再试！';
		}else{
			$updata['address_id']=$this->input->post('address_id');
			$updata['firstname']=$this->input->post('firstname');
			$updata['lastname']=$this->input->post('lastname');
			$updata['postcode']=$this->input->post('postcode');
			$updata['address']=$this->input->post('address');
			$updata['city']=$this->input->post('city');
			$updata['country_id']=$this->input->post('country_id');
			$updata['zone_id']=$this->input->post('zone_id');
			$updata['user_address_id']=($this->input->post('user_address_id') != NULL) ? $this->input->post('user_address_id') : '';
			$updata['user_id']=$this->user->getId();
			
			if($this->address_model->updata_address($updata)){
				$data['info']='地址修改成功！';
			}else{
				$data['error']='地址修改失败！';
			}
			
		}
		
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($data));
	}
	
	//添加一个新地址
	public function add_addres(){
		$updata['firstname']=$this->input->post('firstname');
		$updata['lastname']=$this->input->post('lastname');
		$updata['postcode']=$this->input->post('postcode');
		$updata['address']=$this->input->post('address');
		$updata['city']=$this->input->post('city');
		$updata['country_id']=$this->input->post('country_id');
		$updata['zone_id']=$this->input->post('zone_id');
		if($this->input->post('user_address_id') != NULL){
			$def='on';
		}else{
			$def='';
		}
		
		$updata['user_id']=$this->user->getId();
		
		if($this->address_model->add_address($updata, $def)){
			$data['info']='地址添加成功！';
		}else{
			$data['error']='地址添加失败！';
		}
		
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($data));
	}
	
	//ajax获取地址
	public function edit_address(){
		if($this->input->post('address_id') == NULL){
			$data['status']='faile';
			$data['error']='没有选中地址，不能修改！';
		}
		
		if(!isset($data['status'])){
			$address=$this->address_model->get_address_tofrom($this->input->post('address_id'));
		}
		
		if($address){
			$data['countrys']				=$this->location_model->get_countrys();
			$data['status']='success';
			$data['address']=$address;
		}else{
			$data['status']='faile';
			$data['error']='没有选中地址，不能修改！';
		}
		
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($data));
	}
	
	//ajax 获取省
	public function zone(){
		$zones=$this->location_model->get_zones($this->input->get('country_id'));

		$html = '';
		foreach($zones as $zone){
			if($this->input->get('zone_id') == $zone['zone_id']){
				$html .= '<option value="'.$zone['zone_id'].'" selected>'.$zone['zone_name'].'</option>';
			}else{
				$html .= '<option value="'.$zone['zone_id'].'">'.$zone['zone_name'].'</option>';
			}
		}
		
		$this->output
		    ->set_content_type('application/html')
		    ->set_output($html);
	}
	
	//ajax 获取国家
	public function get_countys(){
		$countrys = $this->location_model->get_countrys();
		
		$html = '';
		foreach($countrys as $country){
			$html .= '<option value="'.$country['country_id'].'">'.$country['name'].'</option>'; 
		}
		
		$this->output
		    ->set_content_type('application/html')
		    ->set_output($html);
	}
	
	//获取更新后的地址列表
	public function get_address_list(){
		$addresss=$this->address_model->get_addresss($this->user->getId());
		$html='';
		if($addresss){
			foreach($addresss as $key=>$address){
				if($addresss[$key]['address_id'] == $this->user->getAddressId()){
				$html.='<div class="col-sm-3"><div class="well confirm-address confirm-active">'.$addresss[$key]['address'].'<div class="address-edit" onclick="edit_address('.$address['address_id'].', '.$this->user->getAddressId().');">修改</div></div></div>';
				unset($addresss[$key]);
				}
			}
				
		if(!empty($addresss)){
			foreach($addresss as $address){
				$html.='<div class="col-sm-3"><div class="well confirm-address">'.$address['address'].'<div class="address-edit" onclick="edit_address('.$address['address_id'].');">修改</div></div></div>';
				}
			}
		}
		
		$this->output
		    ->set_content_type('application/html')
		    ->set_output($html);
	}
	
	//获取帐单地址列表
	public function get_payment_address_list(){
		$addresss=$this->address_model->get_addresss($this->user->getId());
		$html='<table class="table table-bordered table-hover"><thead><tr><td class="text-center">设置收货地址</td></tr></thead><tbody style="max-height:400px;overflow:auto;display:block">';
		if($addresss){
			foreach($addresss as $key=>$address){
				if($addresss[$key]['address_id'] == $this->user->getAddressId()){
				$html.='<tr class="payment-address"><td><div class="checkbox"><label><input type="radio" name="order[payment_address_id]" checked="checked" data-address-id="'.$addresss[$key]['address_id'].'">'.$addresss[$key]['address'].'</label></div></td></tr>';
				unset($addresss[$key]);
				}
			}
				
		if(!empty($addresss)){
			foreach($addresss as $address){
				$html.='<tr class="payment-address"><td><div class="checkbox"><label><input type="radio" name="order[payment_address_id]" data-address-id="'.$addresss[$key]['address_id'].'">'.$address['address'].'</label></div></td></tr>';
				}
			}
		}
		$html .= '</tbody></table>';
		
		$this->output
		    ->set_content_type('application/html')
		    ->set_output($html);
	}
}