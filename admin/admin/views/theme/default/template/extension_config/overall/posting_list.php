<?php echo $header;//装载header?>
<?php echo $top;//装载top?>
<!-- /subnavbar -->
<div class="container">
	<div class="row">
		<div class="col-md-12 middle-flat-left">
			<div class="panel panel-default">
				<div class="panel-heading row row-panel-heading bg-info">
					<p class="navbar-left">
						<i class="glyphicon glyphicon-th-list">
						</i>&nbsp;帖子列表
					</p>
					<div class="navbar-right btn-group" style="margin-right: 0">
						<button type="button" class="btn btn-sm btn-default" onclick="confirm('确定删除帖子吗？') ? $('#form-posting').submit() : false;">
							<i class="glyphicon glyphicon-trash">
							</i>
						</button>
					</div>
				</div>
				<!-- /widget-header -->
				<div class="panel-body">
					<form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-posting">
					<table class="table table-hover">
						<thead>
							<tr>
								<td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
								<td>板块</td>
								<td>帖子标题</td>
								<td>发帖人</td>
								<td>显示</td>
								<td>发帖时间</td>
								<td>回帖数</td>
								<td>精华</td>
								<td class="text-right">操作</td>
							</tr>
						</thead>
						<tbody>
							<?php
							if($postings):?>
							<?php foreach($postings as $posting):?>
							<?php if($posting):?>
							<tr>
								<td class="text-center"><input type="checkbox" name="selected[]" value="<?php echo $posting['posting_id']; ?>" /></td>
								<td class="text-left"><?php echo $posting['plate_title'];?></td>
								<td class="text-left"><?php echo $posting['title'];?></td>
								<td class="text-left"><?php echo $posting['nickname'];?></td>
								<td class="text-left"><?php echo ($posting['is_view'] == '1') ? '是' : '否';?></td>
								<td class="text-left"><?php echo $posting['date_added'];?></td>
								<td class="text-left"><?php echo $posting['count'];?></td>
								<td class="text-left"><?php echo ($posting['very_good'] == '1') ? '是' : '否';?></td>
								<td class="text-right">
									<div class="btn-group">
									  <a href="<?php echo $this->config->item('admin').'extension_config/overall/posting/edit_show';?>?posting_id=<?php echo $posting['posting_id'];?>&is_view=<?php echo ($posting['is_view'] == '1') ? '0' : '1';?>" class="btn btn-danger btn-sm"><i class="<?php echo ($posting['is_view'] == '1') ? 'glyphicon glyphicon-eye-open' : 'glyphicon glyphicon-eye-close';?>"></i></a>
									  <a href="<?php echo $this->config->item('admin').'extension_config/overall/posting/edit_show';?>?posting_id=<?php echo $posting['posting_id'];?>&very_good=<?php echo ($posting['very_good'] == '1') ? '0' : '1';?>" class="btn btn-primary btn-sm"><i class="<?php echo ($posting['very_good'] == '1') ? 'glyphicon glyphicon-thumbs-up' : 'glyphicon glyphicon-thumbs-down';?>"></i></a>
									  <a href="<?php echo $this->config->item('admin').'extension_config/overall/posting/edit_show';?>?posting_id=<?php echo $posting['posting_id'];?>&is_top=<?php echo ($posting['is_top'] == '1') ? '0' : '1';?>" class="btn btn-info btn-sm"><i class="<?php echo ($posting['is_top'] == '1') ? 'glyphicon glyphicon-arrow-up' : 'glyphicon glyphicon-arrow-down';?>"></i></a>
									</div>
								</td>
							</tr>
							<?php endif;?>
							<?php endforeach;?>
							<?php endif;?>
						</tbody>
						<tfoot>
							<tr>
								<td colspan="5" class="text-left">
									<?php echo $pagination;?>
								</td>
								<td colspan="4" class="text-right">
									<p class="pagination">
										共为你找到&nbsp;
										<a>
											<?php echo $count;?>条
										</a>&nbsp;记录
									</p>
								</td>
							</tr>
						</tfoot>
					</table>
				</div>
				</form>
				<!-- /widget-content -->
			</div>
			<!-- /widget -->
		</div>
		<!-- /span12 -->
	</div>
	<!-- /row -->
</div>
<!-- /container -->
<?php echo $footer;//装载header?>