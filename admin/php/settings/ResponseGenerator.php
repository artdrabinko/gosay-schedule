<?php
class ResponseGenerator {

  private $response_list = array(
     'success' =>
     array( '2'  => array('operation' => 'add_group', 'status' => 'success', 'message' => 'Группа успешно создана!'),
            '21' => array('operation' => 'check_gruop', 'status' => 'success', 'message' => 'Название группы свободно!'),
            '3' => array('operation' => 'remove_group', 'status' => 'success', 'message' => "Группа успешно удалена!"),
            '31' => array('operation' => 'search_group', 'status' => 'success', 'message' => "Группа успешно найдена!"),
            '6' => array('operation' => 'update_password', 'status' => 'success', 'message' => "Пароль успешно изменён!"),
      ),
     'error' =>
     array( '201' => array('operation' => 'add_group', 'status' => 'error', 'message' => 'Группа уже существует!'),
            '2101' => array('operation' => 'check_gruop', 'status' => 'error', 'message' => 'Группа уже существует!'),
            '21404' => array('operation' => 'check_gruop', 'status' => 'error', 'message' => 'System error, conntect with developer!'),
            '31' => array('operation' => 'remove_group', 'status' => 'error', 'message' => 'Неверный пароль!'),
            '32' => array('operation' => 'remove_group', 'status' => 'error', 'message' => 'Группа не найдена!'),
            '3101' => array('operation' => 'search_group', 'status' => 'error', 'message' => 'Группа не найдена!'),
     )
  );


   public function create_response( $type, $number ){
      if ( !$this->response_list[(string)$type][(string)$number] ) {
         throw new Exception('Ошибка, такого ответа в списке доступных нет!');
      }else{
         return $this->response_list[(string)$type][(string)$number];
      }
   }
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
