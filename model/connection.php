<?php
$host     = "db31.grserver.gr";
$username = "sdi1300202";
$password = "sdi1300202!!!";

$mysqli = new mysqli($host, $username, $password, $db_name);

if ($mysqli->connect_errno) {
	printf("Connect failed: %s\n", $mysqli->connect_error);
	exit( );
}
$mysqli->query("SET NAMES utf8");
?>