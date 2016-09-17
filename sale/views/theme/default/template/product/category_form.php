<?php echo $header;//装载header?>
<?php echo $top_nav;//装载top?>
<!-- /subnavbar -->
<div class="container">
	<div class="row">
		<div class="col-md-12 middle-flat-left">
			<div class="panel panel-default">
				<div class="panel-heading row row-panel-heading bg-info">
					<p class="navbar-left"><i class="glyphicon glyphicon-edit"></i>&nbsp;编辑商品分类</p>
					<div class="navbar-right btn-group" style="margin-right: 0">
						<button type="button" onclick="submit('form-category')" class="btn btn-default"><i class="glyphicon glyphicon-floppy-save"></i></button>
						<a href="<?php echo site_url('product/category');?>" class="btn btn-default"><i class="glyphicon glyphicon-share-alt"></i></a>
					</div>
				</div>
				<!-- /widget-header -->
				<div class="panel-body page-tab">
					<form action="<?php echo $action;?>" method="post" enctype="multipart/form-data" id="form-category" class="form-horizontal">
						<ul class="nav nav-tabs">
							<li class="active"><a href="#tab-general" aria-controls="tab-general" role="tab" data-toggle="tab">编辑项目</a></li>
							<li><a href="#tab-data" aria-controls="profile" role="tab" data-toggle="tab">基本信息</a></li>
						</ul>

						<!-- Tab panes -->
						<div class="tab-content">
							<div role="tabpanel" class="tab-pane active" id="tab-general">
								<ul class="nav nav-tabs" role="tablist" id="language-list">
									<?php foreach($languages as $language):?>
									<li role="presentation"><a href="#language<?php echo $language['language_id']?>" role="tab" data-toggle="tab"><img  width="16px" height="11px" class="lazy" data-original="public/flags/<?php echo $language['image']?>">&nbsp;&nbsp;<?php echo $language['name']?></a></li>
									<?php endforeach;?>
								</ul>
								<!-- Tab panes -->
								<div class="tab-content" id="language-form">
									<?php foreach($languages as $language):?>
									<div role="tabpanel" class="tab-pane" id="language<?php echo $language['language_id']?>">
										<div class="form-group">
											<label class="col-sm-2 control-label" for="name"><span style="color:red">*</span>分类名称</label>
											<div class="col-sm-10">
												<input type="text" class="form-control" name="category_description[<?php echo $language['language_id']?>][name]" id="input-name<?php echo $language['language_id']?>" placeholder="分类名称" value="<?php echo isset($category_description[$language['language_id']]) ? $category_description[$language['language_id']]['name'] : ''; ?>">
												<?php if(!empty($error_name)):?><label class="text-danger"><?php echo isset($error_name[$language['language_id']]) ? $error_name[$language['language_id']] : '';?></label><?php endif;?>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="description">分类描述</label>
											<div class="col-sm-10">
												<textarea name="category_description[<?php echo $language['language_id']; ?>][description]" id="input-description<?php echo $language['language_id']; ?>" class="form-control" placeholder="分类描述"><?php echo isset($category_description[$language['language_id']]['description']) ? $category_description[$language['language_id']]['description'] : ''; ?></textarea>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="meta_title"><span style="color:red">*</span>mate标签</label>
											<div class="col-sm-10">
												<input type="text" class="form-control" id="meta_title" name="category_description[<?php echo $language['language_id']; ?>][meta_title]" placeholder="mat标签" value="<?php echo isset($category_description[$language['language_id']]) ? $category_description[$language['language_id']]['meta_title'] : ''; ?>">
												<?php if(!empty($error_meta_title)):?><label class="text-danger"><?php echo isset($error_meta_title[$language['language_id']]) ? $error_meta_title[$language['language_id']] : '';?></label><?php endif;?>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="meta-description">mate标签描述</label>
											<div class="col-sm-10">
												<textarea rows="5" name="category_description[<?php echo $language['language_id']; ?>][meta_description]" class="form-control" placeholder="1253645"><?php echo isset($category_description[$language['language_id']]) ? $category_description[$language['language_id']]['meta_description'] : ''; ?></textarea>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="meta-keyword">mate标签关键词</label>
											<div class="col-sm-10">
												<textarea class="form-control" cols="20" rows="5" name="category_description[<?php echo $language['language_id']; ?>][meta_keyword]" placeholder="555"><?php echo isset($category_description[$language['language_id']]) ? $category_description[$language['language_id']]['meta_keyword'] : ''; ?></textarea>
											</div>
										</div>
									</div>
									<?php endforeach;?>
								</div>
							</div>
							<div role="tabpanel" class="tab-pane" id="tab-data">
								<div class="form-group">
									<label class="col-sm-2 control-label" for="image">分类图片</label>
									<div class="col-sm-10">
										<a href="" id="thumb-image" data-toggle="sale-image" class="img-thumbnail"><img width="100px" height="100px" class="lazy" data-original="<?php echo isset($image) ? $image : $placeholder_image;?>" alt="分类图片" title="分类图片" data-placeholder="<?php echo $placeholder_image;?>" /></a>
										<input type="hidden" name="base[image]" value="<?php echo isset($image) ? $image : '';?>" id="input-image" />
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="parent-id">上级分类</label>
									<div class="col-sm-10">
										<select name="base[parent_id]" class="form-control">
											<option value="">--无--</option>
											<?php foreach($cotegorys_select as $category):?>
											<?php if($parent_id == $category['category_id']):?>
											<option value="<?php echo $category['category_id']?>" selected><?php echo $category['name'];?></option>
											<?php else:?>
											<option value="<?php echo $category['category_id']?>"><?php echo $category['name'];?></option>
											<?php endif;?>
											<?php endforeach;?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="sort_order">排序</label>
									<div class="col-sm-10">
										<input type="text" name="base[sort_order]" class="form-control" id="sort_order" placeholder="排序" value="<?php echo !empty($sort_order) ? $sort_order : '0'?>">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="status">状态</label>
									<div class="col-sm-10">
										<select name="base[status]" class="form-control" id="status">
											<?php if($status == TRUE):?>
											<option value="1" checked>启用</option>
											<option value="0">停用</option>
											<?php else:?>
											<option value="1">启用</option>
											<option value="0" checked>停用</option>
											<?php endif;?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="column">二级目录分几列显示</label>
									<div class="col-sm-10">
										<input type="text" name="base[column]" class="form-control" id="column" placeholder="显示几列" value="<?php echo !empty($column) ? $column : '1';?>">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="top">顶部导航显示</label>
									<div class="col-sm-10">
										<?php if($top == TRUE):?>
										<label class="radio-inline"><input type="radio" name="base[top]" id="top" value="1" checked>是</label>
										<label class="radio-inline"><input type="radio" name="base[top]" id="top" value="0">否</label>
										<?php else:?>
										<label class="radio-inline"><input type="radio" name="base[top]" id="top" value="1">是</label>
										<label class="radio-inline"><input type="radio" name="base[top]" id="top" value="0" checked>否</label>
										<?php endif;?>
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
	$(document).ready(function () {
			$('#input-description<?php echo $language['language_id']; ?>').summernote({
					height: 200,                 // set editor height
				});
		});
	<?php endforeach; ?>

	//
	<?php if(!empty($error_warning)):?>
	$(document).ready(function () {
			$.notify({
					// options
					icon: 'icon-warning-sign',
					message: '<?php echo $error_warning;?>' 
				},{
					// settings
					type: 'danger'
				});
		});
	<?php endif;?>
</script>
<?php echo $footer;//装载header?>