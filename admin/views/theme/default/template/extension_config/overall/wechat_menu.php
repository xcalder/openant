<?php echo $header;//装载header?>
<?php echo $top;//装载top?>
<div class="container">
	<div class="row">
		<div class="col-md-12 middle-flat-left">
			<div class="panel panel-default">
				<div class="panel-heading row row-panel-heading bg-info">
					<p class="navbar-left"><i class="glyphicon glyphicon-signal"></i>管理微信公众号菜单</p>
					<div class="navbar-right btn-group" style="margin-right: 0">
						<button type="button" onclick="submit('form-module')" class="btn btn-sm btn-default"><i class="glyphicon glyphicon-floppy-save"></i></button>
						<a href="<?php echo site_url('extension_config/module/product');?>" class="btn btn-sm btn-default"><i class="glyphicon glyphicon-share-alt"></i></a>
					</div>
				</div>
				<!-- /widget-header -->
				<div class="panel-body">
					<form action="admin.php/extension_config/overall/wechat_menu.html" method="post" enctype="multipart/form-data" id="form-module" class="form-horizontal">
						<table class="table table-bordered">
							<thead>
								<tr>
									<td>一级菜单</td>
									<td>二级菜单</td>
									<td>事件</td>
									<td>关键词/链接</td>
									<td>操作</td>
								</tr>
							</thead>
							<tbody>
								<?php $row_top='0';?>
								<?php if(!empty($menus)):?>
								<?php foreach($menus['menu']['button'] as $key=>$value):?>
								<?php if(isset($value['sub_button']) && !empty($value['sub_button'])):?>
								<tr style="background-color: #eee" id="menu-top-<?php echo $row_top;?>" class="menu-top">
									<td colspan="2"><input type="text" onblur="change_topname('<?php echo $row_top;?>');" class="form-control" id="menu-button-<?php echo $row_top;?>-name" name="menu[button][<?php echo $row_top;?>][name]" placeholder="一级菜单名" value="<?php echo $value['name'];?>"></td>
									<td><?php //echo $value['type'];?>
										<select class="form-control" id="menu-button-<?php echo $row_top;?>-type" name="menu[button][<?php echo $row_top;?>][type]" onchange="change_top_key('<?php echo $row_top;?>');">
											<option value="">无事件的一级菜单</option>
											<?php foreach ($action as $k=>$v):?>
											<?php if($value['type'] == $k):?>
											<option value="<?php echo $k;?>" selected><?php echo $v;?></option>
											<?php else:?>
											<option value="<?php echo $k;?>"><?php echo $v;?></option>
											<?php endif;?>
											<?php endforeach;?>
										</select>
									</td>
									<?php if(isset($value['key'])):?>
									<td><input type="text" class="form-control" id="menu-button-<?php echo $row_top;?>-key-url" name="menu[button][<?php echo $row_top;?>][key]" placeholder="关键词" value="<?php echo $value['key'];?>"></td>
									<?php elseif(isset($value['url'])):?>
									<td><input type="text" class="form-control" id="menu-button-<?php echo $row_top;?>-key-url" name="menu[button][<?php echo $row_top;?>][url]" placeholder="链接" value="<?php echo $value['url'];?>"></td>
									<?php else:?>
									<td><input type="text" class="form-control" id="menu-button-<?php echo $row_top;?>-key-url" name="menu[button][<?php echo $row_top;?>][key]" placeholder="关键词/链接" value=""></td>
									<?php endif;?>
									<td class="text-right">
										<div class="btn-group">
										  <button type="button" class="btn btn-info btn-sm" onclick="add_child('<?php echo $row_top?>');">添加子菜单</button>
										  <button type="button" class="btn btn-danger btn-sm" onclick="$('#menu-top-<?php echo $row_top?>').remove();$('.menu-top-<?php echo $row_top?>').remove();">删除</button>
										</div>
									</td>
								</tr>
								<?php $row_child='0';?>
								<?php foreach ($value['sub_button'] as $k=>$v):?>
								<tr id="menu-top-<?php echo $row_top.$row_child;?>" class="menu-top-<?php echo $row_top;?>">
									<td><input type="text" class="form-control menu-button-<?php echo $row_top;?>-name" placeholder="一级菜单名" value="<?php echo $value['name'];?>" disabled="disabled"></td>
									<td><input type="text" class="form-control" id="menu-button-<?php echo $row_top;?>-sub_button-<?php echo $row_child;?>-name" name="menu[button][<?php echo $row_top;?>][sub_button][<?php echo $row_child;?>][name]" placeholder="二级菜单名" value="<?php echo $v['name'];?>"></td>
									<td><?php //echo $v['type'];?>
										<select class="form-control" id="menu-button-<?php echo $row_top;?>-sub_button-<?php echo $row_child;?>-type" name="menu[button][<?php echo $row_top;?>][sub_button][<?php echo $row_child;?>][type]" onchange="change_child_key('<?php echo $row_top;?>', '<?php echo $row_child;?>');">
											<option value="">无事件的一级菜单</option>
											<?php foreach ($action as $ke=>$va):?>
											<?php if($v['type'] == $ke):?>
											<option value="<?php echo $ke;?>" selected><?php echo $va;?></option>
											<?php else:?>
											<option value="<?php echo $ke;?>"><?php echo $va;?></option>
											<?php endif;?>
											<?php endforeach;?>
										</select>
									</td>
									<?php if(isset($v['key'])):?>
									<td><input type="text" class="form-control" id="menu-button-<?php echo $row_top;?>-sub_button-<?php echo $row_child;?>-key-url" name="menu[button][<?php echo $row_top;?>][sub_button][<?php echo $row_child;?>][key]" placeholder="关键词" value="<?php echo $v['key'];?>"></td>
									<?php elseif(isset($v['url'])):?>
									<td><input type="text" class="form-control" id="menu-button-<?php echo $row_top;?>-sub_button-<?php echo $row_child;?>-key-url" name="menu[button][<?php echo $row_top;?>][sub_button][<?php echo $row_child;?>][url]" placeholder="链接" value="<?php echo $v['url'];?>"></td>
									<?php else:?>
									<td><input type="text" class="form-control" id="menu-button-<?php echo $row_top;?>-sub_button-<?php echo $row_child;?>-key-url" name="menu[button][<?php echo $row_top;?>][sub_button][<?php echo $row_child;?>][key]" placeholder="关键词/链接" value=""></td>
									<?php endif;?>
									<td class="text-right"><button type="button" class="btn btn-danger btn-sm" onclick="$('#menu-top-<?php echo $row_top.$row_child?>').remove();check_top('<?php echo $row_top?>');">删除</button></td>
								</tr>
								<?php $row_child++;?>
								<?php endforeach;?>
								<?php else:?>
								<tr style="background-color: #eee" id="menu-top-<?php echo $row_top;?>" class="menu-top">
									<td colspan="2"><input type="text" class="form-control" onblur="change_topname('<?php echo $row_top;?>');" id="menu-button-<?php echo $row_top;?>-name" name="menu[button][<?php echo $row_top;?>][name]" placeholder="一级菜单名" value="<?php echo $value['name'];?>"></td>
									<td><?php //echo $value['type'];?>
										<select class="form-control" id="menu-button-<?php echo $row_top;?>-type" name="menu[button][<?php echo $row_top;?>][type]" onchange="change_top_key('<?php echo $row_top;?>');">
											<option value="">无事件的一级菜单</option>
											<?php foreach ($action as $k=>$v):?>
											<option value="<?php echo $k;?>"><?php echo $v;?></option>
											<?php endforeach;?>
										</select>
									</td>
									<?php if(isset($value['key'])):?>
									<td><input type="text" class="form-control" id="menu-button-<?php echo $row_top;?>-key-url" name="menu[button][<?php echo $row_top;?>][key]" placeholder="关键词" value="<?php echo $value['key'];?>"></td>
									<?php elseif(isset($value['url'])):?>
									<td><input type="text" class="form-control" id="menu-button-<?php echo $row_top;?>-key-url" name="menu[button][<?php echo $row_top;?>][url]" placeholder="链接" value="<?php echo $value['url'];?>"></td>
									<?php else:?>
									<td><input type="text" class="form-control" id="menu-button-<?php echo $row_top;?>-key-url" name="menu[button][<?php echo $row_top;?>][key]" placeholder="关键词/链接" value=""></td>
									<?php endif;?>
									
									<td class="text-right">
										<div class="btn-group">
										  <button type="button" class="btn btn-info btn-sm" onclick="add_child('<?php echo $row_top?>');">添加子菜单</button>
										  <button type="button" class="btn btn-danger btn-sm" onclick="$('#menu-top-<?php echo $row_top?>').remove();$('.menu-top-<?php echo $row_top?>').remove();">删除</button>
										</div>
									</td>
									
								</tr>
								<?php endif;?>
								<?php $row_top++;?>
								<?php endforeach;?>
								<?php endif;?>
							</tbody>
							<tfoot>
								<tr>
									<td colspan="5" class="text-right"><button type="button" class="btn btn-info btn-sm" onclick="add_top();">添加一级菜单</button></td>
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
	<script type="text/javascript">
		var row_child = <?php echo $row_child + 1; ?>;
		function add_child(row_top){
			if($('.menu-top-'+row_top).length > 4){
				alert('最多添加5个子菜单');
			}else{
				add_child_html(row_top, row_child);
			}
			check_top(row_top);
			row_child++;
		}

		function check_top(row_top){
			if($('tbody tr').hasClass('menu-top-' + row_top)){
				$('tbody tr #menu-button-' + row_top + '-type').attr("disabled", "disabled");
				$('tbody tr #menu-button-' + row_top + '-key-url').attr("disabled", "disabled");
			}else{
				$('tbody tr #menu-button-' + row_top + '-type').removeAttr("disabled");
				$('tbody tr #menu-button-' + row_top + '-key-url').removeAttr("disabled");
			}
		}

		function add_child_html(row_top, row_child){
			html  = '<tr id="menu-top-' + row_top + row_child + '" class="menu-top-' + row_top + '">';
			html += '<td><input type="text" class="form-control menu-button-' + row_top + '-name" placeholder="一级菜单名" value="" disabled="disabled"></td>';
			html += '<td><input type="text" class="form-control" id="menu-button-' + row_top + '-sub_button-' + row_child + '-name" name="menu[button][' + row_top + '][sub_button][' + row_child + '][name]" placeholder="二级菜单名" value=""></td>';
			html += '<td>';
			html += '<select class="form-control" id="menu-button-' + row_top + '-sub_button-' + row_child + '-type" name="menu[button][' + row_top + '][sub_button][' + row_child + '][type]" onchange="change_child_key(\'' + row_top + ', \'' + row_child + '\');">';
			html += '<option value="">无事件的一级菜单</option>';
					<?php foreach ($action as $ke=>$va):?>
			html += '<option value="<?php echo $ke;?>"><?php echo $va;?></option>';
					<?php endforeach;?>
			html += '</select>';
			html += '</td>';
			html += '<td><input type="text" class="form-control" id="menu-button-' + row_top + '-sub_button-' + row_child + '-key-url" name="menu[button][' + row_top + '][sub_button][' + row_child + '][key]" placeholder="关键词/链接" value=""></td>';
				
			html += '<td class="text-right"><button type="button" class="btn btn-danger btn-sm" onclick="$(\'#menu-top-' + row_top + row_child + '\').remove();check_top(' + row_top + ');">删除</button></td>';
			html += '</tr>';

			if($('tbody tr').hasClass('menu-top-' + row_top)){
				$('.menu-top-' + row_top +':last').after(html);
			}else{
				$('#menu-top-' + row_top).after(html);
			}

			$('.menu-button-' + row_top + '-name').val($('#menu-button-' + row_top + '-name').val());
		}

		var row_top = <?php echo $row_top + 1;?>;
		function add_top(){
			if($('tbody .menu-top').length > 2){
				alert('最多添加3个一级菜单');
			}else{
				add_top_html(row_top);
			}
			row_top++;
		}

		function add_top_html(row_top){
			html  = '<tr style="background-color: #eee" id="menu-top-' + row_top + '" class="menu-top">';
			html += '<td colspan="2"><input type="text" onblur="change_topname(\'' + row_top + '\');" class="form-control" id="menu-button-' + row_top + '-name" name="menu[button][' + row_top + '][name]" placeholder="一级菜单名" value=""></td>';
			html += '<td>';
			html += '<select class="form-control" id="menu-button-' + row_top + '-type" name="menu[button][' + row_top + '][type]" onchange="change_top_key(\'' + row_top + '\');">';
			html += '<option value="">无事件的一级菜单</option>';
					<?php foreach ($action as $k=>$v):?>
			html += '<option value="<?php echo $k;?>"><?php echo $v;?></option>';
					<?php endforeach;?>
			html += '</select>';
			html += '</td>';
			html += '<td><input type="text" class="form-control" id="menu-button-' + row_top + '-key-url" name="menu[button][' + row_top + '][key]" placeholder="关键词/链接" value=""></td>';
			html += '<td class="text-right">';
			html += '<div class="btn-group">';
			html += '<button type="button" class="btn btn-info btn-sm" onclick="add_child(\'' + row_top + '\');">添加子菜单</button>';
			html += '<button type="button" class="btn btn-danger btn-sm" onclick="$(\'#menu-top-' + row_top + '\').remove();$(\'.menu-top-' + row_top + '\').remove();">删除</button>';
			html += '</div>';
			html += '</td>';
			html += '</tr>';

			if($('tbody tr').hasClass('menu-top')){
				$('tbody tr:last').after(html);
			}else{
				$('tbody').append(html);
			}
		}

		function change_topname(row_top){
			$('.menu-button-' + row_top + '-name').val($('#menu-button-' + row_top + '-name').val());
		}

		function change_top_key(row_top){
			if($('#menu-button-' + row_top + '-type').val() == 'view'){
				$('#menu-button-' + row_top + '-key-url').attr("name", "menu[button][" + row_top + "][url]");
			}else{
				$('#menu-button-' + row_top + '-key-url').attr("name", "menu[button][" + row_top + "][key]");
			}
		}

		function change_child_key(row_top, row_child){
			if($('#menu-button-' + row_top + '-sub_button-' + row_child + '-type').val() == 'view'){
				$('#menu-button-' + row_top + '-sub_button-' + row_child + '-key-url').attr("name", "menu[button][" + row_top + "][sub_button][" + row_child + "][url]");
			}else{
				$('#menu-button-' + row_top + '-sub_button-' + row_child + '-key-url').attr("name", "menu[button][" + row_top + "][sub_button][" + row_child + "][key]");
			}
		}
	</script>
</div>
<!-- /container -->
<?php echo $footer;//装载header?>