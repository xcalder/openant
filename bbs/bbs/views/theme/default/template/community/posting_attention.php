<?php if($users):?>
  <div class="panel-heading">关注人数<?php echo $count;?></div>
  	<div class="panel-body row">
  		<?php foreach ($users as $user):?>
  		<div class="col-sm-2 col-xs-6">
  			<div class="thumbnail">
  				<a href="<?php echo $this->config->item('bbs').'/community/user?user_id='.$user['user_id'];?>" class="text-center" target="_blank">
		      		<img src="<?php echo $this->image_common->resize($user['image'], 50, 50);?>" alt="<?php echo $user['nickname'];?>" title="<?php echo $user['date_added'];?>" class="img-circle">
		      		<div><?php echo $user['nickname'];?></div>
		      	</a>
		    </div>
  		</div>
  		<?php endforeach;?>
  	</div>
  	<?php echo $pagination;?>
  	<script type="text/javascript">
	  	$(document).ready(function (){
			$('.posting-attention li a').click(function(){
				NProgress.start();
				var href = $(this).attr('href');
				if(href != '' && href != null && href != 'unfind'){
					$('#posting-attention').load(href);
					NProgress.done();
				}
				return false;
			});
	  	});
  	</script>
<?php endif;?>