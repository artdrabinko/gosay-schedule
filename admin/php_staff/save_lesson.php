<?php
session_start();
require_once('../../db/connect_to_DB.php') ;

if( !isset($_SESSION['logged_user']) ) echo json_encode(array('status' => 404, 'data' => 'ERROR' ));

$id_group = $_SESSION['logged_user']['ig_group'];
$subgroup = $_POST['subgroup'];
$week = $_POST['week'];
$day = $_POST['day'];
$time = $_POST['time'];
$subject_type = $_POST['subject_type'];
$subject_name = $_POST['subject_name'];
$teacher_name = $_POST['teacher_name'];
$room = $_POST['room'];

$group = R::findOne('groups', 'id = ?', array($id_group));

function clear($data){
   R::trashAll( $data );
}

if($group) $id_group = $group->id;
else {
  R::close();
  echo json_encode(array('status' => 404, 'data' => 'ERROR GROUP NOT EXIST'));
  exit();
}

$subweek = ''; $allWeeks = '5';

if( $subgroup == '3' ){

   if ( $week == '1' || $week == '3' ){
      $lessons = R::findAll( 'lessons', ' id_group = ? AND ( week = 1 OR week = 3 OR week = 13 OR week = 5 ) AND day = ? AND time = ?',
                          array( $id_group, $day, $time ) );
      clear($lessons);
   }elseif ( $week == '2' || $week == '4' ) {
      $lessons = R::findAll( 'lessons', ' id_group = ? AND ( week = 2 OR week = 4 OR week = 24 OR week = 5 ) AND day = ? AND time = ?',
                          array( $id_group, $day, $time ) );
     clear($lessons);
   }elseif ( $week == '13' ) {
      $lessons = R::findAll( 'lessons', ' id_group = ? AND ( week = 1 OR week = 3 OR week = 13 OR week = 5 ) AND day = ? AND time = ?',
                          array( $id_group, $day, $time ) );
     clear($lessons);
   }elseif ( $week == '24' ) {
      $lessons = R::findAll( 'lessons', ' id_group = ? AND ( week = 2 OR week = 4 OR week = 24 OR week = 5 ) AND day = ? AND time = ?',
                          array( $id_group, $day, $time ) );
     clear($lessons);
   }elseif ( $week == '5' ) {
      $lessons = R::findAll( 'lessons', ' id_group = ? AND day = ? AND time = ?',
                          array( $id_group, $day, $time ) );
     clear($lessons);
   }

}elseif ( $week == '1' || $week == '3' ){
   $lessons = R::findAll( 'lessons', ' id_group = ? AND subgroup = ? AND ( week = 1 OR week = 3 OR week = 13 OR week = 5 ) AND day = ? AND time = ?',
                       array( $id_group, $subgroup, $day, $time ) );
   clear($lessons);
}elseif ( $week == '2' || $week == '4' ) {
   $lessons = R::findAll( 'lessons', ' id_group = ? AND subgroup = ? AND ( week = 2 OR week = 4 OR week = 24 OR week = 5 ) AND day = ? AND time = ?',
                       array( $id_group, $subgroup, $day, $time ) );
  clear($lessons);
}elseif ( $week == '13' ) {
   $lessons = R::findAll( 'lessons', ' id_group = ? AND subgroup = ? AND ( week = 1 OR week = 3 OR week = 13 OR week = 5 ) AND day = ? AND time = ?',
                       array( $id_group, $subgroup, $day, $time ) );
  clear($lessons);
}elseif ( $week == '24' ) {
   $lessons = R::findAll( 'lessons', ' id_group = ? AND subgroup = ? AND ( week = 2 OR week = 4 OR week = 24 OR week = 5 ) AND day = ? AND time = ?',
                       array( $id_group, $subgroup, $day, $time ) );
  clear($lessons);
}elseif ( $week == '5' ) {
   $lessons = R::findAll( 'lessons', ' id_group = ? AND subgroup = ? AND day = ? AND time = ?',
                       array( $id_group, $subgroup, $day, $time ) );
  clear($lessons);
}


$lesson = R::dispense('lessons');

$lesson->id_group = $id_group;
$lesson->subgroup = $subgroup;
$lesson->week = $week;
$lesson->day = $day;
$lesson->time = $time;
$lesson->subject_type = $subject_type;
$lesson->subject_name = $subject_name;
$lesson->teacher_name = $teacher_name;
$lesson->room = $room;
R::store($lesson);
R::close();
echo json_encode(array('status' => 0, 'data' => 'New lesson was created!'));


?>
