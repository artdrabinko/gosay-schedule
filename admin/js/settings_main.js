/*Copyright (C) 2018  Drabinko Artur
This file is part of GoSay Schedule.

GoSay Schedule is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Foobar is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Foobar.  If not, see <http://www.gnu.org/licenses/>.*/;


var selected_item = 1,
    selected_menu = 1;

var controllerAddGroupMenu = new ModuleAddNewGroup(),
    moduleRemoveGroup = new ModuleRemoveGroup(),
    moduleRemoveUser= new ModuleRemoveUser(),
    moduleUpdatePassword = new ModuleUpdatePassword(),
    handlerResponse = new HandlerResponse();


function set_settings_title(number){
   console.log('set_settings_title number - ' + number);
   var array_titles = [
      '-',
      'Аккаунт',
      'Добавление группы',
      'Удаление группы',
      'Добавление пользователя В РАЗРАБОТКЕ!',
      'Удаление пользователя',
      'Обновление пароля',
   ];

   $('#settings_title').text(array_titles[number]);
};

function hide_message(number){
   if(number === 1 || number === 11) $('#error_box').hide();
   if(number === 2 || number === 11) $('#success_box').hide();
};

function handler_click_item(number){
   $('#item_' + selected_item).removeClass('select-item');
   $('#setting_menu_' + selected_menu).hide();

   $('#item_' + number).addClass('select-item');
   $('#setting_menu_' + number).show();

   set_settings_title(number);
   selected_menu = selected_item = number;
   hide_message(11);
};

function processing_form(number){
   let data = $('#form_menu_' + number).serialize();
   $('#btn_form_menu_' + number).prop("disabled", true);
   console.log("-------processing_form------- " + data);

   switch (String(number)) {
      case '2':
         controllerAddGroupMenu.add_group();
         break;
      case '3':
         moduleRemoveGroup.remove_group();
         break;
      case '5':
         moduleRemoveUser.remove_user();
         break;
      case '6':
         moduleUpdatePassword.update_password();
         break;
      default:
         console.log("module developing!");
         break;
   }
};

//-------- ajax processing form --------
function async_send_form(number, action){
   let data = $('#form_menu_' + number).serialize() + '&action=' + action;
   console.log(data);
   handlerResponse.set_action(action);

   $.ajax ({
      url: "php/settings/settings.php",
      type: "POST",
      data: data,
      dataType: "html",
      beforeSend: before_send,
      success: send_form_success,
      complete: function() {
         //$('#btn_form_menu_' + number).prop("disabled", false);
      }
   });
};

function before_send(){
   $('#load_data').show();
};

function send_form_success(data){
   $('#load_data').hide();
   let response = JSON.parse(data);
   console.log("send_form_success - ");
   console.log(data);
   handlerResponse.processing_response(response);
};
//-------- end ajax processing form --------


function HandlerResponse(){
   this.action = '';

   this.set_action = function(action){
      this.action = String(action);
   }

   this.processing_response  = function(response){
      hide_message(11);
      switch (this.action) {
         case '2':
            controllerAddGroupMenu.show_add_group_response(response);
            break;
         case '21':
            controllerAddGroupMenu.show_check_goup_response(response);
            break;
         case '3':
            moduleRemoveGroup.show_remove_group_response(response);
            break;
         case '31':
            moduleRemoveGroup.show_check_exist_group_response(response);
            break;
         case '5':
            moduleRemoveUser.show_remove_user_response(response);
            break;
         case '51':
            moduleRemoveUser.show_check_exist_user_response(response);
            break;
         case '6':
            moduleUpdatePassword.show_up_password_response(response);
            break;
         case 'error':
            console.log("error");
            $('#error_box').show();
            $('#error_box_text').text( response['message'] );
            break;
         default:
            break;

      }
   }
};


/*________ 2 -  ModuleAddNewGroup ________
*/
function  ModuleAddNewGroup(){
   let that = this;

   $('#in_group_name_menu_2').keyup(function(){
      that.check_group_name();
   });

   this.check_group_name = function () {
      let input_text = $('#in_group_name_menu_2').val();
      if(input_text.length === 5){
         async_send_form(2, 21); //FORM 2 and ACTION 21 CHECK EXIST GROUP
      }else{
         $('#in_group_name_menu_2').removeClass('is-invalid').removeClass('is-valid');
         $('#btn_form_menu_2').prop("disabled", true);
      }
   }

   this.add_group = function () {
      let input_text = $('#in_group_name_menu_2').val();
      if(input_text.length === 5){
         let isConfirm = confirm("Вы действително хотите добавить \nновую группу - " + input_text + "?");
         if(isConfirm){
            async_send_form(2, 2); //FORM 2 and ACTION 2 ADD GROUP
         }else{
            $('#btn_form_menu_2').prop("disabled", false);
         }
      }
   }

   this.show_check_goup_response = function (response) {
      switch ( response['status'] ) {
         case 'success':
            $('#in_group_name_menu_2')
            .removeClass('is-invalid').addClass('is-valid');

            $('#btn_form_menu_2').prop("disabled", false);
            break;
         case 'error':
            $('#in_group_name_menu_2')
            .removeClass('is-valid').addClass('is-invalid');

            $('#btn_form_menu_2').prop("disabled", true);
            break;
         default:

      }
   }

   this.show_add_group_response = function(response){
      switch ( response['status'] ) {
         case 'success':
            $('#success_box').show();
            $('#success_box_text').text( response['message'] );
            $('#btn_form_menu_2').prop("disabled", false);
            break;
         case 'error':
            $('#error_box').show();
            $('#error_box_text').text( response['message'] );
            $('#btn_form_menu_2').prop("disabled", true);
            break;
         default:

      }
   }
};
/*________ 2 - END ModuleAddNewGroup ________*/


/*________ 3 - ModuleRemoveGroup ________
*/
function  ModuleRemoveGroup(){
   let that = this;

   $('#in_group_name_menu_3').keyup(function(){
      that.search_group();
   });

   $('#in_password_menu_3').keyup(function(){
      that.keyup_in_password();
   });

   this.keyup_in_password = function(){
      let input_text = $('#in_group_name_menu_3').val();
      if(input_text.length == 5){
         $('#in_password_menu_3').removeClass('is-invalid');
         this.search_group();
      }else{
         $('#btn_form_menu_3').prop("disabled", true);
      }
   }

   this.search_group = function () {
      let input_text = $('#in_group_name_menu_3').val();
      if(input_text.length == 5){
         async_send_form(3, 31); //FORM 3 and ACTION 31 CHECK EXIST GROUP
      }else{
         $('#in_group_name_menu_3').removeClass('is-invalid').removeClass('is-valid');
         $('#btn_form_menu_3').prop("disabled", true);
         $('#setting_menu_3_confirm').hide();
         $('#setting_menu_3_about_group').hide();

         $('#setting_menu_3_about_name').text('');
         $('#setting_menu_3_about_staff').text('');
         $('#setting_menu_3_about_subscribers').text('');
         $('#setting_menu_3_about_lessons').text('');
      }
   }

   this.remove_group = function () {
      let input_text = $('#in_group_name_menu_3').val();
      if(input_text.length == 5){
         let isConfirm = confirm("Вы действително хотите удалить \nгруппу - " + input_text + "?");
         if(isConfirm){
            async_send_form(3, 3); //FORM 3 and ACTION 3 REMOVE GROUP
         }else{
            $('#btn_form_menu_3').prop("disabled", false);
         }
      }
   }

   this.show_remove_group_response  = function(response){
      switch ( response['status'] ) {
         case 'success':
            $('#success_box').show();
            $('#success_box_text').text( response['message'] );
            $('#in_password_menu_3').val("");
            $('#setting_menu_3_confirm').hide();
            $('#setting_menu_3_about_group').hide();

            $('#in_group_name_menu_3')
            .removeClass('is-invalid').removeClass('is-valid');
            break;
         case 'error':
            $('#error_box').show();
            $('#error_box_text').text( response['message'] );

            $('#in_password_menu_3')
            .removeClass('is-valid').addClass('is-invalid');
            break;
         default:

      }
   }

   this.show_check_exist_group_response = function (response) {
      switch ( response['status'] ) {
         case 'success':
            $('#in_group_name_menu_3')
            .removeClass('is-invalid').addClass('is-valid');

            $('#btn_form_menu_3').prop("disabled", false);
            $('#setting_menu_3_about_group').show();
            $('#setting_menu_3_confirm').show();

            $('#setting_menu_3_about_name')
            .text("Название группы : " + $('#in_group_name_menu_3').val().toUpperCase());

            $('#setting_menu_3_about_staff')
            .text("Количество персонала : " + response['staff_count']);

            $('#setting_menu_3_about_subscribers')
            .text("Количество подписчиков : " + response['subscribers_count']);

            $('#setting_menu_3_about_lessons')
            .text("Количество записей занятий в БД : " + response['lessons_count']);
            break;
         case 'error':
            $('#in_group_name_menu_3').removeClass('is-valid').addClass('is-invalid');
            $('#btn_form_menu_3').prop("disabled", true);
            $('#setting_menu_3_about_group').hide();
            $('#setting_menu_3_confirm').hide();
            break;
         default:
            break;
      }
   }
};
/*________ 3 - END ModuleRemoveGroup ________*/


/*________ 5 - END ModuleRemoveUser ________
*/
function ModuleRemoveUser(){
   let that = this;

   $('#in_login_menu_5').keyup(function(){
      that.search_user();
   });

   $('#in_password_menu_5').keyup(function(){
      that.keyup_in_password();
   });

   this.keyup_in_password = function(){
      let input_text = $('#in_login_menu_5').val();
      if(input_text.length > 3){
         $('#in_password_menu_5').removeClass('is-invalid');
         this.search_user();
      }else{
         $('#btn_form_menu_5').prop("disabled", true);
      }
   }

   this.search_user = function () {
      let input_text = $('#in_login_menu_5').val();
      if(input_text.length > 3){
         async_send_form(5, 51); //FORM 5 and ACTION 51 CHECK EXIST USER
      }else{
         $('#in_password_menu_5')
         .removeClass('is-invalid').removeClass('is-valid');

         $('#in_login_menu_5')
         .removeClass('is-invalid').removeClass('is-valid');

         $('#btn_form_menu_5').prop("disabled", true);
         $('#setting_menu_5_confirm').hide();
         $('#setting_menu_5_about_user').hide();

         $('#setting_menu_5_about_login').text('');
         $('#setting_menu_5_about_email').text('');
         $('#setting_menu_5_about_level').text('');
         $('#setting_menu_5_about_relation').text('');
      }
   }

   this.remove_user = function () {
      let input_text = $('#in_login_menu_5').val();
      if(input_text.length > 3){
         let isConfirm = confirm("Вы действително хотите удалить \nпользователя - " + input_text + "?");
         if(isConfirm){
            async_send_form(5, 5); //FORM 5 and ACTION 5 REMOVE GROUP
         }else{
            $('#btn_form_menu_5').prop("disabled", false);
         }
      }
   }

   this.show_remove_user_response  = function(response){
      switch ( response['status'] ) {
         case 'success':
            $('#success_box').show();
            $('#success_box_text').text( response['message'] );
            $('#in_login_menu_5').val("");
            $('#setting_menu_5_confirm').hide();
            $('#setting_menu_5_about_user').hide();

            $('#in_login_menu_5')
            .removeClass('is-invalid').removeClass('is-valid');
            break;
         case 'error':
            $('#error_box').show();
            $('#error_box_text').text( response['message'] );

            $('#in_password_menu_5')
            .removeClass('is-valid').addClass('is-invalid');
            break;
         default:

      }
   }

   this.show_check_exist_user_response = function (response) {
      switch ( response['status'] ) {
         case 'success':
            $('#in_login_menu_5')
            .removeClass('is-invalid').addClass('is-valid');

            $('#btn_form_menu_5').prop("disabled", false);
            $('#setting_menu_5_about_user').show();
            $('#setting_menu_5_confirm').show();

            $('#setting_menu_5_about_login').text("Логин : " + response['login']);
            $('#setting_menu_5_about_email').text("Email : " + response['email']);
            let level = response['level'] == 0 ? "Персонал" : "Администратор";
            $('#setting_menu_5_about_level').text("Уровень доступа : " + level);

            if(response['level']  == 0){
               $('#setting_menu_5_about_relation').text("Ответственный за группу : " + response['group_name'].toUpperCase());
            }
            break;
         case 'error':
            $('#in_login_menu_5')
            .removeClass('is-valid').addClass('is-invalid');

            $('#btn_form_menu_5').prop("disabled", true);
            $('#setting_menu_5_about_user').hide();
            $('#setting_menu_5_confirm').hide();
            break;
         default:
            break;
      }
   }
};
/*________ 5 - END ModuleRemoveUser ________*/


/*________ 6 - ModuleUpdatePassword ________
*/
function ModuleUpdatePassword(){

   $('#in_old_password_menu_6').keyup(function(){
      $('#in_old_password_menu_6').removeClass("is-invalid");
      $('#btn_form_menu_6').prop("disabled", false);
   });

   $('#in_new_password_menu_6').keyup(function(){
      $('#in_new_password_menu_6').removeClass("is-invalid");
      $('#btn_form_menu_6').prop("disabled", false);
   });

   $('#in_confirm_password_menu_6').keyup(function(){
      $('#in_confirm_password_menu_6').removeClass("is-invalid");
      $('#btn_form_menu_6').prop("disabled", false);
   });

   this.update_password = function () {
      if( $('#in_new_password_menu_6').val() == $('#in_confirm_password_menu_6').val() ){
         if ($('#in_new_password_menu_6').val().length < 6 || $('#in_confirm_password_menu_6').val().length < 6){
               $('#in_new_password_menu_6').addClass("is-invalid");
               $('#in_confirm_password_menu_6').addClass("is-invalid");
         }else{
            let isConfirm = confirm("Вы действително хотите сменить пароль?");

            if(isConfirm){
               async_send_form(6, 6); //FORM 6 and ACTION 6 - UPDATE PASSWORD
            }
         }
      }else{
         $('#in_new_password_menu_6').addClass("is-invalid");
         $('#in_confirm_password_menu_6').addClass("is-invalid");
      }
   }

   this.show_up_password_response  = function(response){
      switch ( response['status'] ) {
         case 'success':
            $('#success_box').show();
            $('#success_box_text').text( response['message'] );

            $('#in_old_password_menu_6').val("");
            $('#in_new_password_menu_6').val("");
            $('#in_confirm_password_menu_6').val("");
            break;
         case 'error':
            $('#error_box').show();
            $('#error_box_text').text( response['message'] );
            $('#btn_form_menu_6').prop("disabled", true);

            $('#in_old_password_menu_6')
            .removeClass('is-valid').addClass('is-invalid');
            break;
         default:
            break;
      }
   }
};
/*________ 6 - END ModuleUpdatePassword ________*/
