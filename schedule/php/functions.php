
<?php
require_once('../db/connect_to_DB.php');


function get_group_name($id){
  $group =  R::findOne('groups', ' id = ? ',  array($id));
  if ($group) {
     return $group->group_name;
  }else {
    header("Location: "."/site/schedule");
    exit();
  }
}


function get_shedule_one_day($id_group, $subgroup, $week, $day){
  $subweek = ''; $allWeeks = '5';

  if( $week % 2 == 0 ){
    $subweek = '24';
  }else{
    $subweek = '13';
  }

  $day = R::getAll('SELECT * FROM `lessons` WHERE `id_group` = ? AND ( `subgroup` = ? OR `subgroup` = "3") AND (`week` = ? OR  `week` = ? OR `week` = ?) AND `day` = ?  ORDER BY `lessons`.`time` ASC',
  array($id_group, $subgroup, $week, $subweek, $allWeeks, $day));
  return $day;
}

function get_day_name($number){
  switch ($number) {
    case 1:
        return 'Понедельник';
        break;
    case 2:
        return 'Вторник';
        break;
    case 3:
        return 'Среда';
        break;
    case 4:
        return 'Четверг';
        break;
    case 5:
        return 'Пятница';
        break;
    case 6:
        return 'Суббота';
        break;
  }
}

function get_style_subject_type($number){
  switch ($number) {
    case 1:
        return 'class="bg-primary text-light pl-1 pr-1"';
        break;
    case 2:
        return 'class="bg-warning text-light pl-1 pr-1"';
        break;
    case 3:
        return 'class="bg-danger text-light pl-1 pr-1"';
        break;
  }
}

function get_subject_type($number){
  $array_types = ['-', 'Лекция', 'Практика', 'ЛР'];
  return $array_types[$number];
}

function get_time_lesson_start($number){
  $array_times_start = ['-', '08:00', '09:55', '12:15', '14:10', '16:20', '18:10'];
  return $array_times_start[$number];
}
function get_time_lesson_end($number){
  $array_times_end = ['-', '09:40', '11:35', '13:55', '15.50', '18:00', '20:00'];
  return $array_times_end[$number];
}

function get_subject_name($number){
  $array_types = ['Лекция', 'Практика', 'ЛР'];
  return $array_types[$number-1];
}

function corrector_week($current_week, $buckup_current_week){
   if($current_week == $buckup_current_week){
      return ' 0 ';
   }else {
      return ' '.$current_week - $buckup_current_week;
   }
}

function get_number_day($current_week, $buckup_current_week, $number){
  $number -= 1;
  $corrector = corrector_week($current_week, $buckup_current_week);
  return date('d', strtotime('Mon this week '.$corrector.' week +'.$number.' day'));
}

function get_month_name($current_week, $buckup_current_week, $number){
  $array_months = ['-','Января', 'Февраля', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'];
  $corrector = corrector_week($current_week, $buckup_current_week);
  $number -= 1;
  $current_month = date('n', strtotime('Mon this week '.$corrector.' week +'.$number.' day'));
  return $array_months[$current_month];
}

function get_str_name_sub($number){
   $array_str_sub = ['-', 'Первая', 'Вторая', 'Все'];
   return $array_str_sub[$number];
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
