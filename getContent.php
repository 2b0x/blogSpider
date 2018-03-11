<?php
	header("Content-Type:text/html;charset=utf-8");
	include_once('simple_html_dom.php');
	require('conn.php');
	
	$artId = $_POST['href'];
	$artSQL = "select * from article where id='" . $artId . "'";
	$artRS = mysql_query($artSQL) or die ("统计失败");	
	$artData = array(); 
	while($row = mysql_fetch_array($artRS)){  
	    $artData[] = $row;  
	} 
	
	if( empty($artData[0]['content']) ){
//		echo "空";
		$url = $artData[0]['href'];
		
		preg_match_all("/(.*?).com/",$url,$datafrom);
		$targetURL = $datafrom[0][0];
		
		if(strstr($targetURL,"cnblogs")){
			$url = substr_replace($url,'',stripos($url,"s"),1);
		}
	
		$content=getContent($url);
		$artContent = $content[0];
		$test = htmlspecialchars($artContent, ENT_QUOTES);	
		// $test = html_entity_decode($artContent, ENT_QUOTES);	
		$getContSQL = "UPDATE article SET content='" . $test . "' where id='" . $artId . "'" ;
		if (!mysql_query($getContSQL)) {
			echo mysql_error();
//			echo "0";
		} else {
			echo "1";
		}
	}else{
		echo "1";
//		echo "非空";
		echo $test;
	}
	
	mysql_close();
	
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
	
	function getContent($u){
		$d = getData($u);
		$ds = str_get_html($d);
		$res = array(); 
		
		preg_match_all("/(.*?).com/",$u,$datafrom);
		$targetURL = $datafrom[0][0];
		
		if(strstr($targetURL,"iteye")){
			// the rule is param for ITEYE
		    $res = $ds->find('div[id=blog_content]');
			$from = "ITEYE";
		}else if(strstr($targetURL,"51cto")){
			// the rule is param for 51CTO
	   		$res = $ds->find('div[class=main-content]');
			$from = "51CTO";
		}else if(strstr($targetURL,"cnblogs")){
		    // the rule is param for 博客园
		    $res = $ds->find('div[id=cnblogs_post_body]');
			$from = "博客园";
		}
		return $res;
	}

?>