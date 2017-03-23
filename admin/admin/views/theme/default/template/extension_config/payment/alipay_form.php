<?php echo $header;//装载header?>
<?php echo $top;//装载top?>
<!-- /subnavbar -->
<div class="container">
	<div class="row">
		<div class="col-md-12 middle-flat-left">
			<div class="panel panel-default">
				<div class="panel-heading row row-panel-heading bg-info">
					<p class="navbar-left"><i class="glyphicon glyphicon-edit"></i>编辑<?php echo isset($value['vname']) ? $value['vname'] : 'payment';?></p>
					<div class="navbar-right btn-group" style="margin-right: 0">
						<button type="button" onclick="submit('form-module')" class="btn btn-sm btn-default"><i class="glyphicon glyphicon-floppy-save"></i></button>
						<a href="<?php echo $this->config->item('admin').'extension_config/module/alipay';?>" class="btn btn-sm btn-default"><i class="glyphicon glyphicon-share-alt"></i></a>
					</div>
				</div>
				<!-- /widget-header -->
				<div class="panel-body page-tab">
					<form action="<?php echo $this->config->item('admin').'extension_config/payment/alipay';?>" method="post" enctype="multipart/form-data" id="form-module" class="form-horizontal">
						<div class="form-group">
							<label class="col-sm-2 control-label" for="vname">名称</label>
							<div class="col-sm-10">
								<input type="text" name="alipay[vname]" id="vname" class="form-control" placeholder="显示名称" value="<?php echo isset($value['vname']) ? $value['vname'] : '';?>">
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-2 control-label" for="appkey">Appkey</label>
							<div class="col-sm-10">
								<input type="text" name="alipay[appkey]" id="appkey" class="form-control" placeholder="Appkey" value="<?php echo isset($value['appkey']) ? $value['appkey'] : '';?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="appsecret">AppSecret</label>
							<div class="col-sm-10">
								<input type="text" name="alipay[appsecret]" id="appsecret" class="form-control" placeholder="AppSecret" value="<?php echo isset($value['appsecret']) ? $value['appsecret'] : '';?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="rates">费率</label>
							<div class="col-sm-10">
								<input type="text" name="alipay[rates]" id="rates" class="form-control" placeholder="费率" value="<?php echo isset($value['rates']) ? $value['rates'] : '';?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="minimum_amount">最小使用金额</label>
							<div class="col-sm-10">
								<input type="text" name="alipay[minimum_amount]" id="minimum_amount" class="form-control" placeholder="最小使用金额" value="<?php echo isset($value['minimum_amount']) ? $value['minimum_amount'] : '';?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="status">状态</label>
							<div class="col-sm-10">
								<select name="alipay[status]" id="status" class="form-control">
								<?php if($value && $value['status'] == '1'):?>
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