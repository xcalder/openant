<?php //echo $header;//装载header?>
<?php //echo $top;//装载top?>
<!-- 
<nav class="navbar navbar-default" role="navigation">
	<ul class="nav navbar-nav">
		<li class="active"><a href="#">Link</a></li>
		<li><a href="#">Link</a></li>
	</ul>
</nav>

<div class="col-md-3" role="main">
	<h5>关于我们</h5>
	<ul class="list-unstyled">
		<li><a href="http://www.openant.com/helper/faq.html?inforation_id=9"> 联系我们</a></li>
		<li><a href="#"> 发展历程 </a></li>
		<li><a href="#"> 需求反馈 </a></li>
	</ul>
</div>
<!-- /span3 -->
<!--
<div class="col-md-3" role="main">
	<h5>新手入门</h5>
	<ul class="list-unstyled">
		<li><a href="#"> 注册条款</a></li>
		<li><a href="#"> 规则解读</a></li>
		<li><a href="#"> 新手引导</a></li>
		<li><a href="#"> 购物流程</a></li>
	</ul>
</div>
<!-- /span3 -->
<!--
<div class="col-md-3" role="main">
	<h5>商家入驻</h5>
	<ul class="list-unstyled">
		<li><a href="#"> 商家规则</a></li>
		<li><a href="#"> 后台使用</a></li>
		<li><a href="#"> API接口</a></li>
	</ul>
</div>
<!-- /span3 -->
<!--
<div class="col-md-3" role="main">
	<h5>购物保障</h5>
	<ul class="list-unstyled">
		<li><a href="#"> 七天无理由退换货</a></li>
		<li><a href="#"> 相关证书</a></li>
		<li><a href="#"> 质检证明</a></li>
		<li><a href="#"> 经营性网站备案</a></li>
	</ul>
</div>
<!-- /span3 -->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" /> 
<title>用js批量处理a标签的target属性_blank</title> 
</head> 
<body> 
<a href="http://www.5ixuexiwang.com">正常链接测试</a> 
<div id="test"> 
<a href="http://www.5ixuexiwang.com">被JS处理过的链接测试</a> 
</div> 
<script language="JavaScript"> 
var anchors = document.getElementById("test").getElementsByTagName("a"); 
for(i=0;i<anchors.length;i++){ 
var anchor_item = anchors[i]; 
anchor_item.target="_blank"; 
} 
</script> 
</body> 
</html> 
