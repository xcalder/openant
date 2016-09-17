<?php echo $header;//装载header?>
<?php echo $top;//装载top?>
<!-- /subnavbar -->
<div class="container">
  <div class="row">
    <div class="col-md-12 middle-flat-left">
      <div class="panel panel-default">
        <div class="panel-heading row row-panel-heading bg-info">
	        <p class="navbar-left"><i class="glyphicon glyphicon-edit"></i>&nbsp;编辑货币</p>
	    	<div class="navbar-right btn-group" style="margin-right: 0">
			  <button type="button" onclick="submit('form-currency')" class="btn btn-default"><i class="glyphicon glyphicon-floppy-save"></i></button>
			  <a href="<?php echo site_url('localisation/currency');?>" class="btn btn-default"><i class="glyphicon glyphicon-share-alt"></i></a>
			</div>
        </div>
        <!-- /widget-header -->
        <div class="panel-body page-tab">
          <form action="<?php echo $action;?>" method="post" enctype="multipart/form-data" id="form-currency" class="form-horizontal">
          	<div class="form-group">
				<label class="col-sm-2 control-label" for="title"><span style="color: red">*&nbsp;</span>货币名称</label>
				<div class="col-sm-10">
					<input type="text" name="title" class="form-control" id="title" placeholder="货币名称" value="<?php echo $title;?>">
					<?php if(isset($error_title)):?><label class="text-danger"><?php echo $error_title;?></label><?php endif;?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="code"><span style="color: red">*&nbsp;</span>货币国际标码</label>
				<div class="col-sm-10">
					<input type="text" name="code" class="form-control" id="code" placeholder="货币国际标码" value="<?PHP echo $code;?>">
					<?php if(isset($error_code)):?><label class="text-danger"><?php echo $error_code;?></label><?php endif;?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="symbol_left">左符号</label>
				<div class="col-sm-10">
					<input type="text" name="symbol_left" class="form-control" id="symbol_left" placeholder="左符号" value="<?php echo $symbol_left;?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="symbol_right">右符号</label>
				<div class="col-sm-10">
					<input type="text" name="symbol_right" class="form-control" id="symbol_right" placeholder="右符号" value="<?php echo $symbol_right;?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="decimal_place">小数位数</label>
				<div class="col-sm-10">
					<input type="text" name="decimal_place" class="form-control" id="decimal_place" placeholder="小数位数" value="<?php echo $decimal_place;?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="value">汇率</label>
				<div class="col-sm-10">
					<input type="text" name="value" class="form-control" id="value" placeholder="汇率" value="<?php echo $value;?>">
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