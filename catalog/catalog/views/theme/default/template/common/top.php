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
						<?php if(!$this->user->isLogged()):?>
						<!--当前窗口登陆-->
						<?php if($this->config->get_config('login_window') == '1' && !$this->agent->is_mobile()):?>
						<li>
							<a onclick="mylogin('login-botton');" id="login-botton" data-toggle="modal" data-target="#mylogin" style="cursor: pointer;"><i class="glyphicon glyphicon-user"></i><?php echo lang_line('login');?></a>
						</li>
						<li>
							<a onclick="mylogin('register-botton');" id="register-botton" data-toggle="modal" data-target="#mylogin" style="cursor: pointer;"><i class="glyphicon glyphicon-pencil"></i><?php echo lang_line('register');?></a>
						</li>
						<?php else:?>
						<li>
							<a href="<?php echo $this->config->item('catalog').'/user/signin/login?url='.rawurlencode(all_current_url())?>"><i class="glyphicon glyphicon-user"></i><?php echo lang_line('login');?></a>
						</li>
						<li>
							<a href="<?php echo $this->config->item('catalog').'/user/signin/signinup'?>"><i class="glyphicon glyphicon-pencil"></i><?php echo lang_line('register');?></a>
						</li>
						<?php endif;?>
						
						<?php else:?>
						<!--如果没有登陆不显示-->
						<li class="dropdown">
							<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-user"></i><?php echo utf8_substr($this->user->getnickname(), 0, 8);?><span class="badge"><?php echo $activity_count;?></span>
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
				</div>
				<!-- /.navbar-collapse -->
			</div>
		</nav>
		<!-- End Navigation -->

		<?php echo $position_above;?>

		<!-- Start Navigation -->
		<nav class="navbar navbar-default bootsnav on menu-center no-full navbar-sticky hidden-xs" id="nav-menu">
			<div class="container">
				<div id="navbar-menu" class="navbar-collapse collapse">
					<ul class="nav navbar-nav navbar-left category-menu">
						<li>
							<a href="<?php echo $this->config->item('catalog').'/product/category';?>"><?php echo lang_line('all_product');?></a>
						</li>
						<?php if($menus):?>
						<?php foreach($menus as $menu):?>
						<?php $menu['column'] = ($menu['column'] < 1) ? '1' : $menu['column'];?>
						<?php if(isset($menu['child']) && is_array($menu['child'])):?>
						<li class="dropdown megamenu-fw">
							<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"><?php echo $menu['name'];?></a>
							<?php foreach(array_chunk($menu['child'], ceil(count($menu['child']) / $menu['column'])) as $child):?>
							<ul class="dropdown-menu megamenu-content" role="menu">
									<li class="container">
										<div class="row">
										<?php foreach($child as $child_):?>
										<div class="col-menu col-md-3">
												<div class="content">
													<ul class="menu-col">
														<li>
															<a
																href="<?php echo $this->config->item('catalog').'/product/category?id='.$menu['category_id'].'_'.$child_['category_id'];?>"><?php echo $child_['name']; ?></a>
														</li>
													</ul>
												</div>
											</div>
											<!-- end col-3 -->
										<?php endforeach; ?>
									</div>
									</li>
								</ul>
							<?php endforeach; ?>
						</li>
						<?php else:?>
						<li>
								<a
									href="<?php echo $this->config->item('catalog').'/product/category?id='.$menu['category_id'];?>"><?php echo $menu['name'];?></a>
							</li>
						<?php endif;?>
						<?php endforeach;?>
						<?php endif;?>
						<!-- Start Atribute Navigation -->
						<!-- End Atribute Navigation -->
					</ul>
				</div>
				<!-- /.navbar-collapse -->
			</div>
		</nav>
		<!-- End Navigation -->

		<!-- mylogin modal -->
		<!-- Modal -->
		
		<!--当前窗口登陆-->
		<?php if($this->config->get_config('login_window') == '1' && !$this->agent->is_mobile()):?>
		<div class="modal fade" id="mylogin" tabindex="-1" role="dialog"
			aria-labelledby="myModallogin">
			<div class="modal-dialog modal-sm" role="document">
				<div class="modal-content well">
					<!-- Nav tabs -->
					<ul class="nav nav-tabs" role="tablist">
						<li role="presentation" class="login-botton">
							<a href="#login-tab" aria-controls="home" role="tab"
								data-toggle="tab"><?php echo lang_line('login');?></a>
						</li>
						<li role="presentation" class="register-botton">
							<a href="#register-tab" aria-controls="profile" role="tab"
								data-toggle="tab"><?php echo lang_line('register');?></a>
						</li>
						<li class="login-close">
							<a type="button" class="close login-close" data-dismiss="modal"
								aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</a>
						</li>
					</ul>

					<!-- Tab panes -->
					<div class="tab-content">
						<div role="tabpanel" class="tab-pane login-botton" id="login-tab">
							<form action="<?php echo $this->config->item('catalog').'/user/signin/login';?>" method="post" enctype="multipart/form-data" id="login">
								<div class="form-group error"></div>
								<div class="form-group">
									<input type="text" id="email" name="email" value=""
										placeholder="<?php echo lang_line('email');?>"
										class="form-control" />
								</div>
								<!-- /field -->
								<div class="form-group">
									<input type="password" id="password" name="password" value=""
										placeholder="<?php echo lang_line('password');?>"
										class="form-control" />
								</div>
								<!-- /password -->
								<div class="form-group">
									<a href="<?php echo $this->config->item('catalog').'/user/forget';?>"><?php echo lang_line('forget');?></a>
								</div>
								<div class="form-group">
									<input type="hidden" name="is_view" value="1"/>
									<button type="submit" class="btn btn-info btn-block"><?php echo lang_line('login');?></button>
								</div>
								<!-- .actions -->
							</form>
						</div>
						<div role="tabpanel" class="tab-pane register-botton"
							id="register-tab">
							<form action="<?php echo $this->config->item('catalog').'/user/signin/signinup';?>" method="post" enctype="multipart/form-data" id="regist">
								<div class="form-group error"></div>
								<div class="form-group">
									<input type="text" id="email" name="email" value=""
										placeholder="<?php echo lang_line('email');?>"
										class="form-control" />
								</div>
								<!-- /field -->
								<div class="form-group">
									<input type="password" id="password" name="password" value=""
										placeholder="<?php echo lang_line('password');?>"
										class="form-control" />
								</div>
								<!-- /password -->
								<div class="form-group">
									<input type="text" id="nickname" name="nickname" value=""
										placeholder="<?php echo lang_line('nickname');?>"
										class="form-control" />
								</div>
								<!-- /password -->
								<div class="form-group form-captcha">
									<input type="text" id="captcha" name="captcha" value=""
										placeholder="<?php echo lang_line('captcha');?>"
										class="form-control" />
									<img title="<?php echo lang_line('refresh');?>"
										src="<?php echo $this->config->item('catalog').'/common/captcha';?>"
										align="absbottom"
										onclick="this.src='<?php echo $this->config->item('catalog');?>/common/captcha?'+Math.random();"></img>
								</div>
								<!-- /field -->
								<div class="form-group">
									<div class="checkbox login-checkbox">
										<label>
											<input id="agree" type="checkbox" name="agree" value="1"><?php echo lang_line('agree');?></label>

										<label class="login-forget">
											<a
												onclick="window.open('<?php echo $this->config->item('catalog').'/helper/faq?id='.$this->config->get_config('registration_terms');?>');"><?php echo lang_line('registration_terms');?></a>
										</label>
									</div>
								</div>
								<div class="form-group">
									<button type="submit" class="btn btn-info btn-block"><?php echo lang_line('register');?></button>
								</div>
								<!-- .actions -->
							</form>
						</div>
					</div>
					<div class="modal-footer mylogin-footer" style="text-align: center; padding-left: 0; padding-right: 0">
						<?php foreach($sign_ins as $key=>$value):?>
						<a onclick="with_login('<?php echo $key;?>');">
							<img width="32px" height="32px" class="lazy"
								data-original="resources/public/resources/default/image/login_ico/<?php echo $value['setting']['image'];?>"
								data-toggle="tooltip" data-placement="top"
								title="<?php echo $value['setting']['extra'];?>">
						</a>
						<?php endforeach;?>
					</div>
				</div>
			</div>
		</div>

		<script>
		//第三方登陆
		function with_login(key){
			window.open ('<?php echo $this->config->item('catalog');?>/user/sns/session/'+key,'newwindow','height=400,width=400,top=0,left=0,toolbar=no,menubar=no,scrollbars=no, resizable=no,location=no, status=no');
		}
	
		//登陆
		$(document).ready(function(){
			$("#login").validate({
				rules:{
					email: {
						required: true,
						email: true
					},
					password: {
						required: true,
						rangelength: [6,18],
					}
				},
				messages:{
					email: {
						required: "<?php echo lang_line('email');?>",
						email: "<?php echo lang_line('error_email');?>"
					},
					password: {
						required: "<?php echo lang_line('password');?>",
						rangelength: "<?php echo lang_line('error_password');?>"
					}
				},
				submitHandler: function(form) 
				{      
					$(form).ajaxSubmit({
						dataType: "json",
						beforeSubmit: function(){NProgress.start();},
						success: function(result){
							//返回提示信息 
							NProgress.done();      
							if(result.status == '1'){
								window.location.reload();
							}else{
								$("#login .error").html('<span style="color: #A94442">'+result.msg+'</span>');
							}
						}
					});
				}
			});
		});

		//注册
		$(document).ready(function(){
			$("#regist").validate({
				rules: {
					email: {
						required: true,
						email: true,
						remote: "user/signin/check_email_web"
					},
					password: {
						required: true,
						rangelength: [6,18],
					},
					nickname: {
						required: true,
						cn_edu: true,
						rangelength: [3,18],
					},
					captcha: {
						required: true,
						rangelength:[4,4],
						remote: "<?php echo $this->config->item('catalog');?>/common/captcha/veri"
					},
					agree: {
						required: true,
					}
				},
				messages: {
					email: {
						required: "<?php echo lang_line('email');?>",
						email: "<?php echo lang_line('error_email');?>",
						remote: "<?php echo lang_line('error_registered');?>"
					},
					password: {
						required: "<?php echo lang_line('password');?>",
						equalTo: "<?php echo lang_line('error_password');?>"
					},
					nickname: {
						required: "<?php echo lang_line('nickname');?>",
						cn_edu: "<?php echo lang_line('error_nickname');?>",
						rangelength: "<?php echo lang_line('error_nickname');?>",
					},
					captcha: {
						required: "<?php echo lang_line('captcha');?>",
						rangelength: "<?php echo lang_line('error_captcha_lenght');?>",
						remote: "<?php echo lang_line('error_captcha');?>"
					},
					agree: {
						required: "<?php echo lang_line('agree');?>",
					},
				},
				errorPlacement: function(error, element) { 
					if ( element.is(":checkbox") ) 
					error.appendTo ( element.parent().parent().parent() ); 
					else 
					error.insertAfter(element); 
				},

				submitHandler: function(form) 
				{      
					$(form).ajaxSubmit({
						dataType: "json",
						beforeSubmit: function(){NProgress.start();},
						success: function(result){
							//返回提示信息 
							NProgress.done();     
							if(result.status == '1'){
								window.location.reload();
							}
						}
					});
				}
			});
		});
	</script>
	<?php endif;?>
	<script type="text/javascript">
		$('#search').placeholderTypewriter({
			text: ["www.openant.com/bbs.php", "蚂蚁开源论坛", "如果你有什么问题？", "可以在这里得到解答", "用简单的方式描述它"]
		});
	</script>
	<div id="mobile-menu" class="well">
		<ul>
			<li class="text-center" style="width: 20%"><a href="<?php echo base_url();?>"><i class="glyphicon glyphicon-home"></i>首页</a></li>
			<li class="text-center" style="width: 20%"><a href="<?php echo base_url();?>"><i class="glyphicon glyphicon-search"></i>搜索</a></li>
			<li class="text-center" style="width: 20%"><a href="<?php echo $this->config->item('catalog').'/mobile/category';?>"><i class="glyphicon glyphicon-th-list"></i>分类</a></li>
			<li class="text-center" style="width: 20%"><a href="user/wecome"><i class="glyphicon glyphicon-shopping-cart"></i>购物车</a></li>
			<li class="text-center" style="width: 20%"><a href="<?php echo $this->config->item('catalog').'/mobile/user';?>"><i class="glyphicon glyphicon-user"></i>我的</a></li>
		</ul>
	</div>

</div>
	<div id="content">