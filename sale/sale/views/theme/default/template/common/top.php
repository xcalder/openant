<body id="<?php echo $css;?>">
<div id="header">
	<!-- Start Navigation -->
	<nav class="navbar center-side bootsnav hidden-xs" style="z-index: 10" id="nav-top">
	<div class="container">
		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="navbar-menu-top">
			<ul class="nav navbar-nav navbar-left" data-in="fadeInDown" data-out="fadeOutUp">
				<li><a class="navbar-brand navbar-brand-logo" href="<?php echo base_url();?>" title="<?php echo unserialize($this->config->get_config('site_abbreviation'))[$_SESSION['language_id']]?>"><img width="46px" height="46px" data-original="<?php echo $this->config->get_config('site_image') !== FALSE ? $this->image_common->resize($this->config->get_config('site_image'), 46, 46, 'h') : 'resources/public/resources/default/image/logo-menu.jpg';?>" class="lazy" alt="<?php echo unserialize($this->config->get_config('site_abbreviation'))[$_SESSION['language_id']]?>"></a></li>
				<?php echo $language;?>
				<?php echo $currency;?>
				
			</ul>
				
			<form class="navbar-form navbar-left" role="search" action="product/category" method="get" id="openant-search">
				<div class="input-group input-group-sm">
				  <span class="input-group-addon">商城</span>
				  <input type="text" class="form-control" name="search" id="search" value="<?php echo !empty($action_search) ? $action_search : '';?>">
				</div>
			</form>
			
			<ul class="nav navbar-nav navbar-right" data-in="fadeInDown" data-out="fadeOutUp">
				
				<li class="dropdown megamenu-fw">
					<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">站点地图</a>
					<ul class="dropdown-menu megamenu-content" role="menu">
						<li class="container">
							<div class="row">
								<div class="col-menu col-md-3">
									<h6 class="title">Title Menu One</h6>
									<div class="content">
										<ul class="menu-col">
											<li><a href="#">Custom Menu</a></li>
											<li><a href="#">Custom Menu</a></li>
											<li><a href="#">Custom Menu</a></li>
											<li><a href="#">Custom Menu</a></li>
											<li><a href="#">Custom Menu</a></li>
											<li><a href="#">Custom Menu</a></li>
										</ul>
									</div>
								</div><!-- end col-3 -->
								<div class="col-menu col-md-3">
									<h6 class="title">Title Menu Two</h6>
									<div class="content">
										<ul class="menu-col">
											<li><a href="#">Custom Menu</a></li>
											<li><a href="#">Custom Menu</a></li>
											<li><a href="#">Custom Menu</a></li>
											<li><a href="#">Custom Menu</a></li>
											<li><a href="#">Custom Menu</a></li>
											<li><a href="#">Custom Menu</a></li>
										</ul>
									</div>
								</div><!-- end col-3 -->
								<div class="col-menu col-md-3">
									<h6 class="title">Title Menu Three</h6>
									<div class="content">
										<ul class="menu-col">
											<li><a href="#">Custom Menu</a></li>
											<li><a href="#">Custom Menu</a></li>
											<li><a href="#">Custom Menu</a></li>
											<li><a href="#">Custom Menu</a></li>
											<li><a href="#">Custom Menu</a></li>
											<li><a href="#">Custom Menu</a></li>
										</ul>
									</div>
								</div>    
								<div class="col-menu col-md-3">
                                    	<?php if($nav_infomation):?>
                                        <h6 class="title"><?php echo $nav_infomation['name'];?></h6>
                                        <?php if($nav_infomation['informations']):?>
                                        <div class="content">
                                            <ul class="menu-col">
                                            	<?php foreach($nav_infomation['informations'] as $information):?>
                                                <li><a href="<?php echo $this->config->item('catalog');?>/helper/faq?inforation_id=<?php echo $information['information_id'];?>#inforation-<?php echo $information['information_id'];?>"><?php echo $information['title'];?></a></li><hr>
                                                <?php endforeach;?>
                                            </ul>
                                        </div>
                                        <?php endif;?>
                                        <?php endif;?>
                                    </div><!-- end col-3 -->
							</div><!-- end row -->
						</li>
					</ul>
				</li>
				<!--如果已经登陆不显示-->
				<?php
				if($this->user->isLogged()):?>
				<!--如果没有登陆不显示-->
				<li class="dropdown">
					<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
						<?php echo utf8_substr($this->user->getnickname(), 0, 8);?>
						<span class="badge">
							<?php echo $activity_count;?>
						</span>
					</a>
					<ul class="dropdown-menu">
						<li>
							<a href="user/notice">
								消息
								<span class="badge">
									<?php echo $activity_count;?>
								</span>
							</a>
						</li>
						<?php
						if(isset($access_sale)):?>
						<li>
							<a onclick="window.open('<?php echo $url_sale;?>');">
								卖家中心
							</a>
						</li>
						<?php endif;?>
						<li>
							<a href="#">
								我的订单
							</a>
						</li>
						<li>
							<a href="#">
								我的足迹
							</a>
						</li>
						<li>
							<a onclick="logout();">
								退出帐号
							</a>
						</li>
					</ul>
				</li>
				<?php endif;?>
			</ul>
		</div>
		<!--/.nav-collapse -->
	</div>
</nav>
<!-- /navbar -->
<?php echo $position_above;?>
<nav class="navbar navbar-default bootsnav on menu-center no-full navbar-sticky hidden-xs" id="nav-menu">
	<div class="container">
	<div id="navbar-menu" class="navbar-collapse collapse">
		<ul class="nav navbar-nav navbar-left category-menu">
			<li><a href="<?php echo $this->config->item('sale');?>" title="lvxingto"><i class="glyphicon glyphicon-briefcase"></i>商家中心</a></li>
			<li class="dropdown">
				<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
					<i class="glyphicon glyphicon-th"></i>
					<span>商品管理</span>
				</a>
				<ul class="dropdown-menu">
					<li>
						<a href="<?php echo $this->config->item('sale').'product/product/select_category';?>">
							添加商品
						</a>
					</li>
					<li>
						<a href="<?php echo $this->config->item('sale').'product/product';?>">
							所有商品
						</a>
					</li>
					<li>
						<a href="<?php echo $this->config->item('sale').'product/product?status=1';?>">
							售中商品
						</a>
					</li>
					<li>
						<a href="<?php echo $this->config->item('sale').'product/product?status=0';?>">
							仓库中商品
						</a>
					</li>
					<li>
						<a href="<?php echo $this->config->item('sale').'product/product?invalid=1';?>">
							永久下架
						</a>
					</li>
					<li>
						<a href="<?php echo $this->config->item('sale').'product/product?time=1';?>">
							处罚商品
						</a>
					</li>
				</ul>
			</li>
			<li class="dropdown">
				<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
					<i class=" glyphicon glyphicon-user">
					</i>
					<span>
						订单管理
					</span>
				</a>
				<ul class="dropdown-menu">
					<li>
						<a href="<?php echo $this->config->item('sale').'order/orders';?>">
							所有订单
						</a>
					</li>
					<li>
						<a href="<?php echo $this->config->item('sale').'order/orders?order_status='.$this->config->get_config('default_order_status');?>">
							待付款订单
						</a>
					</li>
					<li>
						<a href="<?php echo $this->config->item('sale').'order/orders?order_status='.$this->config->get_config('to_be_delivered');?>">
							待发货订单
						</a>
					</li>
					<li>
						<a href="<?php echo $this->config->item('sale').'order/orders?order_status='.$this->config->get_config('inbound_state');?>">
							待收货订单
						</a>
					</li>
					<li>
						<a href="<?php echo $this->config->item('sale').'order/orders?order_status='.$this->config->get_config('state_to_be_evaluated');?>">
							待评价订单
						</a>
					</li>
					<li>
						<a href="<?php echo $this->config->item('sale').'order/orders?order_status='.$this->config->get_config('order_completion_status');?>">
							交易成功订单
						</a>
					</li>
					<li>
						<a href="<?php echo $this->config->item('sale').'order/orders?order_status='.$this->config->get_config('refund_order');?>">
							退款中订单
						</a>
					</li>
					<li>
						<a href="<?php echo $this->config->item('sale').'order/orders?order_status='.$this->config->get_config('refund_order_success');?>">
							退款成功的订单
						</a>
					</li>
				</ul>
			</li>
			<li class="dropdown">
				<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-wrench"></i><span>退款管理</span></a>
				<ul class="dropdown-menu">
					<li><a href="<?php echo $this->config->item('sale').'order/returned';?>">退款商品列表</a></li>
				</ul>
			</li>
			<li class="dropdown">
				<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
					<i class="glyphicon glyphicon-wrench">
					</i>
					<span>
						评价管理
					</span>
				</a>
				<ul class="dropdown-menu">
					<li>
						<a href="<?php echo $this->config->item('sale').'product/review';?>">
							评价管理
						</a>
					</li>
				</ul>
			</li>
			<li class="dropdown">
				<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
					<i class="glyphicon glyphicon-wrench">
					</i>
					<span>
						店铺装修
					</span>
				</a>
				<ul class="dropdown-menu">
					<li>
						<a href="<?php echo $this->config->item('sale').'product/category';?>">
							分类管理
						</a>
					</li>
					<li>
						<a href="<?php echo $this->config->item('sale').'product/manufacturer';?>">
							品牌申请
						</a>
					</li>
					<li>
						<a href="<?php echo $this->config->item('sale').'product/freight';?>">
							运费模板
						</a>
					</li>
				</ul>
			</li>
			<li class="dropdown">
				<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
					<i class="glyphicon glyphicon-cog">
					</i>
					<span>
						常见问题
					</span>
				</a>
				<ul class="dropdown-menu">
					<li>
						<a href="<?php echo $this->config->item('sale').'common/setting';?>">
							网站设置
						</a>
					</li>
					<li>
						<a href="<?php echo $this->config->item('sale').'information/information';?>">
							文章管理
						</a>
					</li>
					<li>
						<a href="<?php echo $this->config->item('sale').'information/information_category';?>">
							文章分类
						</a>
					</li>
					<li>
						<a href="<?php echo $this->config->item('sale').'report/reports';?>">
							数据报表
						</a>
					</li>
					<li>
						<a href="login">
							数据库备份/恢复
						</a>
					</li>
					<li>
						<a href="signup">
							错误日志
						</a>
					</li>
				</ul>
			</li>
		</ul>
	</div>
	<!-- /container -->
	<!-- /subnavbar-inner -->
</nav>
<script type="text/javascript">
	$('#search').placeholderTypewriter({
		text: ["www.openant.com/bbs.php", "蚂蚁开源论坛", "如果你有什么问题？", "可以在这里得到解答", "用简单的方式描述它"]
	});
</script>
	<div id="mobile-menu" class="well">
		<ul>
			<li class="text-center" style="width: 20%"><a href="<?php echo base_url();?>"><i class="glyphicon glyphicon-home"></i>首页</a></li>
			<li class="text-center" style="width: 20%"><a href="<?php echo base_url();?>"><i class="glyphicon glyphicon-ok"></i>订单</a></li>
			<li class="text-center" style="width: 20%"><a href="common/mobile_nav"><i class="glyphicon glyphicon-th"></i>商品</a></li>
			<li class="text-center" style="width: 20%"><a href="user/wecome"><i class="glyphicon glyphicon-repeat"></i>退换</a></li>
			<li class="text-center" style="width: 20%"><a href="user/wecome"><i class="glyphicon glyphicon-tree-deciduous"></i>论坛</a></li>
		</ul>
	</div>

</div>
<div id="content">