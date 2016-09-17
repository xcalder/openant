<?php echo $header;//装载header?>
<?php echo $top;//装载top?>
<div class="container">
	<div class="row" style="background: url(image/public/star_404bg.png) repeat center center"><?php echo $position_left;?>
		<?php if($position_left && $position_right):?>
		<?php $class = 'col-sm-6'; ?>
		<?php $point_col='';?>
		<?php elseif($position_left || $position_right):?>
		<?php $class = 'col-sm-9'; ?>
		<?php $point_col='<div class="col-sm-3"></div>';?>
		<?php else:?>
		<?php $class = 'col-sm-12'; ?>
		<?php $point_col='<div class="col-sm-3"></div>';?>
		<?php endif;?>
	
		<?php echo ($position_right || (!$position_left && !$position_right)) ? $point_col : '';?>
		<div id="middle" class="col-sm-6">
			<?php echo $position_top; ?>
    	
			<div class="row" style="background: url(<?php echo $image_404?>) no-repeat left center">
				<div class="col-sm-6 img-404">
					<!--<img src="<?php //echo $image_404;?>">-->
				</div>
				<div class="col-sm-6 panel panel-default">
					<div class="panel-body">
						<p><?php echo lang_line('title');?></p>
						<p><?php echo lang_line('repair');?></p>
						<li><?php echo lang_line('causes');?></li>
						<p><?php echo lang_line('return');?><a href="<?php echo site_url();?>">&nbsp;<span id="timing" style="color: red">5</span>&nbsp;&nbsp;<?php echo lang_line('home');?></a></p>
					</div>
				</div>
			</div>
			<?php echo $position_bottom; ?>
		</div>
		<?php echo ($position_left || (!$position_left && !$position_right)) ? $point_col : '';?>
		<?php echo $position_right; ?>
	</div>
	<!-- /row -->
	<style>
		#content{
			min-height: 100%;
		}
	</style>
	<script>
		//倒计时
		$(function () {
				var count = 4;
				var countdown = setInterval(CountDown, 1000);
				function CountDown() {
					$("#timing").text(count);
					if (count == 0) {
						window.location.href="<?php echo site_url();?>";
					}
					count--;
				}
			});
	</script>
</div>
<?php echo $footer;//装载header?>