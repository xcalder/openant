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
	<tr style="background-color: #f5f5f5">
		<td colspan="3" style="border-right-width: 0;">订单号：<?php echo date('YmdHis',strtotime($order['date_added'])).'-'.$order['order_id'];?></td>
		<td colspan="2" class="text-right" style="border-left-width: 0;border-right-width: 0"><img width="18px" height="18px" class="lazy" data-original="<?php echo $this->image_common->resize($order['logo'], 18, 18);?>" alt="<?php echo $order['store_name']; ?>"><?php echo $order['store_name'];?></td>
		<td style="border-left-width: 0;"></td>
	</tr>
	<?php if($order['products']):?>
	<tr>
		<td class="text-left col-sm-2 col-md-2"><a target="_blank" href="<?php echo $this->config->item('catalog').'/product?product_id='.$order['products'][0]['product_id'];?>"><img width="<?php echo $this->config->get_config('wish_cart_image_size_b_w');?>px" height="<?php echo $this->config->get_config('wish_cart_image_size_b_h');?>px" class="media-object lazy" data-original="<?php echo $this->image_common->resize($order['products'][0]['image'], $this->config->get_config('wish_cart_image_size_b_w'), $this->config->get_config('wish_cart_image_size_b_h'));?>" alt="<?php echo $order['products'][0]['name']; ?>"></a></td>
		<td class="text-left col-sm-2 col-md-2"><span><a target="_blank" href="<?php echo $this->config->item('catalog').'/product?product_id='.$order['products'][0]['product_id'];?>"><?php echo utf8_substr($order['products'][0]['name'], 0, 15); ?></a></span><br/><span class="value"><?php echo !empty($order['products'][0]['value']) ? utf8_substr($order['products'][0]['value'], 0, 15) : '';?></span></td>
		<td class="text-center col-sm-1 col-md-2"><?php echo $order['products'][0]['quantity']; ?></td>
		<td class="text-center col-md-2 hidden-xs" style="border-top-width: 0;border-bottom-width: 0"><strong><?php echo $order['currency_code'].':<b class="red">'.$order['symbol_left'].sprintf('%.'.$order['decimal_place'].'f', $order['total'] * $order['currency_value']).$order['symbol_right']; ?></b></strong>
			<span>含税（<?php echo $order['currency_code'].':'.$order['symbol_left'].sprintf('%.'.$order['decimal_place'].'f', array_sum(array_column($order['products'], 'tax')) * $order['currency_value']).$order['symbol_right']; ?>）</span>
		</td>
		<td class="text-center col-sm-3 col-md-2" style="border-top-width: 0;border-bottom-width: 0"><?php echo $order['status_name']; ?></td>
		<td class="text-center col-sm-3 col-md-2" style="border-top-width: 0;border-bottom-width: 0"><button type="button" class="btn btn-default">确认收货</button></td>
	</tr>
	<?php unset($order['products'][0]);?>
	<?php if(!empty($order['products'])):?>
	<?php foreach($order['products'] as $key=>$value):?>
	<tr>
		<td class="text-left"><a target="_blank" href="<?php echo $this->config->item('catalog').'/product?product_id='.$order['products'][$key]['product_id'];?>"><img width="<?php echo $this->config->get_config('wish_cart_image_size_b_w');?>px" height="<?php echo $this->config->get_config('wish_cart_image_size_b_h');?>px" class="media-object lazy" data-original="<?php echo $this->image_common->resize($order['products'][$key]['image'], $this->config->get_config('wish_cart_image_size_b_w'), $this->config->get_config('wish_cart_image_size_b_h'));?>" alt="<?php echo $order['products'][$key]['name']; ?>"></a></td>
		<td class="text-left"><span><a target="_blank" href="<?php echo $this->config->item('catalog').'/product?product_id='.$order['products'][$key]['product_id'];?>"><?php echo utf8_substr($order['products'][$key]['name'], 0, 15); ?></a></span><br/><span class="value"><?php echo !empty($order['products'][$key]['value']) ? utf8_substr($order['products'][$key]['value'], 0, 15) : '';?></span></td>
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