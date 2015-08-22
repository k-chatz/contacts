<?php
$host     = "127.0.0.1:8631";
$username = "contacts";
$password = "1Fzvma86dX3b86f2W6";

$mysqli = new mysqli($host, $username, $password, $db_name) or die("Cannot create object!");
if ($mysqli->connect_errno) {
	printf("Connect failed: %s\n", $mysqli->connect_error);
	$_SESSION['warning'] = "<b>connection.php:</b><br>Unable to connect to the database!<br />Error: ". $mysqli->connect_error ."";
	header("Location: ../../index.php");
	exit();
}
else
	$mysqli->query("SET NAMES utf8");

//dump( $mysqli ,"mysqli");
?>