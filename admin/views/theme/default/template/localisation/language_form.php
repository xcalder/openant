<?php echo $header;//装载header?>
<?php echo $top;//装载top?>
<!-- /subnavbar -->
<div class="container">
  <div class="row">
    <div class="col-md-12 middle-flat-left">
      <div class="panel panel-default">
        <div class="panel-heading row row-panel-heading bg-info">
	        <p class="navbar-left"><i class="glyphicon glyphicon-edit"></i>&nbsp;编辑语言</p>
	    	<div class="navbar-right btn-group" style="margin-right: 0">
			  <button type="button" onclick="submit('form-language')" class="btn btn-default"><i class="glyphicon glyphicon-floppy-save"></i></button>
			  <a href="<?php echo site_url('localisation/language');?>" class="btn btn-default"><i class="glyphicon glyphicon-share-alt"></i></a>
			</div>
        </div>
        <!-- /widget-header -->
        <div class="panel-body page-tab">
          <form action="<?php echo $action;?>" method="post" enctype="multipart/form-data" id="form-language" class="form-horizontal">
          	<div class="form-group">
				<label class="col-sm-2 control-label" for="name"><span style="color: red">*&nbsp;</span>语言名称</label>
				<div class="col-sm-10">
					<input type="text" name="name" class="form-control" id="name" placeholder="语言名称" value="<?php echo $name;?>">
					<?php if(isset($error_name)):?><label class="text-danger"><?php echo $error_name;?></label><?php endif;?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="code"><span style="color: red">*&nbsp;</span>语言国际标码</label>
				<div class="col-sm-10">
					<input type="text" name="code" class="form-control" id="code" placeholder="语言国际标码" value="<?PHP echo $code;?>">
					<?php if(isset($error_code)):?><label class="text-danger"><?php echo $error_code;?></label><?php endif;?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="locale">本地编码</label>
				<div class="col-sm-10">
					<input type="text" name="locale" class="form-control" id="locale" placeholder="本地编码,使用[,]隔开" value="<?php echo $locale;?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="image"><span style="color: red">*&nbsp;</span>语言图标</label>
				<div class="col-sm-10">
					<input type="text" name="image" class="form-control" id="image" placeholder="语言图标" value="<?php echo $image;?>">
					<?php if(isset($error_image)):?><label class="text-danger"><?php echo $error_image;?></label><?php endif;?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="language_name"><span style="color: red">*&nbsp;</span>语言所在文件</label>
				<div class="col-sm-10">
					<input type="text" name="language_name" class="form-control" id="language_name" placeholder="语言所在文件" value="<?php echo $language_name;?>">
					<?php if(isset($error_language_name)):?><label class="text-danger"><?php echo $error_language_name;?></label><?php endif;?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="sort_order">排序</label>
				<div class="col-sm-10">
					<input type="text" name="sort_order" class="form-control" id="sort_order" placeholder="排序" value="<?php echo $sort_order;?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="status">状态</label>
				<div class="col-sm-10">
					<select class="form-control" name="status">
						<?php if($status == '1'):?>
						<option value="1" selected>启用</option>
						<option value="0">停用</option>
						<?php else:?>
						<option value="1">启用</option>
						<option value="0" selected>停用</option>
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