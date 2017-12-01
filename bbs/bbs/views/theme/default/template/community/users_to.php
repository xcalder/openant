<?php if($users):?>
<div class="panel panel-default">
  <div class="panel-heading">他/她关注的人<?php echo $count;?></div>
  	<div class="panel-body row">
  		<?php foreach ($users as $user):?>
  		<div class="col-sm-2 col-xs-6">
  			<div class="thumbnail">
  				<a href="<?php echo $this->config->item('bbs').'community/user?user_id='.$user['user_id'];?>" class="text-center" target="_blank">
		      		<img src="<?php echo $this->image_common->resize($user['image'], 50, 50);?>" alt="<?php echo $user['nickname'];?>" title="<?php echo $user['date_added'];?>" class="img-circle">
		      		<div><?php echo $user['nickname'];?></div>
		      	</a>
		      	<div class="text-center"><a class="btn btn-success btn-sm" onclick="u_unattention('<?php echo $user['user_id'];?>');">不再关注</i></a></div>
		    </div>
  		</div>
  		<?php endforeach;?>
  	</div>
  	<div class="panel-footer"><?php echo $pagination;?></div>
  </div>
  	<script type="text/javascript">
	  	$(document).ready(function (){
			$('.ajax-users li a').click(function(){
				NProgress.start();
				var href = $(this).attr('href');
				if(href != '' && href != null && href != 'unfind'){
					$('#load-user-list').load(href);
					NProgress.done();
				}
				return false;
			});
	  	});

	  //取消关注
		function u_unattention(id){
			$.ajax({
				url: '<?php echo $this->config->item('bbs').'community/user/unattention';?>',
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
  	</script>
<?php endif;?>