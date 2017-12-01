<li class="dropdown">
	<?php if(isset($_SESSION['currency_id'])):?>
	<?php foreach($currencys as $currency):?>
	<?php if(isset($_SESSION['currency_id']) && $currency['currency_id'] == $_SESSION['currency_id']):?>
	<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"><?php echo (!empty($currency['symbol_left']) ? $currency['symbol_left'] : $currency['symbol_right']).$currency['title'];?></a>
	<?php endif;?>
	<?php endforeach;?>
	<?php else:?>
	<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"><?php echo (!empty($currency['symbol_left']) ? $currency['symbol_left'] : $currency['symbol_right']).$currency['title'];?></a>
	<?php endif;?>
	
	<ul class="dropdown-menu" id="currency">
		<?php foreach($currencys as $currency):?>
		<li><a href="<?php echo $currency['currency_id']?>"><?php echo (!empty($currency['symbol_left']) ? $currency['symbol_left'] : $currency['symbol_right']).$currency['title'];?></a></li>
		<?php endforeach;?>
	</ul>
</li>