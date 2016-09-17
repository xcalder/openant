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
			
			<?php if($manufacturers):?>
			<?php echo $pagination;?>
			<?php foreach($manufacturers as $manufacturer):?>
			<div class="media">
			  <div class="media-left media-middle">
			    <a href="product/manufacturer.html?id=<?php echo $manufacturer['manufacturer_id']?>">
			      <img class="lazy media-object" data-original="<?php echo $this->image_common->resize($manufacturer['image'], 100, 100);?>" alt="<?php echo $manufacturer['name'];?>" width="150px" height="150px" style="max-width:150px">
			    </a>
			  </div>
			  <div class="media-body">
			    <a href="product/manufacturer.html?id=<?php echo $manufacturer['manufacturer_id']?>"><h5 class="media-heading"><?php echo $manufacturer['name'];?></h5></a>
			    <?php echo $manufacturer['description'];?>
			    
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