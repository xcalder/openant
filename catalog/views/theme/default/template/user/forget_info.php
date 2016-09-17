<?php echo $header;//装载header?>
<?php echo $login_top;//装载top?>
<div class="container">
	<div class="row">
		<?php echo $position_left;?>
		<?php
		if($position_left && $position_right):?>
		<?php $class = 'col-sm-6'; ?>
		<?php
		elseif($position_left || $position_right):?>
		<?php $class = 'col-sm-9'; ?>
		<?php
		else:?>
		<?php $class = 'col-sm-12'; ?>
		<?php endif;?>

		<div id="middle" class="<?php echo $class; ?>">
			<?php echo $position_top; ?>
			<div class="col-sm-12 panel panel-default middle-flat-left">
				<div class="panel-body">
					<p class="text-center login-title">
					<strong>
						找回密码
					</strong><hr style="margin: 10px 0">
					<h5>
						前往邮箱找回密码...
					</h5>
					没有收到？&nbsp;
					<a href="<?php echo site_url('user/forget');?>">
						重新发送邮件
					</a>
				</div>
			</div>
			<?php echo $position_bottom; ?>
			<?php echo $position_right; ?>
		</div>
	</div>
</div>
	<script>
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
		$(".ystep1").setStep(2);
	</script>
</div>
<style type="text/css">
	.ystep-container
	{
		margin-left: calc(50% - 115px);
	}
</style>
<?php echo $login_footer;?>