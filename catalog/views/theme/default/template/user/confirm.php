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
			<form action="<?php echo $this->config->item('catalog').'user/confirm/checkout';?>" method="post" enctype="multipart/form-data" id="forget-form">
				<!-- Nav tabs -->
				<strong>选择收货地址</strong><hr style="margin: 15px 0;border-top: 2px solid #5bc0de">
				<?php if(!$check_out):?>
				<p class="text-danger">请先<a onclick="add_address();">添加收货地址</a>或到<a target="_blank" href="<?php echo $this->config->item('catalog').'user/address';?>">管理地址</a>然后刷新页面</p>
				<?php else:?>
				<div class="row show-address" style="margin-left: -15px;height: 130px;overflow: hidden;">
					<?php if($addresss):?>
					<?php foreach($addresss as $key=>$address):?>
					<?php if($addresss[$key]['address_id'] == $this->user->getAddressId()):?>
					<div class="col-sm-3">
						<input type="hidden" value="<?php echo $addresss[$key]['address_id'];?>" name="order[address_id]">
						<div class="well confirm-address confirm-active" data-id="<?php echo $addresss[$key]['address_id'];?>">
							<?php echo $addresss[$key]['address'];?>
							<div class="address-edit" onclick="edit_address('<?php echo $address['address_id']?>', '<?php echo $this->user->getAddressId()?>');">修改</div>
						</div>
					</div>
					<?php unset($addresss[$key]);?>
					<?php endif;?>
					<?php endforeach;?>
				
					<?php if(!empty($addresss)):?>
					<?php foreach($addresss as $address):?>
					<div class="col-sm-3">
						<div class="well confirm-address" data-id="<?php echo $address['address_id'];?>">
							<?php echo $address['address'];?>
							<div class="address-edit" onclick="edit_address('<?php echo $address['address_id']?>');">修改</div>
						</div>
					</div>
					<?php endforeach;?>
					<?php endif;?>
					<?php endif;?>
				</div>
				<?php endif;?>
				<hr style="margin: 5px 0">
				<?php if($check_out):?>
				<div class="row" style="margin: 15px 0">
					<a class="new-address col-sm-4" style="cursor: pointer;padding-left: 0" onclick="show_all();">显示全部地址<i class="glyphicon glyphicon-menu-down"></i></a>
					<a class="col-sm-4 text-center" style="cursor: pointer" onclick="payment_address();" data-container="body" data-toggle="popover" data-placement="top" data-content="默认同收货地址，如果帐单地址不同请点击修改！" data-original-title="" title="">单独设置帐单地址<i class="glyphicon glyphicon-piggy-bank"></i></a>
					<a class="col-sm-4 text-right" style="cursor: pointer;padding-right: 0" target="_blank" href="<?php echo $this->config->item('catalog').'user/address';?>">管理地址<i class="glyphicon glyphicon-edit"></i></a>
				</div>
				<?php endif;?>
				<strong>确认商品信息</strong><hr style="margin: 15px 0;border-top: 2px solid #5bc0de">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<td>商品信息</td>
								<td>选项</td>
								<td>单价</td>
								<td>数量</td>
								<td>价格</td>
							</tr>
						</thead>
						<tbody>
							<?php foreach($carts_product as $key=>$value):?>
							<tr class="cart-table-store" style="background-color: #d9edf7;">
								<td colspan="3">店铺：<?php echo $carts_product[$key]['store_name'];?></td>
								<td colspan="2"></td>
							</tr>
							<?php if(isset($carts_product[$key]['products'])):?>
							<?php foreach($carts_product[$key]['products'] as $b=>$c):?>
							<tr class="cart-table-product">
								<td style="width: 25%">
									<div class="media">
										<div class="media-left media-middle">
											<input type="hidden" value="<?php echo $carts_product[$key]['products'][$b]['rowid'];?>" name="rowid[]"/>
											<a target="_blank" href="<?php echo $this->config->item('catalog').'product?product_id='.$carts_product[$key]['products'][$b]['id'];?>">
												<img width="<?php echo $this->config->get_config('wish_cart_image_size_b_w');?>px" height="<?php echo $this->config->get_config('wish_cart_image_size_b_h');?>px" style="max-width: <?php echo $this->config->get_config('wish_cart_image_size_b_w');?>px;display: block;" class="media-object lazy" data-original="<?php echo $this->image_common->resize($carts_product[$key]['products'][$b]['image'], $this->config->get_config('wish_cart_image_size_b_w'), $this->config->get_config('wish_cart_image_size_b_h'));?>" alt="<?php echo $carts_product[$key]['products'][$b]['name']; ?>">
											</a>
										</div>
										<div class="media-body">
											<a class="cart-table-product-name" target="_blank" href="<?php echo $this->config->item('catalog').'product?product_id='.$carts_product[$key]['products'][$b]['id'];?>"><?php echo $carts_product[$key]['products'][$b]['name']; ?></a>
										</div>
									</div>
								</td>
								<td style="width: 25%;"><?php echo isset($carts_product[$key]['products'][$b]['options']) ? $carts_product[$key]['products'][$b]['options'] : '';?></td>
								<td class="price-<?php echo $key.$b;?>" style="width: 10%;font-weight:bold"><?php echo $this->currency->Compute($carts_product[$key]['products'][$b]['price']); ?></td>
								<td style="width: 10%"><?php echo $carts_product[$key]['products'][$b]['qty']; ?></td>
								<td class="subtotal-<?php echo $key.$b;?> all-price" style="width: 10%;color: #f40;font-size: 18px"><?php echo $this->currency->Compute($carts_product[$key]['products'][$b]['subtotal']);?></td>
							
							</tr>
							<?php endforeach;?>
						
							<!--留言-->
							<tr>
								<td colspan="5">
									<div class="form-group">
										<label for="store-number-<?php echo $carts_product[$key]['store_id'];?>" class="col-sm-2 control-label" style="line-height: 34px;magin: 0;font-weight: 200">给商家留言</label>
										<div class="col-sm-10">
											<input type="text" name="order[<?php echo $carts_product[$key]['store_id'];?>][message]" class="form-control" id="store-number-<?php echo $carts_product[$key]['store_id'];?>" placeholder="给商家留言">
										</div>
									</div></td>
							</tr>
						
							<?php endif;?>
							<?php endforeach;?>
						</tbody>
					</table>
					<?php if($check_out):?>
					<strong>确认订单信息</strong><hr style="margin: 15px 0;border-top: 2px solid #5bc0de">
					<table class="table">
						<tfoot>
							<tr>
								<td colspan="7">收货地址：<span id="shipping-address"></span></td>
							</tr>
							<tr>
								<td colspan="7">帐单地址：<span id="payment_address"></span></td>
							</tr>
							<tr style="background-color: #5bc0de; color: #FFF">
								<td colspan="4"><div class="carts-top-info">结账价格(含运费):<a class="value-" style="color: #FFF"><?php echo $total;?></a></div></td>
								<td colspan="3"><button type="submit" class="btn btn-success cart-confirm" style="float: right">提交订单</button></td>
							</tr>
						</tfoot>
					</table>
					<?php endif;?>
				</div>
			</form>
			<?php echo $position_bottom; ?>
		</div>
		<?php echo $position_right; ?>
	</div>
	
	<!--修改地址-->
	<div class="modal fade" id="edit-shop-address" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content edit-address-from"></div>
		</div>
	</div>
	<!--修改地址-->
	
	<!-- /row -->
	<script>
		function edit_address(id, def){
			$.ajax(
				{
					url: '<?php echo $this->config->item('catalog').'user/confirm/edit_address';?>',
					type: 'post',
					dataType: 'json',
					data: {address_id:id},
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
						if(data.status == 'success'){
							//$.notify({message: data.success },{type: 'success',offset: {x: 0,y: 52}});
							var html  = '<form id="form1" class="form-horizontal" action="<?php echo $this->config->item('catalog').'user/confirm/edit_addres';?>" method="post" style="padding: 15px">';
							html += '<input type="hidden" name="address_id" value="'+id+'">';
							html += '<div class="form-group">';
							html += '<label for="firstname" class="col-sm-2 control-label">姓氏：</label>';
							html += '<div class="col-sm-10">';
							html += '<input type="text" name="firstname" class="form-control" id="firstname" placeholder="姓氏" value="'+data.address.firstname+'">';
							html += '</div></div>';
							html += '<div class="form-group">';
							html += '<label for="lastname" class="col-sm-2 control-label">名字：</label>';
							html += '<div class="col-sm-10">';
							html += '<input type="text" class="form-control" name="lastname" id="lastname" placeholder="名字" value="'+data.address.lastname+'">';
							html += '</div></div>';
							html += '<div class="form-group">';
							html += '<label for="postcode" class="col-sm-2 control-label">邮编：</label>';
							html += '<div class="col-sm-10">';
							html += '<input type="text" name="postcode" class="form-control" id="postcode" placeholder="邮编" value="'+data.address.postcode+'">';
							html += '</div></div>';
							html += '<div class="form-group">';
							html += '<label for="address" class="col-sm-2 control-label">地址：</label>';
							html += '<div class="col-sm-10">';
							html += '<input type="text" name="address" class="form-control" id="address" placeholder="详细地址" value="'+data.address.address+'">';
							html += '</div></div>';
							html += '<div class="form-group">';
							html += '<label for="city" class="col-sm-2 control-label">城市：</label>';
							html += '<div class="col-sm-10">';
							html += '<input type="text" class="form-control" name="city" id="city" placeholder="城市" value="'+data.address.city+'">';
							html += '</div></div>';
							
							html += '<div class="form-group">';
							html += '<label class="col-sm-2 control-label" for="country">国家</label>';
							html += '<div class="col-sm-10">';
							html += '<select class="form-control" id="country" onchange="countryd(this, \''+data.address.zone_id+'\');" name="country_id" class="form-control">';
							html += '<option value="">--无--</option>';
				
							$(data.countrys).each(function(){
									if(this.country_id == data.address.country_id){
										html += '<option value="' + this.country_id + '" selected="selected">' + this.name + '</option>';
									}else{
										html += '<option value="' + this.country_id + '">' + this.name + '</option>';
									}
								});
							
							html += '</select></div></div>';
							html += '<div class="form-group">';
							html += '<label class="col-sm-2 control-label" for="zone">省份</label>';
							html += '<div class="col-sm-10">';
							html += '<select name="zone_id" id="zone" class="form-control"></select></div></div>';
											
							html += '<div class="form-group">';
							html += '<div class="col-sm-offset-2 col-sm-10">';
							html += '<div class="checkbox">';
							html += '<label>';
							if(id == def){
								html += '<input type="checkbox" name="user_address_id" value="'+id+'" checked>设为默认';
							}else{
								html += '<input type="checkbox" name="user_address_id" value="'+id+'">设为默认';
							}
							
							html += '</label></div></div></div>';
							html += '<div class="form-group">';
							html += '<div class="col-sm-offset-2 col-sm-10">';
							html += '<a class="btn btn-default" onclick="autoSubmitFun();">确定</a>';
							html += '</div></div></form>';
							
							$.ajax(
								{
									url: '<?php echo $this->config->item('catalog').'user/confirm/zone?zone_id=';?>'+data.address.zone_id+'&country_id='+data.address.country_id,
									type: 'get',
									dataType: 'html',
									success: function(dataa)
									{
										$('#zone').html(dataa);
									}
								});
							
							$('.edit-address-from').html(html);
							$('#edit-shop-address').modal();
							change_shipping_address();
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
		
		function add_address(){
			var html  = '<form id="form1" class="form-horizontal" action="<?php echo $this->config->item('catalog').'user/confirm/add_addres';?>" method="post" style="padding: 15px">';
			html += '<div class="form-group">';
			html += '<label for="firstname" class="col-sm-2 control-label">姓氏：</label>';
			html += '<div class="col-sm-10">';
			html += '<input type="text" name="firstname" class="form-control" id="firstname" placeholder="姓氏" value="">';
			html += '</div></div>';
			html += '<div class="form-group">';
			html += '<label for="lastname" class="col-sm-2 control-label">名字：</label>';
			html += '<div class="col-sm-10">';
			html += '<input type="text" class="form-control" name="lastname" id="lastname" placeholder="名字" value="">';
			html += '</div></div>';
			html += '<div class="form-group">';
			html += '<label for="postcode" class="col-sm-2 control-label">邮编：</label>';
			html += '<div class="col-sm-10">';
			html += '<input type="text" name="postcode" class="form-control" id="postcode" placeholder="邮编" value="">';
			html += '</div></div>';
			html += '<div class="form-group">';
			html += '<label for="address" class="col-sm-2 control-label">地址：</label>';
			html += '<div class="col-sm-10">';
			html += '<input type="text" name="address" class="form-control" id="address" placeholder="详细地址" value="">';
			html += '</div></div>';
			html += '<div class="form-group">';
			html += '<label for="city" class="col-sm-2 control-label">城市：</label>';
			html += '<div class="col-sm-10">';
			html += '<input type="text" class="form-control" name="city" id="city" placeholder="城市" value="">';
			html += '</div></div>';
			
			html += '<div class="form-group">';
			html += '<label class="col-sm-2 control-label" for="country">国家</label>';
			html += '<div class="col-sm-10">';
			html += '<select class="form-control" id="country" onchange="countryd(this);" name="country_id" class="form-control">';
			html += '<option value="">--无--</option>';
			
			html += '</select></div></div>';
			html += '<div class="form-group">';
			html += '<label class="col-sm-2 control-label" for="zone">省份</label>';
			html += '<div class="col-sm-10">';
			html += '<select name="zone_id" id="zone" class="form-control"><option value="">--无--</option></select></div></div>';
							
			html += '<div class="form-group">';
			html += '<div class="col-sm-offset-2 col-sm-10">';
			html += '<div class="checkbox">';
			html += '<label>';
			html += '<input type="checkbox" name="user_address_id">设为默认';
			
			html += '</label></div></div></div>';
			html += '<div class="form-group">';
			html += '<div class="col-sm-offset-2 col-sm-10">';
			html += '<a class="btn btn-default" onclick="autoSubmitFun();">确定</a>';
			html += '</div></div></form>';
			
			$.ajax({
					url: '<?php echo $this->config->item('catalog').'user/confirm/get_countys';?>',
					type: 'get',
					dataType: 'html',
					success: function(datae)
					{
						$('#country').append(datae);
					}
				});
			
			$('.edit-address-from').html(html);
			$('#edit-shop-address').modal();
			change_shipping_address();
		}
		
		function autoSubmitFun(){
			ajaxSubmit($('#form1'),function(data){
					$('#edit-shop-address').modal('hide');
					if(data.info){
						
						$.ajax({
								url: '<?php echo $this->config->item('catalog').'user/confirm/get_address_list';?>',
								type: 'get',
								dataType: 'html',
								success: function(datae)
								{
									$('.show-address').html(datae);
								
									$('.confirm-active .address-edit').attr("style", "display: block");
		
									$('.confirm-address').click(function(){
											$('.show-address').find('.confirm-active').removeClass('confirm-active').find('.address-edit').attr("style", "display: none");
											$(this).addClass('confirm-active').find('.address-edit').attr("style", "display: block");
										});
								
								}
							});
						
						$.notify({message: data.info },{type: 'success',offset: {x: 0,y: 52}});
					}else{
						$.notify({message: data.error },{type: 'warning',offset: {x: 0,y: 52}});
					}
					
					$('#edit-shop-address form').remove();
				});
			return false;
		}
		
		<?php if($check_out):?>
		
		$(document).ready(function(){
			change_shipping_address();
			$('.confirm-active .address-edit').attr("style", "display: block");
			$('.confirm-address').click(function(){
				$('input[name=\'order[address_id]\']').remove();
				$('.show-address').find('.confirm-active').removeClass('confirm-active').find('.address-edit').attr("style", "display: none");
				$(this).addClass('confirm-active').find('.address-edit').attr("style", "display: block").before('<input type="hidden" value="'+$(this).attr('data-id')+'" name="order[address_id]">');
				change_shipping_address();
			});
		});
		
		function show_all(){
			$('.show-address').attr("style", "margin-left: -15px;height: auto");
			$('.new-address').after('<a class="new-address col-sm-4" style="cursor: pointer;padding-left: 0" onclick="add_address();">使用新地址</a>').remove();
		}
	
		function change_shipping_address(){
			var str_address=$('.confirm-active').html();
			var reg = /<div[\s\S]*?<\/{0,}[a-z](.+?)>/;
				str_address  = str_address .replace(reg,"");
				//str_address =str_address.replace(/<br>/g,"&nbsp;"+"、"+"&nbsp;");
				$('#shipping-address').html(str_address);
				if($('#payment_address').text().length == 0){
					str_address  = str_address + '<input type="hidden" value="'+$('.confirm-active').attr('data-id')+'" name="order[payment_id]">';
					$('#payment_address').html(str_address);
				}
		}
		
		function payment_address (){
			$.ajax({
				url: '<?php echo $this->config->item('catalog').'user/confirm/get_payment_address_list';?>',
				type: 'get',
				dataType: 'html',
				success: function(data)
				{
					$('#edit-shop-address .edit-address-from').html(data);
					$('#edit-shop-address').modal();
					$('.payment-address').mouseup(function(){
						$('#payment_address').text($(this).find('label').text()).after('<input type="hidden" name="order[payment_id]" value="'+$(this).find('input').attr("data-address-id")+'">');
						$('#edit-shop-address').modal('hide');
						$('#edit-shop-address table').remove();
						//return false;
					});
				
				}
			});
		}
		<?php endif;?>
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
		$(".ystep1").setStep(4);
		
		function countryd (element, zone_id=''){
			$.ajax(
				{
					url: "<?php echo $this->config->item('catalog').'localisation/country/get_country?country_id=';?>" + element.value,
					dataType: 'json',
					beforeSend: function()
					{
						NProgress.start();
					},
					complete: function()
					{
						NProgress.done();
					},
					success: function(json)
					{
						if (json['postcode_required'] == '1')
						{
							$('input[name=\'postcode\']').parent().parent().find('label').prepend('<span style="color:red">*&nbsp;</span>');
						} else
						{
							$('input[name=\'postcode\']').parent().parent().find('label').find('span').remove();
						}

						html = '';
						//html = '<option value="0">--无--</option>';

						if (json['zone'] && json['zone'] != '')
						{
							for (i = 0; i < json['zone'].length; i++)
							{
								html += '<option value="' + json['zone'][i]['zone_id'] + '"';

								if (json['zone'][i]['zone_id'] == zone_id)
								{
									html += ' selected="selected"';
								}

								html += '>' + json['zone'][i]['zone_name'] + '</option>';
							}
						} else
						{
							html += '<option value="0">--无--</option>';
						}

						$('select[name=\'zone_id\']').html(html);
					},
					error: function(xhr, ajaxOptions, thrownError)
					{
						alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					}
				});
		}

		$('select[name=\'country_id\']').trigger('change');
	</script>
	<style type="text/css">
		.ystep-container{
			margin-left: calc(50% - 180px);
		}
	</style>
</div>
<!-- /container -->
<?php echo $footer;//装载header?>