<?php echo $header;//装载header?>
<?php echo $top;//装载top?>
<!-- /subnavbar -->
<div class="container">
  <div class="row">
    <div class="col-md-12 middle-flat-left">
      <div class="panel panel-default">
        <div class="panel-heading row row-panel-heading bg-info">
	        <p class="navbar-left"><i class="glyphicon glyphicon-edit"></i>&nbsp;编辑税率</p>
	    	<div class="navbar-right btn-group" style="margin-right: 0">
			  <button type="button" onclick="submit('form-tax_rate')" class="btn btn-default"><i class="glyphicon glyphicon-floppy-save"></i></button>
			  <a href="<?php echo site_url('localisation/tax_rate');?>" class="btn btn-default"><i class="glyphicon glyphicon-share-alt"></i></a>
			</div>
        </div>
        <!-- /widget-header -->
        <div class="panel-body page-tab">
          <form action="<?php echo $action;?>" method="post" enctype="multipart/form-data" id="form-tax_rate" class="form-horizontal">
          	<div class="form-group" id="language">
				<label class="col-sm-2 control-label" for="name"><span style="color: red">*&nbsp;</span>税率名称</label>
				<div class="col-sm-10">
				<?php foreach($languages as $language):?>
					<div class="input-group">
					  <span class="input-group-addon"><img width="16px" height="11px" class="lazy" data-original="public/flags/<?php echo $language['image']?>"></span>
					  <input type="text" name="description[<?php echo $language['language_id']?>][name]" class="form-control" placeholder="税率名称" value="<?php echo isset($description[$language['language_id']]['name']) ? $description[$language['language_id']]['name'] : '';?>">
					</div>
					<?php if(isset($error_description[$language['language_id']]['error_name'])):?><label class="text-danger"><?php echo $error_description[$language['language_id']]['error_name'];?></label><?php endif;?>
				<?php endforeach;?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="sort_order"><span style="color: red">*&nbsp;</span>税率</label>
				<div class="col-sm-10">
					<input type="text" name="base[rate]" class="form-control" id="rate" placeholder="税率" value="<?php echo $rate;?>">
					<?php if(isset($error_rate)):?><label class="text-danger"><?php echo $error_rate;?></label><?php endif;?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="sort_order">类型</label>
				<div class="col-sm-10">
					<select class="form-control" id="type" name="base[type]">
						<?php if($type == 'F'):?>
						<option value="F" selected>固定费率</option>
						<option value="P">百分比</option>
						<?php else:?>
						<option value="F">固定费率</option>
						<option value="P" selected>百分比</option>
						<?php endif;?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="sort_order">用户组</label>
				<div class="col-sm-10">
					<select class="form-control" id="type" name="user_class[user_class_id]">
						<?php if($user_groups):?>
						<?php foreach($user_groups as $user_group):?>
						<?php if($user_group['user_class_id'] == $user_class_id):?>
						<option value="<?php echo $user_group['user_class_id'];?>" selected><?php echo $user_group['name'];?></option>
						<?php else:?>
						<option value="<?php echo $user_group['user_class_id'];?>"><?php echo $user_group['name'];?></option>
						<?php endif;?>
						<?php endforeach;?>
						<?php endif;?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="sort_order">区域组</label>
				<div class="col-sm-10">
					<select class="form-control" id="type" name="base[geo_zone_id]">
						<?php if($geo_zones):?>
						<?php foreach($geo_zones as $key=>$geo_zone):?>
						<?php if($geo_zones[$key]['geo_zone_id'] == $geo_zone_id):?>
						<option value="<?php echo $geo_zones[$key]['geo_zone_id'];?>" selected><?php echo $geo_zones[$key]['geo_zone_name'];?></option>
						<?php else:?>
						<option value="<?php echo $geo_zones[$key]['geo_zone_id'];?>"><?php echo $geo_zones[$key]['geo_zone_name'];?></option>
						<?php endif;?>
						<?php endforeach;?>
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