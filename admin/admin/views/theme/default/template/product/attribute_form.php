<?php echo $header;//装载header?>
<?php echo $top;//装载top?>
<!-- /subnavbar -->
<div class="container">
	<div class="row">
	<div class="col-md-12 middle-flat-left" role="main">
		<div class="panel panel-default" id="edit-attribute">
			<div class="panel-heading row row-panel-heading bg-info">
				<p class="navbar-left"><i class="glyphicon glyphicon-edit"></i>&nbsp;编辑商品属性</p>
				<div class="navbar-right btn-group" style="margin-right: 0">
					<button type="button" onclick="submit('form-edit-attribute')" class="btn btn-sm btn-default"><i class="glyphicon glyphicon-floppy-save"></i></button>
					<a href="<?php echo $this->config->item('admin').'product/attribute';?>#attribute-list" class="btn btn-sm btn-default"><i class="glyphicon glyphicon-share-alt"></i></a>
				</div>
			</div>
			<!-- /widget-header -->
			<div class="panel-body page-tab">
				<form action="<?php echo $attribute_action;?>" method="post" enctype="multipart/form-data" id="form-edit-attribute" class="form-horizontal">
					<div class="form-group" id="language">
						<label class="col-sm-2 control-label" for="attribute-description-name"><span style="color: red">*&nbsp;</span>属性名称</label>
						<div class="col-sm-10">
							<?php foreach($languages as $language):?>
							<div class="input-group">
								<span class="input-group-addon" id="basic-addon1"><img width="16px" height="11px" class="lazy" data-original="resources/public/flags/<?php echo $language['image']?>"></span>
								<input type="text" name="description[<?php echo $language['language_id']?>][name]" class="form-control" placeholder="属性名称" value="<?php echo isset($description[$language['language_id']]['name']) ? $description[$language['language_id']]['name'] : '';?>">
								<?php if(isset($error_attribute_description)):?><label class="text-danger"><?php echo $error_attribute_description[$language['language_id']]['error_attribute_name']?></label><?php endif;?>
							</div>
							<?php endforeach;?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="attribute-group"><span style="color: red">*&nbsp;</span>属性组</label>
						<div class="col-sm-10">
							<select name="base[attribute_group_id]" class="form-control">
								<?php if($attribute_groups):?>
								<?php foreach($attribute_groups as $key=>$value):?>
								<?php if($attribute_group_id == $attribute_groups[$key]['attribute_group_id']):?>
								<option value="<?php echo $attribute_groups[$key]['attribute_group_id'];?>" selected><?php echo $attribute_groups[$key]['group_name'];?></option>
								<?php else:?>
								<option value="<?php echo $attribute_groups[$key]['attribute_group_id'];?>"><?php echo $attribute_groups[$key]['group_name'];?></option>
								<?php endif;?>
								<?php endforeach;?>
								<?php endif;?>
							</select>
							<?php if(isset($error_attribute_group_id)):?><label class="text-danger"><?php echo $error_attribute_group_id;?></label><?php endif;?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="attribute-sort-order">排序</label>
						<div class="col-sm-10">
							<input type="text" name="base[sort_order]" class="form-control" placeholder="排序" value="<?php echo isset($attribute_sort_order) ? $attribute_sort_order : '0';?>">
						</div>
					</div>
				</form>
				<!-- /shortcuts --> 
			</div>
			<!-- /widget-content --> 
		</div>
			<!-- /widget -->
			<div class="panel panel-default" id="edit-attribute-group">
				<div class="panel-heading row row-panel-heading bg-info">
					<p class="navbar-left"><i class="glyphicon glyphicon-edit"></i>&nbsp;编辑商品属性组</p>
					<div class="navbar-right btn-group" style="margin-right: 0">
						<button type="button" onclick="submit('form-edit-attribute-group')" class="btn btn-sm btn-default"><i class="glyphicon glyphicon-floppy-save"></i></button>
						<a href="<?php echo $this->config->item('admin').'product/attribute';?>#attribute-group" class="btn btn-sm btn-default"><i class="glyphicon glyphicon-share-alt"></i></a>
					</div>
				</div>
				<!-- /widget-header -->
				<div class="panel-body page-tab">
					<form action="<?php echo $attribute_group_action;?>" method="post" enctype="multipart/form-data" id="form-edit-attribute-group" class="form-horizontal">
						<div class="form-group" id="language">
							<label class="col-sm-2 control-label" for="attribute-group-name"><span style="color: red">*&nbsp;</span>属性组名称</label>
							<div class="col-sm-10">
								<?php foreach($languages as $language):?>
								<div class="input-group">
									<span class="input-group-addon"><img width="16px" height="11px" class="lazy" data-original="resources/public/flags/<?php echo $language['image']?>"></span>
									<input type="text" name="group_description[<?php echo $language['language_id']?>][group_name]" class="form-control" placeholder="属性组名称" value="<?php echo isset($group_description[$language['language_id']]['group_name']) ? $group_description[$language['language_id']]['group_name'] : '';?>">
								</div>
								<?php if(isset($attribute_group_description)):?><label class="text-danger"><?php echo $attribute_group_description[$language['language_id']]['error_attribute_group_name']?></label><?php endif;?>
							<?php endforeach;?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="attribute-group-sale_type">填写类型</label>
							<div class="col-sm-10">
								<select name="group_base[sale_type]" id="attribute-group-sale_type" class="form-control">
									<?php if(isset($attribute_group_sale_type) && $attribute_group_sale_type == 'text'):?>
									<option value="text" selected>文字</option>
									<option value="image">图片</option>
									<option value="select">列表</option>
									<?php elseif(isset($attribute_group_sale_type) && $attribute_group_sale_type == 'image'):?>
									<option value="text">文字</option>
									<option value="image" selected>图片</option>
									<option value="select">列表</option>
									<?php else:?>
									<option value="text">文字</option>
									<option value="image">图片</option>
									<option value="select" selected>列表</option>
									<?php endif;?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="attribute-group-sort-order">排序</label>
							<div class="col-sm-10">
								<input type="text" name="group_base[sort_order]" class="form-control" placeholder="排序" value="<?php echo isset($attribute_group_sort_order) ? $attribute_group_sort_order : '0';?>">
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