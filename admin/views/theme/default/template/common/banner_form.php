<?php echo $header;//装载header?>
<?php echo $top;//装载top?>
<!-- /subnavbar -->
<div class="container">
	<div class="row">
		<div class="col-md-12 middle-flat-left">
			<div class="panel panel-default">
				<div class="panel-heading row row-panel-heading bg-info">
					<p class="navbar-left">
						<i class="glyphicon glyphicon-edit">
						</i>&nbsp;编辑Banner
					</p>
					<div class="navbar-right btn-group" style="margin-right: 0">
						<button type="button" onclick="submit('form-banner')" class="btn btn-sm btn-default" data-container="body" data-toggle="popover" data-placement="top" data-content="保存">
							<i class="glyphicon glyphicon-floppy-save">
							</i>
						</button>
						<a href="<?php echo site_url('common/banner');?>" class="btn btn-sm btn-default" data-container="body" data-toggle="popover" data-placement="top" data-content="返回">
							<i class="glyphicon glyphicon-share-alt">
							</i>
						</a>
					</div>
				</div>
				<!-- /widget-header -->
				<div class="panel-body page-tab">
					<form action="<?php echo $action;?>" method="post" enctype="multipart/form-data" id="form-banner" class="form-horizontal">
						<div class="form-group">
							<label class="col-sm-2 control-label" for="name">
								<span style="color: red">
									*&nbsp;
								</span>Banner名称
							</label>
							<div class="col-sm-10">
								<input type="text" name="base[name]" class="form-control" placeholder="Banner名称" value="<?php echo $name;?>">
								<?php
								if(isset($error_name)):?>
								<label class="text-danger">
									<?php echo $error_name;?>
								</label><?php endif;?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="status">
								状态
							</label>
							<div class="col-sm-10">
								<select name="base[status]" class="form-control" id="status">
									<?php
									if($status == '0'):?>
									<option value="1">
										启用
									</option>
									<option value="0" selected>
										禁用
									</option>
									<?php
									else:?>
									<option value="1" selected>
										启用
									</option>
									<option value="0">
										禁用
									</option>
									<?php endif;?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-12">
								<table class="table" id="banner">
									<thead>
										<tr>
											<td width="350px">
												标题
											</td>
											<td>
												链接
											</td>
											<td>
												图片
											</td>
											<td>
												排序
											</td>
											<td class="text-right">
												操作
											</td>
										</tr>
									</thead>
									<tbody>
										<?php $row = 0;?>
										<?php
										if(isset($images) && is_array($images)):?>
										<?php
										foreach($images as $image):?>
										<tr id="banner-row<?php echo $row; ?>">
											<td id="language">
												<?php
												foreach($languages as $language):?>
												<div class="input-group">
													<span class="input-group-addon">
														<img width="16px" height="11px" class="lazy" data-original="public/flags/<?php echo $language['image']?>">
													</span>
													<input type="text" name="image[<?php echo $row;?>][descriptions][<?php echo $language['language_id']?>][title]" class="form-control" placeholder="图片描述" value="<?php echo isset($image['descriptions'][$language['language_id']]['title']) ? $image['descriptions'][$language['language_id']]['title'] : '';?>">
												</div>
												<?php endforeach;?>
											</td>
											<td width="30%">
												<input type="text" name="image[<?php echo $row;?>][link]" class="form-control" placeholder="链接" value="<?php echo $image['link']?>">
											</td>
											<td>
												<a href="" id="thumb-image<?php echo $row;?>" data-toggle="admin-image" class="img-thumbnail">
													<img width="100px" height="100px" class="lazy" data-original="<?php echo !empty($image['sm_image']) ? $image['sm_image'] : $placeholder_image;?>" data-placeholder="<?php echo $placeholder_image;?>" />
												</a>
												<input type="hidden" name="image[<?php echo $row;?>][image]" value="<?php echo $image['image'];?>" id="input-image<?php echo $row;?>" />
											</td>
											<td>
												<input type="text" name="image[<?php echo $row;?>][sort_order]" class="form-control" placeholder="排序" value="<?php echo !empty($image['sort_order']) ? $image['sort_order'] : '0';?>">
											</td>
											<td class="text-right">
												<button type="button" onclick="$('#banner-row<?php echo $row; ?>').remove();" data-toggle="tooltip" class="btn btn-sm btn-danger">
													<i class="glyphicon glyphicon-minus">
													</i>
												</button>
											</td>
										</tr>
										<?php $row++;?>
										<?php endforeach;?>
										<?php endif;?>
									</tbody>
									<tfoot>
										<tr>
											<td colspan="5" class="text-right">
												<button type="button" onclick="addimg();" data-toggle="tooltip" class="btn btn-sm btn-primary">
													<i class="glyphicon glyphicon-plus">
													</i>
												</button>
											</td>
										</tr>
									</tfoot>
								</table>
							</div>
						</div>
					</form>
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
	var row = <?php echo $row; ?>;
	function addimg()
	{
		html  = '<tr id="banner-row'+row+'"><td width="350px" id="language">';
		html += '<?php foreach($languages as $language):?>';
		html += '<div class="input-group">';
		html += '<span class="input-group-addon"><img class="lazy" data-original="public/flags/<?php echo $language['image']?>"></span>';
		html += '<input type="text" name="image['+row+'][descriptions][<?php echo $language['language_id']?>][title]" class="form-control" placeholder="图片描述" value=""></div>';
		html += '<?php endforeach;?>';
		html += '</td><td><input type="text" name="image['+row+'][link]" class="form-control" placeholder="链接" value=""></td>';
		html += '<td><a href="" id="thumb-image'+row+'" data-toggle="admin-image" class="img-thumbnail"><img class="lazy" data-original="<?php echo $placeholder_image;?>" data-placeholder="<?php echo $placeholder_image;?>" /></a>';
		html += '<input type="hidden" name="image['+row+'][image]" value="" id="input-image'+row+'" /></td>';
		html += '<td><input type="text" name="image['+row+'][sort_order]" class="form-control" placeholder="排序" value="0"></td>';
		html += '<td class="text-right"><button type="button" onclick="$(\'#banner-row'+row+'\').remove();" data-toggle="tooltip" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-minus"></i></button></td></tr>';

		$('#banner tbody').append(html);

		row++;

		lazy_load();
	}
</script>
<?php echo $footer;//装载header?>