<?php
session_start();

require_once('../db/connect_to_DB.php');
require_once('./libs/authorization.php');

$isErrorShow = false;
$isEmailSend = false;

function reset_password($email) {
   $user =  R::findOne( 'users', 'email = ?', array($email) );
   R::close();
   if($user){
      require_once('../mailer/reset_email.php');

      $password = getRandomPassword(10);

      $user->password = $password;
      R::store($user);
      R::close();
      //send_email($email, $password);
      $password = "";
      return true;
   }else {
      return false;
   }
}


if ( isset($_POST['do_reset'])) {
   if ( isset($_POST['email']) && $_POST['email'] != "") {
      //echo "$_POST['email']";
      //echo $_POST['email'];
      if(reset_password( $_POST['email'])) {
         $isErrorShow = false;
         $isEmailSend = true;
      }else{
         $isErrorShow = true;
      }

   }else {
      $isErrorShow = true;
   }
}

?>

<!DOCTYPE html>
<html lang="ru">
  <head>
    <title>Reset password</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php
       require_once('../main_templates/basic_styles.php');
    ?>
   </head>
  <body style="background-color: #f5f5f5; padding: 50px 0px 50px 0px;">
     <?php
      $page = '2';
      require_once('../main_templates/navbar.php');
    ?>
    <div class="container">

      <div class="row justify-content-center">
        <div class="col-12 col-auto mt-4">
            <h4 style="text-align:center; padding-top: 30px; padding-bottom: 15px;">Восстановление пароля</h4>
        </div>
      </div>

      <?php
      if($isEmailSend) { require_once("templates/success_reset_email.php");  }
      if($isErrorShow) { require_once("templates/error_email.php"); }
      if( (!$isEmailSend && $isErrorShow) || (!$isEmailSend && !$isErrorShow) ) { require_once("templates/reset_password_form.php"); }
      ?>

    </div>

    <?php
      require_once('../main_templates/basic_scripts.php');
    ?>

  </body>
</html>
