<?php echo $header;//装载header?>
<?php echo $top;//装载top?>
<!-- /subnavbar -->
<div class="container">
	<div class="row"><?php echo $position_left;?>
		<?php if($position_left && $position_right):?>
		<?php $class = 'col-sm-6'; ?>
		<?php $point_col='';?>
		<?php elseif($position_left || $position_right):?>
		<?php $class = 'col-sm-9'; ?>
		<?php $point_col='<div class="col-sm-3"></div>';?>
		<?php else:?>
		<?php $class = 'col-sm-12'; ?>
		<?php $point_col='<div class="col-sm-3"></div>';?>
		<?php endif;?>
	
		<?php echo ($position_right || (!$position_left && !$position_right)) ? $point_col : '';?>
		<div id="middle" class="col-sm-6">
			<?php echo $position_top; ?>
    	
			<div class="row">
				<div class="col-sm-12 panel panel-default middle-flat-left">
					<div class="panel-body">
						<form action="<?php echo site_url('user/edit/edit_pay_password');?>" method="post" enctype="multipart/form-data" id="edit-pay_password-form">
							<p class="text-center login-title"><strong>修改支付密码</strong><hr style="margin: 10px 0">
							<div class="form-group">
								<input type="password" id="current_password" name="current_password" placeholder="登陆密码" class="form-control" value=""/>
							</div> <!-- /field -->
							<div class="form-group">
								<input type="password" id="new_password" name="new_password" placeholder="支付密码" class="form-control" value=""/>
							</div> <!-- /field -->
							<div class="form-group">
								<input type="password" id="confirm_password" name="confirm_password" placeholder="确认支付密码" class="form-control" value=""/>
							</div> <!-- /field -->
							<div class="form-group form-captcha">
								<input type="text" id="captcha" name="captcha" placeholder="验证码" class="form-control" value=""/>
								<img title="点击刷新" src="index.php/common/captcha" align="absbottom" onclick="this.src='index.php/common/captcha?'+Math.random();"></img>
					
							</div> <!-- /field -->
				
							<div class="form-group">
								<button type="submit" class="btn btn-info btn-block">提交</button>
							</div> <!-- .actions -->
						</form>
					</div>
				</div>
			</div>
			<?php echo $position_bottom; ?>
		</div><?php echo ($position_left || (!$position_left && !$position_right)) ? $point_col : '';?>
		<?php echo $position_right; ?>
	</div>
	<script>
		//验证表单
		$(document).ready(function(){
				$("#edit-pay_password-form").validate({
						rules:{
							current_password: {
								required: true,
								rangelength: [6,18],
								remote: "user/edit/verify_current_password.html"
							},
							new_password: {
								required: true,
								rangelength: [6,18],
							},
							confirm_password: {
								required: true,
								rangelength: [6,18],
								equalTo:"#new_password"
							},
							captcha: {
								required: true,
								rangelength:[4,4],
								remote: "common/captcha/veri.html"
							}
						},
						messages:{
							current_password: {
								required: "登陆密码不能为空",
								rangelength: "密码6——18位",
								remote: "当前密码不正确"
							},
							new_password: {
								required: "请输入新支付密码",
								rangelength: "新密码6——18位"
							},
							confirm_password: {
								required: "请确认支付密码",
								rangelength: "密码6——18位",
								equalTo:"密码输入不一至"
							},
							captcha: {
								required: "验证码不能为空",
								rangelength:"验证码4个字符",
								remote: "验证码不正确！"
							},
						}
					});
			});
	</script>
</div>
<!-- /container -->
<?php echo $footer;//装载header?>