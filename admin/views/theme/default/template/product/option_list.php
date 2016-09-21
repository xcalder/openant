<?php echo $header;//装载header?>
<?php echo $top;//装载top?>
<!-- /subnavbar -->
<div class="container">
	<div class="row">
		<div class="col-md-12 middle-flat-left">
			<div class="panel panel-default" id="option-list">
				<div class="panel-heading row row-panel-heading bg-info">
					<p class="navbar-left"><i class="glyphicon glyphicon-th-list"></i>&nbsp;商品选项列表</p>
					<div class="navbar-right btn-group" style="margin-right: 0">
						<a href="admin.php/product/option/add_option.html#edit-option" class="btn btn-default"><i class="glyphicon glyphicon-plus"></i></a>
						<button type="button" class="btn btn-default" onclick="confirm('确定吗？') ? $('#form-option').submit() : false;"><i class="glyphicon glyphicon-trash"></i></button>
					</div>
				</div>
				<!-- /widget-header -->
				<div class="panel-body">
					<form action="<?php echo $option_delete; ?>" method="post" enctype="multipart/form-data" id="form-option">
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
								<?php if($options):?>
								<?php foreach($options as $option):?>
								<tr>
									<td class="text-center"><input type="checkbox" name="selected[]" value="<?php echo $option['option_id']; ?>" /></td>
									<td><?php echo $option['name'];?></td>
									<td><?php echo $option['option_group_name'];?></td>
									<td><?php echo $option['sort_order'];?></td>
									<td class="text-right"><a href="<?php echo site_url('product/option/edit_option?option_id='.$option['option_id'])?>#edit-option" class="btn btn-info"><i class="glyphicon glyphicon-edit"></i></a>
									</td>
								</tr>
								<?php endforeach;?>
								<?php endif;?>
							</tbody>
							<tfoot>
								<tr>
									<td colspan="5"><?php echo $options_pagination;?></td>
								</tr>
							</tfoot>
						</table>
					</form>
				</div>
				<!-- /widget-content --> 
			</div>
			<!-- /widget -->

			<div class="panel panel-default" id="option-group">
				<div class="panel-heading row row-panel-heading bg-info">
					<p class="navbar-left"><i class="glyphicon glyphicon-th-list"></i>&nbsp;商品选项组列表</p>
					<div class="navbar-right btn-group" style="margin-right: 0">
						<a href="admin.php/product/option/add_option_group.html#edit-option-group" class="btn btn-default"><i class="glyphicon glyphicon-plus"></i></a>
						<button type="button" class="btn btn-default" onclick="confirm('确定吗') ? $('#form-option-group').submit() : false;"><i class="glyphicon glyphicon-trash"></i></button>
					</div>
				</div>
				<!-- /widget-header -->
				<div class="panel-body">
					<form action="<?php echo $option_group_delete; ?>" method="post" enctype="multipart/form-data" id="form-option-group">
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
								<?php if($option_groups):?>
								<?php foreach($option_groups as $option_group):?>
								<tr>
									<td class="text-center"><input type="checkbox" name="selected_group[]" value="<?php echo $option_group['option_group_id']; ?>" /></td>
									<td><?php echo $option_group['option_group_name'];?></td>
									<td><?php echo $option_group['sort_order'];?></td>
									<td class="text-right"><a href="<?php echo site_url('product/option/edit_option_group?option_group_id='.$option_group['option_group_id'])?>#edit-option-group" class="btn btn-info"><i class="glyphicon glyphicon-edit"></i></a>
									</td>
								</tr>
								<?php endforeach;?>
								<?php endif;?>
							</tbody>
							<tfoot>
								<tr>
									<td colspan="4"><?php echo $option_group_pagination;?></td>
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