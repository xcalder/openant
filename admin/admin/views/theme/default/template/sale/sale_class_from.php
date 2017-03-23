<?php echo $header;//装载header?>
<?php echo $top;//装载login_top?>
<!-- /subnavbar -->
<div class="container">
  <div class="row">
    <div class="col-md-12 middle-flat-left" role="main">
      <div class="panel panel-default">
        <div class="panel-heading row row-panel-heading bg-info">
        	<h3 class="navbar-left"> <i class="glyphicon glyphicon-th-list"></i>&nbsp;修改商家组</h3>
        	<div class="navbar-right btn-group" role="group" aria-label="..." style="margin-right: 0">
				<button type="button" onclick="submit('form-sale-class-edit')" class="btn btn-sm btn-default"><i class="glyphicon glyphicon-floppy-save"></i></button>
				<a href="<?php echo $this->config->item('admin').'sale/sale_class';?>" class="btn btn-sm btn-default"><i class="glyphicon glyphicon-share-alt"></i></a>
			</div>
        </div>
        <!-- /widget-header -->
            <div class="panel-body">
            	<form action="<?php echo $action;?>" method="post" enctype="multipart/form-data" id="form-sale-class-edit" class="form-horizontal">
					<div class="form-group" id="language">
						<label class="col-sm-2 control-label" for="nickname"><span style="color: red">*</span>&nbsp;名称</label>
						<div class="col-sm-10">
							<?php foreach($languages as $language):?>
							<div class="input-group">
							<span class="input-group-addon"><img  width="16px" height="11px" class="lazy" data-original="resources/public/flags/<?php echo $language['image'];?>"></span>
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
							<span class="input-group-addon"><img  width="16px" height="11px" class="lazy" data-original="resources/public/flags/<?php echo $language['image'];?>"></span>
							<textarea class="form-control" rows="3" id="language-description" name="description[<?php echo $language['language_id']?>][description]" placeholder="描述"><?php echo isset($description[$language['language_id']]['description']) ? $description[$language['language_id']]['description'] : '';?></textarea>
							</div>
							<?php endforeach;?>
							<?php endif;?>
						</div>
					</div>
	            	<div class="form-group">
						<label class="col-sm-2 control-label" for="level">多少交易额升级</label>
						<div class="col-sm-10">
							<input type="text" name="sale_class[level]" id="level" class="form-control" placeholder="多少分升级" value="<?php echo isset($level) ? $level : '0';?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="sort-order">排序</label>
						<div class="col-sm-10">
							<input type="text" name="sale_class[sort_order]" class="form-control" id="" placeholder="排序" value="<?php echo isset($sort_order) ? $sort_order : '0';?>">
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