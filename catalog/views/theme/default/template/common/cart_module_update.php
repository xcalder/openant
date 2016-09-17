<a href="#" class="dropdown-toggle" data-toggle="dropdown" id="page-cart">
        <i class="glyphicon glyphicon-shopping-cart"></i><?php echo lang_line('text_cart');?><span class="badge"><?php echo ($carts !== FALSE && is_array($carts)) ? count($carts) - 2 : '';?></span>
    </a>
    <ul class="dropdown-menu cart-list">
    
    	<?php if($carts):?>
		<?php $row = 0;?>
		<?php foreach($carts as $key=>$value):?>
		<?php if(isset($carts[$key]['rowid']) && $row < 5):?>
		
		<li>
            <a href="<?php echo site_url('user/cart');?>" class="photo"><img width="<?php echo $this->config->get_config('product_list_image_size_w');?>px" height="<?php echo $this->config->get_config('product_list_image_size_h');?>px" data-original="<?php echo $this->image_common->resize($carts[$key]['image'], $this->config->get_config('product_list_image_size_w'), $this->config->get_config('product_list_image_size_h'));?>" class="lazy cart-thumb" alt="<?php echo $carts[$key]['name'];?>" /></a>
            <p><a href="<?php echo site_url('user/cart');?>" style="color: rgb(91, 192, 222)"><?php echo $carts[$key]['name'];?></a></p>
            <p style="color: rgb(182, 182, 182);font-size: 12px;"><?php echo $carts[$key]['qty'];?>x - <span class="price"><?php echo $this->currency->Compute($carts[$key]['price']);?></span></p>
            <p style="color: rgb(182, 182, 182);font-size: 12px;"><?php echo (isset($carts[$key]['options']) && !empty($carts[$key]['options'])) ? $carts[$key]['options'] : ''?></p>
        </li>
		
		<?php endif;?>
		<?php $row++;?>
		<?php endforeach;?>
		<?php if($carts !== FALSE && is_array($carts) && (count($carts) - 2) >= 5):?>
		<li ><a target="_blank" href="<?php echo site_url('user/cart');?>" class="text-center" style="padding-bottom: 0;padding-top: 0;border-bottom-width: 0">...更多...</a></li>

		<?php endif;?>
		<li class="total">
            <span class="pull-right">总价：<?php echo $total;?></span>
            <a href="<?php echo site_url('user/cart');?>" class="btn btn-default btn-sm btn-cart" style="padding: 5px 15px">结算</a>
        </li>
		<?php else:?>
		<li><a>购物车中没有商品</a></a></li>
		<?php endif;?>
    </ul>