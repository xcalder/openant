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
	
		<div id="middle" class="<?php echo $class; ?> middle-flat-left">
			<?php echo $position_top; ?>
			<div class="panel panel-default">
				<div class="well well-sm row" style="margin-left: 0;margin-right: 0;margin-bottom: 0">
					<div class="col-sm-3">
					    <div class="media">
						  <div class="media-left">
						    <a href="#">
						      <img class="media-object img-circle lazy" data-original="<?php echo $user['image'];?>" alt="<?php echo $user['nickname'];?>" width="50px" height="50px">
						    </a>
						  </div>
						  <div class="media-body">
						    <p class="media-heading"><?php echo $user['nickname'].'('.$user['firstname'].$user['lastname'].')';?></p>
						    <p class="media-heading"><?php echo $user['nickname'].'('.$user['firstname'].$user['lastname'].')';?></p>
						  </div>
						</div>
					</div>
					<div class="col-sm-3 text-center">
						<a href="<?php echo site_url('user/address');?>">我的收货地址</a>
					</div>
					<div class="col-sm-3 text-center">
						我的优惠信息
					</div>
					<div class="col-sm-3 text-center">
						帐户余额
					</div>
				</div>
				<!-- /widget-header -->
				<div class="panel-body row">
				
					<div class="col-sm-2">侍付款</div>
					<div class="col-sm-2">待发货</div>
					<div class="col-sm-2">待收货</div>
					<div class="col-sm-2">待评价</div>
					<div class="col-sm-2">退款</div>
					<div class="col-sm-2">收藏夹</div>
					
				</div>
				<!-- /widget-content --> 
			</div>
			<!-- /widget -->
			<?php echo $position_bottom; ?>
		</div>
		<?php echo $position_right; ?>
	</div>
	<!-- /row --> 
</div>
<!-- /container -->
<?php echo $footer;//装载header?>