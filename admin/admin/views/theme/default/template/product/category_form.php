<?php echo $header;//装载header?>
<?php echo $top_nav;//装载top?>
<!-- /subnavbar -->
<div class="container">
	<div class="row">
		<div class="col-md-12 middle-flat-left">
			<div class="panel panel-default">
				<div class="panel-heading row row-panel-heading bg-info">
					<p class="navbar-left"><i class="glyphicon glyphicon-edit"></i>&nbsp;编辑商品分类</p>
					<div class="navbar-right btn-group" style="margin-right: 0">
						<button type="button" onclick="submit('form-category')" class="btn btn-sm btn-default"><i class="glyphicon glyphicon-floppy-save"></i></button>
						<a href="<?php echo $this->config->item('admin').'product/category';?>" class="btn btn-sm btn-default"><i class="glyphicon glyphicon-share-alt"></i></a>
					</div>
				</div>
				<!-- /widget-header -->
				<div class="panel-body page-tab">
					<form action="<?php echo $action;?>" method="post" enctype="multipart/form-data" id="form-category" class="form-horizontal">
						<ul class="nav nav-tabs">
							<li class="active"><a href="#tab-general" aria-controls="tab-general" role="tab" data-toggle="tab">编辑项目</a></li>
							<li><a href="#tab-data" aria-controls="profile" role="tab" data-toggle="tab">基本信息</a></li>
							<li><a href="#tab-attribute" aria-controls="profile" role="tab" data-toggle="tab">属性</a></li>
							<li><a href="#tab-option" aria-controls="profile" role="tab" data-toggle="tab">选项</a></li>
							<li><a href="#tab-manufacturer" aria-controls="profile" role="tab" data-toggle="tab">品牌</a></li>
							<li><a href="#tab-barcode" aria-controls="profile" role="tab" data-toggle="tab">条码</a></li>
							<li><a href="#tab-stock-status" aria-controls="profile" role="tab" data-toggle="tab">发货时间</a></li>
							<li><a href="#tab-aftermarket" aria-controls="profile" role="tab" data-toggle="tab">售后保障</a></li>
							<li><a href="#tab-tax" aria-controls="profile" role="tab" data-toggle="tab">税费</a></li>
							<li><a href="#tab-download" aria-controls="profile" role="tab" data-toggle="tab">下载商品</a></li>
						</ul>

						<!-- Tab panes -->
						<div class="tab-content">
							<div role="tabpanel" class="tab-pane active" id="tab-general">
								<ul class="nav nav-tabs" role="tablist" id="language-list">
									<?php foreach($languages as $language):?>
									<li role="presentation"><a href="#language<?php echo $language['language_id']?>" role="tab" data-toggle="tab"><img width="16px" height="11px" class="lazy" data-original="resources/public/flags/<?php echo $language['image']?>">&nbsp;&nbsp;<?php echo $language['name']?></a></li>
									<?php endforeach;?>
								</ul>
								<!-- Tab panes -->
								<div class="tab-content" id="language-form">
									<?php foreach($languages as $language):?>
									<div role="tabpanel" class="tab-pane" id="language<?php echo $language['language_id']?>">
										<div class="form-group">
											<label class="col-sm-2 control-label" for="name"><span style="color:red">*</span>分类名称</label>
											<div class="col-sm-10">
												<input type="text" class="form-control" name="category_description[<?php echo $language['language_id']?>][name]" id="input-name<?php echo $language['language_id']?>" placeholder="分类名称" value="<?php echo isset($category_description[$language['language_id']]) ? $category_description[$language['language_id']]['name'] : ''; ?>">
												<?php if(!empty($error_name)):?><label class="text-danger"><?php echo isset($error_name[$language['language_id']]) ? $error_name[$language['language_id']] : '';?></label><?php endif;?>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="description">分类描述</label>
											<div class="col-sm-10">
												<textarea name="category_description[<?php echo $language['language_id']; ?>][description]" id="input-description<?php echo $language['language_id']; ?>" class="form-control" placeholder="分类描述"><?php echo isset($category_description[$language['language_id']]['description']) ? $category_description[$language['language_id']]['description'] : ''; ?></textarea>
											</div>
										</div>
									</div>
									<?php endforeach;?>
								</div>
							</div>
							<div role="tabpanel" class="tab-pane" id="tab-data">
								<div class="form-group">
									<label class="col-sm-2 control-label" for="image">分类图片</label>
									<div class="col-sm-10">
										<a href="" id="thumb-image" data-toggle="admin-image" class="img-thumbnail"><img width="16px" height="11px" class="lazy" data-original="<?php echo isset($image) ? $image : $placeholder_image;?>" alt="分类图片" title="分类图片" data-placeholder="<?php echo $placeholder_image;?>" /></a>
										<input type="hidden" name="base[image]" value="<?php echo isset($image) ? $image : '';?>" id="input-image" />
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="parent-id">上级分类</label>
									<div class="col-sm-10">
										<select name="base[parent_id]" class="form-control">
											<option value="">--无--</option>
											<?php foreach($cotegorys_select as $category):?>
											<?php if($parent_id == $category['category_id']):?>
											<option value="<?php echo $category['category_id']?>" selected><?php echo $category['name'];?></option>
											<?php else:?>
											<option value="<?php echo $category['category_id']?>"><?php echo $category['name'];?></option>
											<?php endif;?>
											<?php endforeach;?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="sort_order">排序</label>
									<div class="col-sm-10">
										<input type="text" name="base[sort_order]" class="form-control" id="sort_order" placeholder="排序" value="<?php echo !empty($sort_order) ? $sort_order : '0'?>">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="status">状态</label>
									<div class="col-sm-10">
										<select name="base[status]" class="form-control" id="status">
											<?php if($status == TRUE):?>
											<option value="1" checked>启用</option>
											<option value="0">停用</option>
											<?php else:?>
											<option value="1">启用</option>
											<option value="0" checked>停用</option>
											<?php endif;?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="column">二级目录分几列显示</label>
									<div class="col-sm-10">
										<input type="text" name="base[column]" class="form-control" id="column" placeholder="显示几列" value="<?php echo !empty($column) ? $column : '1';?>">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="top">顶部导航显示</label>
									<div class="col-sm-10">
										<?php if($top == TRUE):?>
										<label class="radio-inline"><input type="radio" name="base[top]" id="top" value="1" checked>是</label>
										<label class="radio-inline"><input type="radio" name="base[top]" id="top" value="0">否</label>
										<?php else:?>
										<label class="radio-inline"><input type="radio" name="base[top]" id="top" value="1">是</label>
										<label class="radio-inline"><input type="radio" name="base[top]" id="top" value="0" checked>否</label>
										<?php endif;?>
									</div>
								</div>
							
							</div>
							<div role="tabpanel" class="tab-pane" id="tab-attribute">
								选择属性<hr>
								<?php foreach($attributes as $key=>$attribute):?>
								<div class="form-group">
									<span class="col-sm-2 control-label" for="option-<?php echo $key;?>"><?php echo $attribute['group_name'];?></span>
									<div class="col-sm-10">
										<?php if(isset($ol_attribute) && in_array($attribute['attribute_group_id'], $ol_attribute)):?>
										<label class="radio-inline">
											<input type="radio" name="attribute[<?php echo $key;?>][value]" id="attribute-<?php echo $key;?>" value="<?php echo $attribute['attribute_group_id'];?>" checked>在此分类下显示
										</label>
										<label class="radio-inline">
											<input type="radio" name="attribute[<?php echo $key;?>][value]" id="attribute-<?php echo $key;?>" value="">在此分类下不显示
										</label>
										<?php else:?>
										<label class="radio-inline">
											<input type="radio" name="attribute[<?php echo $key;?>][value]" id="attribute-<?php echo $key;?>" value="<?php echo $attribute['attribute_group_id'];?>">在此分类下显示
										</label>
										<label class="radio-inline">
											<input type="radio" name="attribute[<?php echo $key;?>][value]" id="attribute-<?php echo $key;?>" value="" checked>在此分类下不显示
										</label>
										<?php endif;?>
										
										<span style="color: blue;margin: 0 15px">|</span>
										
										<?php if(isset($ol_attribute_required) && in_array($attribute['attribute_group_id'].'.1', $ol_attribute_required)):?>
										<label class="radio-inline">
											<input type="radio" name="attribute[<?php echo $key;?>][required]" id="attribute-<?php echo $key;?>" value="<?php echo $attribute['attribute_group_id'].'.1';?>" checked>必填
										</label>
										<label class="radio-inline">
											<input type="radio" name="attribute[<?php echo $key;?>][required]" id="attribute-<?php echo $key;?>" value="<?php echo $attribute['attribute_group_id'].'.0';?>">非必填
										</label>
										<?php else:?>
										<label class="radio-inline">
											<input type="radio" name="attribute[<?php echo $key;?>][required]" id="attribute-<?php echo $key;?>" value="<?php echo $attribute['attribute_group_id'].'.1';?>">必填
										</label>
										<label class="radio-inline">
											<input type="radio" name="attribute[<?php echo $key;?>][required]" id="attribute-<?php echo $key;?>" value="<?php echo $attribute['attribute_group_id'].'.0';?>" checked>非必填
										</label>
										<?php endif;?>
									</div>
								</div><hr>
								<?php endforeach;?>
							</div>
							<div role="tabpanel" class="tab-pane" id="tab-option">
								选择选项<hr>
								<?php foreach($options as $key=>$option):?>
								<div class="form-group">
									<span class="col-sm-2 control-label" for="option-<?php echo $key;?>"><?php echo $option['option_group_name'];?></span>
									<div class="col-sm-10">
										<?php if(isset($ol_option) && in_array($option['option_group_id'], $ol_option)):?>
										<label class="radio-inline">
											<input type="radio" name="option[<?php echo $key;?>][value]" id="option-<?php echo $key;?>" value="<?php echo $option['option_group_id'];?>" checked>在此分类下显示
										</label>
										<label class="radio-inline">
											<input type="radio" name="option[<?php echo $key;?>][value]" id="option-<?php echo $key;?>" value="">在此分类下不显示
										</label>
										<?php else:?>
										<label class="radio-inline">
											<input type="radio" name="option[<?php echo $key;?>][value]" id="option-<?php echo $key;?>" value="<?php echo $option['option_group_id'];?>">在此分类下显示
										</label>
										<label class="radio-inline">
											<input type="radio" name="option[<?php echo $key;?>][value]" id="option-<?php echo $key;?>" value="" checked>在此分类下不显示
										</label>
										<?php endif;?>
										
										<span style="color: blue;margin: 0 15px">|</span>
										
										<?php if(isset($ol_option_required) && in_array($option['option_group_id'].'.1', $ol_option_required)):?>
										<label class="radio-inline">
											<input type="radio" name="option[<?php echo $key;?>][required]" id="option-<?php echo $key;?>" value="<?php echo $option['option_group_id'].'.1';?>" checked>必填
										</label>
										<label class="radio-inline">
											<input type="radio" name="option[<?php echo $key;?>][required]" id="option-<?php echo $key;?>" value="<?php echo $option['option_group_id'].'.0';?>">非必填
										</label>
										<?php else:?>
										<label class="radio-inline">
											<input type="radio" name="option[<?php echo $key;?>][required]" id="option-<?php echo $key;?>" value="<?php echo $option['option_group_id'].'.1';?>">必填
										</label>
										<label class="radio-inline">
											<input type="radio" name="option[<?php echo $key;?>][required]" id="option-<?php echo $key;?>" value="<?php echo $option['option_group_id'].'.0';?>" checked>非必填
										</label>
										<?php endif;?>
									</div>
								</div><hr>
								<?php endforeach;?>
							</div>
							<div role="tabpanel" class="tab-pane" id="tab-manufacturer">
								选择品牌<hr>
								<?php foreach($manufacturers as $key=>$manufacturer):?>
								<div class="form-group">
									<span class="col-sm-2 control-label" for="option-<?php echo $key;?>"><?php echo $manufacturer['name'];?></span>
									<div class="col-sm-10">
										<?php if(isset($ol_manufacturer) && in_array($manufacturer['manufacturer_id'], $ol_manufacturer)):?>
										<label class="radio-inline">
											<input type="radio" name="manufacturer[<?php echo $key;?>][value]" id="manufacturer-<?php echo $key;?>" value="<?php echo $manufacturer['manufacturer_id'];?>" checked>在此分类下显示
										</label>
										<label class="radio-inline">
											<input type="radio" name="manufacturer[<?php echo $key;?>][value]" id="manufacturer-<?php echo $key;?>" value="">在此分类下不显示
										</label>
										<?php else:?>
										<label class="radio-inline">
											<input type="radio" name="manufacturer[<?php echo $key;?>][value]" id="manufacturer-<?php echo $key;?>" value="<?php echo $manufacturer['manufacturer_id'];?>">在此分类下显示
										</label>
										<label class="radio-inline">
											<input type="radio" name="manufacturer[<?php echo $key;?>][value]" id="manufacturer-<?php echo $key;?>" value="" checked>在此分类下不显示
										</label>
										<?php endif;?>
										
										<span style="color: blue;margin: 0 15px">|</span>
										
										<?php if(isset($ol_manufacturer_required) && in_array($manufacturer['manufacturer_id'].'.1', $ol_manufacturer_required)):?>
										<label class="radio-inline">
											<input type="radio" name="manufacturer[<?php echo $key;?>][required]" id="manufacturer-<?php echo $key;?>" value="<?php echo $manufacturer['manufacturer_id'].'.1';?>" checked>必填
										</label>
										<label class="radio-inline">
											<input type="radio" name="manufacturer[<?php echo $key;?>][required]" id="manufacturer-<?php echo $key;?>" value="<?php echo $manufacturer['manufacturer_id'].'.0';?>">非必填
										</label>
										<?php else:?>
										<label class="radio-inline">
											<input type="radio" name="manufacturer[<?php echo $key;?>][required]" id="manufacturer-<?php echo $key;?>" value="<?php echo $manufacturer['manufacturer_id'].'.1';?>">必填
										</label>
										<label class="radio-inline">
											<input type="radio" name="manufacturer[<?php echo $key;?>][required]" id="manufacturer-<?php echo $key;?>" value="<?php echo $manufacturer['manufacturer_id'].'.0';?>" checked>非必填
										</label>
										<?php endif;?>
									</div>
								</div><hr>
								<?php endforeach;?>
							</div>
							<div role="tabpanel" class="tab-pane" id="tab-barcode">
								选择条码<hr>
								<?php foreach($barcodes as $key=>$barcode):?>
								<div class="form-group">
									<span class="col-sm-2 control-label" for="option-<?php echo $key;?>"><?php echo $barcode['name'];?></span>
									<div class="col-sm-10">
										<?php if(isset($ol_barcode) && in_array($barcode['barcode_id'], $ol_barcode)):?>
										<label class="radio-inline">
											<input type="radio" name="barcode[<?php echo $key;?>][value]" id="barcode-<?php echo $key;?>" value="<?php echo $barcode['barcode_id'];?>" checked>在此分类下显示
										</label>
										<label class="radio-inline">
											<input type="radio" name="barcode[<?php echo $key;?>][value]" id="barcode-<?php echo $key;?>" value="">在此分类下不显示
										</label>
										<?php else:?>
										<label class="radio-inline">
											<input type="radio" name="barcode[<?php echo $key;?>][value]" id="barcode-<?php echo $key;?>" value="<?php echo $barcode['barcode_id'];?>">在此分类下显示
										</label>
										<label class="radio-inline">
											<input type="radio" name="barcode[<?php echo $key;?>][value]" id="barcode-<?php echo $key;?>" value="" checked>在此分类下不显示
										</label>
										<?php endif;?>
										
										<span style="color: blue;margin: 0 15px">|</span>
										
										<?php if(isset($ol_barcode_required) && in_array($barcode['barcode_id'].'.1', $ol_barcode_required)):?>
										<label class="radio-inline">
											<input type="radio" name="barcode[<?php echo $key;?>][required]" id="barcode-<?php echo $key;?>" value="<?php echo $barcode['barcode_id'].'.1';?>" checked>必填
										</label>
										<label class="radio-inline">
											<input type="radio" name="barcode[<?php echo $key;?>][required]" id="barcode-<?php echo $key;?>" value="<?php echo $barcode['barcode_id'].'.0';?>">非必填
										</label>
										<?php else:?>
										<label class="radio-inline">
											<input type="radio" name="barcode[<?php echo $key;?>][required]" id="barcode-<?php echo $key;?>" value="<?php echo $barcode['barcode_id'].'.1';?>">必填
										</label>
										<label class="radio-inline">
											<input type="radio" name="barcode[<?php echo $key;?>][required]" id="barcode-<?php echo $key;?>" value="<?php echo $barcode['barcode_id'].'.0';?>" checked>非必填
										</label>
										<?php endif;?>
									</div>
								</div><hr>
								<?php endforeach;?>
							</div>
							<div role="tabpanel" class="tab-pane" id="tab-stock-status">
								选择发货时间<hr>
								<?php foreach($stock_statuss as $key=>$stock_status):?>
								<div class="form-group">
									<span class="col-sm-2 control-label" for="option-<?php echo $key;?>"><?php echo $stock_status['name'];?></span>
									<div class="col-sm-10">
										<?php if(isset($ol_stock_status) && in_array($stock_status['stock_status_id'], $ol_stock_status)):?>
										<label class="radio-inline">
											<input type="radio" name="stock_status[<?php echo $key;?>][value]" id="stock_status-<?php echo $key;?>" value="<?php echo $stock_status['stock_status_id'];?>" checked>在此分类下显示
										</label>
										<label class="radio-inline">
											<input type="radio" name="stock_status[<?php echo $key;?>][value]" id="stock_status-<?php echo $key;?>" value="">在此分类下不显示
										</label>
										<?php else:?>
										<label class="radio-inline">
											<input type="radio" name="stock_status[<?php echo $key;?>][value]" id="stock_status-<?php echo $key;?>" value="<?php echo $stock_status['stock_status_id'];?>">在此分类下显示
										</label>
										<label class="radio-inline">
											<input type="radio" name="stock_status[<?php echo $key;?>][value]" id="stock_status-<?php echo $key;?>" value="" checked>在此分类下不显示
										</label>
										<?php endif;?>
										
										<span style="color: blue;margin: 0 15px">|</span>
										
										<?php if(isset($ol_stock_status_required) && in_array($stock_status['stock_status_id'].'.1', $ol_stock_status_required)):?>
										<label class="radio-inline">
											<input type="radio" name="stock_status[<?php echo $key;?>][required]" id="stock_status-<?php echo $key;?>" value="<?php echo $stock_status['stock_status_id'].'.1';?>" checked>必填
										</label>
										<label class="radio-inline">
											<input type="radio" name="stock_status[<?php echo $key;?>][required]" id="stock_status-<?php echo $key;?>" value="<?php echo $stock_status['stock_status_id'].'.0';?>">非必填
										</label>
										<?php else:?>
										<label class="radio-inline">
											<input type="radio" name="stock_status[<?php echo $key;?>][required]" id="stock_status-<?php echo $key;?>" value="<?php echo $stock_status['stock_status_id'].'.1';?>">必填
										</label>
										<label class="radio-inline">
											<input type="radio" name="stock_status[<?php echo $key;?>][required]" id="stock_status-<?php echo $key;?>" value="<?php echo $stock_status['stock_status_id'].'.0';?>" checked>非必填
										</label>
										<?php endif;?>
									</div>
								</div><hr>
								<?php endforeach;?>
							</div>
							<div role="tabpanel" class="tab-pane" id="tab-aftermarket">
								选择售后保障<hr>
								<?php foreach($aftermarkets as $key=>$aftermarket):?>
								<div class="form-group">
									<span class="col-sm-2 control-label" for="option-<?php echo $key;?>"><?php echo $aftermarket['name'];?></span>
									<div class="col-sm-10">
										<?php if(isset($ol_aftermarket) && in_array($aftermarket['aftermarket_id'], $ol_aftermarket)):?>
										<label class="radio-inline">
											<input type="radio" name="aftermarket[<?php echo $key;?>][value]" id="aftermarket-<?php echo $key;?>" value="<?php echo $aftermarket['aftermarket_id'];?>" checked>在此分类下显示
										</label>
										<label class="radio-inline">
											<input type="radio" name="aftermarket[<?php echo $key;?>][value]" id="aftermarket-<?php echo $key;?>" value="">在此分类下不显示
										</label>
										<?php else:?>
										<label class="radio-inline">
											<input type="radio" name="aftermarket[<?php echo $key;?>][value]" id="aftermarket-<?php echo $key;?>" value="<?php echo $aftermarket['aftermarket_id'];?>">在此分类下显示
										</label>
										<label class="radio-inline">
											<input type="radio" name="aftermarket[<?php echo $key;?>][value]" id="aftermarket-<?php echo $key;?>" value="" checked>在此分类下不显示
										</label>
										<?php endif;?>
										
										<span style="color: blue;margin: 0 15px">|</span>
										
										<?php if(isset($ol_aftermarket_required) && in_array($aftermarket['aftermarket_id'].'.1', $ol_aftermarket_required)):?>
										<label class="radio-inline">
											<input type="radio" name="aftermarket[<?php echo $key;?>][required]" id="aftermarket-<?php echo $key;?>" value="<?php echo $aftermarket['aftermarket_id'].'.1';?>" checked>必填
										</label>
										<label class="radio-inline">
											<input type="radio" name="aftermarket[<?php echo $key;?>][required]" id="aftermarket-<?php echo $key;?>" value="<?php echo $aftermarket['aftermarket_id'].'.0';?>">非必填
										</label>
										<?php else:?>
										<label class="radio-inline">
											<input type="radio" name="aftermarket[<?php echo $key;?>][required]" id="aftermarket-<?php echo $key;?>" value="<?php echo $aftermarket['aftermarket_id'].'.1';?>">必填
										</label>
										<label class="radio-inline">
											<input type="radio" name="aftermarket[<?php echo $key;?>][required]" id="aftermarket-<?php echo $key;?>" value="<?php echo $aftermarket['aftermarket_id'].'.0';?>" checked>非必填
										</label>
										<?php endif;?>
									</div>
								</div><hr>
								<?php endforeach;?>
							</div>
							<div role="tabpanel" class="tab-pane" id="tab-tax">
								选择税费<hr>
								<?php foreach($tax_classs as $key=>$tax_class):?>
								<div class="form-group">
									<span class="col-sm-2 control-label" for="option-<?php echo $key;?>"><?php echo $tax_class['title'];?></span>
									<div class="col-sm-10">
										<?php if(isset($ol_tax_class) && in_array($tax_class['tax_class_id'], $ol_tax_class)):?>
										<label class="radio-inline">
											<input type="radio" name="tax_class[<?php echo $key;?>][value]" id="tax_class-<?php echo $key;?>" value="<?php echo $tax_class['tax_class_id'];?>" checked>在此分类下显示
										</label>
										<label class="radio-inline">
											<input type="radio" name="tax_class[<?php echo $key;?>][value]" id="tax_class-<?php echo $key;?>" value="">在此分类下不显示
										</label>
										<?php else:?>
										<label class="radio-inline">
											<input type="radio" name="tax_class[<?php echo $key;?>][value]" id="tax_class-<?php echo $key;?>" value="<?php echo $tax_class['tax_class_id'];?>">在此分类下显示
										</label>
										<label class="radio-inline">
											<input type="radio" name="tax_class[<?php echo $key;?>][value]" id="tax_class-<?php echo $key;?>" value="" checked>在此分类下不显示
										</label>
										<?php endif;?>
										
										<span style="color: blue;margin: 0 15px">|</span>
										
										<?php if(isset($ol_tax_class_required) && in_array($tax_class['tax_class_id'].'.1', $ol_tax_class_required)):?>
										<label class="radio-inline">
											<input type="radio" name="tax_class[<?php echo $key;?>][required]" id="tax_class-<?php echo $key;?>" value="<?php echo $tax_class['tax_class_id'].'.1';?>" checked>必填
										</label>
										<label class="radio-inline">
											<input type="radio" name="tax_class[<?php echo $key;?>][required]" id="tax_class-<?php echo $key;?>" value="<?php echo $tax_class['tax_class_id'].'.0';?>">非必填
										</label>
										<?php else:?>
										<label class="radio-inline">
											<input type="radio" name="tax_class[<?php echo $key;?>][required]" id="tax_class-<?php echo $key;?>" value="<?php echo $tax_class['tax_class_id'].'.1';?>">必填
										</label>
										<label class="radio-inline">
											<input type="radio" name="tax_class[<?php echo $key;?>][required]" id="tax_class-<?php echo $key;?>" value="<?php echo $tax_class['tax_class_id'].'.0';?>" checked>非必填
										</label>
										<?php endif;?>
									</div>
								</div><hr>
								<?php endforeach;?>
							</div>
							<div role="tabpanel" class="tab-pane" id="tab-download">
								下载商品<hr>
								<?php foreach($downloads as $key=>$download):?>
								<div class="form-group">
									<span class="col-sm-2 control-label" for="option-<?php echo $key;?>"><?php echo $download['name'];?></span>
									<div class="col-sm-10">
										<?php if(isset($ol_download) && in_array($download['download_id'], $ol_download)):?>
										<label class="radio-inline">
											<input type="radio" name="download[<?php echo $key;?>][value]" id="download-<?php echo $key;?>" value="<?php echo $download['download_id'];?>" checked>在此分类下显示
										</label>
										<label class="radio-inline">
											<input type="radio" name="download[<?php echo $key;?>][value]" id="download-<?php echo $key;?>" value="">在此分类下不显示
										</label>
										<?php else:?>
										<label class="radio-inline">
											<input type="radio" name="download[<?php echo $key;?>][value]" id="download-<?php echo $key;?>" value="<?php echo $download['download_id'];?>">在此分类下显示
										</label>
										<label class="radio-inline">
											<input type="radio" name="download[<?php echo $key;?>][value]" id="download-<?php echo $key;?>" value="" checked>在此分类下不显示
										</label>
										<?php endif;?>
										
										<span style="color: blue;margin: 0 15px">|</span>
										
										<?php if(isset($ol_download_required) && in_array($download['download_id'].'.1', $ol_download_required)):?>
										<label class="radio-inline">
											<input type="radio" name="download[<?php echo $key;?>][required]" id="download-<?php echo $key;?>" value="<?php echo $download['download_id'].'.1';?>" checked>必填
										</label>
										<label class="radio-inline">
											<input type="radio" name="download[<?php echo $key;?>][required]" id="download-<?php echo $key;?>" value="<?php echo $download['download_id'].'.0';?>">非必填
										</label>
										<?php else:?>
										<label class="radio-inline">
											<input type="radio" name="download[<?php echo $key;?>][required]" id="download-<?php echo $key;?>" value="<?php echo $download['download_id'].'.1';?>">必填
										</label>
										<label class="radio-inline">
											<input type="radio" name="download[<?php echo $key;?>][required]" id="download-<?php echo $key;?>" value="<?php echo $download['download_id'].'.0';?>" checked>非必填
										</label>
										<?php endif;?>
									</div>
								</div><hr>
								<?php endforeach;?>
							</div>
						</div>
					</form>
				</div>
				<!-- /widget-content --> 
			</div>
			<!-- /widget -->
		</div>
		<!-- /span12 -->
	</div>
	<!-- /row --> 
</div>
<!-- /container -->

<script type="text/javascript">
	<?php foreach ($languages as $language):?>
	$(document).ready(function () {
			$('#input-description<?php echo $language['language_id']; ?>').summernote({
					height: 200,                 // set editor height
				});
		});
	<?php endforeach; ?>

	//
	<?php if(!empty($error_warning)):?>
	$(document).ready(function () {
			$.notify({
					// options
					icon: 'icon-warning-sign',
					message: '<?php echo $error_warning;?>' 
				},{
					// settings
					type: 'danger'
				});
		});
	<?php endif;?>
</script>
<?php echo $footer;//装载header?>