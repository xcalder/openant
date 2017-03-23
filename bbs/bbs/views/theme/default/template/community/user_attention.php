  <?php if($postings):?>
<div class="panel-body" id="posting-list">

	<ul>
    			<?php foreach($postings as $posting):?>
    		<?php $time=timediff((!empty($posting['re_date']) ? human_to_unix($posting['re_date']) : human_to_unix($posting['date_added'])), human_to_unix(date("Y-m-d H:i:s")));?>
		   	<li>
		   		<div class="col-sm-2 hidden-xs">
		   			<a href="<?php echo $this->config->item('bbs');?>/community/user?user_id=<?php echo $posting['user_id'];?>"><img class="img-circle" src="<?php echo $this->image_common->resize($posting['image'], 30, 30);?>" alt="<?php echo $posting['nickname'];?>" title="<?php echo $posting['nickname'];?>"></a>
		   			<strong class="text-primary hidden-xs" style="padding: 0 15px;font-weight: normal;"><span style="font-size: 24px;"><?php echo $posting['count'];?></span><span style="color: #868686;font-size: 22px">/</span><span style="color: #bfbfbf;font-size: 14px;"><?php echo $posting['access_count'];?></span></strong>
		   		</div>
		   		<div class="col-sm-8 col-xs-12">
		   			<?php if($this->user->isLogged() && $posting['user_id'] == $this->user->getId()):?>
		   			<a class="btn btn-success btn-sm" onclick="unattention('<?php echo $posting['posting_id']?>');">取消<i class="glyphicon glyphicon-minus"></i></a>
		   			<?php endif;?>
		   			<a><?php echo $posting['a_date_added'];?></a>|
			   		<a class="text-<?php echo $posting['label'];?>" href="<?php echo $this->config->item('bbs');?>?plate_id=<?php echo $posting['plate_id'];?>">[<?php echo $posting['plate_title'];?>]</a>&nbsp;<a href="<?php echo $this->config->item('bbs');?>/community/posting?posting_id=<?php echo $posting['posting_id'];?>" style="max-height: 15px;overflow: hidden;"><?php echo $posting['title'];?></a>
			   		<?php if($posting['very_good'] == '1'):?>
			   		<span class="text-primary">[精华]</span>
			   		<?php endif;?>
			   		<?php if($posting['is_top'] == '1'):?>
			   		<span class="text-danger">[置顶]</span>
			   		<?php endif;?>
		   		</div>
		   		<div class="col-sm-2 col-xs-12">
		   			<a class="hidden-xs info-right" href="<?php echo $this->config->item('bbs');?>/community/user?user_id=<?php echo $posting['re_user_id'];?>"><img class="img-circle" src="<?php echo $this->image_common->resize((!empty($posting['re_image']) ? $posting['re_image'] : $posting['image']), 25, 25);?>" alt="<?php echo (!empty($posting['re_nickname'])) ? $posting['re_nickname'] : $posting['nickname'];?>" title="<?php echo (!empty($posting['re_nickname'])) ? $posting['re_nickname'] : $posting['nickname'];?>" style="padding: 0"></a>
		   			
		   			<span class="visible-xs info-left"><?php echo $posting['nickname'];?></span>
		   			<span class="info-right"><?php echo $time['time'].$time['unit'];?></span>
		   		</div>
		   	</li>
		   	<?php endforeach;?>
		</ul>

</div>
<div class="panel-footer"><?php echo $pagination;?></div>

<script type="text/javascript">
//取消关注
function unattention(id){
	$.ajax({
		url: '<?php echo $this->config->item('bbs').'community/posting/unattention_position';?>',
		type: 'post',
		dataType: 'json',
		data: {posting_id: id},
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
			$('.ajax-attention li a').click(function(){
				NProgress.start();
				var href = $(this).attr('href');
				if(href != '' && href != null && href != 'unfind'){
					$('#load-posting-attention').load(href);
					NProgress.done();
				}
				return false;
			});
	  	});
  	</script>
<?php endif;?>