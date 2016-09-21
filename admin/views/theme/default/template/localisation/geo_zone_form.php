<?php echo $header;//装载header?>
<?php echo $top;//装载top?>
<!-- /subnavbar -->
<div class="container">
  <div class="row">
    <div class="col-md-12 middle-flat-left">
      <div class="panel panel-default">
        <div class="panel-heading row row-panel-heading bg-info">
	        <p class="navbar-left"><i class="glyphicon glyphicon-edit"></i>&nbsp;编辑区域设置</p>
	    	<div class="navbar-right btn-group" style="margin-right: 0">
			  <button type="button" onclick="submit('form-geo_zone')" class="btn btn-default"><i class="glyphicon glyphicon-floppy-save"></i></button>
			  <a href="<?php echo site_url('localisation/geo_zone');?>" class="btn btn-default"><i class="glyphicon glyphicon-share-alt"></i></a>
			</div>
        </div>
        <!-- /widget-header -->
        <div class="panel-body page-tab">
          <form action="<?php echo $action;?>" method="post" enctype="multipart/form-data" id="form-geo_zone" class="form-horizontal">
          	<div class="form-group" id="language">
				<label class="col-sm-2 control-label" for="geo_zone_name"><span style="color: red">*&nbsp;</span>区域设置名称</label>
				<div class="col-sm-10">
				<?php foreach($languages as $language):?>
					<div class="input-group">
					  <span class="input-group-addon"><img width="16px" height="11px" class="lazy" data-original="public/flags/<?php echo $language['image']?>"></span>
					  <input type="text" name="description[<?php echo $language['language_id']?>][geo_zone_name]" class="form-control" placeholder="区域设置名称" value="<?php echo isset($description[$language['language_id']]['geo_zone_name']) ? $description[$language['language_id']]['geo_zone_name'] : '';?>">
					</div>
					<?php if(isset($error_description[$language['language_id']]['error_geo_zone_name'])):?><label class="text-danger"><?php echo $error_description[$language['language_id']]['error_geo_zone_name'];?></label><?php endif;?>
				<?php endforeach;?>
				</div>
			</div>
			<div class="form-group" id="language">
				<label class="col-sm-2 control-label" for="geo_zone_description"><span style="color: red">*&nbsp;</span>区域设置名称</label>
				<div class="col-sm-10">
				<?php foreach($languages as $language):?>
					<div class="input-group">
					  <span class="input-group-addon"><img width="16px" height="11px" class="lazy" data-original="public/flags/<?php echo $language['image']?>"></span>
					  <input type="text" name="description[<?php echo $language['language_id']?>][geo_zone_description]" class="form-control" placeholder="区域设置名称" value="<?php echo isset($description[$language['language_id']]['geo_zone_description']) ? $description[$language['language_id']]['geo_zone_description'] : '';?>">
					</div>
					<?php if(isset($error_description[$language['language_id']]['error_geo_zone_description'])):?><label class="text-danger"><?php echo $error_description[$language['language_id']]['error_geo_zone_description'];?></label><?php endif;?>
				<?php endforeach;?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="sort_order">区域内</label>
				<div class="col-sm-10">
					<table class="table" id="zone-to-geo-zone">
						<thead>
							<tr>
								<td>国家</td>
								<td>地区</td>
								<td class="text-right">操作</td>
							</tr>
						</thead>
						<tbody>
							<?php $zone_to_geo_zone_row = 0; ?>
							<?php if(isset($zone_to_geo_zones) && is_array($zone_to_geo_zones)):?>
							<?php foreach($zone_to_geo_zones as $zone_to_geo_zone):?>
							<tr id="zone-to-geo-zone-row<?php echo $zone_to_geo_zone_row; ?>">
								<td>
									<select name="zone_to_geo_zone[<?php echo $zone_to_geo_zone_row;?>][country_id]" id="country<?php echo $zone_to_geo_zone_row; ?>" class="form-control" onchange="$('#zone<?php echo $zone_to_geo_zone_row; ?>').load('<?php echo site_url();?>/localisation/geo_zone/zone.html?country_id=' + this.value + '&zone_id=0');">
										<?php foreach ($countrys as $country):?>
										<?php if($zone_to_geo_zone['country_id'] == $country['country_id']):?>
										<option value="<?php echo $country['country_id'];?>" selected><?php echo $country['name'];?></option>
										<?php else:?>
										<option value="<?php echo $country['country_id'];?>"><?php echo $country['name'];?></option>
										<?php endif;?>
										<?php endforeach;?>
									</select>
								</td>
								<td>
									<select class="form-control" name="zone_to_geo_zone[<?php echo $zone_to_geo_zone_row;?>][zone_id]" id="zone<?php echo $zone_to_geo_zone_row; ?>">
									
										
									</select>
								</td>
								<td class="text-right"><button type="button" onclick="$('#zone-to-geo-zone-row<?php echo $zone_to_geo_zone_row; ?>').remove();" data-toggle="tooltip" class="btn btn-danger"><i class="glyphicon glyphicon-minus"></i></button></td>
							</tr>
							<?php $zone_to_geo_zone_row++; ?>
							<?php endforeach;?>
							<?php endif;?>
						</tbody>
						<tfoot>
							<tr>
								<td colspan="2"></td>
								<td class="text-right"><button type="button" onclick="addGeoZone();" data-toggle="tooltip" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i></button></td>
							</tr>
						</tfoot>
					</table>
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

<script>
$('#zone-id').load('<?php echo site_url();?>/localisation/geo_zone/zone.html?country_id=' + $('#country-id').attr('value') + '&zone_id=0');


<?php $zone_to_geo_zone_row = 0; ?>
<?php if(isset($zone_to_geo_zones) && is_array($zone_to_geo_zones)):?>
<?php foreach ($zone_to_geo_zones as $zone_to_geo_zone):?>
$('#zone<?php echo $zone_to_geo_zone_row; ?>').load('<?php echo site_url();?>/localisation/geo_zone/zone.html?country_id=<?php echo $zone_to_geo_zone['country_id']; ?>&zone_id=<?php echo $zone_to_geo_zone['zone_id']; ?>');
<?php $zone_to_geo_zone_row++; ?>
<?php endforeach;?>
<?php endif;?>
  
  
var zone_to_geo_zone_row = <?php echo $zone_to_geo_zone_row; ?>;

function addGeoZone() {
	html  = '<tr id="zone-to-geo-zone-row' + zone_to_geo_zone_row + '">';
	html += '  <td><select name="zone_to_geo_zone[' + zone_to_geo_zone_row + '][country_id]" id="country' + zone_to_geo_zone_row + '" class="form-control" onchange="$(\'#zone' + zone_to_geo_zone_row + '\').load(\'<?php echo site_url()?>/localisation/geo_zone/zone.html?country_id=\' + this.value + \'&zone_id=0\');">';
	<?php foreach ($countrys as $country):?>
	html += '<option value="<?php echo $country['country_id']; ?>"><?php echo addslashes($country['name']); ?></option>';
	<?php endforeach;?>   
	html += '</select></td>';
	html += '  <td><select name="zone_to_geo_zone[' + zone_to_geo_zone_row + '][zone_id]" id="zone' + zone_to_geo_zone_row + '" class="form-control"></select></td>';
	html += '  <td class="text-right"><button type="button" onclick="$(\'#zone-to-geo-zone-row' + zone_to_geo_zone_row + '\').remove();" data-toggle="tooltip" class="btn btn-danger"><i class="glyphicon glyphicon-minus"></i></button></td>';
	html += '</tr>';
	
	$('#zone-to-geo-zone tbody').append(html);
		
	$('#zone' + zone_to_geo_zone_row).load('<?php echo site_url();?>/localisation/geo_zone/zone.html?country_id=' + $('#country' + zone_to_geo_zone_row).attr('value') + '&zone_id=0');
	
	zone_to_geo_zone_row++;
} 
</script>
<?php echo $footer;//装载header?>