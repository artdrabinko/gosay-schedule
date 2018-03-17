<?php

$MainURL = "/site/admin";
$ResetPageURL = "/site/admin/password_reset.php";

if( isset( $_GET['action'] ) ){
  if ( $_GET["action"] == "out" ) {
    session_destroy();
    header( "Location: ". $MainURL );
    exit();
  }
  //Other action
}


if( isset( $_GET['forgot_password'] ) ){
  if ( $_GET["forgot_password"] == "forgot" ) {
    session_destroy();
    header( "Location: ". $ResetPageURL );
    exit();
  }
  //Other action
}

//Проверяем авторизован ли пользователь
if ( !isset( $_SESSION['logged_user'] ) ) {
    header("Location: ". $MainURL);
}

//Если level != 1 редирект на $MainURL
if ( (int)$_SESSION['logged_user']['level'] != $LEVEL ){
   header( "Location: ". $MainURL );
}


?>
