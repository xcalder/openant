<?php echo $header;//装载header?>
<?php echo $top;//装载top?>
<!-- /subnavbar -->
<div class="container">
  <div class="row">
    <div class="col-md-12 middle-flat-left">
      <div class="panel panel-default">
        <div class="panel-heading  row row-panel-heading bg-info">
	        <p class="navbar-left"><i class="glyphicon glyphicon-edit"></i>&nbsp;编辑发货状态</p>
	    	<div class="navbar-right btn-group" style="margin-right: 0">
			  <button type="button" onclick="submit('form-return_status')" class="btn btn-default"><i class="glyphicon glyphicon-floppy-save"></i></button>
			  <a href="<?php echo site_url('localisation/return_status');?>" class="btn btn-default"><i class="glyphicon glyphicon-share-alt"></i></a>
			</div>
        </div>
        <!-- /widget-header -->
        <div class="panel-body page-tab">
          <form action="<?php echo $action;?>" method="post" enctype="multipart/form-data" id="form-return_status" class="form-horizontal">
          	<div class="form-group" id="language">
				<label class="col-sm-2 control-label" for="name"><span style="color: red">*&nbsp;</span>发货状态名称</label>
				<div class="col-sm-10">
				<?php foreach($languages as $language):?>
					<div class="input-group">
					  <span class="input-group-addon"><img width="16px" height="11px" class="lazy" data-original="public/flags/<?php echo $language['image']?>"></span>
					  <input type="text" name="description[<?php echo $language['language_id']?>][name]" class="form-control" placeholder="发货状态名称" value="<?php echo isset($description[$language['language_id']]['name']) ? $description[$language['language_id']]['name'] : '';?>">
					</div>
					<?php if(isset($error_description[$language['language_id']]['error_name'])):?><label class="text-danger"><?php echo $error_description[$language['language_id']]['error_name'];?></label><?php endif;?>
				<?php endforeach;?>
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