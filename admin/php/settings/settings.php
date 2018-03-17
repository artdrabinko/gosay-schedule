<?php
session_start();
require_once('../../../db/connect_to_DB.php');


if ( isset( $_POST['action'] ) && isset( $_SESSION['logged_user'] ) && $_SESSION['logged_user']['level'] == 1 ) {

   require_once('Controller.php');
   $controller = new Controller($_SESSION['logged_user'], (string)$_POST['action'] );

   switch ( (string)$_POST['action'] ) {
      case '2':
         $response = $controller->add_group($_POST);
         echo json_encode($response);
         break;
      case '21':
         $response = $controller->check_gruop($_POST);
         echo json_encode($response);
         break;
      case '3':
         $response = $controller->remove_group($_POST);
         echo json_encode($response);
         break;
      case '31':
         $response = $controller->search_group($_POST);
         echo json_encode($response);
         break;
      case '4':
         $response = $controller->update_password();
         echo json_encode($response);
         break;
      case '5':
         $response = $controller->update_password();
         echo json_encode($response);
         break;
      case '6':
         $response = $controller->update_password();
         echo json_encode($response);
         break;

      default:
         json_encode("action not found!");
         break;
   }
}else{
   echo json_encode("access denaided!");
}


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
 ?>
