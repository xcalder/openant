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
					
					<?php echo $cart_module;?>
					<li><a href="<?php echo $this->config->item('catalog').'/user/wishlist';?>"><i class="glyphicon glyphicon-star"></i><?php echo lang_line('favorites');?><span id="wishlist-count" class="badge"><?php echo $wishlist_count;?></span></a></li>
					
					<?php if(!isset($access_sale)):?>
					<li><a target="_black" href="<?php echo $this->config->item('catalog').'/user/new_store';?>" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-briefcase"></i><?php echo lang_line('business_in');?></a></li>
					<?php endif;?>
					
					<li class="dropdown megamenu-fw">
						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-globe"></i><?php echo lang_line('site_map');?></a>
						<ul class="dropdown-menu megamenu-content" role="menu">
							<li>
								<div class="col-menu col-md-3">
									<h6 class="title"><?php echo lang_line('self');?></h6>
									<ul class="menu-col">
										<li>
											<a href="<?php echo $this->config->item('catalog').'/user/forget';?>"><?php echo lang_line('forget');?></a>
										</li><hr>
										<li>
											<a href="<?php echo $this->config->item('catalog').'/user/new_store';?>"><?php echo lang_line('business_in');?></a>
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
												<a href="<?php echo $this->config->item('catalog').'/product/category?id='.$category['category_id'];?>"><?php echo $category['name'];?></a>
											</li><hr>
											<?php endforeach;?>
											<?php endif;?>
									<li><a href="<?php echo $this->config->item('catalog').'/product/category/category_all';?>">所有分类</a></li>
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
										</li><hr>
										<?php endforeach;?>
										<?php endif;?>
										<li><a href="<?php echo $this->config->item('catalog').'/product/manufacturer/manufacturer_all';?>">所有品牌</a></li>
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
												href="<?php echo $this->config->item('catalog').'/helper/faq?inforation_id='.$information['information_id'];?>#inforation-<?php echo $information['information_id'];?>"><?php echo $information['title'];?></a>
											</li><hr>
                                            <?php endforeach;?>
                                        </ul>
                                    <?php endif;?>
                                    <?php endif;?>
                                </div>
								<!-- end col-3 -->
							</li>
						</ul>
					</li>
					<li><a href="<?php echo $this->config->item('bbs');?>"><i class="glyphicon glyphicon-tree-deciduous"></i><?php echo lang_line('community');?></a></li>
					<!--如果已经登陆不显示-->
					<?php if($this->user->isLogged()):?>
					<li class="dropdown">
						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"><?php echo utf8_substr($this->user->getnickname(), 0, 8);?><span class="badge"><?php echo $activity_count;?></span>
						</a>
						<ul class="dropdown-menu">
							<li>
								<a href="<?php echo $this->config->item('catalog').'/user/notice';?>"><?php echo lang_line('news');?><span class="badge"><?php echo $activity_count;?></span></a>
							</li>
							<li>
								<a href="<?php echo $this->config->item('catalog').'/user';?>"><?php echo lang_line('user_center');?></a>
							</li>
							<?php if(!isset($access_sale)):?>
							<li><a target="_black" href="<?php $this->config->item('catalog').'/user/new_store';?>" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-briefcase"></i><?php echo lang_line('business_in');?></a></li>
							<?php endif;?>
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
					<form action="product/category" method="get" id="openant-search">
						<div class="input-group">
							<div class="input-group-btn">
								<button type="button" class="btn btn-style dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo lang_line('commodity');?><span class="caret" style="margin-left: 5px;"></span>
								</button>
								<ul class="dropdown-menu" style="left: 0; right: auto;">
									<li data-href="<?php echo $this->config->item('catalog').'/product/category'?>"><a><?php echo lang_line('commodity');?></a></li>
									<li data-href="<?php echo $this->config->item('catalog').'/store'?>"><a><?php echo lang_line('store');?></a></li>
									<li data-href="<?php echo $this->config->item('catalog').'/helper/faq'?>"><a><?php echo lang_line('helper');?></a></li>
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
			
			<div id="navbar-menu" class="navbar-collapse collapse">
				<ul class="nav navbar-nav navbar-left category-menu">
					<li><a href="<?php echo $this->config->item('catalog').'user';?>"><strong>个人中心</strong></a></li>
					<li class="dropdown"><a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">订单管理<?php echo isset($count_sum) ? '<span class="badge">'.$count_sum.'</span>' : '';?></a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo $this->config->item('catalog').'/user/orders?page=0&order_status='.$this->config->get_config('default_order_status');?>">侍付款订单<?php echo isset($count_default_order) ? '<span class="badge">'.$count_default_order.'</span>' : '';?></a></li>
							<li><a href="<?php echo $this->config->item('catalog').'/user/orders?page=0&order_status='.$this->config->get_config('to_be_delivered');?>">侍发货订单<?php echo isset($count_to_be_delivered) ? '<span class="badge">'.$count_to_be_delivered.'</span>' : '';?></a></li>
							<li><a href="<?php echo $this->config->item('catalog').'/user/orders?page=0&order_status='.$this->config->get_config('inbound_state');?>">侍收货订单<?php echo isset($count_inbound_state) ? '<span class="badge">'.$count_inbound_state.'</span>' : '';?></a></li>
							<li><a href="<?php echo $this->config->item('catalog').'/user/orders?page=0&order_status='.$this->config->get_config('state_to_be_evaluated');?>">侍评价订单<?php echo isset($count_to_be_evaluated) ? '<span class="badge">'.$count_to_be_evaluated.'</span>' : '';?></a></li>
							<li><a href="<?php echo $this->config->item('catalog').'/user/orders?page=0&order_status='.$this->config->get_config('order_completion_status');?>">交易成功的订单</a></li>
							<li><a href="<?php echo $this->config->item('catalog').'/user/orders?page=0&order_status='.$this->config->get_config('refund_order');?>">退款中订单<?php echo isset($count_refund_order) ? '<span class="badge">'.$count_refund_order.'</span>' : '';?></a></li>
							<li><a href="<?php echo $this->config->item('catalog').'/user/orders?page=0&order_status='.$this->config->get_config('refund_order_success');?>">退款成功的订单</a></li>
							<li><a href="<?php echo $this->config->item('catalog').'/user/orders';?>">所有订单</a></li>
						</ul>
					</li>
					<li class="dropdown"><a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">优惠信息<span class="badge">42</span></a>
						<ul class="dropdown-menu">
							<li><a href="#">平台优惠券</a></li>
							<li><a href="#">商家优惠券</a></li>
							<li><a href="#">打折市场</a></li>
							<li><a href="#">优惠预告</a></li>
						</ul>
					</li>
					<li class="dropdown"><a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">历史记录<span class="badge">42</span></a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo $this->config->item('catalog').'/user/my_tracks';?>">我的足迹</a></li>
							<li><a href="#">操作记录</a></li>
							<li><a href="#">其它交易</a></li>
						</ul>
					</li>
					<li class="dropdown"><a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">退款维权<?php echo isset($count_refund_order) ? '<span class="badge">'.$count_refund_order.'</span>' : '';?></a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo $this->config->item('catalog').'/user/returned/returned_list';?>">退款商品</a></li>
							<li><a href="<?php echo $this->config->item('catalog').'/helper/faq?information_id='.$this->config->get_config('return_terms');?>">退换货规则</a></li>
						</ul>
					</li>
					<li class="dropdown megamenu-fw">
						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">帐户设置</a>
						<ul class="dropdown-menu megamenu-content" role="menu">
							<li>
								<div class="row">
									<div class="col-menu col-md-4">
										<h6 class="title">安全设置</h6>
											<ul class="menu-col">
												<li><a href="<?php echo $this->config->item('catalog').'/user/edit/edit_paswd';?>">修改登陆密码</a></li>
												<li><a href="<?php echo $this->config->item('catalog').'/user/edit/edit_user_info';?>">修改个人信息</a></li>
												<li><a href="<?php echo $this->config->item('catalog').'/user/edit/edit_pay_password';?>">修改支付密码</a></li>
											</ul>
									</div><!-- end col-3 -->
									<div class="col-menu col-md-4">
										<h6 class="title">个人资料</h6>
											<ul class="menu-col">
												<li><a href="<?php echo $this->config->item('catalog').'/user/address';?>">地址管理</a></li>
												<li><a href="<?php echo $this->config->item('catalog').'/user/edit/edit_avatar';?>">修改头像</a></li>
												<li><a href="<?php echo $this->config->item('catalog').'/user/edit/edit_message_notification';?>">消息提醒设置</a></li>
											</ul>
									</div><!-- end col-3 -->
									<div class="col-menu col-md-4">
										<h6 class="title">帐号绑定</h6>
											<ul class="menu-col">
												<li><a href="<?php echo $this->config->item('catalog').'/user/edit/edit_account_binding';?>">第三方登陆帐号绑定</a></li>
											</ul>
									</div><!-- end col-3 -->
								</div><!-- end row -->
							</li>
						</ul>
					</li>
					<li><a href="<?php echo $this->config->item('catalog').'/user';?>">消息</a></li>
					<!-- Start Atribute Navigation -->
					<!-- End Atribute Navigation -->
				</ul>
			</div><!-- /.navbar-collapse -->
		</div>
	</nav>
	<!-- End Navigation -->
	<script type="text/javascript">
		$('#search').placeholderTypewriter({
			text: ["www.openant.com/bbs.php", "蚂蚁开源论坛", "如果你有什么问题？", "可以在这里得到解答", "用简单的方式描述它"]
		});
	</script>
	<div id="mobile-menu" class="well">
		<ul>
			<li class="text-center" style="width: 20%"><a href="<?php echo base_url();?>"><i class="glyphicon glyphicon-home"></i>首页</a></li>
			<li class="text-center" style="width: 20%"><a href="<?php echo base_url();?>"><i class="glyphicon glyphicon-briefcase"></i>商城</a></li>
			<li class="text-center" style="width: 20%"><a href="<?php echo base_url();?>"><i class="glyphicon glyphicon-ok"></i>订单</a></li>
			<li class="text-center" style="width: 20%"><a href="<?php echo $this->config->item('catalog').'/common/mobile_nav';?>"><i class="glyphicon glyphicon-repeat"></i>退换</a></li>
			<li class="text-center" style="width: 20%"><a href="<?php echo $this->config->item('catalog').'/user/wecome';?>"><i class="glyphicon glyphicon-user"></i>我的</a></li>
		</ul>
	</div>

</div>
<div id="content">