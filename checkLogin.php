<?php
include('conn.php');  

$userEmail = $_POST['userEmail'];
$password = $_POST['password'];


//检测用户名及密码是否正确  
$check_query = mysql_query("select * from user where email='$userEmail' and password='$password' limit 1");  
if($result = mysql_fetch_array($check_query)){  
    //登录成功  
    session_start();  
    $_SESSION['username'] = $result['username'];  
    $_SESSION['email'] = $result['email'];  
    $_SESSION['intro'] = $result['intro'];  
    $_SESSION['focus'] = $result['focus'];  
    $_SESSION['userpic'] = $result['personpic']; 
	echo '1';
	exit;  
} else {
    exit('0');  
}  

?>