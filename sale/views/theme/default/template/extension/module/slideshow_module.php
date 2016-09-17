<?php $row_id=rand(1000,9999);?>

<div id="slidshow-<?php echo $row_id;?>" class="carousel slide" data-ride="carousel" data-interval="<?php echo rand(2000, 4500);?>">
   <!-- 轮播（Carousel）指标 -->
   <ol class="carousel-indicators" style="margin-bottom: 0;bottom: 0">
   	  <?php foreach($banners as $k=>$v):?>
      <li data-target="#slidshow-<?php echo $row_id;?>" data-slide-to="<?php echo $k;?>" <?php echo ($k == 0) ? 'class="active"' : '';?>></li>
      <?php endforeach;?>
   </ol>   
   <!-- 轮播（Carousel）项目 -->
   <div class="carousel-inner">
	  <?php foreach($banners as $k=>$v):?>
      <div class="item <?php echo ($k == 0) ? 'active' : '';?>">
         <a <?php echo !empty($banners[$k]['link']) ? 'href="'.$banners[$k]['link'].'"' : '';?>><img width="<?php echo $setting['width'];?>px" height="<?php echo $setting['height'];?>px" class="lazy lazy-auto" data-original="<?php echo $banners[$k]['image'];?>" title="<?php echo $banners[$k]['title']?>" alt="<?php echo $banners[$k]['title']?>"></a>
      </div>
      <?php endforeach;?>
   </div>
</div> 
<style type='text/css'>
	#content #slidshow-<?php echo $row_id;?>{
		margin-bottom: 15px;
	}
</style>
<script>
	//滑动支持

 $('#slidshow-<?php echo $row_id;?>').hammer().on('swipeleft', function(){

  $(this).carousel('next');

 });

$('#slidshow-<?php echo $row_id;?>').hammer().on('swiperight', function(){

  $(this).carousel('prev');

 });
</script>
