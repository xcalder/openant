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
						<a href="<?php echo site_url('extension_config/module/product');?>" class="btn btn-default"><i class="glyphicon glyphicon-share-alt"></i></a>
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
							<label class="col-sm-2 control-label" for="vname">显示名称</label>
							<div class="col-sm-10">
								<input type="text" name="setting[name]" id="vname" class="form-control" placeholder="显示名称" value="<?php echo isset($module) ? $module['setting']['name'] : '';?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="category_id">选择分类</label>
							<div class="col-sm-10">
								<select name="setting[category_id]" id="category_id" class="form-control">
									<option value="">--无--</option>
									<?php if(!empty($cotegorys_select)):?>
									<?php foreach($cotegorys_select as $category):?>
									
									<?php if(isset($module) && $module['setting']['category_id'] == $category['category_id']):?>
									<option value="<?php echo $category['category_id'];?>" selected><?php echo $category['name'];?></option>
									<?php else:?>
									<option value="<?php echo $category['category_id'];?>"><?php echo $category['name'];?></option>
									<?php endif;?>
									
									<?php endforeach;?>
									<?php endif;?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="number">商品数量</label>
							<div class="col-sm-10">
								<input type="text" name="setting[number]" id="number" class="form-control" placeholder="显示数量" value="<?php echo isset($module['setting']['number']) ? $module['setting']['number'] : '';?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="order">排序方式</label>
							<div class="col-sm-10">
								<select name="setting[order]" id="order" class="form-control">
								
								<option value="time" <?php echo (isset($module['setting']['order']) && $module['setting']['order'] == 'time') ? 'selected'  : '';?>>最新商品</option>
								<option value="sales" <?php echo (isset($module['setting']['order']) && $module['setting']['order'] == 'sales') ? 'selected'  : '';?>>热销商品</option>
								<option value="RANDOM" <?php echo (isset($module['setting']['order']) && $module['setting']['order'] == 'RANDOM') ? 'selected'  : '';?>>随机排序</option>
								
								</select>
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