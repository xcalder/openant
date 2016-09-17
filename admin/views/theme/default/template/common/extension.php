<?php echo $header;//装载header?>
<?php echo $top;//装载top?>
<!-- /subnavbar -->
<div class="container">
	<div class="row">
		<div class="col-md-12 middle-flat-left">
			<div class="panel panel-default">
				<p class="panel-heading row row-panel-heading bg-info">
					<i class="glyphicon glyphicon-cog">
					</i>&nbsp;插件管理
				</p>
				<!-- /widget-header -->
				<div class="panel-body">
					<table class="table table-hover">
						<thead>
							<tr>
								<td>
									名称
								</td>
								<td class="text-right">
									操作
								</td>
							</tr>
						</thead>
						<tbody>
							<?php
							if(isset($extensions)):?>
							<?php
							foreach($extensions as $extension):?>
							<tr>
								<td>
									<?php echo $extension['name'];?>
								</td>
								<td class="text-right">
									<?php
									if(isset($extension['installed']) && $extension['installed'] == TRUE):?>
									<!--已经安装-->
									<a href="<?php echo $uninstall_action.'?extension='.$extension['code'];?>" class="btn btn-danger btn-sm" data-container="body" data-toggle="popover" data-placement="top" data-content="卸载">
										<i class="glyphicon glyphicon-minus-sign">
										</i>
									</a>
									<a href="<?php echo $extension['action'];?>" class="btn btn-primary btn-sm" data-container="body" data-toggle="popover" data-placement="top" data-content="配置">
										<i class="glyphicon glyphicon-pencil">
										</i>
									</a>
									<?php
									else:?>
									<!--未安装-->
									<a href="<?php echo $install_action.'?extension='.$extension['code'];?>" class="btn btn-success btn-sm" data-container="body" data-toggle="popover" data-placement="top" data-content="安装">
										<i class="glyphicon glyphicon-plus-sign">
										</i>
									</a>
									<a class="btn btn-primary btn-sm" data-container="body" data-toggle="popover" data-placement="top" data-content="配置" disabled="disabled">
										<i class="glyphicon glyphicon-pencil">
										</i>
									</a>
									<?php endif;?>
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