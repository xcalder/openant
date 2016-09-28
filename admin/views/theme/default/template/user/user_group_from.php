<?php echo $header;//装载header?>
<?php echo $top;//装载login_top?>
<!-- /subnavbar -->
<div class="container">
  <div class="row">
    <div class="col-md-12 middle-flat-left" role="main">
      <div class="panel panel-default">
        <div class="panel-heading row row-panel-heading bg-info">
        	<h3 class="navbar-left"> <i class="glyphicon glyphicon-th-list"></i>&nbsp;修改权限组</h3>
        	<div class="navbar-right btn-group" role="group" aria-label="..." style="margin-right: 0">
				<button type="button" onclick="submit('form-user-group-edit')" class="btn btn-sm btn-default"><i class="glyphicon glyphicon-floppy-save"></i></button>
				<a href="<?php echo site_url('user/user_group');?>" class="btn btn-sm btn-default"><i class="glyphicon glyphicon-share-alt"></i></a>
			</div>
        </div>
        <!-- /widget-header -->
            <div class="panel-body">
            	<form action="<?php echo $action;?>" method="post" enctype="multipart/form-data" id="form-user-group-edit" class="form-horizontal">
					<div class="form-group" id="language">
						<label class="col-sm-2 control-label" for="nickname"><span style="color: red">*</span>&nbsp;名称</label>
						<div class="col-sm-10">
							<?php foreach($languages as $language):?>
							<div class="input-group">
							<span class="input-group-addon"><img  width="16px" height="11px" class="lazy" data-original="public/flags/<?php echo $language['image'];?>"></span>
							<input type="text" class="form-control" placeholder="名称" name="description[<?php echo $language['language_id']?>][name]" value="<?php echo isset($description[$language['language_id']]['name']) ? $description[$language['language_id']]['name'] : '';?>">
							</div>
							<?php if(isset($error[$language['language_id']]['error_name'])):?>
							<label style="color: red"><?php echo $error[$language['language_id']]['error_name'];?></label>
							<?php endif;?>
							<?php endforeach;?>
						</div>
					</div>
					<div class="form-group" id="language">
						<label class="col-sm-2 control-label" for="desciption">描述</label>
						<div class="col-sm-10">
							<?php if(isset($languages)):?>
							<?php foreach($languages as $language):?>
							<div class="input-group">
							<span class="input-group-addon"><img  width="16px" height="11px" class="lazy" data-original="public/flags/<?php echo $language['image'];?>"></span>
							<textarea class="form-control" rows="3" id="language-description" name="description[<?php echo $language['language_id']?>][description]" placeholder="描述"><?php echo isset($description[$language['language_id']]['description']) ? $description[$language['language_id']]['description'] : '';?></textarea>
							</div>
							<?php endforeach;?>
							<?php endif;?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="sort-order">访问权限</label>
						<div class="col-sm-10">
							<div class="well well-sm" style="height: 150px; overflow: auto;">
								<?php foreach($admin_maps as $admin_map):?>
								<?php if(isset($access)):?>
								<?php if(in_array($admin_map,$access)):?>
								<div class="checkbox">
									<label>
										<input type="checkbox" name="user_group[access][]" value="<?php echo $admin_map?>" checked><?php echo $admin_map?>
									</label>
								</div>
								<?php else:?>
								<div class="checkbox">
									<label>
										<input type="checkbox" name="user_group[access][]" value="<?php echo $admin_map?>"><?php echo $admin_map?>
									</label>
								</div>
								<?php endif;?>
								<?php else:?>
								<div class="checkbox">
									<label>
										<input type="checkbox" name="user_group[access][]" value="<?php echo $admin_map?>"><?php echo $admin_map?>
									</label>
								</div>
								<?php endif;?>
								<?php endforeach;?>
								<hr style="margin: 5px 0;border-top:1px solid red">
								<?php foreach($sale_maps as $sale_map):?>
								<?php if(isset($access)):?>
								<?php if(in_array($sale_map,$access)):?>
								<div class="checkbox">
									<label>
										<input type="checkbox" name="user_group[access][]" value="<?php echo $sale_map?>" checked><?php echo $sale_map?>
									</label>
								</div>
								<?php else:?>
								<div class="checkbox">
									<label>
										<input type="checkbox" name="user_group[access][]" value="<?php echo $sale_map?>"><?php echo $sale_map?>
									</label>
								</div>
								<?php endif;?>
								<?php else:?>
								<div class="checkbox">
									<label>
										<input type="checkbox" name="user_group[access][]" value="<?php echo $sale_map?>"><?php echo $sale_map?>
									</label>
								</div>
								<?php endif;?>
								<?php endforeach;?>
							</div>
							<a onclick="$(this).parent().find(':checkbox').prop('checked', true);" style="cursor: pointer;">全选</a> / <a onclick="$(this).parent().find(':checkbox').prop('checked', false);">全不选</a>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="sort-order">修改权限</label>
						<div class="col-sm-10">
							<div class="well well-sm" style="height: 150px; overflow: auto;">
								<?php foreach($admin_maps as $admin_map):?>
								<?php if(isset($modify)):?>
								<?php if(in_array($admin_map,$modify)):?>
								<div class="checkbox">
									<label>
										<input type="checkbox" name="user_group[modify][]" value="<?php echo $admin_map?>" checked><?php echo $admin_map?>
									</label>
								</div>
								<?php else:?>
								<div class="checkbox">
									<label>
										<input type="checkbox" name="user_group[modify][]" value="<?php echo $admin_map?>"><?php echo $admin_map?>
									</label>
								</div>
								<?php endif;?>
								<?php else:?>
								<div class="checkbox">
									<label>
										<input type="checkbox" name="user_group[modify][]" value="<?php echo $admin_map?>"><?php echo $admin_map?>
									</label>
								</div>
								<?php endif;?>
								<?php endforeach;?>
								<hr style="margin: 5px 0;border-top:1px solid red">
								<?php foreach($sale_maps as $sale_map):?>
								<?php if(isset($modify)):?>
								<?php if(in_array($sale_map,$modify)):?>
								<div class="checkbox">
									<label>
										<input type="checkbox" name="user_group[modify][]" value="<?php echo $sale_map?>" checked><?php echo $sale_map?>
									</label>
								</div>
								<?php else:?>
								<div class="checkbox">
									<label>
										<input type="checkbox" name="user_group[modify][]" value="<?php echo $sale_map?>"><?php echo $sale_map?>
									</label>
								</div>
								<?php endif;?>
								<?php else:?>
								<div class="checkbox">
									<label>
										<input type="checkbox" name="user_group[modify][]" value="<?php echo $sale_map?>"><?php echo $sale_map?>
									</label>
								</div>
								<?php endif;?>
								<?php endforeach;?>
							</div>
							<a onclick="$(this).parent().find(':checkbox').prop('checked', true);" style="cursor: pointer;">全选</a> / <a onclick="$(this).parent().find(':checkbox').prop('checked', false);">全不选</a>
						</div>
					</div>
	            	
					<div class="form-group">
						<label class="col-sm-2 control-label" for="sort-order">排序</label>
						<div class="col-sm-10">
							<input type="text" name="user_group[sort_order]" class="form-control" id="" placeholder="排序" value="<?php echo isset($sort_order) ? $sort_order : '0';?>">
						</div>
					</div>
	            </div>
			</form>
		</div>
            <!-- /widget-content --> 
      </div>
      <!-- /widget --> 
    </div>
  </div>
  <!-- /row --> 
</div>
<!-- /container -->
<?php echo $footer;?>