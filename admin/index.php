<?php
session_start();
require_once('../db/connect_to_DB.php');
require_once('./libs/authorization.php');

if ( isset($_SESSION['logged_user']) ) {
    echo $_SESSION['logged_user'];
}

?>

<!DOCTYPE html>
<html lang="ru">
  <head>
    <title>Entry to admin</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php
       require_once('../main_templates/basic_styles.php');
    ?>
   </head>
  <body style="background-color: #f5f5f5; padding-top: 50px;">
     <?php
      $page = '2';
      require_once('../main_templates/navbar.php');
    ?>
    <div class="container">

      <div class="row justify-content-md-center">
        <div class="col-12 col-md-auto col-lg-auto">
            <h4 style="text-align:center; padding-top: 30px; padding-bottom: 15px;">Вход в админ панель</h4>
        </div>
      </div>

      <div id="js_error_container" class="row justify-content-md-center mb-4"
      <?php
        if(!$login_is_correct){
          echo "style=\"visibility: visible;\"";
        }else {
          echo "style=\"display: none;\"";
        }
      ?>>
        <div class="col-12 col-md-auto col-lg-auto">
          <div clas="col-12" style=" padding: 10px 20px; min-width: 310px; height: 50px;text-align: center; border: 1px solid rgba(27, 31, 35, 0.15); border-radius: 5px; background: rgb(255, 220, 224);">
            <span style=" font-size: 15px; color: #86181d;">Неверный логин или пароль!</span>
          </div>
        </div>
      </div>

      <div class="row justify-content-md-center">
        <div class="col-12 col-md-auto col-lg-auto">
          <form  action='index.php' method="POST">
            <div clas="col-12" style="min-width: 310px; border: 1px solid #d8dee2; border-radius: 5px; padding: 20px; background: #fff;">
              <div class="form-group">
                <label for="exampleInputEmail1" style="font-size: 15px;"><b>Логин или e-mail адрес</b></label>
                <input id="input_login" type="text" name="input_login" value="<?php echo @$data['input_login'];?>" style="font-size: 15px;" class="form-control" aria-describedby="emailHelp" placeholder="Enter email">
              </div>
              <div class="form-group">
                <label style="font-size: 15px;"><b>Пароль</b></label>
                <label class="float-right" tyle="font-size: 15px;"><a href="password_reset.php" alt="/admin">Забыли пароль?</a></label>
                <input id="input_password" type="password" name="input_password" style="font-size: 15px;" class="form-control"  placeholder="Password">
              </div>
              <div class="control-group">
                <!-- Button -->
                <div class="controls">
                  <button id="buttonLogin" name="do_login" type="submit" class="btn btn-block btn-success mt-4" style="cursor: pointer; color: #fff; font-size: 15px;"><b >Войти</b></button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>

      <div class="row justify-content-md-center">
      </div>
    </div>



    <?php
      require_once('../main_templates/basic_scripts.php');
    ?>

  </body>
</html>
