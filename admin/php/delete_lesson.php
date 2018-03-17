<?php

require_once('../../db/connect_to_DB.php') ;

$group_name = $_POST['group_name'];
$subgroup = $_POST['subgroup'];
$week = $_POST['week'];
$day = $_POST['day'];
$time = $_POST['time'];


$group = R::findOne('groups', 'group_name = ?', array($group_name));

if($group){
   $subweek = ''; $allWeeks = '5';
   if($week == '5'){
      $week = '13';
      $subweek = '24';
   }else {
      if( $week % 2 == 0 ){
         $subweek = '24';
      }else{
         $subweek = '13';
      }
   }


   $lesson = R::findAll('lessons',' WHERE `id_group` = ? AND ( `subgroup` = ? OR `subgroup` = "3") AND (`week` = ? OR  `week` = ? OR `week` = ?) AND `day` = ? AND `time` = ?',
               array($group->id, $subgroup, $week, $subweek, $allWeeks, $day, $time));
   //$lesson = false;
   if($lesson){
      R::trashAll( $lesson ); //for one bean
      R::close();
      echo json_encode(array('status' => 0, 'data' => 'LESSON WAS DELETED' ));
   }else {
      //R::close();
      echo json_encode(array('status' => 1, 'data' => 'LESSON NOT EXIST' ));
   }

}else {
   R::close();
   echo json_encode(array('status' => 404, 'data' => 'ERROR GROUP NOT EXIST' ));
}

?>
