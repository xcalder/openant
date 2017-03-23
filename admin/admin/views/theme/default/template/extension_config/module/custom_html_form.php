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
						<a href="<?php echo $this->config->item('admin').'extension_config/module/custom_html';?>" class="btn btn-sm btn-default"><i class="glyphicon glyphicon-share-alt"></i></a>
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
							<label class="col-sm-2 control-label" for="name">HTML内容</label>
							<div class="col-sm-10">
								<div role="tabpanel" class="tab-pane active" id="tab-general">
									<ul class="nav nav-tabs" role="tablist" id="language-description">
										<?php foreach($languages as $language):?>
										<li role="presentation">
											<a href="#description-<?php echo $language['language_id']?>" role="tab" data-toggle="tab">
												<img  width="16px" height="11px" class="lazy" data-original="resources/public/flags/<?php echo $language['image']?>"><?php echo $language['name']?>
											</a>
										</li>
										<?php endforeach;?>
									</ul>
									<!-- Tab panes -->
									<div class="tab-content" id="language-description-form">
										<?php foreach($languages as $language):?>
										<div role="tabpanel" class="tab-pane" id="description-<?php echo $language['language_id']?>">
											<div class="form-group">
												<div class="col-sm-12">
													<textarea name="setting[<?php echo $language['code']?>]" id="input-description-<?php echo $language['language_id']?>"><?php echo isset($module['setting']) ? $module['setting'][$language['code']] : '';?></textarea>
												</div>
											</div>
										</div>
										<?php endforeach;?>
									</div>
								</div>
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
	<script>
		$('#language-description li:first').addClass('active');
		$('#language-description-form .tab-pane:first').addClass('active');
		
		<?php foreach ($languages as $language):?>
		$(document).ready(function () {
				$('#input-description-<?php echo $language['language_id']; ?>').summernote({
						height: 200,                 // set editor height
					});
			});
		<?php endforeach; ?>
	</script>
	<!-- /row -->
</div>
<!-- /container -->
<?php echo $footer;//装载header?>