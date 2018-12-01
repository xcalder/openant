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
			<?php if($returns):?>
				<?php echo $pagination;?>
				<table class="table" style="margin: 10px 0;border:1px solid rgb(217, 217, 217);">
					<thead>
						<tr>
							<td colspan="2" class="text-left col-md-4 col-sm-4 col-xs-6 border-right">商品</td>
							<td class="col-md-2 col-sm-2 hidden-xs text-center border-right">单价</td>
							<td class="col-md-2 col-sm-2 col-xs-2 text-center border-right">数量</td>
							<td class="col-md-2 col-sm-2 col-xs-2 text-center border-right">退款金额</td>
							<td class="col-md-2 col-sm-2 col-xs-2 text-center border-right">退换货状态</td>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($returns as $return):?>
						<tr>
							<td class="col-md-1 col-sm-1 col-xs-2 text-left border-right"><img width="<?php echo $this->config->get_config('wish_cart_image_size_b_w');?>px" height="<?php echo $this->config->get_config('wish_cart_image_size_b_h');?>px" class="media-object lazy" data-original="<?php echo $this->image_common->resize($return['image'], $this->config->get_config('wish_cart_image_size_b_w'), $this->config->get_config('wish_cart_image_size_b_h'));?>" alt="<?php echo $return['name']; ?>"></td>
							<td class="text-left col-md-3 col-sm-3 col-xs-4 border-right"><span><?php echo $return['name']; ?></span><span class="value"><?php echo !empty($return['option']) ? $return['option'] : '';?></span></td>
							<td class="col-md-2 col-sm-2 hidden-xs text-center border-right"><strong style="color: red"><?php echo $this->currency->Compute($return['price'] * $return['currency_value']);?></b></strong></td>
							<td class="col-md-2 col-sm-2 col-xs-2 text-center border-right"><?php echo $return['quantity']; ?></td>
							<td class="text-center col-md-2 col-sm-2 col-xs-2 border-right"><strong style="color: red"><?php echo $this->currency->Compute($return['return_amount']  * $return['currency_value']); ?></b></strong></td>
							<td class="text-center col-md-2 col-sm-2 col-xs-2 border-right"><span><?php echo $return['status_name']; ?></span><br/><span><?php echo $return['return_action']; ?></span><br/><a target="_blank" href="<?php echo $this->config->item('catalog').'/user/returned/info?rowid='.$return['rowid'];?>">查看退换详情</a></td>
						</tr>
						<?php endforeach;?>
					</tbody>
				</table>
				<?php echo $pagination;?>
			<?php else:?>
			<div class="well well-sm text-center">
				还没有订单？马上撸一发吧！
			</div>
			<?php endif;?>
			<?php echo $position_bottom; ?>
		</div>
		<?php echo $position_right; ?>
	</div>
	<!-- /row -->
	
</div>
<!-- /container -->
<?php echo $footer;//装载header?>