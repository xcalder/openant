<?php echo $header;//装载header?>
<?php echo $login_top;//装载top?>
<div class="container">
	<div class="row">
		<div id="middle" class="col-sm-12">
			<?php echo $position_top; ?>
	    	<div class="col-sm-9 hidden-xs hidden-sm" style="padding-left:0"><?php echo $position_bottom; ?></div>
				<?php echo $position_left;?>
			<div class="col-sm-3 panel panel-default">
				<div class="panel-body">
					<form action="<?php echo $action;?>" method="post" enctype="multipart/form-data" id="forget-edit">
						<p class="text-center login-title">
						<strong>
							找回密码
						</strong><hr style="margin: 10px 0">
						<p>
							重置你的密码！
						</p>
						<div class="form-group" style="position: relative;">
							<input type="password" id="password" name="password" value="" placeholder="密码" class="form-control"/>
						</div> <!-- /password -->
						<div class="form-group" style="position: relative;">
							<input type="password" id="confirm_password" name="confirm_password" value="" placeholder="确认密码" class="form-control"/>
						</div> <!-- /field -->
						<div class="form-group form-captcha" style="position: relative;">
							<input type="text" id="captcha" name="captcha" value="" placeholder="验证码" class="form-control" />
							<img title="点击刷新" src="index.php/common/captcha" align="absbottom" onclick="this.src='index.php/common/captcha?'+Math.random();">
							</img>
						</div> <!-- /field -->
						<div class="form-group" style="position: relative;">
							<button type="submit" class="btn btn-success btn-block">
								提交
							</button>
						</div> <!-- .actions -->
					</form>
				</div>
			</div>
			<?php echo $position_right; ?>
		</div>
	</div>
</div>
<?php echo $login_footer;?>
<script>
	//修改密码
	$().ready(function()
		{
			$("#forget-edit").validate(
				{
					rules:
					{
						password:
						{
							required: true,
							rangelength: [6,18],
						},
						confirm_password:
						{
							required: true,
							equalTo: "#password",
						},
						captcha:
						{
							required: true,
							rangelength:[4,4],
							remote: "common/captcha/veri.html"
						}
					},
					messages:
					{
						password:
						{
							required: "请输入密码",
							rangelength: "密码6-18字符之间"
						},
						confirm_password:
						{
							required: "请确认密码",
							equalTo: "密码不一致！"
						},
						captcha:
						{
							required: "请输入验证码",
							rangelength: "验证码4字符",
							remote: "你确定这是你看到的验证码？"
						}
					}
				});
		});

	$(".ystep1").loadStep(
		{
			//ystep的外观大小
			//可选值：small,large
			size: "small",
			//ystep配色方案
			//可选值：green,blue
			color: "green",
			//ystep中包含的步骤
			steps: [
				{
					//步骤名称
					title: "发送",
					//步骤内容(鼠标移动到本步骤节点时，会提示该内容)
					content: "验证注册邮箱，并通过提示完成密码重置！"
				},
				{
					title: "验证",
					content: "邮件已经发送成功，等待验证！"
				},
				{
					title: "重置",
					content: "重置你的登陆密码！"
				}]
		});
	$(".ystep1").setStep(3);
</script>
<style type="text/css">
	.ystep-container
	{
		margin-left: calc(50% - 115px);
	}
</style>