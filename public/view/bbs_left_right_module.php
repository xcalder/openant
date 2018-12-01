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
		   	<li>
	   			<?php $img=$this->image_common->get_string_image($posting['description'], 50, 50);?>
	   			<?php if($img):?>
	   			<a href="<?php echo $this->config->item('bbs');?>/community/posting?posting_id=<?php echo $posting['posting_id'];?>">
	   				<img class="col-md-12" src=<?php echo $img;?>>
	   			</a>
	   			<?php endif;?>
	   			
	   			<span class="col-md-12" style="padding: 3px">
	   				<a class="text-<?php echo $posting['label'];?>" href="<?php echo $this->config->item('bbs');?>?plate_id=<?php echo $posting['plate_id'];?>">[<?php echo $posting['plate_title'];?>]</a>
	   				<a href="<?php echo $this->config->item('bbs');?>/community/posting?posting_id=<?php echo $posting['posting_id'];?>"><?php echo $posting['title'];?></a>
	   			</span>
		   		
		   	</li>
		   	<?php endforeach;?>
			<?php endif;?>
		</ul>

	</div>
</div>
<?php endif;?>