<?php echo $header;//装载header?>
<?php echo $top;//装载login_top?>
<!-- /subnavbar -->
<div class="container">
  <div class="row">
    <div class="col-md-12 middle-flat-left" role="main">
      <div class="panel panel-default">
      	<div class="panel-heading row row-panel-heading bg-info">
	        <p class="navbar-left"> <i class="glyphicon glyphicon-th-list"></i>&nbsp;会员列表</p>
			<div class="navbar-right btn-group" role="group" aria-label="..." style="margin-right: 0">
				<a href="<?php echo site_url('user/user/add')?>" class="btn btn-default"><i class="glyphicon glyphicon-plus"></i></a>
				<button type="button" class="btn btn-default"><i class="glyphicon glyphicon-trash"></i></button>
			</div>
	    </div>
        <!-- /widget-header -->
            <div class="panel-body">
            	<div class="well col-sm-12 user-list-search">
            		<form action="<?php echo $action;?>" method="get" enctype="multipart/form-data" id="form-user-list">
						<div class="form-group col-sm-3">
							<label for="nickname">昵称</label>
							<input type="text" name="nickname" class="form-control" id="nickname" placeholder="昵称" value="<?php echo isset($nickname) ? $nickname : '';?>">
							<?php echo isset($error['nickname']) ? '<label style="color:red">'.$error['nickname'].'</label>' : '';?>
						</div>
						<div class="form-group col-sm-3">
							<label for="user_group_id">会员组</label>
							<select name="user_group_id" class="form-control" id="user_group_id">
								<option value="">--无--</option>
								<?php if($user_groups):?>
								<?php foreach($user_groups as $user_group):?>
								<?php if(isset($user_group_id) && $user_group_id == $user_group['user_group_id']):?>
								<option value="<?php echo $user_group_id?>" selected><?php echo $user_group['name']?></option>
								<?php else:?>
								<option value="<?php echo $user_group['user_group_id']?>"><?php echo $user_group['name'];?></option>
								<?php endif;?>
								<?php endforeach;?>
								<?php endif;?>
							</select>
							<?php echo isset($error['user_group_id']) ? '<label style="color:red">'.$error['user_group_id'].'</label>' : '';?>
						</div>
						<div class="form-group col-sm-3">
							<label for="approved">批准</label>
							<select name="approved" class="form-control" id="approved">
								<option value="">--无--</option>
								<?php if(isset($approved) && $approved == '1'):?>
								<option value="1" selected>是</option>
								<option value="0">否</option>
								<?php elseif(isset($approved) && $approved == '0'):?>
								<option value="1">是</option>
								<option value="0" selected>否</option>
								<?php else:?>
								<option value="1">是</option>
								<option value="0">否</option>
								<?php endif;?>
							</select>
							<?php echo isset($error['approved']) ? '<label style="color:red">'.$error['approved'].'</label>' : '';?>
						</div>
						<div class="form-group col-sm-3">
							<label for="exampleInputEmail1">注册时间</label>
							<input type="text" name="date_added" class="form-control" id="date-added" placeholder="注册时间" value="<?php echo isset($date_added) ? $date_added : '';?>">
							<?php echo isset($error['date_added']) ? '<label style="color:red">'.$error['date_added'].'</label>' : '';?>
							<script type="text/javascript">  $("#date-added").datetimepicker({minView: "month",format: "yyyy-mm-dd",autoclose:true});</script>
						</div>
						<div class="form-group col-sm-3">
							<label for="email1">邮箱</label>
							<input type="text" name="email" class="form-control" id="email1" placeholder="Email" value="<?php echo isset($email) ? $email : '';?>">
							<?php echo isset($error['email']) ? '<label style="color:red">'.$error['email'].'</label>' : '';?>
						</div>
						<div class="form-group col-sm-3">
							<label for="status">状态</label>
							<select name="status" class="form-control" id="status">
								<option value="">--无--</option>
								<?php if(isset($status) && $status == '1'):?>
								<option value="1" selected>启用</option>
								<option value="0">停用</option>
								<?php elseif(isset($status) && $status == '0'):?>
								<option value="1">启用</option>
								<option value="0" selected>停用</option>
								<?php else:?>
								<option value="1">启用</option>
								<option value="0">停用</option>
								<?php endif;?>
							</select>
							<?php echo isset($error['status']) ? '<label style="color:red">'.$error['status'].'</label>' : '';?>
						</div>
						<div class="form-group col-sm-3">
							<label for="exampleInputEmail1">IP</label>
							<input name="ip" type="text" class="form-control" id="ip" placeholder="IP" value="<?php echo isset($ip) ? $ip : '';?>">
							<?php echo isset($error['ip']) ? '<label style="color:red">'.$error['ip'].'</label>' : '';?>
						</div>
						<div class="form-group col-sm-3">
							<label style="display: block">搜索</label>
							<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>">
							<button type="button" onclick="submit('form-user-list')" class="btn"><i class="glyphicon glyphicon-search"></i>&nbsp;搜索</button>
						</div>
            		
            		</form>
            	</div>
				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
							<td>昵称</td>
							<td>邮箱</td>
							<td>群组</td>
							<td>状态</td>
							<td>IP</td>
							<td>注册日期</td>
							<td class="text-right">操作</td>
						</tr>
					</thead>
					<tbody>
						<?php if($users):?>
						<?php foreach($users as $user):?>
						<tr>
							<td class="text-center"><input type="checkbox" name="selected[]" value="<?php echo $user['user_id']; ?>" /></td>
							<td><?php echo $user['nickname']?></td>
							<td><?php echo $user['email']?></td>
							<td><?php echo $user['name']?></td>
							<td><?php echo $user['status'] == TRUE ? '启用' : '禁用';?></td>
							<td><?php echo $user['ip']?></td>
							<td><?php echo $user['date_added']?></td>
							<td class="text-right">
								<?php if($user['status'] == TRUE):?>
								<button type="button" class="btn btn-success btn-sm" data-container="body" data-toggle="popover" data-placement="top" data-content="启用" disabled="disabled"><i class="glyphicon glyphicon-ok-circle"></i></button>
								<?php else:?>
								<button type="button" class="btn btn-success  btn-sm" data-container="body" data-toggle="popover" data-placement="top" data-content="启用"><i class="glyphicon glyphicon-ok-circle"></i></button>
								<?php endif;?>
								
								<?php if($user['status'] == TRUE):?>
								<button type="button" class="btn btn-warning  btn-sm" data-container="body" data-toggle="popover" data-placement="top" data-content="禁止登陆"><i class="glyphicon glyphicon-off"></i></button>
								<?php else:?>
								<button type="button" class="btn btn-warning  btn-sm" data-container="body" data-toggle="popover" data-placement="top" data-content="禁止登陆" disabled="disabled"><i class="glyphicon glyphicon-off"></i></button>
								<?php endif;?>
								
								<a href="<?php echo site_url('user/user/edit?user_id=').$user['user_id'];?>" class="btn btn-primary  btn-sm" data-container="body" data-toggle="popover" data-placement="top" data-content="编辑"><i class="glyphicon glyphicon-edit"></i></a>
							</td>
						</tr>
						<?php endforeach;?>
						<?php endif;?>
					</tbody>
					<tfoot>
						<tr>
							<td colspan="8"><?php echo $pagination;?></td>
						</tr>
					</tfoot>
				</table>
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