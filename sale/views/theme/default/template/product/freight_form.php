<?php echo $header;//装载header?>
<?php echo $top;//装载top?>
<!-- /subnavbar -->
<div class="container">
	<div class="row">
		<div class="col-md-12 middle-flat-left">
			<div class="panel panel-default" id="edit-freight">
				<div class="panel-heading row row-panel-heading bg-info">
					<p class="navbar-left"><i class="glyphicon glyphicon-edit"></i>&nbsp;编辑运费</p>
					<div class="navbar-right btn-group" style="margin-right: 0">
						<button type="button" onclick="submit('form-edit-freight')" class="btn btn-default"><i class="glyphicon glyphicon-floppy-save"></i></button>
						<a href="<?php echo site_url('product/freight');?>#freight-list" class="btn btn-default"><i class="glyphicon glyphicon-share-alt"></i></a>
					</div>
				</div>
				<!-- /widget-header -->
				<div class="panel-body page-tab">
					<form action="<?php echo $freight_action;?>" method="post" enctype="multipart/form-data" id="form-edit-freight" class="form-horizontal">
						<div class="form-group" id="language">
							<label class="col-sm-2 control-label" for="freight-description-name"><span style="color: red">*&nbsp;</span>运费名称</label>
							<div class="col-sm-10">
								<?php foreach($languages as $language):?>
								<div class="input-group">
									<span class="input-group-addon" id="basic-addon1"><img  width="16px" height="11px" class="lazy" data-original="public/flags/<?php echo $language['image']?>"></span>
									<input type="text" name="description[<?php echo $language['language_id']?>][name]" class="form-control" placeholder="运费名称" value="<?php echo isset($description[$language['language_id']]['name']) ? $description[$language['language_id']]['name'] : '';?>">
								</div>
								<?php if(isset($error_freight_description)):?><label class="text-danger"><?php echo $error_freight_description[$language['language_id']]['error_freight_name']?></label><?php endif;?>
								<?php endforeach;?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="freight-group"><span style="color: red">*&nbsp;</span>运费模板</label>
							<div class="col-sm-10">
								<select name="base[freight_template_id]" class="form-control">
									<?php if($freight_templates):?>
									<?php foreach($freight_templates as $key=>$value):?>
									<?php if($freight_template_id == $freight_templates[$key]['freight_template_id']):?>
									<option value="<?php echo $freight_templates[$key]['freight_template_id'];?>" selected><?php echo $freight_templates[$key]['freight_template_name'];?></option>
									<?php else:?>
									<option value="<?php echo $freight_templates[$key]['freight_template_id'];?>"><?php echo $freight_templates[$key]['freight_template_name'];?></option>
									<?php endif;?>
									<?php endforeach;?>
									<?php endif;?>
								</select>
								<?php if(isset($error_freight_template_id)):?><label class="text-danger"><?php echo $error_freight_template_id;?></label><?php endif;?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="input-country">
								<span style="color: red">
									*
								</span>&nbsp;国家
							</label>
							<div class="col-sm-10">
								<select class="form-control" id="input-country" onchange="country(this, '<?php echo isset($country_id) ? $country_id : '44'; ?>', '<?php echo isset($zone_id) ? $zone_id : '713'; ?>');" name="base[country_id]" class="form-control">
									<?php
									if($countrys):?>
									<?php
									foreach($countrys as $country):?>
									<?php
									if(isset($country_id) && $country['country_id'] == $country_id):?>
									<option value="<?php echo $country_id;?>" selected="selected">
										<?php echo $country['name'];?>
									</option>
									<?php
									else:?>
									<option value="<?php echo $country['country_id']?>">
										<?php echo $country['name'];?>
									</option>
									<?php endif;?>
									<?php endforeach;?>
									<?php endif;?>
								</select>
								<lable style="color: red;">
									<?php echo isset($error_country) ? $error_country : '';?>
								</lable>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="input-zone">
								<span style="color: red">
									*
								</span>&nbsp;省份
							</label>
							<div class="col-sm-10">
								<select name="base[zone_id]" id="input-zone" class="form-control">
								</select>
								<lable style="color: red;">
									<?php echo isset($error_zone) ? $error_zone : '';?>
								</lable>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="freight-value">运费</label>
							<div class="col-sm-10">
								<input type="text" name="base[value]" class="form-control" placeholder="运费" id="freight-value" value="<?php echo isset($freight_value) ? $freight_value : '0';?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="freight-sort-order">排序</label>
							<div class="col-sm-10">
								<input type="text" name="base[sort_order]" class="form-control" placeholder="排序" value="<?php echo isset($freight_sort_order) ? $freight_sort_order : '0';?>">
							</div>
						</div>
					</form>
					<!-- /shortcuts --> 
				</div>
				<!-- /widget-content --> 
			</div>
			<!-- /widget -->
			<div class="panel panel-default" id="edit-freight-group">
				<div class="panel-heading row row-panel-heading bg-info">
					<p class="navbar-left"><i class="glyphicon glyphicon-edit"></i>&nbsp;编辑运费模板</p>
					<div class="navbar-right btn-group" style="margin-right: 0">
						<button type="button" onclick="submit('form-edit-freight-group')" class="btn btn-default"><i class="glyphicon glyphicon-floppy-save"></i></button>
						<a href="<?php echo site_url('product/freight');?>#freight-group" class="btn btn-default"><i class="glyphicon glyphicon-share-alt"></i></a>
					</div>
				</div>
				<!-- /widget-header -->
				<div class="panel-body page-tab">
					<form action="<?php echo $freight_template_action;?>" method="post" enctype="multipart/form-data" id="form-edit-freight-group" class="form-horizontal">
						<div class="form-group" id="language">
							<label class="col-sm-2 control-label" for="freight-group-name"><span style="color: red">*&nbsp;</span>运费模板名称</label>
							<div class="col-sm-10">
								<?php foreach($languages as $language):?>
								<div class="input-group">
									<span class="input-group-addon"><img  width="16px" height="11px" class="lazy" data-original="public/flags/<?php echo $language['image']?>"></span>
									<input type="text" name="group_description[<?php echo $language['language_id']?>][freight_template_name]" class="form-control" placeholder="运费模板名称" value="<?php echo isset($group_description[$language['language_id']]['freight_template_name']) ? $group_description[$language['language_id']]['freight_template_name'] : '';?>">
								</div>
								<?php if(isset($freight_template_description)):?><label class="text-danger"><?php echo $freight_template_description[$language['language_id']]['error_freight_template_name']?></label><?php endif;?>
								<?php endforeach;?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="freight-group-value">默认邮费</label>
							<div class="col-sm-10">
								<input type="text" name="group_base[value]" class="form-control" placeholder="排序" value="<?php echo isset($freight_template_value) ? $freight_template_value : '0';?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="freight-pricing">计价方式</label>
							<div class="col-sm-10">
								<select name="group_base[pricing]" class="form-control">
									<?php if(isset($freight_template_pricing) && $$freight_template_pricing == 'W'):?>
									<option value="W" selected>按重量</option>
									<option value="L">按件数</option>
									<?php else:?>
									<option value="W">按重量</option>
									<option value="L" selected>按件数</option>
									<?php endif;?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="freight-group-sort-order">排序</label>
							<div class="col-sm-10">
								<input type="text" name="group_base[sort_order]" class="form-control" placeholder="排序" value="<?php echo isset($freight_template_sort_order) ? $freight_template_sort_order : '0';?>">
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
	<script type="text/javascript">
		function country(element, index, zone_id)
		{
			$.ajax(
				{
					url: "<?php echo site_url();?>/localisation/country/get_country?country_id=" + element.value,
					dataType: 'json',
					beforeSend: function()
					{
						NProgress.start();
					},
					complete: function()
					{
						NProgress.done();
					},
					success: function(json)
					{
						html = '<option value="">--无--</option>';

						if (json['zone'] && json['zone'] != '')
						{
							for (i = 0; i < json['zone'].length; i++)
							{
								html += '<option value="' + json['zone'][i]['zone_id'] + '"';

								if (json['zone'][i]['zone_id'] == zone_id)
								{
									html += ' selected="selected"';
								}

								html += '>' + json['zone'][i]['name'] + '</option>';
							}
						} else
						{
							html += '<option value="">--无--</option>';
						}

						$('select[name=\'base[zone_id]\']').html(html);
					},
					error: function(xhr, ajaxOptions, thrownError)
					{
						alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					}
				});
		}

		$('select[name$=\'base[country_id]\']').trigger('change');
	</script>
</div>
<!-- /container -->
<?php echo $footer;//装载header?>
