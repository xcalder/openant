<?php echo $header;//装载header?>
<?php echo $top;//装载top?>
<!-- /subnavbar -->
<div class="container">
	<div class="row"><?php echo $position_left;?>
  
		<?php if($position_left && $position_right):?>
		<?php $class = 'col-sm-6'; ?>
		<?php elseif($position_left || $position_right):?>
		<?php $class = 'col-sm-9'; ?>
		<?php else:?>
		<?php $class = 'col-sm-12'; ?>
		<?php endif;?>
	
		<div id="middle" class="<?php echo $class; ?> middle-flat-left">
			<?php echo $position_top; ?>
			 <form class="form-horizontal well well-sm" action="<?php echo site_url('user/address/add');?>" method="post" style="padding: 15px">
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">姓氏：</label>
		<div class="col-sm-10">
			<input type="text" name="firstname" class="form-control" id="firstname" placeholder="姓氏" value="<?php echo $address_info ? $address_info['firstname'] : '';?>">
		</div>
	</div>
	<div class="form-group">
		<label for="lastname" class="col-sm-2 control-label">名字：</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" name="lastname" id="lastname" placeholder="名字" value="<?php echo $address_info ? $address_info['lastname'] : '';?>">
		</div>
	</div>
	<div class="form-group">
		<label for="postcode" class="col-sm-2 control-label">邮编：</label>
		<div class="col-sm-10">
			<input type="text" name="postcode" class="form-control" id="postcode" placeholder="邮编" value="<?php echo $address_info ? $address_info['postcode'] : '';?>">
		</div>
	</div>
	<div class="form-group">
		<label for="address" class="col-sm-2 control-label">地址：</label>
		<div class="col-sm-10">
			<input type="text" name="address" class="form-control" id="address" placeholder="详细地址" value="<?php echo $address_info ? $address_info['address'] : '';?>">
		</div>
	</div>
	<div class="form-group">
		<label for="city" class="col-sm-2 control-label">城市：</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" name="city" id="city" placeholder="城市" value="<?php echo $address_info ? $address_info['city'] : '';?>">
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label" for="country">国家</label>
		<div class="col-sm-10">
			<select class="form-control" id="country" onchange="countrye(this, '<?php echo $address_info ? $address_info['zone_id'] : '';?>');" name="country_id" class="form-control">
				<?php foreach($countrys as $country):?>
				<?php if($address_info['country_id'] == $country['country_id']):?>
				<option value="<?php echo $country['country_id']?>" selected><?php echo $country['name']?></option>
				<?php else:?>
				<option value="<?php echo $country['country_id']?>"><?php echo $country['name']?></option>
				<?php endif;?>
				<?php endforeach;?>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label" for="zone">省份</label>
		<div class="col-sm-10">
			<select name="zone_id" id="zone" class="form-control">
				<option value="">--无--</option>
			</select>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<div class="checkbox">
				<label>
					<input type="checkbox" name="user_address_id" <?php echo ($this->input->get('address_id') == $this->user->getAddressId()) ? 'checked' : '';?> value="<?php echo $this->input->get('address_id');?>">设为默认
				</label>
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<?php if($this->input->get('address_id') != NULL):?>
			<input type="hidden" name="address_id" value="<?php echo $this->input->get('address_id');?>"/>
			<?php endif;?>
			<button type="submit" class="btn btn-default">保存</button>
		</div>
	</div>
</form>
			<div class="panel panel-default">
				<!-- /widget-header -->
				<div class="panel-body">
					<table class="table" id="address-list-table">
						<thead>
							<tr>
								<td>地址</td>
								<td>操作</td>
								<td></td>
							</tr>
						</thead>
						<tbody class="table-striped table-hover">
							<?php if($addresss):?>
							<?php foreach($addresss as $address):?>
							<tr>
								<td style="width: 75%;"><?php echo $address['address'];?></td>
								<?php if($this->user->getAddressId() == $address['address_id']):?>
								<td style="width:15%;vertical-align: middle;"><a>删除</a>|<a href="<?php echo site_url('user/address?address_id=').$address['address_id'];?>">修改</a></td>
								<td style="width:10%;vertical-align: middle;"><button type="button" class="btn btn-default btn-xs">默认地址</button></td>
								<?php else:?>
								<td style="width:15%;vertical-align: middle;"><a href="<?php echo site_url('user/address/delete?address_id=').$address['address_id'];?>">删除</a>|<a href="<?php echo site_url('user/address?address_id=').$address['address_id'];?>">修改</a></td>
								<td style="width:10%;vertical-align: middle;"><button type="button" onclick="set_defu('<?php echo $address['address_id'];?>');" class="btn btn-default set-default btn-xs">设为默认</button></td>
								<?php endif;?>
							</tr>
							<?php endforeach;?>
							<?php endif;?>
						</tbody>
					</table>
				</div>
				<!-- /widget-content --> 
			</div>
			<!-- /widget -->
			<?php echo $position_bottom; ?>
		</div>
		<?php echo $position_right; ?>
	</div>
	<!-- /row -->
	<script>
		$('#address-list-table tbody tr').mouseenter(function(){
			$('#address-list-table tbody tr td .set-default').hide();
			$(this).find('.set-default').show();
		});
		
		function set_defu(id){
			$.ajax(
				{
					url: '<?php echo site_url();?>user/address/set_def.html',
					type: 'post',
					dataType: 'json',
					data: {address_id:id},
				})
				window.location.reload();
		}
		
		function countrye(element, zone_id=''){
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
						if (json['postcode_required'] == '1')
						{
							$('input[name=\'postcode\']').parent().parent().find('label').prepend('<span style="color:red">*&nbsp;</span>');
						} else
						{
							$('input[name=\'postcode\']').parent().parent().find('label').find('span').remove();
						}

						html = '';
						
						if (json['zone'] && json['zone'] != '')
						{
							for (i = 0; i < json['zone'].length; i++)
							{
								html += '<option value="' + json['zone'][i]['zone_id'] + '"';

								if (json['zone'][i]['zone_id'] == zone_id)
								{
									html += ' selected="selected"';
								}

								html += '>' + json['zone'][i]['zone_name'] + '</option>';
							}
						} else
						{
							html += '<option value="0">--无--</option>';
						}

						$('select[name=\'zone_id\']').html(html);
					},
					error: function(xhr, ajaxOptions, thrownError)
					{
						alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					}
				});
		}
		$('select[name=\'country_id\']').trigger('change');
	</script>
	
</div>
<!-- /container -->
<?php echo $footer;//装载header?>