<?php echo $header;//装载header?>
<?php echo $top;//装载top?>
<!-- /subnavbar -->
<div class="container">
	<div class="row">
		<!-- /span6 -->
		<div class="col-md-12 middle-flat-left">
			<div class="panel panel-default">
				<div class="panel-heading row row-panel-heading bg-info">
					<div class="col-md-6 col-sm-6 col-xs-6" style="line-height: 34px"><i class="glyphicon glyphicon-th-list"></i>&nbsp;商品列表</div>
					<div class="col-md-6 col-sm-6 col-xs-6 text-right">
						<div class="btn-group" style="margin-right: 0">
							<button type="button" class="btn btn-default" onclick="confirm('确定上架所选商品吗？') ? $('#sale-product-list').attr('action','<?php echo $added;?>').submit() : false;" data-container="body" data-toggle="popover" data-placement="top" data-content="批量上架所选商品"><i class="glyphicon glyphicon-arrow-up"></i></button>
							<button type="button" class="btn btn-default" onclick="confirm('确定下架所选商品吗？') ? $('#sale-product-list').attr('action','<?php echo $shelves;?>').submit() : false;" data-container="body" data-toggle="popover" data-placement="top" data-content="批量下架所选商品"><i class="glyphicon glyphicon-arrow-down"></i></button>
							<button type="button" class="btn btn-default" onclick="confirm('确定删除所选商品吗？删除之后商品将不可恢复！') ? $('#sale-product-list').attr('action','<?php echo $delete;?>').submit() : false;" data-container="body" data-toggle="popover" data-placement="top" data-content="批量删除所选商品"><i class="glyphicon glyphicon-remove"></i></button>
						</div>
					</div>
				</div>
				<!-- /widget-header -->
				<div class="panel-body">
					<form action="<?php echo $added;?>" method="post" enctype="multipart/form-data" id="sale-product-list">
						<table class="table table-hover">
							<thead>
								<tr>
									<td class="text-center col-md-1 col-sm-1"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
									<td class="col-md-1 col-sm-2 col-xs-2">商品图</td>
									<td class="col-md-2 col-sm-3 col-xs-3">标题</td>
									<td class="col-md-1 col-sm-1 col-xs-1">价格</td>
									<td class="col-md-1 col-sm-1 col-xs-1">库存</td>
									<td class="col-md-1 col-sm-1 col-xs-1">总销量</td>
									<td class="col-md-1 hidden-xs">发布时间</td>
									<td class="col-md-2 hidden-xs">状态</td>
									<td class="text-right col-md-2 col-sm-3 col-xs-3">操作</td>
								</tr>
							</thead>
						<tbody>
						<?php if(isset($products)):?>
						<?php foreach($products as $product):?>
						<tr>
							<td class="text-center col-md-1 col-sm-1 col-xs-1"><input type="checkbox" name="selected[]" value="<?php echo $product['product_id']; ?>" /></td>
							<td class="col-md-1 col-sm-2 col-xs-2"><img width="<?php echo $this->config->get_config('wish_cart_image_size_b_w');?>px" height="<?php echo $this->config->get_config('wish_cart_image_size_b_h');?>px" class="lazy" data-original="<?php echo $product['image'];?>"></td>
							<td class="col-md-2 col-sm-3 col-xs-3"><a target="_blank" href="<?php echo base_url().'product.html?product_id='.$product['product_id'];?>"><?php echo utf8_substr($product['name'], 0, 30);?></a></td>
							<td class="col-md-1 col-sm-1 col-xs-1"><?php echo $this->currency->Compute($product['price']);?></td>
							<td class="col-md-1 col-sm-1 col-xs-1"><?php echo $product['quantity'];?></td>
							<td class="col-md-1 col-sm-1 col-xs-1"><?php echo $product['sales'];?></td>
							<td class="col-md-1 hidden-xs"><?php echo $product['date_added'];?></td>
							<td class="col-md-2 hidden-xs"><?php if($product['invalid'] == '1'){echo '永久下架';}elseif($product['date_invalid'] > date("Y-m-d H:i:s")){echo '<p class="text-danger">处罚：下架到'.$product['date_invalid'].'</p>';}elseif($product['status'] == '0'){echo '下架';}else{echo '出售中';}?></td>
							<td class="text-right col-md-2 col-sm-3 col-xs-3">
								<div class="btn-group" role="group">
									<button type="button" class="btn btn-success btn-sm" data-container="body" data-toggle="popover" data-placement="top" data-content="上架" <?php echo ($product['status'] == '0' && $product['invalid'] == '0' && $product['date_invalid'] < date("Y-m-d H:i:s")) ? '' : 'disabled="disabled"';?> onclick="added('<?php echo $product['product_id'];?>');"><i class="glyphicon glyphicon-arrow-up"></i></button>
									<button type="button" class="btn btn-warning btn-sm" data-container="body" data-toggle="popover" data-placement="top" data-content="下架" <?php echo ($product['status'] == '1' && $product['invalid'] == '0' && $product['date_invalid'] < date("Y-m-d H:i:s")) ? '' : 'disabled="disabled"';?> onclick="shelves('<?php echo $product['product_id'];?>');"><i class="glyphicon glyphicon-arrow-down"></i></button>
									<button type="button" class="btn btn-danger hidden-xs btn-sm" data-container="body" data-toggle="popover" data-placement="top" data-content="删除" onclick="product_delete('<?php echo $product['product_id'];?>');"><i class="glyphicon glyphicon-remove"></i></button>
									<a class="btn btn-info hidden-xs btn-sm" data-container="body" data-toggle="popover" data-placement="top" data-content="编辑" <?php echo ($product['invalid'] == '0' && $product['date_invalid'] < date("Y-m-d H:i:s")) ? 'href="'.site_url('product/product/edit?product_id=').$product['product_id'].'"' : 'disabled="disabled"';?> onclick="invalid('<?php echo $product['product_id'];?>','always');"><i class="glyphicon glyphicon-edit"></i></a>
								</div>
							</td>
						</tr>
						<?php endforeach;?>
						<?php endif;?>
						</tbody>
						<tfoot>
							<tr>
								<td colspan="9" class="text-left"><?php echo $pagination;?></td>
							</tr>
						</tfoot>
						</table>
					</form>
					<!-- /area-chart --> 
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
function added(product_id){
	$.ajax({
		url: '<?php echo site_url();?>/product/product/added',
		type: 'post',
		data: 'selected=' + product_id,
		beforeSend: function() {
			NProgress.start();
		},
		complete: function() {
			NProgress.done();
		},
		success: function(){
			window.location.reload();//刷新当前页面.
		} 
	});
}

function shelves(product_id){
	$.ajax({
		url: '<?php echo site_url();?>/product/product/shelves',
		type: 'post',
		data: 'selected=' + product_id,
		beforeSend: function() {
			NProgress.start();
		},
		complete: function() {
			NProgress.done();
		},
		success: function(){
			window.location.reload();//刷新当前页面.
		} 
	});
}

function product_delete(product_id){
	$.ajax({
		url: '<?php echo site_url();?>/product/product/delete',
		type: 'post',
		data: 'selected=' + product_id,
		beforeSend: function() {
			NProgress.start();
		},
		complete: function() {
			NProgress.done();
		},
		success: function(){
			window.location.reload();//刷新当前页面.
		} 
	});
}
</script><!-- /Calendar -->
<?php echo $footer;//装载header?>