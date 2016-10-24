$(document).ready(function(){NProgress.start();});
window.onload = function(){NProgress.done();}
function getURLVar(key) {
	var value = [];

	var query = String(document.location).split('?');

	if (query[1]) {
		var part = query[1].split('&');

		for (i = 0; i < part.length; i++) {
			var data = part[i].split('=');

			if (data[0] && data[1]) {
				value[data[0]] = data[1];
			}
		}

		if (value[key]) {
			return value[key];
		} else {
			return '';
		}
	}
}

$(document).ready(function(){
	$('a.navbar-brand-logo').parent().attr("style", "line-height:0px");
	
		if($(window).width() < 994){
			$('#content').removeAttr("style");
			$('#product-image-big').attr("style", "padding: 0");
			$('.bootsnav').hide();
			$('#mobile-menu').show();
		}else{
			if(!$('#content').hasClass('login-top') && $('#nav-menu').hasClass('navbar-sticky')){
				$('#content').attr("style", "margin-top: 70px");
			}
			
			$('#product-image-big').attr("style", "padding: 5px");
			$('.bootsnav').show();
			$('#mobile-menu').hide();
		}
	
		$(window).resize(function(){
				if($(window).width() < 994){
					$('#content').removeAttr("style");
					$('#product-image-big').attr("style", "padding: 0");
					$('.bootsnav').hide();
					$('#mobile-menu').show();
				}else{
					if(!$('#content').hasClass('login-top') && $('#nav-menu').hasClass('navbar-sticky')){
						$('#content').attr("style", "margin-top: 70px");
					}
					$('#product-image-big').attr("style", "padding: 5px");
					$('.bootsnav').show();
					$('#mobile-menu').hide();
				}
			});
	
		$(document).keyup(function(event){
				if(event.keyCode ==13){
					$("#submit").trigger("click");
				}
			});
		// 切换语言
		$('#language a').on('click', function(e) {
				e.preventDefault();
				NProgress.start();
		
				//发送的数据
				var language_id=$(this).attr("href");
		
				$.get("index.php/common/language.html?language_id="+language_id,function(){
						NProgress.done();
						window.location.reload();//刷新当前页面.
					});
			});

		// 切换货币
		$('#currency a').on('click', function(e) {
				e.preventDefault();
		
				NProgress.start();

				//发送的数据
				var language_id=$(this).attr("href");
				$.get("index.php/common/currency.html?currency_id="+language_id,function(){
						NProgress.done();
						window.location.reload();//刷新当前页面.
					});
			});
	
		$('#language-list li:first').addClass('active');
		$('#language-form .tab-pane:first').addClass('active');
	
		/*
		$('li.dropdown').mouseover(function() {
		$(this).addClass('open');
		}).mouseout(function() {
		$(this).removeClass('open');
		}); 
		*/

		//初始化提示
		$(function () {
			$('[data-toggle="popover"]').popover({trigger: 'hover'})
		});


		//懒惰加载
		//$("img .lazy").lazyload();
		$("img.lazy").lazyload({
			placeholder : "public/resources/default/image/points.png",
			threshold : 180,
			effect : "fadeIn",
			//effect : "slideDown",
			failure_limit : 30
		});

		//加入购物车
		$('button[id=add_cart]').click(function(){
			//alert($(this).html());
		});
	
		//回顶部
		$.goup({bottomOffset: 150,containerColor: '#fff',arrowColor: '#666',});
	});

$(function() {
		$("img.lazy-auto").lazyload({
				event : "sporty"
			});
	});

function lazy_load(){
	$("img.lazy").lazyload({
			placeholder : "public/resources/default/image/points.png",
			threshold : 180,
			effect : "fadeIn",
			//effect : "slideDown",
			failure_limit : 30
		});
}

$(window).bind("load", function() {
		var timeout = setTimeout(function() {
				$("img.lazy-auto").trigger("sporty")
			}, 100);
	});

function getCookie(name)
{
	var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
	if(arr=document.cookie.match(reg))
	return unescape(arr[2]);
	else
	return false;
}

//搜索框
$(function () {
		//$('input:text:first').focus();
		var $inp = $('input:text');
		$inp.bind('keydown', function (e) {
				var key = e.which;
				if (key == 13) {
					e.preventDefault();
					$('#openant-search').submit();
				}
			});
	});

//提交表单
function submit(id){
	$('#' + id).submit(); 
}

function mylogin(id){
	//$('#'+id).click(function(){
	$('#mylogin .active').removeClass("active");
	$('#mylogin .'+id).addClass("active");
	//});
}

//退出登陆
function logout(){
	$.get("index.php/user/signin/logout.html",function(){
		window.location.reload();
	});
}

//自定义验证，输入只能是中英数字下划线
$.validator.addMethod("cn_edu",function(value,element,params){  
		var result=value.match(/^[A-Za-z0-9_\u4e00-\u9fa5]+$/);
		if(result==null) return false;
		return true;
	},"只能输入中文、英文、数字、下划线！");

//自定义验证，输入只能是中英数字下划线点@
$.validator.addMethod("cn_educ_",function(value,element,params){  
		var result=value.match(/^[A-Za-z0-9_.@\u4e00-\u9fa5]+$/);
		if(result==null) return false;
		return true;
	},"只能输入中文、英文、数字、下划线、.@符！");


jQuery(document).ready(function() {
		if(window.console&&window.console.error){
			console.log('这是一个开发中的测试网站\n现在我们还不能提供完整的功能');
		}
	});

$(function () {
		$('[data-toggle="tooltip"]').tooltip()
	});


//将form转为AJAX提交
function ajaxSubmit(frm, fn) {
	var dataPara = getFormJson(frm);
	//writeObj(dataPara);
	var url = frm.attr("action");
	var type = frm.attr("method");
	$.ajax({
			url: url,
			type: type,
			data: dataPara,
			success: fn
		});
}

//将form中的值转换为键值对。
function getFormJson(frm) {
	var o = {};
	var a = $(frm).serializeArray();
	$.each(a, function () {
			if (o[this.name] !== undefined) {
				if (!o[this.name].push) {
					o[this.name] = [o[this.name]];
				}
				o[this.name].push(this.value || '');
			} else {
				o[this.name] = this.value || '';
			}
		});

	return o;
}

//打印对象内容【测试用】
function writeObj(obj){ 
	var description = ""; 
	for(var i in obj){   
		var property=obj[i];   
		description+=i+" = "+property+"\n";  
	}   
	alert(description); 
} 


//转义
function html_encode(str)   
{   
	var s = "";   
	if (str.length == 0) return "";   
	s = str.replace(/&/g, "&gt;");   
	s = s.replace(/</g, "&lt;");   
	s = s.replace(/>/g, "&gt;");   
	s = s.replace(/ /g, "&nbsp;");   
	s = s.replace(/\'/g, "&#39;");   
	s = s.replace(/\"/g, "&quot;");   
	s = s.replace(/\n/g, "<br>");   
	return s;   
}   
 
 
//反转义
function html_decode(str)   
{   
	var s = "";   
	if (str.length == 0) return "";   
	s = str.replace(/&gt;/g, "&");   
	s = s.replace(/&lt;/g, "<");   
	s = s.replace(/&gt;/g, ">");   
	s = s.replace(/&nbsp;/g, " ");   
	s = s.replace(/&#39;/g, "\'");   
	s = s.replace(/&quot;/g, "\"");   
	s = s.replace(/<br>/g, "\n");   
	return s;   
}

//滑动支持
/*
$('#carousel-generic').hammer().on('swipeleft', function(){

$(this).carousel('next');

});

$('#carousel-generic').hammer().on('swiperight', function(){

$(this).carousel('prev');

});
*/