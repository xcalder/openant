<?php echo $header;//装载header?>
<?php echo $top;//装载top?>
<div class="container">
	<div class="row"><?php echo $position_left;?>
		<?php if($position_left && $position_right):?>
		<?php $class = 'col-sm-6'; ?>
		<?php $point_col='';?>
		<?php elseif($position_left || $position_right):?>
		<?php $class = 'col-sm-9'; ?>
		<?php $point_col='<div class="col-sm-3"></div>';?>
		<?php else:?>
		<?php $class = 'col-sm-12'; ?>
		<?php $point_col='<div class="col-sm-3"></div>';?>
		<?php endif;?>
	
		<?php echo ($position_right || (!$position_left && !$position_right)) ? $point_col : '';?>
		<div id="middle" class="col-sm-6">
			<?php echo $position_top; ?>
    	
			<div class="row">
				<div class="col-sm-6"><div style="font-size: 36px;" class="animated rotateIn"></div></div>
				<div class="col-sm-6 panel panel-default">
					<div class="panel-body">
				<h4 class="text-center">重复申请!</h4><hr style="margin: 10px 0">
				<h4>你已经是商家或已经提交了申请，请不要重复提交，审核通过将会以邮件和站内信通知你，请留意！</h4><hr>
				<a href="<?php echo site_url();?>">回首页</a>
			</div>
				</div>
			</div>
    
			<?php echo $position_bottom; ?>
		</div><?php echo ($position_left || (!$position_left && !$position_right)) ? $point_col : '';?>
		<?php echo $position_right; ?>
	</div>
</div>
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
        title: "条款",
        //步骤内容(鼠标移动到本步骤节点时，会提示该内容)
        content: "请先阅读并同意条款，然后进入入驻申请"
      },{
        title: "申请",
        content: "已同意入驻条款，填写商城信息提交申请"
      },{
        title: "待审核",
        content: "已同意入驻条款、信息真实，待审核"
      },{
        title: "完成",
        content: "入驻审核成功，可以前往商家后台管理商城"
      }]
    });
    $(".ystep1").setStep(3);
</script>
<style type="text/css">
	.ystep-container{
		margin-left: calc(50% - 148px);
	}
</style>
<?php echo $footer;?>