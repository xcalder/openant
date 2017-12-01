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
			<div class="panel panel-default user-notice">
				<div class="well well-sm row" style="margin-left: 0;margin-right: 0;margin-bottom: 0">
					<div class="col-sm-3 col-xs-3">
						<div class="media">
							<div class="media-left media-middle">
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
					<div class="col-sm-3 col-xs-3">
						<a href="<?php echo $this->config->item('catalog').'user/address';?>" style="line-height: 55px">我的收货地址</a>
					</div>
					<div class="col-sm-3 col-xs-3" style="line-height: 55px">
						我的优惠信息
					</div>
					<div class="col-sm-3 col-xs-3" style="line-height: 55px">
						<a href="user/detailed_list">余额&nbsp;<span class="badge"><?php echo $this->currency->Compute($balances);?></span></a>
					</div>
				</div>
				<!-- /widget-header -->
				<hr style="margin: 5px">
				<div class="panel-body">
				
					<div class="col-sm-2 col-xs-2"><a href="user/orders?page=0&order_status=<?php echo $this->config->get_config('default_order_status');?>">侍付款<?php echo isset($count_default_order) ? '<span class="badge">'.$count_default_order.'</span>' : '';?></a></div>
					<div class="col-sm-2 col-xs-2"><a href="user/orders?page=0&order_status=<?php echo $this->config->get_config('to_be_delivered');?>">侍发货<?php echo isset($count_to_be_delivered) ? '<span class="badge">'.$count_to_be_delivered.'</span>' : '';?></a></div>
					<div class="col-sm-2 col-xs-2"><a href="user/orders?page=0&order_status=<?php echo $this->config->get_config('inbound_state');?>">侍收货<?php echo isset($count_inbound_state) ? '<span class="badge">'.$count_inbound_state.'</span>' : '';?></a></div>
					<div class="col-sm-2 col-xs-2"><a href="user/orders?page=0&order_status=<?php echo $this->config->get_config('state_to_be_evaluated');?>">侍评价<?php echo isset($count_to_be_evaluated) ? '<span class="badge">'.$count_to_be_evaluated.'</span>' : '';?></a></div>
					<div class="col-sm-2 col-xs-2"><a href="user/orders?page=0&order_status=<?php echo $this->config->get_config('refund_order');?>">退款中<?php echo isset($count_refund_order) ? '<span class="badge">'.$count_refund_order.'</span>' : '';?></a></div>
					<div class="col-sm-2 col-xs-2"><a href="<?php echo $this->config->item('catalog').'user/wishlist';?>">收藏夹<span class="badge"><?php echo $wishlist_count;?></span></a></div>
					
				</div>
				<!-- /widget-content --> 
			</div>
			
			<div id="order">
				<?php if(!empty($orders)):?>
				<table class="table table-bordered table-hover user-wecome">
					<thead>
						<tr>
							<td colspan="2" class="text-center col-sm-4 col-md-4">商品</td>
							<td class="text-center col-sm-2 col-md-2">数量</td>
							<td class="text-center col-md-2 hidden-xs">实付款</td>
							<td class="text-center col-sm-3 col-md-2">交易状态</td>
							<td class="text-center col-sm-3 col-md-2">操作</td>
						</tr>
					</thead>
					<tbody>
					<?php echo $pagination;?>
				
					<?php foreach($orders as $order):?>
					<?php if($order['products'] && !empty($order['products'])):?>
					<tr style="background-color: #f5f5f5">
						<td colspan="3" style="border-right-width: 0;">订单号：<?php echo date('YmdHis',strtotime($order['date_added'])).'-'.$order['order_id'];?></td>
						<td colspan="2" class="text-right" style="border-left-width: 0;border-right-width: 0"><img width="18px" height="18px" class="lazy" data-original="<?php echo $this->image_common->resize($order['logo'], 18, 18);?>" alt="<?php echo $order['store_name']; ?>"><?php echo $order['store_name'];?></td>
						<td style="border-left-width: 0;"></td>
					</tr>
					
					<tr>
						<td class="text-left col-sm-2 col-md-2"><a target="_blank" href="product?product_id=<?php echo $order['products'][0]['product_id'];?>"><img width="<?php echo $this->config->get_config('wish_cart_image_size_b_w');?>px" height="<?php echo $this->config->get_config('wish_cart_image_size_b_h');?>px" class="media-object lazy" data-original="<?php echo $this->image_common->resize($order['products'][0]['image'], $this->config->get_config('wish_cart_image_size_b_w'), $this->config->get_config('wish_cart_image_size_b_h'));?>" alt="<?php echo $order['products'][0]['name']; ?>"></a></td>
						<td class="text-left col-sm-2 col-md-2"><span><a target="_blank" href="product?product_id=<?php echo $order['products'][0]['product_id'];?>"><?php echo utf8_substr($order['products'][0]['name'], 0, 15); ?></a></span><br/><span class="value"><?php echo !empty($order['products'][0]['value']) ? utf8_substr($order['products'][0]['value'], 0, 15) : '';?></span></td>
						<td class="text-center col-sm-1 col-md-2"><?php echo $order['products'][0]['quantity']; ?></td>
						<td class="text-center col-md-2 hidden-xs" style="border-top-width: 0;border-bottom-width: 0"><strong style="color: red"><?php echo $this->currency->Compute($order['total'] * $order['currency_value']);?></b></strong>
							<div>含税（<?php echo $this->currency->Compute(array_sum(array_column($order['products'], 'tax')) * $order['currency_value']);?>）</div>
						</td>
						<td class="text-center col-sm-3 col-md-2" style="border-top-width: 0;border-bottom-width: 0"><?php echo $order['status_name']; ?><div><a href="<?php echo $this->config->item('catalog').'user/orders/order_info?order_id='.$order['order_id'];?>">订单详情</a></div></td>
						<td class="text-center col-sm-3 col-md-2" style="border-top-width: 0;border-bottom-width: 0"><button type="button" class="btn btn-default">确认收货</button></td>
					</tr>
					<?php unset($order['products'][0]);?>
					<?php if(!empty($order['products'])):?>
					<?php foreach($order['products'] as $key=>$value):?>
					<tr>
						<td class="text-left"><a target="_blank" href="product?product_id=<?php echo $order['products'][$key]['product_id'];?>"><img width="<?php echo $this->config->get_config('wish_cart_image_size_b_w');?>px" height="<?php echo $this->config->get_config('wish_cart_image_size_b_h');?>px" class="media-object lazy" data-original="<?php echo $this->image_common->resize($order['products'][$key]['image'], $this->config->get_config('wish_cart_image_size_b_w'), $this->config->get_config('wish_cart_image_size_b_h'));?>" alt="<?php echo $order['products'][$key]['name']; ?>"></a></td>
						<td class="text-left"><span><a target="_blank" href="product?product_id=<?php echo $order['products'][$key]['product_id'];?>"><?php echo utf8_substr($order['products'][$key]['name'], 0, 15); ?></a></span><br/><span class="value"><?php echo !empty($order['products'][$key]['value']) ? utf8_substr($order['products'][$key]['value'], 0, 15) : '';?></span></td>
						<td class="width-ten text-center"><?php echo $order['products'][$key]['quantity']; ?></td>
						<td style="border-top-width: 0;border-bottom-width: 0"></td>
						<td style="border-top-width: 0;border-bottom-width: 0"></td>
						<td style="border-top-width: 0;border-bottom-width: 0"></td>
					</tr>
					<?php endforeach;?>
					<?php endif;?>
					<?php endif;?>
					<?php endforeach;?>
				</table>
				<?php else:?>
				<div class="well well-sm text-center">
					还没有订单？马上撸一发吧！
				</div>
				<?php endif;?>
				<?php echo $pagination;?>
			</div>
			<!-- /widget -->
			<?php echo $position_bottom; ?>
		</div>
		<?php echo $position_right; ?>
	</div>
	<!-- /row --> 
	<script>
		$('#order .pagination li a').click(function(e){
				e.preventDefault(e);
				$.ajax(
					{
						url: $(this).attr("href"),
						type: 'get',
						dataType: 'html',
						data: '',
						beforeSend: function()
						{
							NProgress.start();
						},
						complete: function()
						{
							NProgress.done();
						},
						success: function(html)
						{
							if(html)
							{
								$('#order').html(html);
								lazy_load();
							}
						}
					});
			});
	</script>
</div>
<!-- /container -->
<?php echo $footer;//装载header?>