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
						<a href="<?php echo $this->config->item('admin').'/common/extension/overall';?>" class="btn btn-sm btn-default">
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
											<label class="col-sm-2 control-label" for="input-title<?php echo $language['language_id']?>">
												工作室官网标题
											</label>
											<div class="col-sm-10">
												<input type="text" class="form-control" name="studio_meta_title[<?php echo $language['language_id']?>]" id="input-title<?php echo $language['language_id']?>" placeholder="工作室官网标题" value="<?php echo isset($studio_meta_title[$language['language_id']]) ? $studio_meta_title[$language['language_id']] : ''; ?>">
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="input-keyword<?php echo $language['language_id']?>">
												工作室官网seo关键词
											</label>
											<div class="col-sm-10">
												<input type="text" class="form-control" name="studio_meta_keyword[<?php echo $language['language_id']?>]" id="input-keyword<?php echo $language['language_id']?>" placeholder="工作室官网seo关键词" value="<?php echo isset($studio_meta_keyword[$language['language_id']]) ? $studio_meta_keyword[$language['language_id']] : ''; ?>">
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="input-description<?php echo $language['language_id']; ?>">
												工作室官网描述
											</label>
											<div class="col-sm-10">
												<textarea name="studio_meta_description[<?php echo $language['language_id']; ?>]" id="input-description<?php echo $language['language_id']; ?>" class="form-control" placeholder="工作室官网描述"><?php echo isset($studio_meta_description[$language['language_id']]) ? $studio_meta_description[$language['language_id']] : ''; ?></textarea>
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
										
									</div>
								</div>
							</div>
						</div>
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