<?php echo $header;//装载header?>
<?php echo $top;//装载top?>
<!-- /subnavbar -->
<div class="container">
	<div class="row">
		<div class="col-md-12 middle-flat-left">
			<div class="panel panel-default">
				<div class="panel-heading row row-panel-heading bg-info">
					<p class="navbar-left"><i class="glyphicon glyphicon-cog"></i>&nbsp;模块名称</p>
					<div class="navbar-right btn-group" style="margin-right: 0">
						<a href="<?php echo site_url('extension_config/module/Will_move_text/add');?>" class="btn btn-default"><i class="glyphicon glyphicon-plus"></i></a>
						<a href="<?php echo site_url('common/extension/module');?>" class="btn btn-default"><i class="glyphicon glyphicon-share-alt"></i></a>
					</div>
				</div>
				<!-- /widget-header -->
				<div class="panel-body">
					<table class="table table-hover">
						<thead>
							<tr>
								<th>
									名称
								</th>
								<th class="text-right">
									操作
								</th>
							</tr>
						</thead>
						<tbody>
							<?php
							if($modules):?>
							<?php foreach($modules as $module):?>
							<tr>
								<td><?php echo $module['name'];?></td>
								<td class="text-right">
									<a href="<?php echo site_url('extension_config/module/Will_move_text/delete?module_id=').$module['module_id'];?>" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="top" data-content="删除">
										<i class="glyphicon glyphicon-minus"></i>
									</a>
									<a href="<?php echo site_url('extension_config/module/Will_move_text/edit?module_id=').$module['module_id'];?>" class="btn btn-primary" data-container="body" data-toggle="popover" data-placement="top" data-content="编辑">
										<i class="glyphicon glyphicon-edit"></i>
									</a>
								</td>
							</tr>
							<?php endforeach;?>
							<?php endif;?>
						</tbody>
					</table>
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
<?php echo $footer;//装载header?>