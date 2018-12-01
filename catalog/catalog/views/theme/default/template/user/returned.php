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
			
			 <table class="table table-bordered" style="font-size: 14px">
			 	<thead>
			 		<tr>
			 			<td colspan="2">商品信息</td>
			 			<td>单价</td>
			 			<td>数量</td>
			 			<td>实付款</td>
			 			<td>最高退款金额</td>
			 			<td>积分</td>
			 		</tr>
			 	</thead>
			 	<tbody>
			 		<tr>
			 			<td><img src="<?php echo $this->image_common->resize($order_product['image'], $this->config->get_config('wish_cart_image_size_b_w'), $this->config->get_config('wish_cart_image_size_b_h'));?>"></td>
			 			<td><?php echo $order_product['name'];?><?php if(!empty($order_product['value'])):?><br/><span style="color:#9e9e9e"><?php echo $order_product['value'];?></span><?php endif;?></td>
			 			<td><?php echo $this->currency->Compute($order_product['price'] * $order_product['currency_value']);?>
			 				<?php if($order_product['tax'] != 0):?>
							<br/><span>含税（<?php echo $this->currency->Compute($order_product['tax'] * $order_product['currency_value']);?>）</span>
							<?php endif;?>
			 			</td>
			 			<td><?php echo $order_product['quantity'];?></td>
			 			<td><?php echo $this->currency->Compute($order_product['total']  * $order_product['currency_value']);?>
			 				<?php if($order_product['tax'] != 0):?>
							<br/><span>含税（<?php echo $this->currency->Compute($order_product['tax'] * $order_product['quantity']  * $order_product['currency_value']);?>）</span>
							<?php endif;?>
			 			</td>
			 			<td><?php echo $this->currency->Compute($order_product['total'] * $order_product['currency_value'] - ($order_product['tax'] * $order_product['quantity'] * $order_product['currency_value']));?></td>
			 			<td>-<?php echo $order_product['points'];?></td>
			 		</tr>
			 	</tbody>
			 </table>
			
			 <form class="form-horizontal" action="<?php echo $this->config->item('catalog').'/user/returned?token=' . $_SESSION['token'] . '&rowid=' . $this->input->get('rowid');?>" method="post" style="padding: 15px;border:1px solid rgb(222, 221, 221)">
				<div class="form-group">
					<label for="return_action" class="col-sm-2 control-label">退换货方式</label>
					<div class="col-sm-10">
						<select name="return_action_id" class="form-control" id="return_action">
						 <?php foreach ($return_actions as $return_action):?>
						 <option value="<?php echo $return_action['return_action_id'];?>"><?php echo $return_action['name'];?></option>
						 <?php endforeach;?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="return_reason" class="col-sm-2 control-label">退换货原因</label>
					<div class="col-sm-10">
						<select name="return_reason_id" class="form-control" id="return_reason">
						 <?php foreach ($return_reasons as $return_reason):?>
						 <option value="<?php echo $return_reason['return_reason_id'];?>"><?php echo $return_reason['name'];?></option>
						 <?php endforeach;?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="return_amount" class="col-sm-2 control-label">退款金额</label>
					<div class="col-sm-10">
						<input type="text" name="return_amount" class="form-control" id="return_amount" placeholder="退款金额" value="<?php echo $order_product['total'] - ($order_product['tax'] * $order_product['quantity']);?>">
					</div>
				</div>
				<div class="form-group">
					<label for="return_opened" class="col-sm-2 control-label">是否打开包装</label>
					<div class="col-sm-10">
						<input type="radio" name="opened" id="return_opened" value="1"> 是
						<input type="radio" name="opened" id="return_opened" value="0" checked> 否
					</div>
				</div>
				<div class="form-group">
					<label for="return-instructions" class="col-sm-2 control-label">退款说明</label>
					<div class="col-sm-10">
						<textarea rows="5" id="return-instructions" name="return_instructions" class="form-control"></textarea>
					</div>
				</div>
				
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<button type="submit" class="btn btn-default">提交</button>
					</div>
				</div>
			</form>
			
			<!-- /widget -->
			<?php echo $position_bottom; ?>
		</div>
		<?php echo $position_right; ?>
	</div>
	<script type="text/javascript">
		$(document).ready(function ()
			{
				$('#return-instructions').summernote(
				{
					height: 200,                 // set editor height

				});
			});
	</script>
	<!-- /row -->
</div>
<!-- /container -->
<?php echo $footer;//装载header?>