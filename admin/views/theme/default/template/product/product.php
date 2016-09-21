<?php echo $header;//装载header?>
<?php echo $top;//装载top?>
<!-- /subnavbar -->
<div class="container">
	<div class="row">
		<!-- /span6 -->
		<div class="col-md-12 middle-flat-left">
			<div class="panel panel-default">
				<div class="panel-heading row row-panel-heading bg-info">
					<p class="navbar-left"><i class="glyphicon glyphicon-th-list"></i>&nbsp;商品列表</p>
					<div class="navbar-right btn-group" style="margin-right: 0">
						<button type="button" class="btn btn-default" onclick="confirm('确定处罚所选商品吗？') ? $('#form-category').submit() : false;" data-container="body" data-toggle="popover" data-placement="top" data-content="批量处罚30天"><i class="glyphicon glyphicon-remove-circle"></i></button>
					</div>
				</div>
				<!-- /widget-header -->
				<div class="panel-body">
					<form action="<?php echo $invalid; ?>" method="post" enctype="multipart/form-data" id="form-category">
						<table class="table table-hover">
							<thead>
								<tr>
									<td style="width: 5%;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
									<td style="width: 10%;"></td>
									<td style="width: 25%;">标题</td>
									<td style="width: 8%;">价格</td>
									<td style="width: 8%;">库存</td>
									<td style="width: 8%;">总销量</td>
									<td style="width: 8%;">发布时间</td>
									<td style="width: 8%;">屏蔽状态</td>
									<td style="width: 20%;" class="text-right">操作</td>
								</tr>
							</thead>
						<tbody>
						<?php if(isset($products)):?>
						<?php foreach($products as $product):?>
						<?php 
							if($product['invalid'] == '1' || $product['date_invalid'] > date("Y-m-d H:i:s")){
								$invalid='disabled="disabled"';
								$uninvalid='';
							}else{
								$invalid='';
								$uninvalid='disabled="disabled"';
							}

							if($product['invalid'] == 1){
								$str_invalid='永久';
							}elseif($product['date_invalid'] > date("Y-m-d H:i:s")){
								$str_invalid=$product['date_invalid'].'(是)';
							}else{
								$str_invalid='否';
							}
						?>
						<tr>
							<td class="text-center"><input type="checkbox" name="selected[]" value="<?php echo $product['product_id']; ?>" /></td>
							<td><a target="_blank" href="product.html?product_id=<?php echo $product['product_id'];?>"><img width="<?php echo $this->config->get_config('wish_cart_image_size_b_w');?>px" height="<?php echo $this->config->get_config('wish_cart_image_size_b_h');?>px" class="lazy" data-original="<?php echo $product['image'];?>"></a></td>
							<td><a target="_blank" href="product.html?product_id=<?php echo $product['product_id'];?>"><?php echo utf8_substr($product['name'], 0, 30);?></a></td>
							<td><?php echo $this->currency->Compute($product['price']);?></td>
							<td><?php echo $product['quantity'];?></td>
							<td><?php echo $product['sales'];?></td>
							<td><?php echo $product['date_added'];?></td>
							<td class="text-center"><?php echo $str_invalid;?></td>
							<td class="text-right">
								<div class="btn-group" role="group">
									<button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="top" data-content="解除屏蔽" <?php echo $uninvalid;?> onclick="uninvalid('<?php echo $product['product_id'];?>');"><i class="glyphicon glyphicon-ok"></i></button>
									<div class="btn-group" data-container="body" data-toggle="popover" data-placement="top" data-content="选择屏蔽时间">
										<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" <?php echo $invalid;?>>
										<i class="glyphicon glyphicon-calendar"></i>
										</button>
										<ul class="dropdown-menu" style="right: 0;left: auto;">
											<li onclick="invalid('<?php echo $product['product_id'];?>','7');"><a>7天</a></li>
											<li onclick="invalid('<?php echo $product['product_id'];?>','15');"><a>15天</a></li>
											<li onclick="invalid('<?php echo $product['product_id'];?>','30');"><a>30天</a></li>
											<li onclick="invalid('<?php echo $product['product_id'];?>','90');"><a>90天</a></li>
										</ul>
									</div>
									<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="top" data-content="永久屏蔽" <?php echo $invalid;?> onclick="invalid('<?php echo $product['product_id'];?>','always');"><i class="glyphicon glyphicon-remove"></i></button>
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
function invalid(product_id,date){
	$.ajax({
		url: '<?php echo site_url();?>/product/product/invalid',
		type: 'post',
		data: 'product_id=' + product_id +'&date_invalid=' + date,
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

function uninvalid(product_id){
	$.ajax({
		url: '<?php echo site_url();?>/product/product/uninvalid',
		type: 'post',
		data: 'product_id=' + product_id,
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