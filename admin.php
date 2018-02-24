<?php
	
	session_start(); 
//	if(empty($_SESSION['adminName'])){
//		echo '<script> alert("请先登录管理员帐号");</script>';
//		header("Location:adminLog.html");
//	}else{
		$adminName = $_SESSION['adminName'];
		include('admin.html');
//	}
	
	
?>