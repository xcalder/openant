<?php echo $header;//装载header?>
<?php echo $top;//装载top?>
<!-- /subnavbar -->
<div class="container">
  <div class="row"><?php echo $position_left;?>
	<?php if ($position_left && $position_right):?>
	<?php $class = 'col-sm-6'; ?>
	<?php elseif ($position_left || $position_right):?>
	<?php $class = 'col-sm-9'; ?>
	<?php else:?>
	<?php $class = 'col-sm-12'; ?>
	<?php endif;?>
    <div id="middle" class="<?php echo $class; ?>"><?php echo $position_top; ?><?php echo $position_bottom; ?></div>
    <?php echo $position_right; ?>
  </div>
  <!-- /row --> 
</div>
<!-- /container -->
<?php echo $footer;//装载header?>