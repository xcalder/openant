<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->language('wecome');
		if(!$this->user->hasPermission('access', 'admin/common/setting')){
			$this->session->set_flashdata('fali', '你没有访问权限！');
			redirect(site_url());
			exit;
		}
		$this->load->model(array('setting/setting_model','localisation/country_model','common/language_model','common/currency_model','localisation/length_class_model','information/information_model','localisation/weight_class_model','localisation/order_status_model', 'localisation/return_action_model', 'common/user_model', 'common/sale_class_model', 'common/user_class_model'));
	}

	public function index()
	{
		$this->document->setTitle('网站设置');

		$this->get_form();
	}

	public function edit()
	{
		$this->document->setTitle('设置修改');
		
		if($_SERVER['REQUEST_METHOD'] == "POST" && $this->check_modify())
		{
			$this->setting_model->edit($this->input->post(), 'config');
			$this->session->set_flashdata('success', '成功：修改网站设置成功！');
			redirect(site_url('common/setting'));
		}

		$this->get_form();
	}

	public function get_form()
	{
		$settings = $this->setting_model->get_settings();
		$languages=$this->language_model->get_languages();
		$return_actions=$this->return_action_model->get_return_actions_to_setting();
		foreach($settings as $key=>$value)
		{
			if($this->input->post('store_country_id') != NULL && !isset($store_country_id))
			{
				$data['store_country_id'] = $this->input->post('store_country_id');
				$store_country_id = TRUE;
			}
			elseif($settings[$key]['key'] == 'store_country_id' && !isset($store_country_id))
			{
				$data['store_country_id'] = $settings[$key]['value'];
				$store_country_id = TRUE;
			}

			if($this->input->post('store_zone_id') != NULL && !isset($store_zone_id))
			{
				$data['store_zone_id'] = $this->input->post('store_zone_id');
				$store_zone_id = TRUE;
			}
			elseif($settings[$key]['key'] == 'store_zone_id' && !isset($store_zone_id))
			{
				$data['store_zone_id'] = $settings[$key]['value'];
				$store_zone_id = TRUE;
			}

			if($this->input->post('default_language') != NULL && !isset($default_language))
			{
				$data['default_language'] = $this->input->post('default_language');
				$default_language = TRUE;
			}
			elseif($settings[$key]['key'] == 'default_language' && !isset($default_language))
			{
				$data['default_language'] = $settings[$key]['value'];
				$default_language = TRUE;
			}

			if($this->input->post('default_currency') != NULL && !isset($default_currency))
			{
				$data['default_currency'] = $this->input->post('default_currency');
				$default_currency = TRUE;
			}
			elseif($settings[$key]['key'] == 'default_currency' && !isset($default_currency))
			{
				$data['default_currency'] = $settings[$key]['value'];
				$default_currency = TRUE;
			}

			if($this->input->post('default_length_class') != NULL && !isset($default_length_class))
			{
				$data['default_length_class'] = $this->input->post('default_length_class');
				$default_length_class = TRUE;
			}
			elseif($settings[$key]['key'] == 'default_length_class' && !isset($default_length_class))
			{
				$data['default_length_class'] = $settings[$key]['value'];
				$default_length_class = TRUE;
			}

			if($this->input->post('default_weight_class') != NULL && !isset($default_weight_class))
			{
				$data['default_weight_class'] = $this->input->post('default_weight_class');
				$default_weight_class = TRUE;
			}
			elseif($settings[$key]['key'] == 'default_weight_class' && !isset($default_weight_class))
			{
				$data['default_weight_class'] = $settings[$key]['value'];
				$default_weight_class = TRUE;
			}

			if($this->input->post('config_limit_admin') != NULL && !isset($config_limit_admin))
			{
				$data['config_limit_admin'] = $this->input->post('config_limit_admin');
				$config_limit_admin = TRUE;
			}
			elseif($settings[$key]['key'] == 'config_limit_admin' && !isset($config_limit_admin))
			{
				$data['config_limit_admin'] = $settings[$key]['value'];
				$config_limit_admin = TRUE;
			}


			if($this->input->post('config_limit_catalog') != NULL && !isset($config_limit_catalog))
			{
				$data['config_limit_catalog'] = $this->input->post('config_limit_catalog');
				$config_limit_catalog = TRUE;
			}
			elseif($settings[$key]['key'] == 'config_limit_catalog' && !isset($config_limit_catalog))
			{
				$data['config_limit_catalog'] = $settings[$key]['value'];
				$config_limit_catalog = TRUE;
			}

			if($this->input->post('allow_review') != NULL && !isset($allow_review))
			{
				$data['allow_review'] = $this->input->post('allow_review');
				$allow_review = TRUE;
			}
			elseif($settings[$key]['key'] == 'allow_review' && !isset($allow_review))
			{
				$data['allow_review'] = $settings[$key]['value'];
				$allow_review = TRUE;
			}
			
			if($this->input->post('login_window') != NULL && !isset($login_window))
			{
				$data['login_window'] = $this->input->post('login_window');
				$login_window = TRUE;
			}
			elseif($settings[$key]['key'] == 'login_window' && !isset($login_window))
			{
				$data['login_window'] = $settings[$key]['value'];
				$login_window = TRUE;
			}
			
			if($this->input->post('auto_language') != NULL && !isset($auto_language))
			{
				$data['auto_language'] = $this->input->post('auto_language');
				$auto_language = TRUE;
			}
			elseif($settings[$key]['key'] == 'auto_language' && !isset($auto_language))
			{
				$data['auto_language'] = $settings[$key]['value'];
				$auto_language = TRUE;
			}

			if($this->input->post('guest_review') != NULL && !isset($guest_review))
			{
				$data['guest_review'] = $this->input->post('guest_review');
				$guest_review = TRUE;
			}
			elseif($settings[$key]['key'] == 'guest_review' && !isset($guest_review))
			{
				$data['guest_review'] = $settings[$key]['value'];
				$guest_review = TRUE;
			}

			if($this->input->post('remind_review') != NULL && !isset($remind_review))
			{
				$data['remind_review'] = $this->input->post('remind_review');
				$remind_review = TRUE;
			}
			elseif($settings[$key]['key'] == 'remind_review' && !isset($remind_review))
			{
				$data['remind_review'] = $settings[$key]['value'];
				$remind_review = TRUE;
			}

			if($this->input->post('audit_review') != NULL && !isset($audit_review))
			{
				$data['audit_review'] = $this->input->post('audit_review');
				$audit_review = TRUE;
			}
			elseif($settings[$key]['key'] == 'audit_review' && !isset($audit_review))
			{
				$data['audit_review'] = $settings[$key]['value'];
				$audit_review = TRUE;
			}

			if($this->input->post('points_proportion') != NULL && !isset($points_proportion))
			{
				$data['points_proportion'] = $this->input->post('points_proportion');
				$points_proportion = TRUE;
			}
			elseif($settings[$key]['key'] == 'points_proportion')
			{
				$data['points_proportion'] = $settings[$key]['value'];
				$points_proportion = TRUE;
			}

			if($this->input->post('coupon_use') != NULL && !isset($coupon_use))
			{
				$data['coupon_use'] = $this->input->post('coupon_use');
				$coupon_use = TRUE;
			}
			elseif($settings[$key]['key'] == 'coupon_use' && !isset($coupon_use))
			{
				$data['coupon_use'] = $settings[$key]['value'];
				$coupon_use = TRUE;
			}

			if($this->input->post('register_get_points') != NULL && !isset($register_get_points))
			{
				$data['register_get_points'] = $this->input->post('register_get_points');
				$register_get_points = TRUE;
			}
			elseif($settings[$key]['key'] == 'register_get_points' && !isset($register_get_points))
			{
				$data['register_get_points'] = $settings[$key]['value'];
				$register_get_points = TRUE;
			}

			if($this->input->post('display_tax') != NULL && !isset($display_tax))
			{
				$data['display_tax'] = $this->input->post('display_tax');
				$display_tax = TRUE;
			}
			elseif($settings[$key]['key'] == 'display_tax' && !isset($display_tax))
			{
				$data['display_tax'] = $settings[$key]['value'];
				$display_tax = TRUE;
			}

			if($this->input->post('register_group') != NULL && !isset($register_group))
			{
				$data['register_group'] = $this->input->post('register_group');
				$register_group = TRUE;
			}
			elseif($settings[$key]['key'] == 'register_group' && !isset($register_group))
			{
				$data['register_group'] = $settings[$key]['value'];
				$register_group = TRUE;
			}
			
			if($this->input->post('competence_group') != NULL && !isset($competence_group))
			{
				$data['competence_group'] = $this->input->post('competence_group');
				$competence_group = TRUE;
			}
			elseif($settings[$key]['key'] == 'competence_group' && !isset($competence_group))
			{
				$data['competence_group'] = $settings[$key]['value'];
				$competence_group = TRUE;
			}

			if($this->input->post('login_price_displayed') != NULL && !isset($login_price_displayed))
			{
				$data['login_price_displayed'] = $this->input->post('login_price_displayed');
				$login_price_displayed = TRUE;
			}
			elseif($settings[$key]['key'] == 'login_price_displayed' && !isset($login_price_displayed))
			{
				$data['login_price_displayed'] = $settings[$key]['value'];
				$login_price_displayed = TRUE;
			}

			if($this->input->post('registration_terms') != NULL && !isset($registration_terms))
			{
				$data['registration_terms'] = $this->input->post('registration_terms');
				$registration_terms = TRUE;
			}
			elseif($settings[$key]['key'] == 'registration_terms' && !isset($registration_terms))
			{
				$data['registration_terms'] = $settings[$key]['value'];
				$registration_terms = TRUE;
			}
			
			if($this->input->post('return_terms') != NULL && !isset($return_terms))
			{
				$data['return_terms'] = $this->input->post('return_terms');
				$return_terms = TRUE;
			}
			elseif($settings[$key]['key'] == 'return_terms' && !isset($return_terms))
			{
				$data['return_terms'] = $settings[$key]['value'];
				$return_terms = TRUE;
			}

			if($this->input->post('sale_terms') != NULL && !isset($sale_terms))
			{
				$data['sale_terms'] = $this->input->post('sale_terms');
				$sale_terms = TRUE;
			}
			elseif($settings[$key]['key'] == 'sale_terms' && !isset($sale_terms))
			{
				$data['sale_terms'] = $settings[$key]['value'];
				$sale_terms = TRUE;
			}

			if($this->input->post('notify_admin') != NULL && !isset($notify_admin))
			{
				$data['notify_admin'] = $this->input->post('notify_admin');
				$notify_admin = TRUE;
			}
			elseif($settings[$key]['key'] == 'notify_admin' && !isset($notify_admin))
			{
				$data['notify_admin'] = $settings[$key]['value'];
				$notify_admin = TRUE;
			}

			if($this->input->post('verify_email') != NULL && !isset($verify_email))
			{
				$data['verify_email'] = $this->input->post('verify_email');
				$verify_email = TRUE;
			}
			elseif($settings[$key]['key'] == 'verify_email' && !isset($verify_email))
			{
				$data['verify_email'] = $settings[$key]['value'];
				$verify_email = TRUE;
			}

			if($this->input->post('guest_checkout') != NULL && !isset($guest_checkout))
			{
				$data['guest_checkout'] = $this->input->post('guest_checkout');
				$guest_checkout = TRUE;
			}
			elseif($settings[$key]['key'] == 'guest_checkout' && !isset($guest_checkout))
			{
				$data['guest_checkout'] = $settings[$key]['value'];
				$guest_checkout = TRUE;
			}

			if($this->input->post('default_order_status') != NULL && !isset($default_order_status))
			{
				$data['default_order_status'] = $this->input->post('default_order_status');
				$default_order_status = TRUE;
			}
			elseif($settings[$key]['key'] == 'default_order_status' && !isset($default_order_status))
			{
				$data['default_order_status'] = $settings[$key]['value'];
				$default_order_status = TRUE;
			}
			
			//退换货事件
			if($this->input->post('action_return_and_refund') != NULL && !isset($action_return_and_refund))
			{
				$data['action_return_and_refund'] = $this->input->post('action_return_and_refund');
				$action_return_and_refund = TRUE;
			}
			elseif($settings[$key]['key'] == 'action_return_and_refund' && !isset($action_return_and_refund))
			{
				$data['action_return_and_refund'] = $settings[$key]['value'];
				$action_return_and_refund = TRUE;
			}
			
			if($this->input->post('action_return') != NULL && !isset($action_return))
			{
				$data['action_return'] = $this->input->post('action_return');
				$action_return = TRUE;
			}
			elseif($settings[$key]['key'] == 'action_return' && !isset($action_return))
			{
				$data['action_return'] = $settings[$key]['value'];
				$action_return = TRUE;
			}
			
			if($this->input->post('action_refund') != NULL && !isset($action_refund))
			{
				$data['action_refund'] = $this->input->post('action_refund');
				$action_refund = TRUE;
			}
			elseif($settings[$key]['key'] == 'action_refund' && !isset($action_refund))
			{
				$data['action_refund'] = $settings[$key]['value'];
				$action_refund = TRUE;
			}
			
			if($this->input->post('inbound_state') != NULL && !isset($inbound_state))
			{
				$data['inbound_state'] = $this->input->post('inbound_state');
				$inbound_state = TRUE;
			}
			elseif($settings[$key]['key'] == 'inbound_state' && !isset($inbound_state))
			{
				$data['inbound_state'] = $settings[$key]['value'];
				$inbound_state = TRUE;
			}
			
			if($this->input->post('state_to_be_evaluated') != NULL && !isset($state_to_be_evaluated))
			{
				$data['state_to_be_evaluated'] = $this->input->post('state_to_be_evaluated');
				$state_to_be_evaluated = TRUE;
			}
			elseif($settings[$key]['key'] == 'state_to_be_evaluated' && !isset($state_to_be_evaluated))
			{
				$data['state_to_be_evaluated'] = $settings[$key]['value'];
				$state_to_be_evaluated = TRUE;
			}
			
			if($this->input->post('order_completion_status') != NULL && !isset($order_completion_status))
			{
				$data['order_completion_status'] = $this->input->post('order_completion_status');
				$order_completion_status = TRUE;
			}
			elseif($settings[$key]['key'] == 'order_completion_status' && !isset($order_completion_status))
			{
				$data['order_completion_status'] = $settings[$key]['value'];
				$order_completion_status = TRUE;
			}
			
			if($this->input->post('to_be_delivered') != NULL && !isset($to_be_delivered))
			{
				$data['to_be_delivered'] = $this->input->post('to_be_delivered');
				$to_be_delivered = TRUE;
			}
			elseif($settings[$key]['key'] == 'to_be_delivered' && !isset($to_be_delivered))
			{
				$data['to_be_delivered'] = $settings[$key]['value'];
				$to_be_delivered = TRUE;
			}
			
			if($this->input->post('admin_user_group') != NULL && !isset($admin_user_group))
			{
				$data['admin_user_group'] = $this->input->post('admin_user_group');
				$admin_user_group = TRUE;
			}
			elseif($settings[$key]['key'] == 'admin_user_group' && !isset($admin_user_group))
			{
				$data['admin_user_group'] = unserialize($settings[$key]['value']);
				$admin_user_group = TRUE;
			}

			if($this->input->post('default_sale_class') != NULL && !isset($default_sale_class))
			{
				$data['default_sale_class'] = $this->input->post('default_sale_class');
				$default_sale_class = TRUE;
			}
			elseif($settings[$key]['key'] == 'default_sale_class' && !isset($default_sale_class))
			{
				$data['default_sale_class'] = $settings[$key]['value'];
				$default_sale_class = TRUE;
			}
			
			if($this->input->post('default_user_class') != NULL && !isset($default_user_class))
			{
				$data['default_user_class'] = $this->input->post('default_user_class');
				$default_user_class = TRUE;
			}
			elseif($settings[$key]['key'] == 'default_user_class' && !isset($default_user_class))
			{
				$data['default_user_class'] = $settings[$key]['value'];
				$default_user_class = TRUE;
			}
			
			if($this->input->post('refund_order_success') != NULL && !isset($refund_order_success))
			{
				$data['refund_order_success'] = $this->input->post('refund_order_success');
				$refund_order_success = TRUE;
			}
			elseif($settings[$key]['key'] == 'refund_order_success' && !isset($refund_order_success))
			{
				$refund_order_success = TRUE;
				$data['refund_order_success'] = $settings[$key]['value'];
			}
			
			if($this->input->post('refund_order') != NULL && !isset($refund_order))
			{
				$data['refund_order'] = $this->input->post('refund_order');
				$refund_order = TRUE;
			}
			elseif($settings[$key]['key'] == 'refund_order' && !isset($refund_order))
			{
				$refund_order = TRUE;
				$data['refund_order'] = $settings[$key]['value'];
			}

			if($this->input->post('order_email_alert') != NULL && !isset($order_email_alert))
			{
				$data['order_email_alert'] = $this->input->post('order_email_alert');
				$order_email_alert = TRUE;
			}
			elseif($settings[$key]['key'] == 'order_email_alert' && !isset($order_email_alert))
			{
				$order_email_alert = TRUE;
				$data['order_email_alert'] = $settings[$key]['value'];
			}

			//设置站点标题
			if($this->input->post('site_name') != NULL && !isset($site_name))
			{
				$data['site_name'] = $this->input->post('site_name');
				$site_name = TRUE;
			}
			elseif(($settings[$key]['key'] == 'site_name') && !isset($site_name))
			{
				$data['site_name'] = @unserialize($settings[$key]['value']);
				$site_name = TRUE;
			}
			
			
			if($this->input->post('site_abbreviation') != NULL && !isset($site_abbreviation))
			{
				$data['site_abbreviation'] = $this->input->post('site_abbreviation');
				$site_abbreviation = TRUE;
			}
			elseif(($settings[$key]['key'] == 'site_abbreviation') && !isset($site_abbreviation))
			{
				$data['site_abbreviation'] = @unserialize($settings[$key]['value']);
				$site_abbreviation = TRUE;
			}
			
			
			if($this->input->post('meta_keyword') != NULL && !isset($meta_keyword))
			{
				$data['meta_keyword'] = $this->input->post('meta_keyword');
				$meta_keyword = TRUE;
			}
			elseif($settings[$key]['key'] == 'meta_keyword' && !isset($meta_keyword))
			{
				$data['meta_keyword'] = @unserialize($settings[$key]['value']);
				$meta_keyword = TRUE;
			}
			
			
			if($this->input->post('meta_description') != NULL && !isset($meta_description))
			{
				$data['meta_description'] = $this->input->post('meta_description');
				$meta_description = TRUE;
			}
			elseif($settings[$key]['key'] == 'meta_description' && !isset($meta_description))
			{
				$data['meta_description'] = @unserialize($settings[$key]['value']);
				$meta_description = TRUE;
			}
			//
			
			if($this->input->post('site_image') != NULL && !isset($site_image))
			{
				$data['site_image_thmb'] = $this->image_common->resize($this->input->post('site_image'), 100, 100, 'h');
				$data['site_image'] = $this->input->post('site_image');
				$site_image = TRUE;
			}
			elseif($settings[$key]['key'] == 'site_image' && !isset($site_image))
			{
				@$data['site_image_thmb'] = $this->image_common->resize($settings[$key]['value'], 100, 100, 'h');
				$data['site_image'] = $settings[$key]['value'];
				$site_image = TRUE;
			}

			if($this->input->post('site_icon') != NULL && !isset($site_icon))
			{
				$data['site_icon_thmb'] = $this->image_common->resize($this->input->post('site_icon'), 100, 100, 'h');
				$data['site_icon'] = $this->input->post('site_icon');
				$site_icon = TRUE;
			}
			elseif($settings[$key]['key'] == 'site_icon' && !isset($site_icon))
			{
				@$data['site_icon_thmb'] = $this->image_common->resize($settings[$key]['value'], 100, 100, 'h');
				$data['site_icon'] = $settings[$key]['value'];
				$site_icon = TRUE;
			}

			if($this->input->post('category_image_size_w') != NULL && !isset($category_image_size_w))
			{
				$data['category_image_size_w'] = $this->input->post('category_image_size_w');
				$category_image_size_w = TRUE;
			}
			elseif($settings[$key]['key'] == 'category_image_size_w' && !isset($category_image_size_w))
			{
				$data['category_image_size_w'] = $settings[$key]['value'];
				$category_image_size_w = TRUE;
			}

			if($this->input->post('category_image_size_h') != NULL && !isset($category_image_size_h))
			{
				$data['category_image_size_h'] = $this->input->post('category_image_size_h');
				$category_image_size_h = TRUE;
			}
			elseif($settings[$key]['key'] == 'category_image_size_h' && !isset($category_image_size_h))
			{
				$data['category_image_size_h'] = $settings[$key]['value'];
				$category_image_size_h = TRUE;
			}

			if($this->input->post('product_thumbnail_size_w') != NULL && !isset($product_thumbnail_size_w))
			{
				$data['product_thumbnail_size_w'] = $this->input->post('product_thumbnail_size_w');
				$product_thumbnail_size_w = TRUE;
			}
			elseif($settings[$key]['key'] == 'product_thumbnail_size_w' && !isset($product_thumbnail_size_w))
			{
				$data['product_thumbnail_size_w'] = $settings[$key]['value'];
				$product_thumbnail_size_w = TRUE;
			}

			if($this->input->post('product_thumbnail_size_h') != NULL && !isset($product_thumbnail_size_h))
			{
				$data['product_thumbnail_size_h'] = $this->input->post('product_thumbnail_size_h');
				$product_thumbnail_size_h = TRUE;
			}
			elseif($settings[$key]['key'] == 'product_thumbnail_size_h' && !isset($product_thumbnail_size_h))
			{
				$data['product_thumbnail_size_h'] = $settings[$key]['value'];
				$product_thumbnail_size_h = TRUE;
			}

			if($this->input->post('product_image_size_w') != NULL && !isset($product_image_size_w))
			{
				$data['product_image_size_w'] = $this->input->post('product_image_size_w');
				$product_image_size_w = TRUE;
			}
			elseif($settings[$key]['key'] == 'product_image_size_w' && !isset($product_image_size_w))
			{
				$data['product_image_size_w'] = $settings[$key]['value'];
				$product_image_size_w = TRUE;
			}

			if($this->input->post('product_image_size_h') != NULL && !isset($product_image_size_h))
			{
				$data['product_image_size_h'] = $this->input->post('product_image_size_h');
				$product_image_size_h = TRUE;
			}
			elseif($settings[$key]['key'] == 'product_image_size_h' && !isset($product_image_size_h))
			{
				$data['product_image_size_h'] = $settings[$key]['value'];
				$product_image_size_h = TRUE;
			}

			if($this->input->post('product_list_image_size_w') != NULL && !isset($product_list_image_size_w))
			{
				$data['product_list_image_size_w'] = $this->input->post('product_list_image_size_w');
				$product_list_image_size_w = TRUE;
			}
			elseif($settings[$key]['key'] == 'product_list_image_size_w' && !isset($product_list_image_size_w))
			{
				$data['product_list_image_size_w'] = $settings[$key]['value'];
				$product_list_image_size_w = TRUE;
			}

			if($this->input->post('product_list_image_size_h') != NULL && !isset($product_list_image_size_h))
			{
				$data['product_list_image_size_h'] = $this->input->post('product_list_image_size_h');
				$product_list_image_size_h = TRUE;
			}
			elseif($settings[$key]['key'] == 'product_list_image_size_h' && !isset($product_list_image_size_h))
			{
				$data['product_list_image_size_h'] = $settings[$key]['value'];
				$product_list_image_size_h = TRUE;
			}

			if($this->input->post('wish_cart_image_size_s_w') != NULL && !isset($wish_cart_image_size_s_w))
			{
				$data['wish_cart_image_size_s_w'] = $this->input->post('wish_cart_image_size_s_w');
				$wish_cart_image_size_s_w = TRUE;
			}
			elseif($settings[$key]['key'] == 'wish_cart_image_size_s_w' && !isset($wish_cart_image_size_s_w))
			{
				$data['wish_cart_image_size_s_w'] = $settings[$key]['value'];
				$wish_cart_image_size_s_w = TRUE;
			}

			if($this->input->post('wish_cart_image_size_s_h') != NULL && !isset($wish_cart_image_size_s_h))
			{
				$data['wish_cart_image_size_s_h'] = $this->input->post('wish_cart_image_size_s_h');
				$wish_cart_image_size_s_h = TRUE;
			}
			elseif($settings[$key]['key'] == 'wish_cart_image_size_s_h' && !isset($wish_cart_image_size_s_h))
			{
				$data['wish_cart_image_size_s_h'] = $settings[$key]['value'];
				$wish_cart_image_size_s_h = TRUE;
			}
			
			if($this->input->post('wish_cart_image_size_b_w') != NULL && !isset($wish_cart_image_size_b_w))
			{
				$data['wish_cart_image_size_b_w'] = $this->input->post('wish_cart_image_size_b_w');
				$wish_cart_image_size_b_w = TRUE;
			}
			elseif($settings[$key]['key'] == 'wish_cart_image_size_b_w' && !isset($wish_cart_image_size_b_w))
			{
				$data['wish_cart_image_size_b_w'] = $settings[$key]['value'];
				$wish_cart_image_size_b_w = TRUE;
			}

			if($this->input->post('wish_cart_image_size_b_h') != NULL && !isset($wish_cart_image_size_b_h))
			{
				$data['wish_cart_image_size_b_h'] = $this->input->post('wish_cart_image_size_b_h');
				$wish_cart_image_size_b_h = TRUE;
			}
			elseif($settings[$key]['key'] == 'wish_cart_image_size_b_h' && !isset($wish_cart_image_size_b_h))
			{
				$data['wish_cart_image_size_b_h'] = $settings[$key]['value'];
				$wish_cart_image_size_b_h = TRUE;
			}

			if($this->input->post('email_protocol') != NULL && !isset($email_protocol))
			{
				$data['email_protocol'] = $this->input->post('email_protocol');
				$email_protocol = TRUE;
			}
			elseif($settings[$key]['key'] == 'email_protocol' && !isset($email_protocol))
			{
				$data['email_protocol'] = $settings[$key]['value'];
				$email_protocol = TRUE;
			}

			if($this->input->post('email_smtp_host') != NULL && !isset($email_smtp_host))
			{
				$data['email_smtp_host'] = $this->input->post('email_smtp_host');
				$email_smtp_host = TRUE;
			}
			elseif($settings[$key]['key'] == 'email_smtp_host' && !isset($email_smtp_host))
			{
				$data['email_smtp_host'] = $settings[$key]['value'];
				$email_smtp_host = TRUE;
			}

			if($this->input->post('email_smtp_user') != NULL && !isset($email_smtp_user))
			{
				$data['email_smtp_user'] = $this->input->post('email_smtp_user');
				$email_smtp_user = TRUE;
			}
			elseif($settings[$key]['key'] == 'email_smtp_user' && !isset($email_smtp_user))
			{
				$data['email_smtp_user'] = $settings[$key]['value'];
				$email_smtp_user = TRUE;
			}

			if($this->input->post('email_smtp_pass') != NULL && !isset($email_smtp_pass))
			{
				$data['email_smtp_pass'] = $this->input->post('email_smtp_pass');
				$email_smtp_pass = TRUE;
			}
			elseif($settings[$key]['key'] == 'email_smtp_pass' && !isset($email_smtp_pass))
			{
				$data['email_smtp_pass'] = $settings[$key]['value'];
				$email_smtp_pass = TRUE;
			}

			if($this->input->post('email_smtp_port') != NULL && !isset($email_smtp_port))
			{
				$data['email_smtp_port'] = $this->input->post('email_smtp_port');
				$email_smtp_port = TRUE;
			}
			elseif($settings[$key]['key'] == 'email_smtp_port' && !isset($email_smtp_port))
			{
				$data['email_smtp_port'] = $settings[$key]['value'];
				$email_smtp_port = TRUE;
			}

			if($this->input->post('email_smtp_timeout') != NULL && !isset($email_smtp_timeout))
			{
				$data['email_smtp_timeout'] = $this->input->post('email_smtp_timeout');
				$email_smtp_timeout = TRUE;
			}
			elseif($settings[$key]['key'] == 'email_smtp_timeout' && !isset($email_smtp_timeout))
			{
				$data['email_smtp_timeout'] = $settings[$key]['value'];
				$email_smtp_timeout = TRUE;
			}

			if($this->input->post('email_send_header') != NULL && !isset($email_send_header))
			{
				$data['email_send_header'] = $this->input->post('email_send_header');
				$email_send_header = TRUE;
			}
			elseif($settings[$key]['key'] == 'email_send_header' && !isset($email_send_header))
			{
				$data['email_send_header'] = $settings[$key]['value'];
				$email_send_header = TRUE;
			}

			if($this->input->post('email_send_footer') != NULL && !isset($email_send_footer))
			{
				$data['email_send_footer'] = $this->input->post('email_send_footer');
				$email_send_footer = TRUE;
			}
			elseif($settings[$key]['key'] == 'email_send_footer' && !isset($email_send_footer))
			{
				$data['email_send_footer'] = $settings[$key]['value'];
				$email_send_footer = TRUE;
			}

			if($this->input->post('upload_limit_size') != NULL && !isset($upload_limit_size))
			{
				$data['upload_limit_size'] = $this->input->post('upload_limit_size');
				$upload_limit_size = TRUE;
			}
			elseif($settings[$key]['key'] == 'upload_limit_size' && !isset($upload_limit_size))
			{
				$data['upload_limit_size'] = $settings[$key]['value'];
				$upload_limit_size = TRUE;
			}

			if($this->input->post('maintenance_mode') != NULL && !isset($maintenance_mode))
			{
				$data['maintenance_mode'] = $this->input->post('maintenance_mode');
				$maintenance_mode = TRUE;
			}
			elseif($settings[$key]['key'] == 'maintenance_mode' && !isset($maintenance_mode))
			{
				$data['maintenance_mode'] = $settings[$key]['value'];
				$maintenance_mode = TRUE;
			}
			
			if($this->input->post('output_compression_level') != NULL && !isset($output_compression_level))
			{
				$data['output_compression_level'] = $this->input->post('output_compression_level');
				$output_compression_level = TRUE;
			}
			elseif($settings[$key]['key'] == 'output_compression_level' && !isset($output_compression_level))
			{
				$data['output_compression_level'] = $settings[$key]['value'];
				$output_compression_level = TRUE;
			}
	
		}

		$data['action'] = site_url('common/setting/edit');

		$data['placeholder_image'] = 'public/resources/default/image/no_image.jpg';

		$data['countrys'] = $this->country_model->get_countrys();
		$data['languages'] = $languages;
		$data['return_actions'] = $return_actions;
		$data['currencys'] = $this->currency_model->get_currencys();
		$data['length_classs'] = $this->length_class_model->get_length_classs();
		$data['weight_classs'] = $this->weight_class_model->get_weight_classs();
		$data['user_groups'] = $this->user_model->get_user_groups_all();
		$data['informations'] = $this->information_model->get_informations_where_store();
		$data['order_statuss'] = $this->order_status_model->get_order_statuss_for_setting();
		$data['sale_classs'] = $this->sale_class_model->get_sale_classs_to_setting();
		$data['user_classs'] = $this->user_class_model->get_user_classs_to_setting();

		$data['header'] = $this->header->index();
		$data['top'] = $this->header->top();
		$data['footer'] = $this->footer->index();

		$this->load->view('theme/default/template/common/setting',$data);
	}
	
	public function check_modify(){
		if (!$this->user->hasPermission('modify', 'admin/common/setting')) {
			$this->session->set_flashdata('danger', '你无权修改，请联系管理员！');
			redirect(site_url('common/setting'));
			exit();
		}else {
			return true;
		}
	}
}
