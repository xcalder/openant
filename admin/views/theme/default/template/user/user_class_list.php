<?php echo $header;//装载header?>
<?php echo $top;//装载login_top?>
<!-- /subnavbar -->
<div class="container">
  <div class="row">
    <div class="col-md-12 middle-flat-left" role="main">
      <div class="panel panel-default">
        <div class="panel-heading row row-panel-heading bg-info">
	        <p class="navbar-left"> <i class="glyphicon glyphicon-th-list"></i>&nbsp;买家组列表</p>
			<div class="navbar-right btn-group" style="margin-right: 0">
				<a href="<?php echo site_url('user/user_class/add')?>" class="btn btn-default"><i class="glyphicon glyphicon-plus"></i></a>
				<button type="button" class="btn btn-default" onclick="confirm('确定删除买家组吗？') ? $('#form-user-class').submit() : false;"><i class="glyphicon glyphicon-trash"></i></button>
			</div>
	    </div>
        <!-- /widget-header -->
            <div class="panel-body">
            	<form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-user-class">
					<table class="table">
						<thead>
							<tr>
								<th style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></th>
								<th>组名称</th>
								<th>排序</th>
								<th class="text-right">操作</th>
							</tr>
						</thead>
						<tbody>
							<?php if(isset($user_classs)):?>
							<?php foreach($user_classs as $user_class):?>
							<tr>
								<td class="text-center"><input type="checkbox" name="selected[]" value="<?php echo $user_class['user_class_id']; ?>" /></td>
								<td><?php echo $user_class['name'].'('.$user_class['description'].')';?></td>
								<td><?php echo $user_class['sort_order']?></td>
								<td class="text-right"><a href="<?php echo site_url('user/user_class/edit?user_class_id=').$user_class['user_class_id'];?>" class="btn btn-primary" data-container="body" data-toggle="popover" data-placement="top" data-content="编辑"><i class="glyphicon glyphicon-edit"></i></a></td>
							</tr>
							<?php endforeach;?>
							<?php endif;?>
						</tbody>
						<tfoot>
							<tr>
								<td colspan="4"><?php echo $pagination;?></td>
							</tr>
						</tfoot>
					</table>
				</form>
            </div>
            <!-- /widget-content --> 
      </div>
      <!-- /widget --> 
    </div>
  </div>
  <!-- /row --> 
</div>
<!-- /container -->
<?php echo $footer;?>