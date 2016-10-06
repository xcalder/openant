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
		
			<?php if(isset($product['images'])):?>
			<?php $product_image1 = array_shift($product['images']);?>
			<div class="panel panel-default product-image-big">
				<div class="panel-body" id="product-image-big">
					<div id="product-image" class="carousel slide" data-ride="carousel" data-interval="4000">
						<!-- 轮播（Carousel）指标-->
						<ol class="carousel-indicators image-list" style="bottom: 0">
							<li data-target="#product-image" data-slide-to="0" class="active">
							</li>
							<?php
							foreach($product['images'] as $key=>$image):?>
							<li data-target="#product-image" data-slide-to="<?php echo $key + 1;?>">
							</li>
							<?php endforeach;?>
						</ol>
						<!-- 轮播（Carousel）项目 -->
						<div class="carousel-inner">
							<div class="item active">
								<img class="lazy" data-original="<?php echo $this->image_common->resize($product_image1['image'], $this->config->get_config('product_image_size_w'), $this->config->get_config('product_image_size_h'), 'h');?>" alt="First slide" width="<?php echo $this->config->get_config('product_image_size_w');?>px" height="<?php echo $this->config->get_config('product_image_size_h')?>px">
							</div>
							<?php
							foreach($product['images'] as $image):?>
							<div class="item">
								<img class="lazy" data-original="<?php echo $this->image_common->resize($image['image'], $this->config->get_config('product_image_size_w'), $this->config->get_config('product_image_size_h'), 'h');?>" width="<?php echo $this->config->get_config('product_image_size_w');?>px" height="<?php echo $this->config->get_config('product_image_size_h');?>px">
							</div>
							<?php endforeach;?>
						</div>
					</div>
					<div class="row thm-list">
						<div class="col-md-2">
							<a class="thumbnail" data-target="#product-image" data-slide-to="0">
								<img class="lazy" data-original="<?php echo $this->image_common->resize($product_image1['image'], $this->config->get_config('product_thumbnail_size_w'), $this->config->get_config('product_thumbnail_size_h'), 'h');?>" width="<?php echo $this->config->get_config('product_thumbnail_size_w');?>px" height="<?php echo $this->config->get_config('product_thumbnail_size_h');?>px">
							</a>
						</div>
						<?php
						foreach($product['images'] as $key=>$image):?>
						<div class="col-md-2">
							<a class="thumbnail" data-target="#product-image" data-slide-to="<?php echo $key + 1;?>">
								<img class="lazy" data-original="<?php echo $this->image_common->resize($product['images'][$key]['image'], $this->config->get_config('product_thumbnail_size_w'), $this->config->get_config('product_thumbnail_size_h'), 'h');?>" width="<?php echo $this->config->get_config('product_thumbnail_size_w');?>px" height="<?php echo $this->config->get_config('product_thumbnail_size_h');?>px">
							</a>
						</div>
						<?php endforeach;?>
					</div>
				</div>
				<!-- /widget-content -->
			</div>
			<?php endif;?>
			<!-- /widget -->
			<div class="panel panel-default">
				<div class="panel-body">
					<?php
					if(isset($product['taxs'])){
						if($product['taxs']['type'] == 'F'){
							$taxes = $product['taxs']['rate'];
						}
						elseif($product['taxs']['type'] == 'P'){
							if(isset($product['discount_price'])){
								$tax_num = $tax_rate * $product['discount_price'];
							}else if(isset($product['special_price'])){
								$tax_num = $tax_rate * $product['special_price'];
							}
						}
						else{
							$taxes = '0';
						}
					}else{
						$taxes = '0';
					}
					?>
					<div id="product-price" class="col-md-9" style="padding: 0">
						<h1><?php echo $product['name'];?></h1>
						<p style="color:rgb(186, 186, 186);"><?php echo $product['meta_description'];?></p>
						
						<?php if(isset($product['discount_price'])):?>
						<div class="col-md-6" style="padding: 0">
							<?php echo lang_line('discount_price');?>
							<span class="aprice"><?php echo $this->currency->Compute($product['discount_price']);?></span>
							<?php if(isset($product['taxs'])):?>
							<?php echo sprintf(lang_line('after_tax'), ($this->currency->Compute($product['discount_price'] + $taxes)));?>
							<?php endif;?>
						</div>
						<del class="col-md-6" style="padding: 0">
							<?php echo lang_line('list_price');?>
							<span class="default_price"><?php echo $this->currency->Compute($product['price']);?>
							<?php if(isset($product['taxs'])):?>
							<?php echo sprintf(lang_line('after_tax'), ($this->currency->Compute($product['price'] + $taxes)));?>
							<?php endif;?>
							</span>
						</del>
						<div class="col-md-6 preferential" style="color:rgb(186, 186, 186);padding: 0">
							<?php echo lang_line('discount');?><?php echo $product['discount_value'];?>
						</div>
						<?php endif;?>
						
						<?php if(isset($product['special_price'])):?>
						<div class="col-md-6" style="padding: 0">
							<?php echo lang_line('member_price');?>
							<span class="aprice"><?php echo $this->currency->Compute($product['special_price']);?></span>
							<?php if(isset($product['taxs'])):?>
							<?php echo sprintf(lang_line('after_tax'), ($this->currency->Compute($product['special_price'] + $taxes)));?>
							<?php endif;?>
						</div>
						<del class="col-md-6" style="padding: 0">
							<?php echo lang_line('list_price');?>
							<span class="default_price""><?php echo $this->currency->Compute($product['price']);?>
							<?php if(isset($product['taxs'])):?>
							<?php echo sprintf(lang_line('after_tax'), ($this->currency->Compute($product['price'] + $taxes)));?>
							<?php endif;?>
							</span>
						</del>
						<div class="col-md-6 preferential" style="color:rgb(186, 186, 186);padding: 0">
							<?php echo lang_line('member_relief');?><?php echo $this->currency->Compute($product['special_value']);?>
						</div>
						<?php endif;?>
						
						<?php if(!isset($product['discount_price']) && !isset($product['special_price'])):?>
						<div class="col-md-6" style="padding: 0">
							<?php echo lang_line('list_price');?>
							<span class="default_price"><?php echo $this->currency->Compute($product['price']);?>
							<?php if(isset($product['taxs'])):?>
							<?php echo sprintf(lang_line('after_tax'), ($this->currency->Compute($product['price'] + $taxes)));?>
							<?php endif;?>
							</span>
						</div>
						<?php endif;?>
						
						<?php if(isset($product['points']) && !empty($product['points'])):?>
						<div class="col-md-6" style="padding: 0">
							<?php echo sprintf(lang_line('points_awarded'), $product['points']);?>
						</div>
						<?php endif;?>

						<?php if(isset($product['seal_quantity_total'])):?>
						<div class="col-md-6" style="padding: 0">
							<?php echo sprintf(lang_line('sales'), $product['seal_quantity_total']);?>
						</div>
						<?php endif;?>

						<?php if(isset($product['reviews'])):?>
						<div class="col-md-6" style="padding: 0">
							<?php echo sprintf(lang_line('sales'), count($product['reviews']));?>
						</div>
						<?php endif;?>
					</div>
					<div class="col-md-3 text-right hidden-xs hidden-sm" style="padding: 0">
						<img src="<?php echo $qr_code;?>">
					</div>
				</div>
			</div>
			<?php if(isset($product['options'])):?>
			<div class="panel panel-default" id="product-options">
				<div class="panel-body">
					<div>
						<p style="margin: 0"><?php echo lang_line('option');?><hr style="margin: 5px 0"></p>
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
			<div class="col-md-3 quantity" style="padding: 10px 0;"><?php echo lang_line('in_stock');?><a class="number"><?php echo $product['quantity'];?></a></div><div style="display: none" class="cart_price"><?php echo ($product['price'] + $taxes);?></div>
			<div class="col-md-9 input-group input-group-lg spinner" data-trigger="spinner" id="spinner">
				<input type="text" class="form-control" value="1" data-max="100" data-min="1" data-step="1">
				<div class="input-group-addon">
					<a href="javascript:;" class="spin-up" data-spin="up">
						<i class="glyphicon glyphicon-triangle-top">
						</i>
					</a>
					<a href="javascript:;" class="spin-down" data-spin="down">
						<i class="glyphicon glyphicon-triangle-bottom">
						</i>
					</a>
				</div>
			</div>
			<div class="btn-group btn-group-justified sale-btn" role="group" style="margin: 15px 0;">
				<div class="btn-group btn-group-lg" role="group">
					<button type="button" onclick="add_cart('buy_now');" class="btn btn-success" <?php echo $product['quantity'] < 1 ? 'disabled' : '';?>><?php echo lang_line('buy_now');?></button>
				</div>
				<div class="btn-group btn-group-lg" role="group">
					<button type="button" onclick="add_cart('');" class="btn btn-primary" <?php echo $product['quantity'] < 1 ? 'disabled' : '';?>><?php echo lang_line('add_cart');?></button>
				</div>
				<div class="btn-group btn-group-lg" role="group">
					<button type="button" class="btn btn-info"><?php echo lang_line('collect');?></button>
				</div>
			</div>
			<?php
			if(isset($product['downloads'])):?>
			<div class="panel panel-default">
				<div class="panel-body">
					<table class="table" style="margin-bottom: 0">
						<thead>
							<tr>
								<td><?php echo lang_line('t_name');?></td>
								<td><?php echo lang_line('description');?></td>
								<td><?php echo lang_line('date_added');?></td>
								<td><?php echo lang_line('dwonload');?></td>
							</tr>
						</thead>
						<tbody>
							<?php
							foreach($product['downloads'] as $download):?>
							<tr>
								<td><?php echo $download['mask'];?></td>
								<td><?php echo $download['description'];?></td>
								<td><?php echo $download['date_added'];?></td>
								<td><a href="<?php echo site_url('product/download?name=').$download['mask'].'&filename='.$download['filename'];?>"><?php echo lang_line('dwonload');?></a></td>
							</tr>
							<?php endforeach;?>
						</tbody>
					</table>
				</div>
			</div>
			<?php endif;?>
			<!-- Nav tabs -->
			<ul class="nav nav-tabs" role="tablist">
				<li role="presentation" class="active">
					<a href="#description" aria-controls="description" role="tab" data-toggle="tab"><?php echo lang_line('description');?></a>
				</li>
				<li role="presentation">
					<a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">
						<?php echo lang_line('t_review');?>
						<?php if(isset($product['reviews'])):?>
						<span class="badge"><?php echo count($product['reviews']);?></span>
						<?php endif;?>
					</a>
				</li>
			</ul>

			<!-- Tab panes -->
			<div class="tab-content">
				<div role="tabpanel" class="tab-pane active" id="description">
					<?php if(isset($product['attribute'])):?>
					<div class="panel panel-default" style="margin-top: 15px">
						<div class="panel-body row">
							<p style="padding-left: 15px"><?php echo lang_line('attribute');?></p><hr style="margin: 5px 0">
							<?php foreach($product['attribute'] as $attribute):?>
							<div class="col-md-4 row">
								<div class="col-md-5">
									<p>
										<?php echo $attribute['name'];?>：
									</p>
								</div>
								<div class="col-md-6">
									<?php if(!empty($attribute['text'])):?>
									<p class="text-center">
										<?php echo $attribute['text'];?>
									</p>
									<?php elseif(!empty($attribute['image'])):?>
									<a class="thumbnail text-center" style="margin-bottom: 0;border: 0px solid #ddd">
										<img class="lazy" data-original="<?php echo $this->image_common->resize($attribute['image'], $this->config->get_config('wish_cart_image_size_b_w'), $this->config->get_config('wish_cart_image_size_b_h'), 'h')?>" width="<?php echo $this->config->get_config('wish_cart_image_size_b_w');?>px" height="<?php echo $this->config->get_config('wish_cart_image_size_b_h');?>px">
									</a>
									<?php endif;?>
								</div>
							</div>
							<?php endforeach;?>
						</div>
					</div>
					<?php endif;?>
					<?php echo html_entity_decode($product['description']);?>
				</div>
				<div role="tabpanel" class="tab-pane" id="profile">
					<?php
					if(!isset($product['reviews'])):?>
					<?php echo lang_line('no_review');?>
					<?php else:?>
					<?php foreach($product['reviews'] as $key=>$review):?>
					<div class="media" style="padding-top: 15px;">
						<div class="media-left media-middle">
							<a href="#">
								<?php if(!empty($product['reviews'][$key]['image'])):?>
								<img class="media-object lazy" data-original="<?php echo $this->image_common->resize($product['reviews'][$key]['image'], $this->config->get_config('wish_cart_image_size_w'), $this->config->get_config('wish_cart_image_size_h'), 'h')?>" width="<?php echo $this->config->get_config('wish_cart_image_size_w');?>px" height="<?php echo $this->config->get_config('wish_cart_image_size_h');?>px" alt="<?php echo $product['reviews'][$key]['nickname'];?>">
								<?php else:?>
								<?php echo $product['reviews'][$key]['nickname'];?>
								<?php endif;?>
							</a>
						</div>
						<div class="media-body">
							<?php echo $product['reviews'][$key]['text'];?>
						</div>
					</div><hr>
					<?php endforeach;?>
					<?php endif;?>
				</div>
			</div>
			<?php echo $position_bottom; ?>
		</div>
		<?php echo $position_right; ?>
	</div>
	<!-- /row -->
	<script>
		$("#description a[href]").removeAttr("href");
		$("#description img").attr("style", "max-width: 100%;overflow:hidden");
	
		function option_price(id, group_id, cl, taxs){
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
			arrays[group_id][1]=cl;
			
			var op_ac_nu = '<?php echo count($product['options']);?>';
			if($('#product-options .active').length == op_ac_nu){
				return arrays;
			}else{
				return false;
			}
			<?php endif;?>
		}
	
		//远程请求价格数据
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
							$('#spinner input').attr("disabled","disabled").val('0');
							$('.sale-btn .btn').attr("disabled","disabled");
							$('.sale-btn .btn').attr("title","<?php echo lang_line('no_stock');?>");
						}else{
							$('#spinner input').removeAttr("disabled").val('1');
							$('.sale-btn .btn').removeAttr("disabled");
						}
				
						$('.default_price').html(data.default_price);
						if(data.type == 'discount'){
							$('.preferential').text("<?php echo lang_line('discount');?>"+data.value);
						}
						if(data.type == 'special'){
							$('.preferential').text("<?php echo lang_line('member_relief');?>"+data.value);
						}
						
						$('.quantity a').text(data.quantity);
						$('#spinner input').attr("data-max",data.quantity);
						$("#product-price span[class='aprice']").html(data.price);
						$(".points_awarded").text(data.points);
						$(".cart_price").text(data.cart_price);
					},
					error: function(xhr, ajaxOptions, thrownError)
					{
						alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					}
				});
		}
	</script>
	<script>
		<?php if(isset($product['options'])):?>
		var options=new Array();
		<?php endif;?>
		var qty='';
		var product_id='<?php echo $product_id;?>';
		var name='<?php echo $product['name'];?>';
		function add_cart(action){
			<?php if(isset($product['options'])):?>
			var op_ac_nu = '<?php echo count($product['options']);?>';
			if($('#product-options .active').length == op_ac_nu){
				$("#product-options .active").each(function(index, element){
					options[index]=$(this).attr('option_id');
				});
			
				qty = $('.spinner input').val();
				//alert(options);
				<?php if($this->user->isLogged()):?>
				ajax_add_cart(action, options, qty, product_id, name);
				<?php elseif($this->config->get_config('login_window') == '1' && !$this->agent->is_mobile()):?>
				$('#mylogin').modal({
						show: true
					})
				$('#mylogin .login-botton').addClass('active');
				<?php else:?>
					window.location.href="user/signin/login?url="+window.location.href;
				<?php endif;?>
			}else{
				$.notify({message: "<?php echo lang_line('select_product');?>" },{type: 'warning'});
				$('#product-options').attr('style','border-color: red');
				setTimeout(function () { 
						$('#product-options').removeAttr('style');
					}, 2000);
			}
			<?php else:?>
			qty = $('.spinner input').val();
			//alert(options);
			<?php if($this->user->isLogged()):?>
			ajax_add_cart(action, '', qty, product_id, name);
			<?php elseif($this->config->get_config('login_window') == '1' && !$this->agent->is_mobile()):?>
				$('#mylogin').modal({
					show: true
				})
			$('#mylogin .login-botton').addClass('active');
			<?php else:?>
				window.location.href="user/signin/login?url="+window.location.href;
			<?php endif;?>
			<?php endif;?>
		}
		function ajax_add_cart(action, options, qty, productid, name)
		{
			$.ajax(
				{
					url: '<?php echo site_url();?>user/cart/add.html',
					type: 'post',
					dataType: 'json',
					data: {option_id:options, qtys:qty, product_ids:productid, names:name},
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
							$.notify({message: data.success,},{type: 'success',});
							$.get("product/update_cart.html",function(data){
									$('#page-cart').parent().html(data);
									lazy_load();
								});
							if(action == 'buy_now'){
								$('#buy_now_value').val(data.rowid);
								submit('buy_now');
							}
						}else{
							$.notify({message: data.error },{type: 'warning'});
						}
				
					},
					error: function(xhr, ajaxOptions, thrownError)
					{
						alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					}
				});
		}

		//滑动支持

		$('#product-image').hammer().on('swipeleft', function(){

				$(this).carousel('next');

			});

		$('#product-image').hammer().on('swiperight', function(){

				$(this).carousel('prev');

			});
 
	</script>
	<form action="<?php echo site_url('user/confirm');?>" method="post" enctype="multipart/form-data" id="buy_now">
		<input type="hidden" name="selected[]" id="buy_now_value" value="">
	</form>
</div>
<!-- /container -->
<?php echo $footer;//装载header?>