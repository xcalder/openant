<!DOCTYPE html>
<html lang="<?php echo $_SESSION['language_code'];?>">
<head>
	<meta charset="utf-8">
	<title><?php echo $title;?></title>
	<?php if($keywords):?>
	<meta name="keywords" content="<?php echo $keywords;?>" />
	<?php endif;?>
	<?php if($description):?>
	<meta name="description" content="<?php echo $description; ?>" />
	<?php endif;?>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<Meta name="Copyright" Content="<?php echo $copyright;?>">
	<base href="<?php echo base_url();?>" />
	
	<!--语言标记-->
	<link rel="alternate" href="<?php echo base_url();?>" hreflang="<?php echo $_SESSION['language_code'];?>" />
	<!--缓存dns-->
	<link rel="dns-prefetch" href="<?php echo base_url()?>">
	<link rel="shortcut icon" href="<?php echo base_url('resources/public/resources/default/image/favicon.png');?>" />
	
	<link href="resources/public/resources/default/css/bootstrap.min.css" rel="stylesheet">
	<link href="resources/public/resources/default/css/bootstrap-responsive.min.css" rel="stylesheet">
	<link href="resources/public/summernote/summernote.css" rel="stylesheet">
	<link href="resources/public/nav/css/bootsnav.css" rel="stylesheet">
	<link href="resources/public/nav/css/overwrite.css" rel="stylesheet">
	<link href="resources/public/nav/skins/color.css" rel="stylesheet">
	<link href="resources/public/resources/default/css/style.css" rel="stylesheet">
	
	<?php foreach($styles as $style):?>
	<link type="text/css" href="<?php echo $style['href']; ?>" rel="<?php echo $style['rel']; ?>" media="<?php echo $style['media']; ?>" />
	<?php endforeach;?>
	
	<?php foreach($links as $link):?>
	<link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
	<?php endforeach;?>

	<script src="resources/public/resources/default/js/jquery-1.12.0.min.js"></script>
	<script src="resources/public/resources/default/js/bootstrap.js"></script>
	<script src="resources/public/resources/default/js/jquery.validate/jquery.validate.js"></script>
	<script src="resources/public/resources/default/js/jquery.goup.min.js"></script>
	<script src="resources/public/resources/default/js/jquery.form.js"></script>
	<script src="resources/public/resources/default/js/bootstrap-notify.min.js"></script>
	<script src="resources/public/resources/default/js/nprogress/nprogress.js"></script>
	<script src="resources/public/resources/default/js/jquery.lazyload.js"></script>
	<script src="resources/public/summernote/summernote.min.js"></script>
	<script src="resources/public/resources/default/js/hammer/hammer.min.js"></script>
	<script src="resources/public/resources/default/js/hammer/jquery.hammer.js"></script>
	<script src="resources/public/nav/js/bootsnav.js"></script>
	<script src="resources/public/resources/default/js/placeholderTypewriter.js"></script>
	<script src="resources/public/resources/default/js/base.js"></script>

	<script type="text/javascript">
	$(document).ready(function(){ 
		NProgress.start();
	});

	window.onload = function() { 
		NProgress.done();
	}; 
	</script>
	
	<?php foreach($scripts as $script):?>
	<script type="text/javascript" src="<?php echo $script; ?>"></script>
	<?php endforeach; ?>

	<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	<script src="resources/public/resources/default/js/ie9-html5.js"></script>
	<![endif]-->
	<?php if(isset($_SESSION['success'])):?>
	<script type="text/javascript">
		$(document).ready(function () {$.notify({message: '<?php echo $_SESSION['success'];?>',},{type: 'success',offset: {x: 0,y: 52}});});
	</script>
	<?php endif;?>
	<?php if(isset($_SESSION['fali'])):?>
	<script type="text/javascript">
		$(document).ready(function () {$.notify({message: '<?php echo $_SESSION['fali'];?>' },{type: 'warning',offset: {x: 0,y: 52}});
	</script>
	<?php endif;?>
	
	<script>
	//百度统计
	var _hmt = _hmt || [];
	(function() {
	  var hm = document.createElement("script");
	  hm.src = "https://hm.baidu.com/hm.js?073f3069c89851ba45cb4eb471507a0a";
	  var s = document.getElementsByTagName("script")[0]; 
	  s.parentNode.insertBefore(hm, s);
	})();
	</script>
	<script>
	//百度推送
	(function(){
	    var bp = document.createElement('script');
	    var curProtocol = window.location.protocol.split(':')[0];
	    if (curProtocol === 'https') {
	        bp.src = 'https://zz.bdstatic.com/linksubmit/push.js';        
	    }
	    else {
	        bp.src = 'http://push.zhanzhang.baidu.com/push.js';
	    }
	    var s = document.getElementsByTagName("script")[0];
	    s.parentNode.insertBefore(bp, s);
	})();
	</script>
	<script>
	//360推送
	(function(){
	   var src = (document.location.protocol == "http:") ? "http://js.passport.qihucdn.com/11.0.1.js?ecbfde9f22019c7aa45676c0b88c0f10":"https://jspassport.ssl.qhimg.com/11.0.1.js?ecbfde9f22019c7aa45676c0b88c0f10";
	   document.write('<script src="' + src + '" id="sozz"><\/script>');
	})();

	//统计在线
	$.get('<?php echo $this->config->item('catalog');?>/common/count/add_useronline');
	</script>
</head>