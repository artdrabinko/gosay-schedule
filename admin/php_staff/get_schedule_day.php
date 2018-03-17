<?php
session_start();
require('../../db/connect_to_DB.php');

if( !isset($_SESSION['logged_user']) ) echo json_encode(array('status' => 404, 'data' => 'ERROR' ));

$id_group = $_SESSION['logged_user']['ig_group'];
$subgroup = $_POST['subgroup'];
$week = $_POST['week'];
$day = $_POST['day'];


$group = R::findOne('groups', 'id = ?', array($id_group));

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

?>
