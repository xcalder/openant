<?php echo $header;//装载header?>
<?php echo $top;//装载top?>
<!-- /subnavbar -->
<div class="container">
  <div class="row">
    <div class="col-md-12 middle-flat-left">
      <div class="panel panel-default">
        <div class="panel-heading  row row-panel-heading bg-info">
	        <p class="navbar-left"><i class="glyphicon glyphicon-edit"></i>&nbsp;github登陆插件设置</p>
	    	<div class="navbar-right btn-group" style="margin-right: 0">
			  <button type="button" onclick="submit('form-download')" class="btn btn-sm btn-default"><i class="glyphicon glyphicon-floppy-save"></i></button>
			  <a href="<?php echo $this->config->item('admin').'common/extension/sign_in_with';?>" class="btn btn-sm btn-default"><i class="glyphicon glyphicon-share-alt"></i></a>
			</div>
        </div>
        <!-- /widget-header -->
        <div class="panel-body page-tab">
          <form action="<?php echo $this->config->item('admin').'extension_config/sign_in_with/github/add';?>" method="post" enctype="multipart/form-data" id="form-download" class="form-horizontal">
          	<div class="form-group">
				<label class="col-sm-2 control-label" for="appid"><span style="color: red">*&nbsp;</span>APP ID:</label>
				<div class="col-sm-10">
					<input type="text" name="appid" class="form-control" id="appid" placeholder="appid" value="<?php echo $appid;?>">
					<?php if(isset($error_appid)):?><label class="text-danger">
					<?php echo $error_appid;?>
					</label><?php endif;?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="appkey"><span style="color: red">*&nbsp;</span>APP KEY:</label>
				<div class="col-sm-10">
					<input type="text" name="appkey" class="form-control" id="appkey" placeholder="appkey" value="<?php echo $appkey;?>">
					<?php if(isset($error_appkey)):?><label class="text-danger">
					<?php echo $error_appkey;?>
					</label><?php endif;?>
				</div>
			</div><hr>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="extra">提示:</label>
				<div class="col-sm-10">
					<input type="text" name="extra" class="form-control" id="extra" placeholder="提示" value="<?php echo $extra;?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="store_order">排序:</label>
				<div class="col-sm-10">
					<input type="text" name="store_order" class="form-control" id="store_order" placeholder="排序" value="<?php echo $store_order;?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="status">状态:</label>
				<div class="col-sm-10">
					<select name="status" class="form-control" id="status">
					<?php if($status == '1'):?>
					<option value="0">禁用</option>
					<option value="1" selected>启用</option>
					<?php else:?>
					<option value="0" selected>禁用</option>
					<option value="1">启用</option>
					<?php endif;?>
					</select>
				</div>
			</div>
			<input name="image" type="hidden" value="github.jpg">
			<?php if(isset($module_id)):?>
			<input name="module_id" type="hidden" value="<?php echo $module_id;?>">
			<?php endif;?>
          </form>
        </div>
        <!-- /widget-content --> 
      </div>
      <!-- /widget -->
    </div>
    <!-- /span6 --> 
  </div>
  <!-- /row --> 
</div>
<!-- /container -->
<?php echo $footer;//装载header?>