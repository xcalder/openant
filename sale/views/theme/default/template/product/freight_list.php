<?php echo $header;//装载header?>
<?php echo $top;//装载top?>
<!-- /subnavbar -->
<div class="container">
	<div class="row">
		<div class="col-md-12 middle-flat-left">
			<div class="panel panel-default" id="freight-list">
				<div class="panel-heading row row-panel-heading bg-info">
					<p class="navbar-left"><i class="glyphicon glyphicon-th-list"></i>&nbsp;运费列表</p>
					<div class="navbar-right btn-group" style="margin-right: 0">
						<a href="sale.php/product/freight/add_freight.html#edit-freight" class="btn btn-default"><i class="glyphicon glyphicon-plus"></i></a>
						<button type="button" class="btn btn-default" onclick="confirm('确定吗？') ? $('#form-freight').submit() : false;"><i class="glyphicon glyphicon-trash"></i></button>
					</div>
				</div>
				<!-- /widget-header -->
				<div class="panel-body">
					<form action="<?php echo $freight_delete; ?>" method="post" enctype="multipart/form-data" id="form-freight">
						<table class="table">
							<thead>
								<tr>
									<th style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></th>
									<th>名称</th>
									<th>组</th>
									<th>排序</th>
									<th class="text-right">操作</th>
								</tr>
							</thead>
							<tbody>
								<?php if($freights):?>
								<?php foreach($freights as $freight):?>
								<tr>
									<td class="text-center"><input type="checkbox" name="selected[]" value="<?php echo $freight['freight_id']; ?>" /></td>
									<td><?php echo $freight['name'];?></td>
									<td><?php echo $freight['freight_template_name'];?></td>
									<td><?php echo $freight['sort_order'];?></td>
									<td class="text-right"><a href="<?php echo site_url('product/freight/edit_freight?freight_id='.$freight['freight_id'])?>#edit-freight" class="btn btn-info"><i class="glyphicon glyphicon-edit"></i></a>
									</td>
								</tr>
								<?php endforeach;?>
								<?php endif;?>
							</tbody>
							<tfoot>
								<tr>
									<td colspan="5"><?php echo $freights_pagination;?></td>
								</tr>
							</tfoot>
						</table>
					</form>
				</div>
				<!-- /widget-content --> 
			</div>
			<!-- /widget -->

			<div class="panel panel-default" id="freight-group">
				<div class="panel-heading row row-panel-heading bg-info">
					<p class="navbar-left"><i class="glyphicon glyphicon-th-list"></i>&nbsp;运费模板列表</p>
					<div class="navbar-right btn-group" style="margin-right: 0">
						<a href="sale.php/product/freight/add_freight_template.html#edit-freight-group" class="btn btn-default"><i class="glyphicon glyphicon-plus"></i></a>
						<button type="button" class="btn btn-default" onclick="confirm('确定吗') ? $('#form-freight-group').submit() : false;"><i class="glyphicon glyphicon-trash"></i></button>
					</div>
				</div>
				<!-- /widget-header -->
				<div class="panel-body">
					<form action="<?php echo $freight_template_delete; ?>" method="post" enctype="multipart/form-data" id="form-freight-group">
						<table class="table">
							<thead>
								<tr>
									<th style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected_group\']').prop('checked', this.checked);" /></th>
									<th>名称</th>
									<th>排序</th>
									<th>操作</th>
								</tr>
							</thead>
							<tbody>
								<?php if($freight_templates):?>
								<?php foreach($freight_templates as $freight_template):?>
								<tr>
									<td class="text-center"><input type="checkbox" name="selected_group[]" value="<?php echo $freight_template['freight_template_id']; ?>" /></td>
									<td><?php echo $freight_template['freight_template_name'];?></td>
									<td><?php echo $freight_template['sort_order'];?></td>
									<td class="text-right"><a href="<?php echo site_url('product/freight/edit_freight_template?freight_template_id='.$freight_template['freight_template_id'])?>#edit-freight-group" class="btn btn-info"><i class="glyphicon glyphicon-edit"></i></a>
									</td>
								</tr>
								<?php endforeach;?>
								<?php endif;?>
							</tbody>
							<tfoot>
								<tr>
									<td colspan="4"><?php echo $freight_template_pagination;?></td>
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