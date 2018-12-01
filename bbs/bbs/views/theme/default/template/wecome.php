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
    	<div class="<?php echo $class;?>" style="padding: 0">
    		<?php if($plate_description):?>
    		<div class="well well-sm" style="color: #9e9e9e">
    			<?php echo $plate_description;?>
    		</div>
    		<?php endif;?>
    		
    		<?php if($users):?>
    		<div class="panel panel-default">
			  <div class="panel-heading padding-left">活跃用户</div>
			  <div class="panel-body" id="bbs-user-activity">
			  	<?php foreach ($users as $user):?>
			  	<a href="<?php echo $this->config->item('bbs').'/community/user?user_id='.$user['user_id'];?>" target="_black"><img class="img-circle" src="<?php echo $this->image_common->resize($user['image'], 40, 40);?>" alt="<?php echo $user['nickname'];?>" title="<?php echo $user['nickname'];?>"></a>
			  	<?php endforeach;?>
			  	
			  	<script type="text/javascript">
				  	var d = 0; //delay
				  	var ry, tz, s; //transform params
				  	$("#bbs-user-activity img").each(function(){
						d = Math.random()*1000; //1ms to 1000ms delay
						$(this).delay(d).animate({opacity: 0}, {
							step: function(n){
								s = 1-n; //scale - will animate from 0 to 1
								$(this).css("transform", "scale("+s+")");
							}, 
							duration: 1000, 
						})
					}).promise().done(function(){
						//after *promising* and *doing* the fadeout animation we will bring the images back
						storm();
					})
					
					function storm()
					{
						$("#bbs-user-activity img").each(function(){
							d = Math.random()*1000;
							$(this).delay(d).animate({opacity: 1}, {
								step: function(n){
									//rotating the images on the Y axis from 360deg to 0deg
									ry = (1-n)*360;
									//translating the images from 1000px to 0px
									tz = (1-n)*1000;
									//applying the transformation
									$(this).css("transform", "rotateY("+ry+"deg) translateZ("+tz+"px)");
								}, 
								duration: 3000, 
								//some easing fun. Comes from the jquery easing plugin.
								easing: 'easeOutQuint', 
							})
						})
					}
				</script>
				
			  </div>
			</div>
			<?php endif;?>
			  
    		
    		<?php if(isset($search) && $search_key_words):?>
			<div class="well well-sm">
				<h6>热门搜索关键词</h6><hr>
				<?php foreach ($search_key_words as $key_word):?>
				<a style="margin-bottom: 15px;display:inline-block" class="label label-<?php echo $label[array_rand($label)];?>" href="<?php echo $this->config->item('bbs').'?search='.$key_word['key_word'];?>"><?php echo $key_word['key_word'];?></a>
				<?php endforeach;?>
			</div>
			<?php endif;?>
    		
		    <div class="panel panel-default">
			  <div class="panel-heading padding-left">
			  	<nav class="navbar" style="margin-bottom: 0;min-height: 10px">
				  <ul class="nav navbar-nav">
				    <li <?php echo (isset($order_by) && $order_by == 'time') ? 'class="active"' : '';?>><a href="<?php echo $this->config->item('bbs').'?order_by=time'.(isset($plate_id) ? '&plate_id='.$plate_id : '');?>">活跃</a></li>
				    <li <?php echo (isset($order_by) && $order_by == 'good') ? 'class="active"' : '';?>><a href="<?php echo $this->config->item('bbs').'?order_by=good'.(isset($plate_id) ? '&plate_id='.$plate_id : '');?>">精华</a></li>
				    <li <?php echo (isset($order_by) && $order_by == 'last') ? 'class="active"' : '';?>><a href="<?php echo $this->config->item('bbs').'?order_by=last'.(isset($plate_id) ? '&plate_id='.$plate_id : '');?>">最近</a></li>
				    <li <?php echo (isset($order_by) && $order_by == 'no_reply') ? 'class="active"' : '';?>><a href="<?php echo $this->config->item('bbs').'?order_by=no_reply'.(isset($plate_id) ? '&plate_id='.$plate_id : '');?>">零回复</a></li>
				  </ul>
				</nav>
			  </div>
			  <div class="panel-body" id="posting-list">
			  	
					<ul>
					   	<?php if($postings):?>
			    		<?php foreach($postings as $posting):?>
			    		<?php $time=timediff((!empty($posting['re_date']) ? human_to_unix($posting['re_date']) : human_to_unix($posting['date_added'])), human_to_unix(date("Y-m-d H:i:s")));?>
					   	<li>
					   		<div class="col-sm-2 hidden-xs">
					   			<a href="<?php echo $this->config->item('bbs');?>/community/user?user_id=<?php echo $posting['user_id'];?>"><img class="img-circle" src="<?php echo $this->image_common->resize($posting['image'], 30, 30);?>" alt="<?php echo $posting['nickname'];?>" title="<?php echo $posting['nickname'];?>"></a>
					   			<strong class="text-primary hidden-xs" style="padding: 0 15px;font-weight: normal;"><span style="font-size: 24px;"><?php echo $posting['count'];?></span><span style="color: #868686;font-size: 22px">/</span><span style="color: #bfbfbf;font-size: 14px;"><?php echo $posting['access_count'];?></span></strong>
					   		</div>
					   		<div class="col-sm-8 col-xs-12">
						   		<a class="text-<?php echo $posting['label'];?>" href="<?php echo $this->config->item('bbs');?>?plate_id=<?php echo $posting['plate_id'];?>">[<?php echo $posting['plate_title'];?>]</a>&nbsp;<a href="<?php echo $this->config->item('bbs');?>/community/posting?posting_id=<?php echo $posting['posting_id'];?>" style="max-height: 15px;overflow: hidden;"><?php echo isset($search) ? highlight_phrase($posting['title'], $search) : $posting['title'];?></a>
						   		<?php if($posting['very_good'] == '1'):?>
						   		<span class="text-primary">[精华]</span>
						   		<?php endif;?>
						   		<?php if($posting['is_top'] == '1'):?>
						   		<span class="text-danger">[置顶]</span>
						   		<?php endif;?>
					   		</div>
					   		<div class="col-sm-2 col-xs-12">
					   			<a class="hidden-xs info-right" href="<?php echo $this->config->item('bbs');?>/community/user?user_id=<?php echo $posting['re_user_id'];?>"><img class="img-circle" src="<?php echo $this->image_common->resize($posting['re_image'], 25, 25);?>" alt="<?php echo $posting['re_nickname'];?>" title="<?php echo $posting['re_nickname'];?>" style="padding: 0"></a>
					   			
					   			<span class="visible-xs info-left"><?php echo $posting['nickname'];?></span>
					   			<span class="info-right"><?php echo $time['time'].$time['unit'];?></span>
					   		</div>
					   	</li>
					   	<?php endforeach;?>
						<?php endif;?>
					</ul>
				
			  </div>
			  <div class="panel-footer"><?php echo $pagination;?></div>
			</div>
			
			<?php if(isset($search) && $search_abouts):?>
			<div class="well well-sm">
				<h6>相关搜索</h6><hr>
				<?php foreach ($search_abouts as $key_word):?>
				<a style="margin-bottom: 15px;display:inline-block" class="label label-<?php echo $label[array_rand($label)];?>" href="<?php echo $this->config->item('bbs').'?search='.$key_word['key_word'];?>"><?php echo $key_word['key_word'];?></a>
				<?php endforeach;?>
			</div>
			<?php endif;?>
			
		</div>
    
    <?php echo $position_bottom; ?>
    </div>
    <?php echo $position_right; ?>
  </div>
  <script type="text/javascript">
  $(document).ready(function(){
	var plate_id=<?php echo !empty($plate_id) ? $plate_id : '0'?>;
	if(plate_id > 0){
		$('.plate-'+plate_id).addClass("active");
	}else{
		$('.plate-all').addClass("active");
	}

	//搜索关键词
	<?php if(isset($search)):?>
	$.get('<?php echo $this->config->item('bbs').'/wecome/add_search_keyword?search='.$search?>');
	<?php endif;?>
  });
  </script>
  <!-- /row --> 
</div>
<!-- /container -->
<?php echo $footer;//装载header?>