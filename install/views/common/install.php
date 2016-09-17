<?php echo $header;//装载header?>
<?php echo $top;//装载top?>
<!-- /subnavbar -->
<div class="container">
  <div class="row">
  	<form action="<?php echo site_url('common/install');?>" method="post" enctype="multipart/form-data" id="install">
		<div id="middle" class="col-sm-12">
			<p><strong>1.数据库链接相关信息</strong>请输入数据库链接的详细信息</p><hr>
	    	<div class="form-group">
			    <label for="db_driver">数据库驱动</label>
			    <select class="form-control" id="db_driver" name="db_driver">
			    	<option value="mysqli">MySqli</option>
			    	<option value="pdo">mPdo</option>
			    </select>
			</div>
			<div class="form-group">
			    <label for="hostname">主机名</label>
			    <input type="text" class="form-control" id="hostname" name="hostname" value="" placeholder="localhost"/>
			</div>
			<div class="form-group">
			    <label for="username">用户名</label>
			    <input type="text" class="form-control" id="username" name="username" value="" placeholder="用户名"/>
			</div>
			<div class="form-group">
			    <label for="passwd">密码</label>
			    <input type="text" class="form-control" id="passwd" name="passwd" value="" placeholder="密码"/>
			</div>
			<div class="form-group">
			    <label for="dbname">数据库名</label>
			    <input type="text" class="form-control" id="dbname" name="dbname" value="" placeholder="数据库名"/>
			</div>
			<div class="form-group">
			    <label for="prefix">端口</label>
			    <input type="text" class="form-control" id="prefix" name="prefix" value="" placeholder="3306"/>
			</div>
			<div class="form-group">
			    <label for="prefix">表前缀</label>
			    <input type="text" class="form-control" id="prefix" name="prefix" value="" placeholder="表前缀，暂不支持" disabled=""/>
			</div>
			
			<p><strong>1.管理员相关信息</strong>请输入管理员信息</p><hr>
	    	<div class="form-group">
			    <label for="email">管理员登陆邮箱帐号</label>
			    <input type="text" class="form-control" id="email" name="email" value="" placeholder="管理员邮箱帐号"/>
			</div>
			<div class="form-group">
			    <label for="apasswd">管理员密码</label>
			    <input type="text" class="form-control" id="apasswd" name="apasswd" value="" placeholder="管理员密码"/>
			</div>
			
		</div>
		
	  	<div class="col-sm-6" style="margin-top: 15px">
			<button type="submit" class="btn btn-success">继续安装</button>
		</div>
		<div class="col-sm-6" style="margin-top: 15px;">
			<a href="<?php echo site_url('common/check');?>" class="btn btn-warning" style="float: right;">上一步</a>
		</div>
	</form>
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
	$(".ystep1").setStep(3);
  </script>
  <style type="text/css">
  	.container .text{
		padding: 1px 0 !important;
	}
  </style>
  <!-- /row --> 
</div>
<!-- /container -->
<?php echo $footer;//装载header?>