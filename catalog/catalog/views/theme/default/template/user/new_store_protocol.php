<?php echo $header;//装载header?>
<?php echo $top;//装载top?>
<!-- /subnavbar -->
<div class="container">
	<div class="row">
		<div class="col-md-12 middle-flat-left">
			<div class="well well-sm" id="middle-flat-left">
				<div class="col-xs-4">
					<dl class="dl-horizontal">
						<dt>发布时间：</dt>
						<dd><?php echo $information['date_added'];?></dd>
					</dl>
				</div>
				<div class="col-xs-4">
					<dl class="dl-horizontal">
						<dt>最后修改：</dt>
						<dd><?php echo $information['date_added'];?></dd>
					</dl>
				</div>
				<div class="col-xs-4">
					<dl class="dl-horizontal">
						<dt>缔约时间：</dt>
						<dd><?php echo date("Y-m-d H:i");?></dd>
					</dl>
				</div>
				<hr style="border: 1px solid #eee;margin: 5px 0">
				<div style="overflow: auto;height: 400px;display: -moz-groupbox;">
					<div class="col-xs-12 text-center"><p style="margin: 0"><strong><?php echo $information['title'];?></strong></p><hr style="margin: 5px 0"></div>
					<?php echo $information['description'];?>
				</div><hr style="border: 1px solid #eee;margin: 5px 0">
				<div class="text-center">
					<button class="btn btn-info btn-sm" type="button" id="btn"><span class="badge">9</span>&nbsp;同意条款,下一步！</button>
				</div>
			</div>
		</div>
	</div>
<script>
//倒计时
$(function () {
    var count = 8;
    var countdown = setInterval(CountDown, 1000);
    function CountDown() {
        $("#btn").attr("disabled", true);
        $("#btn span").text(count);
        if (count == 0) {
            $("#btn").removeAttr("disabled");
            $("#btn span").html('<i class="glyphicon glyphicon-ok"></i>');
            clearInterval(countdown);
        }
        count--;
    }
});
$('#btn').click(function(){
	if($('#btn span').text() == 0){
		window.location.href="<?php echo $this->config->item('catalog').'/user/new_store/add';?>";
	}
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
    $(".ystep1").setStep(1);
</script>
<style type="text/css">
	.ystep-container{
		margin-left: calc(50% - 148px);
	}
</style>
	<!-- /row --> 
</div>
<!-- /container -->
<?php echo $footer;//装载header?>