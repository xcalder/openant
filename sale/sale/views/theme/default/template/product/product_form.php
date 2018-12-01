<?php echo $header;//装载header?>
<?php echo $top;//装载top?>
<!-- /subnavbar -->
<div class="container">
	<div class="row">
		<form action="<?php echo $action;?>" method="post" enctype="multipart/form-data" id="form-product" class="form-horizontal">
			<div class="col-md-12 middle-flat-left" role="main">
				<div class="panel panel-default">
					<p class="panel-heading row row-panel-heading bg-info" style="margin: 0">
						<i class="glyphicon glyphicon-list-alt">
						</i>
						基本信息
					</p>
					<!-- /widget-header -->
					<div class="panel-body page-tab">
						<div role="tabpanel" class="tab-pane active" id="tab-general">
							<ul class="nav nav-tabs" role="tablist" id="language-list">
								<?php
								foreach($languages as $language):?>
								<li role="presentation">
									<a href="#language<?php echo $language['language_id']?>" role="tab" data-toggle="tab">
										<img  width="16px" height="11px" class="lazy" data-original="resources/public/flags/<?php echo $language['image']?>"><?php echo $language['name']?>
									</a>
								</li>
								<?php endforeach;?>
							</ul>
							<!-- Tab panes -->
							<div class="tab-content" id="language-form">
								<?php
								foreach($languages as $language):?>
								<div role="tabpanel" class="tab-pane" id="language<?php echo $language['language_id']?>">
									<div class="form-group">
										<span class="col-sm-2 control-label" for="description-name-<?php echo $language['language_id']?>">
											<span style="color:red">
												*
											</span>商品标题
										</span>
										<div class="col-sm-10">
											<input type="text" class="form-control" name="description[<?php echo $language['language_id']?>][name]" id="description-name-<?php echo $language['language_id']?>" placeholder="商品标题" value="<?php echo isset($descriptions[$language['language_id']]['name']) ? $descriptions[$language['language_id']]['name'] : '';?>">
											<?php if(!empty($error_name)):?><label class="text-danger"><?php echo isset($error_name[$language['language_id']]) ? $error_name[$language['language_id']] : '';?></label><?php endif;?>
										</div>
									</div>
									<div class="form-group">
										<span class="col-sm-2 control-label" for="description-m-<?php echo $language['language_id']; ?>">
											卖点描述
										</span>
										<div class="col-sm-10">
											<textarea rows="2" name="description[<?php echo $language['language_id']; ?>][meta_description]" id="description-m-<?php echo $language['language_id']; ?>" class="form-control" placeholder="卖点描述"><?php echo isset($descriptions[$language['language_id']]['meta_description']) ? $descriptions[$language['language_id']]['meta_description'] : ''; ?></textarea>
										</div>
									</div>
								</div>
								<?php endforeach;?>
							</div>
						</div><hr>
						<?php if(isset($manufacturers) && $manufacturers !== FALSE):?>
						<div class="form-group">
							<span class="col-sm-2 control-label" for="manufacturer">
								品牌
							</span>
							<div class="col-sm-10">
								<select name="base[manufacturer_id]" class="form-control" id="manufacturer">
									<?php foreach($manufacturers as $manufacturer):?>
									<?php if(isset($bases) && $bases['manufacturer_id'] == $manufacturer['manufacturer_id']):?>
									<option value="<?php echo $manufacturer['manufacturer_id'];?>" selected><?php echo $manufacturer['name'];?></option>
									<?php else:?>
									<option value="<?php echo $manufacturer['manufacturer_id'];?>"><?php echo $manufacturer['name'];?></option>
									<?php endif;?>
									<?php endforeach;?>
									<option value="0" selected>其它</option>
								</select>
							</div>
						</div>
						<?php endif;?>
						<div class="form-group">
							<span class="col-sm-2 control-label" for="address">
								所在地
							</span>
							<div class="col-sm-10">
								<select name="base[address_id]" class="form-control" id="address">
									<?php if($addresss):?>
									<?php foreach($addresss as $address):?>
									<?php if(isset($bases) && $bases['address_id'] == $address['address_id']):?>
									<option value="<?php echo $address['address_id'];?>" selected><?php echo $address['address']?></option>
									<?php else:?>
									<option value="<?php echo $address['address_id'];?>"><?php echo $address['address']?></option>
									<?php endif;?>
									<?php endforeach;?>
									<?php else:?>
									<option value="" selected>请先到个人中心添加地址记录</option>
									<?php endif;?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<span class="col-sm-2 control-label" for="price">
								价格
							</span>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="base[price]" id="price" placeholder="价格" value="<?php echo isset($bases['price']) ? $bases['price'] : '0';?>">
							</div>
						</div>
						<div class="form-group">
							<span class="col-sm-2 control-label" for="tax_class">
								税费
							</span>
							<div class="col-sm-10">
								<select name="base[tax_class_id]" class="form-control" id="tax_class">
									<?php if(isset($tax_classs) && $tax_classs !== FALSE):?>
									<?php foreach($tax_classs as $tax_class):?>
									<?php if(isset($bases) && $bases['tax_class_id'] == $tax_class['tax_class_id']):?>
									<option value="<?php echo $tax_class['tax_class_id'];?>" selected><?php echo $tax_class['title'].'('.$tax_class['description'].')';?></option>
									<?php else:?>
									<option value="<?php echo $tax_class['tax_class_id'];?>"><?php echo $tax_class['title'].'('.$tax_class['description'].')';?></option>
									<?php endif;?>
									<?php endforeach;?>
									<?php else:?>
									<option value="" selected>--无--</option>
									<?php endif;?>
								</select>
							</div>
						</div>
					</div>
					<!-- /widget-content -->
				</div>
				<div class="panel panel-default">
					<p class="panel-heading row row-panel-heading bg-info" style="margin: 0">
						<i class="glyphicon glyphicon-list-alt">
						</i>
						图片
					</p>
					<!-- /widget-header -->
					<div class="panel-body">
						<div class="form-group">
							<span class="col-sm-2 control-label" for="main-map">
								主图
							</span>
							<div class="col-sm-10 row">
								<div class="col-sm-2">
									<a href="" id="thmb-map" data-toggle="sale-image" class="img-thumbnail"><img width="100px" height="100px" class="lazy" data-original="<?php echo (isset($bases) && !empty($bases['image'])) ? $this->image_common->resize($bases['image'], 100, 100) : $placeholder_image;?>" width="100%" alt="主图" title="主图" data-placeholder="<?php echo $placeholder_image;?>" /></a>
									<input type="hidden" name="base[image]" value="<?php echo (isset($bases) && !empty($bases['image'])) ? $bases['image'] : '';?>" id="main-map" />
								</div>
							</div>
						</div><hr>
						<div class="form-group">
							<span class="col-sm-2 control-label">
								附加主图
							</span>
							<div class="col-sm-10 row" id="addtion-images">
								<?php $row_addtion_image = 0;//$row_addtion_image='1';?>
								<?php if(isset($images) && count($images) > 0):?>
								<?php foreach($images as $image):?>
								<div class="col-sm-2 addition-col-<?php echo $row_addtion_image;?>" data-a="image" for="addition-image<?php echo $row_addtion_image;?>">
									<div onclick="$('.addition-col-<?php echo $row_addtion_image;?>').remove();" class="addtion-image-delete addtion-image-delete<?php echo $row_addtion_image;?>">
									<a style="color: red;position: relative;left: 38%;top: 10px;" class="glyphicon glyphicon-remove"></a>
									</div>
									<a href="" id="thmb-image<?php echo $row_addtion_image;?>" data-toggle="sale-image" class="img-thumbnail addtion-image" data-row="addtion-image-delete<?php echo $row_addtion_image;?>"><img width="100px" height="100px" class="lazy" data-original="<?php echo isset($image['image']) ? $this->image_common->resize($image['image'], 100, 100, 'h') : $placeholder_image;?>" alt="附加主图" width="100%" title="附加主图" data-placeholder="<?php echo $placeholder_image;?>" /></a>
										<input type="hidden" name="image[<?php echo $row_addtion_image;?>][image]" value="<?php echo isset($image['image']) ? $image['image'] : '';?>" id="addition-image<?php echo $row_addtion_image;?>" />
								</div>
								<?php $row_addtion_image++;?>
								<?php endforeach;?>
								<?php endif;?>
							</div>
						</div><hr>
						<div class="text-right">
							<button type="button" onclick="add_addition_image();" class="btn btn-info">添加附加主图</button>
						</div>
					</div>
					<!-- /widget-content -->
				</div>
				<?php if(isset($barcodes) && $barcodes !== FALSE):?>
				<div class="panel panel-default">
					<p class="panel-heading row row-panel-heading bg-info" style="margin: 0">
						<i class="glyphicon glyphicon-list-alt">
						</i>
						条码
					</p>
					<!-- /widget-header -->
					<div class="panel-body">
						<?php foreach($barcodes as $key=>$barcode):?>
						<div class="form-group">
							<span class="col-sm-2 control-label" for="barcode<?php echo $key?>">
								<?php echo $barcode['name'];?>
							</span>
							<div class="col-sm-10">
									<input type="text" name="barcode[<?php echo $key?>][value]" class="form-control" value="<?php echo (isset($product_barcodes[$key]['barcode_id']) && $product_barcodes[$key]['barcode_id'] == $barcode['barcode_id']) ? $product_barcodes[$key]['value'] : '';?>" placeholder="<?php echo $barcode['name'];?>" id="barcode<?php echo $key?>">
									<input type="hidden" name="barcode[<?php echo $key?>][barcode_id]" value="<?php echo $barcode['barcode_id'];?>">
							</div>
						</div><hr>
						<?php endforeach;?>
					</div>
					<!-- /widget-content -->
				</div>
				<?php endif;?>
				
				<?php if(isset($option_groups) && count($option_groups) > 0):?>
				<div class="panel panel-default">
					<p class="panel-heading row row-panel-heading bg-info" style="margin: 0">
						<i class="glyphicon glyphicon-list-alt">
						</i>
						商品选项
					</p>
					<!-- /widget-header -->
					<div class="panel-body">
						<p class="bigstats">请选择商品选项，然后设置对应的价格！</p><hr>
						
						<div class="form-group">
							<div class="col-sm-12">
								<table class="table" id="option_add">
									<thead>
										<tr>
											<?php foreach($option_groups as $v):?>
											<td><?php echo $v['option_group_name'];?></td>
											<?php endforeach;?>
											<td>库存</td>
											<td>积分</td>
											<td>价格</td>
											<td>操作</td>
										</tr>
									</thead>
									<tbody>
										<?php $option_row=0;?>
										
										<?php if(isset($product_options) && count($product_options) > 0):?>
										<?php foreach($product_options as $ke=>$opt):?>
										<tr class="addition-option-<?php echo $option_row;?>">
											<?php foreach($option_groups as $k=>$v):?>
											<td style="vertical-align: middle">
												<input type="hidden" name="options[<?php echo $option_row;?>][child][<?php echo $k;?>][option_group_id]" value="<?php echo $option_groups[$k]['option_group_id'];?>">
												<?php if($option_groups[$k]['sale_type'] == 'select'):?>
												<select class="form-control" name="options[<?php echo $option_row;?>][child][<?php echo $k;?>][option_id]">
													<?php foreach($option_groups[$k]['options'] as $key=>$option):?>
													<option value="<?php echo $option_groups[$k]['options'][$key]['option_id'];?>" <?php echo ($option_groups[$k]['options'][$key]['option_id'] == $product_options[$option_row]['child'][$k]['option_id']) ? 'selected' : '';?>><?php echo $option['name'];?></option>
													<?php endforeach;?>
												</select>
												
												<?php elseif($option_groups[$k]['sale_type'] == 'image'):?>
													<div class="col-sm-12 text-center" for="option-img-<?php echo $option_row;?>" style="margin-bottom: 10px">
														<a href="" id="option-<?php echo $option_row;?>" data-toggle="sale-image" class="img-thumbnail"><img width="100px" height="100px" class="lazy" data-original="<?php echo (isset($product_options[$option_row]['child'][$k]['image']) && !empty($product_options[$option_row]['child'][$k]['image'])) ? $this->image_common->resize($product_options[$option_row]['child'][$k]['image'], 100, 100) : $placeholder_image;?>" alt="主图" title="主图" data-placeholder="<?php echo $placeholder_image;?>" /></a>
														<input type="hidden" name="options[<?php echo $option_row;?>][child][<?php echo $k;?>][image]" value="<?php echo (isset($product_options[$option_row]['child'][$k]['image']) && !empty($product_options[$option_row]['child'][$k]['image'])) ? $product_options[$option_row]['child'][$k]['image'] : '';?>" id="option-img-<?php echo $option_row;?>"/>
													</div>
													
													<select class="form-control" name="options[<?php echo $option_row;?>][child][<?php echo $k;?>][option_id]">
													<?php foreach($option_groups[$k]['options'] as $key=>$option):?>
													<option value="<?php echo $option_groups[$k]['options'][$key]['option_id'];?>" <?php echo ($option_groups[$k]['options'][$key]['option_id'] == $product_options[$option_row]['child'][$k]['option_id']) ? 'selected' : '';?>><?php echo $option['name'];?></option>
													<?php endforeach;?>
												</select>
												
												<?php endif;?>
											</td>
											<?php endforeach;?>
											<td style="vertical-align: middle"><input type="text" class="form-control input-group" name="options[<?php echo $option_row;?>][quantity]" placeholder="库存" value="<?php echo $product_options[$ke]['quantity'];?>"></td>
											<td style="vertical-align: middle"><input type="text" class="form-control input-group" name="options[<?php echo $option_row;?>][points]" placeholder="积分" value="<?php echo $product_options[$ke]['points'];?>"></td>
											<td style="vertical-align: middle"><input type="text" class="form-control input-group" name="options[<?php echo $option_row;?>][price]" placeholder="价格" value="<?php echo $product_options[$ke]['price'];?>"></td>
											<td style="vertical-align: middle"><button onclick="$('.addition-option-<?php echo $option_row;?>').remove();" type="button" class="btn btn-danger"><i class="glyphicon glyphicon-minus"></i></button></td>
										</tr>
										<?php $option_row++;?>
										<?php endforeach;?>
										<?php endif;?>
										
									</tbody>
								</table><hr>
								<button type="button" onclick="add_options();" class="btn btn-info" style="float: right">添加商品选项</button>
							</div>
						</div><hr>
						
						<hr>
					</div>
					<!-- /widget-content -->
				</div>
				<?php endif;?>
				
				<?php if($user_classs):?>
				<div class="panel panel-default">
					<p class="panel-heading row row-panel-heading bg-info" style="margin: 0">
						<i class="glyphicon glyphicon-list-alt">
						</i>
						优惠
					</p>
					<!-- /widget-header -->
					<div class="panel-body">
						<p class="bigstats">会员特价（在原价基础上减去）,如果会员组设为无，对所有会员开放，取最优惠价格结帐！</p><hr>
						<div class="form-group" id="language">
							<div class="col-sm-12">
								<table class="table" id="special">
									<thead>
										<tr>
											<td>会员组</td>
											<td>库存</td>
											<td>减价</td>
											<td>开始时间</td>
											<td>结束时间</td>
											<td>操作</td>
										</tr>
									</thead>
									<tbody>
										<?php $row_special=0;?>
										<?php if(isset($product_specials) && count($product_specials) > 0):?>
										
										<?php foreach($product_specials as $key=>$value):?>
										<tr class="special-<?php echo $row_special;?>">
											<td style="vertical-align: middle">
												<select class="form-control" name="special[<?php echo $row_special;?>][user_class_id]">
													
													<?php if(!isset($product_specials[$key]['user_class_id']) || empty($product_specials[$key]['user_class_id'])):?>
													<option value="0" selected>--无--</option>
													<?php endif;?>
													
													<?php foreach($user_classs as $k=>$v):?>
													<?php if(isset($product_specials[$key]['user_class_id']) && $product_specials[$key]['user_class_id'] == $user_classs[$k]['user_class_id']):?>
													<option value="<?php echo $v['user_class_id'];?>" selected><?php echo $v['name'];?></option>
													<?php else:?>
													<option value="<?php echo $v['user_class_id'];?>"><?php echo $v['name'];?></option>
													<?php endif;?>
													<?php endforeach;?>
												</select>
											</td>
											<td style="vertical-align: middle"><input type="text" class="form-control" name="special[<?php echo $row_special;?>][quantity]" placeholder="库存" value="<?php echo isset($product_specials[$key]['quantity']) ? $product_specials[$key]['quantity'] : 0;?>"></td>
											<td style="vertical-align: middle"><input type="text" class="form-control" name="special[<?php echo $row_special;?>][price]" placeholder="价格" value="<?php echo isset($product_specials[$key]['price']) ? $product_specials[$key]['price'] : 0;?>"></td>
											<td style="vertical-align: middle">
										      <input type="text" class="form-control" name="special[<?php echo $row_special;?>][date_start]" placeholder="开始时间" value="<?php echo isset($product_specials[$key]['date_start']) ? $product_specials[$key]['date_start'] : date("Y-m-d H:i:s");?>" readonly id="special-date_start-<?php echo $row_special;?>" onclick="date_time_picker('special-date_start-<?php echo $row_special?>');">
										    </td>
										    
											<td style="vertical-align: middle">
										      <input type="text" class="form-control" name="special[<?php echo $row_special;?>][date_end]" placeholder="结束时间" value="<?php echo isset($product_specials[$key]['date_end']) ? $product_specials[$key]['date_end'] : date("Y-m-d H:i:s",strtotime("+1 week"));?>" readonly id="special-date_end-<?php echo $row_special;?>" onclick="date_time_picker('special-date_end-<?php echo $row_special?>');">
											</td>
											
											<td style="vertical-align: middle"><button onclick="$('.special-<?php echo $row_special;?>').remove();" type="button" class="btn btn-danger btn-sm"><i class="glyphicon glyphicon-minus"></i></button></td>
										</tr>
										<?php $row_special++;?>
										<?php endforeach;?>
										<?php endif;?>
									</tbody>
									<tfoot>
										<tr>
											<td colspan="6"><button type="button" onclick="add_special();" class="btn btn-info" style="float: right">添加会员特价</button></td>
										</tr>
									</tfoot>
								</table>
							</div>
						</div>
						
						
						<p class="bigstats">会员折扣,如果会员组设为无，对所有会员开放，取最优惠折扣结帐！</p><hr>
						<div class="form-group" id="language">
							<div class="col-sm-12">
								<table class="table" id="discount">
									<thead>
										<tr>
											<td>会员组</td>
											<td>库存</td>
											<td>折扣</td>
											<td>开始时间</td>
											<td>结束时间</td>
											<td>操作</td>
										</tr>
									</thead>
									<tbody>
										
										<?php $row_discount=0;?>
										
										<?php if(isset($product_discounts) && count($product_discounts) > 0):?>
										
										<?php foreach($product_discounts as $key=>$value):?>
										<tr class="discount-<?php echo $row_discount;?>">
											<td style="vertical-align: middle">
												<select class="form-control" name="discount[<?php echo $row_discount;?>][user_class_id]">
												
													<?php if(!isset($product_discounts[$key]['user_class_id']) || empty($product_discounts[$key]['user_class_id'])):?>
													<option value="0" selected>--无--</option>
													<?php endif;?>
													
													<?php foreach($user_classs as $k=>$v):?>
													<?php if(isset($product_discounts[$key]['user_class_id']) && $product_discounts[$key]['user_class_id'] == $user_classs[$k]['user_class_id']):?>
													<option value="<?php echo $v['user_class_id'];?>" selected><?php echo $v['name'];?></option>
													<?php else:?>
													<option value="<?php echo $v['user_class_id'];?>"><?php echo $v['name'];?></option>
													<?php endif;?>
													<?php endforeach;?>
												</select>
											</td>
											<td style="vertical-align: middle"><input type="text" class="form-control" name="discount[<?php echo $row_discount;?>][quantity]" placeholder="库存" value="<?php echo isset($product_discounts[$key]['quantity']) ? $product_discounts[$key]['quantity'] : 0;?>"></td>
											<td style="vertical-align: middle"><input type="text" class="form-control" name="discount[<?php echo $row_discount;?>][value]" placeholder="折扣" value="<?php echo isset($product_discounts[$key]['value']) ? $product_discounts[$key]['value'] : 0;?>"></td>
											<td style="vertical-align: middle">
												<input type="text" class="form-control" name="discount[<?php echo $row_discount;?>][date_start]" placeholder="开始时间" value="<?php echo isset($product_discounts[$key]['date_start']) ? $product_discounts[$key]['date_start'] : date("Y-m-d H:i:s");?>" readonly id="discount-date_start-<?php echo $row_discount;?>" onclick="date_time_picker('discount-date_start-<?php echo $row_discount?>');">
											</td>
											<td style="vertical-align: middle">
												<input type="text" class="form-control" name="discount[<?php echo $row_discount;?>][date_end]" placeholder="结束时间" value="<?php echo isset($product_discounts[$key]['date_end']) ? $product_discounts[$key]['date_end'] : date("Y-m-d H:i:s",strtotime("+1 week"));?>" readonly id="discount-date_end-<?php echo $row_discount;?>" onclick="date_time_picker('discount-date_end-<?php echo $row_discount?>');">
											</td>
											<td style="vertical-align: middle"><button onclick="$('.discount-<?php echo $row_discount;?>').remove();" type="button" class="btn btn-danger btn-sm"><i class="glyphicon glyphicon-minus"></i></button></td>
										</tr>
										<?php $row_discount++;?>
										<?php endforeach;?>
										<?php endif;?>
									</tbody>
									<tfoot>
										<tr>
											<td colspan="6"><button type="button" onclick="add_discount();" class="btn btn-info" style="float: right">添加会员折扣</button></td>
										</tr>
									</tfoot>
								</table>
							</div>
						</div>
						<!-- /widget-content -->
					</div>
				</div>
				<?php endif;?>
				<?php if(isset($attribute_groups) && count($attribute_groups) > 0):?>
				<div class="panel panel-default">
					<p class="panel-heading row row-panel-heading bg-info" style="margin: 0">
						<i class="glyphicon glyphicon-list-alt">
						</i>
						商品属性
					</p>
					<!-- /widget-header -->
					<div class="panel-body page-tab">
						<div role="tabpanel" class="tab-pane active" id="tab-general">
							<ul class="nav nav-tabs" role="tablist" id="language-attribute">
								<?php
								foreach($languages as $language):?>
								<li role="presentation">
									<a href="#language-attribute<?php echo $language['language_id']?>" role="tab" data-toggle="tab">
									<img  width="16px" height="11px" class="lazy" data-original="resources/public/flags/<?php echo $language['image']?>"><?php echo $language['name']?>
									</a>
								</li>
								<?php endforeach;?>
							</ul>
							<!-- Tab panes -->
							<div class="tab-content" id="language-attribute-form">
								<?php
								foreach($languages as $language):?>
								<div role="tabpanel" class="tab-pane" id="language-attribute<?php echo $language['language_id']?>">
									<?php if(isset($attribute_groups) && count($attribute_groups) > 0):?>
									<?php foreach($attribute_groups as $key=>$value):?>
									<?php if(!empty($attribute_groups[$key]['attributes'])):?>
									<div class="form-group">
										<span class="col-sm-2 control-label">
											<?php echo $value['group_name'];?>
										</span>
										<div class="col-sm-10" id="attribute-images">
											<?php if($attribute_groups[$key]['sale_type'] == 'image'):?>
											<?php foreach($attribute_groups[$key]['attributes'] as $k=>$v):?>
											<input type="hidden" name="attribute[<?php echo $language['language_id']?>][<?php echo $key;?>][<?php echo $k;?>][attribute_id]" value="<?php echo $attribute_groups[$key]['attributes'][$k]['attribute_id'];?>"/>
											<div class="col-sm-2" for="attribute-img-<?php echo $k.'-'.$language['language_id'];?>">
												<a href="" id="thumb-img-<?php echo $k.'-'.$language['language_id'];?>" data-toggle="sale-image" class="img-thumbnail"><img width="100px" height="100px" class="lazy" data-original="<?php echo (isset($attribute_groups[$key]['attributes'][$k]['value'][$language['language_id']]) && !empty($attribute_groups[$key]['attributes'][$k]['value'][$language['language_id']])) ? $this->image_common->resize($attribute_groups[$key]['attributes'][$k]['value'][$language['language_id']], 100, 100) : $placeholder_image;?>" width="100%" alt="主图" title="主图" data-placeholder="<?php echo $placeholder_image;?>" /></a>
												<input type="hidden" name="attribute[<?php echo $language['language_id']?>][<?php echo $key;?>][<?php echo $k;?>][image]" value="<?php echo (isset($attribute_groups[$key]['attributes'][$k]['value'][$language['language_id']]) && !empty($attribute_groups[$key]['attributes'][$k]['value'][$language['language_id']])) ? $attribute_groups[$key]['attributes'][$k]['value'][$language['language_id']] : '';?>" id="attribute-img-<?php echo $k.'-'.$language['language_id'];?>"/>
											</div>
											<?php endforeach;?>
											<?php elseif($attribute_groups[$key]['sale_type'] == 'text'):?>
											<?php foreach($attribute_groups[$key]['attributes'] as $k=>$v):?>
											<input type="hidden" name="attribute[<?php echo $language['language_id']?>][<?php echo $key;?>][<?php echo $k;?>][attribute_id]" value="<?php echo $attribute_groups[$key]['attributes'][$k]['attribute_id'];?>"/>
											<div class="col-sm-2">
											<input type="text" class="form-control" name="attribute[<?php echo $language['language_id']?>][<?php echo $key;?>][<?php echo $k;?>][text]" value="<?php echo (isset($attribute_groups[$key]['attributes'][$k]['value'][$language['language_id']]) && !empty($attribute_groups[$key]['attributes'][$k]['value'][$language['language_id']])) ? $attribute_groups[$key]['attributes'][$k]['value'][$language['language_id']] : '';?>"/>
											</div>
											<?php endforeach;?>
											
											<?php elseif($attribute_groups[$key]['sale_type'] == 'select'):?>
											<div class="col-sm-12">
											<select name="attribute[<?php echo $language['language_id']?>][<?php echo $key;?>][<?php echo $k;?>][text]" class="form-control">
											<?php foreach($attribute_groups[$key]['attributes'] as $k=>$v):?>
												<?php if(isset($attribute_groups[$key]['attributes'][$k]['value'][$language['language_id']]) && !empty($attribute_groups[$key]['attributes'][$k]['value'][$language['language_id']]) && $attribute_groups[$key]['attributes'][$k]['value'][$language['language_id']]== $attribute_groups[$key]['attributes'][$k]['name']):?>
												<option value="<?php echo $attribute_groups[$key]['attributes'][$k]['attribute_id'].'-.-.--.-.--.-??.--.-.--.-.-'.$attribute_groups[$key]['attributes'][$k]['name'];?>"selected/><?php echo $attribute_groups[$key]['attributes'][$k]['name'];?></option>
												<?php else:?>
												<option value="<?php echo $attribute_groups[$key]['attributes'][$k]['attribute_id'].'-.-.--.-.--.-??.--.-.--.-.-'.$attribute_groups[$key]['attributes'][$k]['name'];?>"/><?php echo $attribute_groups[$key]['attributes'][$k]['name'];?></option>
												<?php endif;?>
											<?php endforeach;?>
											</select>
											</div>
											
											<?php endif;?>
										</div>
									</div><hr>
									<?php endif;?>
									<?php endforeach;?>
									<?php endif;?>
									
								</div>
								<?php endforeach;?>
							</div>
						</div><hr>
					</div>
					<!-- /widget-content -->
				</div>
				<?php endif;?>
				<div class="panel panel-default">
					<p class="panel-heading row row-panel-heading bg-info" style="margin: 0">
						<i class="glyphicon glyphicon-list-alt">
						</i>
						商品描述
					</p>
					<!-- /widget-header -->
					<div class="panel-body page-tab">
						<div role="tabpanel" class="tab-pane active" id="tab-general">
							<ul class="nav nav-tabs" role="tablist" id="language-description">
								<?php foreach($languages as $language):?>
								<li role="presentation">
									<a href="#description-<?php echo $language['language_id']?>" role="tab" data-toggle="tab">
										<img  width="16px" height="11px" class="lazy" data-original="resources/public/flags/<?php echo $language['image']?>"><?php echo $language['name']?>
									</a>
								</li>
								<?php endforeach;?>
							</ul>
							<!-- Tab panes -->
							<div class="tab-content" id="language-description-form">
								<?php foreach($languages as $language):?>
								<div role="tabpanel" class="tab-pane" id="description-<?php echo $language['language_id']?>">
									<div class="form-group">
										<div class="col-sm-12">
											<textarea name="description[<?php echo $language['language_id']?>][description]" id="input-description-<?php echo $language['language_id']?>"><?php echo isset($descriptions[$language['language_id']]['description']) ? $descriptions[$language['language_id']]['description'] : '';?></textarea>
										</div>
									</div>
								</div>
								<?php endforeach;?>
							</div>
						</div>
					</div>
					<!-- /widget-content -->
				</div>
				<?php if(isset($downloads) && count($downloads) > 0):?>
				<div class="panel panel-default">
					<p class="panel-heading row row-panel-heading bg-info" style="margin: 0">
						<i class="glyphicon glyphicon-list-alt">
						</i>
						下载商品
					</p>
					<!-- /widget-header -->
					<div class="panel-body">
						<table class="table">
							<thead>
								<tr>
									<td>下载分类</td>
									<td>下载名</td>
									<td>描述</td>
									<td>上传时间</td>
									<td>操作</td>
								</tr>
							</thead>
							<tbody>
								<?php foreach($downloads as $k=>$v):?>
								<tr>
									<input type="hidden" name="download[<?php echo $k;?>][download_id]" value="<?php echo $v['download_id'];?>"/>
									<td><?php echo $v['name']?></td>
									<td><input type="text" class="form-control" name="download[<?php echo $k;?>][mask]" placeholder="下载名" value="<?php echo isset($downloads[$k]['mask']) ? $downloads[$k]['mask'] : '';?>"></td>
									<td><input type="text" class="form-control" name="download[<?php echo $k;?>][description]" placeholder="描述" value="<?php echo isset($downloads[$k]['description']) ? $downloads[$k]['description'] : '';?>"></td>
									<td><input type="text" class="form-control" name="download[<?php echo $k;?>][date_added]" placeholder="上传时间" readonly="readonly" value="<?php echo isset($downloads[$k]['date_added']) ? $downloads[$k]['date_added'] : '';?>"></td>
									<td>
										<?php if(isset($downloads[$k]['filename'])):?>
										<button type="button" class="btn btn-warning" id="button-upload<?php echo $k;?>" onclick="upload('<?php echo $k;?>');">覆盖文件</button>
										<input type="hidden" name="download[<?php echo $k;?>][filename]" id="button-upload<?php echo $k;?>" value="<?php echo isset($downloads[$k]['filename']) ? $downloads[$k]['filename'] : '';?>"/>
										<?php else:?>
										<button type="button" class="btn btn-info" id="button-upload<?php echo $k;?>" onclick="upload('<?php echo $k;?>');">上传文件</button>
										<input type="hidden" name="download[<?php echo $k;?>][filename]" id="button-upload<?php echo $k;?>" value=""/>
										<?php endif;?>
									</td>
								</tr>
								<?php endforeach;?>
							</tbody>
						</table>
					</div>
					<!-- /widget-content -->
				</div>
				<?php endif;?>
				<div class="panel panel-default">
					<p class="panel-heading row row-panel-heading bg-info" style="margin: 0">
						<i class="glyphicon glyphicon-list-alt">
						</i>
						商品物流
					</p>
					<!-- /widget-header -->
					<div class="panel-body">
						<div class="form-group">
							<span class="col-sm-2 control-label" for="length_class">
								长度单位
							</span>
							<div class="col-sm-10">
								<select name="base[length_class_id]" class="form-control" id="length_class">
									<?php if(isset($length_classs) && $length_classs !== FALSE):?>
									<?php foreach($length_classs as $length_class):?>
									<?php if(isset($bases) && $length_class['length_class_id'] == $bases['length_class_id']):?>
									<option value="<?php echo $length_class['length_class_id'];?>" selected><?php echo $length_class['title'];?></option>
									<?php else:?>
									<option value="<?php echo $length_class['length_class_id'];?>"><?php echo $length_class['title'];?></option>
									<?php endif;?>
									<?php endforeach;?>
									<?php endif;?>
								</select>
							</div>
						</div><hr>
						<div class="form-group">
							<span class="col-sm-2 control-label">
								体积
							</span>
							<div class="col-sm-10 row">
								<div class="col-sm-4">
									<input type="text" class="form-control" name="base[length]" placeholder="长" value="<?php echo isset($bases) ? $bases['length'] : '';?>">
								</div>
								<div class="col-sm-4">
									<input type="text" class="form-control" name="base[width]" placeholder="宽度" value="<?php echo isset($bases) ? $bases['width'] : '';?>">
								</div>
								<div class="col-sm-4">
									<input type="text" class="form-control" name="base[height]" placeholder="高度" value="<?php echo isset($bases) ? $bases['height'] : '';?>">
								</div>
							</div>
						</div><hr>
						<div class="form-group">
							<span class="col-sm-2 control-label" for="weight_class">
								重量单位
							</span>
							<div class="col-sm-10">
								<select name="base[weight_class_id]" class="form-control" id="weight_class">
									<?php if(isset($weight_classs) && $weight_classs !== FALSE):?>
									<?php foreach($weight_classs as $weight_class):?>
									<?php if(isset($bases) && $weight_class['weight_class_id'] == $bases['weight_class_id']):?>
									<option value="<?php echo $weight_class['weight_class_id'];?>" selected><?php echo $weight_class['title'];?></option>
									<?php else:?>
									<option value="<?php echo $weight_class['weight_class_id'];?>"><?php echo $weight_class['title'];?></option>
									<?php endif;?>
									<?php endforeach;?>
									<?php endif;?>
								</select>
							</div>
						</div><hr>
						<div class="form-group">
							<span class="col-sm-2 control-label" for="weight">
								重量
							</span>
							<div class="col-sm-10">
									<input type="text" class="form-control" name="base[weight]" id="weight" placeholder="重量" value="<?php echo isset($bases) ? $bases['weight'] : '';?>">
							</div>
						</div><hr>
						<?php if(isset($stock_statuss) && $stock_statuss !== FALSE):?>
						<div class="form-group">
							<span class="col-sm-2 control-label" for="stock_status">
								发货时间
							</span>
							<div class="col-sm-10">
								<?php foreach($stock_statuss as $v):?>
								<label class="checkbox-inline" style="padding-left: 0">
									<?php if(isset($bases) && $v['stock_status_id'] == $bases['stock_status_id']):?>
								  	<input type="radio" name="base[stock_status_id]" checked value="<?php echo $v['stock_status_id'];?>"><?php echo $v['name'];?>
								  	<?php else:?>
								  	<input type="radio" name="base[stock_status_id]" value="<?php echo $v['stock_status_id'];?>"><?php echo $v['name'];?>
								  	<?php endif;?>
								</label>
								<?php endforeach;?>
							</div>
						</div><hr>
						<?php endif;?>
						<div class="form-group">
							<span class="col-sm-2 control-label" for="freight_template">
								邮费模板
							</span>
							<div class="col-sm-10">
								<select name="base[freight_template_id]" class="form-control" id="freight_template">
									<?php if(isset($freight_templates) && $freight_templates !== FALSE):?>
									<?php foreach($freight_templates as $freight_template):?>
									<?php if(isset($bases) && $freight_template['freight_template_id'] == $bases['freight_template_id']):?>
									<option value="<?php echo $freight_template['freight_template_id'];?>" selected><?php echo $freight_template['freight_template_name'];?></option>
									<?php else:?>
									<option value="<?php echo $freight_template['freight_template_id'];?>"><?php echo $freight_template['freight_template_name'];?></option>
									<?php endif;?>
									<?php endforeach;?>
									<?php endif;?>
									<option value="0">包邮</option>
								</select>
							</div>
						</div>
					</div>
					<!-- /widget-content -->
				</div>
				
				<?php if(isset($aftermarkets) && count($aftermarkets) > 0):?>
				<div class="panel panel-default">
					<p class="panel-heading row row-panel-heading bg-info" style="margin: 0">
						<i class="glyphicon glyphicon-list-alt">
						</i>
						售后
					</p>
					<!-- /widget-header -->
					<div class="panel-body">
						<div class="form-group">
							<span class="col-sm-2 control-label" for="aftermarket">
								售后保障
							</span>
							<div class="col-sm-10">
								<?php foreach($aftermarkets as $k=>$v):?>
								<label class="checkbox-inline">
									<?php if(isset($product_aftermarkets) && in_array($v['aftermarket_id'], $product_aftermarkets)):?>
								  	<input type="checkbox" name="aftermarket[<?php echo $k?>][aftermarket_id]" id="aftermarket" value="<?php echo $v['aftermarket_id'];?>" checked><?php echo $v['name'];?>
								  	<?php else:?>
								  	<input type="checkbox" name="aftermarket[<?php echo $k?>][aftermarket_id]" id="aftermarket" value="<?php echo $v['aftermarket_id'];?>"><?php echo $v['name'];?>
								  	<?php endif;?>
								</label>
								<?php endforeach;?>
							</div>
						</div>
					</div>
					<!-- /widget-content -->
				</div>
				<?php endif;?>
				
				<div class="panel panel-default">
					<p class="panel-heading row row-panel-heading bg-info" style="margin: 0">
						<i class="glyphicon glyphicon-list-alt">
						</i>
						其它
					</p>
					<!-- /widget-header -->
					<div class="panel-body">
						<div class="form-group">
							<span class="col-sm-2 control-label" for="subtract">
								减库存
							</span>
							<div class="col-sm-10">
								<select class="form-control" name="base[subtract]" id="subtract">
									<?php if(isset($bases) && $bases['subtract'] == '1'):?>
									<option value="1" selected>下单减库存</option>
									<option value="0">付款减库存</option>
									<?php else:?>
									<option value="1">下单减库存</option>
									<option value="0" selected>付款减库存</option>
									<?php endif;?>
								</select>
							</div>
						</div><hr>
						<div class="form-group">
							<span class="col-sm-2 control-label" for="commission_rate">
								佣金比例
							</span>
							<div class="col-sm-10">
									<input type="text" class="form-control" name="base[commission_rate]" id="commission_rate" placeholder="佣金比例" value="<?php echo isset($bases) ? $bases['commission_rate'] : '';?>">
							</div>
						</div><hr>
						<div class="form-group">
							<span class="col-sm-2 control-label" for="quantity">
								库存
							</span>
							<div class="col-sm-10">
									<input type="text" class="form-control" name="base[quantity]" id="quantity" placeholder="库存" value="<?php echo isset($bases) ? $bases['quantity'] : '';?>">
							</div>
						</div><hr>
						<div class="form-group">
							<span class="col-sm-2 control-label" for="points">
								赠送积
							</span>
							<div class="col-sm-10">
									<input type="text" class="form-control" name="base[points]" id="points" placeholder="积分" value="<?php echo isset($bases) ? $bases['points'] : '';?>">
							</div>
						</div><hr>
						<div class="form-group">
							<span class="col-sm-2 control-label" for="user_points">
								使用积分
							</span>
							<div class="col-sm-10">
									<input type="text" class="form-control" name="base[user_points]" id="user_points" placeholder="使用积分限制" value="<?php echo isset($bases) ? $bases['user_points'] : '';?>">
							</div>
						</div><hr>
						<div class="form-group">
							<span class="col-sm-2 control-label" for="maximum">
								限购
							</span>
							<div class="col-sm-10">
									<input type="text" class="form-control" name="base[maximum]" id="maximum" placeholder="最大购买数量" value="<?php echo isset($bases) ? $bases['maximum'] : '';?>">
							</div>
						</div><hr>
						<div class="form-group">
							<span class="col-sm-2 control-label" for="added">
								上架
							</span>
							<div class="col-sm-10">
								<label class="radio-inline">
								  	<input type="radio" name="base[added]" id="added" value="now" checked>立即上架
								</label>
								<label class="radio-inline">
								  	<input type="radio" name="base[added]" id="added" value="">上架时间
								</label>
								<label class="radio-inline">
								  	<input type="radio" name="base[added]" id="added" value="none">放入仓库
								</label>
							</div>
						</div>
					</div>
					<!-- /widget-content -->
				</div>
				<div class="well well-sm text-center" id="buttom-add-product">
					<input type="hidden" name="category[category_id]" value="<?php echo $category_id;?>">
					<input type="hidden" name="category[child_id]" value="<?php echo isset($child_id) ? $child_id : '0';?>">
					<input type="hidden" name="category[parent_id]" value="<?php echo isset($parent_id) ? $parent_id : '0';?>">
					<input type="hidden" name="category[store_id]" value="<?php echo $this->user->getStore_id();?>">
					<button type="submit" class="btn btn-info">发布</button>
				</div>
			</div>
		</form>
		<!-- /span12 -->
	</div>
	<!-- /row -->
<script>

	$(document).ready(function () {
		$('#language-description li:first').addClass('active');
		$('#language-description-form .tab-pane:first').addClass('active');
		
		$('#language-attribute li:first').addClass('active');
		$('#language-attribute-form .tab-pane:first').addClass('active');
		
		$(document).scroll(function(){
		    scr_h = $(document).height()-$(document).scrollTop()-$(window).height();
		    foo_h = $("#footer").outerHeight(true);
		    if(scr_h <= foo_h){
				$('#buttom-add-product').removeAttr("style");
			}else{
				$('#buttom-add-product').attr("style","position:fixed;bottom:0;left:0;width:100%;margin-bottom:0");
			}
		})
	});
	
	<?php foreach ($languages as $language):?>
	$(document).ready(function () {
			$('#input-description-<?php echo $language['language_id']; ?>').summernote({
					height: 200,                 // set editor height
				});
		});
	<?php endforeach; ?>
	
	var row_addtion_image=<?php echo $row_addtion_image;?>;
	function add_addition_image(){
		if($("#addtion-images div[data-a='image']").length > 5){
			alert('最多只能添加6张主图！');
			return false;
		}
		
		html  = '<div class="col-sm-2 addition-col-'+row_addtion_image+'" data-a="image" for="addition-image'+row_addtion_image+'">';
		html += '<div onclick="$(\'.addition-col-'+row_addtion_image+'\').remove();" class="addtion-image-delete addtion-image-delete'+row_addtion_image+'"><a style="color: red;position: relative;left: 38%;top: 10px;" class="glyphicon glyphicon-remove"></a></div>';
		html += '<a href="" id="thmb-image'+row_addtion_image+'" data-toggle="sale-image" class="img-thumbnail addtion-image" data-row="addtion-image-delete'+row_addtion_image+'"><img src="<?php echo $placeholder_image;?>" alt="附加主图" width="100%" title="附加主图" data-placeholder="<?php echo $placeholder_image;?>" /></a>';
		html += '<input type="hidden" name="image['+row_addtion_image+'][image]" value="" id="addition-image'+row_addtion_image+'" /></div>';
		
		$('#addtion-images').append(html);

		row_addtion_image++;
	}
	
	<?php if(isset($option_row)):?>
	var row_option=<?php echo $option_row;?>;
	function add_options(){
		
		html  = '<tr class="addition-option-'+row_option+'">';
				<?php foreach($option_groups as $k=>$v):?>
		html += '<td style="vertical-align: middle">';
		html += '<input type="hidden" name="options['+row_option+'][child][<?php echo $k;?>][option_group_id]" value="<?php echo $option_groups[$k]['option_group_id'];?>">';
				<?php if($option_groups[$k]['sale_type'] == 'select'):?>
		html += '<select class="form-control" name="options['+row_option+'][child][<?php echo $k;?>][option_id]">';
				<?php foreach($option_groups[$k]['options'] as $key=>$option):?>
		html += '<option value="<?php echo $option_groups[$k]['options'][$key]['option_id'];?>"><?php echo $option['name'];?></option>';
				<?php endforeach;?>
		html += '</select>';
								
				<?php elseif($option_groups[$k]['sale_type'] == 'image'):?>
		html += '<div class="col-sm-12 text-center" for="option-img-'+row_option+'" style="margin-bottom: 10px">';
		html += '<a href="" id="option-'+row_option+'" data-toggle="sale-image" class="img-thumbnail"><img width="100px" height="100px" class="lazy" data-original="<?php echo $placeholder_image;?>" alt="主图" title="主图" data-placeholder="<?php echo $placeholder_image;?>" /></a>';
		html += '<input type="hidden" name="options['+row_option+'][child][<?php echo $k;?>][image]" value="" id="option-img-'+row_option+'"/>';
		html += '</div>';
													
		html += '<select class="form-control" name="options['+row_option+'][child][<?php echo $k;?>][option_id]">';
				<?php foreach($option_groups[$k]['options'] as $key=>$option):?>
		html += '<option value="<?php echo $option_groups[$k]['options'][$key]['option_id'];?>"><?php echo $option['name'];?></option>';
				<?php endforeach;?>
		html += '</select>';
												
				<?php endif;?>
		html += '</td>';
				<?php endforeach;?>
		html += '<td style="vertical-align: middle"><input type="text" class="form-control input-group" name="options['+row_option+'][quantity]" placeholder="库存" value=""></td>';
		html += '<td style="vertical-align: middle"><input type="text" class="form-control input-group" name="options['+row_option+'][points]" placeholder="积分" value=""></td>';
		html += '<td style="vertical-align: middle"><input type="text" class="form-control input-group" name="options['+row_option+'][price]" placeholder="价格" value=""></td>';
		html += '<td style="vertical-align: middle"><button onclick="$(\'.addition-option-'+row_option+'\').remove();" type="button" class="btn btn-danger btn-sm"><i class="glyphicon glyphicon-minus"></i></button></td>';
		html += '</tr>';
		
		$('#option_add tbody').append(html);

		row_option++;
	}
	<?php endif;?>
	
	<?php if(isset($row_discount)):?>
	var row_discount=<?php echo $row_discount;?>;
	function add_discount(){
		html  = '<tr class="discount-'+row_discount+'"><td style="vertical-align: middle"><select class="form-control" name="discount['+row_discount+'][user_class_id]">';
				<?php if(isset($user_classs) && count($user_classs) > 0):?>
				<?php foreach($user_classs as $k=>$v):?>
		html += '<option value="<?php echo $v['user_class_id'];?>"><?php echo $v['name'];?></option>';
				<?php endforeach;?>
				<?php endif;?>
		html += '<option value="0">--无--</option>';
		html += '</select></td><td style="vertical-align: middle"><input type="text" class="form-control input-group" name="discount['+row_discount+'][quantity]" placeholder="库存" value="0"></td><td><input type="text" class="form-control input-group" name="discount['+row_discount+'][value]" placeholder="折扣" value=""></td>';
		html += '<td style="vertical-align: middle">';
		html += '<input type="text" class="form-control" name="discount['+row_discount+'][date_start]" placeholder="开始时间" value="<?php echo date("Y-m-d H:i:s");?>" readonly id="discount-date_start-'+row_discount+'" onclick="date_time_picker(\'discount-date_start-'+row_discount+'\');">';
		html += '</td>';
		html += '<td style="vertical-align: middle">';
		html += '<input type="text" class="form-control" name="discount['+row_discount+'][date_end]" placeholder="结束时间" value="<?php echo date("Y-m-d H:i:s",strtotime("+1 week"));?>" readonly id="discount-date_end-'+row_discount+'" onclick="date_time_picker(\'discount-date_end-'+row_discount+'\');">';
		html += '</td>';
		html += '<td style="vertical-align: middle"><button onclick="$(\'.discount-'+row_discount+'\').remove();" type="button" class="btn btn-danger btn-sm"><i class="glyphicon glyphicon-minus"></i></button></td></tr>';
		
		$('#discount tbody').append(html);

		row_discount++;
	}
	<?php endif;?>
	
	
	<?php if(isset($row_special)):?>
	var row_special=<?php echo $row_special;?>;
	function add_special(){
		html  = '<tr class="special-'+row_special+'"><td style="vertical-align: middle"><select class="form-control" name="special['+row_special+'][user_class_id]">';
				<?php if(isset($user_classs) && count($user_classs) > 0):?>
				<?php foreach($user_classs as $k=>$v):?>
		html += '<option value="<?php echo $v['user_class_id'];?>"><?php echo $v['name'];?></option>';
				<?php endforeach;?>
				<?php endif;?>
		html += '<option value="0">--无--</option>';
		html += '</select></td><td style="vertical-align: middle"><input type="text" class="form-control input-group" name="special['+row_special+'][quantity]" placeholder="库存" value="0"></td><td><input type="text" class="form-control input-group" name="special['+row_special+'][price]" placeholder="折扣" value="0"></td>';
		
		html += '<td style="vertical-align: middle">';
		html += '<input type="text" class="form-control" name="special['+row_special+'][date_start]" placeholder="开始时间" value="<?php echo date("Y-m-d H:i:s");?>" readonly id="special-date_start-\'+row_special+\'" onclick="date_time_picker(\'special-date_start-'+row_special+'\');">';
		html += '</td>';
										    
		html += '<td style="vertical-align: middle">';
		html += '<input type="text" class="form-control" name="special['+row_special+'][date_end]" placeholder="结束时间" value="<?php echo date("Y-m-d H:i:s",strtotime("+1 week"));?>" readonly id="special-date_end-'+row_special+'" onclick="date_time_picker(\'special-date_end-'+row_special+'\');">';
		html += '</td>';
											
		html += '<td style="vertical-align: middle"><button onclick="$(\'.special-'+row_special+'\').remove();" type="button" class="btn btn-danger btn-sm"><i class="glyphicon glyphicon-minus"></i></button></td></tr>';
		
		$('#special tbody').append(html);

		row_special++;
	}
	<?php endif;?>
	
	//文件上传
	function upload(row) {

	$('#form-upload').remove();

	$('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file"/></form>');

	$('#form-upload input[name=\'file\']').trigger('click');

	if (typeof timer != 'undefined') {
    	clearInterval(timer);
	}

	timer = setInterval(function() {
		if ($('#form-upload input[name=\'file\']').val() != '') {
			//var file_name=$('#form-upload input[name=\'file'+row+'\']').val();
			clearInterval(timer);

			$.ajax({
				url: '<?php echo $this->config->item('sale').'common/upload'?>',
				type: 'post',
				dataType: 'json',
				data: new FormData($('#form-upload')[0]),
				cache: false,
				contentType: false,
				processData: false,
				beforeSend: function() {
					NProgress.start();
				},
				complete: function() {
					NProgress.done();
				},
				success: function(json) {
					if (json['error']) {
						$.notify({message: json['error'] },{type: 'warning',offset: {x: 0,y: 52}});
					}

					if (json['success']) {
						$.notify({message: json['success']['client_name'],},{type: 'success',offset: {x: 0,y: 52}});
						$('input[id=button-upload'+row+']').val(json['success']['move_path']).after('<input type="hidden" name="download['+row+'][cache_file]" value="'+json['success']['cache_path']+'">');
						//alert(json['success']+row);
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		}
	}, 500);
}

function date_time_picker(c){
	$('#'+c).datetimepicker({
        format: "yyyy-mm-dd hh:ii",
        language: 'auto',
        startDate: false,
    	endDate: false,
    });
}
</script>
</div>
<!-- /container -->
<?php echo $footer;//装载header?>