<?php
require_once('../db/connect_to_DB.php');
header('Content_TYPE: application/json');

if( !isset($_GET['group_name']) ) echo 'error';
else{
  $group_name = trim($_GET['group_name']);

  $group = R::findOne('groups', 'group_name = ?', array($group_name));

  if($group) $id_group = $group->id;
  else {
    R::close();

    echo "ERROR GROUP NOT EXIST";
    exit();
  }

  $dayAll = R::findAll('lessons', 'id_group = ? ', array($id_group));

  //$dayAll = $dayAll->export();
  echo json_encode($dayAll);
  http_response_code(200);
  //echo $dayAll;
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
