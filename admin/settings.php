<?php
session_start();

$LEVEL = 1;
require_once('php/router.php');
require_once('../db/connect_to_DB.php');


if( isset($_POST['btn_add_new_user']) ){
   require_once('php/settings/add_new_user.php');

   echo "</br>";
   if( isAddNewUser( $_POST ) ){
      echo "SUCCESS";
   }else {
      echo "FAIL";
   }
}

$groups =  R::findAll('groups', 'ORDER BY group_name');
?>

<!DOCTYPE html>
<html>
 <head>
  <meta charset="utf-8" />
  <title>HTML5</title>

  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/settings.css">
  <!-- Custom styles for this template -->

 </head>
 <body style="background-color: #f5f5f5; padding-top: 80px;">

   <?php
     require_once('templates/admin_navbar.php');
   ?>

  <div class="container">
     <div class="row">
        <!-- /#sidebar-wrapper -->
       <div class="col-lg-3 col-md-3 col-sm-5">
           <div class="list-group">
              <h5 class="list-group-item">Настройки</h5>
              <span id="item_1" onclick="handler_click_item(1)" href="#" class="list-group-item select-item">Аккаунт</span>
              <span id="item_2" onclick="handler_click_item(2)" href="#" class="list-group-item">Добавить группу</span>
              <span id="item_3" onclick="handler_click_item(3)" href="#" class="list-group-item">Удалить группу</span>
              <span id="item_4" onclick="handler_click_item(4)" href="#" class="list-group-item">Добавить пользователя</span>
              <span id="item_5" onclick="handler_click_item(5)" href="#" class="list-group-item">Удалить пользователя</span>
              <span id="item_6" onclick="handler_click_item(6)" href="#" class="list-group-item">Сменить пароль</span>
         </div>
       </div>
       <!-- /#sidebar-wrapper -->


       <div class="col-lg-9 col-md-9 col-sm-7">

          <h3 id="settings_title" class="settings_title">Аккаунт</h3>
          <img id="load_data" class="hide" width="30px" height="30px" src="img/load.gif">
          <hr>
          <div class="col-md-6 pl-0">
             <div id="error_box" class="alert alert-danger alert-dismissible fade show hide" role="alert">
               <span id="error_box_text"></span>
               <button type="button" class="close" onclick="hide_message(1)">
               <span aria-hidden="true">&times;</span>
               </button>
             </div>
          </div>
          <div class="col-md-6 pl-0">
             <div id="success_box" class="alert alert-success alert-dismissible fade show hide" role="alert">
              <span id="success_box_text"></span>
              <button type="button" class="close" onclick="hide_message(2)">
                 <span aria-hidden="true">&times;</span>
              </button>
            </div>
          </div>


         <!-- <div id="error_box" class="col-6 alert alert-danger">Danger</div>
          <div id="success_box" class="col-6 alert alert-success">Success</div>-->

          <div id="setting_menu_1" class="">
             <p><b>Логин</b> : <?php echo $_SESSION['logged_user']['login']; ?><br>
               <b>Email</b>  : <?php echo $_SESSION['logged_user']['email']; ?><br><br>
               <b>Уровень доступа</b>  :
               <?php
                  if( $_SESSION['logged_user']['level'] == 1 ) echo 'Администратор';
                  else echo 'Персонал';
               ?>
            </p>
          </div>


          <div id="setting_menu_2" class="hide">
             <form method="POST" id="form_menu_2" action="javascript:void(null);" onsubmit="processing_form(2)">
               <label for="exampleInputEmail1"><b>Введите название группы</b></label>
               <div class="form-row col-md-6 p-0">
                <div class="form-group col-md-6">
                  <input id="in_group_name_menu_2" type="text" name="group_name" class="form-control" placeholder="СП777"  maxlength="5" >
                  <div class="valid-feedback">
                    Название свободно!
                  </div>
                  <div class="invalid-feedback">
                   Группа уже существует!
                 </div>
                </div>
                <div class="form-group col-md-6">
                  <button id="btn_form_menu_2" class=" col-md-12 btn btn-info" type="submit" name="btn-form-menu_2" disabled>
                    Добавить группу
                 </button>
                </div>
               </div>
            </form>
          </div>


          <div id="setting_menu_3" class="hide">
             <div id="setting_menu_3_about_group" class="col-md-6 pl-0 hide">
                <label>
                   <b>Информация о группе:</b>
                </label>
                <div class="about-box">
                   <label id="setting_menu_3_about_name" class="ml-2"></label><br />
                   <label id="setting_menu_3_about_staff" class="ml-2"></label><br />
                   <label id="setting_menu_3_about_subscribers" class="ml-2"></label><br />
                   <label id="setting_menu_3_about_lessons" class="ml-2"></label>
               </div>
             </div>
             <form method="POST" id="form_menu_3" action="javascript:void(null);" onsubmit="processing_form(3)">

               <div id="setting_menu_3_confirm" class="form-row col-md-6 p-1 hide">
                  <label><b>Введите пароль</b></label>
                  <input id="in_password_menu_3" type="password" name="password" class="form-control" maxlength="20" >
                  <div class="invalid-feedback">
                    Неверный пароль!
                  </div>
               </div>
               <label for="exampleInputEmail1"><b>Введите название группы</b></label>
               <div class="form-row col-md-6 p-0">
                <div class="form-group col-md-6">
                  <input id="in_group_name_menu_3" type="text" name="group_name" class="form-control" placeholder="СП777"  maxlength="5" >
                  <div class="valid-feedback">
                    Группа найдена!
                  </div>
                  <div class="invalid-feedback">
                    Группа не существует!
                 </div>
                </div>

                <div class="form-group col-md-6">
                  <button id="btn_form_menu_3" class=" col-md-12 btn btn-danger" type="submit" name="btn-form-menu_3" disabled>
                    Удалить группу
                 </button>
                </div>
               </div>

            </form>
          </div>


          <div id="setting_menu__" class="hide">
             <form method="POST" id="form_menu_4" action="javascript:void(null);" onsubmit="processing_form(4)">
               <label for="exampleInputEmail1"><b>Введите email</b></label>
               <div class="form-row col-md-6 p-0">
                <div class="form-group col-md-6">
                  <input id="in_group_name_menu_4" type="text" name="email" class="form-control" placeholder="ivanov@gmail.com"  maxlength="25" >
                  <div class="valid-feedback">
                    Email свободен!
                  </div>
                  <div class="invalid-feedback">
                    Пользователь с таким email уже существует!
                 </div>
                </div>
                <div class="form-group col-md-6">
                  <button id="btn_form_menu_4" class=" col-md-12 btn btn-info" type="submit" name="btn-form-menu_4" disabled>
                    Добавить группу
                 </button>
                </div>
               </div>
            </form>
          </div>


          <div id="setting_menu_5" class="hide">
             <div id="setting_menu_5_about_user" class=" col-md-6 pl-0 hide">
                <label>
                   <b>Информация о пользователе:</b>
                </label>
                <div class="about-box">
                   <label id="setting_menu_5_about_login" class="ml-2"></label><br />
                   <label id="setting_menu_5_about_email" class="ml-2"></label><br />
                   <label id="setting_menu_5_about_level" class="ml-2"></label><br />
                   <label id="setting_menu_5_about_relation" class="ml-2"></label>
               </div>
             </div>
             <form method="POST" id="form_menu_5" action="javascript:void(null);" onsubmit="processing_form(5)">

               <div id="setting_menu_5_confirm" class="form-group col-md-6 pl-0 hide">
                  <label><b>Введите пароль</b></label>
                  <input id="in_password_menu_5" type="password" name="password" class="form-control" maxlength="30" >
                  <div class="invalid-feedback">
                    Неверный пароль!
                  </div>
               </div>
               <label ><b>Введите email или логин пользователя</b></label>

                   <div class="form-group col-md-6 pl-0">
                      <input id="in_login_menu_5" type="text" name="login" class="form-control" placeholder="ivanov@gmail.com"  maxlength="30" >
                      <div class="valid-feedback">
                        Пользователь найден!
                      </div>
                      <div class="invalid-feedback">
                        Пользователь не существует!
                      </div>
                   </div>

                   <div class="form-row col-md-6 pl-1">
                     <button id="btn_form_menu_5" class="btn btn-danger" type="submit" name="btn-form-menu_5" disabled>
                       Удалить пользователя
                    </button>
                   </div>


            </form>
          </div>






          <div id="setting_menu_6" class="hide">
             <form method="POST" id="form_menu_6" action="javascript:void(null);" onsubmit="processing_form(6)">
              <div class="form-group col-md-6 pl-0">
                 <label for="exampleInputEmail1"><b>Старый пароль</b></label>
                 <input id="in_old_password_menu_6" type="password" name="old_password" class="form-control" >
                 <div class="invalid-feedback">
                   Неверный пароль!
                 </div>
              </div>

              <div class="form-group col-md-6 pl-0">
                <label for="exampleInputPassword1"><b>Новый пароль</b></label>
                <input id="in_new_password_menu_6" type="password" name="new_password" class="form-control" >
                <div class="invalid-feedback">
                  Пароли не совпали либо слишко простые!
                </div>
              </div>

              <div class="form-group col-md-6 pl-0">
                <label for="exampleInputPassword1"><b>Повторите новый пароль</b></label>
                <input id="in_confirm_password_menu_6" type="password" name="confirm_password" class="form-control" >
                <div class="invalid-feedback">
                  Пароли не совпали либо слишко простые!
                </div>
              </div>

              <div class="form-group col-md-6 pl-0">
                   <button id="btn_form_menu_6" type="submit" name="btn-form-menu_6" class="btn btn-info" disabled>
                     Обновить пароль
                  </button>
                  <label class="ml-3" tyle="font-size: 15px;"><a href="admin.php?forgot_password=forgot" alt="/admin">Забыли пароль?</a></label>
              </div>
            </form>
          </div>







       </div>
     </div>
 </div>

  <?php
      require_once('../main_templates/basic_scripts.php');
    ?>
 </body>
 </html>

































































































 <!--
  <div class="container">
    <div class="row">



      <div class="col-9">

       <div class="Subhead">
         <h3>Добавление нового пользователя</h3><hr>
       </div>
       <div class="row">



          <div class="col-8">
             <div class="col-8 alert alert-danger">LOl</div>
             <form action='settings.php' checkForm(); method="POST">
                 <div class="form-group  pl-0">
                    <label for="exampleInputEmail1"><b>Уровень доступа:</b></label>
                    <br>
                    <label class="custom-control custom-radio" >
                       <input onClick="setAccessLevel(0)"  name="level" type="radio" class="col-sm-9 custom-control-input" checked="checked" value="0">
                       <span class="custom-control-indicator"  ></span>
                       <span  class="custom-control-description">Староста</span>
                    </label>
                    <label class="custom-control  custom-radio" >
                       <input onClick="setAccessLevel(1)"  name="level" type="radio" class="col-sm-9 custom-control-input" value="1">
                       <span class="custom-control-indicator"  ></span>
                       <span class="custom-control-description">Администратор</span>
                    </label>
                 </div>

                 <div class="form-group col-md-8 pl-0">
                    <label for="exampleInputEmail1"><b>Email:</b></label>
                    <input type="email" name="email" class="form-control" id="exampleInputEmail1" >
                 </div>
                 <button type="submit" name="btn_add_new_user" class="btn btn-info">
                    Добавить пользователя
                 </button>
             </form>
          </div>
          <div id="search-area" class="col-4">
            <form>
             <label for="exampleInputEmail1" class="mt-1 mb-2"><b>Группа:</b></label>
            <img id="load_data" class="" width="30px" height="30px" src="img/load.gif" style="display:none;">
             <div class="form-group row ">
                <div class="col-sm-12">
                    <input id="input_name_group" type="text" name="group" class="form-control" maxlength="5" placeholder="ИТ777">
                 </div>

             </div>
            </form>
              <div class="reault-search" >

                  <table class="table inline m-0">
                     <tbody id="table_groups">

                     </tbody>
                  </table>
              </div>

          </div>
       </div>
 -->


  <script src="js/settings.js"></script>
  <script type="text/javascript" src="js/settings_main.js" charset="utf-8"></script>

  <script type="text/javascript">
  function setAccessLevel(level){
     console.log(level)
     if(level) {
         $("#search-area").hide()
     }else{
         $("#search-area").show();
     }
  }

  $(document).ready ( function () {
      $("#input_name_group").keyup(searchGroups);
   });
  </script>




 </body>
 </html>
