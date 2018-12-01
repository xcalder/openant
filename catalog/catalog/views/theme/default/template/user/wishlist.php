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
			
			<div class="row" style="margin-left: -15px" id="category-product-list">
				<?php if(isset($products)):?>
				
				<?php if($position_left && $position_right):?>
				<?php $class = 'col-sm-6'; ?>
				<?php elseif($position_left || $position_right):?>
				<?php $class = 'col-sm-4'; ?>
				<?php else:?>
				<?php $class = 'col-sm-3'; ?>
				<?php endif;?>
				
				<?php foreach($products as $product):?>
				<div class="<?php echo $class;?> col-xs-6">
					<div class="thumbnail">
						<a href="product?product_id=<?php echo $product['product_id'];?>"><img width="<?php echo $this->config->get_config('product_list_image_size_w');?>px" height="<?php echo $this->config->get_config('product_list_image_size_h');?>px" class="lazy" data-original="<?php echo $this->image_common->resize($product['image'], $this->config->get_config('product_list_image_size_w'), $this->config->get_config('product_list_image_size_h'), 'h');?>" alt="<?php echo $product['name'];?>"></a>
						<div class="caption">
							<strong><?php echo $this->currency->Compute($product['price']);?></strong>
							<a target="_blank" href="product?product_id=<?php echo $product['product_id'];?>"><p><?php echo $product['name'];?></p></a>
					
							<div class="row">
								<span data-toggle="tooltip" data-placement="top" title="<?php echo sprintf(lang_line('sales'), (isset($product['seal_quantity_total']) ? $product['seal_quantity_total'] : '0'));?>" class="col-sm-4 col-xs-4 text-left"><i class="glyphicon glyphicon-credit-card"></i></span>
								<span data-toggle="tooltip" data-placement="top" title="<?php echo sprintf(lang_line('reviews'), (isset($product['reviews']) ? count($product['reviews']) : '0'));?>" class="col-sm-4 col-xs-4 text-center"><i class="glyphicon glyphicon-thumbs-up"></i></span>
								<span data-toggle="tooltip" data-html="true" data-placement="top" title="<?php echo lang_line('business').$product['store_name'];?><br/><?php echo lang_line('refund').$product['order_rate']['refund_rate'];?><br/><?php echo lang_line('transactions').$product['order_rate']['success_rate'];?>" class="col-sm-4 col-xs-4 text-right"><i class="glyphicon glyphicon-star-empty"></i></span>
							</div>
					
						</div>
					</div>
				</div>
				<?php endforeach;?>
				<?php endif;?>
				<div class="col-md-12">
					<hr>
					<?php echo $pagination;?>
				</div>
			</div>
			<!-- /widget -->
			<?php echo $position_bottom; ?>
		</div>
		<?php echo $position_right; ?>
	</div>
	<!-- /row --> 
</div>
<!-- /container -->
<?php echo $footer;//装载header?>