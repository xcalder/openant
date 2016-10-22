<li class="dropdown">
	<?php if(isset($_SESSION['language_code'])):?>
	<?php foreach($languages as $language):?>
	<?php if($language['code'] == $_SESSION['language_code']):?>
	<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"><img width="16px" height="11px" class="lazy" data-original="public/flags/<?php echo $language['image'];?>"><span class="visible-lg-inline"><?php echo $language['name']?></span></a>
	<?php endif;?>
	<?php endforeach;?>
	<?php else:?>
	<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"><img width="16px" height="11px" class="lazy" data-original="public/flags/<?php echo $language['image'];?>"><span class="visible-lg-inline"><?php echo $language['name'];?></span></a>
	<?php endif;?>
	<ul class="dropdown-menu" id="language">
		<?php foreach($languages as $language):?>
		<li><a href="<?php echo $language['language_id']?>"><img alt="Brand" width="16px" height="11px" class="lazy" data-original="public/flags/<?php echo $language['image'];?>"><span class="visible-lg-inline"><?php echo $language['name'];?></span></a></li>
		<?php endforeach;?>
	</ul>
</li>