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
	<link rel="shortcut icon" href="<?php echo base_url('public/resources/default/image/favicon.png');?>" />
	
	<link href="public/min?g=css&v=<?php echo CI_VERSION;?>" rel="stylesheet">
	<?php foreach($styles as $style):?>
	<link type="text/css" href="<?php echo $style['href']; ?>" rel="<?php echo $style['rel']; ?>" media="<?php echo $style['media']; ?>" />
	<?php endforeach;?>
	<?php foreach($links as $link):?>
	<link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
	<?php endforeach;?>

	<script src="public/min?g=js&v=<?php echo CI_VERSION;?>"></script>

	<?php foreach($scripts as $script):?>
	<script type="text/javascript" src="<?php echo $script; ?>"></script>
	<?php endforeach; ?>

	<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	<script src="public/resources/default/js/ie9-html5.js"></script>
	<![endif]-->
	<?php if(isset($_SESSION['success'])):?>
	<script type="text/javascript">
		$(document).ready(function () {$.notify({message: '<?php echo $_SESSION['success'];?>',},{type: 'success',});});
	</script>
	<?php endif;?>
	<?php if(isset($_SESSION['fali'])):?>
	<script type="text/javascript">
		$(document).ready(function () {$.notify({message: '<?php echo $_SESSION['fali'];?>' },{type: 'warning'});});
	</script>
	<?php endif;?>
</head>