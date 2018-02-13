<?php
	require ('conn.php');	
	session_start();

	$username = $_SESSION['username'];
	$userEmail = $_SESSION['email'];
	$focus = $_SESSION['focus'];
	$userpic = $_SESSION['userpic'];
	$userintro = $_SESSION['intro'];
	
	$focuType = explode("-",$focus);
	$focuType = urldecode(json_encode($focuType));

	//统计用户收藏文章数
	$favoriteNumSQL = "select count(*) from favorite where userEmail='" . $userEmail ."'";
	$favoriteNumRS = mysql_query($favoriteNumSQL) or die ("checkFavorErro");
	while($row = mysql_fetch_array($favoriteNumRS)){  
	    $count = $row;  
	} 
	$favoriteNum = $count[0];

	//统计各分类收藏数
	$favoriteClassNumSQL = "select artiType,count(*) from favorite where userEmail='" . $userEmail . "' group by artiType";
	$favoriteClassNumRS = mysql_query($favoriteClassNumSQL) or die ("checkFavorErro");
	$countFavorite = array();
	while($row = mysql_fetch_array($favoriteClassNumRS)){  
	    $countFavorite[] = $row;  
	} 
	$favoriteClassNum = $countFavorite;
	$favoriteClassNum = urldecode(json_encode($favoriteClassNum));
	
	
//	print_r($favoriteClassNum);
	
	
	include('myhome.html');
?>