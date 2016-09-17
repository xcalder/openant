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
			
			<?php if(!$retun):?>
			<div class="well well-lg">
				<div class="media">
				  <div class="media-left media-middle">
				    <a>
				      <img class="media-object" src="public/resources/default/image/error.jpg" alt="...">
				    </a>
				  </div>
				  <div class="media-body">
				    <p class="media-heading"><strong>付款错误,服务器拒绝！</strong></p>
				    可能的原因：<br/>1、安全码不一致<br/>2、已经完成付款<br/>3、联系网站处理
				  </div>
				</div>
			</div>
			
			<?php else:?>
			<div class="well well-sm">支付金额:<span style="color: red;font-size:18px;font-weight: bold;"><?php echo $this->currency->Compute($payment_total);?></span></div>
			
			<strong>选择付款方式</strong><hr style="margin: 15px 0;border-top: 2px solid #5bc0de">
			<div id="payment_method" style="margin-bottom: 25px">
				<?php foreach($payment_methods as $payment_method):?>
				<?php $payment_method['value']=unserialize($payment_method['value']);?>
				
				<?php if($payment_method['value']['status'] == '1'):?>
				<div class="col-md-2 payment-list <?php echo $payment_method['key']?>" onclick="change_paymethod('<?php echo $payment_method['key']?>');">
					<img src="public/resources/default/image/payment_ico/<?php echo $payment_method['key']?>.jpg" title="<?php echo $payment_method['value']['vname'];?>"/>
				</div>
				<?php endif;?>
				
				<?php endforeach;?>
			</div>
			
			<strong>余额付款</strong><hr style="margin: 15px 0;border-top: 2px solid #5bc0de">
			<form action="<?php echo site_url('user/confirm/payment_operation?encrypt=').$encrypt;?>" method="post" enctype="multipart/form-data" class="form-horizontal" id="pay_form">
			  <div class="form-group">
			    <label class="col-sm-2 control-label">帐户余额</label>
			    <div class="col-sm-10">
			      <p class="form-control-static"><?php echo $this->currency->Compute($balances);?></p>
			    </div>
			  </div>
			  <div class="form-group">
			    <label for="balances" class="col-sm-2 control-label">使用余额支付</label>
			    <div class="col-sm-10" style="padding-top: 9px">
			    	<?php if($payment_total > $balances):?>
			    	余额不足，请选用其它支付方式
			    	<?php else:?>
			    	<input type="checkbox" name="balances" value="1" id="balances" onclick="chang_payinput();">使用余额付款
			    	<?php endif;?>
			    </div>
			  </div>
			  
			  <hr style="margin: 15px 0;border-top: 2px solid #5bc0de">
			  
			  <div class="form-group">
			    <label for="inputPassword" class="col-sm-6 control-label">
				      <input type="password" class="form-control" id="payPassword" name="pay_password" placeholder="请输入支付密码" value="">
			    </label>
			    <div class="col-sm-6" style="padding-top: 7px;text-align: right">
			    	支付金额:<span style="color: red;font-size:18px;font-weight: bold;padding:6px 12px"><?php echo $this->currency->Compute($payment_total);?></span>
			      	<input type="hidden" name="payment_total" value="<?php echo $payment_total;?>">
			    	<input type="hidden" name="order_ids" value="<?php echo $this->input->get('order_ids');?>">
			    	<button type="submit" class="btn btn-info">确认</button>
			    </div>
			  </div>
			</form>
			<?php endif;?>
			
			<?php echo $position_bottom; ?>
		</div>
		<?php echo $position_right; ?>
	</div>
	<!-- /row -->
	<script>
		function change_paymethod(key){
			$('#payment_method .payment-list').removeClass('active');
			$('.'+key).addClass('active');
			$('input[id=\'balances\']').removeAttr("checked");
			
			if($('input[name=\'payment_method\']').hasClass('payment_method')){
				$('input[name=\'payment_method\']').val(key);
			}else{
				$('button[type=\'submit\']').before('<input type="hidden" class="payment_method" name="payment_method" value="'+key+'">');
			}
		}
		
		function chang_payinput(){
			$('input[name=\'payment_method\']').remove();
			$('#payment_method .payment-list').removeClass('active');
		}
		
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
		
		//验证找回密码
		$(document).ready(function(){
			$("#pay_form").validate({
					rules: {
						pay_password: {
							required: true
						}
					},
					messages: {
						pay_password: {
							required: "支付密码不能为空！"
						}
					}
				});
		});
	</script>
	<style type="text/css">
		.ystep-container{
			margin-left: calc(50% - 180px);
		}
		#payment_method .payment-list.active{
			border: 1px solid rgb(0, 195, 255);
		}
	</style>
</div>
<!-- /container -->
<?php echo $footer;//装载header?>