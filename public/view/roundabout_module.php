<?php $row_id=rand(1000,9999);?>
<div id="tour" class="zebra tour-<?php echo $row_id;?> hidden-xs">
	<div class="wrap">
		<div class="switcher-wrap slider">
			<a class="prev jQ_sliderPrev" href=""></a>
			<a class="next jQ_sliderNext" href=""></a>

			<ul id="img-slider" style="height: 450px;">
				<?php foreach($banners as $banner):?>
				<li class="img">
					<img data-original="<?php echo $banner['image'];?>" class="lazy"/>
					<div class="label"><?php echo $banner['title'];?></div>
				</li>
				<?php endforeach;?>
			</ul>
			<ul class="switcher jQ_sliderSwitch">
				<?php foreach($banners as $k=>$v):?>
				<?php if($k == '0'):?>
				<li class="active"><a href=""></a></li>
				<?php else:?>
				<li><a href=""></a></li>
				<?php endif;?>
				<?php endforeach;?>
			</ul>
		</div>
	</div>
</div>
<script>
	window.setInterval(function(){ 
		showalert(); 
	}, 2000);
	function showalert() 
	{ 
		$('#tour.tour-<?php echo $row_id;?> #img-slider').roundabout('animateToNextChild');
	} 
	//滑动支持
	$('#tour.tour-<?php echo $row_id;?>').hammer().on('swipeleft', function(){

		$('#tour.tour-<?php echo $row_id;?> #img-slider').roundabout('animateToNextChild');

	});

	$('#tour.tour-<?php echo $row_id;?>').hammer().on('swiperight', function(){

		$('#tour.tour-<?php echo $row_id;?> #img-slider').roundabout('animateToPreviousChild');

	});
</script>
