<?php

require_once('/site/db/connect_to_DB.php') ;

$name_group = $_POST['name_group'];
$subgroup = $_POST['subgroup'];
$week = $_POST['week'];
$day = $_POST['day'];


$group = R::findOne('groups', 'group_name = ?', array($name_group));

if($group){

   $subweek = ''; $allWeeks = '5';
   if( $week == '24' ){
      $subweek = '24';
   }elseif ( $week == '13' ) {
      $subweek = '13';
   }elseif ( $week == '5' ) {
      $subweek = '5';
   } else {
      if( $week % 2 == 0 ){
         $subweek = '24';
      }else{
         $subweek = '13';
      }
   }

   $dayAll = R::getAll('SELECT * FROM `lessons` WHERE `id_group` = ? AND ( `subgroup` = ? OR `subgroup` = "3") AND (`week` = ? OR  `week` = ? OR `week` = ?) AND `day` = ?  ORDER BY `lessons`.`time` ASC',
               array($group->id, $subgroup, $week, $subweek, $allWeeks, $day));
   R::close();

   if($dayAll){
      echo json_encode(array('status' => 0, 'data' => $dayAll ));
   }else {
      echo json_encode(array('status' => 1, 'data' => 'GROUP EXIST' ));
   }

}else {
   R::close();
   echo json_encode(array('status' => 404, 'data' => 'ERROR GROUP NOT EXIST' ));
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
