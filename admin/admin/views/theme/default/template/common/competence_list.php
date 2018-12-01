<?php echo $header;//装载header?>
<?php echo $top;//装载top?>
<!-- /subnavbar -->
<div class="container">
  <div class="row">
    <div class="col-md-12 middle-flat-left">
      <div class="panel panel-default">
        <div class="panel-heading row row-panel-heading bg-info">
	        <p class="navbar-left"> <i class="glyphicon glyphicon-th-list"></i>&nbsp;权限列表</p>
			<div class="navbar-right btn-group" style="margin-right: 0">
				<a href="<?php echo $this->config->item('admin').'/common/competence/add'?>" class="btn btn-sm btn-default"><i class="glyphicon glyphicon-plus"></i></a>
				<button type="button" class="btn btn-sm btn-default" onclick="confirm('确定删除权限吗？') ? $('#form-competence').submit() : false;"><i class="glyphicon glyphicon-trash"></i></button>
			</div>
	    </div>
        <!-- /widget-header -->
        <div class="panel-body">
        	<form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-competence">
			<table class="table">
				<thead>
					<tr>
						<th style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></th>
						<th>名称</th>
						<th>描述</th>
						<th class="text-right">操作</th>
					</tr>
				</thead>
				<tbody>
					<?php if(isset($competences)):?>
					<?php foreach($competences as $competence):?>
					<tr>
						<td class="text-center"><input type="checkbox" name="selected[]" value="<?php echo $competence['competence_id']; ?>" /></td>
						<td><?php echo $competence['title'];?></td>
						<td><?php echo $competence['description'];?></td>
						<td class="text-right"><a href="<?php echo $this->config->item('admin').'/common/competence/edit?competence_id='.$competence['competence_id'];?>" class="btn btn-sm btn-primary" data-container="body" data-toggle="popover" data-placement="top" data-content="编辑"><i class="glyphicon glyphicon-edit"></i></a></td>
					</tr>
					<?php endforeach;?>
					<?php endif;?>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="3"><?php echo !empty($pagination) ? $pagination : '';?></td>
						
						<td><div class="navbar-right pagination" style="margin-right: 0">共为你查询到&nbsp;<a><?php echo isset($count) ? $count : '0';?>条</a>&nbsp;记录</div></td>
					</tr>
				</tfoot>
			</table>
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
<?php echo $footer;//装载header?>