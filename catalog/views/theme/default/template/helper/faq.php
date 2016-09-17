<?php echo $header;//装载header?>
<?php echo $top;//装载top?>
<div class="container">
	<div class="row"><?php echo $position_left;?>
  
		<?php if($position_left && $position_right):?>
		<?php $class = 'col-sm-6'; ?>
		<?php elseif($position_left || $position_right):?>
		<?php $class = 'col-sm-9'; ?>
		<?php else:?>
		<?php $class = 'col-sm-12'; ?>
		<?php endif;?>
	
		<div id="middle" class="<?php echo $class; ?>">
			<?php echo $position_top; ?>
	
			<div id="faq-content">
				<div class="col-xs-3 well well-sm">
					<ul class="nav-pills nav-stacked faq-nav-left">
						<?php if(!empty($categorys)):?>
						<?php foreach($categorys as $category):?>
						
						<?php if($category['titles']):?>
						
						<li id="category-<?php echo $category['information_category_id'];?>" class="category-<?php echo $category['information_category_id'];?>"><a onclick="change_active('.category-<?php echo $category['information_category_id'];?>');"><?php echo $category['name'];?></a>
							<ul class="faq-nav-two">
								<?php foreach($category['titles'] as $title):?>
								<li class="inforation-<?php echo $title['information_id'];?>"><a href="helper/faq.html?inforation_id=<?php echo $title['information_id'];?>#inforation-<?php echo $title['information_id'];?>"><?php echo $title['title'];?></a></li>
								<?php endforeach;?>
								
								<?php if($category['childs']):?>
								<?php foreach($category['childs'] as $child):?>
									<li class="child-<?php echo $child['information_category_id'];?>"><a onclick="change_active('.child-<?php echo $child['information_category_id'];?>');"><?php echo $child['name'];?></a>
									
									<?php if($child['titles']):?>
									<ul class="faq-nav-two">
									<?php foreach($child['titles'] as $title):?>
									<li class="inforation-<?php echo $title['information_id'];?>"><a href="helper/faq.html?inforation_id=<?php echo $title['information_id'];?>#inforation-<?php echo $title['information_id'];?>"><?php echo $title['title'];?></a></li>
									<?php endforeach;?>
									</ul>
									<?php endif;?>
									
									</li>
								<?php endforeach;?>
								<?php endif;?>
							</ul>
							
						</li>
						<?php else:?>
						<li id="category-<?php echo $category['information_category_id'];?>" class="category-<?php echo $category['information_category_id'];?>"><a onclick="change_active('.category-<?php echo $category['information_category_id'];?>');"><?php echo $category['name'];?></a>
						
						<?php if($category['childs']):?>
						<ul class="faq-nav-two">
							<?php foreach($category['childs'] as $child):?>
							<li class="child-<?php echo $child['information_category_id'];?>"><a onclick="change_active('.child-<?php echo $child['information_category_id'];?>');"><?php echo $child['name'];?></a>
							
								<?php if($child['titles']):?>
								<ul class="faq-nav-two">
								<?php foreach($child['titles'] as $title):?>
								<li class="inforation-<?php echo $title['information_id'];?>"><a href="helper/faq.html?inforation_id=<?php echo $title['information_id'];?>#inforation-<?php echo $title['information_id'];?>"><?php echo $title['title'];?></a></li>
								<?php endforeach;?>
								</ul>
								<?php endif;?>
							
							</li>
							<?php endforeach;?>
						</ul>
						<?php endif;?>
						
						</li>
						<?php endif;?>
						
						<?php endforeach;?>
						<?php endif;?>
					</ul>
				</div>
				<div class="col-xs-9">
					<div class="text-left"><p style="margin-bottom: 0"><strong><?php echo $information['title'];?></strong></p></div>
					<hr style="float: left;width: 100%">
					<div class="col-xs-6"><?php echo lang_line('release_time');?><?php echo $information['date_added'];?></div>
					<div class="col-xs-6 text-right"><?php echo lang_line('last_modified');?><?php echo $information['date_modified'];?></div>
				
					<hr style="float: left;width: 100%">
					<?php echo htmlspecialchars_decode($information['description']);?>
				</div>
			</div>
			<?php echo $position_bottom; ?>
		</div>
		<?php echo $position_right; ?>
	</div> <!-- /row -->
	<script>
		var div=window.location.hash.replace("#",".");
		if(div.length > 0){
			$('.category-menu li').removeClass('active');
			$('.faq-nav-left li').removeClass('active');
			$(div).addClass("active");
		}
		
		function change_active(div){
			if(div.length > 0){
				$('.category-menu li').removeClass('active');
				$('.faq-nav-left li').removeClass('active');
				$(div).addClass("active");
			}
		}
	</script>
</div> <!-- /container -->
<?php echo $footer;//装载header?>