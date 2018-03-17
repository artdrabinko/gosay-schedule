<?php
session_start();

$LEVEL = 0;
require_once('php/router.php');
require_once('../db/connect_to_DB.php');
require_once('php/update_password.php');

?>


<!DOCTYPE html>
<html>
 <head>
  <meta charset="utf-8" />
  <title>HTML5</title>

  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <!-- Custom styles for this template -->

 </head>
 <body style="background-color: #f5f5f5; padding-top: 70px;">

   <?php
     require_once('templates/admin_navbar.php');
   ?>

  <div class="container">
    <div class="row">
    <!-- /#sidebar-wrapper -->
      <div class="col-3 ">
          <div class="list-group">
             <h5 class="list-group-item" style="background: #f2f2f2;">Настройки</h5>
             <a href="settings_staff.php"  class="list-group-item">Аккаунт</a>
        </div>
      </div>
   <!-- /#sidebar-wrapper -->


      <div class="col-9">
         <div class="Subhead">
            <h3>Смена пароля</h3><hr>
         </div>
         <?php
         if( empty($errors) && isset( $_POST['btn_update_password'] ) ){
            echo '<div class="col-6 pl-0">
                     <div class="alert alert-success">Пароль успешно изменён!</div>
                  </div>';
         }

         if( !empty($errors) ){
            echo '<div class="col-6 pl-0">
                     <div class="alert alert-danger">'.array_shift($errors).'</div>
                  </div>';
         }

         ?>

         <form action='settings_staff.php' method="POST">
           <div class="form-group col-6 pl-0">
              <label for="exampleInputEmail1"><b>Старый пароль</b></label>
              <input type="password" name="old_password" class="form-control" >
           </div>

           <div class="form-group col-6 pl-0">
             <label for="exampleInputPassword1"><b>Новый пароль</b></label>
             <input type="password" name="new_password" class="form-control" >
           </div>

           <div class="form-group col-6 pl-0">
             <label for="exampleInputPassword1"><b>Повторите новый пароль</b></label>
             <input type="password" name="confirm_password" class="form-control" >
           </div>

           <div class="form-group col-6 pl-0">
                <button type="submit" name="btn_update_password" class="btn btn-info">
                  Обновить пароль
               </button>
               <label class="ml-3" tyle="font-size: 15px;"><a href="admin.php?forgot_password=forgot" alt="/admin">Забыли пароль?</a></label>
           </div>
         </form>
      </div>


    </div>
  </div>

  <?php
      require_once('../main_templates/basic_scripts.php');
    ?>


   <style media="screen">
  .list-group a{
      border-left: 3px solid #e36209;
  }

  .header-item {

     background-color: rgb(243, 245, 248);
     border-bottom: 1px solid rgba(0,0,0,.1);
  }
  .menu-settings a{
     background-color: rgb(243, 245, 248);
  }
  .menu-settings a:hover{
     background-color: rgb(243, 245, 248);
  }
  </style>

 </body>
 </html>
