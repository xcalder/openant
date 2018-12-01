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
		<div id="middel-mobile-nav" class="<?php echo $class; ?>"><?php echo $position_top; ?>
    		<div class="text-center" style="position: relative;border-bottom: 1px solid rgb(230, 230, 230);">
    			<img src="image\users\2016\02\02\1/oXFeATWxPrvaKO2Z.png" alt="..." class="img-circle" style="padding: 15px;max-width: 150px;">
    			<span style="position: relative;">用户001</span>
    		</div>
			<section style="padding-left: 0">
				<div id="menu" class="slinky-menu">
					<ul style="padding-left: 0">
						<li><a>消息</a></li>
						<li>
							<a>我的订单</a>
							<ul>
								<li><a>侍付款</a></li>
								<li><a>待发货</a></li>
								<li><a>待收货</a></li>
								<li><a>待评价</a></li>
								<li><a>交易成功</a></li>
								<li><a>全部订单</a></li>
							</ul>
						</li>
						<li>
							<a>优惠券</a>
							<ul>
								<li><a>平台优惠券</a></li>
								<li><a>商家优惠券</a></li>
								<li><a>打折市场</a></li>
								<li><a>优惠预告</a></li>
							</ul>
						</li>
						<li>
							<a>历史记录</a>
							<ul>
								<li><a>我的足迹</a></li>
								<li><a>操作记录</a></li>
								<li><a>其它交易</a></li>
							</ul>
						</li>
						<li>
							<a>退款维权</a>
							<ul>
								<li><a>退款中订单</a></li>
								<li><a>退款成功的订单</a></li>
								<li><a>退换货规则</a></li>
							</ul>
						</li>
						<li>
							<a>帐户设置</a>
							<ul>
								<li>
									<a>安全设置</a>
									<ul>
										<li><a>修改登陆密码</a></li>
										<li><a>修改个人信息</a></li>
										<li><a>修改支付密码</a></li>
									</ul>
								</li>
								<li>
									<a>个人资料</a>
									<ul>
										<li><a>管理收货地址</a></li>
										<li><a>隐私设置</a></li>
									</ul>
								</li>
							</ul>
						</li>
						<li>
							<a>语言设置</a>
							<ul>
								<li><a>简体中文</a></li>
								<li><a>english</a></li>
							</ul>
						</li>
						<li>
							<a>货币设置</a>
							<ul>
								<li><a>人民币</a></li>
								<li><a>美元</a></li>
							</ul>
						</li>
						<li><a>退出</a></li>
					</ul>
				</div>
			</section>
    
			<?php echo $position_bottom; ?></div>
		<?php echo $position_right; ?>
	</div>
	<script>
		$(document).ready(function() {
				$('#menu').slinky({
						title: true
					});
			});
	</script>
	<!-- /row --> 
</div>
<!-- /container -->
<?php echo $footer;//装载header?>