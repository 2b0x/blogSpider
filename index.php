<?php
	require ('conn.php');	
	session_start();

	$username = $_SESSION['username'];
	$userEmail = $_SESSION['email'];
	$focus = $_SESSION['focus'];
	$userpic = $_SESSION['userpic'];
	
	//统计关注数量
	$focusNum = count(explode("-",$focus))-1;
	
	
		
	//统计用户收藏文章数
	$favoriteNumSQL = "select count(*) from favorite where userEmail='" . $userEmail ."'";
	$favoriteNumRS = mysql_query($favoriteNumSQL) or die ("checkFavorErro");
	while($row = mysql_fetch_array($favoriteNumRS)){  
	    $count = $row;  
	} 
	$favoriteNum = $count[0];
	
	
	include('index.html');
?>