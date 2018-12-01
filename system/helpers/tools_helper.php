<?php

defined('BASEPATH') OR exit('No direct script access allowed');

if( ! function_exists('vpost')){
	//post请求
	function vpost($url,$data=''){ // 模拟提交数据函数
		
		$curl = curl_init(); // 启动一个CURL会话
		curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2); // 从证书中检查SSL加密算法是否存在
		curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 0); // 使用自动跳转
		curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
		curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包
		curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
		curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
		$tmpInfo = curl_exec($curl); // 执行操作
		if(curl_errno($curl)){
			echo 'Errno-'.curl_error($curl);//捕抓异常
		}
		curl_close($curl); // 关闭CURL会话
	
		return $tmpInfo;// 返回数据
	}
}

if( ! function_exists('vget')){
	function vget($url){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
		curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		$result = curl_exec($ch);
		curl_close ($ch);
		return $result;
	}
}

if( ! function_exists('randrgb')){
	//post请求
	function randrgb(){  
		$str='0123456789ABCDEF';  
		$estr='#';  
		$len=strlen($str);  
		for($i=1;$i<=6;$i++){  
			$num=rand(0,$len-1);    
			$estr=$estr.$str[$num];   
		}  
		return $estr;  
	}
}

/**
* 生成从开始月份到结束月份的月份数组
* @param int $start 开始时间戳
* @param int $end 结束时间戳
* @tpye string 时间类型，year、quarter、month、day、hour、minute
*/
if( ! function_exists('monthList')){
	function dateList($start, $end, $type){
	    if(!is_numeric($start)||!is_numeric($end)||($end<=$start) || empty($type)) return '';
	    
	    if($type == 'year'){
			//年
			$start=date('Y', strtotime ("+1 day", $start));
		    $end=date('Y',$end);
		    //转为时间戳
		    $start=strtotime($start.'-01');
		    $end=strtotime($end.'-01');
		}
		
		//季度
		if($type == 'quarter'){
			//季度
			$start=date('Y-m', strtotime ("+1 day", $start));
		    $end=date('Y-m',$end);
		    //转为时间戳
		    $start=strtotime($start.'-01');
		    $end=strtotime($end.'-01');
		}
		
	    //月
	    if($type == 'month'){
			$start=date('Y-m', strtotime ("+1 day", $start));
		    $end=date('Y-m',$end);
		    //转为时间戳
		    $start=strtotime($start.'-01');
		    $end=strtotime($end.'-01');
		}
		
		//日
	    if($type == 'day'){
			$start=date('Y-m-d', strtotime ("+1 day", $start));
		    $end=date('Y-m-d',$end);
		    //转为时间戳
		    $start=strtotime($start.' 00:00');
		    $end=strtotime($end.' 00:00');
		}
		
		//小时
	    if($type == 'hour'){
			$end=date('Y-m-d H:i:s',$end);
		    $start=date("Y-m-d H:i:s",strtotime("$end -23 hour"));
		    
		    //转为时间戳
		    $start=strtotime($start);
		    $end=strtotime($end);
		}
		
		//分
	    if($type == 'minute'){
			$end=date('Y-m-d',$end);
		    $start=date("Y-m-d",strtotime("$end -1 hour"));
		    
		    //转为时间戳
		    $start=strtotime($start.' 00:01:00');
		    $end=strtotime($end.' 01:00:00');
		}
	    
	    $i=0;
	    $d=array();
	    while($start<=$end){
	        //这里累加每个月的的总秒数 计算公式：上一月1号的时间戳秒数减去当前月的时间戳秒数
	        if($type == 'year'){
				//年
				$d[$i]=trim(date('Y',$start),' ');
	        	$start+=strtotime('+1 year',$start)-$start;
			}
			if($type == 'quarter'){
				//季度
				$d[$i]=trim(date('Y',$start),' ').'-'.ceil(date('m',$start)/3);
	        	$start+=strtotime('+3 month',$start)-$start;
			}
	        if($type == 'month'){
	        	//月
				$d[$i]=trim(date('Y-m',$start),' ');
	        	$start+=strtotime('+1 month',$start)-$start;
			}
			
			if($type == 'day'){
	        	//日
				$d[$i]=trim(date('Y-m-d',$start),' ');
	        	$start+=strtotime('+1 day',$start)-$start;
			}
			if($type == 'hour'){
	        	//小时
				$d[$i]=trim(date('Y-m-d H', strtotime ("-1 hour", $start)).':00',' ');
	        	$start+=strtotime('+1 hour',$start)-$start;
			}
			
			if($type == 'minute'){
	        	//分
				$d[$i]=trim(date('Y-m-d H:i:s', strtotime ("-1 minute", $start)),' ');
	        	$start+=strtotime('+1 minute',$start)-$start;
			}
	        $i++;
	    }
	    return $d;
	}
}

/* 
*function：计算两个日期相隔多少年，多少月，多少天 
*param string $date1[格式如：2011-11-5] 
*param string $date2[格式如：2012-12-01] 
*return array array('年','月','日'); 
*/
if( ! function_exists('diffDate')){
	function diffDate($date1,$date2){  
	    if(strtotime($date1)>strtotime($date2)){  
	        $tmp=$date2;  
	        $date2=$date1;  
	        $date1=$tmp;  
	    }  
	    list($Y1,$m1,$d1)=explode('-',$date1);  
	    list($Y2,$m2,$d2)=explode('-',$date2);  
	    $Y=$Y2-$Y1;  
	    $m=$m2-$m1; 
	    $d=$d2-$d1;  
	    if($d<0){  
	        $d+=(int)date('t',strtotime("-1 month $date2"));  
	        $m--;  
	    }  
	    if($m<0){  
	        $m+=12;  
	        $Y--;  
	    }  
	    return array('year'=>$Y,'month'=>$m,'day'=>$d);  
	}
}