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
						</i>&nbsp;编辑文章
					</p>
					<div class="navbar-right btn-group" style="margin-right: 0">
						<button type="button" onclick="submit('form-information')" class="btn btn-default">
							<i class="glyphicon glyphicon-floppy-save">
							</i>
						</button>
						<a href="<?php echo site_url('information/information');?>" class="btn btn-default">
							<i class="glyphicon glyphicon-share-alt">
							</i>
						</a>
					</div>
				</div>
				<!-- /widget-header -->
				<div class="panel-body page-tab">
					<form action="<?php echo $action;?>" method="post" enctype="multipart/form-data" id="form-information" class="form-horizontal">
						<ul class="nav nav-tabs">
							<li class="active">
								<a href="#tab-general" aria-controls="tab-general" role="tab" data-toggle="tab">
									编辑项目
								</a>
							</li>
							<li>
								<a href="#tab-data" aria-controls="profile" role="tab" data-toggle="tab">
									基本信息
								</a>
							</li>
						</ul>

						<!-- Tab panes -->
						<div class="tab-content">
							<div role="tabpanel" class="tab-pane active" id="tab-general">
								<ul class="nav nav-tabs" role="tablist" id="language-list">
									<?php
									foreach($languages as $language):?>
									<li role="presentation">
										<a href="#language<?php echo $language['language_id']?>" role="tab" data-toggle="tab">
											<img width="16px" height="11px" class="lazy" data-original="public/flags/<?php echo $language['image']?>">&nbsp;&nbsp;<?php echo $language['name']?>
										</a>
									</li>
									<?php endforeach;?>
								</ul>

								<!-- Tab panes -->
								<div class="tab-content" id="language-form">
									<?php
									foreach($languages as $language):?>
									<div role="tabpanel" class="tab-pane" id="language<?php echo $language['language_id']?>">
										<div class="form-group">
											<label class="col-sm-2 control-label" for="input-name<?php echo $language['language_id']?>">
												<span style="color:red">
													*
												</span>文章标题
											</label>
											<div class="col-sm-10">
												<input type="text" class="form-control" name="information_description[<?php echo $language['language_id']?>][title]" id="input-name<?php echo $language['language_id']?>" placeholder="文章标题" value="<?php echo isset($information_description[$language['language_id']]['title']) ? $information_description[$language['language_id']]['title'] : ''; ?>">
												<?php
												if(isset($error_information)):?>
												<label class="text-danger">
													<?php echo isset($error_information[$language['language_id']]['error_title']) ? $error_information[$language['language_id']]['error_title'] : '';?>
												</label><?php endif;?>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="input-description<?php echo $language['language_id']; ?>">
												<span style="color:red">
													*
												</span>文章描述
											</label>
											<div class="col-sm-10">
												<textarea name="information_description[<?php echo $language['language_id']; ?>][description]" id="input-description<?php echo $language['language_id']; ?>" class="form-control" placeholder="文章描述"><?php echo !empty($information_description[$language['language_id']]['description']) ? $information_description[$language['language_id']]['description'] : ''; ?></textarea>
												<?php
												if(isset($error_information)):?>
												<label class="text-danger">
													<?php echo isset($error_information[$language['language_id']]['error_description']) ? $error_information[$language['language_id']]['error_description'] : '';?>
												</label><?php endif;?>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="meta-description<?php echo $language['language_id']; ?>">
												meta描述
											</label>
											<div class="col-sm-10">
												<textarea name="information_description[<?php echo $language['language_id']; ?>][meta_description]" id="meta-description<?php echo $language['language_id']; ?>" class="form-control" placeholder="meta描述" rows="5"><?php echo isset($information_description[$language['language_id']]['meta_description']) ? $information_description[$language['language_id']]['meta_description'] : ''; ?></textarea>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="meta-keyword<?php echo $language['language_id']; ?>">
												meta关键词
											</label>
											<div class="col-sm-10">
												<textarea name="information_description[<?php echo $language['language_id']; ?>][meta_keyword]" id="meta-keyword<?php echo $language['language_id']; ?>" class="form-control" placeholder="meta关键词" rows="5"><?php echo isset($information_description[$language['language_id']]['meta_keyword']) ? $information_description[$language['language_id']]['meta_keyword'] : ''; ?></textarea>
											</div>
										</div>
									</div>
									<?php endforeach;?>
								</div>
							</div>
							<div role="tabpanel" class="tab-pane" id="tab-data">
								<div class="form-group">
									<label class="col-sm-2 control-label" for="information_category_id">
										选择分类
									</label>
									<div class="col-sm-10">
										<select name="base[information_category_id]" class="form-control" id="information_category_id">
											<?php
											if($information_categorys):?>
											<?php
											foreach($information_categorys as $information_category):?>
											<?php
											if($information_category_id == $information_category['information_category_id']):?>
											<option value="<?php echo $information_category['information_category_id']?>" selected>
												<?php echo $information_category['name']?>
											</option>
											<?php
											else:?>
											<option value="<?php echo $information_category['information_category_id']?>">
												<?php echo $information_category['name']?>
											</option>
											<?php endif;?>
											<?php endforeach;?>
											<?php endif;?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="sort_order">
										排序
									</label>
									<div class="col-sm-10">
										<input type="text" name="base[sort_order]" class="form-control" id="sort_order" placeholder="排序" value="<?php echo !empty($sort_order) ? $sort_order : '0'?>">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="status">
										状态
									</label>
									<div class="col-sm-10">
										<select name="base[status]" class="form-control" id="status">
											<?php
											if($status == '0'):?>
											<option value="1">
												启用
											</option>
											<option value="0" selected="selected">
												停用
											</option>
											<?php
											else:?>
											<option value="1" selected="selected">
												启用
											</option>
											<option value="0">
												停用
											</option>
											<?php endif;?>
										</select>
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
					// options
					icon: 'icon-warning-sign',
					message: '<?php echo $error_warning;?>'
				},
				{
					// settings
					type: 'danger'
				});
		});
	<?php endif;?>
</script>
<?php echo $footer;//装载header?>