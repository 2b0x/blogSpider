<?php
	header("Content-type: text/html; charset=utf-8");
	require ('conn.php');	

	session_start(); 
	 
	//登录状态
	if(!empty($_SESSION['email'])){
		$userEmail = $_SESSION['email'];
		$artiId = $_POST['artiId'];
		
		//获取文章信息
		$getArtiSQL = "SELECT * FROM article WHERE id='" . $artiId . "'";   
		$artiRS = mysql_query($getArtiSQL) or die("checkArtiErro");
		$artiData = array();
		while ($row = mysql_fetch_array($artiRS)) {
			$artiData[] = $row;
		}
		$artiTitle = $artiData[0]['title'];//获取文章标题
		$artiFrom = $artiData[0]['artfrom'];//获取文章来源
		$artiType = $artiData[0]['arttype'];//获取文章分类
		
		//添加收藏
		$addFavoriteSQL = "insert into favorite(artiTitle,artiFrom,artiType,artiId,userEmail) values('".$artiTitle."','".$artiFrom."','".$artiType."','".$artiId."','".$userEmail."')"; 
		mysql_query($addFavoriteSQL) or die("addFavoriteErro"); 
		echo '1';
	}else{
		echo 'unlogin';
	}
	
	
	


	
?>