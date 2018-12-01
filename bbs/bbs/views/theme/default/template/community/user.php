<?php echo $header;//装载header?>
<?php echo $top;//装载top?>
<!-- /subnavbar -->
<div class="container">
	<div class="row"><?php echo $position_left;?>
  
		<?php if($position_left && $position_right):?>
		<?php $class = 'col-sm-6'; ?>
		<?php elseif($position_left || $position_right):?>
		<?php $class = 'col-sm-9'; ?>
		<?php else:?>
		<?php $class = 'col-sm-12'; ?>
		<?php endif;?>
	
		<div id="middle" class="<?php echo $class; ?> middle-flat-left">
			<?php echo $position_top; ?>
			
			<div class="text-center" style="position: relative;border-bottom: 1px solid rgb(230, 230, 230);">
				<?php if($this->user->isLogged()):?>
				<a href="<?php echo $this->config->item('catalog');?>/user" title="编辑个人信息">
				<?php else:?>
				<a>
				<?php endif;?>
    				<img src="<?php echo $this->image_common->resize($user['image'], 100, 100);?>" alt="<?php echo $user['nickname'];?>" class="img-circle" style="padding: 15px;max-width: 150px;">
    			</a>
    			<span style="position: relative;"><?php echo $user['nickname'];?></span>
    			<span style="position: relative; position: absolute; bottom: 10px;right:5px" class="btn btn-success btn-sm" onclick="add_attention('<?php echo $this->input->get('user_id');?>');">关注他/她<i class="glyphicon glyphicon-plus"></i></span>
    		</div>
			
			<div class="panel panel-default user-notice">
				<div class="well well-sm row" style="margin-left: 0;margin-right: 0;margin-bottom: 0">
					<div class="col-sm-3 hidden-xs">
						<div class="media">
							<div class="media-body">
								<p class="media-heading">昵称:<?php echo $user['nickname'];?></p>
								<?php $ds_time=timediff(human_to_unix($user['re_date']), human_to_unix(date("Y-m-d H:i:s")));?>
								<p class="media-heading">活跃于:<?php echo $ds_time['time'].$ds_time['unit'];?></p>
								<?php $rt_time=timediff(human_to_unix($user['date_added']), human_to_unix(date("Y-m-d H:i:s")));?>
								<p class="media-heading">注册于:<?php echo $rt_time['time'].$rt_time['unit'];?></p>
							</div>
						</div>
					</div>
					<div class="col-sm-3 col-xs-6">
						<h2 style="margin-bottom: 0;text-align: center;"><?php echo $user['bp_count'];?></h2>
						<p style="margin-bottom: 0;text-align: center;">帖子</p>
					</div>
					<div class="col-sm-3 col-xs-6">
						<h2 style="margin-bottom: 0;text-align: center;"><?php echo $user['re_count'];?></h2>
						<p style="margin-bottom: 0;text-align: center;">回复</p>
					</div>
					<div class="col-sm-3 hidden-xs">
						<span class="label label-default"><?php echo $user['user_group_name'];?></span>
						<span class="label label-default"><?php echo $user['user_class_name'];?></span>
					</div>
				</div>
			</div>
			
			<div id="load-user-for"></div>
			<div id="load-user-to"></div>
			
			<div class="panel panel-default">
			  <div class="panel-heading">
			  	<nav class="navbar" style="margin-bottom: 0;min-height: 10px">
				  <ul class="nav navbar-nav">
				    <li><a><?php echo $user['nickname'];?>的帖子</a></li>
				  </ul>
				</nav>
			  </div>
			  <div id="load-posting-list"></div>
			</div>
			
			<div class="panel panel-default">
			  <div class="panel-heading">
			  	<nav class="navbar" style="margin-bottom: 0;min-height: 10px">
				  <ul class="nav navbar-nav">
				    <li><a><?php echo $user['nickname'];?>关注的的帖子</a></li>
				  </ul>
				</nav>
			  </div>
			  <div id="load-posting-attention"></div>
			</div>
			
			<!-- /widget -->
			<?php echo $position_bottom; ?>
		</div>
		<?php echo $position_right; ?>
	</div>
	<!-- /row --> 
	<script type="text/javascript">
	  function add_attention(id){
	  var user_id = <?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '0';?>;
	  if(!user_id > 0){
		  $.notify({message: '请先登陆！'},{type: 'warning',offset: {x: 0,y: 52}});
		  return false;
	  }
	  
	  $.ajax({
			url: '<?php echo $this->config->item('bbs').'/community/user/add_attention';?>',
			type: 'post',
			dataType: 'json',
			data: {to_user_id: id},
			beforeSend: function()
			{
				NProgress.start();
			},
			complete: function()
			{
				NProgress.done();
			},
			success: function(data)
			{
				if(data.status == 'success'){
					$.notify({message: data.msg,},{type: 'success',offset: {x: 0,y: 52}});
					window.location.reload();
				}else{
					$.notify({message: data.msg },{type: 'warning',offset: {x: 0,y: 52}});
				}
			},
			error: function(xhr, ajaxOptions, thrownError)
			{
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	  }

  		//取消关注
		function unattention(id){
			$.ajax({
				url: '<?php echo $this->config->item('bbs').'/community/user/unattention';?>',
				type: 'post',
				dataType: 'json',
				data: {to_user_id: id},
				beforeSend: function()
				{
					NProgress.start();
				},
				complete: function()
				{
					NProgress.done();
				},
				success: function(data)
				{
					if(data.status == 'success'){
						$.notify({message: data.msg,},{type: 'success',offset: {x: 0,y: 52}});
						window.location.reload();
					}else{
						$.notify({message: data.msg },{type: 'warning',offset: {x: 0,y: 52}});
					}
				},
				error: function(xhr, ajaxOptions, thrownError)
				{
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		}
		
		$(document).ready(function (){
			$('#load-user-for').load("<?php echo $this->config->item('bbs').'/community/user/users_for?user_id='.$this->input->get('user_id');?>");
			$('#load-user-to').load("<?php echo $this->config->item('bbs').'/community/user/users_to?user_id='.$this->input->get('user_id');?>");
			$('#load-posting-list').load("<?php echo $this->config->item('bbs').'/community/user/user_posting?user_id='.$this->input->get('user_id');?>");
			$('#load-posting-attention').load("<?php echo $this->config->item('bbs').'/community/user/user_attention?user_id='.$this->input->get('user_id');?>");
		});
	</script>
</div>
<!-- /container -->
<?php echo $footer;//装载header?>