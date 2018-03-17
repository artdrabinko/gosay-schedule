<?php
require_once('rb.php');
require_once('config_DB.php');

R::setup( 'mysql:host='.$host.';dbname='.$database, $user, $password ); //for both mysql or mariaDB

//R::freeze(tf: true);
?>
