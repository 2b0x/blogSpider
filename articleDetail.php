<?php
	header("Content-type: text/html; charset=utf-8");
	require ('conn.php');	
	session_start();  
	$userEmail = $_SESSION['email'];
	$articleId = $_GET['random'];

	//获取文章信息
	$getArtiSQL = "SELECT * FROM dom2 WHERE id='" . $articleId . "'";   
	$artiRS = mysql_query($getArtiSQL) or die("查询失败");
	$artiData = array();
	while ($row = mysql_fetch_array($artiRS)) {
		$artiData[] = $row;
	}
	$artiTitle = $artiData[0]['title'];//获取文章标题
	$artiFrom = $artiData[0]['from'];//获取文章来源
	$artiType = $artiData[0]['type'];//获取文章分类
	switch ($artiType) {
		case '1':
			$artiType = 'Java';
			break;
		case '2':
			$artiType = 'Web';
			break;
		case '3':
			$artiType = 'Android';
			break;
		case '4':
			$artiType = 'PHP';
			break;
		default:
			$artiType = '其他';
			break;
	}
	$artiTime = $artiData[0]['publishtime'];//获取文章发布时间
	$artiContent = htmlspecialchars_decode($artiData[0][2]);//获取文章内容
	$artiContent = preg_replace("#\s{3,}#", "\n", $artiContent);
	
	
	
	
	//判断是否有收藏 0为无 1为有
	$isFavorSQL = "select count(*) from favorite where artiId='" . $articleId . "' and userEmail='" . $userEmail ."'";
	$isFavorRS = mysql_query($isFavorSQL) or die ("checkFavorErro");
	while($row = mysql_fetch_array($isFavorRS)){  
	    $count = $row;  
	} 
	$isFavorite = $count[0];
	
	mysql_close();
	include ('articleDetail.html');

?>