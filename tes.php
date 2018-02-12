<?php
	header("Content-type: text/html; charset=utf-8");
	include_once('simple_html_dom.php');
	require ('conn.php');
	
//	$sql = "SELECT content FROM dom2 WHERE id=319";   

	//mysql查询语句
	
//	$rs = mysql_query($sql) or die("查询失败");
//	$data = array();
//	while ($row = mysql_fetch_array($rs)) {
//		$data[] = $row;
//	}
//	$datas = array();
//	$length = count($data);
//	for ($i = 0; $i < $length; $i++) {
//		$datas[$i][title] = $data[$i][title];
//	}
//	
//	$str = htmlspecialchars_decode($data[0][0]);
//	
//	$str = preg_replace("#\s{3,}#", "\n", $str);
//	mysql_close();
	
//	include ('tes.html');

$url = 'http://localhost:88//blogSpD/tes.html';

$d = array();
$d = getContent($url);
print_r($d);
//echo $d[1];
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
//		$res = $ds->find('div[id=blog_content]');//iteye的规则
		$res[0] = $ds->find('a.name',0)->plaintext;//51CTO的规则
		$res[1] = $ds->find('a.time',0)->plaintext;
		return $res;
	}
?>
