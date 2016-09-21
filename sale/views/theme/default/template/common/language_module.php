<li class="dropdown">
	<?php if(isset($_SESSION['language_code'])):?>
	<?php foreach($languages as $language):?>
	<?php if($language['code'] == $_SESSION['language_code']):?>
	<a href="#" class="dropdown-toggle" data-toggle="dropdown"><img width="16px" height="11px" class="lazy" data-original="public/flags/<?php echo $language['image'];?>"><?php echo $language['name']?></a>
	<?php endif;?>
	<?php endforeach;?>
	<?php else:?>
	<a href="#" class="dropdown-toggle" data-toggle="dropdown"><img width="16px" height="11px" class="lazy" data-original="public/flags/<?php echo $language['image'];?>"><?php echo $language['name'];?></a>
	<?php endif;?>
	
	<ul class="dropdown-menu" id="language">
		<?php foreach($languages as $language):?>
		<li><a href="<?php echo $language['language_id']?>"><img alt="Brand" width="16px" height="11px" class="lazy" data-original="public/flags/<?php echo $language['image'];?>"><?php echo $language['name'];?></a></li>
		<?php endforeach;?>
	</ul>
</li>