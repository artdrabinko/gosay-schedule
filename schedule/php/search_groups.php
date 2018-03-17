<?php
require('../../db/connect_to_DB.php');

$name_group = '%'.$_POST['name_group'].'%';

$key = $_POST['key'];



if($key == 'GROUP')
  $groups = R::find( 'groups', ' group_name LIKE ? ', array($name_group));
else if ($key == 'ALL')
  $groups =  R::findAll('groups');

echo json_encode($groups);

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
