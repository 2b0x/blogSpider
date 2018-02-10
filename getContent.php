<?php
	header("Content-Type:text/html;charset=utf-8");
	include_once('simple_html_dom.php');
	require('conn.php');
	
	$artId = $_POST['href'];
	$sql = "select * from dom2 where id='" . $artId . "'";
	$rs = mysql_query($sql) or die ("统计失败");	
	$data = array(); 
	while($row = mysql_fetch_array($rs)){  
	    $data[] = $row;  
	} 
	
	if( empty($data[0][content]) ){
//		echo "空";
		$url = $data[0][href];
		$content=getContent($url);
		$test = htmlspecialchars($content, ENT_QUOTES);	
		$getContSQL = "UPDATE dom2 SET content='" . $test . "' where id='" . $artId . "'" ;
		if (!mysql_query($getContSQL)) {
			echo mysql_error();
//			echo "0";
		} else {
			echo "1";
		}
		
	}else{
//		echo "非空";
	}
	
//	echo $artId;
	
//	echo empty($data[0][content]); 判断内容是否为空
	
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
//		$res = $ds->find('div[id=blog_content]');//iteye的规则
		$res = $ds->find('div[class=main-content]');//51CTO的规则
		return $res[0];
	}
?>