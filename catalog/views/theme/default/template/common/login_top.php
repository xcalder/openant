<body>
	<div id="header">
	<!-- Start Navigation -->
		<nav class="navbar navbar-default brand-center center-side bootsnav" id="nav-top">
			<div class="container">

				<!-- Start Header Navigation -->
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse"
						data-target="#navbar-menu-top">
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
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-briefcase"></i><?php echo lang_line('business');?><span class="badge">42</span></a>
							<ul class="dropdown-menu">
								<li>
									<a target="_black" href="user/new_store.html"><?php echo lang_line('business_in');?></a>
								</li>
								<li>
									<a href="javascript:;"><?php echo lang_line('goods_sold');?></a>
								</li>
								<li>
									<a href="javascript:;"><?php echo lang_line('sale_goods');?></a>
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
							<a href="<?php echo base_url()?>user/signin/login.html?url=<?php echo rawurlencode(all_current_url());?>"><i class="glyphicon glyphicon-user"></i><?php echo lang_line('login');?></a>
						</li>
						<li>
							<a href="<?php echo base_url()?>user/signin/signinup.html"><i class="glyphicon glyphicon-pencil"></i><?php echo lang_line('register');?></a>
						</li>
						<?php endif;?>
						
						<?php else:?>
						<!--如果没有登陆不显示-->
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-user"></i><?php echo utf8_substr($this->user->getnickname(), 0, 8);?><span class="badge">14</span>
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
				</div>
				<!-- /.navbar-collapse -->
			</div>
		</nav>
		<!-- End Navigation -->
		<?php echo $position_above;?>
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
							<form action="<?php echo base_url('user/signin/login.html');?>" method="post" enctype="multipart/form-data" id="login">
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
									<a href="user/forget.html"><?php echo lang_line('forget');?></a>
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
							<form action="<?php echo base_url('user/signin/signinup.html');?>" method="post" enctype="multipart/form-data" id="regist">
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
										src="<?php echo site_url('common/captcha');?>"
										align="absbottom"
										onclick="this.src='common/captcha.html?'+Math.random();"></img>
								</div>
								<!-- /field -->
								<div class="form-group">
									<div class="checkbox login-checkbox">
										<label>
											<input id="agree" type="checkbox" name="agree" value="1"><?php echo lang_line('agree');?></label>

										<label class="login-forget">
											<a onclick="window.open('<?php echo base_url('helper/faq.html?id=').$this->config->get_config('registration_terms');?>');"><?php echo lang_line('registration_terms');?></a>
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
								data-original="public/resources/default/image/login_ico/<?php echo $value['setting']['image'];?>"
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
			window.open ('user/sns/session/'+key+'.html','newwindow','height=400,width=400,top=0,left=0,toolbar=no,menubar=no,scrollbars=no, resizable=no,location=no, status=no');
		}
		//登陆
		$(document).ready(function()
			{
				$("#login").validate(
					{
						rules:
						{
							email:
							{
								required: true,
								email: true
							},
							password:
							{
								required: true,
								rangelength: [6,18],
							}
						},
						messages:
						{
							email:
							{
								required: "<?php echo lang_line('email');?>",
								email: "<?php echo lang_line('error_email');?>"
							},
							password:
							{
								required: "<?php echo lang_line('password');?>",
								rangelength: "<?php echo lang_line('error_password');?>"
							}
						},

						submitHandler: function(form)
						{
							$(form).ajaxSubmit(
								{
									dataType: "json",
									beforeSubmit: function()
									{
										NProgress.start();
									},
									success: function(result)
									{
										//返回提示信息
										NProgress.done();

										if(result.status == '1')
										{
											self.location.reload();
											
										}else
										{
											$("#login .error").html('<span style="color: #A94442">'+result.msg+'</span>');
										}
									}
								});
						}

					});
			});

		//注册
		$(document).ready(function()
			{
				$("#regist").validate(
					{
						rules:
						{
							email:
							{
								required: true,
								email: true,
								remote: "user/signin/check_email_web.html"
							},
							password:
							{
								required: true,
								rangelength: [6,18],
							},
							nickname:
							{
								required: true,
								cn_edu: true,
								rangelength: [3,18],
							},
							captcha:
							{
								required: true,
								rangelength:[4,4],
								remote: "common/captcha/veri.html"
							},
							agree:
							{
								required: true,
							}
						},
						messages:
						{
							email:
							{
								required: "<?php echo lang_line('email');?>",
								email: "<?php echo lang_line('error_email');?>",
								remote: "<?php echo lang_line('error_registered');?>"
							},
							password:
							{
								required: "<?php echo lang_line('password');?>",
								equalTo: "<?php echo lang_line('error_password');?>"
							},
							nickname:
							{
								required: "<?php echo lang_line('nickname');?>",
								cn_edu: "<?php echo lang_line('error_nickname');?>",
								rangelength: "<?php echo lang_line('error_nickname');?>",
							},
							captcha:
							{
								required: "<?php echo lang_line('captcha');?>",
								rangelength: "<?php echo lang_line('error_captcha_lenght');?>",
								remote: "<?php echo lang_line('error_captcha');?>"
							},
							agree:
							{
								required: "<?php echo lang_line('agree');?>",
							},
						},
						errorPlacement: function(error, element)
						{
							if ( element.is(":checkbox") )
							error.appendTo ( element.parent().parent().parent() );
							else
							error.insertAfter(element);
						},

						submitHandler: function(form)
						{
							$(form).ajaxSubmit(
								{
									dataType: "json",
									beforeSubmit: function()
									{
										NProgress.start();
									},
									success: function(result)
									{
										//返回提示信息
										NProgress.done();

										if(result.status == '1')
										{
											
											self.location.reload();
											
										}
									}
								});
						}
					});
			});
	</script>
	<?php endif;?>
	
	<div id="mobile-menu" class="well">
		<ul>
			<li class="text-center" style="width: 20%"><a href="<?php echo base_url();?>"><i class="glyphicon glyphicon-home"></i>首页</a></li>
			<li class="text-center" style="width: 20%"><a href="<?php echo base_url();?>"><i class="glyphicon glyphicon-briefcase"></i>商城</a></li>
			<li class="text-center" style="width: 20%"><a href="<?php echo base_url();?>"><i class="glyphicon glyphicon-tree-deciduous"></i>社区</a></li>
			<li class="text-center" style="width: 20%"><a href="common/mobile_nav.html"><i class="glyphicon glyphicon-th-list"></i>管理</a></li>
			<li class="text-center" style="width: 20%"><a href="user/wecome.html"><i class="glyphicon glyphicon-user"></i>商家</a></li>
		</ul>
	</div>

</div>
	<div id="content" class="login-top" style="margin-top: 15px">