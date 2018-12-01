<body id=<?php echo $css;?>>
<div id="header">
	<!-- Start Navigation -->
	<nav class="navbar center-side bootsnav hidden-xs" style="z-index: 10" id="nav-top">
		<div class="container">
			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="navbar-menu-top">
				<ul class="nav navbar-nav navbar-left" data-in="fadeInDown" data-out="fadeOutUp">
					<li><a class="navbar-brand navbar-brand-logo" href="<?php echo base_url();?>" title="<?php echo unserialize($this->config->get_config('site_abbreviation'))[$_SESSION['language_id']];?>"><img width="46px" height="46px" data-original="<?php echo $this->config->get_config('site_image') !== FALSE ? $this->image_common->resize($this->config->get_config('site_image'), 46, 46, 'h') : 'resources/public/resources/default/image/logo-menu.jpg';?>" class="lazy" alt="<?php echo unserialize($this->config->get_config('site_abbreviation'))[$_SESSION['language_id']]?>"></a></li>
					<?php echo $language;?>
					<?php echo $currency;?>
					
				</ul>
				<form class="navbar-form navbar-left" role="search" action="product/category" method="get" id="openant-search">
					<div class="input-group input-group-sm">
					  <span class="input-group-addon">插件</span>
					  <input type="text" class="form-control" name="search" id="search" value="<?php echo !empty($action_search) ? $action_search : '';?>">
					</div>
				</form>
				
				<ul class="nav navbar-nav navbar-right" data-in="fadeInDown" data-out="fadeOutUp">
					
					<li class="dropdown"><a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-briefcase"></i><?php echo lang_line('business');?></a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo $this->config->item('admin');?>/order/orders">已售商品</a></li>
							<li><a href="<?php echo $this->config->item('admin');?>/product/product">售中商品</a></li>
						</ul>
					</li>
					<li><a target="_black" href="<?php echo $this->config->item('bbs');?>"><i class="glyphicon glyphicon-tree-deciduous"></i>论坛</a></li>
					<li class="dropdown megamenu-fw">
						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-globe"></i>站点地图</a>
						<ul class="dropdown-menu megamenu-content" role="menu">
							<li>
								<div class="row">
									<div class="col-menu col-md-3">
										<h6 class="title">Title Menu One</h6>
											<ul class="menu-col">
												<li><a href="#">Custom Menu</a></li>
												<li><a href="#">Custom Menu</a></li>
												<li><a href="#">Custom Menu</a></li>
												<li><a href="#">Custom Menu</a></li>
												<li><a href="#">Custom Menu</a></li>
												<li><a href="#">Custom Menu</a></li>
											</ul>
									</div><!-- end col-3 -->
									<div class="col-menu col-md-3">
										<h6 class="title">Title Menu One</h6>
											<ul class="menu-col">
												<li><a href="#">Custom Menu</a></li>
												<li><a href="#">Custom Menu</a></li>
												<li><a href="#">Custom Menu</a></li>
												<li><a href="#">Custom Menu</a></li>
												<li><a href="#">Custom Menu</a></li>
												<li><a href="#">Custom Menu</a></li>
											</ul>
									</div><!-- end col-3 -->
									<div class="col-menu col-md-3">
										<h6 class="title">Title Menu One</h6>
											<ul class="menu-col">
												<li><a href="#">Custom Menu</a></li>
												<li><a href="#">Custom Menu</a></li>
												<li><a href="#">Custom Menu</a></li>
												<li><a href="#">Custom Menu</a></li>
												<li><a href="#">Custom Menu</a></li>
												<li><a href="#">Custom Menu</a></li>
											</ul>
									</div><!-- end col-3 -->
									<div class="col-menu col-md-3">
                                    	<?php if($nav_infomation):?>
                                        <h6 class="title"><?php echo $nav_infomation['name'];?></h6>
                                        <?php if($nav_infomation['informations']):?>
                                            <ul class="menu-col">
                                            	<?php foreach($nav_infomation['informations'] as $information):?>
                                                <li><a href="helper/faq?inforation_id=<?php echo $information['information_id'];?>#inforation-<?php echo $information['information_id'];?>"><?php echo $information['title'];?></a></li>
                                                <?php endforeach;?>
                                            </ul>
                                        <?php endif;?>
                                        <?php endif;?>
                                    </div><!-- end col-3 -->
								</div><!-- end row -->
							</li>
						</ul>
					</li>
					<!--如果已经登陆不显示-->
					<?php if($this->user->isLogged()):?>
					<!--如果没有登陆不显示-->
					<li class="dropdown"><a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-user"></i><?php echo utf8_substr($this->user->getnickname(), 0, 8);?><span class="badge"><?php echo $activity_count;?></span></a>
						<ul class="dropdown-menu">
							<li><a href="user/notice">消息<span class="badge"><?php echo $activity_count;?></span></a></li>
							<li><a href="user">个人中心</a></li>
							<?php if(isset($access_admin)):?>
							<li><a onclick="window.open('<?php echo $url_admin;?>');">进入内网</a></li>
							<?php endif;?>
							<?php if(isset($access_sale)):?>
							<li><a onclick="window.open('<?php echo $url_sale;?>');">卖家中心</a></li>
							<?php endif;?>
							<li><a href="#">我的订单</a></li>
							<li><a href="#">我的足迹</a></li>
							<li><a onclick="logout();">退出帐号</a></li>
						</ul>
					</li>
					<?php endif;?>
				</ul>
			</div><!-- /.navbar-collapse -->
		</div>    
	</nav>
	<!-- End Navigation -->
	<?php echo $position_above;?>
	<nav class="navbar navbar-default bootsnav on menu-center no-full navbar-sticky hidden-xs" id="nav-menu">
		<div class="container">
			
			<div id="navbar-menu" class="navbar-collapse collapse">
				<ul class="nav navbar-nav navbar-left category-menu">
					<li>
						<a href="<?php echo $this->config->item('admin');?>" title="lvxingto">
							管理中心
						</a>
					</li>
					<li class="dropdown"> 
						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
							<i class="glyphicon glyphicon-th"></i>
							<span>
								商品维护
							</span>
						</a>
						<ul class="dropdown-menu">
							<li>
								<a href="<?php echo $this->config->item('admin').'/product/category';?>">
									分类管理
								</a>
							</li>
							<li>
								<a href="<?php echo $this->config->item('admin').'/product/product';?>">
									商品管理
								</a>
							</li>
							<li>
								<a href="<?php echo $this->config->item('admin').'/product/download';?>">
									下载商品
								</a>
							</li>
							<li>
								<a href="<?php echo $this->config->item('admin').'/product/attribute';?>">
									属性维护
								</a>
							</li>
							<li>
								<a href="<?php echo $this->config->item('admin').'/product/option';?>">
									选项维护
								</a>
							</li>
							<li>
								<a href="<?php echo $this->config->item('admin').'/product/manufacturer';?>">
									品牌维护
								</a>
							</li>
							<li>
								<a href="<?php echo $this->config->item('admin').'/product/barcode';?>">
									条码维护
								</a>
							</li>
							<li>
								<a href="<?php echo $this->config->item('admin').'/product/review';?>">
									评价管理
								</a>
							</li>
							<li>
								<a href="<?php echo $this->config->item('admin').'/product/freight';?>">
									运费模板
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
								<a href="<?php echo $this->config->item('admin').'/order/orders';?>">
									所有订单
								</a>
							</li>
							<li>
								<a href="<?php echo $this->config->item('admin').'/order/orders?order_status='.$this->config->get_config('default_order_status');?>">
									待付款订单
								</a>
							</li>
							<li>
								<a href="<?php echo $this->config->item('admin').'/order/orders?order_status='.$this->config->get_config('to_be_delivered');?>">
									待发货订单
								</a>
							</li>
							<li>
								<a href="<?php echo $this->config->item('admin').'/order/orders?order_status='.$this->config->get_config('inbound_state');?>">
									待收货订单
								</a>
							</li>
							<li>
								<a href="<?php echo $this->config->item('admin').'/order/orders?order_status='.$this->config->get_config('state_to_be_evaluated');?>">
									待评价订单
								</a>
							</li>
							<li>
								<a href="<?php echo $this->config->item('admin').'/order/orders?order_status='.$this->config->get_config('order_completion_status');?>">
									交易成功订单
								</a>
							</li>
							<li>
								<a href="<?php echo $this->config->item('admin').'/order/orders?order_status='.$this->config->get_config('refund_order');?>">
									退款中订单
								</a>
							</li>
							<li>
								<a href="<?php echo $this->config->item('admin').'/order/orders?order_status='.$this->config->get_config('refund_order_success');?>">
									退款成功的订单
								</a>
							</li>
							<li>
								<a href="<?php echo $this->config->item('admin').'/order/returned';?>">
									退款商品列表
								</a>
							</li>
							<li>
								<a href="<?php echo $this->config->item('admin').'/order/returned?status_id='.$this->config->get_config('intervention');?>">
									平台介入退款商品
								</a>
							</li>
						</ul>
					</li>
					<li class="dropdown">
						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
							<i class=" glyphicon glyphicon-user">
							</i>
							<span>
								会员管理
							</span>
						</a>
						<ul class="dropdown-menu">
							<li>
								<a href="<?php echo $this->config->item('admin').'/user/user';?>">
									会员列表
								</a>
							</li>
							<li>
								<a href="<?php echo $this->config->item('admin').'/user/user_group';?>">
									权限组
								</a>
							</li>
							<li>
								<a href="<?php echo $this->config->item('admin').'/user/user_class';?>">
									买家组
								</a>
							</li>
							<li>
								<a href="<?php echo $this->config->item('admin').'/user/user_online';?>">
									在线会员
								</a>
							</li>
							<li>
								<a href="<?php echo $this->config->item('admin').'/user/user_activity';?>">
									会员活动
								</a>
							</li>
							<li>
								<a href="<?php echo $this->config->item('admin').'/user/user_manager/user_reward';?>">
									会员积分
								</a>
							</li>
						</ul>
					</li>
					<li class="dropdown">
						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
							<i class="glyphicon glyphicon-briefcase">
							</i>
							<span>
								商家管理
							</span>
						</a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo $this->config->item('admin').'/sale/sale_class';?>">商家组</a></li>
							<li><a href="<?php echo $this->config->item('admin').'/sale/sale';?>">商家列表</a></li>
							<li><a href="<?php echo $this->config->item('admin').'/sale/check';?>">审核列表</a></li>
						</ul>
					</li>
					<li class="dropdown">
						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
							<i class="glyphicon glyphicon-wrench">
							</i>
							<span>
								布局插件
							</span>
						</a>
						<ul class="dropdown-menu">
							<li>
								<a href="<?php echo $this->config->item('admin').'/common/layout';?>">
									插件
								</a>
							</li>
							<li>
								<a href="<?php echo $this->config->item('admin').'/common/extension/module';?>">
									扩展模块
								</a>
							</li>
							<li>
								<a href="<?php echo $this->config->item('admin').'/common/extension/payment';?>">
									支付管理
								</a>
							</li>
							<li>
								<a href="<?php echo $this->config->item('admin').'/common/extension/delivery';?>">
									配送管理
								</a>
							</li>
							<li>
								<a href="<?php echo $this->config->item('admin').'/common/extension/overall';?>">
									全局模块
								</a>
							</li>
							<li>
								<a href="<?php echo $this->config->item('admin').'/common/extension/sign_in_with';?>">
									第三方登陆
								</a>
							</li>
							<li>
								<a href="<?php echo $this->config->item('admin').'/common/layout';?>">
									布局管理
								</a>
							</li>
							<li>
								<a href="<?php echo $this->config->item('admin').'/common/banner';?>">
									Banner管理
								</a>
							</li>
						</ul>
					</li>
					<li class="dropdown">
						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
							<i class="glyphicon glyphicon-dashboard">
							</i>
							<span>
								参数设置
							</span>
						</a>
						<ul class="dropdown-menu">
							<li>
								<a href="<?php echo $this->config->item('admin').'/localisation/language';?>">
									语言设置
								</a>
							</li>
							<li>
								<a href="<?php echo $this->config->item('admin').'/localisation/currency';?>">
									货币设置
								</a>
							</li>
							<li>
								<a href="<?php echo $this->config->item('admin').'/localisation/stock_status';?>">
									发货时间
								</a>
							</li>
							<li>
								<a href="<?php echo $this->config->item('admin').'/localisation/order_status';?>">
									订单状态
								</a>
							</li>
							<li>
								<a href="<?php echo $this->config->item('admin').'/localisation/return_status';?>">
									退换状态
								</a>
							</li>
							<li>
								<a href="<?php echo $this->config->item('admin').'/localisation/aftermarket';?>">
									售后保障
								</a>
							</li>
							<li>
								<a href="<?php echo $this->config->item('admin').'/localisation/return_action';?>">
									退换事件
								</a>
							</li>
							<li>
								<a href="<?php echo $this->config->item('admin').'/localisation/return_reason';?>">
									退换原因
								</a>
							</li>
							<li>
								<a href="<?php echo $this->config->item('admin').'/localisation/return_mode';?>">
									退款方式
								</a>
							</li>
							<li>
								<a href="<?php echo $this->config->item('admin').'/localisation/mode_transport';?>">
									运输方式
								</a>
							</li>
							<li>
								<a href="<?php echo $this->config->item('admin').'/localisation/tax_class';?>">
									税费组
								</a>
							</li>
							<li>
								<a href="<?php echo $this->config->item('admin').'/localisation/tax_rate';?>">
									税费税率
								</a>
							</li>
							<li>
								<a href="<?php echo $this->config->item('admin').'/localisation/length_class';?>">
									长度单位
								</a>
							</li>
							<li>
								<a href="<?php echo $this->config->item('admin').'/localisation/weight_class';?>">
									重量单位
								</a>
							</li>
							<li>
								<a href="<?php echo $this->config->item('admin').'/localisation/country';?>">
									国家设置
								</a>
							</li>
							<li>
								<a href="<?php echo $this->config->item('admin').'/localisation/zone';?>">
									地区设置
								</a>
							</li>
							<li>
								<a href="<?php echo $this->config->item('admin').'/localisation/geo_zone';?>">
									区域设置
								</a>
							</li>
						</ul>
					</li>
					<li class="dropdown">
						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
							<i class="glyphicon glyphicon-cog">
							</i>
							<span>
								系统维护
							</span>
						</a>
						<ul class="dropdown-menu">
							<li>
								<a href="<?php echo $this->config->item('admin').'/common/setting';?>">
									网站设置
								</a>
							</li>
							<li>
								<a href="<?php echo $this->config->item('admin').'/common/competence';?>">
									权限管理
								</a>
							</li>
							<li>
								<a href="<?php echo $this->config->item('admin').'/information/information';?>">
									文章管理
								</a>
							</li>
							<li>
								<a href="<?php echo $this->config->item('admin').'/information/information_category';?>">
									文章分类
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
			<li class="text-center" style="width: 20%"><a href="<?php echo base_url();?>"><i class="glyphicon glyphicon-th"></i>商品</a></li>
			<li class="text-center" style="width: 20%"><a href="common/mobile_nav"><i class="glyphicon glyphicon-ok"></i>订单</a></li>
			<li class="text-center" style="width: 20%"><a href="user/wecome"><i class="glyphicon glyphicon-tree-deciduous"></i>论坛</a></li>
			<li class="text-center" style="width: 20%"><a href="user/wecome"><i class="glyphicon glyphicon-user"></i>商家</a></li>
		</ul>
	</div>
	
</div>
<div id="content">