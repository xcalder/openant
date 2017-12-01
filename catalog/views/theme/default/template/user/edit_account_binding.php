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
			<table class="table table-bordered table-striped">
			  <thead>
			  	<?php if(empty($user['password'])):?>
			  	<tr>
			  		<td colspan="4">你还没有为你的帐号设置密码，你可以<a href="#">点此设置</a></td>
			  	</tr>
			  	<?php endif;?>
			  	<tr>
			  		<td colspan="4">帐号绑定</td>
			  	</tr>
			  	<tr>
			  		<td>帐号</td>
			  		<td>第三方帐号</td>
			  		<td>绑定日期</td>
			  		<td>操作</td>
			  	</tr>
			  </thead>
			  <tbody>
			  	<?php if($sgin_withs):?>
			  	<?php foreach ($sgin_withs as $k=>$v):?>
			  		<?php $withs_=false;?>
				  	<?php if(isset($withs) && $withs == true):?>
			  		<?php foreach ($withs as $key=>$with):?>
			  		<?php if($withs[$key]['via'] == $k):?>
			  		<?php $withs_=$withs[$key];?>
			  		<?php endif;?>
			  		<?php endforeach;?>
			  		<?php endif;?>
			  	<tr>
			  		<td><img src="<?php echo $this->image_common->resize($user['image'], 40, 40);?>" alt="<?php echo $user['nickname'];?>" class="img-circle"><?php echo $user['nickname'];?></td>
			  		<td><img src="<?php echo '/resources/public/resources/default/image/login_ico/'. $v['setting']['image'];?>" alt="<?php echo $k;?>" class="img-circle"><?php echo $k;?>
			  		
			  		<?php if($withs_):?>
			  		<i class="glyphicon glyphicon-saved"></i>
			  		<img src="<?php echo $this->image_common->resize($withs_['image'], 40, 40);?>" alt="<?php echo $k;?>" class="img-circle"><?php echo $withs_['nickname'];?>
			  		</td>
			  		<td><?php echo $withs_['date_added'];?></td>
			  		<td><a href="javascript:;" class="btn btn-warning btn-sm" onclick="unbundling('<?php echo $k;?>');">解绑<?php echo $k;?>帐号</a></td>
			  		<?php else:?>
			  		</td>
			  		<td>————</td>
			  		<td><a href="javascript:;" onclick="with_login('<?php echo $k;?>');" class="btn btn-success btn-sm">绑定<?php echo $k;?>帐号</a></td>
			  		<?php endif;?>
			  	</tr>
			  	<?php endforeach;?>
			  	<?php endif;?>
			  </tbody>
			  <tfoot>
			  	<tr>
			  		<td colspan="4">提示：第三方帐号绑定后，可以通过第三方帐号一键登陆本网站！</td>
			  	</tr>
			  </tfoot>
			</table>
			<!-- /widget -->
			<?php echo $position_bottom; ?>
		</div>
		<?php echo $position_right; ?>
	</div>
	<script type="text/javascript">
	//第三方登陆
	function with_login(key){
		window.open ('<?php echo $this->config->item('catalog');?>/user/sns/session/'+key,'newwindow','height=400,width=400,top=0,left=0,toolbar=no,menubar=no,scrollbars=no, resizable=no,location=no, status=no');
	}

	function unbundling(key){
		$.ajax({
			url: '<?php echo $this->config->item('catalog').'user/edit/unbundling';?>',
			type: 'post',
			dataType: 'json',
			data: {via: key, nickname: '<?php echo $user['nickname']?>'},
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
				if(data.success){
					$.notify({message: name + data.success,},{type: 'success',offset: {x: 0,y: 52}});
					window.location.reload();
				}else{
					$.notify({message: name + data.error },{type: 'warning',offset: {x: 0,y: 52}});
				}
		
			},
			error: function(xhr, ajaxOptions, thrownError)
			{
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	}
	</script>
	<!-- /row --> 
</div>
<!-- /container -->
<?php echo $footer;//装载header?>