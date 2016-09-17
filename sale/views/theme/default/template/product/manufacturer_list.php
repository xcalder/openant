<?php echo $header;//装载header?>
<?php echo $top;//装载top?>
<!-- /subnavbar -->
<div class="container">
	<div class="row">
		<div class="col-md-12 middle-flat-left">
			<div class="panel panel-default">
				<div class="panel-heading row row-panel-heading bg-info">
					<p class="navbar-left"><i class="glyphicon glyphicon-th-list"></i>&nbsp;品牌列表</p>
					<div class="navbar-right btn-group" style="margin-right: 0">
						<a href="sale.php/product/manufacturer/add.html" class="btn btn-default"><i class="glyphicon glyphicon-plus"></i></a>
						<button type="button" class="btn btn-default" onclick="confirm('确定删除分类吗？') ? $('#form-manufacturer').submit() : false;"><i class="glyphicon glyphicon-trash"></i></button>
					</div>
				</div>
				<!-- /widget-header -->
				<div class="panel-body">
					<form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-manufacturer">
						<table class="table">
							<thead>
								<tr>
									<th style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></th>
									<th>名称</th>
									<th>状态</th>
									<th>排序</th>
									<th class="text-right">操作</th>
								</tr>
							</thead>
							<tbody>
								<?php if(isset($manufacturers)):?>
								<?php foreach($manufacturers as $manufacturer):?>
								<tr>
									<td class="text-center"><input type="checkbox" name="selected[]" value="<?php echo $manufacturer['manufacturer_id']; ?>" /></td>
									<td><?php echo $manufacturer['name'];?></td>
									<td><?php echo ($manufacturer['status'] == '1') ? '待审核' : '审核通过';?></td>
									<td><?php echo $manufacturer['sort_order'];?></td>
									<td class="text-right"><a href="<?php echo site_url('product/manufacturer/edit?manufacturer_id='.$manufacturer['manufacturer_id'])?>" class="btn btn-info"><i class="glyphicon glyphicon-edit"></i></a>
									</td>
								</tr>
								<?php endforeach;?>
								<?php endif;?>
							</tbody>
							<tfoot>
								<tr>
									<td colspan="5" class="text-left"><?php echo $pagination;?></td>
								</tr>
							</tfoot>
						</table>
					</form>
				</div>
				<!-- /widget-content --> 
			</div>
		</div>
		<!-- /span6 --> 
	</div>
	<!-- /row --> 
</div>
<!-- /container -->
<?php echo $footer;//装载header?>