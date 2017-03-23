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
				<?php echo $pagination;?>
				<table class="table" style="margin-bottom: 20px;border:1px solid rgb(222, 222, 222);" id="table-orders-product">
					<thead>
						<tr>
							<td class="col-md-1 col-sm-1 col-xs-2 text-left border-right"><input type="checkbox" class="checkall" onclick="$('input[class*=\'select\']').prop('checked', this.checked);"/>&nbsp;全选</td>
							<td class="text-left col-md-3 col-sm-3 col-xs-4 border-right">商品</td>
							<td class="col-md-1 col-sm-1 hidden-xs text-center border-right">单价</td>
							<td class="col-md-1 col-sm-1 hidden-xs text-center border-right">数量</td>
							<td class="col-md-1 col-sm-1 hidden-xs text-center border-right">操作</td>
							<td class="col-md-2 col-sm-2 col-xs-2 text-center border-right">实付款</td>
							<td class="col-md-1 col-sm-1 col-xs-2 text-center border-right">交易状态</td>
							<td class="col-md-2 col-sm-2 col-xs-2 text-center">交易操作</td>
						</tr>
					</thead>
					<tbody class="table-hover">
					<?php foreach($orders as $order):?>
					<?php if($order['order_status_id'] == $this->config->get_config('refund_order') || $order['order_status_id'] == $this->config->get_config('refund_order_success')){
						$style_bg='style="background-color: #eee;"';
					}elseif($order['order_status_id'] != $this->config->get_config('order_completion_status')){
						$style_bg='style="background-color: #d9edf7;"';
					}else{
						$style_bg='style="background-color: #f8f8f8;"';
					}
					?>
					
					<?php if(isset($order['products']) && $order['products'] && !empty($order['products'])):?>
					<tr <?php echo $style_bg;?>>
						<td colspan="2" class="border-right text-left"><input class="select" type="checkbox" /><?php echo date('Y-m-d',strtotime($order['date_added']));?></td>
						<td colspan="3" class="border-right">订单号：<?php echo date('YmdHis',strtotime($order['date_added'])).'-'.$order['order_id'];?></td>
						<td colspan="2" class="hidden-xs border-right"><img width="18px" height="18px" class="lazy" data-original="<?php echo $this->image_common->resize($order['logo'], 18, 18);?>" alt="<?php echo $order['store_name']; ?>"><?php echo $order['store_name'];?></td>
						<td class="text-right hidden-xs border-right"><button type="button" class="btn btn-default btn-xs" data-toggle="tooltip" data-placement="top" title="删除订单" onclick="del_order('<?php echo $order['order_id'];?>');"><i class="text-warning glyphicon glyphicon-remove"></i></button></td>
					</tr>
					
					<tr>
						<td class="col-md-1 col-sm-1 col-xs-2 text-left border-right" style="vertical-align: middle"><a target="_blank" href="<?php echo $this->config->item('catalog').'product?product_id='.$order['products'][0]['product_id'];?>"><img width="<?php echo $this->config->get_config('wish_cart_image_size_b_w');?>px" height="<?php echo $this->config->get_config('wish_cart_image_size_b_h');?>px" class="media-object lazy" data-original="<?php echo $this->image_common->resize($order['products'][0]['image'], $this->config->get_config('wish_cart_image_size_b_w'), $this->config->get_config('wish_cart_image_size_b_h'));?>" alt="<?php echo $order['products'][0]['name']; ?>"></a></td>
						<td class="text-left col-md-3 col-sm-3 col-xs-4 border-right"><span><a target="_blank" href="<?php echo $this->config->item('catalog').'product?product_id='.$order['products'][0]['product_id'];?>"><?php echo $order['products'][0]['name']; ?></a></span><span class="value"><?php echo !empty($order['products'][0]['value']) ? $order['products'][0]['value'] : '';?></span></td>
						<td class="col-md-1 col-sm-1 hidden-xs text-center border-right"><strong style="color: red"><?php echo $this->currency->Compute($order['products'][0]['price'] * $order['currency_value']);?></b></strong>
						
						<?php if($order['products'][0]['tax'] != 0):?>
						<span>含税（<?php echo $this->currency->Compute($order['products'][0]['tax'] * $order['currency_value']);?>）</span>
						<?php endif;?>
						</td>
						<td class="col-md-1 col-sm-1 hidden-xs text-center border-right"><?php echo $order['products'][0]['quantity']; ?></td>
						<td class="text-center col-md-1 col-sm-1 hidden-xs border-right">
							<?php if(isset($order['products'][0]['return'])):?>
							<a style="color: orange" target="_blank" href="<?php echo $this->config->item('catalog').'user/returned/info?rowid='.$order['products'][0]['rowid'];?>"><?php echo $order['products'][0]['return'];?></a><br/>
							<?php elseif($order['order_status_id'] != $this->config->get_config('default_order_status')):?>
							<a target="_blank" href="<?php echo $this->config->item('catalog').'user/returned?token='.$_SESSION['token'].'&rowid='.$order['products'][0]['rowid'];?>">退款/退货</a><br/>
							<?php endif;?>
							投诉商家
						</td>
						<td class="text-center col-md-2 col-sm-2 col-xs-2 border-right"><strong style="color: red"><?php echo $this->currency->Compute($order['total'] * $order['currency_value']); ?></b></strong>
						<span>含税（<?php echo $this->currency->Compute(array_sum(array_column($order['products'], 'tax')) * $order['currency_value']);?>）</span>
						</td>
						<td class="text-center col-md-1 col-sm-1 col-xs-2 border-right"><span><?php echo $order['status_name']; ?></span><a target="_blank" href="<?php echo $this->config->item('catalog').'user/orders/order_info?order_id='.$order['order_id'];?>">订单详情</a></td>
						<td class="text-center col-md-2 col-sm-2 col-xs-2">
							<?php if($order['order_status_id'] == $this->config->get_config('default_order_status')):?>
							<a target="_blank" href="<?php echo $this->config->item('catalog').'user/confirm/payment?order_ids='.$_SESSION['token'].','.$order['order_id'];?>" class="btn btn-default btn-sm">去付款</a>
							<?php elseif($order['order_status_id'] == $this->config->get_config('to_be_delivered')):?>
							<button type="button" class="btn btn-default btn-sm">提醒卖家发货</button>
							<?php elseif($order['order_status_id'] == $this->config->get_config('inbound_state')):?>
							<button type="button" class="btn btn-default btn-sm">确认收货</button>
							<?php elseif($order['order_status_id'] == $this->config->get_config('state_to_be_evaluated')):?>
							<button type="button" class="btn btn-default btn-sm">去评价</button>
							<?php elseif($order['order_status_id'] == $this->config->get_config('refund_order')):?>
							<button type="button" class="btn btn-warning btn-sm">退款中</button>
							
							<?php endif;?>
						</td>
					</tr>
					<?php unset($order['products'][0]);?>
					<?php if(!empty($order['products'])):?>
					<?php foreach($order['products'] as $key=>$value):?>
					<tr>
						<td class="col-md-1 col-sm-1 col-xs-2 text-left border-right"><a target="_blank" href="<?php echo $this->config->item('catalog').'product?product_id='.$order['products'][$key]['product_id'];?>"><img width="<?php echo $this->config->get_config('wish_cart_image_size_b_w');?>px" height="<?php echo $this->config->get_config('wish_cart_image_size_b_h');?>px" class="media-object lazy" data-original="<?php echo $this->image_common->resize($order['products'][$key]['image'], $this->config->get_config('wish_cart_image_size_b_w'), $this->config->get_config('wish_cart_image_size_b_h'));?>" alt="<?php echo $order['products'][$key]['name']; ?>"></a></td>
						<td class="text-left col-md-3 col-sm-3 col-xs-4 border-right"><span><a target="_blank" href="<?php echo $this->config->item('catalog').'product?product_id='.$order['products'][$key]['product_id'];?>"><?php echo $order['products'][$key]['name']; ?></a></span><span class="value"><?php echo !empty($order['products'][$key]['value']) ? $order['products'][$key]['value'] : '';?></span></td>
						<td class="col-md-1 col-sm-1 hidden-xs text-center border-right"><strong style="color: red"><?php echo $this->currency->Compute($order['products'][$key]['price'] * $order['currency_value']);?></b></strong>
						
						<?php if($order['products'][$key]['tax'] != 0):?>
						<span>含税（<?php echo $this->currency->Compute($order['products'][$key]['tax'] * $order['currency_value']);?>）</span>
						<?php endif;?>
						</td>
						<td class="col-md-1 col-sm-1 hidden-xs text-center border-right"><?php echo $order['products'][$key]['quantity']; ?></td>
						<td class="text-center col-md-1 col-sm-1 hidden-xs border-right">
							<?php if(isset($order['products'][$key]['return'])):?>
							<a style="color: orange" target="_blank" href="<?php echo $this->config->item('catalog').'user/returned/info?rowid='.$order['products'][$key]['rowid'];?>"><?php echo $order['products'][$key]['return'];?></a><br/>
							<?php elseif($order['order_status_id'] != $this->config->get_config('default_order_status')):?>
							<a target="_blank" href="<?php echo $this->config->item('catalog').'user/returned?token='.$_SESSION['token'].'&rowid='.$order['products'][$key]['rowid'];?>">退款/退货</a><br/>
							<?php endif;?>
							投诉商家
						</td>
						<td class="col-md-2 col-sm-2 col-xs-2 border-noborder-top-right"></td>
						<td class="col-md-1 col-sm-1 col-xs-2 border-noborder-top-right"></td>
						<td class="col-md-2 col-sm-2 col-xs-2 border-noborder-top"></td>
					</tr>
					<?php endforeach;?>
					<?php endif;?>
					<?php endif;?>
					
				<?php endforeach;?>
				</tbody>
			</table>
			<?php else:?>
			<div class="well well-sm text-center">
				还没有订单？马上撸一发吧！
			</div>
			<?php endif;?>
			<?php echo $pagination;?>
			<?php echo $position_bottom; ?>
		</div>
		<?php echo $position_right; ?>
	</div>
	<!-- /row -->
	<script>
		function del_order(id){
			$.ajax({
				url: '<?php echo $this->config->item('catalog').'user/orders/del_order';?>',
				type: 'post',
				dataType: 'json',
				data: {order_id:id},
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
					if(data.success){
						window.location.reload();
						$.notify({message: data.success,},{type: 'success',offset: {x: 0,y: 52}});
					}else{
						$.notify({message: data.error },{type: 'warning',offset: {x: 0,y: 52}});
					}
				},
				error: function(xhr, ajaxOptions, thrownError)
				{
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		}
		
		$('#table-orders-product tbody input[class=\'select\']').click(function(){
			var insize=parseInt($('#table-orders-product tbody input[class=\'select\']').size());
			var chsize=parseInt($('#table-orders-product tbody input[class=\'select\']:checked').size());

			if(chsize >= 1){
				if(chsize < insize){
					$('#table-orders-product .checkall').prop("indeterminate", true);
				}else if(chsize = insize){
					$('#table-orders-product .checkall').prop("indeterminate", false);
					$('#table-orders-product .checkall').attr("checked", "checked");
				}
			}else{
				$('#table-orders-product .checkall').prop("indeterminate", false);
				$('#table-orders-product .checkall').removeAttr("checked");
			}
		});
	</script>
</div>
<!-- /container -->
<?php echo $footer;//装载header?>