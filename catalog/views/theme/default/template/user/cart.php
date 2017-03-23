<?php echo $header;//装载header?>
<?php echo $top;//装载top?>
<!-- /subnavbar -->
<div class="container">
	<div class="row"><?php echo $position_left;?>
  
		<?php if($position_left && $position_right):?>
		<?php $class = 'col-sm-6'; ?>
		<?php elseif($position_left || $position_right):?>
		<?php $class = 'col-sm-9'; ?>
		<?php else:?>
		<?php $class = 'col-sm-12'; ?>
		<?php endif;?>
	
		<div id="middle" class="<?php echo $class; ?>">
			<?php echo $position_top; ?>
			<!-- Nav tabs -->
			<ul class="nav nav-tabs" role="tablist" style="margin-bottom: 15px">
				<li role="presentation" class="active"><a href="#cart-all" aria-controls="cart-all" role="tab" data-toggle="tab">购物车商品<span class="label label-info" id="cart_quantity"><?php echo $i;?></span></a></li>
				
				<div class="carts-top-info">已选商品(不含运费)<a class="value-">0.00</a><button type="button" class="btn btn-info btn-xs">结算</button></div>
			</ul>

			<!-- Tab panes -->
			<div class="tab-content" id="cart-table-all">
				<div role="tabpanel" class="tab-pane active" id="cart-all">
					<?php if($carts_product):?>
					<div class="panel panel-default">
						<!-- Table -->
						<form action="<?php echo $this->config->item('catalog').'user/confirm';?>" method="post" enctype="multipart/form-data" id="cart-form">
						<table class="table table-striped">
							<thead>
								<tr>
									<td style="width: 8%" class="text-center"><input class="checkall" type="checkbox" onclick="$('input[class*=\'select\']').prop('checked', this.checked);"/>&nbsp;全选</td>
									<td style="width: 25%">商品信息</td>
									<td style="width: 25%">选项</td>
									<td style="width: 10%">单价(含税)</td>
									<td style="width: 10%">数量</td>
									<td style="width: 10%">金额(含税)</td>
									<td style="width: 10%">操作</td>
								</tr>
							</thead>
							<tbody>
								<?php foreach($carts_product as $key=>$value):?>
								<?php if(isset($value['store_name']) && isset($value['products'])):?>
								<tr class="cart-table-store">
									<td class="text-center"><input ifcheckall="1" store="store-id-<?php echo $carts_product[$key]['store_id'];?>" type="checkbox" class="select" onclick="$('input[class_=\'select-<?php echo $carts_product[$key]['store_id'];?>\']').prop('checked', this.checked);" /></td>
									<td colspan="3">店铺：<?php echo $carts_product[$key]['store_name'];?></td>
									<td colspan="3"></td>
								</tr>
								<?php if(isset($carts_product[$key]['products'])):?>
								<?php foreach($carts_product[$key]['products'] as $b=>$c):?>
				    	
								<tr class="cart-table-product">
									<td style="width: 8%" class="text-center">&nbsp;&nbsp;<input ifcheckall="1" product="store-product-<?php echo $carts_product[$key]['store_id'];?>" onclick="select_store_product('<?php echo $carts_product[$key]['store_id'];?>');" type="checkbox" class_="select-<?php echo $carts_product[$key]['store_id'];?>" class="select product" name="selected[]" value="<?php echo $carts_product[$key]['products'][$b]['rowid']; ?>" /></td>
									<td style="width: 25%">
										<div class="media">
											<div class="media-left media-middle">
												<a target="_blank" href="<?php echo $this->config->item('catalog').'product?product_id='.$carts_product[$key]['products'][$b]['id'];?>">
													<img width="<?php echo $this->config->get_config('wish_cart_image_size_b_w');?>px" height="<?php echo $this->config->get_config('wish_cart_image_size_b_h');?>px" style="max-width: <?php echo $this->config->get_config('wish_cart_image_size_b_w');?>px;display: block;" class="media-object lazy" data-original="<?php echo $this->image_common->resize($carts_product[$key]['products'][$b]['image'], $this->config->get_config('wish_cart_image_size_b_w'), $this->config->get_config('wish_cart_image_size_b_h'));?>" alt="<?php echo $carts_product[$key]['products'][$b]['name']; ?>">
												</a>
											</div>
											<div class="media-body">
												<a class="cart-table-product-name" target="_blank" href="<?php echo $this->config->item('catalog').'product?product_id='.$carts_product[$key]['products'][$b]['id'];?>"><?php echo $carts_product[$key]['products'][$b]['name']; ?></a>
											</div>
										</div>
									</td>
									<td style="width: 25%;position: relative;" class="<?php echo !empty($carts_product[$key]['products'][$b]['options']) ? 'cart-table-options-p option-'.$key.$b : '';?>"><span class="cart-table-options"><?php echo isset($carts_product[$key]['products'][$b]['options']) ? $carts_product[$key]['products'][$b]['options'] : '';?></span>
										<?php if(!empty($carts_product[$key]['products'][$b]['options'])):?>
										<div class="options-edit" onclick="edit_options('<?php echo $carts_product[$key]['products'][$b]['id'];?>','<?php echo $carts_product[$key]['products'][$b]['rowid'];?>');"><i class="glyphicon glyphicon-edit"></i></div>
										<?php endif;?>
									</td>
									<td class="price-<?php echo $key.$b;?>" style="width: 10%;font-weight:bold"><?php echo $this->currency->Compute($carts_product[$key]['products'][$b]['price']); ?></td>
									<td style="width: 10%">
										<div class="input-group input-group-bg spinner" data-trigger="spinner" id="spinner">
											<input type="text" class="form-control" value="<?php echo $carts_product[$key]['products'][$b]['qty']; ?>" data-max="100" data-min="1" data-step="1" rowid="<?php echo $carts_product[$key]['products'][$b]['rowid']; ?>" price="<?php echo $carts_product[$key]['products'][$b]['price']; ?>" keyb="<?php echo $key.$b;?>"/>
											<div class="input-group-addon">
												<a href="javascript:;" class="spin-up qty-change" data-spin="up">
													<i class="glyphicon glyphicon-triangle-top">
													</i>
												</a>
												<a href="javascript:;" class="spin-down qty-change" data-spin="down">
													<i class="glyphicon glyphicon-triangle-bottom">
													</i>
												</a>
											</div>
										</div>
									</td>
									<td class="subtotal-<?php echo $key.$b;?> all-price" style="width: 10%;color: #f40;font-size: 18px"><?php echo $this->currency->Compute($carts_product[$key]['products'][$b]['subtotal']);?></td>
									<td style="width: 10%" class="text-center cart-operating"><a style="cursor: pointer;">移到收藏夹</a><br/><a style="cursor: pointer;" onclick="remove_cart('<?php echo $carts_product[$key]['products'][$b]['rowid']; ?>');">删除</a></td>
								</tr>
				    	
								<?php endforeach;?>
								<?php endif;?>
								<?php endif;?>
								<?php endforeach;?>
							</tbody>
							<tfoot style="background-color: #5bc0de; color: #FFF">
								<tr>
									<td colspan="4"><div class="carts-top-info">已选商品(不含运费):<a class="value-" style="color: #FFF">0.00</a></div></td>
									<td colspan="3"><button type="submit" class="btn btn-success cart-confirm" style="float: right" disabled="disabled">结算</button></td>
								</tr>
							</tfoot>
						</table>
						</form>
					</div>
					<?php endif;?>
				</div>
				<div role="tabpanel" class="tab-pane" id="cart-price-reduction">2...</div>
				<div role="tabpanel" class="tab-pane" id="cart-tight-inventories">3...</div>
			</div>
		
			<div id="cart-options-edit-modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="cart-options">
				<div class="modal-dialog modal-lg">
					<div class="modal-content"></div>
				</div>
				<?php echo $position_bottom; ?>
			</div>
			<?php echo $position_right; ?>
		</div>
	</div>
	<!-- /row -->
	<script>
	function change_price(){
		var price_totla=new Array();
		var t_all=parseFloat('00.00');
		$('input[type=\'checkbox\']:checked').each(function(index){
				var value =$(this).attr("value");
				if(!value==undefined || !value=="" || !value==null){
					price_totla[index] = $(this).parent().parent().find('.all-price').text();
				}
			});
		for(var i = 0 ;i<price_totla.length;i++)
		{
			if(price_totla[i] == "" || typeof(price_totla[i]) == "undefined")
			{
				price_totla.splice(i,1);
				i= i-1;
  
			}else{
				t_all=parseFloat(price_totla[i].replace(/[^\d.]/g,'')) + t_all;
			}
		}
		if(t_all > 0){
			$('.cart-confirm').removeAttr("disabled");
		}else{
			$('.cart-confirm').attr("disabled","disabled");
		}
		$.get("<?php echo $this->config->item('catalog').'common/currency/compute?currency='?>"+t_all, function(data){
			$('.carts-top-info .value-').text(data.value);
		});
	}
		$(document).ready(function(){
			$('input[type=\'checkbox\']').click(function(){
				change_price();
			});
		
			$('#cart-table-all table tbody .cart-table-options-p').mouseenter(function(){
					$(this).find('.options-edit').show();
				});
			$('#cart-table-all table tbody .cart-table-options-p').mouseleave(function(){
					$(this).find('.options-edit').hide();
				});

			$('#cart-table-all #spinner input').change(function(){
					qty=$(this).val();
					rowid=$(this).attr('rowid');
					price=$(this).attr('price');
					key=$(this).attr('keyb');
					if(qty > 0){
						qty_change(qty, price, rowid, key);
					}
				});
			$('#cart-table-all #spinner .spin-up').click(function(){
					qty=parseInt($(this).parent().parent().find('input').val()) + 1;
					rowid=$(this).parent().parent().find('input').attr('rowid');
					price=$(this).parent().parent().find('input').attr('price');
					key=$(this).parent().parent().find('input').attr('keyb');
					if(qty > 0){
						qty_change(qty, price, rowid, key);
					}
				});
			$('#cart-table-all #spinner .spin-down').click(function(){
					qty=parseInt($(this).parent().parent().find('input').val()) - 1;
					rowid=$(this).parent().parent().find('input').attr('rowid');
					price=$(this).parent().parent().find('input').attr('price');
					key=$(this).parent().parent().find('input').attr('keyb');
					if(qty > 0){
						qty_change(qty, price, rowid, key);
					}
				});
			});
		function qty_change(qty, price, rowid, key){
			$.ajax(
				{
					url: '<?php echo $this->config->item('catalog').'user/cart/update';?>',
					type: 'post',
					dataType: 'json',
					data: {qty:qty, price:price, rowid:rowid},
					beforeSend: function()
					{
						NProgress.start();
					},
					complete: function()
					{
						NProgress.done();
					},
					success: function(data)
					{
						if(data.success){
							$('#cart-table-all .subtotal-'+key).text(data.subtotal);
							$('input[rowid=\''+rowid+'\']').attr('value',qty);
							change_price();
						}else{
							$.notify({message: data.error },{type: 'warning',offset: {x: 0,y: 52}});
						}
				
					},
					error: function(xhr, ajaxOptions, thrownError)
					{
						alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					}
				});
		}
	
		function edit_options(id, rowid){
			$.ajax(
				{
					url: '<?php echo $this->config->item('catalog').'product/option/cart_option?product_id=';?>'+id,
					type: 'post',
					dataType: 'html',
					data: {product_id:id, rowid:rowid},
					beforeSend: function()
					{
						NProgress.start();
					},
					complete: function()
					{
						NProgress.done();
					},
					success: function(html)
					{
						if(html){
							$('#cart-options-edit-modal .modal-content').html(html);
							$('#cart-options-edit-modal').modal();
							lazy_load();
						}
					},
					error: function(xhr, ajaxOptions, thrownError)
					{
						alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					}
				});
		}
	
		function remove_cart(rowid){
			$.ajax(
				{
					url: '<?php echo $this->config->item('catalog').'product/option/remove_cart';?>',
					type: 'post',
					dataType: 'json',
					data: {rowid:rowid},
					beforeSend: function()
					{
						NProgress.start();
					},
					complete: function()
					{
						NProgress.done();
					},
					success: function(data)
					{
						if(data.success){
							$.notify({message: data.success },{type: 'success',offset: {x: 0,y: 52}});
							$('#cart_quantity').html($('#cart_quantity').html() - 1);
							if($('input[rowid=\''+rowid+'\']').parent().parent().parent().prev('tr').hasClass('cart-table-store')){
								$('input[rowid=\''+rowid+'\']').parent().parent().parent().prev('tr').remove();
							}
							$('input[rowid=\''+rowid+'\']').parent().parent().parent().remove();
							$.get("product/update_cart",function(data){
									$('#page-cart').parent().html(data);
									change_price();
								});
						}else{
							$.notify({message: data.error },{type: 'warning',offset: {x: 0,y: 52}});
						}
					},
					error: function(xhr, ajaxOptions, thrownError)
					{
						alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					}
				});
		}
	
		$(".ystep1").loadStep({
				//ystep的外观大小
				//可选值：small,large
				size: "small",
				//ystep配色方案
				//可选值：green,blue
				color: "green",
				//ystep中包含的步骤
				steps: [{
						//步骤名称
						title: "添加",
						//步骤内容(鼠标移动到本步骤节点时，会提示该内容)
						content: "验证注册邮箱，并通过提示完成密码重置！"
					},{
						title: "确认",
						content: "邮件已经发送成功，等待验证！"
					},{
						title: "购买",
						content: "重置你的登陆密码！"
					},{
						title: "结帐",
						content: "重置你的登陆密码！"
					},{
						title: "收货",
						content: "重置你的登陆密码！"
					},{
						title: "评价",
						content: "重置你的登陆密码！"
					},{
						title: "成功",
						content: "重置你的登陆密码！"
					}]
			});
		$(".ystep1").setStep(2);
		
		$('#cart-form input[type=\'checkbox\']').click(function(){
			var insize=parseInt($('#cart-form input[ifcheckall=\'1\']').size());
			var chsize=parseInt($('#cart-form input[ifcheckall=\'1\']:checked').size());

			if(chsize >= 1){
				if(chsize < insize){
					$('.checkall').prop("indeterminate", true);
				}else if(chsize = insize){
					$('.checkall').prop("indeterminate", false);
					$('.checkall').attr("checked", "checked");
				}
			}else{
				$('.checkall').prop("indeterminate", false);
				$('.checkall').removeAttr("checked");
			}
		});
		
		function select_store_product(store_id){
			var insize=parseInt($('#cart-form input[product=\'store-product-'+store_id+'\']').size());
			var chsize=parseInt($('#cart-form input[product=\'store-product-'+store_id+'\']:checked').size());

			if(chsize >= 1){
				if(chsize < insize){
					$('input[store=\'store-id-'+store_id+'\']').prop("indeterminate", true);
				}else if(chsize = insize){
					$('input[store=\'store-id-'+store_id+'\']').prop("indeterminate", false);
					$('input[store=\'store-id-'+store_id+'\']').attr("checked", true);
				}
			}else{
				$('input[store=\'store-id-'+store_id+'\']').prop("indeterminate", false);
				$('input[store=\'store-id-'+store_id+'\']').attr("checked", false);
			}
		}
		
	</script>
	<style type="text/css">
		.ystep-container{
			margin-left: calc(50% - 180px);
		}
	</style>
</div>
<!-- /container -->
<?php echo $footer;//装载header?>