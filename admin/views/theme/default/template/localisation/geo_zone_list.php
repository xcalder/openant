<?php echo $header;//装载header?>
<?php echo $top;//装载top?>
<!-- /subnavbar -->
<div class="container">
  <div class="row">
    <div class="col-md-12 middle-flat-left">
      <div class="panel panel-default">
        <div class="panel-heading row row-panel-heading bg-info">
	        <p class="navbar-left"> <i class="glyphicon glyphicon-th-list"></i>&nbsp;区域设置列表</p>
			<div class="navbar-right btn-group" style="margin-right: 0">
				<a href="<?php echo site_url('localisation/geo_zone/add')?>" class="btn btn-sm btn-default"><i class="glyphicon glyphicon-plus"></i></a>
				<button type="button" class="btn btn-sm btn-default" onclick="confirm('确定删除区域设置参数吗？') ? $('#form-geo_zone').submit() : false;"><i class="glyphicon glyphicon-trash"></i></button>
			</div>
	    </div>
        <!-- /widget-header -->
        <div class="panel-body">
        	<form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-geo_zone">
			<table class="table">
				<thead>
					<tr>
						<th style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></th>
						<th>名称</th>
						<th>描述</th>
						<th class="text-right">操作</th>
					</tr>
				</thead>
				<tbody>
					<?php if(isset($geo_zones)):?>
					<?php foreach($geo_zones as $geo_zone):?>
					<tr>
						<td class="text-center"><input type="checkbox" name="selected[]" value="<?php echo $geo_zone['geo_zone_id']; ?>" /></td>
						<td><?php echo $geo_zone['geo_zone_name'];?></td>
						<td><?php echo $geo_zone['geo_zone_description'];?></td>
						<td class="text-right"><a href="<?php echo site_url('localisation/geo_zone/edit?geo_zone_id=').$geo_zone['geo_zone_id'];?>" class="btn btn-sm btn-primary" data-container="body" data-toggle="popover" data-placement="top" data-content="编辑"><i class="glyphicon glyphicon-edit"></i></a></td>
					</tr>
					<?php endforeach;?>
					<?php endif;?>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="2"><?php echo !empty($pagination) ? $pagination : '';?></td>
						
						<td colspan="2"><div class="navbar-right pagination" style="margin-right: 0">共为你查询到&nbsp;<a><?php echo isset($count) ? $count : '0';?>条</a>&nbsp;记录</div></td>
					</tr>
				</tfoot>
			</table>
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