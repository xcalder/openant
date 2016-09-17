<?php echo $header;//装载header?>
<?php echo $top;//装载top?>
<!-- /subnavbar -->
<div class="container">
  <div class="row">
    <div class="col-md-12 middle-flat-left">
      <div class="panel panel-default">
        <div class="panel-heading  row row-panel-heading bg-info">
	        <h4 class="navbar-left"><i class="glyphicon glyphicon-edit"></i>&nbsp;开店申请</h4>
	    	<div class="navbar-right btn-group" style="margin-right: 0">
			  <button type="button" onclick="submit('form-download')" class="btn btn-default"><i class="glyphicon glyphicon-floppy-save"></i></button>
			  <a href="<?php echo site_url('product/download');?>" class="btn btn-default"><i class="glyphicon glyphicon-share-alt"></i></a>
			</div>
        </div>
        <!-- /widget-header -->
        <div class="panel-body page-tab">
          <form action="user/new_store/add.html" method="post" enctype="multipart/form-data" id="form-download" class="form-horizontal">
          	<div class="form-group" id="language">
				<label class="col-sm-2 control-label" for="store-name"><span style="color: red">*&nbsp;</span>店铺名称</label>
				<div class="col-sm-10">
				<?php foreach($languages as $language):?>
					<div class="input-group">
					  <span class="input-group-addon"><img  width="16px" height="11px" class="lazy" data-original="public/flags/<?php echo $language['image']?>"></span>
					  <input type="text" name="description[<?php echo $language['language_id']?>][store_name]" class="form-control" placeholder="店铺名称" value="<?php echo isset($description[$language['language_id']]['stoer_name']) ? $description[$language['language_id']]['store_name'] : '';?>" id="store_name">
					</div>
					<?php if(isset($error_description[$language['language_id']]['error_store_name'])):?><label class="text-danger"><?php echo $error_description[$language['language_id']]['error_store_name'];?></label><?php endif;?>
				<?php endforeach;?>
				</div>
			</div>
			
			<div class="form-group" id="language">
				<label class="col-sm-2 control-label" for="description"><span style="color: red">*&nbsp;</span>店铺描述</label>
				<div class="col-sm-10">
				<?php foreach($languages as $language):?>
					<div class="input-group">
					  <span class="input-group-addon"><img  width="16px" height="11px" class="lazy" data-original="public/flags/<?php echo $language['image']?>"></span>
					  <input type="text" name="description[<?php echo $language['language_id']?>][description]" class="form-control" placeholder="店铺描述" value="<?php echo isset($description[$language['language_id']]['description']) ? $description[$language['language_id']]['description'] : '';?>" id="description">
					</div>
				<?php endforeach;?>
				</div>
			</div>
			<div class="form-group" id="language">
				<label class="col-sm-2 control-label" for="logo"><span style="color: red">*&nbsp;</span>logo</label>
				<?php foreach($languages as $language):?>
				<div class="col-sm-2">
					<div class="input-group" for="store-description-<?php echo $language['language_id'];?>">
						<span class="input-group-addon"><img  width="16px" height="11px" class="lazy" data-original="public/flags/<?php echo $language['image']?>"></span>
						  	<span style="cursor: pointer" id="thmb-map<?php echo $language['language_id'];?>" data-toggle="image" class="img-thumbnail"><img  width="100px" height="100px" class="lazy" data-original="<?php echo $placeholder_image;?>" width="100%" alt="主图" title="主图" data-placeholder="<?php echo $placeholder_image;?>" /></span>
							<input type="hidden" name="description[<?php echo $language['language_id'];?>][logo]" value="" id="store-description-<?php echo $language['language_id'];?>" />
					</div>
				</div>
				<?php endforeach;?>
			</div>
			
          </form>
        </div>
        <!-- /widget-content --> 
      </div>
      <!-- /widget -->
    </div>
    <!-- /span6 --> 
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
        content: "实名用户/公益组织发起项目"
      },{
        title: "申请",
        content: "乐捐平台工作人员审核项目"
      },{
        title: "审核",
        content: "乐捐项目上线接受公众募款"
      },{
        title: "完成",
        content: "项目执行者线下开展救护行动"
      }]
    });
    $(".ystep1").setStep(2);
</script>
<style type="text/css">
	.ystep-container{
		margin-left: calc(50% - 148px);
	}
</style>
</script>
  <!-- /row --> 
</div>
<!-- /container -->
<?php echo $footer;//装载header?>