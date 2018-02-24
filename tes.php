<?php
	header("Content-type: text/html; charset=utf-8");
	require ('conn.php');
	
	$sql = "SELECT content FROM dom2 WHERE id=319";   

	
	//mysql查询语句
//	
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

//https://www.cnblogs.com/nnngu/p/8467440.html
//http://blog.51cto.com/ityouknow/1964495
$url = 'http://david-wrong.iteye.com/blog/2411461';
	
	
	include ('tes.html');
?>
