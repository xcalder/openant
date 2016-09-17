<?php echo $header;//装载header?>
<?php echo $top;//装载top?>
<!-- /subnavbar -->
<div class="container">
  <div class="row"><?php echo $position_left;?>
	<?php if ($position_left && $position_right):?>
	<?php $class = 'col-sm-6'; ?>
	<?php elseif ($position_left || $position_right):?>
	<?php $class = 'col-sm-9'; ?>
	<?php else:?>
	<?php $class = 'col-sm-12'; ?>
	<?php endif;?>
    <div id="middle" class="<?php echo $class; ?>">
    <?php echo $position_top; ?>
    <div style="text-align: center">
    	<i class="glyphicon glyphicon-ok-circle" style="font-size: 120px;color: green"></i>
    </div>
    <p style="text-align: center;">程序已经安装成功！</p>
    <hr>
    <p>
		<div class="col-sm-6 col-md-3">
			<div class="thumbnail">
			  <a href="http://www.openant.com"><img src="public/resources/default/image/big_logo.jpg" alt="OpenAnt 项目主页"></a>
			  <div class="caption">
			    <h5>OpenAnt 项目主页</h5>
			  </div>
			</div>
		</div>
		<div class="col-sm-6 col-md-3">
			<div class="thumbnail">
			  <a href="http://www.openant.com/bbs.php"><img src="public/resources/default/image/big_logo.jpg" alt="OpenAnt 社区论坛"></a>
			  <div class="caption">
			    <h5>OpenAnt社区论坛</h5>
			  </div>
			</div>
		</div>
		<div class="col-sm-6 col-md-3">
			<div class="thumbnail">
			  <a href="http://www.openant.com/index.php"><img src="public/resources/default/image/big_logo.jpg" alt="获取OpenAnt插件"></a>
			  <div class="caption">
			    <h5>获取OpenAnt插件</h5>
			  </div>
			</div>
		</div>
		<div class="col-sm-6 col-md-3">
			<div class="thumbnail">
			  <a href="http://www.openant.com/index.php"><img src="public/resources/default/image/big_logo.jpg" alt="OpenAnt GitHub仓库"></a>
			  <div class="caption">
			    <h5>OpenAnt GitHub仓库</h5>
			  </div>
			</div>
		</div>
    </p>
    <?php echo $position_bottom; ?></div>
    <?php echo $position_right; ?>
  </div>
  <!-- /row -->
  <script>
	$(".ystep1").loadStep({
		//ystep的外观大小
		//可选值：small,large
		size: "small",
		//ystep配色方案
		//可选值：green,blue
		color: "green",
		//ystep中包含的步骤
		steps: [{
				//步骤名称
				title: "第一步",
				//步骤内容(鼠标移动到本步骤节点时，会提示该内容)
				content: "同意免费授权协议并继续"
			},{
				title: "第二步",
				content: "检查系统安装环境"
			},{
				title: "第三步",
				content: "设置初始密码和系统配置"
			},{
				title: "第四步",
				content: "完成安装"
			}]
		});
	$(".ystep1").setStep(4);
  </script>
  <style type="text/css">
  	.ystep-container{
		margin-left: calc(50% - 180px);
	}
  </style>
</div>
<!-- /container -->
<?php echo $footer;//装载header?>