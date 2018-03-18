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


require_once('ResponseGenerator.php');

class Controller {
   private $user;
   private $action;
   private $RG; //ResponseGenerator

   public function __construct($user, $action){
     $this->user = $user;
     $this->action = $action;
     $this->RG = new ResponseGenerator();
   }

   private function pass_verify($data){
      if( isset( $_SESSION['logged_user'] ) && $_SESSION['logged_user']['level'] == 1 ){
         $user =  R::findOne( 'users', 'id = ?', array( $_SESSION['logged_user']['id'] ) );

         if($user){
            return ( $user->password == $data['password'] ) ? true : false ;
         }else{
            return false;
         }
      }
   }

   public function add_group($data){
      if( isset( $data['group_name'] ) ){
         $group =  R::findOne( 'groups', 'group_name = ?', array( $data['group_name'] ) );
         if(!$group){
            $new_group = R::dispense('groups');
            $new_group->group_name = mb_strtoupper($data['group_name'], 'UTF-8');
            R::store($new_group);
            R::close();
            return $this->RG->create_response('success', 2);
         }else{
            R::close();
            return $this->RG->create_response('error', 201);
         }
      }else {
         return $this->RG->create_response('error', 21404);
      }
   }

   /*
   21 01    21 - check_gruop    01 - error code
   21 404    21 - check_gruop    404 - error code
   */
   public function check_gruop($data){
      if( isset( $data['group_name'] ) ){
         $group =  R::findOne( 'groups', 'group_name = ?', array( $data['group_name'] ) );
         R::close();
         return $group ?  $this->RG->create_response('error', 2101) :
                         $this->RG->create_response('success', 21);
      }else {
         return $this->RG->create_response('error', 21404);
      }
   }

   public function search_group($data){
      if( isset( $data['group_name'] ) ){
         $group =  R::findOne( 'groups', 'group_name = ?', array( $data['group_name'] ) );

         if($group){
            $staff_count = R::count( 'users', 'id_group = ?', [$group->id ] );
            $lessons_count = R::count( 'lessons', 'id_group = ?', [$group->id ] );
            $subscribers_count = R::count( 'subscribers',' WHERE `id_group` = ?', [$group->id] );
            R::close();
            return array('operation' => 'search_group',
                          'status' => 'success',
                          'staff_count' => $staff_count,
                          'subscribers_count' => $subscribers_count,
                          'lessons_count' => $lessons_count,
                          'message' => "Группа успешно найдена!");
         }else {
            R::close();
            return $this->RG->create_response('error', 3101);
         }

      }else {
         return $this->RG->create_response('error', 21404);
      }
   }

   public function search_user($data){
      if( isset( $data['login'] ) ){
         $user =  R::findOne( 'users', 'login = ? OR email = ?', array( $data['login'], $data['login']  ) );

         if($user){
            $group_name = '';

            if($user->level == 0) {
               $group = R::findOne( 'groups', 'id = ?', array( $user->id_group ) );
               if($group) $group_name = $group->group_name;
            }

            R::close();
            return array('operation' => 'search_group',
                          'status' => 'success',
                          'login' => $user->login,
                          'email' => $user->email,
                          'level' => $user->level,
                          'group_name' => $group_name,
                          'message' => "Пользователь успешно найден!");
         }else {
            R::close();
            return $this->RG->create_response('error', 5101);
         }

      }else {
         return $this->RG->create_response('error', 21404);
      }
   }

   public function remove_group($data){
      if( isset( $data['group_name'] ) ){
         if( !$this->pass_verify( $data ) ) return $this->RG->create_response('error', 31);
         $group =  R::findOne( 'groups', 'group_name = ?', array( $data['group_name'] ) );

         $id_group = '';
         if( $group ) {
            $id_group = $group->id;
            R::trash( $group );
         }else{
            R::close();
            return $this->RG->create_response('error', 32);
         }

         $lessons = R::findAll( 'lessons',' WHERE `id_group` = ?', array( $id_group ) );
         if( $lessons ) R::trashAll( $lessons );

         $users = R::findAll( 'users',' WHERE `id_group` = ?', array( $id_group ) );
         if( $users ) R::trashAll( $users );

         $subscribers = R::findAll( 'subscribers',' WHERE `id_group` = ?', array( $id_group ) );
         if( $subscribers ) R::trashAll( $subscribers );
         R::close();
         return $this->RG->create_response('success', 3);
      }else {
         return $this->RG->create_response('error', 21404);
      }
   }

   public function remove_user($data){
      if( isset( $data['login'] ) ){
         if( !$this->pass_verify( $data ) ) return $this->RG->create_response('error', 31);
         $users = R::findOne( 'users',' WHERE login = ? OR email = ?', array( $data['login'], $data['login'] ) );

         if( $users ) {
            R::trash( $users );
            R::close();
            return $this->RG->create_response('success', 5);
         }else{
            R::close();
            return $this->RG->create_response('error', 52);
         }

      }else {
         return $this->RG->create_response('error', 21404);
      }
   }


   public function add_new_user(){
      return $this->RG->create_response('success', 6);
   }

   public function update_password($data){
      $isPasswordsEqual = ($data['new_password'] == $data['confirm_password']) ? true : false;
      if( !$isPasswordsEqual ){
         return $this->RG->create_response('error', 61);
      }
      $user =  R::findOne( 'users', 'login = ?', array( $_SESSION['logged_user']['login']) );

      if($user){
        //логин существует, проверяем пароль
        //if( password_verify($input_password, $user->password) ){
        if($data['old_password'] == $user->password){

          $user->password = $data['new_password'];
          R::store($user);
          R::close();
          return $this->RG->create_response('success', 6);
        }else{
          return $this->RG->create_response('error', 62);
        }

      }else{
        return $this->RG->create_response('error', 21404);
      }

   }
}

?>
