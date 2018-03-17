<?php
$data = $_POST;
$ulr_success = '/site/admin';
$login_is_correct = true;


$AdminURL = '/site/admin/admin.php';
$UserURL = '/site/admin/staff.php';

//Если level 1 редирект на $AdminURL
if ( isset( $_SESSION['logged_user'] ) && (int)$_SESSION['logged_user']['level'] == 1 ){
   header( "Location: ". $AdminURL );
}

//Если level 0 редирект на $UserURL
if ( isset( $_SESSION['logged_user'] ) && (int)$_SESSION['logged_user']['level'] == 0 ){
   header( "Location: ". $UserURL );
}


if(isset($_GET['accesscheck'])) $_SESSION['PrevUrl'] = $_GET['accesscheck'];

if(isset($data['do_login'])){

  //здесь авторизация

  //получаем данные из формы
  $input_login = $data['input_login'];
  $input_password = $data['input_password'];

  $errors = array();
  $user =  R::findOne( 'users', 'login = ?', array($input_login) );

  if($user){
    //логин существует, проверяем пароль
    //if( password_verify($input_password, $user->password) ){
    if($input_password == $user->password){
      //session_regenerate_id(true);
      $group_name = '-';
      if($user->level == 0) {
         $group =  R::findOne( 'groups', 'id = ?', array($user->id_group) );
         $group_name = $group->group_name;
      }

      $user_data = $arrayName = array('id' => $user->id,
                                      'login' => $user->login,
                                      'level' => $user->level,
                                      'email' => $user->email,
                                      'ig_group' => $user->id_group,
                                      'group_name' => $group_name);

      $_SESSION['logged_user'] = $user_data;
      R::close();

      header("Location: ". $ulr_success);

      echo '<div style="color: #00FF02;">Good!</div><hr>';
      $login_is_correct = true;

    }else{
      $errors[] = "Password is not correct";
    }

  }else{
    $errors[] = "User not exist!";
  }

  if( !empty($errors) ){
    $login_is_correct = false;
    R::close();
    echo '<div style="color: red;">'.array_shift($errors).'</div><hr>';
  }


}

 ?>
