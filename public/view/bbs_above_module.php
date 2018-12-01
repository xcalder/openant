<?php if($postings):?>
<div class="panel panel-default">
	<div class="panel-heading">
		<nav class="navbar" style="margin-bottom: 0;min-height: 10px">
			<ul class="nav navbar-nav">
				<li>
					<a>
						<?php echo $title;?>
					</a>
				</li>
			</ul>
		</nav>
	</div>
	<div class="panel-body" id="posting-list" style="padding: 15px 0">

		<ul>
			<?php if($postings):?>
    		<?php foreach($postings as $posting):?>
    		<?php $time=timediff(human_to_unix($posting['re_date']), human_to_unix(date("Y-m-d H:i:s")));?>
		   	<li style="float: left;width:100%">
		   		<a href="<?php echo $this->config->item('bbs');?>/community/user?user_id=<?php echo $posting['user_id'];?>"><img class="img-circle" src="<?php echo $this->image_common->resize($posting['image'], 30, 30);?>" alt="<?php echo $posting['nickname'];?>" title="<?php echo $posting['nickname'];?>"></a>
		   		<strong class="text-primary hidden-xs" style="padding: 0 15px;font-weight: normal;"><span style="font-size: 24px;"><?php echo $posting['count'];?></span><span style="color: #868686;font-size: 22px">/</span><span style="color: #bfbfbf;font-size: 14px;"><?php echo $posting['access_count'];?></span></strong>
		   		<a class="text-<?php echo $posting['label'];?>" href="<?php echo $this->config->item('bbs');?>?plate_id=<?php echo $posting['plate_id'];?>">[<?php echo $posting['plate_title'];?>]</a>&nbsp;<a href="<?php echo $this->config->item('bbs');?>community/posting?posting_id=<?php echo $posting['posting_id'];?>" style="max-height: 15px;overflow: hidden;"><?php echo $posting['title'];?></a>
		   		<?php if($posting['very_good'] == '1'):?>
		   		<span class="text-primary">[精华]</span>
		   		<?php endif;?>
		   		<?php if($posting['is_top'] == '1'):?>
		   		<span class="text-danger">[置顶]</span>
		   		<?php endif;?>
		   		<div style="float: right;line-height: 40px">
		   		<a href="<?php echo $this->config->item('bbs');?>/community/user?user_id=<?php echo $posting['re_user_id'];?>"><img class="img-circle" src="<?php echo $this->image_common->resize($posting['re_image'], 25, 25);?>" alt="<?php echo $posting['re_nickname'];?>" title="<?php echo $posting['re_nickname'];?>" style="padding: 0">
		   		</a>
		   		<?php echo $time['time'].$time['unit'];?>
		   			
		   		</div>
		   	</li>
		   	<?php endforeach;?>
			<?php endif;?>
		</ul>

	</div>
</div>
<style type="text/css">　　
#posting-list{
	padding: 0;
}
#posting-list img{
	border:1px solid #d2d2d2;
	padding:3px;
}

#posting-list.panel-body ul{
	margin: 0;
	padding: 0;
}
#posting-list.panel-body ul li{
	position: relative;
	display: block;
	padding: 5px;
	list-style: none;
	border-bottom: 1px solid #f2f2f2;
}
</style>
<?php endif;?>