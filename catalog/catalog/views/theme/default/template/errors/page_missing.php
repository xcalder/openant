<?php echo $header;//装载header?>
<body>
	<div class="container">
		<div class="text-center">
			<h1>404</h1>
			<p>你所访问的页面不存在</p>
		</div>
		<hr>
		<p class="text-center">
			资源不存在或没有权限 <a class="text-primary" href="<?php echo $this->config->item('catalog');?>">返回首页</a>
		<?php if(!$this->user->isLogged()):?>
		或<a class="text-primary"
				href="<?php echo $this->config->item('catalog').'/user/signin/login';?>">登陆</a>
		<?php endif;?>
		</p>
	</div>
</body>