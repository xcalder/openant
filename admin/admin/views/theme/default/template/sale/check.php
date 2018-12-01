<?php echo $header;//装载header?>
<?php echo $top;//装载login_top?>
<!-- /subnavbar -->
<div class="container">
  <div class="row">
    <div class="col-md-12 middle-flat-left" role="main">
      <div class="panel panel-default">
        <p class="panel-heading row row-panel-heading bg-info"> <i class="glyphicon glyphicon-th-list"></i>&nbsp;商家列表</p>
        <!-- /widget-header -->
            <div class="panel-body">
				<table class="table">
					<thead>
						<tr>
							<td>名称</td>
							<td>昵称</td>
							<td>邮箱</td>
							<td>手机</td>
							<td>用户组</td>
							<td>商家组</td>
							<td>所在地</td>
							<td>状态</td>
							<td class="text-right">操作</td>
						</tr>
					</thead>
					<tbody>
						<?php if(isset($stores)):?>
						<?php foreach($stores as $store):?>
						<?php if(!empty($store)):?>
						<tr>
							<td><?php echo $store['store_name'];?></td>
							<td><?php echo $store['nickname'];?></td>
							<td><?php echo $store['email'];?></td>
							<td><?php echo $store['telephone'];?></td>
							<td><?php echo $store['name'];?></td>
							<td><?php echo $store['sale_class_name'];?></td>
							<td>所在地</td>
							<td><?php echo ($store['check'] == 1) ? '<span style="color:red">待审核</span>' : '';?></td>
							<td class="text-right"><button type="button" onclick="pass('<?php echo $store['store_id'];?>', '<?php echo $store['user_id'];?>');" class="btn btn-sm btn-success">通过</button></td>
						</tr>
						<?php endif;?>
						<?php endforeach;?>
						<?php endif;?>
					</tbody>
					<tfoot>
						<tr>
							<td colspan="7"><?php echo !empty($pagination) ? $pagination : '';?></td>
							<td colspan="4"><div class="navbar-right pagination" style="margin-right: 0">共为你查询到&nbsp;<a><?php echo isset($count) ? $count : '0';?>个</a>&nbsp;商家记录</div></td>
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

<script>     
function pass(store_id, user_id){
	$.ajax({
		url: '<?php echo $this->config->item('admin').'/sale/check/pass';?>',
		type: 'post',
		data: 'store_id=' + store_id + '&user_id=' + user_id,
		beforeSend: function() {
			NProgress.start();
		},
		complete: function() {
			NProgress.done();
		},
		success: function(){
			window.location.reload();//刷新当前页面.
		} 
	});
}
</script><!-- /Calendar -->
<?php echo $footer;?>