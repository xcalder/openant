<?php echo $header;//装载header?>
<?php echo $top;//装载top?>
<!-- /subnavbar -->
<div class="container">
	<div class="row">
		<div class="col-md-12 middle-flat-left">
			<div class="panel panel-default">
				<div class="panel-heading row row-panel-heading bg-info">
					<p class="navbar-left">
						<i class="glyphicon glyphicon-edit">
						</i>&nbsp;编辑国家设置
					</p>
					<div class="navbar-right btn-group" style="margin-right: 0">
						<button type="button" onclick="submit('form-country')" class="btn btn-sm btn-default">
							<i class="glyphicon glyphicon-floppy-save">
							</i>
						</button>
						<a href="<?php echo $this->config->item('admin').'/localisation/country';?>" class="btn btn-sm btn-default">
							<i class="glyphicon glyphicon-share-alt">
							</i>
						</a>
					</div>
				</div>
				<!-- /widget-header -->
				<div class="panel-body page-tab">
					<form action="<?php echo $action;?>" method="post" enctype="multipart/form-data" id="form-country" class="form-horizontal">
						<div class="form-group" id="language">
							<label class="col-sm-2 control-label" for="name">
								<span style="color: red">
									*&nbsp;
								</span>国家设置名称
							</label>
							<div class="col-sm-10">
								<?php
								foreach($languages as $language):?>
								<div class="input-group">
									<span class="input-group-addon">
										<img width="16px" height="11px" class="lazy" data-original="resources/public/flags/<?php echo $language['image']?>">
									</span>
									<input type="text" name="description[<?php echo $language['language_id']?>][name]" class="form-control" placeholder="国家设置名称" value="<?php echo isset($description[$language['language_id']]['name']) ? $description[$language['language_id']]['name'] : '';?>">
								</div>
								<?php
								if(isset($error_description[$language['language_id']]['error_name'])):?>
								<label class="text-danger">
									<?php echo $error_description[$language['language_id']]['error_name'];?>
								</label><?php endif;?>
								<?php endforeach;?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="iso_code_2">
								ISO_CODE_2
							</label>
							<div class="col-sm-10">
								<input type="text" name="base[iso_code_2]" class="form-control" id="iso_code_2" placeholder="iso_code_2" value="<?php echo $iso_code_2;?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="iso_code_2">
								ISO_CODE_3
							</label>
							<div class="col-sm-10">
								<input type="text" name="base[iso_code_3]" class="form-control" id="iso_code_3" placeholder="iso_code_3" value="<?php echo $iso_code_3;?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="address_format">
								地址格式
							</label>
							<div class="col-sm-10">
								<textarea name="base[address_format]" class="form-control" id="address_format" placeholder="地址格式" rows="3"><?php echo $address_format;?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="postcode_required">
								邮编要求
							</label>
							<div class="col-sm-10">
								<?php
								if($postcode_required == '1'):?>
								<label class="radio-inline">
									<input type="radio" name="base[postcode_required]" id="postcode_required" value="1" checked>是
								</label>
								<label class="radio-inline">
									<input type="radio" name="base[postcode_required]" id="postcode_required" value="0">否
								</label>
								<?php
								else:?>
								<label class="radio-inline">
									<input type="radio" name="base[postcode_required]" id="postcode_required" value="1">是
								</label>
								<label class="radio-inline">
									<input type="radio" name="base[postcode_required]" id="postcode_required" value="0" checked>否
								</label>
								<?php endif;?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="postcode_required">
								状态
							</label>
							<div class="col-sm-10">
								<select name="base[status]" class="form-control" id="status">
									<?php
									if($status == '1'):?>
									<option value="1" selected>
										启用
									</option>
									<option value="0">
										禁用
									</option>
									<?php
									else:?>
									<option value="1">
										启用
									</option>
									<option value="0" selected>
										禁用
									</option>
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