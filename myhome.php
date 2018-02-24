<?php
	require ('conn.php');	
	session_start();

	if(!empty($_SESSION['username'])){
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
	//	print_r($favoriteClassNum);
		include('myhome.html');
	}else{
		echo '<script> alert("请先登录帐号");</script>';
		header("Location:login.html");
	}

	
?>