<?php echo $header;//装载header?>
<?php echo $top;//装载top?>
<!-- /subnavbar -->
<div class="container">
  <div class="row"><?php echo $position_left;?>
	<?php if ($position_left && $position_right):?>
	<?php $class = 'col-sm-6'; ?>
	<?php elseif ($position_left || $position_right):?>
	<?php $class = 'col-sm-9'; ?>
	<?php else:?>
	<?php $class = 'col-sm-12'; ?>
	<?php endif;?>
    <div id="middle" class="<?php echo $class; ?>">
	    <?php echo $position_top; ?>
	    <div class="col-sm-12" style="padding: 0">
		    <div class="panel panel-default" id="posting-content">
			  <div class="panel-heading">
			  	
			  	<div class="media">
				  <div class="media-right" style="float: right">
				  	<?php if($posting['is_attention'] > 0):?>
				  	<span class="btn btn-success btn-sm" onclick="unattention();">取消关注<i class="glyphicon glyphicon-minus"></i></span>
				  	<?php else:?>
				  	<span class="btn btn-success btn-sm" onclick="add_attention();">关注<i class="glyphicon glyphicon-plus"></i></span>
				  	<?php endif;?>
				  	&nbsp;
				    <a href="<?php echo $this->config->item('bbs').'/community/user?user_id='.$posting['user_id'];?>"><img class="img-circle" src="<?php echo $this->image_common->resize($posting['image'], 60, 60);?>" alt="<?php echo $posting['nickname'];?>"></a>
				  </div>
				  <div class="media-body">
				    <h1 class="media-heading"><?php echo $posting['title'];?></h1>
				    
				    <?php $time=timediff(human_to_unix($posting['date_added']), human_to_unix(date("Y-m-d H:i:s")));?>
				    
				   	 访问:<a><?php echo $posting['access_count'];?></a>
			  		回复:<a><?php echo $posting['count'];?></a>
			  		关注:<a><?php echo $posting['attentions'];?></a>
			  		<br/>
			  		
			  		板块:<a href="<?php echo $this->config->item('bbs').'/?plate_id='.$posting['plate_id'];?>"><?php echo $posting['plate_title'];?></a>
			  		由:<a href="<?php echo $this->config->item('bbs').'/community/user?user_id='.$posting['user_id'];?>"><?php echo $posting['nickname'];?></a>
			  		发布于:<a><?php echo $time['time'].$time['unit'];?></a>
			  		
			  		<!--最新回复时间-->
			  		<?php if($posting['replies']):?>
			  		<?php if($posting['replies'][0]['discuss']):?>
			  		<?php $re_time=timediff(human_to_unix($posting['replies'][0]['discuss'][0]['date_added']), human_to_unix(date("Y-m-d H:i:s")));?>
			  		最后回复:<a href="<?php echo $this->config->item('bbs').'/community/user?user_id='.$posting['replies'][0]['discuss'][0]['user_id'];?>"><?php echo $posting['replies'][0]['discuss'][0]['nickname'];?></a>
			  		于:<a><?php echo $re_time['time'].$re_time['unit'];?></a>
			  		<?php else:?>
			  		<?php $re_time=timediff(human_to_unix($posting['replies'][0]['date_added']), human_to_unix(date("Y-m-d H:i:s")));?>
			  		最后回复:<a href="<?php echo $this->config->item('bbs').'/community/user?user_id='.$posting['replies'][0]['user_id'];?>"><?php echo $posting['replies'][0]['nickname'];?></a>
			  		于:<a><?php echo $re_time['time'].$re_time['unit'];?></a>
			  		<?php endif;?>
			  		<?php endif;?>
			  		<!--最新回复时间-->
				  </div>
				</div>
			  </div>
			  <div class="panel-body">
			    <?php echo str_ireplace('href="', 'href="'.base_url('errors/page_missing/go_to?go_to='), $posting['description']);?>
			  </div>
			</div>
		</div>
		
		<div class="col-sm-12" style="padding: 0">
		
			<div class="panel panel-default" id="posting-attention"></div>
			
			<div class="panel panel-default" id="posting-replies">
			  <div class="panel-heading">回复数量<?php echo $posting['count'];?></div>
			  <div class="panel-body">
				<?php if($posting['replies']):?>
				<?php foreach($posting['replies'] as $replie):?>
				<div class="media">
					<a href="<?php echo $this->config->item('bbs').'/community/user?user_id='.$replie['user_id'];?>" class="media-left media-middle"><img class="img-circle" src="<?php echo $this->image_common->resize($replie['image'], 30, 30);?>" alt="<?php echo $replie['nickname'];?>" title="<?php echo $replie['nickname'];?>"></a>
				  <div class="media-body">
					<?php $re_time=timediff(human_to_unix($replie['date_added']), human_to_unix(date("Y-m-d H:i:s")));?>
					<p class="media-heading" style="color: #b3b3b3;"><a href="<?php echo $this->config->item('bbs').'/community/user?user_id='.$replie['user_id'];?>" style="color: #b3b3b3;"><?php echo $replie['nickname'];?></a>&nbsp;<span><?php echo $re_time['time'].$re_time['unit'];?></span><span style="float: right;cursor: pointer;" onclick="click_scroll('<?php echo $replie['nickname']?>', '<?php echo $replie['replies_id']?>');"><i class="glyphicon glyphicon-pencil"></i></span></p>
					<?php echo str_ireplace('href="', 'href="'.base_url('errors/page_missing/go_to?go_to='), $replie['content']);?>
					
					<!--回帖讨论-->
					<?php if($replie['discuss']):?>
					<?php foreach($replie['discuss'] as $discuss):?>
					<hr>
					<div class="media">
						
						<?php if($replie['user_id'] != $discuss['user_id']):?>
						<a href="<?php echo $this->config->item('bbs').'/community/user?user_id='.$discuss['user_id'];?>" class="media-left media-middle"><img class="img-circle" src="<?php echo $this->image_common->resize($discuss['image'], 30, 30);?>" alt="<?php echo $discuss['nickname'];?>" title="<?php echo $discuss['nickname'];?>"></a>
					  <div class="media-body">
						<?php $ds_time=timediff(human_to_unix($discuss['date_added']), human_to_unix(date("Y-m-d H:i:s")));?>
						<p class="media-heading" style="color: #b3b3b3;"><a href="<?php echo $this->config->item('bbs').'/community/user?user_id='.$discuss['user_id'];?>" style="color: #b3b3b3;"><?php echo $discuss['nickname'];?></a>&nbsp;<span><?php echo $ds_time['time'].$ds_time['unit'];?></span></p>
						<?php echo str_ireplace('href="', 'href="'.base_url('errors/page_missing/go_to?go_to='), $discuss['content']);?>
					  </div>
					  <?php else:?>
					  <div class="media-body" style="padding-left: 15px">
						<?php $ds_time=timediff(human_to_unix($discuss['date_added']), human_to_unix(date("Y-m-d H:i:s")));?>
						<p class="media-heading" style="color: #b3b3b3;"><a href="<?php echo $this->config->item('bbs').'/community/user?user_id='.$discuss['user_id'];?>" style="color: #b3b3b3;"><?php echo $discuss['nickname'];?></a>&nbsp;<span><?php echo $ds_time['time'].$ds_time['unit'];?></span></p>
						<?php echo str_ireplace('href="', 'href="'.base_url('errors/page_missing/go_to?go_to='), $discuss['content']);?>
					  </div>
					   <a href="<?php echo $this->config->item('bbs').'/community/user?user_id='.$discuss['user_id'];?>" class="media-left media-middle"><img class="img-circle" src="<?php echo $this->image_common->resize($discuss['image'], 30, 30);?>" alt="<?php echo $discuss['nickname'];?>" title="<?php echo $discuss['nickname'];?>"></a>
					  <?php endif;?>
					</div>
					<?php endforeach;?>
					<?php endif;?>
					<!--回帖讨论-->
					
				  </div>
				</div><hr>
				<?php endforeach;?>
				<?php endif;?>
				
				<?php echo $pagination;?>
				
			  </div>
			</div>
		</div>
		
		<div class="col-sm-12" style="padding: 0">
			<div class="panel panel-default">
				<div class="panel-heading padding-left">相关推荐</div>
				<div class="panel-body" id="posting-list">
					<ul>
					   	<?php if($about_postings):?>
			    		<?php foreach($about_postings as $posting):?>
			    		<?php $time=timediff((!empty($posting['re_date']) ? human_to_unix($posting['re_date']) : human_to_unix($posting['date_added'])), human_to_unix(date("Y-m-d H:i:s")));?>
					   	<li>
					   		<div class="col-sm-2 hidden-xs" style="display: flex;">
					   			<a href="<?php echo $this->config->item('bbs');?>community/user?user_id=<?php echo $posting['user_id'];?>"><img class="img-circle" src="<?php echo $this->image_common->resize($posting['image'], 30, 30);?>" alt="<?php echo $posting['nickname'];?>" title="<?php echo $posting['nickname'];?>"></a>
					   			<strong class="text-primary hidden-xs" style="padding: 0 15px;font-weight: normal;"><span style="font-size: 24px;"><?php echo $posting['count'];?></span><span style="color: #868686;font-size: 22px">/</span><span style="color: #bfbfbf;font-size: 14px;"><?php echo $posting['access_count'];?></span></strong>
					   		</div>
					   		<div class="col-sm-8 col-xs-12">
						   		<a class="text-<?php echo $posting['label'];?>" href="<?php echo $this->config->item('bbs');?>?plate_id=<?php echo $posting['plate_id'];?>">[<?php echo $posting['plate_title'];?>]</a>&nbsp;<a href="<?php echo $this->config->item('bbs');?>community/posting?posting_id=<?php echo $posting['posting_id'];?>" style="max-height: 15px;overflow: hidden;"><?php echo isset($search) ? highlight_phrase($posting['title'], $search) : $posting['title'];?></a>
						   		<?php if($posting['very_good'] == '1'):?>
						   		<span class="text-primary">[精华]</span>
						   		<?php endif;?>
						   		<?php if($posting['is_top'] == '1'):?>
						   		<span class="text-danger">[置顶]</span>
						   		<?php endif;?>
					   		</div>
					   		<div class="col-sm-2 col-xs-12">
					   			<a class="hidden-xs info-right" href="<?php echo $this->config->item('bbs');?>community/user?user_id=<?php echo $posting['re_user_id'];?>"><img class="img-circle" src="<?php echo $this->image_common->resize((!empty($posting['re_image']) ? $posting['re_image'] : $posting['image']), 25, 25);?>" alt="<?php echo (!empty($posting['re_nickname'])) ? $posting['re_nickname'] : $posting['nickname'];?>" title="<?php echo (!empty($posting['re_nickname'])) ? $posting['re_nickname'] : $posting['nickname'];?>" style="padding: 0"></a>
					   			
					   			<span class="visible-xs info-left"><?php echo $posting['nickname'];?></span>
					   			<span class="info-right"><?php echo $time['time'].$time['unit'];?></span>
					   		</div>
					   	</li>
					   	<?php endforeach;?>
						<?php endif;?>
					</ul>
			  </div>
			</div>
		</div>
		
		<div class="col-sm-12" style="padding: 0">
			<div class="well well-sm" style="color: #b7b7b7">*请文明回帖，激烈讨论！<br/>*单张图片上传最大200kb<br/>*回帖内容2000字符内<br/>*链接请直接输入"href"标签将会被过滤</div>
		</div>
		
		<div class="col-sm-12" style="padding: 0">
			<form action="<?php echo $this->config->item('bbs').'/community/posting?posting_id='.$this->input->get('posting_id');?>" method="post" enctype="multipart/form-data">
			  <div class="form-group">
				<textarea rows="5" id="posting-reply" name="content" class="form-control" placeholder="<?php echo ($this->user->isLogged() == TRUE) ? '回复内容，最多2000个字"' : '请先登陆！" disabled="disabled"';?>"></textarea>
			  </div>
			  <input type="hidden" value="0" name="replies_id" id="posting-reply-id">
			  <button type="submit" id="posting-reply-submit" class="btn btn-sm btn-info" <?php echo $this->user->isLogged() ? '' : 'disabled';?>>回复</button>&nbsp;Ctrl+Enter
			</form>
		</div>
		
		<?php echo $position_bottom; ?>
    </div>
    <?php echo $position_right; ?>
  </div>
  <script>
  function add_attention(){
	  var user_id = <?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '0';?>;
	  if(!user_id > 0){
		  $.notify({message: '请先登陆！'},{type: 'warning',offset: {x: 0,y: 52}});
		  return false;
	  }
	  
	  $.ajax({
			url: '<?php echo $this->config->item('bbs').'/community/posting/add_attention';?>',
			type: 'post',
			dataType: 'json',
			data: {posting_id: <?php echo $posting['posting_id'];?>},
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
	function unattention(){
		$.ajax({
			url: '<?php echo $this->config->item('bbs').'/community/posting/unattention_position';?>',
			type: 'post',
			dataType: 'json',
			data: {posting_id: <?php echo $posting['posting_id'];?>},
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

	
  <?php if($this->user->isLogged()):?>
  $(document).ready(function ()
	{
		$('#posting-reply').summernote(
		{
			height: 200,                 // set editor height

		});
	});
  <?php endif;?>
  	$('#posting-reply').keypress(function(e){
		if(e.ctrlKey && e.which == 13 || e.which == 10) {
			$('#posting-reply-submit').click();
		}
	});
	
	function click_scroll(nickname, replies_id) {
	  var scroll_offset = $("#posting-reply").offset();
	  $("body,html").animate({
	   	scrollTop:scroll_offset.top - 20
	  },100);
	  
	  $('#posting-reply').code('@'+nickname).focus();
	  $('#posting-reply-id').val(replies_id);
 	}
 	
	$(document).ready(function (){
		$('#posting-attention').load("<?php echo $this->config->item('bbs').'/community/posting/attention_page?posting_id='.$posting['posting_id']?>");
		//统计帖子访问量
		$.get('<?php echo $this->config->item('bbs').'/community/posting/total?posting_id='.$this->input->get('posting_id')?>');
	});
  </script>
  <!-- /row --> 
</div>
<!-- /container -->
<?php echo $footer;//装载header?>