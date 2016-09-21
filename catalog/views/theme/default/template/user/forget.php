<?php echo $header;//装载header?>
<?php echo $login_top;//装载top?>
<div class="container">
	<div class="row">
		<div id="middle" class="col-sm-12">
			<?php echo $position_top; ?>
	    	<div class="col-sm-9 hidden-xs hidden-sm" style="padding-left:0"><?php echo $position_bottom; ?></div>
				<?php echo $position_left;?>
				<div class="col-sm-3 panel panel-default middle-flat-left">
					<div class="panel-body">
						<form action="<?php echo site_url('user/forget');?>" method="post" enctype="multipart/form-data" id="forget-form">
							<p class="text-center login-title"><strong>找回密码</strong><hr style="margin: 10px 0">
							<p>通过注册邮箱找回密码</p>
							<div class="form-group">
								<input type="text" id="email" name="email" placeholder="Email" class="form-control" value=""/>
							</div> <!-- /field -->
							<div class="form-group form-captcha">
								<input type="text" id="captcha" name="captcha" placeholder="验证码" class="form-control" value=""/>
								<img title="点击刷新" src="common/captcha" align="absbottom" onclick="this.src='common/captcha?'+Math.random();"></img>
						
							</div> <!-- /field -->
					
							<div class="form-group">
								<button type="submit" class="btn btn-danger btn-block">提交</button>
							</div> <!-- .actions -->
						</form>
					</div>
				</div>
				<?php echo $position_right; ?>
			</div>
	</div>
</div>

<?php if(isset($error_times)):?><script type="text/javascript">$(document).ready(function () {$.notify({message: '<?php echo $error_times;?>' },{type: 'danger'});});</script><?php endif;?>
<?php if(isset($message)):?><script type="text/javascript">$(document).ready(function () {$.notify({message: '<?php echo $message;?>' },{type: 'message'});});</script><?php endif;?>
<?php if(isset($error_check)):?><script type="text/javascript">$(document).ready(function () {$.notify({message: '<?php echo $error_check;?>' },{type: 'warning'});});</script><?php endif;?>
<?php if(isset($_SESSION['warning'])):?><script type="text/javascript">$(document).ready(function () {$.notify({message: '<?php echo $_SESSION['warning'];?>' },{type: 'warning'});});</script><?php endif;?>

<?php echo $login_footer;?>
<script>
	//验证找回密码
	$(document).ready(function(){
			$("#forget-form").validate({
					rules: {
						email: {
							required: true,
							email: true
						},
						captcha: {
							required: true,
							rangelength:[4,4],
							remote: "common/captcha/veri.html"
						}
					},
					messages: {
						email: {
							required: "请输入Email！",
							email: "Email格式不正确！"
						},
						captcha: {
							required: "请输入验证码",
							rangelength: "验证码4字符",
							remote: "你确定这是你看到的验证码？"
						}
					}
				});
		});

	$(".ystep1").loadStep({
			//ystep的外观大小
			//可选值：small,large
			size: "small",
			//ystep配色方案
			//可选值：green,blue
			color: "green",
			//ystep中包含的步骤
			steps: [{
					//步骤名称
					title: "发送",
					//步骤内容(鼠标移动到本步骤节点时，会提示该内容)
					content: "验证注册邮箱，并通过提示完成密码重置！"
				},{
					title: "验证",
					content: "邮件已经发送成功，等待验证！"
				},{
					title: "重置",
					content: "重置你的登陆密码！"
				}]
		});
	$(".ystep1").setStep(1);
</script>
<style type="text/css">
	.ystep-container{
		margin-left: calc(50% - 115px);
	}
</style>