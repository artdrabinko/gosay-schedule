<?php
$errors = array();

if( isset( $_POST['btn_update_password'] ) ){

  //получаем данные из формы
  $old_password = $_POST['old_password'];
  $new_password = $_POST['new_password'];
  $confirm_password = $_POST['confirm_password'];

  $isPasswordsEqual = ($new_password == $confirm_password) ? true : false;


  $user =  R::findOne( 'users', 'login = ?', array($_SESSION['logged_user']['login']) );

  if($user && $isPasswordsEqual){
    //логин существует, проверяем пароль
    //if( password_verify($input_password, $user->password) ){
    if($old_password == $user->password){

      $user->password = $new_password;
      R::store($user);
      R::close();
    }else{
      $errors[] = "Неверный старый пароль";
    }

  }else{
    $errors[] = "Новый и подтвержденный пароли не совпали!";
  }
   R::close();

}

 ?>
