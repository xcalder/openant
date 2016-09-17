<body id="<?php //echo $css;?>">
<div id="header">
	<!-- Start Navigation -->
	<nav class="navbar navbar-default brand-center center-side bootsnav hidden-xs" style="z-index: 10" id="nav-top">
	<div class="container">

		<!-- Start Header Navigation -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu-top">
				<i class="glyphicon glyphicon-menu-hamburger"></i>
			</button>
		</div>
		<!-- End Header Navigation -->

		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="navbar-menu-top">
			<ul class="nav navbar-nav" data-in="fadeInDown" data-out="fadeOutUp">
				<li style="max-height: 50px"><a class="navbar-brand navbar-brand-logo" style="padding: 0 15px" href="<?php echo base_url();?>" title="<?php echo unserialize($this->config->get_config('site_abbreviation'))[$_SESSION['language_id']]?>"><img width="50px" height="50px" data-original="<?php echo $this->config->get_config('site_image') !== FALSE ? $this->image_common->resize($this->config->get_config('site_image'), 65, 65, 'h') : 'public/resources/default/image/logo-menu.jpg';?>" class="logo lazy" alt="" style="background: url();"></a></li>
				<?php echo $language;?>
				<?php echo $currency;?>

				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<?php echo lang_line('text_business');?>
						<span class="badge">
							42
						</span>
					</a>
					<ul class="dropdown-menu">
						<li>
							<a href="javascript:;">
								设置
							</a>
						</li>
						<li>
							<a href="javascript:;">
								帮助
							</a>
						</li>
					</ul>
				</li>
				<li class="dropdown megamenu-fw">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">站点地图</a>
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
                                                <li><a href="helper/faq.html?inforation_id=<?php echo $information['information_id'];?>#inforation-<?php echo $information['information_id'];?>"><?php echo $information['title'];?></a></li>
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
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<?php echo utf8_substr($this->user->getnickname(), 0, 8);?>
						<span class="badge">
							14
						</span>
					</a>
					<ul class="dropdown-menu">
						<li>
							<a href="<?php echo site_url();?>">
								消息
								<span class="badge">
									14
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
	<!-- Start Header Navigation -->
	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu"><i class="glyphicon glyphicon-menu-hamburger"></i></button>
	</div>
	<!-- End Header Navigation -->

	<!-- Collect the nav links, forms, and other content for toggling -->
	<div id="navbar-menu" class="navbar-collapse collapse">
		<ul class="nav navbar-nav navbar-left category-menu">
			<li><a href="<?php echo site_url();?>" title="lvxingto"><i class="glyphicon glyphicon-briefcase"></i>商家中心</a></li>
			<li class="dropdown">
				<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
					<i class="glyphicon glyphicon-th"></i>
					<span>商品管理</span>
				</a>
				<ul class="dropdown-menu">
					<li>
						<a href="<?php echo site_url('product/product/select_category');?>">
							添加商品
						</a>
					</li>
					<li>
						<a href="<?php echo site_url('product/product');?>">
							所有商品
						</a>
					</li>
					<li>
						<a href="<?php echo site_url('product/product?status=1');?>">
							售中商品
						</a>
					</li>
					<li>
						<a href="<?php echo site_url('product/product?status=0');?>">
							仓库中商品
						</a>
					</li>
					<li>
						<a href="<?php echo site_url('product/product?invalid=1');?>">
							永久下架
						</a>
					</li>
					<li>
						<a href="<?php echo site_url('product/product?time=1');?>">
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
						<a href="<?php echo site_url('order/orders');?>">
							所有订单
						</a>
					</li>
					<li>
						<a href="<?php echo site_url('order/orders?order_status=').$this->config->get_config('default_order_status');?>">
							待付款订单
						</a>
					</li>
					<li>
						<a href="<?php echo site_url('order/orders?order_status=').$this->config->get_config('to_be_delivered');?>">
							待发货订单
						</a>
					</li>
					<li>
						<a href="<?php echo site_url('order/orders?order_status=').$this->config->get_config('inbound_state');?>">
							待收货订单
						</a>
					</li>
					<li>
						<a href="<?php echo site_url('order/orders?order_status=').$this->config->get_config('state_to_be_evaluated');?>">
							待评价订单
						</a>
					</li>
					<li>
						<a href="<?php echo site_url('order/orders?order_status=').$this->config->get_config('order_completion_status');?>">
							交易成功订单
						</a>
					</li>
					<li>
						<a href="<?php echo site_url('order/orders?order_status=').$this->config->get_config('refund_order');?>">
							退款中订单
						</a>
					</li>
					<li>
						<a href="<?php echo site_url('order/orders?order_status=').$this->config->get_config('refund_order_success');?>">
							退款成功的订单
						</a>
					</li>
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
						<a href="<?php echo site_url('product/review');?>">
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
						<a href="<?php echo site_url('product/category');?>">
							分类管理
						</a>
					</li>
					<li>
						<a href="<?php echo site_url('product/manufacturer');?>">
							品牌申请
						</a>
					</li>
					<li>
						<a href="<?php echo site_url('product/freight');?>">
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
						<a href="<?php echo site_url('common/setting');?>">
							网站设置
						</a>
					</li>
					<li>
						<a href="<?php echo site_url('information/information');?>">
							文章管理
						</a>
					</li>
					<li>
						<a href="<?php echo site_url('information/information_category');?>">
							文章分类
						</a>
					</li>
					<li>
						<a href="<?php echo site_url('report/reports');?>">
							数据报表
						</a>
					</li>
					<li>
						<a href="login.html">
							数据库备份/恢复
						</a>
					</li>
					<li>
						<a href="signup.html">
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

	<div id="mobile-menu" class="well">
		<ul>
			<li class="text-center" style="width: 20%"><a href="<?php echo base_url();?>"><i class="glyphicon glyphicon-home"></i>首页</a></li>
			<li class="text-center" style="width: 20%"><a href="<?php echo base_url();?>"><i class="glyphicon glyphicon-ok"></i>订单</a></li>
			<li class="text-center" style="width: 20%"><a href="common/mobile_nav.html"><i class="glyphicon glyphicon-th"></i>商品</a></li>
			<li class="text-center" style="width: 20%"><a href="user/wecome.html"><i class="glyphicon glyphicon-repeat"></i>退换</a></li>
			<li class="text-center" style="width: 20%"><a href="user/wecome.html"><i class="glyphicon glyphicon-tree-deciduous"></i>社区</a></li>
		</ul>
	</div>

</div>
<div id="content">