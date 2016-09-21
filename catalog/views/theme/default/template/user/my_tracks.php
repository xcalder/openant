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
			<?php echo $pagination;?>
			<div class="panel panel-default">
				<div class="well well-sm row" style="margin-left: 0;margin-right: 0;margin-bottom: 0">
					<div class="text-left">
						我的足迹
					</div>
				</div>
				<!-- /widget-header -->
				<div class="panel-body">
				
					<?php if(isset($tracks)):?>
					<?php foreach($tracks as $track):?>
					<?php if(isset($track['product']['product_id'])):?>
					<div class="media">
						<div class="media-left media-middle">
							<a href="product.html?product_id=<?php echo $track['product']['product_id'];?>">
								<img class="lazy" data-original="<?php echo $this->image_common->resize($track['product']['image'], $this->config->get_config('wish_cart_image_size_b_w'), $this->config->get_config('wish_cart_image_size_b_h'), 'h');?>" alt="<?php echo $track['product']['name']?>" width="<?php echo $this->config->get_config('wish_cart_image_size_b_w');?>px" height="<?php echo $this->config->get_config('wish_cart_image_size_b_h')?>px">
							</a>
						</div>
						<div class="media-body">
							<div class="col-sm-6"><?php echo $track['time'];?></div>
							<div class="col-sm-6"><?php echo $track['product']['store_name']?></div><br/><hr style="margin: 5px 0">
							<div class="col-sm-12">
								<p class="media-heading"><a href="product.html?product_id=<?php echo $track['product']['product_id'];?>"><?php echo $track['product']['name']?></a></p>
								<?php echo utf8_substr(strip_tags($track['product']['description']), 0,145);?>
							</div>
						</div>
					</div><hr>
					<?php endif;?>
					<?php endforeach;?>
					<?php endif;?>
					
				</div>
				<!-- /widget-content --> 
			</div>
			<?php echo $pagination;?>
			<!-- /widget -->
			<?php echo $position_bottom; ?>
		</div>
		<?php echo $position_right; ?>
	</div>
	<!-- /row --> 
</div>
<!-- /container -->
<?php echo $footer;//装载header?>