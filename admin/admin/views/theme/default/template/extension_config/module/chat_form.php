<?php echo $header;//装载header?>
<?php echo $top;//装载top?>
<!-- /subnavbar -->
<div class="container">
	<div class="row">
		<div class="col-md-12 middle-flat-left">
			<div class="panel panel-default">
				<div class="panel-heading row row-panel-heading bg-info">
					<p class="navbar-left"><i class="glyphicon glyphicon-edit"></i>&nbsp;编辑<?php echo isset($module) ? $module['name'] : 'module';?></p>
					<div class="navbar-right btn-group" style="margin-right: 0">
						<button type="button" onclick="submit('form-module')" class="btn btn-sm btn-default"><i class="glyphicon glyphicon-floppy-save"></i></button>
						<a href="<?php echo $this->config->item('admin').'/extension_config/module/chat';?>" class="btn btn-sm btn-default"><i class="glyphicon glyphicon-share-alt"></i></a>
					</div>
				</div>
				<!-- /widget-header -->
				<div class="panel-body page-tab">
					<form action="<?php echo $action;?>" method="post" enctype="multipart/form-data" id="form-module" class="form-horizontal">
						<div class="form-group">
							<label class="col-sm-2 control-label" for="name">模块名称</label>
							<div class="col-sm-10">
								<input type="text" name="name" id="name" class="form-control" placeholder="模块名称" value="<?php echo isset($module) ? $module['name'] : '';?>">
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-2 control-label">显示名称</label>
							<div class="col-sm-10">
								<?php foreach($languages as $language):?>
								<div class="input-group">
								  <span class="input-group-addon"><img width="16px" height="11px" class="lazy" data-original="resources/public/flags/<?php echo $language['image']?>"></span>
								  <input type="text" name="setting[name][<?php echo $language['language_id']?>]" class="form-control" placeholder="模块名称" value="<?php echo isset($module['setting']['name'][$language['language_id']]) ? $module['setting']['name'][$language['language_id']] : '';?>">
								</div>
								<?php endforeach;?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">显示位置</label>
							<div class="col-sm-10">
								<?php if(isset($module['setting']['position']) && $module['setting']['position'] == 'left'):?>
								<label class="radio-inline">
								  <input type="radio" name="setting[position]" value="left" checked>左
								</label>
								<label class="radio-inline">
								  <input type="radio" name="setting[position]" value="right">右
								</label>
								<?php elseif(isset($module['setting']['position']) && $module['setting']['position'] == 'right'):?>
								<label class="radio-inline">
								  <input type="radio" name="setting[position]" value="left">左
								</label>
								<label class="radio-inline">
								  <input type="radio" name="setting[position]" value="right" checked>右
								</label>
								<?php else:?>
								<label class="radio-inline">
								  <input type="radio" name="setting[position]" value="left" checked>左
								</label>
								<label class="radio-inline">
								  <input type="radio" name="setting[position]" value="right">右
								</label>
								<?php endif;?>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-2 control-label">文字内容</label>
							<div class="col-sm-10">
								<table class="table table-bordered">
									<thead>
										<tr><td colspan="3">中间内容</td></tr>
										<tr>
											<?php foreach($languages as $language):?>
											<td><img width="16px" height="11px" class="lazy" data-original="resources/public/flags/<?php echo $language['image']?>"></td>
											<?php endforeach;?>
											<td>操作</td>
										</tr>
									</thead>
									<tbody>
										<?php $row_id=0;?>
										<?php if(isset($module['setting']['content']) && is_array($module['setting']['content'])):?>
										<?php foreach ($module['setting']['content'] as $key=>$content):?>
										<tr id="chat-<?php echo $row_id;?>">
											<?php foreach($languages as $language):?>
											<td>
												
												<a href="" id="thumb-image<?php echo $row_id.'-'.$language['language_id'];?>" data-toggle="admin-image" class="img-thumbnail">
													<img width="100px" height="100px" class="lazy" data-original="<?php echo !empty($module['setting']['content'][$key][$language['language_id']]['image']) ? $this->image_common->resize($module['setting']['content'][$key][$language['language_id']]['image'], 100, 100) : $placeholder_image;?>" data-placeholder="<?php echo $placeholder_image;?>" />
												</a>
												<input type="hidden" name="setting[content][<?php echo $row_id;?>][<?php echo $language['language_id']?>][image]" value="<?php echo isset($module['setting']['content'][$key][$language['language_id']]['image']) ? $module['setting']['content'][$key][$language['language_id']]['image'] : '';?>" id="input-image<?php echo $row_id.'-'.$language['language_id'];?>" />
												
												<input type="text" name="setting[content][<?php echo $row_id;?>][<?php echo $language['language_id']?>][title]" class="form-control" placeholder="文字描述" value="<?php echo isset($module['setting']['content'][$key][$language['language_id']]['title']) ? $module['setting']['content'][$key][$language['language_id']]['title'] : '';?>">
												<input type="text" name="setting[content][<?php echo $row_id;?>][<?php echo $language['language_id']?>][url]" class="form-control" placeholder="链接" value="<?php echo isset($module['setting']['content'][$key][$language['language_id']]['url']) ? $module['setting']['content'][$key][$language['language_id']]['url'] : '';?>">
											</td>
											<?php endforeach;?>
											<td><button type="button" class="btn btn-danger btn-sm" onclick="$('#chat-<?php echo $row_id?>').remove();">删除</button></td>
										</tr>
										<?php $row_id++;?>
										<?php endforeach;?>
										<?php endif;?>
									</tbody>
									<tfoot>
										<tr>
											<td colspan="3" class="text-right"><button type="button" onclick="add_chat();" class="btn btn-primary btn-sm">添加</button></td>
										</tr>
									</tfoot>
								</table>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="status">状态</label>
							<div class="col-sm-10">
								<select name="setting[status]" id="status" class="form-control">
								<?php if(isset($module) && $module['setting']['status'] == '1'):?>
								<option value="1" selected>启用</option>
								<option value="0">停用</option>
								<?php else:?>
								<option value="1">启用</option>
								<option value="0" selected>停用</option>
								<?php endif;?>
								</select>
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
	<script type="text/javascript">
		var row_id=<?php echo $row_id?>;
		function add_chat(){
			if($('tbody').children('tr').length > 3){
				alert('中间内容最多4个');
				return false;
			}
			var html  = '<tr id="chat-'+row_id+'">';
						<?php foreach($languages as $language):?>
				html += '<td>';
				html += '<a href="" id="thumb-image'+row_id+'-'+<?php echo $language['language_id']?>+'" data-toggle="admin-image" class="img-thumbnail">';
				html += '<img width="100px" height="100px" class="lazy" src="<?php echo $placeholder_image;?>"/>';
				html += '</a>';
				html += '<input type="hidden" name="setting[content]['+row_id+'][<?php echo $language['language_id']?>][image]" value="" id="input-image'+row_id+'-<?php echo $language['language_id']?>" />';
			
				html += '<input type="text" name="setting[content]['+row_id+'][<?php echo $language['language_id']?>][name]" class="form-control" placeholder="客服名称" value="">';
				html += '<input type="text" name="setting[content]['+row_id+'][<?php echo $language['language_id']?>][url]" class="form-control" placeholder="链接" value="">';
						<?php endforeach;?>
				html += '<td><button type="button" class="btn btn-danger btn-sm" onclick="$(\'#chat-'+row_id+'\').remove();">删除</button></td>';
				html += '</tr>';

				$('tbody').append(html);
				
			row_id++;
		}
	</script>
	<!-- /row -->
</div>
<!-- /container -->
<?php echo $footer;//装载header?>