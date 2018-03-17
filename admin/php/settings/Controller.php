<?php
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
      if( iseet( $_SESSION['logged_user'] ) && $_SESSION['logged_user']['level'] == 1 ){
         $user =  R::findOne( 'usrs', 'id = ?', array( $_SESSION['logged_user']['id'] ) );

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
         R::close();
         return $group ? $this->RG->create_response('success', 31);
                         $this->RG->create_response('error', 3101) :

      }else {
         return $this->RG->create_response('error', 21404);
      }
   }

   public function remove_group($data){
      if( isset( $data['group_name'] ) ){
         if( !pass_verify() ) return $this->RG->create_response('error', 31);
         $group =  R::findOne( 'groups', 'group_name = ?', array( $data['group_name'] ) );

         $id_group = '';
         if( $id_group ) {
            $id_group = $group->id;
            R::trash( $group );
         }else{
            R::close();
            return $this->RG->create_response('error', 32);
         }

         $lessons = R::findAll( 'lessons',' WHERE `id_group` = ?', array( $id_group ) );
         if( $lessons ) R::trash( $lessons );
         R::close();
         return $this->RG->create_response('success', 3);
      }else {
         return $this->RG->create_response('error', 21404);
      }
   }

   public function add_new_user(){
      return $this->RG->create_response('success', 6);
   }

   public function update_password(){
      return $this->RG->create_response('success', 6);
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
