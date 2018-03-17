;
var selected_item = 1,
    selected_menu = 1;

var controllerAddGroupMenu = new ModuleAddNewGroup();
var moduleRemoveNewGroup = new ModuleRemoveNewGroup();
var handlerResponse = new HandlerResponse();

 $('#in_group_name_menu_2').keyup(function(){
    controllerAddGroupMenu.check_group_name();
 });

 $('#in_group_name_menu_3').keyup(function(){
    moduleRemoveNewGroup.search_group();
 });


function set_settings_title(number){
   console.log('set_settings_title number - ' + number);
   var array_titles = [
      '-',
      'Аккаунт',
      'Добавление группы',
      'Удаление группы',
      'Добавление пользователя',
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
   console.log('handler_click item - ' + number);
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

   //async_send_form(number);
   switch (String(number)) {
      case '2':
         controllerAddGroupMenu.add_group();
         break;
      case '3':
         moduleRemoveNewGroup.remove_group();
         break;
      default:
   }
};

//-------- ajax processing form --------
function async_send_form(number, action){
   let data = $('#form_menu_' + number).serialize() + '&action=' + action;
   console.log(data);
   handlerResponse.set_action(action);

   $.ajax ({
      url: "/site/admin/php/settings/settings.php",
      type: "POST",
      data: data,
      dataType: "html",
      beforeSend: before_send,
      success: send_form_success,
      complete: function() {
         $('#btn_form_menu_' + number).prop("disabled", false);
      }
   });
};

function before_send(){
   console.log('beforeSend');
   $('#load_data').show();
};

function send_form_success(data){
   $('#load_data').hide();
   let response = JSON.parse(data);
   console.log("send_form_success - " + data);
   hide_message(11);
   handlerResponse.processing_response(response);
};
//-------- end ajax processing form --------


function HandlerResponse(){
   this.action = '';

   this.set_action = function(action){
      this.action = String(action);
   }

   this.processing_response  = function(response){
      switch (this.action) {
         case '2':
            this.show_response_message(response);
            $('#in_group_name_menu_2').removeClass('is-invalid').removeClass('is-valid');
            break;
         case '21':
            controllerAddGroupMenu.show_response_message(response);
            break;
         case '3':
            this.show_response_message(response);
            $('#in_group_name_menu_3').removeClass('is-invalid').removeClass('is-valid');
            break;
         case '31':
            moduleRemoveNewGroup.show_response_message(response);
            break;
         case 'error':
            console.log("error");
            $('#error_box').show();
            $('#error_box_text').text( response['message'] );
            break;
         default:

      }
   }

   this.show_response_message  = function(response){
      switch ( response['status'] ) {
         case 'success':
            console.log("success");
            $('#success_box').show();
            $('#success_box_text').text( response['message'] );
            break;
         case 'error':
            console.log("error");
            $('#error_box').show();
            $('#error_box_text').text( response['message'] );
            break;
         default:

      }
   }

};



function  ModuleRemoveNewGroup(){

   this.search_group = function () {
      let input_text = $('#in_group_name_menu_3').val();
      if(input_text.length === 5){
         async_send_form(3, 31); //FORM 3 and ACTION 31 CHECK EXIST GROUP
      }else{
         $('#in_group_name_menu_2').removeClass('is-invalid').removeClass('is-valid');
         $('#btn_form_menu_2').prop("disabled", true);
      }
   }

   this.remove_group = function () {
      let input_text = $('#in_group_name_menu_3').val();
      if(input_text.length === 5){
         async_send_form(3, 3); //FORM 3 and ACTION 3 REMOVE GROUP
      }
   }

   this.show_response_message = function (response) {
      switch ( response['status'] ) {
         case 'success':
            $('#in_group_name_menu_3').removeClass('is-invalid').addClass('is-valid');
            break;
         case 'error':
            $('#in_group_name_menu_3').removeClass('is-valid').addClass('is-invalid').
            break;
         default:

      }
   }

};


function  ModuleAddNewGroup(){

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
         async_send_form(2, 2); //FORM 2 and ACTION 2 ADD GROUP
      }
   }

   this.show_response_message = function (response) {
      switch ( response['status'] ) {
         case 'success':
            $('#in_group_name_menu_2').removeClass('is-invalid').addClass('is-valid');
            break;
         case 'error':
            $('#in_group_name_menu_2').removeClass('is-valid').addClass('is-invalid').
            break;
         default:

      }
   }

};




function ModuleAddNewUser(){}


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
