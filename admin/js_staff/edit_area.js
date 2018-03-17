;function EditArea(lessons_area) {
   LESSON_AREA = lessons_area;

   $(document).ready ( function () {
      $("#in_name_subject").keyup( function () {
         let subject = document.getElementById("in_name_subject").value;
         LESSON_AREA.updateNameSubject(subject);
         LESSON_AREA.checkDataSelectLesson();
      });
   });

   $(document).ready ( function () {
      $("#in_name_teacher").keyup( function () {
         let name_teacher = document.getElementById("in_name_teacher").value;
         LESSON_AREA.updateNameTeacher(name_teacher);
         LESSON_AREA.checkDataSelectLesson();
      });
   });

   $(document).ready ( function () {
      $("#in_room").keyup( function() {
         let room_number = document.getElementById("in_room").value;
         LESSON_AREA.updateRoomNumber(room_number);
         LESSON_AREA.checkDataSelectLesson();
      });
   });


   this.setStateRadioBtnLessonNum = function(subject_type) {
      $("#lesson_R_" + subject_type).prop('checked', true);
   };


   this.setStateRadioBtnSybjectType = function(subject_type) {
      if (subject_type == 0) {
         for (let i = 1; i <= 3; i++) { $("#lesson_type_R_" + i).prop('checked', false); }
      }else {
         $("#lesson_type_R_" + subject_type).prop('checked', true);
      }
   };


   function funcBeforeUpdateDay(){
      $('#load_data').show();
   };


   function funcSuccessUpdateDay(data){
      $('#load_data').hide();
      LESSON_AREA.render(data);
   };


   this.ajaxSearchScheduleByGroupName = function (callback){

      let subgroup = LESSON_AREA.selected_subgroup;
      let week = LESSON_AREA.selected_week;
      let day = LESSON_AREA.selected_day;

      $.ajax ({
         url: "/site/admin/php_staff/get_schedule_day.php",
         type: "POST",
         data: ({subgroup: subgroup, week: week, day: day}),
         dataType: "html",
         beforeSend: funcBeforeUpdateDay,
         success: funcSuccessUpdateDay,
         complete: function() { callback(); }
      });

   };


   this.render = function(selected_lesson){
      $("#in_name_subject").val( lessons_area.getNameSubject(selected_lesson) );
      $("#in_name_teacher").val( lessons_area.getNameTeacher(selected_lesson) );
      $("#in_room").val( lessons_area.getRoomNumber(selected_lesson) );

      this.setStateRadioBtnLessonNum(selected_lesson);
      this.setStateRadioBtnSybjectType(lessons_area.getSubjectType(selected_lesson));
   };


};
