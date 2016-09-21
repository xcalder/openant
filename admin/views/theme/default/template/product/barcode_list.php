<?php echo $header;//装载header?>
<?php echo $top;//装载top?>
<!-- /subnavbar -->
<div class="container">
	<div class="row">
		<div class="col-md-12 middle-flat-left">
			<div class="panel panel-default">
				<div class="panel-heading row row-panel-heading bg-info">
					<p class="navbar-left"><i class="glyphicon glyphicon-th-list"></i>&nbsp;条码列表</p>
					<div class="navbar-right btn-group" style="margin-right: 0">
						<a href="admin.php/product/barcode/add.html" class="btn btn-default"><i class="glyphicon glyphicon-plus"></i></a>
						<button type="button" class="btn btn-default" onclick="confirm('确定删除分类吗？') ? $('#form-barcode').submit() : false;"><i class="glyphicon glyphicon-trash"></i></button>
					</div>
				</div>
				<!-- /widget-header -->
				<div class="panel-body">
					<form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-barcode">
						<table class="table">
							<thead>
								<tr>
									<th style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></th>
									<th>名称</th>
									<th>排序</th>
									<th class="text-right">操作</th>
								</tr>
							</thead>
							<tbody>
								<?php if(isset($barcodes)):?>
								<?php foreach($barcodes as $barcode):?>
								<tr>
									<td class="text-center"><input type="checkbox" name="selected[]" value="<?php echo $barcode['barcode_id']; ?>" /></td>
									<td><?php echo $barcode['name'];?></td>
									<td><?php echo $barcode['sort_order'];?></td>
									<td class="text-right"><a href="<?php echo site_url('product/barcode/edit?barcode_id='.$barcode['barcode_id'])?>" class="btn btn-info"><i class="glyphicon glyphicon-edit"></i></a>
									</td>
								</tr>
								<?php endforeach;?>
								<?php endif;?>
							</tbody>
							<tfoot>
								<tr>
									<td colspan="4" class="text-left"><?php echo $pagination;?></td>
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
