<?php
require ('conn.php');

session_start();
$useremail = $_SESSION['email'];

$uname = $_POST['username'];
$intro = $_POST['intro'];
$focus = $_POST['focus'];
$password = $_POST['password'];

if (!empty($_FILES['photo']['tmp_name'])) {
	$nameTag = time();
	$filename = $nameTag . '0' . substr($_FILES['photo']['name'], strrpos($_FILES['photo']['name'], '.'));
	$photo = "img/personPic/" . $filename;
	move_uploaded_file($_FILES['photo']['tmp_name'], $photo);
} else {
	$photo = $_SESSION['userpic'];
}

if($password==''){
	$sqlstr = "UPDATE user SET username='" . $uname . "',intro='" . $intro . "',focus='" . $focus . "',personpic='" . $photo . "' where email='" . $useremail . "'";
}else{
	$sqlstr = "UPDATE user SET username='" . $uname . "',intro='" . $intro . "',focus='" . $focus . "',password='" . $password . "',personpic='" . $photo . "' where email='" . $useremail . "'";
}

if (!mysql_query($sqlstr)) {
	echo  mysql_error();
//	echo "0";
} else {
	//	echo "修改成功";
	$check_query = mysql_query("select * from user where email='$useremail'");  
	if($result = mysql_fetch_array($check_query)){  
	    //登录成功  
	    session_start();  
	    $_SESSION['username'] = $result['username'];  
	    $_SESSION['email'] = $result['email'];  
	    $_SESSION['intro'] = $result['intro'];  
	    $_SESSION['focus'] = $result['focus'];  
	    $_SESSION['userpic'] = $result['personpic']; 
	}
	echo "1";
}
?>