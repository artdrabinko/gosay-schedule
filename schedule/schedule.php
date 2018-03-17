<?php

$MainURL = "/schedule";
if ( !isset($_GET['idgroup']) ||  !isset($_GET['subgroup']) ) {
    header("Location: ". $MainURL);
}else {
  require_once('php/functions.php');

  $id_group = $_GET['idgroup'];
  $subgroup = $_GET['subgroup'];
  if ( (int)$id_group <= 0 || (int)$id_group >= 3000 || (int)$subgroup != 1 && (int)$subgroup != 2) {
      header("Location: ". $MainURL);
      exit();
  }

  $group_name = get_group_name($id_group);

  $current_week = (date ("W", time())+ 2) % 4 ;
  if($current_week == 0) $current_week = 4;
  $buckup_current_week = $current_week; //for correkt view selected and current week

  //if receive 3 param, check param "week"
  if ( count($_GET) == 3 ) {
     if( isset($_GET['week']) && ( (int)$_GET['week'] > 0 && (int)$_GET['week'] < 5 ) ){
        $current_week = $_GET['week'];
     }else {
        header("Location: ". $MainURL);
     }
  }

}

?>

<!doctype html>
<html lang="ru">
  <head>
    <title>Schedule</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


    <?php
      require_once('../main_templates/basic_styles.php');
    ?>

    <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

  </head>
  <body style="background-color: #005d6c; padding-top: 70px;">

    <nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark">
      <!-- Navbar content -->
      <div class="container">
        <a class="navbar-brand" href="../index.php"><b><i>GoSay</i></b></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item ">
               <a class="nav-link" href="../schedule/schedule.php">Расписание</a>
            </li>

            <li class="nav-item dropdown ">
             <a class="nav-link dropdown-toggle active "  href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
               <?php
                  if($buckup_current_week == $current_week) {
                      echo 'Текущая неделя - '.$current_week;
                  }else { echo 'Выбранная неделя - '.$current_week; } ?>
             </a>
             <div id="dropdown-menu-week" class="dropdown-menu p-2" aria-labelledby="navbarDropdownMenuLink">
               <?php
               $btn_defoult_style =  "btn btn-outline-primary btn-block btn-sm";
               $btn_selected_style = "btn btn-primary btn-block btn-sm";
               $btn_current_week_style = "btn btn-warning btn-block btn-sm";


               for ($i=1; $i < 5; $i++) {
                 if ($current_week == $i && $buckup_current_week == $i){
                  echo  '<a class="'.$btn_current_week_style.'" href="schedule.php?idgroup='.$id_group.'&amp;subgroup='.$subgroup.'&amp;week='.$i.'"> '.$i.' - неделя </a>';
                 }else if($buckup_current_week == $i){
                  echo  '<a class="'.$btn_current_week_style.'" href="schedule.php?idgroup='.$id_group.'&amp;subgroup='.$subgroup.'&amp;week='.$i.'"> '.$i.' - неделя </a>';
                 }else if($current_week == $i){
                  echo  '<a class="'.$btn_selected_style.'" href="schedule.php?idgroup='.$id_group.'&amp;subgroup='.$subgroup.'&amp;week='.$i.'"> '.$i.' - неделя </a>';
                 }else{
                     echo  '<a class="'.$btn_defoult_style.'" href="schedule.php?idgroup='.$id_group.'&amp;subgroup='.$subgroup.'&amp;week='.$i.'"> '.$i.' - неделя </a>';
                 }
               }
               ?>
             </div>
           </li>

           <li class="nav-item ">
             <a class="nav-link " href="/site/admin">Админ панель</a>
           </li>

          </ul>

          <ul class="navbar-nav navbar-right">
            <li class="nav-item dropdown">
             <a class="nav-link dropdown-toggle text-light" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <?php echo  $group_name.' - '.$subgroup; ?><i class="ml-3 ion-ios-bell-outline fa-2x w-50"></i>
             </a>

             <div id="dropdown-menu" class="dropdown-menu dropdown-menu-right p-3" style="width:335px;" aria-labelledby="navbarDropdownMenuLink">
               <form id="subscribe-form" method="POST" action="" >
                 <div class="form-group">
                   <label for="exampleInputEmail1">Вы желаете получать уведомления при изменении расписания для группы  <?php echo  $group_name.' - '.$subgroup; ?>?</label>
                   <input id="inputEmail" class="form-control" type="email" name="email" placeholder="Enter email">
                   <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                 </div>
                 <div class="g-recaptcha" data-sitekey="6Ld7n0QUAAAAALkj_Ov_qCz5jglcorMwKjNJUoyl"></div>
                 <div id="error-box" class="alert alert-danger mb-0 mt-2" style="display: none;">-</div>
                 <button id="btn-subcribe" class="btn btn-primary w-100 mt-3" type="button" >Subscribe</button>
                 <img id="load_data" class="" width="40px" height="40px" src="/site/admin/img/load.gif" style="margin: 0 auto; display: none;">
               </form>

               <div id="success-box" class="alert alert-success mb-0" style="display: none;">Вы успешно подписалиcь на <br />рассылку для группы <?php echo  $group_name.' - '.$subgroup; ?> !</div>
             </div>
           </li>
          </ul>
        </div>
      </div>
    </nav>

        <div class="container">

        <?php
        echo '<div class="row">';


        for ($count_days=1; $count_days < 7; $count_days++) {
            if($count_days == 1 || $count_days == 4){
              //echo '<div class="row p-4">';
            }

            $day = get_shedule_one_day($id_group, $subgroup, $current_week, $count_days);
            //dump($day);
            echo '<dir class="col-lg-4 d-inline-block" >
                     <table class="table">
                         <tr class="table-active text-light">
                           <td colspan="3" class="text-center  bg-success"
                             style="border-top:none; border-top-left-radius: 10px; border-top-right-radius: 10px;box-shadow: 10px 0 #005d6c, -10px 0 #005d6c;">
                             '.get_day_name($count_days).', '.get_number_day($current_week, $buckup_current_week, $count_days).' '.get_month_name($current_week, $buckup_current_week, $count_days).'
                          </td>
                         </tr>';
            if(!$day){
                echo '<tr class="bg-white">
                       <td class="" style=" border-bottom-left-radius: 10px; box-shadow: -10px 0 #005d6c;"></td>
                       <td class="">
                         <span class="text-center text-success">Сегодня занятий нет, можно отдохнуть.</span>
                       </td>
                       <td class="" style="float: none; vertical-align: middle;border-bottom-right-radius: 10px; box-shadow: 10px 0 #005d6c;"></td>
                     </tr>';
            }
            foreach ($day as $lesson) {
              $style_type_lesson = get_style_subject_type($lesson['subject_type']);
              $subject_type = get_subject_type($lesson['subject_type']);
              echo'<tr class="bg-white">';
                  if ($lesson == end($day)){
                    echo '<td class="text-right" style="border-bottom-left-radius: 10px; box-shadow: -10px 0 #005d6c;">';
                  } else echo '<td class=" text-right">';
                  echo '
                    <span '.$style_type_lesson.'>'.$subject_type.'</span><br>
                    <span class="font-weight-bold">'.get_time_lesson_start($lesson['time']).'</span><br>
                    <span class="text-secondary">'.get_time_lesson_end($lesson['time']).'</span>
                  </td>

                  <td class="">
                    <span class="font-weight-bold">'.$lesson['subject_name'].'</span><br>
                    <span class="text-secondary">'.$lesson['teacher_name'].'</span><br>
                    <span class="text-secondary">Подгруппа: '.get_str_name_sub($lesson['subgroup']).'</span>
                  </td>';

                  if ($lesson == end($day)){
                    echo '<td class="" style="float: none; vertical-align: middle; border-bottom-right-radius: 10px; box-shadow: 10px 0 #005d6c;">';
                  } else echo '<td style="float: none; vertical-align: middle;">';
                    echo '<span>'.$lesson['room'].'</span>
                  </td>
                </tr>';
            }
            echo '</table>
             </dir>';

          }
        ?>
        </div>

    </div>

    <?php
      require_once('../main_templates/basic_scripts.php');
    ?>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <script type="text/javascript">

   $(document).ready( function (){
      $('#btn-subcribe').click(function() {
          var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
          if (reg.test(document.getElementById("inputEmail").value) == false) {
              $("#inputEmail").addClass("is-invalid");
              $('#error-box').text('Проверьте введенный адрес!').show();
          }else{
            $("#inputEmail").removeClass("is-invalid");
            hendlerSubscribe();
          }
      });
   });

   function funcBeforeSubcscribe() {
      $('#load_data').css( "display"," block");
      $('#btn-subcribe').hide();
   }

   function funcSuccessJSONSubscribe(data){
      data = JSON.parse(data);
      if(data.status !== 0){
         $('#error-box').text(data.data).show();
      }else{
         $('#subscribe-form').hide();
         $('#success-box').show();
      }
   }

   function hendlerSubscribe(){
      var _formData = {
         'email' : document.getElementById("inputEmail").value,
         'g-recaptcha-response': grecaptcha.getResponse(),
         'id_group' :  <?php echo $_GET['idgroup']?>,
         'subgroup' : <?php echo $_GET['subgroup']?>
      };

      $.ajax ({
          url: "/mailer/subcribe.php",
          type: "POST",
          data: (_formData),
          dataType: "html",
          beforeSend: funcBeforeSubcscribe,
          success: funcSuccessJSONSubscribe
      });
   }

   </script>

  </body>
</html>

<!--
/*
GoSay Schedule is a web application for scheduling in educational institutions.
Copyright (C) 2018  Drabinko Artur

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU Affero General Public License as
published by the Free Software Foundation, either version 3 of the
License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU Affero General Public License for more details.

You should have received a copy of the GNU Affero General Public License
along with this program.  If not, see <https://www.gnu.org/licenses/>
*/
-->
