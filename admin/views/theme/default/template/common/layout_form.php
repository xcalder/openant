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
						</i>&nbsp;编辑布局
					</p>
					<div class="navbar-right btn-group" style="margin-right: 0">
						<button type="button" onclick="submit('form-layout')" class="btn btn-default">
							<i class="glyphicon glyphicon-floppy-save">
							</i>
						</button>
						<a href="<?php echo site_url('common/layout');?>" class="btn btn-default">
							<i class="glyphicon glyphicon-share-alt">
							</i>
						</a>
					</div>
				</div>
				<!-- /widget-header -->
				<div class="panel-body page-tab">
					<form action="<?php echo $action;?>" method="post" enctype="multipart/form-data" id="form-layout" class="form-horizontal">
						<div class="form-group">
							<label class="col-sm-2 control-label" for="name">
								<span style="color:red">
									*
								</span>名称
							</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="name" name="base[name]" placeholder="布局名称" value="<?php echo $name;?>">
								<?php
								if(isset($error_name)):?>
								<label class="text-danger">
									<?php echo $error_name;?>
								</label><?php endif;?>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-12">
								<table class="table" id="route">
									<thead>
										<tr>
											<td>
												路由
											</td>
											<td class="text-right">
												操作
											</td>
										</tr>
									</thead>
									<tbody>
										<?php $route_row = 0;?>
										<?php
										if(isset($routes) && is_array($routes)):?>
										<?php
										foreach($routes as $route):?>
										<tr id="route-<?php echo $route_row;?>">
											<td>
												<input type="text" class="form-control" id="route" name="route[<?php echo $route_row;?>][route]]" placeholder="路由" value="<?php echo $route['route'];?>">
											</td>
											<td class="text-right">
												<button type="button" onclick="$('#route-<?php echo $route_row; ?>').remove();" data-toggle="tooltip" class="btn btn-danger">
													<i class="glyphicon glyphicon-minus">
													</i>
												</button>
											</td>
										</tr>
										<?php $route_row++;?>
										<?php endforeach;?>
										<?php endif;?>
									</tbody>
									<tfoot>
										<tr>
											<td colspan="2" class="text-right">
												<button type="button" onclick="addroute();" data-toggle="tooltip" class="btn btn-primary">
													<i class="glyphicon glyphicon-plus">
													</i>
												</button>
											</td>
										</tr>
									</tfoot>
								</table>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-12">
								<table class="table" id="module">
									<thead>
										<tr>
											<td>
												模块
											</td>
											<td>
												位置
											</td>
											<td>
												排序
											</td>
											<td>
												操作
											</td>
										</tr>
									</thead>
									<tbody>
										<?php $module_row = 0;?>
										<?php
										if(isset($layout_modules) && is_array($layout_modules)):?>
										<?php
										foreach($layout_modules as $layout_module):?>
										<tr id="module-<?php echo $module_row;?>">
											<td>
												<select name="layout_module[<?php echo $module_row;?>][code]" class="form-control">
													<?php
													foreach($modules as $module):?>
													<?php
													if($module['module_id'] == $layout_module['module_id']):?>
													<option value="<?php echo $module['code'].'.'.$module['module_id'];?>" selected>
														<?php echo $module['name'];?>
													</option>
													<?php
													else:?>
													<option value="<?php echo $module['code'].'.'.$module['module_id'];?>">
														<?php echo $module['name'];?>
													</option>
													<?php endif;?>
													<?php endforeach;?>
												</select>
											</td>
											<td>
												<select name="layout_module[<?php echo $module_row;?>][position]" class="form-control">
													<?php
													if($layout_module['position'] == 'above'):?>
													<option value="above" selected>
														页面顶部
													</option>
													<option value="top">
														内容顶部
													</option>
													<option value="bottom">
														内容底部
													</option>
													<option value="left">
														内容左边
													</option>
													<option value="right">
														内容右边
													</option>
													<?php
													elseif($layout_module['position'] == 'top'):?>
													<option value="above">
														页面顶部
													</option>
													<option value="top" selected>
														内容顶部
													</option>
													<option value="bottom">
														内容底部
													</option>
													<option value="left">
														内容左边
													</option>
													<option value="right">
														内容右边
													</option>
													<?php
													elseif($layout_module['position'] == 'bottom'):?>
													<option value="above">
														页面顶部
													</option>
													<option value="top">
														内容顶部
													</option>
													<option value="bottom" selected>
														内容底部
													</option>
													<option value="left">
														内容左边
													</option>
													<option value="right">
														内容右边
													</option>
													<?php
													elseif($layout_module['position'] == 'left'):?>
													<option value="above">
														页面顶部
													</option>
													<option value="top">
														内容顶部
													</option>
													<option value="bottom">
														内容底部
													</option>
													<option value="left" selected>
														内容左边
													</option>
													<option value="right">
														内容右边
													</option>
													<?php
													else:?>
													<option value="above">
														页面顶部
													</option>
													<option value="top">
														内容顶部
													</option>
													<option value="bottom">
														内容底部
													</option>
													<option value="left">
														内容左边
													</option>
													<option value="right" selected>
														内容右边
													</option>
													<?php endif;?>
												</select>
											</td>
											<td>
												<input type="text" class="form-control" id="module" name="layout_module[<?php echo $module_row;?>][sort_order]" placeholder="排序" value="<?php echo $layout_module['sort_order'];?>">

											</td>
											<td class="text-right">
												<button type="button" onclick="$('#module-<?php echo $module_row; ?>').remove();" data-toggle="tooltip" class="btn btn-danger">
													<i class="glyphicon glyphicon-minus">
													</i>
												</button>
											</td>
										</tr>
										<?php $module_row++;?>
										<?php endforeach;?>
										<?php endif;?>
									</tbody>
									<tfoot>
										<tr>
											<td colspan="4" class="text-right">
												<button type="button" onclick="addmodule();" data-toggle="tooltip" class="btn btn-primary">
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
	var route_row = <?php echo $route_row; ?>;
	function addroute()
	{
		html  = '<tr id="route-'+route_row+'"><td>';
		html += '<input type="text" class="form-control" id="route" name="route['+route_row+'][route]]" placeholder="路由" value=""></td>';
		html += '<td class="text-right"><button type="button" onclick="$(\'#route-'+route_row+'\').remove();" data-toggle="tooltip" class="btn btn-danger"><i class="glyphicon glyphicon-minus"></i></button></td></tr>';

		$('#route tbody').append(html);

		route_row++;

	}


	var module_row = <?php echo $module_row; ?>;
	function addmodule()
	{
		html  = '<tr id="module-'+module_row+'"><td><select name="layout_module['+module_row+'][code]" class="form-control">';
		html += '<?php foreach($modules as $module):?>';
		html += '<option value="<?php echo $module['code'].'.'.$module['module_id'];?>"><?php echo $module['name'];?></option>';
		html += '<?php endforeach;?>';
		html += '</select></td><td><select name="layout_module['+module_row+'][position]" class="form-control">';
		html += '<option value="above">页面顶部</option><option value="top">内容顶部</option><option value="bottom">内容底部</option><option value="left">内容左边</option><option value="right">内容右边</option>';
		html += '</select></td><td><input type="text" class="form-control" id="module" name="layout_module['+module_row+'][sort_order]" placeholder="排序" value="0"></td>';
		html += '<td class="text-right"><button type="button" onclick="$(\'#module-'+module_row+'\').remove();" data-toggle="tooltip" class="btn btn-danger"><i class="glyphicon glyphicon-minus"></i></button></td></tr>';

		$('#module tbody').append(html);

		module_row++;
	}
</script><!-- /Calendar -->
<?php echo $footer;//装载header?>