;function LessonsArea(){
   this.selected_subgroup = 1;
   this.selected_week = 1;
   this.selected_day= 1;
   this.selected_lesson = 1;


   function setStyleForSelectedLessons(component_id){
      $("#lesson_"+ component_id).removeClass('table-light').addClass('table-info');
   }

   function updateLessonsStyles(component_id){
      for (var i = 1; i <= 6; i++){$("#lesson_" + i).removeClass('table-info').addClass('table-light');}
      setStyleForSelectedLessons(component_id);
   }

   this.getNameSubject = function(){ return $("#subject_" + this.selected_lesson).text() }
   this.getNameTeacher = function(){ return $("#teacher_" + this.selected_lesson).text() }
   this.getRoomNumber = function(){ return $("#room_" + this.selected_lesson).text() }

   this.getSubjectType = function(){
      var textLessonType = $("#lesson_type_" + this.selected_lesson).text();
      if (textLessonType == "Лекция") {
        return 1;
      }
      if (textLessonType == "Практика") {
        return 2;
      }
      if (textLessonType == "ЛР") {
        return 3;
      }
      return 0;
   }


   this.updateNameSubject = function(subject){ $("#subject_" + this.selected_lesson).text(subject); }
   this.updateNameTeacher = function(name_teacher){ $("#teacher_" + this.selected_lesson).text(name_teacher); }
   this.updateRoomNumber = function(room_number){ $("#room_" + this.selected_lesson).text(room_number); }


   this.setCurrentLesson = function(component_id){
      this.selected_lesson = component_id;
      updateLessonsStyles(this.selected_lesson);
   }

   this.setSelectedSubgroup = function(component_id){ this.selected_subgroup = component_id; }
   this.setSelectedWeek = function(component_id){ this.selected_week = component_id; }
   this.setSelectedDay = function(component_id){ this.selected_day = component_id; }


   this.showBtnSaveLesson = function(component_id = this.selected_lesson){
      $("#btn_lesson_delete_" + component_id).hide();
      $("#btn_lesson_save_" + component_id).show();
   }

   this.showBtnDeleteLesson = function(component_id = this.selected_lesson){
      $("#btn_lesson_save_" + component_id).hide();
      $("#btn_lesson_delete_" + component_id).show();
   }

   this.saveLessonAction = function(component_id, callback = undefined){
      this.selected_lesson = component_id;

      function functionBeforeSaveLesson(){
         $('#load_data').show();
      }

      function functionSuccessSaveLesson(data){
         data = JSON.parse(data);
         $('#load_data').hide();
         $("#log_text_update").slideDown(200, function(){
             $(this).delay( 1000 ).slideUp(500);
         });
         callback();
      }

      let subject_type = this.getSubjectType();
      let subject_name = $("#subject_" + this.selected_lesson).text();
      let textTeacher = $("#teacher_" + this.selected_lesson).text();
      let room = $("#room_" + this.selected_lesson).text();

      $.ajax ({
          url: "/site/admin/php_staff/save_lesson.php",
          type: "POST",
          data: ({subgroup: this.selected_subgroup, week: this.selected_week, day: this.selected_day, time: this.selected_lesson,
            subject_type: subject_type, subject_name: subject_name, teacher_name: textTeacher, room: room}),
          dataType: "html",
          beforeSend: functionBeforeSaveLesson,
          success: functionSuccessSaveLesson,
          complete: this.showBtnDeleteLesson()
      });
   }

   function log(){
      console.log('del');
   }

   this.deleteLessonAction = function(component_id, callback = undefined){
      this.selected_lesson = component_id;
      var r = confirm("Удалить " + component_id +"-ю пару из разписания?");

      function functionBeforeDeleteLesson(){
         $('#load_data').show();
      }

      function functionSuccesDeleteLesson(data){
         $('#load_data').hide();
         data = JSON.parse(data);
         $("#log_text_deleted").slideDown(500, function(){
             $(this).delay( 1300 ).slideUp(500);
         });
         callback();
      }

      if (r == true) {
         $("#subject_" + component_id).text("");
         $("#teacher_" + component_id).text("");
         $("#room_" + component_id).text("");
         this.setTypeSubject(0);
         this.checkDataSelectLesson();

         $.ajax ({
            url: "/site/admin/php_staff/delete_lesson.php",
            type: "POST",
            data: ({subgroup: this.selected_subgroup, week: this.selected_week, day: this.selected_day, time: this.selected_lesson}),
            dataType: "html",
            beforeSend: functionBeforeDeleteLesson,
            success: functionSuccesDeleteLesson
         });

      } else {
          console.log("You pressed Cancel!");
      }
   };


   this.checkDataSelectLesson = function(){
      if(this.getNameSubject() == "" || this.getNameTeacher() == "" || this.getRoomNumber() == "" || this.getSubjectType() == 0){
         $("#btn_lesson_save_" + this.selected_lesson).hide();
         $("#btn_lesson_delete_" + this.selected_lesson).hide();
      }else {
         this.showBtnSaveLesson();
      }
   };


   this.setTypeSubject = function(type_subject){
      switch (type_subject) {
         case 1:
            $("#lesson_type_" + this.selected_lesson).removeClass('bg-warning bg-primary bg-danger');
            $("#lesson_type_" + this.selected_lesson).addClass('bg-primary');
            $("#lesson_type_" + this.selected_lesson).text("Лекция");
            break;
         case 2:
            $("#lesson_type_" + this.selected_lesson).removeClass('bg-warning bg-primary bg-danger');
            $("#lesson_type_" + this.selected_lesson).addClass('bg-warning');
            $("#lesson_type_" + this.selected_lesson).text("Практика");
            break;
         case 3:
            $("#lesson_type_" + this.selected_lesson).removeClass('bg-warning bg-primary bg-danger');
            $("#lesson_type_" + this.selected_lesson).addClass('bg-danger');
            $("#lesson_type_" + this.selected_lesson).text("ЛР");
            break;
         case 0:
            $("#lesson_type_" + this.selected_lesson).removeClass('bg-warning bg-primary bg-danger');
            $("#lesson_type_" + this.selected_lesson).text("");
            break;

      }
   };

   function clearArea(){
      for (let i = 1; i <= 6; i++) {
         $( "#lesson_type_"+ i ).removeClass( "bg-danger bg-primary bg-warning" );
         $( "#lesson_type_"+ i ).text("");

         $( "#subject_"+ i ).text("");
         $( "#room_"+ i ).text("");
         $( "#teacher_"+ i ).text("");

         $("#btn_lesson_save_" + i).hide();
         $("#btn_lesson_delete_" + i).hide();
      }
   };

   //function sort by time
   function sortByTime(a, b) {
     if (a.time > b.time) return 1;
     if (a.time < b.time) return -1;
  };

   function setTypeAntStyleLesson(count_lesson, type){
      switch (Number(type)) {
         case 1:
            $( "#lesson_type_"+ count_lesson ).addClass( "bg-primary" );
            $("#lesson_type_"+ count_lesson).text("Лекция");
            break;
         case 2:
            $( "#lesson_type_"+ count_lesson ).addClass( "bg-warning" );
            $("#lesson_type_"+ count_lesson).text("Практика");
            break;
         case 3:
            $( "#lesson_type_"+ count_lesson ).addClass( "bg-danger" );
            $("#lesson_type_"+ count_lesson).text("ЛР");
            break;
      }
   };


   function updateStyleInputSearch(status){

      function toastSuccessSearch(){
         $('#log_text_succes_search').slideDown(200, function(){
             $(this).delay( 1000 ).slideUp(500);
         });
      }

      switch (status) {
         case 0:
            $('#group_name').removeClass('is-invalid').addClass('is-valid');
            toastSuccessSearch();
            break;
         case 1:
            $('#group_name').removeClass('is-invalid').addClass('is-valid');
            toastSuccessSearch();
            break;
         case 404:
            $('#group_name').removeClass('is-valid').addClass('is-invalid');
            $('.invalid-feedback').text('GROUP NOT EXIST');
            break;
      }

   };


   function updateSearchStatus(dataArray){
      switch (dataArray.status) {
         case 0:
            console.log("updateSearchStatus - "+ 0);
            var array_lessons = [];
            console.log(dataArray.data);
            for(var lesson in dataArray.data){
               console.log(dataArray.data[lesson]);
               array_lessons.push(dataArray.data[lesson]);
            }

            array_lessons.sort(sortByTime);
            console.log("array_lessons compleate" + array_lessons[0]);
            for(var lesson in array_lessons){
               var count_id = array_lessons[lesson].time;
               console.log(count_id);
               var subject_name = array_lessons[lesson].subject_name;
               var subject_type = array_lessons[lesson].subject_type;
               var teacher = array_lessons[lesson].teacher_name;
               var room = array_lessons[lesson].room;

               $("#subject_"+ count_id).text(subject_name);
               setTypeAntStyleLesson(count_id, subject_type);
               $("#teacher_"+ count_id).text(teacher);
               $("#room_" + count_id).text(room);

               $("#btn_lesson_delete_" + count_id).show();
            }
            updateStyleInputSearch(0);
            break;
         case 1:
            updateStyleInputSearch(1);
            break;
         case 404:
            updateStyleInputSearch(404);
            break;
         default:
            break;
      }
   }


   this.render = function(data){
      clearArea();
      console.log("----render LessonsArea ------");
      data = JSON.parse(data);
      updateSearchStatus(data);
   };

};
