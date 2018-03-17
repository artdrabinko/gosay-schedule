<?php
session_start();

$LEVEL = 0;
require_once('php/router.php');
?>


<!DOCTYPE html>
<html>
 <head>
  <meta charset="utf-8" />
  <title>HTML5</title>

  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link rel="stylesheet" href="/site/admin/css/bootstrap.min.css">

 </head>
 <body style="background-color: #f5f5f5; padding-top: 70px;">

  <?php
    require_once('templates/admin_navbar.php');
  ?>

  <div class="container">
    <div class="row">
      <div class="col-md-8 pt-4">

        <form onsubmit="return checkForm(this)" action="addLesson.php" method="POST" class="col">

          <div class="form-row">

            <label for="group_name" class="col-sm-3 col-form-label "><b>Группа:</b></label>

            <div class="col-md-2 ml-0" style="padding-left: 0px;">
             <label class="col-form-label "><b><?php echo $_SESSION['logged_user']['group_name']; ?></b></label>
            </div>

            <label id="log_text_update"class="text-success col-sm-3 col-form-label" style="display:none;"><b>Обновлено</b></label>
            <label id="log_text_deleted"class="text-danger col-sm-3 col-form-label" style="display:none;"><b>Пара удалена</b></label>
            <img id="load_data" class="" width="35px" height="35px" src="img/load.gif" style="display:none;">

          </div>
          <hr>

          <div class="form-group row">
            <label for="subgroup" class="col-sm-3">Подгруппа:</label>
            <label class="custom-control custom-radio">
              <input id="subgroup_R_1" onClick="udateAllBySelectedSubgroup(1)" name="subgroup" type="radio" class="col-sm-9 custom-control-input"  checked>
              <span class="custom-control-indicator"></span>
              <span class="custom-control-description">Первая</span>
            </label>
            <label class="custom-control custom-radio">
              <input id="subgroup_R_2" onClick="udateAllBySelectedSubgroup(2)"  name="subgroup" type="radio" class="col-sm-9 custom-control-input">
              <span class="custom-control-indicator"></span>
              <span class="custom-control-description">Вторая</span>
            </label>
            <label class="custom-control custom-radio">
              <input id="subgroup_R_All" onClick="udateAllBySelectedSubgroup(3)" name="subgroup" type="radio" class="col-sm-9 custom-control-input">
              <span class="custom-control-indicator"></span>
              <span class="custom-control-description">Все</span>
            </label>
          </div>

          <style media="screen">
            #display_week_groups,#hide_week_groups label {
                cursor: pointer;
            }

            #log_text {
              display: none;
            }
          </style>
          <div class="form-group row">
            <label for="week" class="col-sm-3" >Неделя:</label>

            <div id="display_week_groups" >
              <label class="custom-control custom-radio" >
                <input id="week_1" onClick="udateAllBySelectedWeek(1)" name="week" type="radio" class="col-sm-9 custom-control-input" checked>
                <span class="custom-control-indicator"></span>
                <span class="custom-control-description">1 неделя</span>
              </label>
              <label class="custom-control custom-radio"  >
                <input id="week_2" onClick="udateAllBySelectedWeek(2)" name="week" type="radio" class="col-sm-9 custom-control-input" >
                <span class="custom-control-indicator"></span>
                <span class="custom-control-description">2 неделя</span>
              </label>
              <label class="custom-control custom-radio" >
                <input id="week_3" onClick="udateAllBySelectedWeek(3)" name="week"    type="radio" class="col-sm-9 custom-control-input">
                <span class="custom-control-indicator"></span>
                <span class="custom-control-description">3 неделя</span>
              </label>
              <label class="custom-control custom-radio" >
                <input id="week_4" onClick="udateAllBySelectedWeek(4)"  name="week" type="radio" class="col-sm-9 custom-control-input" >
                <span class="custom-control-indicator"></span>
                <span class="custom-control-description">4 неделя</span>
              </label>
            </div>


            <div id="hide_week_groups" style="display:none;">
              <label class="custom-control custom-radio" >
                <input id="week_13" onClick="udateAllBySelectedWeek(13)" name="week" type="radio" class="col-sm-9 custom-control-input" >
                <span class="custom-control-indicator"></span>
                <span class="custom-control-description">1/3 неделя</span>
              </label>
              <label class="custom-control custom-radio" >
                <input id="week_24" onClick="udateAllBySelectedWeek(24)" name="week" type="radio" class="col-sm-9 custom-control-input" >
                <span class="custom-control-indicator"></span>
                <span class="custom-control-description">2/4 неделя</span>
              </label>
              <label class="custom-control custom-radio" >
                <input id="week_All" onClick="udateAllBySelectedWeek(5)" name="week" type="radio" class="col-sm-9 custom-control-input" >
                <span class="custom-control-indicator"></span>
                <span class="custom-control-description">Каждую неделю</span>
              </label>
            </div>


            <div id="btn_more_weeks" title="more settings weeks" style="cursor:pointer" onclick="showMoreWeeks()" class="glyphicon glyphicon-chevron-right">
               <img id="img_more_weeks" width="22px" height="22px" src="img/left-arrow-angle.svg" alt="">
            </div>

            <audio src="lo.mp3" autoplay="autoplay"></audio>

          </div>



          <div class="form-group row">
            <label for="day" class="col-sm-3">День недели:</label>
            <label class="custom-control custom-radio">
              <input id="day_1" onClick="udateAllBySelectedDay(1)" name="day" type="radio" class="col-sm-9 custom-control-input" checked>
              <span class="custom-control-indicator"></span>
              <span class="custom-control-description">Пн</span>
            </label>
            <label class="custom-control custom-radio">
              <input id="day_2" onClick="udateAllBySelectedDay(2)" name="day" type="radio" class="col-sm-9 custom-control-input" >
              <span class="custom-control-indicator"></span>
              <span class="custom-control-description">Вт</span>
            </label>
            <label class="custom-control custom-radio">
              <input id="day_3" onClick="udateAllBySelectedDay(3)" name="day" type="radio" class="col-sm-9 custom-control-input" >
              <span class="custom-control-indicator"></span>
              <span class="custom-control-description">Ср</span>
            </label>
            <label class="custom-control custom-radio" >
            <input id="day_4" onClick="udateAllBySelectedDay(4)" name="day" type="radio" class="col-sm-9 custom-control-input" >
            <span class="custom-control-indicator"></span>
            <span class="custom-control-description">Чт</span>
            </label>
            <label class="custom-control custom-radio">
            <input id="day_5" onClick="udateAllBySelectedDay(5)" name="day" type="radio" class="col-sm-9 custom-control-input" >
            <span class="custom-control-indicator"></span>
            <span class="custom-control-description">Пт</span>
            </label>
            <label class="custom-control custom-radio">
            <input id="day_6" onClick="udateAllBySelectedDay(6)" name="day" type="radio" class="col-sm-9 custom-control-input" >
            <span class="custom-control-indicator"></span>
            <span class="custom-control-description">Сб</span>
            </label>
          </div>
          <div class="form-group row">
            <label for="lesson" class="col-sm-3">Пара:</label>
            <label class="custom-control custom-radio" >
            <input id="lesson_R_1" onChange="udateEditArea(1)" name="lesson" type="radio" class="col-sm-9 custom-control-input" value="1" checked>
            <span class="custom-control-indicator"></span>
            <span class="custom-control-description">1-я</span>
            </label>
            <label class="custom-control custom-radio" >
            <input id="lesson_R_2" onChange="udateEditArea(2)" name="lesson" type="radio" class="col-sm-9 custom-control-input" value="2" >
            <span class="custom-control-indicator"></span>
            <span class="custom-control-description">2-я</span>
            </label>
            <label class="custom-control custom-radio" >
            <input id="lesson_R_3" onChange="udateEditArea(3)" name="lesson" type="radio" class="col-sm-9 custom-control-input" value="3" >
            <span class="custom-control-indicator"></span>
            <span class="custom-control-description">3-я</span>
            </label>
            <label class="custom-control custom-radio">
              <input id="lesson_R_4" onChange="udateEditArea(4)" name="lesson" type="radio" class="col-sm-9 custom-control-input" value="4" >
              <span class="custom-control-indicator"></span>
              <span class="custom-control-description">4-я</span>
            </label>
            <label class="custom-control custom-radio" >
              <input id="lesson_R_5" onChange="udateEditArea(5)"  name="lesson" type="radio" class="col-sm-9 custom-control-input" value="5" >
              <span class="custom-control-indicator"></span>
              <span class="custom-control-description">5-я</span>
            </label>
            <label class="custom-control custom-radio" >
              <input id="lesson_R_6" onChange="udateEditArea(6)" name="lesson" type="radio" class="col-sm-9 custom-control-input" value="6" >
              <span class="custom-control-indicator"></span>
              <span class="custom-control-description">6-я</span>
            </label>
          </div>
          <div class="form-group row">
            <label for="in_name_subject" class="col-sm-3 col-form-label">Название предмета:</label>
            <input id="in_name_subject" class="col-sm-9 form-control col-sm-9" name="name_subject" type="text" maxlength="15">
          </div>
          <div class="form-group row">
            <label for="in_name_teacher" class="col-sm-3 col-form-label">Преподаватель:</label>
            <input id="in_name_teacher" class="col-sm-9 form-control col-sm-9" name="in_name_teacher" type="text" maxlength="17" >
          </div>
          <div class="form-group row">
            <label for="in_room_number" class="col-sm-3 col-form-label">Кабинет:</label>
            <input id="in_room" class="col-sm-9 form-control col-sm-9" name="in_room" type="text" maxlength="3">
          </div>
          <div class="form-group row">
            <label for="lesson_type" class="col-sm-3">Тип премета:</label>
            <label class="custom-control custom-radio">
              <input id="lesson_type_R_1" onChange="udateTypeSubjectLessonArea(1)" name="lesson_type" type="radio" class="col-sm-9 custom-control-input" value="1" checked>
              <span class="custom-control-indicator"></span>
              <span class="custom-control-description">Лекция</span>
            </label>
            <label class="custom-control custom-radio">
              <input id="lesson_type_R_2" onChange="udateTypeSubjectLessonArea(2)" name="lesson_type" type="radio" class="col-sm-9 custom-control-input" value="2" >
              <span class="custom-control-indicator"></span>
              <span class="custom-control-description">Практика</span>
            </label>
            <label class="custom-control custom-radio">
              <input id="lesson_type_R_3" onChange="udateTypeSubjectLessonArea(3)" name="lesson_type" type="radio" class="col-sm-9 custom-control-input" value="3" >
              <span class="custom-control-indicator"></span>
              <span class="custom-control-description">Лабораторная</span>
            </label>
          </div>
      </div>




      <!-- Start div table schedule by day  -->
      <div class="col-md-4 mt-4">
         <table class="table table-sm table-hover" style="min-width: 200px; max-width: 400px;">


            <!-- Start content header table lessons  -->
            <tr class="table-active text-light bg-success">
               <td id="headerSchedule" colspan="3" class="text-center  bg-success"
               style="border-top:none; border-top-left-radius: 10px; border-top-right-radius: 10px;">
               Понедельник, 1/3 неделя
               </td>
            </tr><!-- End content header table lessons  -->


            <!-- Start content 1 lesson  -->
            <tr  id="lesson_1" onClick="udateEditArea(1)" class="table-info" style="cursor: pointer;">
               <td class="text-right">
                  <span id="lesson_type_1"  class="text-light pl-1 pr-1"></span><br>
                  <span class="font-weight-bold">08:00</span><br>
                  <span class="text-secondary">9:40</span>
               </td>

               <td class="">
                  <span id="subject_1" class="font-weight-bold"></span><br>
                  <span id="teacher_1" class="text-secondary"></span><br>
                  <span id="subgroup_1" class="text-secondary">Подгруппа: Первая</span>
               </td>

               <td class="" style="float: none; vertical-align: middle;">
                  <span id="room_1"></span>
               </td>
               <td id="btn_lesson_save_1" onClick="saveLesson(1)" style="border: none; display: none; float: none; background-color: #f5f5f5; vertical-align: middle; ">
                  <img width="20px" height="20px" src="img/save.svg" alt="">
               </td>
               <td id="btn_lesson_delete_1" onClick="deleteLesson(1)" style="border: none; display: none; float: none; background-color: #f5f5f5; vertical-align: middle; ">
                  <img width="20px" height="20px" src="img/delete.svg" alt="">
               </td>
            </tr><!-- End content 1 lesson  -->


            <!-- Start content 2 lesson  -->
            <tr id="lesson_2" onClick="udateEditArea(2)" class="table-light" style="cursor: pointer;">
               <td class=" text-right">
                  <span id="lesson_type_2" class="text-light pl-1 pr-1"></span><br>
                  <span class="font-weight-bold"> 09:55 </span><br>
                  <span class="text-secondary"> 11:35</span>
               </td>

               <td class="">
                  <span id="subject_2" class="font-weight-bold"></span><br>
                  <span id="teacher_2" class="text-secondary"></span><br>
                  <span id="subgroup_2" class="text-secondary">Подгруппа: Первая</span>
               </td>

               <td class="" style="float: none; vertical-align: middle;">
                  <span id="room_2"></span>
               </td>
               <td id="btn_lesson_save_2" onClick="saveLesson(2)" style="border: none; display: none; float: none; background-color: #f5f5f5; vertical-align: middle; ">
                  <img width="20px" height="20px" src="img/save.svg" alt="">
               </td>
               <td id="btn_lesson_delete_2" onClick="deleteLesson(2)" style="border: none; display: none; float: none; background-color: #f5f5f5; vertical-align: middle; ">
                  <img width="20px" height="20px" src="img/delete.svg" alt="">
               </td>
            </tr><!-- End content 2 lesson  -->


            <!-- Start content 3 lesson  -->
            <tr id="lesson_3" onClick="udateEditArea(3)" class="table-light" style="cursor: pointer;">
               <td class="text-right">
                  <span id="lesson_type_3" class="text-light pl-1 pr-1"></span><br>
                  <span class="font-weight-bold">12:15</span><br>
                  <span class="text-secondary">13:55</span>
               </td>

               <td class="">
                  <span id="subject_3" class="font-weight-bold"></span><br>
                  <span id="teacher_3" class="text-secondary"></span><br>
                  <span id="subgroup_3" class="text-secondary">Подгруппа: Первая</span>
               </td>

               <td class="" style="float: none; vertical-align: middle;">
                  <span id="room_3"></span>
               </td>
               <td id="btn_lesson_save_3" onClick="saveLesson(3)" style="border: none; display: none; float: none; background-color: #f5f5f5; vertical-align: middle; ">
                  <img width="20px" height="20px" src="img/save.svg" alt="">
               </td>
               <td id="btn_lesson_delete_3" onClick="deleteLesson(3)" style="border: none; display: none; float: none; background-color: #f5f5f5; vertical-align: middle; ">
                  <img width="20px" height="20px" src="img/delete.svg" alt="">
               </td>
            </tr><!-- End content 3 lesson  -->


            <!-- Start content 4 lesson  -->
            <tr  id="lesson_4" onClick="udateEditArea(4)" class="table-light" style="cursor: pointer;">
               <td class="text-right">
                  <span id="lesson_type_4" class=" text-light pl-1 pr-1 "></span><br>
                  <span class="font-weight-bold">14:10</span><br>
                  <span class="text-secondary">15:50</span>
               </td>

               <td class="">
                  <span id="subject_4" class="font-weight-bold"></span><br>
                  <span id="teacher_4" class="text-secondary"></span><br>
                  <span id="subgroup_4" class="text-secondary">Подгруппа: Первая</span>
               </td>

               <td class="" style="float: none; vertical-align: middle;">
                  <span id="room_4"></span>
               </td>
               <td id="btn_lesson_save_4" onClick="saveLesson(4)" style="border: none; display: none; float: none; background-color: #f5f5f5; vertical-align: middle; ">
                  <img width="20px" height="20px" src="img/save.svg" alt="">
               </td>
               <td id="btn_lesson_delete_4"onClick="deleteLesson(4)" style="border: none; display: none; float: none; background-color: #f5f5f5; vertical-align: middle; ">
                  <img width="20px" height="20px" src="img/delete.svg" alt="">
               </td>
            </tr><!-- End content 4 lesson  -->


            <!-- Start content 5 lesson  -->
            <tr  id="lesson_5" onClick="udateEditArea(5)" class="table-light" style="cursor: pointer;">
               <td class="text-right">
                  <span id="lesson_type_5" class="text-light pl-1 pr-1"></span><br>
                  <span class="font-weight-bold">16:20</span><br>
                  <span class="text-secondary">18:00</span>
               </td>

               <td class="">
                  <span id="subject_5" class="font-weight-bold"></span><br>
                  <span id="teacher_5" class="text-secondary"></span><br>
                  <span id="subgroup_5" class="text-secondary">Подгруппа: Первая</span>
               </td>

               <td class="" style="float: none; vertical-align: middle;">
                  <span id="room_5"></span>
               </td>
               <td id="btn_lesson_save_5" onClick="saveLesson(5)" style="border: none; display: none; float: none; background-color: #f5f5f5; vertical-align: middle; ">
                  <img width="20px" height="20px" src="img/save.svg" alt="">
               </td>
               <td id="btn_lesson_delete_5"onClick="deleteLesson(5)" style="border: none; display: none; float: none; background-color: #f5f5f5; vertical-align: middle; ">
                  <img width="20px" height="20px" src="img/delete.svg" alt="">
               </td>

            </tr><!-- End content 5 lesson  -->


            <!-- Start content 6 lesson  -->
            <tr  id="lesson_6" onClick="udateEditArea(6)" class="table-light" style="cursor: pointer;">
               <td class="text-right" style="border-bottom-left-radius: 10px;">
                  <span id="lesson_type_6"  class="text-light pl-1 pr-1" value="3"></span><br>
                  <span class="font-weight-bold">18:10</span><br>
                  <span class="text-secondary">20:00</span>
               </td>

               <td class="">
                  <span id="subject_6" class="font-weight-bold"></span><br>
                  <span id="teacher_6" class="text-secondary"></span><br>
                  <span id="subgroup_6" class="text-secondary">Подгруппа: Первая</span>
               </td>

               <td class="" style="float: none; vertical-align: middle; border-bottom-right-radius: 10px; ">
                  <span id="room_6"></span>
               </td>
               <td id="btn_lesson_save_6" onClick="saveLesson(6)"style="border: none; display: none; float: none; background-color: #f5f5f5; vertical-align: middle; ">
                  <img width="20px" height="20px" src="img/save.svg" alt="">
               </td>
               <td id="btn_lesson_delete_6" onClick="deleteLesson(6)"  style="border: none; display: none; float: none; background-color: #f5f5f5; vertical-align: middle; ">
                  <img width="20px" height="20px" src="img/delete.svg" alt="">
               </td>

            </tr><!-- End content 6 lesson  -->

         </table>
      </div><!-- End div table schedule by day  -->


   </div>
</div>

<div id="audioNotice" style="display:none;"></div>


   <style media="screen">
      .custom-radio {
         cursor: pointer;
      }
   </style>

   <?php
      require_once('../main_templates/basic_scripts.php');
   ?>

  <script src="/site/admin/js_staff/lessons_area.js" type="text/javascript"></script>
  <script src="/site/admin/js_staff/edit_area.js" type="text/javascript"></script>


   <script type="text/javascript">
      const lessons_area = new LessonsArea();
      var edit_area = new EditArea(lessons_area);

      $(document).ready( function () {
         edit_area.ajaxSearchScheduleByGroupName(function(){
            //send callback witch run render edit_area
            edit_area.render(lessons_area.selected_lesson);
         });
         console.log("update edit area " + lessons_area.selected_lesson);
      });


      function udateAllBySelectedSubgroup(component_id){
         console.log("udateAllBySelectedSubgroup " + component_id);
         lessons_area.setSelectedSubgroup(component_id);
         edit_area.ajaxSearchScheduleByGroupName( function(){
            //send callback witch run render edit_area
            edit_area.render(lessons_area.selected_lesson);
         });
      }

      function udateAllBySelectedWeek(component_id){
         console.log("udateAllBySelectedWeek " + component_id);
         lessons_area.setSelectedWeek(component_id);

         edit_area.ajaxSearchScheduleByGroupName(function(){
            //send callback witch run render edit_area
            edit_area.render(lessons_area.selected_lesson);
         });
      }


      function udateAllBySelectedDay(component_id){
         console.log("udateAllBySelectedDay " + component_id);
         lessons_area.setSelectedDay(component_id);

         edit_area.ajaxSearchScheduleByGroupName(function(){

            //send callback witch run render edit_area
            edit_area.render(lessons_area.selected_lesson);
         });
      }


      function udateEditArea(component_id){
         lessons_area.setCurrentLesson(component_id);
         edit_area.render(component_id);
      }

      function udateTypeSubjectLessonArea(component_id){
         lessons_area.setTypeSubject(component_id);
         lessons_area.checkDataSelectLesson();
      }

      function saveLesson(component_id){
         function playSound(filename){
            document.getElementById("audioNotice").innerHTML='<audio autoplay="autoplay"><source src="audio/' + filename + '.mp3" type="audio/mpeg" /><embed hidden="true" autostart="true" loop="false" src="' + filename +'.mp3" /></audio>';
         }

         lessons_area.saveLessonAction(component_id, function(){
            playSound("success");
         });
      }

      function deleteLesson(component_id){
         function playSound(filename){
            document.getElementById("audioNotice").innerHTML='<audio autoplay="autoplay"><source src="audio/' + filename + '.mp3" type="audio/mpeg" /><embed hidden="true" autostart="true" loop="false" src="' + filename +'.mp3" /></audio>';
         }

         lessons_area.deleteLessonAction(component_id, function(){
            playSound("deleted");
         });

         udateEditArea(component_id);
      }



      var moreWeeksShow = false;

      function showMoreWeeks(){
        if (moreWeeksShow) {
          $("#hide_week_groups").hide(600);
          $("#display_week_groups").show(1000);
          $("#img_more_weeks").attr("src","img/left-arrow-angle.svg");
          moreWeeksShow = false;
        }else {
          $("#display_week_groups").hide(600);
          $("#hide_week_groups").show(1000);
          $("#img_more_weeks").attr("src","img/right-arrow-angle.svg");
          moreWeeksShow = true;
        }
      }

   </script>



  <script type="text/javascript">

    function playSound(filename){
        document.getElementById("audioNotice").innerHTML='<audio autoplay="autoplay"><source src="audio/' + filename + '.mp3" type="audio/mpeg" /><embed hidden="true" autostart="true" loop="false" src="' + filename +'.mp3" /></audio>';
    }
    function updateLesson(lesson){

      updateLessonAndInputs(lesson);
      $("#log_text").slideDown(500, function(){
          $(this).delay( 1000 ).slideUp(500);
      });

      playSound("success");
    }

    function setCurrentWeek(week){
      selectedWeek = week;
      alertAndAjaxDay();
    }

  </script>

 </body>
 </html>
