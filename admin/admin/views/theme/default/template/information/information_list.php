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
						</i>&nbsp;文章列表
					</p>
					<div class="navbar-right btn-group" style="margin-right: 0">
						<a href="<?php echo $this->config->item('admin').'/information/information/add'?>" class="btn btn-sm btn-default">
							<i class="glyphicon glyphicon-plus">
							</i>
						</a>
						<button type="button" class="btn btn-sm btn-default" onclick="confirm('确定删除文章吗？') ? $('#form-information').submit() : false;">
							<i class="glyphicon glyphicon-trash">
							</i>
						</button>
					</div>
				</div>
				<!-- /widget-header -->
				<div class="panel-body">
					<form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-information">
					<table class="table table-hover">
						<thead>
							<tr>
								<th style="width: 1px;" class="text-center">
									<input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" />
								</th>
								<th>
									文章名称
								</th>
								<th>
									排序
								</th>
								<th class="text-right">
									编辑
								</th>
							</tr>
						</thead>
						<tbody>
							<?php
							if($informations):?>
							<?php
							foreach($informations as $information):?>
							<tr>
								<td class="text-center">
									<input type="checkbox" name="selected[]" value="<?php echo $information['information_id']; ?>" />
								</td>
								<td class="text-left">
									<?php echo $information['title'];?>
								</td>
								<td class="text-left">
									<?php echo $information['sort_order'];?>
								</td>
								<td class="text-right">
									<a href="<?php echo $this->config->item('admin').'/information/information/edit?information_id='.$information['information_id']?>" class="btn btn-sm btn-info">
										<i class="glyphicon glyphicon-edit">
										</i>
									</a>
								</td>
							</tr>
							<?php endforeach;?>
							<?php endif;?>
						</tbody>
						<tfoot>
							<tr>
								<td colspan="2" class="text-left">
									<?php echo $pagination;?>
								</td>
								<td colspan="2" class="text-right">
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