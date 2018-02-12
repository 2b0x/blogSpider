<?php

session_start();
unset( $_SESSION['username'] );
unset( $_SESSION['email'] );
unset( $_SESSION['height'] );
unset( $_SESSION['weight'] );
unset( $_SESSION['target'] );
unset( $_SESSION['userpic'] );

$ref = $_SERVER["HTTP_REFERER"];
header("Location:" . $ref);

exit ;
?>