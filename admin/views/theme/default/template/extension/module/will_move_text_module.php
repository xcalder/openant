<?php $row_id=rand(1000,9999);?>
<div id="textillate<?php echo $row_id;?>" style="height: <?php echo $setting['height'];?>px;text-align: center;background-color: <?php echo $setting['bgcolor'];?>;overflow: hidden;">
  <div class="col-1-1 viewport" style="line-height: <?php echo $setting['height'];?>px;color: <?php echo $setting['color'];?>;font-size: <?php echo $setting['font_size'];?>px">
      <div class="tlt">
        <ul class="texts" style="display: none">
        	<?php if(isset($setting['content'])):?>
        	<?php foreach($setting['content'] as $value):?>
          	<li><?php echo $value;?></li>
          	<?php endforeach;?>
          	<?php endif;?>
        </ul>
      </div>
  </div>
</div>
<style type='text/css'>
	#content #textillate<?php echo $row_id;?>{
		margin-bottom: 15px;
	}
</style>
<script>
$(document).ready(function(){
	$(function (){
		var animateClasses = 'flash bounce shake tada swing wobble pulse flip flipInX flipOutX flipInY flipOutY fadeIn fadeInUp fadeInDown fadeInLeft fadeInRight fadeInUpBig fadeInDownBig fadeInLeftBig fadeInRightBig fadeOut fadeOutUp fadeOutDown fadeOutLeft fadeOutRight fadeOutUpBig fadeOutDownBig fadeOutLeftBig fadeOutRightBig bounceIn bounceInDown bounceInUp bounceInLeft bounceInRight bounceOut bounceOutDown bounceOutUp bounceOutLeft bounceOutRight rotateIn rotateInDownLeft rotateInDownRight rotateInUpLeft rotateInUpRight rotateOut rotateOutDownLeft rotateOutDownRight rotateOutUpLeft rotateOutUpRight hinge rollIn rollOut';

		var type = 'sequence reverse sync shuffle';

		var $viewport = $('#textillate<?php echo $row_id;?> .viewport');



		var getFormData = function () {
			var an_type = type.split(' ');
			var type_selected_in= an_type[Math.floor((Math.random()*an_type.length))];
			var type_selected_out= an_type[Math.floor((Math.random()*an_type.length))];

			var an_arr=animateClasses.split(' ');
			var t_in =an_arr[Math.floor((Math.random()*an_arr.length))];
			var t_out =an_arr[Math.floor((Math.random()*an_arr.length))];

		  var data = { 
		    loop: true, 
		    in: { }, 
		    out: { }
		  };
		  
		  data["in"]["effect"]=t_in;
		  data["out"]["effect"]=t_out;
		  
		  for(i=0;i<=4;i++){
			if(an_type[i] == type_selected_in){
				data["in"][an_type[i]]='true';
			}else{
				data["in"][an_type[i]]='false';
			}
			
			if(an_type[i] == type_selected_out){
				data["out"][an_type[i]]='true';
			}else{
				data["out"][an_type[i]]='false';
			}
		  }
		  
		  return data;
		};

		var $tlt = $viewport.find('.tlt')
		  .on('start.tlt')
		  .on('inAnimationBegin.tlt')
		  .on('inAnimationEnd.tlt')
		  .on('outAnimationBegin.tlt')
		  .on('outAnimationEnd.tlt')
		  .on('end.tlt');

		$viewport.on('change', function () {
		  var obj = getFormData();
		  $tlt.textillate(obj);
		}).trigger('change');

	});
});
</script>