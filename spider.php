<?php

header("content-type:text/html;charset=utf-8");
include_once('simple_html_dom.php');
require('conn.php');


$type;

$sub = $_POST['type'];
if ("Java"==$sub){  
	$url = ['http://www.iteye.com/blogs/tag/Java',
		   'http://blog.51cto.com/artcommend/15/p1',
		   'http://www.cnblogs.com/cate/java/#p1']; 
	$type = '1'; 
}else if("Web"==$sub){  
	$url = ['http://www.iteye.com/blogs/category/web',
		   'http://blog.51cto.com/artcommend/30/p1',
		   'http://www.cnblogs.com/cate/web/#p1'];
	$type = '2'; 
}else if("Android"==$sub){  
	$url = ['http://www.iteye.com/blogs/tag/Android',
		   'http://blog.51cto.com/artcommend/99',
		   'http://www.cnblogs.com/cate/android/#p1'];
	$type = '3'; 
}else if("PHP"==$sub){  
	$url = ['http://www.iteye.com/blogs/tag/PHP',
		   'http://blog.51cto.com/artcommend/60/p1',
		   'http://www.cnblogs.com/cate/php/#p1'];
	$type = '4'; 
} 
$t1 = microtime(true);

for($i=0;$i<3;$i++){
	getTitle($url[$i]);
}

$t2 = microtime(true);
//echo '耗时'.round($t2-$t1,3).'秒<br><br>';
//echo urldecode(json_encode($tits));
//echo $te;
echo round($t2-$t1,3);

//获取整页面
function getData($url){
	$header[]="User-Agent:Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36";  
	$header[]="Cache-Control: max-age=0";     
	$header[]="Connection: keep-alive";  
	$header[]="Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8";   
	$header[]="Accept-Language: zh-CN,zh;q=0.8,en-US;q=0.5,en;q=0.3"; 
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_HTTPHEADER,$header);  
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}


function getTitle($u){
    $d = getData($u);
    $ds = str_get_html($d);
//	global $tits;
	global $type;

	$tits = array();

	if(strstr($u,"iteye")){
		// the rule is param for ITEYE
	    $range = $ds->find('div.blog h3 a');
		$from = "ITEYE";
	}else if(strstr($u,"51cto")){
		// the rule is param for 51CTO
   		$range = $ds->find('a[class=tit]');
		$from = "51CTO";
	}else if(strstr($u,"cnblogs")){
	    // the rule is param for 博客园
	    $range = $ds->find('div.post_item_body h3 a');
		$from = "博客园";
	}
	
    foreach($range as $e){
        $tits[0][] .= $e->plaintext;
        $tits[1][] .= $e->href;
    }
	
	$time = date("Y-m-d H:i:s");
	
	for($i=0;$i<count($tits[0]);++$i){
		$sqlstr = "insert into article(title,href,arttype,artfrom) values('".$tits[0][$i]."','".$tits[1][$i]."',".$type.",'".$from."')"; 
		@mysql_query($sqlstr)or die(mysql_error()); 
	}
}

?>