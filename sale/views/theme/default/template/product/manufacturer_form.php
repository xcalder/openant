<?php echo $header;//装载header?>
<?php echo $top;//装载top?>
<!-- /subnavbar -->
<div class="container">
	<div class="row">
		<!-- /span6 -->
		<div class="col-md-12 middle-flat-left">
			<div class="panel panel-default">
				<div class="panel-heading row row-panel-heading bg-info">
					<p class="navbar-left"><i class="glyphicon glyphicon-edit"></i>&nbsp;编辑品牌</p>
					<div class="navbar-right btn-group" style="margin-right: 0">
						<button type="button" onclick="submit('form-manufacturer')" class="btn btn-default"><i class="glyphicon glyphicon-floppy-save"></i></button>
						<a href="<?php echo site_url('product/manufacturer');?>" class="btn btn-default"><i class="glyphicon glyphicon-share-alt"></i></a>
					</div>
				</div>
				<!-- /widget-header -->
				<div class="panel-body page-tab">
					<form action="<?php echo $action;?>" method="post" enctype="multipart/form-data" id="form-manufacturer" class="form-horizontal">
					<div class="form-group">
						<label class="col-sm-2 control-label" for="image">品牌图片</label>
						<div class="col-sm-10">
							<a href="" id="thumb-image" data-toggle="sale-image" class="img-thumbnail"><img width="100px" height="100px" class="lazy" data-original="<?php echo isset($image) ? $image : $placeholder_image;?>" alt="分类图片" title="分类图片" data-placeholder="<?php echo $placeholder_image;?>" /></a>
							<input type="hidden" name="base[image]" value="<?php echo isset($image_old) ? $image_old : '';?>" id="input-image" />
						</div>
					</div>
					<div class="form-group" id="language">
						<label class="col-sm-2 control-label" for="manufacturer-name">品牌名称</label>
						<div class="col-sm-10">
							<?php foreach($languages as $language):?>
							<div class="input-group">
								<span class="input-group-addon"><img  width="16px" height="11px" class="lazy" data-original="public/flags/<?php echo $language['image']?>"></span>
								<input type="text" name="description[<?php echo $language['language_id']?>][name]" class="form-control" placeholder="品牌名称" value="<?php echo isset($descriptions[$language['language_id']]['name']) ? $descriptions[$language['language_id']]['name'] : '';?>">
							</div>
							<?php endforeach;?>
						</div>
					</div>
						<div class="form-group" id="language">
							<label class="col-sm-2 control-label" for="manufacturer-description">品牌描述</label>
							<div class="col-sm-10">
								<?php foreach($languages as $language):?>
								<div class="input-group">
									<span class="input-group-addon"><img  width="16px" height="11px" class="lazy" data-original="public/flags/<?php echo $language['image']?>"></span>
									<input type="text" name="description[<?php echo $language['language_id']?>][description]" class="form-control" placeholder="品牌描述" value="<?php echo isset($descriptions[$language['language_id']]['description']) ? $descriptions[$language['language_id']]['description'] : '';?>">
								</div>
								<?php endforeach;?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="sort_order">排序</label>
							<div class="col-sm-10">
								<input type="text" name="base[sort_order]" class="form-control" id="sort_order" placeholder="排序" value="<?php echo !empty($sort_order) ? $sort_order : '0'?>">
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