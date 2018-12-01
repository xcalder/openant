<?php echo $header;//装载header?>
<?php echo $top;//装载top?>
<!-- /subnavbar -->
<div class="container">
	<div class="row">
		<div class="col-md-12 middle-flat-left">
			<div class="panel panel-default">
				<div class="panel-heading row row-panel-heading bg-info">
					<p class="navbar-left"><i class="glyphicon glyphicon-edit"></i>编辑<?php echo isset($module) ? $module['name'] : 'module';?></p>
					<div class="navbar-right btn-group" style="margin-right: 0">
						<button type="button" onclick="submit('form-module')" class="btn btn-sm btn-default"><i class="glyphicon glyphicon-floppy-save"></i></button>
						<a href="<?php echo $this->config->item('admin').'/extension_config/module/bbs';?>" class="btn btn-sm btn-default"><i class="glyphicon glyphicon-share-alt"></i></a>
					</div>
				</div>
				<!-- /widget-header -->
				<div class="panel-body page-tab">
					<form action="<?php echo $action;?>" method="post" enctype="multipart/form-data" id="form-module" class="form-horizontal">
						<div class="form-group">
							<label class="col-sm-2 control-label" for="name">模块名称</label>
							<div class="col-sm-10">
								<input type="text" name="name" id="name" class="form-control" placeholder="模块名称" value="<?php echo isset($module) ? $module['name'] : '';?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="view-name">显示名称</label>
							<div class="col-sm-10">
								<input type="text" name="setting[view_name]" id="view-name" class="form-control" placeholder="显示名称" value="<?php echo isset($module) ? $module['setting']['view_name'] : '';?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="type">帖子类型</label>
							<div class="col-sm-10">
								<?php if(isset($module) && $module['setting']['type'] == 'very_good'):?>
								<label class="radio-inline">
								  <input type="radio" name="setting[type]" id="type" value="very_good" checked>随机展示
								</label>
								<label class="radio-inline">
								  <input type="radio" name="setting[type]" id="type" value="active">热门帖
								</label>
								<?php else:?>
								<label class="radio-inline">
								  <input type="radio" name="setting[type]" id="type" value="very_good">随机展示
								</label>
								<label class="radio-inline">
								  <input type="radio" name="setting[type]" id="type" value="active" checked>热门帖
								</label>
								<?php endif;?>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-2 control-label" for="limit">显示数量</label>
							<div class="col-sm-10">
								<input type="text" name="setting[limit]" id="limit" class="form-control" placeholder="显示数量" value="<?php echo isset($module) ? $module['setting']['limit'] : '';?>">
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-2 control-label" for="status">状态</label>
							<div class="col-sm-10">
								<select name="setting[status]" id="status" class="form-control">
									<?php if(isset($module) && $module['setting']['status'] == '1'):?>
									<option value="1" selected>启用</option>
									<option value="0">停用</option>
									<?php else:?>
									<option value="1">启用</option>
									<option value="0" selected>停用</option>
									<?php endif;?>
								</select>
							</div>
						</div>
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