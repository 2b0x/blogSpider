<?php
	
	require('conn.php');
	
	if(empty($_POST[type])){
		$type=1;
	}else{
		$type = $_POST[type];
	}
	
	if(empty($_POST[page])){
		$page=1;
	}else{
		$page = $_POST[page];
	}
	
	$pageEnd=$page*10;
	$pageStart=$pageEnd-10;



//	$sql = "SELECT * FROM dom2 WHERE type='" . $type . "' LIMIT " . $pageStart .  ",20";   
  
	$sql = "SELECT * FROM dom2 WHERE type='" . $type . "'";     

	$rs = mysql_query($sql) or die ("查询失败"); 
	$data = array(); 
	while($row = mysql_fetch_array($rs)){  
	    $data[] = $row;  
	} 
	$datas = array();
	$length=count($data);
	for($i=0;$i<$length;$i++){	
		$datas[$i][title] = $data[$i][title];
		$datas[$i][href] = $data[$i][href];
		$datas[$i][from] = $data[$i][from];
	}
	
	echo urldecode(json_encode($datas));	

	mysql_close();
	
?>


	


