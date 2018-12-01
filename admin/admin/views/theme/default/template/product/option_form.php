<?php echo $header;//装载header?>
<?php echo $top;//装载top?>
<!-- /subnavbar -->
<div class="container">
	<div class="row">
		<div class="col-md-12 middle-flat-left">
			<div class="panel panel-default" id="edit-option">
				<div class="panel-heading row row-panel-heading bg-info">
					<p class="navbar-left"><i class="glyphicon glyphicon-edit"></i>&nbsp;编辑商品选项</p>
					<div class="navbar-right btn-group" style="margin-right: 0">
						<button type="button" onclick="submit('form-edit-option')" class="btn btn-sm btn-default"><i class="glyphicon glyphicon-floppy-save"></i></button>
						<a href="<?php echo $this->config->item('admin').'/product/option';?>#option-list" class="btn btn-sm btn-default"><i class="glyphicon glyphicon-share-alt"></i></a>
					</div>
				</div>
				<!-- /widget-header -->
				<div class="panel-body page-tab">
				  <form action="<?php echo $option_action;?>" method="post" enctype="multipart/form-data" id="form-edit-option" class="form-horizontal">
					<div class="form-group" id="language">
						<label class="col-sm-2 control-label" for="option-description-name"><span style="color: red">*&nbsp;</span>选项名称</label>
						<div class="col-sm-10">
							<?php foreach($languages as $language):?>
							<div class="input-group">
							  <span class="input-group-addon" id="basic-addon1"><img width="16px" height="11px" class="lazy" data-original="resources/public/flags/<?php echo $language['image']?>"></span>
							  <input type="text" name="description[<?php echo $language['language_id']?>][name]" class="form-control" placeholder="选项名称" value="<?php echo isset($description[$language['language_id']]['name']) ? $description[$language['language_id']]['name'] : '';?>">
							</div>
							<?php if(isset($error_option_description)):?><label class="text-danger"><?php echo $error_option_description[$language['language_id']]['error_option_name']?></label><?php endif;?>
							<?php endforeach;?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="option-group"><span style="color: red">*&nbsp;</span>选项组</label>
						<div class="col-sm-10">
							<select name="base[option_group_id]" class="form-control">
							  <?php if($option_groups):?>
							  <?php foreach($option_groups as $key=>$value):?>
							  <?php if($option_group_id == $option_groups[$key]['option_group_id']):?>
							  <option value="<?php echo $option_groups[$key]['option_group_id'];?>" selected><?php echo $option_groups[$key]['option_group_name'];?></option>
							  <?php else:?>
							  <option value="<?php echo $option_groups[$key]['option_group_id'];?>"><?php echo $option_groups[$key]['option_group_name'];?></option>
							  <?php endif;?>
							  <?php endforeach;?>
							  <?php endif;?>
							</select>
							<?php if(isset($error_option_group_id)):?><label class="text-danger"><?php echo $error_option_group_id;?></label><?php endif;?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="option-sort-order">排序</label>
						<div class="col-sm-10">
							<input type="text" name="base[sort_order]" class="form-control" placeholder="排序" value="<?php echo isset($option_sort_order) ? $option_sort_order : '0';?>">
						</div>
					</div>
				  </form>
				  <!-- /shortcuts --> 
				</div>
				<!-- /widget-content --> 
			</div>
		  <!-- /widget -->
		  <div class="panel panel-default" id="edit-option-group">
			<div class="panel-heading row row-panel-heading bg-info">
				<p class="navbar-left"><i class="glyphicon glyphicon-edit"></i>&nbsp;编辑商品选项组</p>
				<div class="navbar-right btn-group" style="margin-right: 0">
					<button type="button" onclick="submit('form-edit-option-group')" class="btn btn-sm btn-default"><i class="glyphicon glyphicon-floppy-save"></i></button>
					<a href="<?php echo $this->config->item('admin').'/product/option';?>#option-group" class="btn btn-sm btn-default"><i class="glyphicon glyphicon-share-alt"></i></a>
				</div>
			</div>
			<!-- /widget-header -->
			<div class="panel-body page-tab">
				<form action="<?php echo $option_group_action;?>" method="post" enctype="multipart/form-data" id="form-edit-option-group" class="form-horizontal">
					<div class="form-group" id="language">
						<label class="col-sm-2 control-label" for="option-group-name"><span style="color: red">*&nbsp;</span>选项组名称</label>
						<div class="col-sm-10">
							<?php foreach($languages as $language):?>
							<div class="input-group">
							  <span class="input-group-addon"><img width="16px" height="11px" class="lazy" data-original="resources/public/flags/<?php echo $language['image']?>"></span>
							  <input type="text" name="group_description[<?php echo $language['language_id']?>][option_group_name]" class="form-control" placeholder="选项组名称" value="<?php echo isset($group_description[$language['language_id']]['option_group_name']) ? $group_description[$language['language_id']]['option_group_name'] : '';?>">
							</div>
							<?php if(isset($option_group_description)):?><label class="text-danger"><?php echo $option_group_description[$language['language_id']]['error_option_group_name']?></label><?php endif;?>
							<?php endforeach;?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="option-group-type">前台显示类型</label>
						<div class="col-sm-10">
							<select name="group_base[type]" class="form-control">
								<?php if(isset($option_group_type) && $option_group_type == 'image'):?>
								<option value="image" selected>图片</option>
								<option value="text">文字</option>
								<?php else:?>
								<option value="image">图片</option>
								<option value="text" selected>文字</option>
								<?php endif;?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="option-group-sale-type">商家填写类型</label>
						<div class="col-sm-10">
							<select name="group_base[sale_type]" class="form-control" id="option-group-sale-type">
								<?php if(isset($option_group_sale_type) && $option_group_sale_type == 'image'):?>
									<option value="image" selected>图片+列表</option>
									<option value="select">列表</option>
								<?php elseif(isset($option_group_sale_type) && $option_group_sale_type == 'text'):?>
									<option value="image">图片+列表</option>
									<option value="select">列表</option>
									<?php else:?>
									<option value="image">图片+列表</option>
									<option value="select" selected>列表</option>
								<?php endif;?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="option-group-sort-order">排序</label>
						<div class="col-sm-10">
							<input type="text" name="group_base[sort_order]" class="form-control" placeholder="排序" value="<?php echo isset($option_group_sort_order) ? $option_group_sort_order : '0';?>">
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
