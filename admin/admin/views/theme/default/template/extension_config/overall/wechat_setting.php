<?php echo $header;//装载header?>
<?php echo $top;//装载top?>
<div class="container">
	<div class="row">
		<div class="col-md-12 middle-flat-left">
			<div class="panel panel-default">
				<div class="panel-heading row row-panel-heading bg-info">
					<p class="navbar-left"><i class="glyphicon glyphicon-signal"></i>配置微信公众号</p>
					<div class="navbar-right btn-group" style="margin-right: 0">
						<button type="button" onclick="submit('form-module')" class="btn btn-sm btn-default"><i class="glyphicon glyphicon-floppy-save"></i></button>
						<a href="<?php echo $this->config->item('admin').'/extension_config/module/product';?>" class="btn btn-sm btn-default"><i class="glyphicon glyphicon-share-alt"></i></a>
					</div>
				</div>
				<!-- /widget-header -->
				<div class="panel-body">
					<form action="<?php echo $this->config->item('admin');?>/extension_config/overall/wechat_setting" method="post" enctype="multipart/form-data" id="form-module" class="form-horizontal">
						<div class="form-group">
							<label class="col-sm-2 control-label" for="appID">
								appID
							</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="appID" name="appID" placeholder="appID" value="<?php echo isset($appID) ? $appID : '';?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="appsecret">
								appsecret
							</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="appsecret" name="appsecret" placeholder="appsecret" value="<?php echo isset($appsecret) ? $appsecret : '';?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="token">
								token
							</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="token" name="token" placeholder="token" value="<?php echo isset($token) ? $token : '';?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="encodingaeskey">
								encodingaeskey
							</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="encodingaeskey" name="encodingaeskey" placeholder="encodingaeskey" value="<?php echo isset($encodingaeskey) ? $encodingaeskey : '';?>">
							</div>
						</div>
					</form>
					<!-- /area-chart --> 
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