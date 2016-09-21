<body>
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
					
					<?php echo $cart_module;?>
					<li><a href="#"><i class="glyphicon glyphicon-star"></i><?php echo lang_line('favorites');?><span class="badge">42</span></a></li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-briefcase"></i><?php echo lang_line('business');?><span class="badge">42</span></a>
						<ul class="dropdown-menu">
							<li>
								<a target="_black" href="user/new_store.html"><?php echo lang_line('business_in');?></a>
							</li>
							<li>
								<a target="_blank" href="admin.php/order/orders.html"><?php echo lang_line('goods_sold');?></a>
							</li>
							<li>
								<a target="_blank" href="admin.php/product/product.html"><?php echo lang_line('sale_goods');?></a>
							</li>
						</ul>
					</li>
					<li class="dropdown megamenu-fw">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-globe"></i><?php echo lang_line('site_map');?></a>
						<ul class="dropdown-menu megamenu-content" role="menu">
							<li>
								<div class="col-menu col-md-3">
									<h6 class="title"><?php echo lang_line('self');?></h6>
									<ul class="menu-col">
										<li>
											<a href="user/forget.html"><?php echo lang_line('forget');?></a>
										</li>
										<li>
											<a href="user/new_store.html"><?php echo lang_line('business_in');?></a>
										</li>
									</ul>
								</div>
								<!-- end col-3 -->
								<div class="col-menu col-md-3">
									<h6 class="title">热门分类</h6>
									<ul class="menu-col">
										<?php if($categorys):?>
											<?php foreach($categorys as $category):?>
											<li>
												<a href="product/category.html?id=<?php echo $category['category_id'];?>"><?php echo $category['name'];?></a>
											</li>
											<?php endforeach;?>
											<?php endif;?>
									<li><a href="product/category/category_all.html">所有分类</a></li>
									</ul>
								</div>
								<!-- end col-3 -->
								<div class="col-menu col-md-3">
									<h6 class="title">热门品牌</h6>
									<ul class="menu-col">
										<?php if($manufacturers):?>
										<?php foreach($manufacturers as $manufacturer):?>
										<li>
											<a href="#"><?php echo $manufacturer['name'];?>u</a>
										</li>
										<?php endforeach;?>
										<?php endif;?>
										<li><a href="product/manufacturer/manufacturer_all.html">所有品牌</a></li>
									</ul>
								</div>
								<div class="col-menu col-md-3">
                                	<?php if($nav_infomation):?>
                                    <h6 class="title"><?php echo $nav_infomation['name'];?></h6>
                                    <?php if($nav_infomation['informations']):?>
                                        <ul class="menu-col">
                                        	<?php foreach($nav_infomation['informations'] as $information):?>
                                            <li>
											<a
												href="helper/faq.html?inforation_id=<?php echo $information['information_id'];?>#inforation-<?php echo $information['information_id'];?>"><?php echo $information['title'];?></a>
										</li>
                                            <?php endforeach;?>
                                        </ul>
                                    <?php endif;?>
                                    <?php endif;?>
                                </div>
								<!-- end col-3 -->
							</li>
						</ul>
					</li>
					<!--如果已经登陆不显示-->
					<?php if($this->user->isLogged()):?>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo utf8_substr($this->user->getnickname(), 0, 8);?><span class="badge">14</span>
						</a>
						<ul class="dropdown-menu">
							<li>
								<a href="<?php echo site_url('user');?>"><?php echo lang_line('news');?><span class="badge">14</span></a>
							</li>
							<li>
								<a href="<?php echo site_url('user');?>"><?php echo lang_line('user_center');?></a>
							</li>
							<?php if(isset($access_admin)):?>
							<li>
								<a onclick="window.open('<?php echo $url_admin;?>');"><?php echo lang_line('control_center');?></a>
							</li>
							<?php endif;?>
							<?php if(isset($access_sale)):?>
							<li>
								<a onclick="window.open('<?php echo $url_sale;?>');"><?php echo lang_line('merchant_center');?></a>
							</li>
							<?php endif;?>
							<li>
								<a onclick="logout();"><?php echo lang_line('sign_out');?></a>
							</li>
						</ul>
					</li>
					<?php endif;?>
				</ul>
			</div><!-- /.navbar-collapse -->
		</div>    
	</nav>
	<!-- End Navigation -->
	<?php echo $position_above;?>
	<!-- Start Navigation -->
	<nav class="navbar navbar-default bootsnav on menu-center no-full navbar-sticky hidden-xs" id="nav-menu">
		<!-- Start Top Search -->
		<div class="top-search">
				<div class="container">
					<form action="product/category.html" method="get" id="openant-search">
						<div class="input-group">
							<div class="input-group-btn">
								<button type="button" class="btn btn-style dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo lang_line('commodity');?><span class="caret" style="margin-left: 5px;"></span>
								</button>
								<ul class="dropdown-menu" style="left: 0; right: auto;">
									<li data-href="<?php echo site_url('product/category')?>"><a><?php echo lang_line('commodity');?></a></li>
									<li data-href="<?php echo site_url('store')?>"><a><?php echo lang_line('store');?></a></li>
									<li data-href="<?php echo site_url('helper/faq')?>"><a><?php echo lang_line('helper');?></a></li>
								</ul>
							</div>
							<!-- /btn-group -->
							<input type="text" class="form-control" name="search" value="<?php echo !empty($action_search) ? $action_search : '';?>" placeholder="<?php echo lang_line('search');?>">
							<?php if(!empty($action_id)):?>
							<input type="hidden" name="id" value="<?php echo $action_id;?>">
							<?php endif;?>
							<span class="input-group-addon close-search"><i class="glyphicon glyphicon-remove"></i></span>
						</div>
						<!-- /input-group -->
					</form>
				</div>
			</div>
		<!-- End Top Search -->
		<div class="container">  
			<div class="attr-nav">
				<ul>
					<li class="search"><a href="#"><i class="glyphicon glyphicon-search"></i></a></li>
				</ul>
			</div>       
			<!-- Start Header Navigation -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu"><i class="glyphicon glyphicon-menu-hamburger"></i></button>
			</div>
			<!-- End Header Navigation -->

			<!-- Collect the nav links, forms, and other content for toggling -->
             
			<div id="navbar-menu" class="navbar-collapse collapse">
				<ul class="nav navbar-nav navbar-left category-menu">
					<li><a href="<?php echo site_url('user');?>"><strong>个人中心</strong></a></li>
					<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">订单管理<?php echo isset($count_sum) ? '<span class="badge">'.$count_sum.'</span>' : '';?></a>
						<ul class="dropdown-menu">
							<li><a href="user/orders.html?page=0&order_status=<?php echo $this->config->get_config('default_order_status');?>">侍付款订单<?php echo isset($count_default_order) ? '<span class="badge">'.$count_default_order.'</span>' : '';?></a></li>
							<li><a href="user/orders.html?page=0&order_status=<?php echo $this->config->get_config('to_be_delivered');?>">侍发货订单<?php echo isset($count_to_be_delivered) ? '<span class="badge">'.$count_to_be_delivered.'</span>' : '';?></a></li>
							<li><a href="user/orders.html?page=0&order_status=<?php echo $this->config->get_config('inbound_state');?>">侍收货订单<?php echo isset($count_inbound_state) ? '<span class="badge">'.$count_inbound_state.'</span>' : '';?></a></li>
							<li><a href="user/orders.html?page=0&order_status=<?php echo $this->config->get_config('state_to_be_evaluated');?>">侍评价订单<?php echo isset($count_to_be_evaluated) ? '<span class="badge">'.$count_to_be_evaluated.'</span>' : '';?></a></li>
							<li><a href="user/orders.html?page=0&order_status=<?php echo $this->config->get_config('order_completion_status');?>">交易成功的订单</a></li>
							<li><a href="user/orders.html">所有订单</a></li>
						</ul>
					</li>
					<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">优惠信息<span class="badge">42</span></a>
						<ul class="dropdown-menu">
							<li><a href="#">平台优惠券</a></li>
							<li><a href="#">商家优惠券</a></li>
							<li><a href="#">打折市场</a></li>
							<li><a href="#">优惠预告</a></li>
						</ul>
					</li>
					<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">历史记录<span class="badge">42</span></a>
						<ul class="dropdown-menu">
							<li><a href="user/my_tracks.html">我的足迹</a></li>
							<li><a href="#">操作记录</a></li>
							<li><a href="#">其它交易</a></li>
						</ul>
					</li>
					<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">退款维权<?php echo isset($count_refund_order) ? '<span class="badge">'.$count_refund_order.'</span>' : '';?></a>
						<ul class="dropdown-menu">
							<li><a href="user/orders.html?page=0&order_status=<?php echo $this->config->get_config('refund_order');?>">退款中订单<?php echo isset($count_refund_order) ? '<span class="badge">'.$count_refund_order.'</span>' : '';?></a></li>
							<li><a href="user/orders.html?page=0&order_status=<?php echo $this->config->get_config('refund_order_success');?>">退款成功的订单</a></li>
							<li><a href="helper/faq.html?information_id=<?php echo $this->config->get_config('return_terms');?>">退换货规则</a></li>
						</ul>
					</li>
					<li class="dropdown megamenu-fw">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">帐户设置</a>
						<ul class="dropdown-menu megamenu-content" role="menu">
							<li>
								<div class="row">
									<div class="col-menu col-md-4">
										<h6 class="title">安全设置</h6>
											<ul class="menu-col">
												<li><a href="<?php echo site_url('user/edit/edit_paswd');?>">修改登陆密码</a></li>
												<li><a href="<?php echo site_url('user/edit/edit_user_info');?>">修改个人信息</a></li>
												<li><a href="<?php echo site_url('user/edit/edit_pay_password');?>">修改支付密码</a></li>
											</ul>
									</div><!-- end col-3 -->
									<div class="col-menu col-md-4">
										<h6 class="title">个人资料</h6>
											<ul class="menu-col">
												<li><a href="<?php echo site_url('user/address');?>">地址管理</a></li>
												<li><a href="<?php echo site_url('user/edit/edit_avatar');?>">修改头像</a></li>
												<li><a href="<?php echo site_url('user/edit/edit_message_notification');?>">消息提醒设置</a></li>
											</ul>
									</div><!-- end col-3 -->
									<div class="col-menu col-md-4">
										<h6 class="title">帐号绑定</h6>
											<ul class="menu-col">
												<li><a href="<?php echo site_url('user/edit/edit_account_binding');?>">第三方登陆帐号绑定</a></li>
											</ul>
									</div><!-- end col-3 -->
								</div><!-- end row -->
							</li>
						</ul>
					</li>
					<li><a href="<?php echo site_url('user');?>">消息</a></li>
					<!-- Start Atribute Navigation -->
					<!-- End Atribute Navigation -->
				</ul>
			</div><!-- /.navbar-collapse -->
		</div>
	</nav>
	<!-- End Navigation -->
	
	<div id="mobile-menu" class="well">
		<ul>
			<li class="text-center" style="width: 20%"><a href="<?php echo base_url();?>"><i class="glyphicon glyphicon-home"></i>首页</a></li>
			<li class="text-center" style="width: 20%"><a href="<?php echo base_url();?>"><i class="glyphicon glyphicon-briefcase"></i>商城</a></li>
			<li class="text-center" style="width: 20%"><a href="<?php echo base_url();?>"><i class="glyphicon glyphicon-ok"></i>订单</a></li>
			<li class="text-center" style="width: 20%"><a href="common/mobile_nav.html"><i class="glyphicon glyphicon-repeat"></i>退换</a></li>
			<li class="text-center" style="width: 20%"><a href="user/wecome.html"><i class="glyphicon glyphicon-user"></i>我的</a></li>
		</ul>
	</div>

</div>
<div id="content">