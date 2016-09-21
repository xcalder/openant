<?php echo $header;//装载header?>
<?php echo $top;//装载top?>
<!-- /subnavbar -->
<div class="container">
  <div class="row">
    <div class="col-md-12 middle-flat-left">
      <div class="panel panel-default">
        <div class="panel-heading row row-panel-heading bg-info">
	        <p class="navbar-left"><i class="glyphicon glyphicon-edit"></i>&nbsp;编辑地区</p>
	    	<div class="navbar-right btn-group" style="margin-right: 0">
			  <button type="button" onclick="submit('form-zone')" class="btn btn-default"><i class="glyphicon glyphicon-floppy-save"></i></button>
			  <a href="<?php echo site_url('localisation/zone');?>" class="btn btn-default"><i class="glyphicon glyphicon-share-alt"></i></a>
			</div>
        </div>
        <!-- /widget-header -->
        <div class="panel-body page-tab">
          <form action="<?php echo $action;?>" method="post" enctype="multipart/form-data" id="form-zone" class="form-horizontal">
          	<div class="form-group" id="language">
				<label class="col-sm-2 control-label" for="zone_name"><span style="color: red">*&nbsp;</span>地区名称</label>
				<div class="col-sm-10">
				<?php foreach($languages as $language):?>
					<div class="input-group">
					  <span class="input-group-addon"><img width="16px" height="11px" class="lazy" data-original="public/flags/<?php echo $language['image']?>"></span>
					  <input type="text" name="description[<?php echo $language['language_id']?>][zone_name]" class="form-control" placeholder="地区名称" value="<?php echo isset($description[$language['language_id']]['zone_name']) ? $description[$language['language_id']]['zone_name'] : '';?>">
					</div>
					<?php if(isset($error_description[$language['language_id']]['error_zone_name'])):?><label class="text-danger"><?php echo $error_description[$language['language_id']]['error_zone_name'];?></label><?php endif;?>
				<?php endforeach;?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="code">地区代码</label>
				<div class="col-sm-10">
					<input type="text" name="base[code]" class="form-control" id="code" placeholder="排序" value="<?php echo $code;?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="country_id">所在国家</label>
				<div class="col-sm-10">
					<select name="base[country_id]" class="form-control" id="country_id">
						<?php foreach($countrys as $country):?>
						<?php if($country['country_id'] == $country_id):?>
						<option value="<?php echo $country['country_id'];?>" selected><?php echo $country['name'];?></option>
						<?php else:?>
						<option value="<?php echo $country['country_id'];?>"><?php echo $country['name'];?></option>
						<?php endif;?>
						<?php endforeach;?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="postcode_required">状态</label>
				<div class="col-sm-10">
					<select name="base[status]" class="form-control" id="status">
						<?php if($status == '1'):?>
						<option value="1" selected>启用</option>
						<option value="0">禁用</option>
						<?php else:?>
						<option value="1">启用</option>
						<option value="0" selected>禁用</option>
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