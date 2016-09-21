<?php echo $header;//装载header?>
<?php echo $top;//装载login_top?>
<!-- /subnavbar -->
<div class="container">
  <div class="row">
    <div class="col-md-12 middle-flat-left" role="main">
      <div class="panel panel-default">
        <p class="panel-heading row row-panel-heading bg-info"> <i class="glyphicon glyphicon-th-list"></i>&nbsp;&nbsp;在线会员</p>
        <!-- /widget-header -->
            <div class="panel-body">
				<table class="table">
					<thead>
						<tr>
							<td>IP</td>
							<td>用户昵称</td>
							<td>操作</td>
						</tr>
					</thead>
					<tbody>
						<?php if($user_onlines):?>
						<?php foreach($user_onlines as $key=>$user_online):?>
						<tr>
							<td><?php echo $user_online['ip']?></td>
							<td><?php echo isset($user_online['nickname']) ? $user_online['nickname'] : '游客';?></td>
							<?php if(isset($user_ban_ip) && in_array($user_online['ip'],$user_ban_ip)):?>
							<td class="text-right"><button onclick="add_ban_ip('<?php echo $user_online['ip'];?>','add-ban-ip<?php echo $key;?>');" type="button" id="add-ban-ip<?php echo $key;?>" class="btn btn-success" disabled="disabled">加入黑名单</button></td>
							<?php else:?>
							<td class="text-right"><button onclick="add_ban_ip('<?php echo $user_online['ip'];?>','add-ban-ip<?php echo $key;?>');" type="button" id="add-ban-ip<?php echo $key;?>" class="btn btn-success">加入黑名单</button></td>
							<?php endif;?>
						</tr>
						<?php endforeach;?>
						<?php endif;?>
					</tbody>
					<tfoot>
						<td colspan="3"><?php echo isset($pagination) ? $pagination : '';?></td>
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
	function add_ban_ip(ip,id){
	$.ajax({
		url: '<?php echo site_url();?>/user/user/add_ban_ip.html',
		type: 'post',
		data: 'ip=' + ip,
		beforeSend: function() {
			NProgress.start();
		},
		complete: function() {
			NProgress.done();
		},
		success: function(){
			$('#'+id).attr({"disabled":"disabled"});
		} 
	});
}
</script>
<?php echo $footer;?>