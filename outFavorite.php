<?php
	header("Content-type: text/html; charset=utf-8");
	require ('conn.php');	

	session_start(); 
	 
	//登录状态
	if(!empty($_SESSION['email'])){
		$userEmail = $_SESSION['email'];
		$artiId = $_POST['artiId'];

		//取消收藏
		$outFavoriteSQL = "DELETE FROM favorite WHERE artiId='" . $artiId . "' and userEmail='" . $userEmail ."'";
		mysql_query($outFavoriteSQL) or die("outFavoriteErro"); 
		echo '1';
	}else{
		echo 'unlogin';
	}
	
	
	


	
?>