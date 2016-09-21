<?php echo $header;//装载header?>
<?php echo $top;//装载top?>
<!-- /subnavbar -->
<div class="container">
	<div class="row">
		<div class="col-md-12 middle-flat-left">
			<div class="panel panel-default">
				<div class="panel-heading row row-panel-heading bg-info">
					<p class="navbar-left"><i class="glyphicon glyphicon-edit"></i>&nbsp;编辑<?php echo isset($module) ? $module['name'] : 'module';?></p>
					<div class="navbar-right btn-group" style="margin-right: 0">
						<button type="button" onclick="submit('form-module')" class="btn btn-default"><i class="glyphicon glyphicon-floppy-save"></i></button>
						<a href="<?php echo site_url('extension_config/module/Will_move_text');?>" class="btn btn-default"><i class="glyphicon glyphicon-share-alt"></i></a>
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
							<label class="col-sm-2 control-label">文字内容</label>
							<div class="col-sm-10">
								<?php foreach($languages as $language):?>
								<div class="input-group" style="margin-bottom: 15px">
								  <span class="input-group-addon"><img width="16px" height="11px" class="lazy" data-original="public/flags/<?php echo $language['image']?>"></span>
								  <textarea name="setting[content][<?php echo $language['language_id']?>]" class="form-control" rows="3" placeholder="多行文字用分号“;”隔开"><?php echo isset($module) ? $module['setting']['content'][$language['language_id']] : '';?></textarea>
								</div>
								<?php endforeach;?>
							</div>
						</div>
						
						
						<div class="form-group">
							<label class="col-sm-2 control-label" for="bgcolor">背景色</label>
							<div class="col-sm-10">
								<input type="text" name="setting[bgcolor]" id="bgcolor" class="form-control" placeholder="背景色" value="<?php echo isset($module) ? $module['setting']['bgcolor'] : '';?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="color">文字色</label>
							<div class="col-sm-10">
								<input type="text" name="setting[color]" id="color" class="form-control" placeholder="文字色" value="<?php echo isset($module) ? $module['setting']['color'] : '';?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="height">模块高</label>
							<div class="col-sm-10">
								<input type="text" name="setting[height]" id="height" class="form-control" placeholder="模块高" value="<?php echo isset($module['setting']['height']) ? $module['setting']['height'] : '';?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="font_size">字体大小</label>
							<div class="col-sm-10">
								<input type="text" name="setting[font_size]" id="font_size" class="form-control" placeholder="字体大小" value="<?php echo isset($module['setting']['font_size']) ? $module['setting']['font_size'] : '';?>">
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