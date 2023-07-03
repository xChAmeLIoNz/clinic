<?php

///////////////////////
//DATABASE CONNECTION//
///////////////////////
$dbServerName = "mysql.next-data.net";
$dbUsername = "www_13237";
$dbPassword = "uBaKfYFM";
$dbName = "www_wpschool_it";


$mysqli = new mysqli($dbServerName, $dbUsername, $dbPassword, $dbName);

/////////////////////////////
//CHECK FOR DB CONNECT FAIL//
/////////////////////////////

if($mysqli->connect_errno > 0) {
	die('Unable to connect to database [ '. $mysqli->connect_error . ' ]' . ' [ ERROR ' . $mysqli->connect_errno . ' ]');
}

?>