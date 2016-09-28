<?php echo $header;//装载header?>
<?php echo $top;//装载top?>
<!-- /subnavbar -->
<div class="container">
	<div class="row">
		<div class="col-md-12 middle-flat-left">
			<div class="panel panel-default">
				<div class="panel-heading row row-panel-heading bg-info">
					<p class="navbar-left"><i class="glyphicon glyphicon-th-list"></i>&nbsp;商品分类列表</p>
					<div class="navbar-right btn-group" style="margin-right: 0">
						<a href="admin.php/product/category/add.html" class="btn btn-sm btn-default"><i class="glyphicon glyphicon-plus"></i></a>
						<button type="button" class="btn btn-sm btn-default" onclick="confirm('确定删除分类吗？') ? $('#form-category').submit() : false;"><i class="glyphicon glyphicon-trash"></i></button>
					</div>
				</div>
				<!-- /widget-header -->
				<div class="panel-body">
					<form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-category">
						<table class="table table-hover">
							<thead>
								<tr>
									<th style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></th>
									<th>分类名称</th>
									<th>排序</th>
									<th>编辑</th>
								</tr>
							</thead>
							<tbody>
								<?php if($categorys):?>
								<?php foreach ($categorys as $key=>$category):?>
								<?php if (!isset($categorys[$key]['childs'])):?>
								<tr>
									<td class="text-center"><input type="checkbox" name="selected[]" value="<?php echo $categorys[$key]['category_id']; ?>" /></td>
									<td class="text-left"><?php echo $categorys[$key]['name'];?></td>
									<td class="text-left"><?php echo $categorys[$key]['sort_order'];?></td>
									<td class="text-right"><a href="<?php echo site_url('product/category/edit?category_id='.$categorys[$key]['category_id'])?>" class="btn btn-sm btn-info"><i class="glyphicon glyphicon-edit"></i></a>
									</td>
								</tr>
								<?php else:?>
								<tr>
									<td class="text-center"><input type="checkbox" name="selected[]" value="<?php echo $categorys[$key]['category_id']; ?>" /></td>
									<td class="text-left"><?php echo $categorys[$key]['name'];?></td>
									<td class="text-left"><?php echo $categorys[$key]['sort_order'];?></td>
									<td class="text-right"><a href="<?php echo site_url('product/category/edit?category_id='.$categorys[$key]['category_id'])?>" class="btn btn-sm btn-info"><i class="glyphicon glyphicon-edit"></i></a>
									</td>
								</tr>
								<?php foreach($categorys[$key]['childs'] as $k=>$v):?>
								<tr>
									<td class="text-center"><input type="checkbox" name="selected[]" value="<?php echo $categorys[$key]['childs'][$k]['category_id']; ?>" /></td>
									<td class="text-left"><?php echo $categorys[$key]['name'].'=>'.$categorys[$key]['childs'][$k]['name'];?></td>
									<td class="text-left"><?php echo $categorys[$key]['childs'][$k]['sort_order'];?></td>
									<td class="text-right"><a href="<?php echo site_url('product/category/edit?category_id='.$categorys[$key]['childs'][$k]['category_id'])?>" class="btn btn-sm btn-info"><i class="glyphicon glyphicon-edit"></i></a>
									</td>
								</tr>
								<?php endforeach;?>
								<?php endif;?>
								<?php endforeach;?>
								<?php endif;?>
							</tbody>
							<tfoot>
								<tr>
									<td colspan="4"><?php echo $pagination;?></td>
								</tr>
							</tfoot>
						</table>
					</form>
					<!-- /widget-content --> 
				</div>
				<!-- /widget --> 
			</div>
		</div>
		<!-- /span12 -->
	</div>
	<!-- /row --> 
</div>
<!-- /container -->
<?php echo $footer;//装载header?>