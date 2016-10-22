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
			
		<div id="middle" class="<?php echo $class; ?>" role="main">
			<?php echo $position_top; ?>
			
			<?php if($categorys):?>
			<?php echo $pagination;?>
			<?php foreach($categorys as $category):?>
			<div class="media">
			  <div class="media-left media-middle">
			    <a href="<?php echo site_url('product/category?id='.$category['category_id']);?>">
			      <img class="lazy media-object" data-original="<?php echo $this->image_common->resize($category['image'], 150, 150);?>" alt="<?php echo $category['name'];?>" width="150px" height="150px" style="max-width:150px">
			    </a>
			  </div>
			  <div class="media-body">
			    <a href="<?php echo site_url('product/category?id='.$category['category_id']);?>"><h5 class="media-heading"><?php echo $category['name'];?></h5></a>
			    <?php echo $category['description'];?>
			    
			    <?php if($category['child']):?>
			    <?php foreach($category['child'] as $child):?>
			    <div class="media">
				  <div class="media-left media-middle">
				    <a href="<?php echo site_url('product/category?id='.$category['category_id'].'_'.$child['category_id']);?>">
				      <img class="media-object lazy" data-original="<?php echo $this->image_common->resize($child['image'], 100, 100);?>" alt="<?php echo $child['name'];?>" style="max-width: 100px">
				    </a>
				  </div>
				  <div class="media-body">
				    <a href="<?php echo site_url('product/category?id='.$category['category_id'].'_'.$child['category_id']);?>"><h6 class="media-heading"><?php echo $child['name'];?></h6></a>
				    <?php echo $child['description'];?>
				  </div>
				</div>
				<?php endforeach;;?>
				<?php endif;?>
			    
			  </div>
			</div><hr>
			<?php endforeach;?>
			<?php echo $pagination;?>
			<?php endif;?>
			
			<?php echo $position_bottom; ?>
		</div>
		<?php echo $position_right; ?>
		
	</div>
	<script>
		var p_width = $('#category-product-list').width();
		if(p_width < 850 && p_width > 600){
			$('#category-product-list .col-xs-6').attr("class", "col-sm-4 col-xs-6");
		}
		if(p_width > 850){
			$('#category-product-list .col-xs-6').attr("class", "col-sm-3 col-xs-6");
		}
		if(p_width < 600){
			$('#category-product-list .col-xs-6').attr("class", "col-sm-6 col-xs-6");
		}
	</script>
</div>
<!-- /row --> 
</div>
<!-- /container -->
<?php echo $footer;//装载header?>