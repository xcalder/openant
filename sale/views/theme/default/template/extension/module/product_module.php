<?php if(isset($products)):?>
<?php $id=rand(1, 999)?>
<div class="panel panel-default">
	<div class="panel-heading"><?php echo $view_name;?></div>
	<div class="panel-body product-new-list product-new-list-<?php echo $id;?>" style="padding-left: 0;padding-right: 0">
		
		<?php foreach($products as $product):?>
		<div class="col-sm-3 col-xs-6">
			<div class="thumbnail">
				<a target="_blank" href="product.html?product_id=<?php echo $product['product_id'];?>"><img width="<?php echo $this->config->get_config('product_list_image_size_w');?>px" height="<?php echo $this->config->get_config('product_list_image_size_h');?>px" class="lazy" data-original="<?php echo $this->image_common->resize($product['image'], $this->config->get_config('product_list_image_size_w'), $this->config->get_config('product_list_image_size_h'), 'h');?>" alt="<?php echo $product['name'];?>"></a>
				<div class="caption">
					<strong><?php echo $this->currency->Compute($product['price']);?></strong>
					<a target="_blank" href="product.html?product_id=<?php echo $product['product_id'];?>"><p><?php echo $product['name'];?></p></a>
					
					<div class="row">
						<span data-toggle="tooltip" data-placement="top" title="销量：<?php echo isset($product['seal_quantity_total']) ? $product['seal_quantity_total'] : '0';?>件" class="col-sm-4 col-xs-4 text-left"><i class="glyphicon glyphicon-credit-card"></i></span>
						<span data-toggle="tooltip" data-placement="top" title="评价：<?php echo isset($product['reviews']) ? count($product['reviews']) : '0';?>条" class="col-sm-4 col-xs-4 text-center"><i class="glyphicon glyphicon-thumbs-up"></i></span>
						<span data-toggle="tooltip" data-html="true" data-placement="top" title="商家：<?php echo $product['store_name'];?><br/>退款：<?php echo $product['order_rate']['refund_rate'];?><br/>成交：<?php echo $product['order_rate']['success_rate'];?>" class="col-sm-4 col-xs-4 text-right"><i class="glyphicon glyphicon-star-empty"></i></span>
					</div>
					
				</div>
			</div>
		</div>
		<?php endforeach;?>
	</div>
		
</div>
<?php endif;?>
<script>
	$(document).ready(function(){
			var width = $('.product-new-list-<?php echo $id?>').width();
			if(width > 850){
				$('.product-new-list-<?php echo $id?> .col-xs-6').attr('class', 'col-xs-6 col-sm-3');
			}
			if(width < 850 && width > 460){
				$('.product-new-list-<?php echo $id?> .col-xs-6').attr('class', 'col-xs-6 col-sm-4');
			}
			if(width < 460){
				$('.product-new-list-<?php echo $id?> .col-xs-6').attr('class', 'col-xs-6 col-sm-12');
			}
		
		
			$(window).resize(function(){
					var width = $('.product-new-list-<?php echo $id?>').width();
					if(width > 850){
						$('.product-new-list-<?php echo $id?> .col-xs-6').attr('class', 'col-xs-6 col-sm-3');
					}
					if(width < 850 && width > 460){
						$('.product-new-list-<?php echo $id?> .col-xs-6').attr('class', 'col-xs-6 col-sm-4');
					}
					if(width < 460){
						$('.product-new-list-<?php echo $id?> .col-xs-6').attr('class', 'col-xs-6 col-sm-12');
					}
				});
		});
</script>