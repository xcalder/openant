<?php echo $header;//装载header?>
<?php echo $top;//装载top?>
<!-- /subnavbar -->
<div class="container">
  <div class="row">
    <div class="col-md-12 middle-flat-left">
      <div class="panel panel-default">
        <div class="panel-heading row row-panel-heading bg-info">
	        <p class="navbar-left"><i class="glyphicon glyphicon-edit"></i>&nbsp;编辑权限</p>
	    	<div class="navbar-right btn-group" style="margin-right: 0">
			  <button type="button" onclick="submit('form-competence')" class="btn btn-sm btn-default"><i class="glyphicon glyphicon-floppy-save"></i></button>
			  <a href="<?php echo $this->config->item('admin').'/common/competence';?>" class="btn btn-sm btn-default"><i class="glyphicon glyphicon-share-alt"></i></a>
			</div>
        </div>
        <!-- /widget-header -->
        <div class="panel-body page-tab">
          <form action="<?php echo $action;?>" method="post" enctype="multipart/form-data" id="form-competence" class="form-horizontal">
          	<div class="form-group" id="language">
				<label class="col-sm-2 control-label" for="title"><span style="color: red">*&nbsp;</span>权限名称</label>
				<div class="col-sm-10">
				<?php foreach($languages as $language):?>
					<div class="input-group">
					  <span class="input-group-addon"><img width="16px" height="11px" class="lazy" data-original="resources/public/flags/<?php echo $language['image']?>"></span>
					  <input type="text" name="description[<?php echo $language['language_id']?>][title]" id="title" class="form-control" placeholder="权限名称" value="<?php echo isset($description[$language['language_id']]['title']) ? $description[$language['language_id']]['title'] : '';?>">
					</div>
					<?php if(isset($error_description[$language['language_id']]['error_title'])):?><label class="text-danger"><?php echo $error_description[$language['language_id']]['error_title'];?></label><?php endif;?>
				<?php endforeach;?>
				</div>
			</div>
			<div class="form-group" id="language">
				<label class="col-sm-2 control-label" for="description">权限描述</label>
				<div class="col-sm-10">
				<?php foreach($languages as $language):?>
					<div class="input-group">
					  <span class="input-group-addon"><img width="16px" height="11px" class="lazy" data-original="resources/public/flags/<?php echo $language['image']?>"></span>
					  <input type="text" name="description[<?php echo $language['language_id']?>][description]" id="description" class="form-control" placeholder="权限描述" value="<?php echo isset($description[$language['language_id']]['description']) ? $description[$language['language_id']]['description'] : '';?>">
					</div>
					<?php endforeach;?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="key">类型</label>
				<div class="col-sm-10">
					<select name="base[key]" class="form-control" id="key">
						<?php if($key == 'edit'):?>
						<option value="access">访问</option>
						<option value="edit" selected>修改</option>
						<?php else:?>
						<option value="access" selected>访问</option>
						<option value="edit">修改</option>
						<?php endif;?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="value">权限值</label>
				<div class="col-sm-10">
					<input type="text" name="base[value]" class="form-control" id="value" placeholder="权限值" value="<?php echo $value;?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="sort_order">排序</label>
				<div class="col-sm-10">
					<input type="text" name="base[sort_order]" class="form-control" id="sort_order" placeholder="排序" value="<?php echo $sort_order;?>">
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