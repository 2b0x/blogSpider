<?php

	require('conn.php');
	
	$email = $_POST['email'];

	$sql = "select count(*) from user where email='" . $email . "'";
	$rs = mysql_query($sql) or die ("统计失败");
	
	while($row = mysql_fetch_array($rs)){  
	    $count = $row;  
	} 
	
	echo urldecode(json_encode($count));	

	mysql_close();
	
?>