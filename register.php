<?php
		require('conn.php');

			$nameTag = time();
			$filename = $nameTag . '0' . substr($_FILES['photo']['name'], strrpos($_FILES['photo']['name'],'.'));  
			$response = array();
			$path = "img/personPic/"  . $filename;  
						
			$user_name = $_POST['username'];
			$user_email = $_POST['email'];
			$user_intro = $_POST['intro'];
			$user_focus = $_POST['focus'];
			$password = $_POST['password'];
			
//			echo $user_name . '--' . $user_email . '--' . $user_intro . '--' . $user_focus . '--' . $password . '--' . $path;
			
			if(move_uploaded_file($_FILES['photo']['tmp_name'], $path) ){
				$sqlstr = "insert into user(email,username,intro,focus,password,personpic) values('".$user_email."','".$user_name."','".$user_intro."','".$user_focus."','".$password."','".$path."')"; 
				@mysql_query($sqlstr) or die(mysql_error()); 
				echo 1; 
			}else{  
			    $response['isSuccess'] = false;  
			}  
////			echo '<p><img src="' . $path .'" width="150"></p>'; 
//			Header("Location: login.php"); 
			exit();  
	
		


?>  

