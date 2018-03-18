<?php
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
along with Foobar.  If not, see <http://www.gnu.org/licenses/>.*/


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
      case '5':
         $response = $controller->remove_user($_POST);
         echo json_encode($response);
         break;
      case '51':
         $response = $controller->search_user($_POST);
         echo json_encode($response);
         break;
      case '6':
         $response = $controller->update_password($_POST);
         echo json_encode($response);
         break;

      default:
         json_encode("action not found!");
         break;
   }
}else{
   echo json_encode("access denaided!");
}

 ?>
