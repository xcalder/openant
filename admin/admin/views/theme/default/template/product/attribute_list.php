<?php echo $header;//装载header?>
<?php echo $top;//装载top?>
<!-- /subnavbar -->
<div class="container">
	<div class="row">
		<div class="col-md-12 middle-flat-left" role="main">
			<div class="panel panel-default" id="attribute-list">
				<div class="panel-heading row row-panel-heading bg-info">
					<p class="navbar-left"><i class="glyphicon glyphicon-th-list"></i>&nbsp;商品属性列表</p>
					<div class="navbar-right btn-group" role="group" aria-label="..." style="margin-right: 0">
						<a href="<?php echo $this->config->item('admin').'/product/attribute/add_attribute'?>#edit-attribute" class="btn btn-sm btn-default"><i class="glyphicon glyphicon-plus"></i></a>
						<button type="button" class="btn btn-sm btn-default" onclick="confirm('确定吗？') ? $('#form-attribute').submit() : false;"><i class="glyphicon glyphicon-trash"></i></button>
					</div>
				</div>
				<!-- /widget-header -->
				<div class="panel-body">
					<form action="<?php echo $attribute_delete; ?>" method="post" enctype="multipart/form-data" id="form-attribute">
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
								<?php if($attributes):?>
								<?php foreach($attributes as $attribute):?>
								<tr>
									<td class="text-center"><input type="checkbox" name="selected[]" value="<?php echo $attribute['attribute_id']; ?>" /></td>
									<td><?php echo $attribute['name'];?></td>
									<td><?php echo $attribute['group_name'];?></td>
									<td><?php echo $attribute['sort_order'];?></td>
									<td class="text-right"><a href="<?php echo $this->config->item('admin').'/product/attribute/edit_attribute?attribute_id='.$attribute['attribute_id']?>#edit-attribute" class="btn btn-sm btn-info"><i class="glyphicon glyphicon-edit"></i></a>
									</td>
								</tr>
								<?php endforeach;?>
								<?php endif;?>
							</tbody>
							<tfoot>
								<tr>
									<td colspan="5"><?php echo $attributes_pagination;?></td>
								</tr>
							</tfoot>
						</table>
					</form>
				</div>
				<!-- /widget-content --> 
			</div>
			<!-- /widget -->

			<div class="panel panel-default" id="attribute-group">
				<div class="panel-heading row row-panel-heading bg-info">
					<p class="navbar-left"><i class="glyphicon glyphicon-th-list"></i>&nbsp;商品属性组列表</p>
					<div class="navbar-right btn-group" role="group" aria-label="..." style="margin-right: 0">
						<a href="<?php echo $this->config->item('admin').'/product/attribute/add_attribute_group'?>#edit-attribute-group" class="btn btn-sm btn-default"><i class="glyphicon glyphicon-plus"></i></a>
						<button type="button" class="btn btn-sm btn-default" onclick="confirm('确定吗') ? $('#form-attribute-group').submit() : false;"><i class="glyphicon glyphicon-trash"></i></button>
					</div>
				</div>
				<!-- /widget-header -->
				<div class="panel-body">
					<form action="<?php echo $attribute_group_delete; ?>" method="post" enctype="multipart/form-data" id="form-attribute-group">
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
								<?php if($attribute_groups):?>
								<?php foreach($attribute_groups as $attribute_group):?>
								<tr>
									<td class="text-center"><input type="checkbox" name="selected_group[]" value="<?php echo $attribute_group['attribute_group_id']; ?>" /></td>
									<td><?php echo $attribute_group['group_name'];?></td>
									<td><?php echo $attribute_group['sort_order'];?></td>
									<td class="text-right"><a href="<?php echo $this->config->item('admin').'/product/attribute/edit_attribute_group?attribute_group_id='.$attribute_group['attribute_group_id']?>#edit-attribute-group" class="btn btn-sm btn-info"><i class="glyphicon glyphicon-edit"></i></a>
									</td>
								</tr>
								<?php endforeach;?>
								<?php endif;?>
							</tbody>
							<tfoot>
								<tr>
									<td colspan="4"><?php echo $attribute_group_pagination;?></td>
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