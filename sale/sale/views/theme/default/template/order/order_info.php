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
			<?php if(!empty($orders)):?>
				<p style="margin-bottom: 0">物流信息</p><hr style="margin: 2px 0">
				<div>快递单号：<?php echo $orders['payment_address'];?></div>
				<hr style="margin: 2px 0">
				<p style="margin-bottom: 0">商家信息</p><hr style="margin: 2px 0">
				<div class="col-sm-6">商家昵称：<?php echo $orders['u_nickname'];?></div>
				<div class="col-sm-6">真实姓名：<?php echo $orders['u_firstname'].$orders['u_lastname'];?></div>
				<div class="col-sm-6">邮箱：<?php echo $orders['u_email'];?></div>
				<div class="col-sm-6">手机号：<?php echo $orders['u_telephone'];?></div>
				<hr style="margin: 2px 0">
				
				<p style="margin-bottom: 0">订单信息</p><hr style="margin: 2px 0">
				<div>下单时间：<?php echo $orders['date_added'];?></div>
				<div>发票号码：<?php echo !empty($orders['invoice_no']) ? $orders['invoice_no'] : '无发票';?></div>
				<div>帐单地址：<?php echo $orders['payment_address'];?></div>
				<div>收货地址：<?php echo $orders['shipping_address'];?></div>
				<div>买家留言：<?php echo $orders['comment'];?></div>
				<table class="table" style="margin: 10px 0;border:1px solid rgb(217, 217, 217);">
					<thead>
						<tr>
							<td colspan="6" class="col-md-6 col-sm-6 col-xs-6 border-right">订单号：<?php echo date('YmdHis',strtotime($orders['date_added'])).'-'.$orders['order_id'];?></td>
						</tr>
						<tr>
							<td colspan="2" class="text-left col-md-4 col-sm-4 col-xs-6 border-right">商品</td>
							<td class="col-md-2 col-sm-2 hidden-xs text-center border-right">单价</td>
							<td class="col-md-2 col-sm-2 col-xs-2 text-center border-right">数量</td>
							<td class="col-md-2 col-sm-2 col-xs-2 text-center border-right">实付款</td>
							<td class="col-md-2 col-sm-2 col-xs-2 text-center border-right">交易状态</td>
						</tr>
					</thead>
					<tbody>
						<?php if($orders['products']):?>
						<tr>
							<td class="col-md-1 col-sm-1 col-xs-2 text-left border-right"><a target="_blank" href="<?php echo $this->config->item('catalog');?>/product?product_id=<?php echo $orders['products'][0]['product_id'];?>"><img width="<?php echo $this->config->get_config('wish_cart_image_size_b_w');?>px" height="<?php echo $this->config->get_config('wish_cart_image_size_b_h');?>px" class="media-object lazy" data-original="<?php echo $this->image_common->resize($orders['products'][0]['image'], $this->config->get_config('wish_cart_image_size_b_w'), $this->config->get_config('wish_cart_image_size_b_h'));?>" alt="<?php echo $orders['products'][0]['name']; ?>"></a></td>
							<td class="text-left col-md-3 col-sm-3 col-xs-4 border-right"><span><a target="_blank" href="<?php echo $this->config->item('catalog');?>/product?product_id=<?php echo $orders['products'][0]['product_id'];?>"><?php echo $orders['products'][0]['name']; ?></a></span><span class="value"><?php echo !empty($orders['products'][0]['value']) ? $orders['products'][0]['value'] : '';?></span></td>
							<td class="col-md-2 col-sm-2 hidden-xs text-center border-right"><strong style="color: red"><?php echo $this->currency->Compute($orders['products'][0]['price'] * $orders['currency_value']);?></b></strong>
							
							<?php if($orders['products'][0]['tax'] != 0):?>
							<span>含税（<?php echo $this->currency->Compute($orders['products'][0]['tax'] * $orders['currency_value']);?>）</span>
							<?php endif;?>
							</td>
							<td class="col-md-2 col-sm-2 col-xs-2 text-center border-right"><?php echo $orders['products'][0]['quantity']; ?></td>
							<td class="text-center col-md-2 col-sm-2 col-xs-2 border-right"><strong style="color: red"><?php echo $this->currency->Compute($orders['total'] * $orders['currency_value']); ?></b></strong>
							<span>含税（<?php echo $this->currency->Compute(array_sum(array_column($orders['products'], 'tax')) * $orders['currency_value']);?>）</span>
							</td>
							<td class="text-center col-md-2 col-sm-2 col-xs-2 border-right"><span><?php echo $orders['status_name']; ?></span></td>
						</tr>
						<?php unset($orders['products'][0]);?>
						<?php if(!empty($orders['products'])):?>
						<?php foreach($orders['products'] as $key=>$value):?>
						<tr>
							<td class="col-md-1 col-sm-1 col-xs-2 text-left border-right"><a target="_blank" href="<?php echo $this->config->item('catalog');?>/product?product_id=<?php echo $orders['products'][$key]['product_id'];?>"><img width="<?php echo $this->config->get_config('wish_cart_image_size_b_w');?>px" height="<?php echo $this->config->get_config('wish_cart_image_size_b_h');?>px" class="media-object lazy" data-original="<?php echo $this->image_common->resize($orders['products'][$key]['image'], $this->config->get_config('wish_cart_image_size_b_w'), $this->config->get_config('wish_cart_image_size_b_h'));?>" alt="<?php echo $orders['products'][$key]['name']; ?>"></a></td>
							<td class="text-left col-md-3 col-sm-3 col-xs-4 border-right"><span><a target="_blank" href="<?php echo $this->config->item('catalog');?>/product?product_id=<?php echo $orders['products'][$key]['product_id'];?>"><?php echo $orders['products'][$key]['name']; ?></a></span><span class="value"><?php echo !empty($orders['products'][$key]['value']) ? $orders['products'][$key]['value'] : '';?></span></td>
							<td class="col-md-2 col-sm-2 hidden-xs text-center border-right"><strong style="color: red"><?php echo $this->currency->Compute($orders['products'][$key]['price'] * $orders['currency_value']);?></b></strong>
							
							<?php if($orders['products'][$key]['tax'] != 0):?>
							<span>含税（<?php echo $this->currency->Compute($orders['products'][$key]['tax'] * $orders['currency_value']);?>）</span>
							<?php endif;?>
							</td>
							<td class="col-md-2 col-sm-2 col-xs-2 text-center border-right"><?php echo $orders['products'][$key]['quantity']; ?></td>
							<td class="col-md-2 col-sm-2 col-xs-2 border-noborder-top-right"></td>
							<td class="col-md-2 col-sm-2 col-xs-2 border-noborder-top-right"></td>
						</tr>
						<?php endforeach;?>
						<?php endif;?>
						<?php endif;?>
					</tbody>
				</table>
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