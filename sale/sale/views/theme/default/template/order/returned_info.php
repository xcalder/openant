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
			
			<p style="margin-bottom: 0">物流信息</p><hr style="margin: 2px 0">
			<div>快递单号：<?php echo $return_info['logistic'];?></div>
			<div>退货快递单号：<?php echo $return_info['re_logistics'];?></div>
			<hr style="margin: 2px 0">
			<p style="margin-bottom: 0">商家信息</p><hr style="margin: 2px 0">
			<div class="col-sm-6">商家昵称：<?php echo $return_info['s_nickname'];?></div>
			<div class="col-sm-6">真实姓名：<?php echo $return_info['s_firstname'].$return_info['s_lastname'];?></div>
			<div class="col-sm-6">邮箱：<?php echo $return_info['s_email'];?></div>
			<div class="col-sm-6">手机号：<?php echo $return_info['s_telephone'];?></div>
			<hr style="margin: 2px 0">
			
			<p style="margin-bottom: 0">订单信息</p><hr style="margin: 2px 0">
			<div>下单时间：<?php echo $return_info['o_date_added'];?></div>
			<div>发票号码：<?php echo !empty($return_info['o_invoice_no']) ? $return_info['o_invoice_no'] : '无发票';?></div>
			<div>退款方式：<?php echo $return_info['re_mode'];?></div>
			
			<table class="table" style="margin: 10px 0;border:1px solid rgb(217, 217, 217);">
				<thead>
					<tr>
						<td colspan="6" class="col-md-6 col-sm-6 col-xs-6 border-right">退款编号：<?php echo $return_info['rowid'];?></td>
					</tr>
					<tr>
						<td colspan="2" class="text-left col-md-4 col-sm-4 col-xs-6 border-right">商品</td>
						<td class="col-md-2 col-sm-2 hidden-xs text-center border-right">单价</td>
						<td class="col-md-2 col-sm-2 col-xs-2 text-center border-right">数量</td>
						<td class="col-md-2 col-sm-2 col-xs-2 text-center border-right">退款金额</td>
						<td class="col-md-2 col-sm-2 col-xs-2 text-center border-right">退换货状态</td>
					</tr>
				</thead>
				<tbody>
				
					<tr>
						<td class="col-md-1 col-sm-1 col-xs-2 text-left border-right"><a target="_blank" href="<?php echo $this->config->item('sale').'product?product_id='.$return_info['product_id'];?>"><img width="<?php echo $this->config->get_config('wish_cart_image_size_b_w');?>px" height="<?php echo $this->config->get_config('wish_cart_image_size_b_h');?>px" class="media-object lazy" data-original="<?php echo $this->image_common->resize($return_info['image'], $this->config->get_config('wish_cart_image_size_b_w'), $this->config->get_config('wish_cart_image_size_b_h'));?>" alt="<?php echo $return_info['name']; ?>"></a></td>
						<td class="text-left col-md-3 col-sm-3 col-xs-4 border-right"><span><a target="_blank" href="<?php echo $this->config->item('sale').'product?product_id='.$return_info['product_id'];?>"><?php echo $return_info['name']; ?></a></span><span class="value"><?php echo !empty($return_info['option']) ? $return_info['option'] : '';?></span></td>
						<td class="col-md-2 col-sm-2 hidden-xs text-center border-right"><strong style="color: red"><?php echo $this->currency->Compute($return_info['price'] * $return_info['currency_value']);?></b></strong></td>
						<td class="col-md-2 col-sm-2 col-xs-2 text-center border-right"><?php echo $return_info['quantity']; ?></td>
						<td class="text-center col-md-2 col-sm-2 col-xs-2 border-right"><strong style="color: red"><?php echo $this->currency->Compute($return_info['return_amount']  * $return_info['currency_value']); ?></b></strong></td>
						<td class="text-center col-md-2 col-sm-2 col-xs-2 border-right"><span><?php echo $return_info['status_name']; ?></span><?php echo $return_info['return_action']; ?><br/><?php echo $return_info['opened'] == '1' ? '已开封' : '未开封';?></td>
					</tr>
					
				</tbody>
				
				<tfoot>
					<tr>
						<td colspan="6">退换货历史</td>
					</tr>
					<tr>
						<td colspan="2">描述</td>
						<td colspan="2">状态</td>
						<td colspan="2">时间</td>
					</tr>
					<?php if(!empty($return_info['return_history'])):?>
					<?php foreach ($return_info['return_history'] as $history):?>
					<tr>
						<td colspan="2"><?php echo $history['comment'];?></td>
						<td colspan="2"><?php echo $history['name'];?></td>
						<td colspan="2"><?php echo $history['date_added'];?></td>
					</tr>
					<?php endforeach;?>
					<?php endif;?>
				</tfoot>
				
			</table>
			
			<?php if($return_info['return_history'][0]['return_status_id'] == $this->config->get_config('request_refund')):?>
			退款处理
			<hr>
			<form action="<?php echo $this->config->item('sale').'order/returned/action?token='.$_SESSION['token'].'&rowid='.$this->input->get('rowid');?>" method="post" enctype="multipart/form-data" class="form-horizontal">
			<div class="form-group">
				<div class="col-sm-12" for="comment">退款说明</div>
				<div class="col-sm-12">
					<textarea rows="5" id="comment" name="comment" class="form-control"></textarea>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-6 text-right"><button type="submit" class="btn btn-warning btn-sm" id="refuse">拒绝退款</button></div>
				<div class="col-sm-6"><button type="submit" class="btn btn-success btn-sm" id="agree">同意退款</button></div>
				<input type="hidden" name="return_id" value="<?php echo $return_info['return_id'];?>">
				<input type="hidden" name="action" id="action" value="">
				<input type="hidden" name="return_action_id" value="<?php echo $return_info['return_action_id'];?>">
				<input type="hidden" name="user_id" value="<?php echo $return_info['user_id'];?>">
			</div>
          </form>
          <script type="text/javascript">
			$(document).ready(function ()
			{
				$('#comment').summernote(
				{
					height: 200,                 // set editor height
	
				});

				$('#agree').click(function(){
					$('#action').val('agree');
				});
				
				$('#refuse').click(function(){
					$('#action').val('refuse');
				});
				
			});
		</script>
		<?php endif;?>
		
		<?php if($return_info['return_history'][0]['return_status_id'] == $this->config->get_config('wait_m_returns')):?>
			退款处理
			<hr>
			<form action="<?php echo $this->config->item('sale').'order/returned/mode?token='.$_SESSION['token'].'&rowid='.$this->input->get('rowid');?>" method="post" enctype="multipart/form-data" class="form-horizontal">
				<div class="form-group">
					<div class="col-sm-12" for="return_mode">退款方式</div>
					<div class="col-sm-12">
						<select id="return_mode" name="return_mode_id" class="form-control">
							<?php foreach ($return_modes as $return_mode):?>
							<option value="<?php echo $return_mode['return_mode_id'];?>"><?php echo $return_mode['name'];?></option>
							<?php endforeach;?>
						</select>
					</div>
				</div>
				
				<div class="form-group">
					<div class="col-sm-12" for="comment">退款说明</div>
					<div class="col-sm-12">
						<textarea rows="5" id="comment" name="comment" class="form-control"></textarea>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-12 text-center"><button type="submit" class="btn btn-success btn-sm">确认退款</button></div>
					<input type="hidden" name="return_id" value="<?php echo $return_info['return_id'];?>">
					<input type="hidden" name="user_id" value="<?php echo $return_info['o_user_id'];?>">
				</div>
          </form>
          <script type="text/javascript">
			$(document).ready(function ()
			{
				$('#comment').summernote(
				{
					height: 200,                 // set editor height
	
				});
			});
			</script>
			<?php endif;?>
			
		<?php echo $position_bottom; ?>
		</div>
		<?php echo $position_right; ?>
	</div>
	<!-- /row -->
	
</div>
<!-- /container -->
<?php echo $footer;//装载header?>