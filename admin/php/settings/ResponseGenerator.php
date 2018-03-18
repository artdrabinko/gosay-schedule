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


class ResponseGenerator {

  private $response_list = array(
     'success' =>
     array( '2'  => array('operation' => 'add_group', 'status' => 'success', 'message' => 'Группа успешно создана!'),
            '21' => array('operation' => 'check_gruop', 'status' => 'success', 'message' => 'Название группы свободно!'),
            '3' => array('operation' => 'remove_group', 'status' => 'success', 'message' => "Группа успешно удалена!"),
            '31' => array('operation' => 'search_group', 'status' => 'success', 'message' => "Группа успешно найдена!"),
            '5' => array('operation' => 'remove_user', 'status' => 'success', 'message' => "Пользователь успешно удален!"),
            '6' => array('operation' => 'update_password', 'status' => 'success', 'message' => "Пароль успешно изменён!"),
      ),
     'error' =>
     array( '201' => array('operation' => 'add_group', 'status' => 'error', 'message' => 'Группа уже существует!'),
            '2101' => array('operation' => 'check_gruop', 'status' => 'error', 'message' => 'Группа уже существует!'),
            '21404' => array('operation' => 'check_gruop', 'status' => 'error', 'message' => 'System error, conntect with developer!'),
            '31' => array('operation' => 'remove_group', 'status' => 'error', 'message' => 'Неверный пароль!'),
            '32' => array('operation' => 'remove_group', 'status' => 'error', 'message' => 'Группа не найдена 32!'),
            '3101' => array('operation' => 'search_group', 'status' => 'error', 'message' => 'Группа не найдена 3101!'),
            '52' => array('operation' => 'remove_user', 'status' => 'error', 'message' => 'Пользователь не найден!'),
            '5101' => array('operation' => 'search_user', 'status' => 'error', 'message' => 'Пользователь не найден!'),
            '61' => array('operation' => 'update_password', 'status' => 'error', 'message' => 'Пароли не совпали жулик!'),
            '62' => array('operation' => 'update_password', 'status' => 'error', 'message' => 'Неверный старый пароль!'),
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


 ?>
