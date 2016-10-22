<?php
/**
 * Groups configuration for default Minify implementation
 * @package Minify
 */

/** 
 * You may wish to use the Minify URI Builder app to suggest
 * changes. http://yourdomain/min/builder/
 *
 * See http://code.google.com/p/minify/wiki/CustomSource for other ideas
 **/
$subpath=str_replace('/min', '/',str_replace($_SERVER['DOCUMENT_ROOT'].'/', '', str_replace('\\', '/', dirname(__FILE__))));
$jss = array('resources/default/js/jquery-1.12.0.min.js', 'resources/default/js/bootstrap.js', 'resources/default/js/jquery.validate/jquery.validate.js', 'resources/default/js/jquery.goup.min.js', 'resources/default/js/jquery.form.js', 'resources/default/js/bootstrap-notify.min.js', 'resources/default/js/nprogress/nprogress.js', 'resources/default/js/jquery.lazyload.js', 'summernote/summernote.min.js', 'resources/default/js/hammer/hammer.min.js', 'resources/default/js/hammer/jquery.hammer.js', 'nav/js/bootsnav.js', 'resources/default/js/base.js');
foreach ($jss as $js){
	$js_s[]='//'.$subpath.$js;
}

$csss=array('resources/default/css/bootstrap.min.css', 'resources/default/css/bootstrap-responsive.min.css', 'summernote/summernote.css', 'resources/default/js/nprogress/nprogress.css', 'nav/css/bootsnav.css', 'nav/css/overwrite.css', 'nav/skins/color.css', 'resources/default/css/style.css');
foreach ($csss as $css){
	$css_s[]='//'.$subpath.$css;
}

return array(
    'js' => $js_s,
	
	
    'css' => $css_s,
);