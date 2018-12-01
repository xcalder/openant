<?php echo $header;//装载header?>
<body>
	<div class="container">
		<div class="text-center">
			<h1>404</h1>
			<p>你所访问的页面不存在</p>
		</div>
		<hr>
		<p class="text-center">
			资源不存在或没有权限 <a class="text-primary" href="<?php echo site_url();?>">返回首页</a>
		<?php if(!$this->user->isLogged()):?>
		或<a class="text-primary"
				href="<?php echo $this->config->item('catalog').'/user/signin/login';?>">登陆</a>
		<?php endif;?>
		<?php if(isset($msg) && !empty($msg)):?>
		或&nbsp;<a <?php echo (isset($msg_url) && !empty($msg_url)) ? 'class="text-primary" href="'.$msg_url.'"' : '';?>><?php echo $msg;?></a>
		<?php endif;?>
		</p>
	</div>
</body>