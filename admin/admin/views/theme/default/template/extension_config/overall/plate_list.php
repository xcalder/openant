<?php echo $header;//装载header?>
<?php echo $top;//装载top?>
<!-- /subnavbar -->
<div class="container">
	<div class="row">
		<div class="col-md-12 middle-flat-left">
			<div class="panel panel-default">
				<div class="panel-heading row row-panel-heading bg-info">
					<p class="navbar-left">
						<i class="glyphicon glyphicon-th-list">
						</i>论坛版块列表
					</p>
					<div class="navbar-right btn-group" style="margin-right: 0">
						<a href="<?php echo $this->config->item('admin');?>/extension_config/overall/plate/add" class="btn btn-sm btn-default">
							<i class="glyphicon glyphicon-plus">
							</i>
						</a>
						<button type="button" class="btn btn-sm btn-default" onclick="confirm('确定删除分类吗？') ? $('#form-plate').submit() : false;">
							<i class="glyphicon glyphicon-trash">
							</i>
						</button>
					</div>
				</div>
				<!-- /widget-header -->
				<div class="panel-body">
					<form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-plate">
					<table class="table table-hover">
						<thead>
							<tr>
								<td style="width: 1px;" class="text-center">
									<input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" />
								</td>
								<td>版块标题</td>
								<td>描述</td>
								<td>添加者</td>
								<td>管理员</td>
								<td>添加日期</td>
								<td class="text-right">编辑</td>
							</tr>
						</thead>
						<tbody>
							<?php
							if($plates):?>
							<?php foreach($plates as $plate):?>
							
							<tr>
								<td class="text-center">
									<input type="checkbox" name="selected[]" value="<?php echo $plate['plate_id']; ?>" />
								</td>
								<td class="text-left">
									<?php echo $plate['title'];?>
								</td>
								<td class="text-left">
									<?php echo $plate['description'];?>
								</td>
								<td class="text-left">
									<?php echo $plate['user_id'];?>
								</td>
								<td class="text-left">
									<?php echo $plate['admin_ids'];?>
								</td>
								<td class="text-left">
									<?php echo $plate['date_added'];?>
								</td>
								<td class="text-right">
									<a href="<?php echo $this->config->item('admin').'extension_config/overall/plate/edit?plate_id='.$plate['plate_id'];?>" class="btn btn-info btn-sm">
										<i class="glyphicon glyphicon-edit"></i>
									</a>
								</td>
							</tr>
							
							<?php endforeach;?>
							<?php endif;?>
						</tbody>
						<tfoot>
							<tr>
								<td colspan="7" class="text-left">
									<?php echo $pagination;?>
								</td>
							</tr>
						</tfoot>
					</table>
				</div>
				</form>
				<!-- /widget-content -->
			</div>
			<!-- /widget -->
		</div>
		<!-- /span12 -->
	</div>
	<!-- /row -->
</div>
<!-- /container -->
<?php echo $footer;//装载header?>

