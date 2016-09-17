<?php echo $header;//装载header?>
<?php echo $top;//装载top?>
<!-- /subnavbar -->
<div class="container">
	<div class="row">
		<form action="<?php echo $action;?>" method="post" enctype="multipart/form-data" id="setting" class="form-horizontal">
			<div class="col-md-6 middle-flat-left">
				<!-- /widget -->
				<div class="panel panel-default">
					<div class="panel-heading row row-panel-heading bg-info">
						<p class="navbar-left">
							<i class="glyphicon glyphicon-calendar">
							</i>&nbsp;选项
						</p>
						<div class="navbar-right btn-group" style="margin-right: 0">
							<button type="button" onclick="submit('form-setting')" class="btn btn-default btn-sm">
								<i class="glyphicon glyphicon-floppy-save">
								</i>
							</button>
						</div>
					</div>
					<!-- /widget-header -->
					<div class="panel-body">
						<div class="form-group">
							<label class="col-sm-2 control-label" for="config_limit_catalog">
								前台每页显示数
							</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="config_limit_catalog" name="config_limit_catalog" placeholder="前台每页显示数" value="<?php echo isset($config_limit_catalog) ? $config_limit_catalog : '';?>">

							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="config_limit_admin">
								后台每页显示数
							</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="config_limit_admin" name="config_limit_admin" placeholder="网站名称" value="<?php echo isset($config_limit_admin) ? $config_limit_admin : '';?>">

							</div>
						</div>
						<hr style="margin: 0 0 15px 0">
						<div class="form-group">
							<label class="col-sm-2 control-label" for="allow_review">
								允许评价
							</label>
							<div class="col-sm-10">
								<?php
								if(isset($allow_review) && $allow_review == '0'):?>
								<label class="radio-inline">
									<input type="radio" name="allow_review" id="allow_review" value="1"> 是
								</label>
								<label class="radio-inline">
									<input type="radio" name="allow_review" id="allow_review" value="0" checked> 否
								</label>
								<?php
								else:?>
								<label class="radio-inline">
									<input type="radio" name="allow_review" id="allow_review" value="1" checked> 是
								</label>
								<label class="radio-inline">
									<input type="radio" name="allow_review" id="allow_review" value="0"> 否
								</label>
								<?php endif;?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="guest_review">
								游客评价
							</label>
							<div class="col-sm-10">
								<?php
								if(isset($guest_review) && $guest_review == '0'):?>
								<label class="radio-inline">
									<input type="radio" name="guest_review" id="guest_review" value="1"> 是
								</label>
								<label class="radio-inline">
									<input type="radio" name="guest_review" id="guest_review" value="0" checked> 否
								</label>
								<?php
								else:?>
								<label class="radio-inline">
									<input type="radio" name="guest_review" id="guest_review" value="1" checked> 是
								</label>
								<label class="radio-inline">
									<input type="radio" name="guest_review" id="guest_review" value="0"> 否
								</label>
								<?php endif;?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="remind_review">
								新评论邮件提醒
							</label>
							<div class="col-sm-10">
								<?php
								if(isset($remind_review) && $remind_review == '0'):?>
								<label class="radio-inline">
									<input type="radio" name="remind_review" id="remind_review" value="1"> 是
								</label>
								<label class="radio-inline">
									<input type="radio" name="remind_review" id="remind_review" value="0" checked> 否
								</label>
								<?php
								else:?>
								<label class="radio-inline">
									<input type="radio" name="remind_review" id="remind_review" value="1" checked> 是
								</label>
								<label class="radio-inline">
									<input type="radio" name="remind_review" id="remind_review" value="0"> 否
								</label>
								<?php endif;?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="audit_review">
								审核评论
							</label>
							<div class="col-sm-10">
								<?php
								if(isset($audit_review) && $audit_review == '0'):?>
								<label class="radio-inline">
									<input type="radio" name="audit_review" id="audit_review" value="1"> 是
								</label>
								<label class="radio-inline">
									<input type="radio" name="audit_review" id="audit_review" value="0" checked> 否
								</label>
								<?php
								else:?>
								<label class="radio-inline">
									<input type="radio" name="audit_review" id="audit_review" value="1" checked> 是
								</label>
								<label class="radio-inline">
									<input type="radio" name="audit_review" id="audit_review" value="0"> 否
								</label>
								<?php endif;?>
							</div>
						</div>
						<hr style="margin: 0 0 15px 0">
						<div class="form-group">
							<label class="col-sm-2 control-label" for="points_proportion">
								使用积分
							</label>
							<div class="col-sm-10">
								<?php
								if(isset($points_proportion) && $points_proportion == '0'):?>
								<label class="radio-inline">
									<input type="radio" name="points_proportion" id="points_proportion" value="1"> 是
								</label>
								<label class="radio-inline">
									<input type="radio" name="points_proportion" id="points_proportion" value="0" checked> 否
								</label>
								<?php
								else:?>
								<label class="radio-inline">
									<input type="radio" name="points_proportion" id="points_proportion" value="1" checked> 是
								</label>
								<label class="radio-inline">
									<input type="radio" name="points_proportion" id="points_proportion" value="0"> 否
								</label>
								<?php endif;?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="coupon_use">
								使用优惠券
							</label>
							<div class="col-sm-10">
								<?php
								if(isset($coupon_use) && $coupon_use == '0'):?>
								<label class="radio-inline">
									<input type="radio" name="coupon_use" id="coupon_use" value="1"> 是
								</label>
								<label class="radio-inline">
									<input type="radio" name="coupon_use" id="coupon_use" value="0" checked> 否
								</label>
								<?php
								else:?>
								<label class="radio-inline">
									<input type="radio" name="coupon_use" id="coupon_use" value="1" checked> 是
								</label>
								<label class="radio-inline">
									<input type="radio" name="coupon_use" id="coupon_use" value="0"> 否
								</label>
								<?php endif;?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="register_get_points">
								注册送积分
							</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="register_get_points" name="register_get_points" placeholder="网站名称" value="<?php echo isset($register_get_points) ? $register_get_points : '0'?>">

							</div>
						</div>
						<hr style="margin: 0 0 15px 0">
						<div class="form-group">
							<label class="col-sm-2 control-label" for="display_tax">
								显示税
							</label>
							<div class="col-sm-10">
								<?php
								if(isset($display_tax) && $display_tax == '0'):?>
								<label class="radio-inline">
									<input type="radio" name="display_tax" id="display_tax" value="1"> 是
								</label>
								<label class="radio-inline">
									<input type="radio" name="display_tax" id="display_tax" value="0" checked> 否
								</label>
								<?php
								else:?>
								<label class="radio-inline">
									<input type="radio" name="display_tax" id="display_tax" value="1" checked> 是
								</label>
								<label class="radio-inline">
									<input type="radio" name="display_tax" id="display_tax" value="0"> 否
								</label>
								<?php endif;?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="register_group">
								注册默认权限组
							</label>
							<div class="col-sm-10">
								<select id="register_group" name="register_group" class="form-control">
									<?php
									foreach($user_groups as $user_group):?>
									<?php
									if(isset($register_group) && $register_group == $user_group['user_group_id']):?>
									<option value="<?php echo $user_group['user_group_id'];?>" selected>
										<?php echo $user_group['name'];?>
									</option>
									<?php
									else:?>
									<option value="<?php echo $user_group['user_group_id'];?>">
										<?php echo $user_group['name'];?>
									</option>
									<?php endif;?>
									<?php endforeach;?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="default_sale_class">
								注册默认商家组
							</label>
							<div class="col-sm-10">
								<select id="default_sale_class" name="default_sale_class" class="form-control">
									<?php
									foreach($sale_classs as $sale_class):?>
									<?php
									if(isset($default_sale_class) && $default_sale_class == $sale_class['sale_class_id']):?>
									<option value="<?php echo $sale_class['sale_class_id'];?>" selected>
										<?php echo $sale_class['name'];?>
									</option>
									<?php
									else:?>
									<option value="<?php echo $sale_class['sale_class_id'];?>">
										<?php echo $sale_class['name'];?>
									</option>
									<?php endif;?>
									<?php endforeach;?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="competence_group">
								默认商家权限组
							</label>
							<div class="col-sm-10">
								<select id="competence_group" name="competence_group" class="form-control">
									<?php foreach($user_groups as $user_group):?>
									<?php if(isset($competence_group) && $competence_group == $user_group['user_group_id']):?>
									<option value="<?php echo $user_group['user_group_id'];?>" selected>
										<?php echo $user_group['name'];?>
									</option>
									<?php else:?>
									<option value="<?php echo $user_group['user_group_id'];?>">
										<?php echo $user_group['name'];?>
									</option>
									<?php endif;?>
									<?php endforeach;?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="default_user_class">
								注册默认买家组
							</label>
							<div class="col-sm-10">
								<select id="default_user_class" name="default_user_class" class="form-control">
									<?php
									foreach($user_classs as $user_class):?>
									<?php
									if(isset($default_user_class) && $default_user_class == $user_class['user_class_id']):?>
									<option value="<?php echo $user_class['user_class_id'];?>" selected>
										<?php echo $user_class['name'];?>
									</option>
									<?php
									else:?>
									<option value="<?php echo $user_class['user_class_id'];?>">
										<?php echo $user_class['name'];?>
									</option>
									<?php endif;?>
									<?php endforeach;?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="admin_user_group">
								管理员权限组
							</label>
							<div class="col-sm-10">
								<div class="well well-sm well-hidden" id="admin_user_group">
									<?php
									foreach($user_groups as $user_group):?>
									<?php
									if(isset($admin_user_group) && is_array($admin_user_group) && in_array($user_group['user_group_id'], $admin_user_group)):?>
									<div class="checkbox">
										<label>
											<input type="checkbox" name="admin_user_group[]" value="<?php echo $user_group['user_group_id'];?>" checked><?php echo $user_group['name']?>
										</label>
									</div>
									<?php
									else:?>
									<div class="checkbox">
										<label>
											<input type="checkbox" name="admin_user_group[]" value="<?php echo $user_group['user_group_id'];?>"><?php echo $user_group['name']?>
										</label>
									</div>
									<?php endif;?>
									<?php endforeach;?>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="login_price_displayed">
								登陆显示价格
							</label>
							<div class="col-sm-10">
								<?php
								if(isset($login_price_displayed) && $login_price_displayed == '0'):?>
								<label class="radio-inline">
									<input type="radio" name="login_price_displayed" id="login_price_displayed" value="1"> 是
								</label>
								<label class="radio-inline">
									<input type="radio" name="login_price_displayed" id="login_price_displayed" value="0" checked> 否
								</label>
								<?php
								else:?>
								<label class="radio-inline">
									<input type="radio" name="login_price_displayed" id="login_price_displayed" value="1" checked> 是
								</label>
								<label class="radio-inline">
									<input type="radio" name="login_price_displayed" id="login_price_displayed" value="0"> 否
								</label>
								<?php endif;?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="registration_terms">
								注册条款
							</label>
							<div class="col-sm-10">
								<select id="registration_terms" name="registration_terms" class="form-control">
									<?php
									if($informations):?>
									<?php
									foreach($informations as $information):?>
									<?php
									if($registration_terms == $information['information_id']):?>
									<option value="<?php echo $information['information_id']?>" selected="selected">
										<?php echo $information['title']?>
									</option>
									<?php
									else:?>
									<option value="<?php echo $information['information_id']?>">
										<?php echo $information['title']?>
									</option>
									<?php endif;?>
									<?php endforeach;?>
									<?php endif;?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="sale_terms">
								卖家条款
							</label>
							<div class="col-sm-10">
								<select id="sale_terms" name="sale_terms" class="form-control">
									<?php
									if($informations):?>
									<?php
									foreach($informations as $information):?>
									<?php
									if($sale_terms == $information['information_id']):?>
									<option value="<?php echo $information['information_id']?>" selected="selected">
										<?php echo $information['title']?>
									</option>
									<?php
									else:?>
									<option value="<?php echo $information['information_id']?>">
										<?php echo $information['title']?>
									</option>
									<?php endif;?>
									<?php endforeach;?>
									<?php endif;?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="return_terms">
								退换货条款
							</label>
							<div class="col-sm-10">
								<select id="return_terms" name="return_terms" class="form-control">
									<?php
									if($informations):?>
									<?php
									foreach($informations as $information):?>
									<?php
									if($return_terms == $information['information_id']):?>
									<option value="<?php echo $information['information_id']?>" selected="selected">
										<?php echo $information['title']?>
									</option>
									<?php
									else:?>
									<option value="<?php echo $information['information_id']?>">
										<?php echo $information['title']?>
									</option>
									<?php endif;?>
									<?php endforeach;?>
									<?php endif;?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="notify_admin">
								通知管理员
							</label>
							<div class="col-sm-10">
								<?php
								if(isset($notify_admin) && $notify_admin == '0'):?>
								<label class="radio-inline">
									<input type="radio" name="notify_admin" id="notify_admin" value="1"> 是
								</label>
								<label class="radio-inline">
									<input type="radio" name="notify_admin" id="notify_admin" value="0" checked> 否
								</label>
								<?php
								else:?>
								<label class="radio-inline">
									<input type="radio" name="notify_admin" id="notify_admin" value="1" checked> 是
								</label>
								<label class="radio-inline">
									<input type="radio" name="notify_admin" id="notify_admin" value="0"> 否
								</label>
								<?php endif;?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="verify_email">
								邮箱验证
							</label>
							<div class="col-sm-10">
								<?php
								if(isset($verify_email) && $verify_email == '0'):?>
								<label class="radio-inline">
									<input type="radio" name="verify_email" id="verify_email" value="1"> 是
								</label>
								<label class="radio-inline">
									<input type="radio" name="verify_email" id="verify_email" value="0" checked> 否
								</label>
								<?php
								else:?>
								<label class="radio-inline">
									<input type="radio" name="verify_email" id="verify_email" value="1" checked> 是
								</label>
								<label class="radio-inline">
									<input type="radio" name="verify_email" id="verify_email" value="0"> 否
								</label>
								<?php endif;?>
							</div>
						</div>
						<hr style="margin: 0 0 15px 0">
						<div class="form-group">
							<label class="col-sm-2 control-label" for="guest_checkout">
								游客结帐
							</label>
							<div class="col-sm-10">
								<?php
								if(isset($guest_checkout) && $guest_checkout == '0'):?>
								<label class="radio-inline">
									<input type="radio" name="guest_checkout" id="guest_checkout" value="1"> 是
								</label>
								<label class="radio-inline">
									<input type="radio" name="guest_checkout" id="guest_checkout" value="0" checked> 否
								</label>
								<?php
								else:?>
								<label class="radio-inline">
									<input type="radio" name="guest_checkout" id="guest_checkout" value="1" checked> 是
								</label>
								<label class="radio-inline">
									<input type="radio" name="guest_checkout" id="guest_checkout" value="0"> 否
								</label>
								<?php endif;?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="default_order_status">
								默认提交订单状态
							</label>
							<div class="col-sm-10">
								<select id="default_order_status" name="default_order_status" class="form-control">
									<?php
									if($order_statuss):?>
									<?php
									foreach($order_statuss as $k=>$v):?>
									<?php
									if(isset($default_order_status) && $default_order_status == $order_statuss[$k]['order_status_id']):?>
									<option value="<?php echo $order_statuss[$k]['order_status_id']?>" selected>
										<?php echo $order_statuss[$k]['status_name']?>
									</option>
									<?php
									else:?>
									<option value="<?php echo $order_statuss[$k]['order_status_id']?>">
										<?php echo $order_statuss[$k]['status_name']?>
									</option>
									<?php endif;?>
									<?php endforeach;?>
									<?php endif;?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="to_be_delivered">
								待发货状态
							</label>
							<div class="col-sm-10">
								<select id="to_be_delivered" name="to_be_delivered" class="form-control">
									<?php
									if($order_statuss):?>
									<?php
									foreach($order_statuss as $k=>$v):?>
									<?php
									if(isset($to_be_delivered) && $to_be_delivered == $order_statuss[$k]['order_status_id']):?>
									<option value="<?php echo $order_statuss[$k]['order_status_id']?>" selected>
										<?php echo $order_statuss[$k]['status_name']?>
									</option>
									<?php
									else:?>
									<option value="<?php echo $order_statuss[$k]['order_status_id']?>">
										<?php echo $order_statuss[$k]['status_name']?>
									</option>
									<?php endif;?>
									<?php endforeach;?>
									<?php endif;?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="inbound_state">
								待收货状态
							</label>
							<div class="col-sm-10">
								<select id="inbound_state" name="inbound_state" class="form-control">
									<?php
									if($order_statuss):?>
									<?php
									foreach($order_statuss as $k=>$v):?>
									<?php
									if(isset($inbound_state) && $inbound_state == $order_statuss[$k]['order_status_id']):?>
									<option value="<?php echo $order_statuss[$k]['order_status_id']?>" selected>
										<?php echo $order_statuss[$k]['status_name']?>
									</option>
									<?php
									else:?>
									<option value="<?php echo $order_statuss[$k]['order_status_id']?>">
										<?php echo $order_statuss[$k]['status_name']?>
									</option>
									<?php endif;?>
									<?php endforeach;?>
									<?php endif;?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="state_to_be_evaluated">
								待评价状态
							</label>
							<div class="col-sm-10">
								<select id="state_to_be_evaluated" name="state_to_be_evaluated" class="form-control">
									<?php
									if($order_statuss):?>
									<?php
									foreach($order_statuss as $k=>$v):?>
									<?php
									if(isset($state_to_be_evaluated) && $state_to_be_evaluated == $order_statuss[$k]['order_status_id']):?>
									<option value="<?php echo $order_statuss[$k]['order_status_id']?>" selected>
										<?php echo $order_statuss[$k]['status_name']?>
									</option>
									<?php
									else:?>
									<option value="<?php echo $order_statuss[$k]['order_status_id']?>">
										<?php echo $order_statuss[$k]['status_name']?>
									</option>
									<?php endif;?>
									<?php endforeach;?>
									<?php endif;?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="order_completion_status">
								交易成功状态
							</label>
							<div class="col-sm-10">
								<select id="order_completion_status" name="order_completion_status" class="form-control">
									<?php
									if($order_statuss):?>
									<?php
									foreach($order_statuss as $k=>$v):?>
									<?php
									if(isset($order_completion_status) && $order_completion_status == $order_statuss[$k]['order_status_id']):?>
									<option value="<?php echo $order_statuss[$k]['order_status_id']?>" selected>
										<?php echo $order_statuss[$k]['status_name']?>
									</option>
									<?php
									else:?>
									<option value="<?php echo $order_statuss[$k]['order_status_id']?>">
										<?php echo $order_statuss[$k]['status_name']?>
									</option>
									<?php endif;?>
									<?php endforeach;?>
									<?php endif;?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="refund_order">
								退款中订单
							</label>
							<div class="col-sm-10">
								<select id="refund_order" name="refund_order" class="form-control">
									<?php
									if($order_statuss):?>
									<?php
									foreach($order_statuss as $k=>$v):?>
									<?php
									if(isset($refund_order) && $refund_order == $order_statuss[$k]['order_status_id']):?>
									<option value="<?php echo $order_statuss[$k]['order_status_id']?>" selected>
										<?php echo $order_statuss[$k]['status_name']?>
									</option>
									<?php
									else:?>
									<option value="<?php echo $order_statuss[$k]['order_status_id']?>">
										<?php echo $order_statuss[$k]['status_name']?>
									</option>
									<?php endif;?>
									<?php endforeach;?>
									<?php endif;?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="refund_order_success">
								退款成功的订单
							</label>
							<div class="col-sm-10">
								<select id="refund_order_success" name="refund_order_success" class="form-control">
									<?php
									if($order_statuss):?>
									<?php
									foreach($order_statuss as $k=>$v):?>
									<?php
									if(isset($refund_order_success) && $refund_order_success == $order_statuss[$k]['order_status_id']):?>
									<option value="<?php echo $order_statuss[$k]['order_status_id']?>" selected>
										<?php echo $order_statuss[$k]['status_name']?>
									</option>
									<?php
									else:?>
									<option value="<?php echo $order_statuss[$k]['order_status_id']?>">
										<?php echo $order_statuss[$k]['status_name']?>
									</option>
									<?php endif;?>
									<?php endforeach;?>
									<?php endif;?>
								</select>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-2 control-label" for="order_email_alert">
								邮件提醒
							</label>
							<div class="col-sm-10">
								<?php
								if(isset($order_email_alert) && $order_email_alert == '0'):?>
								<label class="radio-inline">
									<input type="radio" name="order_email_alert" id="order_email_alert" value="1"> 是
								</label>
								<label class="radio-inline">
									<input type="radio" name="order_email_alert" id="order_email_alert" value="0" checked> 否
								</label>
								<?php
								else:?>
								<label class="radio-inline">
									<input type="radio" name="order_email_alert" id="order_email_alert" value="1" checked> 是
								</label>
								<label class="radio-inline">
									<input type="radio" name="order_email_alert" id="order_email_alert" value="0"> 否
								</label>
								<?php endif;?>
							</div>
						</div>
					</div>
					<!-- /widget-content -->
				</div>
				<!-- /widget -->
				<div class="panel panel-default">
					<div class="panel-heading row row-panel-heading bg-info">
						<p class="navbar-left">
							<i class="glyphicon glyphicon-th-list">
							</i>&nbsp;服务器设置
						</p>
						<div class="navbar-right btn-group" style="margin-right: 0">
							<button type="button" onclick="submit('form-setting')" class="btn btn-default btn-sm">
								<i class="glyphicon glyphicon-floppy-save">
								</i>
							</button>
						</div>
					</div>
					<!-- /widget-header -->
					<div class="panel-body">
						<div class="form-group">
							<label class="col-sm-2 control-label" for="upload_limit_size">
								上传限制
							</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="upload_limit_size" name="upload_limit_size" placeholder="上传文件大小限制" value="<?php echo isset($upload_limit_size) ? $upload_limit_size : '';?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="maintenance_mode">
								维护模式
							</label>
							<div class="col-sm-10">
								<?php
								if(isset($maintenance_mode) && $maintenance_mode == '1'):?>
								<label class="radio-inline">
									<input type="radio" name="maintenance_mode" id="maintenance_mode" value="1" checked> 是
								</label>
								<label class="radio-inline">
									<input type="radio" name="maintenance_mode" id="maintenance_mode" value="0"> 否
								</label>
								<?php
								else:?>
								<label class="radio-inline">
									<input type="radio" name="maintenance_mode" id="maintenance_mode" value="1"> 是
								</label>
								<label class="radio-inline">
									<input type="radio" name="maintenance_mode" id="maintenance_mode" value="0" checked> 否
								</label>
								<?php endif;?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="output_compression_level">
								输出压缩级别
							</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="output_compression_level" name="output_compression_level" placeholder="输出压缩级别" value="<?php echo isset($output_compression_level) ? $output_compression_level : '60';?>">
							</div>
						</div>
					</div>
					<!-- /widget-content -->
				</div>
				<!-- /widget -->
			</div>
			<!-- /span6 -->
			<div class="col-md-6 middle-flat-left" role="main">
				<div class="panel panel-default">
					<div class="panel-heading row row-panel-heading bg-info">
						<p class="navbar-left">
							<i class="glyphicon glyphicon-tags">
							</i>&nbsp;基础设置
						</p>
						<div class="navbar-right btn-group" style="margin-right: 0">
							<button type="button" onclick="submit('form-setting')" class="btn btn-default btn-sm">
								<i class="glyphicon glyphicon-floppy-save">
								</i>
							</button>
						</div>
					</div>
					<!-- /widget-header -->
					<div class="panel-body">
						<div class="form-group">
							<label class="col-sm-2 control-label" for="site_name">
								<span style="color:red">*</span>网站名称
							</label>
							<div class="col-sm-10">
								<?php foreach($languages as $language):?>
								<div class="input-group" style="margin-bottom: 15px">
								  <span class="input-group-addon"><img width="16px" height="11px" class="lazy" data-original="public/flags/<?php echo $language['image']?>"></span>
								  <input type="text" class="form-control" id="site_name" name="site_name[<?php echo $language['language_id'];?>]" placeholder="网站名称" value="<?php echo (isset($site_name[$language['language_id']])) ? $site_name[$language['language_id']] : '';?>">
								</div>
								<?php endforeach;?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="site_abbreviation">
								<span style="color:red">*</span>网站简称
							</label>
							<div class="col-sm-10">
								<?php foreach($languages as $language):?>
								<div class="input-group" style="margin-bottom: 15px">
								  <span class="input-group-addon"><img width="16px" height="11px" class="lazy" data-original="public/flags/<?php echo $language['image']?>"></span>
								  <input type="text" class="form-control" id="site_abbreviation" name="site_abbreviation[<?php echo $language['language_id'];?>]" placeholder="网站名称" value="<?php echo (isset($site_abbreviation[$language['language_id']])) ? $site_abbreviation[$language['language_id']] : '';?>">
								</div>
								<?php endforeach;?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="meta-keyword">meta关键词
							</label>
							<div class="col-sm-10">
								<?php foreach($languages as $language):?>
								<div class="input-group" style="margin-bottom: 15px">
								  <span class="input-group-addon"><img width="16px" height="11px" class="lazy" data-original="public/flags/<?php echo $language['image']?>"></span>
								  <input type="text" class="form-control" id="meta-keyword" name="meta_keyword[<?php echo $language['language_id'];?>]" placeholder="SEO关键词" value="<?php echo (isset($meta_keyword[$language['language_id']])) ? $meta_keyword[$language['language_id']] : '';?>">
								</div>
								<?php endforeach;?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="meta-description">meta描述
							</label>
							<div class="col-sm-10">
								<?php foreach($languages as $language):?>
								<div class="input-group" style="margin-bottom: 15px">
								  <span class="input-group-addon"><img width="16px" height="11px" class="lazy" data-original="public/flags/<?php echo $language['image']?>"></span>
								  <input type="text" class="form-control" id="meta-description" name="meta_description[<?php echo $language['language_id']?>]" placeholder="SEO描述" value="<?php echo (isset($meta_description[$language['language_id']])) ? $meta_description[$language['language_id']] : '';?>">
								</div>
								<?php endforeach;?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="login-window">
								当前窗口登陆
							</label>
							<div class="col-sm-10">
								<?php
								if(isset($login_window) && $login_window == '0'):?>
								<label class="radio-inline">
									<input type="radio" name="login_window" id="login-window" value="1"> 是
								</label>
								<label class="radio-inline">
									<input type="radio" name="login_window" id="login-window" value="0" checked> 否
								</label>
								<?php
								else:?>
								<label class="radio-inline">
									<input type="radio" name="login_window" id="login-window" value="1" checked> 是
								</label>
								<label class="radio-inline">
									<input type="radio" name="login_window" id="login-window" value="0"> 否
								</label>
								<?php endif;?>
							</div>
						</div>
					</div>
					<!-- /widget-content -->
				</div>
				<div class="panel panel-default">
					<div class="panel-heading row row-panel-heading bg-info">
						<p class="navbar-left">
							<i class="glyphicon glyphicon-bookmark">
							</i>&nbsp;本地化
						</p>
						<div class="navbar-right btn-group" style="margin-right: 0">
							<button type="button" onclick="submit('form-setting')" class="btn btn-default btn-sm">
								<i class="glyphicon glyphicon-floppy-save">
								</i>
							</button>
						</div>
					</div>
					<!-- /widget-header -->
					<div class="panel-body">
						<div class="form-group">
							<label class="col-sm-2 control-label" for="store_country_id">
								国家
							</label>
							<div class="col-sm-10">
								<select class="form-control" id="store_country_id" name="store_country_id">
									<?php
									foreach($countrys as $country):?>
									<?php
									if(isset($store_country_id) && $country['country_id'] == $store_country_id):?>
									<option value="<?php echo $country['country_id'];?>" selected>
										<?php echo $country['name'];?>
									</option>
									<?php
									else:?>
									<option value="<?php echo $country['country_id'];?>">
										<?php echo $country['name'];?>
									</option>
									<?php endif;?>
									<?php endforeach;?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="store_zone_id">
								省/市
							</label>
							<div class="col-sm-10">
								<select class="form-control" id="store_zone_id" name="store_zone_id">
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="default_language">
								默认语言
							</label>
							<div class="col-sm-10">
								<select class="form-control" id="default_language" name="default_language">
									<?php
									foreach($languages as $language):?>
									<?php
									if(isset($default_language) && $language['code'] == $default_language):?>
									<option value="<?php echo $language['code'];?>" selected>
										<?php echo $language['name'];?>
									</option>
									<?php
									else:?>
									<option value="<?php echo $language['code'];?>">
										<?php echo $language['name'];?>
									</option>
									<?php endif;?>
									<?php endforeach;?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="auto-language">自动选择语言</label>
							<div class="col-sm-10">
								<?php
								if(isset($auto_language) && $auto_language == '0'):?>
								<label class="radio-inline">
									<input type="radio" name="auto_language" id="auto-language" value="1"> 是
								</label>
								<label class="radio-inline">
									<input type="radio" name="auto_language" id="auto-language" value="0" checked> 否
								</label>
								<?php
								else:?>
								<label class="radio-inline">
									<input type="radio" name="auto_language" id="auto-language" value="1" checked> 是
								</label>
								<label class="radio-inline">
									<input type="radio" name="auto_language" id="auto-language" value="0"> 否
								</label>
								<?php endif;?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="default_currency">
								默认货币
							</label>
							<div class="col-sm-10">
								<select class="form-control" id="default_currency" name="default_currency">
									<?php
									foreach($currencys as $currency):?>
									<?php
									if(isset($default_currency) && $currency['currency_id'] == $default_currency):?>
									<option value="<?php echo $currency['currency_id'];?>" selected>
										<?php echo $currency['title'];?>
									</option>
									<?php
									else:?>
									<option value="<?php echo $currency['currency_id'];?>">
										<?php echo $currency['title'];?>
									</option>
									<?php endif;?>
									<?php endforeach;?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="default_length_class">
								长度单位
							</label>
							<div class="col-sm-10">
								<select class="form-control" id="default_length_class" name="default_length_class">
									<?php
									foreach($length_classs as $length_class):?>
									<?php
									if(isset($default_length_class) && $length_class['length_class_id'] == $default_length_class):?>
									<option value="<?php echo $length_class['length_class_id'];?>" selected>
										<?php echo $length_class['title'];?>
									</option>
									<?php
									else:?>
									<option value="<?php echo $length_class['length_class_id'];?>">
										<?php echo $length_class['title'];?>
									</option>
									<?php endif;?>
									<?php endforeach;?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="default_weight_class">
								重量单位
							</label>
							<div class="col-sm-10">
								<select class="form-control" id="default_weight_class" name="default_weight_class">
									<?php
									foreach($weight_classs as $weight_class):?>
									<?php
									if(isset($default_weight_class) && $weight_class['weight_class_id'] == $default_weight_class):?>
									<option value="<?php echo $weight_class['weight_class_id'];?>" selected>
										<?php echo $weight_class['title'];?>
									</option>
									<?php
									else:?>
									<option value="<?php echo $weight_class['weight_class_id'];?>">
										<?php echo $weight_class['title'];?>
									</option>
									<?php endif;?>
									<?php endforeach;?>
								</select>
							</div>
						</div>
						<!-- /shortcuts -->
					</div>
					<!-- /widget-content -->
				</div>
				<!-- /widget -->
				<div class="panel panel-default">
					<div class="panel-heading row row-panel-heading bg-info">
						<p class="navbar-left">
							<i class="glyphicon glyphicon-signal">
							</i>&nbsp;图片
						</p>
						<div class="navbar-right btn-group" style="margin-right: 0">
							<button type="button" onclick="submit('form-setting')" class="btn btn-default btn-sm">
								<i class="glyphicon glyphicon-floppy-save">
								</i>
							</button>
						</div>
					</div>
					<!-- /widget-header -->
					<div class="panel-body">
						<div class="form-group">
							<label class="col-sm-2 control-label" for="site_image">
								网站logo
							</label>
							<div class="col-sm-10">
								<a id="thmb_image" data-toggle="admin-image" class="img-thumbnail">
									<img width="100px" height="100px" class="lazy" data-original="<?php echo isset($site_image_thmb) ? $site_image_thmb : $placeholder_image;?>" data-placeholder="<?php echo $placeholder_image;?>" />
								</a>
								<input type="hidden" name="site_image" value="<?php echo isset($site_image) ? $site_image : '';?>" id="site_image" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="site_icon">
								icon
							</label>
							<div class="col-sm-10">
								<a id="thmb_icon" data-toggle="admin-image" class="img-thumbnail">
									<img width="100px" height="100px" class="lazy" data-original="<?php echo isset($site_icon_thmb) ? $site_icon_thmb : $placeholder_image;?>" data-placeholder="<?php echo $placeholder_image;?>" />
								</a>
								<input type="hidden" name="site_icon" value="<?php echo isset($site_icon) ? $site_icon : '';?>" id="site_icon" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="category_image_size">
								分类图片大小
							</label>
							<div class="col-sm-10 form-inline">
								<div class="form-group" style="margin: 0">
									<input type="text" class="form-control" name="category_image_size_w" id="category_image_size" placeholder="分类图片宽" value="<?php echo isset($category_image_size_w) ? $category_image_size_w : '';?>">
								</div>
								<div class="form-group" style="margin: 0">
									<input type="text" class="form-control" name="category_image_size_h" id="category_image_size" placeholder="分类图片高" value="<?php echo isset($category_image_size_h) ? $category_image_size_h : '';?>">
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="product_thumbnail_size">
								商品缩略图
							</label>
							<div class="col-sm-10 form-inline">
								<div class="form-group" style="margin: 0">
									<input type="text" class="form-control" name="product_thumbnail_size_w" id="product_thumbnail_size" placeholder="缩略图宽" value="<?php echo isset($product_thumbnail_size_w) ? $product_thumbnail_size_w : '';?>">
								</div>
								<div class="form-group" style="margin: 0">
									<input type="text" class="form-control" name="product_thumbnail_size_h" id="product_thumbnail_size" placeholder="缩略图高" value="<?php echo isset($product_thumbnail_size_h) ? $product_thumbnail_size_h : '';?>">
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="product_image_size">
								商品主图
							</label>
							<div class="col-sm-10 form-inline">
								<div class="form-group" style="margin: 0">
									<input type="text" class="form-control" name="product_image_size_w" id="product_image_size" placeholder="商品主图宽" value="<?php echo isset($product_image_size_w) ? $product_image_size_w : '';?>">
								</div>
								<div class="form-group" style="margin: 0">
									<input type="text" class="form-control" name="product_image_size_h" id="product_image_size" placeholder="商品主图高" value="<?php echo isset($product_image_size_h) ? $product_image_size_h : '';?>">
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="product_list_image_size">
								商品列表图
							</label>
							<div class="col-sm-10 form-inline">
								<div class="form-group" style="margin: 0">
									<input type="text" class="form-control" name="product_list_image_size_w" id="product_list_image_size" placeholder="商品列表图宽" value="<?php echo isset($product_list_image_size_w) ? $product_list_image_size_w : '';?>">
								</div>
								<div class="form-group" style="margin: 0">
									<input type="text" class="form-control" name="product_list_image_size_h" id="product_list_image_size" placeholder="商品列表图高" value="<?php echo isset($product_list_image_size_h) ? $product_list_image_size_h : '';?>">
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="wish_cart_image_size_s">
								收藏夹/购物车/小
							</label>
							<div class="col-sm-10 form-inline">
								<div class="form-group" style="margin: 0">
									<input type="text" class="form-control" name="wish_cart_image_size_s_w" id="wish_cart_image_size_s" placeholder="收藏夹购物车图片宽" value="<?php echo isset($wish_cart_image_size_s_w) ? $wish_cart_image_size_s_w : '';?>">
								</div>
								<div class="form-group" style="margin: 0">
									<input type="text" class="form-control" name="wish_cart_image_size_s_h" id="wish_cart_image_size_s" placeholder="购物车收藏夹图片高" value="<?php echo isset($wish_cart_image_size_s_h) ? $wish_cart_image_size_s_h : '';?>">
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="wish_cart_image_size_b">
								收藏夹/购物车/大
							</label>
							<div class="col-sm-10 form-inline">
								<div class="form-group" style="margin: 0">
									<input type="text" class="form-control" name="wish_cart_image_size_b_w" id="wish_cart_image_size_b" placeholder="收藏夹购物车图片宽" value="<?php echo isset($wish_cart_image_size_b_w) ? $wish_cart_image_size_b_w : '';?>">
								</div>
								<div class="form-group" style="margin: 0">
									<input type="text" class="form-control" name="wish_cart_image_size_b_h" id="wish_cart_image_size_b" placeholder="购物车收藏夹图片高" value="<?php echo isset($wish_cart_image_size_b_h) ? $wish_cart_image_size_b_h : '';?>">
								</div>
							</div>
						</div>
						<!-- /area-chart -->
					</div>
					<!-- /widget-content -->
				</div>
				<!-- /widget -->
				<div class="panel panel-default">
					<div class="panel-heading row row-panel-heading bg-info">
						<p class="navbar-left">
							<i class="glyphicon glyphicon-file">
							</i>&nbsp;邮箱设置
						</p>
						<div class="navbar-right btn-group" style="margin-right: 0">
							<button type="button" onclick="submit('form-setting')" class="btn btn-default btn-sm">
								<i class="glyphicon glyphicon-floppy-save">
								</i>
							</button>
						</div>
					</div>
					<!-- /widget-header -->
					<div class="panel-body">
						<div class="form-group">
							<label class="col-sm-2 control-label" for="email_protocol">
								邮件协议
							</label>
							<div class="col-sm-10">
								<select class="form-control" id="email_protocol" name="email_protocol">
									<?php
									if($email_protocol == 'mail'):?>
									<option value="mail" selected>
										MAIL
									</option>
									<option value="smtp">
										SMTP
									</option>
									<option value="sendmail">
										Sendmail
									</option>
									<?php
									elseif($email_protocol == 'sendmail'):?>
									<option value="mail">
										MAIL
									</option>
									<option value="smtp">
										SMTP
									</option>
									<option value="sendmail" selected>
										Sendmail
									</option>
									<?php
									else:?>
									<option value="mail">
										MAIL
									</option>
									<option value="smtp" selected>
										SMTP
									</option>
									<option value="sendmail">
										Sendmail
									</option>
									<?php endif;?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="email_smtp_host">
								SMTP服务器地址
							</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="email_smtp_host" name="email_smtp_host" placeholder="邮箱服务器地址" value="<?php echo isset($email_smtp_host) ? $email_smtp_host : '';?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="email_smtp_user">
								SMTP用户名
							</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="email_smtp_user" name="email_smtp_user" placeholder="发货邮箱" value="<?php echo isset($email_smtp_user) ? $email_smtp_user : '';?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="email_smtp_pass">
								SMTP密码
							</label>
							<div class="col-sm-10">
								<input type="password" class="form-control" id="email_smtp_pass" name="email_smtp_pass" placeholder="发件邮箱密码/只要输入提交就行了，目前公测，不显示value" value="<?php echo isset($email_smtp_pass) ? $email_smtp_pass : '';?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="email_smtp_port">
								SMTP端口
							</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="email_smtp_port" name="email_smtp_port" placeholder="SMTP端口" value="<?php echo isset($email_smtp_port) ? $email_smtp_port : '';?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="email_smtp_timeout">
								SMTP超时(秒)
							</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="email_smtp_timeout" name="email_smtp_timeout" placeholder="超时" value="<?php echo isset($email_smtp_timeout) ? $email_smtp_timeout : '5';?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="email_send_header">
								邮件头
							</label>
							<div class="col-sm-10">
								<textarea class="form-control" rows="3" id="email_send_header" name="email_send_header" placeholder="邮件头"><?php echo isset($email_send_header) ? $email_send_header : '';?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="email_send_footer">
								邮件尾
							</label>
							<div class="col-sm-10">
								<textarea class="form-control" rows="3" id="email_send_footer" name="email_send_footer" placeholder="邮件尾"><?php echo isset($email_send_footer) ? $email_send_footer : '';?></textarea>
							</div>
						</div>
					</div>
					<!-- /widget-content -->
				</div>
				<!-- /widget -->
			</div>
			<!-- /span6 -->
		</form>
	</div>
	<!-- /row -->
</div>
<!-- /container -->

<script>
	$('select[name=\'store_country_id\']').on('change', function()
		{
			$.ajax(
				{
					url: '<?php echo site_url();?>/localisation/country/get_country?country_id=' + this.value,
					dataType: 'json',
					beforeSend: function()
					{
						NProgress.start();
					},
					complete: function()
					{
						NProgress.done();
					},
					success: function(json)
					{
						html = '<option value="">请选择</option>';

						if (json['zone'] && json['zone'] != '')
						{
							for (i = 0; i < json['zone'].length; i++)
							{
								html += '<option value="' + json['zone'][i]['zone_id'] + '"';

								if (json['zone'][i]['zone_id'] == '<?php echo isset($store_zone_id) ? $store_zone_id : ''; ?>')
								{
									html += ' selected="selected"';
								}

								html += '>' + json['zone'][i]['name'] + '</option>';
							}
						} else
						{
							html += '<option value="0" selected="selected">--无--</option>';
						}

						$('select[name=\'store_zone_id\']').html(html);
					},
					error: function(xhr, ajaxOptions, thrownError)
					{
						alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					}
				});
		});

	$('select[name=\'store_country_id\']').trigger('change');
</script>
<?php echo $footer;//装载header?>