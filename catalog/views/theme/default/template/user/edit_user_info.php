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
	<?php else:?>
	<?php $class = 'col-sm-12'; ?>
	<?php endif;?>
	
	<div id="middle" class="<?php echo $class;?>">
		<?php echo $position_top; ?>
    	
		<div class="row">
			<div class="col-sm-12 panel panel-default middle-flat-left">
				<div class="panel-body">
					<form action="<?php echo site_url('user/edit/edit_user_info');?>" method="post" enctype="multipart/form-data" id="edit-paswd-form">
						<p class="login-title"><strong>修改个人信息！</strong><hr style="margin: 10px 0">
						<div class="form-group">
							<label for="nickname">昵称</label>
							<input type="text" id="nickname" name="nickname" placeholder="姓氏" class="form-control" value="<?php echo $user_info ? $user_info['nickname'] : '';?>"/>
						</div> <!-- /field -->
						<div class="form-group">
							<label for="firstname">姓氏</label>
							<input type="text" id="firstname" name="firstname" placeholder="姓氏" class="form-control" value="<?php echo $user_info ? $user_info['firstname'] : '';?>"/>
						</div> <!-- /field -->
						<div class="form-group">
							<label for="lastname">名字</label>
							<input type="text" id="lastname" name="lastname" placeholder="名字" class="form-control" value="<?php echo $user_info ? $user_info['lastname'] : '';?>"/>
						</div> <!-- /field -->
						<div class="form-group">
							<label for="gender">性别</label><br/>
							<label class="radio-inline">
								<input type="radio" name="gender" id="gender" value="男" <?php echo ($user_info && $user_info['gender'] == '男') ? 'checked' : '';?>>男
							</label>
							<label class="radio-inline">
								<input type="radio" name="gender" id="gender" value="女" <?php echo ($user_info && $user_info['gender'] == '女') ? 'checked' : '';?>>女
							</label>
							<label class="radio-inline">
								<input type="radio" name="gender" id="gender" value="其它" <?php echo ($user_info && $user_info['gender'] != '男' && $user_info['gender'] != '女') ? 'checked' : '';?>>其它
							</label>
						</div> <!-- /field -->
						<hr>
						<div class="form-group">
							<label for="telephone">手机</label>
							<input type="text" id="telephone" name="telephone" placeholder="手机" class="form-control" value="<?php echo $user_info ? $user_info['telephone'] : '';?>"/>
						</div> <!-- /field -->
						<div class="form-group">
							<label for="email">邮箱</label>
							<div class="input-group">
								<input type="text" id="email" name="email" placeholder="邮箱" class="form-control" value="<?php echo $user_info ? $user_info['email'] : '';?>"/>
								<span class="input-group-btn">
									<button class="btn btn-default email" type="button" onclick="sender_email();">获取验证码</button>
								</span>
							</div><!-- /input-group -->
						</div>
						<div class="form-group">
							<label for="email_captcha">验证码</label>
							<input type="text" id="email_captcha" name="email_captcha" placeholder="请登陆邮箱查看6位数验证码" class="form-control" value="" disabled="disabled"/>
						</div> <!-- /field -->
						<hr>
						<div class="form-group">
							<label for="description">个人简介</label>
							<textarea rows="3" cols="20" id="description" name="description" placeholder="个人简介（最多255个字符）" class="form-control"><?php echo $user_info ? $user_info['description'] : '';?></textarea>
						</div> <!-- /field -->
							
						<div class="form-group">
							<button type="submit" class="btn btn-info btn-block" onclick="$('#email_captcha').removeAttr('disabled').trigger('blur');$('#email').removeAttr('disabled');">提交</button>
						</div> <!-- .actions -->
					</form>
				</div>
			</div>
		</div>
		<?php echo $position_bottom; ?>
		<?php echo $position_right; ?>
	</div>
	<script>
		//验证表单
		$(document).ready(function(){
			$("#edit-paswd-form").validate({
					rules:{
						firstname: {
							required: true
						},
						lastname: {
							required: true
						},
						telephone: {
							required: true,
						},
						email_captcha: {
							required: true,
							rangelength:[6,6],
							remote: "user/edit/verify_email_captcha.html"
						}
					},
					messages:{
						firstname: {
							required: "姓氏不能为空"
						},
						lastname: {
							required: "名字不能为空"
						},
						telephone: {
							required: "手机号码不正确"
						},
						email_captcha: {
							required: "验证码不正确",
							rangelength:"验证码是6位数",
							remote: "验证码不正确"
						}
					}
				});
			});
		
		function sender_email()
		{
			var email=$('input[name=\'email\']').val();
			var re = /^(\w-*\.*)+@(\w-?)+(\.\w{2,})+$/;
			if(re.test(email)){
				$('label[for=\'email\']').text('邮箱').removeAttr("style");
				//邮箱格式正确
				$.ajax(
					{
						url: '<?php echo site_url();?>user/edit/sender_email_check.html',
						type: 'post',
						dataType: 'json',
						data: {email:email},
						beforeSend: function()
						{
							NProgress.start();
						},
						complete: function()
						{
							NProgress.done();
						},
						success: function(data)
						{
							if(data.status == '1'){
								$('button.email').text(data.message).removeAttr("onclick");
								$('#email').attr("disabled", "disabled");
								$('#email_captcha').removeAttr("disabled");
							}else{
								$('button.email').text(data.message);
							}
						
						},
						error: function(xhr, ajaxOptions, thrownError)
						{
							alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
						}
					});
			}else{
				$('label[for=\'email\']').text('邮箱（邮箱格式不正确）').attr("style","color:red");
			}
		}
	</script>
</div>
<!-- /container -->
<?php echo $footer;//装载header?>