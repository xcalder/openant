<?php echo $header;//装载header?>
<?php echo $top;//装载top?>
<!-- /subnavbar -->
<div class="container">
	<div class="row"><?php echo $position_left;?>
  
		<?php if($position_left && $position_right):?>
		<?php $class = 'col-sm-6'; ?>
		<?php elseif($position_left || $position_right):?>
		<?php $class = 'col-sm-9'; ?>
		<?php else:?>
		<?php $class = 'col-sm-12'; ?>
		<?php endif;?>
	
		<div id="middle" class="<?php echo $class; ?> middle-flat-left user-order-list">
			<?php echo $position_top; ?>
			
			<?php if(isset($_SESSION['result'])):?>
			<div class="well well-lg">
				<?php if($_SESSION['result']['status'] == TRUE):?>
				<h1 style="text-align: center"><i class="glyphicon glyphicon-ok"></i></h1>
				<h4 style="text-align: center"><?php echo $_SESSION['result']['msg'].'付款总金额:'.$this->currency->Compute($_SESSION['result']['money']).',订单号:'.$_SESSION['result']['order_ids'];?></h4>
				<?php else:?>
				<h1 style="text-align: center"><i class="glyphicon glyphicon-remove"></i></h1>
				<h4 style="text-align: center"><?php echo $_SESSION['result']['msg'];?></h4>
				<?php endif;?>
			</div>
			<?php else:?>
				<h1 style="text-align: center"><i class="glyphicon glyphicon-remove"></i></h1>
				<h4 style="text-align: center">付款不成功，没有需要付款的订单！</h4>
			<?php endif;?>
			
			<?php echo $position_bottom; ?>
		</div>
		<?php echo $position_right; ?>
	</div>
	<!-- /row -->
	<script>
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
						title: "添加",
						//步骤内容(鼠标移动到本步骤节点时，会提示该内容)
						content: "验证注册邮箱，并通过提示完成密码重置！"
					},{
						title: "确认",
						content: "邮件已经发送成功，等待验证！"
					},{
						title: "购买",
						content: "重置你的登陆密码！"
					},{
						title: "结帐",
						content: "重置你的登陆密码！"
					},{
						title: "收货",
						content: "重置你的登陆密码！"
					},{
						title: "评价",
						content: "重置你的登陆密码！"
					},{
						title: "成功",
						content: "重置你的登陆密码！"
					}]
			});
		$(".ystep1").setStep(4);
	</script>
	<style type="text/css">
		.ystep-container{
			margin-left: calc(50% - 180px);
		}
	</style>
</div>
<!-- /container -->
<?php echo $footer;//装载header?>