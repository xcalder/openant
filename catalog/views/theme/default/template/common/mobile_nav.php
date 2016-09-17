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
		<div id="middel-mobile-nav" class="<?php echo $class; ?>"><?php echo $position_top; ?>
    
			<section style="padding-left: 0">
				<div id="menu" class="slinky-menu">
					<ul style="padding-left: 0">
						<li>
							<a href="#">移动导航菜单</a>
						</li>
						<?php if($menus):?>
						<?php foreach($menus as $menu):?>
						<?php if(isset($menu['child']) && is_array($menu['child'])):?>
						<li><a href="#"><?php echo $menu['name'];?></a>
							<?php foreach(array_chunk($menu['child'], ceil(count($menu['child']) / $menu['column'])) as $child):?>
							<ul>
								<?php foreach($child as $child_):?>
								<li><a href="<?php echo site_url('product/category').'?id='.$menu['category_id'].'_'.$child_['category_id'];?>"><?php echo $child_['name']; ?></a></li>
								<?php endforeach; ?>
							</ul>
							<?php endforeach; ?>
						</li>
						<?php else:?>
						<li><a href="<?php echo site_url('product/category').'?id='.$menu['category_id'];?>"><?php echo $menu['name'];?></a></li>
						<?php endif;?>
						<?php endforeach;?>
						<?php endif;?>
					</ul>
				</div>
			</section>
    
			<?php echo $position_bottom; ?></div>
		<?php echo $position_right; ?>
	</div>
	<script>
		$(document).ready(function() {
				$('#menu').slinky({
						title: true
					});
			});
	</script>
	<!-- /row --> 
</div>
<!-- /container -->
<?php echo $footer;//装载header?>