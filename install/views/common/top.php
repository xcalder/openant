<body id="<?php //echo $css;?>">
	<div id="header">
	<!-- Start Navigation -->
		<nav class="navbar navbar-default brand-center center-side bootsnav hidden-xs" style="z-index: 10" id="nav-top">
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
						<li style="max-height: 50px"><a class="navbar-brand navbar-brand-logo" style="padding: 0 15px" href="http://www.openant.com" title="logo"><img width="50px" height="50px" data-original="public/resources/default/image/logo-menu.jpg" class="logo lazy" alt="logo" style="background: url();"></a></li>
					</ul>
				</div>
				<!-- /.navbar-collapse -->
			</div>
		</nav>
		<!-- End Navigation -->

		<div id="fh5co-hero" style="background-image: url(public/resources/default/image/hero_2.jpg)">
			<a href="<?php echo all_current_url();?>#fh5co-main" class="smoothscroll animated bounce fh5co-arrow"><i class="glyphicon glyphicon-menu-down"></i></a>
			<div class="overlay"></div>
			<div class="container">
			  <div class="col-md-8 col-md-offset-2">
				<div class="text" style="padding: 6em 0">
				  <h1><?php echo lang_line('header_title');?></h1>
				</div>
			  </div>
			</div>
		</div>
		<div id="fh5co-main"></div>
		
		<nav class="navbar bg-info">
			<div class="container">
				<div class="row">
					<div class="collapse navbar-collapse">
						<div class="ystep1" style="margin-top: 7px;"></div>
					</div>
				</div>
			</div>
			<!-- /container -->
			<!-- /subnavbar-inner -->
		</nav>
</div>
	<div id="content">