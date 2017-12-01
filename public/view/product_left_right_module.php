<?php if(isset($products)):?>
<?php $id=rand(1, 999)?>
<div class="panel panel-default">
	<div class="panel-heading"><?php echo $view_name;?></div>
	<div class="panel-body product-new-list product-new-list-<?php echo $id;?>" style="padding-left: 0;padding-right: 0">
		
		<?php foreach($products as $product):?>
		<div class="col-sm-12 col-xs-12">
			<div class="thumbnail">
				<a target="_blank" href="<?php echo $this->config->item('catalog');?>/product?product_id=<?php echo $product['product_id'];?>"><img width="<?php echo $this->config->get_config('product_list_image_size_w');?>px" height="<?php echo $this->config->get_config('product_list_image_size_h');?>px" class="lazy" data-original="<?php echo $this->image_common->resize($product['image'], $this->config->get_config('product_list_image_size_w'), $this->config->get_config('product_list_image_size_h'), 'h');?>" alt="<?php echo $product['name'];?>"></a>
				<div class="caption">
					<strong><?php echo $this->currency->Compute($product['price']);?></strong>
					<a target="_blank" href="<?php echo $this->config->item('catalog');?>/product?product_id=<?php echo $product['product_id'];?>"><p><?php echo $product['name'];?></p></a>
					
					<div class="row">
						<span data-toggle="tooltip" data-placement="top" title="<?php echo sprintf(lang_line('sales'), (isset($product['seal_quantity_total']) ? $product['seal_quantity_total'] : '0'));?>" class="col-sm-4 col-xs-4 text-left"><i class="glyphicon glyphicon-credit-card"></i></span>
						<span data-toggle="tooltip" data-placement="top" title="<?php echo sprintf(lang_line('reviews'), (isset($product['reviews']) ? count($product['reviews']) : '0'));?>" class="col-sm-4 col-xs-4 text-center"><i class="glyphicon glyphicon-thumbs-up"></i></span>
						<span data-toggle="tooltip" data-html="true" data-placement="top" title="<?php echo lang_line('business').$product['store_name'];?><br/><?php echo lang_line('refund').$product['order_rate']['refund_rate'];?><br/><?php echo lang_line('transactions').$product['order_rate']['success_rate'];?>" class="col-sm-4 col-xs-4 text-right"><i class="glyphicon glyphicon-star-empty"></i></span>
					</div>
					
				</div>
			</div>
		</div>
		<?php endforeach;?>
	</div>
		
</div>
<?php endif;?>