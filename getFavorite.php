<?php
	header("Content-type: text/html; charset='utf-8'");
	
	require('conn.php');
	
	session_start();  
	$userEmail = $_SESSION['email'];
	
	//获取文章信息
	$getArtiSQL = "SELECT * FROM favorite WHERE userEmail='" . $userEmail . "'  order by addTime desc";   
	$artiRS = mysql_query($getArtiSQL) or die("查询失败");
	$artiData = array();
	while ($row = mysql_fetch_array($artiRS)) {
		$artiData[] = $row;
	}
	$artiDatas = array();
	$length=count($artiData);
	for($i=0;$i<$length;$i++){	
		$artiDatas[$i]['artiId'] = $artiData[$i]['artiId'];
		$artiDatas[$i]['artiTitle'] = $artiData[$i]['artiTitle'];
		$artiDatas[$i]['artiFrom'] = $artiData[$i]['artiFrom'];
		$artiDatas[$i]['artiType'] = $artiData[$i]['artiType'];
		$artiDatas[$i]['addTime'] = $artiData[$i]['addTime'];
	}
	for($i=0;$i<$length;$i++){	
		switch ($artiDatas[$i]['artiType']) {
			case '1':
				$artiDatas[$i]['artiType'] = 'Java';
				break;
			case '2':
				$artiDatas[$i]['artiType'] = 'Web';
				break;
			case '3':
				$artiDatas[$i]['artiType'] = 'Android';
				break;
			case '4':
				$artiDatas[$i]['artiType'] = 'PHP';
				break;
			default:
				break;
		}
	}
	echo urldecode(json_encode($artiDatas));
	
	mysql_close();
	
?>


	


