<?php
	
	// header("Content-type:text/html;charset='utf8'");
	// error_reporting(0); 
	
	$conn = @mysql_connect('localhost' , 'root' , 'root') or die(mysql_error());
	mysql_query('set names utf8' , $conn);
	@mysql_select_db('blogspd' , $conn) or die(mysql_error());
		
?>