<?php if(isset($product['options'])):?>
<div class="panel panel-default" id="product-options">
	<div class="panel-body">
		<div>
			<p style="margin: 0"><?php echo lang_line('option')?><hr style="margin: 5px 0"></p>
		</div>
		<?php foreach($product['options'] as $k=>$v):?>
		<div class="row" id="<?php echo $product['options'][$k]['type'].'-'.$product['options'][$k]['option_group_id'];?>">
			<div class="col-md-3 option-title">
				<p>
					<?php echo $product['options'][$k]['option_group_name'];?>：
				</p>
			</div>
			<div class="col-md-9 row">
				<?php foreach($product['options'][$k]['options'] as $key=>$value):?> 
				<?php if($product['options'][$k]['type'] == 'image'):?>
				<div class="col-md-3 col-sm-4 col-xs-4" style="margin-bottom: 10px;">
					<?php if(isset($option_image[$product['options'][$k]['options'][$key]['option_id']]['image'])):?>
					<a style="margin-bottom: 0" class="thumbnail text-center option-id-<?php echo $product['options'][$k]['options'][$key]['option_id'];?>" option_id="<?php echo $product['options'][$k]['options'][$key]['option_id'];?>" onclick="option_price('<?php echo $product['options'][$k]['type'].'-'.$product['options'][$k]['option_group_id'];?>', '<?php echo $product['options'][$k]['option_group_id'];?>', '<?php echo $product['options'][$k]['options'][$key]['option_id'];?>', '<?php echo isset($product['taxs']) ? $product['taxs']['type'].'+.+'.$product['taxs']['rate'] : '';?>');">
						<img class="lazy" data-original="<?php echo $this->image_common->resize($option_image[$product['options'][$k]['options'][$key]['option_id']]['image'], $this->config->get_config('wish_cart_image_size_s_w'), $this->config->get_config('wish_cart_image_size_s_h'), 'h')?>" width="<?php echo $this->config->get_config('wish_cart_image_size_s_w');?>px" height="<?php echo $this->config->get_config('wish_cart_image_size_s_h');?>px" alt="<?php echo $product['options'][$k]['options'][$key]['name'];?>" data-container="body" data-toggle="popover" data-placement="top" data-content="<?php echo $product['options'][$k]['options'][$key]['name'];?>">
					</a>
					<?php else:?>
					<a class="text-center option-image option-id-<?php echo $product['options'][$k]['options'][$key]['option_id'];?>" option_id="<?php echo $product['options'][$k]['options'][$key]['option_id'];?>" onclick="option_price('<?php echo $product['options'][$k]['type'].'-'.$product['options'][$k]['option_group_id'];?>', '<?php echo $product['options'][$k]['option_group_id'];?>', '<?php echo $product['options'][$k]['options'][$key]['option_id'];?>', '<?php echo isset($product['taxs']) ? $product['taxs']['type'].'+.+'.$product['taxs']['rate'] : '';?>');" style="margin-bottom: 10px"><p style="line-height: <?php echo $this->config->get_config('wish_cart_image_size_s_h').'px';?>">
							<?php echo $product['options'][$k]['options'][$key]['name'];?>
						</p></a>
					<?php endif;?>
				</div>
				<?php
				elseif($product['options'][$k]['type'] == 'text'):?>
				<div class="col-md-3 col-sm-4 col-xs-4" style="margin-bottom: 10px;">
					<?php
					if(!empty($product['options'][$k]['options'][$key]['text'])):?>
					<a class="text-center option-id-<?php echo $product['options'][$k]['options'][$key]['option_id'];?>" option_id="<?php echo $product['options'][$k]['options'][$key]['option_id'];?>" onclick="option_price('<?php echo $product['options'][$k]['type'].'-'.$product['options'][$k]['option_group_id'];?>', '<?php echo $product['options'][$k]['option_group_id'];?>', '<?php echo $product['options'][$k]['options'][$key]['option_id'];?>', '<?php echo isset($product['taxs']) ? $product['taxs']['type'].'+.+'.$product['taxs']['rate'] : '';?>');"><p>
							<?php echo $product['options'][$k]['options'][$key]['text'];?>
						</p></a>
					<?php
					else:?>
					<a class="text-center option-id-<?php echo $product['options'][$k]['options'][$key]['option_id'];?>" option_id="<?php echo $product['options'][$k]['options'][$key]['option_id'];?>" onclick="option_price('<?php echo $product['options'][$k]['type'].'-'.$product['options'][$k]['option_group_id'];?>', '<?php echo $product['options'][$k]['option_group_id'];?>', '<?php echo $product['options'][$k]['options'][$key]['option_id'];?>', '<?php echo isset($product['taxs']) ? $product['taxs']['type'].'+.+'.$product['taxs']['rate'] : '';?>');"><p>
							<?php echo $product['options'][$k]['options'][$key]['name'];?>
						</p></a>
					<?php endif;?>
				</div>
				<?php endif;?>
				<?php endforeach;?>
			</div>
		</div>
		<?php endforeach;?>
	</div>
</div>
<?php endif;?>
<script>
	function option_price(id, group_id, cl, taxs){
		//alert('#'+id+' .option-id-'+group_id);
		$('#'+id+' .active').removeClass('active');
		$('#'+id+' .option-id-'+cl).addClass('active');
		
		var re=is_select_all(group_id, cl);
		if(re !== false){
			option(re, taxs);
		}
	}
	
	var arrays=new Array();
	function is_select_all(group_id, cl){
		<?php if(isset($product['options'])):?>
		//组装数组
		arrays[group_id]=new Array();
		//arrays[group_id][0]=group_id;
		arrays[group_id][1]=cl;
		
		var op_ac_nu = '<?php echo count($product['options']);?>';
		if($('#product-options .active').length == op_ac_nu){
			return arrays;
		}else{
			return false;
		}
		<?php endif;?>
	}
	
	//远程请求选项
	function option(a, taxs)
	{
	$.ajax(
		{
			url: '<?php echo site_url();?>product/option.html?product_id=<?php echo $this->input->get('product_id');?>',
			type: 'post',
			dataType: 'json',
			data: {arr:a, taxs:taxs},
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
				if(data.sale == 'fail'){
					if($('#product-options .panel-body .no-sale').length > 0){
						$('#product-options .panel-body .no-sale').text("<?php echo lang_line('not_buy')?>");
					}else{
						$('#product-options .panel-body').append('<div class="col-md-12 no-sale text-center" style="color: red;"><?php echo lang_line("not_buy")?></div>');
					}
				}else{
					$('#product-options .panel-body .no-sale').remove();
					cart_option_update(a, taxs);
				}
			},
			error: function(xhr, ajaxOptions, thrownError)
			{
				//alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	}
	
	//远程请求价格数据
	function cart_option_update(a, taxs)
	{
		var numbe=$('input[rowid=\'<?php echo $rowid;?>\']').val();
		var rowid=$('input[rowid=\'<?php echo $rowid;?>\']').attr('rowid');
		var keyb=$('input[rowid=\'<?php echo $rowid;?>\']').attr('keyb');
		
		$.ajax(
		{
			url: '<?php echo site_url();?>product/option/cart_option_update.html?product_id=<?php echo $this->input->get('product_id')?>',
			type: 'post',
			dataType: 'json',
			data: {arr:a, taxs:taxs, number:numbe, rowids:rowid},
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
				if(data.sale == 'success'){
					$('.cart-table-product .subtotal-'+keyb).text(data.total_price);
					$('.cart-table-product .price-'+keyb).text(data.tax_price);
					$('.cart-table-product .option-'+keyb+' .cart-table-options').text(data.options);
					$('input[rowid=\'<?php echo $rowid;?>\']').attr('data-max',data.quantity);
					$('input[rowid=\'<?php echo $rowid;?>\']').attr('price',data.default_price);
					$('#cart-options-edit-modal').modal('hide');
				}else{
					if($('#product-options .panel-body .no-sale').length > 0){
						$('#product-options .panel-body .no-sale').text('<?php echo lang_line("not_buy");?>');
					}else{
						$('#product-options .panel-body').append('<div class="col-md-12 no-sale text-center" style="color: red;"><?php echo lang_line("not_buy")?></div>');
					}
				}
			},
			error: function(xhr, ajaxOptions, thrownError)
			{
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	}
</script>