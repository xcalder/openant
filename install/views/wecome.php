<?php echo $header;//装载header?>
<?php echo $top;//装载top?>
<!-- /subnavbar -->
<div class="container">
  <div class="row">
    <div id="middle" class="col-sm-12">
    	<div class="well well-lg" style="max-height: 500px; overflow-y: auto;margin-top: 15px">
    		<?php echo lang('terms');?>
    	</div>
    </div>
    <form action="<?php echo site_url('common/check');?>" method="post" enctype="multipart/form-data" id="install">
	    <div class="col-sm-12">
	    	请认真阅读本协议补充条款，任何个人或组织有权免费获得，修改发布或部分发布本程序的原代码，并且免费用于商业用途，但要保留底部原作者的版权标识，遮盖或修改原作者版权或标识视为自动放弃上述所有权利，原作者有权对违反协议用户行使（包括但不限于远程终止软件运行）权利，请知悉！
	    	<br/><hr><input type="checkbox" name="agree" value="1">同意授权协议及附加条款并继续,如果你不同意软件许可请放弃安装，关闭些页面
	    </div>
	    <div class="col-sm-6" style="margin-top: 15px">
	    	<button type="submit" class="btn btn-success">继续安装</button>
	    </div>
	    <div class="col-sm-6" style="margin-top: 15px;">
	    	<button type="button" class="btn btn-warning" style="float: right;" id="closeBtn">放弃安装</button>
	    </div>
	</form>
  </div>
  <script>
 	
 	$("#closeBtn").click(function(){
		var userAgent = navigator.userAgent;
		if (userAgent.indexOf("Firefox") != -1 || userAgent.indexOf("Chrome") !=-1) {
		   window.location.href="about:blank";
		} else {
		   window.opener = null;
		   window.open("", "_self");
		   window.close();
		}
	});
 	
  	//登陆
	$(document).ready(function()
		{
			$("#install").validate(
				{
					rules:
					{
						agree:
						{
							required: true
						}
					},
					messages:
					{
						password:
						{
							required: "<?php echo lang_line('password');?>"
						}
					}
				});
		});
		
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
		$(".ystep1").setStep(1);
  </script>
  <!-- /row --> 
</div>
<!-- /container -->
<?php echo $footer;//装载header?>