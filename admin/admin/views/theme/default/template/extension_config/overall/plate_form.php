<?php echo $header;//装载header?>
<?php echo $top_nav;//装载top?>
<!-- /subnavbar -->
<div class="container">
	<div class="row">
		<div class="col-md-12 middle-flat-left">
			<div class="panel panel-default">
				<div class="panel-heading row row-panel-heading bg-info">
					<p class="navbar-left">
						<i class="glyphicon glyphicon-edit">
						</i>编辑论坛版块
					</p>
					<div class="navbar-right btn-group" style="margin-right: 0">
						<button type="button" onclick="submit('form-plate')" class="btn btn-sm btn-default">
							<i class="glyphicon glyphicon-floppy-save">
							</i>
						</button>
						<a href="<?php echo $this->config->item('admin').'extension_config/overall/plate';?>" class="btn btn-sm btn-default">
							<i class="glyphicon glyphicon-share-alt">
							</i>
						</a>
					</div>
				</div>
				<!-- /widget-header -->
				<div class="panel-body page-tab">
					<form action="<?php echo $action;?>" method="post" enctype="multipart/form-data" id="form-plate" class="form-horizontal">
						<ul class="nav nav-tabs">
							<li class="active">
								<a href="#tab-general" aria-controls="tab-general" role="tab" data-toggle="tab">编辑版块</a>
							</li>
							<li>
								<a href="#tab-data" aria-controls="profile" role="tab" data-toggle="tab">基本信息</a>
							</li>
						</ul>

						<!-- Tab panes -->
						<div class="tab-content">
							<div role="tabpanel" class="tab-pane active" id="tab-general">
								<ul class="nav nav-tabs" role="tablist" id="language-list">
									<?php foreach($languages as $language):?>
									<li role="presentation">
										<a href="#language<?php echo $language['language_id']?>" role="tab" data-toggle="tab">
											<img width="16px" height="11px" class="lazy" data-original="resources/public/flags/<?php echo $language['image']?>"><?php echo $language['name']?>
										</a>
									</li>
									<?php endforeach;?>
								</ul>

								<!-- Tab panes -->
								<div class="tab-content" id="language-form">
									<?php foreach($languages as $language):?>
									<div role="tabpanel" class="tab-pane" id="language<?php echo $language['language_id']?>">
										<div class="form-group">
											<label class="col-sm-2 control-label" for="input-name<?php echo $language['language_id']?>">
												<span style="color:red">*</span>板块标题
											</label>
											<div class="col-sm-10">
												<input type="text" class="form-control" name="description[<?php echo $language['language_id']?>][title]" id="input-name<?php echo $language['language_id']?>" placeholder="板块标题" value="<?php echo isset($description[$language['language_id']]['title']) ? $description[$language['language_id']]['title'] : ''; ?>">
												<?php if(!empty($error_title)):?>
												<label class="text-danger">
													<?php echo isset($error_title[$language['language_id']]['error_title']) ? $error_title[$language['language_id']]['error_title'] : '';?>
												</label>
												<?php endif;?>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="input-description<?php echo $language['language_id']; ?>">
												<span style="color:red">*</span>板块描述
											</label>
											<div class="col-sm-10">
												<textarea name="description[<?php echo $language['language_id']; ?>][description]" id="input-description<?php echo $language['language_id']; ?>" class="form-control" placeholder="板块描述"><?php echo isset($description[$language['language_id']]['description']) ? $description[$language['language_id']]['description'] : ''; ?></textarea>
												<?php if(!empty($error_description)):?>
												<label class="text-danger">
													<?php echo isset($error_description[$language['language_id']]['error_description']) ? $error_description[$language['language_id']]['error_description'] : '';?>
												</label>
												<?php endif;?>
											</div>
										</div>
									</div>
									<?php endforeach;?>
								</div>
							</div>
							<div role="tabpanel" class="tab-pane" id="tab-data">
								<div class="form-group">
									<label class="col-sm-2 control-label" for="admin_ids">
										板块管理员
									</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="base[admin_ids]" id="admin_ids" placeholder="板块管理员" value="<?php echo $admin_ids;?>">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="label">
										标签样式
									</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="base[label]" id="label" placeholder="标签样式" value="<?php echo $label;?>">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="allow-posting">
										允许发帖
									</label>
									<div class="col-sm-10">
										<label class="radio-inline">
										  <input type="radio" name="base[allow_posting]" id="allow-posting" value="1" <?php echo ($allow_posting == '1') ? 'checked' : '';?>> 是
										</label>
										<label class="radio-inline">
										  <input type="radio" name="base[allow_posting]" id="allow-posting" value="0" <?php echo ($allow_posting == '0') ? 'checked' : '';?>> 否
										</label>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="is-view">
										显示
									</label>
									<div class="col-sm-10">
										<label class="radio-inline">
										  <input type="radio" name="base[is_view]" id="is-view" value="1" <?php echo ($is_view == '1') ? 'checked' : '';?>> 是
										</label>
										<label class="radio-inline">
										  <input type="radio" name="base[is_view]" id="is-view" value="0" <?php echo ($is_view == '0') ? 'checked' : '';?>> 否
										</label>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="is-menu">
										菜单显示
									</label>
									<div class="col-sm-10">
										<label class="radio-inline">
										  <input type="radio" name="base[is_menu]" id="is-menu" value="1" <?php echo ($is_menu == '1') ? 'checked' : '';?>> 是
										</label>
										<label class="radio-inline">
										  <input type="radio" name="base[is_menu]" id="is-menu" value="0" <?php echo ($is_menu == '0') ? 'checked' : '';?>> 否
										</label>
									</div>
								</div>
							</div>
						</div>
						<input type="hidden" name="base[user_id]" value="<?php echo $user_id;?>">
					</form>
				</div>
				<!-- /widget-content -->
			</div>
			<!-- /widget -->
		</div>
		<!-- /span12 -->
	</div>
	<!-- /row -->
</div>
<!-- /container -->

<script type="text/javascript">
	<?php foreach ($languages as $language):?>
	$(document).ready(function ()
		{
			$('#input-description<?php echo $language['language_id']; ?>').summernote(
				{
					height: 200,                 // set editor height
				});
		});
	<?php endforeach; ?>

	//
	<?php if(!empty($error_warning)):?>
		$(document).ready(function ()
		{
			$.notify(
				{
					icon: 'icon-warning-sign', message: '<?php echo $error_warning;?>'
				},
				{
					type: 'danger'
				});
		});
	<?php endif;?>
</script>

<?php echo $footer;//装载header?>