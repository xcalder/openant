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
		<div id="middle" class="<?php echo $class; ?>">
			<?php echo $position_top; ?>
			<div class="row sale-index-info">
				<div class="col-sm-3 col-xs-6">
					<div class="well well-sm">
						<p style="margin: 0"><i class="glyphicon glyphicon-th"></i>商品</p>
						<h3 class="text-center"><span class="label label-info"><?php echo $count['count_all'];?></span></h3>
						<div class="text-left">售中商品：<?php echo $count['count_status'];?></div>
						<div class="text-left">永久屏蔽：<?php echo $count['count_invalid'];?></div>
						<div class="text-left">处罚期内：<?php echo $count['count_time'];?></div>
					</div>
				</div>
				<div class="col-sm-3 col-xs-6">
					<div class="well well-sm">
						<p style="margin: 0"><i class="glyphicon glyphicon-ok"></i>待处理订单</p>
						<h3 class="text-center"><span class="label label-success"><?php echo $orders['order_all'];?></span></h3>
						<div class="text-left">待发货：<?php echo $orders['to_be_delivered'];?></div>
						<div class="text-left">待收货：<?php echo $orders['inbound_state'];?></div>
						<div class="text-left">退款中：<?php echo $orders['refund_order'];?></div>
					</div>
				</div>
				<div class="col-sm-3 col-xs-6">
					<div class="well well-sm">
						<p style="margin: 0"><i class="glyphicon glyphicon-piggy-bank"></i>交易额</p>
						<h3 class="text-center"><span class="label label-primary"><?php echo $total_all;?></span></h3>
						<div class="text-left">已到帐：<?php echo $total_success;?></div>
						<div class="text-left">未到帐：<?php echo $total_no_arrival;?></div>
						<div class="text-left">已退款：<?php echo $total_refund_order_success;?></div>
					</div>
				</div>
				<div class="col-sm-3 col-xs-6">
					<div class="well well-sm">
						<p style="margin: 0"><i class="glyphicon glyphicon-comment"></i>消息</p>
						<h3 class="text-center"><span class="label label-default"><?php echo $total_all;?></span></h3>
						<div class="text-left">盘询：<?php echo $total_success;?></div>
						<div class="text-left">系统：<?php echo $total_no_arrival;?></div>
						<div class="text-left">处罚：<?php echo $total_refund_order_success;?></div>
					</div>
				</div>
			</div>
			<?php echo $position_bottom; ?>
		</div>
		<?php echo $position_right; ?>
	</div>
	<!-- /row -->
</div>
<?php echo $footer;//装载header?>