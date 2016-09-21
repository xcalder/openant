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
						</i>&nbsp;文章分类列表
					</p>
					<div class="navbar-right btn-group" style="margin-right: 0">
						<a href="admin.php/information/information_category/add.html" class="btn btn-default">
							<i class="glyphicon glyphicon-plus">
							</i>
						</a>
						<button type="button" class="btn btn-default" onclick="confirm('确定删除分类吗？') ? $('#form-information_category').submit() : false;">
							<i class="glyphicon glyphicon-trash">
							</i>
						</button>
					</div>
				</div>
				<!-- /widget-header -->
				<div class="panel-body">
					<form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-information_category">
					<table class="table table-hover">
						<thead>
							<tr>
								<td style="width: 1px;" class="text-center">
									<input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" />
								</td>
								<td>分类名称</td>
								<td>位置</td>
								<td>排序</td>
								<td class="text-right">编辑</td>
							</tr>
						</thead>
						<tbody>
							<?php
							if($information_categorys):?>
							<?php
							foreach($information_categorys as $information_category):?>
							<?php if($information_category['childs']):?>
							<tr>
								<td class="text-center">
									<input type="checkbox" name="selected[]" value="<?php echo $information_category['information_category_id']; ?>" />
								</td>
								<td class="text-left">
									<?php echo $information_category['name'];?>
								</td>
								<td class="text-left">
									<?php echo $information_category['position'];?>
								</td>
								<td class="text-left">
									<?php echo $information_category['sort_order'];?>
								</td>
								<td class="text-right">
									<a href="<?php echo site_url('information/information_category/edit?information_category_id='.$information_category['information_category_id']);?>" class="btn btn-info">
										<i class="glyphicon glyphicon-edit">
										</i>
									</a>
								</td>
							</tr>
							<?php foreach($information_category['childs'] as $child):?>
							<tr>
								<td class="text-center">
									<input type="checkbox" name="selected[]" value="<?php echo $child['information_category_id']; ?>" />
								</td>
								<td class="text-left">
									<?php echo $information_category['name'].'=>'.$child['name'];?>
								</td>
								<td class="text-left">
									<?php echo $child['position'];?>
								</td>
								<td class="text-left">
									<?php echo $child['sort_order'];?>
								</td>
								<td class="text-right">
									<a href="<?php echo site_url('information/information_category/edit?information_category_id='.$child['information_category_id']);?>" class="btn btn-info">
										<i class="glyphicon glyphicon-edit">
										</i>
									</a>
								</td>
							</tr>
							<?php endforeach;?>
							<?php else:?>
							
							<tr>
								<td class="text-center">
									<input type="checkbox" name="selected[]" value="<?php echo $information_category['information_category_id']; ?>" />
								</td>
								<td class="text-left">
									<?php echo $information_category['name'];?>
								</td>
								<td class="text-left">
									<?php echo $information_category['position'];?>
								</td>
								<td class="text-left">
									<?php echo $information_category['sort_order'];?>
								</td>
								<td class="text-right">
									<a href="<?php echo site_url('information/information_category/edit?information_category_id='.$information_category['information_category_id']);?>" class="btn btn-info">
										<i class="glyphicon glyphicon-edit">
										</i>
									</a>
								</td>
							</tr>
							
							<?php endif;?>
							<?php endforeach;?>
							<?php endif;?>
						</tbody>
						<tfoot>
							<tr>
								<td colspan="5" class="text-left">
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

