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

//	echo $focuType;
	
	include('updateInfo.html');
?>